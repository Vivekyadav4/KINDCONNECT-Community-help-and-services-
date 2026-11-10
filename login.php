<?php
// ADDED: Start output buffering for safe redirection on successful login
ob_start();

require_once __DIR__ . '/../inc/header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (!$email || !$pass) {
        $msg = 'Provide email and password.';
    } else {
        $stmt = safe_prepare($mysqli, "SELECT id, name, password, role FROM users WHERE email = ? LIMIT 1");
        if ($stmt === false) {
            header("Location: " . SITE_URL . "/public/login.php?error=server");
            exit;
        }
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            // Use the password you set during registration
            if (password_verify($pass, $row['password'])) {
                // Login success - Set session variables
                $_SESSION['user_id'] = (int)$row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['role'] = $row['role'] ?? 'user';

                // --- ADMIN REDIRECT LOGIC ---
                // --- MULTI-ROLE REDIRECT LOGIC ---
                if ($_SESSION['role'] === 'admin') {
                    // Admins go to the Admin Control Panel
                    header("Location: admin_dashboard.php");
                } elseif ($_SESSION['role'] === 'business' || $_SESSION['role'] === 'volunteer') {
                    // Providers go to their specific Dashboard
                    header("Location: dashboard.php");
                } else {
                    // Regular users go to the Home Page
                    header("Location: index.php");
                }
                exit;
            } else {
                $msg = 'Invalid credentials.';
            }
        } else {
            $msg = 'Invalid credentials.';
        }
        $stmt->close();
    }
}

?>
<div style="max-width:420px;margin:50px auto;background:white;padding:18px;border-radius:8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
  <h2 style="color: var(--accent);">Login</h2>
  <?php if($msg): ?><div style="color:red; margin-bottom:10px;"><?= h($msg) ?></div><?php endif; ?>
  <?php if(!empty($_GET['registered'])): ?><div style="color:green; margin-bottom:10px;">Registration successful. Please login.</div><?php endif; ?>
  
  <form method="post">
    <label>Email</label>
    <input name="email" type="email" required style="width:100%; padding:8px; margin:6px 0;" class="form-control">
    
    <label>Password</label>
    <input name="password" type="password" required style="width:100%; padding:8px; margin:6px 0;" class="form-control">
    
    <button type="submit" style="width:100%; padding:10px; margin-top:10px; background:var(--accent); color:white; border:none; border-radius:6px; cursor:pointer;">
        Login
    </button>
  </form>
  
  <p style="margin-top:15px; text-align:center;">Don't have an account? <a href="register.php">Sign up</a></p>
</div>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>
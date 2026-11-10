<?php
require_once __DIR__ . '/../inc/header.php';
require_login();

$user_id = $_SESSION['user_id'];
$mysqli = connect_db();
$msg = '';
$error = '';

$stmt = safe_prepare($mysqli, "SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $biz_cat = isset($_POST['business_category']) ? trim($_POST['business_category']) : $user['business_category'];
    
    // --- NEW: UNIQUE VALIDATION (Excluding Current User) ---
    $check_stmt = safe_prepare($mysqli, "SELECT id FROM users WHERE (email = ? OR phone = ?) AND id != ? LIMIT 1");
    $check_stmt->bind_param('ssi', $email, $phone, $user_id);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows > 0) {
        $error = "Error: This Email or Phone Number is already used by another account.";
    } else {
        $profile_pic = $user['profile_pic'];
        if (!empty($_FILES['profile_pic']['name'])) {
            $uploadDir = __DIR__ . '/uploads/profiles/';
            $fname = time() . '_' . basename($_FILES['profile_pic']['name']);
            $targetFile = $uploadDir . $fname;
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
                if ($user['profile_pic'] !== 'uploads/profiles/default.png' && file_exists(__DIR__ . '/' . $user['profile_pic'])) {
                    @unlink(__DIR__ . '/' . $user['profile_pic']);
                }
                $profile_pic = 'uploads/profiles/' . $fname;
            }
        }

        $upd = safe_prepare($mysqli, "UPDATE users SET name=?, email=?, phone=?, business_category=?, profile_pic=? WHERE id=?");
        $upd->bind_param('sssssi', $name, $email, $phone, $biz_cat, $profile_pic, $user_id);
        
        if ($upd->execute()) {
            $_SESSION['name'] = $name;
            header("Location: profile.php?msg=updated");
            exit;
        } else {
            $error = "Error updating database.";
        }
    }
}
?>

<div style="max-width:600px; margin:40px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.05);">
    <h2 style="margin-top:0;">Edit Profile</h2>
    
    <?php if($error): ?>
        <div style="background:#fee2e2; color:#b91c1c; padding:10px; border-radius:5px; margin-bottom:15px; border:1px solid #fecaca;"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div style="text-align:center; margin-bottom:20px;">
            <img src="<?= SITE_URL . '/public/' . $user['profile_pic'] ?>" style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:2px solid #3498db;">
            <br>
            <label style="font-size:13px; color:#3498db; cursor:pointer;">
                Change Photo
                <input type="file" name="profile_pic" accept="image/*" style="display:none;">
            </label>
        </div>
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="name" value="<?= h($user['name']) ?>" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="<?= h($user['email']) ?>" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= h($user['phone']) ?>" class="form-control">
        </div>
        <?php if($user['role'] === 'business'): ?>
        <div class="mb-3">
            <label>Business Category</label>
            <input type="text" name="business_category" value="<?= h($user['business_category']) ?>" class="form-control">
        </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
    </form>
</div>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
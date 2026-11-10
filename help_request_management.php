<?php
ob_start();

/** * 1. HEADER PROTECTION
 * Detect if we are inside admin_dashboard.php or standalone
 */
error_reporting(0);
ini_set('display_errors', 0);
if (!defined('IS_INCLUDED')) {
    require_once __DIR__ . '/../inc/header.php';
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
        die("Access Denied."); 
    }
}
$user_count = $mysqli->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$problem_count = $mysqli->query("SELECT COUNT(*) FROM problems")->fetch_row()[0];
/** * 2. DATABASE LOGIC (Must stay at the top!)
 */
// Update Logic
if (isset($_POST['update_req_full'])) {
    $rid = (int)$_POST['req_id'];
    $title = $_POST['title'];
    $cat = $_POST['category'];
    $p_status = $_POST['payment_status'];
    $status = $_POST['status'];
    
    $stmt = $mysqli->prepare("UPDATE problems SET title=?, category=?, payment_status=?, status=? WHERE id=?");
    $stmt->bind_param("ssssi", $title, $cat, $p_status, $status, $rid);
    $stmt->execute();

    // The Redirect - This is where the "Blank Screen" usually happens
    $target = defined('IS_INCLUDED') ? "admin_dashboard.php" : "help_request_management.php";
    header("Location: $target?msg=RequestUpdated");
    exit;
}

// Fetch data if Editing
$edit_req_data = null;
if (isset($_GET['edit_request'])) {
    $rid = (int)$_GET['edit_request'];
    $edit_req_data = $mysqli->query("SELECT * FROM problems WHERE id = $rid")->fetch_assoc();
}
ob_end_flush();
?>
<div class="container mt-4">
    <h1 style="color: var(--accent);">Admin Control Panel</h1>
    <p class="text-muted">Overview of KindConnect platform activity.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card p-4" style="border-radius:12px; border-left: 5px solid var(--accent); background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <h4>Total Users</h4>
                <h2 style="color: var(--accent);"><?= $user_count ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4" style="border-radius:12px; border-left: 5px solid #f39c12; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <h4>Service Requests</h4>
                <h2 style="color: #f39c12;"><?= $problem_count ?></h2>
            </div>
        </div>
    </div> 

<div class="container mt-4">
    <h1 style="color:var(--accent);">Admin Control Panel</h1>
    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-success"><?= h($_GET['msg']) ?></div>
    <?php endif; ?>
<div class="card p-4 shadow-sm border-0 mb-3">
    <h3>3. Help Request Management (Full Access)</h3>

    <?php if ($edit_req_data): ?>
    <form method="POST" class="row g-3 mb-4 p-3 bg-warning bg-opacity-10 rounded border">
        <h5>Editing Request ID: <?= $edit_req_data['id'] ?></h5>
        <input type="hidden" name="req_id" value="<?= $edit_req_data['id'] ?>">
        
        <div class="col-md-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= h($edit_req_data['title']) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" value="<?= h($edit_req_data['category']) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Payment Status</label>
            <select name="payment_status" class="form-control">
                <option value="pending" <?= $edit_req_data['payment_status'] == 'pending' ? 'selected' : '' ?>>pending</option>
                <option value="paid" <?= $edit_req_data['payment_status'] == 'paid' ? 'selected' : '' ?>>paid</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Job Status</label>
            <select name="status" class="form-control">
                <option value="open" <?= $edit_req_data['status'] == 'open' ? 'selected' : '' ?>>open</option>
                <option value="completed" <?= $edit_req_data['status'] == 'completed' ? 'selected' : '' ?>>completed</option>
            </select>
        </div>
        
        <div class="col-12 mt-2">
            <button type="submit" name="update_req_full" class="btn btn-primary">Save Changes</button>
            <a href="<?= defined('IS_INCLUDED') ? 'admin_dashboard.php' : 'help_request_management.php' ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th><th>User</th><th>Title</th><th>Category</th><th>Payment</th><th>Status</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $p_res = $mysqli->query("SELECT * FROM problems ORDER BY id DESC");
                while($p = $p_res->fetch_assoc()): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['user_id'] ?></td>
                    <td><?= h($p['title']) ?></td>
                    <td><?= h($p['category']) ?></td>
                    <td>
                        <span class="badge <?= $p['payment_status']=='paid'?'bg-success':'bg-warning text-dark' ?>">
                            <?= $p['payment_status'] ?>
                        </span>
                    </td>
                    <td><span class="badge bg-secondary"><?= $p['status'] ?></span></td>
                    <td>
                        <a href="?edit_request=<?= $p['id'] ?>" class="btn btn-sm btn-link">Edit</a>
                        <a href="?delete_request=<?= $p['id'] ?>" class="btn btn-sm btn-link text-danger" onclick="return confirm('Delete?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
/** * 4. FOOTER PROTECTION
 */
if (!defined('IS_INCLUDED')) {
    require_once __DIR__ . '/../inc/footer.php';
} 
?>
<?php
ob_start();

define('IS_INCLUDED', true); // The safety switch
require_once __DIR__ . '/../inc/header.php';

// ... rest of your admin_dashboard.php code ...
// Near the bottom where you include the files:

error_reporting(0);
ini_set('display_errors', 0);

// Security: Admins only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied.");
}
$user_count = $mysqli->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$problem_count = $mysqli->query("SELECT COUNT(*) FROM problems")->fetch_row()[0];
$msg = '';
$msg = '';
$edit_service = null;

// --- FETCH SERVICE FOR EDITING ---
if (isset($_GET['edit_service'])) {
    $edit_id = (int)$_GET['edit_service'];
    $res = $mysqli->query("SELECT * FROM categories_db WHERE id = $edit_id");
    $edit_service = $res->fetch_assoc();
}

// --- ADD OR UPDATE SERVICE ---
if (isset($_POST['save_service'])) {
    $title = trim($_POST['title']);
    $short = trim($_POST['short']);
    $desc  = $_POST['description'];
    $slug  = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    $id    = isset($_POST['service_id']) ? (int)$_POST['service_id'] : 0;

    // Handle Image
    if (!empty($_FILES['service_image']['name'])) {
        $target_dir = __DIR__ . "/assets/images/";
        $ext = pathinfo($_FILES['service_image']['name'], PATHINFO_EXTENSION);
        $image_name = $slug . "_" . time() . "." . $ext;
        move_uploaded_file($_FILES['service_image']['tmp_name'], $target_dir . $image_name);
    } else {
        $image_name = $_POST['existing_image'] ?? 'default.jpg';
    }

    if ($id > 0) {
        // UPDATE EXISTING
        $stmt = $mysqli->prepare("UPDATE categories_db SET slug=?, title=?, short_desc=?, description=?, image=? WHERE id=?");
        $stmt->bind_param("sssssi", $slug, $title, $short, $desc, $image_name, $id);
        $msg = "Service Updated Successfully!";
    } else {
        // INSERT NEW
        $stmt = $mysqli->prepare("INSERT INTO categories_db (slug, title, short_desc, description, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $slug, $title, $short, $desc, $image_name);
        $msg = "Service Added Successfully!";
    }
    
    $stmt->execute();
    $redirect_url = defined('IS_INCLUDED') ? "admin_dashboard.php" : "user_management.php";
    header("Location: $redirect_url?msg=Updated");
    exit;
}
// --- 2. CRUD: DELETE OPERATIONS ---
if (isset($_GET['delete_service'])) {
    $id = (int)$_GET['delete_service'];
    $mysqli->query("DELETE FROM categories_db WHERE id = $id");
    header("Location: admin_dashboard.php?msg=ServiceDeleted");
    exit;
}
// --- DELETE USER ---
$edit_user_data = null;
if (isset($_GET['edit_user'])) {
    $uid = (int)$_GET['edit_user'];
    $edit_user_data = $mysqli->query("SELECT * FROM users WHERE id = $uid")->fetch_assoc();
}

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
<div class="card p-4 mb-5 shadow-sm border-0">
    <h3><?= $edit_service ? "Edit Service Card" : "1. Manage Service Cards" ?></h3>
    <form method="POST" enctype="multipart/form-data" class="row g-3 mt-1 mb-4 p-3 bg-light rounded">
        <input type="hidden" name="service_id" value="<?= $edit_service['id'] ?? '' ?>">
        <input type="hidden" name="existing_image" value="<?= $edit_service['image'] ?? 'default.jpg' ?>">

        <div class="col-md-4">
            <label class="form-label">Service Title</label>
            <input type="text" name="title" class="form-control" value="<?= h($edit_service['title'] ?? '') ?>" required>
        </div>
        <div class="col-md-8">
            <label class="form-label">Short Summary (Card View)</label>
            <input type="text" name="short" class="form-control" value="<?= h($edit_service['short_desc'] ?? '') ?>" required>
        </div>
        <div class="col-md-12">
            <label class="form-label">Full Description / Details (Category Page)</label>
            <textarea name="description" class="form-control" rows="4"><?= h($edit_service['description'] ?? '') ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Card Image (Leave blank to keep current)</label>
            <input type="file" name="service_image" class="form-control" accept="image/*">
        </div>
        <div class="col-md-6 d-flex align-items-end gap-2">
            <button type="submit" name="save_service" class="btn btn-primary w-10">
                <?= $edit_service ? "Update Service" : "Save Service Card" ?>
            </button>
            <?php if($edit_service): ?>
                <a href="admin_dashboard.php" class="btn btn-secondary w-50">Cancel</a>
            <?php endif; ?>
        </div>
    </form>

    <div class="row">
        <?php
        $res = $mysqli->query("SELECT * FROM categories_db ORDER BY title ASC");
        while($s = $res->fetch_assoc()): ?>
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <img src="assets/images/<?= h($s['image']) ?>" class="card-img-top" style="height:120px; object-fit:cover;">
                <div class="card-body p-2">
                    <h6 class="mb-1"><?= h($s['title']) ?></h6>
                    <a href="?edit_service=<?= $s['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?delete_service=<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete card?')">Delete</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
    
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
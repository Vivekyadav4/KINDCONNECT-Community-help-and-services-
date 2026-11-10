<?php
require_once __DIR__ . '/../inc/header.php';
require_once __DIR__ . '/../inc/config.php';
require_login();

$role    = $_SESSION['role'] ?? 'user';
$user_id = $_SESSION['user_id'];
$name    = $_SESSION['name'] ?? '';

/* ================= PROVIDER / BUSINESS / VOLUNTEER DASHBOARD ================= */
if ($role === 'provider' || $role === 'business' || $role === 'volunteer') {

    // Fetch provider details including category and registration date
    $stmt = safe_prepare($mysqli, "SELECT business_category, created_at FROM users WHERE id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $provider = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $business_category = $provider['business_category'] ?? '';
    $registration_date = $provider['created_at']; // Captured provider's registration time

    // Stats for Provider (Filtered by registration date)
    $total = $mysqli->query("SELECT COUNT(*) FROM problems WHERE category = '$business_category' AND created_at >= '$registration_date'")->fetch_row()[0];
    $pending = $mysqli->query("SELECT COUNT(*) FROM problems WHERE category = '$business_category' AND status = 'open' AND created_at >= '$registration_date'")->fetch_row()[0];
    $accepted = $mysqli->query("SELECT COUNT(*) FROM problems WHERE status = 'accepted' AND accepted_by = $user_id")->fetch_row()[0];

    // Fetch requests: Open in category (POSTED AFTER REGISTRATION) OR accepted by this specific provider
    $q = safe_prepare($mysqli, "
        SELECT p.*, u.name AS requester_name, u.phone AS requester_phone
        FROM problems p
        LEFT JOIN users u ON u.id = p.user_id
        WHERE p.category = ? 
        AND (
            (p.status = 'open' AND p.created_at >= ?) 
            OR p.accepted_by = ?
        )
        ORDER BY p.created_at DESC
    ");
    // We bind the provider's registration date to ensure they only see "New" help requests 
    $q->bind_param('ssi', $business_category, $registration_date, $user_id);
    $q->execute();
    $requests = $q->get_result()->fetch_all(MYSQLI_ASSOC);
    $q->close();
?>

<style>
    .dashboard-container{ margin:40px auto; max-width: 1100px; padding: 0 20px; font-family: sans-serif; }
    .stats-grid{ display:flex; gap:20px; margin-bottom:30px; }
    .stat-card{ background:#fff; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,.1); flex:1; text-align:center; padding:20px; border-top: 4px solid #2b7a78; }
    .stat-card div{ font-size:24px; font-weight:bold; color:#2b7a78; }
    .table-container { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    table{ width:100%; border-collapse:collapse; margin-top: 15px; }
    th, td{ border-bottom:1px solid #eee; padding:12px; text-align:left; }
    th { background: #f8f9fa; color: #666; font-size: 13px; }
    .status-open{ color: #3498db; font-weight: bold; }
    .status-accepted{ color: #2ecc71; font-weight: bold; }
    .btn{ padding:6px 12px; border-radius:4px; text-decoration:none; color:white; font-size:13px; display: inline-block; cursor: pointer; border: none; }
    .btn-success{ background:#27ae60; }
    .btn-danger{ background:#e74c3c; }
    .btn-info{ background:#3498db; }
    .details-row { display: none; background: #f9f9f9; }
</style>

<main class="dashboard-container">
    <h2>Welcome, <?= h($name) ?></h2>
    <p>Specialty: <strong><?= h($business_category) ?></strong> | Member Since: <?= h($registration_date) ?></p>

    <div class="stats-grid">
        <div class="stat-card"><h3>Available Requests</h3><div><?= $pending ?></div></div>
        <div class="stat-card"><h3>My Active Jobs</h3><div><?= $accepted ?></div></div>
    </div>

    <div class="table-container">
        <h3>New Help Requests</h3>
        <p style="font-size: 0.85em; color: #888;">Only showing requests posted after your registration.</p>
        <table>
            <thead>
                <tr>
                    <th>Title</th><th>Requester</th><th>Status</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($requests)): ?>
                    <tr><td colspan="4">No new requests found in your category since you joined.</td></tr>
                <?php else: foreach ($requests as $r): ?>
                <tr>
                    <td><?= h($r['title']) ?></td>
                    <td><?= h($r['requester_name']) ?></td>
                    <td class="status-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></td>
                    <td>
                        <button class="btn btn-info" onclick="toggleDetails(<?= $r['id'] ?>)">View Details</button>
                        
                        <?php if ($r['status'] === 'open'): ?>
                            <a class="btn btn-success" href="modify_request.php?action=accept&id=<?= $r['id'] ?>">Accept</a>
                        <?php elseif ($r['status'] === 'accepted' && $r['accepted_by'] == $user_id): ?>
                            <a class="btn btn-danger" href="modify_request.php?action=cancel&id=<?= $r['id'] ?>" onclick="return confirm('Cancel this job?')">Cancel Job</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr id="details-<?= $r['id'] ?>" class="details-row">
                    <td colspan="4">
                        <div style="padding: 15px; border-left: 3px solid #3498db; margin: 10px 0;">
                            <strong>Full Description:</strong> <?= nl2br(h($r['description'])) ?><br>
                            <strong>Requester Phone:</strong> <?= h($r['requester_phone']) ?><br>
                            <strong>Service Address:</strong> <?= nl2br(h($r['address'])) ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
function toggleDetails(id) {
    var row = document.getElementById('details-' + id);
    row.style.display = (row.style.display === 'table-row') ? 'none' : 'table-row';
}
</script>

<?php
} else { 
/* ================= REGULAR USER DASHBOARD ================= */
    $stmt = safe_prepare($mysqli, "SELECT * FROM problems WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
?>
<div style="max-width:900px;margin:40px auto;background:white;padding:25px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1); font-family: sans-serif;">
  <h2>My Help Requests</h2>
  <a href="post_problem.php" style="display:inline-block; margin-bottom:20px; color:#3498db; text-decoration: none; font-weight: bold;">+ Post New Request</a>
  
  <?php if(empty($rows)): ?>
    <p>You have not posted any requests yet.</p>
  <?php else: foreach($rows as $r): ?>
    <div style="border-bottom:1px solid #eee; padding:15px 0;">
      <div style="float:right; font-weight:bold; color:#3498db;"><?= strtoupper($r['status']) ?></div>
      <strong style="font-size: 1.1em;"><?= h($r['title']) ?></strong> 
      <div style="font-size:12px;color:#888"><?= h($r['category']) ?> • Posted <?= h($r['created_at']) ?></div>
      <p style="color: #555;"><?= nl2br(h($r['description'])) ?></p>
      
      <div style="margin-top:10px;">
        <b>Payment:</b> 
        <span style="color:<?= $r['payment_status']=='paid'?'green':'red'?>">
            <?= ucfirst($r['payment_status']) ?>
        </span>
        <?php if($r['payment_status'] !== 'paid'): ?>
          <a href="pay.php?id=<?= $r['id'] ?>" style="margin-left:10px; font-size:12px; color: #3498db;">[Pay Now]</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; endif; ?>
</div>
<?php } ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>
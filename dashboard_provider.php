<?php
require_once __DIR__ . '/../inc/header.php';
require_login();

$role = $_SESSION['role'] ?? 'user';
$user_id = $_SESSION['user_id'] ?? 0;

// Only allow providers to access this page
if (!in_array($role, ['provider', 'business', 'volunteer'])) {
  header("Location: dashboard.php");
  exit;
}

// Fetch provider category
$stmt = safe_prepare($mysqli, "SELECT business_category, name FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$res = $stmt->get_result();
$provider = $res->fetch_assoc();
$stmt->close();

$business_category = $provider['business_category'] ?? '';
$provider_name = $provider['name'] ?? 'Provider';

// Fetch all help requests that match provider category
$stmt = safe_prepare($mysqli, "
  SELECT p.*, u.name AS requester_name, u.phone AS requester_phone
  FROM problems p
  LEFT JOIN users u ON p.user_id = u.id
  WHERE p.category = ?
  ORDER BY p.created_at DESC
");
$stmt->bind_param('s', $business_category);
$stmt->execute();
$res = $stmt->get_result();
$requests = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Provider Dashboard - KindConnect</title>
<style>
body { background:#f6f8f9; font-family: 'Segoe UI', Roboto, sans-serif; margin:0; margin-bottom: 20px;}
.container { max-width:1000px; background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.06); margin-right: 20px; margin-left: 20px; }
h2 { color:#111; margin-bottom:6px; }
p.sub { color:#555; margin-bottom:25px; }
table { width:100%; border-collapse:collapse; margin-top:10px; }
th, td { border:1px solid #eef2f4; padding:10px; text-align:left; font-size:14px; }
th { background:#f9fafb; color:#333; }
td { vertical-align:top; }
.status-open { color:#1f7fe0; font-weight:600; }
.status-accepted { color:#16a34a; font-weight:600; }
.status-canceled { color:#e11d48; font-weight:600; }
footer { text-align:center; margin-top:25px; color:#777; font-size:13px; }
.card-row { display:flex; flex-wrap:wrap; gap:15px; margin-bottom:25px; }
.card { flex:1 1 200px; background:#fff; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05); text-align:center; padding:15px; }
.card h3 { margin:0; font-size:14px; color:#444; }
.card div { font-size:20px; font-weight:700; color:#2ecc71; margin-top:6px; }
@media(max-width:720px){ .card-row{flex-direction:column;} }
</style>
</head>
<body>
  <div class="container">
    <h2>Welcome, <?= h($provider_name) ?></h2>
    <p class="sub">Business category: <strong><?= h($business_category) ?></strong></p>

    <div class="card-row">
      <?php 
      $total = count($requests);
      $pending = $accepted = $canceled = 0;
      $accepted = count($accepted);
      foreach ($requests as $r) {
        $s = strtolower($r['status'] ?? 'open');
        if ($s === 'accepted') $accepted++; elseif ($s === 'canceled') $canceled++; else $pending++;
      }
      ?>
      <div class="card"><h3>Total Requests</h3><div><?= $total ?></div></div>
      <div class="card"><h3>Pending</h3><div><?= $pending ?></div></div>
      <div class="card"><h3>Accepted</h3><div><?= $accepted ?></div></div>
      <div class="card"><h3>Canceled</h3><div><?= $canceled ?></div></div>
    </div>

    <h3>Help Requests (<?= h($business_category) ?>)</h3>
    <?php if(empty($requests)): ?>
      <p>No help requests available for your category right now.</p>
    <?php else: ?>
      <table>
        <tr>
          <th>ID</th>
          <th>Requester</th>
          <th>Phone</th>
          <th>Title</th>
          <th>Description</th>
          <th>Posted On</th>
        </tr>
        <?php foreach($requests as $r): ?>
        <tr>
          <td><?= intval($r['id']) ?></td>
          <td><?= h($r['requester_name'] ?? '') ?></td>
          <td><?= h($r['requester_phone'] ?? '') ?></td>
          <td><?= h($r['title'] ?? '') ?></td>
          <td><?= nl2br(h($r['description'] ?? '')) ?></td>
          <td><?= h($r['created_at'] ?? '') ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>

    <footer>© KindConnect 2025 | Built by BCA Students, SGM College Karad</footer>
  </div>
</body>
</html>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>

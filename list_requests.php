<?php
require_once __DIR__ . '/../inc/header.php';
require_login();
$user_id = $_SESSION['user_id'];

// Total count for THIS USER ONLY
$total_stmt = safe_prepare($mysqli, "SELECT COUNT(*) AS total FROM problems WHERE user_id = ?");
$total_stmt->bind_param('i', $user_id);
$total_stmt->execute();
$total = $total_stmt->get_result()->fetch_assoc()['total'];

// Pagination
$page = max(1, (int)($_GET['page'] ?? 1));
$per_page = 10;
$offset = ($page - 1) * $per_page;
$pages = (int)ceil($total / $per_page);

// Fetch requests for THIS USER ONLY
$stmt = safe_prepare($mysqli, "
  SELECT * FROM problems 
  WHERE user_id = ? 
  ORDER BY created_at DESC 
  LIMIT ?, ?
");
$stmt->bind_param('iii', $user_id, $offset, $per_page);
$stmt->execute();
$requests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<div class="main-content" style="max-width:800px; margin:20px auto; background:#fff; padding:20px;">
  <h2>Your Request History</h2>

  <?php if(empty($requests)): ?>
    <p>You haven't created any requests.</p>
  <?php else: foreach($requests as $r): ?>
    <div style="border-bottom:1px solid #eee; padding:15px 0;">
      <strong><?= h($r['title']) ?></strong> [<?= h($r['status']) ?>]
      <p style="font-size:14px; color:#555;"><?= h($r['description']) ?></p>
      <small>Category: <?= h($r['category']) ?> | Date: <?= h($r['created_at']) ?></small>
    </div>
  <?php endforeach; endif; ?>

  <div style="margin-top:20px;">
    <?php for($i=1;$i<=$pages;$i++): ?>
      <a href="?page=<?= $i ?>" style="padding:5px; <?= $i==$page ? 'font-weight:bold' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
</div>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>
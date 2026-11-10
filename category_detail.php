<?php
require_once __DIR__ . '/../inc/header.php';

$cat = trim($_GET['cat'] ?? '');
if (!$cat) {
    header("Location: " . SITE_URL . "/public/services.php");
    exit;
}

// safe mapping for images & descriptions (for demo, use images/ folder)
$images = [
  'Plumbing' => 'images/plumbing.jpg',
  'Electrical' => 'images/electrical.jpg',
  'Medical' => 'images/medical.jpg',
  'Grocery' => 'images/grocery.jpg',
  'Home Repair' => 'images/home_repair.jpg',
];

$desc = [
  'Plumbing' => 'Local plumbing help — taps, leaks, pipes and emergency assistance.',
  'Electrical' => 'Electricians for wiring, small repairs, and emergency electrical help.',
  'Medical' => 'Medical shops and volunteers who can deliver medicines.',
  'Grocery' => 'Grocery shops offering delivery for essentials.',
  'Home Repair' => 'General home repair and carpentry assistance.',
];

$image = $images[$cat] ?? 'images/default.jpg';
$info = $desc[$cat] ?? 'No description available for this category yet.';
?>
<div class="container main-content">
  <h2><?= h($cat) ?></h2>
  <img src="<?= SITE_URL . '/' . $image ?>" alt="<?= h($cat) ?>">
  <p style="margin-top:12px;"><?= h($info) ?></p>

  <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'business'): ?>
    <p><a href="<?= SITE_URL ?>/public/list_requests.php?cat=<?= urlencode($cat) ?>">View requests in this category</a></p>
  <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
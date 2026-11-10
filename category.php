<?php
require_once __DIR__ . '/../inc/header.php';
error_reporting(0);
ini_set('display_errors', 0);
// Get the slug from the URL (e.g., category.php?cat=plumber)
$slug = $_GET['cat'] ?? '';
$slug = preg_replace('/[^a-z0-9-]/', '', strtolower($slug));

// Fetch the service details from the database based on the slug
$stmt = $mysqli->prepare("SELECT * FROM categories_db WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
$cat = $result->fetch_assoc();

// If the service doesn't exist in the database, show 404
if (!$cat) {
    http_response_code(404);
    ?>
    <div class="container main-content">
      <h2>Category not found</h2>
      <p class="muted">We couldn't find the category you requested. <a href="<?= SITE_URL ?>/public/services.php">Back to services</a></p>
    </div>
    <?php
    require_once __DIR__ . '/../inc/footer.php';
    exit;
}
?>
<div class="container main-content">
  <a href="<?= SITE_URL ?>/public/services.php" class="muted">&larr; Back to Services</a>
  <div class="category-detail card" style="align-items:center;justify-content:center; display:flex;gap:20px;padding:20px;box-shadow:0 4px 6px rgba(0,0,0,0.1);margin-top:16px;flex-wrap:wrap;">
    <div style="height: 400px; width: 700px" class="category-image">
      <img src="<?= SITE_URL ?>/public/assets/images/<?= htmlspecialchars($cat['image']) ?>" alt="<?= htmlspecialchars($cat['title']) ?>" style="width: 700px; height:300px; object-fit: cover; border-radius: 5px 5px 0 0;">
    </div>
    <div style="flex:1;">
      <h2><?= htmlspecialchars($cat['title']) ?></h2>
      <div class="muted"><?= htmlspecialchars($cat['short']) ?></div>
      <div style="margin-top:12px;"><?= $cat['description'] ?></div>

      <div style="margin-top:16px;">
        <strong>Example contact</strong>
        <p class="muted">Use the post request feature or contact local listed providers.</p>
      </div>
    </div>
  </div>
</div>
<section class="providers-section">
  <h2 class="providers-title">KindConnect Developers</h2>

  <div class="providers-grid">
    <div class="provider-card">
      <img src="./../assets/images/prajwal.jpg" alt="Provider">
      <div class="provider-body">
        <h3>Prajwal Pharande</h3>
        <div class="provider-rating">⭐ 4.8 <span>(120 jobs)</span></div>
        <p>10+ years experience in residential and commercial electrical work.</p>
      </div>
    </div>

    <div class="provider-card">
      <img src="./../assets/images/anuj.jpeg" alt="Provider">
      <div class="provider-body">
        <h3>Anuj Yadav</h3>
        <div class="provider-rating">⭐ 4.6 <span>(85 jobs)</span></div>
        <p>Certified electrician specializing in safety inspections and repairs.</p>
      </div>
    </div>

    <div class="provider-card">
      <img src="./../assets/images/vivek.jpeg" alt="Provider">
      <div class="provider-body">
        <h3>Vivek Yadav</h3>
        <div class="provider-rating">⭐ 4.9 <span>(210 jobs)</span></div>
        <p>Fast, reliable service for homes and small businesses.</p> 
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>

<?php
// inc/header.php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// ✅ Add this line only:
$public_path = SITE_URL . '/public';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** Connect to DB (don't silence errors) */
$mysqli = connect_db();
if ($mysqli === null) {
    // DB connection failed. For development show an unobtrusive message in logs
    error_log("Unable to connect to DB from header.php - check DB settings in inc/config.php");
    // You can show a small banner for developers (comment out for production)
    $db_warning = true;
} else {
    $db_warning = false;
}

$is_logged_in = !empty($_SESSION['user_id']);
$user_name = $is_logged_in ? h($_SESSION['name']) : '';

?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>KindConnect</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Main CSS -->
  <link rel="stylesheet" href="<?= SITE_URL ?>/public/assets/css/redesign.css">

  <!-- Main JS (defer) -->
  <script defer src="<?= SITE_URL ?>/public/assets/js/redesign.js"></script>

<style>
.has-submenu .submenu { display:none; list-style:none; padding-left:20px; }
.has-submenu.open .submenu { display:block; }
.submenu-toggle { cursor:pointer; display:block; padding:8px 12px; color:#fff; text-decoration:none; }
.submenu a { display:block; padding:6px 16px; color:#ddd; text-decoration:none; }
.submenu a:hover { background-color:#0d7a6f; color:#fff; }
body{ max-width: 100%;}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.submenu-toggle').forEach(function(toggle){
    toggle.addEventListener('click',function(e){
      e.preventDefault();
      this.parentElement.classList.toggle('open');
    });
  });
});
</script>

</head>
<body>
<div class="container-fluid" style="max-width: 100%;">
<?php if (!empty($db_warning)): ?>
  <div class="db-warning" role="alert" style="background:#fff2f2;color:#6b0b0b;padding:8px;text-align:center;font-size:13px;">
    Warning: Unable to connect to database. Some features may be unavailable. (Check server logs)
  </div>
<?php endif; ?>

<header class="site-header">
  <div class="header-inner container">
    <div style="display:flex;align-items:center;gap:12px">
      <button id="menuBtn" class="menu-btn" aria-label="Open navigation">☰</button>
      <div class="brand">
        <a href="<?= SITE_URL ?>/public/index.php" class="brand-link">KindConnect</a>
      </div>
    </div>

    <nav class="top-nav" aria-label="Main navigation">
      <?php if ($is_logged_in): ?>
        <?php if(($_SESSION['role'] ?? '') !== 'business' && ($_SESSION['role'] ?? '') !== 'admin'): ?>
          <a href="<?= SITE_URL ?>/public/post_problem.php" class="btn-link">Post Request</a>
        <?php endif; ?>
        <?php if(($_SESSION['role'] ?? '') == 'admin'): ?>
        <a href="<?= SITE_URL ?>/public/admin_dashboard.php">Dashboard</a>
        <?php else: ?>
        <a href="<?= SITE_URL ?>/public/dashboard.php">Dashboard</a>
        <?php endif; ?>
        <a href="<?= SITE_URL ?>/public/logout.php">Logout</a>
      <?php else: ?>
        <a id="open-login" href="<?= SITE_URL ?>/public/login.php">Login</a>
        <a id="open-signup" href="<?= SITE_URL ?>/public/register.php">Sign up</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<!-- Sidebar (hidden by default, slides in when .open applied) -->
<aside id="siteSidebar" class="sidebar" aria-hidden="true" role="navigation">
  <div class="sidebar-inner">
    <div class="sidebar-brand">
      <a href="<?= SITE_URL ?>/public/index.php">KindConnect</a>
    </div>

    <ul class="sidebar-list">
      <li><a href="<?= SITE_URL ?>/public/index.php">Home</a></li>
      <li><a href="<?= SITE_URL ?>/public/services.php">Services</a></li>
      <?php if ($is_logged_in): ?>
        
        <?php if(!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <li><a href="<?= SITE_URL ?>/public/admin_dashboard.php" style="color: #f39c12; font-weight: bold;">Admin Panel</a></li>
        <?php endif; ?>
        <?php if(!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <li><a href="<?= SITE_URL ?>/public/user_management.php" style="color: #f39c12; font-weight: bold;">User Management</a></li>
        <?php endif; ?>
        <?php if(!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <li><a href="<?= SITE_URL ?>/public/help_request_management.php" style="color: #f39c12; font-weight: bold;">Help Request Management</a></li>
        <?php endif; ?>
        <li><a href="<?= SITE_URL ?>/public/profile.php">Profile</a></li>
        <?php if(!empty($_SESSION['role']) && ($_SESSION['role'] === 'business' || $_SESSION['role'] === 'volunteer' || $_SESSION['role'] === 'admin')): ?>

          <li><a href="<?= SITE_URL ?>/public/dashboard.php">Dashboard</a></li>
          
</li>
          <li><a href="<?= SITE_URL ?>/public/list_requests.php"></a></li>
          <!-- show counts next to Request (AJAX could be used later) -->
        <?php endif; ?>
        <li><a href="<?= SITE_URL ?>/public/logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="<?= SITE_URL ?>/public/login.php">Login</a></li>
        <li><a href="<?= SITE_URL ?>/public/register.php">Sign up</a></li>
      <?php endif; ?>


</ul>
  </div>
</aside>

<!-- Overlay shown when sidebar is open -->
<div id="sidebarOverlay" class="sidebar-overlay" hidden></div>
</div>
<!-- page main start -->
<main>

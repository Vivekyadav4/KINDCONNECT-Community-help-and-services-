<?php
// ADDED: Start output buffering for safe redirection after logging out
ob_start();

// public/logout.php - clean logout and redirect
require_once __DIR__ . '/../inc/config.php';

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

// Clear session
$_SESSION = [];
session_unset();
session_destroy();

// Redirect to home
header("Location: " . SITE_URL . "/public/index.php");
exit;
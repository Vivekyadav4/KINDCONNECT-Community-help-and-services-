<?php
require_once __DIR__ . '/../inc/config.php';
require_once __DIR__ . '/../inc/functions.php';
require_login();

if ($_SESSION['role'] !== 'admin') { die("Unauthorized"); }

$mysqli = connect_db();

// Handle User Deletion
if (isset($_GET['delete_user'])) {
    $id = (int)$_GET['delete_user'];
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

// Handle Problem Deletion
if (isset($_GET['delete_problem'])) {
    $id = (int)$_GET['delete_problem'];
    $stmt = $mysqli->prepare("DELETE FROM problems WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

header("Location: admin_dashboard.php");
exit;
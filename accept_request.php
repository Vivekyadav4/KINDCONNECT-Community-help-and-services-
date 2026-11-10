<?php
require_once __DIR__ . '/../inc/header.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id = intval($_POST['id']);
  $provider_id = $_SESSION['user_id'];

  $stmt = safe_prepare($mysqli, "UPDATE problems SET status='accepted', accepted_by=? WHERE id=? AND status='open'");
  $stmt->bind_param('ii', $provider_id, $id);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    header("Location: dashboard.php?msg=accepted");
  } else {
    header("Location: dashboard.php?msg=failed");
  }
  exit;
} else {
  header("Location: dashboard.php");
  exit;
}
?>

<?php
require_once __DIR__ . '/../inc/config.php';
require_once __DIR__ . '/../inc/functions.php';

// Ensure the user is logged in
require_login();

// FIX: Establish the database connection so $mysqli is defined
$mysqli = connect_db(); 

$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);
$provider_id = $_SESSION['user_id'];

if ($id > 0) {
    if ($action === 'accept') {
        // Only accept if the status is currently 'open'
        $stmt = safe_prepare($mysqli, "UPDATE problems SET status='accepted', accepted_by=? WHERE id=? AND status='open'");
        $stmt->bind_param('ii', $provider_id, $id);
        $stmt->execute();
        $stmt->close();
    } 
    elseif ($action === 'cancel') {
        // Revert status to 'open' and remove the provider's ID
        // This allows other providers to see and accept the request again
        $stmt = safe_prepare($mysqli, "UPDATE problems SET status='open', accepted_by=NULL WHERE id=? AND accepted_by=?");
        $stmt->bind_param('ii', $id, $provider_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirect back to the dashboard after the action is complete
header("Location: dashboard.php");
exit;
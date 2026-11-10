<?php
// inc/functions.php - reusable helpers
// ✅ Define base site URL if not already defined
if (!defined('SITE_URL')) {
    define('SITE_URL', 'http://localhost/kindconnect');
}

/**
 * Create and return mysqli connection using constants from config.php
 * @return mysqli
 */
function connect_db() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($mysqli->connect_errno) {
        // Log the error and return null so callers can handle it.
        error_log("DB connection failed (Port: " . DB_PORT . "): " . $mysqli->connect_error);
        return null;
    }
    $mysqli->set_charset("utf8mb4");
    return $mysqli;
}

/** Escape HTML output **/
function h($str) {
    return htmlspecialchars((string)$str ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/** Ensure the user is logged in; if not, redirect to login */
function require_login() {
    if (empty($_SESSION['user_id'])) {
        header("Location: " . SITE_URL . "/public/login.php");
        exit;
    }
}

/** Simple JSON helper used by AJAX endpoints **/
function send_json($ok, $msg = '', $extra = []) {
    header('Content-Type: application/json');
    echo json_encode(array_merge(['success' => $ok, 'message' => $msg], $extra));
    exit;
}

/** Log an application error to inc/error.log with a timestamp **/
function log_error($msg) {
    $file = __DIR__ . '/error.log';
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL;
    // Use error_log as well for server logs
    error_log($msg);
    @file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
}

/** Safely prepare a mysqli statement. Returns statement or false. **/
function safe_prepare($mysqli, $sql) {
    if (empty($mysqli) || !($mysqli instanceof mysqli)) {
        log_error('safe_prepare: mysqli object is null or invalid.');
        return false;
    }
    // mysqli::prepare can return false
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        log_error('safe_prepare: statement failed: ' . $mysqli->error . ' Query: ' . $sql);
    }
    return $stmt;
}
<?php
// inc/config.php - central configuration (safe defaults + auto SITE_URL)

// --- DB settings: adjust to your environment if needed ---
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');         // set MySQL root password if any
define('DB_NAME', 'kindconnect');
// Most local setups use 3306; if your XAMPP uses 3307 keep it there
// *** CHECK THIS: Change 3307 to 3306 if your MySQL is not running on 3307 ***
define('DB_PORT', 3307);

// Build base URL (http/https) + project folder (auto-detected)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base_url = $protocol . '://' . $host;

// Determine project root by moving up from the current script path.
// Typical layout: /<project>/public/... so dirname(dirname($_SERVER['SCRIPT_NAME'])) -> /<project>
$possible_root = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');

// If root resolves to '.' or to root slash, set empty
if ($possible_root === '.' || $possible_root === '/' || $possible_root === '\\') {
    $possible_root = '';
}

// Final SITE_URL (no trailing slash)
define('SITE_URL', rtrim($base_url . $possible_root, '/'));

// Start session once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
<?php
// includes/config.php
session_start();

// Database configuration - adjust for your XAMPP setup
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sablon_custom');

// Admin WhatsApp number (used for checkout redirect)
define('ADMIN_WA', '628986709016'); // change to admin number in international format without +

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Set character set
$conn->set_charset('utf8mb4');

// Useful base paths
define('BASE_URL', '/sablon'); // adjust if project is in subfolder
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads');
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

?>

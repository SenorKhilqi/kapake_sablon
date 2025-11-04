<?php
// includes/functions.php
require_once __DIR__ . '/config.php';

function esc($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function is_logged_in() {
    return !empty($_SESSION['user_id']);
}

function is_admin() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function format_rupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

function get_products() {
    global $conn;
    $sql = "SELECT * FROM products ORDER BY created_at DESC";
    $res = $conn->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

function get_product($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc();
}

function get_cart_count($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM cart WHERE id_user = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res ? (int)$res['cnt'] : 0;
}

function get_total_cart_count() {
    global $conn;
    $res = $conn->query("SELECT COUNT(*) AS cnt FROM cart");
    if ($res) {
        $row = $res->fetch_assoc();
        return (int)($row['cnt'] ?? 0);
    }
    return 0;
}

function get_total_cart_value() {
    global $conn;
    $res = $conn->query("SELECT SUM(p.harga * c.quantity) AS total FROM cart c JOIN products p ON c.id_produk = p.id");
    if ($res) {
        $row = $res->fetch_assoc();
        return $row['total'] ? (float)$row['total'] : 0.0;
    }
    return 0.0;
}

function get_pending_orders_count() {
    global $conn;
    $res = $conn->query("SELECT COUNT(*) AS cnt FROM orders WHERE status = 'Menunggu Pembayaran'");
    if ($res) {
        $row = $res->fetch_assoc();
        return (int)($row['cnt'] ?? 0);
    }
    return 0;
}

function get_total_revenue() {
    global $conn;
    // sum only completed orders
    $res = $conn->query("SELECT SUM(total_harga) AS total FROM orders WHERE status = 'Selesai'");
    if ($res) {
        $row = $res->fetch_assoc();
        return $row['total'] ? (float)$row['total'] : 0.0;
    }
    return 0.0;
}

/**
 * Get total revenue (sum) and count of completed orders between two datetime strings (inclusive)
 * $start and $end must be in 'Y-m-d H:i:s' format
 * Returns array: ['total' => float, 'count' => int]
 */
function get_revenue_between($start, $end) {
    global $conn;
    $sql = "SELECT COALESCE(SUM(total_harga),0) AS total, COUNT(*) AS cnt FROM orders WHERE status = 'Selesai' AND tanggal >= ? AND tanggal <= ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return ['total' => 0.0, 'count' => 0];
    $stmt->bind_param('ss', $start, $end);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res ? $res->fetch_assoc() : null;
    if ($row) {
        return ['total' => (float)($row['total'] ?? 0.0), 'count' => (int)($row['cnt'] ?? 0)];
    }
    return ['total' => 0.0, 'count' => 0];
}

/**
 * Get orders between two datetime strings (inclusive). Returns array of orders with user name
 */
function get_orders_between($start, $end) {
    global $conn;
    $sql = "SELECT o.*, u.nama FROM orders o JOIN users u ON o.id_user = u.id WHERE o.tanggal >= ? AND o.tanggal <= ? ORDER BY o.tanggal DESC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];
    $stmt->bind_param('ss', $start, $end);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

/**
 * Return weekly summary of orders: array of ['year'=>Y, 'week'=>W, 'cnt'=>N, 'total'=>SUM]
 * Limit default to most recent $weeks entries
 */
function get_weekly_summary($weeks = 4) {
    global $conn;
    $weeks = (int)$weeks;
    $sql = "SELECT YEAR(tanggal) AS y, WEEK(tanggal,1) AS w, COUNT(*) AS cnt, COALESCE(SUM(total_harga),0) AS total FROM orders GROUP BY y, w ORDER BY y DESC, w DESC LIMIT " . $weeks;
    $res = $conn->query($sql);
    $out = [];
    if ($res) {
        while ($r = $res->fetch_assoc()) {
            $out[] = $r;
        }
    }
    return $out;
}

/**
 * Return monthly summary of orders: array of ['ym'=>YYYY-MM, 'cnt'=>N, 'total'=>SUM]
 * Limit default to most recent $months entries
 */
function get_monthly_summary($months = 6) {
    global $conn;
    $months = (int)$months;
    $sql = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS ym, COUNT(*) AS cnt, COALESCE(SUM(total_harga),0) AS total FROM orders GROUP BY ym ORDER BY ym DESC LIMIT " . $months;
    $res = $conn->query($sql);
    $out = [];
    if ($res) {
        while ($r = $res->fetch_assoc()) {
            $out[] = $r;
        }
    }
    return $out;
}

/**
 * Get all orders (transactions) in the last N weeks
 * Returns array of orders with user name
 */
function get_transactions_last_weeks($weeks = 6) {
    global $conn;
    $weeks = (int)$weeks;
    $start = date('Y-m-d H:i:s', strtotime("-{$weeks} week"));
    $sql = "SELECT o.*, u.nama FROM orders o JOIN users u ON o.id_user = u.id WHERE o.tanggal >= ? ORDER BY o.tanggal DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $start);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

/**
 * Get all orders (transactions) in the last N months
 * Returns array of orders with user name
 */
function get_transactions_last_months($months = 6) {
    global $conn;
    $months = (int)$months;
    $start = date('Y-m-d H:i:s', strtotime("-{$months} month"));
    $sql = "SELECT o.*, u.nama FROM orders o JOIN users u ON o.id_user = u.id WHERE o.tanggal >= ? ORDER BY o.tanggal DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $start);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

function allowed_image($file) {
    $allowed = ['image/png', 'image/jpeg'];
    return in_array($file['type'], $allowed);
}

function upload_image($file) {
    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    if ($file['size'] > 2 * 1024 * 1024) return false; // 2MB
    if (!allowed_image($file)) return false;

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = uniqid('img_') . '.' . $ext;
    $dest = UPLOAD_DIR . '/' . $name;
    if (move_uploaded_file($file['tmp_name'], $dest)) {
        return 'assets/uploads/' . $name; // public path
    }
    return false;
}

function get_user_cart($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT c.*, p.nama_produk, p.harga, p.foto FROM cart c JOIN products p ON c.id_produk = p.id WHERE c.id_user = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
}

function calculate_cart_total($items) {
    $total = 0;
    foreach ($items as $it) {
        $total += $it['harga'] * $it['quantity'];
    }
    return $total;
}

?>

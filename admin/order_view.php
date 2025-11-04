<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/header.php';
require_admin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT o.*, u.nama, u.no_wa FROM orders o JOIN users u ON o.id_user = u.id WHERE o.id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
if (!$order) {
    echo '<div class="alert alert-danger">Order tidak ditemukan.</div>';
  require_once __DIR__ . '/footer.php';
    exit;
}

$stmt2 = $conn->prepare("SELECT od.*, p.nama_produk FROM order_details od JOIN products p ON od.id_produk = p.id WHERE od.id_order = ?");
$stmt2->bind_param('i', $id);
$stmt2->execute();
$details = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<h2>Detail Pesanan #<?php echo $order['id']; ?></h2>
<p>User: <?php echo esc($order['nama']); ?> (<?php echo esc($order['no_wa']); ?>)</p>
<p>Tanggal: <?php echo $order['tanggal']; ?></p>
<p>Status: <?php echo esc($order['status']); ?></p>
<ul class="list-group mb-3">
  <?php foreach ($details as $d): ?>
    <li class="list-group-item d-flex justify-content-between">
      <?php echo esc($d['nama_produk']) . ' x' . (int)$d['quantity']; ?>
      <span><?php echo format_rupiah($d['harga'] * $d['quantity']); ?></span>
    </li>
  <?php endforeach; ?>
  <li class="list-group-item d-flex justify-content-between"><strong>Total</strong><strong><?php echo format_rupiah($order['total_harga']); ?></strong></li>
</ul>

<?php require_once __DIR__ . '/footer.php'; ?>

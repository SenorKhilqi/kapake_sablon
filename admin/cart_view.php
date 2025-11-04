<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/header.php';
require_admin();

$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
if (!$user_id) {
    echo '<div class="alert alert-danger">User tidak dipilih.</div>';
    require_once __DIR__ . '/footer.php';
    exit;
}

// Admin view only: no delete or convert functionality here. Cart is read-only for admin.

// fetch user info
$u = $conn->prepare("SELECT id, nama, email FROM users WHERE id = ?");
$u->bind_param('i', $user_id);
$u->execute();
$user = $u->get_result()->fetch_assoc();
if (!$user) {
  echo '<div class="alert alert-danger">User tidak ditemukan.</div>';
  require_once __DIR__ . '/footer.php';
  exit;
}

// fetch cart items
$stmt = $conn->prepare("SELECT c.*, p.nama_produk, p.harga FROM cart c JOIN products p ON c.id_produk = p.id WHERE c.id_user = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$total = 0;
foreach ($items as $it) $total += $it['harga'] * $it['quantity'];
?>

<h2>Cart User: <?php echo esc($user['nama']); ?> (<?php echo esc($user['email']); ?>)</h2>
<?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo esc($error); ?></div><?php endif; ?>

<?php if (empty($items)): ?>
  <div class="alert alert-info">Keranjang kosong untuk user ini.</div>
<?php else: ?>
  <table class="table">
    <thead><tr><th>Produk</th><th>Warna/Size</th><th>Qty</th><th>Harga</th><th>Subtotal</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php foreach ($items as $it): ?>
        <tr>
          <td><?php echo esc($it['nama_produk']); ?></td>
          <td><?php echo esc($it['warna'] . ' / ' . $it['size']); ?></td>
          <td><?php echo (int)$it['quantity']; ?></td>
          <td><?php echo format_rupiah($it['harga']); ?></td>
          <td><?php echo format_rupiah($it['harga'] * $it['quantity']); ?></td>
          <td><!-- read-only -->&mdash;</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Total: <?php echo format_rupiah($total); ?></h4>
    <a class="btn btn-sm btn-outline-primary" href="orders.php">Kelola Pesanan</a>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>

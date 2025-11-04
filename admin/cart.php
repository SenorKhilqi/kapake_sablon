<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/header.php';
require_admin();

// List distinct users who have items in cart with counts and totals
$sql = "SELECT u.id AS user_id, u.nama, u.email, COUNT(c.id) AS items_count, SUM(p.harga * c.quantity) AS total_price
        FROM cart c
        JOIN users u ON c.id_user = u.id
        JOIN products p ON c.id_produk = p.id
        GROUP BY u.id
        ORDER BY u.nama ASC";
$res = $conn->query($sql);
?>

<h2>Keranjang Pengguna (Admin)</h2>
<?php if (!$res || $res->num_rows === 0): ?>
  <div class="alert alert-info">Tidak ada keranjang aktif.</div>
<?php else: ?>
  <table class="table table-hover">
    <thead>
      <tr><th>User</th><th>Email</th><th>Items</th><th>Total</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
          <td><?php echo esc($row['nama']); ?></td>
          <td><?php echo esc($row['email']); ?></td>
          <td><?php echo (int)$row['items_count']; ?></td>
          <td><?php echo format_rupiah($row['total_price'] ?? 0); ?></td>
          <td>
            <a class="btn btn-sm btn-primary" href="cart_view.php?user_id=<?php echo $row['user_id']; ?>">Lihat</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>

<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/header.php';
require_admin();

// Update status with validation and flash message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status_update'])) {
  $id = (int)$_POST['order_id'];
  $status = $_POST['status'];
  $allowed = ['Menunggu Pembayaran','Sudah Dibayar','Selesai'];
  if (!in_array($status, $allowed)) {
    $_SESSION['admin_msg'] = 'Status tidak valid.';
  } else {
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $status, $id);
    if ($stmt->execute()) {
      $_SESSION['admin_msg'] = 'Status pesanan berhasil diubah.';
    } else {
      $_SESSION['admin_msg'] = 'Gagal mengubah status pesanan.';
    }
  }
  header('Location: orders.php');
  exit;
}

$orders = $conn->query("SELECT o.*, u.nama FROM orders o JOIN users u ON o.id_user = u.id ORDER BY o.tanggal DESC");
?>

<style>
  .table-container {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  }
  .table-container h5 {
    font-weight: 700;
    margin-bottom: 20px;
    color: #1e293b;
  }
  .table-modern {
    font-size: 0.9rem;
  }
  .table-modern thead th {
    background: #f8fafc;
    color: #475569;
    font-weight: 600;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px;
  }
  .table-modern tbody td {
    padding: 12px;
    vertical-align: middle;
  }
  .table-modern tbody tr:hover {
    background: #f8fafc;
  }
  /* Column widths for better layout */
  .table-modern th:nth-child(1) { min-width: 80px; } /* Order ID */
  .table-modern th:nth-child(2) { min-width: 150px; } /* Pelanggan */
  .table-modern th:nth-child(3) { min-width: 130px; } /* Tanggal */
  .table-modern th:nth-child(4) { min-width: 120px; } /* Total */
  .table-modern th:nth-child(5) { min-width: 100px; } /* Pembayaran */
  .table-modern th:nth-child(6) { min-width: 140px; } /* Status */
  .table-modern th:nth-child(7) { min-width: 340px; } /* Aksi */
  
  .badge-status {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .badge-pending {
    background: #fef3c7;
    color: #92400e;
  }
  .badge-paid {
    background: #dbeafe;
    color: #1e40af;
  }
  .badge-done {
    background: #d1fae5;
    color: #065f46;
  }
  .btn-update {
    background: linear-gradient(135deg, #3b82f6, #60a5fa);
    border: none;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
  }
  .btn-update:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    color: #fff;
  }
  .btn-view {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #475569;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
  }
  .btn-view:hover {
    background: #e2e8f0;
    color: #1e293b;
  }
  .action-form {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: nowrap;
  }
  .action-form .form-select {
    min-width: 160px;
    max-width: 180px;
  }
  
  /* Responsive Styles */
  @media (max-width: 768px) {
    .table-container {
      padding: 16px;
    }
    .table-container h5 {
      font-size: 1.1rem;
      margin-bottom: 16px;
    }
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }
    .table-modern {
      font-size: 0.8rem;
      min-width: 1000px; /* Allow horizontal scroll on mobile */
    }
    .table-modern thead th,
    .table-modern tbody td {
      padding: 8px;
    }
    .badge-status {
      padding: 4px 8px;
      font-size: 0.75rem;
      gap: 4px;
    }
    .form-select-sm {
      font-size: 0.75rem;
      padding: 4px 8px;
      min-width: 140px;
    }
    .btn-update, .btn-view {
      padding: 4px 8px;
      font-size: 0.75rem;
    }
    .action-form {
      gap: 4px;
    }
  }
  
  @media (max-width: 576px) {
    .mb-4 h2 {
      font-size: 1.5rem;
    }
    .mb-4 p {
      font-size: 0.85rem;
    }
  }
</style>

<div class="mb-4">
  <h2 class="mb-1">Kelola Pesanan</h2>
  <p class="text-muted mb-0">Lihat dan kelola status pesanan pelanggan</p>
</div>

<?php if (!empty($_SESSION['admin_msg'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-check-circle me-2"></i><?php echo esc($_SESSION['admin_msg']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  <?php unset($_SESSION['admin_msg']); ?>
<?php endif; ?>

<div class="table-container">
  <h5><i class="fa-solid fa-shopping-bag me-2"></i>Daftar Pesanan</h5>
  <div class="table-responsive">
    <table class="table table-modern table-hover">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Pelanggan</th>
          <th>Tanggal</th>
          <th>Total</th>
          <th>Pembayaran</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($o = $orders->fetch_assoc()): ?>
          <tr>
            <td><strong>#<?php echo $o['id']; ?></strong></td>
            <td><?php echo esc($o['nama']); ?></td>
            <td><?php echo date('d M Y H:i', strtotime($o['tanggal'])); ?></td>
            <td><strong><?php echo format_rupiah($o['total_harga']); ?></strong></td>
            <td><span class="badge bg-secondary"><?php echo esc($o['metode_pembayaran']); ?></span></td>
            <td>
              <?php
                $badge_class = 'badge-pending';
                $icon = 'fa-clock';
                if ($o['status'] === 'Sudah Dibayar') {
                  $badge_class = 'badge-paid';
                  $icon = 'fa-credit-card';
                } elseif ($o['status'] === 'Selesai') {
                  $badge_class = 'badge-done';
                  $icon = 'fa-check-circle';
                }
              ?>
              <span class="badge-status <?php echo $badge_class; ?>">
                <i class="fa-solid <?php echo $icon; ?>"></i>
                <?php echo esc($o['status']); ?>
              </span>
            </td>
            <td>
              <form method="post" class="action-form">
                <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                <select name="status" class="form-select form-select-sm">
                  <option <?php if ($o['status']=='Menunggu Pembayaran') echo 'selected'; ?>>Menunggu Pembayaran</option>
                  <option <?php if ($o['status']=='Sudah Dibayar') echo 'selected'; ?>>Sudah Dibayar</option>
                  <option <?php if ($o['status']=='Selesai') echo 'selected'; ?>>Selesai</option>
                </select>
                <button name="status_update" class="btn btn-update btn-sm" title="Update Status">
                  <i class="fa-solid fa-sync"></i>
                </button>
                <a class="btn btn-view btn-sm" href="order_view.php?id=<?php echo $o['id']; ?>" title="Lihat Detail">
                  <i class="fa-solid fa-eye"></i>
                </a>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

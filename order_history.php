<?php
// order_history.php - Halaman Riwayat Pesanan
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

require_login();
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE id_user = ? ORDER BY tanggal DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
  <section class="section-padding">
    <h1 class="mb-4" data-aos="fade-up">
      <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Riwayat Pesanan
    </h1>

    <?php if (empty($orders)): ?>
      <div class="text-center py-5" data-aos="fade-up">
        <i class="fa-solid fa-receipt text-muted" style="font-size:4rem;opacity:0.3;"></i>
        <h4 class="mt-4 mb-3">Belum Ada Riwayat Pesanan</h4>
        <p class="text-muted mb-4">Anda belum melakukan pemesanan. Mulai belanja sekarang!</p>
        <a href="products.php" class="btn btn-primary btn-lg px-5">
          <i class="fa-solid fa-box-open me-2"></i>Lihat Produk
        </a>
      </div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($orders as $index => $o): ?>
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo 50 * $index; ?>">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <div>
                    <h5 class="mb-1">Order #<?php echo $o['id']; ?></h5>
                    <p class="text-muted small mb-0">
                      <i class="fa-solid fa-calendar me-1"></i><?php echo date('d M Y', strtotime($o['tanggal'])); ?>
                    </p>
                  </div>
                  <?php
                    $badgeClass = 'bg-secondary';
                    $badgeIcon = 'fa-hourglass-half';
                    if ($o['status'] === 'Menunggu Pembayaran') {
                      $badgeClass = 'bg-warning text-dark';
                      $badgeIcon = 'fa-clock';
                    }
                    if ($o['status'] === 'Sudah Dibayar') {
                      $badgeClass = 'bg-info text-dark';
                      $badgeIcon = 'fa-credit-card';
                    }
                    if ($o['status'] === 'Selesai') {
                      $badgeClass = 'bg-success';
                      $badgeIcon = 'fa-check-circle';
                    }
                  ?>
                  <span class="badge <?php echo $badgeClass; ?>">
                    <i class="fa-solid <?php echo $badgeIcon; ?> me-1"></i><?php echo esc($o['status']); ?>
                  </span>
                </div>

                <div class="mb-3 pb-3 border-bottom">
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Metode Pembayaran:</span>
                    <strong class="small"><?php echo esc($o['metode_pembayaran']); ?></strong>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span class="text-muted small">Total:</span>
                    <strong class="text-primary"><?php echo format_rupiah($o['total_harga']); ?></strong>
                  </div>
                </div>

                <a href="order_detail.php?id=<?php echo $o['id']; ?>" class="btn btn-outline-primary w-100">
                  <i class="fa-solid fa-eye me-2"></i>Lihat Detail
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

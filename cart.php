<?php
// cart.php - Halaman Keranjang
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

require_login();
$user_id = $_SESSION['user_id'];

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND id_user = ?");
    $stmt->bind_param('ii', $id, $user_id);
    $stmt->execute();
    header('Location: cart.php');
    exit;
}

$items = get_user_cart($user_id);
$total = calculate_cart_total($items);
?>

<div class="container">
  <section class="section-padding">
    <h1 class="mb-4" data-aos="fade-up"><i class="fa-solid fa-cart-shopping me-2 text-primary"></i>Keranjang Saya</h1>
    
    <?php if (empty($items)): ?>
      <div class="text-center py-5" data-aos="fade-up">
        <i class="fa-solid fa-cart-shopping text-muted" style="font-size:4rem;opacity:0.3;"></i>
        <h4 class="mt-4 mb-3">Keranjang Anda Kosong</h4>
        <p class="text-muted mb-4">Belum ada produk di keranjang. Yuk mulai belanja!</p>
        <a href="products.php" class="btn btn-primary btn-lg px-5">
          <i class="fa-solid fa-box-open me-2"></i>Lihat Produk
        </a>
      </div>
    <?php else: ?>
      <div class="row g-4">
        <div class="col-lg-8" data-aos="fade-right">
          <?php foreach ($items as $index => $it): ?>
            <div class="card mb-3 border-0 shadow-sm" data-aos="fade-up" data-aos-delay="<?php echo 50 * $index; ?>">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-md-2 text-center mb-3 mb-md-0">
                    <?php 
                      $thumb = !empty($it['foto']) ? 'assets/img/'.$it['foto'] : 'https://via.placeholder.com/120x120?text='.urlencode($it['nama_produk']); 
                    ?>
                    <img src="<?php echo esc($thumb); ?>" alt="<?php echo esc($it['nama_produk']); ?>" class="img-fluid rounded" style="max-width:100px;">
                  </div>
                  <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="mb-1"><?php echo esc($it['nama_produk']); ?></h5>
                    <p class="text-muted small mb-0">
                      <i class="fa-solid fa-palette me-1"></i><?php echo esc($it['warna']); ?> | 
                      <i class="fa-solid fa-ruler me-1"></i><?php echo esc($it['size']); ?>
                    </p>
                  </div>
                  <div class="col-md-2 text-center mb-3 mb-md-0">
                    <small class="text-muted d-block">Quantity</small>
                    <strong class="fs-5"><?php echo (int)$it['quantity']; ?>x</strong>
                  </div>
                  <div class="col-md-2 text-center mb-3 mb-md-0">
                    <small class="text-muted d-block">Harga</small>
                    <strong class="text-primary"><?php echo format_rupiah($it['harga']); ?></strong>
                  </div>
                  <div class="col-md-2 text-center">
                    <strong class="d-block mb-2 fs-5"><?php echo format_rupiah($it['harga'] * $it['quantity']); ?></strong>
                    <a class="btn btn-sm btn-delete" href="cart.php?action=delete&id=<?php echo $it['id']; ?>" onclick="return confirm('Hapus item ini?');">
                      <i class="fa-solid fa-trash me-1"></i>Hapus
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="col-lg-4" data-aos="fade-left">
          <div class="card border-0 shadow-sm sticky-top" style="top:90px;">
            <div class="card-body">
              <h5 class="mb-4"><i class="fa-solid fa-receipt me-2"></i>Ringkasan Belanja</h5>
              <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Total Item:</span>
                <strong><?php echo count($items); ?> item</strong>
              </div>
              <hr>
              <div class="d-flex justify-content-between mb-4">
                <strong class="fs-5">Total Pembayaran:</strong>
                <strong class="fs-4 text-primary"><?php echo format_rupiah($total); ?></strong>
              </div>
              <a href="checkout.php" class="btn btn-confirm w-100 py-3 mb-2">
                <i class="fa-solid fa-credit-card me-2"></i>Lanjut ke Checkout
              </a>
              <a href="products.php" class="btn btn-outline-secondary w-100">
                <i class="fa-solid fa-arrow-left me-2"></i>Belanja Lagi
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

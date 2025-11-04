<?php
// products.php - Halaman Daftar Produk
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/functions.php';

$products = get_products();
?>

<div class="container">
  <section class="section-padding">
    <div class="row align-items-center mb-5" data-aos="fade-up">
      <div class="col-md-8">
        <h1 class="mb-2">Daftar Produk</h1>
        <p class="text-muted mb-0">Pilih produk favorit Anda dan mulai custom desain sesuai keinginan</p>
      </div>
      <div class="col-md-4 text-md-end">
        <span class="badge bg-primary px-3 py-2 fs-6">
          <i class="fa-solid fa-box-open me-2"></i><?php echo count($products); ?> Produk Tersedia
        </span>
      </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php foreach ($products as $index => $p): ?>
        <div class="col" data-aos="fade-up" data-aos-delay="<?php echo 50 + ($index * 30); ?>">
          <div class="product-card">
            <div class="img-wrapper">
              <?php 
                $img = !empty($p['foto']) ? 'assets/img/' . $p['foto'] : 'https://via.placeholder.com/300x220?text=' . urlencode($p['nama_produk']);
              ?>
              <img src="<?php echo esc($img); ?>" alt="<?php echo esc($p['nama_produk']); ?>">
            </div>
            <div class="card-body">
              <h5 class="product-name"><?php echo esc($p['nama_produk']); ?></h5>
              <p class="product-category"><?php echo esc($p['kategori']); ?></p>
              <p class="text-muted small text-truncate mb-3"><?php echo esc($p['deskripsi']); ?></p>
              <div class="product-price"><?php echo format_rupiah($p['harga']); ?></div>
              <a href="product_detail.php?id=<?php echo $p['id']; ?>" class="btn btn-order">
                <i class="fa-solid fa-eye me-2"></i>Lihat & Pesan
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

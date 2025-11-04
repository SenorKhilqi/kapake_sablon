<?php
// index.php - Landing Page
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/functions.php';

$products = get_products();
// Take first 8 products for gallery
$featured_products = array_slice($products, 0, 8);
?>

<!-- Hero Section -->
<section class="hero-section" data-aos="fade-in">
  <div class="container">
    <h1 data-aos="fade-down">Cetak Sablon Custom Berkualitas Premium</h1>
    <p data-aos="fade-up" data-aos-delay="100">Desain kaos, jaket, topi, dan merchandise sesuai keinginan Anda.<br>Proses cepat, hasil memuaskan, harga terjangkau.</p>
    <a href="products.php" class="btn btn-hero" data-aos="zoom-in" data-aos-delay="200">
      <i class="fa-solid fa-arrow-right me-2"></i> Lihat Produk
    </a>
  </div>
</section>

<!-- Mengapa Pilih Kami Section -->
<section class="section-padding">
  <div class="container">
    <h2 class="section-title" data-aos="fade-up">Mengapa Pilih Kami?</h2>
    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Kami memberikan pelayanan terbaik untuk kebutuhan sablon custom Anda</p>
    
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="feature-card">
          <div class="icon"><i class="fa-solid fa-award"></i></div>
          <h4>Kualitas Premium</h4>
          <p>Menggunakan bahan berkualitas tinggi dan teknik sablon terbaik untuk hasil yang tahan lama.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="feature-card">
          <div class="icon"><i class="fa-solid fa-palette"></i></div>
          <h4>Desain Custom</h4>
          <p>Bebas upload desain sendiri atau konsultasi dengan tim desainer kami secara gratis.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="feature-card">
          <div class="icon"><i class="fa-solid fa-headset"></i></div>
          <h4>Admin Responsif</h4>
          <p>Tim kami siap membantu Anda 24/7 via WhatsApp untuk proses pemesanan yang cepat dan mudah.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Galeri Produk Section -->
<section class="section-padding bg-light-section">
  <div class="container">
    <h2 class="section-title" data-aos="fade-up">Galeri Produk Kami</h2>
    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Pilih produk favorit Anda dan mulai berkreasi</p>
    
    <div class="row row-cols-2 row-cols-md-4 g-4">
      <?php foreach ($featured_products as $index => $p): ?>
        <div class="col" data-aos="fade-up" data-aos-delay="<?php echo 100 + ($index * 50); ?>">
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
              <div class="product-price"><?php echo format_rupiah($p['harga']); ?></div>
              <a href="product_detail.php?id=<?php echo $p['id']; ?>" class="btn btn-order">
                <i class="fa-solid fa-cart-plus me-2"></i>Pesan Sekarang
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    
    <div class="text-center mt-5" data-aos="fade-up">
      <a href="products.php" class="btn btn-primary btn-lg px-5">
        Lihat Semua Produk <i class="fa-solid fa-arrow-right ms-2"></i>
      </a>
    </div>
  </div>
</section>

<!-- Testimoni Section -->
<section class="section-padding">
  <div class="container">
    <h2 class="section-title" data-aos="fade-up">Apa Kata Mereka?</h2>
    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Testimoni dari pelanggan setia kami</p>
    
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="testimonial-card">
          <img src="assets/model/testi1.jpg" alt="Customer 1" class="avatar" onerror="this.src='https://ui-avatars.com/api/?name=Budi+S&background=1E40AF&color=fff&size=120'">
          <h5 class="name">Budi Santoso</h5>
          <p class="role">Owner Kafe Kopi Nusantara</p>
          <p class="quote">"Kualitas sablon sangat bagus! Desain sesuai request dan hasilnya memuaskan. Pasti order lagi untuk kebutuhan merchandise kafe."</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="testimonial-card">
          <img src="assets/model/testi2.jpg" alt="Customer 2" class="avatar" onerror="this.src='https://ui-avatars.com/api/?name=Siti+N&background=1E40AF&color=fff&size=120'">
          <h5 class="name">Siti Nurhaliza</h5>
          <p class="role">Event Organizer</p>
          <p class="quote">"Pelayanan cepat dan responsif! Admin sangat membantu dari desain sampai pengiriman. Recommended banget buat yang butuh sablon custom."</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="testimonial-card">
          <img src="assets/model/testi3.jpg" alt="Customer 3" class="avatar" onerror="this.src='https://ui-avatars.com/api/?name=Andi+P&background=1E40AF&color=fff&size=120'">
          <h5 class="name">Andi Prasetyo</h5>
          <p class="role">Komunitas Sepeda</p>
          <p class="quote">"Sudah beberapa kali order untuk jersey komunitas. Hasilnya selalu rapi, warna tajam, dan pengiriman tepat waktu. Top deh!"</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="section-padding bg-light-section">
  <div class="container text-center" data-aos="zoom-in">
    <h2 class="mb-3">Siap Mulai Pesanan Custom Anda?</h2>
    <p class="text-muted mb-4">Hubungi kami sekarang dan wujudkan desain impian Anda!</p>
    <a href="https://wa.me/628986709016" target="_blank" class="btn btn-primary btn-lg px-5 me-3">
      <i class="fa-brands fa-whatsapp me-2"></i>Chat WhatsApp
    </a>
    <a href="products.php" class="btn btn-outline-primary btn-lg px-5">
      Mulai Pesan
    </a>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

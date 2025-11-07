<?php
// about.php - Halaman Tentang Kami
require_once __DIR__ . '/includes/header.php';
?>

<div class="container">
  <!-- Hero Section -->
  <section class="hero-section" style="background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 100%); padding: 80px 0;" data-aos="fade-in">
    <div class="text-center text-white">
      <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">
        <i class="fa-solid fa-building me-3"></i>Tentang Kami
      </h1>
      <p class="lead mb-0" data-aos="fade-up" data-aos-delay="100">
        Mitra Terpercaya Untuk Kebutuhan Sablon Anda
      </p>
    </div>
  </section>

  <!-- About Content -->
  <section class="section-padding">
    <div class="row g-5 align-items-center mb-5">
      <div class="col-lg-6" data-aos="fade-right">
        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&h=600&fit=crop" 
             alt="Kapake Workshop" 
             class="img-fluid rounded shadow-lg" 
             style="object-fit: cover; width: 100%; height: 400px;">
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <h2 class="mb-4">
          <i class="fa-solid fa-shirt me-2 text-primary"></i>
          Kapake Workshop - Wujudkan Desain Impianmu
        </h2>
        <p class="text-muted mb-3">
          <strong>Kapake Workshop</strong> adalah layanan sablon profesional yang berkomitmen untuk menghadirkan produk berkualitas tinggi dengan desain sesuai keinginan Anda. Kami melayani berbagai kebutuhan sablon untuk kaos, jaket, topi, dan merchandise lainnya.
        </p>
        <p class="text-muted mb-4">
          Dengan pengalaman lebih dari <strong>20 tahun</strong> di industri percetakan dan sablon, kami telah melayani ribuan pelanggan dari berbagai kalangan, mulai dari individu, komunitas, hingga perusahaan besar.
        </p>
        <div class="row g-3">
          <div class="col-6">
            <div class="p-3 bg-light rounded text-center">
              <h3 class="text-primary mb-1">20+</h3>
              <p class="small text-muted mb-0">Tahun Pengalaman</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 bg-light rounded text-center">
              <h3 class="text-primary mb-1">10K+</h3>
              <p class="small text-muted mb-0">Pelanggan Puas</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 bg-light rounded text-center">
              <h3 class="text-primary mb-1">50K+</h3>
              <p class="small text-muted mb-0">Produk Terjual</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 bg-light rounded text-center">
              <h3 class="text-primary mb-1">100%</h3>
              <p class="small text-muted mb-0">Garansi Kualitas</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Visi Misi -->
    <div class="row g-4 mb-5">
      <div class="col-md-6" data-aos="fade-up">
        <div class="card border-0 shadow-sm h-100 p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #3B82F6, #60A5FA); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="fa-solid fa-eye text-white fs-4"></i>
            </div>
            <h4 class="mb-0">Visi Kami</h4>
          </div>
          <p class="text-muted mb-0">
            Menjadi penyedia layanan sablon terdepan di Indonesia yang dikenal dengan kualitas premium, inovasi desain, dan pelayanan terbaik bagi setiap pelanggan.
          </p>
        </div>
      </div>
      <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="card border-0 shadow-sm h-100 p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="icon-box me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #10B981, #34D399); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="fa-solid fa-bullseye text-white fs-4"></i>
            </div>
            <h4 class="mb-0">Misi Kami</h4>
          </div>
          <ul class="text-muted mb-0 ps-3">
            <li class="mb-2">Menghadirkan produk sablon berkualitas premium dengan harga terjangkau</li>
            <li class="mb-2">Memberikan pelayanan cepat, ramah, dan profesional</li>
            <li class="mb-2">Mendukung kreativitas pelanggan dengan teknologi sablon terkini</li>
            <li class="mb-0">Menjaga kepercayaan pelanggan dengan garansi kualitas 100%</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Keunggulan -->
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="mb-3">
        <i class="fa-solid fa-star me-2 text-primary"></i>
        Mengapa Memilih Kami?
      </h2>
      <p class="text-muted">Kami berkomitmen memberikan yang terbaik untuk setiap pesanan Anda</p>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
        <div class="card border-0 shadow-sm h-100 p-4 text-center">
          <div class="mb-3">
            <div class="icon-box mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #F59E0B, #FBBF24); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
              <i class="fa-solid fa-award text-white fs-2"></i>
            </div>
          </div>
          <h5 class="mb-3">Kualitas Premium</h5>
          <p class="text-muted small mb-0">
            Menggunakan bahan berkualitas tinggi dan tinta sablon terbaik yang tahan lama dan tidak mudah pudar.
          </p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card border-0 shadow-sm h-100 p-4 text-center">
          <div class="mb-3">
            <div class="icon-box mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #8B5CF6, #A78BFA); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
              <i class="fa-solid fa-rocket text-white fs-2"></i>
            </div>
          </div>
          <h5 class="mb-3">Proses Cepat</h5>
          <p class="text-muted small mb-0">
            Pengerjaan pesanan yang efisien dengan estimasi waktu yang jelas dan pengiriman tepat waktu.
          </p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card border-0 shadow-sm h-100 p-4 text-center">
          <div class="mb-3">
            <div class="icon-box mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #EF4444, #F87171); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
              <i class="fa-solid fa-palette text-white fs-2"></i>
            </div>
          </div>
          <h5 class="mb-3">Desain Custom</h5>
          <p class="text-muted small mb-0">
            Kebebasan penuh untuk mendesain sesuai keinginan Anda, dengan bantuan tim desain profesional kami.
          </p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
        <div class="card border-0 shadow-sm h-100 p-4 text-center">
          <div class="mb-3">
            <div class="icon-box mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #14B8A6, #2DD4BF); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
              <i class="fa-solid fa-tags text-white fs-2"></i>
            </div>
          </div>
          <h5 class="mb-3">Harga Terjangkau</h5>
          <p class="text-muted small mb-0">
            Harga kompetitif dengan diskon menarik untuk pemesanan dalam jumlah besar.
          </p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card border-0 shadow-sm h-100 p-4 text-center">
          <div class="mb-3">
            <div class="icon-box mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #3B82F6, #60A5FA); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
              <i class="fa-solid fa-headset text-white fs-2"></i>
            </div>
          </div>
          <h5 class="mb-3">Pelayanan 24/7</h5>
          <p class="text-muted small mb-0">
            Customer service yang responsif dan siap membantu Anda kapan saja melalui WhatsApp.
          </p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card border-0 shadow-sm h-100 p-4 text-center">
          <div class="mb-3">
            <div class="icon-box mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #10B981, #34D399); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
              <i class="fa-solid fa-shield-halved text-white fs-2"></i>
            </div>
          </div>
          <h5 class="mb-3">Garansi Kualitas</h5>
          <p class="text-muted small mb-0">
            Jaminan 100% kepuasan pelanggan dengan garansi kualitas produk yang kami hasilkan.
          </p>
        </div>
      </div>
    </div>

    <!-- Layanan -->
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="mb-3">
        <i class="fa-solid fa-briefcase me-2 text-primary"></i>
        Layanan Kami
      </h2>
      <p class="text-muted">Berbagai pilihan produk sablon untuk kebutuhan Anda</p>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="0">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
          <i class="fa-solid fa-shirt text-primary fs-1 mb-3"></i>
          <h6 class="mb-0">Kaos Custom</h6>
        </div>
      </div>
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="100">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
          <i class="fa-solid fa-user-tie text-primary fs-1 mb-3"></i>
          <h6 class="mb-0">Polo Shirt</h6>
        </div>
      </div>
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="200">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
          <i class="fa-solid fa-mitten text-primary fs-1 mb-3"></i>
          <h6 class="mb-0">Jaket Hoodie</h6>
        </div>
      </div>
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="300">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
          <i class="fa-solid fa-hat-cowboy text-primary fs-1 mb-3"></i>
          <h6 class="mb-0">Topi Custom</h6>
        </div>
      </div>
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="0">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
          <i class="fa-solid fa-shopping-bag text-primary fs-1 mb-3"></i>
          <h6 class="mb-0">Totebag</h6>
        </div>
      </div>
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="100">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
          <i class="fa-solid fa-mug-hot text-primary fs-1 mb-3"></i>
          <h6 class="mb-0">Mug Custom</h6>
        </div>
      </div>
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="200">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
          <i class="fa-solid fa-flag text-primary fs-1 mb-3"></i>
          <h6 class="mb-0">Bendera</h6>
        </div>
      </div>
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="300">
        <div class="card border-0 shadow-sm h-100 p-3 text-center">
          <i class="fa-solid fa-gift text-primary fs-1 mb-3"></i>
          <h6 class="mb-0">Merchandise</h6>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="text-center p-5 rounded shadow-sm" style="background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 100%);" data-aos="zoom-in">
      <h3 class="text-white mb-3">
        <i class="fa-solid fa-phone me-2"></i>
        Siap Mewujudkan Desain Anda?
      </h3>
      <p class="text-white mb-4">Hubungi kami sekarang dan konsultasikan kebutuhan sablon Anda!</p>
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="https://wa.me/6281323100108" target="_blank" class="btn btn-light btn-lg px-5">
          <i class="fa-brands fa-whatsapp me-2"></i>Hubungi WhatsApp
        </a>
        <a href="products.php" class="btn btn-outline-light btn-lg px-5">
          <i class="fa-solid fa-shopping-cart me-2"></i>Lihat Produk
        </a>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

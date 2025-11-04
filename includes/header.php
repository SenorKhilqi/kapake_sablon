<?php
// includes/header.php (public UI)
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sablon Custom - Cetak Kaos & Merchandise</title>
    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
  </head>
  <body>
  <!-- Navbar Fixed Top -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <i class="fa-solid fa-shirt me-2"></i>
        <span>Sablon Custom</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="products.php">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">Tentang Kami</a></li>
          <?php if (is_logged_in()): ?>
            <?php if (is_admin()): ?>
              <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Dashboard</a></li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link" href="cart.php">
                  <i class="fa-solid fa-cart-shopping me-1"></i> Keranjang 
                  <span class="badge bg-primary ms-1"><?php echo get_cart_count($_SESSION['user_id'] ?? 0); ?></span>
                </a>
              </li>
              <li class="nav-item"><a class="nav-link" href="order_history.php">Riwayat</a></li>
            <?php endif; ?>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item ms-lg-2"><a class="nav-link btn-cta" href="register.php">Daftar</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Content Wrapper with padding-top for fixed navbar -->
  <div style="padding-top:76px;">

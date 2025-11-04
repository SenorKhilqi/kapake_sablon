<?php
// product_detail.php - Halaman Detail Produk & Form Custom
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

// product detail
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = get_product($id);
if (!$product) {
    echo '<div class="container"><div class="alert alert-danger mt-5">Produk tidak ditemukan.</div></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// require login to order
if (!is_logged_in()) {
    header('Location: login.php?return=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

$message = '';
$message_type = 'info';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // handle add to cart
    $warna = $_POST['warna'] ?? null;
    $size = $_POST['size'] ?? null;
    $quantity = (int)($_POST['quantity'] ?? 1);
    $ukuran_sablon = $_POST['ukuran_sablon'] ?? null;
    $bahan = $_POST['bahan'] ?? null;
    $deskripsi = $_POST['deskripsi'] ?? null;
    $gambar_path = null;
    if (!empty($_FILES['desain']) && $_FILES['desain']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload = upload_image($_FILES['desain']);
        if ($upload === false) {
            $message = 'Upload desain gagal. Pastikan file PNG/JPG dan maksimal 2MB.';
            $message_type = 'danger';
        } else {
            $gambar_path = $upload;
        }
    }

  if (empty($message)) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO cart (id_user, id_produk, warna, size, quantity, bahan, ukuran_sablon, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $user_id = $_SESSION['user_id'];
    $prod_id = $product['id'];
    $stmt->bind_param('iississss', $user_id, $prod_id, $warna, $size, $quantity, $bahan, $ukuran_sablon, $deskripsi, $gambar_path);
    $ok = $stmt->execute();
        if ($ok) {
            $message = 'Item berhasil ditambahkan ke keranjang!';
            $message_type = 'success';
        } else {
            $message = 'Gagal menambahkan ke keranjang.';
            $message_type = 'danger';
        }
    }
}
?>

<div class="container">
  <section class="section-padding">
    <div class="row g-4">
      <div class="col-lg-6" data-aos="fade-right">
        <div class="card border-0 shadow-sm overflow-hidden">
          <?php $img = !empty($product['foto']) ? 'assets/img/' . $product['foto'] : 'https://via.placeholder.com/600x450?text=' . urlencode($product['nama_produk']); ?>
          <img src="<?php echo esc($img); ?>" class="img-fluid" alt="<?php echo esc($product['nama_produk']); ?>" style="width:100%;height:auto;">
        </div>
      </div>
      
      <div class="col-lg-6" data-aos="fade-left">
        <div class="card border-0 shadow-sm p-4">
          <div class="mb-4">
            <span class="badge bg-primary mb-2"><?php echo esc($product['kategori'] ?? 'Produk'); ?></span>
            <h1 class="mb-2"><?php echo esc($product['nama_produk']); ?></h1>
            <p class="text-muted mb-3"><?php echo esc($product['deskripsi']); ?></p>
            <div class="d-flex align-items-center gap-3">
              <h3 class="text-primary mb-0"><?php echo format_rupiah($product['harga']); ?></h3>
              <small class="text-muted">/ pcs</small>
            </div>
          </div>

          <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> d-flex align-items-center" data-aos="fade-in">
              <i class="fa-solid fa-circle-check me-2"></i><?php echo esc($message); ?>
            </div>
          <?php endif; ?>

          <form method="post" enctype="multipart/form-data">
            <h5 class="mb-3"><i class="fa-solid fa-palette me-2 text-primary"></i>Custom Desain Anda</h5>
            
            <div class="mb-3">
              <label class="form-label"><i class="fa-solid fa-image me-2"></i>Upload Gambar Desain</label>
              <input type="file" name="desain" accept="image/png, image/jpeg" class="form-control">
              <small class="text-muted">Format: PNG/JPG • Max: 2MB</small>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label"><i class="fa-solid fa-droplet me-2"></i>Warna Pakaian</label>
                <input type="text" name="warna" class="form-control" placeholder="Contoh: Hitam, Putih, #FFFFFF" required>
              </div>
              <div class="col-md-6">
                <label class="form-label"><i class="fa-solid fa-ruler me-2"></i>Ukuran (Size)</label>
                <select name="size" class="form-select" required>
                  <option value="">Pilih Size</option>
                  <option>S</option>
                  <option>M</option>
                  <option>L</option>
                  <option>XL</option>
                  <option>XXL</option>
                </select>
              </div>
            </div>

            <div class="row g-3 mt-2">
              <div class="col-md-6">
                <label class="form-label"><i class="fa-solid fa-hashtag me-2"></i>Quantity</label>
                <input type="number" name="quantity" class="form-control" value="1" min="1" required>
              </div>
              <div class="col-md-6">
                <label class="form-label"><i class="fa-solid fa-expand me-2"></i>Ukuran Sablon (CM)</label>
                <input type="text" name="ukuran_sablon" class="form-control" placeholder="Contoh: 20x30">
              </div>
            </div>

            <div class="mb-3 mt-3">
              <label class="form-label"><i class="fa-solid fa-shirt me-2"></i>Nama Bahan</label>
              <input type="text" name="bahan" class="form-control" placeholder="Contoh: Cotton Combed 30s">
            </div>

            <div class="mb-4">
              <label class="form-label"><i class="fa-solid fa-message me-2"></i>Deskripsi Tambahan</label>
              <textarea name="deskripsi" class="form-control" rows="3" placeholder="Catatan khusus untuk desain Anda..."></textarea>
            </div>

            <div class="d-flex gap-2">
              <a href="products.php" class="btn btn-outline-secondary flex-fill">
                <i class="fa-solid fa-arrow-left me-2"></i>Kembali
              </a>
              <button type="submit" class="btn btn-primary flex-fill">
                <i class="fa-solid fa-cart-plus me-2"></i>Tambah ke Keranjang
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

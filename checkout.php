<?php
// checkout.php - Halaman Checkout & Konfirmasi Pembayaran
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

require_login();
$user_id = $_SESSION['user_id'];
$items = get_user_cart($user_id);
if (empty($items)) {
    echo '<div class="container"><div class="alert alert-info mt-5">Keranjang kosong. <a href="products.php">Belanja sekarang</a></div></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$total = calculate_cart_total($items);
$error = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metode = $_POST['metode'] ?? 'Transfer Bank';
    // create order
    $stmt = $conn->prepare("INSERT INTO orders (id_user, total_harga, metode_pembayaran, status) VALUES (?, ?, ?, 'Menunggu Pembayaran')");
    $stmt->bind_param('ids', $user_id, $total, $metode);
    if ($stmt->execute()) {
        $order_id = $conn->insert_id;
        // insert details
        $stmt2 = $conn->prepare("INSERT INTO order_details (id_order, id_produk, quantity, harga) VALUES (?, ?, ?, ?)");
        foreach ($items as $it) {
            $stmt2->bind_param('iiid', $order_id, $it['id_produk'], $it['quantity'], $it['harga']);
            $stmt2->execute();
        }
        // clear cart
        $del = $conn->prepare("DELETE FROM cart WHERE id_user = ?");
        $del->bind_param('i', $user_id);
        $del->execute();

        // Build WhatsApp message with greeting
        $user_name = $_SESSION['username'] ?? 'Customer';
        
        // Determine payment method text
        $payment_text = '';
        switch ($metode) {
            case 'Transfer Bank':
                $payment_text = "🏦 Pembayaran melalui *Transfer Bank*\n\n";
                $payment_text .= "Pilih salah satu rekening berikut:\n";
                $payment_text .= "📌 BCA: *0542167104*\n";
                $payment_text .= "📌 BNI: *9000042757501*\n";
                $payment_text .= "📌 BRI: *010001017918531*";
                break;
            case 'QRIS':
                $payment_text = "📱 Pembayaran melalui *QRIS*\n";
                $payment_text .= "📌 Scan QRIS yang akan dikirimkan oleh admin";
                break;
            default:
                $payment_text = "🏦 Pembayaran melalui *Transfer Bank*";
                break;
        }
        
        $message = "Assalamualaikum, Halo Admin Kapake Workshop! 👋\n\n";
        $message .= "Saya *{$user_name}* ingin konfirmasi pesanan:\n\n";
        $message .= "📋 *ID Pesanan: #{$order_id}*\n";
        $message .= "━━━━━━━━━━━━━━━━\n\n";
        $message .= "*Detail Pesanan:*\n";
        foreach ($items as $it) {
            $message .= "• " . $it['nama_produk'] . "\n";
            $message .= "  Qty: " . $it['quantity'] . " | Harga: " . format_rupiah($it['harga']) . "\n\n";
        }
        $message .= "━━━━━━━━━━━━━━━━\n";
        $message .= "💰 *Total Pembayaran: " . format_rupiah($total) . "*\n\n";
        $message .= $payment_text . "\n\n";
        $message .= "Mohon informasi untuk proses pembayaran selanjutnya. Terima kasih! 🙏";
        $wa = 'https://wa.me/' . ADMIN_WA . '?text=' . urlencode($message);
        header('Location: ' . $wa);
        exit;
    } else {
        $error = 'Gagal membuat pesanan.';
    }
}
?>

<div class="container">
  <section class="section-padding">
    <h1 class="mb-4" data-aos="fade-up">
      <i class="fa-solid fa-credit-card me-2 text-primary"></i>Checkout & Konfirmasi
    </h1>

    <?php if ($error): ?>
      <div class="alert alert-danger" data-aos="fade-in">
        <i class="fa-solid fa-circle-exclamation me-2"></i><?php echo esc($error); ?>
      </div>
    <?php endif; ?>

    <div class="row g-4">
      <div class="col-lg-7" data-aos="fade-right">
        <div class="card border-0 shadow-sm p-4">
          <h4 class="mb-4"><i class="fa-solid fa-list-check me-2"></i>Ringkasan Pesanan</h4>
          
          <?php foreach ($items as $index => $it): ?>
            <div class="d-flex align-items-center mb-3 pb-3 border-bottom" data-aos="fade-up" data-aos-delay="<?php echo 50 * $index; ?>">
              <div class="me-3">
                <?php 
                  $thumb = !empty($it['foto']) ? 'assets/img/'.$it['foto'] : 'https://via.placeholder.com/80x80?text='.urlencode($it['nama_produk']); 
                ?>
                <img src="<?php echo esc($thumb); ?>" alt="<?php echo esc($it['nama_produk']); ?>" class="rounded" style="width:80px;height:80px;object-fit:cover;">
              </div>
              <div class="flex-fill">
                <h6 class="mb-1"><?php echo esc($it['nama_produk']); ?></h6>
                <p class="text-muted small mb-0">
                  <i class="fa-solid fa-palette me-1"></i><?php echo esc($it['warna']); ?> | 
                  <i class="fa-solid fa-ruler me-1"></i><?php echo esc($it['size']); ?> | 
                  <i class="fa-solid fa-hashtag me-1"></i><?php echo (int)$it['quantity']; ?>x
                </p>
              </div>
              <div class="text-end">
                <strong class="text-primary"><?php echo format_rupiah($it['harga'] * $it['quantity']); ?></strong>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <h5 class="mb-0">Total Pembayaran:</h5>
            <h4 class="mb-0 text-primary"><?php echo format_rupiah($total); ?></h4>
          </div>
        </div>
      </div>

      <div class="col-lg-5" data-aos="fade-left">
        <div class="card border-0 shadow-sm p-4 sticky-top" style="top:90px;">
          <h4 class="mb-4"><i class="fa-solid fa-wallet me-2"></i>Metode Pembayaran</h4>
          
          <form method="post">
            <div class="mb-4">
              <label class="form-label fw-bold">Pilih Metode Pembayaran</label>
              <select name="metode" class="form-select form-select-lg" required>
                <option value="">-- Pilih Metode Pembayaran --</option>
                <option value="Transfer Bank">🏦 Transfer Bank (BCA / BNI / BRI)</option>
                <option value="QRIS">📱 QRIS</option>
              </select>
            </div>

            <div class="alert alert-info mb-4">
              <i class="fa-solid fa-circle-info me-2"></i>
              <strong>Catatan:</strong> Setelah konfirmasi, Anda akan diarahkan ke WhatsApp admin untuk proses pembayaran dan konfirmasi pesanan.
            </div>

            <button type="submit" class="btn btn-pay w-100 py-3 mb-2">
              <i class="fa-solid fa-check-circle me-2"></i>Konfirmasi & Bayar Sekarang
            </button>
            <a href="cart.php" class="btn btn-outline-secondary w-100">
              <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Keranjang
            </a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

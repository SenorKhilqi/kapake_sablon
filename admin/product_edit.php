<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    $_SESSION['admin_msg'] = 'Produk tidak ditemukan.';
    header('Location: products.php');
    exit;
}

// fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
if (!$product) {
    $_SESSION['admin_msg'] = 'Produk tidak ditemukan.';
    header('Location: products.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_produk'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $harga = (float)($_POST['harga'] ?? 0);
    $deskripsi = $_POST['deskripsi'] ?? '';
    $foto = $product['foto'];

    if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $destDir = __DIR__ . '/../assets/img/';
        if (!is_dir($destDir)) mkdir($destDir, 0755, true);
        $fn = basename($_FILES['foto']['name']);
        $target = $destDir . $fn;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
            $foto = $fn;
        }
    }

    $upd = $conn->prepare("UPDATE products SET nama_produk = ?, kategori = ?, harga = ?, deskripsi = ?, foto = ? WHERE id = ?");
    $upd->bind_param('ssdssi', $nama, $kategori, $harga, $deskripsi, $foto, $id);
    if ($upd->execute()) {
        $_SESSION['admin_msg'] = 'Produk berhasil diperbarui.';
        header('Location: products.php');
        exit;
    } else {
        $error = 'Gagal menyimpan perubahan.';
    }
}

?>

<h2>Edit Produk</h2>
<?php if ($error): ?><div class="alert alert-danger"><?php echo esc($error); ?></div><?php endif; ?>

<form method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input name="nama_produk" class="form-control" value="<?php echo esc($product['nama_produk']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="kategori" class="form-select">
      <option <?php if ($product['kategori']=='Kaos Custom') echo 'selected'; ?>>Kaos Custom</option>
      <option <?php if ($product['kategori']=='Topi Bordir') echo 'selected'; ?>>Topi Bordir</option>
      <option <?php if ($product['kategori']=='Jaket Hoodie') echo 'selected'; ?>>Jaket Hoodie</option>
      <option <?php if ($product['kategori']=='Kemeja Custom') echo 'selected'; ?>>Kemeja Custom</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Harga</label>
    <input name="harga" type="number" step="0.01" class="form-control" value="<?php echo esc($product['harga']); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" class="form-control"><?php echo esc($product['deskripsi']); ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Foto Produk (kosongkan untuk tidak mengubah)</label>
    <input name="foto" type="file" class="form-control">
    <?php if (!empty($product['foto'])): ?>
      <div class="mt-2"><img src="../assets/img/<?php echo esc($product['foto']); ?>" class="img-preview" alt="preview"></div>
    <?php endif; ?>
  </div>
  <button class="btn btn-primary">Simpan Perubahan</button>
  <a class="btn btn-secondary ms-2" href="products.php">Batal</a>
</form>

<?php require_once __DIR__ . '/footer.php'; ?>

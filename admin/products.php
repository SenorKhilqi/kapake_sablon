<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/header.php';
require_admin();

// Handle add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $nama = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = (float)$_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $foto = '';
    if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $dest = __DIR__ . '/../assets/img/';
        if (!is_dir($dest)) mkdir($dest, 0755, true);
        $fn = basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $dest . $fn);
        $foto = $fn;
    }
  $stmt = $conn->prepare("INSERT INTO products (nama_produk, kategori, harga, deskripsi, foto) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param('ssdss', $nama, $kategori, $harga, $deskripsi, $foto);
    $stmt->execute();
    header('Location: products.php');
    exit;
}

// Handle edit price inline
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_price') {
    $id = (int)$_POST['id'];
    $harga = (float)$_POST['harga'];
    $stmt = $conn->prepare("UPDATE products SET harga = ? WHERE id = ?");
    $stmt->bind_param('di', $harga, $id);
    $stmt->execute();
    header('Location: products.php');
    exit;
}

// Delete product
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: products.php');
    exit;
}

$res = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<style>
  .form-card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    margin-bottom: 24px;
  }
  .form-card h5 {
    font-weight: 700;
    margin-bottom: 20px;
    color: #1e293b;
  }
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
  .btn-edit {
    background: linear-gradient(135deg, #3b82f6, #60a5fa);
    border: none;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
  }
  .btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    color: #fff;
  }
  .btn-delete {
    background: linear-gradient(135deg, #ef4444, #f87171);
    border: none;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
  }
  .btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: #fff;
  }
  .btn-save-price {
    background: linear-gradient(135deg, #10b981, #34d399);
    border: none;
    color: #fff;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.8rem;
  }
  .btn-save-price:hover {
    background: linear-gradient(135deg, #059669, #10b981);
    color: #fff;
  }
</style>

<div class="mb-4">
  <h2 class="mb-1">Kelola Produk</h2>
  <p class="text-muted mb-0">Tambah, edit, dan hapus produk toko</p>
</div>

<?php if (!empty($_SESSION['admin_msg'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-check-circle me-2"></i><?php echo esc($_SESSION['admin_msg']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  <?php unset($_SESSION['admin_msg']); ?>
<?php endif; ?>

<div class="form-card">
  <h5><i class="fa-solid fa-plus-circle me-2"></i>Tambah Produk Baru</h5>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="add">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nama Produk</label>
        <input name="nama_produk" class="form-control" placeholder="Contoh: Kaos Custom Premium" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Kategori</label>
        <select name="kategori" class="form-select">
          <option>Kaos Custom</option>
          <option>Topi Bordir</option>
          <option>Jaket Hoodie</option>
          <option>Kemeja Custom</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Harga (Rp)</label>
        <input name="harga" type="number" class="form-control" placeholder="50000" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Foto Produk</label>
        <input name="foto" type="file" class="form-control">
      </div>
      <div class="col-md-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi produk..."></textarea>
      </div>
      <div class="col-md-12">
        <button class="btn btn-primary px-4" type="submit">
          <i class="fa-solid fa-save me-2"></i>Tambah Produk
        </button>
      </div>
    </div>
  </form>
</div>

<div class="table-container">
  <h5><i class="fa-solid fa-box-open me-2"></i>Daftar Produk</h5>
  <div class="table-responsive">
    <table class="table table-modern table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($p = $res->fetch_assoc()): ?>
          <tr>
            <td><strong>#<?php echo $p['id']; ?></strong></td>
            <td><?php echo esc($p['nama_produk']); ?></td>
            <td><span class="badge bg-secondary"><?php echo esc($p['kategori']); ?></span></td>
            <td>
              <form method="post" class="d-flex align-items-center" style="max-width: 250px;">
                <input type="hidden" name="action" value="edit_price">
                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                <input type="number" name="harga" class="form-control form-control-sm me-2" value="<?php echo $p['harga']; ?>" style="width: 120px;">
                <button class="btn btn-save-price btn-sm" type="submit">
                  <i class="fa-solid fa-check"></i>
                </button>
              </form>
            </td>
            <td>
              <a class="btn btn-edit btn-sm me-1" href="product_edit.php?id=<?php echo $p['id']; ?>">
                <i class="fa-solid fa-edit me-1"></i>Edit
              </a>
              <a class="btn btn-delete btn-sm" href="products.php?delete=<?php echo $p['id']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                <i class="fa-solid fa-trash me-1"></i>Hapus
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

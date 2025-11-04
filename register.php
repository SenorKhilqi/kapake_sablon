<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $no_wa = $_POST['no_wa'] ?? '';

    // check unique email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $error = 'Email sudah terdaftar.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $ins = $conn->prepare("INSERT INTO users (nama, email, password, no_wa, role) VALUES (?, ?, ?, ?, 'user')");
        $ins->bind_param('ssss', $nama, $email, $hash, $no_wa);
        if ($ins->execute()) {
            header('Location: login.php');
            exit;
        } else {
            $error = 'Gagal mendaftar.';
        }
    }
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4">
      <h3 class="mb-3">Buat Akun</h3>
      <?php if ($error): ?><div class="alert alert-danger"><?php echo esc($error); ?></div><?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">No WhatsApp</label>
          <input type="text" name="no_wa" class="form-control">
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <button class="btn btn-primary">Daftar</button>
          <a href="login.php" class="small">Sudah punya akun? Login</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

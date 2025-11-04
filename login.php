<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT id, nama, password, role FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];
        $return = $_GET['return'] ?? 'products.php';
        header('Location: ' . $return);
        exit;
    } else {
        $error = 'Email atau password salah.';
    }
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4">
      <h3 class="mb-3">Login</h3>
      <?php if ($error): ?><div class="alert alert-danger"><?php echo esc($error); ?></div><?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <button class="btn btn-primary">Login</button>
          <a href="register.php" class="small">Belum punya akun? Daftar</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

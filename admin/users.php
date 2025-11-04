<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/header.php';
require_admin();

$users = $conn->query("SELECT id, nama, email, no_wa, role, created_at FROM users ORDER BY created_at DESC");
?>

<style>
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
  .badge-role-admin {
    background: linear-gradient(135deg, #8b5cf6, #a78bfa);
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
  }
  .badge-role-user {
    background: #e2e8f0;
    color: #475569;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
  }
</style>

<div class="mb-4">
  <h2 class="mb-1">Kelola User</h2>
  <p class="text-muted mb-0">Daftar pengguna yang terdaftar di sistem</p>
</div>

<div class="table-container">
  <h5><i class="fa-solid fa-users me-2"></i>Daftar User</h5>
  <div class="table-responsive">
    <table class="table table-modern table-hover">
      <thead>
        <tr>
          <th>User ID</th>
          <th>Nama</th>
          <th>Email</th>
          <th>No WhatsApp</th>
          <th>Role</th>
          <th>Terdaftar</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($u = $users->fetch_assoc()): ?>
          <tr>
            <td><strong>#<?php echo $u['id']; ?></strong></td>
            <td>
              <i class="fa-solid fa-user-circle me-2 text-muted"></i>
              <?php echo esc($u['nama']); ?>
            </td>
            <td>
              <i class="fa-solid fa-envelope me-2 text-muted"></i>
              <?php echo esc($u['email']); ?>
            </td>
            <td>
              <i class="fa-brands fa-whatsapp me-2 text-success"></i>
              <?php echo esc($u['no_wa']); ?>
            </td>
            <td>
              <span class="<?php echo ($u['role'] === 'admin') ? 'badge-role-admin' : 'badge-role-user'; ?>">
                <i class="fa-solid <?php echo ($u['role'] === 'admin') ? 'fa-user-shield' : 'fa-user'; ?> me-1"></i>
                <?php echo esc($u['role']); ?>
              </span>
            </td>
            <td><?php echo date('d M Y H:i', strtotime($u['created_at'])); ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/header.php';
require_admin();

// counts
$c1 = $conn->query("SELECT COUNT(*) as c FROM products")->fetch_assoc();
$c2 = $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc();
$c3 = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc();
$revenue = get_total_revenue();
$pending = get_pending_orders_count();

// Status counts for modern cards
$paid_count = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status='Sudah Dibayar'")->fetch_assoc()['c'];
$done_count = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status='Selesai'")->fetch_assoc()['c'];

// get weekly and monthly recaps
$weekly = get_weekly_summary(6); // aggregated counts (kept for quick view)
$monthly = get_monthly_summary(6); // aggregated counts

// --- handle filter pendapatan by week/month ---
$filter_type = $_GET['filter_type'] ?? '';
$filter_value = '';
$filter_result = null;
$filter_orders = [];
// accept inputs from either "filter_value_week" or "filter_value_month" (from HTML inputs)
if ($filter_type === 'week' && !empty($_GET['filter_value_week'])) {
  $filter_value = $_GET['filter_value_week'];
} elseif ($filter_type === 'month' && !empty($_GET['filter_value_month'])) {
  $filter_value = $_GET['filter_value_month'];
} else {
  $filter_value = $_GET['filter_value'] ?? '';
}
if ($filter_type && $filter_value) {
  if ($filter_type === 'week') {
    // expected format: 2025-W45 or 2025-W05 (HTML input week gives YYYY-Www)
    if (preg_match('/^(\d{4})-W(\d{1,2})$/', $filter_value, $m)) {
      $year = (int)$m[1];
      $week = (int)$m[2];
      $dt = new DateTime();
      // set ISO week (Monday as first day)
      $dt->setISODate($year, $week);
      $start = $dt->format('Y-m-d') . ' 00:00:00';
      $dt2 = clone $dt;
      $dt2->modify('+6 days');
      $end = $dt2->format('Y-m-d') . ' 23:59:59';
      $filter_result = get_revenue_between($start, $end);
      $filter_orders = get_orders_between($start, $end);
    }
  } elseif ($filter_type === 'month') {
    // expected format: YYYY-MM
    if (preg_match('/^(\d{4})-(\d{2})$/', $filter_value, $m)) {
      $start = $filter_value . '-01 00:00:00';
      $dt = new DateTime($start);
      $endDt = clone $dt;
      $endDt->modify('last day of this month')->setTime(23,59,59);
      $end = $endDt->format('Y-m-d H:i:s');
      $filter_result = get_revenue_between($start, $end);
      $filter_orders = get_orders_between($start, $end);
    }
  }
}
?>

<style>
  .stat-card { 
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border-left: 4px solid;
    transition: all 0.3s ease;
  }
  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
  }
  .stat-card .icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 16px;
  }
  .stat-card h6 {
    color: #64748b;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .stat-card .value {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
  }
  .stat-card-blue { border-left-color: #3b82f6; }
  .stat-card-blue .icon { background: linear-gradient(135deg, #3b82f6, #60a5fa); color: #fff; }
  .stat-card-green { border-left-color: #10b981; }
  .stat-card-green .icon { background: linear-gradient(135deg, #10b981, #34d399); color: #fff; }
  .stat-card-yellow { border-left-color: #f59e0b; }
  .stat-card-yellow .icon { background: linear-gradient(135deg, #f59e0b, #fbbf24); color: #fff; }
  .stat-card-purple { border-left-color: #8b5cf6; }
  .stat-card-purple .icon { background: linear-gradient(135deg, #8b5cf6, #a78bfa); color: #fff; }
  .stat-card-teal { border-left-color: #14b8a6; }
  .stat-card-teal .icon { background: linear-gradient(135deg, #14b8a6, #2dd4bf); color: #fff; }

  .info-card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    margin-bottom: 24px;
  }
  .info-card h5 {
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
  .badge-status {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
  }
</style>

<div class="mb-4">
  <h2 class="mb-1">Dashboard Overview</h2>
  <p class="text-muted mb-0">Ringkasan data dan statistik toko</p>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
  <div class="col-md-6 col-lg-4">
    <div class="stat-card stat-card-blue">
      <div class="icon">
        <i class="fa-solid fa-shopping-cart"></i>
      </div>
      <h6>Total Pesanan</h6>
      <div class="value"><?php echo $c2['c']; ?></div>
    </div>
  </div>
  <div class="col-md-6 col-lg-4">
    <div class="stat-card stat-card-green">
      <div class="icon">
        <i class="fa-solid fa-check-circle"></i>
      </div>
      <h6>Sudah Dibayar</h6>
      <div class="value"><?php echo $paid_count; ?></div>
    </div>
  </div>
  <div class="col-md-6 col-lg-4">
    <div class="stat-card stat-card-yellow">
      <div class="icon">
        <i class="fa-solid fa-circle-check"></i>
      </div>
      <h6>Selesai</h6>
      <div class="value"><?php echo $done_count; ?></div>
    </div>
  </div>
  <div class="col-md-6 col-lg-4">
    <div class="stat-card stat-card-purple">
      <div class="icon">
        <i class="fa-solid fa-box-open"></i>
      </div>
      <h6>Produk Tersedia</h6>
      <div class="value"><?php echo $c1['c']; ?></div>
    </div>
  </div>
  <div class="col-md-6 col-lg-4">
    <div class="stat-card stat-card-teal">
      <div class="icon">
        <i class="fa-solid fa-sack-dollar"></i>
      </div>
      <h6>Total Pendapatan</h6>
      <div class="value" style="font-size: 1.5rem;"><?php echo format_rupiah($revenue); ?></div>
    </div>
  </div>
  <div class="col-md-6 col-lg-4">
    <div class="stat-card stat-card-yellow">
      <div class="icon">
        <i class="fa-solid fa-clock"></i>
      </div>
      <h6>Menunggu Pembayaran</h6>
      <div class="value"><?php echo $pending; ?></div>
    </div>
  </div>
</div>

<div class="info-card">
  <h5><i class="fa-solid fa-filter me-2"></i>Filter Pendapatan (Mingguan / Bulanan)</h5>
  <p class="small text-muted mb-3">Pilih tipe filter, kemudian pilih minggu atau bulan yang ingin ditampilkan.</p>
  <form class="mb-3" method="get" action="">
    <div class="row g-3 align-items-center">
      <div class="col-auto">
        <select name="filter_type" id="filter_type" class="form-select">
          <option value="week" <?php echo ($filter_type==='week')? 'selected':''; ?>>Minggu</option>
          <option value="month" <?php echo ($filter_type==='month')? 'selected':''; ?>>Bulan</option>
        </select>
      </div>
      <div class="col-auto" id="week_input" style="display: <?php echo ($filter_type==='month')? 'none':'block'; ?>;">
        <input type="week" name="filter_value_week" id="filter_value_week" class="form-control" value="<?php echo ($filter_type==='week' && $filter_value)? esc($filter_value):''; ?>">
      </div>
      <div class="col-auto" id="month_input" style="display: <?php echo ($filter_type==='week')? 'none':'block'; ?>;">
        <input type="month" name="filter_value_month" id="filter_value_month" class="form-control" value="<?php echo ($filter_type==='month' && $filter_value)? esc($filter_value):''; ?>">
      </div>
      <div class="col-auto">
        <button class="btn btn-primary" type="submit">Tampilkan</button>
        <a class="btn btn-secondary ms-2" href="dashboard.php">Reset</a>
      </div>
    </div>
  </form>
  <script>
    // small toggle for inputs
    (function(){
      var sel = document.getElementById('filter_type');
      var weekInput = document.getElementById('week_input');
      var monthInput = document.getElementById('month_input');
      function update(){
        if (sel.value === 'week') { weekInput.style.display='block'; monthInput.style.display='none'; }
        else { weekInput.style.display='none'; monthInput.style.display='block'; }
      }
      sel.addEventListener('change', update);
    })();
  </script>

  <?php
    // normalize incoming filter_value from inputs
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['filter_type'])) {
            $ft = $_GET['filter_type'];
            if ($ft === 'week' && !empty($_GET['filter_value_week'])) {
                // convert HTML week input to YYYY-Www format
                $filter_value = $_GET['filter_value_week'];
                $filter_type = 'week';
            } elseif ($ft === 'month' && !empty($_GET['filter_value_month'])) {
                $filter_value = $_GET['filter_value_month'];
                $filter_type = 'month';
            }
        }
    }
  ?>

  <?php if ($filter_result !== null): ?>
    <div class="alert alert-info">
      <h6 class="mb-2"><i class="fa-solid fa-chart-line me-2"></i>Hasil Filter</h6>
      <p class="mb-1">Total Pendapatan (Selesai): <strong><?php echo format_rupiah($filter_result['total']); ?></strong></p>
      <p class="mb-0">Jumlah Transaksi Selesai: <strong><?php echo $filter_result['count']; ?></strong></p>
    </div>

    <?php if (empty($filter_orders)): ?>
      <div class="alert alert-warning"><i class="fa-solid fa-exclamation-triangle me-2"></i>Tidak ada transaksi selesai pada periode yang dipilih.</div>
    <?php else: ?>
      <table class="table table-modern table-hover">
        <thead><tr><th>Order ID</th><th>Tanggal</th><th>User</th><th>Total</th><th>Status</th></tr></thead>
        <tbody>
          <?php foreach ($filter_orders as $o): ?>
            <tr>
              <td><strong>#<?php echo $o['id']; ?></strong></td>
              <td><?php echo date('d M Y H:i', strtotime($o['tanggal'])); ?></td>
              <td><?php echo esc($o['nama']); ?></td>
              <td><strong><?php echo format_rupiah($o['total_harga']); ?></strong></td>
              <td><span class="badge bg-success badge-status"><?php echo esc($o['status']); ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  <?php else: ?>
    <div class="alert alert-secondary"><i class="fa-solid fa-info-circle me-2"></i>Gunakan filter di atas untuk melihat pendapatan pada minggu atau bulan tertentu.</div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

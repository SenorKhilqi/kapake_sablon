<?php
// admin/header.php - Modern Admin Panel Layout
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$admin_name = $_SESSION['username'] ?? 'Admin';
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - SablonKita</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/sablon/assets/css/style.css" rel="stylesheet">
    <style>
      /* Admin Panel Modern Layout */
      body { font-family: 'Inter', sans-serif; background: #f8f9fa; margin:0; overflow-x:hidden; }
      .admin-wrapper { display: flex; min-height: 100vh; }
      
      /* Sidebar */
      .admin-sidebar-modern { 
        width: 260px; 
        background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        color: #fff; 
        position: fixed; 
        height: 100vh; 
        overflow-y: auto;
        box-shadow: 4px 0 12px rgba(0,0,0,0.15);
        z-index: 1000;
        transition: all 0.3s ease;
      }
      .admin-sidebar-modern .brand { 
        padding: 24px 20px; 
        font-size: 1.35rem; 
        font-weight: 700; 
        border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        gap: 12px;
      }
      .admin-sidebar-modern .brand img { 
        background: #fff;
        border-radius: 10px;
        height: 40px;
        object-fit: contain;
      }
      .admin-sidebar-modern .nav { padding: 20px 0; }
      .admin-sidebar-modern .nav-item { margin: 4px 12px; }
      .admin-sidebar-modern .nav-link { 
        display: flex; 
        align-items: center; 
        padding: 12px 16px; 
        color: rgba(255,255,255,0.75); 
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
      }
      .admin-sidebar-modern .nav-link i { margin-right: 12px; width: 20px; }
      .admin-sidebar-modern .nav-link:hover { 
        background: rgba(255,255,255,0.08); 
        color: #fff;
        transform: translateX(4px);
      }
      .admin-sidebar-modern .nav-link.active { 
        background: linear-gradient(90deg, rgba(59,130,246,0.15), rgba(96,165,250,0.1));
        color: #60a5fa;
        box-shadow: inset 3px 0 0 #3b82f6;
      }
      .admin-sidebar-modern .badge { 
        margin-left: auto;
        background: #ef4444;
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 999px;
      }

      /* Main Content */
      .admin-main-modern { 
        margin-left: 260px; 
        flex: 1; 
        display: flex;
        flex-direction: column;
        min-height: 100vh;
      }

      /* Topbar */
      .admin-topbar { 
        background: #fff; 
        padding: 16px 32px; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 999;
      }
      .admin-topbar h1 { 
        font-size: 1.5rem; 
        font-weight: 700; 
        margin: 0;
        color: #1e293b;
      }
      .admin-topbar .admin-user { 
        display: flex; 
        align-items: center; 
        gap: 12px;
        color: #64748b;
        font-weight: 500;
      }
      .admin-topbar .admin-user i { 
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        color: #fff;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      /* Content Area */
      .admin-content-modern { 
        padding: 32px; 
        flex: 1;
      }

      /* Footer */
      .admin-footer-modern { 
        padding: 20px 32px; 
        background: #fff; 
        border-top: 1px solid #e2e8f0;
        text-align: center;
        color: #64748b;
        font-size: 0.9rem;
      }

      /* Mobile Responsive */
      @media (max-width: 991px) {
        .admin-sidebar-modern { 
          transform: translateX(-260px);
        }
        .admin-sidebar-modern.show { 
          transform: translateX(0);
        }
        .admin-main-modern { 
          margin-left: 0;
        }
        .admin-topbar {
          padding: 12px 20px;
        }
        .admin-content-modern {
          padding: 20px;
        }
      }

      /* Mobile Toggle Button */
      .mobile-toggle { 
        display: none;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        border: 0;
        padding: 10px 16px;
        border-radius: 8px;
        cursor: pointer;
      }
      @media (max-width: 991px) {
        .mobile-toggle { display: inline-block; }
      }
    </style>
  </head>
  <body>
    <div class="admin-wrapper">
      <!-- Sidebar -->
      <aside class="admin-sidebar-modern" id="adminSidebar">
        <div class="brand">
          <img src="../assets/logo/logo.png" alt="Logo" style="height: 32px; border-radius: 8px;">
          <span>SablonKita Admin</span>
        </div>
        <nav class="nav flex-column">
          <div class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
              <i class="fa-solid fa-chart-line"></i>
              Dashboard
            </a>
          </div>
          <div class="nav-item">
            <a href="products.php" class="nav-link <?php echo $current_page === 'products' ? 'active' : ''; ?>">
              <i class="fa-solid fa-box-open"></i>
              Data Produk
            </a>
          </div>
          <div class="nav-item">
            <a href="orders.php" class="nav-link <?php echo $current_page === 'orders' ? 'active' : ''; ?>">
              <i class="fa-solid fa-receipt"></i>
              Data Pesanan
              <?php $pending = get_pending_orders_count(); if ($pending > 0): ?>
                <span class="badge"><?php echo $pending; ?></span>
              <?php endif; ?>
            </a>
          </div>
          <div class="nav-item">
            <a href="users.php" class="nav-link <?php echo $current_page === 'users' ? 'active' : ''; ?>">
              <i class="fa-solid fa-users"></i>
              Data User
            </a>
          </div>
          <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 12px;">
          <div class="nav-item">
            <a href="../index.php" class="nav-link" target="_blank">
              <i class="fa-solid fa-eye"></i>
              Lihat Situs
            </a>
          </div>
          <div class="nav-item">
            <a href="../logout.php" class="nav-link">
              <i class="fa-solid fa-right-from-bracket"></i>
              Keluar
            </a>
          </div>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="admin-main-modern">
        <!-- Topbar -->
        <header class="admin-topbar">
          <div class="d-flex align-items-center gap-3">
            <button class="mobile-toggle" onclick="document.getElementById('adminSidebar').classList.toggle('show')">
              <i class="fa-solid fa-bars"></i>
            </button>
            <h1>Dashboard Admin — SablonKita</h1>
          </div>
          <div class="admin-user">
            <i class="fa-solid fa-user-shield"></i>
            <span><?php echo esc($admin_name); ?></span>
          </div>
        </header>

        <!-- Content Area -->
        <div class="admin-content-modern">

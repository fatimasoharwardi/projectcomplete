<?php
include '../includes/auth_check.php';
include '../includes/db.php';

// Only admin can access
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login_admin.php");
    exit();
}

// Count stats
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'manufacturer'")->fetchColumn();
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$pendingTests = $pdo->query("SELECT COUNT(*) FROM products WHERE status IS NULL")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body {
      background: #f7fafc;
      min-height: 100vh;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .dashboard-title {
      color: #4a69bd;
      font-weight: 900;
      font-size: 2.2rem;
      letter-spacing: 1px;
      margin: 2.5rem auto 2rem auto;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.8rem;
    }
    .dashboard-title .bi {
      font-size: 2.3rem;
      color: #263859;
    }
    .dashboard-cards-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 28px;
      max-width: 1100px;
      margin: 0 auto 2.5rem auto;
      align-items: stretch;
    }
    .dashboard-card {
      background: #fff;
      border: 2.5px solid #e3e6f0;
      border-radius: 18px;
      box-shadow: 0 4px 18px 0 rgba(44, 62, 80, 0.10);
      padding: 2.1rem 1.2rem 1.2rem 1.2rem;
      text-align: center;
      transition: box-shadow 0.2s, transform 0.15s, border-color 0.2s;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 200px;
      position: relative;
    }
    .dashboard-card:hover {
      box-shadow: 0 16px 48px 0 rgba(44, 62, 80, 0.18);
      border-color: #4a69bd;
      transform: translateY(-2px) scale(1.03);
    }
    .dashboard-card .icon {
      font-size: 2.5rem;
      margin-bottom: 0.7rem;
      color: #4a69bd;
    }
    .dashboard-card .label {
      font-size: 1.13rem;
      color: #263859;
      font-weight: 700;
      margin-bottom: 0.2rem;
      letter-spacing: 0.5px;
    }
    .dashboard-card .value {
      font-size: 2.1rem;
      font-weight: 900;
      color: #263859;
      margin-bottom: 0.5rem;
    }
    .dashboard-card .desc {
      font-size: 1.01rem;
      color: #4a69bd;
      margin-bottom: 0.2rem;
      font-weight: 500;
    }
    .dashboard-card .card-link {
      margin-top: 0.7rem;
      font-size: 1.08rem;
      color: #fff;
      background: #4a69bd;
      border-radius: 8px;
      padding: 0.5rem 1.2rem;
      text-decoration: none;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: background 0.2s, color 0.2s;
    }
    .dashboard-card .card-link:hover {
      background: #263859;
      color: #fff;
    }
    .dashboard-actions-row {
      display: flex;
      flex-wrap: wrap;
      gap: 18px;
      justify-content: center;
      margin: 2.5rem auto 1.5rem auto;
      max-width: 900px;
    }
    .dashboard-action-btn {
      background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
      color: #fff;
      border: none;
      border-radius: 14px;
      font-weight: 700;
      font-size: 1.13rem;
      padding: 1rem 2rem;
      transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
      box-shadow: 0 2px 8px rgba(44,62,80,0.10);
      display: flex;
      align-items: center;
      gap: 0.7rem;
      text-decoration: none;
    }
    .dashboard-action-btn:hover, .dashboard-action-btn:focus {
      background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
      box-shadow: 0 8px 32px rgba(44, 62, 80, 0.18);
      transform: translateY(-2px) scale(1.03);
      color: #fff;
    }
    .dashboard-search-form {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 2px 8px rgba(44,62,80,0.07);
      padding: 1.2rem 1rem 0.5rem 1rem;
      margin: 0 auto 2.2rem auto;
      max-width: 700px;
    }
    @media (max-width: 1100px) {
      .dashboard-title, .dashboard-search-form, .dashboard-cards-grid {
        max-width: 100%;
        padding: 1rem 0.3rem;
      }
      .dashboard-cards-grid {
        gap: 16px;
      }
      .dashboard-card {
        min-width: 180px;
        max-width: 100%;
        padding: 1.2rem 0.5rem;
      }
    }
    @media (max-width: 700px) {
      .dashboard-title {
        font-size: 1.3rem;
        padding: 1rem 0.3rem;
      }
      .dashboard-card {
        font-size: 0.95rem;
        padding: 1rem 0.2rem;
      }
      .dashboard-cards-grid {
        grid-template-columns: 1fr;
        gap: 10px;
      }
      .dashboard-actions-row {
        flex-direction: column;
        gap: 10px;
      }
    }
  </style>
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="container-fluid px-0">
  <div class="dashboard-title mb-3">
    <i class="bi bi-speedometer2"></i>
    Admin Dashboard
  </div>
  <div class="dashboard-cards-grid">
    <div class="dashboard-card">
      <span class="icon"><i class="bi bi-people"></i></span>
      <span class="label">Manufacturers</span>
      <span class="value"><?= $totalUsers ?></span>
      <span class="desc">Registered companies</span>
      <a href="manage_users.php" class="card-link"><i class="bi bi-arrow-right-circle"></i> Manage</a>
    </div>
    <div class="dashboard-card">
      <span class="icon"><i class="bi bi-box-seam"></i></span>
      <span class="label">Products</span>
      <span class="value"><?= $totalProducts ?></span>
      <span class="desc">Submitted for testing</span>
      <a href="view_all_products.php" class="card-link"><i class="bi bi-arrow-right-circle"></i> View</a>
    </div>
    <div class="dashboard-card">
      <span class="icon"><i class="bi bi-hourglass-split"></i></span>
      <span class="label">Pending</span>
      <span class="value"><?= $pendingTests ?></span>
      <span class="desc">Awaiting test results</span>
      <a href="view_pending.php" class="card-link"><i class="bi bi-arrow-right-circle"></i> Pending</a>
    </div>
  </div>
  <div class="dashboard-actions-row">
    <a href="test_voltage.php" class="dashboard-action-btn"><i class="bi bi-lightning-charge"></i> Voltage Test</a>
    <a href="test_heat.php" class="dashboard-action-btn"><i class="bi bi-thermometer-half"></i> Heat Test</a>
    <a href="test_durability.php" class="dashboard-action-btn"><i class="bi bi-hourglass-split"></i> Durability Test</a>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>

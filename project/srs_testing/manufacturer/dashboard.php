<?php
include '../includes/auth_check.php';
include '../includes/db.php';
if ($_SESSION['role'] !== 'manufacturer') {
    header("Location: ../login_manufacturer.php");
    exit();
}
// Total products
$stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$totalProducts = $stmt->fetchColumn();

// Last test info
$stmt = $pdo->prepare("SELECT t.*, p.product_name FROM tests t JOIN products p ON t.product_id = p.id WHERE p.user_id = ? ORDER BY t.tested_at DESC LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$lastTest = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manufacturer Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e3e6f0 0%, #b2bec3 100%);
      min-height: 100vh;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .dashboard-hero {
      background: linear-gradient(90deg, #274690 60%, #4a69bd 100%);
      color: #fff;
      padding: 3rem 1.5rem 2rem 1.5rem;
      border-radius: 22px;
      margin: 2rem auto 2.5rem auto;
      max-width: 950px;
      box-shadow: 0 8px 32px 0 rgba(39,70,144,0.13);
      text-align: center;
    }
    .dashboard-hero h1 {
      font-size: 2.7rem;
      font-weight: 900;
      margin-bottom: 0.7rem;
      letter-spacing: 1px;
    }
    .dashboard-hero p {
      font-size: 1.22rem;
      font-weight: 500;
      margin-bottom: 0.5rem;
    }
    .dashboard-stats {
      display: flex;
      gap: 32px;
      justify-content: center;
      margin-bottom: 2.5rem;
      flex-wrap: wrap;
    }
    .stat-card {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 4px 18px 0 rgba(44, 62, 80, 0.10);
      padding: 1.7rem 2.2rem;
      text-align: center;
      min-width: 220px;
      border: 2px solid #e3e6f0;
      margin-bottom: 1rem;
      transition: box-shadow 0.2s, transform 0.15s;
    }
    .stat-card:hover {
      box-shadow: 0 12px 36px 0 rgba(44, 62, 80, 0.18);
      transform: translateY(-2px) scale(1.04);
    }
    .stat-card .icon {
      font-size: 2.3rem;
      color: #4a69bd;
      margin-bottom: 0.5rem;
    }
    .stat-card .label {
      font-size: 1.13rem;
      color: #263859;
      font-weight: 700;
      margin-bottom: 0.2rem;
    }
    .stat-card .value {
      font-size: 2.3rem;
      font-weight: 900;
      color: #263859;
      margin-bottom: 0.5rem;
    }
    .stat-card .desc {
      font-size: 1.07rem;
      color: #4a69bd;
      margin-bottom: 0.2rem;
      font-weight: 500;
    }
    .dashboard-section {
      background: #fff;
      border-radius: 22px;
      box-shadow: 0 8px 32px 0 rgba(39,70,144,0.13);
      padding: 2.2rem 1.2rem;
      margin: 0 auto 2rem auto;
      max-width: 950px;
    }
    .dashboard-section h2 {
      font-size: 1.5rem;
      font-weight: 800;
      color: #274690;
      margin-bottom: 1.2rem;
      letter-spacing: 1px;
    }
    .dashboard-actions {
      background: #f7fafc;
      border-radius: 16px;
      box-shadow: 0 2px 8px rgba(44,62,80,0.07);
      padding: 1.5rem 1.2rem;
      margin: 0 auto 2rem auto;
      max-width: 700px;
      text-align: center;
    }
    .dashboard-actions h2 {
      font-size: 1.2rem;
      font-weight: 700;
      color: #4a69bd;
      margin-bottom: 1rem;
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
      display: inline-flex;
      align-items: center;
      gap: 0.7rem;
      text-decoration: none;
      margin: 0.5rem 0.7rem;
    }
    .dashboard-action-btn:hover, .dashboard-action-btn:focus {
      background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
      box-shadow: 0 8px 32px rgba(44, 62, 80, 0.18);
      transform: translateY(-2px) scale(1.03);
      color: #fff;
    }
    .dashboard-contact {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 2px 8px rgba(44,62,80,0.07);
      padding: 1.5rem 1.2rem;
      margin: 0 auto 2.2rem auto;
      max-width: 700px;
      text-align: center;
    }
    .dashboard-contact h2 {
      font-size: 1.2rem;
      font-weight: 700;
      color: #4a69bd;
      margin-bottom: 0.7rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      justify-content: center;
    }
    .dashboard-contact p {
      font-size: 1.05rem;
      color: #263859;
      margin-bottom: 0.3rem;
    }
    @media (max-width: 1100px) {
      .dashboard-hero, .dashboard-section {
        max-width: 100%;
        padding: 1.2rem 0.5rem;
      }
      .dashboard-stats {
        gap: 16px;
      }
      .stat-card {
        min-width: 180px;
        padding: 1.2rem 0.5rem;
      }
    }
    @media (max-width: 700px) {
      .dashboard-hero h1 {
        font-size: 1.3rem;
      }
      .stat-card {
        font-size: 0.95rem;
        padding: 1rem 0.2rem;
      }
      .dashboard-stats {
        flex-direction: column;
        gap: 10px;
      }
      .dashboard-section {
        padding: 1rem 0.5rem;
      }
      .dashboard-actions, .dashboard-contact {
        padding: 1rem 0.5rem;
      }
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/../includes/header_manufacturer.php'; ?>

<!-- Hero Section -->
<div class="dashboard-hero">
  <h1><i class="bi bi-person-badge"></i> Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Manufacturer') ?>!</h1>
  <p>Manage your products, view test results, and stay updated with your dashboard.</p>
</div>

<!-- Stats Section -->
<div class="dashboard-stats">
  <div class="stat-card">
    <span class="icon"><i class="bi bi-box-seam"></i></span>
    <div class="label">Total Products</div>
    <div class="value"><?= $totalProducts ?></div>
    <div class="desc">Products submitted</div>
  </div>
  <div class="stat-card">
    <span class="icon"><i class="bi bi-activity"></i></span>
    <div class="label">Last Test Status</div>
    <div class="value">
      <?php if ($lastTest): ?>
        <span class="badge bg-<?= strtolower($lastTest['status']) === 'passed' ? 'success' : 'danger' ?>">
          <?= htmlspecialchars($lastTest['status']) ?>
        </span>
      <?php else: ?>
        <span class="badge bg-secondary">N/A</span>
      <?php endif; ?>
    </div>
    <div class="desc"><?= $lastTest ? htmlspecialchars($lastTest['test_type']) : 'No tests yet' ?></div>
  </div>
</div>

<!-- Products Section (show top 5) -->
<div class="dashboard-section">
  <h2><i class="bi bi-box-seam"></i> My Products</h2>
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>Product ID</th>
          <th>Name</th>
          <th>Date Added</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $pdo->prepare("SELECT product_id, product_name, created_at FROM products WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
        $stmt->execute([$_SESSION['user_id']]);
        $topProducts = $stmt->fetchAll();
        if ($topProducts):
          foreach ($topProducts as $prod):
        ?>
          <tr>
            <td><?= htmlspecialchars($prod['product_id']) ?></td>
            <td><?= htmlspecialchars($prod['product_name']) ?></td>
            <td><?= htmlspecialchars($prod['created_at']) ?></td>
          </tr>
        <?php endforeach; else: ?>
          <tr>
            <td colspan="3" class="text-center text-muted">No products added yet.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
    <a href="view_products.php" class="btn btn-outline-primary mt-2"><i class="bi bi-arrow-right-circle"></i> View All Products</a>
  </div>
</div>

<!-- Actions Section -->
<div class="dashboard-actions">
  <h2><i class="bi bi-lightning-charge"></i> Quick Actions</h2>
  <a href="add_product.php" class="dashboard-action-btn"><i class="bi bi-plus-square"></i> Add New Product</a>
  <a href="view_products.php" class="dashboard-action-btn"><i class="bi bi-box-seam"></i> View My Products</a>
  <a href="profile.php" class="dashboard-action-btn"><i class="bi bi-person-circle"></i> My Profile</a>
</div>

<!-- Contact Section -->
<div class="dashboard-contact">
  <h2><i class="bi bi-chat-dots"></i> Need Help?</h2>
  <p>For support or queries, reach out to our team.</p>
  <a href="/project/srs_testing/contact.php" class="btn btn-primary"><i class="bi bi-envelope"></i> Contact Us</a>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>

<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manufacturer') {
    header("Location: ../login_manufacturer.php");
    exit();
}

if (!isset($_GET['product_id'])) die("Product ID missing");
$product_id = $_GET['product_id'];

// Check product ownership
$stmt = $pdo->prepare("SELECT product_id, product_name, user_id FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();
if (!$product || $product['user_id'] != $_SESSION['user_id']) {
    die("Unauthorized access");
}

// Fetch latest voltage test
$vtest = $pdo->prepare("SELECT * FROM voltage_tests WHERE product_id = ? ORDER BY tested_at DESC LIMIT 1");
$vtest->execute([$product_id]);
$voltage = $vtest->fetch();

// Fetch latest heat test
$htest = $pdo->prepare("SELECT * FROM heat_tests WHERE product_id = ? ORDER BY tested_at DESC LIMIT 1");
$htest->execute([$product_id]);
$heat = $htest->fetch();

// Fetch latest durability test
$dtest = $pdo->prepare("SELECT * FROM durability_tests WHERE product_id = ? ORDER BY tested_at DESC LIMIT 1");
$dtest->execute([$product_id]);
$durability = $dtest->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Test Results</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e3e6f0 0%, #b2bec3 100%);
      min-height: 100vh;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .test-title {
      color: #4a69bd;
      font-weight: 900;
      font-size: 2.1rem;
      letter-spacing: 1px;
      margin: 2.5rem auto 2rem auto;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.8rem;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 8px 32px 0 rgba(44, 62, 80, 0.18);
      margin-bottom: 1.5rem;
      border: none;
    }
    .card-header {
      font-size: 1.18rem;
      font-weight: 700;
      letter-spacing: 0.5px;
      border-radius: 20px 20px 0 0;
    }
    .card-body p {
      font-size: 1.07rem;
      color: #263859;
      margin-bottom: 0.3rem;
    }
    .badge-success {
      background-color: #28a745 !important;
    }
    .badge-danger {
      background-color: #dc3545 !important;
    }
    .badge-secondary {
      background-color: #6c757d !important;
    }
    @media (max-width: 700px) {
      .test-title {
        font-size: 1.2rem;
        padding: 1rem 0.3rem;
      }
      .card-header {
        font-size: 1rem;
      }
      .card-body p {
        font-size: 0.95rem;
      }
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/../includes/header_manufacturer.php'; ?>
<div class="container py-4">
  <div class="test-title mb-4"><i class="bi bi-clipboard-data"></i> Test Results</div>
  <div class="mb-3 fw-bold" style="color:#274690;">
    Product: <?= htmlspecialchars($product['product_name']) ?> (ID: <?= htmlspecialchars($product['product_id']) ?>)
  </div>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card border-primary shadow-sm">
        <div class="card-header bg-primary text-white fw-bold"><i class="bi bi-lightning-charge"></i> Voltage Test</div>
        <div class="card-body">
          <?php if ($voltage): ?>
            <p><b>Voltage Level:</b> <?= $voltage['voltage_level'] ? 'Yes' : 'No' ?></p>
            <p><b>Voltage Stability:</b> <?= $voltage['voltage_stability'] ? 'Yes' : 'No' ?></p>
            <p><b>Spike Protection:</b> <?= $voltage['voltage_spike_protection'] ? 'Yes' : 'No' ?></p>
            <p><b>Status:</b> <span class="badge badge-<?= $voltage['status']=='Pass'?'success':'danger' ?>"><?= htmlspecialchars($voltage['status']) ?></span></p>
            <p><b>Tested By:</b> <?= htmlspecialchars($voltage['tested_by']) ?></p>
            <p><b>Date:</b> <?= htmlspecialchars($voltage['tested_at']) ?></p>
            <p><b>Remarks:</b> <?= nl2br(htmlspecialchars($voltage['remarks'])) ?></p>
          <?php else: ?>
            <p class="text-muted">No voltage test performed.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-warning shadow-sm">
        <div class="card-header bg-warning text-dark fw-bold"><i class="bi bi-thermometer-half"></i> Heat Test</div>
        <div class="card-body">
          <?php if ($heat): ?>
            <p><b>Heat Resistance:</b> <?= $heat['heat_resistance'] ? 'Yes' : 'No' ?></p>
            <p><b>Temperature Tolerance:</b> <?= $heat['temperature_tolerance'] ? 'Yes' : 'No' ?></p>
            <p><b>Overheating Protection:</b> <?= $heat['overheating_protection'] ? 'Yes' : 'No' ?></p>
            <p><b>Status:</b> <span class="badge badge-<?= $heat['status']=='Pass'?'success':'danger' ?>"><?= htmlspecialchars($heat['status']) ?></span></p>
            <p><b>Tested By:</b> <?= htmlspecialchars($heat['tested_by']) ?></p>
            <p><b>Date:</b> <?= htmlspecialchars($heat['tested_at']) ?></p>
            <p><b>Remarks:</b> <?= nl2br(htmlspecialchars($heat['remarks'])) ?></p>
          <?php else: ?>
            <p class="text-muted">No heat test performed.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-success shadow-sm">
        <div class="card-header bg-success text-white fw-bold"><i class="bi bi-hourglass-split"></i> Durability Test</div>
        <div class="card-body">
          <?php if ($durability): ?>
            <p><b>Drop Test:</b> <?= $durability['drop_test'] ? 'Yes' : 'No' ?></p>
            <p><b>Water Resistance:</b> <?= $durability['water_resistance'] ? 'Yes' : 'No' ?></p>
            <p><b>Material Strength:</b> <?= $durability['material_strength'] ? 'Yes' : 'No' ?></p>
            <p><b>Status:</b> <span class="badge badge-<?= $durability['status']=='Pass'?'success':'danger' ?>"><?= htmlspecialchars($durability['status']) ?></span></p>
            <p><b>Tested By:</b> <?= htmlspecialchars($durability['tested_by']) ?></p>
            <p><b>Date:</b> <?= htmlspecialchars($durability['tested_at']) ?></p>
            <p><b>Remarks:</b> <?= nl2br(htmlspecialchars($durability['remarks'])) ?></p>
          <?php else: ?>
            <p class="text-muted">No durability test performed.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>

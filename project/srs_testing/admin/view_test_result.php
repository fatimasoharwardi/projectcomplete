<?php
include '../includes/auth_check.php';
include '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login_admin.php");
    exit();
}

if (!isset($_GET['product_id'])) die("Product ID missing");
$product_id = $_GET['product_id'];

// Fetch product info
$stmt = $pdo->prepare("SELECT product_id, product_name FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

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
<?php include '../includes/header.php'; ?>
<div class="container py-4">
  <h2 class="mb-4 text-center fw-bold text-primary"><i class="bi bi-clipboard-data"></i> Test Results</h2>
  <div class="mb-3 fw-bold text-primary">
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
            <p><b>Status:</b> <span class="badge bg-<?= $voltage['status']=='Pass'?'success':'danger' ?>"><?= htmlspecialchars($voltage['status']) ?></span></p>
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
            <p><b>Status:</b> <span class="badge bg-<?= $heat['status']=='Pass'?'success':'danger' ?>"><?= htmlspecialchars($heat['status']) ?></span></p>
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
            <p><b>Status:</b> <span class="badge bg-<?= $durability['status']=='Pass'?'success':'danger' ?>"><?= htmlspecialchars($durability['status']) ?></span></p>
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

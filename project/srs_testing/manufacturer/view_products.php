<?php
include '../includes/auth_check.php';
include '../includes/db.php';

if ($_SESSION['role'] !== 'manufacturer') {
    header("Location: ../login_manufacturer.php");
    exit();
}

// Step 1: Get all products for the logged-in manufacturer
$stmt = $pdo->prepare("SELECT * FROM products WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$products = $stmt->fetchAll();

// Step 2: Fetch latest test for each product by matching product_id from tests with products.id
$testResults = [];
if ($products) {
    $productIds = array_column($products, 'id');  // products.id, not product_id
    if ($productIds) {
        $in = str_repeat('?,', count($productIds) - 1) . '?';
        $testStmt = $pdo->prepare("
            SELECT * FROM tests 
            WHERE product_id IN ($in)
            ORDER BY tested_at DESC
        ");
        $testStmt->execute($productIds);
        foreach ($testStmt->fetchAll() as $row) {
            if (!isset($testResults[$row['product_id']])) {
                $testResults[$row['product_id']] = $row;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Products</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f0f4f8, #cfd9df);
      min-height: 100vh;
      font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
    }
    .products-title {
      font-size: 2.1rem;
      font-weight: 800;
      color: #274690;
      margin-bottom: 1.2rem;
      text-align: center;
      letter-spacing: 1px;
      margin-top: 2rem;
    }
    .products-table {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 8px 32px 0 rgba(39,70,144,0.13);
      padding: 1.2rem 0.5rem 1.2rem 0.5rem;
      margin: 0 auto 2rem auto;
      max-width: 1100px;
    }
    .table {
      border-radius: 14px;
      overflow: hidden;
      margin-top: 0.5rem;
      background: #fff;
      box-shadow: 0 2px 8px rgba(39,70,144,0.07);
    }
    .table thead {
      background-color: #274690;
      color: #fff;
    }
    .table th, .table td {
      vertical-align: middle;
      font-size: 1.01rem;
      text-align: center;
      border-bottom: 1px solid #e3e6f0;
      padding: 0.65rem 0.4rem;
    }
    .table-hover tbody tr:hover {
      background-color: #f1f4f9;
      transition: background 0.2s;
    }
    .status {
      font-weight: 700;
      text-transform: capitalize;
      letter-spacing: 0.5px;
    }
    .status.Pending {
      color: #ffc107;
    }
    .status.Passed {
      color: #28a745;
    }
    .status.Failed {
      color: #dc3545;
    }
    @media (max-width: 992px) {
      .products-table {
        padding: 0.7rem 0.1rem;
        max-width: 100%;
      }
      .table th, .table td {
        font-size: 0.95rem;
      }
    }
    @media (max-width: 600px) {
      .products-title {
        font-size: 1.2rem;
      }
      .products-table {
        padding: 0.3rem 0.05rem;
      }
      .table th, .table td {
        font-size: 0.85rem;
      }
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/../includes/header_manufacturer.php'; ?>
<div class="container-fluid px-0">
  <div class="products-title"><i class="bi bi-box-seam"></i> My Products</div>
  <div class="products-table">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Test Type</th>
            <th>Tested By</th>
            <th>Tested Date</th>
            <th>Remarks</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): 
              $productId = $product['id'];
              $test = $testResults[$productId] ?? null;
            ?>
              <tr>
                <td><?= htmlspecialchars($product['product_id']) ?></td>
                <td><?= htmlspecialchars($product['product_name']) ?></td>
                <td class="status <?= htmlspecialchars($test['status'] ?? 'Pending') ?>">
                  <?= htmlspecialchars($test['status'] ?? 'Pending') ?>
                </td>
                <td><?= htmlspecialchars($test['test_type'] ?? '-') ?></td>
                <td><?= htmlspecialchars($test['tested_by'] ?? '-') ?></td>
                <td><?= htmlspecialchars($test['tested_at'] ?? '-') ?></td>
                <td><?= nl2br(htmlspecialchars($test['remarks'] ?? '-')) ?></td>
                <td>
                  <a href="/project/srs_testing/manufacturer/view_test_result.php?product_id=<?= $productId ?>" class="btn btn-info btn-sm">View Test</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center text-muted">No products added yet.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>

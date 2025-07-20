<?php
include '../includes/auth_check.php';
include '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login_admin.php");
    exit();
}

// Get all products with manufacturer name
$stmt = $pdo->query("SELECT p.*, u.name AS manufacturer_name FROM products p LEFT JOIN users u ON p.user_id = u.id");
$products = $stmt->fetchAll();

function getTestStatus($pdo, $table, $product_id) {
    $q = $pdo->prepare("SELECT status FROM $table WHERE product_id = ? ORDER BY tested_at DESC LIMIT 1");
    $q->execute([$product_id]);
    $row = $q->fetch();
    return $row ? $row['status'] : 'Pending';
}
?>
<?php include '../includes/header.php'; ?>

<style>
body {
  background: linear-gradient(135deg, #f7fafc 0%, #e3e6f0 100%);
}
.pending-title {
  color: #263859;
  font-weight: 900;
  font-size: 2.1rem;
  letter-spacing: 1px;
  margin-bottom: 2.2rem;
  margin-top: 2.5rem;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.7rem;
}
.pending-table {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.13);
  padding: 2.2rem 1.2rem 1.2rem 1.2rem;
  margin: 0 auto 2.5rem auto;
  max-width: 1200px;
}
.table {
  border-radius: 14px;
  overflow: hidden;
  margin-top: 1rem;
  background: linear-gradient(90deg, #f7fafc 60%, #e3e6f0 100%);
  box-shadow: 0 2px 8px rgba(39,70,144,0.07);
}
.table thead {
  background-color: #274690;
  color: #fff;
}
.table th, .table td {
  vertical-align: middle;
  font-size: 1.07rem;
  text-align: center;
  border-bottom: 1px solid #e3e6f0;
  padding: 0.75rem 0.5rem;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}
.table-hover tbody tr:hover {
  background-color: #e3e6f0;
  transition: background 0.2s;
}
.badge-success {
  background-color: #28a745;
}
.badge-danger {
  background-color: #dc3545;
}
@media (max-width: 1200px) {
  .pending-table {
    padding: 1rem 0.2rem;
    max-width: 100%;
  }
  .table th, .table td {
    font-size: 0.97rem;
  }
}
@media (max-width: 700px) {
  .pending-title {
    font-size: 1.3rem;
  }
  .pending-table {
    padding: 0.5rem 0.1rem;
  }
  .table th, .table td {
    font-size: 0.89rem;
  }
}
</style>

<div class="container-fluid px-0">
  <div class="pending-title mb-4">
    <i class="bi bi-clipboard-data"></i> Test Results Overview
  </div>
  <div class="pending-table">
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Manufacturer</th>
            <th>Voltage Test</th>
            <th>Heat Test</th>
            <th>Durability Test</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $p): ?>
            <tr>
              <td><?= htmlspecialchars($p['product_id']) ?></td>
              <td><?= htmlspecialchars($p['product_name']) ?></td>
              <td><?= htmlspecialchars($p['manufacturer_name'] ?? '-') ?></td>
              <td>
                <?php
                  $status = getTestStatus($pdo, 'voltage_tests', $p['id']);
                  $badge = $status === 'Pass' ? 'success' : ($status === 'Fail' ? 'danger' : 'secondary');
                ?>
                <span class="badge bg-<?= $badge ?>"><?= $status ?></span>
              </td>
              <td>
                <?php
                  $status = getTestStatus($pdo, 'heat_tests', $p['id']);
                  $badge = $status === 'Pass' ? 'success' : ($status === 'Fail' ? 'danger' : 'secondary');
                ?>
                <span class="badge bg-<?= $badge ?>"><?= $status ?></span>
              </td>
              <td>
                <?php
                  $status = getTestStatus($pdo, 'durability_tests', $p['id']);
                  $badge = $status === 'Pass' ? 'success' : ($status === 'Fail' ? 'danger' : 'secondary');
                ?>
                <span class="badge bg-<?= $badge ?>"><?= $status ?></span>
              </td>
              <td>
                <a href="update_test.php?product_id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Update</a>
                <a href="view_test_result.php?product_id=<?= $p['id'] ?>" class="btn btn-info btn-sm">View Test</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>

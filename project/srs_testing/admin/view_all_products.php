<?php
include '../includes/auth_check.php';
include '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login_admin.php");
    exit();
}

$stmt = $pdo->query("SELECT p.*, u.name FROM products p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
$products = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<style>
body {
  background: linear-gradient(135deg, #f7fafc 0%, #e3e6f0 100%);
}
.products-title {
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
.products-table {
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
@media (max-width: 1200px) {
  .products-table {
    padding: 1rem 0.2rem;
    max-width: 100%;
  }
  .table th, .table td {
    font-size: 0.97rem;
  }
}
@media (max-width: 700px) {
  .products-title {
    font-size: 1.3rem;
  }
  .products-table {
    padding: 0.5rem 0.1rem;
  }
  .table th, .table td {
    font-size: 0.89rem;
  }
}
</style>
<div class="container-fluid px-0">
  <div class="products-title mb-4">
    <i class="bi bi-box-seam"></i> All Products
  </div>
  <div class="products-table">
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th>Product ID</th>
            <th>Manufacturer</th>
            <th>Product Name</th>
            <th>Status</th>
            <th>Remarks</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $p): ?>
            <tr>
              <td><?= htmlspecialchars($p['product_id']) ?></td>
              <td><?= htmlspecialchars($p['name']) ?></td>
              <td><?= htmlspecialchars($p['product_name']) ?></td>
              <td>
                <?php if ($p['status'] == 'Passed'): ?>
                  <span class="badge bg-success">Passed</span>
                <?php elseif ($p['status'] == 'Failed'): ?>
                  <span class="badge bg-danger">Failed</span>
                <?php else: ?>
                  <span class="badge bg-warning text-dark">Pending</span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($p['remarks'] ?? '-') ?></td>
              <td><?= htmlspecialchars($p['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include '../includes/footer.php'; ?>

<?php
include '../includes/auth_check.php';
include '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login_admin.php");
    exit();
}

$where = [];
$params = [];

if (!empty($_GET['product_id'])) {
    $where[] = "p.product_id = ?";
    $params[] = $_GET['product_id'];
}
if (!empty($_GET['status'])) {
    $where[] = "p.status = ?";
    $params[] = $_GET['status'];
}
if (!empty($_GET['from']) && !empty($_GET['to'])) {
    $where[] = "DATE(p.tested_at) BETWEEN ? AND ?";
    $params[] = $_GET['from'];
    $params[] = $_GET['to'];
}

$sql = "SELECT p.*, u.name AS manufacturer FROM products p JOIN users u ON p.user_id = u.id";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY p.tested_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<style>
body {
  background: linear-gradient(135deg, #f7fafc 0%, #e3e6f0 100%);
}
.search-title {
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
.search-form-section {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.13);
  padding: 2.2rem 1.2rem 1.2rem 1.2rem;
  margin: 0 auto 2.5rem auto;
  max-width: 1000px;
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
@media (max-width: 1100px) {
  .search-form-section {
    padding: 1rem 0.2rem;
    max-width: 100%;
  }
  .table th, .table td {
    font-size: 0.97rem;
  }
}
@media (max-width: 700px) {
  .search-title {
    font-size: 1.3rem;
  }
  .search-form-section {
    padding: 0.5rem 0.1rem;
  }
  .table th, .table td {
    font-size: 0.89rem;
  }
}
</style>
<div class="container-fluid px-0">
  <div class="search-title mb-4">
    <i class="bi bi-search"></i> Advanced Search & Filter
  </div>
  <div class="search-form-section mb-4">
    <form method="GET" class="row g-3">
      <div class="col-md-3">
        <input type="text" name="product_id" class="form-control" placeholder="Product ID" value="<?= htmlspecialchars($_GET['product_id'] ?? '') ?>">
      </div>
      <div class="col-md-2">
        <select name="status" class="form-select">
          <option value="">Status</option>
          <option value="Passed" <?= (isset($_GET['status']) && $_GET['status'] == 'Passed') ? 'selected' : '' ?>>Passed</option>
          <option value="Failed" <?= (isset($_GET['status']) && $_GET['status'] == 'Failed') ? 'selected' : '' ?>>Failed</option>
        </select>
      </div>
      <div class="col-md-2">
        <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($_GET['from'] ?? '') ?>">
      </div>
      <div class="col-md-2">
        <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($_GET['to'] ?? '') ?>">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
      </div>
    </form>
  </div>
  <?php if ($results): ?>
    <div class="search-form-section">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead>
            <tr>
              <th>Product ID</th>
              <th>Name</th>
              <th>Manufacturer</th>
              <th>Status</th>
              <th>Date</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($results as $row): ?>
              <tr>
                <td><?= htmlspecialchars($row['product_id']) ?></td>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td><?= htmlspecialchars($row['manufacturer']) ?></td>
                <td>
                  <?php if ($row['status'] == 'Passed'): ?>
                    <span class="badge bg-success">Passed</span>
                  <?php elseif ($row['status'] == 'Failed'): ?>
                    <span class="badge bg-danger">Failed</span>
                  <?php else: ?>
                    <span class="badge bg-warning text-dark">Pending</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['tested_at']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['remarks'])) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php else: ?>
    <div class="text-center text-muted mb-5">No results found.</div>
  <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>

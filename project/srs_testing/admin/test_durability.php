<?php
include '../includes/auth_check.php';
include '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login_admin.php");
    exit();
}

if (!isset($_GET['product_id'])) die("Product ID missing");
$product_id = $_GET['product_id'];

// Fetch product info for display
$stmt = $pdo->prepare("SELECT product_id, product_name FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $d1 = isset($_POST['drop_test']) ? 1 : 0;
    $d2 = isset($_POST['water_resistance']) ? 1 : 0;
    $d3 = isset($_POST['material_strength']) ? 1 : 0;
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];
    $tested_by = $_SESSION['username'] ?? $_SESSION['admin_id'];

    $sql = "INSERT INTO durability_tests (product_id, drop_test, water_resistance, material_strength, status, remarks, tested_by)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id, $d1, $d2, $d3, $status, $remarks, $tested_by]);

    header("Location: view_test_result.php?product_id=$product_id");
    exit;
}
?>
<?php include '../includes/header.php'; ?>
<style>
body {
  background: linear-gradient(135deg, #e3e6f0 0%, #b2bec3 100%);
  min-height: 100vh;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}
.test-form-title {
  color: #263859;
  font-weight: 900;
  font-size: 2.2rem;
  letter-spacing: 1px;
  margin-bottom: 2.7rem;
  margin-top: 2.7rem;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.8rem;
}
.durability-form-card {
  background: #fff;
  border-radius: 22px;
  box-shadow: 0 8px 32px 0 rgba(44, 62, 80, 0.16);
  padding: 2.2rem 2rem 2rem 2rem;
  max-width: 520px;
  margin: 0 auto;
  border: 2px solid #e3e6f0;
}
.custom-checkbox {
  position: relative;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  font-weight: 700;
  color: #263859;
  font-size: 1.13rem;
  margin-bottom: 10px;
  cursor: pointer;
  user-select: none;
}
.custom-checkbox input[type="checkbox"] {
  appearance: none;
  width: 22px;
  height: 22px;
  border: 2px solid #4a69bd;
  border-radius: 6px;
  background: #f4f6fb;
  margin-right: 8px;
  position: relative;
  transition: border-color 0.2s, background 0.2s;
}
.custom-checkbox input[type="checkbox"]:checked {
  background: #4a69bd;
  border-color: #263859;
}
.custom-checkbox input[type="checkbox"]:checked:after {
  content: '\2714';
  color: #fff;
  font-size: 1.1rem;
  position: absolute;
  left: 3px;
  top: 0px;
}
.custom-checkbox input[type="checkbox"]:focus {
  outline: 2px solid #4a69bd;
}
.form-control, .form-select {
  background: #f4f6fb;
  color: #263859;
  border: 1.5px solid #b2bec3;
  border-radius: 12px;
  font-size: 1.13rem;
  padding: 1rem 1.2rem;
  margin-bottom: 1.3rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.form-control:focus, .form-select:focus {
  border-color: #4a69bd;
  box-shadow: 0 0 0 2px #4a69bd33;
  background: #e3e6f0;
  color: #263859;
}
.btn-primary {
  background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
  border: none;
  border-radius: 12px;
  font-weight: 800;
  padding: 1.1rem;
  font-size: 1.18rem;
  letter-spacing: 0.5px;
  transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
  margin-top: 0.7rem;
  margin-bottom: 0.5rem;
  box-shadow: 0 2px 8px rgba(44,62,80,0.10);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.7rem;
}
.btn-primary:hover, .btn-primary:focus {
  background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
  box-shadow: 0 8px 32px rgba(44, 62, 80, 0.18);
  transform: translateY(-2px) scale(1.03);
  color: #fff;
}
.durability-product-info {
  font-weight: 700;
  color: #4a69bd;
  font-size: 1.13rem;
  margin-bottom: 1.7rem;
  text-align: center;
  letter-spacing: 0.5px;
}
@media (max-width: 700px) {
  .test-form-title {
    font-size: 1.3rem;
    margin-top: 1.2rem;
    margin-bottom: 1.2rem;
  }
  .durability-form-card {
    padding: 1.1rem 0.5rem;
    max-width: 100%;
  }
  .custom-checkbox {
    font-size: 1rem;
  }
}
</style>
<div class="container py-4">
  <div class="test-form-title mb-4 justify-content-center"><i class="bi bi-hourglass-split"></i> Durability Test</div>
  <div class="durability-form-card">
    <div class="durability-product-info">
      Product: <?= htmlspecialchars($product['product_name']) ?> (ID: <?= htmlspecialchars($product['product_id']) ?>)
    </div>
    <form method="POST">
      <div class="mb-3">
        <label class="custom-checkbox">
          <input type="checkbox" name="drop_test"> Drop Test
        </label>
      </div>
      <div class="mb-3">
        <label class="custom-checkbox">
          <input type="checkbox" name="water_resistance"> Water Resistance
        </label>
      </div>
      <div class="mb-3">
        <label class="custom-checkbox">
          <input type="checkbox" name="material_strength"> Material Strength
        </label>
      </div>
      <div class="mb-3">
        <label>Status</label>
        <select name="status" required class="form-select">
          <option value="">Select</option>
          <option value="Pass">Pass</option>
          <option value="Fail">Fail</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Remarks</label>
        <textarea name="remarks" class="form-control" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-circle"></i> Submit Final Test</button>
    </form>
  </div>
</div>
<?php include '../includes/footer.php'; ?>

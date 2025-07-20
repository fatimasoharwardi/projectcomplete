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

// Fetch latest test data for pre-fill
function fetchTest($pdo, $table, $product_id) {
    $q = $pdo->prepare("SELECT * FROM $table WHERE product_id = ? ORDER BY tested_at DESC LIMIT 1");
    $q->execute([$product_id]);
    return $q->fetch();
}
$voltage = fetchTest($pdo, 'voltage_tests', $product_id);
$heat = fetchTest($pdo, 'heat_tests', $product_id);
$durability = fetchTest($pdo, 'durability_tests', $product_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Voltage
    $v1 = isset($_POST['voltage_level']) ? 1 : 0;
    $v2 = isset($_POST['voltage_stability']) ? 1 : 0;
    $v3 = isset($_POST['voltage_spike_protection']) ? 1 : 0;
    $vstatus = $_POST['voltage_status'];
    $vremarks = $_POST['voltage_remarks'];
    $tested_by = $_SESSION['username'] ?? $_SESSION['admin_id'];

    // Heat
    $h1 = isset($_POST['heat_resistance']) ? 1 : 0;
    $h2 = isset($_POST['temperature_tolerance']) ? 1 : 0;
    $h3 = isset($_POST['overheating_protection']) ? 1 : 0;
    $hstatus = $_POST['heat_status'];
    $hremarks = $_POST['heat_remarks'];

    // Durability
    $d1 = isset($_POST['drop_test']) ? 1 : 0;
    $d2 = isset($_POST['water_resistance']) ? 1 : 0;
    $d3 = isset($_POST['material_strength']) ? 1 : 0;
    $dstatus = $_POST['durability_status'];
    $dremarks = $_POST['durability_remarks'];

    // Update or Insert for each test
    foreach (array(
        array('voltage_tests', array(
            'voltage_level' => $v1,
            'voltage_stability' => $v2,
            'voltage_spike_protection' => $v3,
            'status' => $vstatus,
            'remarks' => $vremarks,
            'tested_by' => $tested_by
        )),
        array('heat_tests', array(
            'heat_resistance' => $h1,
            'temperature_tolerance' => $h2,
            'overheating_protection' => $h3,
            'status' => $hstatus,
            'remarks' => $hremarks,
            'tested_by' => $tested_by
        )),
        array('durability_tests', array(
            'drop_test' => $d1,
            'water_resistance' => $d2,
            'material_strength' => $d3,
            'status' => $dstatus,
            'remarks' => $dremarks,
            'tested_by' => $tested_by
        ))
    ) as $test) {
        $table = $test[0];
        $fields = $test[1];
        // Check if test exists
        $check = $pdo->prepare("SELECT id FROM $table WHERE product_id = ? ORDER BY tested_at DESC LIMIT 1");
        $check->execute(array($product_id));
        $row = $check->fetch();
        if ($row) {
            // Update
            $set = implode(', ', array_map(function($k) { return "$k = ?"; }, array_keys($fields)));
            $sql = "UPDATE $table SET $set WHERE id = ?";
            $params = array_values($fields);
            $params[] = $row['id'];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        } else {
            // Insert
            $cols = implode(', ', array_keys($fields));
            $qs = implode(', ', array_fill(0, count($fields), '?'));
            $sql = "INSERT INTO $table (product_id, $cols) VALUES (?, $qs)";
            $params = array_merge(array($product_id), array_values($fields));
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        }
    }
    header("Location: view_test_result.php?product_id=$product_id");
    exit;
}
?>
<?php include '../includes/header.php'; ?>
<div class="container py-4">
  <h2 class="mb-4 text-center fw-bold text-primary"><i class="bi bi-pencil-square"></i> Update All Tests</h2>
  <div class="mb-3 fw-bold text-primary">
    Product: <?= htmlspecialchars($product['product_name']) ?> (ID: <?= htmlspecialchars($product['product_id']) ?>)
  </div>
  <form method="POST" style="max-width:600px;margin:0 auto;">
    <div class="card mb-4">
      <div class="card-header bg-primary text-white fw-bold"><i class="bi bi-lightning-charge"></i> Voltage Test</div>
      <div class="card-body">
        <div class="mb-3">
          <label><input type="checkbox" name="voltage_level" <?= !empty($voltage['voltage_level']) ? 'checked' : '' ?>> Voltage Level is Normal</label>
        </div>
        <div class="mb-3">
          <label><input type="checkbox" name="voltage_stability" <?= !empty($voltage['voltage_stability']) ? 'checked' : '' ?>> Voltage Stability</label>
        </div>
        <div class="mb-3">
          <label><input type="checkbox" name="voltage_spike_protection" <?= !empty($voltage['voltage_spike_protection']) ? 'checked' : '' ?>> Spike Protection Working</label>
        </div>
        <div class="mb-3">
          <label>Status</label>
          <select name="voltage_status" required class="form-select">
            <option value="">Select</option>
            <option value="Pass" <?= (isset($voltage['status']) && $voltage['status']=='Pass') ? 'selected' : '' ?>>Pass</option>
            <option value="Fail" <?= (isset($voltage['status']) && $voltage['status']=='Fail') ? 'selected' : '' ?>>Fail</option>
          </select>
        </div>
        <div class="mb-3">
          <label>Remarks</label>
          <textarea name="voltage_remarks" class="form-control" rows="2"><?= htmlspecialchars($voltage['remarks'] ?? '') ?></textarea>
        </div>
      </div>
    </div>
    <div class="card mb-4">
      <div class="card-header bg-warning text-dark fw-bold"><i class="bi bi-thermometer-half"></i> Heat Test</div>
      <div class="card-body">
        <div class="mb-3">
          <label><input type="checkbox" name="heat_resistance" <?= !empty($heat['heat_resistance']) ? 'checked' : '' ?>> Heat Resistance</label>
        </div>
        <div class="mb-3">
          <label><input type="checkbox" name="temperature_tolerance" <?= !empty($heat['temperature_tolerance']) ? 'checked' : '' ?>> Temperature Tolerance</label>
        </div>
        <div class="mb-3">
          <label><input type="checkbox" name="overheating_protection" <?= !empty($heat['overheating_protection']) ? 'checked' : '' ?>> Overheating Protection</label>
        </div>
        <div class="mb-3">
          <label>Status</label>
          <select name="heat_status" required class="form-select">
            <option value="">Select</option>
            <option value="Pass" <?= (isset($heat['status']) && $heat['status']=='Pass') ? 'selected' : '' ?>>Pass</option>
            <option value="Fail" <?= (isset($heat['status']) && $heat['status']=='Fail') ? 'selected' : '' ?>>Fail</option>
          </select>
        </div>
        <div class="mb-3">
          <label>Remarks</label>
          <textarea name="heat_remarks" class="form-control" rows="2"><?= htmlspecialchars($heat['remarks'] ?? '') ?></textarea>
        </div>
      </div>
    </div>
    <div class="card mb-4">
      <div class="card-header bg-success text-white fw-bold"><i class="bi bi-hourglass-split"></i> Durability Test</div>
      <div class="card-body">
        <div class="mb-3">
          <label><input type="checkbox" name="drop_test" <?= !empty($durability['drop_test']) ? 'checked' : '' ?>> Drop Test</label>
        </div>
        <div class="mb-3">
          <label><input type="checkbox" name="water_resistance" <?= !empty($durability['water_resistance']) ? 'checked' : '' ?>> Water Resistance</label>
        </div>
        <div class="mb-3">
          <label><input type="checkbox" name="material_strength" <?= !empty($durability['material_strength']) ? 'checked' : '' ?>> Material Strength</label>
        </div>
        <div class="mb-3">
          <label>Status</label>
          <select name="durability_status" required class="form-select">
            <option value="">Select</option>
            <option value="Pass" <?= (isset($durability['status']) && $durability['status']=='Pass') ? 'selected' : '' ?>>Pass</option>
            <option value="Fail" <?= (isset($durability['status']) && $durability['status']=='Fail') ? 'selected' : '' ?>>Fail</option>
          </select>
        </div>
        <div class="mb-3">
          <label>Remarks</label>
          <textarea name="durability_remarks" class="form-control" rows="2"><?= htmlspecialchars($durability['remarks'] ?? '') ?></textarea>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-circle"></i> Update All Tests</button>
  </form>
</div>
<?php include '../includes/footer.php'; ?>


<?php
include '../includes/auth_check.php';
include '../includes/db.php';
if ($_SESSION['role'] !== 'manufacturer') {
    header("Location: ../login_manufacturer.php");
    exit();
}

if (isset($_POST['add'])) {
    // Auto generate 10 digit unique product ID
    $product_id = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);

    $name = trim($_POST['product_name']);
    $desc = trim($_POST['description']);
    $code = trim($_POST['product_code']);
    $rev = trim($_POST['revision']);
    $manu = trim($_POST['manufacture_no']);

    $stmt = $pdo->prepare("INSERT INTO products 
        (user_id, product_id, product_name, description, product_code, revision, manufacture_no, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')");

    if ($stmt->execute([$_SESSION['user_id'], $product_id, $name, $desc, $code, $rev, $manu])) {
        $msg = "✅ Product added successfully. <br>Product ID: <b>$product_id</b>";
    } else {
        $error = "❌ Failed to add product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f0f4f8, #cfd9df);
      font-family: 'Segoe UI', 'Roboto', sans-serif;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      padding: 2.5rem;
    }
    .card-title {
      color: #274690;
      font-weight: bold;
      text-align: center;
    }
    .form-label {
      font-weight: 600;
      color: #274690;
    }
    .form-control {
      border-radius: 10px;
      border: 1px solid #ccc;
    }
    .form-control:focus {
      border-color: #274690;
      box-shadow: 0 0 0 0.2rem rgba(39, 70, 144, 0.25);
    }
    .btn-primary {
      background-color: #274690;
      border: none;
      border-radius: 10px;
      font-weight: 600;
    }
    .btn-primary:hover {
      background-color: #1b263b;
    }
    .alert {
      border-radius: 10px;
      font-weight: 500;
      text-align: center;
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/../includes/header_manufacturer.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card">
        <h3 class="card-title mb-4">Add Product</h3>

        <?php if (isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" autocomplete="off">
          <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" name="product_name" id="product_name" required class="form-control" placeholder="e.g. LED Bulb 9W">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" required class="form-control" rows="3" placeholder="Product description..."></textarea>
          </div>
          <div class="mb-3">
            <label for="product_code" class="form-label">Product Code</label>
            <input type="text" name="product_code" id="product_code" required class="form-control" placeholder="e.g. LDB-9W-XP">
          </div>
          <div class="mb-3">
            <label for="revision" class="form-label">Revision</label>
            <input type="text" name="revision" id="revision" required class="form-control" placeholder="e.g. Rev A1">
          </div>
          <div class="mb-3">
            <label for="manufacture_no" class="form-label">Manufacture No</label>
            <input type="text" name="manufacture_no" id="manufacture_no" required class="form-control" placeholder="e.g. MNF202501">
          </div>
          <button type="submit" name="add" class="btn btn-primary w-100">Add Product</button>
        </form>

      </div>
    </div>
  </div>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>

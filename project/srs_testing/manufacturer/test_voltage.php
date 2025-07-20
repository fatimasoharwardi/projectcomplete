<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manufacturer') {
    header("Location: ../login_manufacturer.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Get user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found");
}

// Fetch products that have NOT been tested for voltage
$stmt = $pdo->prepare("
    SELECT p.id, p.product_name
    FROM products p
    WHERE p.user_id = ?
      AND NOT EXISTS (
        SELECT 1 FROM tests t
        WHERE t.product_id = p.id AND t.test_type = 'Voltage'
      )
");
$stmt->execute([$_SESSION['user_id']]);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body {
      background: #f7fafc;
      min-height: 100vh;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .profile-title {
      color: #4a69bd;
      font-weight: 900;
      font-size: 2rem;
      letter-spacing: 1px;
      margin: 2.5rem auto 2rem auto;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.8rem;
    }
    .profile-title .bi {
      font-size: 2.1rem;
      color: #263859;
    }
    .profile-card {
      background: #fff;
      border: 2.5px solid #e3e6f0;
      border-radius: 18px;
      box-shadow: 0 4px 18px 0 rgba(44, 62, 80, 0.10);
      padding: 2.1rem 1.2rem 1.2rem 1.2rem;
      max-width: 480px;
      margin: 0 auto 2.5rem auto;
    }
    .profile-avatar {
      display: flex;
      justify-content: center;
      margin-bottom: 1.2rem;
    }
    .profile-avatar img {
      border-radius: 50%;
      width: 120px;
      height: 120px;
      object-fit: cover;
      border: 4px solid #4a69bd;
      background: #f7fafc;
    }
    .form-label {
      font-weight: 600;
      color: #263859;
    }
    .btn-primary {
      background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
      border: none;
      border-radius: 10px;
      font-weight: 700;
      font-size: 1.08rem;
      padding: 0.7rem 2rem;
      transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
      box-shadow: 0 2px 8px rgba(44,62,80,0.10);
    }
    .btn-primary:hover, .btn-primary:focus {
      background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
      box-shadow: 0 8px 32px rgba(44, 62, 80, 0.18);
      transform: translateY(-2px) scale(1.03);
      color: #fff;
    }
    @media (max-width: 600px) {
      .profile-card {
        padding: 1.2rem 0.5rem;
      }
      .profile-title {
        font-size: 1.2rem;
        padding: 1rem 0.3rem;
      }
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/../includes/header_manufacturer.php'; ?>

<div class="profile-title mb-3">
  <i class="bi bi-person-circle"></i>
  My Profile
</div>

<?php if (isset($_GET['updated'])): ?>
  <div class="alert alert-success text-center" style="max-width:480px;margin:0 auto 1.2rem auto;">Profile updated successfully.</div>
<?php endif; ?>

<form action="update_profile.php" method="POST" enctype="multipart/form-data" class="profile-card shadow-sm">
  <div class="profile-avatar">
    <?php if ($user['profile_pic']): ?>
      <img src="../uploads/<?= htmlspecialchars($user['profile_pic']) ?>" alt="Profile Picture">
    <?php else: ?>
      <img src="../assets/default_user.png" alt="Default">
    <?php endif; ?>
  </div>
  <div class="mb-3">
    <label class="form-label">Profile Picture</label>
    <input type="file" name="profile_pic" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Full Name</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Company Name</label>
    <input type="text" name="company" class="form-control" value="<?= htmlspecialchars($user['company_name']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
  </div>
  <button type="submit" class="btn btn-primary w-100 mt-2">Update Profile</button>
</form>

<!-- Voltage Test Dropdown -->
<div class="container mt-4">
  <label class="form-label" for="productSelect">Select Product for Voltage Test</label>
  <select name="product_id" class="form-select" id="productSelect" required>
    <option value="">Select Product</option>
    <?php foreach ($products as $product): ?>
      <option value="<?= $product['id'] ?>"><?= htmlspecialchars($product['product_name']) ?></option>
    <?php endforeach; ?>
  </select>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
<?php
include 'includes/db.php';
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'manufacturer') {
    header("Location: manufacturer/dashboard.php");
    exit();
}
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'manufacturer'");
    $stmt->execute([$email]);
    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch();
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            header("Location: manufacturer/dashboard.php");
            exit();
        } else {
            $error = "Wrong password.";
        }
    } else {
        $error = "No manufacturer account found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manufacturer Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e3e6f0 0%, #b2bec3 100%);
      min-height: 100vh;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 32px 0 rgba(44, 62, 80, 0.18);
      padding: 2.7rem 2.2rem 2.2rem 2.2rem;
      max-width: 410px;
      width: 100%;
      margin: 0 auto;
      transition: box-shadow 0.3s, transform 0.2s;
      position: relative;
      overflow: hidden;
    }
    .login-card:hover {
      box-shadow: 0 16px 48px 0 rgba(44, 62, 80, 0.22);
      transform: translateY(-2px) scale(1.01);
    }
    .login-title {
      color: #263859;
      font-weight: 800;
      font-size: 2.1rem;
      letter-spacing: 1px;
      margin-bottom: 2rem;
      text-align: center;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.6rem;
    }
    .login-title .bi {
      font-size: 2.1rem;
      color: #4a69bd;
      transition: color 0.2s;
    }
    .login-card:hover .login-title .bi {
      color: #263859;
    }
    label {
      font-weight: 600;
      margin-bottom: 8px;
      color: #263859;
      font-size: 1.07rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
      letter-spacing: 0.2px;
    }
    .icon-input {
      position: relative;
      margin-bottom: 1.2rem;
    }
    .icon-input input {
      padding-left: 2.7rem;
    }
    .icon-input .bi {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #b2bec3;
      font-size: 1.25rem;
      opacity: 0.9;
      pointer-events: none;
      transition: color 0.2s;
    }
    .icon-input input:focus ~ .bi {
      color: #4a69bd;
    }
    .form-control {
      background: #f4f6fb;
      color: #263859;
      border: 1.5px solid #b2bec3;
      border-radius: 10px;
      font-size: 1.09rem;
      padding: 0.9rem 1.1rem;
      transition: box-shadow 0.2s, border-color 0.2s;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .form-control:focus {
      border-color: #4a69bd;
      box-shadow: 0 0 0 2px #4a69bd33;
      background: #e3e6f0;
      color: #263859;
    }
    .btn-primary {
      background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
      border: none;
      border-radius: 10px;
      font-weight: 700;
      padding: 0.95rem;
      font-size: 1.13rem;
      letter-spacing: 0.5px;
      transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
      margin-top: 0.5rem;
      margin-bottom: 0.5rem;
      box-shadow: 0 2px 8px rgba(44,62,80,0.10);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.6rem;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .btn-primary .bi {
      font-size: 1.2rem;
      margin-right: 0.2rem;
      transition: color 0.2s;
    }
    .btn-primary:hover, .btn-primary:focus {
      background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
      box-shadow: 0 8px 32px rgba(44, 62, 80, 0.18);
      transform: translateY(-2px) scale(1.03);
      color: #fff;
    }
    .btn-primary:hover .bi, .btn-primary:focus .bi {
      color: #ffd700;
    }
    .alert-danger {
      border-radius: 10px;
      font-weight: 600;
      padding: 0.8rem 1rem;
      margin-bottom: 1.1rem;
      font-size: 1.05rem;
      text-align: center;
      background: #ffeaea;
      color: #c0392b;
      border: 1.5px solid #c0392b33;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .register-link {
      text-decoration: underline;
      font-weight: 600;
      color: #263859 !important;
      font-size: 1.05rem;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      margin-top: 1.1rem;
      transition: color 0.2s, letter-spacing 0.2s;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .register-link .bi {
      font-size: 1.1rem;
      margin-right: 0.2rem;
      color: #4a69bd;
      transition: color 0.2s;
    }
    .register-link:hover {
      color: #4a69bd !important;
      letter-spacing: 1px;
      text-decoration: underline wavy #4a69bd;
    }
    .register-link:hover .bi {
      color: #263859;
    }
    @media (max-width: 600px) {
      .login-card {
        padding: 1rem;
        max-width: 100%;
      }
      .login-title {
        font-size: 1.3rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-card shadow-lg">
    <div class="card-body">
      <div class="login-title mb-4">
        <i class="bi bi-person-circle"></i>
        Manufacturer Login
      </div>
      <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
      <form method="POST" action="login_manufacturer.php" autocomplete="off">
        <div class="mb-3 icon-input">
          <input type="email" name="email" id="email" required class="form-control" placeholder="Enter your email">
          <i class="bi bi-envelope-at"></i>
          <label for="email" class="visually-hidden">Email</label>
        </div>
        <div class="mb-3 icon-input">
          <input type="password" name="password" id="password" required class="form-control" placeholder="Enter your password">
          <i class="bi bi-lock"></i>
          <label for="password" class="visually-hidden">Password</label>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">
          <i class="bi bi-box-arrow-in-right"></i> Login
        </button>
      </form>
      <div class="text-center">
        <a href="register.php" class="register-link">
          <i class="bi bi-person-plus"></i> Register as Manufacturer
        </a>
      </div>
    </div>
  </div>
</body>
</html>

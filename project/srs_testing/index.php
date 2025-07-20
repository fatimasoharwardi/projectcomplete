<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header("Location: admin/dashboard.php");
    exit();
} elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'manufacturer') {
    header("Location: manufacturer/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SRS Testing Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: linear-gradient(135deg, #e3e6f0 0%, #b2bec3 100%);
      min-height: 100vh;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .welcome-card {
      background: #fff;
      border-radius: 24px;
      box-shadow: 0 10px 32px rgba(44,62,80,0.13);
      padding: 2.7rem 2.2rem 2.2rem 2.2rem;
      max-width: 420px;
      width: 100%;
      margin: 0 auto;
      text-align: center;
      transition: box-shadow 0.3s, transform 0.2s;
      position: relative;
      overflow: hidden;
    }
    .welcome-card:hover {
      box-shadow: 0 18px 48px 0 rgba(44, 62, 80, 0.22);
      transform: translateY(-2px) scale(1.01);
    }
    .welcome-title {
      color: #263859;
      font-weight: 900;
      font-size: 2.2rem;
      letter-spacing: 1px;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.7rem;
    }
    .welcome-title .bi {
      color: #4a69bd;
      font-size: 2.3rem;
    }
    .welcome-desc {
      color: #4a69bd;
      font-size: 1.13rem;
      margin-bottom: 2.2rem;
      font-weight: 500;
      letter-spacing: 0.2px;
    }
    .action-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      font-size: 1.13rem;
      font-weight: 700;
      border-radius: 12px;
      padding: 0.95rem 1.2rem;
      margin: 0.5rem 0;
      width: 100%;
      transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.15s;
      box-shadow: 0 2px 8px rgba(44,62,80,0.08);
      border: none;
      text-decoration: none;
    }
    .action-btn.admin {
      background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
      color: #fff;
    }
    .action-btn.admin:hover, .action-btn.admin:focus {
      background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
      color: #ffd700;
      transform: translateY(-2px) scale(1.03);
    }
    .action-btn.manufacturer {
      background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
      color: #fff;
    }
    .action-btn.manufacturer:hover, .action-btn.manufacturer:focus {
      background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
      color: #ffd700;
      transform: translateY(-2px) scale(1.03);
    }
    .action-btn.register {
      background: #fff;
      color: #263859;
      border: 2px solid #4a69bd;
      font-weight: 800;
    }
    .action-btn.register:hover, .action-btn.register:focus {
      background: #4a69bd;
      color: #fff;
      border-color: #263859;
      transform: translateY(-2px) scale(1.03);
    }
    @media (max-width: 600px) {
      .welcome-card {
        padding: 1.1rem;
        max-width: 100%;
      }
      .welcome-title {
        font-size: 1.3rem;
      }
    }
  </style>
</head>
<body>
  <div class="welcome-card shadow-lg">
    <div class="welcome-title mb-3">
      <i class="bi bi-shield-check"></i>
      SRS Testing Portal
    </div>
    <div class="welcome-desc mb-4">
      Welcome! Please select your login or register as a manufacturer to get started.
    </div>
    <a href="login_admin.php" class="action-btn admin mb-2">
      <i class="bi bi-person-lock"></i> Admin Login
    </a>
    <a href="login_manufacturer.php" class="action-btn manufacturer mb-2">
      <i class="bi bi-person-circle"></i> Manufacturer Login
    </a>
    <a href="register.php" class="action-btn register mb-2">
      <i class="bi bi-person-plus"></i> Register Manufacturer
    </a>
  </div>
</body>
</html>

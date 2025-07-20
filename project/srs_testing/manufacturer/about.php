<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - Manufacturer Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: linear-gradient(135deg, #f7fafc 0%, #e3e6f0 100%);
      min-height: 100vh;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .about-hero {
      background: linear-gradient(90deg, #274690 60%, #4a69bd 100%);
      color: #fff;
      padding: 3rem 1.5rem 2rem 1.5rem;
      border-radius: 18px;
      margin: 2rem auto 2.5rem auto;
      max-width: 900px;
      box-shadow: 0 8px 32px 0 rgba(39,70,144,0.13);
      text-align: center;
    }
    .about-hero h1 {
      font-size: 2.5rem;
      font-weight: 900;
      margin-bottom: 0.7rem;
      letter-spacing: 1px;
    }
    .about-hero p {
      font-size: 1.18rem;
      font-weight: 500;
      margin-bottom: 0.5rem;
    }
    .about-section {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 8px 32px 0 rgba(39,70,144,0.13);
      padding: 2rem 1.2rem;
      margin: 0 auto 2rem auto;
      max-width: 900px;
    }
    .about-section h2 {
      font-size: 1.5rem;
      font-weight: 800;
      color: #274690;
      margin-bottom: 1.2rem;
      letter-spacing: 1px;
    }
    .about-section ul {
      font-size: 1.09rem;
      color: #263859;
      margin-bottom: 1.2rem;
      padding-left: 1.2rem;
    }
    .about-section li {
      margin-bottom: 0.7rem;
    }
    .about-section p {
      font-size: 1.13rem;
      color: #263859;
      margin-bottom: 1.2rem;
      font-weight: 500;
    }
    @media (max-width: 900px) {
      .about-hero, .about-section {
        max-width: 100%;
        padding: 1.2rem 0.5rem;
      }
      .about-hero h1 {
        font-size: 1.5rem;
      }
      .about-section h2 {
        font-size: 1.1rem;
      }
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/../includes/header_manufacturer.php'; ?>

<div class="about-hero">
  <h1><i class="bi bi-info-circle"></i> About Us</h1>
  <p>Welcome to the Manufacturer Panel. Here you can manage your products, track testing, and connect with our support team.</p>
</div>

<div class="about-section">
  <h2>What You Can Do</h2>
  <ul>
    <li><b>Dashboard:</b> Get a quick overview and stats of your products.</li>
    <li><b>Products:</b> Add, view, and manage your submitted products.</li>
    <li><b>Test Results:</b> Track the latest status of product testing.</li>
    <li><b>Profile:</b> Update your company and contact details.</li>
    <li><b>Contact:</b> Reach out for support or queries.</li>
  </ul>
  <p>
    Our goal is to help manufacturers ensure their products meet the highest standards of safety and quality. 
    If you have any questions or need assistance, our support team is here to help.
  </p>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>

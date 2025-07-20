<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include '../includes/db.php';

$success = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO contact_messages (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $name, $email, $subject, $message]);

    $success = "Message sent successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
    body {
        background: #e3eafc;
        min-height: 100vh;
        font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .contact-card {
        max-width: 400px;
        margin: 60px auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 32px 0 rgba(44, 62, 80, 0.13);
        padding: 2.2rem 2rem 1.5rem 2rem;
        text-align: center;
        border: 2px solid #e3e6f0;
    }
    .contact-card .icon {
        font-size: 2.5rem;
        color: #4a69bd;
        margin-bottom: 0.7rem;
    }
    .contact-card h2 {
        font-weight: 800;
        color: #263859;
        margin-bottom: 1.2rem;
        letter-spacing: 1px;
    }
    .form-control {
        border-radius: 8px;
        font-size: 1.05rem;
        margin-bottom: 1rem;
        padding: 0.7rem 1rem;
        background: #f7fafc;
        border: 1.5px solid #e3e6f0;
    }
    .btn-primary {
        background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
        border: none;
        font-weight: 700;
        font-size: 1.08rem;
        border-radius: 8px;
        padding: 0.6rem 0;
        margin-top: 0.7rem;
    }
    .btn-primary:hover, .btn-primary:focus {
        background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
    }
    </style>
</head>
<body>
<?php include_once __DIR__ . '/../includes/header_manufacturer.php'; ?>
<div class="contact-card">
    <span class="icon"><i class="bi bi-chat-dots"></i></span>
    <h2>Contact Us</h2>
    <?php if ($success) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="post">
        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
        <input type="text" name="subject" class="form-control" placeholder="Subject" required>
        <textarea name="message" class="form-control" placeholder="Your Message" required></textarea>
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-send"></i> Send</button>
    </form>
</div>
</body>
</html>

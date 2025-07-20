<?php
session_start();
include '../includes/auth_check.php';
include '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login_admin.php");
    exit();
}

if (!isset($_GET['id'])) die("Message ID missing");
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) die("Message not found");
?>
<?php include '../includes/header.php'; ?>
<style>
body {
  background: linear-gradient(135deg, #f7fafc 0%, #e3e6f0 100%);
  min-height: 100vh;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}
.msg-detail-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.13);
  padding: 2.2rem 2rem 2rem 2rem;
  margin: 2.5rem auto;
  max-width: 600px;
}
.msg-detail-title {
  color: #274690;
  font-weight: 900;
  font-size: 1.6rem;
  letter-spacing: 1px;
  margin-bottom: 1.2rem;
  text-align: center;
  display: flex;
  align-items: center;
  gap: 0.7rem;
}
.msg-detail-label {
  font-weight: 700;
  color: #263859;
  margin-bottom: 0.2rem;
}
.msg-detail-value {
  font-size: 1.09rem;
  color: #263859;
  margin-bottom: 1rem;
  word-break: break-word;
}
</style>
<div class="msg-detail-card">
  <div class="msg-detail-title"><i class="bi bi-envelope"></i> Message Detail</div>
  <div class="msg-detail-label">User ID:</div>
  <div class="msg-detail-value"><?= htmlspecialchars($row['user_id']) ?></div>
  <div class="msg-detail-label">Name:</div>
  <div class="msg-detail-value"><?= htmlspecialchars($row['name']) ?></div>
  <div class="msg-detail-label">Email:</div>
  <div class="msg-detail-value"><?= htmlspecialchars($row['email']) ?></div>
  <div class="msg-detail-label">Subject:</div>
  <div class="msg-detail-value"><?= htmlspecialchars($row['subject']) ?></div>
  <div class="msg-detail-label">Message:</div>
  <div class="msg-detail-value"><?= nl2br(htmlspecialchars($row['message'])) ?></div>
  
</div>
<?php include '../includes/footer.php'; ?>

<?php
session_start();
include '../includes/auth_check.php';
include '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login_admin.php");
    exit();
}

// Fetch all contact messages (no join)
$stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC");
?>
<?php include '../includes/header.php'; ?>
<style>
body {
  background: linear-gradient(135deg, #f7fafc 0%, #e3e6f0 100%);
  min-height: 100vh;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}
.messages-title {
  color: #274690;
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
.messages-table {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.13);
  padding: 2.2rem 1.2rem 1.2rem 1.2rem;
  margin: 0 auto 2.5rem auto;
  max-width: 1100px;
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
.view-btn {
  padding: 0.2rem 0.8rem;
  font-size: 0.95rem;
  border-radius: 8px;
  font-weight: 600;
}
@media (max-width: 1100px) {
  .messages-table {
    padding: 1rem 0.2rem;
    max-width: 100%;
  }
  .table th, .table td {
    font-size: 0.97rem;
  }
}
@media (max-width: 700px) {
  .messages-title {
    font-size: 1.3rem;
  }
  .messages-table {
    padding: 0.5rem 0.1rem;
  }
  .table th, .table td {
    font-size: 0.89rem;
  }
}
</style>
<div class="container-fluid px-0">
  <div class="messages-title mb-4">
    <i class="bi bi-envelope"></i> User Messages
  </div>
  <div class="messages-table">
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle table-hover">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
          
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach ($stmt as $row): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['user_id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['subject']) ?></td>
            <td>
              <?php
                $msg = strip_tags($row['message']);
                if (mb_strlen($msg) > 60) {
                  echo htmlspecialchars(mb_substr($msg, 0, 60)) . '... ';
                  echo '<a href="view_message_detail.php?id=' . $row['id'] . '" class="btn btn-info btn-sm view-btn">View</a>';
                } else {
                  echo nl2br(htmlspecialchars($msg));
                }
              ?>
            </td>
           
            <td>
              <a href="view_message_detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm view-btn">View</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include '../includes/footer.php'; ?>

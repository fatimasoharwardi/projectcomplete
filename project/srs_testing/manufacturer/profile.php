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

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $company_name = $_POST['company_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $website = $_POST['website'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];

    // Handle profile_pic upload
    $profile_pic = $user['profile_pic'];
    if (!empty($_FILES['profile_pic']['name'])) {
        $upload_dir = "../uploads/profile_pics/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_name = uniqid() . "_" . basename($_FILES['profile_pic']['name']);
        $tmp_name = $_FILES['profile_pic']['tmp_name'];
        $dest = $upload_dir . $file_name;
        if (move_uploaded_file($tmp_name, $dest)) {
            $profile_pic = $file_name;
        }
    }

    $sql = "UPDATE users SET name=?, email=?, company_name=?, address=?, phone=?, city=?, country=?, website=?, gender=?, birthday=?, profile_pic=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $name, $email, $company_name, $address, $phone, $city, $country, $website, $gender, $birthday, $profile_pic, $userId
    ]);
    header("Location: profile.php?updated=1");
    exit();
}

// Refresh user data after update
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
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
      background: linear-gradient(135deg, #e3e6f0 0%, #f7fafc 100%);
      min-height: 100vh;
      font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .profile-container {
      display: flex;
      gap: 2.5rem;
      max-width: 1100px;
      margin: 2.5rem auto 2rem auto;
      align-items: flex-start;
    }
    .profile-sidebar {
      width: 30%;
      min-width: 260px;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 4px 18px 0 rgba(44, 62, 80, 0.13);
      padding: 2rem 1.2rem 1.2rem 1.2rem;
      text-align: center;
      position: relative;
      transition: box-shadow 0.2s, transform 0.15s;
    }
    .profile-sidebar:hover {
      box-shadow: 0 8px 32px 0 rgba(44, 62, 80, 0.18);
      transform: translateY(-2px) scale(1.02);
    }
    .profile-avatar img {
      border-radius: 50%;
      width: 120px;
      height: 120px;
      object-fit: cover;
      border: 4px solid #4a69bd;
      background: #f7fafc;
      box-shadow: 0 2px 8px rgba(44,62,80,0.10);
      margin-bottom: 1rem;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .profile-avatar img:hover {
      border-color: #263859;
      box-shadow: 0 6px 24px rgba(44,62,80,0.18);
    }
    .profile-name {
      font-size: 1.35rem;
      font-weight: 800;
      color: #263859;
      margin-bottom: 0.2rem;
      transition: color 0.2s;
    }
    .profile-role {
      font-size: 1.05rem;
      color: #4a69bd;
      font-weight: 600;
      margin-bottom: 1.2rem;
    }
    .profile-contact-list {
      list-style: none;
      padding: 0;
      margin: 1.2rem 0 1.2rem 0;
      text-align: left;
    }
    .profile-contact-list li {
      font-size: 1.05rem;
      color: #263859;
      margin-bottom: 0.7rem;
      display: flex;
      align-items: center;
      gap: 0.7rem;
      transition: color 0.2s;
    }
    .profile-contact-list li:hover {
      color: #4a69bd;
    }
    .profile-sidebar .btn-edit {
      margin-bottom: 1rem;
      width: 100%;
      background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
      border: none;
      font-weight: 700;
      transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
    }
    .profile-sidebar .btn-edit:hover, .profile-sidebar .btn-edit:focus {
      background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
      box-shadow: 0 8px 32px rgba(44, 62, 80, 0.18);
      color: #fff;
      transform: translateY(-2px) scale(1.03);
    }
    .profile-sidebar .btn-logout {
      width: 100%;
      border-radius: 10px;
      font-weight: 700;
      transition: background 0.2s, color 0.2s;
    }
    .profile-sidebar .btn-logout:hover {
      background: #dc3545;
      color: #fff;
    }
    .profile-main {
      width: 70%;
      min-width: 300px;
    }
    .profile-section {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 2px 8px rgba(44,62,80,0.07);
      padding: 1.7rem 1.3rem 1.3rem 1.3rem;
      margin-bottom: 1.5rem;
      transition: box-shadow 0.2s, transform 0.15s;
    }
    .profile-section:hover {
      box-shadow: 0 8px 32px 0 rgba(44, 62, 80, 0.13);
      transform: translateY(-2px) scale(1.01);
    }
    .profile-section h5 {
      font-weight: 700;
      color: #274690;
      margin-bottom: 1.1rem;
      font-size: 1.18rem;
      letter-spacing: 0.5px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .profile-section .row > div {
      margin-bottom: 0.7rem;
    }
    .profile-label {
      font-weight: 600;
      color: #263859;
      font-size: 1.05rem;
    }
    .profile-value {
      color: #4a69bd;
      font-size: 1.05rem;
      font-weight: 500;
      transition: color 0.2s;
    }
    .profile-value:hover {
      color: #263859;
    }
    .profile-actions {
      display: flex;
      gap: 1rem;
      justify-content: flex-end;
      margin-top: 1.5rem;
    }
    .profile-actions .btn {
      border-radius: 10px;
      font-weight: 700;
      transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.15s;
    }
    .profile-actions .btn-primary {
      background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
      border: none;
    }
    .profile-actions .btn-primary:hover, .profile-actions .btn-primary:focus {
      background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
      color: #fff;
      box-shadow: 0 8px 32px rgba(44, 62, 80, 0.18);
      transform: translateY(-2px) scale(1.03);
    }
    .profile-actions .btn-outline-danger:hover {
      background: #dc3545;
      color: #fff;
    }
    @media (max-width: 900px) {
      .profile-container {
        flex-direction: column;
        gap: 1.5rem;
        max-width: 100%;
        padding: 0 0.5rem;
      }
      .profile-sidebar, .profile-main {
        width: 100%;
        min-width: 0;
      }
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/../includes/header_manufacturer.php'; ?>

<?php if (isset($_GET['updated'])): ?>
  <div id="profile-updated-alert" class="alert alert-success text-center" style="max-width:480px;margin:1.2rem auto;">✅ Profile updated successfully!</div>
  <script>
    setTimeout(function() {
      var alertBox = document.getElementById('profile-updated-alert');
      if (alertBox) alertBox.style.display = 'none';

      // Remove `?updated=1` from URL without refreshing
      if (window.history.replaceState) {
        const cleanUrl = window.location.href.split('?')[0];
        window.history.replaceState(null, null, cleanUrl);
      }
    }, 5000);
  </script>
<?php endif; ?>

<div class="profile-container">
  <!-- Sidebar -->
  <div class="profile-sidebar">
    <div class="profile-avatar">
      <?php
        $profile_pic = !empty($user['profile_pic']) ? "../uploads/profile_pics/" . htmlspecialchars($user['profile_pic']) : "../assets/default_user.png";
      ?>
      <img src="<?= $profile_pic ?>" alt="Profile Picture" class="img-thumbnail rounded-circle">
    </div>
    <div class="profile-name"><?= htmlspecialchars($user['name']) ?></div>
    <div class="profile-role"><i class="bi bi-person-badge"></i> <?= ucfirst($user['role']) ?></div>
    <a href="#editProfileModal" data-bs-toggle="modal" class="btn btn-primary btn-edit"><i class="bi bi-pencil"></i> Edit Profile</a>
    <ul class="profile-contact-list">
      <li><i class="bi bi-envelope"></i> <span><?= htmlspecialchars($user['email']) ?></span></li>
      <li><i class="bi bi-telephone"></i> <span><?= htmlspecialchars($user['phone'] ?? '-') ?></span></li>
      <li><i class="bi bi-building"></i> <span><?= htmlspecialchars($user['company_name']) ?></span></li>
      <li><i class="bi bi-geo-alt"></i> <span><?= htmlspecialchars($user['city']) ?></span></li>
    </ul>
    <a href="../logout.php" class="btn btn-outline-danger btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>
  <!-- Main Details -->
  <div class="profile-main">
    <div class="profile-section">
      <h5><i class="bi bi-person-lines-fill"></i> Personal Information</h5>
      <div class="row">
        <div class="col-md-6">
          <span class="profile-label">Full Name:</span>
          <span class="profile-value"><?= htmlspecialchars($user['name']) ?></span>
        </div>
        <div class="col-md-6">
          <span class="profile-label">Gender:</span>
          <span class="profile-value"><?= htmlspecialchars($user['gender']) ?></span>
        </div>
        <div class="col-md-6">
          <span class="profile-label">Date of Birth:</span>
          <span class="profile-value"><?= htmlspecialchars($user['birthday']) ?></span>
        </div>
        <div class="col-md-6">
          <span class="profile-label">Email:</span>
          <span class="profile-value"><?= htmlspecialchars($user['email']) ?></span>
        </div>
        <div class="col-md-6">
          <span class="profile-label">Phone:</span>
          <span class="profile-value"><?= htmlspecialchars($user['phone'] ?? '-') ?></span>
        </div>
        <div class="col-md-6">
          <span class="profile-label">Company Name:</span>
          <span class="profile-value"><?= htmlspecialchars($user['company_name']) ?></span>
        </div>
        <div class="col-md-12">
          <span class="profile-label">Address:</span>
          <span class="profile-value"><?= htmlspecialchars($user['address']) ?></span>
        </div>
      </div>
    </div>
    <div class="profile-section">
      <h5><i class="bi bi-person-vcard"></i> Account Info</h5>
      <div class="row">
        <div class="col-md-6">
          <span class="profile-label">Username:</span>
          <span class="profile-value"><?= htmlspecialchars($user['name']) ?></span>
        </div>
        <div class="col-md-6">
          <span class="profile-label">Registration Date:</span>
          <span class="profile-value"><?= htmlspecialchars($user['created_at']) ?></span>
        </div>
        <div class="col-md-6">
          <span class="profile-label">Account Status:</span>
          <span class="profile-value"><?= isset($user['status']) ? htmlspecialchars(ucfirst($user['status'])) : 'Active' ?></span>
        </div>
        <div class="col-md-6">
          <span class="profile-label">Last Login:</span>
          <span class="profile-value"><?= htmlspecialchars($user['last_login'] ?? '-') ?></span>
        </div>
      </div>
    </div>
    <div class="profile-section">
      <h5><i class="bi bi-file-earmark-image"></i> Uploaded Documents</h5>
      <div>
        <span class="profile-label">Profile Picture:</span>
        <img src="<?= $profile_pic ?>" alt="Profile Picture" class="img-thumbnail rounded-circle" style="width:70px;height:70px;">
      </div>
      <!-- Add more document fields here if needed -->
    </div>
    <div class="profile-actions">
      <a href="#editProfileModal" data-bs-toggle="modal" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit Profile</a>
      <a href="../logout.php" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content profile-edit-modal">
      <form action="profile.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header profile-edit-modal-header">
          <h5 class="modal-title profile-edit-modal-title" id="editProfileModalLabel"><i class="bi bi-pencil"></i> Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body profile-edit-modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control profile-edit-input" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control profile-edit-input" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Company Name</label>
              <input type="text" name="company_name" class="form-control profile-edit-input" value="<?= htmlspecialchars($user['company_name']) ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Address</label>
              <input type="text" name="address" class="form-control profile-edit-input" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" class="form-control profile-edit-input" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">City</label>
              <input type="text" name="city" class="form-control profile-edit-input" value="<?= htmlspecialchars($user['city'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Country</label>
              <input type="text" name="country" class="form-control profile-edit-input" value="<?= htmlspecialchars($user['country'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Website</label>
              <input type="text" name="website" class="form-control profile-edit-input" value="<?= htmlspecialchars($user['website'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Gender</label>
              <select name="gender" class="form-select profile-edit-input">
                <option value="Male" <?= (isset($user['gender']) && $user['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= (isset($user['gender']) && $user['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= (isset($user['gender']) && $user['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Birthday</label>
              <input type="date" name="birthday" class="form-control profile-edit-input" value="<?= htmlspecialchars($user['birthday'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Profile Picture</label>
              <input type="file" name="profile_pic" class="form-control profile-edit-input">
            </div>
          </div>
        </div>
        <div class="modal-footer profile-edit-modal-footer">
          <button type="submit" class="btn btn-primary profile-edit-btn"><i class="bi bi-check-circle"></i> Save Changes</button>
          <button type="button" class="btn btn-secondary profile-edit-cancel" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<style>
/* ...existing code... */
.profile-edit-modal {
  border-radius: 18px;
  box-shadow: 0 8px 32px 0 rgba(44, 62, 80, 0.13);
  border: none;
  background: #f7fafc;
}
.profile-edit-modal-header {
  background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
  color: #fff;
  border-radius: 18px 18px 0 0;
  border-bottom: none;
  padding-top: 1.2rem;
  padding-bottom: 1.2rem;
}
.profile-edit-modal-title {
  font-weight: 800;
  font-size: 1.25rem;
  letter-spacing: 0.5px;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.profile-edit-modal-body {
  background: #f7fafc;
  border-radius: 0 0 18px 18px;
  padding-top: 2rem;
  padding-bottom: 1.5rem;
}
.profile-edit-modal-footer {
  background: #f7fafc;
  border-radius: 0 0 18px 18px;
  border-top: none;
  padding-top: 1rem;
  padding-bottom: 1.2rem;
}
.profile-edit-input {
  background: #f4f6fb;
  color: #263859;
  border: 1.5px solid #b2bec3;
  border-radius: 10px;
  font-size: 1.09rem;
  padding: 0.9rem 1.1rem;
  margin-bottom: 0.7rem;
  transition: box-shadow 0.2s, border-color 0.2s;
}
.profile-edit-input:focus {
  border-color: #4a69bd;
  box-shadow: 0 0 0 2px #4a69bd33;
  background: #e3e6f0;
  color: #263859;
}
.profile-edit-btn {
  background: linear-gradient(90deg, #263859 60%, #4a69bd 100%);
  border: none;
  border-radius: 10px;
  font-weight: 700;
  font-size: 1.09rem;
  padding: 0.85rem 2rem;
  transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
  box-shadow: 0 2px 8px rgba(44,62,80,0.10);
  display: flex;
  align-items: center;
  gap: 0.6rem;
}
.profile-edit-btn:hover, .profile-edit-btn:focus {
  background: linear-gradient(90deg, #4a69bd 60%, #263859 100%);
  color: #fff;
  box-shadow: 0 8px 32px rgba(44, 62, 80, 0.18);
  transform: translateY(-2px) scale(1.03);
}
.profile-edit-cancel {
  border-radius: 10px;
  font-weight: 700;
  font-size: 1.09rem;
  padding: 0.85rem 2rem;
  transition: background 0.2s, color 0.2s;
}
.profile-edit-cancel:hover {
  background: #e3e6f0;
  color: #263859;
}
@media (max-width: 900px) {
  .modal-dialog {
    max-width: 98vw;
  }
}
</style>

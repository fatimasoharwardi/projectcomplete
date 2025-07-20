<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manufacturer') {
    header("Location: ../login_manufacturer.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch current user data for password fallback
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect all fields
    $name = $_POST['name'];
    $email = $_POST['email'];
    $company_name = $_POST['company_name'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $website = $_POST['website'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $role = $_POST['role'];
    $created_at = $_POST['created_at'];
    $profile_pic_text = $_POST['profile_pic_text'];
    $profile_picture = $_POST['profile_picture'];
    $password = $_POST['password'];

    // Handle profile_pic upload
    $profile_pic = $user['profile_pic'];
    if (!empty($_FILES['profile_pic']['name'])) {
        $upload_dir = "../uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_name = uniqid() . "_" . basename($_FILES['profile_pic']['name']);
        $tmp_name = $_FILES['profile_pic']['tmp_name'];
        $dest = $upload_dir . $file_name;
        if (move_uploaded_file($tmp_name, $dest)) {
            $profile_pic = $file_name;
        }
    } elseif (!empty($profile_pic_text)) {
        $profile_pic = $profile_pic_text;
    }

    // Password update logic
    if ($password !== $user['password']) {
        // If password changed, hash it
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $password_hashed = $user['password'];
    }

    // Update query
    $sql = "UPDATE users SET 
        name=?, email=?, company_name=?, address=?, phone_number=?, phone=?, city=?, country=?, website=?, gender=?, birthday=?, role=?, created_at=?, profile_pic=?, profile_picture=?, password=?
        WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $name, $email, $company_name, $address, $phone_number, $phone, $city, $country, $website, $gender, $birthday, $role, $created_at, $profile_pic, $profile_picture, $password_hashed, $userId
    ]);

    header("Location: profile.php?updated=1");
    exit();
}
?>

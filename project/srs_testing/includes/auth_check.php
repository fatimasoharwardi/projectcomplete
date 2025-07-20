<?php
// auth_check.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Check role match if page is inside role folder
$currentFolder = basename(dirname($_SERVER['PHP_SELF']));
$expectedRole = ($currentFolder === 'admin') ? 'admin' : 'manufacturer';

if ($_SESSION['role'] !== $expectedRole) {
    echo "Access denied!";
    exit();
}
?>
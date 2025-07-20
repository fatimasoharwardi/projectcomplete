<?php
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>SRS Testing System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
/* Removed global body styling to avoid clash with page backgrounds */
/* Use .srs-body for dark mode if needed */
.srs-body {
  background: #0d1b2a;
  color: #f8f9fa;
}
.srs-sidebar {
  min-height: 100vh;
  background: #1b263b;
  color: #f8f9fa;
  padding-top: 30px;
  position: fixed;
  left: 0;
  top: 0;
  width: 220px;
  z-index: 1000;
}
.srs-sidebar-link {
  color: #f8f9fa;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  padding: 10px 20px;
  margin-bottom: 5px;
  border-radius: 4px;
  font-size: 1.08rem;
  font-weight: 500;
  transition: background 0.2s, color 0.2s;
}
.srs-sidebar-link i {
  font-size: 1.2rem;
  color: #4a69bd;
  transition: color 0.2s;
}
.srs-sidebar-link.active, .srs-sidebar-link:hover {
  background: #274690;
  color: #fff;
}
.srs-sidebar-link.active i, .srs-sidebar-link:hover i {
  color: #fff;
}
.srs-main-content {
  margin-left: 230px;
  padding: 20px;
}
</style>
</head>
 
   
    </div>
  </div>
</nav>
<div class="srs-sidebar">
  <h4 class="mb-4 text-center">Admin Panel</h4>
  <a href="/project/srs_testing/admin/dashboard.php" class="srs-sidebar-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
  <a href="/project/srs_testing/admin/manage_users.php" class="srs-sidebar-link"><i class="bi bi-people"></i> Manage Users</a>
  <a href="/project/srs_testing/admin/view_all_products.php" class="srs-sidebar-link"><i class="bi bi-box-seam"></i> View All Products</a>
  <a href="/project/srs_testing/admin/view_pending.php" class="srs-sidebar-link"><i class="bi bi-hourglass-split"></i> Pending Products</a>
  <a href="/project/srs_testing/admin/view_results.php" class="srs-sidebar-link"><i class="bi bi-clipboard-data"></i> Test Results</a>
  <a href="/project/srs_testing/admin/search.php" class="srs-sidebar-link"><i class="bi bi-search"></i> Search & Filter</a>
  <a href="/project/srs_testing/admin/view_messages.php" class="srs-sidebar-link"><i class="bi bi-envelope"></i> View Messages</a>
  <a href="/project/srs_testing/logout.php" class="srs-sidebar-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>
<div class="srs-main-content">
  <!-- Page content starts here -->

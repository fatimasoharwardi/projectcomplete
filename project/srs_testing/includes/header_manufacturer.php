<?php if (!isset($_SESSION)) session_start(); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<nav class="navbar navbar-expand-lg navbar-dark" style="background: #274690;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/project/srs_testing/manufacturer/dashboard.php">
      <i class="bi bi-building"></i> Manufacturer Panel
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><i class="bi bi-person-circle"></i> Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/project/srs_testing/manufacturer/dashboard.php">
              <i class="bi bi-house-door"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/project/srs_testing/manufacturer/add_product.php">
              <i class="bi bi-plus-square"></i> Add Product
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/project/srs_testing/manufacturer/view_products.php">
              <i class="bi bi-box-seam"></i> View Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/project/srs_testing/manufacturer/profile.php">
              <i class="bi bi-person-circle"></i> Profile
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/project/srs_testing/manufacturer/contact.php">
              <i class="bi bi-chat-dots"></i> Contact Us
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/project/srs_testing/manufacturer/about.php">
              <i class="bi bi-info-circle"></i> About
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger fw-bold" href="/project/srs_testing/logout.php">
              <i class="bi bi-box-arrow-right"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
.navbar {
  box-shadow: 0 2px 8px rgba(39,70,144,0.08);
  font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
}
.navbar-brand {
  font-weight: 700;
  font-size: 1.3rem;
  letter-spacing: 1px;
}
.nav-link {
  font-weight: 500;
  font-size: 1.05rem;
  margin-left: 1rem;
  color: #f6f8fc !important;
  transition: color 0.2s;
  display: flex;
  align-items: center;
  gap: 6px;
}
.nav-link:hover, .nav-link.active {
  color: #ffd700 !important;
  text-decoration: underline;
}
.text-danger {
  color: #dc3545 !important;
}
.fw-bold {
  font-weight: 700 !important;
}
@media (max-width: 991.98px) {
  .navbar-nav .nav-link {
    margin-left: 0;
    margin-bottom: 10px;
  }
}
</style>

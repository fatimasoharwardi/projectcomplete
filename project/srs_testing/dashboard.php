<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manufacturer Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Manufacturer Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="#why">Why Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="py-5 text-center bg-white">
        <div class="container">
            <h1 class="display-4 mb-3">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
            <p class="lead mb-4">Your trusted partner in quality manufacturing solutions.</p>
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80" alt="Manufacturing" class="img-fluid rounded shadow" style="max-width: 500px;">
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <h2 class="mb-4 text-center">About Us</h2>
            <p class="text-center">We are a leading manufacturer with years of experience delivering high-quality products to clients worldwide. Our mission is to innovate and provide reliable solutions for all your manufacturing needs.</p>
        </div>
    </section>

    <!-- Our Products Section -->
    <section id="products" class="py-5 bg-white">
        <div class="container">
            <h2 class="mb-4 text-center">Our Products</h2>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=400&q=80" class="card-img-top" alt="Product 1">
                        <div class="card-body">
                            <h5 class="card-title">Product A</h5>
                            <p class="card-text">High-quality industrial component for modern manufacturing.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80" class="card-img-top" alt="Product 2">
                        <div class="card-body">
                            <h5 class="card-title">Product B</h5>
                            <p class="card-text">Reliable and efficient machinery for your production line.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1508921912186-1d1a45ebb3c1?auto=format&fit=crop&w=400&q=80" class="card-img-top" alt="Product 3">
                        <div class="card-body">
                            <h5 class="card-title">Product C</h5>
                            <p class="card-text">Custom solutions tailored to your manufacturing requirements.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="why" class="py-5 bg-light">
        <div class="container">
            <h2 class="mb-4 text-center">Why Choose Us?</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <div class="p-3 border rounded bg-white h-100">
                        <h5>Quality Assurance</h5>
                        <p>We maintain the highest standards in every product we deliver.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 border rounded bg-white h-100">
                        <h5>Expert Team</h5>
                        <p>Our experienced professionals are dedicated to your success.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 border rounded bg-white h-100">
                        <h5>Customer Support</h5>
                        <p>We provide 24/7 support to ensure your satisfaction.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-white">
        <div class="container">
            <h2 class="mb-4 text-center">Contact Us</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Your Name</label>
                            <input type="text" class="form-control" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="4" placeholder="Your message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3 mt-5">
        &copy; <?php echo date('Y'); ?> Manufacturer Portal. All rights reserved.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
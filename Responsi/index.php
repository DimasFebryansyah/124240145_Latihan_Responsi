<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Skillora - Layanan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .hero-section {
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        color: white;
        padding: 5rem 0;
        margin-bottom: 3rem;
        border-radius: 0 0 20px 20px;
    }

    .feature-card {
        transition: transform 0.3s;
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #6e8efb;
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Skillora</a>
            <div class="ml-auto">
                <?php if (isset($_SESSION["user_id"])) : ?>
                <?php if ($_SESSION["role"] == "admin") : ?>
                <a href="admin_dashboard.php" class="btn btn-light me-2"><i class="fas fa-tachometer-alt"></i> Admin</a>
                <?php endif; ?>
                <a href="dashboard.php" class="btn btn-light me-2"><i class="fas fa-th-large"></i> Dashboard</a>
                <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <?php else : ?>
                <a href="login.php" class="btn btn-light me-2"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="register.php" class="btn btn-success"><i class="fas fa-user-plus"></i> Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Selamat datang di Skillora</h1>
            <p class="lead">Pesan layanan digital terbaik dari para profesional.</p>
            <?php if (!isset($_SESSION["user_id"])) : ?>
            <a href="register.php" class="btn btn-light btn-lg mt-3"><i class="fas fa-rocket"></i> Mulai Sekarang</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container my-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card feature-card h-100 p-4">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>Cepat</h3>
                    <p>Proses pesanan cepat dan efisien</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card h-100 p-4">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Aman</h3>
                    <p>Transaksi aman dan terjamin</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card h-100 p-4">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Berkualitas</h3>
                    <p>Layanan dari profesional terbaik</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2023 Skillora. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
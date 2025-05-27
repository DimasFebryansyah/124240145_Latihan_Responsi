<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM services";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Dashboard - Skillora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .service-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .service-img {
        height: 180px;
        object-fit: cover;
    }

    .user-greeting {
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Skillora</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my_orders.php"><i class="fas fa-history"></i> Riwayat Pesanan</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="user-greeting">
            <h2>Halo, <?= isset($_SESSION["name"]) ? $_SESSION["name"] : 'Pengguna' ?>!</h2>
            <p class="mb-0">Temukan layanan digital terbaik untuk kebutuhan Anda</p>
        </div>

        <h3 class="mb-4">Daftar Layanan Tersedia</h3>
        <div class="row">
            <?php while ($service = mysqli_fetch_assoc($result)) : ?>
            <div class="col-md-4">
                <div class="card service-card h-100">
                    <img src="https://source.unsplash.com/random/300x200/?<?= urlencode($service['category']) ?>"
                        class="card-img-top service-img" alt="<?= $service["name"] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $service["name"] ?></h5>
                        <span class="badge bg-primary mb-2"><?= $service["category"] ?></span>
                        <h5 class="text-success">Rp<?= number_format($service["price"], 0, ',', '.') ?></h5>
                        <p class="card-text text-muted">
                            <?= substr($service["description"] ?? 'Layanan profesional berkualitas', 0, 100) ?>...</p>
                        <a href="order.php?id=<?= $service["id"] ?>" class="btn btn-primary w-100"><i
                                class="fas fa-shopping-cart"></i> Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
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
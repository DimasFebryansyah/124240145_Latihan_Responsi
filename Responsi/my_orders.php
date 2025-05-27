<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT orders.id, services.name, services.price, orders.notes, orders.order_date 
        FROM orders 
        JOIN services ON orders.service_id = services.id 
        WHERE orders.user_id = '$user_id' ORDER BY orders.order_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>My Orders - Skillora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .order-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        transition: transform 0.3s;
    }

    .order-card:hover {
        transform: translateY(-5px);
    }

    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
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
                        <a class="nav-link" href="dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="my_orders.php"><i class="fas fa-history"></i> Riwayat
                            Pesanan</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-history"></i> Riwayat Pemesanan</h2>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>

        <?php if (mysqli_num_rows($result) > 0) : ?>
        <div class="row">
            <?php while ($order = mysqli_fetch_assoc($result)) : ?>
            <div class="col-md-6">
                <div class="card order-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0"><?= $order["name"] ?></h5>
                            <span class="badge bg-primary">Rp<?= number_format($order["price"], 0, ',', '.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted"><?= date('d M Y H:i', strtotime($order["order_date"])) ?></small>
                            <span class="status-badge status-<?= strtolower($order["status"] ?? 'pending') ?>">
                                <?= strtoupper($order["status"] ?? 'PENDING') ?>
                            </span>
                        </div>
                        <p class="card-text"><strong>Catatan:</strong> <?= $order["notes"] ?? '-' ?></p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else : ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <h4>Anda belum memiliki pesanan</h4>
            <p>Silahkan pesan layanan terlebih dahulu</p>
            <a href="dashboard.php" class="btn btn-primary">Lihat Layanan</a>
        </div>
        <?php endif; ?>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2023 Skillora. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
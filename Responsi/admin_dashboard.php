<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit;
}

$sql_services = "SELECT COUNT(*) AS total_services FROM services";
$sql_orders = "SELECT COUNT(*) AS total_orders FROM orders";
$sql_users = "SELECT COUNT(*) AS total_users FROM users WHERE role='user'";

$result_services = mysqli_query($conn, $sql_services);
$result_orders = mysqli_query($conn, $sql_orders);
$result_users = mysqli_query($conn, $sql_users);

$total_services = mysqli_fetch_assoc($result_services)["total_services"];
$total_orders = mysqli_fetch_assoc($result_orders)["total_orders"];
$total_users = mysqli_fetch_assoc($result_users)["total_users"];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Admin Dashboard - Skillora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .stat-card {
        border: none;
        border-radius: 15px;
        color: white;
        padding: 1.5rem;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }

    .admin-sidebar {
        background: #343a40;
        min-height: 100vh;
        color: white;
    }

    .admin-sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .admin-sidebar .nav-link:hover,
    .admin-sidebar .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .admin-sidebar .nav-link i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 admin-sidebar p-0">
                <div class="p-3">
                    <h4 class="text-center mb-4">Admin Panel</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i>
                                Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_services.php"><i class="fas fa-concierge-bell"></i> Kelola
                                Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-users"></i> Kelola Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_orders.php"><i class="fas fa-clipboard-list"></i> Kelola
                                Pesanan</a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i>
                                Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h2>
                    <div class="text-muted">Selamat datang, <?= $_SESSION["name"] ?? 'Admin' ?></div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-card bg-primary">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3><?= $total_services ?></h3>
                                    <p class="mb-0">Total Layanan</p>
                                </div>
                                <i class="fas fa-concierge-bell stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card bg-success">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3><?= $total_orders ?></h3>
                                    <p class="mb-0">Total Pesanan</p>
                                </div>
                                <i class="fas fa-shopping-cart stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card bg-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3><?= $total_users ?></h3>
                                    <p class="mb-0">Total Pengguna</p>
                                </div>
                                <i class="fas fa-users stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-chart-line"></i> Ringkasan Aktivitas
                    </div>
                    <div class="card-body">
                        <p>Grafik dan statistik akan ditampilkan di sini.</p>
                        <a href="admin_services.php" class="btn btn-primary"><i class="fas fa-concierge-bell"></i>
                            Kelola Layanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
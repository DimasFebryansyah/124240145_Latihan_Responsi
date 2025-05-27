<?php
session_start();
include "config.php";

// Check admin authentication
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit;
}

// Handle order status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_status"])) {
    $order_id = $_POST["order_id"];
    
    
    mysqli_query($conn, "UPDATE orders SET status='$new_status' WHERE id=$order_id");
    $_SESSION['message'] = "Status pesanan berhasil diperbarui!";
    header("Location: admin_orders.php");
    exit;
}

// Get all orders with user and service information
$orders = mysqli_query($conn, "
    SELECT orders.*, users.name as user_name, services.name as service_name, services.price 
    FROM orders 
    JOIN users ON orders.user_id = users.id 
    JOIN services ON orders.service_id = services.id 
    ORDER BY orders.order_date DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelola Pesanan - Skillora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    :root {
        --primary: #4e73df;
        --secondary: #f8f9fc;
        --success: #1cc88a;
        --warning: #f6c23e;
        --danger: #e74a3b;
    }

    body {
        background: var(--secondary);
    }

    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .badge-pending {
        background: var(--warning);
        color: #000;
    }

    .badge-completed {
        background: var(--success);
        color: #fff;
    }

    .badge-cancelled {
        background: var(--danger);
        color: #fff;
    }

    .status-select {
        border-radius: 20px;
        padding: 5px 10px;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">
                <i class="fas fa-cog me-2"></i>Admin Panel
            </a>
            <div class="d-flex">
                <a href="admin_services.php" class="btn btn-light me-2">
                    <i class="fas fa-concierge-bell me-1"></i> Layanan
                </a>
                <a href="logout.php" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Success Message -->
        <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Daftar Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = mysqli_fetch_assoc($orders)) : ?>
                            <tr>
                                <td>#<?= $order['id'] ?></td>
                                <td><?= $order['user_name'] ?></td>
                                <td><?= $order['service_name'] ?></td>
                                <td>Rp<?= number_format($order['price'], 0, ',', '.') ?></td>
                                <td><?= date('d M Y', strtotime($order['order_date'])) ?></td>
                                <td>
                                    <form method="POST" class="d-flex">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <select name="status" class="form-select form-select-sm status-select" style="background: <?= 
                                                $order['status'] == 'completed' ? 'var(--success)' : 
                                                ($order['status'] == 'cancelled' ? 'var(--danger)' : 'var(--warning)') 
                                            ?>; color: <?= 
                                                $order['status'] == 'pending' ? '#000' : '#fff' 
                                            ?>;" onchange="this.form.submit()">
                                            <option value="pending"
                                                <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="completed"
                                                <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed
                                            </option>
                                            <option value="cancelled"
                                                <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled
                                            </option>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                </td>
                                <td><?= $order['notes'] ?: '-' ?></td>
                                <td>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?= $order['id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $order['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus pesanan ini?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <a href="admin_orders.php?delete=<?= $order['id'] ?>"
                                                        class="btn btn-danger">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Update select color when changed
    document.querySelectorAll('select[name="status"]').forEach(select => {
        select.addEventListener('change', function() {
            if (this.value === 'completed') {
                this.style.background = 'var(--success)';
                this.style.color = '#fff';
            } else if (this.value === 'cancelled') {
                this.style.background = 'var(--danger)';
                this.style.color = '#fff';
            } else {
                this.style.background = 'var(--warning)';
                this.style.color = '#000';
            }
        });
    });
    </script>
</body>

</html>
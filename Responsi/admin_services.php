<?php
session_start();
include "config.php";

// Check admin authentication
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Handle service deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM services WHERE id=$id");
    $_SESSION['message'] = "Service deleted successfully!";
    header("Location: admin_services.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    
    if (isset($_POST['edit_id'])) {
        // Update existing service
        $id = $_POST['edit_id'];
        mysqli_query($conn, "UPDATE services SET name='$name', category='$category', price='$price', description='$description' WHERE id=$id");
        $_SESSION['message'] = "Service updated successfully!";
    } else {
        // Add new service
        mysqli_query($conn, "INSERT INTO services (name, category, price, description) VALUES ('$name', '$category', '$price', '$description')");
        $_SESSION['message'] = "Service added successfully!";
    }
    header("Location: admin_services.php");
    exit;
}

// Get all services
$services = mysqli_query($conn, "SELECT * FROM services");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kelola Layanan - Skillora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    :root {
        --primary: #4e73df;
        --secondary: #f8f9fc;
        --danger: #e74a3b;
    }

    body {
        background: var(--secondary);
    }

    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background: var(--primary);
        border: none;
    }

    .btn-danger {
        background: var(--danger);
        border: none;
    }

    .table th {
        background: var(--primary);
        color: white;
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
            <a href="logout.php" class="btn btn-danger">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
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

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i><?= isset($_GET['edit']) ? 'Edit' : 'Tambah' ?>
                    Layanan</h5>
            </div>
            <div class="card-body">
                <?php
                $edit_service = null;
                if (isset($_GET['edit'])) {
                    $edit_id = $_GET['edit'];
                    $edit_service = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM services WHERE id=$edit_id"));
                }
                ?>
                <form method="POST">
                    <input type="hidden" name="edit_id" value="<?= $edit_service['id'] ?? '' ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama Layanan</label>
                        <input type="text" name="name" class="form-control" value="<?= $edit_service['name'] ?? '' ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" class="form-control"
                            value="<?= $edit_service['category'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="price" class="form-control"
                            value="<?= $edit_service['price'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control"
                            rows="3"><?= $edit_service['description'] ?? '' ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                    <?php if (isset($_GET['edit'])) : ?>
                    <a href="admin_services.php" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Layanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($service = mysqli_fetch_assoc($services)) : ?>
                            <tr>
                                <td><?= $service['name'] ?></td>
                                <td><?= $service['category'] ?></td>
                                <td>Rp<?= number_format($service['price'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="admin_services.php?edit=<?= $service['id'] ?>"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="admin_services.php?delete=<?= $service['id'] ?>"
                                        class="btn btn-sm btn-danger" onclick="return confirm('Hapus layanan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
</body>

</html>
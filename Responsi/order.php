<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id_service = $_GET["id"];
$sql = "SELECT * FROM services WHERE id='$id_service'";
$result = mysqli_query($conn, $sql);
$service = mysqli_fetch_assoc($result);

if (!$service) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $notes = $_POST["notes"];
    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO orders (user_id, service_id, notes, order_date) VALUES ('$user_id', '$id_service', '$notes', NOW())";
if (mysqli_query($conn, $sql)) {
    $_SESSION["order_success"] = true;
    header("Location: my_orders.php");
    exit;
} else {
    $error = "Terjadi kesalahan saat memproses pesanan: " . mysqli_error($conn);
}

}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Pesan Layanan - Skillora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .order-container {
        max-width: 600px;
        margin: 3rem auto;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .service-info {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Skillora</a>
            <a href="dashboard.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </nav>

    <div class="container">
        <div class="order-container bg-white">
            <h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Pesan Layanan</h2>

            <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <div class="service-info">
                <h4><?= $service["name"] ?></h4>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-primary"><?= $service["category"] ?></span>
                    <h5 class="text-success mb-0">Rp<?= number_format($service["price"], 0, ',', '.') ?></h5>
                </div>
                <p class="mt-2"><?= $service["description"] ?? 'Layanan profesional berkualitas' ?></p>
            </div>

            <form method="POST">
                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan Tambahan</label>
                    <textarea name="notes" id="notes" class="form-control"
                        placeholder="Masukkan catatan tambahan untuk layanan ini (opsional)" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100 py-2"><i class="fas fa-check-circle"></i> Konfirmasi
                    Pesanan</button>
            </form>
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
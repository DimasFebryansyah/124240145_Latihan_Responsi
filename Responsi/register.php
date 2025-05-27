<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $role = "user";

    $checkEmail = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($checkEmail) > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION["registration_success"] = true;
            header("Location: login.php");
            exit;
        } else {
            $error = "Terjadi kesalahan saat mendaftar: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Register - Skillora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .register-container {
        max-width: 600px;
        margin: 5rem auto;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .register-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .register-icon {
        font-size: 3rem;
        color: #6e8efb;
        margin-bottom: 1rem;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Skillora</a>
            <a href="login.php" class="btn btn-light"><i class="fas fa-sign-in-alt"></i> Login</a>
        </div>
    </nav>

    <div class="container">
        <div class="register-container bg-white">
            <div class="register-header">
                <div class="register-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2>Buat Akun Baru</h2>
                <p class="text-muted">Isi form berikut untuk mendaftar</p>
            </div>

            <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap"
                            required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100 py-2"><i class="fas fa-user-plus"></i>
                    Daftar</button>
            </form>

            <div class="text-center mt-3">
                <p>Sudah punya akun? <a href="login.php">Login sekarang</a></p>
                <p><a href="index.php">Kembali ke beranda</a></p>
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
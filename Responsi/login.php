<?php
session_start();
include "config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    if ($email === "admin@admin.com" && $password === "admin123") {
        $_SESSION["user_id"] = "admin"; $_SESSION["role"] = "admin"; $_SESSION["name"] = "Administrator";
        header("Location: admin_dashboard.php"); exit;
    }
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"]; $_SESSION["role"] = $user["role"]; $_SESSION["name"] = $user["name"];
        header("Location: dashboard.php"); exit;
    } else { $error = "Email atau password salah!"; }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Login - Skillora</title>
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
        font-family: 'Segoe UI';
    }

    .login-container {
        max-width: 500px;
        margin: 2rem auto;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .nav-pills .nav-link {
        border-radius: 30px;
        margin: 0 5px;
    }

    .nav-pills .nav-link.active {
        background: var(--primary);
    }

    .form-control {
        padding: 12px 15px;
        margin-bottom: 1rem;
    }

    .btn-login {
        background: var(--primary);
        padding: 12px;
        width: 100%;
    }

    .btn-admin {
        background: var(--danger);
    }

    .input-group-text {
        background: var(--primary);
        color: white;
    }

    @media (max-width: 576px) {
        .login-container {
            margin: 1rem;
            padding: 1.5rem;
        }
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-rocket me-2"></i>Skillora</a>
            <a href="register.php" class="btn btn-light"><i class="fas fa-user-plus me-1"></i> Daftar</a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="login-container">
            <div class="text-center mb-4">
                <i class="fas fa-sign-in-alt fa-3x text-primary mb-2"></i>
                <h2>Masuk ke Akun Anda</h2>
            </div>

            <ul class="nav nav-pills justify-content-center mb-4">
                <li class="nav-item"><a class="nav-link active" onclick="showLogin('user')"><i
                            class="fas fa-user me-1"></i> User</a></li>
                <li class="nav-item"><a class="nav-link" onclick="showLogin('admin')"><i class="fas fa-lock me-1"></i>
                        Admin</a></li>
            </ul>

            <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <div id="user-login">
                <form method="POST">
                    <div class="input-group mb-3"><span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="input-group mb-3"><span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-login mb-3"><i class="fas fa-sign-in-alt me-2"></i>
                        Login</button>
                </form>
                <div class="text-center"><a href="register.php">Buat Akun Baru</a></div>
            </div>

            <div id="admin-login" style="display:none">
                <form method="POST">
                    <div class="input-group mb-3"><span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="text" name="email" class="form-control" value="admin@admin.com" readonly>
                    </div>
                    <div class="input-group mb-3"><span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Password Admin"
                            required>
                    </div>
                    <button type="submit" class="btn btn-danger btn-login btn-admin mb-3"><i
                            class="fas fa-lock me-2"></i> Login Admin</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function showLogin(type) {
        document.getElementById("user-login").style.display = type === "user" ? "block" : "none";
        document.getElementById("admin-login").style.display = type === "admin" ? "block" : "none";
        document.querySelectorAll(".nav-link").forEach(link => link.classList.remove("active"));
        event.target.classList.add("active");
    }
    </script>
</body>

</html>
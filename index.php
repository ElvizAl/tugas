<?php
session_start();
include 'db/koneksi.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['kata_sandi'])) {
            $_SESSION['id_pengguna'] = $user['id_pengguna'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['email'] = $user['email'];

            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil',
                        text: 'Selamat datang, " . addslashes($user['nama_lengkap']) . "!',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'dashboard.php';
                    });
                });
            </script>";
            exit;
        } else {
            $error = "Email atau password salah!";
        }
    } else {
        $error = "Harap isi email dan password!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login</title>
<link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css" />
<link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet" />
<link rel="stylesheet" href="./assets/libs/css/style.css" />
<link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css" />
<style>
    html, body { height: 100%; }
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="splash-container">
    <div class="card">
        <div class="card-header text-center">
            <a href="dashboard.php"><img class="logo-img" src="./assets/images/gym.png" alt="logo" width=150px></a>
            <span class="splash-description">Masukkan informasi pengguna Anda.</span>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: '<?= addslashes($error) ?>',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                });
            </script>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <input class="form-control form-control-lg" type="email" name="email" placeholder="Email" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="password" name="password" placeholder="Kata Sandi" required>
                </div>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="remember"><span class="custom-control-label">Ingat Saya</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Masuk</button>
            </form>
        </div>
        <div class="card-footer bg-white p-0">
            <div class="card-footer-item card-footer-item-bordered">
                <a href="register.php" class="footer-link">Buat Akun Baru</a>
            </div>
            <div class="card-footer-item card-footer-item-bordered">
                <a href="#" class="footer-link">Lupa Kata Sandi?</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

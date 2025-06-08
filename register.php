<?php
    session_start();
    include("koneksi.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <form class="splash-container" action="simpan-register.php" method="POST">
        <?php include("errors.php"); ?>
        <?php if (isset($_SESSION["error"])) : ?>
            <div class="error">
                <h3>
                    <?php
                        echo $_SESSION["error"];
                        unset($_SESSION[$error]);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Pendaftaran Akun</h3>
                <p>Tolong Masukkin Informasi Pengguna.</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>nama</label>
                    <input class="form-control form-control-lg" type="text" name="name" id="name" placeholder="Username"
                        autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control form-control-lg" type="email" name="email" id="email"
                        placeholder="E-mail" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control form-control-lg" id="password" type="password" name="password"
                        placeholder="Password">
                </div>
                <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary" name="reg_user" type="submit">Daftar</button>
                </div>
            </div>
            <div class="card-footer bg-white">
                <p>Sudah Punya Akun? <a href="/yuhu/login.php" class="text-secondary">Login Disini.</a></p>
            </div>
        </div>
    </form>
    <script src="../assets/libs/js/jquery-3.7.1.js"></script>
    <script src="../assets/libs/js/sweetalert2.all.min.js"></script>
</body>

</html>
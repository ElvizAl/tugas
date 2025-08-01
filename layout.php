<?php
session_start();
require 'db/koneksi.php'; // koneksi database

// Pastikan user sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: index.php");
    exit;
}

$id_pengguna = $_SESSION['id_pengguna'];

// Ambil data user dari database dengan PDO
$stmt = $pdo->prepare("SELECT * FROM pengguna WHERE id_pengguna = :id");
$stmt->execute(['id' => $id_pengguna]);
$user = $stmt->fetch();

if (!$user) {
    // User tidak ditemukan, logout
    header("Location: logout.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css">

    <title>Dashboard - Gym Management System</title>

    <style>
        /* Menambahkan kelas aktif pada link */
        .nav-link.active {
            background-color:rgb(0, 0, 0);
            color: white;
        }

        .navbar-brand {
            color: black;
        }
        .dashboard-header .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            box-shadow: 0 2px 4px rgba(28, 2, 59, 0.69);
        }

        .nav-left-sidebar {
  width: 250px;
  height: calc(100vh - 70px); /* Sesuaikan dengan tinggi navbar/header atas */
  position: fixed;
  top: 70px;
  left: 0;
  z-index: 1029;
  overflow-y: auto; /* Aktifkan scroll */
  background-color:rgb(28, 2, 59) /* jika sidebar dark */
}

.nav-left-sidebar .menu-list {
  padding-bottom: 20px; /* Biar scroll tidak mentok */
}

/* Scrollbar styling opsional */
.nav-left-sidebar::-webkit-scrollbar {
  width: 6px;
}

.nav-left-sidebar::-webkit-scrollbar-thumb {
  background-color:rgba(28, 2, 59, 0.69);
  border-radius: 3px;
}


        /* CSS inline untuk memastikan footer di bawah */
        .dashboard-main-wrapper {
            min-height: 100vh;
            display: flex;
        }

        .dashboard-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .dashboard-ecommerce {
            flex: 1;
        }

        .footer {
            margin-top: auto;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <!-- Sidebar -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">Menu</li>
                            <li class="nav-item">
                                <a class="nav-link" id="dashboardLink" href="dashboard.php"><i
                                        class="fa fa-fw fa-tachometer-alt"></i> Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="anggotaLink" href="anggota.php"><i
                                        class="fa fa-fw fa-users"></i> Anggota</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" id="trainersLink" href="pelatih.php"><i
                                        class="fa fa-fw fa-user-circle"></i> Pelatih</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="facilitiesLink" href="fasilitas.php"><i
                                        class="fa fa-fw fa-suitcase"></i> Fasilitas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="packagesLink" href="paket.php"><i
                                        class="fa fa-fw fa-box"></i> Paket</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="packagesLink" href="keanggotaan.php"><i
                                        class="fa fa-fw fa-address-card"></i> Daftar Keanggotaan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="schedulesLink" href="jadwal-kelas.php"><i
                                        class="fa fa-fw fa-calendar-alt"></i> Jadwal Kelas</a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" id="classesLink" href="kelas.php"><i
                                     class="fa fa-fw fa-columns"></i> Kelas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="classesLink" href="daftar-kelas.php"><i
                                     class="fa fa-fw fa-crosshairs"></i> Daftar Kelas</a>
                            </li>
                              <li class="nav-item">
                                <a class="nav-link" id="paymentsLink" href="pembayaran.php"><i
                                        class="fa fa-fw fa-credit-card"></i> Pembayaran</a>
                            </li>
                           <li class="nav-item">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-laporan" aria-controls="submenu-laporan">
                                    <i class="fa fa-fw fa-file-alt"></i> Data Laporan
                                </a>
                                <div id="submenu-laporan" class="collapse" data-parent="#navbarNav">
                                    <ul class="nav flex-column ml-3">
                                        <li class="nav-item">
                                            <a class="nav-link" href="laporan_anggota.php">Laporan Anggota</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="laporan_pelatih.php">Laporan Pelatih</a>
                                        </li>
                                         <li class="nav-item">
                                            <a class="nav-link" href="laporan_kelas.php">Laporan Kelas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="laporan_pendapatan.php">Pendapatan Bulanan</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="dashboard-wrapper">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <nav class="navbar navbar-expand-lg bg-white">
                    <a class="navbar-brand" href="index.php" style="color: black; text-decoration: none;">Gym Management</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto navbar-right-top">
                            <li class="nav-item">
                                <div id="custom-search" class="top-search-bar">
                                    <input class="form-control" type="text" placeholder="Search..">
                                </div>
                            </li>
                            <li class="nav-item dropdown nav-user">
                                <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="assets/images/gym.png" alt="" class="user-avatar-md rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                                    aria-labelledby="navbarDropdownMenuLink2">
                                    <div class="nav-user-info">
                                        <h5 class="mb-0 text-white nav-user-name">Halo, <?= htmlspecialchars($user['nama_lengkap']); ?></h5>
                                    </div>
                                    
                                    <a class="dropdown-item" href="logout.php"><i class="fas fa-power-off mr-2"></i>Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content">
                    <!-- Dynamic Page Content -->
                    <div class="ecommerce-widget">
                        <div class="row">
                            <?php include($page_content); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            Copyright © 2025 Concept. All rights reserved.
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/libs/js/main-js.js"></script>
    <script>
        // Menentukan link aktif berdasarkan URL
        const currentPath = window.location.pathname;
        const links = document.querySelectorAll('.nav-link');

        links.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
</body>

</html>

<?php
include 'koneksi.php';

// Ambil total anggota
$jumlahAnggota = mysqli_query($conn, "SELECT COUNT(*) as total FROM anggota");
$totalAnggota = mysqli_fetch_assoc($jumlahAnggota)['total'];

// Ambil total pelatih
$jumlahPelatih = mysqli_query($conn, "SELECT COUNT(*) as total FROM pelatih");
$totalPelatih = mysqli_fetch_assoc($jumlahPelatih)['total'];

// Ambil total kelas hari ini
$hariIni = date('Y-m-d');
$kelasHariIni = mysqli_query($conn, "SELECT COUNT(*) as total FROM jadwal_kelas WHERE tanggal = '$hariIni'");
$totalKelas = mysqli_fetch_assoc($kelasHariIni)['total'];

// Ambil total paket
$jumlahPaket = mysqli_query($conn, "SELECT COUNT(*) as total FROM paket");
$totalPaket = mysqli_fetch_assoc($jumlahPaket)['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Dashboard Admin Gym</h1>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Anggota</h5>
                    <p class="card-text fs-4"><?= $totalAnggota ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Kelas Hari Ini</h5>
                    <p class="card-text fs-4"><?= $totalKelas ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pelatih Aktif</h5>
                    <p class="card-text fs-4"><?= $totalPelatih ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Paket Tersedia</h5>
                    <p class="card-text fs-4"><?= $totalPaket ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <canvas id="statistikChart" height="100"></canvas>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('statistikChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Anggota', 'Kelas Hari Ini', 'Pelatih', 'Paket'],
        datasets: [{
            label: 'Statistik Umum',
            data: [<?= $totalAnggota ?>, <?= $totalKelas ?>, <?= $totalPelatih ?>, <?= $totalPaket ?>],
            backgroundColor: [
                'rgba(13, 110, 253, 0.7)',
                'rgba(25, 135, 84, 0.7)',
                'rgba(255, 193, 7, 0.7)',
                'rgba(220, 53, 69, 0.7)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</body>
</html>

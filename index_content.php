<?php
include 'db/koneksi.php';

// Konversi hari Inggris ke Bahasa Indonesia
$hariMap = [
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',
    'Sunday'    => 'Minggu',
];
$hariIniEnglish = date('l');
$hariIndo = $hariMap[$hariIniEnglish];
$tanggalHariIni = date('Y-m-d');

// Total anggota
$totalAnggota = $pdo->query("SELECT COUNT(*) as total FROM anggota")->fetch()['total'];

// Total pelatih
$totalPelatih = $pdo->query("SELECT COUNT(*) as total FROM pelatih")->fetch()['total'];

// Total kelas hari ini
$stmtKelas = $pdo->prepare("SELECT COUNT(*) as total FROM jadwal_kelas WHERE hari = ?");
$stmtKelas->execute([$hariIndo]);
$totalKelas = $stmtKelas->fetch()['total'];

// Total paket
$totalPaket = $pdo->query("SELECT COUNT(*) as total FROM paket_keanggotaan")->fetch()['total'];

// Total pembayaran semua
$totalPembayaran = $pdo->query("SELECT SUM(jumlah_bayar) as total FROM pembayaran")->fetch()['total'] ?? 0;

// Total pembayaran hari ini
$stmtBayarHariIni = $pdo->prepare("SELECT SUM(jumlah_bayar) as total FROM pembayaran WHERE tanggal_bayar = ?");
$stmtBayarHariIni->execute([$tanggalHariIni]);
$totalBayarHariIni = $stmtBayarHariIni->fetch()['total'] ?? 0;

// Anggota baru hari ini
$stmtAnggotaBaru = $pdo->prepare("SELECT COUNT(*) as total FROM anggota WHERE DATE(created_at) = ?");
$stmtAnggotaBaru->execute([$tanggalHariIni]);
$totalAnggotaBaru = $stmtAnggotaBaru->fetch()['total'];

// Notifikasi terakhir (ambil 5 pembayaran terbaru)
$notifikasi = $pdo->query("
   SELECT a.nama_lengkap, p.jumlah_bayar, p.tanggal_bayar
FROM pembayaran p
JOIN keanggotaan k ON p.id_keanggotaan = k.id_keanggotaan
JOIN anggota a ON k.id_anggota = a.id_anggota
ORDER BY p.tanggal_bayar DESC, p.id_pembayaran DESC
LIMIT 5

")->fetchAll();
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

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h6>Total Anggota</h6>
                    <h3><?= $totalAnggota ?></h3>
                    <p class="mb-0 text-white-50"><?= $totalAnggotaBaru ?> baru hari ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h6>Kelas Hari Ini (<?= $hariIndo ?>)</h6>
                    <h3><?= $totalKelas ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <h6>Pelatih Aktif</h6>
                    <h3><?= $totalPelatih ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger h-100">
                <div class="card-body">
                    <h6>Paket Tersedia</h6>
                    <h3><?= $totalPaket ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-md-6">
            <div class="card border-success h-100">
                <div class="card-body">
                    <h6 class="text-success">Total Pembayaran</h6>
                    <h3>Rp <?= number_format($totalPembayaran, 0, ',', '.') ?></h3>
                    <p class="mb-0 text-muted">Hari ini: Rp <?= number_format($totalBayarHariIni, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-info h-100">
                <div class="card-body">
                    <h6 class="text-info">Notifikasi Terakhir</h6>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($notifikasi as $n): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($n['nama_lengkap']) ?> membayar Rp <?= number_format($n['jumlah_bayar'], 0, ',', '.') ?> pada <?= $n['tanggal_bayar'] ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
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
    data: {
        labels: ['Anggota', 'Kelas Hari Ini', 'Pelatih', 'Paket'],
        datasets: [
            {
                type: 'bar',
                label: 'Jumlah',
                data: [<?= $totalAnggota ?>, <?= $totalKelas ?>, <?= $totalPelatih ?>, <?= $totalPaket ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            },
            {
                type: 'line',
                label: 'Tren',
                data: [<?= $totalAnggota ?>, <?= $totalKelas ?>, <?= $totalPelatih ?>, <?= $totalPaket ?>],
                fill: false,
                borderColor: 'rgba(0,0,0,0.6)',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Statistik Umum Hari Ini',
                font: { size: 18 }
            },
            tooltip: {
                mode: 'index',
                intersect: false,
            }
        },
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

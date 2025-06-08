<?php
include 'db/koneksi.php'; // Koneksi ke database

// Mendapatkan ID pembayaran dari URL
$id_pembayaran = $_GET['id'];

// Query untuk mengambil data pembayaran berdasarkan ID
$query = "SELECT p.id_pembayaran, p.id_keanggotaan, p.jumlah_bayar, p.tanggal_bayar, p.metode_pembayaran, p.status_pembayaran, p.keterangan, a.nama_lengkap, pk.nama_paket
          FROM pembayaran p
          JOIN keanggotaan k ON p.id_keanggotaan = k.id_keanggotaan
          JOIN anggota a ON k.id_anggota = a.id_anggota
          JOIN paket_keanggotaan pk ON k.id_paket = pk.id_paket
          WHERE p.id_pembayaran = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_pembayaran]);
$pembayaran = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Detail Pembayaran - ID: <?php echo $pembayaran['id_pembayaran']; ?></h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID Pembayaran</th>
                    <td><?php echo $pembayaran['id_pembayaran']; ?></td>
                </tr>
                <tr>
                    <th>Nama Anggota</th>
                    <td><?php echo $pembayaran['nama_lengkap']; ?></td>
                </tr>
                <tr>
                    <th>Nama Paket</th>
                    <td><?php echo $pembayaran['nama_paket']; ?></td>
                </tr>
                <tr>
                    <th>Jumlah Bayar</th>
                    <td>Rp <?php echo number_format($pembayaran['jumlah_bayar'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th>Tanggal Bayar</th>
                    <td><?php echo $pembayaran['tanggal_bayar']; ?></td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td><?php echo $pembayaran['metode_pembayaran']; ?></td>
                </tr>
                <tr>
                    <th>Status Pembayaran</th>
                    <td><?php echo $pembayaran['status_pembayaran']; ?></td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td><?php echo $pembayaran['keterangan']; ?></td>
                </tr>
            </table>

            <a href="pembayaran.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

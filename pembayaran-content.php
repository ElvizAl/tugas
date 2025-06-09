<?php
include 'db/koneksi.php'; // Koneksi ke database

// Mendapatkan data pembayaran
$query = "SELECT p.id_pembayaran, p.id_keanggotaan, p.jumlah_bayar, p.tanggal_bayar, p.metode_pembayaran, p.status_pembayaran, p.keterangan, a.nama_lengkap
          FROM pembayaran p
          JOIN keanggotaan k ON p.id_keanggotaan = k.id_keanggotaan
          JOIN anggota a ON k.id_anggota = a.id_anggota";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembayaran</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <style>
         thead th {
    background-color: rgb(124, 188, 255) !important;
  }
    </style>
</head>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Daftar Pembayaran</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID Pembayaran</th>
                        <th>Nama Anggota</th>
                        <th>Jumlah Bayar</th>
                        <th>Tanggal Bayar</th>
                        <th>Metode Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch()) { ?>
                    <tr>
                        <td><?php echo $row['id_pembayaran']; ?></td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                        <td>Rp <?php echo number_format($row['jumlah_bayar'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['tanggal_bayar']; ?></td>
                        <td><?php echo $row['metode_pembayaran']; ?></td>
                        <td><?php echo $row['status_pembayaran']; ?></td>
                        <td><?php echo $row['keterangan']; ?></td>
                        <td>
                            <?php if ($row['status_pembayaran'] == 'Pending') { ?>
                                <a href="update-status-pembayaran.php?id=<?php echo $row['id_pembayaran']; ?>" class="btn btn-success btn-sm">Verifikasi Pembayaran</a>
                            <?php } ?>
                            <a href="detail-pembayaran.php?id=<?php echo $row['id_pembayaran']; ?>" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

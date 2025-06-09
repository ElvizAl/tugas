<?php
include 'db/koneksi.php'; // Menyertakan koneksi database

// Mengambil data keanggotaan dengan informasi anggota dan paket
$query = "SELECT k.id_keanggotaan, a.nama_lengkap, pk.nama_paket, k.tanggal_mulai, k.tanggal_berakhir, k.status_keanggotaan
          FROM keanggotaan k
          JOIN anggota a ON k.id_anggota = a.id_anggota
          JOIN paket_keanggotaan pk ON k.id_paket = pk.id_paket";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Keanggotaan</title>
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
            <h4>Daftar Keanggotaan</h4>
            <a href="tambah-keanggotaan.php" class="btn btn-primary btn-sm">Tambah Keanggotaan</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Anggota</th>
                        <th>Paket Keanggotaan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Berakhir</th>
                        <th>Status Keanggotaan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_paket']); ?></td>
                        <td><?php echo htmlspecialchars($row['tanggal_mulai']); ?></td>
                        <td><?php echo htmlspecialchars($row['tanggal_berakhir']); ?></td>
                        <td><?php echo htmlspecialchars($row['status_keanggotaan']); ?></td>
                        <td>
                            <a href="edit-keanggotaan.php?id=<?php echo $row['id_keanggotaan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus-keanggotaan.php?id=<?php echo $row['id_keanggotaan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus keanggotaan ini?');">Delete</a>
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

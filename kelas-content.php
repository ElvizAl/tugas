<?php
include 'db/koneksi.php'; // Koneksi ke database

// Query untuk mengambil data kelas
$query = "SELECT k.id_kelas, k.nama_kelas, k.deskripsi, p.nama_pelatih, f.nama_fasilitas, k.kapasitas_maksimal, k.harga_per_sesi, k.durasi_menit, k.tingkat_kesulitan, k.status_kelas
          FROM kelas k
          JOIN pelatih p ON k.id_pelatih = p.id_pelatih
          JOIN fasilitas f ON k.id_fasilitas = f.id_fasilitas";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kelas</title>
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
            <h4>Daftar Kelas</h4>
            <a href="tambah-kelas.php" class="btn btn-primary btn-sm">Tambah Kelas</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Deskripsi</th>
                        <th>Pelatih</th>
                        <th>Fasilitas</th>
                        <th>Kapasitas Maksimal</th>
                        <th>Harga per Sesi</th>
                        <th>Durasi (Menit)</th>
                        <th>Tingkat Kesulitan</th>
                        <th>Status Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch()) { ?>
                        <tr>
                            <td><?php echo $row['nama_kelas']; ?></td>
                            <td><?php echo $row['deskripsi']; ?></td>
                            <td><?php echo $row['nama_pelatih']; ?></td>
                            <td><?php echo $row['nama_fasilitas']; ?></td>
                            <td><?php echo $row['kapasitas_maksimal']; ?></td>
                            <td>Rp <?= number_format($row['harga_per_sesi'], 0, ',', '.') ?></td>
                            <td><?php echo $row['durasi_menit']; ?></td>
                            <td><?php echo $row['tingkat_kesulitan']; ?></td>
                            <td><?php echo $row['status_kelas']; ?></td>
                            <td>
                                <a href="edit-kelas.php?id=<?php echo $row['id_kelas']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus-kelas.php?id=<?php echo $row['id_kelas']; ?>" class="btn btn-danger btn-sm">Delete</a>
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

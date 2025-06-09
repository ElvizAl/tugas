<?php
include 'db/koneksi.php'; // Koneksi ke database

// Ambil data jadwal kelas
$query = "SELECT jk.id_jadwal_kelas, k.nama_kelas, jk.hari, jk.jam_mulai, jk.jam_selesai
          FROM jadwal_kelas jk
          JOIN kelas k ON jk.id_kelas = k.id_kelas";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kelas</title>
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
            <h4>Jadwal Kelas</h4>
            <a href="tambah-jadwal-kelas.php" class="btn btn-primary btn-sm">Tambah Jadwal Kelas</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
            <tr>
                <th>Nama Kelas</th>
                <th>Hari</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch()) { ?>
            <tr>
                <td><?php echo $row['nama_kelas']; ?></td>
                <td><?php echo $row['hari']; ?></td>
                <td><?php echo $row['jam_mulai']; ?></td>
                <td><?php echo $row['jam_selesai']; ?></td>
                <td>
                    <a href="edit-jadwal-kelas.php?id=<?php echo $row['id_jadwal_kelas']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus-jadwal-kelas.php?id=<?php echo $row['id_jadwal_kelas']; ?>" class="btn btn-danger btn-sm">Delete</a>
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

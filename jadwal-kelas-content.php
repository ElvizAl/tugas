<?php
include 'db/koneksi.php'; // Koneksi ke database

// Ambil data jadwal kelas
$query = "SELECT jk.id_jadwal_kelas, k.nama_kelas, jk.hari, jk.jam_mulai, jk.jam_selesai, jk.tanggal_mulai, jk.tanggal_selesai
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
</head>
<body>
<div class="container mt-5">
    <!-- Tombol untuk menambah jadwal kelas -->
    <a href="tambah-jadwal-kelas.php" class="btn btn-success mb-3">Tambah Jadwal Kelas</a>

    <!-- Tabel untuk menampilkan jadwal kelas -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Kelas</th>
                <th>Hari</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
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
                <td><?php echo $row['tanggal_mulai']; ?></td>
                <td><?php echo $row['tanggal_selesai']; ?></td>
                <td>
                    <a href="edit-jadwal-kelas.php?id=<?php echo $row['id_jadwal_kelas']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus-jadwal-kelas.php?id=<?php echo $row['id_jadwal_kelas']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
include 'db/koneksi.php'; // Koneksi ke database

// Query untuk mengambil data fasilitas
$query = "SELECT * FROM fasilitas";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Fasilitas</title>
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
            <h4>Daftar Fasilitas</h4>
            <a href="tambah-fasilitas.php" class="btn btn-primary btn-sm">Tambah Fasilitas</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Fasilitas</th>
                        <th>Deskripsi</th>
                        <th>Kapasitas</th>
                        <th>Status Fasilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch()) { ?>
                        <tr>
                            <td><?php echo $row['nama_fasilitas']; ?></td>
                            <td><?php echo $row['deskripsi']; ?></td>
                            <td><?php echo $row['kapasitas']; ?></td>
                            <td><?php echo $row['status_fasilitas']; ?></td>
                            <td>
                                <a href="edit-fasilitas.php?id=<?php echo $row['id_fasilitas']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus-fasilitas.php?id=<?php echo $row['id_fasilitas']; ?>" class="btn btn-danger btn-sm">Delete</a>
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

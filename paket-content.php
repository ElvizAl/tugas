<?php
include 'db/koneksi.php'; // Include database connection

// Fetch all the packages from the database
$query = "SELECT * FROM paket_keanggotaan";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Paket Member</title>
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
            <h4>Daftar Paket Member</h4>
            <a href="tambah-paket.php" class="btn btn-primary btn-sm">Tambah Paket</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Durasi (Hari)</th>
                        <th>Deskripsi</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nama_paket']); ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?php echo htmlspecialchars($row['durasi_hari']); ?></td>
                        <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                        <td><?php echo htmlspecialchars($row['fasilitas']); ?></td>
                        <td><?php echo htmlspecialchars($row['status_paket']); ?></td>
                        <td>
                            <a href="edit-paket.php?id=<?php echo $row['id_paket']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus-paket.php?id=<?php echo $row['id_paket']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this package?');">Delete</a>
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

<?php
include 'db/koneksi.php'; // Koneksi ke database

// Query untuk mengambil data pelatih
$query = "SELECT * FROM pelatih";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelatih</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Daftar Pelatih</h4>
            <a href="tambah-pelatih.php" class="btn btn-primary btn-sm">Tambah Pelatih</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Pelatih</th>
                        <th>Spesialisasi</th>
                        <th>No. Telpon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Gaji</th>
                        <th>Status Pelatih</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch()) { ?>
                        <tr>
                            <td><?php echo $row['nama_pelatih']; ?></td>
                            <td><?php echo $row['spesialisasi']; ?></td>
                            <td><?php echo $row['no_telpon']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['gaji']; ?></td>
                            <td><?php echo $row['status_pelatih']; ?></td>
                            <td>
                                <a href="edit-pelatih.php?id=<?php echo $row['id_pelatih']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus-pelatih.php?id=<?php echo $row['id_pelatih']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

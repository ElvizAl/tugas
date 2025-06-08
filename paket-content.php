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
    <title>Membership Packages</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Membership Packages</h4>
            <a href="tambah-paket.php" class="btn btn-primary btn-sm">Add New Package</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Duration (Days)</th>
                        <th>Description</th>
                        <th>Facilities</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nama_paket']); ?></td>
                        <td><?php echo htmlspecialchars($row['harga']); ?></td>
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

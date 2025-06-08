<?php
include 'db/koneksi.php'; // Include database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $durasi_hari = $_POST['durasi_hari'];
    $deskripsi = $_POST['deskripsi'];
    $fasilitas = $_POST['fasilitas'];
    $status_paket = $_POST['status_paket'];

    // Insert the new package into the database
    $query = "INSERT INTO paket_keanggotaan (nama_paket, harga, durasi_hari, deskripsi, fasilitas, status_paket, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nama_paket, $harga, $durasi_hari, $deskripsi, $fasilitas, $status_paket]);

    // Redirect to the package list after adding
    header("Location: paket.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Membership Package</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Add Membership Package</h4>
        </div>
        <div class="card-body">
            <form action="tambah-paket-content.php" method="POST">
                <div class="form-group">
                    <label for="nama_paket">Package Name</label>
                    <input type="text" class="form-control" name="nama_paket" required>
                </div>
                <div class="form-group">
                    <label for="harga">Price</label>
                    <input type="number" class="form-control" name="harga" required>
                </div>
                <div class="form-group">
                    <label for="durasi_hari">Duration (Days)</label>
                    <input type="number" class="form-control" name="durasi_hari" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Description</label>
                    <textarea class="form-control" name="deskripsi" required></textarea>
                </div>
                <div class="form-group">
                    <label for="fasilitas">Facilities</label>
                    <textarea class="form-control" name="fasilitas" required></textarea>
                </div>
                <div class="form-group">
                    <label for="status_paket">Status</label>
                    <select class="form-control" name="status_paket" required>
                        <option value="Aktif">Active</option>
                        <option value="Tidak Aktif">Inactive</option>
                        <option value="Suspend">Suspended</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Package</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
include 'db/koneksi.php'; // Koneksi ke database

// Menyimpan data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $deskripsi = $_POST['deskripsi'];
    $kapasitas = $_POST['kapasitas'];
    $status_fasilitas = $_POST['status_fasilitas'];

    // Menyimpan data fasilitas ke database
    $query = "INSERT INTO fasilitas (nama_fasilitas, deskripsi, kapasitas, status_fasilitas) 
              VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nama_fasilitas, $deskripsi, $kapasitas, $status_fasilitas]);

    // Redirect ke halaman fasilitas setelah menambah
    header("Location: fasilitas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Fasilitas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Fasilitas</h4>
        </div>
        <div class="card-body">
            <form action="tambah-fasilitas-content.php" method="POST">
                <div class="form-group">
                    <label for="nama_fasilitas">Nama Fasilitas</label>
                    <input type="text" class="form-control" name="nama_fasilitas" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" required></textarea>
                </div>
                <div class="form-group">
                    <label for="kapasitas">Kapasitas</label>
                    <input type="number" class="form-control" name="kapasitas" required>
                </div>
                <div class="form-group">
                    <label for="status_fasilitas">Status Fasilitas</label>
                    <select class="form-control" name="status_fasilitas" required>
                        <option value="Tersedia">Tersedia</option>
                        <option value="Dalam Perawatan">Dalam Perawatan</option>
                        <option value="Tidak Tersedia">Tidak Tersedia</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Fasilitas</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

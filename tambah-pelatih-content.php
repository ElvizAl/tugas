<?php
include 'db/koneksi.php'; // Menyertakan koneksi database

// Menyimpan data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelatih = $_POST['nama_pelatih'];
    $spesialisasi = $_POST['spesialisasi'];
    $no_telpon = $_POST['no_telpon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $gaji = $_POST['gaji'];
    $status_pelatih = $_POST['status_pelatih'];

    // Menyimpan data pelatih ke database
    $query = "INSERT INTO pelatih (nama_pelatih, spesialisasi, no_telpon, email, alamat, gaji, status_pelatih) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nama_pelatih, $spesialisasi, $no_telpon, $email, $alamat, $gaji, $status_pelatih]);

    // Redirect ke halaman pelatih setelah menambah
    header("Location: pelatih.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelatih</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Pelatih</h4>
        </div>
        <div class="card-body">
            <form action="tambah-pelatih-content.php" method="POST">
                <div class="form-group">
                    <label for="nama_pelatih">Nama Pelatih</label>
                    <input type="text" class="form-control" name="nama_pelatih" required>
                </div>
                <div class="form-group">
                    <label for="spesialisasi">Spesialisasi</label>
                    <input type="text" class="form-control" name="spesialisasi" required>
                </div>
                <div class="form-group">
                    <label for="no_telpon">No. Telpon</label>
                    <input type="text" class="form-control" name="no_telpon" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" name="alamat" required></textarea>
                </div>
                <div class="form-group">
                    <label for="gaji">Gaji</label>
                    <input type="number" class="form-control" name="gaji" required>
                </div>
                <div class="form-group">
                    <label for="status_pelatih">Status Pelatih</label>
                    <select class="form-control" name="status_pelatih" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                        <option value="Cuti">Cuti</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Pelatih</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

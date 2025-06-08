<?php
include 'db/koneksi.php'; // Koneksi ke database

// Mendapatkan ID pelatih dari URL
$id_pelatih = $_GET['id'];

// Query untuk mengambil data pelatih berdasarkan ID
$query = "SELECT * FROM pelatih WHERE id_pelatih = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_pelatih]);
$pelatih = $stmt->fetch();

// Proses jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelatih = $_POST['nama_pelatih'];
    $spesialisasi = $_POST['spesialisasi'];
    $no_telpon = $_POST['no_telpon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $gaji = $_POST['gaji'];
    $status_pelatih = $_POST['status_pelatih'];

    // Update data pelatih
    $query_update = "UPDATE pelatih SET nama_pelatih = ?, spesialisasi = ?, no_telpon = ?, email = ?, alamat = ?, gaji = ?, status_pelatih = ? WHERE id_pelatih = ?";
    $stmt_update = $pdo->prepare($query_update);
    $stmt_update->execute([$nama_pelatih, $spesialisasi, $no_telpon, $email, $alamat, $gaji, $status_pelatih, $id_pelatih]);

    // Redirect ke daftar pelatih setelah berhasil update
    header("Location: pelatih.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelatih</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Pelatih</h4>
        </div>
        <div class="card-body">
            <form action="edit-pelatih-content.php?id=<?php echo $id_pelatih; ?>" method="POST">
                <div class="form-group">
                    <label for="nama_pelatih">Nama Pelatih</label>
                    <input type="text" class="form-control" name="nama_pelatih" value="<?php echo $pelatih['nama_pelatih']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="spesialisasi">Spesialisasi</label>
                    <input type="text" class="form-control" name="spesialisasi" value="<?php echo $pelatih['spesialisasi']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="no_telpon">No. Telpon</label>
                    <input type="text" class="form-control" name="no_telpon" value="<?php echo $pelatih['no_telpon']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $pelatih['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" name="alamat" required><?php echo $pelatih['alamat']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="gaji">Gaji</label>
                    <input type="number" class="form-control" name="gaji" value="<?php echo $pelatih['gaji']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status_pelatih">Status Pelatih</label>
                    <select class="form-control" name="status_pelatih" required>
                        <option value="Aktif" <?php echo ($pelatih['status_pelatih'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                        <option value="Tidak Aktif" <?php echo ($pelatih['status_pelatih'] == 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                        <option value="Cuti" <?php echo ($pelatih['status_pelatih'] == 'Cuti') ? 'selected' : ''; ?>>Cuti</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Pelatih</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

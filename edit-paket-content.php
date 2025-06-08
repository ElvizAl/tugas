<?php
include 'db/koneksi.php'; // Menyertakan koneksi database

// Mengambil ID paket dari URL
if (!isset($_GET['id'])) {
    echo "ID paket tidak ditemukan.";
    exit();
}

$package_id = $_GET['id'];

// Mengambil data paket dari database
$query = "SELECT * FROM paket_keanggotaan WHERE id_paket = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$package_id]);
$package = $stmt->fetch();

if (!$package) {
    echo "Paket tidak ditemukan.";
    exit();
}

// Menyimpan perubahan data paket
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $durasi_hari = $_POST['durasi_hari'];
    $deskripsi = $_POST['deskripsi'];
    $fasilitas = $_POST['fasilitas']; // Menyimpan fasilitas dalam bentuk text
    $status_paket = $_POST['status_paket'];

    // Memperbarui data paket
    $update_query = "UPDATE paket_keanggotaan SET nama_paket = ?, harga = ?, durasi_hari = ?, deskripsi = ?, fasilitas = ?, status_paket = ? WHERE id_paket = ?";
    $stmt = $pdo->prepare($update_query);
    $stmt->execute([$nama_paket, $harga, $durasi_hari, $deskripsi, $fasilitas, $status_paket, $package_id]);

    // Redirect setelah update
    header("Location: paket.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paket Keanggotaan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Paket Keanggotaan</h4>
        </div>
        <div class="card-body">
            <form action="edit-paket-content.php?id=<?php echo $package['id_paket']; ?>" method="POST">
                <div class="form-group">
                    <label for="nama_paket">Nama Paket</label>
                    <input type="text" class="form-control" name="nama_paket" value="<?php echo htmlspecialchars($package['nama_paket']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga" value="<?php echo htmlspecialchars($package['harga']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="durasi_hari">Durasi (Hari)</label>
                    <input type="number" class="form-control" name="durasi_hari" value="<?php echo htmlspecialchars($package['durasi_hari']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" required><?php echo htmlspecialchars($package['deskripsi']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="fasilitas">Fasilitas</label>
                    <textarea class="form-control" name="fasilitas" required><?php echo htmlspecialchars($package['fasilitas']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status_paket">Status Paket</label>
                    <select class="form-control" name="status_paket" required>
                        <option value="Aktif" <?php echo $package['status_paket'] == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                        <option value="Tidak Aktif" <?php echo $package['status_paket'] == 'Tidak Aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui Paket</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

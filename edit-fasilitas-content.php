<?php
include 'db/koneksi.php'; // Koneksi ke database

// Mendapatkan ID fasilitas dari URL
$id_fasilitas = $_GET['id'];

// Query untuk mengambil data fasilitas berdasarkan ID
$query = "SELECT * FROM fasilitas WHERE id_fasilitas = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_fasilitas]);
$fasilitas = $stmt->fetch();

// Proses jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $deskripsi = $_POST['deskripsi'];
    $kapasitas = $_POST['kapasitas'];
    $status_fasilitas = $_POST['status_fasilitas'];

    // Update data fasilitas
    $query_update = "UPDATE fasilitas SET nama_fasilitas = ?, deskripsi = ?, kapasitas = ?, status_fasilitas = ? WHERE id_fasilitas = ?";
    $stmt_update = $pdo->prepare($query_update);
    $stmt_update->execute([$nama_fasilitas, $deskripsi, $kapasitas, $status_fasilitas, $id_fasilitas]);

    // Redirect ke daftar fasilitas setelah berhasil update
    header("Location: fasilitas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fasilitas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Fasilitas</h4>
        </div>
        <div class="card-body">
            <form action="edit-fasilitas-content.php?id=<?php echo $id_fasilitas; ?>" method="POST">
                <div class="form-group">
                    <label for="nama_fasilitas">Nama Fasilitas</label>
                    <input type="text" class="form-control" name="nama_fasilitas" value="<?php echo $fasilitas['nama_fasilitas']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" required><?php echo $fasilitas['deskripsi']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="kapasitas">Kapasitas</label>
                    <input type="number" class="form-control" name="kapasitas" value="<?php echo $fasilitas['kapasitas']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status_fasilitas">Status Fasilitas</label>
                    <select class="form-control" name="status_fasilitas" required>
                        <option value="Tersedia" <?php echo ($fasilitas['status_fasilitas'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                        <option value="Dalam Perawatan" <?php echo ($fasilitas['status_fasilitas'] == 'Dalam Perawatan') ? 'selected' : ''; ?>>Dalam Perawatan</option>
                        <option value="Tidak Tersedia" <?php echo ($fasilitas['status_fasilitas'] == 'Tidak Tersedia') ? 'selected' : ''; ?>>Tidak Tersedia</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Fasilitas</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

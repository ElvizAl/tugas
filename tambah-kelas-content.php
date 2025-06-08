<?php
include 'db/koneksi.php'; // Koneksi ke database

// Mendapatkan data pelatih dan fasilitas untuk form dropdown
$query_pelatih = "SELECT * FROM pelatih WHERE status_pelatih = 'Aktif'";
$pelatih_result = $pdo->query($query_pelatih)->fetchAll();

$query_fasilitas = "SELECT * FROM fasilitas WHERE status_fasilitas = 'Tersedia'";
$fasilitas_result = $pdo->query($query_fasilitas)->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari form
    $nama_kelas = $_POST['nama_kelas'];
    $deskripsi = $_POST['deskripsi'];
    $id_pelatih = $_POST['id_pelatih'];
    $id_fasilitas = $_POST['id_fasilitas'];
    $kapasitas_maksimal = $_POST['kapasitas_maksimal'];
    $harga_per_sesi = $_POST['harga_per_sesi'];
    $durasi_menit = $_POST['durasi_menit'];
    $tingkat_kesulitan = $_POST['tingkat_kesulitan'];
    $status_kelas = $_POST['status_kelas'];

    // Insert kelas baru
    $query = "INSERT INTO kelas (nama_kelas, deskripsi, id_pelatih, id_fasilitas, kapasitas_maksimal, harga_per_sesi, durasi_menit, tingkat_kesulitan, status_kelas)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nama_kelas, $deskripsi, $id_pelatih, $id_fasilitas, $kapasitas_maksimal, $harga_per_sesi, $durasi_menit, $tingkat_kesulitan, $status_kelas]);

    // Redirect ke halaman kelas setelah berhasil ditambahkan
    header("Location: kelas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kelas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Kelas Baru</h4>
        </div>
        <div class="card-body">
            <form action="tambah-kelas-content.php" method="POST">
                <div class="form-group">
                    <label for="nama_kelas">Nama Kelas</label>
                    <input type="text" class="form-control" name="nama_kelas" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" required></textarea>
                </div>
                <div class="form-group">
                    <label for="id_pelatih">Pelatih</label>
                    <select class="form-control" name="id_pelatih" required>
                        <?php foreach ($pelatih_result as $pelatih) { ?>
                            <option value="<?php echo $pelatih['id_pelatih']; ?>"><?php echo $pelatih['nama_pelatih']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_fasilitas">Fasilitas</label>
                    <select class="form-control" name="id_fasilitas" required>
                        <?php foreach ($fasilitas_result as $fasilitas) { ?>
                            <option value="<?php echo $fasilitas['id_fasilitas']; ?>"><?php echo $fasilitas['nama_fasilitas']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kapasitas_maksimal">Kapasitas Maksimal</label>
                    <input type="number" class="form-control" name="kapasitas_maksimal" required>
                </div>
                <div class="form-group">
                    <label for="harga_per_sesi">Harga Per Sesi</label>
                    <input type="number" class="form-control" name="harga_per_sesi" required>
                </div>
                <div class="form-group">
                    <label for="durasi_menit">Durasi (Menit)</label>
                    <input type="number" class="form-control" name="durasi_menit" required>
                </div>
                <div class="form-group">
                    <label for="tingkat_kesulitan">Tingkat Kesulitan</label>
                    <select class="form-control" name="tingkat_kesulitan">
                        <option value="Pemula">Pemula</option>
                        <option value="Menengah">Menengah</option>
                        <option value="Lanjutan">Lanjutan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status_kelas">Status Kelas</label>
                    <select class="form-control" name="status_kelas" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Kelas</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

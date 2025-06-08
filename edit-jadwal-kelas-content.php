<?php
include 'db/koneksi.php'; // Koneksi ke database

// Ambil data jadwal kelas berdasarkan ID
$id_jadwal_kelas = $_GET['id'];
$query = "SELECT jk.*, k.nama_kelas 
          FROM jadwal_kelas jk
          JOIN kelas k ON jk.id_kelas = k.id_kelas 
          WHERE jk.id_jadwal_kelas = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_jadwal_kelas]);
$row = $stmt->fetch();

// Ambil data kelas untuk dropdown
$query_kelas = "SELECT * FROM kelas WHERE status_kelas = 'Aktif'";
$kelas_result = $pdo->query($query_kelas)->fetchAll();

// Menyimpan perubahan jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kelas = $_POST['id_kelas'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    // Update jadwal kelas
    $query = "UPDATE jadwal_kelas 
              SET id_kelas = ?, hari = ?, jam_mulai = ?, jam_selesai = ?, tanggal_mulai = ?, tanggal_selesai = ?, updated_at = NOW() 
              WHERE id_jadwal_kelas = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_kelas, $hari, $jam_mulai, $jam_selesai, $tanggal_mulai, $tanggal_selesai, $id_jadwal_kelas]);

    // Redirect ke halaman jadwal kelas setelah update
    header("Location: jadwal-kelas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal Kelas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Jadwal Kelas</h4>
        </div>
        <div class="card-body">
            <form action="edit-jadwal-kelas-content.php?id=<?php echo $row['id_jadwal_kelas']; ?>" method="POST">
                <div class="form-group">
                    <label for="id_kelas">Kelas</label>
                    <select class="form-control" name="id_kelas" required>
                        <?php foreach ($kelas_result as $kelas) { ?>
                            <option value="<?php echo $kelas['id_kelas']; ?>" <?php echo $kelas['id_kelas'] == $row['id_kelas'] ? 'selected' : ''; ?>>
                                <?php echo $kelas['nama_kelas']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="hari">Hari</label>
                    <select class="form-control" name="hari" required>
                        <option value="Senin" <?php echo $row['hari'] == 'Senin' ? 'selected' : ''; ?>>Senin</option>
                        <option value="Selasa" <?php echo $row['hari'] == 'Selasa' ? 'selected' : ''; ?>>Selasa</option>
                        <option value="Rabu" <?php echo $row['hari'] == 'Rabu' ? 'selected' : ''; ?>>Rabu</option>
                        <option value="Kamis" <?php echo $row['hari'] == 'Kamis' ? 'selected' : ''; ?>>Kamis</option>
                        <option value="Jumat" <?php echo $row['hari'] == 'Jumat' ? 'selected' : ''; ?>>Jumat</option>
                        <option value="Sabtu" <?php echo $row['hari'] == 'Sabtu' ? 'selected' : ''; ?>>Sabtu</option>
                        <option value="Minggu" <?php echo $row['hari'] == 'Minggu' ? 'selected' : ''; ?>>Minggu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jam_mulai">Jam Mulai</label>
                    <input type="time" class="form-control" name="jam_mulai" value="<?php echo $row['jam_mulai']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="jam_selesai">Jam Selesai</label>
                    <input type="time" class="form-control" name="jam_selesai" value="<?php echo $row['jam_selesai']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="tanggal_mulai" value="<?php echo $row['tanggal_mulai']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="tanggal_selesai" value="<?php echo $row['tanggal_selesai']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Jadwal Kelas</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

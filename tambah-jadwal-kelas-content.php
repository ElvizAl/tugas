<?php
include 'db/koneksi.php'; // Koneksi ke database

// Ambil data kelas untuk dropdown
$query_kelas = "SELECT * FROM kelas WHERE status_kelas = 'Aktif'";
$kelas_result = $pdo->query($query_kelas)->fetchAll();

// Menyimpan data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_kelas = $_POST['id_kelas'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    // Insert Jadwal Kelas
    $query = "INSERT INTO jadwal_kelas (id_kelas, hari, jam_mulai, jam_selesai, created_at) 
              VALUES (?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_kelas, $hari, $jam_mulai, $jam_selesai]);

    // Redirect ke halaman jadwal kelas setelah menambah
    header("Location: jadwal-kelas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Kelas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Jadwal Kelas</h4>
        </div>
        <div class="card-body">
            <form action="tambah-jadwal-kelas-content.php" method="POST">
                <div class="form-group">
                    <label for="id_kelas">Kelas</label>
                    <select class="form-control" name="id_kelas" required>
                        <?php foreach ($kelas_result as $kelas) { ?>
                            <option value="<?php echo $kelas['id_kelas']; ?>"><?php echo $kelas['nama_kelas']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="hari">Hari</label>
                    <select class="form-control" name="hari" required>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jam_mulai">Jam Mulai</label>
                    <input type="time" class="form-control" name="jam_mulai" required>
                </div>
                <div class="form-group">
                    <label for="jam_selesai">Jam Selesai</label>
                    <input type="time" class="form-control" name="jam_selesai" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Tambah Jadwal Kelas</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

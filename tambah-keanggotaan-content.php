<?php
include 'db/koneksi.php'; // Menyertakan koneksi database

// Mendapatkan daftar paket keanggotaan untuk form dropdown
$query_paket = "SELECT * FROM paket_keanggotaan WHERE status_paket = 'Aktif'";
$paket_result = $pdo->query($query_paket)->fetchAll();

// Menyimpan data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari form
    $id_anggota = $_POST['id_anggota'];
    $id_paket = $_POST['id_paket'];
    $tanggal_mulai = $_POST['tanggal_mulai'];

    // Menyimpan keanggotaan baru
    $query = "INSERT INTO keanggotaan (id_anggota, id_paket, tanggal_mulai, tanggal_berakhir, status_keanggotaan, created_at)
              VALUES (?, ?, ?, CURDATE(), 'Aktif', NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_anggota, $id_paket, $tanggal_mulai]);

    // Redirect ke halaman keanggotaan setelah menambah
    header("Location: keanggotaan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Keanggotaan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Keanggotaan</h4>
        </div>
        <div class="card-body">
            <form action="tambah-keanggotaan-content.php" method="POST">
                <div class="form-group">
                    <label for="id_anggota">Anggota</label>
                    <select class="form-control" name="id_anggota" required>
                        <?php
                        // Menampilkan daftar anggota yang sudah terdaftar
                        $query_anggota = "SELECT * FROM anggota WHERE status_anggota = 'Aktif'";
                        $anggota_result = $pdo->query($query_anggota)->fetchAll();
                        foreach ($anggota_result as $anggota) {
                            echo "<option value='".$anggota['id_anggota']."'>".$anggota['nama_lengkap']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_paket">Paket Keanggotaan</label>
                    <select class="form-control" name="id_paket" required>
                        <?php foreach ($paket_result as $paket) { ?>
                            <option value="<?php echo $paket['id_paket']; ?>"><?php echo $paket['nama_paket']; ?> (Rp <?php echo $paket['harga']; ?>)</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="tanggal_mulai" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Keanggotaan</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

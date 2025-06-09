<?php
include 'db/koneksi.php'; // Koneksi ke database

// Ambil data kelas
$query_kelas = "SELECT * FROM kelas WHERE status_kelas = 'Aktif'";
$kelas_result = $pdo->query($query_kelas)->fetchAll();

// Ambil data anggota
$query_anggota = "SELECT * FROM anggota WHERE status_anggota = 'Aktif'";
$anggota_result = $pdo->query($query_anggota)->fetchAll();

// Menyimpan data pembayaran ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_anggota = $_POST['id_anggota'];
    $id_kelas = $_POST['id_kelas'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Ambil harga kelas
    $query_harga = "SELECT harga_per_sesi, nama_kelas FROM kelas WHERE id_kelas = ?";
    $stmt_harga = $pdo->prepare($query_harga);
    $stmt_harga->execute([$id_kelas]);
    $kelas_data = $stmt_harga->fetch();
    $harga = $kelas_data['harga_per_sesi'];
    $nama_kelas = $kelas_data['nama_kelas'];

    // Insert pembayaran dengan status 'Pending'
    $query_pembayaran = "INSERT INTO pembayaran (id_keanggotaan, jumlah_bayar, tanggal_bayar, metode_pembayaran, status_pembayaran, nama_kelas) 
                         VALUES (?, ?, CURDATE(), ?, 'Pending', ?)";
    $stmt_pembayaran = $pdo->prepare($query_pembayaran);
    $stmt_pembayaran->execute([$id_anggota, $harga, $metode_pembayaran, $nama_kelas]);

    // Redirect ke halaman pembayaran setelah insert
    header("Location: pembayaran.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Kelas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Pendaftaran Kelas</h4>
        </div>
        <div class="card-body">
            <form action="daftar-kelas-content.php" method="POST">
                <div class="form-group">
                    <label for="id_anggota">Anggota</label>
                    <select class="form-control" name="id_anggota" required>
                        <?php foreach ($anggota_result as $anggota) { ?>
                            <option value="<?php echo $anggota['id_anggota']; ?>"><?php echo $anggota['nama_lengkap']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_kelas">Kelas</label>
                    <select class="form-control" name="id_kelas" required>
                        <?php foreach ($kelas_result as $kelas) { ?>
                            <option value="<?php echo $kelas['id_kelas']; ?>"><?php echo $kelas['nama_kelas']; ?> (Rp <?php echo number_format($kelas['harga_per_sesi'], 2, ',', '.'); ?>)</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="metode_pembayaran">Metode Pembayaran</label>
                    <select class="form-control" name="metode_pembayaran" required>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Kartu Kredit">Kartu Kredit</option>
                        <option value="Kartu Debit">Kartu Debit</option>
                        <option value="E-Wallet">E-Wallet</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Pendaftaran Kelas</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<?php
include 'db/koneksi.php';

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap   = $_POST['nama_lengkap'];
    $email          = $_POST['email'];
    $kata_sandi     = password_hash($_POST['kata_sandi'], PASSWORD_DEFAULT);
    $no_telepon     = $_POST['no_telepon'];
    $jenis_kelamin  = $_POST['jenis_kelamin'];
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $alamat         = $_POST['alamat'];
    $peran          = 'user';
    $tanggal_dibuat = date('Y-m-d');

    // Cek apakah email sudah ada
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pengguna WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $pesan = "duplicate";
    } else {
        $query = "INSERT INTO pengguna 
            (nama_lengkap, email, kata_sandi, no_telepon, jenis_kelamin, tanggal_lahir, alamat, peran, tanggal_dibuat)
            VALUES 
            (:nama_lengkap, :email, :kata_sandi, :no_telepon, :jenis_kelamin, :tanggal_lahir, :alamat, :peran, :tanggal_dibuat)";
        
        $stmt = $pdo->prepare($query);
        $success = $stmt->execute([
            'nama_lengkap'   => $nama_lengkap,
            'email'          => $email,
            'kata_sandi'     => $kata_sandi,
            'no_telepon'     => $no_telepon,
            'jenis_kelamin'  => $jenis_kelamin,
            'tanggal_lahir'  => $tanggal_lahir,
            'alamat'         => $alamat,
            'peran'          => $peran,
            'tanggal_dibuat' => $tanggal_dibuat
        ]);

        $pesan = $success ? "sukses" : "gagal";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <form method="POST" class="card p-4" style="width: 500px;">
        <h3 class="text-center">Form Registrasi</h3>
        <div class="form-group"><input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required></div>
        <div class="form-group"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="form-group"><input type="password" name="kata_sandi" class="form-control" placeholder="Kata Sandi" required></div>
        <div class="form-group"><input type="text" name="no_telepon" class="form-control" placeholder="No. Telepon" required></div>
        <div class="form-group">
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="form-group"><input type="date" name="tanggal_lahir" class="form-control" required></div>
        <div class="form-group"><textarea name="alamat" class="form-control" placeholder="Alamat" required></textarea></div>
        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        <p class="text-center mt-2">Sudah punya akun? <a href="index.php">Login di sini</a></p>
    </form>

    <?php if ($pesan == "sukses") : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Registrasi Berhasil!',
            text: 'Silakan login dengan akun Anda.',
        }).then(() => {
            window.location.href = 'index.php';
        });
    </script>
    <?php elseif ($pesan == "duplicate") : ?>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Email sudah digunakan!',
            text: 'Silakan gunakan email lain.',
        });
    </script>
    <?php elseif ($pesan == "gagal") : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Registrasi Gagal!',
            text: 'Silakan coba lagi nanti.',
        });
    </script>
    <?php endif; ?>
</body>
</html>

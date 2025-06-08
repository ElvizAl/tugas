<?php
include 'db/koneksi.php'; // Menyertakan koneksi database

// Mengambil ID paket dari URL
if (!isset($_GET['id'])) {
    echo "ID paket tidak ditemukan.";
    exit();
}

$package_id = $_GET['id'];

// Menghapus paket keanggotaan dari database
$query = "DELETE FROM paket_keanggotaan WHERE id_paket = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$package_id]);

// Redirect ke halaman daftar paket setelah menghapus
header("Location: paket.php");
exit();
?>

<?php
include 'db/koneksi.php'; // Koneksi ke database

// Mengambil ID jadwal kelas dari URL
$id_jadwal_kelas = $_GET['id'];

// Menghapus jadwal kelas berdasarkan ID
$query = "DELETE FROM jadwal_kelas WHERE id_jadwal_kelas = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_jadwal_kelas]);

// Redirect ke halaman jadwal kelas setelah penghapusan
header("Location: jadwal-kelas.php");
exit();
?>

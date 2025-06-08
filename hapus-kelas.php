<?php
include 'db/koneksi.php'; // Koneksi ke database

// Mendapatkan ID kelas dari URL
$id_kelas = $_GET['id'];

// Query untuk menghapus kelas berdasarkan ID
$query = "DELETE FROM kelas WHERE id_kelas = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_kelas]);

// Redirect ke halaman daftar kelas setelah menghapus
header("Location: kelas.php");
exit();
?>

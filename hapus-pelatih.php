<?php
include 'db/koneksi.php'; // Koneksi ke database

// Mendapatkan ID pelatih dari URL
$id_pelatih = $_GET['id'];

// Query untuk menghapus pelatih berdasarkan ID
$query = "DELETE FROM pelatih WHERE id_pelatih = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_pelatih]);

// Redirect ke halaman daftar pelatih setelah menghapus
header("Location: pelatih.php");
exit();
?>

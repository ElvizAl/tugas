<?php
include 'db/koneksi.php'; // Koneksi ke database

// Mendapatkan ID fasilitas dari URL
$id_fasilitas = $_GET['id'];

// Query untuk menghapus fasilitas berdasarkan ID
$query = "DELETE FROM fasilitas WHERE id_fasilitas = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_fasilitas]);

// Redirect ke halaman daftar fasilitas setelah menghapus
header("Location: fasilitas.php");
exit();
?>

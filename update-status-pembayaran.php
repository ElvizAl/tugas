<?php
include 'db/koneksi.php'; // Koneksi ke database

// Mendapatkan ID pembayaran dari URL
$id_pembayaran = $_GET['id'];

// Update status pembayaran menjadi 'Lunas'
$query = "UPDATE pembayaran SET status_pembayaran = 'Lunas' WHERE id_pembayaran = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_pembayaran]);

// Redirect ke halaman daftar pembayaran
header("Location: pembayaran.php");
exit();
?>

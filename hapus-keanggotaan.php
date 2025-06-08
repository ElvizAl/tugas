<?php
include 'db/koneksi.php'; // Including database connection

// Fetching membership ID from URL
if (!isset($_GET['id'])) {
    echo "ID keanggotaan tidak ditemukan.";
    exit();
}

$keanggotaan_id = $_GET['id'];

// Delete membership from the database
$query = "DELETE FROM keanggotaan WHERE id_keanggotaan = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$keanggotaan_id]);

// Redirect to keanggotaan list after deletion
header("Location: keanggotaan.php");
exit();
?>

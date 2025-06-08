<?php
include 'db/koneksi.php'; // Include the database connection

// Check if the member ID is provided
if (!isset($_GET['id'])) {
    echo "Member ID is missing.";
    exit();
}

$member_id = $_GET['id'];

// Delete the member from the database
$query = "DELETE FROM anggota WHERE id_anggota = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$member_id]);

// Redirect to the members list page after deletion
header("Location: anggota.php"); // Corrected redirect
exit();
?>

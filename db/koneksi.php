<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'uas_gym'; // Ganti dengan nama database Anda
$username = 'root';
$password = ''; // Ganti dengan password jika diperlukan

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
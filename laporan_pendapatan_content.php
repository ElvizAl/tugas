<?php
include 'db/koneksi.php';
$data = $pdo->query("SELECT DATE_FORMAT(tanggal_bayar, '%Y-%m') AS bulan, SUM(jumlah_bayar) AS total FROM pembayaran GROUP BY bulan ORDER BY bulan DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Pendapatan Bulanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }
  thead th {
    background-color: rgb(124, 188, 255) !important;
  }
  @page {
    margin: 10mm;
  }
  @media print {
    .no-print { display: none; }
    body { margin: 0; padding: 0; }
    #laporan-content { width: 100%; margin: 0; }
    table { font-size: 12px; }
    th, td { padding: 6px; }
    th {
      background-color: rgb(124, 188, 255) !important;
      color: #000;
      text-align: center;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
  }
</style>
</head>
<body>
<div id="laporan-content" style="width: 95%; margin: 0 auto;">
  <h3 class="text-center mb-4">Laporan Pendapatan Bulanan</h3>
  <table class="table table-bordered">
    <thead class="table-light">
      <tr><th>Bulan</th><th>Total Pendapatan</th></tr>
    </thead>
    <tbody>
      <?php foreach ($data as $d): ?>
      <tr><td><?= date('F Y', strtotime($d['bulan'] . '-01')) ?></td><td>Rp <?= number_format($d['total'], 0, ',', '.') ?></td></tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="text-center no-print">
    <a href="laporan_pendapatan_print.php" class="btn btn-primary btn-sm">Cetak atau Simpan PDF</a>
  </div>
</div>
</body>
</html>

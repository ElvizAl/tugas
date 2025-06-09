<?php
include 'db/koneksi.php';
$data = $pdo->query("SELECT * FROM pelatih")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Pelatih</title>
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
  <h3 class="text-center mb-4">Laporan Pelatih</h3>
  <table class="table table-bordered">
    <thead class="table-light">
                      <tr>
                        <th>Nama Pelatih</th>
                        <th>Spesialisasi</th>
                        <th>No. Telpon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Gaji</th>
                        <th>Status Pelatih</th>
                    </tr>
      </thead>
    <tbody>
      <?php foreach ($data as $row): ?>
                          <tr>
                            <td><?php echo $row['nama_pelatih']; ?></td>
                            <td><?php echo $row['spesialisasi']; ?></td>
                            <td><?php echo $row['no_telpon']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td>Rp <?= number_format($row['gaji'], 0, ',', '.') ?></td>
                            <td><?php echo $row['status_pelatih']; ?></td>
                        </tr>      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="text-center no-print">
  <a href="laporan_pelatih_print.php" class="btn btn-primary btn-sm">Cetak atau Simpan PDF</a>
  </div>
</div>
</body>
</html>

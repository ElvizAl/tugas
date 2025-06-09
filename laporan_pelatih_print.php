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
  text-align: center;
  }
  .header {
            margin-bottom: 20px;
           
        }
        .header img {
            width: 130px;
            height: auto;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 20px;
        }
        .header p {
            margin: 2px 0;
            font-size: 14px;
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
  <div class="header">
    <img src="assets/images/gym.png" alt="" class="user-avatar-md rounded-circle">
    <h2>Fitness Center Tangerang</h2>
    <p>Jl. Oto Iskandardinata No.9, RT.001/RW.007, Gerendeng, Kec. Tangerang, Kota Tangerang, Banten 15113</p>
    <p>Telp: 0838-9010-3616 | Website: www.fitnescenter.com</p>
</div>
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
    <a href="laporan_pelatih.php" class="btn btn-primary btn-sm">Kembali ke Laporan</a>
  </div>
</div>
<script>
  window.onload = function() {
    window.print();
  };
</script>
</body>
</html>

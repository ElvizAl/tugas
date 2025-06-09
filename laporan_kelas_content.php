<?php
include 'db/koneksi.php';
$data = $pdo->query("SELECT k.id_kelas, k.nama_kelas, k.deskripsi, p.nama_pelatih, f.nama_fasilitas, k.kapasitas_maksimal, k.harga_per_sesi, k.durasi_menit, k.tingkat_kesulitan, k.status_kelas
          FROM kelas k
          JOIN pelatih p ON k.id_pelatih = p.id_pelatih
          JOIN fasilitas f ON k.id_fasilitas = f.id_fasilitas")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Kelas</title>
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
  <h3 class="text-center mb-4">Laporan Kelas</h3>
  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
                        <th>Nama Kelas</th>
                        <th>Deskripsi</th>
                        <th>Pelatih</th>
                        <th>Fasilitas</th>
                        <th>Kapasitas Maksimal</th>
                        <th>Harga per Sesi</th>
                        <th>Durasi (Menit)</th>
                        <th>Tingkat Kesulitan</th>
                        <th>Status Kelas</th>
                    </tr>
    </thead>
    <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?php echo $row['nama_kelas']; ?></td>
                            <td><?php echo $row['deskripsi']; ?></td>
                            <td><?php echo $row['nama_pelatih']; ?></td>
                            <td><?php echo $row['nama_fasilitas']; ?></td>
                            <td><?php echo $row['kapasitas_maksimal']; ?></td>
                            <td>Rp <?= number_format($row['harga_per_sesi'], 0, ',', '.') ?></td>
                            <td><?php echo $row['durasi_menit']; ?></td>
                            <td><?php echo $row['tingkat_kesulitan']; ?></td>
                            <td><?php echo $row['status_kelas']; ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
 
  </table>
  <div class="text-center no-print">
  <a href="laporan_kelas_print.php" class="btn btn-primary btn-sm">Cetak atau Simpan PDF</a>
  </div>
  
</div>
</body>
</html>

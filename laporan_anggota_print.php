<?php
include 'db/koneksi.php';
$anggota = $pdo->query("SELECT nama_lengkap, jenis_kelamin, tanggal_lahir, no_telpon, email, alamat, status_anggota, created_at FROM anggota")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Anggota</title>
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
  background-color:rgb(124, 188, 255) !important;
}


    @page {
      margin: 10mm;
    }

    @media print {
      .no-print {
        display: none;
      }

      body {
        margin: 0;
        padding: 0;
      }

      #laporan-content {
        width: 100%;
        margin: 0;
      }

      table {
        font-size: 12px;
      }

      th, td {
        padding: 6px;
      }
    

   th {
    background-color: rgb(124, 188, 255)!important;
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
  <h3 class="text-center mb-4">Laporan Anggota</h3>
  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Nama Lengkap</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
        <th>No. Telepon</th>
        <th>Email</th>
        <th>Alamat</th>
        <th>Status Anggota</th>
        <th>Tanggal Daftar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($anggota as $a): ?>
      <tr>
        <td><?= htmlspecialchars($a['nama_lengkap']) ?></td>
        <td><?= $a['jenis_kelamin'] ?></td>
        <td><?= date('d-m-Y', strtotime($a['tanggal_lahir'])) ?></td>
        <td><?= $a['no_telpon'] ?></td>
        <td><?= $a['email'] ?></td>
        <td><?= $a['alamat'] ?></td>
        <td><?= $a['status_anggota'] ?></td>
        <td><?= date('d-m-Y', strtotime($a['created_at'])) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="text-center no-print">
    <a href="laporan_anggota.php" class="btn btn-primary btn-sm">Kembali ke Laporan</a>
  </div>
</div>

<script>
  window.onload = function() {
    window.print();
  };
</script>
</body>
</html>

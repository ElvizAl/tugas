
<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Manajemen Gym</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4 text-center">Laporan Manajemen Gym</h2>

  <div class="accordion" id="laporanAccordion">

    <!-- 1. Laporan Jadwal Kelas -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingJadwal">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseJadwal">
          Laporan Jadwal Kelas
        </button>
      </h2>
      <div id="collapseJadwal" class="accordion-collapse collapse show">
        <div class="accordion-body">
          <?php
          $jadwal = $pdo->query("SELECT k.nama_kelas, jk.hari, jk.jam_mulai, jk.jam_selesai, p.nama_pelatih
                                 FROM jadwal_kelas jk
                                 JOIN kelas k ON jk.id_kelas = k.id_kelas
                                 JOIN pelatih p ON k.id_pelatih = p.id_pelatih")->fetchAll();
          ?>
          <table class="table table-bordered">
            <thead><tr><th>Kelas</th><th>Hari</th><th>Jam</th><th>Pelatih</th></tr></thead>
            <tbody>
            <?php foreach ($jadwal as $j): ?>
              <tr>
                <td><?= $j['nama_kelas'] ?></td>
                <td><?= $j['hari'] ?></td>
                <td><?= $j['jam_mulai'] ?> - <?= $j['jam_selesai'] ?></td>
                <td><?= $j['nama_pelatih'] ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- 2. Laporan Anggota -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingAnggota">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAnggota" aria-expanded="false" aria-controls="collapseAnggota">
          Laporan Anggota
        </button>
      </h2>
      <div id="collapseAnggota" class="accordion-collapse collapse">
        <div class="accordion-body">
          <?php
          $anggota = $pdo->query("SELECT nama_lengkap, no_hp, created_at FROM anggota")->fetchAll();
          ?>
          <table class="table table-bordered">
            <thead><tr><th>Nama</th><th>No. HP</th><th>Terdaftar</th></tr></thead>
            <tbody>
            <?php foreach ($anggota as $a): ?>
              <tr>
                <td><?= $a['nama_lengkap'] ?></td>
                <td><?= $a['no_hp'] ?></td>
                <td><?= $a['created_at'] ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- 3. Laporan Pembayaran -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingPembayaran">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePembayaran" aria-expanded="false" aria-controls="collapsePembayaran">
          Laporan Pembayaran
        </button>
      </h2>
      <div id="collapsePembayaran" class="accordion-collapse collapse">
        <div class="accordion-body">
          <?php
          $pembayaran = $pdo->query("SELECT a.nama_lengkap, p.jumlah_bayar, p.tanggal_bayar
                                     FROM pembayaran p
                                     JOIN keanggotaan k ON p.id_keanggotaan = k.id_keanggotaan
                                     JOIN anggota a ON k.id_anggota = a.id_anggota")->fetchAll();
          ?>
          <table class="table table-bordered">
            <thead><tr><th>Nama</th><th>Jumlah Bayar</th><th>Tanggal</th></tr></thead>
            <tbody>
            <?php foreach ($pembayaran as $p): ?>
              <tr>
                <td><?= $p['nama_lengkap'] ?></td>
                <td>Rp <?= number_format($p['jumlah_bayar'], 0, ',', '.') ?></td>
                <td><?= $p['tanggal_bayar'] ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- 4. Laporan Keanggotaan Aktif -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingAktif">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAktif" aria-expanded="false" aria-controls="collapseAktif">
          Laporan Keanggotaan Aktif
        </button>
      </h2>
      <div id="collapseAktif" class="accordion-collapse collapse">
        <div class="accordion-body">
          <?php
          $aktif = $pdo->query("SELECT a.nama_lengkap, pk.nama_paket, k.tanggal_mulai, k.tanggal_selesai
                                FROM keanggotaan k
                                JOIN anggota a ON k.id_anggota = a.id_anggota
                                JOIN paket pk ON k.id_paket = pk.id_paket")->fetchAll();
          ?>
          <table class="table table-bordered">
            <thead><tr><th>Nama</th><th>Paket</th><th>Mulai</th><th>Selesai</th></tr></thead>
            <tbody>
            <?php foreach ($aktif as $k): ?>
              <tr>
                <td><?= $k['nama_lengkap'] ?></td>
                <td><?= $k['nama_paket'] ?></td>
                <td><?= $k['tanggal_mulai'] ?></td>
                <td><?= $k['tanggal_selesai'] ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- 5. Laporan Pelatih & Kelas -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingPelatih">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePelatih" aria-expanded="false" aria-controls="collapsePelatih">
          Laporan Pelatih & Jumlah Kelas
        </button>
      </h2>
      <div id="collapsePelatih" class="accordion-collapse collapse">
        <div class="accordion-body">
          <?php
          $pelatih = $pdo->query("SELECT p.nama_pelatih, COUNT(k.id_kelas) as jumlah_kelas
                                  FROM pelatih p
                                  LEFT JOIN kelas k ON k.id_pelatih = p.id_pelatih
                                  GROUP BY p.id_pelatih")->fetchAll();
          ?>
          <table class="table table-bordered">
            <thead><tr><th>Nama Pelatih</th><th>Jumlah Kelas</th></tr></thead>
            <tbody>
            <?php foreach ($pelatih as $pl): ?>
              <tr>
                <td><?= $pl['nama_pelatih'] ?></td>
                <td><?= $pl['jumlah_kelas'] ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- 6. Laporan Pendapatan Bulanan -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingPendapatan">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePendapatan" aria-expanded="false" aria-controls="collapsePendapatan">
          Laporan Pendapatan Bulanan
        </button>
      </h2>
      <div id="collapsePendapatan" class="accordion-collapse collapse">
        <div class="accordion-body">
          <?php
          $pendapatan = $pdo->query("SELECT DATE_FORMAT(tanggal_bayar, '%Y-%m') as bulan, SUM(jumlah_bayar) as total 
                                     FROM pembayaran GROUP BY bulan ORDER BY bulan DESC")->fetchAll();
          ?>
          <table class="table table-bordered">
            <thead><tr><th>Bulan</th><th>Total Pendapatan</th></tr></thead>
            <tbody>
            <?php foreach ($pendapatan as $d): ?>
              <tr>
                <td><?= $d['bulan'] ?></td>
                <td>Rp <?= number_format($d['total'], 0, ',', '.') ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

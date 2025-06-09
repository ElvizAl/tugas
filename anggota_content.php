<?php
include 'db/koneksi.php'; // Menyertakan koneksi database

// Menampilkan daftar anggota
$query = "SELECT * FROM anggota";
$result = $pdo->query($query);

// Fungsi untuk format tanggal Indonesia
function formatTanggal($tanggal) {
    if (!$tanggal || $tanggal == '0000-00-00') {
        return '-';
    }
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $split = explode('-', $tanggal);
    if (count($split) >= 3) {
        $tahun = $split[0];
        $bulan_num = (int)$split[1];
        $hari = $split[2];
        return $hari . ' ' . $bulan[$bulan_num] . ' ' . $tahun;
    }
    return $tanggal;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Daftar Anggota</h4>
            <a href="tambah-anggota.php" class="btn btn-primary btn-sm">Tambah Anggota</a>
            <!-- Button untuk menambah anggota -->
        </div>
        <div class="card-body">
            <!-- Tabel daftar anggota dengan scroll -->
            <div class="scrollable-table-wrapper">
                <table class="table table-striped table-bordered scrollable-table" id="membersTable">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>No Telpon</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Tanggal Gabung</th>
                            <th>Status Anggota</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                            <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                            <td><?php echo formatTanggal($row['tanggal_lahir']); ?></td>
                            <td><?php echo htmlspecialchars($row['no_telpon']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                            <td><?php echo formatTanggal($row['tanggal_daftar']); ?></td>
                            <td><?php echo htmlspecialchars($row['status_anggota']); ?></td>
                            <td>
                                <a href="edit-anggota.php?id=<?php echo $row['id_anggota']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus-anggota.php?id=<?php echo $row['id_anggota']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            
        </div>
    </div>
</div>

<!-- Add jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

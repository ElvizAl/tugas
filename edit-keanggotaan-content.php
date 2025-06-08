<?php
include 'db/koneksi.php'; // Including database connection

// Fetching membership ID from URL
if (!isset($_GET['id'])) {
    echo "ID keanggotaan tidak ditemukan.";
    exit();
}

$keanggotaan_id = $_GET['id'];

// Fetch membership data from database
$query = "SELECT k.id_keanggotaan, k.id_anggota, k.id_paket, k.tanggal_mulai, k.status_keanggotaan, a.nama_lengkap, pk.nama_paket 
          FROM keanggotaan k
          JOIN anggota a ON k.id_anggota = a.id_anggota
          JOIN paket_keanggotaan pk ON k.id_paket = pk.id_paket
          WHERE k.id_keanggotaan = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$keanggotaan_id]);
$keanggotaan = $stmt->fetch();

if (!$keanggotaan) {
    echo "Keanggotaan tidak ditemukan.";
    exit();
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_anggota = $_POST['id_anggota'];
    $id_paket = $_POST['id_paket'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $status_keanggotaan = $_POST['status_keanggotaan'];

    // Update membership data
    $update_query = "UPDATE keanggotaan SET id_anggota = ?, id_paket = ?, tanggal_mulai = ?, status_keanggotaan = ? WHERE id_keanggotaan = ?";
    $stmt = $pdo->prepare($update_query);
    $stmt->execute([$id_anggota, $id_paket, $tanggal_mulai, $status_keanggotaan, $keanggotaan_id]);

    // Redirect after updating
    header("Location: keanggotaan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Keanggotaan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Keanggotaan</h4>
        </div>
        <div class="card-body">
            <form action="edit-keanggotaan-content.php?id=<?php echo $keanggotaan['id_keanggotaan']; ?>" method="POST">
                <div class="form-group">
                    <label for="id_anggota">Anggota</label>
                    <select class="form-control" name="id_anggota" required>
                        <option value="<?php echo $keanggotaan['id_anggota']; ?>"><?php echo $keanggotaan['nama_lengkap']; ?></option>
                        <?php
                        // Fetch other active members
                        $query_anggota = "SELECT * FROM anggota WHERE status_anggota = 'Aktif'";
                        $anggota_result = $pdo->query($query_anggota)->fetchAll();
                        foreach ($anggota_result as $anggota) {
                            echo "<option value='".$anggota['id_anggota']."'>".$anggota['nama_lengkap']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_paket">Paket Keanggotaan</label>
                    <select class="form-control" name="id_paket" required>
                        <option value="<?php echo $keanggotaan['id_paket']; ?>"><?php echo $keanggotaan['nama_paket']; ?></option>
                        <?php
                        // Fetch active packages
                        $query_paket = "SELECT * FROM paket_keanggotaan WHERE status_paket = 'Aktif'";
                        $paket_result = $pdo->query($query_paket)->fetchAll();
                        foreach ($paket_result as $paket) {
                            echo "<option value='".$paket['id_paket']."'>".$paket['nama_paket']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="tanggal_mulai" value="<?php echo $keanggotaan['tanggal_mulai']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status_keanggotaan">Status Keanggotaan</label>
                    <select class="form-control" name="status_keanggotaan" required>
                        <option value="Aktif" <?php echo $keanggotaan['status_keanggotaan'] == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                        <option value="Berakhir" <?php echo $keanggotaan['status_keanggotaan'] == 'Berakhir' ? 'selected' : ''; ?>>Berakhir</option>
                        <option value="Suspend" <?php echo $keanggotaan['status_keanggotaan'] == 'Suspend' ? 'selected' : ''; ?>>Suspend</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui Keanggotaan</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

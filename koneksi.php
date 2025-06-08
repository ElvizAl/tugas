<?php
// Konfigurasi database
$host = 'localhost';
$dbname = 'kontol';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Fungsi untuk format tanggal Indonesia
function formatTanggal($tanggal) {
    if (!$tanggal || $tanggal == '0000-00-00') {
        return '-';
    }
    
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    
    try {
        $split = explode('-', $tanggal);
        if (count($split) >= 3) {
            $tahun = $split[0];
            $bulan_num = (int)$split[1];
            $hari = $split[2];
            
            if ($bulan_num >= 1 && $bulan_num <= 12) {
                return $hari . ' ' . $bulan[$bulan_num] . ' ' . $tahun;
            }
        }
        return $tanggal;
    } catch (Exception $e) {
        return $tanggal;
    }
}

// Fungsi untuk menghitung umur
function hitungUmur($tanggal_lahir) {
    if (!$tanggal_lahir || $tanggal_lahir == '0000-00-00') {
        return 0;
    }
    
    try {
        $lahir = new DateTime($tanggal_lahir);
        $sekarang = new DateTime();
        $umur = $sekarang->diff($lahir);
        return $umur->y;
    } catch (Exception $e) {
        return 0;
    }
}

// Fungsi untuk format uang
function formatRupiah($angka) {
    if (!is_numeric($angka)) {
        return 'Rp 0';
    }
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Fungsi untuk mendapatkan status dengan badge
function getBadgeStatus($status, $tipe = 'default') {
    if (!$status) {
        return '<span class="badge bg-secondary">-</span>';
    }
    
    $badge_class = '';
    
    if ($tipe == 'anggota' || $tipe == 'keanggotaan' || $tipe == 'pelatih' || $tipe == 'paket') {
        switch($status) {
            case 'Aktif': $badge_class = 'bg-success'; break;
            case 'Tidak Aktif': $badge_class = 'bg-secondary'; break;
            case 'Suspend': $badge_class = 'bg-danger'; break;
            case 'Berakhir': $badge_class = 'bg-warning'; break;
            case 'Cuti': $badge_class = 'bg-info'; break;
            default: $badge_class = 'bg-secondary';
        }
    } elseif ($tipe == 'pembayaran') {
        switch($status) {
            case 'Lunas': $badge_class = 'bg-success'; break;
            case 'Pending': $badge_class = 'bg-warning'; break;
            case 'Gagal': $badge_class = 'bg-danger'; break;
            default: $badge_class = 'bg-secondary';
        }
    } elseif ($tipe == 'fasilitas') {
        switch($status) {
            case 'Tersedia': $badge_class = 'bg-success'; break;
            case 'Dalam Perawatan': $badge_class = 'bg-warning'; break;
            case 'Tidak Tersedia': $badge_class = 'bg-danger'; break;
            default: $badge_class = 'bg-secondary';
        }
    } elseif ($tipe == 'pendaftaran') {
        switch($status) {
            case 'Terdaftar': $badge_class = 'bg-primary'; break;
            case 'Hadir': $badge_class = 'bg-success'; break;
            case 'Tidak Hadir': $badge_class = 'bg-danger'; break;
            case 'Batal': $badge_class = 'bg-secondary'; break;
            default: $badge_class = 'bg-secondary';
        }
    }
    
    return '<span class="badge ' . $badge_class . '">' . htmlspecialchars($status) . '</span>';
}

// Fungsi untuk mendapatkan nama hari dalam bahasa Indonesia
function getNamaHari($hari) {
    $nama_hari = [
        'Senin' => 'Senin',
        'Selasa' => 'Selasa',
        'Rabu' => 'Rabu',
        'Kamis' => 'Kamis',
        'Jumat' => 'Jumat',
        'Sabtu' => 'Sabtu',
        'Minggu' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
        'Sunday' => 'Minggu'
    ];
    
    return $nama_hari[$hari] ?? $hari;
}

// Fungsi untuk format waktu
function formatWaktu($waktu) {
    if (!$waktu || $waktu == '00:00:00') {
        return '-';
    }
    
    try {
        return date('H:i', strtotime($waktu));
    } catch (Exception $e) {
        return $waktu;
    }
}

// Fungsi untuk mengecek apakah database dan tabel sudah ada
function checkDatabase($pdo) {
    try {
        // Cek apakah tabel anggota ada
        $stmt = $pdo->query("SHOW TABLES LIKE 'anggota'");
        if ($stmt->rowCount() == 0) {
            return false;
        }
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Fungsi untuk mendapatkan data dengan error handling
function getDataSafe($pdo, $query, $params = []) {
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return [];
    }
}

// Fungsi untuk mendapatkan satu data dengan error handling
function getDataSingle($pdo, $query, $params = []) {
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ? $result : [];
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return [];
    }
}

// Fungsi untuk mendapatkan count dengan error handling
function getCountSafe($pdo, $query, $params = []) {
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result && isset($result['total']) ? (int)$result['total'] : 0;
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return 0;
    }
}

// Cek apakah database sudah setup
if (!checkDatabase($pdo)) {
    // Redirect ke halaman setup database jika belum ada
    if (!strpos($_SERVER['REQUEST_URI'], 'setup.php')) {
        header('Location: setup.php');
        exit();
    }
}
?>
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2025 at 10:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coeg`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_daftar_anggota_baru` (IN `p_nama_lengkap` VARCHAR(100), IN `p_jenis_kelamin` ENUM('Laki-laki','Perempuan'), IN `p_tanggal_lahir` DATE, IN `p_no_telpon` VARCHAR(15), IN `p_email` VARCHAR(100), IN `p_alamat` TEXT, IN `p_id_paket` INT, IN `p_metode_pembayaran` ENUM('Tunai','Transfer Bank','Kartu Kredit','Kartu Debit','E-Wallet'))   BEGIN
    DECLARE v_id_anggota INT;
    DECLARE v_id_keanggotaan INT;
    DECLARE v_harga_paket DECIMAL(10,2);
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;
    
    -- Insert anggota baru
    INSERT INTO anggota (nama_lengkap, jenis_kelamin, tanggal_lahir, no_telpon, email, alamat)
    VALUES (p_nama_lengkap, p_jenis_kelamin, p_tanggal_lahir, p_no_telpon, p_email, p_alamat);
    
    SET v_id_anggota = LAST_INSERT_ID();
    
    -- Get harga paket
    SELECT harga INTO v_harga_paket FROM paket_keanggotaan WHERE id_paket = p_id_paket;
    
    -- Insert keanggotaan
    INSERT INTO keanggotaan (id_anggota, id_paket, tanggal_mulai)
    VALUES (v_id_anggota, p_id_paket, CURDATE());
    
    SET v_id_keanggotaan = LAST_INSERT_ID();
    
    -- Insert pembayaran
    INSERT INTO pembayaran (id_keanggotaan, jumlah_bayar, tanggal_bayar, metode_pembayaran, status_pembayaran)
    VALUES (v_id_keanggotaan, v_harga_paket, CURDATE(), p_metode_pembayaran, 'Lunas');
    
    COMMIT;
    
    SELECT v_id_anggota AS id_anggota_baru;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_perpanjang_keanggotaan` (IN `p_id_anggota` INT, IN `p_id_paket` INT, IN `p_metode_pembayaran` ENUM('Tunai','Transfer Bank','Kartu Kredit','Kartu Debit','E-Wallet'))   BEGIN
    DECLARE v_id_keanggotaan INT;
    DECLARE v_harga_paket DECIMAL(10,2);
    DECLARE v_tanggal_berakhir_lama DATE;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;
    
    -- Update keanggotaan lama menjadi berakhir
    UPDATE keanggotaan 
    SET status_keanggotaan = 'Berakhir' 
    WHERE id_anggota = p_id_anggota AND status_keanggotaan = 'Aktif';
    
    -- Get tanggal berakhir keanggotaan lama
    SELECT MAX(tanggal_berakhir) INTO v_tanggal_berakhir_lama 
    FROM keanggotaan 
    WHERE id_anggota = p_id_anggota;
    
    -- Get harga paket baru
    SELECT harga INTO v_harga_paket FROM paket_keanggotaan WHERE id_paket = p_id_paket;
    
    -- Insert keanggotaan baru
    INSERT INTO keanggotaan (id_anggota, id_paket, tanggal_mulai)
    VALUES (p_id_anggota, p_id_paket, GREATEST(CURDATE(), v_tanggal_berakhir_lama));
    
    SET v_id_keanggotaan = LAST_INSERT_ID();
    
    -- Insert pembayaran
    INSERT INTO pembayaran (id_keanggotaan, jumlah_bayar, tanggal_bayar, metode_pembayaran, status_pembayaran)
    VALUES (v_id_keanggotaan, v_harga_paket, CURDATE(), p_metode_pembayaran, 'Lunas');
    
    COMMIT;
    
    SELECT v_id_keanggotaan AS id_keanggotaan_baru;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_daftar` date DEFAULT curdate(),
  `status_anggota` enum('Aktif','Tidak Aktif','Suspend') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama_lengkap`, `jenis_kelamin`, `tanggal_lahir`, `no_telpon`, `email`, `alamat`, `tanggal_daftar`, `status_anggota`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'Laki-laki', '1990-05-15', '081234567890', 'john@email.com', 'Jl. Sudirman No. 123', '2025-06-08', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(2, 'Jane Smith', 'Perempuan', '1985-08-22', '081234567891', 'jane@email.com', 'Jl. Thamrin No. 456', '2025-06-08', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(3, 'Bob Wilson', 'Laki-laki', '1992-03-10', '081234567892', 'bob@email.com', 'Jl. Gatot Subroto No. 789', '2025-06-08', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(4, 'Alice Brown', 'Perempuan', '1988-12-05', '081234567893', 'alice@email.com', 'Jl. Kuningan No. 321', '2025-06-08', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(5, 'Charlie Davis', 'Laki-laki', '1995-07-18', '081234567894', 'charlie@email.com', 'Jl. Senayan No. 654', '2025-06-08', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(6, 'Test User', 'Laki-laki', '1990-01-01', '081999888777', 'testuser@email.com', 'Jl. Test No. 123', '2025-06-08', 'Aktif', '2025-06-08 05:03:58', '2025-06-08 05:03:58');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id_fasilitas` int(11) NOT NULL,
  `nama_fasilitas` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `status_fasilitas` enum('Tersedia','Dalam Perawatan','Tidak Tersedia') DEFAULT 'Tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id_fasilitas`, `nama_fasilitas`, `deskripsi`, `kapasitas`, `status_fasilitas`, `created_at`, `updated_at`) VALUES
(1, 'Ruang Angkat Beban', 'Area dengan berbagai alat angkat beban dan free weights', 30, 'Tersedia', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(2, 'Ruang Cardio', 'Area dengan treadmill, sepeda statis, elliptical', 25, 'Tersedia', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(3, 'Studio A', 'Studio untuk kelas grup yoga dan pilates', 20, 'Tersedia', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(4, 'Studio B', 'Studio untuk kelas grup HIIT dan aerobik', 25, 'Tersedia', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(5, 'Ruang Sauna', 'Ruang sauna untuk relaksasi', 8, 'Tersedia', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(6, 'Kolam Renang', 'Kolam renang untuk latihan dan rekreasi', 15, 'Dalam Perawatan', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(7, 'Lapangan Badminton', 'Lapangan badminton indoor', 4, 'Tersedia', '2025-06-08 05:03:47', '2025-06-08 05:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kelas`
--

CREATE TABLE `jadwal_kelas` (
  `id_jadwal_kelas` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_kelas`
--

INSERT INTO `jadwal_kelas` (`id_jadwal_kelas`, `id_kelas`, `hari`, `jam_mulai`, `jam_selesai`, `tanggal_mulai`, `tanggal_selesai`, `created_at`) VALUES
(1, 1, 'Senin', '07:00:00', '08:00:00', '2024-01-01', NULL, '2025-06-08 05:03:47'),
(2, 1, 'Rabu', '07:00:00', '08:00:00', '2024-01-01', NULL, '2025-06-08 05:03:47'),
(3, 1, 'Jumat', '07:00:00', '08:00:00', '2024-01-01', NULL, '2025-06-08 05:03:47'),
(4, 2, 'Selasa', '18:00:00', '18:45:00', '2024-01-01', NULL, '2025-06-08 05:03:47'),
(5, 2, 'Kamis', '18:00:00', '18:45:00', '2024-01-01', NULL, '2025-06-08 05:03:47'),
(6, 3, 'Selasa', '19:00:00', '19:50:00', '2024-01-01', NULL, '2025-06-08 05:03:47'),
(7, 3, 'Kamis', '19:00:00', '19:50:00', '2024-01-01', NULL, '2025-06-08 05:03:47'),
(8, 4, 'Rabu', '17:30:00', '18:30:00', '2024-01-01', NULL, '2025-06-08 05:03:47'),
(9, 4, 'Jumat', '17:30:00', '18:30:00', '2024-01-01', NULL, '2025-06-08 05:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_pelatih`
--

CREATE TABLE `jadwal_pelatih` (
  `id_jadwal_pelatih` int(11) NOT NULL,
  `id_pelatih` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_pelatih`
--

INSERT INTO `jadwal_pelatih` (`id_jadwal_pelatih`, `id_pelatih`, `hari`, `jam_mulai`, `jam_selesai`, `created_at`) VALUES
(1, 1, 'Senin', '07:00:00', '12:00:00', '2025-06-08 05:03:47'),
(2, 1, 'Selasa', '07:00:00', '12:00:00', '2025-06-08 05:03:47'),
(3, 1, 'Rabu', '07:00:00', '12:00:00', '2025-06-08 05:03:47'),
(4, 1, 'Kamis', '07:00:00', '12:00:00', '2025-06-08 05:03:47'),
(5, 1, 'Jumat', '07:00:00', '12:00:00', '2025-06-08 05:03:47'),
(6, 2, 'Selasa', '16:00:00', '21:00:00', '2025-06-08 05:03:47'),
(7, 2, 'Rabu', '16:00:00', '21:00:00', '2025-06-08 05:03:47'),
(8, 2, 'Kamis', '16:00:00', '21:00:00', '2025-06-08 05:03:47'),
(9, 2, 'Jumat', '16:00:00', '21:00:00', '2025-06-08 05:03:47'),
(10, 2, 'Sabtu', '16:00:00', '21:00:00', '2025-06-08 05:03:47'),
(11, 3, 'Senin', '17:00:00', '20:00:00', '2025-06-08 05:03:47'),
(12, 3, 'Rabu', '17:00:00', '20:00:00', '2025-06-08 05:03:47'),
(13, 3, 'Jumat', '17:00:00', '20:00:00', '2025-06-08 05:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `keanggotaan`
--

CREATE TABLE `keanggotaan` (
  `id_keanggotaan` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `status_keanggotaan` enum('Aktif','Berakhir','Suspend') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keanggotaan`
--

INSERT INTO `keanggotaan` (`id_keanggotaan`, `id_anggota`, `id_paket`, `tanggal_mulai`, `tanggal_berakhir`, `status_keanggotaan`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2024-06-01', '2024-07-01', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(2, 2, 6, '2024-02-20', '2025-02-19', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(3, 3, 4, '2024-05-15', '2024-08-13', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(4, 4, 3, '2024-06-10', '2024-07-10', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(5, 5, 2, '2024-06-20', '2024-06-27', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(6, 6, 1, '2025-06-08', '2025-07-08', 'Aktif', '2025-06-08 05:03:58', '2025-06-08 05:14:12'),
(7, 3, 2, '2025-06-08', '2025-06-15', 'Aktif', '2025-06-08 05:08:55', '2025-06-08 05:08:55'),
(8, 6, 2, '2025-06-08', '2025-06-15', 'Aktif', '2025-06-08 05:09:23', '2025-06-08 05:09:23'),
(9, 5, 1, '2025-06-08', '2025-06-09', 'Aktif', '2025-06-08 06:04:51', '2025-06-08 06:04:51'),
(10, 4, 1, '2025-06-08', '2025-06-09', 'Aktif', '2025-06-08 06:21:07', '2025-06-08 06:21:07');

--
-- Triggers `keanggotaan`
--
DELIMITER $$
CREATE TRIGGER `tr_keanggotaan_tanggal_berakhir` BEFORE INSERT ON `keanggotaan` FOR EACH ROW BEGIN
    DECLARE durasi INT;
    SELECT durasi_hari INTO durasi FROM paket_keanggotaan WHERE id_paket = NEW.id_paket;
    SET NEW.tanggal_berakhir = DATE_ADD(NEW.tanggal_mulai, INTERVAL durasi DAY);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_update_status_keanggotaan` BEFORE UPDATE ON `keanggotaan` FOR EACH ROW BEGIN
    IF NEW.tanggal_berakhir < CURDATE() AND NEW.status_keanggotaan = 'Aktif' THEN
        SET NEW.status_keanggotaan = 'Berakhir';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_pelatih` int(11) NOT NULL,
  `id_fasilitas` int(11) NOT NULL,
  `kapasitas_maksimal` int(11) NOT NULL,
  `harga_per_sesi` decimal(10,2) DEFAULT NULL,
  `durasi_menit` int(11) NOT NULL,
  `tingkat_kesulitan` enum('Pemula','Menengah','Lanjutan') DEFAULT 'Pemula',
  `status_kelas` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `deskripsi`, `id_pelatih`, `id_fasilitas`, `kapasitas_maksimal`, `harga_per_sesi`, `durasi_menit`, `tingkat_kesulitan`, `status_kelas`, `created_at`, `updated_at`) VALUES
(1, 'Yoga Morning', 'Kelas yoga untuk pemula dan menengah di pagi hari', 1, 3, 15, 75000.00, 60, 'Pemula', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(2, 'HIIT Training', 'High Intensity Interval Training untuk membakar kalori', 2, 4, 12, 100000.00, 45, 'Menengah', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(3, 'Pilates Evening', 'Kelas pilates untuk fleksibilitas dan core strength', 1, 3, 12, 85000.00, 50, 'Pemula', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(4, 'Zumba Dance', 'Kelas dance fitness yang menyenangkan', 3, 4, 20, 65000.00, 60, 'Pemula', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(5, 'Strength Training', 'Latihan kekuatan dengan personal trainer', 4, 1, 6, 150000.00, 60, 'Lanjutan', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `paket_keanggotaan`
--

CREATE TABLE `paket_keanggotaan` (
  `id_paket` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `durasi_hari` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `fasilitas` text DEFAULT NULL,
  `status_paket` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket_keanggotaan`
--

INSERT INTO `paket_keanggotaan` (`id_paket`, `nama_paket`, `harga`, `durasi_hari`, `deskripsi`, `fasilitas`, `status_paket`, `created_at`, `updated_at`) VALUES
(1, 'Paket Harian', 25000.00, 1, 'Paket untuk sekali kunjungan', 'Gym, Cardio', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(2, 'Paket Mingguan', 150000.00, 7, 'Paket untuk satu minggu', 'Gym, Cardio, Locker', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(3, 'Paket Bulanan', 500000.00, 30, 'Paket untuk satu bulan', 'Gym, Cardio, Locker, Sauna', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(4, 'Paket 3 Bulan', 1350000.00, 90, 'Paket untuk tiga bulan', 'Gym, Cardio, Locker, Sauna, Kelas Grup', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(5, 'Paket 6 Bulan', 2500000.00, 180, 'Paket untuk enam bulan', 'Gym, Cardio, Locker, Sauna, Kelas Grup, Personal Training', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(6, 'Paket Tahunan', 4500000.00, 365, 'Paket untuk satu tahun', 'Semua Fasilitas + Priority Booking', 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `pelatih`
--

CREATE TABLE `pelatih` (
  `id_pelatih` int(11) NOT NULL,
  `nama_pelatih` varchar(100) NOT NULL,
  `spesialisasi` varchar(200) NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_bergabung` date DEFAULT curdate(),
  `gaji` decimal(10,2) DEFAULT NULL,
  `status_pelatih` enum('Aktif','Tidak Aktif','Cuti') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelatih`
--

INSERT INTO `pelatih` (`id_pelatih`, `nama_pelatih`, `spesialisasi`, `no_telpon`, `email`, `alamat`, `tanggal_bergabung`, `gaji`, `status_pelatih`, `created_at`, `updated_at`) VALUES
(1, 'Sarah Johnson', 'Yoga, Pilates, Stretching', '081234567893', 'sarah@gym.com', 'Jl. Wellness No. 15', '2025-06-08', 8000000.00, 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(2, 'Mike Chen', 'HIIT, Strength Training, CrossFit', '081234567894', 'mike@gym.com', 'Jl. Fitness No. 22', '2025-06-08', 9000000.00, 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(3, 'Lisa Wong', 'Aerobik, Dance Fitness, Zumba', '081234567895', 'lisa@gym.com', 'Jl. Dance No. 8', '2025-06-08', 7500000.00, 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(4, 'David Smith', 'Personal Training, Bodybuilding', '081234567896', 'david@gym.com', 'Jl. Strong No. 12', '2025-06-08', 10000000.00, 'Aktif', '2025-06-08 05:03:47', '2025-06-08 05:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_keanggotaan` int(11) NOT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `metode_pembayaran` enum('Tunai','Transfer Bank','Kartu Kredit','Kartu Debit','E-Wallet') NOT NULL,
  `status_pembayaran` enum('Lunas','Pending','Gagal') DEFAULT 'Pending',
  `nama_kelas` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_keanggotaan`, `jumlah_bayar`, `tanggal_bayar`, `metode_pembayaran`, `status_pembayaran`, `nama_kelas`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 500000.00, '2024-06-01', 'Transfer Bank', 'Lunas', '', NULL, '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(2, 2, 4500000.00, '2024-02-20', 'Tunai', 'Lunas', '', NULL, '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(3, 3, 1350000.00, '2024-05-15', 'Kartu Kredit', 'Lunas', '', NULL, '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(4, 4, 500000.00, '2024-06-10', 'E-Wallet', 'Lunas', '', NULL, '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(5, 5, 150000.00, '2024-06-20', 'Tunai', 'Lunas', '', NULL, '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(6, 6, 500000.00, '2025-06-08', 'Transfer Bank', 'Lunas', '', NULL, '2025-06-08 05:03:58', '2025-06-08 05:03:58'),
(7, 10, 25000.00, '2025-06-08', 'Tunai', 'Lunas', '', NULL, '2025-06-08 06:21:07', '2025-06-08 06:27:26'),
(8, 3, 75000.00, '2025-06-08', 'Tunai', 'Pending', 'Yoga Morning', NULL, '2025-06-08 08:18:28', '2025-06-08 08:18:28');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran_kelas`
--

CREATE TABLE `pendaftaran_kelas` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_jadwal_kelas` int(11) NOT NULL,
  `tanggal_daftar` date DEFAULT curdate(),
  `status_pendaftaran` enum('Terdaftar','Hadir','Tidak Hadir','Batal') DEFAULT 'Terdaftar',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran_kelas`
--

INSERT INTO `pendaftaran_kelas` (`id_pendaftaran`, `id_anggota`, `id_jadwal_kelas`, `tanggal_daftar`, `status_pendaftaran`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-06-08', 'Terdaftar', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(2, 1, 2, '2025-06-08', 'Terdaftar', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(3, 2, 4, '2025-06-08', 'Terdaftar', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(4, 3, 5, '2025-06-08', 'Terdaftar', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(5, 4, 7, '2025-06-08', 'Terdaftar', '2025-06-08 05:03:47', '2025-06-08 05:03:47'),
(6, 5, 1, '2025-06-08', 'Terdaftar', '2025-06-08 05:03:47', '2025-06-08 05:03:47');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_anggota_aktif`
-- (See below for the actual view)
--
CREATE TABLE `view_anggota_aktif` (
`id_anggota` int(11)
,`nama_lengkap` varchar(100)
,`jenis_kelamin` enum('Laki-laki','Perempuan')
,`tanggal_lahir` date
,`no_telpon` varchar(15)
,`email` varchar(100)
,`alamat` text
,`tanggal_daftar` date
,`status_anggota` enum('Aktif','Tidak Aktif','Suspend')
,`id_keanggotaan` int(11)
,`nama_paket` varchar(100)
,`harga` decimal(10,2)
,`tanggal_mulai` date
,`tanggal_berakhir` date
,`status_keanggotaan` enum('Aktif','Berakhir','Suspend')
,`sisa_hari` int(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_jadwal_kelas_lengkap`
-- (See below for the actual view)
--
CREATE TABLE `view_jadwal_kelas_lengkap` (
`id_jadwal_kelas` int(11)
,`nama_kelas` varchar(100)
,`deskripsi` text
,`nama_pelatih` varchar(100)
,`nama_fasilitas` varchar(100)
,`hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')
,`jam_mulai` time
,`jam_selesai` time
,`kapasitas_maksimal` int(11)
,`harga_per_sesi` decimal(10,2)
,`durasi_menit` int(11)
,`tingkat_kesulitan` enum('Pemula','Menengah','Lanjutan')
,`jumlah_peserta` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_laporan_pembayaran`
-- (See below for the actual view)
--
CREATE TABLE `view_laporan_pembayaran` (
`id_pembayaran` int(11)
,`nama_lengkap` varchar(100)
,`nama_paket` varchar(100)
,`jumlah_bayar` decimal(10,2)
,`tanggal_bayar` date
,`metode_pembayaran` enum('Tunai','Transfer Bank','Kartu Kredit','Kartu Debit','E-Wallet')
,`status_pembayaran` enum('Lunas','Pending','Gagal')
,`keterangan` text
,`bulan` int(2)
,`tahun` int(4)
);

-- --------------------------------------------------------

--
-- Structure for view `view_anggota_aktif`
--
DROP TABLE IF EXISTS `view_anggota_aktif`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_anggota_aktif`  AS SELECT `a`.`id_anggota` AS `id_anggota`, `a`.`nama_lengkap` AS `nama_lengkap`, `a`.`jenis_kelamin` AS `jenis_kelamin`, `a`.`tanggal_lahir` AS `tanggal_lahir`, `a`.`no_telpon` AS `no_telpon`, `a`.`email` AS `email`, `a`.`alamat` AS `alamat`, `a`.`tanggal_daftar` AS `tanggal_daftar`, `a`.`status_anggota` AS `status_anggota`, `k`.`id_keanggotaan` AS `id_keanggotaan`, `p`.`nama_paket` AS `nama_paket`, `p`.`harga` AS `harga`, `k`.`tanggal_mulai` AS `tanggal_mulai`, `k`.`tanggal_berakhir` AS `tanggal_berakhir`, `k`.`status_keanggotaan` AS `status_keanggotaan`, to_days(`k`.`tanggal_berakhir`) - to_days(curdate()) AS `sisa_hari` FROM ((`anggota` `a` left join `keanggotaan` `k` on(`a`.`id_anggota` = `k`.`id_anggota` and `k`.`status_keanggotaan` = 'Aktif')) left join `paket_keanggotaan` `p` on(`k`.`id_paket` = `p`.`id_paket`)) WHERE `a`.`status_anggota` = 'Aktif' ;

-- --------------------------------------------------------

--
-- Structure for view `view_jadwal_kelas_lengkap`
--
DROP TABLE IF EXISTS `view_jadwal_kelas_lengkap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_jadwal_kelas_lengkap`  AS SELECT `jk`.`id_jadwal_kelas` AS `id_jadwal_kelas`, `k`.`nama_kelas` AS `nama_kelas`, `k`.`deskripsi` AS `deskripsi`, `p`.`nama_pelatih` AS `nama_pelatih`, `f`.`nama_fasilitas` AS `nama_fasilitas`, `jk`.`hari` AS `hari`, `jk`.`jam_mulai` AS `jam_mulai`, `jk`.`jam_selesai` AS `jam_selesai`, `k`.`kapasitas_maksimal` AS `kapasitas_maksimal`, `k`.`harga_per_sesi` AS `harga_per_sesi`, `k`.`durasi_menit` AS `durasi_menit`, `k`.`tingkat_kesulitan` AS `tingkat_kesulitan`, count(`pk`.`id_pendaftaran`) AS `jumlah_peserta` FROM ((((`jadwal_kelas` `jk` join `kelas` `k` on(`jk`.`id_kelas` = `k`.`id_kelas`)) join `pelatih` `p` on(`k`.`id_pelatih` = `p`.`id_pelatih`)) join `fasilitas` `f` on(`k`.`id_fasilitas` = `f`.`id_fasilitas`)) left join `pendaftaran_kelas` `pk` on(`jk`.`id_jadwal_kelas` = `pk`.`id_jadwal_kelas` and `pk`.`status_pendaftaran` in ('Terdaftar','Hadir'))) WHERE `k`.`status_kelas` = 'Aktif' GROUP BY `jk`.`id_jadwal_kelas` ;

-- --------------------------------------------------------

--
-- Structure for view `view_laporan_pembayaran`
--
DROP TABLE IF EXISTS `view_laporan_pembayaran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_pembayaran`  AS SELECT `pb`.`id_pembayaran` AS `id_pembayaran`, `a`.`nama_lengkap` AS `nama_lengkap`, `pk`.`nama_paket` AS `nama_paket`, `pb`.`jumlah_bayar` AS `jumlah_bayar`, `pb`.`tanggal_bayar` AS `tanggal_bayar`, `pb`.`metode_pembayaran` AS `metode_pembayaran`, `pb`.`status_pembayaran` AS `status_pembayaran`, `pb`.`keterangan` AS `keterangan`, month(`pb`.`tanggal_bayar`) AS `bulan`, year(`pb`.`tanggal_bayar`) AS `tahun` FROM (((`pembayaran` `pb` join `keanggotaan` `k` on(`pb`.`id_keanggotaan` = `k`.`id_keanggotaan`)) join `anggota` `a` on(`k`.`id_anggota` = `a`.`id_anggota`)) join `paket_keanggotaan` `pk` on(`k`.`id_paket` = `pk`.`id_paket`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_anggota_nama` (`nama_lengkap`),
  ADD KEY `idx_anggota_email` (`email`),
  ADD KEY `idx_anggota_status` (`status_anggota`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id_fasilitas`);

--
-- Indexes for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD PRIMARY KEY (`id_jadwal_kelas`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `idx_jadwal_kelas_hari` (`hari`);

--
-- Indexes for table `jadwal_pelatih`
--
ALTER TABLE `jadwal_pelatih`
  ADD PRIMARY KEY (`id_jadwal_pelatih`),
  ADD KEY `id_pelatih` (`id_pelatih`);

--
-- Indexes for table `keanggotaan`
--
ALTER TABLE `keanggotaan`
  ADD PRIMARY KEY (`id_keanggotaan`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_paket` (`id_paket`),
  ADD KEY `idx_keanggotaan_status` (`status_keanggotaan`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_pelatih` (`id_pelatih`),
  ADD KEY `id_fasilitas` (`id_fasilitas`);

--
-- Indexes for table `paket_keanggotaan`
--
ALTER TABLE `paket_keanggotaan`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `pelatih`
--
ALTER TABLE `pelatih`
  ADD PRIMARY KEY (`id_pelatih`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_keanggotaan` (`id_keanggotaan`),
  ADD KEY `idx_pembayaran_tanggal` (`tanggal_bayar`),
  ADD KEY `idx_pembayaran_status` (`status_pembayaran`);

--
-- Indexes for table `pendaftaran_kelas`
--
ALTER TABLE `pendaftaran_kelas`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `unique_pendaftaran` (`id_anggota`,`id_jadwal_kelas`),
  ADD KEY `id_jadwal_kelas` (`id_jadwal_kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id_fasilitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  MODIFY `id_jadwal_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jadwal_pelatih`
--
ALTER TABLE `jadwal_pelatih`
  MODIFY `id_jadwal_pelatih` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `keanggotaan`
--
ALTER TABLE `keanggotaan`
  MODIFY `id_keanggotaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paket_keanggotaan`
--
ALTER TABLE `paket_keanggotaan`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pelatih`
--
ALTER TABLE `pelatih`
  MODIFY `id_pelatih` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pendaftaran_kelas`
--
ALTER TABLE `pendaftaran_kelas`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD CONSTRAINT `jadwal_kelas_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_pelatih`
--
ALTER TABLE `jadwal_pelatih`
  ADD CONSTRAINT `jadwal_pelatih_ibfk_1` FOREIGN KEY (`id_pelatih`) REFERENCES `pelatih` (`id_pelatih`) ON DELETE CASCADE;

--
-- Constraints for table `keanggotaan`
--
ALTER TABLE `keanggotaan`
  ADD CONSTRAINT `keanggotaan_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE,
  ADD CONSTRAINT `keanggotaan_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `paket_keanggotaan` (`id_paket`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_pelatih`) REFERENCES `pelatih` (`id_pelatih`),
  ADD CONSTRAINT `kelas_ibfk_2` FOREIGN KEY (`id_fasilitas`) REFERENCES `fasilitas` (`id_fasilitas`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_keanggotaan`) REFERENCES `keanggotaan` (`id_keanggotaan`) ON DELETE CASCADE;

--
-- Constraints for table `pendaftaran_kelas`
--
ALTER TABLE `pendaftaran_kelas`
  ADD CONSTRAINT `pendaftaran_kelas_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_kelas_ibfk_2` FOREIGN KEY (`id_jadwal_kelas`) REFERENCES `jadwal_kelas` (`id_jadwal_kelas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

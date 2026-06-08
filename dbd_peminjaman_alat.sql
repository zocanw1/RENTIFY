-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2026 at 07:28 AM
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
-- Database: `dbd_peminjaman_alat`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `aksi` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `data_lama` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_lama`)),
  `data_baru` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_baru`)),
  `ip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alats`
--

CREATE TABLE `alats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_alat` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_08_040449_create_alats_table', 1),
(5, '2026_04_08_040511_create_units_table', 1),
(6, '2026_04_08_040533_create_peminjamen_table', 1),
(7, '2026_05_16_000001_create_activity_logs_table', 1),
(8, '2026_05_16_000002_create_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjamen`
--

CREATE TABLE `peminjamen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `status_pengajuan` enum('aktif','menunggu_konfirmasi','selesai') NOT NULL DEFAULT 'aktif',
  `waktu_pinjam` datetime NOT NULL,
  `waktu_kembali` datetime DEFAULT NULL,
  `komentar_siswa` text DEFAULT NULL,
  `balasan_admin` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'batas_jam_kembali', '15:00', 'Batas waktu pengembalian alat hari ini (HH:MM)', '2026-06-04 23:49:55', '2026-06-04 23:49:55'),
(2, 'nama_sekolah', 'SMK', 'Nama sekolah untuk laporan', '2026-06-04 23:49:55', '2026-06-04 23:49:55');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alat_id` bigint(20) UNSIGNED NOT NULL,
  `kode_unit` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('Tersedia','Dipinjam','Rusak','Diperbaiki') NOT NULL DEFAULT 'Tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nis` varchar(255) NOT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `role` enum('admin','siswa','ketua_tjkt','ketua_sija','wali_kelas') NOT NULL DEFAULT 'siswa',
  `foto_profil` varchar(255) DEFAULT NULL,
  `no_wa` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `nis`, `kelas`, `role`, `foto_profil`, `no_wa`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin WePinjam', 'admin@wepinjam.id', '0000000001', NULL, 'admin', NULL, NULL, NULL, '$2y$12$93NphrMlIHheR3FAb.P2ye7u2fl8etF0kwxSWXAo920SIsvn2dxly', NULL, '2026-06-05 00:20:27', '2026-06-05 00:20:27'),
(2, 'Ketua Jurusan TJKT', 'ketua.tjkt@wepinjam.id', '0000000002', NULL, 'ketua_tjkt', NULL, NULL, NULL, '$2y$12$Mje/Y/TxzOagRgWG9oDQOutLuPCu8Q5.yy0Ezvr8uZqcpnWaqpC7q', NULL, '2026-06-05 00:20:28', '2026-06-05 00:20:28'),
(3, 'Ketua Jurusan SIJA', 'ketua.sija@wepinjam.id', '0000000003', NULL, 'ketua_sija', NULL, NULL, NULL, '$2y$12$jxr/JEWamoyr/KrzmXEThu146aqIzKvRfVbv3DgX4L2IzE1BildAG', NULL, '2026-06-05 00:20:29', '2026-06-05 00:20:29'),
(4, 'Wali Kelas X TJKT 1', 'wali.x.tjkt.1@wepinjam.id', '0000000010', 'X TKJ 1', 'wali_kelas', NULL, NULL, NULL, '$2y$12$ludN9woKy4MOK6hzIs55NOh3wNpKe8lGMfS41e8WlTaKT/S0pLkfu', NULL, '2026-06-05 00:20:30', '2026-06-05 00:20:30'),
(5, 'Wali Kelas X TJKT 2', 'wali.x.tjkt.2@wepinjam.id', '0000000011', 'X TKJ 2', 'wali_kelas', NULL, NULL, NULL, '$2y$12$AnXFKWUruY/Z1G42afnFNOkgj0fuqlbVM/9FKKCibKWMfjtbKR4.i', NULL, '2026-06-05 00:20:31', '2026-06-05 00:20:31'),
(6, 'Wali Kelas X SIJA 1', 'wali.x.sija.1@wepinjam.id', '0000000012', 'X SIJA 1', 'wali_kelas', NULL, NULL, NULL, '$2y$12$rjabAAFRyWMzXSNMUj326.BBbKj7LLs2az05QKCoL8pk.PPxa8UBm', NULL, '2026-06-05 00:20:32', '2026-06-05 00:20:32'),
(7, 'Wali Kelas X SIJA 2', 'wali.x.sija.2@wepinjam.id', '0000000013', 'X SIJA 2', 'wali_kelas', NULL, NULL, NULL, '$2y$12$cj5ZM8SAtAURktx2yMWffuiy0mfBRZxZFrwI.NskQ3xl7aepLwSMu', NULL, '2026-06-05 00:20:33', '2026-06-05 00:20:33'),
(8, 'Wali Kelas XI TJKT 1', 'wali.xi.tjkt.1@wepinjam.id', '0000000014', 'XI TKJ 1', 'wali_kelas', NULL, NULL, NULL, '$2y$12$kEe.DB6SUZHYk11WJ8p7ae/7U8rrpGMImYAwnjSeNChzY3tgunHCi', NULL, '2026-06-05 00:20:34', '2026-06-05 00:20:34'),
(9, 'Wali Kelas XI TJKT 2', 'wali.xi.tjkt.2@wepinjam.id', '0000000015', 'XI TKJ 2', 'wali_kelas', NULL, NULL, NULL, '$2y$12$tVNlGfYG670vZvGepdkHR.oNOGUVyjRWkILfOcIcjSVCymQMt8w8S', NULL, '2026-06-05 00:20:34', '2026-06-05 00:20:34'),
(10, 'Wali Kelas XI SIJA 1', 'wali.xi.sija.1@wepinjam.id', '0000000016', 'XI SIJA 1', 'wali_kelas', NULL, NULL, NULL, '$2y$12$o2wsJ1FhbnJaKtB7omdTK.clP04aq40Uiz.F0yyqQJgtxl4BI.Fc.', NULL, '2026-06-05 00:20:35', '2026-06-05 00:20:35'),
(11, 'Wali Kelas XI SIJA 2', 'wali.xi.sija.2@wepinjam.id', '0000000017', 'XI SIJA 2', 'wali_kelas', NULL, NULL, NULL, '$2y$12$SEYRlUTtzcIvzI3phEtqLe1DYJL56GHcyW2qu8/.cJLN/g1TJ9tdS', NULL, '2026-06-05 00:20:36', '2026-06-05 00:20:36'),
(12, 'Wali Kelas XII TJKT 1', 'wali.xii.tjkt.1@wepinjam.id', '0000000018', 'XII TKJ 1', 'wali_kelas', NULL, NULL, NULL, '$2y$12$Uyb1wGtsPry09FX4Msyn4.ye7k8TSQcB.KYLRa5sCCIULgtde4xDm', NULL, '2026-06-05 00:20:37', '2026-06-05 00:20:37'),
(13, 'Wali Kelas XII TJKT 2', 'wali.xii.tjkt.2@wepinjam.id', '0000000019', 'XII TKJ 2', 'wali_kelas', NULL, NULL, NULL, '$2y$12$Krj5iW24vrvmzv8OhJp1jOcli7p3DHL0u.HnDdCLAQaV6KaUbCMcW', NULL, '2026-06-05 00:20:38', '2026-06-05 00:20:38'),
(14, 'Wali Kelas XII SIJA 1', 'wali.xii.sija.1@wepinjam.id', '0000000020', 'XII SIJA 1', 'wali_kelas', NULL, NULL, NULL, '$2y$12$oFSQex0I2Py64PpQ9EzQ.O/4PdbKlxS9SlvNZnQ11AmzafuojpkiS', NULL, '2026-06-05 00:20:39', '2026-06-05 00:20:39'),
(15, 'Wali Kelas XII SIJA 2', 'wali.xii.sija.2@wepinjam.id', '0000000021', 'XII SIJA 2', 'wali_kelas', NULL, NULL, NULL, '$2y$12$2Cmr7JptPpJhyUUt1yfA5uKinURIiFhWs02NbBGz.wW5QussPdNsu', NULL, '2026-06-05 00:20:40', '2026-06-05 00:20:40'),
(16, 'Abdulloh Reza Permana', 'abdullohrezapermana@gmail.com', '17697/128/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$rBa62KY0Br1t.gDbNDI5wOZIUYftb.zB9NPamTm38COt8.EC6UwS2', NULL, '2026-06-05 00:21:55', '2026-06-05 00:21:55'),
(17, 'ACHMAD RASHYA ADITYA AFFANDI', 'achmadrashyaadityaaffandi@gmail.com', '17698/129/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$Wy0QQURe4/4.C9DSlVGTSOIiQRddZdDzzc8Z8UUniYXv14g7vmUzq', NULL, '2026-06-05 00:21:57', '2026-06-05 00:21:57'),
(18, 'AINNUR SYIFA AULIA', 'ainnursyifaaulia@gmail.com', '17699/130/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$UfttalNZdjkP.X90nG32d.rWwWTyG5GMo8Z.S0weHvkAx1pdNBPqa', NULL, '2026-06-05 00:21:58', '2026-06-05 00:21:58'),
(19, 'ALFIN YUSUF ANUGRAH', 'alfinyusufanugrah@gmail.com', '17700/131/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$HteLM6G4UBiIplGBzWX9x.zRKSLl7LJ/NbVVcA9Xh5rVwHzdZAaAK', NULL, '2026-06-05 00:21:59', '2026-06-05 00:21:59'),
(20, 'ALFIRA FIFI RIMADHINA', 'alfirafifirimadhina@gmail.com', '17701/132/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$Ww5swQ9Z88xJiEOZA.E5TOnCJAsXBHu1/eMZj3c3IR3xi6vceJgFu', NULL, '2026-06-05 00:22:00', '2026-06-05 00:22:00'),
(21, 'AMIRA KUSUMA DJATI', 'amirakusumadjati@gmail.com', '17702/133/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$X.zaFccQNLOijOA/GISLCO8PgQZnz2VyoaLuvxy0sQvw6o7VLQkju', NULL, '2026-06-05 00:22:01', '2026-06-05 00:22:01'),
(22, 'ANGGA RIZKY YUDHAYANA', 'anggarizkyyudhayana@gmail.com', '17703/134/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$1RQqb1cf2v5KwukAkwu/YOYqCXVZW./ybNZM9qvsutH2ZfDT0vYqm', NULL, '2026-06-05 00:22:02', '2026-06-05 00:22:02'),
(23, 'Anggun Aulia Anggana', 'anggunauliaanggana@gmail.com', '17704/135/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$/caw3xE2AbJP7RqKIpVVR.MxSHlN.vbqRrtPLuNF3iIwtBu9YvCo6', NULL, '2026-06-05 00:22:03', '2026-06-05 00:22:03'),
(24, 'ARDIAN DWI FAIQUL HIMAM', 'ardiandwifaiqulhimam@gmail.com', '17705/136/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$O5qicFKV4Yoyy2kxcfqqmuJcX25HhcIYkqKphowA7IMsstPA3IPrm', NULL, '2026-06-05 00:22:04', '2026-06-05 00:22:04'),
(25, 'ARMAND DESTIYAN', 'armanddestiyan@gmail.com', '17706/137/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$QXo7gj6ZqIknge1vX4BLvekYMepK956fXdOtQb3gYOz4.7gBnIa4.', NULL, '2026-06-05 00:22:05', '2026-06-05 00:22:05'),
(26, 'Aryaputra Reswara', 'aryaputrareswara@gmail.com', '17707/138/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$kJF.QlFH5Xcc2uXylR.YROa0AlRPoZlzWJVJTk4ESd5eYtZ8NwSCq', NULL, '2026-06-05 00:22:06', '2026-06-05 00:22:06'),
(27, 'AUREL AULIA CITRA', 'aurelauliacitra@gmail.com', '17708/139/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$qf/eQ9o65wBL3ylCNhDzTupdLATaG9HGU2ZumGKeu9e1ZGFcW4V9O', NULL, '2026-06-05 00:22:07', '2026-06-05 00:22:07'),
(28, 'AURELITA RATU OCTALIVYA SALSABILLA', 'aurelitaratuoctalivyasalsabilla@gmail.com', '17709/140/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$sA362VWXicIPmEyZVkSesO0j/TirsNM.y9BMn9Yo7lxMODM.CKHMa', NULL, '2026-06-05 00:22:08', '2026-06-05 00:22:08'),
(29, 'AZIZAH IZANDRA', 'azizahizandra@gmail.com', '17710/141/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$CbBxmJvdgb.TAulWgDAkD.EoaGENSbM0BhDSmKNKXDKioYSywAxUi', NULL, '2026-06-05 00:22:09', '2026-06-05 00:22:09'),
(30, 'BELLADINA BAGUS PUTRI', 'belladinabagusputri@gmail.com', '17711/142/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$JZrRkn.Zj8uwKhd7codw5eYmpQQGUAvc8xtDmSNw6T46q.MFAQVXG', NULL, '2026-06-05 00:22:10', '2026-06-05 00:22:10'),
(31, 'Bernando akmal juni siswanto', 'bernandoakmaljunisiswanto@gmail.com', '17712/143/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$a9HMTUsiT.l/0HijjAuGzO.322xIZXCb/cvhHToSMqda/5/fOq23q', NULL, '2026-06-05 00:22:11', '2026-06-05 00:22:11'),
(32, 'CHARISSA EVELIN DEVITASARI PRASETYA', 'charissaevelindevitasariprasetya@gmail.com', '17713/144/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$cfz2d/oSBp3qcGi76a5ibuBRHnKI7tfrbpGNL3g/5qSgPmHORRhSm', NULL, '2026-06-05 00:22:12', '2026-06-05 00:22:12'),
(33, 'DEAN ALAM JUNIANSYAH', 'deanalamjuniansyah@gmail.com', '17714/145/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$GEoulHN37YwIEk.ZtrAbf.pVMm3a7/kLGSBdUpcp9a7/bQspG6bzm', NULL, '2026-06-05 00:22:13', '2026-06-05 00:22:13'),
(34, 'DENDY ACHMAD SODIQIN', 'dendyachmadsodiqin@gmail.com', '17715/146/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$gDaK1qiXtqatarz9wHuj2uPay4nU2IC2URPf5eRxh33LPPxCW7yE2', NULL, '2026-06-05 00:22:14', '2026-06-05 00:22:14'),
(35, 'Dendy Ardiansyah', 'dendyardiansyah@gmail.com', '17716/147/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$9mEVB450VEn9Wl0soQLtx..dXOrN2OEF573zeM2TJiuZCtM5JpJqu', NULL, '2026-06-05 00:22:15', '2026-06-05 00:22:15'),
(36, 'Devina Aulia Putri', 'devinaauliaputri@gmail.com', '17717/148/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$U9aIDOsn2dv2eS9yYi2roOqi1mwDdM44UqqAnNuog8Ihw2FvRmJNm', NULL, '2026-06-05 00:22:16', '2026-06-05 00:22:16'),
(37, 'DIMAS NOVYAN PRATAMA', 'dimasnovyanpratama@gmail.com', '17718/149/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$ON3AqSq0CTrVu4dt5wfMSu1RRCiAF23yCynHUjtRbMY7y3bYl7Y5e', NULL, '2026-06-05 00:22:17', '2026-06-05 00:22:17'),
(38, 'ELFIDA ZAHWAH LEVIA ROSA', 'elfidazahwahleviarosa@gmail.com', '17719/150/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$2WF0AwXpYywuyg2iwJTogOSMcg6S7fVJy7XQjjnYa19Ljlyl5Y95u', NULL, '2026-06-05 00:22:18', '2026-06-05 00:22:18'),
(39, 'FAKHRI AKRAM WAHYUDIN WIAAM', 'fakhriakramwahyudinwiaam@gmail.com', '17720/151/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$qmaehLZcpFasOaEF8qcQVOp6udHn.czqzD0PT3DldGj4uhQRtmuuC', NULL, '2026-06-05 00:22:19', '2026-06-05 00:22:19'),
(40, 'Fande Agis Indra Permata', 'fandeagisindrapermata@gmail.com', '17721/152/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$30o0uBHekrAd49.DAassTOSYPCD3u4qhkF3OpvtLWn8VEM5b7TEsC', NULL, '2026-06-05 00:22:20', '2026-06-05 00:22:20'),
(41, 'FARHAN RAMADHAN PUTRA ABDUL ROKHIM', 'farhanramadhanputraabdulrokhim@gmail.com', '17722/153/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$UEGik5.qgCmDeRO.cMNDO.Raf.4KvlsBCpUedAXhc3W2.LQ2eG.gy', NULL, '2026-06-05 00:22:21', '2026-06-05 00:22:21'),
(42, 'Ferryawan eka putra ferdiansyah', 'ferryawanekaputraferdiansyah@gmail.com', '17723/154/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$hL9ZuiNvIZ/AABND2cg2Ze2nhb1jBnIJmMI6IeDRrusRyoFQyNCeG', NULL, '2026-06-05 00:22:23', '2026-06-05 00:22:23'),
(43, 'FIRZA KIRANA PUTRI RAMADHANI', 'firzakiranaputriramadhani@gmail.com', '17724/155/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$k/fGtetMAF6a7jWjcVlkSOcqdZr6i1pGRrMAjCyjI8SwNLrqRWc0S', NULL, '2026-06-05 00:22:24', '2026-06-05 00:22:24'),
(44, 'GEOREYY EKA SONI PUTRA', 'georeyyekasoniputra@gmail.com', '17725/156/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$PRLAWRDAv9QCyMN8uCkRpuksY4MVng8qJkAF.JUeBywZ/GkfSPiem', NULL, '2026-06-05 00:22:25', '2026-06-05 00:22:25'),
(45, 'GITA TSABITA HUWAIDA', 'gitatsabitahuwaida@gmail.com', '17726/157/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$qcbyedMKDaoftBzdWGJmsOJkmhr4LbrCEf.TxZqBaR64AZF6vmZWu', NULL, '2026-06-05 00:22:26', '2026-06-05 00:22:26'),
(46, 'HABIBULLAH ABDUL ZAKY ARRAID', 'habibullahabdulzakyarraid@gmail.com', '17727/158/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$ScZjCxqoYLp8vf.O5Hy7n.Q9xEoG3ppiS/iI3G1yyN7dr8dtOwfh.', NULL, '2026-06-05 00:22:27', '2026-06-05 00:22:27'),
(47, 'HAFIZH SYARIFUDDIN ASLAM', 'hafizhsyarifuddinaslam@gmail.com', '17728/159/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$peJ9KKTZoc/HIH8sEPB/OO0h/hL3LSK5Uv1Q2RmtOV/YOGGJ8jvju', NULL, '2026-06-05 00:22:28', '2026-06-05 00:22:28'),
(48, 'INDAH TRINURIHA', 'indahtrinuriha@gmail.com', '17729/160/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$CdLY3X4LZPNDmxiiD8OOPOmr/zD9moXD/r/mPfX.9KeSiiyR./nJK', NULL, '2026-06-05 00:22:29', '2026-06-05 00:22:29'),
(49, 'IRSYA NABILA', 'irsyanabila@gmail.com', '17730/161/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$Dkh5nvU0/kg.VSs/.xp4H.7aoKibfpg93it.3nVzilDwb4IGehm/G', NULL, '2026-06-05 00:22:30', '2026-06-05 00:22:30'),
(50, 'Jannatin Alya Maharani', 'jannatinalyamaharani@gmail.com', '17731/162/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$j/io4hOyG.PgC4xqC/Fqf.yEB3MKXYzE6Fbb.FvH8Na8qe9wvyASK', NULL, '2026-06-05 00:22:31', '2026-06-05 00:22:31'),
(51, 'Jihan Aulia Rahma Ariansyah', 'jihanauliarahmaariansyah@gmail.com', '17732/163/065', 'X SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$Fv5Ew8N2jdjM0xFaQnkQYO/LfQNDjiQXeA.TLFvGsFyjH14hrSMg.', NULL, '2026-06-05 00:22:32', '2026-06-05 00:22:32'),
(52, 'ACHMAD ZIDAN ALI ABBROOR', 'achmadzidanaliabbroor@gmail.com', '17769/682/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$lCau1jNpk97T40jYQlrff.um8my0jRWs4c70KvE3qMiJNdVaRaBxe', NULL, '2026-06-05 00:23:16', '2026-06-05 00:23:16'),
(53, 'Adinda Aula Kailatussadiah', 'adindaaulakailatussadiah@gmail.com', '17770/683/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$xEttumYk8UAHJP.Ngc.MXOjeIMX2t5GKQ2u9RcIZTZrgwJy9/0IUe', NULL, '2026-06-05 00:23:17', '2026-06-05 00:23:17'),
(54, 'AHMAD AL SHYFA PUTRA LESMANA', 'ahmadalshyfaputralesmana@gmail.com', '17771/684/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$1QuSkt2cTnn0.lNFuq53juNrkKfaHyntcUpxzV27TdYEFQeUKYPw2', NULL, '2026-06-05 00:23:18', '2026-06-05 00:23:18'),
(55, 'AKHMAL NUR SAPUTRA', 'akhmalnursaputra@gmail.com', '17772/685/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$jy2wSy53u0NzeP1ykJjoke6MGnyVDgdwcDFhXeeththGe7kKqMsKC', NULL, '2026-06-05 00:23:19', '2026-06-05 00:23:19'),
(56, 'ALISE ORIONA JANITRA', 'aliseorionajanitra@gmail.com', '17773/686/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$B2dlVmHvBw3gt1f.eE1faumgrIVfIhW7lAD6bm4Sf3Waqe6P6Keua', NULL, '2026-06-05 00:23:20', '2026-06-05 00:23:20'),
(57, 'Alviandra Yanuar Prasnandito', 'alviandrayanuarprasnandito@gmail.com', '17774/687/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$7u7NkRXVCEE4Oj7YHu22huMPQWNQ4bCBgupDxJ/fUFBMa4.0aInI.', NULL, '2026-06-05 00:23:21', '2026-06-05 00:23:21'),
(58, 'ANGGA FINOYA', 'anggafinoya@gmail.com', '17775/688/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$J3d40lpFu1V2g4wXWiL9juaggYxYc1emuCUXccmHlbuT/TpcKjihS', NULL, '2026-06-05 00:23:23', '2026-06-05 00:23:23'),
(59, 'ANGGI NURAHMA', 'angginurahma@gmail.com', '17776/689/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$L.HX33xEqa4zWGiqo1kdU.Wu5UkDBYG5BWyOHYaglji6lyhynDyqa', NULL, '2026-06-05 00:23:24', '2026-06-05 00:23:24'),
(60, 'ANNISA BALQISTANIA NAURI', 'annisabalqistanianauri@gmail.com', '17777/690/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$PBxmzZ9Ku17vfuTaf82w4eVJtIqXYN6ujTL.gtvxz8MtAKYsus20K', NULL, '2026-06-05 00:23:25', '2026-06-05 00:23:25'),
(61, 'ARDAN MUBAROK', 'ardanmubarok@gmail.com', '17778/691/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$WwMljfthZq7bEwyH4McO0ehY4c99O5BMYR/cGHxOa9yK4U07dwvbi', NULL, '2026-06-05 00:23:26', '2026-06-05 00:23:26'),
(62, 'AULIA WANDA PUTRI', 'auliawandaputri@gmail.com', '17779/692/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$ALYAQkzOmSCKcPpV9aPsze8fFAKVf9ny2LUWD3IzffSyAxBIkCB9K', NULL, '2026-06-05 00:23:27', '2026-06-05 00:23:27'),
(63, 'AZHA KINADRA DAVALYNO YUSUF', 'azhakinadradavalynoyusuf@gmail.com', '17780/693/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$o4dv2PhEUwxJLUcA3SRcU.qUvYVVtUgiwBHkOBaBtqpIAUK3xrXyq', NULL, '2026-06-05 00:23:28', '2026-06-05 00:23:28'),
(64, 'Billy Natanael Denata', 'billynatanaeldenata@gmail.com', '17781/694/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$8meDyqt5BbwYGTndZX9otuqnMYrRaVv.530TM1WT/aa.ffF7jptda', NULL, '2026-06-05 00:23:29', '2026-06-05 00:23:29'),
(65, 'CANTIKA ZENALIA', 'cantikazenalia@gmail.com', '17782/695/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$BcsbQuSEO/CQNqOsLqvASu28RoOl0t8//uRNWt3DKVSuh0J5w/ljO', NULL, '2026-06-05 00:23:30', '2026-06-05 00:23:30'),
(66, 'Choky Satria Hermawan', 'chokysatriahermawan@gmail.com', '17783/696/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$fzFikpcURL2tyOHMLGWByeil6pcatgIYk3eHwYEyuTdraoTSDtiR6', NULL, '2026-06-05 00:23:31', '2026-06-05 00:23:31'),
(67, 'CICILIA IKA HANDAYANI', 'ciciliaikahandayani@gmail.com', '17784/697/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$FVP5KzcISjGhcInWdrlZdOShpAM70y2jPW./zQGplvmKV0e/d2Dpa', NULL, '2026-06-05 00:23:32', '2026-06-05 00:23:32'),
(68, 'COSTARICA VINO PRATAMA', 'costaricavinopratama@gmail.com', '17785/698/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$RPl2FvAWVO3pO5Egh.4KOuDx3SIaexXEOtt51wv.M4HOrIoT1mW7e', NULL, '2026-06-05 00:23:33', '2026-06-05 00:23:33'),
(69, 'Danadyaksa Rizqullah Nararya Mahawira', 'danadyaksarizqullahnararyamahawira@gmail.com', '17786/699/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$89/PriaHxwOlRtqGkl8AWucSS2HG.hCMadkeo2oG6sFVLgnuYRLn.', NULL, '2026-06-05 00:23:34', '2026-06-05 00:23:34'),
(70, 'DAVINA AISYAH PUTRI', 'davinaaisyahputri@gmail.com', '17787/700/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$R9.T3t.MiariIN7lKhUnwO28uB1At95kkYvwI/HftmwNbEs/LzTI6', NULL, '2026-06-05 00:23:35', '2026-06-05 00:23:35'),
(71, 'Devika Aurillia', 'devikaaurillia@gmail.com', '17788/701/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$aAA9qqdYOPTC46wFhUg9WOwaK5twWwA877zVwhLa3VSxAMbzTIBA2', NULL, '2026-06-05 00:23:36', '2026-06-05 00:23:36'),
(72, 'Dion Wahyu Kurniawan', 'dionwahyukurniawan@gmail.com', '17789/702/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$.ocQMC38/b3l7iFL3j7XlOa3/tnDca9DHPnWd.mgTYSb.yWBQO.o2', NULL, '2026-06-05 00:23:37', '2026-06-05 00:23:37'),
(73, 'ESTI PALUPI MAYA RATIH', 'estipalupimayaratih@gmail.com', '17790/703/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$NluT/5eg/EzDbks65Z7eJOUSbCiP7ZpAtcVf.smbadU/GlEIgN4qi', NULL, '2026-06-05 00:23:38', '2026-06-05 00:23:38'),
(74, 'FADHIL ALIF ALDIANSYAH', 'fadhilalifaldiansyah@gmail.com', '17791/704/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$tZLfWDkr7x..vhRPiMeuxOwFYeFCdfQNP2x2XL6iNiBxfGixYJ04m', NULL, '2026-06-05 00:23:39', '2026-06-05 00:23:39'),
(75, 'FAMEYSHA AURA OLIVIA', 'fameyshaauraolivia@gmail.com', '17792/705/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$VGBJbGalWgLVPFSPyA.DculV3CpAxtqI0xNtpdal/g9kShsGmTQ5m', NULL, '2026-06-05 00:23:41', '2026-06-05 00:23:41'),
(76, 'FERINIA BILQIS ALUNA', 'feriniabilqisaluna@gmail.com', '17793/706/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$ac2hJodszvZ4u0LsZAdz0uLVnNTP4aK1/7/kMNDe8B2A56MhYi7r6', NULL, '2026-06-05 00:23:42', '2026-06-05 00:23:42'),
(77, 'FERNANDO AUDITA EKO PRATAMA', 'fernandoauditaekopratama@gmail.com', '17794/707/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$K6M9Snab.leqRP.kUShrUOzxhR7MuFGo4iJrhSq6MtfkQQVr8i0tK', NULL, '2026-06-05 00:23:43', '2026-06-05 00:23:43'),
(78, 'GALIH PANCA SEPTIA BASIT', 'galihpancaseptiabasit@gmail.com', '17795/708/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$jjpTvQyt/8/Phmf/pIOUDOXiv/jxgLCWxRmEqjtnlO1AbbHds9TkO', NULL, '2026-06-05 00:23:44', '2026-06-05 00:23:44'),
(79, 'GISYA SANDRA AGUSTINA', 'gisyasandraagustina@gmail.com', '17796/709/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$l6U4WSfXfiyrqr3XqMgaHuIfKw8UoOrzDdwPNXStVVA1jlr3YmG1S', NULL, '2026-06-05 00:23:45', '2026-06-05 00:23:45'),
(80, 'Intan elok wahyuni', 'intanelokwahyuni@gmail.com', '17797/710/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$n//42n/f9JH2ZBvJnqyLeOWMu/0zp7zeqluYJPgsh3XQLoUgkRxd6', NULL, '2026-06-05 00:23:46', '2026-06-05 00:23:46'),
(81, 'JULAIKHA', 'julaikha@gmail.com', '17798/711/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$WInVnxePXcblDQNCPpJ/mOWZIjj31wL1eaE6bJME0adPLhtRGxDXy', NULL, '2026-06-05 00:23:47', '2026-06-05 00:23:47'),
(82, 'KEYZIA MUTIARA ANASTASIA LOUPATTY', 'keyziamutiaraanastasialoupatty@gmail.com', '17799/712/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$EwZQs50pRK.g7gQeYVMQIueED5Gr.s38RNteppETJ3fB1PZhGtcqW', NULL, '2026-06-05 00:23:48', '2026-06-05 00:23:48'),
(83, 'KHAIRUNNISA QURRATUAIN', 'khairunnisaqurratuain@gmail.com', '17800/713/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$xY01kvsLusoIv7Vxy6543uEL8oFkKP3PFFK.KPBXREhsnD3O89T2.', NULL, '2026-06-05 00:23:49', '2026-06-05 00:23:49'),
(84, 'KHANZAH AURELIA AZAHRA', 'khanzahaureliaazahra@gmail.com', '17801/714/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$9gPchLzhwzxlaj5oxcIL/eqDdSJE86Udvvk1thaXo7OZATEysLeZu', NULL, '2026-06-05 00:23:50', '2026-06-05 00:23:50'),
(85, 'LAILATUS SARIFAH', 'lailatussarifah@gmail.com', '17802/715/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$l3vSGJhETvBUHS6QT.WU3OU5i55.WtR0FROHAThG/mkKQEg9trLVi', NULL, '2026-06-05 00:23:51', '2026-06-05 00:23:51'),
(86, 'LAILIA SYAFITRI', 'lailiasyafitri@gmail.com', '17803/716/066', 'X TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$6.Ed.wpA2B5ibG8ZoUE/sO/7yL7txaI.M4D57Ztxjg.W9n.kIU3KO', NULL, '2026-06-05 00:23:52', '2026-06-05 00:23:52'),
(87, 'KEYLA ALEYSIA FAJARINA', 'keylaaleysiafajarina@gmail.com', '17733/164/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$bqFO.Vlon3L/j3YyVxzJc.K0UhApWeTJ57SscDORGip.oh60JPJZC', NULL, '2026-06-07 16:30:53', '2026-06-07 16:30:53'),
(88, 'LEXA ALVIAN WAHYUDO PUTRA', 'lexaalvianwahyudoputra@gmail.com', '17734/165/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$VS4Kc4HsOOIMfWa3K0X9r.QlKTZRZI3FNxSu4Iyc91epdIPwklzPi', NULL, '2026-06-07 16:30:54', '2026-06-07 16:30:54'),
(89, 'MEYLANI AULIA PUTRI', 'meylaniauliaputri@gmail.com', '17735/166/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$uAnH8lUCRAqsfXFlYKuZgO7.hwKnDJhAIbIAFwtYnf.UC0HCtezK6', NULL, '2026-06-07 16:30:55', '2026-06-07 16:30:55'),
(90, 'MOCHAMAD RIZAL PRATAMA', 'mochamadrizalpratama@gmail.com', '17736/167/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$41bFntfsrQx145jks/1m8ewV3NfTkfzvlZS5jvcZlXsVVxpVaWWha', NULL, '2026-06-07 16:30:56', '2026-06-07 16:30:56'),
(91, 'MOCHAMMAD FAREL RAMADHAN', 'mochammadfarelramadhan@gmail.com', '17737/168/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$xPfJFlPUPT/Ik1.b.qhYDOTtGwHBp6t9nzMTrDivf4tlsjtKHRzFG', NULL, '2026-06-07 16:30:57', '2026-06-07 16:30:57'),
(92, 'MOCHAMMAD MICHELLE ZENINKA RAHMAN', 'mochammadmichellezeninkarahman@gmail.com', '17738/169/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$b8A.gRJDEbPVBqFdvQa2qePYV6ePCBeEpoxAp8z.GfV/Kn3arN3WK', NULL, '2026-06-07 16:30:58', '2026-06-07 16:30:58'),
(93, 'Moh Dafa Rofiul Huda', 'mohdafarofiulhuda@gmail.com', '17739/170/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$SD/VkIs6jSNFI1bIE3gl0entINoOEgr24EbxV1Ku81ReFXTCBtyWy', NULL, '2026-06-07 16:30:59', '2026-06-07 16:30:59'),
(94, 'MUHAMAD NOH ALAMSYAH', 'muhamadnohalamsyah@gmail.com', '17740/171/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$u5arWs19HZvwWBQT0jFTG.mLtmm.U4yQKznZMhlKB.MoG71WNCNrO', NULL, '2026-06-07 16:31:01', '2026-06-07 16:31:01'),
(95, 'MUHAMMAD LUTFI FIRMANSYAH', 'muhammadlutfifirmansyah@gmail.com', '17741/172/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$Ch4wIVmwGYkkZWaA4qfgVuWOxYSDHjnKfQkqxskOJXaKk4GZlK0r.', NULL, '2026-06-07 16:31:02', '2026-06-07 16:31:02'),
(96, 'MUHAMMAD RAFFA FATHUL IAQUINTA', 'muhammadraffafathuliaquinta@gmail.com', '17742/173/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$O9A7.YU8DYve9KMwoli5KuemjyUdfDUo1vIz7r/aFFbefBfWsNjuS', NULL, '2026-06-07 16:31:03', '2026-06-07 16:31:03'),
(97, 'MUHAMMAD REZA ZUBAIR', 'muhammadrezazubair@gmail.com', '17743/174/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$UyWqt/h5TdmNZBAwr3m17elQdm/Lt.ltuEs/hPqfuTwvb3gqJcJWC', NULL, '2026-06-07 16:31:04', '2026-06-07 16:31:04'),
(98, 'MUHAMMAD RIFKI NUR FADILLAH', 'muhammadrifkinurfadillah@gmail.com', '17744/175/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$HzjBtXClwoODKJgJGYXzbea4KVPXWjJG0NopWdrOMxTTkarGeHPY.', NULL, '2026-06-07 16:31:05', '2026-06-07 16:31:05'),
(99, 'Nararya Ezkha Wardhana', 'nararyaezkhawardhana@gmail.com', '17745/176/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$VES/bY0EeM1tSv/nQaNx5.RZ/39r0mWD.t06.Zdwl1.nKAy3mpPCC', NULL, '2026-06-07 16:31:07', '2026-06-07 16:31:07'),
(100, 'Naura Anindyapavita Ramadhani', 'nauraanindyapavitaramadhani@gmail.com', '17746/177/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$SENfsblURd6xL7RC.Pa8IeVHULTpTGXNQ2gDu5Vc7CvNJadxy9L4G', NULL, '2026-06-07 16:31:08', '2026-06-07 16:31:08'),
(101, 'Nayla Atqiya', 'naylaatqiya@gmail.com', '17747/178/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$Wu5yW/G4edE6p5BizLNgQOSgfbRyzKnc1WqH5w5RJZkSfOKyHj1Ra', NULL, '2026-06-07 16:31:09', '2026-06-07 16:31:09'),
(102, 'NOVI ANGGRAENI', 'novianggraeni@gmail.com', '17748/179/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$P2PDfK.g4w/Gc.p8EvQtyOuV6NU.aqSmD60COdJOLWrp3eCrisbqK', NULL, '2026-06-07 16:31:10', '2026-06-07 16:31:10'),
(103, 'PRIAMBODO NUR CAHYO', 'priambodonurcahyo@gmail.com', '17749/180/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$WUcEzFFk9erFQVteZsMqLOktB2oLpnsh35c.AVCs.PzHxRVOoM7BK', NULL, '2026-06-07 16:31:11', '2026-06-07 16:31:11'),
(104, 'PUTRI APRILIA', 'putriaprilia@gmail.com', '17750/181/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$vDCNyUkjcSr56Nj89rvuFej3VhM3i5zeb6xRG3Dlum32XjCfIrsFS', NULL, '2026-06-07 16:31:12', '2026-06-07 16:31:12'),
(105, 'PUTRI AYU AMELLYA', 'putriayuamellya@gmail.com', '17751/182/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$1iCGhbsiWJhU0F0/054GzeICTVkCCb9XsQjrbbPCs7/hO7ZtDdvja', NULL, '2026-06-07 16:31:13', '2026-06-07 16:31:13'),
(106, 'REGITA FANYA NAVIZA', 'regitafanyanaviza@gmail.com', '17752/183/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$tFL9U/IGx84L/5INt.W3aenPJ.t4/60DiuXcadkAi2seZUnpq9ZMS', NULL, '2026-06-07 16:31:14', '2026-06-07 16:31:14'),
(107, 'RISKA FAKHRUNISA', 'riskafakhrunisa@gmail.com', '17753/184/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$jGZDKu7vmG1UVLeRBrsdzujL1Md98uHJ9UsVxKH8ILgxMAUHJj28i', NULL, '2026-06-07 16:31:15', '2026-06-07 16:31:15'),
(108, 'RIZAL EKA SAPUTRA', 'rizalekasaputra@gmail.com', '17754/185/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$bkg9LNtiPlCX7YNa0Qj/e.uiWDqhu89l7O3rrGPFPBKdTxazNrPg.', NULL, '2026-06-07 16:31:17', '2026-06-07 16:31:17'),
(109, 'Sahisnu Nagata Ogya', 'sahisnunagataogya@gmail.com', '17755/186/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$lGMtXY5m5NC5l2hQwrpYbeymnIcYv4Ohe72CNzvg9D18RaZV1oqqG', NULL, '2026-06-07 16:31:18', '2026-06-07 16:31:18'),
(110, 'SALSABILA AFIFAH HAFIZAH', 'salsabilaafifahhafizah@gmail.com', '17756/187/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$x5XV.63sUBbYaw1PGsqaaenz2kzL5Aqnnzwd6G58xxIFEzHjV9HIu', NULL, '2026-06-07 16:31:19', '2026-06-07 16:31:19'),
(111, 'Sayyidah yazmin Al maghfira', 'sayyidahyazminalmaghfira@gmail.com', '17757/188/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$GD2j7sdetJ/f5seAFvM8Y.0T5CM1606P0AIn5Dbq7b/1LaS2B.rHK', NULL, '2026-06-07 16:31:20', '2026-06-07 16:31:20'),
(112, 'SHERIN ANNISA RAMADHANI', 'sherinannisaramadhani@gmail.com', '17758/189/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$Cjn5nCj852aSzMLvCJ9EYejMWOAMMRgW3FzqA27kKPtexlF7N2T2C', NULL, '2026-06-07 16:31:21', '2026-06-07 16:31:21'),
(113, 'SULISTYOWATI', 'sulistyowati@gmail.com', '17759/190/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$VfLhSDjamHUGxTorPu7wHeQvYsEs0/9.7hCQsC0mCERvbkO6LoYdu', NULL, '2026-06-07 16:31:22', '2026-06-07 16:31:22'),
(114, 'Sulthan Mahdy Khosyi', 'sulthanmahdykhosyi@gmail.com', '17760/191/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$Pql2FANg.wr3EYWi9dDd2.w3x28VawOb5Tezfm7/Y2yYuZStfu9Z2', NULL, '2026-06-07 16:31:23', '2026-06-07 16:31:23'),
(115, 'SVETLANA NOVITA STEVANI LUHUKAY', 'svetlananovitastevaniluhukay@gmail.com', '17761/192/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$0FUS8A676nRTGHITi9c.9e7u0QDL/rQjRmpnTJdNOuMvf.NnYywH2', NULL, '2026-06-07 16:31:24', '2026-06-07 16:31:24'),
(116, 'Thadea Azra Levina', 'thadeaazralevina@gmail.com', '17762/193/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$K8mXpiklEylWnY9G4RW.XOJ4g/UbLbQTtOy5c466e2msHQpK5BP..', NULL, '2026-06-07 16:31:25', '2026-06-07 16:31:25'),
(117, 'TONNY RISQY SATRIYA PUTRA PRADAMA', 'tonnyrisqysatriyaputrapradama@gmail.com', '17763/194/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$UqANQwsPX474mOxyUSDe3ObGj6egIvKL8v70FfL/n9DRqwz2QpWKK', NULL, '2026-06-07 16:31:27', '2026-06-07 16:31:27'),
(118, 'VIERA CALLISTA BILLA', 'vieracallistabilla@gmail.com', '17764/195/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$xunh3kqhy0WnpNxYclINfeXBNkrLrWNi4ah//7p1ABDoSzY.hbDfe', NULL, '2026-06-07 16:31:28', '2026-06-07 16:31:28'),
(119, 'YUSUF ARYA WICAKSANA', 'yusufaryawicaksana@gmail.com', '17765/196/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$MxqR2NzGp0GJTfvg5zrHgejhKSEe9OfWMnLfqz0yp8HW.eRX5nLIS', NULL, '2026-06-07 16:31:29', '2026-06-07 16:31:29'),
(120, 'Zahratu syita', 'zahratusyita@gmail.com', '17766/197/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$/VysuOVi.Y1GprfWUZ6axODfnjxZlI3O7NYalmDRWSbjRJthifK2m', NULL, '2026-06-07 16:31:30', '2026-06-07 16:31:30'),
(121, 'ZAHWA RINDA AZURA', 'zahwarindaazura@gmail.com', '17767/198/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$772NHNTVMvklDSivRif1qOKyEfJ0HybfnJT9x7EqaUORevpjfzai.', NULL, '2026-06-07 16:31:31', '2026-06-07 16:31:31'),
(122, 'ZALFA MELDIANA SAFITRI', 'zalfameldianasafitri@gmail.com', '17768/199/065', 'X SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$PUGAFuPwUDPJ1WFbD8RhTexmHHLAn1dgf4CZUQforZ28Llqql2okG', NULL, '2026-06-07 16:31:32', '2026-06-07 16:31:32'),
(123, 'Luna Almira Kustomo', 'lunaalmirakustomo@gmail.com', '17804/717/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$1DwQOZgE8GnjmEE01GZAEOxwedraMMi2AP6xPxcvGgJy5fCsUL96O', NULL, '2026-06-07 16:31:59', '2026-06-07 16:31:59'),
(124, 'M ARKA NAUVAL', 'markanauval@gmail.com', '17805/718/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$6GkHd27HskYPeiu/jvhf5uaLnDKwdAUnW7QNNZupl1CSLXGSVnoeK', NULL, '2026-06-07 16:32:00', '2026-06-07 16:32:00'),
(125, 'Marisa Dea Khusnul Khotimah', 'marisadeakhusnulkhotimah@gmail.com', '17806/719/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$L0CjIRKSNT2LrnomOmbsm.GZtu2XL2kSGBNxFLwpWxhCCm2xmphH2', NULL, '2026-06-07 16:32:02', '2026-06-07 16:32:02'),
(126, 'MAULIKA APRILIANSAH', 'maulikaapriliansah@gmail.com', '17807/720/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$RWBwVW2h/6AMSNaw6IJdSu9U.ZN8PRMsvYq3BhshpWWV85s5iYUZC', NULL, '2026-06-07 16:32:03', '2026-06-07 16:32:03'),
(127, 'MFAHRIL ISLAM', 'mfahrilislam@gmail.com', '17808/721/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$Kgx5Ur5/qzbgjwU18yqbIe.W5y5OxXc2OIHH0mxQrhGQr8VaRKHpu', NULL, '2026-06-07 16:32:04', '2026-06-07 16:32:04'),
(128, 'MOCH RIFQY FIRMANSYAH', 'mochrifqyfirmansyah@gmail.com', '17809/722/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$nC1L79QVZNd4T77mV2CHhewvJ9PGtoZmud1jZYKdqKLz7absiueyu', NULL, '2026-06-07 16:32:05', '2026-06-07 16:32:05'),
(129, 'MOCHAMAD AMIR ZAKKY', 'mochamadamirzakky@gmail.com', '17810/723/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$swxefZ/lsB0dhifK3AdSZOUE.njS85PBDrHr4mT9wlNUmr3Hm.GLy', NULL, '2026-06-07 16:32:06', '2026-06-07 16:32:06'),
(130, 'MUHAMMAD NAUFAL ALFARIS', 'muhammadnaufalalfaris@gmail.com', '17811/724/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$BzQmfhiKjvtuuf6qQ9xl2OXQy6v6X1KxS1snAlmN9lKuHSz53QhDu', NULL, '2026-06-07 16:32:07', '2026-06-07 16:32:07'),
(131, 'Muhammad Raffi Pradikso', 'muhammadraffipradikso@gmail.com', '17812/725/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$gM6ARSrSNFZB7W1rDroEJerIzQp2bxZvqWPzUGgQQXBRrKixJuit6', NULL, '2026-06-07 16:32:08', '2026-06-07 16:32:08'),
(132, 'Musyarofah', 'musyarofah@gmail.com', '17813/726/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$IrPK4hXZnBijg2fVRnWCL.fe4qXd5dGyvT02Xc/e1wTUESN9lyoQa', NULL, '2026-06-07 16:32:10', '2026-06-07 16:32:10'),
(133, 'NAIMATUS SYARIFAH', 'naimatussyarifah@gmail.com', '17814/727/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$6FwkOUEvy7ta3DNpqxrrTOgyAArlBKvg8DJGbZjEilDQ8AwW4zVni', NULL, '2026-06-07 16:32:11', '2026-06-07 16:32:11'),
(134, 'Nayla Fitria Ardini', 'naylafitriaardini@gmail.com', '17815/728/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$oz33il13jqUANpZC8Y8BfujqP4AGkyHhsttWZJrxPfxiQPcfwofOK', NULL, '2026-06-07 16:32:12', '2026-06-07 16:32:12'),
(135, 'NOUVAL AZZAM SATRIA', 'nouvalazzamsatria@gmail.com', '17816/729/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$CeNqixf7uDE568.gsPzNQOst6f3FqS1MAsr5IQ4Vl6rviYyyhUhtO', NULL, '2026-06-07 16:32:13', '2026-06-07 16:32:13'),
(136, 'PUTRI CYNTHIA ABELLIA', 'putricynthiaabellia@gmail.com', '17817/730/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$CbpIT2aZVag99.RkzxmIm.6.eGRSrVCNVnRfqjd/rd78jC9Ramd5C', NULL, '2026-06-07 16:32:14', '2026-06-07 16:32:14'),
(137, 'Putri Nur Halisah', 'putrinurhalisah@gmail.com', '17818/731/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$JnzCd1nnWCdAa53oZJVNnOpQYL.2Q6O4V4CS0GxJK8i/af3qBZfry', NULL, '2026-06-07 16:32:16', '2026-06-07 16:32:16'),
(138, 'RAFA DANENDRA PRATAMA', 'rafadanendrapratama@gmail.com', '17819/732/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$MvH8pMB6ZgTPq3.KuBzEkOl.MD6usYXSj2brnAX1b158QuqBfV0Uy', NULL, '2026-06-07 16:32:17', '2026-06-07 16:32:17'),
(139, 'REIHANA MELLIA ZEMMA', 'reihanamelliazemma@gmail.com', '17820/733/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$ih.r7cQwcTsJxhBB2VzcHOeg3KGgb12suUd.W7aJ9VTdHUtlFNqlK', NULL, '2026-06-07 16:32:18', '2026-06-07 16:32:18'),
(140, 'REISHA AYUDIA BINTANG RAMADHAN', 'reishaayudiabintangramadhan@gmail.com', '17821/734/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$vFqTgHym8X6hThMSlFWZA.Q/rRqGZuwS4dsn5lXfPyrFJd1u7n2Xm', NULL, '2026-06-07 16:32:19', '2026-06-07 16:32:19'),
(141, 'REVI ANDYANTO', 'reviandyanto@gmail.com', '17822/735/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$XTMA1H8tVHNVfU.Xhbeon.Mm.pVCpHgahcVFBoKz3IPzU/dX5qY56', NULL, '2026-06-07 16:32:20', '2026-06-07 16:32:20'),
(142, 'Rhacelluna Nuraisyah Ramadhani', 'rhacellunanuraisyahramadhani@gmail.com', '17823/736/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$y8lZep45Y7VE7GhGKUbjvOsKoNEShs8IjK2kZCpU3Hr4CINhgNsGu', NULL, '2026-06-07 16:32:21', '2026-06-07 16:32:21'),
(143, 'RIZKY WILDANI', 'rizkywildani@gmail.com', '17824/737/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$1laq1kxkIRVIG.Mdqa2/ie5AgT9/qlrtS34Jq0dx..RicyuaUKaF2', NULL, '2026-06-07 16:32:23', '2026-06-07 16:32:23'),
(144, 'SANDI WIJAYA', 'sandiwijaya@gmail.com', '17825/738/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$oPM/KB21tEcBaODQdm6zSeQwiGA.8fvGcacCz1KlVaGqyFCkzsXJi', NULL, '2026-06-07 16:32:24', '2026-06-07 16:32:24'),
(145, 'SHOFI WIDYANSYAH SAPUTRA', 'shofiwidyansyahsaputra@gmail.com', '17826/739/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$9UgxyDSTSMzQPqAsy6dzSOPixnbd/YE/TkjfFKRRJ4OiYiyFYBOjC', NULL, '2026-06-07 16:32:25', '2026-06-07 16:32:25'),
(146, 'SILVI ALIYAH EKA PUTRI', 'silvialiyahekaputri@gmail.com', '17827/740/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$gGvUUQ2O9A1GELNUxV1Q0.Itl5.I4Go.Pancb468v.LW7EeWxpM9K', NULL, '2026-06-07 16:32:26', '2026-06-07 16:32:26'),
(147, 'SINTA BELA PUTRI', 'sintabelaputri@gmail.com', '17828/741/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$M60wkYS2exWzsDOczjrECO8YrGXnVsZxwM9ZqJKILTeis04IPqSZO', NULL, '2026-06-07 16:32:27', '2026-06-07 16:32:27'),
(148, 'SINTA WIJAYANTI ZAHRO NUR HIDAYAH', 'sintawijayantizahronurhidayah@gmail.com', '17829/742/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$/qph6Pnr9qdsUnXCd8VJX.nm1xnct1cxItkpEgY8i86sDr31X6J/m', NULL, '2026-06-07 16:32:28', '2026-06-07 16:32:28'),
(149, 'Siti Nur Laila Setiyowati', 'sitinurlailasetiyowati@gmail.com', '17830/743/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$gX/NZEozICjt7pNw4yUwpuiwvsc8WGLJgpTOi2Xi6DweBjhOj4Ria', NULL, '2026-06-07 16:32:30', '2026-06-07 16:32:30'),
(150, 'SITI RAHMAWATI', 'sitirahmawati@gmail.com', '17831/744/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$IdLSGgiBQHwo2/MuLCqHCu.ys9whDqTWPCNHiSU9bX10RGzLOat26', NULL, '2026-06-07 16:32:31', '2026-06-07 16:32:31'),
(151, 'SYAHIRA AVRILISA ASHARI', 'syahiraavrilisaashari@gmail.com', '17832/745/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$1TcLd0OpqmI08hazbeh6BOBo/eHdhM2vCWOKEHbZ7m.v8i1JHHP76', NULL, '2026-06-07 16:32:33', '2026-06-07 16:32:33'),
(152, 'SYAKIRA AUREL AZALITA', 'syakiraaurelazalita@gmail.com', '17833/746/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$0kGB9cvyx7oQjgUGKef1neEtmV.tN.dE3YBEWivLv192GkIgLE5ce', NULL, '2026-06-07 16:32:34', '2026-06-07 16:32:34'),
(153, 'TANIA FARAH RANJANI', 'taniafarahranjani@gmail.com', '17834/747/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$VU1uiHa9./GHF6XczD5J3OkNVvBNBsTEffvwLDniHoPEbwl/pzR1K', NULL, '2026-06-07 16:32:35', '2026-06-07 16:32:35'),
(154, 'VEGA VERLITA AULIA', 'vegaverlitaaulia@gmail.com', '17835/748/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$QvZ5BwgxlmGYSbBZ5Slsfu34ecQ1SvO76qajBCql6c5xD9JcpRS4W', NULL, '2026-06-07 16:32:36', '2026-06-07 16:32:36'),
(155, 'WICHA ADIESTA NEDIATI', 'wichaadiestanediati@gmail.com', '17836/749/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$QfuT8DYlXAfv8PpSgkMwXOci/sHaybSJ135nPG/rymQThlPSlh17G', NULL, '2026-06-07 16:32:38', '2026-06-07 16:32:38'),
(156, 'ZIVANA ADZKA AMIRA', 'zivanaadzkaamira@gmail.com', '17837/750/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$W0.nc5Yvk682E95erSGNLeX7X0WuUi5TBsNPHmTqLz.dz8VEDKee6', NULL, '2026-06-07 16:32:39', '2026-06-07 16:32:39'),
(157, 'ZULFADHLI HAIDAR FADIL AKHTAR', 'zulfadhlihaidarfadilakhtar@gmail.com', '17838/751/066', 'X TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$f2LWFgmMqZCZ9aNvI4dwKenQ6qN/tweOajfWAdEg7H2dFvP3geFU.', NULL, '2026-06-07 16:32:40', '2026-06-07 16:32:40'),
(158, 'ACH IWAN DARMANSYAH', 'achiwandarmansyah@gmail.com', '18537/127/009', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$2KS7qIEPp1ta./EFOigQTecz1///xi.jfF0MDW5M4i7pvkUShSawW', NULL, '2026-06-07 16:36:29', '2026-06-07 16:36:29'),
(159, 'ADITYA FABIAN PRATAMA', 'adityafabianpratama@gmail.com', '18395/071/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$96GGSUbVVNp8faYeC4RThe0jiFrzXkainPXjmPe0OxcXOTwh5GDP2', NULL, '2026-06-07 16:36:30', '2026-06-07 16:36:30'),
(160, 'AHMAD ZAKARIA BAKTIAR', 'ahmadzakariabaktiar@gmail.com', '18397/073/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$VSg3YZpM6SxjrJjkB0maaeQUdZ0v35bg7RC9/OvdHjRk6gJqiBkTS', NULL, '2026-06-07 16:36:31', '2026-06-07 16:36:31'),
(161, 'AKBAR RADHITYA JAYA PRADANA', 'akbarradhityajayapradana@gmail.com', '18399/074/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$JaBDYCmufLs/BxuFtI2YSO8RF76BrQMhaPlMYZ8qBfn9qOsujVoyq', NULL, '2026-06-07 16:36:32', '2026-06-07 16:36:32'),
(162, 'ALENTA NADA PUTRI SHIFANA', 'alentanadaputrishifana@gmail.com', '18400/075/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$S96lVSGq2NPXgaLI7DkGe.dYPcohUxShonmY6nX2gVmGKBKepyGpG', NULL, '2026-06-07 16:36:33', '2026-06-07 16:36:33'),
(163, 'ALFIAN VIGO ARRAHMAN', 'alfianvigoarrahman@gmail.com', '18401/076/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$6q0M8DuOX5PrDZJKGqiIPeKYMj3JZrplQXzte4ag8ABc5jrDr7Mn2', NULL, '2026-06-07 16:36:34', '2026-06-07 16:36:34'),
(164, 'ALMIRA SHIVANIA PUTRI', 'almirashivaniaputri@gmail.com', '18402/077/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$GgqM3ZxdhPABxcK5x76Dj.B990V.KEPPeLLTn.tTyPL3dLV/WQW1e', NULL, '2026-06-07 16:36:35', '2026-06-07 16:36:35'),
(165, 'ANDIKA BAYU PRATAMA', 'andikabayupratama@gmail.com', '18403/078/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$hq17.ih6KrBNyg7tW0KSR.m.VhRMMeLaiWwKdCnuTzxNFBJBUGlyG', NULL, '2026-06-07 16:36:37', '2026-06-07 16:36:37'),
(166, 'ANGELLIYA CAHAYA PUTRI', 'angelliyacahayaputri@gmail.com', '18404/079/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$kqXgMnQ4qT/aGormbEoKuu1LwRdnG2QYfvzOeb3lTrorBpamTtPj6', NULL, '2026-06-07 16:36:38', '2026-06-07 16:36:38'),
(167, 'ANISA NOVI TRIHARSARI', 'anisanovitriharsari@gmail.com', '18405/080/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$RfwHXLGlJvGQdX78wWq0aOzjuZxVAAnzYntKwENXsaplIxeY/63N6', NULL, '2026-06-07 16:36:39', '2026-06-07 16:36:39'),
(168, 'AUREL SEVYA PUTRI', 'aurelsevyaputri@gmail.com', '18406/081/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$1LCSiiUxv8paJ/iVqFuXk.tn6m0LtBj.Y6O7c3uwGhCiVu4rGZ7KC', NULL, '2026-06-07 16:36:40', '2026-06-07 16:36:40'),
(169, 'AZAHRA RAHMA FITRI', 'azahrarahmafitri@gmail.com', '18407/082/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$GkXUeRGmbg8nmpyGVe6KJuGpbLwyKFUk9MM1bGgnetsaRIF8fdVdO', NULL, '2026-06-07 16:36:41', '2026-06-07 16:36:41'),
(170, 'CANTIKA EGARAISYA RAFIDA', 'cantikaegaraisyarafida@gmail.com', '18408/083/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$6MVRtYiina6b5KKmHyrJgOG46feIYMCvIRxcT7OA3YAMPaBJrgYZe', NULL, '2026-06-07 16:36:42', '2026-06-07 16:36:42'),
(171, 'DIMAS PUTRA ARSYA PRATAMA', 'dimasputraarsyapratama@gmail.com', '18410/085/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$7IPcmN/E100Ms21evhieh.XapMEV002mTYnlEVQDG21G92ZeLgorO', NULL, '2026-06-07 16:36:43', '2026-06-07 16:36:43'),
(172, 'DINAR RIZKI SAPUTRA', 'dinarrizkisaputra@gmail.com', '18411/086/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$ALeyyMu896K49Qk9N8rIwuUAr9obB5buMrPsWgW71x5IBqlqYByWC', NULL, '2026-06-07 16:36:44', '2026-06-07 16:36:44'),
(173, 'FAKHRI AMMAR HABIBURROHIM', 'fakhriammarhabiburrohim@gmail.com', '18412/087/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$4w.M3u2LUe6i3v0mk46Pz.n9GOp9npJd99FMFbkZSoZ1teE6BpfRO', NULL, '2026-06-07 16:36:45', '2026-06-07 16:36:45'),
(174, 'FATHI AMRULLAH SAPUTRA', 'fathiamrullahsaputra@gmail.com', '18413/088/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$h94/5FCzfzuztWDDYeZEjOyr7kaN/ImUXS/PKiL6jEOJFLrEc0p86', NULL, '2026-06-07 16:36:46', '2026-06-07 16:36:46'),
(175, 'FATHINA IFTITA SAHDA', 'fathinaiftitasahda@gmail.com', '18414/089/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$AHGe2JsUJfbnE5UljxJ7WulJ1SMM6g0v19fpP7iGD.6ZPliU/l8Gq', NULL, '2026-06-07 16:36:47', '2026-06-07 16:36:47'),
(176, 'FATTAN HADI PRATAMA', 'fattanhadipratama@gmail.com', '18415/090/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$UWwRTi0bPHhnsrdM9f2HcuEzzOU1h3nLpCTk82eqC5zY2/xQR845W', NULL, '2026-06-07 16:36:48', '2026-06-07 16:36:48'),
(177, 'FAZA LANA TAMA', 'fazalanatama@gmail.com', '18416/091/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$mtH/WH05ZjvBFnssu4kl7uAoQFfA9EQkPZqO7RgJA/xmzsrvMIA2C', NULL, '2026-06-07 16:36:49', '2026-06-07 16:36:49'),
(178, 'FEBRIAN TRISTAN SUKARNO', 'febriantristansukarno@gmail.com', '18417/092/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$tnfR6L4g8TpBncT5k3Vpxu6kXJYDRyFzWDL2rrzQ/YIFrScgUY64a', NULL, '2026-06-07 16:36:50', '2026-06-07 16:36:50'),
(179, 'FHERIZ PRAMADITA DAEFALANI', 'fherizpramaditadaefalani@gmail.com', '18418/093/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$EdsEDD6F4r4Qh.gsERZOpeELXmHzzj01KhM7nVeEPUhtr9FTCypMi', NULL, '2026-06-07 16:36:51', '2026-06-07 16:36:51'),
(180, 'ISNAINI RAMADANI', 'isnainiramadani@gmail.com', '18420/095/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$PvHPHCJXiwIUNqmoGK.5m.QAkIcmKoh6Si/s.WyfteJ9vtkbxESmW', NULL, '2026-06-07 16:36:52', '2026-06-07 16:36:52'),
(181, 'JASMINE PUTRI ANDRIANA SAKMAF', 'jasmineputriandrianasakmaf@gmail.com', '18421/096/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$bLAwYEz.k.PA2.Ld2.ryNe8dmHZ/Se6negyS8RQAjfZ0N9ogDaLD.', NULL, '2026-06-07 16:36:53', '2026-06-07 16:36:53'),
(182, 'LUTFIAH NUR IZZA', 'lutfiahnurizza@gmail.com', '18422/097/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$gsF6rUvB6oyHvrJtrK1.QeVTxT.bHP6bGu/o.5C4WSmudPJS3Eef2', NULL, '2026-06-07 16:36:55', '2026-06-07 16:36:55'),
(183, 'MAHARANI NURITA ANGGRAENI', 'maharaninuritaanggraeni@gmail.com', '18424/099/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$5wZpGHumDNnDuyzsaip13.RJ3oLEaYKalMOw0Z5RhZlK/VZI66hPe', NULL, '2026-06-07 16:36:56', '2026-06-07 16:36:56'),
(184, 'MEGA YULIANI', 'megayuliani@gmail.com', '18425/100/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$SCC4Df3.xHHiPUpC4lMlHeON2R3gtlOE6gv5S8WE8A2xPGpFAnf3C', NULL, '2026-06-07 16:36:57', '2026-06-07 16:36:57'),
(185, 'MEYRONALD RIFKY SAPUTRA', 'meyronaldrifkysaputra@gmail.com', '18426/101/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$K3K485dNzociq7VBS49qIeAbtQR9a/R9.X7AT89vuHJ/Mn3caYv7e', NULL, '2026-06-07 16:36:58', '2026-06-07 16:36:58'),
(186, 'MOCHAMMAD VICKY ISLAMI', 'mochammadvickyislami@gmail.com', '18427/102/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$1xeW3cRUhBpGAdDV.DJTN.Jv.VESLZm3m5giTKWeqUNz8/coZVr4G', NULL, '2026-06-07 16:37:00', '2026-06-07 16:37:00'),
(187, 'MOHAMMAD TARIQ AL JANABI', 'mohammadtariqaljanabi@gmail.com', '18428/103/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$R56tOs0DQ.5EN8gDJwqFbOfTLTxnxZKLzruR5i0YLDlr55FlK3hvS', NULL, '2026-06-07 16:37:02', '2026-06-07 16:37:02'),
(188, 'MUHAMMAD AKHADI AL MACHZUMI', 'muhammadakhadialmachzumi@gmail.com', '18429/104/065', 'XI SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$PK1B8SFs3bRQUFvM1cnvN.YyA4YoNdhhc0Tj0rn0TZxnIQGoH.I/G', NULL, '2026-06-07 16:37:03', '2026-06-07 16:37:03'),
(189, 'MUHAMMAD AQIL NAUFAL', 'muhammadaqilnaufal@gmail.com', '18430/105/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$I0qpehF6jqIAhAYaUteASuk5JfSHRFj4HxK3jwPamIa9e7mhxOgja', NULL, '2026-06-07 16:37:34', '2026-06-07 16:37:34'),
(190, 'MUHAMMAD FATHUR ROZIQIN', 'muhammadfathurroziqin@gmail.com', '18431/106/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$WZ6Zqkz0h3gZzGCUay2CauboIHiV/kDodwwqK2ZPBdZAuMGf2CKNm', NULL, '2026-06-07 16:37:35', '2026-06-07 16:37:35'),
(191, 'MUHAMMAD IRFAN MUSHTOFA', 'muhammadirfanmushtofa@gmail.com', '18432/107/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$l5.UEJNgyYAKCutvogc6Ze0WcBVShxVoV200/aQtQrNAHQgZlKc1O', NULL, '2026-06-07 16:37:36', '2026-06-07 16:37:36'),
(192, 'MUHAMMAD RAFIF FIRJATULLAH', 'muhammadrafiffirjatullah@gmail.com', '18433/108/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$cGtbRyw/aX.XN1a9/lmGaeSYxy10OhbUh5a/eglGD/sYx7Lgkrzju', NULL, '2026-06-07 16:37:38', '2026-06-07 16:37:38'),
(193, 'MUHAMMAD RAIHAN', 'muhammadraihan@gmail.com', '18434/109/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$HdUKqlB0e/p8xXB.7OEiPuY9H4vJBMO1Ni3Nbq39MSkYPBgattBvi', NULL, '2026-06-07 16:37:39', '2026-06-07 16:37:39'),
(194, 'NADHIFATUS ZALFA', 'nadhifatuszalfa@gmail.com', '18435/110/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$7CqPJyz7PSAMqZIF1RbK0.AnnrLpha21pgn.uSmMjvYs/l38vM2Lu', NULL, '2026-06-07 16:37:40', '2026-06-07 16:37:40'),
(195, 'NADIA ATHANAIFA YUONO', 'nadiaathanaifayuono@gmail.com', '18436/111/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$uI.D5cCIq3crcnO38GM..uWGmkiZCpgYrSFQ7qCzlxZHOo3WAi0We', NULL, '2026-06-07 16:37:41', '2026-06-07 16:37:41'),
(196, 'NADIA CHINTIA PUTRI', 'nadiachintiaputri@gmail.com', '18437/112/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$y93JUJe0E42MgFSNkvryVOpKlwRwHFeicva8eHTpWeifddb/WWLsi', NULL, '2026-06-07 16:37:42', '2026-06-07 16:37:42'),
(197, 'NAFIS ACHMAD MARUF', 'nafisachmadmaruf@gmail.com', '18438/113/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$xrnfAGcgx1b/xHcqKa/UTO2a4PRk9fdxGjZ643JsPhAM0D1U2e90q', NULL, '2026-06-07 16:37:43', '2026-06-07 16:37:43'),
(198, 'NAFISA RAMADHANI', 'nafisaramadhani@gmail.com', '18439/114/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$7OazVbj9RtcCm2KpCmsHseh5myIY8oFodIL7PvoxsHwHYssyh2UYe', NULL, '2026-06-07 16:37:44', '2026-06-07 16:37:44'),
(199, 'NAYLA AMANDA KHAIRUNNISA', 'naylaamandakhairunnisa@gmail.com', '18440/115/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$I/d5CE8Vsnc3M5sKp2Zjgu3PG0F8g7dW0kVQOZeS70T.Js3rOXYCC', NULL, '2026-06-07 16:37:45', '2026-06-07 16:37:45'),
(200, 'NIA AMELIA PUTRI', 'niaameliaputri@gmail.com', '18441/116/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$6VBiPwvNExrcKBtmX5bUNO4tgU0Gj6kCE0mbSTtHItOnjp87UttLu', NULL, '2026-06-07 16:37:46', '2026-06-07 16:37:46'),
(201, 'PRADITA GALUH SENDRY PRATIWI', 'praditagaluhsendrypratiwi@gmail.com', '18442/117/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$ct.yUs9ROP9VeddNHRkCZOB/9A.IybAj9oEqsYNOumX9DD6NrSguK', NULL, '2026-06-07 16:37:47', '2026-06-07 16:37:47'),
(202, 'RADITYA DIAZ PAHLEVI SAFARUDIN', 'radityadiazpahlevisafarudin@gmail.com', '18444/119/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$E/iSu.cWBWGX33QnUH2ThOD8SHqgfWPm0kaazcaiqcNxcAYQJm6Ai', NULL, '2026-06-07 16:37:48', '2026-06-07 16:37:48'),
(203, 'RAFI ANGGA NUGROHO', 'rafiangganugroho@gmail.com', '18445/120/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$yOIc4No81WbNN/U6b4.3Me27cZmgXNwbHAk4eAXdaWK2fuAKMbuBO', NULL, '2026-06-07 16:37:49', '2026-06-07 16:37:49'),
(204, 'REVALDO EDMODA ARDANA', 'revaldoedmodaardana@gmail.com', '18446/121/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$jaTJePD7WBwnjWJys30HGehgpMY4zQ.5.t6kj6q23fkzfqTbp3UAW', NULL, '2026-06-07 16:37:50', '2026-06-07 16:37:50'),
(205, 'RIBUT HARI YAHYA', 'ributhariyahya@gmail.com', '18447/122/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$oMNVwUnWQ/FVmDt65DWKdOjeQtKB4Z3RKhGidPgWb7w3F/Jb4NqV6', NULL, '2026-06-07 16:37:51', '2026-06-07 16:37:51'),
(206, 'SAFIRA TUNAJAH', 'safiratunajah@gmail.com', '18448/123/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$4jYZ9qVu31P6WhM8FGgWOOQRXhoJXNxm5HY8DAnkjRQlIW11uoYo6', NULL, '2026-06-07 16:37:52', '2026-06-07 16:37:52'),
(207, 'SALWA OKTAVIA MAHARANI', 'salwaoktaviamaharani@gmail.com', '18449/124/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$uP.XxzXhyekm3zCL1woIgOOACQMnVtBnLWXGbPNptLgWAH7Fdnpya', NULL, '2026-06-07 16:37:53', '2026-06-07 16:37:53'),
(208, 'SANNY AULIA SYAHRANI', 'sannyauliasyahrani@gmail.com', '18450/125/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$m.5qHmMo2hHk3W7151S1QeP1b0yR5ntZXLwn8AOfE9V9TW0quDYma', NULL, '2026-06-07 16:37:54', '2026-06-07 16:37:54'),
(209, 'SELKY CALLISTA RETNADI', 'selkycallistaretnadi@gmail.com', '18451/126/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$IM43SH0YXisP1uSnjvr.ReJRXX9txw4Iu2jQ4fQKoZ1DAhQsMXomS', NULL, '2026-06-07 16:37:56', '2026-06-07 16:37:56'),
(210, 'SHELIA FITRI RAHMAWATI', 'sheliafitrirahmawati@gmail.com', '18452/127/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$DCmn1eaaHfzMu3b9Ypi6yOrS2lvX9wO1gv8wWnb17XOm6a5hdqulO', NULL, '2026-06-07 16:37:57', '2026-06-07 16:37:57'),
(211, 'SHOFA ANNISATUS ZAHRA', 'shofaannisatuszahra@gmail.com', '18453/128/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$X9UTO2/leqVKqdGlE0nBI.fvHG/3pPnGSNp/DPkj9l6TwJjNBPmNi', NULL, '2026-06-07 16:37:58', '2026-06-07 16:37:58'),
(212, 'SILVI ANITASARI', 'silvianitasari@gmail.com', '18454/129/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$lKp3AlQIsuZ.yfBkufrYSemrmzsbYef18ih9X28U2omB.Au/15A9S', NULL, '2026-06-07 16:37:59', '2026-06-07 16:37:59');
INSERT INTO `users` (`id`, `name`, `email`, `nis`, `kelas`, `role`, `foto_profil`, `no_wa`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(213, 'SITI FATIMATUZ ZAHRO', 'sitifatimatuzzahro@gmail.com', '18455/130/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$gUK/xmpAna05xmABxv4FgODJXGov9xVoO4UQoJAlMz8kyLmznE9W2', NULL, '2026-06-07 16:38:00', '2026-06-07 16:38:00'),
(214, 'SITI NAURAH ISLAMI PUTRI', 'sitinaurahislamiputri@gmail.com', '18456/131/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$Y/OykQwT.g760Mn59mxvmelMObLRMbb1dbq8oJ4kchhhwak7IxZNa', NULL, '2026-06-07 16:38:02', '2026-06-07 16:38:02'),
(215, 'SOFI WULANDARI', 'sofiwulandari@gmail.com', '18457/132/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$AmBsNnKz35VZ7LL0.g98I.VHXBj5tvEKFgskdNm2gnBoAesvV2xOS', NULL, '2026-06-07 16:38:03', '2026-06-07 16:38:03'),
(216, 'SONIA SINTA PUTRI', 'soniasintaputri@gmail.com', '18458/133/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$l/seZEIxZbvuUlZrC1ExqOY76V8.33uCeONuWDL2Pr/vNefz.qL3i', NULL, '2026-06-07 16:38:04', '2026-06-07 16:38:04'),
(217, 'SULTAN YUDHISTIRA ASMARRAMAN SYAH', 'sultanyudhistiraasmarramansyah@gmail.com', '18459/134/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$XE2XOU7ebQbroHWgRkUkM./brYen5fAFm6qv.d9hFU7dmaltxSQsW', NULL, '2026-06-07 16:38:05', '2026-06-07 16:38:05'),
(218, 'VIOLA PUTRI RAMADANI', 'violaputriramadani@gmail.com', '18460/135/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$wioloBhvBkTAVZAbyHa.ZO/fV5jB3zOPNhTn8rMXwiBNCwO3Z4P1O', NULL, '2026-06-07 16:38:06', '2026-06-07 16:38:06'),
(219, 'YAN ARDIANSYAH', 'yanardiansyah@gmail.com', '18461/136/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$hji9kKHg21RcbSnutA.dD.J4zrKLmD3GU/iwmZ6d5Pd.YuWdqtQS2', NULL, '2026-06-07 16:38:07', '2026-06-07 16:38:07'),
(220, 'ZAHRATUL WARDA AULIA', 'zahratulwardaaulia@gmail.com', '18462/137/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$cK7X4NJ0TQP1QdpnF.GI9ezA1zl5QiFdw5pu1uKUgvaEBR5vx4l2S', NULL, '2026-06-07 16:38:08', '2026-06-07 16:38:08'),
(221, 'ZAKIYAH FIRDAUSI ABDILLAH', 'zakiyahfirdausiabdillah@gmail.com', '18463/138/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$ANUE8CW6Qaps8IRH8andF.5G7DoPganFPV2yvZEh26RJYlj9Joh4.', NULL, '2026-06-07 16:38:09', '2026-06-07 16:38:09'),
(222, 'ZASKIA CILLA RADHITA', 'zaskiacillaradhita@gmail.com', '18464/139/065', 'XI SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$dn2kfHuhGc5s4/fRBVxiHO7bnKgSsnfIlZWH.UKGaLyf.ME7rpKWu', NULL, '2026-06-07 16:38:10', '2026-06-07 16:38:10'),
(223, 'ADINDA JUNIAR PRAMITA', 'adindajuniarpramita@gmail.com', '18465/611/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$hVURDW0J.HqDINK6s67J/OZjrE.T5t6EbOOaXATsLS/7/GAvvYeP6', NULL, '2026-06-07 16:38:51', '2026-06-07 16:38:51'),
(224, 'AHMAD FADILI', 'ahmadfadili@gmail.com', '18468/614/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$.1PbW/Lw6zyY7KTG3YQo6esdTFZTGBkJImAnbqiB3/AybcTSEdNVW', NULL, '2026-06-07 16:38:52', '2026-06-07 16:38:52'),
(225, 'AISYAH SAFIR KUMALA', 'aisyahsafirkumala@gmail.com', '18469/615/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$rIG9cvdpXXJtWn0/eY1lneIUqdW2SNeR/9GGe/7322MCBloxYH/rq', NULL, '2026-06-07 16:38:53', '2026-06-07 16:38:53'),
(226, 'ALMIRA JIHAN TALITA', 'almirajihantalita@gmail.com', '18470/616/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$6WNRNc8la3maTNX1tBSHPe.yeIRTiIjmMx/Qmnl4Ep8mo31noowBa', NULL, '2026-06-07 16:38:54', '2026-06-07 16:38:54'),
(227, 'ANIDA DUMI RAMADHANI', 'anidadumiramadhani@gmail.com', '18471/617/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$Ihj/gzVsMa6icdnJAwVlvuIoRJtQc4gJBVCFAvud.jJLJp/y6UXoS', NULL, '2026-06-07 16:38:55', '2026-06-07 16:38:55'),
(228, 'ANNISA RAHMADANI BISYAUQIN', 'annisarahmadanibisyauqin@gmail.com', '18472/618/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$kBAv9Ok1O8L4itxtcv5Bx.3MFwdpsTsN67tfbJNmEKo.gGBllYo0y', NULL, '2026-06-07 16:38:56', '2026-06-07 16:38:56'),
(229, 'ARINGGA FIRLI ANANTA', 'aringgafirliananta@gmail.com', '18473/619/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$zPKsnvjZ96/977U3Bl1cCu8fOBtBkrepcKDdPGCF7QZM2XhAf7CMa', NULL, '2026-06-07 16:38:57', '2026-06-07 16:38:57'),
(230, 'BAGAS NOVANDA PUTRA YUDISTIRA', 'bagasnovandaputrayudistira@gmail.com', '18474/620/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$y9lW.0tTsUXfkdRASuYD6.uiSyNnPPIp.HsUYVk45eqK0B6xp4F9y', NULL, '2026-06-07 16:38:58', '2026-06-07 16:38:58'),
(231, 'BULAN CANTIKANESA', 'bulancantikanesa@gmail.com', '18475/621/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$gLVCcchHWH8rW4kpfcpfY.05ZCCgbn1EieV86NCuZvIGuEGKa8ZjO', NULL, '2026-06-07 16:38:59', '2026-06-07 16:38:59'),
(232, 'BUNGA MEIRIZA PUTRI', 'bungameirizaputri@gmail.com', '18476/622/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$fnHZD8sQ0oGJ6vAzx.wdm.v3LUHmZNn6bZhJGUdkYI1erRcOca63W', NULL, '2026-06-07 16:39:00', '2026-06-07 16:39:00'),
(233, 'CHESTA FAJAR PRASETYA', 'chestafajarprasetya@gmail.com', '18477/623/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$zAHE.BFSTPERll8AZJmX6uQAvgqeVPXoPF/uRwbWUhTBqohfbJvwG', NULL, '2026-06-07 16:39:02', '2026-06-07 16:39:02'),
(234, 'DAVA RUSLI HASAN FIRDAUS', 'davaruslihasanfirdaus@gmail.com', '18478/624/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$Q58LJ9nzjQfX/ejzteLbreUFq5Zh9VOU4cGTn217g7lEejJiLKfq6', NULL, '2026-06-07 16:39:03', '2026-06-07 16:39:03'),
(235, 'DESTI SULISTIYOWATI', 'destisulistiyowati@gmail.com', '18479/625/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$pTDmPSxqgx8xtdGbpJpMWuNwoN7PZujxLyBlLSkGRLaBf0I01VExy', NULL, '2026-06-07 16:39:04', '2026-06-07 16:39:04'),
(236, 'DEVI AULIYA', 'deviauliya@gmail.com', '18480/626/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$YWNv7LvEQYn/e4pDEZxOgegS/znB.1XdGnWZg.huL6n3F78Bgkr0q', NULL, '2026-06-07 16:39:05', '2026-06-07 16:39:05'),
(237, 'DIANA ANDRIANI NOVITASARI', 'dianaandrianinovitasari@gmail.com', '18481/627/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$QGjx1Ktdg4PTA9W/BvARxOi46q/u755tKFePlL.t1Me7T.a1OnPE6', NULL, '2026-06-07 16:39:06', '2026-06-07 16:39:06'),
(238, 'DINA SUJIATI', 'dinasujiati@gmail.com', '18482/628/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$Yd.t2y7UB9fbKQ70IWdDSuPL/u/XbZMmHACmU6CgMNapGr0eZxoEq', NULL, '2026-06-07 16:39:07', '2026-06-07 16:39:07'),
(239, 'DIVA KARTIA AURELIA', 'divakartiaaurelia@gmail.com', '18483/629/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$b/giF19j8EAYBz9wio5RtOPjQ73qt2P62zu310wewmGKidLXWOrLS', NULL, '2026-06-07 16:39:08', '2026-06-07 16:39:08'),
(240, 'FAHILMA MAHINDRA', 'fahilmamahindra@gmail.com', '18484/630/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$h0/zHHBcuJsadJ4yOA9yfOUhl49acJXXicXLsuvudEeYlYnd..mNq', NULL, '2026-06-07 16:39:09', '2026-06-07 16:39:09'),
(241, 'FALIA SISKA RAHMALINDA', 'faliasiskarahmalinda@gmail.com', '18485/631/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$j4R9l0wMFA0FO0oHc/92Ee49s/hzu76DQRIAvox0MTFbUxIs.zVn6', NULL, '2026-06-07 16:39:11', '2026-06-07 16:39:11'),
(242, 'FIRMANSYAH', 'firmansyah@gmail.com', '18486/632/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$NkTtMOlyC9SEzKVUgYT2aewmiucen5Vc2VHUgp/wEoAShHVffIVCW', NULL, '2026-06-07 16:39:12', '2026-06-07 16:39:12'),
(243, 'JENNY TALITHA', 'jennytalitha@gmail.com', '18488/634/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$4cIE2.liza89rzodi0T6r.8TEDiHHDInEFzVia1zHtzjN0JUnF2Om', NULL, '2026-06-07 16:39:13', '2026-06-07 16:39:13'),
(244, 'JEREMIA AGUSOFIANTINUS MULYADI', 'jeremiaagusofiantinusmulyadi@gmail.com', '18489/635/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$awzJsMGbvU1.K37cb3ibEujXkv8btA6LYhh/0Z5FRWRY0BKU/1.8u', NULL, '2026-06-07 16:39:14', '2026-06-07 16:39:14'),
(245, 'JIHAN CYNTHIA DEWI LARASATI', 'jihancynthiadewilarasati@gmail.com', '18490/636/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$nQqUg06SuruT.NQFfzZdJ.jzv.9UMFRug3R5Cr3di4yfnYzEasBey', NULL, '2026-06-07 16:39:15', '2026-06-07 16:39:15'),
(246, 'JIWA DWI SAHPUTRA', 'jiwadwisahputra@gmail.com', '18491/637/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$Cl612sSvsY6jLVCV9sxG5uCHSCAjuGO2N//rmv6fYx.xWE3LBWyuK', NULL, '2026-06-07 16:39:16', '2026-06-07 16:39:16'),
(247, 'LAILATUL NUR AZKIYAH', 'lailatulnurazkiyah@gmail.com', '18492/638/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$.Bf5bJ0YJeafoIy7lSr01eh8FVM2.FhZtL3yjmh41E34Y21HMSEL6', NULL, '2026-06-07 16:39:17', '2026-06-07 16:39:17'),
(248, 'LENNY ARDIANI', 'lennyardiani@gmail.com', '18493/639/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$owzy5NrfYB5O23NtUSgnxef5mcdNTGblnfKnOMuTTUUksMnOnDp0G', NULL, '2026-06-07 16:39:19', '2026-06-07 16:39:19'),
(249, 'LINTANG SHANDY LANANG SEJATI', 'lintangshandylanangsejati@gmail.com', '18494/640/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$rxuHMWKHAI68chN65Xo.b.HlkJDNdJKHb4pxIWW4T8uvYdhQIz6Qi', NULL, '2026-06-07 16:39:20', '2026-06-07 16:39:20'),
(250, 'LUCKY IRVANSYAH', 'luckyirvansyah@gmail.com', '18495/641/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$zZGmc.GlyqywG6RtJmNamuOhZXe5KWQm/IKc2yY.Vp.4ULBWdsid2', NULL, '2026-06-07 16:39:21', '2026-06-07 16:39:21'),
(251, 'M RAFI RISQI PUTRA', 'mrafirisqiputra@gmail.com', '18496/642/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$hzQBGesdhxN8OMrI/jUD1uwjes8P1cvabECD1zzr3FiPUT7fNGXWi', NULL, '2026-06-07 16:39:22', '2026-06-07 16:39:22'),
(252, 'MELLIA NAJWA INAYA NETA', 'mellianajwainayaneta@gmail.com', '18497/643/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$HBrQjlCgmOGCSQZvK/lqKuQf18BDUVqi3Z2iauwpOoELSt6e8RFUm', NULL, '2026-06-07 16:39:23', '2026-06-07 16:39:23'),
(253, 'MOCHAMMAD EKO PRASETYO', 'mochammadekoprasetyo@gmail.com', '18499/645/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$BSLPNIYJdtH2va6V81Lv5.o7EFQ7ZjVujTJdEJIkthOI/Wb2J0VhW', NULL, '2026-06-07 16:39:24', '2026-06-07 16:39:24'),
(254, 'MUHAMMAD EGGY KURNIAWAN', 'muhammadeggykurniawan@gmail.com', '18500/646/066', 'XI TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$nQ1h6P9YZFro4AndGT3Ysu2RGrrbYKGlyq7PPx3aIESnV8HJ3FH.m', NULL, '2026-06-07 16:39:25', '2026-06-07 16:39:25'),
(255, 'MUHAMMAD ISAKI PRANANDA', 'muhammadisakiprananda@gmail.com', '18501/647/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$egqOwxSM7li7lrFNCJ1kzu6G3vXIZjG5js0kHnhD6LrGU1z.Prfvy', NULL, '2026-06-07 16:39:58', '2026-06-07 16:39:58'),
(256, 'MUHAMMAD NOVAL IRWANSYAH', 'muhammadnovalirwansyah@gmail.com', '18502/648/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$kJvu.ZOvb3e0A0yOytDXnepv9NTGqqm.gl5fbRl4OtVOum5/i0rKe', NULL, '2026-06-07 16:40:00', '2026-06-07 16:40:00'),
(257, 'MUHAMMAD RASYA BACHRUL ALAM', 'muhammadrasyabachrulalam@gmail.com', '18503/649/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$PMSseuMg1FWySzt4rAs41OvTO7FxF3k9Rr7mH/4AKvUR7wPPrn7pa', NULL, '2026-06-07 16:40:01', '2026-06-07 16:40:01'),
(258, 'NANDA WULAN DWI SAPUTRI', 'nandawulandwisaputri@gmail.com', '18504/650/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$YzFN8Et8iL1AZhUz2uT3Buf/4jjfgrlwSFSzGNdLPTc26VPWKb/Ue', NULL, '2026-06-07 16:40:02', '2026-06-07 16:40:02'),
(259, 'NARAYA PUTRI ARDAIS', 'narayaputriardais@gmail.com', '18505/651/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$wFQ68cZ.jajFSZE2cHF3uuH6oezucI2IjKuwDanu4rI53JbOKkYGe', NULL, '2026-06-07 16:40:03', '2026-06-07 16:40:03'),
(260, 'NASYUWA MUALIFA', 'nasyuwamualifa@gmail.com', '18506/652/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$rYLRvws1iNFbJ2eB9isAwuZn7am0dPdmIZ5VGBhkZOYsNe0sGZ/li', NULL, '2026-06-07 16:40:04', '2026-06-07 16:40:04'),
(261, 'OCCHA TASYA ANANTA', 'occhatasyaananta@gmail.com', '18507/653/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$fkc6EJE68X0X9qBOpliL1Oy.R3DAg5QlyUm5e7bDquKCfDC8isX86', NULL, '2026-06-07 16:40:05', '2026-06-07 16:40:05'),
(262, 'PANEMBRAMA PANATANAGARA', 'panembramapanatanagara@gmail.com', '18508/654/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$UEH8LltBmocg6JwjrIh3yuSWbVP2COs..jrAiYN/tCg8cEat9/XBq', NULL, '2026-06-07 16:40:06', '2026-06-07 16:40:06'),
(263, 'PINGKI HANDAYANI', 'pingkihandayani@gmail.com', '18509/655/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$gj13rM3MG6SEolzgvwP6gekraorZtiz1vQdMsWBkTUmJS4nGjYeBS', NULL, '2026-06-07 16:40:08', '2026-06-07 16:40:08'),
(264, 'PUTRI MAHARANI', 'putrimaharani@gmail.com', '18510/656/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$xEy2xAe1i9/EngZY5Hrc4uO4ueqBhXZe8OqaZUGias/wpnkzuuYYS', NULL, '2026-06-07 16:40:09', '2026-06-07 16:40:09'),
(265, 'PUTRI MEILINDA', 'putrimeilinda@gmail.com', '18511/657/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$uddOFMqeU9OARzSlivmi7e9VInVjyiiULN1q1.DmaVHaExo1.N/Ga', NULL, '2026-06-07 16:40:10', '2026-06-07 16:40:10'),
(266, 'QUROTA AYUN NISA', 'qurotaayunnisa@gmail.com', '18512/658/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$AF9iKp9igwNf4Czm3vp.NOOaThBba0zuuN1QH/e0WlFBjb54x/qMS', NULL, '2026-06-07 16:40:11', '2026-06-07 16:40:11'),
(267, 'RAFA ADIRA NAFASHA', 'rafaadiranafasha@gmail.com', '18513/659/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$y.t7m/hignb.3N2omSMKpOl7SXPX1xNmFJPRW9Ww3hPjnOWv2eo22', NULL, '2026-06-07 16:40:12', '2026-06-07 16:40:12'),
(268, 'RAFFI AHMAD MAULANA', 'raffiahmadmaulana@gmail.com', '18514/660/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$TJrOTsPQA4wxsyZj24gGqeH3pBum41WlbUgLBVwKdEboU42uv3BF6', NULL, '2026-06-07 16:40:13', '2026-06-07 16:40:13'),
(269, 'REVINA OCTAVIA CICILIANTI', 'revinaoctaviacicilianti@gmail.com', '18515/661/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$9h7QjTRzLMuKLOJkG6wVM.cf3Q/ScKEiU4pjBkeKUQg5WVU6wVgQu', NULL, '2026-06-07 16:40:14', '2026-06-07 16:40:14'),
(270, 'RIYUSANDI GAMANDANU', 'riyusandigamandanu@gmail.com', '18516/662/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$CfSi1q.0qXzCFEAGIaxmfO2UVioeo029Dj8K/rlP.aCQZMBJ20wiO', NULL, '2026-06-07 16:40:15', '2026-06-07 16:40:15'),
(271, 'RIZKY DARMA SETYAJI', 'rizkydarmasetyaji@gmail.com', '18517/663/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$.DuBKo2H64boeHTkI.1fhOPUjKZOeAoWSZCMLWDDCjjD/XdEbW1cC', NULL, '2026-06-07 16:40:16', '2026-06-07 16:40:16'),
(272, 'RIZKY FERNANDA SYARIEF', 'rizkyfernandasyarief@gmail.com', '18518/664/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$6nFQk7xmA3H/toTyHDrw7uVo4L30/ViOsenYFqdsFpyi6w7BKn0/m', NULL, '2026-06-07 16:40:17', '2026-06-07 16:40:17'),
(273, 'ROHMATUL KHASANAH', 'rohmatulkhasanah@gmail.com', '18519/665/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$kUwLgcwpy2oEtFZ3u1Y7IeQ9ROBeyNF9dqNJDElykSUs5ZWXE/9z6', NULL, '2026-06-07 16:40:18', '2026-06-07 16:40:18'),
(274, 'SANDY WAHYU PRATAMA', 'sandywahyupratama@gmail.com', '18520/666/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$R1QRaY2A/3hr8s0NCTbVZ.5AfOGNB.bNayun6.jIeDZoWnMT9mdji', NULL, '2026-06-07 16:40:19', '2026-06-07 16:40:19'),
(275, 'SANI WILDAN RISAY', 'saniwildanrisay@gmail.com', '18521/667/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$/X4CS9wVpEVNnRQbjFU19OF1lteJV3LbIHwpNhZhCf2wOZwn.Ecsa', NULL, '2026-06-07 16:40:20', '2026-06-07 16:40:20'),
(276, 'SATRIA AHMAD KUSUMA', 'satriaahmadkusuma@gmail.com', '18522/668/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$xZufvsxJa/MRCHm49AOLVuVxORPtssPep05YYZk3Kp.w/zPcXNS1q', NULL, '2026-06-07 16:40:21', '2026-06-07 16:40:21'),
(277, 'SATRIA WIBAWA', 'satriawibawa@gmail.com', '18523/669/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$uKU3Tvf7gzMLtHO0IXVR3OOmTiPg2gxm4n.047bgzebjmbyrbzYgu', NULL, '2026-06-07 16:40:22', '2026-06-07 16:40:22'),
(278, 'SEKI', 'seki@gmail.com', '18524/670/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$nSiZOypvC.aLbWiyQtkzp.szUe2miiKBP8hyoPl2tPnZCUIfXgFZu', NULL, '2026-06-07 16:40:23', '2026-06-07 16:40:23'),
(279, 'SELVIA RAMADANITA SARI', 'selviaramadanitasari@gmail.com', '18525/671/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$gssKV9xDPHdqCj.CtuD0.eid/AIs5mfChocSLzRdRSFQRCIRryhXu', NULL, '2026-06-07 16:40:24', '2026-06-07 16:40:24'),
(280, 'SHERLYN ANGGITA PRATIWI', 'sherlynanggitapratiwi@gmail.com', '18526/672/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$mjtYq0Y2HUJ8anJn9gx8qeBKgYLKSmZtnkjzTOIaCNFgwcqMLyk4C', NULL, '2026-06-07 16:40:25', '2026-06-07 16:40:25'),
(281, 'SITI AISYAH', 'sitiaisyah@gmail.com', '18527/673/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$dUtXRoAFdAcWypUxWYlr3ONJD7Rk5bKWtUtctG8pNLKF0Xj2Vbhfa', NULL, '2026-06-07 16:40:26', '2026-06-07 16:40:26'),
(282, 'SITI HADIYATI RUKMANA', 'sitihadiyatirukmana@gmail.com', '18528/674/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$zvJ1B0oM7SO1Irl5ksJkTOsgS7NacNrMu82Pl5JeVRMiA0kQ0Mta6', NULL, '2026-06-07 16:40:27', '2026-06-07 16:40:27'),
(283, 'SOFIA MAULINA LOVA', 'sofiamaulinalova@gmail.com', '18529/675/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$2yvQCIInYgzHJuIVfNS1IOXUUWXoayI5RXSETwYKK02LqbSJx6P2G', NULL, '2026-06-07 16:40:29', '2026-06-07 16:40:29'),
(284, 'SYIFAH PURNAMASARI', 'syifahpurnamasari@gmail.com', '18530/676/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$ZEDGsK89u0Nfg3x0M3EmheaoiIx.UDt4j4xGptGdln3TEILCdbKfm', NULL, '2026-06-07 16:40:30', '2026-06-07 16:40:30'),
(285, 'TAUFIQUROHMAN', 'taufiqurohman@gmail.com', '18531/677/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$R1ifRis7Ytsx6DV04M9En.328wN1q0NzYDg3A9MF9BTfJ4sG8CWCi', NULL, '2026-06-07 16:40:31', '2026-06-07 16:40:31'),
(286, 'THORIQUL MAGALLO ELSHIRAZY', 'thoriqulmagalloelshirazy@gmail.com', '18532/678/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$4KXrmRf6A/s.pp/CHeAcWOK6nj.dMO3KoN1Z.22j3pA346GdXSQpm', NULL, '2026-06-07 16:40:32', '2026-06-07 16:40:32'),
(287, 'TSAABITHA DZAAKIYYATUS ROCHMAN', 'tsaabithadzaakiyyatusrochman@gmail.com', '18533/679/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$OJB1KVMfj8l6WD16TDD4uO.luNbePxzTpj0Nkiqj7PaRzzjPD/Kua', NULL, '2026-06-07 16:40:33', '2026-06-07 16:40:33'),
(288, 'VERREN AURELYA HERMAWATI', 'verrenaurelyahermawati@gmail.com', '18534/680/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$a9H5sATMl7Y70LJkPd.E3e7xg7LsriwuIyOgTxVfE3MlYVqQqDPiq', NULL, '2026-06-07 16:40:34', '2026-06-07 16:40:34'),
(289, 'ZAHROTUL AINI', 'zahrotulaini@gmail.com', '18535/681/066', 'XI TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$p/fwIDuUtN.OcvabCqUojOer1Rq8Zm7OP9WoyodXhBhTRBeebO5gi', NULL, '2026-06-07 16:40:35', '2026-06-07 16:40:35'),
(290, 'AFRIZA NUGRAHA ADA GOZA', 'afrizanugrahaadagoza@gmail.com', '17547/001/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$i4nJHpAYUz6Ii5EiXkSx4eFyRjCfvuMqaVP/YnfX5QZMNOANNMdMK', NULL, '2026-06-07 16:40:56', '2026-06-07 16:40:56'),
(291, 'AHMAD RAFII', 'ahmadrafii@gmail.com', '17548/002/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$uVwJ9h3c/DKIcdaBm3zPSu9bEWfejnNE6YI4RFbmgYX2bKBwBBOAW', NULL, '2026-06-07 16:40:57', '2026-06-07 16:40:57'),
(292, 'AISATU SABANIYAH', 'aisatusabaniyah@gmail.com', '17549/003/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$MspMFymPUSySeSAWzFwrretRK/BS4c9KfTulK05eWnQN6JzupQNPS', NULL, '2026-06-07 16:40:58', '2026-06-07 16:40:58'),
(293, 'AISYAH NUR RAHMAWATI', 'aisyahnurrahmawati@gmail.com', '17550/004/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$Hy.m.yvgfL.B/mLHsS2uZeIEvoTSc150z2uowkWp3pvkaQTVPBoTK', NULL, '2026-06-07 16:40:59', '2026-06-07 16:40:59'),
(294, 'AISYIAH RIZKIKA', 'aisyiahrizkika@gmail.com', '17551/005/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$JCUQoaOwrnk67BAbe77xku4cPq9NdbFALeVBqAdb7j7MuPfeUoSra', NULL, '2026-06-07 16:41:01', '2026-06-07 16:41:01'),
(295, 'AJENG NIELZA ITSNA MUFIDA', 'ajengnielzaitsnamufida@gmail.com', '17552/006/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$IEGVaVmZYcyr.mjVU68znucmkqpwamuzJiUZu2tfgKc9DQhBmlgsm', NULL, '2026-06-07 16:41:02', '2026-06-07 16:41:02'),
(296, 'AKMAL WILDAN PRATAMA', 'akmalwildanpratama@gmail.com', '17553/007/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$.oTDKkMonnvy7V210kHCOOjProO8Het5RonPsPCtKmrFIVKCVlL7.', NULL, '2026-06-07 16:41:03', '2026-06-07 16:41:03'),
(297, 'ALINDA DWI NINGTYAS', 'alindadwiningtyas@gmail.com', '17554/008/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$k25A.t1o/voKydr719Cjnuz5D0f5FX/1XIwMBO.b7KhOU/VoHOaz6', NULL, '2026-06-07 16:41:04', '2026-06-07 16:41:04'),
(298, 'AMELIA SALSA BILA ANDINI', 'ameliasalsabilaandini@gmail.com', '17555/009/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$FddgAWoL2/lh1jrOk6zz4.8iVHCD74iRARUQTjkFii1/lRsrbEXHu', NULL, '2026-06-07 16:41:05', '2026-06-07 16:41:05'),
(299, 'ANDINA STEVY', 'andinastevy@gmail.com', '17556/010/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$z1lTTGrILHNcF8fduja8seBCuk7XuITgFzKAcHGN1484Dcm9G2u8K', NULL, '2026-06-07 16:41:06', '2026-06-07 16:41:06'),
(300, 'ANGGA DWI SETIAWAN', 'anggadwisetiawan@gmail.com', '17557/011/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$FfJDt.Dp4uJskAKAEBGQbe/6PKsI/rRmw0sAwuHBAJlx.SpzXulTi', NULL, '2026-06-07 16:41:07', '2026-06-07 16:41:07'),
(301, 'ARFAN RESTU RACHMATDHANI', 'arfanresturachmatdhani@gmail.com', '17558/012/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$ee7pmLtaL3FdTFpzcGLAPevcTL.UM610x7NSyuliYii/k2S3lKcYa', NULL, '2026-06-07 16:41:09', '2026-06-07 16:41:09'),
(302, 'ARIO ILHAM KURNIAWAN', 'arioilhamkurniawan@gmail.com', '17559/013/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$MJhVOi2ky4Y7onTKVMzcvutH4WVRoSirCuvB/Vrzw.hi.gW9Gkxf.', NULL, '2026-06-07 16:41:10', '2026-06-07 16:41:10'),
(303, 'ARWEYN ABBYGAIL', 'arweynabbygail@gmail.com', '17560/014/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$vd1fMWWLaQxqBgqCUKHI3eP/19ivzpl/F38W4CQ.i0vGuxmNifvr.', NULL, '2026-06-07 16:41:11', '2026-06-07 16:41:11'),
(304, 'AYDA SAZMITA PRATIWI', 'aydasazmitapratiwi@gmail.com', '17561/015/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$OF5zy4Z3pKGtGR8zgsRPxeBhe0iZni.T8HVOArncAh.2mKDZGIxMm', NULL, '2026-06-07 16:41:12', '2026-06-07 16:41:12'),
(305, 'AZZAHRA KHAYLA RAMADHANI', 'azzahrakhaylaramadhani@gmail.com', '17562/016/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$JndCLtjqF8OSCcKSKQQkxOlkK2nGIn6PBYNEkWAA8l6mdE0N3sj9.', NULL, '2026-06-07 16:41:13', '2026-06-07 16:41:13'),
(306, 'BILQYS THALITA EFENDY', 'bilqysthalitaefendy@gmail.com', '17563/017/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$Eg9ktZMKD6z7BlKQktpK7Ot67KJrq7n82XuMV93wwZAWNPsoybyqy', NULL, '2026-06-07 16:41:14', '2026-06-07 16:41:14'),
(307, 'BINTANG ADI ALVARO', 'bintangadialvaro@gmail.com', '17564/018/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$z7A9n8QHoDMewB2Nb3jyHO57ik3IrnML7SzDbnvcQxcVJGwyWOHtC', NULL, '2026-06-07 16:41:15', '2026-06-07 16:41:15'),
(308, 'BINTANG ARYAPUTRA MAULANA', 'bintangaryaputramaulana@gmail.com', '17565/019/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$CBaLYhGkqDNM.8zoOfo1XOI9IynkRpQFckhElC.iJx/Y5ywBJL/Yy', NULL, '2026-06-07 16:41:16', '2026-06-07 16:41:16'),
(309, 'BINTANG PUTRA SUGIARTA', 'bintangputrasugiarta@gmail.com', '17566/020/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$dh8SJGPaSThqBODgunpwPehzzMZSCFph73MnOlbDWODCINk8yDAY2', NULL, '2026-06-07 16:41:17', '2026-06-07 16:41:17'),
(310, 'CALISTA ANDRA FITRYANI', 'calistaandrafitryani@gmail.com', '17567/021/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$SG08WnMzDCPYAtYhftGsYe1btoNjmYpMdoNNjJkZwZTG9YEgaohha', NULL, '2026-06-07 16:41:18', '2026-06-07 16:41:18'),
(311, 'CHELSEA MEILANY CICILIA', 'chelseameilanycicilia@gmail.com', '17568/022/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$75vuSfx787jw4BzshkelbuQMUbt35BT02CyhM/EGkVhK0UWhEfr8.', NULL, '2026-06-07 16:41:19', '2026-06-07 16:41:19'),
(312, 'DAFA GHAITSA YOGATAMA', 'dafaghaitsayogatama@gmail.com', '17570/024/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$dRtFJsygOwzPKEaFcmKHX.JeHeBShnBBXUv5S8PL2yLKiyns9ETNy', NULL, '2026-06-07 16:41:20', '2026-06-07 16:41:20'),
(313, 'DAVISYA SATRIA NANDA', 'davisyasatriananda@gmail.com', '17571/025/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$tkA.DE.Loeta/4.Oli7Ej.LMgDZQzUwqtPPbqBD7nI998yRxpGdDa', NULL, '2026-06-07 16:41:21', '2026-06-07 16:41:21'),
(314, 'DEVINA AULIA AZZAHRA', 'devinaauliaazzahra@gmail.com', '17572/026/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$jKdugY0GYixFeTSkx4okVOzbwIJbbwSQw1DJeTkPhIcVQfYGAFi9i', NULL, '2026-06-07 16:41:22', '2026-06-07 16:41:22'),
(315, 'DHINNA OLIVIA', 'dhinnaolivia@gmail.com', '17574/028/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$N9WvGiD3KK6T/p0TAEvY8eM.E8gfWhfrRqqN53NWa7Cmkjqbd/NzO', NULL, '2026-06-07 16:41:23', '2026-06-07 16:41:23'),
(316, 'DIMAS NUR CIPTA SUSENO', 'dimasnurciptasuseno@gmail.com', '17575/029/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$2ckv/mYRRKXsDuG2eO9xl.I2mtVY4OlMLv/ho2kQ3ffbd1n9DBuL.', NULL, '2026-06-07 16:41:24', '2026-06-07 16:41:24'),
(317, 'ELVIRA NADYA RUDYANTO', 'elviranadyarudyanto@gmail.com', '17576/030/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$fdtaUsQjGE/bIDeMCbu92eR9Yd2U5vfmBLHKh4WVunnKXIQ.GwyFW', NULL, '2026-06-07 16:41:25', '2026-06-07 16:41:25'),
(318, 'ERIC ADITYA PRASETYO', 'ericadityaprasetyo@gmail.com', '17577/031/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$rJ7e1HJ0EAtd2XhYenOJ7uW.fvMSFABjTs4rLhhG6pyLZsFVWGS6i', NULL, '2026-06-07 16:41:26', '2026-06-07 16:41:26'),
(319, 'FALAKIAH ALLIE RAVARIANZA', 'falakiahallieravarianza@gmail.com', '17578/032/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$bYtL7e1oNBFpcNq8p7YXteGAvh3tX7RKgdmX6gjUU1LFw3mva/AxW', NULL, '2026-06-07 16:41:27', '2026-06-07 16:41:27'),
(320, 'HARDIANSYAH ADITYA PRATAMA', 'hardiansyahadityapratama@gmail.com', '17580/034/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$WV.G9V3xyzqnMOHdgqJ2buLsE5..kcs9g7fJvxw7v.m0DGmOu1a22', NULL, '2026-06-07 16:41:28', '2026-06-07 16:41:28'),
(321, 'IMELDA ZULFA AFRILLIA', 'imeldazulfaafrillia@gmail.com', '17581/035/065', 'XII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$lWQ3FX9HOpv3W367rGV78Oe3oHT0iC87yoBzxizGdMFpOuI.jaskW', NULL, '2026-06-07 16:41:29', '2026-06-07 16:41:29'),
(322, 'INAYA NAZMIN HENDRAWATI', 'inayanazminhendrawati@gmail.com', '17582/036/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$2wV6fy5jAifremGV6d5JN.6.JgIOBQ6IgwybMB7kSx4Sg9hYh/kqm', NULL, '2026-06-07 16:41:54', '2026-06-07 16:41:54'),
(323, 'INDAH FIRDLOTUL AZIZAH', 'indahfirdlotulazizah@gmail.com', '17583/037/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$pj/ZtLslQPnQ9kWN1Sc9uuSMWAQ1H5rr5ioGPZ8txfN3l8qMn3Cma', NULL, '2026-06-07 16:41:55', '2026-06-07 16:41:55'),
(324, 'INDRI RATNA FERLINA', 'indriratnaferlina@gmail.com', '17584/038/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$8xsML0mOxvrfMZEi/h803e0oX1WtXrh1qdP1XZzfOcPni5nkTLzDO', NULL, '2026-06-07 16:41:56', '2026-06-07 16:41:56'),
(325, 'JASMINE TANISHA RUSTIANDI', 'jasminetanisharustiandi@gmail.com', '17585/039/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$uauSJSSYg1D.j4kF9e9zge9njtTosGd35YCJPceG7HaIw3TnE5Mdq', NULL, '2026-06-07 16:41:57', '2026-06-07 16:41:57'),
(326, 'KENZIE ANANTA RADITYA', 'kenzieanantaraditya@gmail.com', '17586/040/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$hNjVl9Tz6SZgfdZPDnGeQObPYoZGINU..UqyNUEz3cMsAiEF5YJWm', NULL, '2026-06-07 16:41:59', '2026-06-07 16:41:59'),
(327, 'KEYLA ARIELLA CALISSA', 'keylaariellacalissa@gmail.com', '17587/041/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$lDcM5FRAC0.IsU80yFWJeuTnhqxnn58mQFpQcGJ2wZ3f5GLsFW9bO', NULL, '2026-06-07 16:42:00', '2026-06-07 16:42:00'),
(328, 'LAILA PUTRI RAHMAWATI', 'lailaputrirahmawati@gmail.com', '17588/042/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$o1cW0o2IIBhcaH02rfqNfOYGy6bdFpnN3uw6zHAYLCw865emXDQEO', NULL, '2026-06-07 16:42:01', '2026-06-07 16:42:01'),
(329, 'LALU DEYNDRA FAVIAN JIVANI', 'laludeyndrafavianjivani@gmail.com', '17589/043/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$xflLfBF22wZvjUl/aq2tpO5NTX9y8bNlzVnwEqxNhqjJxefo9BcYa', NULL, '2026-06-07 16:42:02', '2026-06-07 16:42:02'),
(330, 'LUCKY DWI PERMANA', 'luckydwipermana@gmail.com', '17590/044/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$9z9iN/V5n/hhS7yqv8CWOej2TOTWuO1xzq4K1FQBlwJxT33/KB0Q.', NULL, '2026-06-07 16:42:03', '2026-06-07 16:42:03'),
(331, 'MARVELLIN WIDITRYSTANIA', 'marvellinwiditrystania@gmail.com', '17591/045/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$xxQfUe0VMQob4DIGu/0aXuTjaLXF75MrDSsoD6cF/rodb6ER41Zd2', NULL, '2026-06-07 16:42:04', '2026-06-07 16:42:04'),
(332, 'MEIZA AULIA MAWADDA', 'meizaauliamawadda@gmail.com', '17592/046/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$cRiHnSbRLpiQAc7xpqMi7ufhksdmoFxKHh.ngMisGBmUW/xT6rXUi', NULL, '2026-06-07 16:42:05', '2026-06-07 16:42:05'),
(333, 'MOCHAMMAD WYLDAN DAFRIANSYAH', 'mochammadwyldandafriansyah@gmail.com', '17593/047/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$A.E2XCDuC0tZvcJEw4VuU.46QpYOIDX7V4fUvo4xsXGn8d05/b6yG', NULL, '2026-06-07 16:42:07', '2026-06-07 16:42:07'),
(334, 'MOHAMAD RISQI MAULANA AKBAR', 'mohamadrisqimaulanaakbar@gmail.com', '17594/048/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$1joXaOGbIIUw2Cc35D.3xebQxuDKg.iyDwUQzFYW6H8ejUz9Ad1MK', NULL, '2026-06-07 16:42:08', '2026-06-07 16:42:08'),
(335, 'MOHAMMAD BERYL MAULANA', 'mohammadberylmaulana@gmail.com', '17595/049/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$JSxLjhsjbdn4WPHIsOIMu.Y.NlUUB4SexK6WQ6boX.H5UDh8qfR5O', NULL, '2026-06-07 16:42:09', '2026-06-07 16:42:09'),
(336, 'MUFIDA LAILATUL ADKHA', 'mufidalailatuladkha@gmail.com', '17596/050/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$i.QGtSbsC2n6XpkKfUWiuen2GkBZpzx84iP8HYGP8TDS7OaT9oJfq', NULL, '2026-06-07 16:42:10', '2026-06-07 16:42:10'),
(337, 'MUHAMMAD ALMEYDA RIFVI BUDIANTO', 'muhammadalmeydarifvibudianto@gmail.com', '17597/051/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$JTmtF2T6zawx.HJeQiVEY.r0IhGgKXV8..ENQJp4BKErFGvDCuN06', NULL, '2026-06-07 16:42:11', '2026-06-07 16:42:11'),
(338, 'MUHAMMAD DAFA AMWALUDDIN', 'muhammaddafaamwaluddin@gmail.com', '17598/052/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$fwRZI3m078uYQ6dsdlFpNuNEBGAP0ExtdPStSNDghc25GIXUlMtcC', NULL, '2026-06-07 16:42:12', '2026-06-07 16:42:12'),
(339, 'MUHAMMAD RASYA AZKA AQILLA', 'muhammadrasyaazkaaqilla@gmail.com', '17599/053/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$8RwMpmuqe.IWNZA6rGT/M.SmuOyJh1NC4Jpquw7soc8dF5lxT4OKu', NULL, '2026-06-07 16:42:13', '2026-06-07 16:42:13'),
(340, 'NAILA YUNA RAMADHANI', 'nailayunaramadhani@gmail.com', '17600/054/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$L2Ox26BNZexzFMvZCVQnpO3tRl/7fT9fN3DKm8VMEf0mEzSDNigeS', NULL, '2026-06-07 16:42:14', '2026-06-07 16:42:14'),
(341, 'NAURAH DIVA YURI ANDINI', 'naurahdivayuriandini@gmail.com', '17601/055/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$4T/t7tlZb2euZNANRLunXuPkVLDaZXX510ehBeo64jl8f46nBOTAG', NULL, '2026-06-07 16:42:15', '2026-06-07 16:42:15'),
(342, 'NOVIA ANGGI NATASYA', 'noviaangginatasya@gmail.com', '17603/057/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$TXIQnHBVPicA2nLGpRMt8eETu3ehGzWPhXreDuoHD5q7BvFj4c8U6', NULL, '2026-06-07 16:42:16', '2026-06-07 16:42:16'),
(343, 'OLIVIA RISTA', 'oliviarista@gmail.com', '17604/058/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$0U2swGYi8YvINt5LMmSBDOu3hdeVxpueF44W6xMrZU.GBnkxma3o2', NULL, '2026-06-07 16:42:17', '2026-06-07 16:42:17'),
(344, 'RENA MISLIKHA PUTRI', 'renamislikhaputri@gmail.com', '17605/059/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$lQPMqvgjjKw1smBxxUxhQO45LhW/RITYhYB40jkVPJIr/enB9oh6m', NULL, '2026-06-07 16:42:18', '2026-06-07 16:42:18'),
(345, 'RHEZA ALENTTA', 'rhezaalentta@gmail.com', '17606/060/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$7FVOWD55Lu7ueWS3aVm55.3WpuDkDnBIqSDrg1v5ohJsfU58p.Oq2', NULL, '2026-06-07 16:42:19', '2026-06-07 16:42:19'),
(346, 'RISKA AYU WULANDARI', 'riskaayuwulandari@gmail.com', '17607/061/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$5YZwCHQ.tlfd6LmCI3Lc/eqf3UpN2jYzgYMRdFN9h5kkcLAdbPOeS', NULL, '2026-06-07 16:42:20', '2026-06-07 16:42:20'),
(347, 'RIVEN AUBREY FEHR', 'rivenaubreyfehr@gmail.com', '17608/062/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$xNoPWP1Lzi2CjO32cKo1Pu8vmY7wA5h70sY0mOleaJhdsn1aa5Qoi', NULL, '2026-06-07 16:42:21', '2026-06-07 16:42:21'),
(348, 'SAIDATUL KHOLIDIYA', 'saidatulkholidiya@gmail.com', '17609/063/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$ZzwVW9SboguP/8yC9TgvNujxYRVNQj2HFLgvxzGU2pbmR.VeSPg..', NULL, '2026-06-07 16:42:22', '2026-06-07 16:42:22'),
(349, 'SAMUEL ELVAN PRATAMA', 'samuelelvanpratama@gmail.com', '17610/064/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$aUYmZ5evT/S0xY6Tf5XS1e8LSCQw.guit/BQr5j34dm7e5aqkBLq.', NULL, '2026-06-07 16:42:23', '2026-06-07 16:42:23'),
(350, 'SEDYO BAGOEST BINATHORO', 'sedyobagoestbinathoro@gmail.com', '17611/065/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$E7Mh.h26snuSP/YBolW09.AnTuBi/1VLO1TVltRHPlhJ2erY.fS3y', NULL, '2026-06-07 16:42:25', '2026-06-07 16:42:25'),
(351, 'SELVI ANGGRAENI', 'selvianggraeni@gmail.com', '17612/066/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$0sRq55Vmnpg5QdRzmbV2vuVqQCXHtvljDlfWs4cT6u/ilaIzBMAFS', NULL, '2026-06-07 16:42:26', '2026-06-07 16:42:26'),
(352, 'SEVES ONE MAHATMA PHUTRA', 'sevesonemahatmaphutra@gmail.com', '17613/067/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$bmTa49vhjHyuf2veCU071OGgbKZ1jCqrPpwxhtZj5KaF0FYJ82Jk.', NULL, '2026-06-07 16:42:27', '2026-06-07 16:42:27'),
(353, 'VANIA PAMELA FRI MASFUFAH', 'vaniapamelafrimasfufah@gmail.com', '17614/068/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$msQQO0GJfYE9nWOSUHR32ucat.q3w2If8mtnAq2sq88j0hUgucHs2', NULL, '2026-06-07 16:42:28', '2026-06-07 16:42:28'),
(354, 'VIRA AYU AZZAHRA', 'viraayuazzahra@gmail.com', '17615/069/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$lDLizHiAo/4o3CUgSAM4FOEmCzRTNUlglxPd1rsRT9FZwIcZryN1e', NULL, '2026-06-07 16:42:29', '2026-06-07 16:42:29'),
(355, 'ZAKY VIRMAN ABI FIKHRI', 'zakyvirmanabifikhri@gmail.com', '17616/070/065', 'XII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$jvPpweI0jh2zJX4CXodL4ORKUmwMwfxUctJX.rhrCnQuyM2dJjqCO', NULL, '2026-06-07 16:42:30', '2026-06-07 16:42:30'),
(356, 'A REZA ADITYA PUTRA', 'arezaadityaputra@gmail.com', '17617/540/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$jVM03GlVLrO77IcyuJ///OLdxo7qGvfdsr5uvvlE59A4nFkHY6zze', NULL, '2026-06-07 16:42:50', '2026-06-07 16:42:50'),
(357, 'ADHYS ANANTA RAMADHANI', 'adhysanantaramadhani@gmail.com', '17618/541/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$XT.cDq73qEoC82tvJKyIfeqkcVCbC0oVXN0vwVhLx.pKYwCidy4Yq', NULL, '2026-06-07 16:42:51', '2026-06-07 16:42:51'),
(358, 'AFNI ARYA NINGSIH', 'afniaryaningsih@gmail.com', '17619/542/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$32eeF4uigNTeec/4p2TeQeOKfJI.4fRqB4Bdh6lFfGFGaNqPsU7Nm', NULL, '2026-06-07 16:42:52', '2026-06-07 16:42:52'),
(359, 'AHMAD BAYU SURYA', 'ahmadbayusurya@gmail.com', '17620/543/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$V8QjwepJZ1dB4NLNbW7f5.vbe4Q6ZTkJOqQ6y2zE//GPQm46WJ166', NULL, '2026-06-07 16:42:53', '2026-06-07 16:42:53'),
(360, 'ALFATAN PASHA RAMADHAN', 'alfatanpasharamadhan@gmail.com', '17621/544/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$.lsgQmAOgjxm5nPaks8gLu5o9K24AD9qH8LQGLH1iszjVVJbsMHrO', NULL, '2026-06-07 16:42:54', '2026-06-07 16:42:54'),
(361, 'ALFIRA PUTRI AULIA', 'alfiraputriaulia@gmail.com', '17622/545/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$SS0Ur1cYuh95/gsnh3.KQO14G8gAIGWbybYI0mllS58BSt1uOT.fq', NULL, '2026-06-07 16:42:55', '2026-06-07 16:42:55'),
(362, 'ANANDA WIDAYATI', 'anandawidayati@gmail.com', '17623/546/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$yxvVZOFKOsHFDwvQDOqVfe9OH4Xagwt0rxYvoltQ.0cM1Mij5BLsG', NULL, '2026-06-07 16:42:56', '2026-06-07 16:42:56'),
(363, 'ANGGI SEPTIA RAHAYU', 'anggiseptiarahayu@gmail.com', '17624/547/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$emMQLGBvJv9tjcvHqfJa/OQ5Hhq3ZJyP8C0jz9.M2guLXnosu/.BW', NULL, '2026-06-07 16:42:57', '2026-06-07 16:42:57'),
(364, 'ANISHA TRIHAPSARI ARTISTA', 'anishatrihapsariartista@gmail.com', '17625/548/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$ciCX0kFC89rEjEQlqthIo.CTm7.s511/.Kr28i/w.q8Jvr7IpiP76', NULL, '2026-06-07 16:42:58', '2026-06-07 16:42:58'),
(365, 'ARDIANSAH DWI NUGROHO', 'ardiansahdwinugroho@gmail.com', '17626/549/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$LYKhF8jzmck6hp930wNRJuvgMWALacZSNNuWPOuQz1NNDCIe7kpS6', NULL, '2026-06-07 16:43:00', '2026-06-07 16:43:00'),
(366, 'ARGA HENDHIN JAVANDA', 'argahendhinjavanda@gmail.com', '17627/550/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$nO4poLnsUy4Ob49dyRa9TuZvqXmHW6n1MvIgCt57wwx2wPkexE66.', NULL, '2026-06-07 16:43:01', '2026-06-07 16:43:01'),
(367, 'ARIO FELIX PUTRA SANTOSO', 'ariofelixputrasantoso@gmail.com', '17629/552/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$zV1nyG66IJXHk7eJRi5dzeD56j7Vn3.fp96Qj10tQCj/69l3u9hzi', NULL, '2026-06-07 16:43:02', '2026-06-07 16:43:02'),
(368, 'AZ ZAHRA RIFTI SETIYAWAN', 'azzahrariftisetiyawan@gmail.com', '17630/553/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$vRqbQk1iIc0dw552Qx1p9.12YUyn9JV8QGLLtw.CKBvdewb/h0NTy', NULL, '2026-06-07 16:43:03', '2026-06-07 16:43:03'),
(369, 'BERNANDO WAHYU PUTRA AMHEKA', 'bernandowahyuputraamheka@gmail.com', '17631/554/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$rzOg1mzrtaVqGES1LSY1zuorwA1QF.4TPvd4rPx9FU2jM5zuI7ITu', NULL, '2026-06-07 16:43:04', '2026-06-07 16:43:04'),
(370, 'CLAUDYA ANDRINA KARTIKA PUTRI', 'claudyaandrinakartikaputri@gmail.com', '17632/555/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$AAe9l0hO8eGNq.aHjtz13usyJ64KuPsrsKznX/3h50JUsI5tmrB3y', NULL, '2026-06-07 16:43:05', '2026-06-07 16:43:05'),
(371, 'DAVIN RADITYA APRIANSYAH', 'davinradityaapriansyah@gmail.com', '17633/556/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$CvV9e1Fq1hPKuF.42E0gle683wnNTN0iVAbujxl8Vj3h13u7WKsci', NULL, '2026-06-07 16:43:06', '2026-06-07 16:43:06'),
(372, 'DHEDY YAHYA MAULANA PUTRA PRATAMA', 'dhedyyahyamaulanaputrapratama@gmail.com', '17634/557/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$pka1Vup7stZJA5Tz5.lf2OjmtwYwCgA2JUuPdesvrLj5c5KxXKiZe', NULL, '2026-06-07 16:43:07', '2026-06-07 16:43:07'),
(373, 'DIAZ PRIHASTARA', 'diazprihastara@gmail.com', '17635/558/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$GzntMznd1Hk/YKvwM1Ykv.7dvpdIHH1B2tXzkNeFEMjV5fBQtVWlq', NULL, '2026-06-07 16:43:08', '2026-06-07 16:43:08'),
(374, 'DIMAS ARYA RAMADHAN', 'dimasaryaramadhan@gmail.com', '17636/559/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$3xhn.hpOKUcjj30ghAV9TO1iEDfVUrdQzWAP0Nk7EGTNz8nO6DxIK', NULL, '2026-06-07 16:43:10', '2026-06-07 16:43:10'),
(375, 'FANI KHOIRUS SANIAH', 'fanikhoirussaniah@gmail.com', '17637/560/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$CoJ638wr57bwwkt88huY..NDcsUp9xWqCp/EvZ6TmmYm8ppbFHKCC', NULL, '2026-06-07 16:43:11', '2026-06-07 16:43:11'),
(376, 'FARREL IRWANSYAH', 'farrelirwansyah@gmail.com', '17638/561/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$rLUoUr9FRnQy6BXfxukPPes7I8vy0qW0y/Dko4ADFl.YLYx3JDzYO', NULL, '2026-06-07 16:43:12', '2026-06-07 16:43:12'),
(377, 'FIKA FEBRIANTI', 'fikafebrianti@gmail.com', '17640/563/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$jLsD/9yMGiGv1XK6JUjeGuM6r1odONNaot.vKl/BtzJSJozu.H8em', NULL, '2026-06-07 16:43:13', '2026-06-07 16:43:13'),
(378, 'GIFFARI REIHAN AMANULLOH', 'giffarireihanamanulloh@gmail.com', '17641/564/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$0trhRGE0dlCNoB2fdlhlA.GHtsoZazfvf//n5Q4scWIOjuQNW/j3u', NULL, '2026-06-07 16:43:14', '2026-06-07 16:43:14'),
(379, 'HAFIZH ANNURIEL ZLATAN ARDIANSYAH', 'hafizhannurielzlatanardiansyah@gmail.com', '17642/565/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$srOpya2G0/DTmgZEVx1vLuxZEYVU6ChZrm.1opQ31Ey.aKgwc4e4K', NULL, '2026-06-07 16:43:15', '2026-06-07 16:43:15'),
(380, 'HASNA ANISFIA NAILA FAIZAH', 'hasnaanisfianailafaizah@gmail.com', '17643/566/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$a2x7fSe84vovtp.wNWw3w.4/EmStFpWDcd/f6tPNsRJbL0nh4GwQC', NULL, '2026-06-07 16:43:16', '2026-06-07 16:43:16'),
(381, 'IDA BAGUS KADE RAMA ARDANA', 'idabaguskaderamaardana@gmail.com', '17645/568/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$PwAIPrIWIqrQRfKphUJTf.ENf8yKLSun7Hz7vZC1t0.Cg1xjF1EVC', NULL, '2026-06-07 16:43:17', '2026-06-07 16:43:17'),
(382, 'IKHBAL BAGOES DWI ILYAS PUTRA', 'ikhbalbagoesdwiilyasputra@gmail.com', '17646/569/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$gk8/O3PKEYvddSABia8e4e.mWECNUVz1icQOoigREG7nt1gAIvvxm', NULL, '2026-06-07 16:43:18', '2026-06-07 16:43:18'),
(383, 'IRZEE FRANSA WIJAYA', 'irzeefransawijaya@gmail.com', '17647/570/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$M4aGOUaHi1MzidHbOddenekZEKz/LbW4NpFP8d/X63elg659wkmZu', NULL, '2026-06-07 16:43:19', '2026-06-07 16:43:19'),
(384, 'JIHAN SAFA FELIZA', 'jihansafafeliza@gmail.com', '17648/571/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$iZYX6ct7o/Sv4e4JAbDI5Oj/dM5pWld0VYQn3fcT7R3AJW4OygYt6', NULL, '2026-06-07 16:43:20', '2026-06-07 16:43:20'),
(385, 'KARINA WIJINING RAHAYU', 'karinawijiningrahayu@gmail.com', '17649/572/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$RNPWO7vOp/VsHFq9CxFCFeVecmeOXex5nemOi4EqqZomsBcVI6TZG', NULL, '2026-06-07 16:43:21', '2026-06-07 16:43:21'),
(386, 'KIRANA NUR ANINDYA', 'kirananuranindya@gmail.com', '17650/573/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$QuBCsUZcHU64Yexdmsbic.bAS8TV/Vfm0qiNM/qrcetAICAg79dn2', NULL, '2026-06-07 16:43:22', '2026-06-07 16:43:22'),
(387, 'LAUDHIYA BUNGA ANTIKA RIZKI', 'laudhiyabungaantikarizki@gmail.com', '17651/574/066', 'XII TKJ 1', 'siswa', NULL, NULL, NULL, '$2y$12$pRfvkExk72uttA6hAXZYT.NNDAv27Vx4aoOYLVsH6o35soQhTIcTK', NULL, '2026-06-07 16:43:24', '2026-06-07 16:43:24'),
(388, 'LEVYA JULIA AGUSTIN', 'levyajuliaagustin@gmail.com', '17652/575/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$n9ASWkkV8/Qo01N6x5tvCuO0f.u2GKxkjpXDHl942FGKIFcGH4ocW', NULL, '2026-06-07 16:43:44', '2026-06-07 16:43:44'),
(389, 'LINA HAPPY NINGTYAS', 'linahappyningtyas@gmail.com', '17654/577/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$JrnOnrUTm5Rjwm0zACAj7OK5Fbxqj5n9yT9zreVW2Tp6r9u/e.HJe', NULL, '2026-06-07 16:43:45', '2026-06-07 16:43:45'),
(390, 'MARIA ULFA', 'mariaulfa@gmail.com', '17655/578/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$UkWHucCcyq9QxLWyOBMyXeyZwMyZ.fZudQWOqn9umaAO0KmE0uc1u', NULL, '2026-06-07 16:43:46', '2026-06-07 16:43:46'),
(391, 'MARSHA CAHAYA PUTRI AGUSTIN', 'marshacahayaputriagustin@gmail.com', '17656/579/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$GR89FV364KucCxA4DjGffuU8dAd2N2AM/zYybribUNci7HT2D6pHW', NULL, '2026-06-07 16:43:47', '2026-06-07 16:43:47'),
(392, 'MOCH ALFIAN ELVIERO', 'mochalfianelviero@gmail.com', '17657/580/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$XeQ4XjiH2xa7q3RpN1VvJ.9feE.9lCtI.sw.kh0/D8xvWs.5apa0e', NULL, '2026-06-07 16:43:48', '2026-06-07 16:43:48'),
(393, 'MOSES JULIO TUZIKO', 'mosesjuliotuziko@gmail.com', '17658/581/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$WFIkvgVEeyZV8BkCgiVuQeuE8G2LD6IFFiVfQntfxhfUKmvS.Tz/W', NULL, '2026-06-07 16:43:48', '2026-06-07 16:43:48'),
(394, 'MUHAMMAD BINTANG SISTRIAWAN', 'muhammadbintangsistriawan@gmail.com', '17659/582/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$J7lnPtshiggm2kvHJw6xfuHU9anlBtsxJzrIIpGOJe1Rz..yhZVgy', NULL, '2026-06-07 16:43:49', '2026-06-07 16:43:49'),
(395, 'MUHAMMAD DEVA ARYA PUTRA', 'muhammaddevaaryaputra@gmail.com', '17660/583/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$uNrUeXI.Z3WeQdcnYL0sw.OnGJAuWnsihE/eRGXWvJHgtiqYfYrXW', NULL, '2026-06-07 16:43:50', '2026-06-07 16:43:50'),
(396, 'MUHAMMAD FAHRIZAL ILHAMI', 'muhammadfahrizalilhami@gmail.com', '17661/584/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$PVrEePO1FIHCirTQbLf.tOJQ/kF9dxGaPXy0Jw9S/Qun6e4YS3xHy', NULL, '2026-06-07 16:43:51', '2026-06-07 16:43:51'),
(397, 'MUHAMMAD FARREL ALFAREZA', 'muhammadfarrelalfareza@gmail.com', '17662/585/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$p.4jcAUpFYu8OcyZUr/rWO3UGw1APpup0VE0G8ybYcAKnGZCkvjQ6', NULL, '2026-06-07 16:43:52', '2026-06-07 16:43:52'),
(398, 'MUHAMMAD SASMITO AJI', 'muhammadsasmitoaji@gmail.com', '17665/588/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$lFjlRGViKs6itrBUrQsn9uqF6pCIKGaF8JLnvGPuk8mO4U0ZnCmt2', NULL, '2026-06-07 16:43:53', '2026-06-07 16:43:53'),
(399, 'MUHAMMAD WAFA AL AWWALU', 'muhammadwafaalawwalu@gmail.com', '17666/589/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$Bf1xMhsFCJTm4uD6uwARg.8tdP1h5NQrhU0jcws9m988LZ0BiHkNe', NULL, '2026-06-07 16:43:54', '2026-06-07 16:43:54'),
(400, 'NADIA NUR AZIZA', 'nadianuraziza@gmail.com', '17667/590/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$cY.GvkChym5InWlQqA5k1uht041.Z.q1uMqYPsieO3A2XEbs1.E3a', NULL, '2026-06-07 16:43:55', '2026-06-07 16:43:55'),
(401, 'NAJWA NIELZA AZZAHRA', 'najwanielzaazzahra@gmail.com', '17668/591/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$qxsBZPkgy6L9muwdlh6d.eE1wFcyCvP0sIEBO8ik4YfMN.QmdEYLK', NULL, '2026-06-07 16:43:56', '2026-06-07 16:43:56'),
(402, 'NANDA RAHAYU', 'nandarahayu@gmail.com', '17669/592/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$8/r9oq80/i9h4.9/L3EwEuokLQMi1/colGZtnvnvElN0J.uk6HV4u', NULL, '2026-06-07 16:43:57', '2026-06-07 16:43:57'),
(403, 'NASYA NIELZA AZZAHRA', 'nasyanielzaazzahra@gmail.com', '17670/593/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$ymkZf3Jr/SrDFCnuMFkiE.56du4Zl2g6PueLiqoXXmIAdIq9BDXpG', NULL, '2026-06-07 16:43:58', '2026-06-07 16:43:58'),
(404, 'NATASYA PUTRI NAYLA', 'natasyaputrinayla@gmail.com', '17671/594/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$prGJ1e3Snj2WGGJGlgn09enAlLWOK0erlS1J6dYFSbRw50P9trUWO', NULL, '2026-06-07 16:43:59', '2026-06-07 16:43:59'),
(405, 'OCIK VIRNANDA JUWITA SARI', 'ocikvirnandajuwitasari@gmail.com', '17673/596/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$90/cbu9kOCu2lCtuGvkbueSGbExzuxUtmxHPI8OI/px6y3fMyOzLC', NULL, '2026-06-07 16:44:00', '2026-06-07 16:44:00'),
(406, 'PUTRI DEWI PRAMESWARI', 'putridewiprameswari@gmail.com', '17674/597/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$A.oxfAV5Xg2fzTtNUwBul.RsQoacTb40C8qbrmeOoOwY2A1/.bVvy', NULL, '2026-06-07 16:44:01', '2026-06-07 16:44:01'),
(407, 'RHEINA PUTRI NADILA', 'rheinaputrinadila@gmail.com', '17675/598/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$wm.qsTdYJCV.T0ZzoF55Y.EkkUcohKmmOfy17ZeDI6AUowiCd.lOK', NULL, '2026-06-07 16:44:02', '2026-06-07 16:44:02'),
(408, 'RIZKIO FASLAH ALFARISI', 'rizkiofaslahalfarisi@gmail.com', '17676/599/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$i/BNoopprs1NHZhjSiwkxeRby7UvEaNFAu1nir0EUKrIMIpRXNcHS', NULL, '2026-06-07 16:44:03', '2026-06-07 16:44:03'),
(409, 'RYA DWI LESTARI', 'ryadwilestari@gmail.com', '17677/600/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$M9rTQL8S7mSwS.pKwpmnF.apG/9SzkBu5QstMYe1GeqW26c4iTpeq', NULL, '2026-06-07 16:44:04', '2026-06-07 16:44:04'),
(410, 'SERLI FERNANDA', 'serlifernanda@gmail.com', '17680/603/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$/jp8Iy2RXDV/FmvqurOdz.CrQ2J91X6HlWiMySOgv.WJBEIaLOZSK', NULL, '2026-06-07 16:44:05', '2026-06-07 16:44:05'),
(411, 'SHEVILA FATIKHA ABDI', 'shevilafatikhaabdi@gmail.com', '17681/604/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$XX6DaU4gHtKbQCRCJPx3sOvrPl2zPvVqBSR9T5J2w1OIKN.6aCnau', NULL, '2026-06-07 16:44:06', '2026-06-07 16:44:06'),
(412, 'SYEFFIRA RAHMA DHIANI', 'syeffirarahmadhiani@gmail.com', '17682/605/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$GjFoTVM1POsq.TkKP7JDF.Fzq32u1JEAOQFUqCTcncdMlYxI1sK5W', NULL, '2026-06-07 16:44:07', '2026-06-07 16:44:07'),
(413, 'TIARA PUTRI DEWI', 'tiaraputridewi@gmail.com', '17683/606/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$nAlu2JsNWbGxtHZ50QF2f.TpZofsMb6slxRcZcNhqWQiAxMigprUS', NULL, '2026-06-07 16:44:08', '2026-06-07 16:44:08'),
(414, 'WALENIA SWASTIKA NINGSIH', 'waleniaswastikaningsih@gmail.com', '17684/607/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$rbHig./9bP6aK9mZtn/IHeNtkIMgYvzDf3BznGE3AygAH.IzZ/B42', NULL, '2026-06-07 16:44:09', '2026-06-07 16:44:09'),
(415, 'ZAINUL HASAN', 'zainulhasan@gmail.com', '17686/609/066', 'XII TKJ 2', 'siswa', NULL, NULL, NULL, '$2y$12$Mj8kHdwbC2tNr5omFU8KD.akklu40D/M214SCaJU/MCcFKSUAFAB6', NULL, '2026-06-07 16:44:10', '2026-06-07 16:44:10'),
(416, 'Ahmad Aditya Pratama', 'ahmadadityapratama@gmail.com', '16751/249/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$5TaVcV8U5VWVBrzH0g8BIOjfkgtnMmYPeyQwlSRWloUPw0eh/1vxS', NULL, '2026-06-07 16:45:09', '2026-06-07 16:45:09'),
(417, 'AINI NUR NABILA', 'aininurnabila@gmail.com', '16752/250/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$MNFUn.eF.3H5Egk6CeEA1eWtHzapHPI4jJgftNtX/AmtWvSMIUdQ.', NULL, '2026-06-07 16:45:11', '2026-06-07 16:45:11'),
(418, 'ALIFFIYA BAKTI', 'aliffiyabakti@gmail.com', '16753/251/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$Simh9eO7p1e5caepBchmWeIhdGvWFfaP8V8j46Mfcqvqi66knqjL.', NULL, '2026-06-07 16:45:12', '2026-06-07 16:45:12'),
(419, 'Alvan Dwi Tristanto', 'alvandwitristanto@gmail.com', '16755/253/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$r5X.xoAxZwOFK75kjSTDs.xPfFg2/rIVtyMEAiESspbYoHNtXZ6ju', NULL, '2026-06-07 16:45:13', '2026-06-07 16:45:13'),
(420, 'ANDRA FEBIAN ABDI NUGRAHA', 'andrafebianabdinugraha@gmail.com', '16756/254/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$KNG3ULrvi9IrzCi44/REDu3gCy.LoAi.7O/cKYaRjurTlRnt235SK', NULL, '2026-06-07 16:45:14', '2026-06-07 16:45:14'),
(421, 'Anisa Nur Hasanah', 'anisanurhasanah@gmail.com', '16757/255/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$tN8wZFiHUqdFC2Qrlxn1a..ZzQAfUNLgIXkgfFyw/vT/u3RUO9sBi', NULL, '2026-06-07 16:45:15', '2026-06-07 16:45:15'),
(422, 'APRILIA NAURA VANESSA', 'aprilianauravanessa@gmail.com', '16758/256/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$CD0fKeRj2CVGB/B.V6GiY.BAnh4/99C3Mxh9TBVgUFSvKGxaMSk1a', NULL, '2026-06-07 16:45:16', '2026-06-07 16:45:16'),
(423, 'ARRELKA RIZQI TRIWARDANA', 'arrelkarizqitriwardana@gmail.com', '16759/257/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$oC7ojK5GuHyP12XYM4hY2eUsRikpKllWr4uVzc3.vxbA/C5cHv3wm', NULL, '2026-06-07 16:45:18', '2026-06-07 16:45:18'),
(424, 'ARYA ARKANANTA RIZQULLAH', 'aryaarkanantarizqullah@gmail.com', '16760/258/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$CIUbDJ.rvjib.bjJ/xaODunwkGEpGoj48KRcePMeQICmqo39IOLI.', NULL, '2026-06-07 16:45:19', '2026-06-07 16:45:19');
INSERT INTO `users` (`id`, `name`, `email`, `nis`, `kelas`, `role`, `foto_profil`, `no_wa`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(425, 'ASHILA FITRIANA HAMIDAH', 'ashilafitrianahamidah@gmail.com', '16761/259/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$e.Jck6YJ4R1uBINHkaLUHe7WXQIll28VZksqxPTHNcJpXo1QWK.5e', NULL, '2026-06-07 16:45:20', '2026-06-07 16:45:20'),
(426, 'Aulia Rahmaydhani', 'auliarahmaydhani@gmail.com', '16762/260/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$V68XacDPAgHt6dvhj2q8ROysowLyC65jZxcXdxbFYeB.RQn9TWwpm', NULL, '2026-06-07 16:45:21', '2026-06-07 16:45:21'),
(427, 'AURA NAJMA AULIA', 'auranajmaaulia@gmail.com', '16763/261/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$2.OOW2oQuvguJIk5q1jW6eUux05bngLmKA3qSiHvM4iC.wzyOoQ2y', NULL, '2026-06-07 16:45:22', '2026-06-07 16:45:22'),
(428, 'AYU AZZAHRA KHAIRUNNISA', 'ayuazzahrakhairunnisa@gmail.com', '16764/262/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$lNrHGAryCvzRy5yqhChyeOvx99SimHTvb/rS6eZXcIrtjdRbU2xVC', NULL, '2026-06-07 16:45:23', '2026-06-07 16:45:23'),
(429, 'Azhar Al Abiyyu', 'azharalabiyyu@gmail.com', '16765/263/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$3mOFwPid.K4RJV19DYXDj.A0gwzMu.PgTPHMnL1o0MPJMTX1vNARC', NULL, '2026-06-07 16:45:24', '2026-06-07 16:45:24'),
(430, 'BAYU DWI APRILIAN', 'bayudwiaprilian@gmail.com', '16766/264/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$zMCHLmMRWn4MYu42OJu2U.kDPbqI8Jg6G2a.m7yeBFd0J.v8PgYCO', NULL, '2026-06-07 16:45:25', '2026-06-07 16:45:25'),
(431, 'CARISSA DEVIN MAHESWARI', 'carissadevinmaheswari@gmail.com', '16767/265/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$C8CvvsopUa5PaocwANTxEujWmdp4px6YDQrZ1g8bTV.7KCqxrFmwK', NULL, '2026-06-07 16:45:26', '2026-06-07 16:45:26'),
(432, 'CHELSEA WIDIA CITARA', 'chelseawidiacitara@gmail.com', '16768/266/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$TawS1HS1xTrv6Q3xcWcuM.P6DpjV8CqwOggO4xipdREv/.crSslqi', NULL, '2026-06-07 16:45:27', '2026-06-07 16:45:27'),
(433, 'CHILMIATUL SALSABILA', 'chilmiatulsalsabila@gmail.com', '16769/267/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$DkBZpy4xbtLniioIrG4qROx80CV7LweBANFOe36xwb49mHjGDcwkS', NULL, '2026-06-07 16:45:28', '2026-06-07 16:45:28'),
(434, 'DAVIN MARTHAN FATHONI', 'davinmarthanfathoni@gmail.com', '16770/268/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$MQaJ3WMb0pq/rFky1L5eguISZHcFKbnpn18hmOJktsKaaYtT2e0tm', NULL, '2026-06-07 16:45:29', '2026-06-07 16:45:29'),
(435, 'Dini Ananda Sari', 'dinianandasari@gmail.com', '16771/269/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$K8Pp0JvbemsXCxNgKcmi3.40yG2ODNHmPTYcuyJrQHjDpxzkHxqUi', NULL, '2026-06-07 16:45:31', '2026-06-07 16:45:31'),
(436, 'Dita Dina Lorensa', 'ditadinalorensa@gmail.com', '16772/270/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$cNsD0vRkw78/3dH/Pfge8OoX5rvJGwfHzRpB17NX3CmeBCnxzHpe2', NULL, '2026-06-07 16:45:32', '2026-06-07 16:45:32'),
(437, 'EKA ARYA RAMADHAN', 'ekaaryaramadhan@gmail.com', '16773/271/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$E3ERW4l/E4jEEqgh7lsIDOWsZH9I8Y.heFPW5DbxeiUwis44JnUi6', NULL, '2026-06-07 16:45:33', '2026-06-07 16:45:33'),
(438, 'ELVIRA PUTRI RAHMADHANI', 'elviraputrirahmadhani@gmail.com', '16774/272/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$7R6NKJmatjbpxAFgy9//bO8.NmjHofR8/vviUJw1fxJoXNnrfOtCy', NULL, '2026-06-07 16:45:34', '2026-06-07 16:45:34'),
(439, 'ERWITA HAYUNING LARASATI', 'erwitahayuninglarasati@gmail.com', '16775/273/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$dD02rUUscS68buZaC67xhunjzPT/F28WZ3TyB/NI.pgrolCApJcsa', NULL, '2026-06-07 16:45:35', '2026-06-07 16:45:35'),
(440, 'FA\'AD HINNIZAR ALKAFF', 'fa\'adhinnizaralkaff@gmail.com', '16776/274/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$jWk4h67iwiP32n8YfxhmDeVnI.eJ8KLVIkyRGZ8NskyMqOoc4FYRe', NULL, '2026-06-07 16:45:36', '2026-06-07 16:45:36'),
(441, 'FADJAR KARADISMA RAMADHANA PUTRA', 'fadjarkaradismaramadhanaputra@gmail.com', '16777/275/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$CHUHYwLC.xS41gNieMxXlufwPQOKvicRnznjOjLY/RDDCz/bppAQS', NULL, '2026-06-07 16:45:37', '2026-06-07 16:45:37'),
(442, 'FARDAN SEBRI AL AZIL', 'fardansebrialazil@gmail.com', '16778/276/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$F3HvJCNn7KLYAOzmApwdyeWPXMhSyDmDfAMph7pR0ifLhjQnW2Buq', NULL, '2026-06-07 16:45:38', '2026-06-07 16:45:38'),
(443, 'FARFISA ANANDA PRATAMA WAHONO', 'farfisaanandapratamawahono@gmail.com', '16779/277/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$7WT1PWTgzCdGq3UXitpZSeFcS9ITOv9Z24RLBLIFpHKpcn1zwd9Ny', NULL, '2026-06-07 16:45:39', '2026-06-07 16:45:39'),
(444, 'FERDIAS YOGA ANANTA', 'ferdiasyogaananta@gmail.com', '16780/278/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$dP/4.LWSQgvClhtJbfV4GOZCYPoNoH6SSso6yVua2i.NoAEGXBJV.', NULL, '2026-06-07 16:45:40', '2026-06-07 16:45:40'),
(445, 'HASNIA NAZILA', 'hasnianazila@gmail.com', '16781/279/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$LYo8JVl67QB4cRRGcN4dk.1QDjP9r76TQc6Ta11FxRbTzg3BN6Qbi', NULL, '2026-06-07 16:45:41', '2026-06-07 16:45:41'),
(446, 'I GUSTI LANANG RIZKI JULIO', 'igustilanangrizkijulio@gmail.com', '16782/280/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$kwHuramPEcPj1XcbVd9CBuS1tmDDybu7xVjkjacAv33/bAmhi1c4C', NULL, '2026-06-07 16:45:42', '2026-06-07 16:45:42'),
(447, 'INTANI ROHMAH', 'intanirohmah@gmail.com', '16783/281/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$BnY931q/QYE/VcUX97Y4V.wHbZSbAz.l7bjqiKEm4SAWonawr3Tb.', NULL, '2026-06-07 16:45:43', '2026-06-07 16:45:43'),
(448, 'M FAREL ALIFIAN PUTRA', 'mfarelalifianputra@gmail.com', '16785/283/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$JNiH6zgMhtfD9urFp3obo.1BefQVRWoRGQU24c5onys6Db/Zn3Hlu', NULL, '2026-06-07 16:45:44', '2026-06-07 16:45:44'),
(449, 'M. MAFTUH FUADI BINURI ROMDHON', 'm.maftuhfuadibinuriromdhon@gmail.com', '16786/284/068', 'XIII SIJA 1', 'siswa', NULL, NULL, NULL, '$2y$12$LIsbQJiwuWJw4EX45sSImuj8wUzb9noY5aLf0BGMSAys1n87d7ISq', NULL, '2026-06-07 16:45:46', '2026-06-07 16:45:46'),
(450, 'Marveleo Gavrilla Antasurya', 'marveleogavrillaantasurya@gmail.com', '16787/285/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$gXS5x5g0TvI7E/Iif/1L3ueJgfkZOzPb8n2PBMCJD7IYG42c9uwMa', NULL, '2026-06-07 16:46:04', '2026-06-07 16:46:04'),
(451, 'MEIDIANA TRIANANDA ZAKINAH', 'meidianatrianandazakinah@gmail.com', '16788/286/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$9NcqaIc2TM2PnM.8ctv/t.a2AOUXQMAZ5uulvVt27QrAitrQagOfK', NULL, '2026-06-07 16:46:05', '2026-06-07 16:46:05'),
(452, 'MOCH DEVANO WIDYA PUTRA \'ADI', 'mochdevanowidyaputra\'adi@gmail.com', '16789/287/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$eBD3D1lLYn3spDKwy3zz9.yvgEZ95vzKeqMc3HeZOzSSpcawTlKAi', NULL, '2026-06-07 16:46:06', '2026-06-07 16:46:06'),
(453, 'MOCHAMAD NABIL', 'mochamadnabil@gmail.com', '16790/288/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$3a6Cqz3nGodI.disRHb0ce.S000bo1Gcr13jGqLs8hLRvhKqvmU5K', NULL, '2026-06-07 16:46:07', '2026-06-07 16:46:07'),
(454, 'MOHAMMAD RAFLY PRAMUDYA FIRMANSYAH', 'mohammadraflypramudyafirmansyah@gmail.com', '16791/289/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$607wF7I.ztoSRcXwKjP8beOX3N87A4BLR2JLOY3HyMIeiTptfJ9ei', NULL, '2026-06-07 16:46:08', '2026-06-07 16:46:08'),
(455, 'MUHAMMAD MAULANA HAFIZH ASSEGAF', 'muhammadmaulanahafizhassegaf@gmail.com', '16792/290/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$KEL0xWNe9smaAagnSne9UuBr/CYI0aPFVelHyzu7CWSd5/4AZmeQa', NULL, '2026-06-07 16:46:09', '2026-06-07 16:46:09'),
(456, 'MUHAMMAD YONI UBAIDILAH', 'muhammadyoniubaidilah@gmail.com', '16793/291/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$2pp17JC6ppz6N7kL5LOb3OLDKYNOsIAkUJYmGSq6AjHerr0I5dIHq', NULL, '2026-06-07 16:46:10', '2026-06-07 16:46:10'),
(457, 'Nezha Ananda Diah Ayu Putri', 'nezhaanandadiahayuputri@gmail.com', '16794/292/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$DlEHOav8/dOpH9JehXh1FucETz5w1DKFK57nZIiRQbmdzGagf8pHW', NULL, '2026-06-07 16:46:11', '2026-06-07 16:46:11'),
(458, 'NOVI ITSNA NAHDHIYATUL ATHFALIA', 'noviitsnanahdhiyatulathfalia@gmail.com', '16795/293/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$N0CdZJO.KbwxQHCFKYrE9.xicmH5Iqsa8IYALy0lCZqiVMQldwXTC', NULL, '2026-06-07 16:46:13', '2026-06-07 16:46:13'),
(459, 'NOVIA PUSPITA ARUM', 'noviapuspitaarum@gmail.com', '16796/294/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$UTwL8XvZi0o/4U0x2NfVo.d.MtrNrw6diGskwLEXy.05tRyOPJwxa', NULL, '2026-06-07 16:46:14', '2026-06-07 16:46:14'),
(460, 'NUR NAYLA ASIPA HOIRIYAH', 'nurnaylaasipahoiriyah@gmail.com', '16797/295/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$yOJUFbOtDSjpiJJ/qpb/VeTEIlFdNhWy9qC3czZt0Oh09FqyfE2qK', NULL, '2026-06-07 16:46:15', '2026-06-07 16:46:15'),
(461, 'NURIL AULIA', 'nurilaulia@gmail.com', '16798/296/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$nrYdTjrKlwQYF9F45UgiDu12ptbqVulDzw.PYktxNygGR87TL/b7W', NULL, '2026-06-07 16:46:16', '2026-06-07 16:46:16'),
(462, 'R. Wahyu Putrananda Satria', 'r.wahyuputranandasatria@gmail.com', '16800/298/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$ZXkJxH2iqzYKSfzVl.01yuzIn54arGoBamzVTfo/3OSE6yIMluQnO', NULL, '2026-06-07 16:46:17', '2026-06-07 16:46:17'),
(463, 'Rahma Aisyah Putri', 'rahmaaisyahputri@gmail.com', '16801/299/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$VBvHID92bK.y2cKdO40UF.NfapPURrcbbcg4hEDoWosdfdRb0dBvq', NULL, '2026-06-07 16:46:18', '2026-06-07 16:46:18'),
(464, 'Raihan Sultonul Hakim', 'raihansultonulhakim@gmail.com', '16802/300/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$MOFD91KYdzt/NKgZ/zNwsOHLqzxIRaUVz8lr55QOqObzItyUOoD2q', NULL, '2026-06-07 16:46:19', '2026-06-07 16:46:19'),
(465, 'RASSYA AKBAR RAMADHAN', 'rassyaakbarramadhan@gmail.com', '16803/301/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$S4gFiX28u9A1XTQ6ITRSRO9HASXW0qyIZExayKcb.PAs/rOAzuXuO', NULL, '2026-06-07 16:46:20', '2026-06-07 16:46:20'),
(466, 'REGA FAHRI SAPUTRA', 'regafahrisaputra@gmail.com', '16804/302/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$xfhRMqt94lY.P6ZyM9xqROVESRAIbR4SK5p2VfrusiENQ5sfWzabG', NULL, '2026-06-07 16:46:21', '2026-06-07 16:46:21'),
(467, 'Regiska Aprilyana Ristanti', 'regiskaaprilyanaristanti@gmail.com', '16805/303/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$c6YxEamxS1Tqmx5agoeufuixrEcCtGI4MX5bCWFSeHbIDDqwt9OSi', NULL, '2026-06-07 16:46:22', '2026-06-07 16:46:22'),
(468, 'Renata Izza Nuraini', 'renataizzanuraini@gmail.com', '16806/304/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$0NUrzW/LMi3FDOg8147ZE.K9dd3SanDivN59yXL8j26v0fde8ZU2m', NULL, '2026-06-07 16:46:23', '2026-06-07 16:46:23'),
(469, 'REYLANA DYAS SYAHFRANIA MASHURI', 'reylanadyassyahfraniamashuri@gmail.com', '16807/305/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$fQQrpsBgZ7X8ix5iuop/pe37OcK53wsHW7FBwntCBcSXrjVmbrg8S', NULL, '2026-06-07 16:46:24', '2026-06-07 16:46:24'),
(470, 'RISMA ANANDA PUTRI', 'rismaanandaputri@gmail.com', '16808/306/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$uiYUnlA1OmaxXxEdgcIhweT4xdygZKa4Q48ByIpt0O0IAhSdI4yXC', NULL, '2026-06-07 16:46:25', '2026-06-07 16:46:25'),
(471, 'SAHILA NUR AULIYA', 'sahilanurauliya@gmail.com', '16810/308/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$h9peK4ORbGsWq7.u/OTVSuQ8XGtuPCowShTK8/zrkRtWkOHtwTuxq', NULL, '2026-06-07 16:46:26', '2026-06-07 16:46:26'),
(472, 'Salsa Novia Nugrahati', 'salsanovianugrahati@gmail.com', '16811/309/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$3gfSW.efawtNDJAuO5zMQ.OMXah8Jvje5g4b7kQl7NjLtcOsZd166', NULL, '2026-06-07 16:46:28', '2026-06-07 16:46:28'),
(473, 'SATRIA ALEUS WIBISONO', 'satriaaleuswibisono@gmail.com', '16813/311/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$vXLMMacNpLqTj2lnItWr7Ooe1juIcOzm5FOd3Gr5pca5WROrVyaiy', NULL, '2026-06-07 16:46:29', '2026-06-07 16:46:29'),
(474, 'SEKAR RENANING GALIH', 'sekarrenaninggalih@gmail.com', '16814/312/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$gU5YYjoe69I2ZTF6OUIcZeOdafPVmsY8Xs/JH4aBVqwIyplKTxIfu', NULL, '2026-06-07 16:46:30', '2026-06-07 16:46:30'),
(475, 'SELVI YUNI ASTUTI', 'selviyuniastuti@gmail.com', '16815/313/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$rVGgKD3QUw5VaAkv16N1L.cX0op5HSvf0Sex2QxEkvK0IO2vqn1OW', NULL, '2026-06-07 16:46:31', '2026-06-07 16:46:31'),
(476, 'SHEFIRA RACHMAWATI', 'shefirarachmawati@gmail.com', '16816/314/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$UgQ3P9ZoqLT9jnS00mrzoe5tUSDmAaW.Xtu9tcaPZW01foNsT88HK', NULL, '2026-06-07 16:46:32', '2026-06-07 16:46:32'),
(477, 'SHEVIRA PUTRI NATASYA', 'sheviraputrinatasya@gmail.com', '16817/315/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$Bj1kglYYOMrQW4Xe2ZPLWuzf2ahqDFYwyeZt.MCVePgeoYLKjG5A2', NULL, '2026-06-07 16:46:33', '2026-06-07 16:46:33'),
(478, 'SITI AZZARAH AULIA PUTRI', 'sitiazzarahauliaputri@gmail.com', '16818/316/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$I9V7cG01vN6ZLAGrj/V24eX31KthU4wimu1uR.pA9shoXQzQXQzj2', NULL, '2026-06-07 16:46:34', '2026-06-07 16:46:34'),
(479, 'Taufiq Achmad Hanafi', 'taufiqachmadhanafi@gmail.com', '16819/317/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$W9tlLP2kvdkuMR4zrWQ5YubV0buElUabCKe1UqXYeiPePtzPrigWi', NULL, '2026-06-07 16:46:35', '2026-06-07 16:46:35'),
(480, 'Verdina Ananda Putri', 'verdinaanandaputri@gmail.com', '16820/318/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$JRonpAz/2zWKHD8v3SATr.wayrBy2WEX4Ma0acakXrHE8g1lSL.oS', NULL, '2026-06-07 16:46:36', '2026-06-07 16:46:36'),
(481, 'VERINA TSABITAH ANITA SURYANDARI TUSHEHA', 'verinatsabitahanitasuryandaritusheha@gmail.com', '16821/319/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$iFAapCCeokN5a2yYmDcEyO5gskA3YkVGh9GDZkyoI.OFdDAohpyeC', NULL, '2026-06-07 16:46:37', '2026-06-07 16:46:37'),
(482, 'WILDA MASLUKHA', 'wildamaslukha@gmail.com', '16822/320/068', 'XIII SIJA 2', 'siswa', NULL, NULL, NULL, '$2y$12$vsSRWszZyiuJZq096MoJluAOJaBE1oFYE9KDyg/.H1QRdqpQ/6GxO', NULL, '2026-06-07 16:46:38', '2026-06-07 16:46:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `alats`
--
ALTER TABLE `alats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjamen`
--
ALTER TABLE `peminjamen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjamen_user_id_foreign` (`user_id`),
  ADD KEY `peminjamen_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units_alat_id_foreign` (`alat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nis_unique` (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alats`
--
ALTER TABLE `alats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `peminjamen`
--
ALTER TABLE `peminjamen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=483;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peminjamen`
--
ALTER TABLE `peminjamen`
  ADD CONSTRAINT `peminjamen_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `peminjamen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alats` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

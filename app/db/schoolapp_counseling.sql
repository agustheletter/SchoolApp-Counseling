-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 12:58 PM
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
-- Database: `schoolapp_counseling`
--

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
(1, '2025_04_29_000001_create_tbl_users', 1),
(2, '2025_04_29_000002_create_tbl_sessions', 1),
(3, '2025_04_29_000003_create_tbl_login', 1),
(4, '2025_04_29_000004_create_tbl_tingkat', 1),
(5, '2025_04_29_000005_create_tbl_bulan', 1),
(6, '2025_04_29_000006_create_tbl_semester', 1),
(7, '2025_04_29_000007_create_tbl_agama', 1),
(8, '2025_04_29_000008_create_tbl_programkeahlian', 1),
(9, '2025_04_29_000009_create_tbl_jurusan', 1),
(10, '2025_04_29_000010_create_tbl_kelas', 1),
(11, '2025_04_29_000011_create_tbl_kelasdetail', 1),
(12, '2025_04_29_000012_create_tbl_siswa', 1),
(13, '2025_04_29_000013_create_tbl_siswakelas', 1),
(14, '2025_04_29_000014_create_tbl_konseling', 1),
(15, '2025_04_29_000015_create_tbl_konselingrequest', 1),
(16, '2025_05_13_132104_add_default_role_tbl_users', 1),
(17, '2025_05_21_030943_alter_user', 1),
(18, '2025_05_25_004251_create_cache_table', 1),
(19, '2025_05_25_044742_add_gender_to_tbl_users', 1),
(20, '2025_05_25_070033_add_nip_to_tbl_users', 1),
(21, '2025_05_27_111139_create_tbl_counselor', 1),
(22, '2025_06_01_092706_modify_idkonseling_column_type', 1),
(23, '2025_06_01_092916_add_foreign_key_to_tbl_konseling', 1),
(24, '2025_06_01_095916_alter_jurusans_table_make_idprogramkeahlian_nullable', 1),
(25, '2025_06_01_100335_make_idprogramkeahlian_in_jurusans_nullable', 1),
(26, '2025_06_01_100759_modify_hasil_konseling_column', 1),
(33, '2025_06_01_100852_modify_hasil_konseling_column', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `payload` longtext DEFAULT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_agama`
--

CREATE TABLE `tbl_agama` (
  `idagama` int(10) UNSIGNED NOT NULL,
  `agama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_agama`
--

INSERT INTO `tbl_agama` (`idagama`, `agama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Islam', '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL),
(2, 'Kristen Protestan', '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL),
(3, 'Kristen Katolik', '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL),
(4, 'Hindu', '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL),
(5, 'Buddha', '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL),
(6, 'Konghucu', '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bulan`
--

CREATE TABLE `tbl_bulan` (
  `idbulan` int(10) UNSIGNED NOT NULL,
  `namabulan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_counselor`
--

CREATE TABLE `tbl_counselor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jurusan`
--

CREATE TABLE `tbl_jurusan` (
  `idjurusan` int(10) UNSIGNED NOT NULL,
  `kodejurusan` varchar(255) NOT NULL,
  `namajurusan` varchar(255) NOT NULL,
  `idprogramkeahlian` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_jurusan`
--

INSERT INTO `tbl_jurusan` (`idjurusan`, `kodejurusan`, `namajurusan`, `idprogramkeahlian`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'RPL', 'Rekayasa Perangkat Lunak', 1, '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL),
(4, 'TEK', 'Teknik Elektronika Komunikasi', 1, '2025-06-01 03:41:43', '2025-06-01 03:41:43', NULL),
(5, 'IOP', 'Instrumentasi dan Otomatisasi Proses', 1, '2025-06-01 03:41:43', '2025-06-01 03:41:43', NULL),
(6, 'TPTUP', 'Teknik Pemanasan, Tata Udara, dan Pendinginan', 2, '2025-06-01 03:41:43', '2025-06-01 03:41:43', NULL),
(8, 'SIJA', 'Sistem Informasi, Jaringan, dan Aplikasi', 3, '2025-06-01 03:41:43', '2025-06-01 03:41:43', NULL),
(9, 'PSPT', 'Produksi dan Siaran Program Televisi', 4, '2025-06-01 03:41:43', '2025-06-01 03:41:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas`
--

CREATE TABLE `tbl_kelas` (
  `idkelas` int(10) UNSIGNED NOT NULL,
  `namakelas` varchar(255) NOT NULL,
  `idjurusan` int(10) UNSIGNED NOT NULL,
  `idtingkat` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelasdetail`
--

CREATE TABLE `tbl_kelasdetail` (
  `idkelasdetail` int(10) UNSIGNED NOT NULL,
  `idkelas` int(10) UNSIGNED NOT NULL,
  `idthnajaran` int(11) NOT NULL,
  `idguru` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_konseling`
--

CREATE TABLE `tbl_konseling` (
  `idkonseling` bigint(20) UNSIGNED NOT NULL,
  `idsiswa` bigint(20) UNSIGNED NOT NULL,
  `idguru` bigint(20) UNSIGNED NOT NULL,
  `tanggal_konseling` date NOT NULL,
  `hasil_konseling` text DEFAULT NULL,
  `status` enum('Pending','Completed','Canceled') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_konseling`
--

INSERT INTO `tbl_konseling` (`idkonseling`, `idsiswa`, `idguru`, `tanggal_konseling`, `hasil_konseling`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 3, '2025-06-02', 'Anaknya rada goblog', 'Completed', '2025-06-01 03:27:23', '2025-06-01 03:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_konselingrequest`
--

CREATE TABLE `tbl_konselingrequest` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idsiswa` bigint(20) UNSIGNED NOT NULL,
  `idguru` bigint(20) UNSIGNED NOT NULL,
  `kategori` enum('Pribadi','Akademik','Karir','Lainnya') NOT NULL,
  `tanggal_permintaan` datetime NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('Pending','Approved','Rejected','Completed') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_konselingrequest`
--

INSERT INTO `tbl_konselingrequest` (`id`, `idsiswa`, `idguru`, `kategori`, `tanggal_permintaan`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 3, 'Akademik', '2025-06-02 17:21:00', 'Cape', 'Completed', '2025-06-01 03:27:23', '2025-06-01 03:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `idlogin` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `idthnajaran` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_programkeahlian`
--

CREATE TABLE `tbl_programkeahlian` (
  `idprogramkeahlian` int(10) UNSIGNED NOT NULL,
  `kodeprogramkeahlian` varchar(255) NOT NULL,
  `namaprogramkeahlian` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_programkeahlian`
--

INSERT INTO `tbl_programkeahlian` (`idprogramkeahlian`, `kodeprogramkeahlian`, `namaprogramkeahlian`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PPLG', 'Pengembangan Perangkat Lunak dan Gim', '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL),
(2, 'TE', 'Teknik Elektronika', '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL),
(3, 'TK', 'Teknik Ketenagalistrikan', '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL),
(4, 'BC', 'Broadcasting dan Perfilman', '2025-06-01 03:08:13', '2025-06-01 03:08:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_semester`
--

CREATE TABLE `tbl_semester` (
  `idsemester` int(11) NOT NULL,
  `idbulan` int(10) UNSIGNED NOT NULL,
  `semester` varchar(255) NOT NULL,
  `keterangan` enum('Ganjil','Genap') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `idsiswa` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(255) NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `namasiswa` varchar(255) NOT NULL,
  `tempatlahir` varchar(255) NOT NULL,
  `tgllahir` date NOT NULL,
  `jenkel` enum('L','P') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `idjurusan` int(10) UNSIGNED NOT NULL,
  `idprogramkeahlian` int(10) UNSIGNED NOT NULL,
  `idagama` int(10) UNSIGNED NOT NULL,
  `tlprumah` varchar(255) NOT NULL,
  `hpsiswa` varchar(255) NOT NULL,
  `photosiswa` varchar(255) NOT NULL,
  `idthnmasuk` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`idsiswa`, `nis`, `nisn`, `namasiswa`, `tempatlahir`, `tgllahir`, `jenkel`, `alamat`, `idjurusan`, `idprogramkeahlian`, `idagama`, `tlprumah`, `hpsiswa`, `photosiswa`, `idthnmasuk`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1231', '1211', 'adwad', 'cibabat', '2008-07-12', 'L', 'adad', 8, 3, 4, '12313', '1313', 'siswa_photos/Zx8ZXoCH2q6l9k34h7oH75Fm2QLnlNZGsiKGgG4j.png', 2024, '2025-06-01 04:25:53', '2025-06-01 04:25:53', NULL),
(2, '13242', '213123', 'ARA', 'ADAWD', '2009-02-12', 'L', 'CAWDA', 9, 4, 5, '12313', '12313', 'siswa_photos/CRTqfpITd7AnTBib98I7DaK0HzGwWXmUwPecPURW.png', 2026, '2025-06-01 04:29:19', '2025-06-01 04:29:19', NULL),
(3, '21313', '123131', 'arkan', 'ciabbat', '2002-12-12', 'L', 'awd', 5, 1, 4, '12313', '12313', 'siswa_photos/mVqIEIVqrvRkTNLpARQTZJBcHOUYacW3dqM9WsMJ.jpg', 2026, '2025-06-01 04:33:25', '2025-06-01 04:33:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswakelas`
--

CREATE TABLE `tbl_siswakelas` (
  `idsiswakelas` int(10) UNSIGNED NOT NULL,
  `idsiswa` bigint(20) UNSIGNED NOT NULL,
  `idkelasdetail` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tingkat`
--

CREATE TABLE `tbl_tingkat` (
  `idtingkat` int(10) UNSIGNED NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idjurusan` int(10) UNSIGNED DEFAULT NULL,
  `idagama` int(10) UNSIGNED DEFAULT NULL,
  `avatar` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `email` varchar(255) NOT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nohp` varchar(15) DEFAULT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `password` varchar(255) NOT NULL,
  `role` enum('user','guru','admin') NOT NULL DEFAULT 'user',
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `idjurusan`, `idagama`, `avatar`, `nama`, `gender`, `email`, `nis`, `nip`, `tgllahir`, `alamat`, `nohp`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'default-male.png', 'Firaas Raihansyah Rizqullah', 'male', 'hulukotak@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-06-01 10:20:02', '$2y$12$/Vi6z6M4Epz3mk9Acc4oRu8dQkhExdKKbtxb0EJpEClCc6MihJ3Je', 'user', NULL, '2025-06-01 03:20:02', '2025-06-01 03:20:02'),
(2, NULL, NULL, 'default-male.png', 'arkan ardiansyah', 'male', 'miptahfardi@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-06-01 10:22:45', '$2y$12$z6KTkXtEL.sDYIL.OYzsu.olO.aTERoKJqeg2dWd3n/yFjqFRGdKe', 'admin', NULL, '2025-06-01 03:20:16', '2025-06-01 03:20:16'),
(3, NULL, NULL, 'default-female.png', 'Chintia Ghiana, S. Pd', 'female', 'chintia@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-06-01 10:20:56', '$2y$12$oNzVTymq5kZqBi/KM1vUEOGp3mh8LnbZpNe7GweboxyfcPbPfB7fi', 'guru', NULL, '2025-06-01 03:20:37', '2025-06-01 03:20:37'),
(4, NULL, NULL, 'default-male.png', 'admin', 'male', 'admin@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-06-02 05:43:49', '$2y$12$S56zmbA.MbXIm9os12ssCeVVfHnb28G18NRdRkl7iAcYdjoSqyDnu', 'admin', NULL, '2025-06-01 22:43:25', '2025-06-01 22:43:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_agama`
--
ALTER TABLE `tbl_agama`
  ADD PRIMARY KEY (`idagama`);

--
-- Indexes for table `tbl_bulan`
--
ALTER TABLE `tbl_bulan`
  ADD PRIMARY KEY (`idbulan`);

--
-- Indexes for table `tbl_counselor`
--
ALTER TABLE `tbl_counselor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
  ADD PRIMARY KEY (`idjurusan`),
  ADD KEY `tbl_jurusan_idprogramkeahlian_foreign` (`idprogramkeahlian`);

--
-- Indexes for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD PRIMARY KEY (`idkelas`),
  ADD KEY `tbl_kelas_idjurusan_foreign` (`idjurusan`),
  ADD KEY `tbl_kelas_idtingkat_foreign` (`idtingkat`);

--
-- Indexes for table `tbl_kelasdetail`
--
ALTER TABLE `tbl_kelasdetail`
  ADD PRIMARY KEY (`idkelasdetail`),
  ADD KEY `tbl_kelasdetail_idkelas_foreign` (`idkelas`);

--
-- Indexes for table `tbl_konseling`
--
ALTER TABLE `tbl_konseling`
  ADD PRIMARY KEY (`idkonseling`),
  ADD KEY `tbl_konseling_idguru_foreign` (`idguru`),
  ADD KEY `tbl_konseling_idsiswa_foreign` (`idsiswa`);

--
-- Indexes for table `tbl_konselingrequest`
--
ALTER TABLE `tbl_konselingrequest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_konselingrequest_idsiswa_foreign` (`idsiswa`),
  ADD KEY `tbl_konselingrequest_idguru_foreign` (`idguru`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`idlogin`),
  ADD KEY `tbl_login_email_index` (`email`);

--
-- Indexes for table `tbl_programkeahlian`
--
ALTER TABLE `tbl_programkeahlian`
  ADD PRIMARY KEY (`idprogramkeahlian`);

--
-- Indexes for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
  ADD PRIMARY KEY (`idsemester`),
  ADD KEY `tbl_semester_idbulan_foreign` (`idbulan`);

--
-- Indexes for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`idsiswa`),
  ADD KEY `tbl_siswa_idjurusan_foreign` (`idjurusan`),
  ADD KEY `tbl_siswa_idprogramkeahlian_foreign` (`idprogramkeahlian`),
  ADD KEY `tbl_siswa_idagama_foreign` (`idagama`);

--
-- Indexes for table `tbl_siswakelas`
--
ALTER TABLE `tbl_siswakelas`
  ADD PRIMARY KEY (`idsiswakelas`),
  ADD KEY `tbl_siswakelas_idsiswa_foreign` (`idsiswa`),
  ADD KEY `tbl_siswakelas_idkelasdetail_foreign` (`idkelasdetail`);

--
-- Indexes for table `tbl_tingkat`
--
ALTER TABLE `tbl_tingkat`
  ADD PRIMARY KEY (`idtingkat`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_users_email_index` (`email`),
  ADD KEY `idjurusan` (`idjurusan`),
  ADD KEY `idagama` (`idagama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_agama`
--
ALTER TABLE `tbl_agama`
  MODIFY `idagama` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_bulan`
--
ALTER TABLE `tbl_bulan`
  MODIFY `idbulan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_counselor`
--
ALTER TABLE `tbl_counselor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
  MODIFY `idjurusan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  MODIFY `idkelas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_kelasdetail`
--
ALTER TABLE `tbl_kelasdetail`
  MODIFY `idkelasdetail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_konselingrequest`
--
ALTER TABLE `tbl_konselingrequest`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `idlogin` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_programkeahlian`
--
ALTER TABLE `tbl_programkeahlian`
  MODIFY `idprogramkeahlian` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
  MODIFY `idsemester` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `idsiswa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_siswakelas`
--
ALTER TABLE `tbl_siswakelas`
  MODIFY `idsiswakelas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_tingkat`
--
ALTER TABLE `tbl_tingkat`
  MODIFY `idtingkat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
  ADD CONSTRAINT `tbl_jurusan_idprogramkeahlian_foreign` FOREIGN KEY (`idprogramkeahlian`) REFERENCES `tbl_programkeahlian` (`idprogramkeahlian`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD CONSTRAINT `tbl_kelas_idjurusan_foreign` FOREIGN KEY (`idjurusan`) REFERENCES `tbl_jurusan` (`idjurusan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_kelas_idtingkat_foreign` FOREIGN KEY (`idtingkat`) REFERENCES `tbl_tingkat` (`idtingkat`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_kelasdetail`
--
ALTER TABLE `tbl_kelasdetail`
  ADD CONSTRAINT `tbl_kelasdetail_idkelas_foreign` FOREIGN KEY (`idkelas`) REFERENCES `tbl_kelas` (`idkelas`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_konseling`
--
ALTER TABLE `tbl_konseling`
  ADD CONSTRAINT `tbl_konseling_idguru_foreign` FOREIGN KEY (`idguru`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_konseling_idkonseling_foreign` FOREIGN KEY (`idkonseling`) REFERENCES `tbl_konselingrequest` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_konseling_idsiswa_foreign` FOREIGN KEY (`idsiswa`) REFERENCES `tbl_siswa` (`idsiswa`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_konselingrequest`
--
ALTER TABLE `tbl_konselingrequest`
  ADD CONSTRAINT `tbl_konselingrequest_idguru_foreign` FOREIGN KEY (`idguru`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_konselingrequest_idsiswa_foreign` FOREIGN KEY (`idsiswa`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD CONSTRAINT `tbl_login_email_foreign` FOREIGN KEY (`email`) REFERENCES `tbl_users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
  ADD CONSTRAINT `tbl_semester_idbulan_foreign` FOREIGN KEY (`idbulan`) REFERENCES `tbl_bulan` (`idbulan`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD CONSTRAINT `tbl_siswa_idagama_foreign` FOREIGN KEY (`idagama`) REFERENCES `tbl_agama` (`idagama`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_siswa_idjurusan_foreign` FOREIGN KEY (`idjurusan`) REFERENCES `tbl_jurusan` (`idjurusan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_siswa_idprogramkeahlian_foreign` FOREIGN KEY (`idprogramkeahlian`) REFERENCES `tbl_programkeahlian` (`idprogramkeahlian`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_siswakelas`
--
ALTER TABLE `tbl_siswakelas`
  ADD CONSTRAINT `tbl_siswakelas_idkelasdetail_foreign` FOREIGN KEY (`idkelasdetail`) REFERENCES `tbl_kelasdetail` (`idkelasdetail`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_siswakelas_idsiswa_foreign` FOREIGN KEY (`idsiswa`) REFERENCES `tbl_siswa` (`idsiswa`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`idjurusan`) REFERENCES `tbl_jurusan` (`idjurusan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_users_ibfk_2` FOREIGN KEY (`idagama`) REFERENCES `tbl_agama` (`idagama`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2023 at 05:07 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ruangrapat`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_permohonan_rapat` int(11) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `divisi` varchar(250) NOT NULL,
  `jabatan` varchar(250) NOT NULL,
  `hari` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absen`
--

INSERT INTO `absen` (`id`, `id_permohonan_rapat`, `nama`, `divisi`, `jabatan`, `hari`, `created_at`, `updated_at`) VALUES
(1, 1, 'haikal', 'IT', 'staf', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Keuangan', NULL, NULL),
(2, 'Pemasaran', NULL, NULL),
(3, 'Dewan Komisaris', NULL, NULL),
(4, 'Direksi', NULL, NULL),
(5, 'Distribusi dan Layanan Teknik', NULL, NULL),
(6, 'Pengadaan dan Logistik', NULL, NULL),
(7, 'Pengembangan Perusahaan', NULL, NULL),
(8, 'Pengendalian Teknik', NULL, NULL),
(9, 'Perencanaan Teknik', NULL, NULL),
(10, 'Produksi', NULL, NULL),
(11, 'Satuan Pengawasan Intern', NULL, NULL),
(12, 'Sekretaris Perusahaan', NULL, NULL),
(13, 'Staf Ahli', NULL, NULL),
(14, 'Sumber Daya Manusia', NULL, NULL),
(15, 'Teknologi Informasi', NULL, NULL);

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
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(250) NOT NULL,
  `kondisi` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama`, `kondisi`, `created_at`, `updated_at`) VALUES
(3, 'Makan Siang', 'ok', NULL, NULL),
(4, 'SNACK', 'ok', NULL, NULL),
(5, 'ZOOOM', 'ok', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(250) NOT NULL,
  `nama_ruangan` varchar(250) NOT NULL,
  `nama_rapat` varchar(250) NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_04_06_072649_create_divisi_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_induk` int(11) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `divisi` varchar(250) DEFAULT NULL,
  `jabatan` varchar(250) NOT NULL,
  `lampiran` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `no_induk`, `nama`, `divisi`, `jabatan`, `lampiran`, `created_at`, `updated_at`) VALUES
(14, 1, 'Rumga', '12', 'staf', 'lampiran -1681438728-stt-nf.png', NULL, '2023-04-13 19:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_rapat`
--

CREATE TABLE `permohonan_rapat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_rapat` varchar(250) NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `waktu_keluar` datetime NOT NULL,
  `deskripsi_rapat` varchar(250) NOT NULL,
  `jumlah_peserta` int(11) NOT NULL,
  `id_ruangrapat` int(11) NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `id_fasilitas` varchar(250) NOT NULL,
  `notulen` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `catatan` varchar(250) DEFAULT NULL,
  `kode_absen` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nama_pemohon` varchar(250) DEFAULT NULL,
  `divisi` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_rapat`
--

INSERT INTO `permohonan_rapat` (`id`, `nama_rapat`, `waktu_masuk`, `waktu_keluar`, `deskripsi_rapat`, `jumlah_peserta`, `id_ruangrapat`, `id_pegawai`, `id_fasilitas`, `notulen`, `status`, `catatan`, `kode_absen`, `created_at`, `updated_at`, `nama_pemohon`, `divisi`) VALUES
(13, 'Rapat Penting', '2023-04-12 11:50:00', '2023-04-16 11:50:00', '......', 4, 1, NULL, 'SNACK', 'asd', 4, NULL, NULL, '2023-04-12 21:50:16', '2023-04-12 21:50:16', 'haikal', '4'),
(14, 'Rapat Penting', '2023-06-27 11:50:00', '2023-06-30 11:50:00', '....', 7, 1, NULL, 'SNACK', 'as', 4, NULL, NULL, '2023-04-12 21:50:59', '2023-04-12 21:50:59', 'haikal', '1'),
(15, 'Rapat Penting', '2023-04-12 11:50:00', '2023-04-16 11:50:00', '......', 4, 1, NULL, 'SNACK', 'asd', 4, NULL, NULL, '2023-04-12 21:50:16', '2023-04-12 21:50:16', 'haikal', '2'),
(16, 'Rapat Penting', '2023-06-27 11:50:00', '2023-06-30 11:50:00', '....', 7, 1, NULL, 'SNACK', 'as', 4, NULL, NULL, '2023-04-12 21:50:59', '2023-04-12 21:50:59', 'haikal', '3'),
(17, 'Rapat Penting', '2023-04-12 11:50:00', '2023-04-16 11:50:00', '......', 4, 1, NULL, 'SNACK', 'asd', 4, NULL, NULL, '2023-04-12 21:50:16', '2023-04-12 21:50:16', 'haikal', '5'),
(18, 'Rapat Penting', '2023-06-27 11:50:00', '2023-06-30 11:50:00', '....', 7, 1, NULL, 'SNACK', 'as', 4, NULL, NULL, '2023-04-12 21:50:59', '2023-04-12 21:50:59', 'haikal', '6'),
(19, 'Rapat Penting', '2023-04-12 11:50:00', '2023-04-16 11:50:00', '......', 4, 1, NULL, 'SNACK', 'asd', 4, NULL, NULL, '2023-04-12 21:50:16', '2023-04-12 21:50:16', 'haikal', '7'),
(20, 'Rapat Penting', '2023-06-27 11:50:00', '2023-06-30 11:50:00', '....', 7, 1, NULL, 'SNACK', 'as', 4, NULL, NULL, '2023-04-12 21:50:59', '2023-04-12 21:50:59', 'haikal', '8'),
(21, 'Rapat Penting', '2023-10-26 11:50:00', '2023-11-09 11:50:00', '....', 7, 1, NULL, 'SNACK', 'as', 4, NULL, NULL, '2023-04-12 21:50:59', '2023-04-12 21:50:59', 'haikal', '9'),
(22, 'Rapat Penting', '2023-04-12 11:50:00', '2023-04-16 11:50:00', '......', 4, 1, NULL, 'SNACK', 'asd', 4, NULL, NULL, '2023-04-12 21:50:16', '2023-04-12 21:50:16', 'haikal', '10'),
(23, 'Rapat Penting', '2023-06-27 11:50:00', '2023-06-30 11:50:00', '....', 7, 1, NULL, 'SNACK', 'as', 4, NULL, NULL, '2023-04-12 21:50:59', '2023-04-12 21:50:59', 'haikal', '1'),
(24, 'Rapat Penting', '2023-04-12 11:50:00', '2023-08-17 11:50:00', '......', 4, 1, NULL, 'SNACK', 'asd', 4, NULL, NULL, '2023-04-12 21:50:16', '2023-04-12 21:50:16', 'haikal', '12'),
(25, 'Rapat Penting', '2023-06-27 11:50:00', '2023-06-30 11:50:00', '....', 7, 1, NULL, 'SNACK', 'as', 4, NULL, NULL, '2023-04-12 21:50:59', '2023-04-12 21:50:59', 'haikal', '11'),
(26, 'Rapat Penting', '2023-04-12 11:50:00', '2023-04-16 11:50:00', '......', 4, 1, NULL, 'SNACK', 'asd', 4, NULL, NULL, '2023-04-12 21:50:16', '2023-04-12 21:50:16', 'haikal', '13'),
(27, 'Rapat', '2023-02-09 12:56:00', '2023-02-23 12:56:00', '...', 5, 1, NULL, 'SNACK', 'asd', 4, '...', '9a2ce', '2023-04-12 22:57:50', '2023-04-12 22:57:50', 'haikal', '1'),
(28, 'Rapat', '2023-02-10 12:58:00', '2023-02-15 12:58:00', '.....', 5, 1, NULL, 'SNACK', 'Banyak', 4, '..', '9a0e1', '2023-04-12 22:58:33', '2023-04-12 22:58:33', 'haikal', '15'),
(29, 'Rapat Penting', '2023-01-01 11:50:00', '2023-01-03 11:50:00', '....', 7, 1, NULL, 'SNACK', 'as', 4, NULL, NULL, '2023-04-12 21:50:59', '2023-04-12 21:50:59', 'haikal', '14'),
(30, 'Rapat Penting', '2023-06-27 11:50:00', '2023-06-30 11:50:00', '....', 7, 1, NULL, 'SNACK', 'as', 4, NULL, NULL, '2023-04-12 21:50:59', '2023-04-12 21:50:59', 'haikal', '3'),
(31, 'Rapat Penting', '2023-02-01 13:21:00', '2023-02-17 13:22:00', '...', 8, 1, NULL, 'SNACK', 'Banyak', 4, NULL, NULL, '2023-04-12 23:22:13', '2023-04-12 23:22:13', 'Keuangan', '1'),
(32, 'Rapat', '2023-03-01 13:22:00', '2023-03-17 13:22:00', '....', 4, 1, NULL, 'Makan Siang', 'asda', 4, NULL, NULL, '2023-04-12 23:22:44', '2023-04-12 23:22:44', 'Keuangan', '1'),
(33, '...', '2023-03-01 13:23:00', '2023-03-30 13:24:00', '...', 2, 3, NULL, 'Makan Siang', 'siapa', 4, NULL, NULL, '2023-04-12 23:24:18', '2023-04-12 23:24:18', 'haikal', '1'),
(34, '...', '2023-04-13 13:24:00', '2023-04-27 13:24:00', '....', 4, 1, NULL, 'Makan Siang', 'siapa', 4, NULL, NULL, '2023-04-12 23:24:48', '2023-04-12 23:24:48', 'haikal', '1'),
(35, 'Rapat', '2023-04-19 13:25:00', '2023-05-04 13:25:00', '....', 4, 1, NULL, 'Makan Siang', 'asd', 4, NULL, NULL, '2023-04-12 23:25:31', '2023-04-12 23:25:31', 'arar', '1'),
(36, 'ad', '2023-04-27 13:25:00', '2023-04-28 13:25:00', 'asd', 3, 1, NULL, 'Makan Siang', 'asd', 4, NULL, NULL, '2023-04-12 23:25:54', '2023-04-12 23:25:54', 'aweq', '1'),
(37, 'Rapat', '2023-05-15 13:26:00', '2023-05-18 13:26:00', '....', 5, 1, NULL, 'SNACK', 'siapa', 4, NULL, NULL, '2023-04-12 23:26:36', '2023-04-12 23:26:36', 'haikal', '1'),
(38, 'Rapat', '2023-06-08 13:26:00', '2023-06-16 13:26:00', '...', 3, 1, NULL, 'Makan Siang', 'asd', 4, NULL, NULL, '2023-04-12 23:27:01', '2023-04-12 23:27:01', 'haikal', '1'),
(39, 'ad', '2023-09-08 13:27:00', '2023-09-15 13:27:00', '....', 3, 1, NULL, 'Makan Siang', 'asd', 4, NULL, NULL, '2023-04-12 23:27:53', '2023-04-12 23:27:53', 'asdad', '1'),
(40, 'Rapat', '2023-10-26 13:28:00', '2023-10-28 13:28:00', '....', 4, 1, NULL, 'SNACK', 'asd', 4, NULL, NULL, '2023-04-12 23:28:34', '2023-04-12 23:28:34', 'haikal', '1'),
(45, 'Rapat', '2023-04-14 09:45:00', '2023-04-15 09:45:00', '....', 6, 8, NULL, 'SNACK', '...', 1, NULL, NULL, '2023-04-13 19:45:34', '2023-04-13 19:45:34', 'AdminRumga', '1'),
(46, 'Rapat', '2023-04-14 09:48:00', '2023-04-16 09:48:00', '123', 8, 2, NULL, 'SNACK', 'siapa', 1, NULL, NULL, '2023-04-13 19:48:42', '2023-04-13 19:48:42', 'haikal', '1'),
(47, 'Rapat', '2023-04-14 09:50:00', '2023-04-15 09:50:00', '...', 3, 3, NULL, 'SNACK', 'siapa', 2, '...', 'bfa6e', '2023-04-13 19:50:26', '2023-04-13 19:50:26', 'haikal', '6');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruangrapat`
--

CREATE TABLE `ruangrapat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(250) NOT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `id_pegawai` int(11) NOT NULL,
  `lokasi` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruangrapat`
--

INSERT INTO `ruangrapat` (`id`, `nama`, `kapasitas`, `id_pegawai`, `lokasi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ruang Rapat Ex Dirut', 25, 14, 'Lt 1 Sebelah Masjid', 1, '2023-04-13 19:14:16', '2023-04-13 19:14:16'),
(2, 'Ruang Rapat Dirut', 50, 14, 'Lt 3', 1, '2023-04-13 19:14:33', '2023-04-13 19:14:33'),
(3, 'Ruang Rapat Dirop', 30, 14, 'lt 1', 1, '2023-04-13 19:14:56', '2023-04-13 19:14:56'),
(4, 'Ruang Rapat Dirum', 30, 14, 'Lt 2', 1, '2023-04-13 19:15:13', '2023-04-13 19:15:13'),
(5, 'Aula', 38, 14, 'Lt 3', 1, '2023-04-13 19:16:09', '2023-04-13 19:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `emailbaru` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `adminRuangan` int(11) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `emailbaru`, `role`, `adminRuangan`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'adminDirop', 'adminDirop', 'haikalshinji@gmail.com', 1, 3, NULL, '$2y$10$N52OxDuWyrwKxGV0PqcJdef0up.cDK9YXIJ.xqF6gTwN4nXIX4Fgi', NULL, '2023-04-10 06:25:30', '2023-04-10 06:25:30'),
(3, 'adminDirut', 'AdminDIrut', 'haikalshinji@gmail.com', 1, 2, NULL, '$2y$10$N52OxDuWyrwKxGV0PqcJdef0up.cDK9YXIJ.xqF6gTwN4nXIX4Fgi', NULL, '2023-04-10 06:25:30', '2023-04-10 06:25:30'),
(4, 'adminDirum', 'adminDirum', 'haikalshinji@gmail.com', 1, 4, NULL, '$2y$10$9Q3sANoyV6w15ap2Y8dmwOq42DWoJkWDY/YmAqzi6uafuAPgmJDka', NULL, '2023-04-13 19:25:21', '2023-04-13 19:25:21'),
(5, 'divisiIT', 'divisiIT', 'haikalshinji@gmail.com', 4, NULL, NULL, '$2y$10$/YGBQGrENUc9uchdfqFB6e9DitxVmsm/u42lKe1wRZ9DFxQ9rKHau', NULL, '2023-04-13 19:42:48', '2023-04-13 19:42:48'),
(6, 'divisiKeuangan', 'divisiKeuangan', 'haikalshinji@gmail.com', 4, NULL, NULL, '$2y$10$oSFrNGGqMQSRqV55sdfIue7Bj69XkByWL1zWHAGLWYDNuJdUIAigS', NULL, '2023-04-13 19:43:51', '2023-04-13 19:43:51'),
(7, 'adminRumga', 'adminRumga', 'haikalshinji@gmail.com', 2, NULL, NULL, '$2y$10$/TsGXQTaNF1pdIQfuUkuKOqCuXZatQQNWtSuvWz7Oy0qvmZyyuIxy', NULL, '2023-04-13 19:44:30', '2023-04-13 19:44:30'),
(8, 'pemasaran', 'pemasaran', 'haikalshinji@gmail.com', 4, NULL, NULL, '$2y$10$FHUrILobRcFxv7zy2bwYAuZn18CBs28G/q9GhTFzW5gwiD5PSQRU2', NULL, '2023-04-13 20:55:57', '2023-04-13 20:55:57'),
(9, 'Distribusi', 'Distribusi', 'haikalshinji@gmail.com', 4, NULL, NULL, '$2y$10$9qE0kzuNgojq2yijsNxsbeM16Xly7PdI/J36Kg7crWIVzu2mCcT1e', NULL, '2023-04-13 20:56:51', '2023-04-13 20:56:51'),
(10, 'Pengadaan', 'Pengadaan', 'haikalshinji@gmail.com', 4, NULL, NULL, '$2y$10$XjY.VOIcYwrP9lCE5lr/5.lj.UlBmvr/rIC4p80ocZYd.y/TFKu4K', NULL, '2023-04-13 20:57:18', '2023-04-13 20:57:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan_rapat`
--
ALTER TABLE `permohonan_rapat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ruangrapat`
--
ALTER TABLE `ruangrapat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen`
--
ALTER TABLE `absen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `permohonan_rapat`
--
ALTER TABLE `permohonan_rapat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruangrapat`
--
ALTER TABLE `ruangrapat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

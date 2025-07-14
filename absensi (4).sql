-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2025 at 02:01 AM
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
-- Database: `absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_guru_mapel` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status_wali_kelas` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `tanggal_persetujuan` datetime DEFAULT NULL,
  `id_wali_kelas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_guru_mapel`, `id_kelas`, `tanggal`, `status_wali_kelas`, `tanggal_persetujuan`, `id_wali_kelas`) VALUES
(99, 14, 7, '2025-07-11', 'disetujui', NULL, 1),
(100, 15, 7, '2025-07-11', 'disetujui', NULL, 1),
(101, 16, 8, '2025-07-10', 'disetujui', NULL, 1),
(102, 14, 7, '2025-07-10', 'disetujui', NULL, 1),
(103, 14, 7, '2025-07-09', 'disetujui', NULL, 1),
(115, 14, 7, '2025-07-12', 'ditolak', NULL, 1),
(116, 15, 7, '2025-07-12', 'pending', NULL, 1),
(117, 16, 8, '2025-07-12', 'pending', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `absensi_detail`
--

CREATE TABLE `absensi_detail` (
  `id_absensi_detail` int(11) NOT NULL,
  `id_absensi` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `status_kehadiran` enum('hadir','izin','sakit','alpa') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status_pengiriman` enum('pending','terkirim','dibaca') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi_detail`
--

INSERT INTO `absensi_detail` (`id_absensi_detail`, `id_absensi`, `id_siswa`, `status_kehadiran`, `keterangan`, `status_pengiriman`) VALUES
(122, 99, 76, 'hadir', '', 'terkirim'),
(123, 99, 79, 'sakit', 'sekarat', 'terkirim'),
(124, 100, 76, 'hadir', '', 'terkirim'),
(125, 100, 79, 'hadir', '', 'terkirim'),
(126, 101, 77, 'hadir', '', 'terkirim'),
(127, 101, 80, 'sakit', '', 'terkirim'),
(128, 102, 76, 'alpa', '', 'terkirim'),
(129, 102, 79, 'hadir', '', 'terkirim'),
(130, 103, 76, 'alpa', '', 'terkirim'),
(131, 103, 79, 'alpa', '', 'terkirim'),
(158, 115, 76, 'alpa', '', 'pending'),
(159, 115, 79, 'alpa', '', 'pending'),
(160, 115, 82, 'alpa', '', 'pending'),
(161, 116, 76, 'alpa', '', 'pending'),
(162, 116, 79, 'alpa', '', 'pending'),
(163, 116, 82, 'alpa', '', 'pending'),
(164, 117, 77, 'hadir', '', 'pending'),
(165, 117, 80, 'hadir', '', 'pending');

-- --------------------------------------------------------

--
-- Stand-in structure for view `absensi_tidak_sesuai_jadwal`
-- (See below for the actual view)
--
CREATE TABLE `absensi_tidak_sesuai_jadwal` (
);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `email`, `password`) VALUES
(2, 'Admin Numan', 'no3m4n@gmail.com', '$2y$10$7xM/rpElBy0od.KObIVI0ef/wwzqQ33ZM7pxjjxqVMXfBT23dwPbK');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `nip`, `email`, `password`) VALUES
(1, 'Numan Zamaludin', '3211150511960005', 'numanzamaludin@gmail.com', '$2y$10$PHI.t7ma7V5IZhxQo8erTOhZGdO/76leYZstfjpNVwNF3YwugKzZW'),
(2, 'Satria Krisna', '3211150511960019', 'satria@gmail.com', '$2y$10$FHKp8YDlsWSMWWixPr.fxOM.91Thyc3vdoJx5jQPzQTlQbn1RAG2m'),
(6, 'dadang', '3211150511960020', 'dadang@gmail.com', '$2y$10$hOK1Odxd17oLF.FlUXz1Ruv8Qil27ebVp.9kqYrgANjmxTMjqJWWS'),
(7, 'Tina Sri', NULL, 'tina@gmail.com', '$2y$10$DT/2zQcU9x/knEI5nRfMZeRk5A1.yHU19Jigv8.zTCLm/B7bH76Kq');

-- --------------------------------------------------------

--
-- Table structure for table `guru_mapel`
--

CREATE TABLE `guru_mapel` (
  `id_guru_mapel` int(11) NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `id_mapel` int(11) DEFAULT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru_mapel`
--

INSERT INTO `guru_mapel` (`id_guru_mapel`, `id_guru`, `id_mapel`, `id_kelas`) VALUES
(14, 1, 2, 7),
(15, 1, 4, 7),
(16, 1, 5, 8),
(17, 2, 2, 8),
(18, 2, 4, 7);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `id_guru_mapel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `hari`, `jam_mulai`, `jam_selesai`, `id_guru_mapel`) VALUES
(16, 'Senin', '01:00:00', '23:59:00', 14),
(17, 'Senin', '00:00:00', '23:59:00', 15),
(18, 'Kamis', '00:00:00', '23:59:00', 16),
(19, 'Rabu', '00:00:00', '23:59:00', 14),
(20, 'Rabu', '00:00:00', '23:59:00', 18),
(21, 'Rabu', '00:00:00', '23:59:00', 17),
(22, 'Kamis', '00:00:00', '23:59:00', 15),
(23, 'Kamis', '00:00:00', '23:59:00', 14),
(24, 'Kamis', '00:00:00', '23:59:00', 16),
(25, 'Jumat', '00:00:00', '23:59:00', 14),
(26, 'Jumat', '00:00:00', '23:59:00', 15),
(30, 'Sabtu', '00:00:00', '23:59:00', 14),
(32, 'Sabtu', '00:00:00', '23:59:00', 15),
(34, 'Sabtu', '00:00:00', '23:59:00', 16),
(35, 'Sabtu', '00:00:00', '23:59:00', 18);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`) VALUES
(7, 'X TKJ A'),
(8, 'X TKJ B'),
(9, 'X TKJ C');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(100) DEFAULT NULL,
  `kode_mapel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id_mapel`, `nama_mapel`, `kode_mapel`) VALUES
(1, 'Kompetensi Keahlian Teknik Komputer dan Jaringan', 'KKTKJ'),
(2, 'Administrasi Sistem Jaringan', 'ASJ.11'),
(4, 'Teknologi Layanan Jaringan', 'TLJ'),
(5, 'Kewirausahaan', 'kwu');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `nis`, `email`, `password`, `id_kelas`) VALUES
(76, 'ariel', '311324', 'ariel@gmail.com', '$2y$10$U90qWvj5fHBZYx/ZR1eymekGeA4jWcvHrzUSVE/vZcsdMYtI7aiwy', 7),
(77, 'budi', '32423', 'budi@gmail.com', '$2y$10$aZVAqHFszWVGhQrQrcCzLeVvJGa3eA7YhL8QbHAXNgHOiL71twxTO', 8),
(78, 'cecep', '13243', 'cecep@gmail.com', '$2y$10$EYafcUP.uBwOlrFWcxhl0.4elAEnGXFcNEkbwoWNqdxV0LIlWM4cW', 9),
(79, 'Acep', '123123', 'Acep@gmail.com', '$2y$10$3Te9h4pNd4P0x6TIzaGLZ.FvMxm0x3On1aaInpK4HrrDtei9EEaI6', 7),
(80, 'Bokir', '34567', 'bokir@gmail.com', '$2y$10$n5OVN8uCU3oAW0Fsl6MPQO3TzrVcjYQc2M/yTEoKZlXyVV36VxVPG', 8),
(81, 'cika', '347234', 'cika@gmail.com', '$2y$10$ihWywUeSH61u..ZddwiJK.I.I1IAjel7Mi0MD6E9EEBhxrv/AWwKG', 9),
(82, 'arip putri budiman', '344124', 'arip@gmail.com', '$2y$10$KM48fLyR.rlIrsxdqFra.uFczLav8cPC04Z4aQM.sI.AzOm6TogQ6', 7);

-- --------------------------------------------------------

--
-- Table structure for table `wali_kelas`
--

CREATE TABLE `wali_kelas` (
  `id_wali_kelas` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wali_kelas`
--

INSERT INTO `wali_kelas` (`id_wali_kelas`, `id_guru`, `id_kelas`) VALUES
(7, 1, 7),
(8, 2, 8),
(9, 7, 9);

-- --------------------------------------------------------

--
-- Structure for view `absensi_tidak_sesuai_jadwal`
--
DROP TABLE IF EXISTS `absensi_tidak_sesuai_jadwal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `absensi_tidak_sesuai_jadwal`  AS SELECT `a`.`id_absensi` AS `id_absensi`, `a`.`id_guru_mapel` AS `id_guru_mapel`, `a`.`id_kelas` AS `id_kelas`, `a`.`tanggal` AS `tanggal`, `a`.`status_wali_kelas` AS `status_wali_kelas`, `a`.`tanggal_persetujuan` AS `tanggal_persetujuan`, `a`.`id_wali_kelas` AS `id_wali_kelas`, `g`.`id_guru` AS `id_guru`, `m`.`id_mapel` AS `id_mapel`, `k`.`nama_kelas` AS `nama_kelas` FROM (((((`absensi` `a` join `guru_mapel` `gm` on(`gm`.`id_guru_mapel` = `a`.`id_guru_mapel`)) join `guru` `g` on(`g`.`id_guru` = `gm`.`id_guru`)) join `mata_pelajaran` `m` on(`m`.`id_mapel` = `gm`.`id_mapel`)) join `kelas` `k` on(`k`.`id_kelas` = `gm`.`id_kelas`)) left join `jadwal` `j` on(`j`.`id_guru` = `g`.`id_guru` and `j`.`id_mapel` = `m`.`id_mapel` and `j`.`id_kelas` = `k`.`id_kelas` and `j`.`hari` = dayname(`a`.`tanggal`))) WHERE `j`.`id_jadwal` is null ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD UNIQUE KEY `unique_absen_perhari` (`id_guru_mapel`,`id_kelas`,`tanggal`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `absensi_ibfk_3` (`id_wali_kelas`);

--
-- Indexes for table `absensi_detail`
--
ALTER TABLE `absensi_detail`
  ADD PRIMARY KEY (`id_absensi_detail`),
  ADD KEY `id_absensi` (`id_absensi`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  ADD PRIMARY KEY (`id_guru_mapel`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `fk_guru_mapel_kelas` (`id_kelas`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `fk_jadwal_guru_mapel` (`id_guru_mapel`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `wali_kelas`
--
ALTER TABLE `wali_kelas`
  ADD PRIMARY KEY (`id_wali_kelas`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `absensi_detail`
--
ALTER TABLE `absensi_detail`
  MODIFY `id_absensi_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  MODIFY `id_guru_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `wali_kelas`
--
ALTER TABLE `wali_kelas`
  MODIFY `id_wali_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_guru_mapel`) REFERENCES `guru_mapel` (`id_guru_mapel`),
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `absensi_ibfk_3` FOREIGN KEY (`id_wali_kelas`) REFERENCES `guru` (`id_guru`);

--
-- Constraints for table `absensi_detail`
--
ALTER TABLE `absensi_detail`
  ADD CONSTRAINT `absensi_detail_ibfk_1` FOREIGN KEY (`id_absensi`) REFERENCES `absensi` (`id_absensi`),
  ADD CONSTRAINT `absensi_detail_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Constraints for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  ADD CONSTRAINT `fk_guru_mapel_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `guru_mapel_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`),
  ADD CONSTRAINT `guru_mapel_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id_mapel`);

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `fk_jadwal_guru_mapel` FOREIGN KEY (`id_guru_mapel`) REFERENCES `guru_mapel` (`id_guru_mapel`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `wali_kelas`
--
ALTER TABLE `wali_kelas`
  ADD CONSTRAINT `wali_kelas_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE,
  ADD CONSTRAINT `wali_kelas_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

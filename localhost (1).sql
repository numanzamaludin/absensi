-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 17, 2025 at 07:57 AM
-- Server version: 11.4.7-MariaDB-cll-lve
-- PHP Version: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smkw2994_absensi`
--
CREATE DATABASE IF NOT EXISTS `smkw2994_absensi` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `smkw2994_absensi`;

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
(121, 20, 13, '2025-07-16', 'disetujui', NULL, 44);

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
(262, 121, 141, 'izin', '', 'terkirim'),
(263, 121, 142, 'sakit', '', 'terkirim'),
(264, 121, 143, 'alpa', '', 'terkirim'),
(265, 121, 144, 'hadir', '', 'terkirim'),
(266, 121, 145, 'hadir', '', 'terkirim'),
(267, 121, 146, 'hadir', '', 'terkirim'),
(268, 121, 147, 'hadir', '', 'terkirim'),
(269, 121, 148, 'hadir', '', 'terkirim'),
(270, 121, 149, 'hadir', '', 'terkirim'),
(271, 121, 150, 'hadir', '', 'terkirim'),
(272, 121, 151, 'hadir', '', 'terkirim'),
(273, 121, 152, 'hadir', '', 'terkirim'),
(274, 121, 153, 'hadir', '', 'terkirim'),
(275, 121, 154, 'hadir', '', 'terkirim'),
(276, 121, 155, 'hadir', '', 'terkirim'),
(277, 121, 156, 'hadir', '', 'terkirim'),
(278, 121, 157, 'hadir', '', 'terkirim'),
(279, 121, 158, 'hadir', '', 'terkirim'),
(280, 121, 159, 'hadir', '', 'terkirim'),
(281, 121, 160, 'hadir', '', 'terkirim'),
(282, 121, 161, 'hadir', '', 'terkirim'),
(283, 121, 162, 'hadir', '', 'terkirim'),
(284, 121, 163, 'hadir', '', 'terkirim'),
(285, 121, 164, 'hadir', '', 'terkirim'),
(286, 121, 165, 'hadir', '', 'terkirim'),
(287, 121, 166, 'hadir', '', 'terkirim'),
(288, 121, 167, 'hadir', '', 'terkirim'),
(289, 121, 168, 'hadir', '', 'terkirim'),
(290, 121, 169, 'hadir', '', 'terkirim'),
(291, 121, 170, 'hadir', '', 'terkirim'),
(292, 121, 171, 'hadir', '', 'terkirim'),
(293, 121, 172, 'hadir', '', 'terkirim');

-- --------------------------------------------------------

--
-- Stand-in structure for view `absensi_tidak_sesuai_jadwal`
-- (See below for the actual view)
--
CREATE TABLE `absensi_tidak_sesuai_jadwal` (
`id_absensi` int(11)
,`id_guru_mapel` int(11)
,`id_kelas` int(11)
,`tanggal` date
,`status_wali_kelas` enum('pending','disetujui','ditolak')
,`tanggal_persetujuan` datetime
,`id_wali_kelas` int(11)
,`id_guru` int(11)
,`id_mapel` int(11)
,`nama_kelas` varchar(50)
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
-- Table structure for table `akun_email`
--

CREATE TABLE `akun_email` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('guru','siswa') NOT NULL,
  `kelas` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `akun_email`
--

INSERT INTO `akun_email` (`id`, `nama`, `email`, `role`, `kelas`, `created_at`) VALUES
(2, 'JAJANG NURJAMAN', 'jajang.nurjaman@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(3, 'MUNADIN', 'munadin@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(4, 'NANDANG', 'nandang@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(5, 'JOHAN JOHANA', 'johan.johana@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(6, 'INDRA ALISYABAN', 'indra.alisyaban@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(7, 'INDRA NASUM', 'indra.nasum@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(8, 'DADANG SULAEMAN', 'dadang.sulaeman@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(9, 'MEYMEY IRIANTI', 'meymey.irianti@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(10, 'ELI QODARIYAH', 'eli.qodariyah@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(11, 'ASEP AJI', 'asep.aji@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(12, 'MERI MARLIA', 'meri.marlia@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(13, 'SARYONO', 'saryono@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(14, 'SOPYAN KURYANA', 'sopyan.kuryana@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(15, 'DALI GANDARA', 'dali.gandara@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(16, 'MOCHAMAD WISNU FAJAR', 'mochamad.wisnu.fajar@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(17, 'DEVI SRI MULYANI', 'devi.sri.mulyani@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(18, 'TINA SRI HANDAYANI', 'tina.sri.handayani@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(19, 'SATRIA KRISNA MUKTI', 'satria.krisna.mukti@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(20, 'VINI MARYANTI', 'vini.maryanti@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(21, 'SITI AISYAH', 'siti.aisyah@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(22, 'NOVELA AFFRI RASITANIA', 'novela.affri.rasitania@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(23, 'RIKA KURNIAWATI', 'rika.kurniawati@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(24, 'NUR CAHYATI', 'nur.cahyati@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(25, 'ADITYA RAHMAN', 'aditya.rahman@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(26, 'SRI PUJI UTAMI', 'sri.puji.utami@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(27, 'ROSI ROSDIANA', 'rosi.rosdiana@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(28, 'NU\'MAN ZAMALUDIN', 'nu.man.zamaludin@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(29, 'RIKA AGUSTINA', 'rika.agustina@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(30, 'ISNAWATI NURKHOLIK', 'isnawati.nurkholik@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(31, 'RIZAL HENDRI PERDIANA', 'rizal.hendri.perdiana@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(32, 'DADAN HERMANA', 'dadan.hermana@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(33, 'MOCH. SAEPULOH ROCHMAN', 'moch.saepuloh.rochman@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(34, 'CHILDA MALINA', 'childa.malina@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(35, 'RISKI NURUL INSANI', 'riski.nurul.insani@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(36, 'FAJAR PUJA KESUMA', 'fajar.puja.kesuma@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(37, 'DEDE AIDAH', 'dede.aidah@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(38, 'TIARA DEWI PUTRI ADJIE', 'tiara.dewi.putri.adjie@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(39, 'IPAN SOPIANA', 'ipan.sopiana@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(40, 'ASEP SUPRIATNA', 'asep.supriatna@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(41, 'NUGRAHA HABIBILAH', 'nugraha.habibilah@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(42, 'FRESA FEBRIANTI RAHAYU', 'fresa.febrianti.rahayu@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(43, 'EDIH SURYADI', 'edih.suryadi@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(44, 'YAN YAN', 'yan.yan@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(45, 'SYAMSUL ILHAM FIRDAUS', 'syamsul.ilham.firdaus@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(46, 'SYIFA FADILAH', 'syifa.fadilah@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(47, 'SYIFA NURRIZKIYA', 'syifa.nurrizkiya@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(48, 'ANGGIA PERMATASARI', 'anggia.permatasari@guru.smkperkasa.sch.id', 'guru', 'guru', '2025-07-15 21:02:21'),
(49, 'Aditia Perdiansyah', 'aditia.perdiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(50, 'Afdal Atalah Yumna', 'afdal.atalah.yumna@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(51, 'Aira Saputri', 'aira.saputri@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(52, 'DEA AMANDA', 'dea.amanda@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(53, 'Dede Sidqi Alditiya', 'dede.sidqi.alditiya@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(54, 'Fanni Novianti', 'fanni.novianti@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(55, 'FAUJIAH', 'faujiah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(56, 'Fitri Maelani', 'fitri.maelani@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(57, 'HARYO JATNIKO', 'haryo.jatniko@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(58, 'ILHAM MAULANA', 'ilham.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(59, 'Isna Siti Hajar', 'isna.siti.hajar@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(60, 'Julia Dewi Yuandira', 'julia.dewi.yuandira@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(61, 'JUWITA LESTARI', 'juwita.lestari@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(62, 'KHAYRAN ZALFA HIDAYAT', 'khayran.zalfa.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(63, 'KURNIAWAN', 'kurniawan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(64, 'Melan Meilani', 'melan.meilani@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(65, 'Melani Febriyanti', 'melani.febriyanti@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(66, 'MOCHAMMAD REYSWAN ARDYA', 'mochammad.reyswan.ardya@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(67, 'MUHAMAD RIDWAN', 'muhamad.ridwan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(68, 'NENG SRI MULYANI', 'neng.sri.mulyani@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(69, 'Nissa Nuraisyah', 'nissa.nuraisyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(70, 'PUTRI LAELASARI', 'putri.laelasari@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(71, 'Raihan Febriano', 'raihan.febriano@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(72, 'RAIHAN HERNAWAN', 'raihan.hernawan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(73, 'REIHAN ALIF PUTRA PRATAMA', 'reihan.alif.putra.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(74, 'RIFAN HIDAYAH', 'rifan.hidayah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(75, 'RISKI', 'riski@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(76, 'Riski Permana', 'riski.permana@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(77, 'SANDI GUNAWAN', 'sandi.gunawan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(78, 'Senandung Nacita Camelia', 'senandung.nacita.camelia@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(79, 'Taufik Hidayat', 'taufik.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(80, 'WINDIYAWATI', 'windiyawati@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ A', '2025-07-15 22:20:28'),
(81, 'Ajeng Gina Solehah', 'ajeng.gina.solehah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(82, 'ANDREAN PRADITA', 'andrean.pradita@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(83, 'AZRIL ZULFIKAR KHOIRUL MARIK', 'azril.zulfikar.khoirul.marik@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(84, 'Cika Karin Agustin', 'cika.karin.agustin@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(85, 'Desi Rahmawati', 'desi.rahmawati@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(86, 'Devi Aulia', 'devi.aulia@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(87, 'Irma', 'irma@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(88, 'LUCKY PRAMANA PUTRA', 'lucky.pramana.putra@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(89, 'MISSELA MAULIDA PUTRI', 'missela.maulida.putri@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(90, 'MUAMMAR KHADAFI', 'muammar.khadafi@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(91, 'MUHAMAD ALVIAN NUGRAHA', 'muhamad.alvian.nugraha@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(92, 'MUHAMAD DEA PERMANA', 'muhamad.dea.permana@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(93, 'NOPAL', 'nopal@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(94, 'Nova Ardiansah', 'nova.ardiansah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(95, 'Rahma Lestari', 'rahma.lestari@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(96, 'REPAN RIZAL APANDI', 'repan.rizal.apandi@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(97, 'RESI ASTARI', 'resi.astari@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(98, 'Revandi Handika Putra', 'revandi.handika.putra@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(99, 'RIZKI', 'rizki@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(100, 'Rizmala Wandani', 'rizmala.wandani@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(101, 'SALSA TRI CAHYA', 'salsa.tri.cahya@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(102, 'Salwa Septianti', 'salwa.septianti@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(103, 'Silvia Nurhasanah Fafila Nacha', 'silvia.nurhasanah.fafila.nacha@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(104, 'Siti Maelani', 'siti.maelani@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(105, 'Tita Aprilianti', 'tita.aprilianti@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(106, 'Wulan Sari', 'wulan.sari@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ B', '2025-07-15 22:20:28'),
(107, 'ALIKA SARI', 'alika.sari@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(108, 'ANISA SUCI DWI ANJANI', 'anisa.suci.dwi.anjani@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(109, 'Auliya Salma Fitriya', 'auliya.salma.fitriya@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(110, 'Azam Suryandi', 'azam.suryandi@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(111, 'DWI GUFIYANA SYAPUTRA', 'dwi.gufiyana.syaputra@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(112, 'Endang Suminar', 'endang.suminar@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(113, 'FERDI ARDIANSYAH', 'ferdi.ardiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(114, 'HANIF IRSYAD ARROJIB', 'hanif.irsyad.arrojib@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(115, 'Jajang Zaenal', 'jajang.zaenal@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(116, 'Kiki Setiwan', 'kiki.setiwan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(117, 'Muhamad Hardiansyah', 'muhamad.hardiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(118, 'Muhammad Rizqi Al \'Buqhori', 'muhammad.rizqi.al.buqhori@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(119, 'Novita Lestari', 'novita.lestari@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(120, 'Nurul Padilah', 'nurul.padilah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(121, 'ORIZA SATIVA HERYANTO', 'oriza.sativa.heryanto@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(122, 'Padli Muhamad Fazra', 'padli.muhamad.fazra@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(123, 'RIDWAN HIDAYAT', 'ridwan.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(124, 'Rifqi Rafid Abdullah', 'rifqi.rafid.abdullah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(125, 'Rosa Amelia', 'rosa.amelia@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(126, 'Rosita', 'rosita@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(127, 'Sonjaya', 'sonjaya@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(128, 'SRI WAHYUNI', 'sri.wahyuni@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(129, 'Tina Pitria', 'tina.pitria@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(130, 'Ujang Regi Jaenal', 'ujang.regi.jaenal@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(131, 'WALIYUDIN FADILAH', 'waliyudin.fadilah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKJ C', '2025-07-15 22:20:28'),
(132, 'Aa Sidik Purnama', 'aa.sidik.purnama@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(133, 'Adit Ardiyan', 'adit.ardiyan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(134, 'Agung Barokah', 'agung.barokah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(135, 'Agung Guntara', 'agung.guntara@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(136, 'Ahmad Riyan', 'ahmad.riyan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(137, 'ALIF HADI SAPUTRA', 'alif.hadi.saputra@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(138, 'BAYU RIZKI', 'bayu.rizki@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(139, 'BRIAN BAKHTIAR ROSIDIQ', 'brian.bakhtiar.rosidiq@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(140, 'Dea Maulana', 'dea.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(141, 'Dede Muhamad Mansur', 'dede.muhamad.mansur@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(142, 'Fakhri Ahmad Azzam', 'fakhri.ahmad.azzam@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(143, 'Galih Anggara', 'galih.anggara@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(144, 'Hari', 'hari@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(145, 'Irgi Fadilatul Sidik', 'irgi.fadilatul.sidik@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(146, 'Jaka Nugraha Mubarok', 'jaka.nugraha.mubarok@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(147, 'Luki Somantri', 'luki.somantri@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(148, 'Moch. Fitrah Taufik Riyadi', 'moch.fitrah.taufik.riyadi@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(149, 'MUHAMMAD YUSUF RONALDO', 'muhammad.yusuf.ronaldo@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(150, 'Muhhamad Zahran Argian', 'muhhamad.zahran.argian@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(151, 'Riki Jamas Mustakin', 'riki.jamas.mustakin@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(152, 'Rio Herdiansyah', 'rio.herdiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(153, 'Riski Aditya', 'riski.aditya@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(154, 'Riyan Etaham', 'riyan.etaham@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(155, 'Rizal Aditia', 'rizal.aditia@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(156, 'Rizki Ramdani', 'rizki.ramdani@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(157, 'Usep Saepudin', 'usep.saepudin@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(158, 'Wawan Setiawan', 'wawan.setiawan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR A', '2025-07-15 22:20:28'),
(159, 'Aditya Pratama Putra', 'aditya.pratama.putra@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(160, 'AHMAD FAUZI', 'ahmad.fauzi@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(161, 'Ahmad Hudaya Al Gifari', 'ahmad.hudaya.al.gifari@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(162, 'AHMAD NASIRI MUZAKKI', 'ahmad.nasiri.muzakki@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(163, 'Denis', 'denis@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(164, 'Eki Parel', 'eki.parel@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(165, 'FADLAN RAMDANI', 'fadlan.ramdani@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(166, 'GATHAN ALTAGANTARI KHAIR', 'gathan.altagantari.khair@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(167, 'Hanif Akmal Zaidan Abidin', 'hanif.akmal.zaidan.abidin@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(168, 'Ihsan Hamzah Maulana', 'ihsan.hamzah.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(169, 'ILYAS FIRDAUS ILHAMI', 'ilyas.firdaus.ilhami@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(170, 'Irgi Wirapratama', 'irgi.wirapratama@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(171, 'IVAN SOPANDI', 'ivan.sopandi@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(172, 'Lucky Wisnu Al Fiandi', 'lucky.wisnu.al.fiandi@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(173, 'MOEHAMAD RIZKY AL FARIANSYAH', 'moehamad.rizky.al.fariansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(174, 'Mohammad Sabarudin', 'mohammad.sabarudin@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(175, 'MUHAMAD FARIZ SIDIK', 'muhamad.fariz.sidik@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(176, 'MUHAMAD RIDWAN FERDIANSYAH', 'muhamad.ridwan.ferdiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(177, 'Muhamad Yudi Hidayat', 'muhamad.yudi.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(178, 'NABIL NAZRIL ILHAM', 'nabil.nazril.ilham@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(179, 'NAJIB ALGHAZALI', 'najib.alghazali@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(180, 'NUR ROHMAN FAUZAN', 'nur.rohman.fauzan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(181, 'RAIHAN PUTRA RAHAYU', 'raihan.putra.rahayu@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(182, 'RASA WIGUNA', 'rasa.wiguna@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(183, 'Saepul Purnama', 'saepul.purnama@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(184, 'Salendra Melandry', 'salendra.melandry@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(185, 'Tarto Zaelani', 'tarto.zaelani@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(186, 'WISHNU WARDHANA', 'wishnu.wardhana@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR B', '2025-07-15 22:20:28'),
(187, 'Akbar Ramadan', 'akbar.ramadan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(188, 'ANDIKA SURYA PRATAMA', 'andika.surya.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(189, 'ANDRE PAUJI', 'andre.pauji@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(190, 'Andrean Firmansyah', 'andrean.firmansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(191, 'ANDRIAN ROHIMAN', 'andrian.rohiman@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(192, 'ASUTISNA', 'asutisna@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(193, 'Bayu Febiansyah', 'bayu.febiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(194, 'Bayu Sukma', 'bayu.sukma@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(195, 'Bima Setyo Purnomo', 'bima.setyo.purnomo@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(196, 'CAHYANA', 'cahyana@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(197, 'Cep Yayan', 'cep.yayan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(198, 'Dirga Muhamad Rizki', 'dirga.muhamad.rizki@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(199, 'DWI NUR AZIS PRASETYO', 'dwi.nur.azis.prasetyo@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(200, 'Fauzan Khoirul Reyhan', 'fauzan.khoirul.reyhan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(201, 'GILANG RAMADAN NURZAMAN', 'gilang.ramadan.nurzaman@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(202, 'Irfan Ramadhan', 'irfan.ramadhan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(203, 'M. Faisal', 'm.faisal@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(204, 'Muhamad Ari Kamanda', 'muhamad.ari.kamanda@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(205, 'MUHAMAD FARHAN', 'muhamad.farhan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(206, 'MUHAMAD IKBAL H', 'muhamad.ikbal.h@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(207, 'Muhamad Mardiansyah', 'muhamad.mardiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(208, 'MUHAMAD RENALDI', 'muhamad.renaldi@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(209, 'Muhamad Revan Reviana Nugraha', 'muhamad.revan.reviana.nugraha@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(210, 'Muhamad Zenal Mustopa', 'muhamad.zenal.mustopa@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(211, 'Muhammad Azhari Mardiansyah', 'muhammad.azhari.mardiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(212, 'Muhammad Fajar Shiddiq', 'muhammad.fajar.shiddiq@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(213, 'Najmu Sakib', 'najmu.sakib@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(214, 'NAZWAN RIZKI', 'nazwan.rizki@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(215, 'Pahmi Sahru Roji', 'pahmi.sahru.roji@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(216, 'Rendra Pardika Awaluya', 'rendra.pardika.awaluya@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(217, 'Repan Gunawan', 'repan.gunawan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(218, 'Rizky Muhamad Agung Pratama', 'rizky.muhamad.agung.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(219, 'RIZKY MUHAMAD GILANG RAMADHAN', 'rizky.muhamad.gilang.ramadhan@siswa.smkperkasa.sch.id', 'siswa', 'XI TKR C', '2025-07-15 22:20:28'),
(220, 'ADE AGASTA', 'ade.agasta@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(221, 'Aditia Laksana Putra', 'aditia.laksana.putra@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(222, 'Agung Permana', 'agung.permana@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(223, 'Bayu', 'bayu@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(224, 'Cahya Lesmana', 'cahya.lesmana@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(225, 'Choky Avian Pratama', 'choky.avian.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(226, 'DAFA AHMAD FAUZI', 'dafa.ahmad.fauzi@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(227, 'DE VAHLI DZALU SUMPENA', 'de.vahli.dzalu.sumpena@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(228, 'Diki Saepul Anwar', 'diki.saepul.anwar@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(229, 'Fadli Firmansyah', 'fadli.firmansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(230, 'Hafiz Salman Farisi', 'hafiz.salman.farisi@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(231, 'Ikhsan Subagja', 'ikhsan.subagja@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(232, 'IZAN ALDIYAN SYAH', 'izan.aldiyan.syah@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(233, 'LUAN DZAKIR HANIF', 'luan.dzakir.hanif@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(234, 'Luki Setiawan', 'luki.setiawan@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(235, 'MOHAMAD GILANG RAMADHAN', 'mohamad.gilang.ramadhan@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(236, 'MUHAMAD ALDY SURYANA', 'muhamad.aldy.suryana@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(237, 'MUHAMAD IHSAN', 'muhamad.ihsan@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(238, 'Muhammad Ilham Putra Hermawan', 'muhammad.ilham.putra.hermawan@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(239, 'NURJAMAN', 'nurjaman@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(240, 'Oki Sukarno', 'oki.sukarno@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(241, 'RAMDAN SEPTIAWAN', 'ramdan.septiawan@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(242, 'Refan Aldiansyah', 'refan.aldiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(243, 'Renaldi', 'renaldi@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(244, 'Reyhan Cepy Ginanjar', 'reyhan.cepy.ginanjar@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(245, 'Rico Nata Palaesa', 'rico.nata.palaesa@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(246, 'RIDWAN NURUL AKBAR', 'ridwan.nurul.akbar@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(247, 'Wisman Ade Putra', 'wisman.ade.putra@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM A', '2025-07-15 22:20:28'),
(248, 'Aditya Pebriansyah', 'aditya.pebriansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(249, 'Agung Rendiansyah', 'agung.rendiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(250, 'Ahmad Supriyadi', 'ahmad.supriyadi@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(251, 'AHMAD WAHYU NUR MULYANA', 'ahmad.wahyu.nur.mulyana@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(252, 'ALFI APRILIAN APANDI', 'alfi.aprilian.apandi@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(253, 'Alfin Muhamad Adriyansyah', 'alfin.muhamad.adriyansyah@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(254, 'ALGI', 'algi@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(255, 'Ali Nurjaman', 'ali.nurjaman@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(256, 'Alip Saepudin Fatuloh', 'alip.saepudin.fatuloh@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(257, 'Cepi Permadi', 'cepi.permadi@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(258, 'Cevy Mulyadi', 'cevy.mulyadi@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(259, 'Dheva Rezky Ramadhani', 'dheva.rezky.ramadhani@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(260, 'Dika Hardiansah', 'dika.hardiansah@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(261, 'FERY ANDIKA PRATAMA', 'fery.andika.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(262, 'Hilman Sanjaya Putra', 'hilman.sanjaya.putra@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(263, 'ILHAM ADITYA', 'ilham.aditya@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(264, 'Junior Yusup Aljaelani', 'junior.yusup.aljaelani@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(265, 'Muhamad Fajar', 'muhamad.fajar@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(266, 'MUHAMAD RIZKI', 'muhamad.rizki@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(267, 'MUHAMAD RIZQI RAMADAN', 'muhamad.rizqi.ramadan@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(268, 'Muhammad Fauzal', 'muhammad.fauzal@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(269, 'MUHAMMAD RIZKI PADILAH', 'muhammad.rizki.padilah@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(270, 'Pahriz', 'pahriz@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(271, 'RIFKI FIRMAN', 'rifki.firman@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(272, 'Rizal Fauzi Permana', 'rizal.fauzi.permana@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(273, 'RIZAL MAULANA', 'rizal.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(274, 'Rizki Fauzi', 'rizki.fauzi@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(275, 'RIZKY FADILAH', 'rizky.fadilah@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(276, 'Robi Mulyana', 'robi.mulyana@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(277, 'Usup Nugraha', 'usup.nugraha@siswa.smkperkasa.sch.id', 'siswa', 'XI TPM B', '2025-07-15 22:20:28'),
(278, 'Abdul Wahab', 'abdul.wahab@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(279, 'ALPHA SATRIANI CARIUS', 'alpha.satriani.carius@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(280, 'ARKA NURIL IZANI', 'arka.nuril.izani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(281, 'Ayu Lasmini', 'ayu.lasmini@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(282, 'BINTANG ALBAR', 'bintang.albar@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(283, 'CAESARIO OCTAVIAN BYZANTINE', 'caesario.octavian.byzantine@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(284, 'DAFA RAISYAH ARIFIN', 'dafa.raisyah.arifin@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(285, 'DAMAR DWI CAHYO', 'damar.dwi.cahyo@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(286, 'DEBI RISMA WARDANI', 'debi.risma.wardani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(287, 'Dewi Kartika', 'dewi.kartika@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(288, 'Fikri Alamsyah', 'fikri.alamsyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(289, 'FIRMAN SETIAWAN', 'firman.setiawan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(290, 'Hendra', 'hendra@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(291, 'Jajang Laksana', 'jajang.laksana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(292, 'KAKA PABIAN NAKULA', 'kaka.pabian.nakula@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(293, 'Kiki Pabian Sadewa', 'kiki.pabian.sadewa@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(294, 'Mariyah Ulfah Hidayah', 'mariyah.ulfah.hidayah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(295, 'Melani Putri', 'melani.putri@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(296, 'MOCH RAFI APRIANSYAH', 'moch.rafi.apriansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(297, 'Muhamad Aji Permana', 'muhamad.aji.permana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(298, 'MUHAMAD FAREL TESAR ADITYA', 'muhamad.farel.tesar.aditya@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(299, 'MUHAMAD SOPYAN FAUZI', 'muhamad.sopyan.fauzi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(300, 'MUHAMMAD RAIHAN', 'muhammad.raihan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(301, 'Nita Marselani', 'nita.marselani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(302, 'SALAS ABDULAH', 'salas.abdulah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(303, 'Salsabila Sapitri', 'salsabila.sapitri@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(304, 'SITI ROHMAH', 'siti.rohmah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(305, 'Syahril Eight Guard', 'syahril.eight.guard@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(306, 'Taufik Hidayat', 'taufik.hidayat1@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(307, 'Zeny Pertiwi', 'zeny.pertiwi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ A', '2025-07-15 22:20:28'),
(308, 'ALANNIS FUJI SYAHRANI', 'alannis.fuji.syahrani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(309, 'ARYA MAULANA ANGGARA', 'arya.maulana.anggara@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(310, 'Asni Purwanti', 'asni.purwanti@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(311, 'DAFFA FAIZAL', 'daffa.faizal@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(312, 'Damelia', 'damelia@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(313, 'Dika Aditama', 'dika.aditama@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(314, 'Dika Reyhan Aditiya', 'dika.reyhan.aditiya@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(315, 'Dimas Arifin', 'dimas.arifin@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(316, 'Fadli Fadilah', 'fadli.fadilah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(317, 'FARHAN TANJUNG RIZIQ', 'farhan.tanjung.riziq@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(318, 'Irfan Nurhakim', 'irfan.nurhakim@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(319, 'LEPLY AGLIANSYAH', 'leply.agliansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(320, 'M. DAVA ABDI RAMANDA', 'm.dava.abdi.ramanda@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(321, 'Muhammad Abdul Backi Juliansyah', 'muhammad.abdul.backi.juliansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(322, 'Muhammad Araafidin Aslama', 'muhammad.araafidin.aslama@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(323, 'MUHAMMAD LUKMAN FIRMANSYAH', 'muhammad.lukman.firmansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(324, 'MUHAMMAD RIZKY LEGIANA', 'muhammad.rizky.legiana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(325, 'Nadia Meilani Fadilah', 'nadia.meilani.fadilah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(326, 'Novi Siti Muchlisoh', 'novi.siti.muchlisoh@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(327, 'Rama Bayu Rizqi', 'rama.bayu.rizqi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(328, 'Rendhy Afreza Pratama', 'rendhy.afreza.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(329, 'Siti Nur Hasanah', 'siti.nur.hasanah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(330, 'SRI HARYANI', 'sri.haryani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(331, 'Toni Herdiansyah', 'toni.herdiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(332, 'Varel Poetra Satria', 'varel.poetra.satria@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(333, 'WIDIANSYAH ZULFIKAR', 'widiansyah.zulfikar@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(334, 'YUGA SUKMA PRATAMA', 'yuga.sukma.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ B', '2025-07-15 22:20:28'),
(335, 'Aisyah Latifa Nursyifa', 'aisyah.latifa.nursyifa@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(336, 'Ali Aghisna', 'ali.aghisna@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(337, 'Anggi Septiani Ramadani', 'anggi.septiani.ramadani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(338, 'ANUGRAH PUTRA ADITYA', 'anugrah.putra.aditya@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(339, 'ASTRI FADILLAH', 'astri.fadillah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(340, 'AULIA ANGGRAINI PUTRI', 'aulia.anggraini.putri@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(341, 'Dalpa Daroriah', 'dalpa.daroriah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(342, 'DERA RAMADANI', 'dera.ramadani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(343, 'ESA FATIMAH QOMARIAH FIRIZKI', 'esa.fatimah.qomariah.firizki@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(344, 'FRANSZA ABDULLAH ADIJAYA', 'fransza.abdullah.adijaya@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(345, 'Julia Fitri', 'julia.fitri@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(346, 'Lismi Haniati', 'lismi.haniati@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(347, 'Meidina Isma', 'meidina.isma@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(348, 'Moch Rizal', 'moch.rizal@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(349, 'MUHAMMAD DAFFA HERMAWAN', 'muhammad.daffa.hermawan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(350, 'MUHAMMAD FAHRI LUKMANULHAKIM', 'muhammad.fahri.lukmanulhakim@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(351, 'Mustika Dewi', 'mustika.dewi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(352, 'Rahayu', 'rahayu@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(353, 'Ramadhan Faturohman', 'ramadhan.faturohman@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(354, 'Rehan Maulana', 'rehan.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(355, 'Rima Honisah', 'rima.honisah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(356, 'Saeful Mubarok', 'saeful.mubarok@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(357, 'SELI', 'seli@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(358, 'Taryana', 'taryana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(359, 'TRIASYA MULYA RAHMAT', 'triasya.mulya.rahmat@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(360, 'Wida Pirmansah', 'wida.pirmansah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(361, 'Wili Saepuloh', 'wili.saepuloh@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(362, 'Yulia', 'yulia@siswa.smkperkasa.sch.id', 'siswa', 'XII TKJ C', '2025-07-15 22:20:28'),
(363, 'AHMAD MAULANA MALIK', 'ahmad.maulana.malik@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(364, 'ANDRIS ZAKI HARDIANSYAH', 'andris.zaki.hardiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(365, 'Anggi Candriyana', 'anggi.candriyana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(366, 'Dede Dian', 'dede.dian@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(367, 'Dedep Restu Fauzi', 'dedep.restu.fauzi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(368, 'Dian Sidik', 'dian.sidik@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(369, 'Diaz Ega Lesmana', 'diaz.ega.lesmana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(370, 'Diki Ardiansyah', 'diki.ardiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(371, 'Dimas Angga Diputra', 'dimas.angga.diputra@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(372, 'Dodi Fernadi', 'dodi.fernadi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(373, 'FIRRIZQY AN-NAAS ARSY', 'firrizqy.an.naas.arsy@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(374, 'Hilman Fauzi', 'hilman.fauzi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(375, 'Irwansyah', 'irwansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(376, 'MOCH CANDRA HIDAYAT', 'moch.candra.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(377, 'Muhamad Fauzan Ramadhan', 'muhamad.fauzan.ramadhan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(378, 'MUHAMAD ILHAM AGUSTIAN', 'muhamad.ilham.agustian@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(379, 'MUHAMAD IRFAN GUNAWAN HILMI', 'muhamad.irfan.gunawan.hilmi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(380, 'MUHAMAD RIAN APRILIANO', 'muhamad.rian.apriliano@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(381, 'Muhamad Rizky Abdul Goni', 'muhamad.rizky.abdul.goni@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(382, 'MUHAMMAD AZIS', 'muhammad.azis@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(383, 'Muhammad Azriel Saomi', 'muhammad.azriel.saomi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(384, 'Muhammad Haikal Maulana', 'muhammad.haikal.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(385, 'NENDI SUPRIYADI', 'nendi.supriyadi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(386, 'PANDU PUTRA SETIAWAN', 'pandu.putra.setiawan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(387, 'RANGGA', 'rangga@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(388, 'Rendi', 'rendi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(389, 'RISKI ABDUL AZIS', 'riski.abdul.azis@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(390, 'Sandika Wahyu Ramadhan', 'sandika.wahyu.ramadhan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(391, 'Soleh Abdul Rohman', 'soleh.abdul.rohman@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(392, 'Syahdan Wildan Sopian', 'syahdan.wildan.sopian@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(393, 'Yadi Handika', 'yadi.handika@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR A', '2025-07-15 22:20:28'),
(394, 'ADAM KURNIAWAN', 'adam.kurniawan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(395, 'Ari Pratama Putra', 'ari.pratama.putra@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(396, 'Azka Ubaidillah', 'azka.ubaidillah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(397, 'Dadan', 'dadan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(398, 'DELA PUSPITA', 'dela.puspita@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(399, 'Donitata Pradita', 'donitata.pradita@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(400, 'Fajar Agustian', 'fajar.agustian@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(401, 'Fondra', 'fondra@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(402, 'GUNA RAGA', 'guna.raga@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(403, 'INDRA PRATAMA', 'indra.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(404, 'Moh. Sandi', 'moh.sandi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(405, 'Mugia Al Vassa', 'mugia.al.vassa@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(406, 'MUHAMAD ADITIYA MAULANA', 'muhamad.aditiya.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(407, 'MUHAMAD ANGGA', 'muhamad.angga@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(408, 'Muhamad Bima Maulana', 'muhamad.bima.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(409, 'Muhammad Rifki Aldiansyah', 'muhammad.rifki.aldiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(410, 'MUHAMMAD RIZKI DWIANANDA', 'muhammad.rizki.dwiananda@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(411, 'Oki Fauzi Rahmat', 'oki.fauzi.rahmat@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(412, 'PAHMI FADILAH', 'pahmi.fadilah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(413, 'Pasha', 'pasha@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(414, 'RENDRA MUHAMAD AFDAL', 'rendra.muhamad.afdal@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(415, 'Reza Mochamad Rizky', 'reza.mochamad.rizky@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(416, 'Riyan Nulhakim', 'riyan.nulhakim@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(417, 'RIZKI RAMDANI', 'rizki.ramdani1@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(418, 'SURYADI RAMDANI HIDAYAT', 'suryadi.ramdani.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(419, 'YUDA PRATAMA', 'yuda.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR B', '2025-07-15 22:20:28'),
(420, 'Aditia Ramadani', 'aditia.ramadani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(421, 'Ateng Hidayat', 'ateng.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(422, 'BAGUS ISMAIL SETIAWAN', 'bagus.ismail.setiawan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(423, 'CECEP MUHAMMAD ALIF', 'cecep.muhammad.alif@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(424, 'Dimas Putra Pratama', 'dimas.putra.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(425, 'DONNY ACHMAD DARAJAT', 'donny.achmad.darajat@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(426, 'EGI RIYADI', 'egi.riyadi@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(427, 'Fajar Maulana Sidik', 'fajar.maulana.sidik@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(428, 'Farid Abdul Karim', 'farid.abdul.karim@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(429, 'GANESHA NUR ZACKY RUSTIAWAN', 'ganesha.nur.zacky.rustiawan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(430, 'Muhamad Adrian Al Lathif', 'muhamad.adrian.al.lathif@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(431, 'MUHAMAD ALIF RABBANI', 'muhamad.alif.rabbani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(432, 'MUHAMAD ARIF', 'muhamad.arif@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(433, 'MUHAMAD ARIFIN PRASETYA', 'muhamad.arifin.prasetya@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(434, 'MUHAMAD TAUFIK HIDAYAT', 'muhamad.taufik.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(435, 'Muhammad Rifki Ramdani', 'muhammad.rifki.ramdani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(436, 'RADIT DWI PERMANA', 'radit.dwi.permana@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(437, 'RAMA HERMALINGGA', 'rama.hermalingga@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(438, 'Rian Nugraha', 'rian.nugraha@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(439, 'Rijal Faisal', 'rijal.faisal@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(440, 'Rizky Agustian', 'rizky.agustian@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(441, 'Rizqi Miftahul Ikhsan', 'rizqi.miftahul.ikhsan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(442, 'SURYA ADITIA', 'surya.aditia@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(443, 'Yana Ramdani', 'yana.ramdani@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(444, 'Yoga Ramadan', 'yoga.ramadan@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28'),
(445, 'Yudha Ihsan Agustiansyah', 'yudha.ihsan.agustiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TKR C', '2025-07-15 22:20:28');
INSERT INTO `akun_email` (`id`, `nama`, `email`, `role`, `kelas`, `created_at`) VALUES
(446, 'ABIL KALAM', 'abil.kalam@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(447, 'ADE RAHMAT', 'ade.rahmat@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(448, 'Adi Kurma', 'adi.kurma@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(449, 'ADITIA RIFQI MAULANA', 'aditia.rifqi.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(450, 'Aditiya Rismana', 'aditiya.rismana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(451, 'BAYU RAMDANI', 'bayu.ramdani@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(452, 'Coki', 'coki@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(453, 'Eki Nurhakim', 'eki.nurhakim@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(454, 'FAUZAN ABDURRAFI ALWAFA', 'fauzan.abdurrafi.alwafa@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(455, 'GALANG BUMI RAMADHAN', 'galang.bumi.ramadhan@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(456, 'Ilham Padilah', 'ilham.padilah@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(457, 'KHODIMAN SAIPUDIN', 'khodiman.saipudin@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(458, 'M. RIJAL', 'm.rijal@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(459, 'MOCHAMAD RESA ALPINA', 'mochamad.resa.alpina@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(460, 'MUCHAMAD RAVI FIRDAUS', 'muchamad.ravi.firdaus@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(461, 'MUHAMAD DIMAS ADITIYA', 'muhamad.dimas.aditiya@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(462, 'MUHAMAD FAISAL RAMDANI', 'muhamad.faisal.ramdani@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(463, 'MUHAMAD IKHSAN', 'muhamad.ikhsan@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(464, 'MUHAMAD MULYANA', 'muhamad.mulyana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(465, 'MUHAMMAD RASSYA ALPADLI', 'muhammad.rassya.alpadli@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(466, 'MULKI ABDUL AZIS', 'mulki.abdul.azis@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(467, 'Pasha Nugraha', 'pasha.nugraha@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(468, 'RAMA PEBRIAN HIDAYAT', 'rama.pebrian.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(469, 'RANGGA MULYA SUNARYO', 'rangga.mulya.sunaryo@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(470, 'Riski Taufik Kurohman', 'riski.taufik.kurohman@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(471, 'Rizki Alfauzi', 'rizki.alfauzi@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(472, 'Yadi Taryadi', 'yadi.taryadi@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(473, 'Yudi Nugraha', 'yudi.nugraha@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM A', '2025-07-15 22:20:28'),
(474, 'ADITYA TATANG ROSWENDI', 'aditya.tatang.roswendi@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(475, 'AFDAL MUHAMAD YUSUP', 'afdal.muhamad.yusup@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(476, 'AJI ALBANI', 'aji.albani@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(477, 'Akbar Rifa\'i', 'akbar.rifa.i@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(478, 'ALIF BANGBANG', 'alif.bangbang@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(479, 'Alpin Adriansah', 'alpin.adriansah@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(480, 'Deden Hadiningrat', 'deden.hadiningrat@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(481, 'ERIK HENDRIAN', 'erik.hendrian@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(482, 'Farel Nurhidayat', 'farel.nurhidayat@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(483, 'Fauzan Ilham', 'fauzan.ilham@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(484, 'Ilyas Sutisna', 'ilyas.sutisna@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(485, 'Jana', 'jana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(486, 'M. Arga Irfan Subagja', 'm.arga.irfan.subagja@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(487, 'MOHAMAD SAHRUN', 'mohamad.sahrun@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(488, 'MUCHAMAD YUSUF MUHARAM', 'muchamad.yusuf.muharam@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(489, 'MUHAMAD PADIL', 'muhamad.padil@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(490, 'Muhamad Putra Almusadad', 'muhamad.putra.almusadad@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(491, 'Muhamad Ramdani', 'muhamad.ramdani@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(492, 'Muhamad Rangga Maulana', 'muhamad.rangga.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(493, 'Muhamad Rehan', 'muhamad.rehan@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(494, 'MUHAMMAD NAZRIL RANGGA ARYA', 'muhammad.nazril.rangga.arya@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(495, 'Nendi Oktavian Nugraha', 'nendi.oktavian.nugraha@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(496, 'Reja Adittia', 'reja.adittia@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(497, 'Restu Apriliawan', 'restu.apriliawan@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(498, 'Rizki Sulaeman Hakim', 'rizki.sulaeman.hakim@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(499, 'Shandy Khusnul Hakim', 'shandy.khusnul.hakim@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(500, 'SYAHRUL JANI', 'syahrul.jani@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(501, 'SYAMSI KURNIAWAN PRATAMA', 'syamsi.kurniawan.pratama@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(502, 'Wildan Ahmad Pauzi', 'wildan.ahmad.pauzi@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(503, 'Yusup Lesmana', 'yusup.lesmana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM B', '2025-07-15 22:20:28'),
(504, 'Aditya Karam Dani', 'aditya.karam.dani@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(505, 'Ahmad Nur Fadilah', 'ahmad.nur.fadilah@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(506, 'Andika', 'andika@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(507, 'Aril M.H Pauzi', 'aril.m.h.pauzi@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(508, 'Asep Muhamad Rohmat', 'asep.muhamad.rohmat@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(509, 'Azis Radiansyah', 'azis.radiansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(510, 'Dery Sukma Nur Hidayat', 'dery.sukma.nur.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(511, 'Didin', 'didin@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(512, 'Fadlan Afrilian Permana', 'fadlan.afrilian.permana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(513, 'FURI MAULANA SULAEMAN', 'furi.maulana.sulaeman@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(514, 'Helmi Permadi', 'helmi.permadi@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(515, 'Ipan Permana Sidik', 'ipan.permana.sidik@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(516, 'Jepri Maulana', 'jepri.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(517, 'M. ZAENAL ISMIANA', 'm.zaenal.ismiana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(518, 'MUHAMAD AZRILA SIDIK', 'muhamad.azrila.sidik@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(519, 'MUHAMAD BAYU TRI NUGRAHA', 'muhamad.bayu.tri.nugraha@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(520, 'MUHAMAD RIDWAN', 'muhamad.ridwan1@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(521, 'Muhamad Rizal Buhori', 'muhamad.rizal.buhori@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(522, 'MUHAMMAD FAZRI MAULANA', 'muhammad.fazri.maulana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(523, 'Nopal', 'nopal1@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(524, 'RAFLI ADITIA PERMANA', 'rafli.aditia.permana@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(525, 'Rafli Hidayat', 'rafli.hidayat@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(526, 'Riki Hendrawan', 'riki.hendrawan@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(527, 'Riski Supria', 'riski.supria@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(528, 'Sahrul Anwar Bokhori', 'sahrul.anwar.bokhori@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(529, 'Tedi Apriliansyah', 'tedi.apriliansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(530, 'Tegar Kamal Fallahudin', 'tegar.kamal.fallahudin@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(531, 'Wildansyah', 'wildansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28'),
(532, 'Yudi Apriansyah', 'yudi.apriansyah@siswa.smkperkasa.sch.id', 'siswa', 'XII TPM C', '2025-07-15 22:20:28');

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
(8, 'ADITYA RAHMAN, S.Pd.', '1', 'aditya.rahman@guru.smkperkasa.sch.id', '$2y$10$o/R1PoWHPilvin6lTeV2yeeogyfyTSKmH1vNqbtRRJvRR.VCg0LwC'),
(9, 'ANGGIA PERMATASARI, S.Pd.', '2', 'anggia.permatasari@guru.smkperkasa.sch.id', '$2y$10$yAmIpMG4QSzmfOPzLahSn.bxXjk2J.7bO9w1kTLFEAg8FYFFOjx/O'),
(10, 'ASEP AJI, S.Pd', '3', 'asep.aji@guru.smkperkasa.sch.id', '$2y$10$2SvmqFP27vKi7k4j4.gm6OLlCGb47nqHy32zY9qeUaqCG6lVCfqve'),
(11, 'ASEP SUPRIATNA', '4', 'asep.supriatna@guru.smkperkasa.sch.id', '$2y$10$ZFvkJqsLKFDAsyIHGdEc7O7wCVxKw4jvn1aDT8xL9wJFdyfVnWrmm'),
(12, 'CHILDA MALINA, S.Psi', '5', 'childa.malina@guru.smkperkasa.sch.id', '$2y$10$n8PhoPxn9O02zaTOVSBL5uKXtF5XPPke6jhjEPWhFcqMKklmhfIBO'),
(13, 'DADAN HERMANA, S.E.', '6', 'dadan.hermana@guru.smkperkasa.sch.id', '$2y$10$5GnBy.NGl9E9oPY6bSUmjutuoU.T718kQKRSnm4XbLukG4g982RWC'),
(14, 'DADANG SULAEMAN , ST', '7', 'dadang.sulaeman@guru.smkperkasa.sch.id', '$2y$10$G8.93FMD7evEGYJCRAvKoeG6hbwewcZ1jcOjjTjfR0IdamE5Oj0be'),
(15, 'DALI GANDARA, S.P', '8', 'dali.gandara@guru.smkperkasa.sch.id', '$2y$10$7gnCh3w/jvwe7LH6WPhvUOq5tlF/3YZMA9xn8RzvNtmteFPBVI6VC'),
(16, 'DEDE AIDAH, S.Ak', '9', 'dede.aidah@guru.smkperkasa.sch.id', '$2y$10$BZqUP7DSDFnKfGsrhKFJiOkduxZfBTrkA9bqOtYY6BpACl2uOo9HK'),
(17, 'DEVI SRI MULYANI,S.Pd', '10', 'devi.sri.mulyani@guru.smkperkasa.sch.id', '$2y$10$GUvzs8nAoFv3YmQbwSDd0.oLSil9Zmq22vS.bulIXfW9nOm5O1KhG'),
(18, 'EDIH SURYADI, S.Pd. Gr.', '11', 'edih.suryadi@guru.smkperkasa.sch.id', '$2y$10$6GtdKM/Y4Hferpjokfi1DOTqnx/xqgdIy.xKDpNDZTnyX.F9Mtq0i'),
(19, 'ELI QODARIYAH, S.Pd', '12', 'eli.qodariyah@guru.smkperkasa.sch.id', '$2y$10$ENQDSImne2nzTwCppWc3Lukgr9FFa7MY09AS41Ebs9gOBgdy00.ui'),
(20, 'FAJAR PUJA KESUMA, S.Pd.', '13', 'fajar.puja.kesuma@guru.smkperkasa.sch.id', '$2y$10$vFdnv9RgL1aXVyZjUEVUtOUUHd9Ej8vrjD3WGRie05dT2rTgc1tmm'),
(21, 'FRESA FEBRIANTI RAHAYU, S.Kom', '14', 'fresa.febrianti.rahayu@guru.smkperkasa.sch.id', '$2y$10$BIcMKxYo7zzmj5pQ/EnOlurpIY6W7zHNwjAh57u7IK3UyTpoNlruO'),
(22, 'INDRA ALISYABAN, ST.', '15', 'indra.alisyaban@guru.smkperkasa.sch.id', '$2y$10$t9slNI4gTju2qADtJsqFheMfyTF8FXb4ydD8e1PjLxxnAx6Y4t3O2'),
(23, 'INDRA NASUM, S.Pd.', '16', 'indra.nasum@guru.smkperkasa.sch.id', '$2y$10$f7X2X.GAEP88Yn/cmObUpOodW9w2sBPWB4sXmp.yR5xyk1FBlw.X.'),
(24, 'IPAN SOPIANA', '17', 'ipan.sopiana@guru.smkperkasa.sch.id', '$2y$10$jdJjv1w.Dy7uarRV91hkvOGc7LxVAem0gCaJ70z4dtj/JbJPttIGm'),
(25, 'ISNAWATI NURKHOLIK, S.Pd.', '18', 'isnawati.nurkholik@guru.smkperkasa.sch.id', '$2y$10$sZWcDoSCUlnNro4R5vuAHeXDmsS4izpIEv1xW41u7SO8tHK7lakGW'),
(26, 'JAJANG NURJAMAN, ST.,MM', '19', 'jajang.nurjaman@guru.smkperkasa.sch.id', '$2y$10$MsRQ4m/8smZJjcuPkGvJAeEtVIN37l9dP6/frPyOssULaGl3FubgS'),
(27, 'JOHAN JOHANA, S.Pd.I', '20', 'johan.johana@guru.smkperkasa.sch.id', '$2y$10$MV9jkctGnxveiQsA7AiivepztiJjACgwBJUjsZr4KZu8aeXKARyLW'),
(28, 'MERI MARLIA, S.Pd', '21', 'meri.marlia@guru.smkperkasa.sch.id', '$2y$10$KQg84/FnAhOyLWPknBxqY.pGBQbOMAlolddFEU1VdttTjYXv1LiSy'),
(29, 'MEYMEY IRIANTI, ST', '22', 'meymey.irianti@guru.smkperkasa.sch.id', '$2y$10$SguFjd.swDKO809KUkp/b.hjzvSkFTiFlJ1GcvYmLo6.gYOjCdkti'),
(30, 'MOCH. SAEPULOH ROCHMAN, S.T.', '23', 'moch.saepuloh.rochman@guru.smkperkasa.sch.id', '$2y$10$dnNHQiTaqVZzCjgk8B3RRu9klH69ENo0hjEULOK4zuZ0QqNN1kjVS'),
(31, 'MOCHAMAD WISNU FAJAR, S.S', '24', 'mochamad.wisnu.fajar@guru.smkperkasa.sch.id', '$2y$10$epQbeQ48G9M/6pDvBpaJbevlFac19jrQ.LiaP.eReHs4T10tuGB.i'),
(32, 'MUNADIN, S.Ag', '25', 'munadin@guru.smkperkasa.sch.id', '$2y$10$Si8GH/8QyTlhnppXIpYc8OZl.44AwfcoAR4g15WB2OaFuqSamZHae'),
(33, 'NANDANG, S.Pd', '26', 'nandang@guru.smkperkasa.sch.id', '$2y$10$itecZSxc3O/sGxJ4FXFZUutl6x5rX1Ul5dLjhNWFF2voSpy6s6KYm'),
(34, 'NOVELA AFFRI RASITANIA, S.Pd.', '27', 'novela.affri.rasitania@guru.smkperkasa.sch.id', '$2y$10$nnEBAFZ.VPJyDW42aT6JHupONvW48htvvVgY.sHILi6TAJyw8y.US'),
(35, 'NU\'MAN ZAMALUDIN, S.Kom., M.Hum', '28', 'nu.man.zamaludin@guru.smkperkasa.sch.id', '$2y$10$jRIrCGe92hQjRHA8YDFeZO0lSI8.647b/6q2wV5Bz1b/7l5zLq/wi'),
(36, 'NUGRAHA HABIBILAH', '29', 'nugraha.habibilah@guru.smkperkasa.sch.id', '$2y$10$zpIxS3yEA3ghfp3WMaAGBerhz.z0LROl2eQCQQttw4LWcGcu.508G'),
(37, 'NUR CAHYATI, S.Kom., M.M.', '30', 'nur.cahyati@guru.smkperkasa.sch.id', '$2y$10$qeQd2v1PN32BCsBznt9nF.6NWYEA3c7oKe5.fNk/6R31kG7KBFCjm'),
(38, 'RIKA AGUSTINA, S.Pd.', '31', 'rika.agustina@guru.smkperkasa.sch.id', '$2y$10$m183Wr5zoUFvajx172ZpEu8NTmS/ad7.LxafFWF/Ojqji3T/wWdeS'),
(39, 'RIKA KURNIAWATI, S. Sos', '32', 'rika.kurniawati@guru.smkperkasa.sch.id', '$2y$10$sBq3lOrDi4ntApSLi7W6sOj8zULqmd8X6Dk/jK2miV997fapSmd5G'),
(40, 'RISKI NURUL INSANI, S.Kep', '33', 'riski.nurul.insani@guru.smkperkasa.sch.id', '$2y$10$.t1tH4l1l/QPydvgKg.XlOrMqbSHLN7nnQqatNPK/T/D4XvkVLJpq'),
(41, 'RIZAL HENDRI PERDIANA, S.Pd.', '34', 'rizal.hendri.perdiana@guru.smkperkasa.sch.id', '$2y$10$yjN4lYeXWGJBRzAb0Rhe2uNP5d7D0UqsVwWglDeXU44u0z7MoSCvq'),
(42, 'ROSI ROSDIANA, S.Pd.', '35', 'rosi.rosdiana@guru.smkperkasa.sch.id', '$2y$10$mgEVRh7LiEBccYU.IZ4.KeLAR/8V1PvwlFeJ3Xao6fXuuCzfIT0IK'),
(43, 'SARYONO, S.T', '36', 'saryono@guru.smkperkasa.sch.id', '$2y$10$uGDqlzjwAx6y75vVlFmMYeTGwlYD1GdPvTq0xsNu3e3E3vND4Y1Um'),
(44, 'SATRIA KRISNA MUKTI', '37', 'satria.krisna.mukti@guru.smkperkasa.sch.id', '$2y$10$ojYu95mY0viekeYFw8kg8uuxsaN9.8luucbHXTGp4d4xzEYfpj3eC'),
(45, 'SITI AISYAH, S.T.', '38', 'siti.aisyah@guru.smkperkasa.sch.id', '$2y$10$lnQLImwguuow4uZK85XtS.XGtuS3y3m4HK8cuzaj6S.XcJRk0oAje'),
(46, 'SOPYAN KURYANA,S.Pd.I', '39', 'sopyan.kuryana@guru.smkperkasa.sch.id', '$2y$10$ADoNc4qAt01Ql4iZpJ6JX.yDnhOViweRbhVHEPTeVyPzAP5MsQQ8e'),
(47, 'SRI PUJI UTAMI, S.Pd.', '40', 'sri.puji.utami@guru.smkperkasa.sch.id', '$2y$10$vHDdYqVzvvef//2yLlS8iOaZlOo9lDzn9elEbzyzsuifB2fM0T0Mi'),
(48, 'SYAMSUL ILHAM FIRDAUS, S.Pd.', '41', 'syamsul.ilham.firdaus@guru.smkperkasa.sch.id', '$2y$10$OSpUWDXORn2LTZJgYw7WQ.qcqY4GFz4Gm3GhpPN.NBdRJJLyFSV.u'),
(49, 'SYIFA FADILAH, S.Pd.', '42', 'syifa.fadilah@guru.smkperkasa.sch.id', '$2y$10$mOfUYd9iAj4h8E8J28JEYOeP621tMHBZcDrxsdx/MrGRt5YXRtzES'),
(50, 'SYIFA NURRIZKIYA, S.H.', '43', 'syifa.nurrizkiya@guru.smkperkasa.sch.id', '$2y$10$BIshoooySZv4oXACfnajGusrPjhF08iAR.Y4MwN/7Iqy3W7z2nMjm'),
(51, 'TIARA DEWI PUTRI ADJIE', '44', 'tiara.dewi.putri.adjie@guru.smkperkasa.sch.id', '$2y$10$/iV//g2idnorA5V.yoeXmuteuZHLW6Pbscn5XPR.IBvBZg6q9nmD6'),
(52, 'TINA SRI HANDAYANI, S.Kom', '45', 'tina.sri.handayani@guru.smkperkasa.sch.id', '$2y$10$qhg27gyXFsOA0EFHc29uv.vAgQNJqBGVLrO6.ODPqQsftAl5eGT4i'),
(53, 'VINI MARYANTI, S.S', '46', 'vini.maryanti@guru.smkperkasa.sch.id', '$2y$10$16HA9i0T4kkLXPKY.OLN1OUimnbOxe6tR/zy1bAdzgXRopb7q01Hy'),
(54, 'YAN YAN, S.Pd.', '47', 'yan.yan@guru.smkperkasa.sch.id', '$2y$10$B1lPgkmykTifxUJRNvwoLeLi810Yq0/evtoHyLQufZ3zKqKaVXyFK');

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
(19, 35, 6, 13),
(20, 44, 7, 13);

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
(36, 'Selasa', '00:00:00', '23:59:00', 19),
(37, 'Rabu', '00:00:00', '23:59:00', 19),
(38, 'Selasa', '00:00:00', '23:59:00', 20),
(39, 'Rabu', '00:00:00', '23:59:00', 20);

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
(10, 'X TKJ A'),
(11, 'X TKJ B'),
(12, 'X TKJ C'),
(13, 'XI TKJ A'),
(14, 'XI TKJ B'),
(15, 'XI TKJ C'),
(16, 'XII TKJ A'),
(17, 'XII TKJ B'),
(18, 'XII TKJ C'),
(19, 'X TPM A'),
(20, 'X TPM B'),
(21, 'X TPM C'),
(22, 'XI TPM A'),
(23, 'XI TPM B'),
(24, 'XI TPM C'),
(25, 'XII TPM A'),
(26, 'XII TPM B'),
(27, 'XII TPM C'),
(28, 'X TKR A'),
(29, 'X TKR B'),
(30, 'X TKR C'),
(31, 'XI TKR A'),
(32, 'XI TKR B'),
(33, 'XI TKR C'),
(34, 'XII TKR A'),
(35, 'XII TKR B'),
(36, 'XII TKR C');

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
(6, 'ompetensi Keahlian Teknik Komputer dan Jaringan', 'KKTKJ'),
(7, 'Produk Kreatif dan Kewirausahaan', 'PKK');

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
(141, 'Aditia Perdiansyah', '0089242862', 'aditia.perdiansyah@siswa.smkperkasa.sch.id', '$2y$10$0o4WOzzryhL6IXrJlxzr5OJKq13EEbjnyYremnK/C7q0JsKC3nbtq', 13),
(142, 'Afdal Atalah Yumna', '0097482650', 'afdal.atalah.yumna@siswa.smkperkasa.sch.id', '$2y$10$Zzn0G2Bm67Chdaa4ciEMtupZ8/yHMoB1vtqV/lnxiqX6R9XsRnN0i', 13),
(143, 'Aira Saputri', '0091592579', 'aira.saputri@siswa.smkperkasa.sch.id', '$2y$10$5S3V.y5hKpH3eOohya.3iODBWjdFy.Z69n/Q0h.QhKphnZeyykB2e', 13),
(144, 'DEA AMANDA', '0093245494', 'dea.amanda@siswa.smkperkasa.sch.id', '$2y$10$u2yaVbWwekjF/IT6mN.UnuWq0t2sLdZUsn0gFwO0VDWJ04KeLAjAm', 13),
(145, 'Dede Sidqi Alditiya', '0098968910', 'dede.sidqi.alditiya@siswa.smkperkasa.sch.id', '$2y$10$B5/YcoiagcTyVKKKlhrkt.gbiFF1lJAIG9LOCxlGJW0JuRxGu5eFG', 13),
(146, 'Fanni Novianti', '0088765618', 'fanni.novianti@siswa.smkperkasa.sch.id', '$2y$10$l1NuD/W9yC56B1UukCHdEODquOmBIP8ZM2M/c5mdfa1w2DS1rUkR6', 13),
(147, 'FAUJIAH', '0083772941', 'faujiah@siswa.smkperkasa.sch.id', '$2y$10$GRdwqvBQo3Lftse8N0EbT.fM3CLfF5JvLdnZ/ujF0lipduSmRlOJ.', 13),
(148, 'Fitri Maelani', '0087487419', 'fitri.maelani@siswa.smkperkasa.sch.id', '$2y$10$1rLIAKgEUsPSgDpyFr1kt.TY3EKULVEODh8FuDwTEI4hwXg8rr4rq', 13),
(149, 'HARYO JATNIKO', '0086096717', 'haryo.jatniko@siswa.smkperkasa.sch.id', '$2y$10$nVR43/PG2H516GzzxeCs0ee4yhZ5mtvwBjPo6emeXPXuaW1WKmJyO', 13),
(150, 'ILHAM MAULANA', '0098583242', 'ilham.maulana@siswa.smkperkasa.sch.id', '$2y$10$Tf5BdNAirC/njiF2vuJTfOVCiwgHWxm1SEyFljN81vLDaB.it6cZ.', 13),
(151, 'Isna Siti Hajar', '0082473459', 'isna.siti.hajar@siswa.smkperkasa.sch.id', '$2y$10$0PD5nrxvOjij0y6aND4UxODhZmfbUn.URRsPMhyKOPdMX0fFQ3nmy', 13),
(152, 'Julia Dewi Yuandira', '0098875831', 'julia.dewi.yuandira@siswa.smkperkasa.sch.id', '$2y$10$td/MEZEnAifzEez4mfcmcOpTb3FT8J7Z4uWFV3ZCCujmnXXRUbTPm', 13),
(153, 'JUWITA LESTARI', '0083093647', 'juwita.lestari@siswa.smkperkasa.sch.id', '$2y$10$pJroi8cjAetnshBAvfP2aekus33n2XvYGN.IV1nulndutoRaAzQiy', 13),
(154, 'KHAYRAN ZALFA HIDAYAT', '0097330598', 'khayran.zalfa.hidayat@siswa.smkperkasa.sch.id', '$2y$10$bFndxRL/ul8N/tDFLe25zO2Zd7NWzwNU.CECmFKiTK4N74mP4.ktS', 13),
(155, 'KURNIAWAN', '0089582788', 'kurniawan@siswa.smkperkasa.sch.id', '$2y$10$7drKGfFRU0SN/Espemj49OuHEewsoOpa91BL6w1glqGJaJ6MXBxGu', 13),
(156, 'Melan Meilani', '0092580685', 'melan.meilani@siswa.smkperkasa.sch.id', '$2y$10$oypbtCytWRlRTf/3VeFe9.b2gQtFvGX9f1Pctxg4Arcck4ba5pTim', 13),
(157, 'Melani Febriyanti', '0095914145', 'melani.febriyanti@siswa.smkperkasa.sch.id', '$2y$10$EqILxL/DVFKG4dGre/XBWODwcMnAuFsil.fVoH/6JG5xtuYrZD0bq', 13),
(158, 'MOCHAMMAD REYSWAN ARDYA', '0076568307', 'mochammad.reyswan.ardya@siswa.smkperkasa.sch.id', '$2y$10$4JZRC13ZDuj6IZd9KGM/oOOehAcVHQChM9wE74ar2qiQCNVTIYhx2', 13),
(159, 'MUHAMAD RIDWAN', '0083320167', 'muhamad.ridwan@siswa.smkperkasa.sch.id', '$2y$10$znO2ekGikZDEek9aEaSKceOCVzbyXRA.QaRoNQMBpL2UCV2hYAIWi', 13),
(160, 'NENG SRI MULYANI', '0097505804', 'neng.sri.mulyani@siswa.smkperkasa.sch.id', '$2y$10$zMNmEYrlIl2cinj63ZkjAO38d.qmbPvn4.ZMfh1t4/fzir5kjyUoK', 13),
(161, 'Nissa Nuraisyah', '0094731467', 'nissa.nuraisyah@siswa.smkperkasa.sch.id', '$2y$10$W2wbQBEWxx0tk1sxwwIVYOD.xKKj8LzTwK8/PCv8Y3gOc4GnguC7S', 13),
(162, 'PUTRI LAELASARI', '0088222670', 'putri.laelasari@siswa.smkperkasa.sch.id', '$2y$10$ekgXGGZhHbgPoWAIL68S7e7.LZc2d1KgtVflmyRWJEKZzYzmoE6KO', 13),
(163, 'Raihan Febriano', '0094420210', 'raihan.febriano@siswa.smkperkasa.sch.id', '$2y$10$QKv1QgXP34O2CF7MixZ4QuGdyOxrhkJLDJfZfK4ie9ozy2cUcBY4e', 13),
(164, 'RAIHAN HERNAWAN', '0088128111', 'raihan.hernawan@siswa.smkperkasa.sch.id', '$2y$10$IlU36JIcrNOdIYj2updVseEzHIbwAdXmT9fZK7QW0jX.fsbJ1l1.S', 13),
(165, 'REIHAN ALIF PUTRA PRATAMA', '0095300444', 'reihan.alif.putra.pratama@siswa.smkperkasa.sch.id', '$2y$10$I/SLACZ5mAuGqDvznc1qgOrfuaet69P/U3cjpvtI8oXWcz.DYm3nO', 13),
(166, 'RIFAN HIDAYAH', '0086088568', 'rifan.hidayah@siswa.smkperkasa.sch.id', '$2y$10$PtEtXASmPH7JNb1lXQ/nQuEp51.J2XZYXFrjP00Hxu9hVm0IEUaWW', 13),
(167, 'RISKI', '0086697914', 'riski@siswa.smkperkasa.sch.id', '$2y$10$JfiwbJC9caR1P2pPfvnMbOVMJhVaBondYqNOQ5zqX4/Lg6zfgdpSC', 13),
(168, 'Riski Permana', '0089944201', 'riski.permana@siswa.smkperkasa.sch.id', '$2y$10$2GipKoe0bAqW/R4/DGD/6up.fFJQTL/JEjjdvnSLndAq0YvdT3kTm', 13),
(169, 'SANDI GUNAWAN', '0086382983', 'sandi.gunawan@siswa.smkperkasa.sch.id', '$2y$10$A06By4XE13/jKlTXA22IXuKMW0F7QZ.nKc5xlPRCfNeeYYK7D5JI.', 13),
(170, 'Senandung Nacita Camelia', '0099960373', 'senandung.nacita.camelia@siswa.smkperkasa.sch.id', '$2y$10$Tw.4KK/D2kGl93aFK.iC0OvBj7/i8l3aJImiQQsjMlG5qPbY.7GJq', 13),
(171, 'Taufik Hidayat', '0089585438', 'taufik.hidayat@siswa.smkperkasa.sch.id', '$2y$10$yEesXIPCiTgQiLLfv1oNXequBoUiMhyvp8vSbmWM.1Ur/Cmh403Ie', 13),
(172, 'WINDIYAWATI', '0084964966', 'windiyawati@siswa.smkperkasa.sch.id', '$2y$10$aXY0irHaTTd4As4TT.fiHO5788SM.qWxrNe9fKks9/vMAc1taVw.u', 13),
(173, 'Ajeng Gina Solehah', '0094953177', 'ajeng.gina.solehah@siswa.smkperkasa.sch.id', '$2y$10$m1fQsuh3An96lijMO52Ps.cGj/5NJOIXJ9wcFm289hEIve.9wbUjW', 11),
(174, 'ANDREAN PRADITA', '0081601371', 'andrean.pradita@siswa.smkperkasa.sch.id', '$2y$10$4VqN1b5yjuJpIzNSoNUomuXp7mEO9pWU0HwyK1ui6yHrzvXFBOqjO', 11),
(175, 'AZRIL ZULFIKAR KHOIRUL MARIK', '0097857535', 'azril.zulfikar.khoirul.marik@siswa.smkperkasa.sch.id', '$2y$10$QVDm.bHx4.5/wpD6hRkhX.U2WfxelbpeukfIMEmy7WBVIsrTHItEW', 11),
(176, 'Cika Karin Agustin', '0081414820', 'cika.karin.agustin@siswa.smkperkasa.sch.id', '$2y$10$O7tkTKu7v9S3qRy.iphE0.Y6TPRUY1n11B9DF4hXkuSlcCOYKOrSe', 11),
(177, 'Desi Rahmawati', '0096162545', 'desi.rahmawati@siswa.smkperkasa.sch.id', '$2y$10$5rfWW.KY7aRylytTnM3S0.hREVfhvqmm1iF959aeQ.UCL9PrUC3aa', 11),
(178, 'Devi Aulia', '0082518955', 'devi.aulia@siswa.smkperkasa.sch.id', '$2y$10$s/C4Pqx.ZVzB1ITnAsSc3.drmcUY60noAJZrTfQqQroBYagPfn3Va', 11),
(179, 'Irma', '0099013435', 'irma@siswa.smkperkasa.sch.id', '$2y$10$6Ffxn4E2AShZzABC9mC8ieO2Nv/lSJ/BYlTbRIetocBD2v9PaVwqK', 11),
(180, 'LUCKY PRAMANA PUTRA', '0095736916', 'lucky.pramana.putra@siswa.smkperkasa.sch.id', '$2y$10$01R/zKhM7/1UKxX4afB1XOGbw2TQQeRCnu0qRSuAXNXOSJsOJI6xu', 11),
(181, 'MISSELA MAULIDA PUTRI', '0097002302', 'missela.maulida.putri@siswa.smkperkasa.sch.id', '$2y$10$fdiAsGfiAFO94D601FbBz.2bFhaaO.SWs3IUAlfT/rse0MnzxXtOO', 11),
(182, 'MUAMMAR KHADAFI', '0098355370', 'muammar.khadafi@siswa.smkperkasa.sch.id', '$2y$10$K81TANlrToi7HBJCLpTEyu5RQ22OOSwxv9DJEFPiRnz9Eqx6iIX.S', 11),
(183, 'MUHAMAD ALVIAN NUGRAHA', '0084124637', 'muhamad.alvian.nugraha@siswa.smkperkasa.sch.id', '$2y$10$an9.O20l0tuJ2SxwL2n2l.x3RXpFX7gWhvNU4EphnrSaNcvFOfcpq', 11),
(184, 'MUHAMAD DEA PERMANA', '0088032851', 'muhamad.dea.permana@siswa.smkperkasa.sch.id', '$2y$10$7tzvRa681KimgJwmLIEQj.xqqT6fXPQmFg/kvbeOT/Qq8uQuzwoGO', 11),
(185, 'NOPAL', '0089845652', 'nopal@siswa.smkperkasa.sch.id', '$2y$10$HR.8B53ANu5cz8b1tKwiT./7S3js5qKUkCz4tn3qX5q46O0KEcfzm', 11),
(186, 'Nova Ardiansah', '0086440715', 'nova.ardiansah@siswa.smkperkasa.sch.id', '$2y$10$2lLyQtUxgoNnoLEjmIQp.e5q6Q.Zy0GzVuQo7qjvZJfyheqsamDiW', 11),
(187, 'Rahma Lestari', '0088815324', 'rahma.lestari@siswa.smkperkasa.sch.id', '$2y$10$QJM2eHQhjGK0TpU9me5ldu/gEUxy82VLMXdbx/4Lc1nAtdxWfSNYC', 11),
(188, 'REPAN RIZAL APANDI', '0088176815', 'repan.rizal.apandi@siswa.smkperkasa.sch.id', '$2y$10$kfeKjH7v//ZMJ50q2rXIbuiqZukSCUVwe3Sr5pmjdcajSYKvnMJ/y', 11),
(189, 'RESI ASTARI', '0092295379', 'resi.astari@siswa.smkperkasa.sch.id', '$2y$10$/ufUg9uuZ8Yi1YoXjGRD8.nE7w25VHjfiJHNBM0pBeX2vY6jiEUii', 11),
(190, 'Revandi Handika Putra', '0087480766', 'revandi.handika.putra@siswa.smkperkasa.sch.id', '$2y$10$.ahgGULfgxTE9qetuRlbL.5U09J8dHYq4cRAV/1cDDCErjaVGfka6', 11),
(191, 'RIZKI', '0093697972', 'rizki@siswa.smkperkasa.sch.id', '$2y$10$F42OhQ0ZmUJelOFUW1kSUee2UrUp8nhpCiFBZOBE6Rjw4Y6fNIGda', 11),
(192, 'Rizmala Wandani', '0092516486', 'rizmala.wandani@siswa.smkperkasa.sch.id', '$2y$10$pGJcUSK7hlQkXC7K4qTK6.WOMsF10LaSor8Mq2vElHjWRG96eVKe.', 11),
(193, 'SALSA TRI CAHYA', '0082052772', 'salsa.tri.cahya@siswa.smkperkasa.sch.id', '$2y$10$QcWULCuu02PpuEsBZcgEe.vcS7zTEzbHV7AJ300zCpYxbSSOwPGOG', 11),
(194, 'Salwa Septianti', '0085189672', 'salwa.septianti@siswa.smkperkasa.sch.id', '$2y$10$HvzPbSKThrl2mS7hat4Zx.9Rzm2eMrM5Ld9pedHGgGS38yRIh.vAS', 11),
(195, 'Silvia Nurhasanah Fafila Nacha', '0087207239', 'silvia.nurhasanah.fafila.nacha@siswa.smkperkasa.sch.id', '$2y$10$v0hTEBe5hrSfp8ss4hUy9.QJgxXTJlVDt1KHtNfB81nC26sT7RdR.', 11),
(196, 'Siti Maelani', '3093834213', 'siti.maelani@siswa.smkperkasa.sch.id', '$2y$10$V1ar2L8lPKaqruVSHZ8rxOGnlKwjsZOscX4QkVFJQXJpFB8ImXhMC', 11),
(197, 'Tita Aprilianti', '0088599564', 'tita.aprilianti@siswa.smkperkasa.sch.id', '$2y$10$7w9s5fhdA8bxodiFlO2fV.T6mYPl2gMp6ts0HZ6gzayMraRimFNSu', 11),
(198, 'Wulan Sari', '0086169929', 'wulan.sari@siswa.smkperkasa.sch.id', '$2y$10$fJ9.2HUH/i/iMTnvgNXp6up.UYBQlzF.JmhUqG7VmJzg3Azqm5/4u', 11),
(199, 'ALIKA SARI', '0087397950', 'alika.sari@siswa.smkperkasa.sch.id', '$2y$10$1wAi6blGaZKAicAoivDWl./t9kPa34jleebECX6/aNnPFwM13A5s2', 12),
(200, 'ANISA SUCI DWI ANJANI', '0086854074', 'anisa.suci.dwi.anjani@siswa.smkperkasa.sch.id', '$2y$10$oYX2k3WtNA/kcJINkksMgePBLVdmYlQpVw/7kpywWl1W0qLM8Ripe', 12),
(201, 'Auliya Salma Fitriya', '0099590350', 'auliya.salma.fitriya@siswa.smkperkasa.sch.id', '$2y$10$sWUevIFUcjgSkDjJGsy4K..Bdu5.Vbr7daeEgxfhbwzracz93Wtue', 12),
(202, 'Azam Suryandi', '0082182383', 'azam.suryandi@siswa.smkperkasa.sch.id', '$2y$10$YpdZxOFdPhppXcoPebIIJ.2meRqxqEVEzmCNHAtjpfK86EMGhN9ii', 12),
(203, 'DWI GUFIYANA SYAPUTRA', '0082127552', 'dwi.gufiyana.syaputra@siswa.smkperkasa.sch.id', '$2y$10$sf4m7.mk5/RlrfMxMEgCS.fHT9H6ppXd9VFXTS3uwCjf8wB.Usd0G', 12),
(204, 'Endang Suminar', '0098374513', 'endang.suminar@siswa.smkperkasa.sch.id', '$2y$10$TxVl8OHp0RYEnu4M2X/ED.DFnhYhdVU.fiwRAgBcQPKqeS8DopmTu', 12),
(205, 'FERDI ARDIANSYAH', '0098766316', 'ferdi.ardiansyah@siswa.smkperkasa.sch.id', '$2y$10$9R5XFGFuK99LQrPl.7lJ.uG3bEyo18fgK7yFcRrN61oEPPwjDYzte', 12),
(206, 'HANIF IRSYAD ARROJIB', '0085710062', 'hanif.irsyad.arrojib@siswa.smkperkasa.sch.id', '$2y$10$rJjL.tooSjSS5oMrvyPDPuQfpYaha7M3OOXRwbLTChBe8cIdHHwQS', 12),
(207, 'Jajang Zaenal', '0081969736', 'jajang.zaenal@siswa.smkperkasa.sch.id', '$2y$10$hlguFY0Lmr3HCbp5C1Wvt.Zn.S2xn4VUN8BYjudhp8urtgzTfp2Na', 12),
(208, 'Kiki Setiwan', '0098275050', 'kiki.setiwan@siswa.smkperkasa.sch.id', '$2y$10$621zwUBuHK9fLdcfJI9HXu45.Y63axgSxYBb75BDy.lRk.xzNUzbm', 12),
(209, 'Muhamad Hardiansyah', '0094733242', 'muhamad.hardiansyah@siswa.smkperkasa.sch.id', '$2y$10$beaB/YyyuLQ3UqIinP/6T.hpjpiZEMH49.9Hm.PABQacCdrpFc30O', 12),
(210, 'Muhammad Rizqi Al \'Buqhori', '0094367503', 'muhammad.rizqi.al.buqhori@siswa.smkperkasa.sch.id', '$2y$10$TFM8pL/vIuyDnODI2j4DTutZuNytcaE6sPc8Fe2kbk7IgLsBIgylW', 12),
(211, 'Novita Lestari', '0094598722', 'novita.lestari@siswa.smkperkasa.sch.id', '$2y$10$RQsbA.tmDpIkbi7mV9YtF.B6fHgBzOz5wzKpVCIkg1O9q6rxK3dCG', 12),
(212, 'Nurul Padilah', '0099894131', 'nurul.padilah@siswa.smkperkasa.sch.id', '$2y$10$D4aX1Z5GwYH32FDLiJxDxOQ8N4v.p78ZBfXQAC/qBD2bqba14B3JC', 12),
(213, 'ORIZA SATIVA HERYANTO', '0093601115', 'oriza.sativa.heryanto@siswa.smkperkasa.sch.id', '$2y$10$8hoCb6QGZJ4Qkl6gCI.zmOyOO6F4MF1BbWlNdYf88ASffCTBpH6di', 12),
(214, 'Padli Muhamad Fazra', '0089508914', 'padli.muhamad.fazra@siswa.smkperkasa.sch.id', '$2y$10$N/nKX8vNWItU2xyHKtgLPeH90P9ueD0gtbbqQdwmJyZb630NKu6SO', 12),
(215, 'RIDWAN HIDAYAT', '0097456721', 'ridwan.hidayat@siswa.smkperkasa.sch.id', '$2y$10$KS7uMD2zZbI1U1Mtz17zQuMRVQnIeKDCdc.f256ENNysMCTHwqjGW', 12),
(216, 'Rifqi Rafid Abdullah', '0084701687', 'rifqi.rafid.abdullah@siswa.smkperkasa.sch.id', '$2y$10$c/5LuigJZAwgUcFkedftGePoTOjXE8EiRC7L3F7ek8hKxtiQDZAYC', 12),
(217, 'Rosa Amelia', '0088431159', 'rosa.amelia@siswa.smkperkasa.sch.id', '$2y$10$6JRczL6tse5E4qTKHeIEnOor6ZyzEBaNTrYM4LxBe4RoeqWuR0nC6', 12),
(218, 'Rosita', '0093448350', 'rosita@siswa.smkperkasa.sch.id', '$2y$10$oOaXLdJcn21ziBre.SmpAOJV7oGkkDztvW/Wfm5X0xCpKr6wk7xzy', 12),
(219, 'Sonjaya', '0085809908', 'sonjaya@siswa.smkperkasa.sch.id', '$2y$10$HeLE.MBVIZoULFw19g3Z/exNHX/PU2E5nr8WFveUtl.XNEXUlkVKa', 12),
(220, 'SRI WAHYUNI', '0083251145', 'sri.wahyuni@siswa.smkperkasa.sch.id', '$2y$10$x1MzR7UlHjwo8aMRsk9T4O0PClGz/XA0bXzJTDnLOexA1DkJzWPVG', 12),
(221, 'Tina Pitria', '3103252386', 'tina.pitria@siswa.smkperkasa.sch.id', '$2y$10$0ecfjRlR1SaQXKKHPBiGfe9NXG7eLFQIreddpgBFZkxpDOkNtMjmq', 12),
(222, 'Ujang Regi Jaenal', '3093643047', 'ujang.regi.jaenal@siswa.smkperkasa.sch.id', '$2y$10$tlew6PYIRkkJCnUT62pqIe7/Lt9ATK2VHeiZDI21kCwYC.wbk4i7.', 12),
(223, 'WALIYUDIN FADILAH', '0093877210', 'waliyudin.fadilah@siswa.smkperkasa.sch.id', '$2y$10$bs/XKl9qyL62X/KlY3zuJ.oNg/Ur/dZ1egW9ao2CSl77B8zmWAE4i', 12),
(224, 'Aa Sidik Purnama', '0097705130', 'aa.sidik.purnama@siswa.smkperkasa.sch.id', '$2y$10$BeaqmBf2Ge6xxaxRxlgFBuNsKcVEae0RmovKmJDhuKAcq2PWPC7BO', 31),
(225, 'Adit Ardiyan', '0089993393', 'adit.ardiyan@siswa.smkperkasa.sch.id', '$2y$10$KNk6P9p5MsvEQuihv7cdCem1H60d1sIUEIDT1imRXBfqDsfYwXbFy', 31),
(226, 'Agung Barokah', '0086434750', 'agung.barokah@siswa.smkperkasa.sch.id', '$2y$10$StUXnRhkSXilf5YrmaEe4eOHQXmetKkF5yfFAulxyoBfuzuhbefem', 31),
(227, 'Agung Guntara', '0099014867', 'agung.guntara@siswa.smkperkasa.sch.id', '$2y$10$AtdD6yYme.GOsTmd3zhahu8athvMSFeOAvJHhh8QnBLTppb6ggVYy', 31),
(228, 'Ahmad Riyan', '0092761056', 'ahmad.riyan@siswa.smkperkasa.sch.id', '$2y$10$xylrJ/w7v.qx6PDl8w4.NO0/gMXRrXcfM/PQ.VD0jzkefMKQAjk9e', 31),
(229, 'ALIF HADI SAPUTRA', '0096031271', 'alif.hadi.saputra@siswa.smkperkasa.sch.id', '$2y$10$BMjnGp447s395SeX6ZzVkeIkMj0elN1mvJ0BSgzOb306FE17hPGQe', 31),
(230, 'BAYU RIZKI', '0085005188', 'bayu.rizki@siswa.smkperkasa.sch.id', '$2y$10$454gznlPlo7eTO0aBYP0vugzSunYc.i7vyBkHMqXMwLCvIC/UVS8C', 31),
(231, 'BRIAN BAKHTIAR ROSIDIQ', '0094558908', 'brian.bakhtiar.rosidiq@siswa.smkperkasa.sch.id', '$2y$10$hP1KgaMqsEXVahe4adAUfOtBTwdniQy5Sez666ezrE6.1XKPMdkv6', 31),
(232, 'Dea Maulana', '0084366837', 'dea.maulana@siswa.smkperkasa.sch.id', '$2y$10$kCr1ndHayPTOHpN/MuQfJeDwj/aQEMm2Qey.FhioDr9Qi/Pds36Qq', 31),
(233, 'Dede Muhamad Mansur', '0087421263', 'dede.muhamad.mansur@siswa.smkperkasa.sch.id', '$2y$10$8vo8kzPZR9Hxb.CDCVFN8uKWnw1mJW8Ko99c5kZEGKnIBmAuHOAqK', 31),
(234, 'Fakhri Ahmad Azzam', '0085974392', 'fakhri.ahmad.azzam@siswa.smkperkasa.sch.id', '$2y$10$xm.Q3wVjn4HSnXcqykXKS.nSJidcnBr6EhwV90q3g.gT/4XKXzHSi', 31),
(235, 'Galih Anggara', '0068099743', 'galih.anggara@siswa.smkperkasa.sch.id', '$2y$10$klQmeLM3LmCAzjW4JQ3YXu2ctv5J.K7HRVbanBeJLb9TwRArNxev2', 31),
(236, 'Hari', '0073363207', 'hari@siswa.smkperkasa.sch.id', '$2y$10$CbeCBzO4ykcxuUmOC5h1Z.aqfhwfjYq9nqoVqUsnRsiLN3/2hI/a6', 31),
(237, 'Irgi Fadilatul Sidik', '0082837810', 'irgi.fadilatul.sidik@siswa.smkperkasa.sch.id', '$2y$10$KzsqL6.WEAjta5ZssMywn.Q8Ns44C0zEy5p35tX.lLMDfMYhEJeA6', 31),
(238, 'Jaka Nugraha Mubarok', '0096529841', 'jaka.nugraha.mubarok@siswa.smkperkasa.sch.id', '$2y$10$97CQ1C8PtPKXCFYsSm/r6OTk8lTPDC0XkSfKEOBwv2DnlSmNewZQq', 31),
(239, 'Luki Somantri', '0087701206', 'luki.somantri@siswa.smkperkasa.sch.id', '$2y$10$24m1szaXgRf0SyIulUvG4.sKTULOMo/q7dX3pTDWGxJPBYvsBIdj6', 31),
(240, 'Moch. Fitrah Taufik Riyadi', '0083806970', 'moch.fitrah.taufik.riyadi@siswa.smkperkasa.sch.id', '$2y$10$BMhF.va5q5WLegOyCDjZs.QXpX38Znf35vTfUJbped1UWKF.9qa4S', 31),
(241, 'MUHAMMAD YUSUF RONALDO', '0081345539', 'muhammad.yusuf.ronaldo@siswa.smkperkasa.sch.id', '$2y$10$OHmmTV.GorKyJSfqbnZKkO4AD9VdjBJ4fo.TAabzI8mc6JyyHLF6O', 31),
(242, 'Muhhamad Zahran Argian', '0083509019', 'muhhamad.zahran.argian@siswa.smkperkasa.sch.id', '$2y$10$wVt0N21JzYShYi.7.H8D7eUYBB0QfVxPyUKUJcubc4VVIvhyQRKw2', 31),
(243, 'Riki Jamas Mustakin', '0086482092', 'riki.jamas.mustakin@siswa.smkperkasa.sch.id', '$2y$10$NYKzvlQ7R1SVmXCyQS8NXuyXPcdV2qKMvV5/ABGc3v0nnjsGv402W', 31),
(244, 'Rio Herdiansyah', '0093644718', 'rio.herdiansyah@siswa.smkperkasa.sch.id', '$2y$10$X3hIqfIJ7pbIiQbsnkHwHuwYK4uI7.zsXt/UYc/7ZV7kZa/u1S2g6', 31),
(245, 'Riski Aditya', '0086575246', 'riski.aditya@siswa.smkperkasa.sch.id', '$2y$10$F6hHlsOi0C7S5soHZGdef.mrimjTW6wdf8oXlWSPP/exKCo2Cpjqe', 31),
(246, 'Riyan Etaham', '0083213490', 'riyan.etaham@siswa.smkperkasa.sch.id', '$2y$10$eQnSceJINN844GOKRLOWieLFoWkZ4hU3kVFNJdDrA/kjWYR7y0V9G', 31),
(247, 'Rizal Aditia', '0094433044', 'rizal.aditia@siswa.smkperkasa.sch.id', '$2y$10$V5CdVJ9KgB3PWzx6BWlBDugXKpI0CHLOhIbD/CcdNJu.kIFTLiXkO', 31),
(248, 'Rizki Ramdani', '0094946070', 'rizki.ramdani@siswa.smkperkasa.sch.id', '$2y$10$qZ2mqarnHyKpXtOQIL2GiezTrpERsBbw7NUQ0l3am1pcqcWZFHuH2', 31),
(249, 'Usep Saepudin', '0089156347', 'usep.saepudin@siswa.smkperkasa.sch.id', '$2y$10$DvxCSEDoXCFmz2a9Ub0vuecb1MlvigoQuHFS0PDk2XgSjtLsVlKWu', 31),
(250, 'Wawan Setiawan', '0087578961', 'wawan.setiawan@siswa.smkperkasa.sch.id', '$2y$10$vn9KLqHH0oB/Gpx2Xe2pGOg71jUu.nQqBPc7iWT9qSxbByG8VwLbi', 31),
(251, 'Aditya Pratama Putra', '0085529305', 'aditya.pratama.putra@siswa.smkperkasa.sch.id', '$2y$10$r7ZDBFYZrK6jw63RGQnJNevdWjIaY28DZejYqwc.g/lgV640n/2SW', 32),
(252, 'AHMAD FAUZI', '0096056075', 'ahmad.fauzi@siswa.smkperkasa.sch.id', '$2y$10$mMl3L6eqKgKa.lT9UNK9YuIQSAy0Xz9txINwiVhMkFsFFePn9zYEC', 32),
(253, 'Ahmad Hudaya Al Gifari', '0095685301', 'ahmad.hudaya.al.gifari@siswa.smkperkasa.sch.id', '$2y$10$0xkOKP7shoXbJrG2pXfB0Oq9TfZj.hgZBnyIOPy..L.HO1P45tJlu', 32),
(254, 'AHMAD NASIRI MUZAKKI', '0065301800', 'ahmad.nasiri.muzakki@siswa.smkperkasa.sch.id', '$2y$10$6W/Fz3NfuVl9NEEllz0dEuhjLL4.mLq5/SoBDSLpX9sp0eFUXVymK', 32),
(255, 'Denis', '0094202774', 'denis@siswa.smkperkasa.sch.id', '$2y$10$M2sVHn5UVGdwcWO40dsoGO1vXheoM8YAb.Q7FTug28kiBa3AHIlUq', 32),
(256, 'Eki Parel', '0087101327', 'eki.parel@siswa.smkperkasa.sch.id', '$2y$10$Wd7OxifeW0RBr344ecVfvuZyy8JfRjWM0W1Yg6SYVsaIyFIdVSWeO', 32),
(257, 'FADLAN RAMDANI', '0092446210', 'fadlan.ramdani@siswa.smkperkasa.sch.id', '$2y$10$mjZV1dGYarjcy/sq/Xf3uOAB2CjGwtew.W6adrcYFZPsWbcQt0Ulu', 32),
(258, 'GATHAN ALTAGANTARI KHAIR', '0082362678', 'gathan.altagantari.khair@siswa.smkperkasa.sch.id', '$2y$10$P3fA/QjMA13igRYBZ83vLe3o0BfxS0T5EIYbaO.dK4.Pzw7zoEP/6', 32),
(259, 'Hanif Akmal Zaidan Abidin', '0093076597', 'hanif.akmal.zaidan.abidin@siswa.smkperkasa.sch.id', '$2y$10$8A6IOGWust31QC6NfHDAOevHuXgC5bKSp7Hkcg2ft1KQanqcwLEuG', 32),
(260, 'Ihsan Hamzah Maulana', '0095102304', 'ihsan.hamzah.maulana@siswa.smkperkasa.sch.id', '$2y$10$2jUKUGOoFOx78ZpW7rmtX.BxgqN269d6DKNG8KE/TuKKUiVkzVCe.', 32),
(261, 'ILYAS FIRDAUS ILHAMI', '0098325624', 'ilyas.firdaus.ilhami@siswa.smkperkasa.sch.id', '$2y$10$YfIKVRbSM.cgSHoQEFzXW.hSLGZplyRXhtvchxMV35jnbfDA3wPNC', 32),
(262, 'Irgi Wirapratama', '0083882394', 'irgi.wirapratama@siswa.smkperkasa.sch.id', '$2y$10$xomIbT5Bxw.xuUIpJxYuxOT9w8Ga/Iycjlin8.w/3RXhidjUvGfn2', 32),
(263, 'IVAN SOPANDI', '0092411458', 'ivan.sopandi@siswa.smkperkasa.sch.id', '$2y$10$TLDPbOq.klbYvZMezbggd.TbYy.26zwkIcmkXcxHr8/rFEVUAhE.O', 32),
(264, 'Lucky Wisnu Al Fiandi', '0093123336', 'lucky.wisnu.al.fiandi@siswa.smkperkasa.sch.id', '$2y$10$5nGmHxdIjAtpmjfl58rfe.HNm2upyWPf5V1oa2RjLHZ07dtCx1ktS', 32),
(265, 'MOEHAMAD RIZKY AL FARIANSYAH', '0097229829', 'moehamad.rizky.al.fariansyah@siswa.smkperkasa.sch.id', '$2y$10$0oRUB0ajFnv/f4w0Tax25OXJOtW7tszEhNi86gp5Kd5L7OPc1LFgO', 32),
(266, 'Mohammad Sabarudin', '0096906186', 'mohammad.sabarudin@siswa.smkperkasa.sch.id', '$2y$10$1xWQg/hNJk1uhLegeTqcPeikejYyaLCn072LliJ7GiEv472.QjQau', 32),
(267, 'MUHAMAD FARIZ SIDIK', '0094655480', 'muhamad.fariz.sidik@siswa.smkperkasa.sch.id', '$2y$10$.WPwrPmC9TJY7K2KVpAJku9SLmx4TQRoWZ37Hehg1Df59vI3z3vM.', 32),
(268, 'MUHAMAD RIDWAN FERDIANSYAH', '0094401795', 'muhamad.ridwan.ferdiansyah@siswa.smkperkasa.sch.id', '$2y$10$ouNGk6tb8ua4jx.sckaxn.u.XcAMrbbm4EUNrC5LGcNg2R9HTRfI.', 32),
(269, 'Muhamad Yudi Hidayat', '0092099315', 'muhamad.yudi.hidayat@siswa.smkperkasa.sch.id', '$2y$10$l81MHEbWyfviXAMv8L829.A3yW3r37oXma95bwpWvLWC9CnMyBOUe', 32),
(270, 'NABIL NAZRIL ILHAM', '0095945852', 'nabil.nazril.ilham@siswa.smkperkasa.sch.id', '$2y$10$0izxinp5YOt7raIpq3UH7.6Mqx/MaK0lME9JqJrTlu5CGpctQnnI6', 32),
(271, 'NAJIB ALGHAZALI', '0083694342', 'najib.alghazali@siswa.smkperkasa.sch.id', '$2y$10$QymGs3OuCEH7tz5Io7d3X.7aXPHcRVU0PMl29c/qersqqr8uP9.6W', 32),
(272, 'NUR ROHMAN FAUZAN', '0099931787', 'nur.rohman.fauzan@siswa.smkperkasa.sch.id', '$2y$10$/GEkGkUwpnGEQJ58ZW6IpeLCyXikHRiUXaJpIAGeTWM1S0mkyHuk.', 32),
(273, 'RAIHAN PUTRA RAHAYU', '0085689814', 'raihan.putra.rahayu@siswa.smkperkasa.sch.id', '$2y$10$QjqOPQlBQVKSrqSWpj7OAuSYpPMhAIjm0pVV9TP6V8Gc3UXj19zuC', 32),
(274, 'RASA WIGUNA', '0074196285', 'rasa.wiguna@siswa.smkperkasa.sch.id', '$2y$10$XSQ429bKFgGdvIZ1HVYSX.GYJC6MuYYMi/YZ2DIEr0ECdPmdU5ZGm', 32),
(275, 'Saepul Purnama', '0089739854', 'saepul.purnama@siswa.smkperkasa.sch.id', '$2y$10$aLkjJz/vfwrQi.Hq0YC57eWCucYYI2Iz6rcbNb6lIHeMbHJ4wqJy6', 32),
(276, 'Salendra Melandry', '0081702592', 'salendra.melandry@siswa.smkperkasa.sch.id', '$2y$10$yNBcOjMFpv1udIIl6eElZ.5FQ0gx2V9wyD7DOlpSrv66qyzK/vv0K', 32),
(277, 'Tarto Zaelani', '0089745242', 'tarto.zaelani@siswa.smkperkasa.sch.id', '$2y$10$iZMT8dBAKwzNETydUACEL.p8yq5U6AGbNabXrJmS1Jd2KDRjV2ZCe', 32),
(278, 'WISHNU WARDHANA', '0089969622', 'wishnu.wardhana@siswa.smkperkasa.sch.id', '$2y$10$nrVLbjMyJOlsSHz2mw2ZV.po3twRH/7Gh5K6I.Q2IgEne3GYurvU.', 32),
(279, 'Akbar Ramadan', '0093447019', 'akbar.ramadan@siswa.smkperkasa.sch.id', '$2y$10$BiBUhTKtkSk5gS0HHJnfne5B91x.XS2U5An39KAXjfS3KLwnkWDqi', 33),
(280, 'ANDIKA SURYA PRATAMA', '0084277303', 'andika.surya.pratama@siswa.smkperkasa.sch.id', '$2y$10$wIbzmEAB6Ci65u6NcT/X5OCtdfWp3gjZ73Ox4kNeuZsCiZYIM6yyC', 33),
(281, 'ANDRE PAUJI', '3090849916', 'andre.pauji@siswa.smkperkasa.sch.id', '$2y$10$t.58a3HqI238fVE80uYZqOLz0RmWsnWnDrtly/edUH/KBDwgsby42', 33),
(282, 'Andrean Firmansyah', '0099158611', 'andrean.firmansyah@siswa.smkperkasa.sch.id', '$2y$10$2xydysM4Wyf4MVWcjCKaf.s5F6isn4HJ4uHJ/tLBFeRVt4gZGiLE6', 33),
(283, 'ANDRIAN ROHIMAN', '0087944597', 'andrian.rohiman@siswa.smkperkasa.sch.id', '$2y$10$98xpmXOnejpgySGLWqPpUOQOFse4emm.XU6MsQ4Dttqjj.0C5yX0O', 33),
(284, 'ASUTISNA', '0082488820', 'asutisna@siswa.smkperkasa.sch.id', '$2y$10$KRBZU4fbIpnmXPcTYlZga.qxipV6M4tb2m4/hA9RW7IzuqYBPLtEC', 33),
(285, 'Bayu Febiansyah', '0099776044', 'bayu.febiansyah@siswa.smkperkasa.sch.id', '$2y$10$v6NaI0B.wCf3CWMoFqNzE.cBmgJ.TX7l1YtVjbeFdxMeSCaZSTCVq', 33),
(286, 'Bayu Sukma', '0085901529', 'bayu.sukma@siswa.smkperkasa.sch.id', '$2y$10$JcPxSuYTCm07IeNWR7H8B.VX802Q0OOL4u55FcN3NzYhHGaL4b9WS', 33),
(287, 'Bima Setyo Purnomo', '0093433318', 'bima.setyo.purnomo@siswa.smkperkasa.sch.id', '$2y$10$.2gJ.if2fyer6YiGISxj5O7q7BLYwi1E2iV6MRi1HCKW6nrnoq/km', 33),
(288, 'CAHYANA', '3082158590', 'cahyana@siswa.smkperkasa.sch.id', '$2y$10$ss2u8cmrPqAtwHxNDNc5TO/GraboFj3haF6G9lEkINr5Tw1xVjcny', 33),
(289, 'Cep Yayan', '0084123488', 'cep.yayan@siswa.smkperkasa.sch.id', '$2y$10$InyNuNZGMfyDAAykRJ3roe/RScGBV1flTyl5S1CEjLIDJt6sbQAu.', 33),
(290, 'Dirga Muhamad Rizki', '0088192880', 'dirga.muhamad.rizki@siswa.smkperkasa.sch.id', '$2y$10$.Nt.VR3UoPs3XLc6CjwrrOzn9I73MhVtvMtv1yLgjv7WHb8ZgRYCi', 33),
(291, 'DWI NUR AZIS PRASETYO', '0086844127', 'dwi.nur.azis.prasetyo@siswa.smkperkasa.sch.id', '$2y$10$9YC3GFEf/xoSNODOmc54X.4gxj7j5wyY5GbL93pGFFsdGN31y2YRC', 33),
(292, 'Fauzan Khoirul Reyhan', '0083952568', 'fauzan.khoirul.reyhan@siswa.smkperkasa.sch.id', '$2y$10$VstCFhMa5n2P7AgNpdoSE.Pa0rhgmejJ6vTdkWB34QEW/uzlBEv5y', 33),
(293, 'GILANG RAMADAN NURZAMAN', '0089825152', 'gilang.ramadan.nurzaman@siswa.smkperkasa.sch.id', '$2y$10$DqnV4Sfylij8PNSE9HlOIOc13qVbOdgBHaMxlggniYhsnXOOBMujW', 33),
(294, 'Irfan Ramadhan', '0075910618', 'irfan.ramadhan@siswa.smkperkasa.sch.id', '$2y$10$wYsga0YwjafFGPMxF8Dt6.TTSM/aE5qV17EqUnYHbENc7rwZgiLPG', 33),
(295, 'M. Faisal', '0084793803', 'm.faisal@siswa.smkperkasa.sch.id', '$2y$10$f9vAKf2CLO31Nellwttx9eU/0zOm7q8JKI05UrrZ6wdHh9CZacQBW', 33),
(296, 'Muhamad Ari Kamanda', '3095554132', 'muhamad.ari.kamanda@siswa.smkperkasa.sch.id', '$2y$10$883J3e57NYrX7HOh34ovM.3Ebdz5X30S03Cu8jEZWZKY9sLxgAYAu', 33),
(297, 'MUHAMAD FARHAN', '0088316737', 'muhamad.farhan@siswa.smkperkasa.sch.id', '$2y$10$tZ5vLoVXdhGSLZ6WDGOGLOoeYwUkxPNX3eo3wfEoqee/B.lT2Ujf6', 33),
(298, 'MUHAMAD IKBAL H', '0072312937', 'muhamad.ikbal.h@siswa.smkperkasa.sch.id', '$2y$10$FAFIyNZT2ghErd8dPXUinOk1gGNEnYKdhxrxKx3QSD4jKTdnn3Qpe', 33),
(299, 'Muhamad Mardiansyah', '0081551191', 'muhamad.mardiansyah@siswa.smkperkasa.sch.id', '$2y$10$zhioN.rfgA06Dv589zep6.gR71dv7YgnTwqYosBAxGmi4SrjmE7Wm', 33),
(300, 'MUHAMAD RENALDI', '0082552854', 'muhamad.renaldi@siswa.smkperkasa.sch.id', '$2y$10$dysLS3SLDp0XYc0LmZ1Vp.fLna01dLh6MrEWOTaWLt3oJj7pskpPq', 33),
(301, 'Muhamad Revan Reviana Nugraha', '0091023361', 'muhamad.revan.reviana.nugraha@siswa.smkperkasa.sch.id', '$2y$10$1pGSORdmphACCjMkVFL/peXeNyeoRqtiej7j2z.LX1SID6dO6DlNi', 33),
(302, 'Muhamad Zenal Mustopa', '0089964451', 'muhamad.zenal.mustopa@siswa.smkperkasa.sch.id', '$2y$10$b3nmfwGBaPKOKWHYGz6KU.4mJA0.NAvn1bipfZPNsle5hK2s0b1/G', 33),
(303, 'Muhammad Azhari Mardiansyah', '0093922452', 'muhammad.azhari.mardiansyah@siswa.smkperkasa.sch.id', '$2y$10$KuBj8TpD12HCAqRwiUWfZO4PaxlU1KlQJcGh01VGKOVR0P/BPwLaW', 33),
(304, 'Muhammad Fajar Shiddiq', '0093873466', 'muhammad.fajar.shiddiq@siswa.smkperkasa.sch.id', '$2y$10$YhvczrCy2FfAbITOVjmEbeXRfYvy1Ar/S3mWpaoBhUT0scmGU5onG', 33),
(305, 'Najmu Sakib', '0097284266', 'najmu.sakib@siswa.smkperkasa.sch.id', '$2y$10$dW46NnwFBinrnuWByzCWee8y1zMXGqlbuAjT3q3xW9.8iqJfPElwG', 33),
(306, 'NAZWAN RIZKI', '0081533316', 'nazwan.rizki@siswa.smkperkasa.sch.id', '$2y$10$MBKirnrx8S/NM54HTZv/texIIRoPwB3g2KGnOrWDCdGc2/I5nEA5S', 33),
(307, 'Pahmi Sahru Roji', '0085465185', 'pahmi.sahru.roji@siswa.smkperkasa.sch.id', '$2y$10$UA4jfB1I9BcpSfoBYx2Ue.UuKSWe09J.x98mrfq7zNGQPzhvlmHU.', 33),
(308, 'Rendra Pardika Awaluya', '0081934131', 'rendra.pardika.awaluya@siswa.smkperkasa.sch.id', '$2y$10$uL8AibgIxYNfN2YkCruPbOBn6j0eQXblNcXtuk959hETDFwpKkIn2', 33),
(309, 'Repan Gunawan', '0098265498', 'repan.gunawan@siswa.smkperkasa.sch.id', '$2y$10$V7APQQIWf99mqnpU6uE8NuLxCoV2FcQLYQHL/Y24l5XJQYL1OCJoW', 33),
(310, 'Rizky Muhamad Agung Pratama', '0082543459', 'rizky.muhamad.agung.pratama@siswa.smkperkasa.sch.id', '$2y$10$U7q7Y8iR4gwhEPryal/cSe0Ibmi/.rVebWmXZq1r.ENdtty1zjpkm', 33),
(311, 'RIZKY MUHAMAD GILANG RAMADHAN', '0084834873', 'rizky.muhamad.gilang.ramadhan@siswa.smkperkasa.sch.id', '$2y$10$1JsPjbeUTO10FQWzkVSKPOk18SFLzd5mfuV7.1MyhFcKoRE8dvfg6', 33),
(312, 'ADE AGASTA', '0085406943', 'ade.agasta@siswa.smkperkasa.sch.id', '$2y$10$XnDaI4uquABUFaZ9JP92c.7GJDw1jaFtL0s2aL0e8XOSjTz7kzaCC', 22),
(313, 'Aditia Laksana Putra', '0094130205', 'aditia.laksana.putra@siswa.smkperkasa.sch.id', '$2y$10$bjf8ddZixt1.cWzl8jTxYOmlsMpNL08mIo/gZ5BtNmOg7AKUwkC2e', 22),
(314, 'Agung Permana', '0098827758', 'agung.permana@siswa.smkperkasa.sch.id', '$2y$10$leQ3i0QOU/xgQKSbmqDh3.HPWqCNSMXALnaTl/9sHY5oFyzY.K8Ty', 22),
(315, 'Bayu', '0081632435', 'bayu@siswa.smkperkasa.sch.id', '$2y$10$QXp.fYEKYDavYU/gUs9wlebGm1a6D5cm0hHYaqCNjhTKa5gC9aX9m', 22),
(316, 'Cahya Lesmana', '0091409602', 'cahya.lesmana@siswa.smkperkasa.sch.id', '$2y$10$gT4MQLRFrKwsUK39ORKnMuRl4sWBPX2XoRPj/oS0pR0UIsOlONEjS', 22),
(317, 'Choky Avian Pratama', '0094069561', 'choky.avian.pratama@siswa.smkperkasa.sch.id', '$2y$10$VNne62ieEQJIJ3hs0mzpcefs4ZQ17VQMPhWprGfKPZiDZ86drl.P2', 22),
(318, 'DAFA AHMAD FAUZI', '0087458596', 'dafa.ahmad.fauzi@siswa.smkperkasa.sch.id', '$2y$10$m0kSqKmYz5NaZpbsk.5OMu9MYkC0YsXjePpw5IzhtsYELcJm3ZGB2', 22),
(319, 'DE VAHLI DZALU SUMPENA', '0081106126', 'de.vahli.dzalu.sumpena@siswa.smkperkasa.sch.id', '$2y$10$2FpYzcOAYLGoH6.9fsgH5OxrX8GPkwf6R/gFwSE1v6iqzymv07R7m', 22),
(320, 'Diki Saepul Anwar', '0098903814', 'diki.saepul.anwar@siswa.smkperkasa.sch.id', '$2y$10$WuBa0GbLozl7mSwM2lTyBOEXpQyC4VzWOBvgyKtfVtp3qJ7aN41X6', 22),
(321, 'Fadli Firmansyah', '0089582343', 'fadli.firmansyah@siswa.smkperkasa.sch.id', '$2y$10$2mDkd5DtmAdU4xqkeB/fYu7CZgmxKU8ZrECqPw9w.PYWWtLY4w/NW', 22),
(322, 'Hafiz Salman Farisi', '0094481731', 'hafiz.salman.farisi@siswa.smkperkasa.sch.id', '$2y$10$wexywHCQGmthPhuOe564iOroTMEACKloU5V3oYNTnMh6KyL1zhc2u', 22),
(323, 'Ikhsan Subagja', '0085344265', 'ikhsan.subagja@siswa.smkperkasa.sch.id', '$2y$10$WBfGIDNjbwNiw4uXXMYIaealklgQum121mNw/cREm26R/76XuB.b.', 22),
(324, 'IZAN ALDIYAN SYAH', '0083748912', 'izan.aldiyan.syah@siswa.smkperkasa.sch.id', '$2y$10$Jo.bCJKSZB.JOh/1K8C5s./L4ytMYpmECV50xLjGE/OG5xYIwafVC', 22),
(325, 'LUAN DZAKIR HANIF', '0086304298', 'luan.dzakir.hanif@siswa.smkperkasa.sch.id', '$2y$10$LBDJ82VxPGTdbjFTrDat6eJAU8EHruj8KeYkb3/0iNw/.mjSxckkK', 22),
(326, 'Luki Setiawan', '0088667151', 'luki.setiawan@siswa.smkperkasa.sch.id', '$2y$10$fFBafbKnf0pu32rw0yC/1eIKL9kyx43jI11ZA3eKPfYYEFBc5Z/pu', 22),
(327, 'MOHAMAD GILANG RAMADHAN', '0084488704', 'mohamad.gilang.ramadhan@siswa.smkperkasa.sch.id', '$2y$10$NX3O3uaAUUabM7.IAHv0Juxq..7zhBM.F2mg34VS.MtyzRhtCWJ3y', 22),
(328, 'MUHAMAD ALDY SURYANA', '0095561520', 'muhamad.aldy.suryana@siswa.smkperkasa.sch.id', '$2y$10$D5.cYc9HUzD1Pk.IRzHni.wUX/RZkxBkK65rmJVrYQUXLAnYN.ul.', 22),
(329, 'MUHAMAD IHSAN', '0083236928', 'muhamad.ihsan@siswa.smkperkasa.sch.id', '$2y$10$UpJUeIY5eZx.T8yEuZC01OzrqXHb.fHIeLKxT419eyih1xBAAAz.2', 22),
(330, 'Muhammad Ilham Putra Hermawan', '0083766409', 'muhammad.ilham.putra.hermawan@siswa.smkperkasa.sch.id', '$2y$10$WMKz7V6LZ9vszc6qlUZ8f.FyXt1r2uZauwsIQ8lhIjCcasumaFxiq', 22),
(331, 'NURJAMAN', '0087839350', 'nurjaman@siswa.smkperkasa.sch.id', '$2y$10$j8FjvAU/0LJ8gccYiCzTMuEgtenPh0g0K.FGH5Tqa7K4DSRRhAo0C', 22),
(332, 'Oki Sukarno', '0092547572', 'oki.sukarno@siswa.smkperkasa.sch.id', '$2y$10$gzToRwPfR05.7HfvUSMp9eBIFVQffHIfxIeMxvxeueYJWiQ4NjisS', 22),
(333, 'RAMDAN SEPTIAWAN', '0088906304', 'ramdan.septiawan@siswa.smkperkasa.sch.id', '$2y$10$iWYVEA9XsQ4G/ReIVhDUderDvP7TabutcSUkd4lqD1S6x/JRI0U6u', 22),
(334, 'Refan Aldiansyah', '0084904505', 'refan.aldiansyah@siswa.smkperkasa.sch.id', '$2y$10$/fRdNOay1RJyzsyVRqTHVekbqgc/ZFhAQB2omgBa9CBnrkil.aHxq', 22),
(335, 'Renaldi', '0089750018', 'renaldi@siswa.smkperkasa.sch.id', '$2y$10$2tiAQvlStEPkLaAv0eNM7Oq7wFjgM3O3gZAAMSM7./NZpm1ZqpVY2', 22),
(336, 'Reyhan Cepy Ginanjar', '0081663583', 'reyhan.cepy.ginanjar@siswa.smkperkasa.sch.id', '$2y$10$CmC.eknjfTGE0iy5QRcS..ae3rjCc53lK7yFDm1OYOKEQ5yGcCxT.', 22),
(337, 'Rico Nata Palaesa', '0089582733', 'rico.nata.palaesa@siswa.smkperkasa.sch.id', '$2y$10$7dYMqK8Bjh/AGdHHuruQeOrA5ZzWr/ZwqqoZ4A2gOZQ2dgKkxR.nW', 22),
(338, 'RIDWAN NURUL AKBAR', '3097441796', 'ridwan.nurul.akbar@siswa.smkperkasa.sch.id', '$2y$10$6s4xtuPvjOanUkYXD9ZC2eh00toOaYV/cSJY1n4xygnVKBCFxmkiK', 22),
(339, 'Wisman Ade Putra', '0093493609', 'wisman.ade.putra@siswa.smkperkasa.sch.id', '$2y$10$llwEQm/hrLuKQcooad7a5e2cWbZH8.iiYBsdfxRu1bzPW650D6pA.', 22),
(340, 'Aditya Pebriansyah', '0091775720', 'aditya.pebriansyah@siswa.smkperkasa.sch.id', '$2y$10$x3AeFTrc0/BTZPftlRtScO1QYwKo27jzRGpyoM1DkYI4xdcuEFj..', 23),
(341, 'Agung Rendiansyah', '0083747564', 'agung.rendiansyah@siswa.smkperkasa.sch.id', '$2y$10$e9zQSxso8hwDV1Qbh0uh4O9TUM22jFMkS3ZYRf9eEXCInRYDOTgsu', 23),
(342, 'Ahmad Supriyadi', '0081347890', 'ahmad.supriyadi@siswa.smkperkasa.sch.id', '$2y$10$ZqTf4OsxN5bkxjXFgOZ0O.VOOB1CX.x7AbRr3YyOCgk7mpHxXKke.', 23),
(343, 'AHMAD WAHYU NUR MULYANA', '0099720343', 'ahmad.wahyu.nur.mulyana@siswa.smkperkasa.sch.id', '$2y$10$Ewn4YtVnyoMKIp6BaqqpeeWPZoQRZnoedmW76LA2gNbWeLF1R8o96', 23),
(344, 'ALFI APRILIAN APANDI', '0091854726', 'alfi.aprilian.apandi@siswa.smkperkasa.sch.id', '$2y$10$MQrNcPnY3J1ZxktDy500mO5ZtomGbvZdKs9AhdgPRmfv6QLON/SYi', 23),
(345, 'Alfin Muhamad Adriyansyah', '0083226051', 'alfin.muhamad.adriyansyah@siswa.smkperkasa.sch.id', '$2y$10$eBu/eii0k0BpK7F44AOeFOd4K/cllSczwlFb9UUBtHmUFQMHTKO.m', 23),
(346, 'ALGI', '0087066633', 'algi@siswa.smkperkasa.sch.id', '$2y$10$0rnFU7amYu/EwcCkdGQ8cO9Q99avABVob64pPCrLdaLVdb9ZrWzGu', 23),
(347, 'Ali Nurjaman', '0086814423', 'ali.nurjaman@siswa.smkperkasa.sch.id', '$2y$10$zTHym8sdekaiYbPin3HVmuSYS2ssrWOWwsjVtWdjFvT2ZYou3VwxK', 23),
(348, 'Alip Saepudin Fatuloh', '0097446577', 'alip.saepudin.fatuloh@siswa.smkperkasa.sch.id', '$2y$10$oOt/GoGVZSel8KvBNXiB/OrnSZ3STDZMAFCaMYhS7rWGe0fTcHNVS', 23),
(349, 'Cepi Permadi', '0082695218', 'cepi.permadi@siswa.smkperkasa.sch.id', '$2y$10$IrPAwqFg/uT5TTzoAfP1peI8esTFT2GuxlOHgP0iaAhdOOwE4UL2K', 23),
(350, 'Cevy Mulyadi', '0086770571', 'cevy.mulyadi@siswa.smkperkasa.sch.id', '$2y$10$UTkeqTMuBERQOfQiECOVrebG4mSLug/TltlB1kEwBtRQTWLcrekJi', 23),
(351, 'Dheva Rezky Ramadhani', '0089761546', 'dheva.rezky.ramadhani@siswa.smkperkasa.sch.id', '$2y$10$2ezPC.UKO1etxxdIx7KYI.92txepvJuxXNdWWnLh6EKyZ/vFw10IK', 23),
(352, 'Dika Hardiansah', '0081713116', 'dika.hardiansah@siswa.smkperkasa.sch.id', '$2y$10$yCl.52UenRjacvCGPyp.q.tjPW2PiCWDxP.GrmFi/L/1cWuCOI.y.', 23),
(353, 'FERY ANDIKA PRATAMA', '0083115150', 'fery.andika.pratama@siswa.smkperkasa.sch.id', '$2y$10$NGC2C3QjLLUNs7hlfw5/mOqcEpm0mR.dxdnBDuGO0kJV/2G8WwyTO', 23),
(354, 'Hilman Sanjaya Putra', '0088208591', 'hilman.sanjaya.putra@siswa.smkperkasa.sch.id', '$2y$10$ikNjrNA2EPEjwOvyF2Dx5.UKMxoQfXFlOnAeDvcOJbjddegxLhYli', 23),
(355, 'ILHAM ADITYA', '0081663538', 'ilham.aditya@siswa.smkperkasa.sch.id', '$2y$10$JduRrYvUKplSuVf19HEDI.ZwBeTKYnXdLV0seIL.7e4FJEv23RIu.', 23),
(356, 'Junior Yusup Aljaelani', '0093825016', 'junior.yusup.aljaelani@siswa.smkperkasa.sch.id', '$2y$10$hwDERHwfoUslNcHLCpKQpeDgAitI9eTotbVLvpFMogCPeQSw5WGbu', 23),
(357, 'Muhamad Fajar', '0098325807', 'muhamad.fajar@siswa.smkperkasa.sch.id', '$2y$10$9TO8DFj22YZlHSJoGZZ27eBXtxSSo4mfFa8nA0hOB/7Aq2CQpS8Na', 23),
(358, 'MUHAMAD RIZKI', '0094542712', 'muhamad.rizki@siswa.smkperkasa.sch.id', '$2y$10$a0m4cwMBfK7vX2LlvbqRGOK5JcxjVWwgj0CbDcl6vS7hq2ZJzBYny', 23),
(359, 'MUHAMAD RIZQI RAMADAN', '0097161413', 'muhamad.rizqi.ramadan@siswa.smkperkasa.sch.id', '$2y$10$ukh3PNleIe6wjaS.Uz9J9.4r6JDlnqm73QOqSFB0Nqmlcsj6MV0Gy', 23),
(360, 'Muhammad Fauzal', '3091387724', 'muhammad.fauzal@siswa.smkperkasa.sch.id', '$2y$10$EsIYoKHO7QgkHgJMSjVGF.NNqyPpjxLQh4O/Rsjm2.OMwmlPcyl7q', 23),
(361, 'MUHAMMAD RIZKI PADILAH', '0089311049', 'muhammad.rizki.padilah@siswa.smkperkasa.sch.id', '$2y$10$P4.O6W.5NMPNvV7/anLG8OeZ7UlZ/VhLIHefOcyEwESoBO1B8oaAu', 23),
(362, 'Pahriz', '0092102620', 'pahriz@siswa.smkperkasa.sch.id', '$2y$10$WLynTtJUdtDMTjmgYRYikOhn9ZY7NtTu0tCraSNXKqR5X0q5hr3zS', 23),
(363, 'RIFKI FIRMAN', '0085847766', 'rifki.firman@siswa.smkperkasa.sch.id', '$2y$10$a49ADbPRf8m4GMkCftaWGOga6NGXP7YPk2lYE2n.DqYKaotDRJ3w.', 23),
(364, 'Rizal Fauzi Permana', '3081626463', 'rizal.fauzi.permana@siswa.smkperkasa.sch.id', '$2y$10$5/5OF6yQwh16l89xj2DCA.8tSvEd.y0g/3ZXQwbh2zaJhvgKGBkbW', 23),
(365, 'RIZAL MAULANA', '0089492687', 'rizal.maulana@siswa.smkperkasa.sch.id', '$2y$10$Atr78LnfWzNou7F6Q5/Km.f9ZwwQJek9gUAUfqN0gv6T0cIsrZiJW', 23),
(366, 'Rizki Fauzi', '0081657215', 'rizki.fauzi@siswa.smkperkasa.sch.id', '$2y$10$5IdPevYTe1oB9zJWxCqMDObkYL5z1ABcqGcffQfS9cl8y7w4Rf0oe', 23),
(367, 'RIZKY FADILAH', '0081253318', 'rizky.fadilah@siswa.smkperkasa.sch.id', '$2y$10$3Fy.T6v0EIyCJSCYISQO/e0TMHadYILlo2xKybqE4ZZKHcmGZ99mi', 23),
(368, 'Robi Mulyana', '0083430602', 'robi.mulyana@siswa.smkperkasa.sch.id', '$2y$10$B.z3DbMTbS/N.nwPYLWsfODTYuV7C4IZK1QXeLnH657K3OEWvnj.S', 23),
(369, 'Usup Nugraha', '0087124210', 'usup.nugraha@siswa.smkperkasa.sch.id', '$2y$10$BokPVyTt8LuiNDfn6TE8Xuzan.HSHxysQYfefM63WRsGR2PSRCyhu', 23),
(370, 'Abdul Wahab', '0066632966', 'abdul.wahab@siswa.smkperkasa.sch.id', '$2y$10$vkSHw0oNset4Z7qM4fyMku7fkKEo97LsDME3yX4KuxaF1GNBRb/5O', 16),
(371, 'ALPHA SATRIANI CARIUS', '0076014978', 'alpha.satriani.carius@siswa.smkperkasa.sch.id', '$2y$10$BXnIj6YqBvkwfSW0M5y4GOer3YPgo5A.qrGzq.BnyfbE193dzLfQS', 16),
(372, 'ARKA NURIL IZANI', '0073238476', 'arka.nuril.izani@siswa.smkperkasa.sch.id', '$2y$10$4Fm.toj.Obrm96Ntfa7Bg..HaJANg.mlbFxIr2eCFAvFwwv/srv/2', 16),
(373, 'Ayu Lasmini', '0087861141', 'ayu.lasmini@siswa.smkperkasa.sch.id', '$2y$10$CSDn7gjyhCNOnuqsREFVGeN4SQ1sOJW9Blm0gs/U1IqS80btzPqLq', 16),
(374, 'BINTANG ALBAR', '0073147014', 'bintang.albar@siswa.smkperkasa.sch.id', '$2y$10$PYlehBXZP1yepJ4cru79L.ZHqekUPR0IF/QQ5Ad1cnZDxlvMpNmea', 16),
(375, 'CAESARIO OCTAVIAN BYZANTINE', '0081271522', 'caesario.octavian.byzantine@siswa.smkperkasa.sch.id', '$2y$10$rcxkaVw8QBLoPEisziupEOKlVJIXrsFjh0oJPtTFqfbCjM31.pINy', 16),
(376, 'DAFA RAISYAH ARIFIN', '0074480005', 'dafa.raisyah.arifin@siswa.smkperkasa.sch.id', '$2y$10$mljyUXImaAPcV1jnM/y5KeqQT8MjiR9D2tq6sSDILgHt/41OYeSnm', 16),
(377, 'DAMAR DWI CAHYO', '0074985352', 'damar.dwi.cahyo@siswa.smkperkasa.sch.id', '$2y$10$WXlmKqESa3kybtajd6wm3./MjjqapuZXoIzd1HYewjp58QyViV0gq', 16),
(378, 'DEBI RISMA WARDANI', '0072335301', 'debi.risma.wardani@siswa.smkperkasa.sch.id', '$2y$10$n4ZtdLbcDn/K0A3DIcWT1eMBHkXXi4lEVbIYs92AGbtF/pnkTlsmO', 16),
(379, 'Dewi Kartika', '0085061343', 'dewi.kartika@siswa.smkperkasa.sch.id', '$2y$10$Wf.680ry6shqFAQhog4KhepGjAeLSrvnGAiIGH9mnXrAPoS4KyOO6', 16),
(380, 'Fikri Alamsyah', '0077205741', 'fikri.alamsyah@siswa.smkperkasa.sch.id', '$2y$10$.vFbCaSf73AQEu7Y4yonT.Xpl5/YBDGx2i1QwrQZNzIE3FLW.ftd.', 16),
(381, 'FIRMAN SETIAWAN', '0079483198', 'firman.setiawan@siswa.smkperkasa.sch.id', '$2y$10$u/.f.rb.F/iIMr51eBNAweRB0YEEQ1OlFIhyozVCa10TH0C5UIuZ6', 16),
(382, 'Hendra', '0082732987', 'hendra@siswa.smkperkasa.sch.id', '$2y$10$T9vXMKcQdJ6B0y1hRbkKdukLMwxDa1zknO3GTl0M3.I0k70Inm6Sa', 16),
(383, 'Jajang Laksana', '0082314426', 'jajang.laksana@siswa.smkperkasa.sch.id', '$2y$10$JeyfcHWkvZC0jR.MxpM6XONTWH/R84CrMDd.A5b3fkX4lZ4xE8j4O', 16),
(384, 'KAKA PABIAN NAKULA', '0087090447', 'kaka.pabian.nakula@siswa.smkperkasa.sch.id', '$2y$10$AP/U5TqZ9mNEkUQlClnHrOh124yMPHMcOXSvDli51tkBQmI7Kefru', 16),
(385, 'Kiki Pabian Sadewa', '0084344761', 'kiki.pabian.sadewa@siswa.smkperkasa.sch.id', '$2y$10$HCe1SZ8dLNM0V/aTlGrbR.e94iM/564sP76TcaGBtgIAn8jqAxm0K', 16),
(386, 'Mariyah Ulfah Hidayah', '0089872930', 'mariyah.ulfah.hidayah@siswa.smkperkasa.sch.id', '$2y$10$pYfNhZT0mYJpmo4PJH9i0eQaDLMsaSxXiPOkrirzVu29s48M80YSi', 16),
(387, 'Melani Putri', '0088001255', 'melani.putri@siswa.smkperkasa.sch.id', '$2y$10$sRD6zAxudb0m09UWDlVBjeL6ZyIJzupRGY7SveIwytl0J5//wezVG', 16),
(388, 'MOCH RAFI APRIANSYAH', '0074868479', 'moch.rafi.apriansyah@siswa.smkperkasa.sch.id', '$2y$10$4gibioNzlZmdkEx6wFSl1.XvwTJTnE.PFBSW81z50Zqr/n6r4Ve0K', 16),
(389, 'Muhamad Aji Permana', '3074476020', 'muhamad.aji.permana@siswa.smkperkasa.sch.id', '$2y$10$3kJKEpho2VBS4Ah99ec.ROlkVVW4KGAxYxxAkJpHv3qIemT9RwWky', 16),
(390, 'MUHAMAD FAREL TESAR ADITYA', '0075026173', 'muhamad.farel.tesar.aditya@siswa.smkperkasa.sch.id', '$2y$10$A5hvzC/B4vk0uMX4KP9DHuGGjtstMJmB2gymotRHpkh3BZgrz.Nbm', 16),
(391, 'MUHAMAD SOPYAN FAUZI', '0069667910', 'muhamad.sopyan.fauzi@siswa.smkperkasa.sch.id', '$2y$10$.W/WjpdpUx6z9lK7.HH88urp.3wVo0GDZg3b849ohAMK3xY7X370W', 16),
(392, 'MUHAMMAD RAIHAN', '0074422602', 'muhammad.raihan@siswa.smkperkasa.sch.id', '$2y$10$tsTUXCGDC7B595j.ZDchN./HyqFMMY0Zt/RZ5XoDifWjlLPbJfSly', 16),
(393, 'Nita Marselani', '0083901108', 'nita.marselani@siswa.smkperkasa.sch.id', '$2y$10$tn7DcgNSMlA1gEoVUa5UW.OmBWk.GqdMH0JWb0rW.tdM/7w1/t4B2', 16),
(394, 'SALAS ABDULAH', '0082618614', 'salas.abdulah@siswa.smkperkasa.sch.id', '$2y$10$4SGjCMRBp2nGCCVrWv9Z0O7tYa3BY93pQtCfAeGW.Ra3ZYobfO.Mm', 16),
(395, 'Salsabila Sapitri', '0086318958', 'salsabila.sapitri@siswa.smkperkasa.sch.id', '$2y$10$NYa3yk7XCMRFF0eLGbQBUu/FMls3fnGQdY5UnE/1H3vbHWa9SMhEm', 16),
(396, 'SITI ROHMAH', '0076304599', 'siti.rohmah@siswa.smkperkasa.sch.id', '$2y$10$T9Sz2mXcHPU6vV7EGm6wNuRc/0fBPD03L1FiLjvwQ.Mus83pBrb2a', 16),
(397, 'Syahril Eight Guard', '0086966273', 'syahril.eight.guard@siswa.smkperkasa.sch.id', '$2y$10$29XCxuIJDMYBQ4Hr3gKTF.ni947VxyTuP5NpE9KN1r4SpHgGHuDP.', 16),
(398, 'Taufik Hidayat', '0074978460', 'taufik.hidayat1@siswa.smkperkasa.sch.id', '$2y$10$u4BtBm.Ym55yH6/ryNGPJ.DyPj6lz8xwQQ4Yw5HQqCFdi63Y1C9BW', 16),
(399, 'Zeny Pertiwi', '0081514157', 'zeny.pertiwi@siswa.smkperkasa.sch.id', '$2y$10$RaPI8wMdcmnUEdHg4sFdquLCFcwl.Eu/PreJRUGKV7AIjKtzCEno6', 16),
(400, 'ALANNIS FUJI SYAHRANI', '0073578746', 'alannis.fuji.syahrani@siswa.smkperkasa.sch.id', '$2y$10$5r6Cbqp.bmmguocBKonsEOGJZVjrA92LAeHl6vgRhSVH7V12qFFta', 17),
(401, 'ARYA MAULANA ANGGARA', '0085405019', 'arya.maulana.anggara@siswa.smkperkasa.sch.id', '$2y$10$14OfIDHVPAoaHu5fgjmxAOxoq/RWq7oMRQ7S5CAyekKzA6KDiThXa', 17),
(402, 'Asni Purwanti', '0073451597', 'asni.purwanti@siswa.smkperkasa.sch.id', '$2y$10$sUSudi9Ks6FttjKdx2qjM.Q8COpmG48Ray5SVTcKLhtpjZOl303XO', 17),
(403, 'DAFFA FAIZAL', '0073283790', 'daffa.faizal@siswa.smkperkasa.sch.id', '$2y$10$3E19r.wHZFrV4vq8vuMLr.qoKnOiKybU1taAgfGPwKptRPE6CTRya', 17),
(404, 'Damelia', '0086254306', 'damelia@siswa.smkperkasa.sch.id', '$2y$10$F6guO1xBfaNcySIC4NO1su3eg9QKL3hkTZG3cBA/ZdypUBZf.M5j.', 17),
(405, 'Dika Aditama', '0076771047', 'dika.aditama@siswa.smkperkasa.sch.id', '$2y$10$aM35pFVdfEwhmRGnbf6eb.1g77k6zYN7fPyBv7r1WpCGSD4gAmD1y', 17),
(406, 'Dika Reyhan Aditiya', '0089453315', 'dika.reyhan.aditiya@siswa.smkperkasa.sch.id', '$2y$10$ebxbSuukzlCphhTSBPnYD.v6jSPT0OUUIuUwR73NhiQKXPfAi8OTS', 17),
(407, 'Dimas Arifin', '0076272331', 'dimas.arifin@siswa.smkperkasa.sch.id', '$2y$10$4tqeN8atuRH0ceaQygxGoewiSUOM2l5uAWzCMetB90I5dp2EkucAK', 17),
(408, 'Fadli Fadilah', '0078876364', 'fadli.fadilah@siswa.smkperkasa.sch.id', '$2y$10$yXp30MiscAj.jw5aBp20/.YSIcLav/HjhCqhyxFvvvHvDDajiZ0fy', 17),
(409, 'FARHAN TANJUNG RIZIQ', '0076742969', 'farhan.tanjung.riziq@siswa.smkperkasa.sch.id', '$2y$10$nEZ0Rz5SieGAmMvOAmqeueLnNysEpFNzY7m0GCT5EAAdUV9Oj0sH.', 17),
(410, 'Irfan Nurhakim', '0076902479', 'irfan.nurhakim@siswa.smkperkasa.sch.id', '$2y$10$LMUWc6AlkKO.VCpuPptmfOBFX4Z4..QMc.PszxwCjIfHKIq7RS7aS', 17),
(411, 'LEPLY AGLIANSYAH', '0071589497', 'leply.agliansyah@siswa.smkperkasa.sch.id', '$2y$10$HoBjpyIODjvoDhJpQTV7QuJXEXYAGjyCZ1PPZDIyVFgNFGycV0DV.', 17),
(412, 'M. DAVA ABDI RAMANDA', '0082020835', 'm.dava.abdi.ramanda@siswa.smkperkasa.sch.id', '$2y$10$uLKN3/022ob5gyqkndToB.CpHamoe39Ytu41M6WyJYxiznSz.KSIy', 17),
(413, 'Muhammad Abdul Backi Juliansyah', '0086135305', 'muhammad.abdul.backi.juliansyah@siswa.smkperkasa.sch.id', '$2y$10$yi4NNUutH/7SoIkqEhdujePTgCeraDP7BISeE0jCPArXJEqMwz5Cm', 17),
(414, 'Muhammad Araafidin Aslama', '0078007586', 'muhammad.araafidin.aslama@siswa.smkperkasa.sch.id', '$2y$10$1WZwyvYh.eD5kIXCYC9n2epocdBaAWKuFis5NWu2QFx7oV2aJeAxa', 17),
(415, 'MUHAMMAD LUKMAN FIRMANSYAH', '0075786895', 'muhammad.lukman.firmansyah@siswa.smkperkasa.sch.id', '$2y$10$u5PY6P3jmtXaDaA6fKK5dOImw9aOhy/8fMqv2ACJI.BniA1Uyg1eG', 17),
(416, 'MUHAMMAD RIZKY LEGIANA', '0076523180', 'muhammad.rizky.legiana@siswa.smkperkasa.sch.id', '$2y$10$7nf/BfSWDk9eNKcc.19VP.yn93J.WBIS.OHip8aD5mf1cuE8CO0HC', 17),
(417, 'Nadia Meilani Fadilah', '0076890962', 'nadia.meilani.fadilah@siswa.smkperkasa.sch.id', '$2y$10$FFGPUSYlTdijD0QK7WX.kellZ17IMmbhKb5Jf7zVNUC.X5uR9gTfK', 17),
(418, 'Novi Siti Muchlisoh', '0073158753', 'novi.siti.muchlisoh@siswa.smkperkasa.sch.id', '$2y$10$m/JUFDmGzN6zrJoXfCUvaeaePH.wzXwV3xkU.Qn/oDoIFsn2XP81q', 17),
(419, 'Rama Bayu Rizqi', '0072773163', 'rama.bayu.rizqi@siswa.smkperkasa.sch.id', '$2y$10$aOBf0CZNp2oIhpq8Lx89/uVKScuBbXqGRO6jVWQGFNvvzft18z/VS', 17),
(420, 'Rendhy Afreza Pratama', '0085596670', 'rendhy.afreza.pratama@siswa.smkperkasa.sch.id', '$2y$10$umdAVme8lvxbkW0OPu1UmOIfQ6kBywszCpksb/zbNVvxLENV5wTMG', 17),
(421, 'Siti Nur Hasanah', '0077668385', 'siti.nur.hasanah@siswa.smkperkasa.sch.id', '$2y$10$BCyEqXoN4O7IdvROVtHJUeL0C9YHG02tE47gPR1DBH/eVq7XApkbG', 17),
(422, 'SRI HARYANI', '0078114465', 'sri.haryani@siswa.smkperkasa.sch.id', '$2y$10$cVTk.J5S08NZ7svBD8Fv7ues5PfaxFqDhH5D1qf5HA3CnuqBvrDPW', 17),
(423, 'Toni Herdiansyah', '0058379855', 'toni.herdiansyah@siswa.smkperkasa.sch.id', '$2y$10$5iHwmsQkvn11NaTjXEQHZeCCEnWX9JW7gwQIU/Ik2Y/1r/hIa1VOm', 17),
(424, 'Varel Poetra Satria', '0085010802', 'varel.poetra.satria@siswa.smkperkasa.sch.id', '$2y$10$yIDEv9Z/NXkZiS4jfEPE1eX3eG1mB3BsUBVFZyv2hHldn8ca.zsIe', 17),
(425, 'WIDIANSYAH ZULFIKAR', '0087189986', 'widiansyah.zulfikar@siswa.smkperkasa.sch.id', '$2y$10$ASl2qiCf.jDohTYMpdxH8.cOSne/6DRpHJMlhDDFaSTPaoXQtHrBC', 17),
(426, 'YUGA SUKMA PRATAMA', '0081927294', 'yuga.sukma.pratama@siswa.smkperkasa.sch.id', '$2y$10$4vPkXOxChsMQSVI51mJzm.uKceG10enfpASxwpeKiMgqKox5qEFM2', 17),
(427, 'Aisyah Latifa Nursyifa', '0088110247', 'aisyah.latifa.nursyifa@siswa.smkperkasa.sch.id', '$2y$10$vewGASCIiOmxfsXQDy4nfOr7ORLK8.O9AwyE/XmG/0gBI/YAGI2.G', 18),
(428, 'Ali Aghisna', '0078104118', 'ali.aghisna@siswa.smkperkasa.sch.id', '$2y$10$DMjXNlmkzB26WUPImv1ksO5zdkPkpYbJBgXgl6vpyCiuSP/sIKcKK', 18),
(429, 'Anggi Septiani Ramadani', '0082046225', 'anggi.septiani.ramadani@siswa.smkperkasa.sch.id', '$2y$10$dF0IcbIiTNuJh36h4tQ3l.8Ii3zs2gspCwCDIxjidb9K0dqqWK3Ze', 18),
(430, 'ANUGRAH PUTRA ADITYA', '0077418484', 'anugrah.putra.aditya@siswa.smkperkasa.sch.id', '$2y$10$pq3eU.PCUb4xyf3buPDobuXrJfnAdk.AzWdQ9UEB8ZfR5juwSaPWm', 18),
(431, 'ASTRI FADILLAH', '0077998164', 'astri.fadillah@siswa.smkperkasa.sch.id', '$2y$10$1Fdd5DRoA26TCEd5urM..O/drOtnsSuWh1WvwIlxb8GyR8vlOs0Wa', 18),
(432, 'AULIA ANGGRAINI PUTRI', '0072001874', 'aulia.anggraini.putri@siswa.smkperkasa.sch.id', '$2y$10$FR1rdBWjvR2To8Weq6MyLOW9mHN2f5NrkWiUWyYe6CvorCpmtazvq', 18),
(433, 'Dalpa Daroriah', '0077200001', 'dalpa.daroriah@siswa.smkperkasa.sch.id', '$2y$10$l/IUpbJmmRn0k7YUs1bXgOZcxey8qwQlE2WQ8eCirfMv1XUVDwCc.', 18),
(434, 'DERA RAMADANI', '0071443023', 'dera.ramadani@siswa.smkperkasa.sch.id', '$2y$10$TMddD7c9wviR33fHiHei/.bLK6p1hJXK0QarsI7fEfMewbErTo0Im', 18),
(435, 'ESA FATIMAH QOMARIAH FIRIZKI', '0072228914', 'esa.fatimah.qomariah.firizki@siswa.smkperkasa.sch.id', '$2y$10$hs6Vf6TjPQIn95BGKoRS6OBnKJe5sNUoazE9cJuQ230MrhZxyPh.2', 18),
(436, 'FRANSZA ABDULLAH ADIJAYA', '0073811442', 'fransza.abdullah.adijaya@siswa.smkperkasa.sch.id', '$2y$10$fvBCy/dth0L1lE0ao16TPeZJLeVN/pVghvC.fIatUqydfIcwerT.m', 18),
(437, 'Julia Fitri', '0082973536', 'julia.fitri@siswa.smkperkasa.sch.id', '$2y$10$zaWRXKaI9YrfFpd5aqThLOHvIXnJ.TxRtX4MP0muSA/FwkaZZoWy6', 18),
(438, 'Lismi Haniati', '0083443753', 'lismi.haniati@siswa.smkperkasa.sch.id', '$2y$10$qFTFbG2xGg1aVLs7c.9Fq.eamVI8sc5hpjljOTCrlF0tJZQrBwOum', 18),
(439, 'Meidina Isma', '0076126589', 'meidina.isma@siswa.smkperkasa.sch.id', '$2y$10$qPXg5HvroT8UnVrlLFrqUOyoUruFM6yeIpInmd9z6fJha6iKqOCty', 18),
(440, 'Moch Rizal', '0081876704', 'moch.rizal@siswa.smkperkasa.sch.id', '$2y$10$znOpabHo2H9R.faaUJjgV.X0knwIWqZc6RCrlGBQ1U34dNA5Gh4AO', 18),
(441, 'MUHAMMAD DAFFA HERMAWAN', '0083881196', 'muhammad.daffa.hermawan@siswa.smkperkasa.sch.id', '$2y$10$VNbG6Jui3clpIlKy9WSmpekD7Cm/Mc1dztdy1eBfXHG76OB3H9SLa', 18),
(442, 'MUHAMMAD FAHRI LUKMANULHAKIM', '0076010393', 'muhammad.fahri.lukmanulhakim@siswa.smkperkasa.sch.id', '$2y$10$ovOaPe8ZJX7ui/psk4yjBe5k/hXWEXkYiG1TfJk8zIvTFbR2lUWd6', 18),
(443, 'Mustika Dewi', '0071367778', 'mustika.dewi@siswa.smkperkasa.sch.id', '$2y$10$hkm4/pQ0.thSO8RJfxb2zOmlWorcb1/vCRL6tk8.3Lz0T0McKAiZq', 18),
(444, 'Rahayu', '0078727300', 'rahayu@siswa.smkperkasa.sch.id', '$2y$10$OBOepPFHnhazN0N8FhZrnuuTTD6rYy/RoeleZApP/lM2k/35FXJWK', 18),
(445, 'Ramadhan Faturohman', '0079613336', 'ramadhan.faturohman@siswa.smkperkasa.sch.id', '$2y$10$CEJroFIKoH1H2coGLWFqFOho5S0a7IKxnH65Gw4dd7.77mq7oPO4G', 18),
(446, 'Rehan Maulana', '0076836872', 'rehan.maulana@siswa.smkperkasa.sch.id', '$2y$10$p53gBjlLtZ1LKMAMP4E3NuRKFrtxx2oCdWGtYVhzTIMw88yWeoCqC', 18),
(447, 'Rima Honisah', '0079985133', 'rima.honisah@siswa.smkperkasa.sch.id', '$2y$10$KHFf2IqPnF6ALLnX4ikzhOu5eyocn/sdfHPSfvouklg2ZnPjiNtKu', 18),
(448, 'Saeful Mubarok', '0078857493', 'saeful.mubarok@siswa.smkperkasa.sch.id', '$2y$10$7indB1Y0Zwwm92KSVEBWy.cwUGo9jUEJE4Fv2LAaDLx7Jh6lMh7fW', 18),
(449, 'SELI', '0087796230', 'seli@siswa.smkperkasa.sch.id', '$2y$10$MRw8u1or0scuUxGxY4N1heUx.QhEx69KaHelDZ27BkQKBPJkFxqCq', 18),
(450, 'Taryana', '0073814773', 'taryana@siswa.smkperkasa.sch.id', '$2y$10$1g4CR7DXGxTjF7jwVZcMPO73I.vifs5Db27gwZbIz9pvMG8ZTrNmG', 18),
(451, 'TRIASYA MULYA RAHMAT', '0083540466', 'triasya.mulya.rahmat@siswa.smkperkasa.sch.id', '$2y$10$9n4x9Neb4ZBxryCowMxgTu21K.4uYWoNSJWbbBWJagLsHQEnWghFa', 18),
(452, 'Wida Pirmansah', '0076328937', 'wida.pirmansah@siswa.smkperkasa.sch.id', '$2y$10$Kr5kpBKBMD2sFlpkSWgcT.1RoJrYAHkg8O2w9kZmSoU1r4DOoBHMi', 18),
(453, 'Wili Saepuloh', '0085838799', 'wili.saepuloh@siswa.smkperkasa.sch.id', '$2y$10$a2dmabvukeCVGnpB6i4BjeQof3/dL0fZaID3uTYpGUhFIL7WH4fXe', 18),
(454, 'Yulia', '0076393088', 'yulia@siswa.smkperkasa.sch.id', '$2y$10$p30v1OG4DRAX8VXxKx61Cu0g0eTFuqym8km9HxcFcNuuNlKx6pbq.', 18),
(455, 'AHMAD MAULANA MALIK', '3077644492', 'ahmad.maulana.malik@siswa.smkperkasa.sch.id', '$2y$10$dROKbxasufmFCPvfkVJv7uD.c5MWP8UlooXGTtdG9rDLaUdjHNrdS', 34),
(456, 'ANDRIS ZAKI HARDIANSYAH', '0072000882', 'andris.zaki.hardiansyah@siswa.smkperkasa.sch.id', '$2y$10$TSIwIaMQsNPAsyVMnc8cOOJlOdH2bSD/BMxtFKbYsS1Sd7HtEqC3S', 34),
(457, 'Anggi Candriyana', '0077152859', 'anggi.candriyana@siswa.smkperkasa.sch.id', '$2y$10$Ab6yC1FhvJQPZG7tFcCTXOWRDQ39Jah6ZutFHJtn0duVBTlPnuYcm', 34),
(458, 'Dede Dian', '0077679903', 'dede.dian@siswa.smkperkasa.sch.id', '$2y$10$zWYsar8qeEJKDm9/kBXPQOHa9gMFvnwomoJRjCfPrSZ37Vx7pJz7e', 34),
(459, 'Dedep Restu Fauzi', '0071444597', 'dedep.restu.fauzi@siswa.smkperkasa.sch.id', '$2y$10$9oDjxw.P0epxiDuNkYF..uIMeytZUE14IOmRpbQYuyUp3B.EZquay', 34),
(460, 'Dian Sidik', '0076737837', 'dian.sidik@siswa.smkperkasa.sch.id', '$2y$10$AxeFlAqDIBYQRMx1c11KquEl.FqKywRgrnEuK7rLwp42GnTAw4WeK', 34),
(461, 'Diaz Ega Lesmana', '0081328651', 'diaz.ega.lesmana@siswa.smkperkasa.sch.id', '$2y$10$08LDzZTi1E8dSonry.a7Nu.6m.K7r8Y14uwRSrjKNmRZDWhve9nlG', 34),
(462, 'Diki Ardiansyah', '0078966876', 'diki.ardiansyah@siswa.smkperkasa.sch.id', '$2y$10$LB5YS/jqBv5b./tqHPTxdu4IbPzeB/CvvLGC5rrIpD04Jh/AvtkGK', 34),
(463, 'Dimas Angga Diputra', '0074799766', 'dimas.angga.diputra@siswa.smkperkasa.sch.id', '$2y$10$PSLOexRMq4Wk7uRm5.f.Gep.hB0zuEm6NeFS6FpJ4BVq/bY06zfE6', 34),
(464, 'Dodi Fernadi', '0069119523', 'dodi.fernadi@siswa.smkperkasa.sch.id', '$2y$10$7y6Um3gCQZ8l4zR4zv7/He7yn8fFZCNpLnb2FRJGRVNzUeRvOgwY2', 34),
(465, 'FIRRIZQY AN-NAAS ARSY', '0079603571', 'firrizqy.an.naas.arsy@siswa.smkperkasa.sch.id', '$2y$10$JhzmjMWSlggK97Wxw1zNFum4nfqRj1CRy/lFzYr3nIFmP28Vs.hY.', 34),
(466, 'Hilman Fauzi', '0074845587', 'hilman.fauzi@siswa.smkperkasa.sch.id', '$2y$10$RFAyY3IBzstiW0VWQ5Lhv.i9yU1NlbnwNWv11.QP3SqpjZnT42l.i', 34),
(467, 'Irwansyah', '0081135615', 'irwansyah@siswa.smkperkasa.sch.id', '$2y$10$wNQD.WmgbG6EaDfcjss1pOPsoHHTPUmk/SVLJyXMj.EXVeHMP89mm', 34),
(468, 'MOCH CANDRA HIDAYAT', '0084595472', 'moch.candra.hidayat@siswa.smkperkasa.sch.id', '$2y$10$FicM9552iCPs7JF422P07Ob9dCSbIB4q4at4UDq.FxdLQczRuBQ7.', 34),
(469, 'Muhamad Fauzan Ramadhan', '0072932263', 'muhamad.fauzan.ramadhan@siswa.smkperkasa.sch.id', '$2y$10$igoE8CVp8WvQf.iVVGSe0uo1DTd8BXZeGRCAhVxJDFb6lu9FSXeGq', 34),
(470, 'MUHAMAD ILHAM AGUSTIAN', '0079449638', 'muhamad.ilham.agustian@siswa.smkperkasa.sch.id', '$2y$10$yH2RdombZoA72eibLmtdPuLmqS/RqBHKt6tz3.vBsn4tJg8bSGgmC', 34);
INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `nis`, `email`, `password`, `id_kelas`) VALUES
(471, 'MUHAMAD IRFAN GUNAWAN HILMI', '0085669633', 'muhamad.irfan.gunawan.hilmi@siswa.smkperkasa.sch.id', '$2y$10$ydCHGDGsRPfckwJ5GuUepOK7BiZcQs.8JTqx2Yzem60.0bMM4CwDq', 34),
(472, 'MUHAMAD RIAN APRILIANO', '0077317522', 'muhamad.rian.apriliano@siswa.smkperkasa.sch.id', '$2y$10$mXUjNgTMAKvpbzAPJ0hEueotfqIuiBVReythc3Q2k3i0H.HsiiLSC', 34),
(473, 'Muhamad Rizky Abdul Goni', '0075612772', 'muhamad.rizky.abdul.goni@siswa.smkperkasa.sch.id', '$2y$10$IDBX77j3WIMB0rZPaPRuEuVBVlZ7rtljonZ.iMxVRZNgsdfumaTIa', 34),
(474, 'MUHAMMAD AZIS', '0071578032', 'muhammad.azis@siswa.smkperkasa.sch.id', '$2y$10$BYVLpeOVXiIuZqsQpKFAvOiObWnYXE2NcjZyUn6alLdiT3GPLBuKy', 34),
(475, 'Muhammad Azriel Saomi', '0089875806', 'muhammad.azriel.saomi@siswa.smkperkasa.sch.id', '$2y$10$yDoX.AHkDKx5Rlyc80.dg.Vg6d5gP9vQ2hMlNuP6XnHwsypDlDqfi', 34),
(476, 'Muhammad Haikal Maulana', '0078818143', 'muhammad.haikal.maulana@siswa.smkperkasa.sch.id', '$2y$10$lpxXfc4vhstJvjimHlq/3.j3yZbjU36NQzu4OivUKuc9/3XQeueBm', 34),
(477, 'NENDI SUPRIYADI', '0087115361', 'nendi.supriyadi@siswa.smkperkasa.sch.id', '$2y$10$BVeWnya7uXmMEQLe5A73m.CMJgBihe/CmCcJujrohTvO1n6hg0JAS', 34),
(478, 'PANDU PUTRA SETIAWAN', '0079255730', 'pandu.putra.setiawan@siswa.smkperkasa.sch.id', '$2y$10$4Hiymh4h5obWjyv22khroOcZxBigzBs6tEeQC2CjDLpVou2xTQmcu', 34),
(479, 'RANGGA', '0078032840', 'rangga@siswa.smkperkasa.sch.id', '$2y$10$bnntIbPLR5I7fo04fBNihO43312Flt0Sf0t/jhU9pKxBgt2qF2VDy', 34),
(480, 'Rendi', '0074622832', 'rendi@siswa.smkperkasa.sch.id', '$2y$10$eeFWOcScSR7tjSc5ebuzd.isAVbPtT18EdrH3K04PSg0YtCUghn1y', 34),
(481, 'RISKI ABDUL AZIS', '0087330463', 'riski.abdul.azis@siswa.smkperkasa.sch.id', '$2y$10$dZuraMp8Ek4kcGBlqPTUceoZo28/KxcmrUGvJvCdlqwS2RS8DWD1u', 34),
(482, 'Sandika Wahyu Ramadhan', '0071355557', 'sandika.wahyu.ramadhan@siswa.smkperkasa.sch.id', '$2y$10$VTAdWr83KkIqHeG0yM6Up.vFctb4y9O5s9WYhiX7JyWRCy3mDI3de', 34),
(483, 'Soleh Abdul Rohman', '0071609778', 'soleh.abdul.rohman@siswa.smkperkasa.sch.id', '$2y$10$/T4wfH5evehXBGPc9ixZu.1JN8cvVvUmVCM00CFgHUvYTmWoIlz0u', 34),
(484, 'Syahdan Wildan Sopian', '0088824018', 'syahdan.wildan.sopian@siswa.smkperkasa.sch.id', '$2y$10$8lEOmDMfrRJgG6Wtx1KizeYBukK/h67ZLDkHA9y9wfHdBiZRcqcpC', 34),
(485, 'Yadi Handika', '0083756648', 'yadi.handika@siswa.smkperkasa.sch.id', '$2y$10$lR0WSz3o0SkRNg3aIed9heavxdb0ulyHK6QCmjZpBuNW.kOSN4W6u', 34),
(486, 'ADAM KURNIAWAN', '0061040216', 'adam.kurniawan@siswa.smkperkasa.sch.id', '$2y$10$aZV2f1msJTnyM/DN41NiD.Za86fNyMlL7wahAdbUWiCXFIPPY1aWW', 35),
(487, 'Ari Pratama Putra', '0082463662', 'ari.pratama.putra@siswa.smkperkasa.sch.id', '$2y$10$zCs2QKwhDBMPeLZ790iN4.uE7pOugNHMKA2lmwuTp6Qh1LSsvF7nG', 35),
(488, 'Azka Ubaidillah', '0083438755', 'azka.ubaidillah@siswa.smkperkasa.sch.id', '$2y$10$3RX2EdZnboMOouePxOR78u2.09PQi0T7aBCyn.sYcToWGp7C0pRXm', 35),
(489, 'Dadan', '0064145511', 'dadan@siswa.smkperkasa.sch.id', '$2y$10$Hmc0fO.ii3phcSaItNLOaO9/vN8Ku6MDSJBLYcvE2khFjbh..A9FG', 35),
(490, 'DELA PUSPITA', '0082938796', 'dela.puspita@siswa.smkperkasa.sch.id', '$2y$10$WKHokei0MDOusyVhKMn.3usJGYnk9yhh0kirITA21VvuDW9SDrfFC', 35),
(491, 'Donitata Pradita', '0072975938', 'donitata.pradita@siswa.smkperkasa.sch.id', '$2y$10$RS.nT3R8x7qa4m.8RdDd8.xZLoW3N5WMB1n2.TfaeTxS0rkIQb3HO', 35),
(492, 'Fajar Agustian', '0078631823', 'fajar.agustian@siswa.smkperkasa.sch.id', '$2y$10$CYRWci6YxG9s9ty22Y1ameiSbIS3tt23hLewPLV.LY9dHBvdLGW1W', 35),
(493, 'Fondra', '0074161189', 'fondra@siswa.smkperkasa.sch.id', '$2y$10$yy4mInWy7hlJfnSfueBwfOuvFQB0zeos7LzfkBe9A7ozKjzy9SYIm', 35),
(494, 'GUNA RAGA', '0074308442', 'guna.raga@siswa.smkperkasa.sch.id', '$2y$10$nR5Q4wEkzoRCQ4axCFjPgOiaK6tTmI.dtdmsoqMmcpmLXWQWDML5i', 35),
(495, 'INDRA PRATAMA', '0084771590', 'indra.pratama@siswa.smkperkasa.sch.id', '$2y$10$f9r8.MMDrWWWv20t7HSah.obs/VBXBCEiGdojwcPl6vlfxKHHnLIK', 35),
(496, 'Moh. Sandi', '0081639659', 'moh.sandi@siswa.smkperkasa.sch.id', '$2y$10$TN/Y0tCGexiDQWEjYjWdOenJ7/WY4/TtxD3oipxGczhmtACp8.TCC', 35),
(497, 'Mugia Al Vassa', '0061772031', 'mugia.al.vassa@siswa.smkperkasa.sch.id', '$2y$10$26XJ5pzqz1BnggWFT2C/FOJoYuN.heumjhYznZB9Rtye30PMUbUOi', 35),
(498, 'MUHAMAD ADITIYA MAULANA', '0073696990', 'muhamad.aditiya.maulana@siswa.smkperkasa.sch.id', '$2y$10$kApY.GljJBhNNQtTXvHS3euY2Ild.MZveWsg3gpDSBk5WfAmy8/Hu', 35),
(499, 'MUHAMAD ANGGA', '0076331110', 'muhamad.angga@siswa.smkperkasa.sch.id', '$2y$10$mGSLg7X2mAglYAUba6EVZekmhXJ006U99WzHTdF/dqwSb.lpQF8BO', 35),
(500, 'Muhamad Bima Maulana', '0075112365', 'muhamad.bima.maulana@siswa.smkperkasa.sch.id', '$2y$10$cCTUy/L9UkUPluf4B.cqnOGmCll/aB4hhW1ydgw1p6VnFT62axrEK', 35),
(501, 'Muhammad Rifki Aldiansyah', '0075886938', 'muhammad.rifki.aldiansyah@siswa.smkperkasa.sch.id', '$2y$10$NAyulC9oiVY7cce7Ob/M/eTz/jhnqR3pBRt4n9P9.fE4Psdc6N87i', 35),
(502, 'MUHAMMAD RIZKI DWIANANDA', '0072222081', 'muhammad.rizki.dwiananda@siswa.smkperkasa.sch.id', '$2y$10$Mg/ZpwvADMalGu1xq5Vc3OEsVwPhoL0Jv8Fe9ZT0/EwUXyPj658MS', 35),
(503, 'Oki Fauzi Rahmat', '0079220201', 'oki.fauzi.rahmat@siswa.smkperkasa.sch.id', '$2y$10$OUCSAoP0bI3D2eg0MBAt3.RcbqQoiVRTWEGXSlPqlyHSAwSFYXhja', 35),
(504, 'PAHMI FADILAH', '0072116371', 'pahmi.fadilah@siswa.smkperkasa.sch.id', '$2y$10$PuyXt6FN9DjpaFPhNCb4WOqLqmXQdDK.eCMn4G2h83H0h6SIosDxa', 35),
(505, 'Pasha', '0072386115', 'pasha@siswa.smkperkasa.sch.id', '$2y$10$izlo5zDOovymGSI5neOHVOXoW.JT.aRMyO/BZPd7NjCEwBO9PVlxa', 35),
(506, 'RENDRA MUHAMAD AFDAL', '0071237871', 'rendra.muhamad.afdal@siswa.smkperkasa.sch.id', '$2y$10$TW8dwgpKEhPmkpdrZA5kOeR5rwFyxJK.LMWkf8xEH4NbwAuoFaFxK', 35),
(507, 'Reza Mochamad Rizky', '0079788185', 'reza.mochamad.rizky@siswa.smkperkasa.sch.id', '$2y$10$khjb5tVX12LqUIesFnMA.e1RanpZVb694G2ANPjvZJxNMZrcpc6DG', 35),
(508, 'Riyan Nulhakim', '0082040757', 'riyan.nulhakim@siswa.smkperkasa.sch.id', '$2y$10$/xpIHiOytENAULDu8tGIe.EPFcdBReM9Rg.BjIa.JoOscgsH.qm.O', 35),
(509, 'RIZKI RAMDANI', '3077363403', 'rizki.ramdani1@siswa.smkperkasa.sch.id', '$2y$10$24pe8I2eL7iW67K9zdjm9.T7v.5aQdgHDoZr70f5F295MZepAkXuS', 35),
(510, 'SURYADI RAMDANI HIDAYAT', '0071446733', 'suryadi.ramdani.hidayat@siswa.smkperkasa.sch.id', '$2y$10$GxH08mvmUTUhxPwCI6uXjOJm0o6rotmUdniXQB5bwRzbX7IkNPIL.', 35),
(511, 'YUDA PRATAMA', '0081649649', 'yuda.pratama@siswa.smkperkasa.sch.id', '$2y$10$VHdB53kMp7HBMmISFIBw8eXRKFdFgV3NTZGERX9P0bxRD.UME0NyK', 35),
(512, 'Aditia Ramadani', '0078856656', 'aditia.ramadani@siswa.smkperkasa.sch.id', '$2y$10$/8kvZR9ge9a7uNgA//auI.2hGOPXE/UT/xvX3fxjmv.72EhwVWHly', 36),
(513, 'Ateng Hidayat', '0049054753', 'ateng.hidayat@siswa.smkperkasa.sch.id', '$2y$10$CCLjTpXr8LSEU6cmsk0qc.gjIAE5QoCEasI1AV/J9NwLD9PyYp2Ge', 36),
(514, 'BAGUS ISMAIL SETIAWAN', '0087116771', 'bagus.ismail.setiawan@siswa.smkperkasa.sch.id', '$2y$10$IkkqFriaMcefRUVNNsRXA.X6xxvdzT4WHhtu1VuhAe81DFTHElFXq', 36),
(515, 'CECEP MUHAMMAD ALIF', '3080921342', 'cecep.muhammad.alif@siswa.smkperkasa.sch.id', '$2y$10$ik1IuH/MwZkjzNngz/cWSuMzG1X5/dlP.08SywDTro1qnxhyKWdC.', 36),
(516, 'Dimas Putra Pratama', '0077242679', 'dimas.putra.pratama@siswa.smkperkasa.sch.id', '$2y$10$v74SeH9QWlv8hV2izgPi/OtWJBQSzCEykeBvb0AgBw9puL0P9q2US', 36),
(517, 'DONNY ACHMAD DARAJAT', '0089289597', 'donny.achmad.darajat@siswa.smkperkasa.sch.id', '$2y$10$CDcBpi94kffGZKOWB3w7veGafxJW6ntU1SctVu.VG0y/n5py2USN2', 36),
(518, 'EGI RIYADI', '0075365369', 'egi.riyadi@siswa.smkperkasa.sch.id', '$2y$10$jOaMn194ISYhlW5aMgBwwe5zGRJcVMxrx9HIxVhV0Tv7P/haZQbYu', 36),
(519, 'Fajar Maulana Sidik', '0085179690', 'fajar.maulana.sidik@siswa.smkperkasa.sch.id', '$2y$10$6S6jZ0lxZq/ndKp0puYLXeOS9oDyt2tJnRWz6qTuHZ6QxzTn1Noju', 36),
(520, 'Farid Abdul Karim', '0075701576', 'farid.abdul.karim@siswa.smkperkasa.sch.id', '$2y$10$MpXwR9eQ6sW4aWZOrORQ5.bgTCAWh2plu0XUjWhIrCm662lkc5nra', 36),
(521, 'GANESHA NUR ZACKY RUSTIAWAN', '0089495128', 'ganesha.nur.zacky.rustiawan@siswa.smkperkasa.sch.id', '$2y$10$9i2VN8nL6UEW0KeRMXAEPuvjJ0fyHVMI/Oy2DcHeSdKjUY/PuZBV.', 36),
(522, 'Muhamad Adrian Al Lathif', '0074530575', 'muhamad.adrian.al.lathif@siswa.smkperkasa.sch.id', '$2y$10$Tbr40mzTeQpngD6YZN2R/.P0JeH2HA1HYLUPRYhyaWJ3qfmwfy0Vu', 36),
(523, 'MUHAMAD ALIF RABBANI', '0074222560', 'muhamad.alif.rabbani@siswa.smkperkasa.sch.id', '$2y$10$O.lg8MoUof2/OuWydHK6lOuqk5doX04c8uwiUezZCHSFrpHoo691m', 36),
(524, 'MUHAMAD ARIF', '0071178987', 'muhamad.arif@siswa.smkperkasa.sch.id', '$2y$10$9vyRkOCdqKOLm/E9U2SFT..WuyZCIlFz1Vw719y1OFloJ4xeYhj/.', 36),
(525, 'MUHAMAD ARIFIN PRASETYA', '0093015586', 'muhamad.arifin.prasetya@siswa.smkperkasa.sch.id', '$2y$10$hmdHAuombCQZDlmAQM7.n.PtPXGhopZ3cd9BwMR6fTKEGsk/jfWJO', 36),
(526, 'MUHAMAD TAUFIK HIDAYAT', '0072763128', 'muhamad.taufik.hidayat@siswa.smkperkasa.sch.id', '$2y$10$ASEcA2dZgpjcHMRS8WLyPevVszDSvFOr7ZUzRQOXIdE5Pz7Wx/F6G', 36),
(527, 'Muhammad Rifki Ramdani', '0073548182', 'muhammad.rifki.ramdani@siswa.smkperkasa.sch.id', '$2y$10$JmJXUbQhcQ7iZxWKithx2.jimCNcQrsafPk4W262gX1GgIx3rWC76', 36),
(528, 'RADIT DWI PERMANA', '0064724127', 'radit.dwi.permana@siswa.smkperkasa.sch.id', '$2y$10$oP6Fxi1gzvvhMnJsLADztumaTk4MEDyMv1s8ZPZwgFNkVH4HDGWxa', 36),
(529, 'RAMA HERMALINGGA', '0071363126', 'rama.hermalingga@siswa.smkperkasa.sch.id', '$2y$10$X8pxRzikLrhXuN62r84mReJVWgFQApD6vIy/w.7rj7g9rVloDZwvW', 36),
(530, 'Rian Nugraha', '0069449862', 'rian.nugraha@siswa.smkperkasa.sch.id', '$2y$10$sqOF0.WHB3IQtC099/of3uY1wh343o/Vm/UHYsveYPdEKetUckrk.', 36),
(531, 'Rijal Faisal', '0081559407', 'rijal.faisal@siswa.smkperkasa.sch.id', '$2y$10$AoFA0MksQ0YNrl6ku1J36enNG32fgDswTD3bFZEoRTOPwJNE2jgx.', 36),
(532, 'Rizky Agustian', '0082047654', 'rizky.agustian@siswa.smkperkasa.sch.id', '$2y$10$oY8xl4oEdbWog7v.NhCehOQe9clzD1vB9rpbhCRQvXn.L0G/L7GvK', 36),
(533, 'Rizqi Miftahul Ikhsan', '0071833134', 'rizqi.miftahul.ikhsan@siswa.smkperkasa.sch.id', '$2y$10$Xb5I2ZnWMSuP..xHAll2nOKaH0WwvAQLpnNGgmYKxoOvd0Quio/dW', 36),
(534, 'SURYA ADITIA', '0068352568', 'surya.aditia@siswa.smkperkasa.sch.id', '$2y$10$J7bI5mfZqF3W3TZnit3louHdYYHSyi27lTj2ffl713CnG1STOZgtG', 36),
(535, 'Yana Ramdani', '0089885349', 'yana.ramdani@siswa.smkperkasa.sch.id', '$2y$10$oGRTS6AumhLIrQzBSFiD/eBUlA6D3XJOBz8QnMkx8dMBJGN9DkHuK', 36),
(536, 'Yoga Ramadan', '0061443448', 'yoga.ramadan@siswa.smkperkasa.sch.id', '$2y$10$IYhP2MReX4mgHjcRb4b8uOwEzfso.H0zB5ztYLsMWHXgx9postmBi', 36),
(537, 'Yudha Ihsan Agustiansyah', '0073503668', 'yudha.ihsan.agustiansyah@siswa.smkperkasa.sch.id', '$2y$10$HpBglaJdmnaWljE9EOYzUu8EOY8hh1CZ3FBLHgiKh0RUQWu1.TGTm', 36),
(538, 'ABIL KALAM', '0077768699', 'abil.kalam@siswa.smkperkasa.sch.id', '$2y$10$WXxpPd3ROS01sOQ/8c6Nde7ea/QZhEL1M4dpioStR8yV1eoXtGiAK', 25),
(539, 'ADE RAHMAT', '0088778605', 'ade.rahmat@siswa.smkperkasa.sch.id', '$2y$10$1OpJtkFFJpb7u6rXrKa9kemC4lORgAwGApXJXvEFqY4FJ9S.kftF2', 25),
(540, 'Adi Kurma', '0085080737', 'adi.kurma@siswa.smkperkasa.sch.id', '$2y$10$YC6TWllS.RiOovgsH0iRWeMzFzBzx9r38YOPgLz.C2xyLFrehvWBu', 25),
(541, 'ADITIA RIFQI MAULANA', '0079290037', 'aditia.rifqi.maulana@siswa.smkperkasa.sch.id', '$2y$10$TdotpN58rrGNj5IXHsPKb.fi8kERvxk7sl6M/5YvSEZZFOZP7f8hq', 25),
(542, 'Aditiya Rismana', '0077827732', 'aditiya.rismana@siswa.smkperkasa.sch.id', '$2y$10$dbqyyeFX2Iw8iKKxd3OeqORU/wL6akyULpSt28i2WLvgqNCT.4Hmi', 25),
(543, 'BAYU RAMDANI', '0078928085', 'bayu.ramdani@siswa.smkperkasa.sch.id', '$2y$10$hSq0E9T5.1YNG5s8edwSeevye61b.J3vlo2nFFvBccCeXVKtXGEjK', 25),
(544, 'Coki', '0071749505', 'coki@siswa.smkperkasa.sch.id', '$2y$10$6rzUlGVkrnLecSNf7uHsJurHTFO9pg6Tj3lI.zOxbNlchSX9rHMI6', 25),
(545, 'Eki Nurhakim', '0071609204', 'eki.nurhakim@siswa.smkperkasa.sch.id', '$2y$10$xXrO1xwRISU49Lkujzo5E.9QN0f97EoWDvPR1g9NPrHxY6iMOQE56', 25),
(546, 'FAUZAN ABDURRAFI ALWAFA', '0088944801', 'fauzan.abdurrafi.alwafa@siswa.smkperkasa.sch.id', '$2y$10$3k8bXNyo88Npd0hKrzLJGOFxFSPl2YxJmYjCoZ8fkFurOYszEDPRe', 25),
(547, 'GALANG BUMI RAMADHAN', '0081736969', 'galang.bumi.ramadhan@siswa.smkperkasa.sch.id', '$2y$10$kl1dl/14Ebxi2AAH8HaYLe4URXFnZUHxBIERSL8SHzcsJ48Vw4MsG', 25),
(548, 'Ilham Padilah', '0071637312', 'ilham.padilah@siswa.smkperkasa.sch.id', '$2y$10$BP43Xl55v04Ei5i/9.dPJuz/.MpuWZDfBVCJXkWDyXviQmHevDAkO', 25),
(549, 'KHODIMAN SAIPUDIN', '0078675111', 'khodiman.saipudin@siswa.smkperkasa.sch.id', '$2y$10$ssmVvdXDYQjS5Ic3ze3j2OQ5cKkt5pAsZaYDSVXN9bK5pIPTJnzpC', 25),
(550, 'M. RIJAL', '0084833362', 'm.rijal@siswa.smkperkasa.sch.id', '$2y$10$a5R4BpYmvURCSbD8iKOjFOqSfgfl5KSEXBb/recoNjvLJ7IfxxpES', 25),
(551, 'MOCHAMAD RESA ALPINA', '0073816053', 'mochamad.resa.alpina@siswa.smkperkasa.sch.id', '$2y$10$9VdB6V3pA9XfPEqq3rsii.XmgPeANOhJwGx4/0vxExXiuIL.zx42W', 25),
(552, 'MUCHAMAD RAVI FIRDAUS', '0085384315', 'muchamad.ravi.firdaus@siswa.smkperkasa.sch.id', '$2y$10$QHm88pilIIkbe07/6wN96Oc2pRvyT9y6Jr7RxqejONCgxvKlKkNAK', 25),
(553, 'MUHAMAD DIMAS ADITIYA', '0075008595', 'muhamad.dimas.aditiya@siswa.smkperkasa.sch.id', '$2y$10$rdnPU8wnDfdvidnkPBHosujCNMSwrMzRKT.IvTdvH.PNCnaTxAP5i', 25),
(554, 'MUHAMAD FAISAL RAMDANI', '0074702718', 'muhamad.faisal.ramdani@siswa.smkperkasa.sch.id', '$2y$10$UMYt6xTm3HWNnYYbJNM52OL0/hms1t4s5xZCJ6IHqwprMc7tZSgUy', 25),
(555, 'MUHAMAD IKHSAN', '0065499968', 'muhamad.ikhsan@siswa.smkperkasa.sch.id', '$2y$10$lZwWjyYLreljxmcKk3cBlerNByJ2FNDnnksuyxxDJ/qVhJcu8SYQO', 25),
(556, 'MUHAMAD MULYANA', '0076815516', 'muhamad.mulyana@siswa.smkperkasa.sch.id', '$2y$10$ExmPs9TpcA/l7q5hvSWIReJYSjB/8ZmhDdGoXqUftQlPAciA8peWS', 25),
(557, 'MUHAMMAD RASSYA ALPADLI', '0073793349', 'muhammad.rassya.alpadli@siswa.smkperkasa.sch.id', '$2y$10$bYSyfh/dOcBE/BxozqW2Su1l0lgs5OIyYDUnbnAjcjvdOx3f5muJG', 25),
(558, 'MULKI ABDUL AZIS', '0072114255', 'mulki.abdul.azis@siswa.smkperkasa.sch.id', '$2y$10$cJnVh1.rgobreFy.L9XCCei8Pcma68Za6uhnS85wBazlSfDae0GRG', 25),
(559, 'Pasha Nugraha', '0072814722', 'pasha.nugraha@siswa.smkperkasa.sch.id', '$2y$10$wF3SAb9cPpeaP3B.COJzcuoJ/1jAhQs2jVw4FzCxTpqKaNGr8oTfa', 25),
(560, 'RAMA PEBRIAN HIDAYAT', '0089652167', 'rama.pebrian.hidayat@siswa.smkperkasa.sch.id', '$2y$10$E5JpzhFGH7Sow7yIypqyC.3.9y7T9eY2P1eNW0zW7WCu8JPBJyuTq', 25),
(561, 'RANGGA MULYA SUNARYO', '0068405482', 'rangga.mulya.sunaryo@siswa.smkperkasa.sch.id', '$2y$10$CMU4pC4SB2ezeTDnN4eSpOqPMwKmHIaqe9FtbvqK.AcosDSC1Vb3i', 25),
(562, 'Riski Taufik Kurohman', '0072187687', 'riski.taufik.kurohman@siswa.smkperkasa.sch.id', '$2y$10$zOFqHUY4oYw.bJPKLkEGm./mqU2ieKfif91.IfjlHffAGLLzuLIUq', 25),
(563, 'Rizki Alfauzi', '0077107229', 'rizki.alfauzi@siswa.smkperkasa.sch.id', '$2y$10$ALFfWFDt6pc4R.JA5T92du0hX4aj9IdfTkgnCy6CpsB2z3IHuJEd2', 25),
(564, 'Yadi Taryadi', '0083346379', 'yadi.taryadi@siswa.smkperkasa.sch.id', '$2y$10$pXYIvveLX0KwZZgb3d2B/.cEgzbcTQ1HspE5/c1lhcIzJ4qnvgCeW', 25),
(565, 'Yudi Nugraha', '0071621451', 'yudi.nugraha@siswa.smkperkasa.sch.id', '$2y$10$hjPwtR7CZMEiPG6RJanCOOmypxNz7vM.HYroQDWN6EqAVZxqTcrTG', 25),
(566, 'ADITYA TATANG ROSWENDI', '0073081651', 'aditya.tatang.roswendi@siswa.smkperkasa.sch.id', '$2y$10$0yquC7Kh.cZOcIM1z4d4Z.vnoJoBFUvKCq8teFkTEGInFXeL1IbIW', 26),
(567, 'AFDAL MUHAMAD YUSUP', '0074632273', 'afdal.muhamad.yusup@siswa.smkperkasa.sch.id', '$2y$10$Qzmfq45g/k9zZvsKV.iwA.SMhKI3KAmLZRRxwfRDoAsw7olub86ii', 26),
(568, 'AJI ALBANI', '0083309839', 'aji.albani@siswa.smkperkasa.sch.id', '$2y$10$kViDYC9jdWmgEPMIxktUJuxTMe4A/OyAQEHEf9QMOtFZVN0XBqury', 26),
(569, 'Akbar Rifa\'i', '0087925948', 'akbar.rifa.i@siswa.smkperkasa.sch.id', '$2y$10$rbazyWypxai8vSKb2lVjvuHbb5uL26x343vSilcRja6V3RdO4rlte', 26),
(570, 'ALIF BANGBANG', '0086531808', 'alif.bangbang@siswa.smkperkasa.sch.id', '$2y$10$t6yAd5NMn53F5E3GBXR9N.u2lFSm.RA1TuHTX2nNWb8Ori6iVRebS', 26),
(571, 'Alpin Adriansah', '0077743012', 'alpin.adriansah@siswa.smkperkasa.sch.id', '$2y$10$9zTWOOE3YwD6RLS38X5zPu5Y8M.SGXmgbX.XMyj03yNvfJ1fq/3j.', 26),
(572, 'Deden Hadiningrat', '0072884453', 'deden.hadiningrat@siswa.smkperkasa.sch.id', '$2y$10$xbk4J/veUQHeFkJL4ysrd.Of4PncRzx9v4dEUi9Tq7kKSK9Tz0a5i', 26),
(573, 'ERIK HENDRIAN', '0073069576', 'erik.hendrian@siswa.smkperkasa.sch.id', '$2y$10$UPMYtu9UOQ8z57JxkXns7OfsdR3PxaOqFaUUmTSIzBJG7cojz27ha', 26),
(574, 'Farel Nurhidayat', '0083619893', 'farel.nurhidayat@siswa.smkperkasa.sch.id', '$2y$10$q..gdY/b2aI4cBITgl.8j.6sZhBCLXgDef7cv21dprnnzc1wcTBO.', 26),
(575, 'Fauzan Ilham', '0084682553', 'fauzan.ilham@siswa.smkperkasa.sch.id', '$2y$10$rzYt6JsHlhP4HHMn0WZv3OS1JS.IekeCLPySKAxAMQlOsDXdKquy.', 26),
(576, 'Ilyas Sutisna', '0085933027', 'ilyas.sutisna@siswa.smkperkasa.sch.id', '$2y$10$ZoPL.3h4ZdqzeDhXvV0TgOD6FYSc61zTDdVgVMBEYLlMaFQ6mfC..', 26),
(577, 'Jana', '0073415825', 'jana@siswa.smkperkasa.sch.id', '$2y$10$RdWrdzS6bWwlu74PYNBDP.M0mp4GATSv2OF9C7g7s7Se5O1j7gFcy', 26),
(578, 'M. Arga Irfan Subagja', '0084893833', 'm.arga.irfan.subagja@siswa.smkperkasa.sch.id', '$2y$10$GLygzVIshp1IriNw7kX1TuSrenynrVbHGtblyWCvhB6zBPXzfTvGG', 26),
(579, 'MOHAMAD SAHRUN', '0079735224', 'mohamad.sahrun@siswa.smkperkasa.sch.id', '$2y$10$ZzczKGMPHTgZ/AKESZhNpuI62DaWz6bKC4AFO6WwmEfiysi/GsxgS', 26),
(580, 'MUCHAMAD YUSUF MUHARAM', '0089681288', 'muchamad.yusuf.muharam@siswa.smkperkasa.sch.id', '$2y$10$Vq.I7xqHuquP5vXjfNlhweCjnuJkieYAqcDfebwp/Kow/t4Y2wx2y', 26),
(581, 'MUHAMAD PADIL', '0073822215', 'muhamad.padil@siswa.smkperkasa.sch.id', '$2y$10$jqCQBe5mp4xCVcsNEcZrsOnMN.QrzQEprC73ESKP10SYKOTXcx1n.', 26),
(582, 'Muhamad Putra Almusadad', '0074100574', 'muhamad.putra.almusadad@siswa.smkperkasa.sch.id', '$2y$10$1wBTRRf7qBlnKiveZmKuVekEtb1Y2hxCkDpu2wadVJCeWUsinSmrK', 26),
(583, 'Muhamad Ramdani', '0072606909', 'muhamad.ramdani@siswa.smkperkasa.sch.id', '$2y$10$baBRkMWingI0QWLI3/MK4O8vZW7CHfrXcxImYmdG0yDc5YrC.zmp.', 26),
(584, 'Muhamad Rangga Maulana', '0085519965', 'muhamad.rangga.maulana@siswa.smkperkasa.sch.id', '$2y$10$LM75NEREMrbhRwkwGTn2Ieeq0AiEIPl3Rwl2RNBMPQWX/iPNvduo2', 26),
(585, 'Muhamad Rehan', '0083627409', 'muhamad.rehan@siswa.smkperkasa.sch.id', '$2y$10$EIZvn6ZeWctTOdbyhCDieeB2./8T4tzPwktoF8.Hh2IJqjwhyTbOG', 26),
(586, 'MUHAMMAD NAZRIL RANGGA ARYA', '0084887450', 'muhammad.nazril.rangga.arya@siswa.smkperkasa.sch.id', '$2y$10$cXPq0LX1r20ON5CZzsRKReS3OzF2RxgdWn8V/74MhJMnTbjmGd1.K', 26),
(587, 'Nendi Oktavian Nugraha', '0089451832', 'nendi.oktavian.nugraha@siswa.smkperkasa.sch.id', '$2y$10$sw5HdlRMO5XRLNZOH0lgMeRMeE97op2Xe/ir9tLA9AM2TaQHm8Goe', 26),
(588, 'Reja Adittia', '0082782793', 'reja.adittia@siswa.smkperkasa.sch.id', '$2y$10$ihHZWAPEjJSVYpXlPaNe1.a6YVSH9b0xJguh0P/Yqm4o8NOWchaEq', 26),
(589, 'Restu Apriliawan', '0089693465', 'restu.apriliawan@siswa.smkperkasa.sch.id', '$2y$10$QPEONlMQNQC6gXoCgk9YIuKkukp3qzoxmnV3GQzKB6mYgPIL64ZbS', 26),
(590, 'Rizki Sulaeman Hakim', '0087839570', 'rizki.sulaeman.hakim@siswa.smkperkasa.sch.id', '$2y$10$CWSypWxaYZAUSZ9blVEEVuoY2B1FVIRpTYQGoY0u2itcY4nT25gku', 26),
(591, 'Shandy Khusnul Hakim', '0082708955', 'shandy.khusnul.hakim@siswa.smkperkasa.sch.id', '$2y$10$Ux1AHVSFOHr00KVLwYALyusMQfdMPJgZyFFrJZR7LHj3JLil7t2ua', 26),
(592, 'SYAHRUL JANI', '0089296417', 'syahrul.jani@siswa.smkperkasa.sch.id', '$2y$10$v./OcjOYU2O7XIHy.lrpC.OO.lZuOGE.1gyiJCYqy2OAcViJvf4ra', 26),
(593, 'SYAMSI KURNIAWAN PRATAMA', '0083650593', 'syamsi.kurniawan.pratama@siswa.smkperkasa.sch.id', '$2y$10$UDhJe7T9pAu1HpWuqNN.WOa/oO0H.XRIZkRbKu/a1kk3hELJIFwv6', 26),
(594, 'Wildan Ahmad Pauzi', '0078603457', 'wildan.ahmad.pauzi@siswa.smkperkasa.sch.id', '$2y$10$kovKMI9BUXUJPfKq5MTp2.IuucTez51RVhJrLEY1CgwqlgHPP6DEu', 26),
(595, 'Yusup Lesmana', '0072261229', 'yusup.lesmana@siswa.smkperkasa.sch.id', '$2y$10$e35Tbu0pYwfRK14.pCXPtecDFG1WFEboSYfFMLlq3BiwMXh887/T6', 26),
(596, 'Aditya Karam Dani', '0074505219', 'aditya.karam.dani@siswa.smkperkasa.sch.id', '$2y$10$1kebD./LfozjGWeVHZyKR.xsJNbsUNz8cfDOos2D.C3faKymvK5cu', 27),
(597, 'Ahmad Nur Fadilah', '0069298366', 'ahmad.nur.fadilah@siswa.smkperkasa.sch.id', '$2y$10$7sWDzKX.Fg7oQM0etko1NuiCES/DO6mSCDuzm0MCgJPwHS4p2iUJC', 27),
(598, 'Andika', '0074822407', 'andika@siswa.smkperkasa.sch.id', '$2y$10$C0waQN4QEJovf2M1nt140eDSbbG68dZ.rbuGAzogJJ3kPrrd8eDI2', 27),
(599, 'Aril M.H Pauzi', '0079801687', 'aril.m.h.pauzi@siswa.smkperkasa.sch.id', '$2y$10$36WOjUjfZBIGJE5/jvP7cumGfXmPuohYuO/laoFOEbDv6zKAEAym.', 27),
(600, 'Asep Muhamad Rohmat', '0084137479', 'asep.muhamad.rohmat@siswa.smkperkasa.sch.id', '$2y$10$kH1PtIAeJWSjoC84Pbzdreu.zvyAHzc9xOnU7UvDZPO6hOTF3nus.', 27),
(601, 'Azis Radiansyah', '0072001275', 'azis.radiansyah@siswa.smkperkasa.sch.id', '$2y$10$uBu8XICdoTuqVmUjZZc4BOavrVuFQ5drxYTDx5/Mi5a7K1OvPef0q', 27),
(602, 'Dery Sukma Nur Hidayat', '0087156471', 'dery.sukma.nur.hidayat@siswa.smkperkasa.sch.id', '$2y$10$V0cE6LBuaIJYkn39lMxh3uW4.6K29MVaPqwUJMbcXaU00EUaKHxzO', 27),
(603, 'Didin', '0076612796', 'didin@siswa.smkperkasa.sch.id', '$2y$10$vyPDm0.Rlsw3WvGtfZSOm.YInqy2kJFNaoTdGhbRQQjTxSOgPm5nG', 27),
(604, 'Fadlan Afrilian Permana', '0087768668', 'fadlan.afrilian.permana@siswa.smkperkasa.sch.id', '$2y$10$A3dy2PzT4JCA4qtNuf5.lOGD6RCzZok9F55C8UG7mF9HteQx8OJBi', 27),
(605, 'FURI MAULANA SULAEMAN', '0077521759', 'furi.maulana.sulaeman@siswa.smkperkasa.sch.id', '$2y$10$E0Kx5p8RQq3xqLKwHHciIuLMgBrN9Z26BiwZI0TsnF5FmA0mSHvzi', 27),
(606, 'Helmi Permadi', '0079580632', 'helmi.permadi@siswa.smkperkasa.sch.id', '$2y$10$z2/c7ZlKT6PaOX.EHhRqsuVCT1IPAVhHzoIME0pLyD2GcTowKmJne', 27),
(607, 'Ipan Permana Sidik', '0073833915', 'ipan.permana.sidik@siswa.smkperkasa.sch.id', '$2y$10$taztMEqjULPLJFlX9yspOeYlY6SN9JBTvK1lVvUHjgywZKP35Zm.G', 27),
(608, 'Jepri Maulana', '0083003302', 'jepri.maulana@siswa.smkperkasa.sch.id', '$2y$10$HpSO/izUXKolFPueG83ffeFNgkq0YF8AhKrtXbEYXfMb6hOVizvvq', 27),
(609, 'M. ZAENAL ISMIANA', '0076336758', 'm.zaenal.ismiana@siswa.smkperkasa.sch.id', '$2y$10$YgtZmyZa4xBVL7fdJDJpEe7N/XxAicMdOJOXPjaCmY2TFDWmP.Tt2', 27),
(610, 'MUHAMAD AZRILA SIDIK', '0075433694', 'muhamad.azrila.sidik@siswa.smkperkasa.sch.id', '$2y$10$sjLoD.p59zcWxzB8ORs3WOu.Hc2IlNIX0baxsn6ct0UtGytM8CcEy', 27),
(611, 'MUHAMAD BAYU TRI NUGRAHA', '3084817563', 'muhamad.bayu.tri.nugraha@siswa.smkperkasa.sch.id', '$2y$10$5L1.VUrz1h1iI67lDuifbeEa2oBAY3Iq4D40I621oCgKV2CurWsKe', 27),
(612, 'MUHAMAD RIDWAN', '0072076924', 'muhamad.ridwan1@siswa.smkperkasa.sch.id', '$2y$10$5Exkb2lv3M/P04GsFGVv5u0cIGo7tBsFG5Ey/6e4FZXa4m2gnIxBq', 27),
(613, 'Muhamad Rizal Buhori', '0077634573', 'muhamad.rizal.buhori@siswa.smkperkasa.sch.id', '$2y$10$/GFHqjHzUycKbgKAtgXBT.fKsFpeqtbafVYglMBHy3jCdpbGss6SK', 27),
(614, 'MUHAMMAD FAZRI MAULANA', '0084066756', 'muhammad.fazri.maulana@siswa.smkperkasa.sch.id', '$2y$10$QGryuLRESCAgrZWevfULC.EzShiUJAMyNZBpbmmzJIWAvZXkuMjcG', 27),
(615, 'Nopal', '0084071983', 'nopal1@siswa.smkperkasa.sch.id', '$2y$10$GdBvQA3.rWDJy7BUbFY66uC/m42/axP3I9elTRWQIAJ2vZbR7aHLS', 27),
(616, 'RAFLI ADITIA PERMANA', '0075076722', 'rafli.aditia.permana@siswa.smkperkasa.sch.id', '$2y$10$d7EPacqcwaER229wPSxNduTLvR5vGW3iUsSqjvg939sWqdJipJiIC', 27),
(617, 'Rafli Hidayat', '0062572162', 'rafli.hidayat@siswa.smkperkasa.sch.id', '$2y$10$Stp6LQZtHOOmMlGEHBpGMeUbQf0Zf.N9M2cmxTRBqMRY27gfSJYOq', 27),
(618, 'Riki Hendrawan', '0077455480', 'riki.hendrawan@siswa.smkperkasa.sch.id', '$2y$10$hXTpfAShz4ZPtbRbRuVQ5O4LguRBawA4nBFNVwa5yo.HZmxI/JdNm', 27),
(619, 'Riski Supria', '0073578426', 'riski.supria@siswa.smkperkasa.sch.id', '$2y$10$i9fMMTTNz6CmoXh3NJULrehcb0zd42RbaKsAy6H4NwsP7m8XhirtG', 27),
(620, 'Sahrul Anwar Bokhori', '0088435829', 'sahrul.anwar.bokhori@siswa.smkperkasa.sch.id', '$2y$10$Y/ljhNlWxDgIDTBHnGZ8sOITVAsneLiOBVp4AOFGMyMxx6AZMGiRG', 27),
(621, 'Tedi Apriliansyah', '0081918954', 'tedi.apriliansyah@siswa.smkperkasa.sch.id', '$2y$10$avQMSA67U/S0w0sAS.RE8eoHjt42d0WGXMGkL.N3SB2rBjMQW8pQa', 27),
(622, 'Tegar Kamal Fallahudin', '0073745524', 'tegar.kamal.fallahudin@siswa.smkperkasa.sch.id', '$2y$10$FekSSmLMxxIuDxCkT2hSBen9NreSqZMV5sCmmkdUObFHeOYdF962e', 27),
(623, 'Wildansyah', '0079396359', 'wildansyah@siswa.smkperkasa.sch.id', '$2y$10$xyqkSiONpE12wjLnkd7JOeGam0bhUEOJ6QB0oxO7gZUw0R4SyECO6', 27),
(624, 'Yudi Apriansyah', '0071087968', 'yudi.apriansyah@siswa.smkperkasa.sch.id', '$2y$10$ej.tl7Dg5yyAdKPoMm.nFeyrWkczlCdL95wqGwBQks.ukvhy1rBla', 27);

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
(10, 32, 26),
(11, 27, 32),
(12, 22, 20),
(13, 14, 18),
(14, 29, 10),
(15, 19, 29),
(16, 28, 30),
(17, 15, 27),
(18, 31, 25),
(19, 17, 19),
(20, 52, 12),
(21, 44, 16),
(22, 53, 28),
(23, 45, 17),
(24, 34, 15),
(25, 39, 14),
(26, 8, 22),
(27, 47, 11),
(28, 42, 34),
(29, 35, 13),
(30, 38, 36),
(31, 13, 35),
(32, 30, 31),
(33, 12, 23),
(34, 24, 33);

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
-- Indexes for table `akun_email`
--
ALTER TABLE `akun_email`
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `absensi_detail`
--
ALTER TABLE `absensi_detail`
  MODIFY `id_absensi_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `akun_email`
--
ALTER TABLE `akun_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=533;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `guru_mapel`
--
ALTER TABLE `guru_mapel`
  MODIFY `id_guru_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=625;

--
-- AUTO_INCREMENT for table `wali_kelas`
--
ALTER TABLE `wali_kelas`
  MODIFY `id_wali_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

-- --------------------------------------------------------

--
-- Structure for view `absensi_tidak_sesuai_jadwal`
--
DROP TABLE IF EXISTS `absensi_tidak_sesuai_jadwal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`smkw2994`@`localhost` SQL SECURITY DEFINER VIEW `absensi_tidak_sesuai_jadwal`  AS SELECT `a`.`id_absensi` AS `id_absensi`, `a`.`id_guru_mapel` AS `id_guru_mapel`, `a`.`id_kelas` AS `id_kelas`, `a`.`tanggal` AS `tanggal`, `a`.`status_wali_kelas` AS `status_wali_kelas`, `a`.`tanggal_persetujuan` AS `tanggal_persetujuan`, `a`.`id_wali_kelas` AS `id_wali_kelas`, `g`.`id_guru` AS `id_guru`, `m`.`id_mapel` AS `id_mapel`, `k`.`nama_kelas` AS `nama_kelas` FROM (((((`absensi` `a` join `guru_mapel` `gm` on(`gm`.`id_guru_mapel` = `a`.`id_guru_mapel`)) join `guru` `g` on(`g`.`id_guru` = `gm`.`id_guru`)) join `mata_pelajaran` `m` on(`m`.`id_mapel` = `gm`.`id_mapel`)) join `kelas` `k` on(`k`.`id_kelas` = `gm`.`id_kelas`)) left join `jadwal` `j` on(`j`.`id_guru_mapel` = `gm`.`id_guru_mapel` and `j`.`hari` = dayname(`a`.`tanggal`))) WHERE `j`.`id_jadwal` is null ;

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

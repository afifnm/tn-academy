-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 17, 2025 at 10:06 AM
-- Server version: 8.0.35
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-rapor_sederhana`
--

-- --------------------------------------------------------

--
-- Table structure for table `enroll`
--

CREATE TABLE `enroll` (
  `id_enroll` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_kelas` int NOT NULL,
  `id_ta` int NOT NULL,
  `tanggal_enroll` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('aktif','nonaktif','pindah','lulus') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `enroll_mapel` (
  `id_enroll_mapel` int NOT NULL,
  `id_mapel` int NOT NULL,
  `id_kelas` int NOT NULL,
  `id_ta` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enroll_mapel`
--

-- --------------------------------------------------------
-- Table structure for table `enroll_mapel_komponen`
--

CREATE TABLE `enroll_mapel_komponen` (
  `id_komponen` int NOT NULL,
  `id_enroll_mapel` int NOT NULL,
  `nama_komponen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bobot` decimal(5,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int NOT NULL,
  `nama_guru` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `tingkat` enum('X','XI','XII') NOT NULL,
  `jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas_mapel`
--

CREATE TABLE `kelas_mapel` (
  `id_kelas_mapel` int NOT NULL,
  `id_kelas` int NOT NULL,
  `id_mapel` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int NOT NULL,
  `nama_mapel` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mapel_komponen`
--

CREATE TABLE `mapel_komponen` (
  `id_komponen` int NOT NULL,
  `id_mapel` int NOT NULL,
  `nama_komponen` varchar(100) NOT NULL,
  `bobot` decimal(5,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int NOT NULL,
  `id_enroll` int NOT NULL,
  `id_kelas_mapel` int NOT NULL,
  `id_komponen` int NOT NULL,
  `id_guru` int DEFAULT NULL,
  `skor` decimal(5,2) DEFAULT NULL,
  `tanggal_input` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `thn_masuk` year NOT NULL,
  `status` enum('Aktif','Lulus','Keluar') NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id_ta` int NOT NULL,
  `tahun` varchar(9) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kepala_sekolah') NOT NULL,
  `nama` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

ALTER TABLE `enroll`
  ADD PRIMARY KEY (`id_enroll`),
  ADD UNIQUE KEY `id_siswa` (`id_siswa`,`id_kelas`,`id_ta`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_ta` (`id_ta`);

ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

ALTER TABLE `kelas_mapel`
  ADD PRIMARY KEY (`id_kelas_mapel`),
  ADD UNIQUE KEY `id_kelas` (`id_kelas`,`id_mapel`),
  ADD KEY `id_mapel` (`id_mapel`);

ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

ALTER TABLE `mapel_komponen`
  ADD PRIMARY KEY (`id_komponen`),
  ADD KEY `id_mapel` (`id_mapel`);

ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD UNIQUE KEY `uniq_nilai` (`id_enroll`,`id_kelas_mapel`,`id_komponen`),
  ADD KEY `id_kelas_mapel` (`id_kelas_mapel`),
  ADD KEY `id_komponen` (`id_komponen`),
  ADD KEY `id_guru` (`id_guru`);

ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nisn` (`nisn`);

ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id_ta`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT
--

ALTER TABLE `enroll`
  MODIFY `id_enroll` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `guru`
  MODIFY `id_guru` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `kelas`
  MODIFY `id_kelas` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `kelas_mapel`
  MODIFY `id_kelas_mapel` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `mapel`
  MODIFY `id_mapel` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `mapel_komponen`
  MODIFY `id_komponen` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `nilai`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `tahun_ajaran`
  MODIFY `id_ta` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT;

--
-- Constraints
--

ALTER TABLE `enroll`
  ADD CONSTRAINT `enroll_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_ibfk_3` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajaran` (`id_ta`) ON DELETE CASCADE;

ALTER TABLE `kelas_mapel`
  ADD CONSTRAINT `kelas_mapel_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelas_mapel_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE;

ALTER TABLE `mapel_komponen`
  ADD CONSTRAINT `mapel_komponen_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE;

ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_enroll`) REFERENCES `enroll` (`id_enroll`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`id_kelas_mapel`) REFERENCES `kelas_mapel` (`id_kelas_mapel`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`id_komponen`) REFERENCES `mapel_komponen` (`id_komponen`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_4` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE SET NULL;

--
-- Dummy Data
--

-- tahun ajaran
INSERT INTO tahun_ajaran (tahun, semester) VALUES
('2024/2025', 'Ganjil'),
('2024/2025', 'Genap');

-- kelas
INSERT INTO kelas (nama_kelas, tingkat, jurusan) VALUES
('X RPL 1', 'X', 'Rekayasa Perangkat Lunak'),
('XI RPL 1', 'XI', 'Rekayasa Perangkat Lunak'),
('XII TKJ 1', 'XII', 'Teknik Komputer Jaringan');

-- siswa
INSERT INTO siswa (nisn, nama, tgl_lahir, thn_masuk, status) VALUES
('1234567890', 'Budi Santoso', '2008-01-15', 2023, 'Aktif'),
('1234567891', 'Siti Aminah', '2007-03-22', 2022, 'Aktif'),
('1234567892', 'Andi Wijaya', '2006-07-11', 2021, 'Aktif');

-- guru
INSERT INTO guru (nama_guru) VALUES
('Pak Ahmad'),
('Bu Sari'),
('Pak Joko');

-- mapel
INSERT INTO mapel (nama_mapel) VALUES
('Matematika'),
('Bahasa Indonesia'),
('Pemrograman Web');

-- kelas_mapel
INSERT INTO kelas_mapel (id_kelas, id_mapel) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(3, 3);

-- mapel_komponen
INSERT INTO mapel_komponen (id_mapel, nama_komponen, bobot) VALUES
(1, 'Tugas', 30.00),
(1, 'UTS', 30.00),
(1, 'UAS', 40.00),
(3, 'Proyek', 50.00),
(3, 'Ujian Praktik', 50.00);

-- enroll
INSERT INTO enroll (id_siswa, id_kelas, id_ta, tanggal_enroll, status) VALUES
(1, 1, 1, '2024-07-15 08:00:00', 'aktif'),
(2, 1, 1, '2024-07-15 08:05:00', 'aktif'),
(3, 2, 1, '2024-07-15 08:10:00', 'aktif');

-- nilai
INSERT INTO nilai (id_enroll, id_kelas_mapel, id_komponen, id_guru, skor, tanggal_input) VALUES
(1, 1, 1, 1, 85.00, '2024-08-10 10:00:00'),
(1, 1, 2, 1, 78.00, '2024-09-15 10:30:00'),
(1, 1, 3, 1, 90.00, '2024-11-20 11:00:00'),
(2, 2, 1, 2, 88.00, '2024-08-12 09:00:00'),
(2, 2, 2, 2, 80.00, '2024-09-16 10:00:00'),
(3, 4, 1, 1, 70.00, '2024-08-14 14:00:00');

-- users
INSERT INTO users (username, password, role, nama) VALUES
('admin', MD5('admin123'), 'admin', 'Administrator'),
('kepsek', MD5('kepsek123'), 'kepala_sekolah', 'Kepala Sekolah');

COMMIT;


--siswa
INSERT INTO siswa (nisn, nama, tgl_lahir, thn_masuk, status) VALUES
('20250001', 'Siswa_1', '2009-10-08', 2022, 'Aktif'),
('20250002', 'Siswa_2', '2004-06-17', 2021, 'Lulus'),
('20250003', 'Siswa_3', '2008-04-10', 2024, 'Lulus'),
('20250004', 'Siswa_4', '2006-07-11', 2022, 'Aktif'),
('20250005', 'Siswa_5', '2004-02-07', 2023, 'Aktif'),
('20250006', 'Siswa_6', '2006-07-08', 2019, 'Aktif'),
('20250007', 'Siswa_7', '2005-03-14', 2021, 'Aktif'),
('20250008', 'Siswa_8', '2007-03-11', 2025, 'Aktif'),
('20250009', 'Siswa_9', '2004-11-26', 2023, 'Keluar'),
('20250010', 'Siswa_10', '2004-05-24', 2023, 'Keluar'),
('20250011', 'Siswa_11', '2005-02-12', 2024, 'Lulus'),
('20250012', 'Siswa_12', '2005-09-02', 2025, 'Aktif'),
('20250013', 'Siswa_13', '2004-02-18', 2024, 'Aktif'),
('20250014', 'Siswa_14', '2006-02-28', 2024, 'Lulus'),
('20250015', 'Siswa_15', '2009-09-26', 2025, 'Aktif'),
('20250016', 'Siswa_16', '2007-12-21', 2023, 'Aktif'),
('20250017', 'Siswa_17', '2006-01-19', 2023, 'Lulus'),
('20250018', 'Siswa_18', '2005-09-01', 2021, 'Lulus'),
('20250019', 'Siswa_19', '2010-05-10', 2025, 'Lulus'),
('20250020', 'Siswa_20', '2007-03-25', 2022, 'Aktif'),
('20250021', 'Siswa_21', '2004-12-08', 2020, 'Keluar'),
('20250022', 'Siswa_22', '2007-12-14', 2020, 'Aktif'),
('20250023', 'Siswa_23', '2009-03-18', 2020, 'Lulus'),
('20250024', 'Siswa_24', '2006-05-17', 2024, 'Keluar'),
('20250025', 'Siswa_25', '2005-06-12', 2025, 'Lulus'),
('20250026', 'Siswa_26', '2009-07-17', 2021, 'Keluar'),
('20250027', 'Siswa_27', '2007-12-07', 2020, 'Keluar'),
('20250028', 'Siswa_28', '2007-08-03', 2024, 'Aktif'),
('20250029', 'Siswa_29', '2010-09-23', 2020, 'Aktif'),
('20250030', 'Siswa_30', '2008-03-13', 2023, 'Aktif'),
('20250031', 'Siswa_31', '2009-08-13', 2021, 'Lulus'),
('20250032', 'Siswa_32', '2006-04-29', 2019, 'Aktif'),
('20250033', 'Siswa_33', '2006-04-23', 2020, 'Keluar'),
('20250034', 'Siswa_34', '2008-12-19', 2021, 'Keluar'),
('20250035', 'Siswa_35', '2006-11-14', 2020, 'Aktif'),
('20250036', 'Siswa_36', '2009-06-29', 2021, 'Lulus'),
('20250037', 'Siswa_37', '2006-10-30', 2024, 'Aktif'),
('20250038', 'Siswa_38', '2008-08-01', 2025, 'Lulus'),
('20250039', 'Siswa_39', '2005-06-26', 2021, 'Keluar'),
('20250040', 'Siswa_40', '2005-12-06', 2025, 'Lulus'),
('20250041', 'Siswa_41', '2008-10-29', 2021, 'Lulus'),
('20250042', 'Siswa_42', '2007-05-01', 2025, 'Aktif'),
('20250043', 'Siswa_43', '2005-06-08', 2021, 'Aktif'),
('20250044', 'Siswa_44', '2004-09-08', 2024, 'Lulus'),
('20250045', 'Siswa_45', '2009-09-23', 2021, 'Lulus'),
('20250046', 'Siswa_46', '2007-09-05', 2019, 'Keluar'),
('20250047', 'Siswa_47', '2005-05-16', 2025, 'Keluar'),
('20250048', 'Siswa_48', '2006-08-11', 2022, 'Lulus'),
('20250049', 'Siswa_49', '2010-02-12', 2024, 'Aktif'),
('20250050', 'Siswa_50', '2010-01-19', 2022, 'Lulus'),
('20250051', 'Siswa_51', '2004-07-27', 2022, 'Keluar'),
('20250052', 'Siswa_52', '2009-10-05', 2021, 'Lulus'),
('20250053', 'Siswa_53', '2009-10-25', 2019, 'Keluar'),
('20250054', 'Siswa_54', '2005-01-26', 2025, 'Aktif'),
('20250055', 'Siswa_55', '2007-03-14', 2020, 'Lulus'),
('20250056', 'Siswa_56', '2010-04-27', 2023, 'Keluar'),
('20250057', 'Siswa_57', '2008-04-24', 2023, 'Keluar'),
('20250058', 'Siswa_58', '2007-10-26', 2023, 'Lulus'),
('20250059', 'Siswa_59', '2004-08-05', 2021, 'Aktif'),
('20250060', 'Siswa_60', '2005-03-05', 2022, 'Aktif'),
('20250061', 'Siswa_61', '2009-12-15', 2022, 'Lulus'),
('20250062', 'Siswa_62', '2006-10-28', 2019, 'Aktif'),
('20250063', 'Siswa_63', '2010-09-27', 2021, 'Lulus'),
('20250064', 'Siswa_64', '2007-06-16', 2025, 'Lulus'),
('20250065', 'Siswa_65', '2004-08-15', 2024, 'Keluar'),
('20250066', 'Siswa_66', '2004-04-20', 2021, 'Lulus'),
('20250067', 'Siswa_67', '2005-04-22', 2025, 'Lulus'),
('20250068', 'Siswa_68', '2005-09-20', 2024, 'Aktif'),
('20250069', 'Siswa_69', '2010-05-20', 2025, 'Keluar'),
('20250070', 'Siswa_70', '2010-05-13', 2022, 'Keluar'),
('20250071', 'Siswa_71', '2010-07-15', 2021, 'Lulus'),
('20250072', 'Siswa_72', '2006-08-14', 2023, 'Aktif'),
('20250073', 'Siswa_73', '2004-02-07', 2020, 'Lulus'),
('20250074', 'Siswa_74', '2009-07-11', 2019, 'Lulus'),
('20250075', 'Siswa_75', '2004-01-13', 2021, 'Keluar'),
('20250076', 'Siswa_76', '2008-11-26', 2021, 'Keluar'),
('20250077', 'Siswa_77', '2010-02-27', 2024, 'Lulus'),
('20250078', 'Siswa_78', '2010-08-16', 2020, 'Aktif'),
('20250079', 'Siswa_79', '2006-01-25', 2025, 'Aktif'),
('20250080', 'Siswa_80', '2008-11-20', 2020, 'Aktif'),
('20250081', 'Siswa_81', '2007-08-19', 2019, 'Keluar'),
('20250082', 'Siswa_82', '2010-10-09', 2019, 'Aktif'),
('20250083', 'Siswa_83', '2008-11-12', 2024, 'Aktif'),
('20250084', 'Siswa_84', '2005-12-28', 2023, 'Keluar'),
('20250085', 'Siswa_85', '2007-03-11', 2024, 'Keluar'),
('20250086', 'Siswa_86', '2007-12-08', 2023, 'Lulus'),
('20250087', 'Siswa_87', '2006-09-11', 2021, 'Aktif'),
('20250088', 'Siswa_88', '2004-09-07', 2019, 'Aktif'),
('20250089', 'Siswa_89', '2006-12-23', 2025, 'Lulus'),
('20250090', 'Siswa_90', '2010-05-15', 2021, 'Keluar'),
('20250091', 'Siswa_91', '2007-07-03', 2022, 'Lulus'),
('20250092', 'Siswa_92', '2005-01-10', 2024, 'Aktif'),
('20250093', 'Siswa_93', '2010-06-22', 2020, 'Aktif'),
('20250094', 'Siswa_94', '2004-03-26', 2020, 'Lulus'),
('20250095', 'Siswa_95', '2010-12-13', 2022, 'Keluar'),
('20250096', 'Siswa_96', '2007-08-17', 2024, 'Lulus'),
('20250097', 'Siswa_97', '2006-03-18', 2022, 'Lulus'),
('20250098', 'Siswa_98', '2010-11-29', 2024, 'Keluar'),
('20250099', 'Siswa_99', '2008-03-28', 2020, 'Lulus'),
('20250100', 'Siswa_100', '2006-07-16', 2019, 'Aktif'),
('20250101', 'Siswa_101', '2007-09-27', 2020, 'Aktif'),
('20250102', 'Siswa_102', '2007-12-27', 2024, 'Aktif'),
('20250103', 'Siswa_103', '2004-01-23', 2019, 'Lulus'),
('20250104', 'Siswa_104', '2007-01-06', 2019, 'Keluar'),
('20250105', 'Siswa_105', '2009-10-27', 2019, 'Aktif'),
('20250106', 'Siswa_106', '2010-05-15', 2024, 'Lulus'),
('20250107', 'Siswa_107', '2008-11-15', 2021, 'Lulus'),
('20250108', 'Siswa_108', '2009-05-03', 2022, 'Aktif'),
('20250109', 'Siswa_109', '2007-07-08', 2021, 'Keluar'),
('20250110', 'Siswa_110', '2006-10-26', 2020, 'Lulus'),
('20250111', 'Siswa_111', '2009-11-17', 2023, 'Aktif'),
('20250112', 'Siswa_112', '2010-07-25', 2019, 'Keluar'),
('20250113', 'Siswa_113', '2010-10-06', 2023, 'Lulus'),
('20250114', 'Siswa_114', '2008-11-19', 2024, 'Aktif'),
('20250115', 'Siswa_115', '2004-05-12', 2023, 'Aktif'),
('20250116', 'Siswa_116', '2004-09-12', 2020, 'Aktif'),
('20250117', 'Siswa_117', '2009-11-30', 2025, 'Keluar'),
('20250118', 'Siswa_118', '2005-02-28', 2022, 'Keluar'),
('20250119', 'Siswa_119', '2009-11-07', 2023, 'Aktif'),
('20250120', 'Siswa_120', '2008-08-29', 2023, 'Aktif'),
('20250121', 'Siswa_121', '2009-06-18', 2022, 'Keluar'),
('20250122', 'Siswa_122', '2008-02-05', 2020, 'Lulus'),
('20250123', 'Siswa_123', '2009-07-22', 2019, 'Keluar'),
('20250124', 'Siswa_124', '2010-02-28', 2023, 'Aktif'),
('20250125', 'Siswa_125', '2004-01-01', 2023, 'Aktif'),
('20250126', 'Siswa_126', '2009-11-19', 2025, 'Keluar'),
('20250127', 'Siswa_127', '2007-05-03', 2021, 'Keluar'),
('20250128', 'Siswa_128', '2008-12-17', 2021, 'Lulus'),
('20250129', 'Siswa_129', '2007-05-23', 2024, 'Keluar'),
('20250130', 'Siswa_130', '2008-11-01', 2025, 'Keluar'),
('20250131', 'Siswa_131', '2004-10-14', 2019, 'Keluar'),
('20250132', 'Siswa_132', '2010-01-08', 2020, 'Aktif'),
('20250133', 'Siswa_133', '2004-09-13', 2020, 'Keluar'),
('20250134', 'Siswa_134', '2005-09-08', 2022, 'Keluar'),
('20250135', 'Siswa_135', '2010-07-04', 2022, 'Aktif'),
('20250136', 'Siswa_136', '2010-07-02', 2019, 'Keluar'),
('20250137', 'Siswa_137', '2009-05-12', 2020, 'Keluar'),
('20250138', 'Siswa_138', '2009-12-03', 2021, 'Aktif'),
('20250139', 'Siswa_139', '2007-07-29', 2020, 'Aktif'),
('20250140', 'Siswa_140', '2004-06-29', 2023, 'Aktif'),
('20250141', 'Siswa_141', '2009-02-10', 2024, 'Lulus'),
('20250142', 'Siswa_142', '2005-05-09', 2020, 'Aktif'),
('20250143', 'Siswa_143', '2004-11-08', 2022, 'Lulus'),
('20250144', 'Siswa_144', '2004-12-02', 2023, 'Lulus'),
('20250145', 'Siswa_145', '2007-12-05', 2021, 'Aktif'),
('20250146', 'Siswa_146', '2009-04-27', 2023, 'Aktif'),
('20250147', 'Siswa_147', '2008-10-09', 2023, 'Keluar'),
('20250148', 'Siswa_148', '2009-07-11', 2024, 'Lulus'),
('20250149', 'Siswa_149', '2007-07-17', 2020, 'Aktif'),
('20250150', 'Siswa_150', '2008-01-23', 2020, 'Keluar'),
('20250151', 'Siswa_151', '2004-04-01', 2021, 'Aktif'),
('20250152', 'Siswa_152', '2010-06-30', 2022, 'Aktif'),
('20250153', 'Siswa_153', '2009-02-23', 2022, 'Aktif'),
('20250154', 'Siswa_154', '2004-01-03', 2022, 'Lulus'),
('20250155', 'Siswa_155', '2009-04-16', 2019, 'Keluar'),
('20250156', 'Siswa_156', '2007-02-24', 2024, 'Keluar'),
('20250157', 'Siswa_157', '2005-03-26', 2019, 'Aktif'),
('20250158', 'Siswa_158', '2004-09-08', 2024, 'Keluar'),
('20250159', 'Siswa_159', '2007-02-27', 2019, 'Keluar'),
('20250160', 'Siswa_160', '2007-01-25', 2023, 'Lulus'),
('20250161', 'Siswa_161', '2007-05-08', 2025, 'Lulus'),
('20250162', 'Siswa_162', '2004-09-26', 2023, 'Lulus'),
('20250163', 'Siswa_163', '2009-07-17', 2019, 'Keluar'),
('20250164', 'Siswa_164', '2009-07-27', 2024, 'Lulus'),
('20250165', 'Siswa_165', '2005-02-23', 2021, 'Aktif'),
('20250166', 'Siswa_166', '2010-10-10', 2021, 'Lulus'),
('20250167', 'Siswa_167', '2010-11-28', 2020, 'Aktif'),
('20250168', 'Siswa_168', '2010-03-22', 2022, 'Lulus'),
('20250169', 'Siswa_169', '2004-05-03', 2025, 'Lulus'),
('20250170', 'Siswa_170', '2009-11-20', 2019, 'Lulus'),
('20250171', 'Siswa_171', '2006-02-24', 2024, 'Aktif'),
('20250172', 'Siswa_172', '2010-04-25', 2025, 'Lulus'),
('20250173', 'Siswa_173', '2007-02-18', 2020, 'Aktif'),
('20250174', 'Siswa_174', '2006-10-02', 2025, 'Lulus'),
('20250175', 'Siswa_175', '2007-08-03', 2022, 'Lulus'),
('20250176', 'Siswa_176', '2005-06-19', 2023, 'Aktif'),
('20250177', 'Siswa_177', '2007-08-17', 2021, 'Keluar'),
('20250178', 'Siswa_178', '2005-02-10', 2024, 'Lulus'),
('20250179', 'Siswa_179', '2007-10-07', 2022, 'Lulus'),
('20250180', 'Siswa_180', '2005-01-01', 2019, 'Keluar'),
('20250181', 'Siswa_181', '2008-02-20', 2024, 'Lulus'),
('20250182', 'Siswa_182', '2008-12-14', 2020, 'Lulus'),
('20250183', 'Siswa_183', '2004-07-30', 2019, 'Lulus'),
('20250184', 'Siswa_184', '2007-06-11', 2019, 'Lulus'),
('20250185', 'Siswa_185', '2006-09-14', 2022, 'Aktif'),
('20250186', 'Siswa_186', '2009-02-27', 2025, 'Lulus'),
('20250187', 'Siswa_187', '2007-12-19', 2023, 'Lulus'),
('20250188', 'Siswa_188', '2009-12-12', 2021, 'Lulus'),
('20250189', 'Siswa_189', '2007-07-07', 2020, 'Aktif'),
('20250190', 'Siswa_190', '2004-04-30', 2022, 'Keluar'),
('20250191', 'Siswa_191', '2005-12-27', 2020, 'Lulus'),
('20250192', 'Siswa_192', '2009-01-13', 2024, 'Aktif'),
('20250193', 'Siswa_193', '2010-12-24', 2022, 'Lulus'),
('20250194', 'Siswa_194', '2004-08-23', 2020, 'Lulus'),
('20250195', 'Siswa_195', '2004-03-03', 2024, 'Lulus'),
('20250196', 'Siswa_196', '2010-02-17', 2024, 'Keluar'),
('20250197', 'Siswa_197', '2009-04-18', 2024, 'Keluar'),
('20250198', 'Siswa_198', '2006-04-26', 2019, 'Lulus'),
('20250199', 'Siswa_199', '2004-08-28', 2022, 'Keluar'),
('20250200', 'Siswa_200', '2008-03-10', 2020, 'Lulus'),
('20250201', 'Siswa_201', '2009-04-09', 2022, 'Lulus'),
('20250202', 'Siswa_202', '2007-06-28', 2019, 'Lulus'),
('20250203', 'Siswa_203', '2006-03-03', 2025, 'Lulus'),
('20250204', 'Siswa_204', '2010-11-04', 2020, 'Lulus'),
('20250205', 'Siswa_205', '2005-11-06', 2019, 'Keluar'),
('20250206', 'Siswa_206', '2007-07-01', 2020, 'Lulus'),
('20250207', 'Siswa_207', '2010-07-09', 2024, 'Lulus'),
('20250208', 'Siswa_208', '2005-04-30', 2020, 'Lulus'),
('20250209', 'Siswa_209', '2007-01-24', 2020, 'Keluar'),
('20250210', 'Siswa_210', '2004-10-08', 2020, 'Lulus'),
('20250211', 'Siswa_211', '2010-03-01', 2023, 'Lulus'),
('20250212', 'Siswa_212', '2010-11-14', 2024, 'Aktif'),
('20250213', 'Siswa_213', '2010-01-18', 2025, 'Lulus'),
('20250214', 'Siswa_214', '2006-07-24', 2019, 'Aktif'),
('20250215', 'Siswa_215', '2007-07-26', 2022, 'Keluar'),
('20250216', 'Siswa_216', '2006-01-12', 2024, 'Keluar'),
('20250217', 'Siswa_217', '2007-10-16', 2024, 'Keluar'),
('20250218', 'Siswa_218', '2009-01-07', 2022, 'Lulus'),
('20250219', 'Siswa_219', '2005-05-15', 2023, 'Aktif'),
('20250220', 'Siswa_220', '2004-02-18', 2021, 'Aktif'),
('20250221', 'Siswa_221', '2005-11-23', 2021, 'Lulus'),
('20250222', 'Siswa_222', '2010-02-13', 2022, 'Aktif'),
('20250223', 'Siswa_223', '2005-07-19', 2021, 'Lulus'),
('20250224', 'Siswa_224', '2009-06-13', 2023, 'Keluar'),
('20250225', 'Siswa_225', '2006-05-02', 2022, 'Lulus'),
('20250226', 'Siswa_226', '2007-05-03', 2019, 'Keluar'),
('20250227', 'Siswa_227', '2008-08-16', 2023, 'Keluar'),
('20250228', 'Siswa_228', '2009-07-12', 2019, 'Lulus'),
('20250229', 'Siswa_229', '2004-01-27', 2025, 'Lulus'),
('20250230', 'Siswa_230', '2010-07-03', 2021, 'Lulus'),
('20250231', 'Siswa_231', '2007-04-28', 2022, 'Lulus'),
('20250232', 'Siswa_232', '2008-07-06', 2022, 'Keluar'),
('20250233', 'Siswa_233', '2006-06-10', 2019, 'Lulus'),
('20250234', 'Siswa_234', '2004-07-15', 2023, 'Keluar'),
('20250235', 'Siswa_235', '2007-04-15', 2020, 'Lulus'),
('20250236', 'Siswa_236', '2006-05-18', 2021, 'Keluar'),
('20250237', 'Siswa_237', '2010-10-14', 2025, 'Keluar'),
('20250238', 'Siswa_238', '2007-10-24', 2024, 'Aktif'),
('20250239', 'Siswa_239', '2005-06-04', 2025, 'Aktif'),
('20250240', 'Siswa_240', '2008-06-02', 2020, 'Lulus'),
('20250241', 'Siswa_241', '2008-01-08', 2023, 'Lulus'),
('20250242', 'Siswa_242', '2004-10-29', 2019, 'Aktif'),
('20250243', 'Siswa_243', '2007-07-03', 2025, 'Keluar'),
('20250244', 'Siswa_244', '2006-12-27', 2019, 'Keluar'),
('20250245', 'Siswa_245', '2006-09-16', 2023, 'Aktif'),
('20250246', 'Siswa_246', '2009-12-20', 2023, 'Keluar'),
('20250247', 'Siswa_247', '2007-10-27', 2021, 'Keluar'),
('20250248', 'Siswa_248', '2007-06-15', 2023, 'Lulus'),
('20250249', 'Siswa_249', '2004-09-07', 2020, 'Keluar'),
('20250250', 'Siswa_250', '2004-04-06', 2019, 'Lulus'),
('20250251', 'Siswa_251', '2010-08-18', 2020, 'Keluar'),
('20250252', 'Siswa_252', '2008-05-25', 2025, 'Aktif'),
('20250253', 'Siswa_253', '2006-03-09', 2024, 'Aktif'),
('20250254', 'Siswa_254', '2006-03-20', 2019, 'Aktif'),
('20250255', 'Siswa_255', '2008-05-05', 2023, 'Keluar'),
('20250256', 'Siswa_256', '2010-04-29', 2021, 'Keluar'),
('20250257', 'Siswa_257', '2006-09-20', 2020, 'Aktif'),
('20250258', 'Siswa_258', '2007-12-09', 2020, 'Keluar'),
('20250259', 'Siswa_259', '2008-04-05', 2025, 'Aktif'),
('20250260', 'Siswa_260', '2008-02-05', 2021, 'Lulus'),
('20250261', 'Siswa_261', '2006-07-12', 2025, 'Lulus'),
('20250262', 'Siswa_262', '2004-09-05', 2023, 'Lulus'),
('20250263', 'Siswa_263', '2006-09-13', 2020, 'Keluar'),
('20250264', 'Siswa_264', '2006-06-04', 2022, 'Keluar'),
('20250265', 'Siswa_265', '2008-12-20', 2020, 'Lulus'),
('20250266', 'Siswa_266', '2010-11-20', 2025, 'Lulus'),
('20250267', 'Siswa_267', '2004-12-03', 2022, 'Aktif'),
('20250268', 'Siswa_268', '2006-03-19', 2021, 'Aktif'),
('20250269', 'Siswa_269', '2009-01-26', 2025, 'Aktif'),
('20250270', 'Siswa_270', '2008-08-27', 2019, 'Keluar'),
('20250271', 'Siswa_271', '2010-01-17', 2023, 'Lulus'),
('20250272', 'Siswa_272', '2006-01-12', 2021, 'Lulus'),
('20250273', 'Siswa_273', '2010-07-10', 2024, 'Aktif'),
('20250274', 'Siswa_274', '2006-05-08', 2022, 'Lulus'),
('20250275', 'Siswa_275', '2007-01-10', 2025, 'Keluar'),
('20250276', 'Siswa_276', '2005-04-11', 2022, 'Aktif'),
('20250277', 'Siswa_277', '2006-10-22', 2023, 'Keluar'),
('20250278', 'Siswa_278', '2006-08-07', 2024, 'Aktif'),
('20250279', 'Siswa_279', '2004-12-07', 2023, 'Aktif'),
('20250280', 'Siswa_280', '2004-03-11', 2024, 'Keluar'),
('20250281', 'Siswa_281', '2009-09-25', 2024, 'Lulus'),
('20250282', 'Siswa_282', '2010-10-17', 2022, 'Keluar'),
('20250283', 'Siswa_283', '2010-09-24', 2024, 'Keluar'),
('20250284', 'Siswa_284', '2008-05-10', 2024, 'Aktif'),
('20250285', 'Siswa_285', '2007-05-29', 2020, 'Lulus'),
('20250286', 'Siswa_286', '2008-05-16', 2024, 'Aktif'),
('20250287', 'Siswa_287', '2007-04-17', 2024, 'Aktif'),
('20250288', 'Siswa_288', '2007-01-01', 2023, 'Keluar'),
('20250289', 'Siswa_289', '2006-08-24', 2020, 'Keluar'),
('20250290', 'Siswa_290', '2010-02-21', 2022, 'Aktif'),
('20250291', 'Siswa_291', '2007-06-09', 2020, 'Keluar'),
('20250292', 'Siswa_292', '2004-04-29', 2019, 'Lulus'),
('20250293', 'Siswa_293', '2004-11-22', 2023, 'Aktif'),
('20250294', 'Siswa_294', '2008-08-27', 2021, 'Lulus'),
('20250295', 'Siswa_295', '2007-08-06', 2019, 'Keluar'),
('20250296', 'Siswa_296', '2008-03-02', 2020, 'Keluar'),
('20250297', 'Siswa_297', '2009-03-04', 2019, 'Aktif'),
('20250298', 'Siswa_298', '2010-04-17', 2023, 'Lulus'),
('20250299', 'Siswa_299', '2008-06-24', 2020, 'Aktif'),
('20250300', 'Siswa_300', '2006-02-19', 2019, 'Lulus'),
('20250301', 'Siswa_301', '2007-07-03', 2021, 'Lulus'),
('20250302', 'Siswa_302', '2010-04-02', 2023, 'Aktif'),
('20250303', 'Siswa_303', '2004-01-15', 2020, 'Lulus'),
('20250304', 'Siswa_304', '2005-08-11', 2025, 'Aktif'),
('20250305', 'Siswa_305', '2006-02-09', 2019, 'Aktif'),
('20250306', 'Siswa_306', '2010-07-02', 2024, 'Keluar'),
('20250307', 'Siswa_307', '2007-01-04', 2024, 'Lulus'),
('20250308', 'Siswa_308', '2004-12-08', 2024, 'Keluar'),
('20250309', 'Siswa_309', '2006-04-04', 2019, 'Keluar'),
('20250310', 'Siswa_310', '2007-03-29', 2020, 'Aktif'),
('20250311', 'Siswa_311', '2010-12-05', 2020, 'Lulus'),
('20250312', 'Siswa_312', '2010-06-02', 2022, 'Lulus'),
('20250313', 'Siswa_313', '2004-11-25', 2019, 'Aktif'),
('20250314', 'Siswa_314', '2009-05-07', 2020, 'Keluar'),
('20250315', 'Siswa_315', '2009-12-03', 2020, 'Keluar'),
('20250316', 'Siswa_316', '2004-09-12', 2020, 'Keluar'),
('20250317', 'Siswa_317', '2004-04-30', 2019, 'Aktif'),
('20250318', 'Siswa_318', '2005-08-29', 2020, 'Lulus'),
('20250319', 'Siswa_319', '2005-09-21', 2020, 'Lulus'),
('20250320', 'Siswa_320', '2006-06-08', 2024, 'Lulus'),
('20250321', 'Siswa_321', '2009-03-21', 2023, 'Keluar'),
('20250322', 'Siswa_322', '2005-11-18', 2024, 'Keluar'),
('20250323', 'Siswa_323', '2005-03-11', 2023, 'Lulus'),
('20250324', 'Siswa_324', '2004-04-20', 2022, 'Keluar'),
('20250325', 'Siswa_325', '2005-04-18', 2020, 'Keluar'),
('20250326', 'Siswa_326', '2009-05-05', 2024, 'Lulus'),
('20250327', 'Siswa_327', '2007-07-29', 2024, 'Aktif'),
('20250328', 'Siswa_328', '2007-11-17', 2019, 'Lulus'),
('20250329', 'Siswa_329', '2008-02-29', 2024, 'Lulus'),
('20250330', 'Siswa_330', '2006-07-03', 2025, 'Lulus'),
('20250331', 'Siswa_331', '2009-07-15', 2022, 'Keluar'),
('20250332', 'Siswa_332', '2004-01-31', 2022, 'Aktif'),
('20250333', 'Siswa_333', '2004-08-28', 2020, 'Lulus'),
('20250334', 'Siswa_334', '2009-09-28', 2022, 'Aktif'),
('20250335', 'Siswa_335', '2005-11-21', 2022, 'Keluar'),
('20250336', 'Siswa_336', '2005-02-12', 2020, 'Keluar'),
('20250337', 'Siswa_337', '2005-05-19', 2021, 'Aktif'),
('20250338', 'Siswa_338', '2004-04-30', 2024, 'Aktif'),
('20250339', 'Siswa_339', '2008-10-16', 2022, 'Keluar'),
('20250340', 'Siswa_340', '2005-03-14', 2019, 'Keluar'),
('20250341', 'Siswa_341', '2010-07-25', 2024, 'Aktif'),
('20250342', 'Siswa_342', '2009-07-08', 2025, 'Keluar'),
('20250343', 'Siswa_343', '2005-04-23', 2021, 'Keluar'),
('20250344', 'Siswa_344', '2010-06-20', 2021, 'Lulus'),
('20250345', 'Siswa_345', '2007-08-26', 2021, 'Lulus'),
('20250346', 'Siswa_346', '2010-09-15', 2022, 'Lulus'),
('20250347', 'Siswa_347', '2009-09-08', 2025, 'Lulus'),
('20250348', 'Siswa_348', '2009-07-27', 2020, 'Aktif'),
('20250349', 'Siswa_349', '2006-09-11', 2020, 'Aktif'),
('20250350', 'Siswa_350', '2004-12-30', 2020, 'Lulus'),
('20250351', 'Siswa_351', '2008-07-08', 2022, 'Lulus'),
('20250352', 'Siswa_352', '2010-11-16', 2020, 'Keluar'),
('20250353', 'Siswa_353', '2007-03-02', 2025, 'Aktif'),
('20250354', 'Siswa_354', '2006-04-12', 2020, 'Aktif'),
('20250355', 'Siswa_355', '2010-09-21', 2021, 'Aktif'),
('20250356', 'Siswa_356', '2009-12-19', 2019, 'Keluar'),
('20250357', 'Siswa_357', '2005-11-18', 2021, 'Aktif'),
('20250358', 'Siswa_358', '2010-02-07', 2023, 'Lulus'),
('20250359', 'Siswa_359', '2008-07-16', 2024, 'Lulus'),
('20250360', 'Siswa_360', '2006-05-07', 2022, 'Lulus'),
('20250361', 'Siswa_361', '2005-07-28', 2019, 'Lulus'),
('20250362', 'Siswa_362', '2005-05-17', 2024, 'Keluar'),
('20250363', 'Siswa_363', '2008-09-26', 2019, 'Aktif'),
('20250364', 'Siswa_364', '2010-07-10', 2021, 'Aktif'),
('20250365', 'Siswa_365', '2006-05-29', 2019, 'Keluar'),
('20250366', 'Siswa_366', '2009-08-13', 2025, 'Aktif'),
('20250367', 'Siswa_367', '2007-08-31', 2025, 'Keluar'),
('20250368', 'Siswa_368', '2006-04-06', 2023, 'Aktif'),
('20250369', 'Siswa_369', '2009-02-26', 2022, 'Lulus'),
('20250370', 'Siswa_370', '2007-09-10', 2020, 'Keluar'),
('20250371', 'Siswa_371', '2008-01-23', 2020, 'Keluar'),
('20250372', 'Siswa_372', '2006-02-08', 2020, 'Keluar'),
('20250373', 'Siswa_373', '2007-05-05', 2024, 'Lulus'),
('20250374', 'Siswa_374', '2008-02-18', 2023, 'Aktif'),
('20250375', 'Siswa_375', '2004-07-21', 2020, 'Keluar'),
('20250376', 'Siswa_376', '2009-12-18', 2022, 'Lulus'),
('20250377', 'Siswa_377', '2009-11-05', 2025, 'Aktif'),
('20250378', 'Siswa_378', '2004-10-21', 2019, 'Keluar'),
('20250379', 'Siswa_379', '2004-12-31', 2020, 'Lulus'),
('20250380', 'Siswa_380', '2004-06-28', 2025, 'Lulus'),
('20250381', 'Siswa_381', '2004-09-02', 2023, 'Lulus'),
('20250382', 'Siswa_382', '2007-10-05', 2019, 'Keluar'),
('20250383', 'Siswa_383', '2009-12-11', 2022, 'Lulus'),
('20250384', 'Siswa_384', '2007-09-29', 2021, 'Keluar'),
('20250385', 'Siswa_385', '2004-03-11', 2024, 'Keluar'),
('20250386', 'Siswa_386', '2008-10-18', 2023, 'Keluar'),
('20250387', 'Siswa_387', '2004-11-13', 2020, 'Lulus'),
('20250388', 'Siswa_388', '2005-01-01', 2019, 'Keluar'),
('20250389', 'Siswa_389', '2007-04-28', 2022, 'Aktif'),
('20250390', 'Siswa_390', '2007-03-18', 2019, 'Lulus'),
('20250391', 'Siswa_391', '2009-04-02', 2024, 'Aktif'),
('20250392', 'Siswa_392', '2007-12-17', 2020, 'Keluar'),
('20250393', 'Siswa_393', '2009-04-11', 2021, 'Keluar'),
('20250394', 'Siswa_394', '2006-07-14', 2023, 'Keluar'),
('20250395', 'Siswa_395', '2008-03-24', 2023, 'Lulus'),
('20250396', 'Siswa_396', '2004-11-04', 2022, 'Keluar'),
('20250397', 'Siswa_397', '2006-03-08', 2020, 'Aktif'),
('20250398', 'Siswa_398', '2009-08-05', 2020, 'Aktif'),
('20250399', 'Siswa_399', '2004-10-30', 2020, 'Lulus'),
('20250400', 'Siswa_400', '2006-10-19', 2024, 'Aktif'),
('20250401', 'Siswa_401', '2004-12-13', 2025, 'Lulus'),
('20250402', 'Siswa_402', '2008-08-16', 2022, 'Keluar'),
('20250403', 'Siswa_403', '2010-09-19', 2021, 'Aktif'),
('20250404', 'Siswa_404', '2004-07-07', 2020, 'Aktif'),
('20250405', 'Siswa_405', '2010-01-03', 2020, 'Keluar'),
('20250406', 'Siswa_406', '2009-09-05', 2020, 'Keluar'),
('20250407', 'Siswa_407', '2006-02-19', 2021, 'Aktif'),
('20250408', 'Siswa_408', '2009-07-29', 2020, 'Lulus'),
('20250409', 'Siswa_409', '2008-11-29', 2023, 'Keluar'),
('20250410', 'Siswa_410', '2004-07-14', 2020, 'Keluar'),
('20250411', 'Siswa_411', '2010-11-21', 2019, 'Lulus'),
('20250412', 'Siswa_412', '2009-07-02', 2025, 'Lulus'),
('20250413', 'Siswa_413', '2005-05-27', 2024, 'Lulus'),
('20250414', 'Siswa_414', '2006-10-09', 2023, 'Keluar'),
('20250415', 'Siswa_415', '2007-09-04', 2025, 'Aktif'),
('20250416', 'Siswa_416', '2006-04-10', 2022, 'Lulus'),
('20250417', 'Siswa_417', '2008-11-17', 2019, 'Lulus'),
('20250418', 'Siswa_418', '2009-04-07', 2024, 'Keluar'),
('20250419', 'Siswa_419', '2008-05-18', 2022, 'Keluar'),
('20250420', 'Siswa_420', '2004-02-02', 2020, 'Lulus'),
('20250421', 'Siswa_421', '2007-03-17', 2024, 'Aktif'),
('20250422', 'Siswa_422', '2007-06-13', 2023, 'Keluar'),
('20250423', 'Siswa_423', '2004-04-12', 2020, 'Lulus'),
('20250424', 'Siswa_424', '2005-04-22', 2022, 'Keluar'),
('20250425', 'Siswa_425', '2005-05-24', 2022, 'Keluar'),
('20250426', 'Siswa_426', '2007-06-03', 2020, 'Aktif'),
('20250427', 'Siswa_427', '2009-07-29', 2024, 'Lulus'),
('20250428', 'Siswa_428', '2008-02-06', 2021, 'Aktif'),
('20250429', 'Siswa_429', '2008-11-12', 2023, 'Aktif'),
('20250430', 'Siswa_430', '2005-09-19', 2019, 'Keluar'),
('20250431', 'Siswa_431', '2004-02-22', 2019, 'Lulus'),
('20250432', 'Siswa_432', '2005-11-23', 2021, 'Keluar'),
('20250433', 'Siswa_433', '2005-01-15', 2020, 'Aktif'),
('20250434', 'Siswa_434', '2004-02-02', 2024, 'Keluar'),
('20250435', 'Siswa_435', '2005-05-11', 2022, 'Aktif'),
('20250436', 'Siswa_436', '2008-01-15', 2020, 'Lulus'),
('20250437', 'Siswa_437', '2008-12-15', 2020, 'Aktif'),
('20250438', 'Siswa_438', '2008-10-06', 2019, 'Lulus'),
('20250439', 'Siswa_439', '2004-04-20', 2022, 'Lulus'),
('20250440', 'Siswa_440', '2009-03-21', 2022, 'Aktif'),
('20250441', 'Siswa_441', '2010-03-10', 2021, 'Lulus'),
('20250442', 'Siswa_442', '2004-07-06', 2023, 'Lulus'),
('20250443', 'Siswa_443', '2004-11-06', 2021, 'Lulus'),
('20250444', 'Siswa_444', '2008-05-09', 2019, 'Lulus'),
('20250445', 'Siswa_445', '2006-10-26', 2020, 'Keluar'),
('20250446', 'Siswa_446', '2010-05-25', 2021, 'Keluar'),
('20250447', 'Siswa_447', '2006-05-26', 2022, 'Keluar'),
('20250448', 'Siswa_448', '2006-08-17', 2020, 'Keluar'),
('20250449', 'Siswa_449', '2009-10-01', 2023, 'Lulus'),
('20250450', 'Siswa_450', '2009-11-08', 2021, 'Aktif'),
('20250451', 'Siswa_451', '2004-03-10', 2020, 'Aktif'),
('20250452', 'Siswa_452', '2010-01-21', 2020, 'Keluar'),
('20250453', 'Siswa_453', '2004-08-07', 2020, 'Keluar'),
('20250454', 'Siswa_454', '2004-05-02', 2025, 'Aktif'),
('20250455', 'Siswa_455', '2010-01-10', 2023, 'Keluar'),
('20250456', 'Siswa_456', '2006-06-25', 2019, 'Aktif'),
('20250457', 'Siswa_457', '2006-02-16', 2023, 'Lulus'),
('20250458', 'Siswa_458', '2006-05-05', 2024, 'Lulus'),
('20250459', 'Siswa_459', '2006-03-14', 2022, 'Keluar'),
('20250460', 'Siswa_460', '2005-10-26', 2025, 'Keluar'),
('20250461', 'Siswa_461', '2004-04-04', 2023, 'Aktif'),
('20250462', 'Siswa_462', '2007-07-11', 2020, 'Aktif'),
('20250463', 'Siswa_463', '2008-03-10', 2019, 'Lulus'),
('20250464', 'Siswa_464', '2009-02-20', 2021, 'Aktif'),
('20250465', 'Siswa_465', '2006-12-29', 2021, 'Aktif'),
('20250466', 'Siswa_466', '2008-04-27', 2023, 'Aktif'),
('20250467', 'Siswa_467', '2004-01-24', 2025, 'Keluar'),
('20250468', 'Siswa_468', '2009-09-21', 2024, 'Aktif'),
('20250469', 'Siswa_469', '2009-07-28', 2019, 'Keluar'),
('20250470', 'Siswa_470', '2004-06-20', 2023, 'Keluar'),
('20250471', 'Siswa_471', '2008-07-20', 2021, 'Lulus'),
('20250472', 'Siswa_472', '2008-12-04', 2022, 'Keluar'),
('20250473', 'Siswa_473', '2005-01-22', 2019, 'Lulus'),
('20250474', 'Siswa_474', '2005-08-08', 2020, 'Lulus'),
('20250475', 'Siswa_475', '2008-01-15', 2020, 'Aktif'),
('20250476', 'Siswa_476', '2010-06-22', 2022, 'Aktif'),
('20250477', 'Siswa_477', '2008-12-15', 2020, 'Aktif'),
('20250478', 'Siswa_478', '2008-08-25', 2020, 'Lulus'),
('20250479', 'Siswa_479', '2005-01-22', 2023, 'Aktif'),
('20250480', 'Siswa_480', '2009-03-09', 2022, 'Lulus'),
('20250481', 'Siswa_481', '2004-04-07', 2023, 'Lulus'),
('20250482', 'Siswa_482', '2010-03-04', 2024, 'Aktif'),
('20250483', 'Siswa_483', '2005-10-16', 2019, 'Lulus'),
('20250484', 'Siswa_484', '2005-01-30', 2019, 'Keluar'),
('20250485', 'Siswa_485', '2008-10-11', 2021, 'Aktif'),
('20250486', 'Siswa_486', '2010-10-18', 2025, 'Lulus'),
('20250487', 'Siswa_487', '2005-10-07', 2020, 'Lulus'),
('20250488', 'Siswa_488', '2010-03-24', 2020, 'Keluar'),
('20250489', 'Siswa_489', '2006-12-25', 2025, 'Lulus'),
('20250490', 'Siswa_490', '2009-02-13', 2022, 'Keluar'),
('20250491', 'Siswa_491', '2009-05-18', 2021, 'Aktif'),
('20250492', 'Siswa_492', '2005-05-05', 2021, 'Keluar'),
('20250493', 'Siswa_493', '2009-03-06', 2020, 'Aktif'),
('20250494', 'Siswa_494', '2005-02-08', 2019, 'Keluar'),
('20250495', 'Siswa_495', '2005-11-10', 2025, 'Aktif'),
('20250496', 'Siswa_496', '2006-06-28', 2020, 'Keluar'),
('20250497', 'Siswa_497', '2006-07-28', 2024, 'Lulus'),
('20250498', 'Siswa_498', '2005-04-26', 2024, 'Lulus'),
('20250499', 'Siswa_499', '2005-09-11', 2023, 'Lulus'),
('20250500', 'Siswa_500', '2009-12-25', 2022, 'Keluar'),
('20250501', 'Siswa_501', '2004-03-02', 2023, 'Lulus'),
('20250502', 'Siswa_502', '2005-05-19', 2022, 'Aktif'),
('20250503', 'Siswa_503', '2007-04-15', 2022, 'Lulus'),
('20250504', 'Siswa_504', '2005-01-08', 2019, 'Aktif'),
('20250505', 'Siswa_505', '2004-04-05', 2020, 'Keluar'),
('20250506', 'Siswa_506', '2008-03-10', 2024, 'Lulus'),
('20250507', 'Siswa_507', '2010-08-01', 2025, 'Lulus'),
('20250508', 'Siswa_508', '2007-07-29', 2022, 'Lulus'),
('20250509', 'Siswa_509', '2010-09-21', 2025, 'Lulus'),
('20250510', 'Siswa_510', '2004-12-08', 2022, 'Lulus'),
('20250511', 'Siswa_511', '2009-08-13', 2022, 'Aktif'),
('20250512', 'Siswa_512', '2010-04-19', 2020, 'Aktif'),
('20250513', 'Siswa_513', '2006-10-19', 2021, 'Lulus'),
('20250514', 'Siswa_514', '2004-05-19', 2020, 'Keluar'),
('20250515', 'Siswa_515', '2005-10-23', 2023, 'Aktif'),
('20250516', 'Siswa_516', '2010-08-06', 2019, 'Aktif'),
('20250517', 'Siswa_517', '2007-12-31', 2023, 'Lulus'),
('20250518', 'Siswa_518', '2007-08-31', 2024, 'Lulus'),
('20250519', 'Siswa_519', '2006-06-28', 2019, 'Keluar'),
('20250520', 'Siswa_520', '2005-04-02', 2020, 'Aktif'),
('20250521', 'Siswa_521', '2008-12-28', 2025, 'Aktif'),
('20250522', 'Siswa_522', '2007-11-09', 2023, 'Keluar'),
('20250523', 'Siswa_523', '2009-03-06', 2021, 'Keluar'),
('20250524', 'Siswa_524', '2007-12-31', 2020, 'Aktif'),
('20250525', 'Siswa_525', '2009-08-01', 2022, 'Lulus'),
('20250526', 'Siswa_526', '2009-05-06', 2019, 'Lulus'),
('20250527', 'Siswa_527', '2007-11-26', 2021, 'Lulus'),
('20250528', 'Siswa_528', '2009-12-19', 2022, 'Keluar'),
('20250529', 'Siswa_529', '2006-03-21', 2024, 'Keluar'),
('20250530', 'Siswa_530', '2006-08-02', 2022, 'Lulus'),
('20250531', 'Siswa_531', '2006-01-10', 2023, 'Aktif'),
('20250532', 'Siswa_532', '2004-08-06', 2021, 'Aktif'),
('20250533', 'Siswa_533', '2007-04-09', 2023, 'Lulus'),
('20250534', 'Siswa_534', '2007-05-25', 2025, 'Lulus'),
('20250535', 'Siswa_535', '2004-02-17', 2022, 'Lulus'),
('20250536', 'Siswa_536', '2007-12-26', 2020, 'Lulus'),
('20250537', 'Siswa_537', '2008-06-05', 2022, 'Keluar'),
('20250538', 'Siswa_538', '2004-07-20', 2023, 'Aktif'),
('20250539', 'Siswa_539', '2009-07-20', 2025, 'Aktif'),
('20250540', 'Siswa_540', '2007-05-24', 2024, 'Keluar'),
('20250541', 'Siswa_541', '2007-04-03', 2024, 'Lulus'),
('20250542', 'Siswa_542', '2010-05-14', 2022, 'Aktif'),
('20250543', 'Siswa_543', '2006-10-18', 2023, 'Keluar'),
('20250544', 'Siswa_544', '2006-06-09', 2020, 'Keluar'),
('20250545', 'Siswa_545', '2007-03-30', 2022, 'Lulus'),
('20250546', 'Siswa_546', '2010-08-28', 2022, 'Aktif'),
('20250547', 'Siswa_547', '2009-10-04', 2019, 'Keluar'),
('20250548', 'Siswa_548', '2005-03-06', 2023, 'Aktif'),
('20250549', 'Siswa_549', '2006-01-10', 2019, 'Keluar'),
('20250550', 'Siswa_550', '2007-10-16', 2020, 'Aktif'),
('20250551', 'Siswa_551', '2005-08-11', 2020, 'Aktif'),
('20250552', 'Siswa_552', '2005-05-16', 2019, 'Lulus'),
('20250553', 'Siswa_553', '2006-04-21', 2025, 'Keluar'),
('20250554', 'Siswa_554', '2007-10-30', 2024, 'Aktif'),
('20250555', 'Siswa_555', '2004-04-08', 2023, 'Aktif'),
('20250556', 'Siswa_556', '2009-07-06', 2025, 'Aktif'),
('20250557', 'Siswa_557', '2010-04-27', 2024, 'Lulus'),
('20250558', 'Siswa_558', '2010-07-29', 2023, 'Aktif'),
('20250559', 'Siswa_559', '2008-09-08', 2022, 'Lulus'),
('20250560', 'Siswa_560', '2010-12-14', 2021, 'Lulus'),
('20250561', 'Siswa_561', '2007-03-15', 2020, 'Aktif'),
('20250562', 'Siswa_562', '2010-12-12', 2019, 'Lulus'),
('20250563', 'Siswa_563', '2010-03-18', 2023, 'Lulus'),
('20250564', 'Siswa_564', '2010-04-24', 2025, 'Aktif'),
('20250565', 'Siswa_565', '2007-04-11', 2019, 'Aktif'),
('20250566', 'Siswa_566', '2004-12-01', 2019, 'Keluar'),
('20250567', 'Siswa_567', '2005-12-22', 2022, 'Keluar'),
('20250568', 'Siswa_568', '2008-06-22', 2022, 'Aktif'),
('20250569', 'Siswa_569', '2004-04-08', 2024, 'Lulus'),
('20250570', 'Siswa_570', '2006-04-01', 2022, 'Keluar'),
('20250571', 'Siswa_571', '2008-11-04', 2020, 'Keluar'),
('20250572', 'Siswa_572', '2007-09-29', 2023, 'Keluar'),
('20250573', 'Siswa_573', '2005-02-01', 2022, 'Keluar'),
('20250574', 'Siswa_574', '2008-12-11', 2019, 'Lulus'),
('20250575', 'Siswa_575', '2004-07-13', 2023, 'Aktif'),
('20250576', 'Siswa_576', '2010-10-08', 2025, 'Lulus'),
('20250577', 'Siswa_577', '2007-12-11', 2020, 'Keluar'),
('20250578', 'Siswa_578', '2007-11-24', 2022, 'Keluar'),
('20250579', 'Siswa_579', '2009-01-09', 2024, 'Lulus'),
('20250580', 'Siswa_580', '2004-08-14', 2021, 'Keluar'),
('20250581', 'Siswa_581', '2010-07-25', 2022, 'Aktif'),
('20250582', 'Siswa_582', '2009-10-31', 2019, 'Keluar'),
('20250583', 'Siswa_583', '2007-07-10', 2024, 'Aktif'),
('20250584', 'Siswa_584', '2007-10-24', 2019, 'Keluar'),
('20250585', 'Siswa_585', '2006-03-04', 2019, 'Keluar'),
('20250586', 'Siswa_586', '2010-06-22', 2025, 'Keluar'),
('20250587', 'Siswa_587', '2007-08-26', 2020, 'Keluar'),
('20250588', 'Siswa_588', '2004-11-13', 2024, 'Aktif'),
('20250589', 'Siswa_589', '2008-04-12', 2024, 'Lulus'),
('20250590', 'Siswa_590', '2009-03-27', 2019, 'Keluar'),
('20250591', 'Siswa_591', '2004-01-02', 2024, 'Aktif'),
('20250592', 'Siswa_592', '2005-04-21', 2022, 'Keluar'),
('20250593', 'Siswa_593', '2008-10-01', 2024, 'Keluar'),
('20250594', 'Siswa_594', '2005-01-02', 2024, 'Aktif'),
('20250595', 'Siswa_595', '2007-11-27', 2025, 'Keluar'),
('20250596', 'Siswa_596', '2010-02-03', 2024, 'Aktif'),
('20250597', 'Siswa_597', '2004-04-20', 2023, 'Lulus'),
('20250598', 'Siswa_598', '2006-06-26', 2024, 'Lulus'),
('20250599', 'Siswa_599', '2007-02-25', 2023, 'Lulus'),
('20250600', 'Siswa_600', '2006-12-27', 2024, 'Keluar'),
('20250601', 'Siswa_601', '2006-08-29', 2020, 'Lulus'),
('20250602', 'Siswa_602', '2009-03-27', 2021, 'Aktif'),
('20250603', 'Siswa_603', '2009-05-09', 2024, 'Aktif'),
('20250604', 'Siswa_604', '2008-10-31', 2021, 'Keluar'),
('20250605', 'Siswa_605', '2008-01-16', 2024, 'Keluar'),
('20250606', 'Siswa_606', '2009-12-15', 2020, 'Keluar'),
('20250607', 'Siswa_607', '2008-08-06', 2021, 'Lulus'),
('20250608', 'Siswa_608', '2007-08-09', 2021, 'Keluar'),
('20250609', 'Siswa_609', '2007-01-25', 2021, 'Aktif'),
('20250610', 'Siswa_610', '2004-09-22', 2024, 'Keluar'),
('20250611', 'Siswa_611', '2006-06-04', 2020, 'Lulus'),
('20250612', 'Siswa_612', '2008-05-14', 2023, 'Keluar'),
('20250613', 'Siswa_613', '2005-05-12', 2025, 'Lulus'),
('20250614', 'Siswa_614', '2009-07-05', 2025, 'Keluar'),
('20250615', 'Siswa_615', '2009-04-06', 2019, 'Keluar'),
('20250616', 'Siswa_616', '2007-04-28', 2019, 'Keluar'),
('20250617', 'Siswa_617', '2006-07-05', 2020, 'Keluar'),
('20250618', 'Siswa_618', '2004-02-20', 2025, 'Keluar'),
('20250619', 'Siswa_619', '2005-03-10', 2019, 'Keluar'),
('20250620', 'Siswa_620', '2009-03-31', 2024, 'Lulus'),
('20250621', 'Siswa_621', '2010-03-03', 2024, 'Aktif'),
('20250622', 'Siswa_622', '2008-06-18', 2025, 'Aktif'),
('20250623', 'Siswa_623', '2005-08-29', 2023, 'Lulus'),
('20250624', 'Siswa_624', '2009-04-09', 2022, 'Lulus'),
('20250625', 'Siswa_625', '2004-05-20', 2022, 'Keluar'),
('20250626', 'Siswa_626', '2006-05-24', 2019, 'Keluar'),
('20250627', 'Siswa_627', '2006-08-25', 2022, 'Lulus'),
('20250628', 'Siswa_628', '2005-06-30', 2019, 'Lulus'),
('20250629', 'Siswa_629', '2006-03-16', 2019, 'Aktif'),
('20250630', 'Siswa_630', '2008-12-30', 2022, 'Aktif'),
('20250631', 'Siswa_631', '2010-12-27', 2020, 'Keluar'),
('20250632', 'Siswa_632', '2009-07-30', 2020, 'Aktif'),
('20250633', 'Siswa_633', '2006-08-04', 2025, 'Aktif'),
('20250634', 'Siswa_634', '2007-07-14', 2019, 'Keluar'),
('20250635', 'Siswa_635', '2006-04-27', 2019, 'Keluar'),
('20250636', 'Siswa_636', '2008-11-21', 2020, 'Lulus'),
('20250637', 'Siswa_637', '2004-07-29', 2025, 'Aktif'),
('20250638', 'Siswa_638', '2008-12-04', 2022, 'Aktif'),
('20250639', 'Siswa_639', '2007-11-19', 2022, 'Lulus'),
('20250640', 'Siswa_640', '2008-10-26', 2025, 'Aktif'),
('20250641', 'Siswa_641', '2006-10-16', 2021, 'Aktif'),
('20250642', 'Siswa_642', '2009-10-12', 2021, 'Aktif'),
('20250643', 'Siswa_643', '2004-08-13', 2022, 'Aktif'),
('20250644', 'Siswa_644', '2006-02-26', 2023, 'Lulus'),
('20250645', 'Siswa_645', '2004-02-19', 2024, 'Keluar'),
('20250646', 'Siswa_646', '2009-05-18', 2022, 'Aktif'),
('20250647', 'Siswa_647', '2008-12-03', 2019, 'Lulus'),
('20250648', 'Siswa_648', '2004-02-01', 2019, 'Keluar'),
('20250649', 'Siswa_649', '2004-07-16', 2021, 'Lulus'),
('20250650', 'Siswa_650', '2006-01-22', 2024, 'Aktif'),
('20250651', 'Siswa_651', '2009-12-30', 2022, 'Keluar'),
('20250652', 'Siswa_652', '2008-06-16', 2022, 'Keluar'),
('20250653', 'Siswa_653', '2007-04-11', 2025, 'Keluar'),
('20250654', 'Siswa_654', '2008-05-14', 2021, 'Lulus'),
('20250655', 'Siswa_655', '2005-02-16', 2019, 'Lulus'),
('20250656', 'Siswa_656', '2005-04-10', 2020, 'Aktif'),
('20250657', 'Siswa_657', '2005-06-20', 2019, 'Aktif'),
('20250658', 'Siswa_658', '2005-07-16', 2020, 'Lulus'),
('20250659', 'Siswa_659', '2004-12-16', 2025, 'Keluar'),
('20250660', 'Siswa_660', '2005-11-26', 2021, 'Aktif'),
('20250661', 'Siswa_661', '2006-08-28', 2022, 'Keluar'),
('20250662', 'Siswa_662', '2005-12-25', 2025, 'Lulus'),
('20250663', 'Siswa_663', '2008-08-11', 2025, 'Aktif'),
('20250664', 'Siswa_664', '2007-08-10', 2024, 'Keluar'),
('20250665', 'Siswa_665', '2010-09-02', 2020, 'Lulus'),
('20250666', 'Siswa_666', '2005-08-12', 2025, 'Lulus'),
('20250667', 'Siswa_667', '2004-01-19', 2024, 'Keluar'),
('20250668', 'Siswa_668', '2008-08-24', 2023, 'Lulus'),
('20250669', 'Siswa_669', '2008-08-27', 2023, 'Lulus'),
('20250670', 'Siswa_670', '2008-08-17', 2020, 'Keluar'),
('20250671', 'Siswa_671', '2009-02-05', 2023, 'Keluar'),
('20250672', 'Siswa_672', '2010-07-09', 2021, 'Lulus'),
('20250673', 'Siswa_673', '2005-04-14', 2022, 'Aktif'),
('20250674', 'Siswa_674', '2006-08-29', 2019, 'Keluar'),
('20250675', 'Siswa_675', '2006-12-01', 2023, 'Keluar'),
('20250676', 'Siswa_676', '2010-09-29', 2021, 'Lulus'),
('20250677', 'Siswa_677', '2007-05-18', 2022, 'Keluar'),
('20250678', 'Siswa_678', '2005-10-28', 2025, 'Lulus'),
('20250679', 'Siswa_679', '2008-04-11', 2024, 'Aktif'),
('20250680', 'Siswa_680', '2009-12-24', 2019, 'Aktif'),
('20250681', 'Siswa_681', '2007-02-04', 2025, 'Keluar'),
('20250682', 'Siswa_682', '2005-04-16', 2023, 'Keluar'),
('20250683', 'Siswa_683', '2004-09-11', 2023, 'Keluar'),
('20250684', 'Siswa_684', '2004-02-17', 2021, 'Keluar'),
('20250685', 'Siswa_685', '2007-09-15', 2023, 'Lulus'),
('20250686', 'Siswa_686', '2005-05-07', 2021, 'Keluar'),
('20250687', 'Siswa_687', '2004-05-10', 2024, 'Keluar'),
('20250688', 'Siswa_688', '2004-06-03', 2022, 'Lulus'),
('20250689', 'Siswa_689', '2004-04-17', 2020, 'Keluar'),
('20250690', 'Siswa_690', '2005-10-26', 2022, 'Lulus'),
('20250691', 'Siswa_691', '2010-10-01', 2023, 'Lulus'),
('20250692', 'Siswa_692', '2007-05-06', 2021, 'Keluar'),
('20250693', 'Siswa_693', '2006-12-30', 2025, 'Keluar'),
('20250694', 'Siswa_694', '2010-07-23', 2022, 'Aktif'),
('20250695', 'Siswa_695', '2007-06-22', 2020, 'Aktif'),
('20250696', 'Siswa_696', '2004-06-26', 2024, 'Keluar'),
('20250697', 'Siswa_697', '2008-12-30', 2023, 'Keluar'),
('20250698', 'Siswa_698', '2009-08-16', 2020, 'Keluar'),
('20250699', 'Siswa_699', '2005-04-06', 2022, 'Keluar'),
('20250700', 'Siswa_700', '2008-07-02', 2020, 'Keluar'),
('20250701', 'Siswa_701', '2007-01-16', 2020, 'Keluar'),
('20250702', 'Siswa_702', '2007-11-01', 2024, 'Aktif'),
('20250703', 'Siswa_703', '2008-10-02', 2025, 'Lulus'),
('20250704', 'Siswa_704', '2006-04-02', 2022, 'Lulus'),
('20250705', 'Siswa_705', '2007-01-26', 2025, 'Keluar'),
('20250706', 'Siswa_706', '2010-08-27', 2025, 'Aktif'),
('20250707', 'Siswa_707', '2008-10-11', 2019, 'Aktif'),
('20250708', 'Siswa_708', '2010-07-14', 2020, 'Lulus'),
('20250709', 'Siswa_709', '2008-04-28', 2019, 'Keluar'),
('20250710', 'Siswa_710', '2009-02-22', 2024, 'Lulus'),
('20250711', 'Siswa_711', '2008-01-09', 2024, 'Aktif'),
('20250712', 'Siswa_712', '2005-03-17', 2023, 'Aktif'),
('20250713', 'Siswa_713', '2008-03-23', 2022, 'Aktif'),
('20250714', 'Siswa_714', '2009-09-01', 2025, 'Aktif'),
('20250715', 'Siswa_715', '2008-08-07', 2021, 'Aktif'),
('20250716', 'Siswa_716', '2009-02-01', 2025, 'Lulus'),
('20250717', 'Siswa_717', '2005-11-01', 2019, 'Keluar'),
('20250718', 'Siswa_718', '2008-01-02', 2022, 'Aktif'),
('20250719', 'Siswa_719', '2010-07-07', 2021, 'Lulus'),
('20250720', 'Siswa_720', '2009-07-27', 2019, 'Keluar'),
('20250721', 'Siswa_721', '2009-12-13', 2019, 'Keluar'),
('20250722', 'Siswa_722', '2007-08-11', 2019, 'Lulus'),
('20250723', 'Siswa_723', '2009-11-04', 2021, 'Lulus'),
('20250724', 'Siswa_724', '2004-08-30', 2021, 'Aktif'),
('20250725', 'Siswa_725', '2008-11-27', 2019, 'Lulus'),
('20250726', 'Siswa_726', '2010-05-18', 2024, 'Aktif'),
('20250727', 'Siswa_727', '2006-04-26', 2024, 'Lulus'),
('20250728', 'Siswa_728', '2006-05-31', 2024, 'Keluar'),
('20250729', 'Siswa_729', '2005-12-26', 2021, 'Aktif'),
('20250730', 'Siswa_730', '2006-06-28', 2022, 'Keluar'),
('20250731', 'Siswa_731', '2008-08-27', 2021, 'Aktif'),
('20250732', 'Siswa_732', '2007-02-11', 2022, 'Lulus'),
('20250733', 'Siswa_733', '2006-11-23', 2020, 'Aktif'),
('20250734', 'Siswa_734', '2004-09-19', 2020, 'Aktif'),
('20250735', 'Siswa_735', '2006-10-06', 2025, 'Lulus'),
('20250736', 'Siswa_736', '2005-05-09', 2020, 'Lulus'),
('20250737', 'Siswa_737', '2009-04-26', 2021, 'Lulus'),
('20250738', 'Siswa_738', '2010-04-05', 2024, 'Lulus'),
('20250739', 'Siswa_739', '2005-01-02', 2019, 'Keluar'),
('20250740', 'Siswa_740', '2007-07-09', 2025, 'Keluar'),
('20250741', 'Siswa_741', '2010-01-19', 2023, 'Lulus'),
('20250742', 'Siswa_742', '2005-10-09', 2023, 'Keluar'),
('20250743', 'Siswa_743', '2009-09-26', 2021, 'Aktif'),
('20250744', 'Siswa_744', '2005-08-03', 2025, 'Lulus'),
('20250745', 'Siswa_745', '2009-06-09', 2023, 'Aktif'),
('20250746', 'Siswa_746', '2009-07-24', 2022, 'Aktif'),
('20250747', 'Siswa_747', '2009-03-27', 2019, 'Keluar'),
('20250748', 'Siswa_748', '2009-02-23', 2019, 'Keluar'),
('20250749', 'Siswa_749', '2010-11-19', 2024, 'Keluar'),
('20250750', 'Siswa_750', '2009-09-14', 2024, 'Aktif'),
('20250751', 'Siswa_751', '2006-06-10', 2020, 'Lulus'),
('20250752', 'Siswa_752', '2006-07-06', 2025, 'Aktif'),
('20250753', 'Siswa_753', '2005-01-16', 2022, 'Lulus'),
('20250754', 'Siswa_754', '2010-10-17', 2020, 'Aktif'),
('20250755', 'Siswa_755', '2007-01-13', 2025, 'Lulus'),
('20250756', 'Siswa_756', '2007-11-06', 2022, 'Keluar'),
('20250757', 'Siswa_757', '2006-03-29', 2023, 'Keluar'),
('20250758', 'Siswa_758', '2008-10-29', 2021, 'Keluar'),
('20250759', 'Siswa_759', '2005-12-05', 2021, 'Lulus'),
('20250760', 'Siswa_760', '2004-05-21', 2023, 'Lulus'),
('20250761', 'Siswa_761', '2010-08-29', 2021, 'Aktif'),
('20250762', 'Siswa_762', '2010-11-18', 2023, 'Keluar'),
('20250763', 'Siswa_763', '2005-06-09', 2025, 'Lulus'),
('20250764', 'Siswa_764', '2009-06-16', 2020, 'Lulus'),
('20250765', 'Siswa_765', '2005-08-19', 2024, 'Lulus'),
('20250766', 'Siswa_766', '2007-11-03', 2023, 'Keluar'),
('20250767', 'Siswa_767', '2004-09-04', 2023, 'Aktif'),
('20250768', 'Siswa_768', '2005-08-11', 2025, 'Aktif'),
('20250769', 'Siswa_769', '2006-11-07', 2022, 'Lulus'),
('20250770', 'Siswa_770', '2008-06-12', 2024, 'Aktif'),
('20250771', 'Siswa_771', '2008-09-07', 2020, 'Aktif'),
('20250772', 'Siswa_772', '2008-05-10', 2020, 'Aktif'),
('20250773', 'Siswa_773', '2005-07-06', 2021, 'Lulus'),
('20250774', 'Siswa_774', '2006-09-12', 2023, 'Keluar'),
('20250775', 'Siswa_775', '2009-11-30', 2021, 'Aktif'),
('20250776', 'Siswa_776', '2009-10-24', 2024, 'Keluar'),
('20250777', 'Siswa_777', '2004-02-04', 2024, 'Lulus'),
('20250778', 'Siswa_778', '2010-11-08', 2020, 'Keluar'),
('20250779', 'Siswa_779', '2006-06-24', 2019, 'Lulus'),
('20250780', 'Siswa_780', '2010-09-13', 2023, 'Aktif'),
('20250781', 'Siswa_781', '2007-03-21', 2021, 'Aktif'),
('20250782', 'Siswa_782', '2004-01-09', 2023, 'Aktif'),
('20250783', 'Siswa_783', '2007-05-24', 2020, 'Keluar'),
('20250784', 'Siswa_784', '2005-06-30', 2020, 'Lulus'),
('20250785', 'Siswa_785', '2009-05-24', 2020, 'Lulus'),
('20250786', 'Siswa_786', '2004-07-15', 2019, 'Aktif'),
('20250787', 'Siswa_787', '2006-09-15', 2020, 'Lulus'),
('20250788', 'Siswa_788', '2006-11-25', 2019, 'Lulus'),
('20250789', 'Siswa_789', '2009-07-17', 2023, 'Aktif'),
('20250790', 'Siswa_790', '2009-12-14', 2021, 'Lulus'),
('20250791', 'Siswa_791', '2009-11-12', 2019, 'Lulus'),
('20250792', 'Siswa_792', '2010-02-13', 2019, 'Keluar'),
('20250793', 'Siswa_793', '2008-10-08', 2019, 'Lulus'),
('20250794', 'Siswa_794', '2010-08-21', 2020, 'Keluar'),
('20250795', 'Siswa_795', '2009-11-12', 2024, 'Lulus'),
('20250796', 'Siswa_796', '2009-12-03', 2025, 'Aktif'),
('20250797', 'Siswa_797', '2005-10-21', 2020, 'Keluar'),
('20250798', 'Siswa_798', '2004-11-24', 2022, 'Aktif'),
('20250799', 'Siswa_799', '2005-09-25', 2024, 'Keluar'),
('20250800', 'Siswa_800', '2009-05-13', 2020, 'Aktif'),
('20250801', 'Siswa_801', '2007-05-19', 2025, 'Keluar'),
('20250802', 'Siswa_802', '2007-11-17', 2021, 'Lulus'),
('20250803', 'Siswa_803', '2008-04-09', 2024, 'Keluar'),
('20250804', 'Siswa_804', '2005-10-14', 2022, 'Keluar'),
('20250805', 'Siswa_805', '2006-10-04', 2024, 'Aktif'),
('20250806', 'Siswa_806', '2010-09-05', 2024, 'Aktif'),
('20250807', 'Siswa_807', '2008-03-21', 2022, 'Aktif'),
('20250808', 'Siswa_808', '2004-07-22', 2019, 'Lulus'),
('20250809', 'Siswa_809', '2010-10-13', 2021, 'Lulus'),
('20250810', 'Siswa_810', '2008-08-07', 2022, 'Keluar'),
('20250811', 'Siswa_811', '2004-12-29', 2023, 'Aktif'),
('20250812', 'Siswa_812', '2010-04-06', 2019, 'Lulus'),
('20250813', 'Siswa_813', '2006-04-08', 2025, 'Lulus'),
('20250814', 'Siswa_814', '2008-08-29', 2025, 'Lulus'),
('20250815', 'Siswa_815', '2005-11-18', 2020, 'Aktif'),
('20250816', 'Siswa_816', '2007-04-26', 2021, 'Keluar'),
('20250817', 'Siswa_817', '2010-03-13', 2020, 'Lulus'),
('20250818', 'Siswa_818', '2005-10-24', 2024, 'Keluar'),
('20250819', 'Siswa_819', '2006-07-25', 2023, 'Lulus'),
('20250820', 'Siswa_820', '2004-02-26', 2019, 'Aktif'),
('20250821', 'Siswa_821', '2010-07-23', 2022, 'Keluar'),
('20250822', 'Siswa_822', '2009-02-15', 2025, 'Keluar'),
('20250823', 'Siswa_823', '2007-03-12', 2023, 'Aktif'),
('20250824', 'Siswa_824', '2009-11-20', 2020, 'Aktif'),
('20250825', 'Siswa_825', '2010-09-15', 2023, 'Lulus'),
('20250826', 'Siswa_826', '2004-04-14', 2020, 'Lulus'),
('20250827', 'Siswa_827', '2005-11-21', 2021, 'Lulus'),
('20250828', 'Siswa_828', '2004-04-02', 2024, 'Lulus'),
('20250829', 'Siswa_829', '2007-04-16', 2019, 'Lulus'),
('20250830', 'Siswa_830', '2006-05-01', 2023, 'Lulus'),
('20250831', 'Siswa_831', '2006-05-16', 2022, 'Keluar'),
('20250832', 'Siswa_832', '2009-09-17', 2024, 'Lulus'),
('20250833', 'Siswa_833', '2007-07-03', 2022, 'Keluar'),
('20250834', 'Siswa_834', '2008-05-29', 2019, 'Keluar'),
('20250835', 'Siswa_835', '2005-04-12', 2025, 'Keluar'),
('20250836', 'Siswa_836', '2010-03-09', 2022, 'Keluar'),
('20250837', 'Siswa_837', '2006-01-03', 2023, 'Aktif'),
('20250838', 'Siswa_838', '2009-06-17', 2023, 'Lulus'),
('20250839', 'Siswa_839', '2004-06-22', 2022, 'Lulus'),
('20250840', 'Siswa_840', '2009-06-20', 2023, 'Keluar'),
('20250841', 'Siswa_841', '2010-07-30', 2021, 'Keluar'),
('20250842', 'Siswa_842', '2004-07-23', 2025, 'Aktif'),
('20250843', 'Siswa_843', '2010-01-17', 2019, 'Keluar'),
('20250844', 'Siswa_844', '2006-10-12', 2023, 'Lulus'),
('20250845', 'Siswa_845', '2004-09-19', 2019, 'Keluar'),
('20250846', 'Siswa_846', '2007-07-23', 2021, 'Keluar'),
('20250847', 'Siswa_847', '2006-06-29', 2023, 'Aktif'),
('20250848', 'Siswa_848', '2009-02-23', 2024, 'Keluar'),
('20250849', 'Siswa_849', '2007-07-04', 2024, 'Keluar'),
('20250850', 'Siswa_850', '2004-05-22', 2025, 'Aktif'),
('20250851', 'Siswa_851', '2005-12-14', 2022, 'Keluar'),
('20250852', 'Siswa_852', '2007-06-23', 2025, 'Aktif'),
('20250853', 'Siswa_853', '2006-07-07', 2021, 'Lulus'),
('20250854', 'Siswa_854', '2008-09-07', 2023, 'Keluar'),
('20250855', 'Siswa_855', '2009-08-10', 2024, 'Aktif'),
('20250856', 'Siswa_856', '2006-11-27', 2025, 'Keluar'),
('20250857', 'Siswa_857', '2004-08-23', 2021, 'Keluar'),
('20250858', 'Siswa_858', '2009-04-29', 2022, 'Lulus'),
('20250859', 'Siswa_859', '2007-03-21', 2022, 'Aktif'),
('20250860', 'Siswa_860', '2010-07-09', 2022, 'Keluar'),
('20250861', 'Siswa_861', '2005-10-27', 2021, 'Keluar'),
('20250862', 'Siswa_862', '2010-05-22', 2021, 'Aktif'),
('20250863', 'Siswa_863', '2006-02-27', 2022, 'Keluar'),
('20250864', 'Siswa_864', '2005-12-23', 2024, 'Keluar'),
('20250865', 'Siswa_865', '2004-02-19', 2021, 'Lulus'),
('20250866', 'Siswa_866', '2006-11-05', 2024, 'Lulus'),
('20250867', 'Siswa_867', '2005-10-07', 2020, 'Aktif'),
('20250868', 'Siswa_868', '2010-08-09', 2024, 'Aktif'),
('20250869', 'Siswa_869', '2005-01-08', 2024, 'Lulus'),
('20250870', 'Siswa_870', '2009-04-06', 2024, 'Keluar'),
('20250871', 'Siswa_871', '2010-03-21', 2025, 'Keluar'),
('20250872', 'Siswa_872', '2007-11-18', 2019, 'Keluar'),
('20250873', 'Siswa_873', '2006-08-17', 2024, 'Aktif'),
('20250874', 'Siswa_874', '2010-03-26', 2024, 'Aktif'),
('20250875', 'Siswa_875', '2009-05-26', 2019, 'Keluar'),
('20250876', 'Siswa_876', '2004-12-10', 2019, 'Keluar'),
('20250877', 'Siswa_877', '2008-03-25', 2021, 'Lulus'),
('20250878', 'Siswa_878', '2007-11-30', 2022, 'Keluar'),
('20250879', 'Siswa_879', '2005-03-29', 2021, 'Keluar'),
('20250880', 'Siswa_880', '2010-10-01', 2019, 'Keluar'),
('20250881', 'Siswa_881', '2008-10-10', 2021, 'Keluar'),
('20250882', 'Siswa_882', '2005-04-05', 2020, 'Keluar'),
('20250883', 'Siswa_883', '2010-10-19', 2025, 'Aktif'),
('20250884', 'Siswa_884', '2009-06-15', 2025, 'Lulus'),
('20250885', 'Siswa_885', '2010-09-22', 2025, 'Lulus'),
('20250886', 'Siswa_886', '2008-03-19', 2023, 'Keluar'),
('20250887', 'Siswa_887', '2007-07-11', 2021, 'Lulus'),
('20250888', 'Siswa_888', '2010-11-27', 2022, 'Keluar'),
('20250889', 'Siswa_889', '2007-01-31', 2020, 'Keluar'),
('20250890', 'Siswa_890', '2006-03-22', 2020, 'Aktif'),
('20250891', 'Siswa_891', '2008-06-23', 2021, 'Aktif'),
('20250892', 'Siswa_892', '2007-06-19', 2021, 'Aktif'),
('20250893', 'Siswa_893', '2004-07-30', 2023, 'Aktif'),
('20250894', 'Siswa_894', '2008-12-16', 2019, 'Aktif'),
('20250895', 'Siswa_895', '2008-07-19', 2025, 'Lulus'),
('20250896', 'Siswa_896', '2010-10-02', 2023, 'Keluar'),
('20250897', 'Siswa_897', '2006-11-07', 2021, 'Aktif'),
('20250898', 'Siswa_898', '2004-09-15', 2024, 'Aktif'),
('20250899', 'Siswa_899', '2006-02-26', 2023, 'Keluar'),
('20250900', 'Siswa_900', '2010-03-10', 2023, 'Aktif'),
('20250901', 'Siswa_901', '2006-04-28', 2019, 'Keluar'),
('20250902', 'Siswa_902', '2009-01-20', 2023, 'Aktif'),
('20250903', 'Siswa_903', '2008-01-30', 2019, 'Aktif'),
('20250904', 'Siswa_904', '2008-05-04', 2019, 'Aktif'),
('20250905', 'Siswa_905', '2004-06-12', 2021, 'Lulus'),
('20250906', 'Siswa_906', '2009-08-03', 2020, 'Aktif'),
('20250907', 'Siswa_907', '2008-10-31', 2019, 'Aktif'),
('20250908', 'Siswa_908', '2006-02-08', 2024, 'Aktif'),
('20250909', 'Siswa_909', '2008-10-31', 2023, 'Keluar'),
('20250910', 'Siswa_910', '2009-01-20', 2020, 'Lulus'),
('20250911', 'Siswa_911', '2009-08-21', 2023, 'Aktif'),
('20250912', 'Siswa_912', '2004-02-25', 2022, 'Lulus'),
('20250913', 'Siswa_913', '2008-07-20', 2023, 'Aktif'),
('20250914', 'Siswa_914', '2010-10-07', 2020, 'Lulus'),
('20250915', 'Siswa_915', '2005-05-14', 2020, 'Lulus'),
('20250916', 'Siswa_916', '2007-01-16', 2020, 'Lulus'),
('20250917', 'Siswa_917', '2004-01-06', 2025, 'Lulus'),
('20250918', 'Siswa_918', '2007-04-08', 2021, 'Lulus'),
('20250919', 'Siswa_919', '2007-03-26', 2021, 'Lulus'),
('20250920', 'Siswa_920', '2008-01-26', 2021, 'Lulus'),
('20250921', 'Siswa_921', '2006-11-24', 2021, 'Aktif'),
('20250922', 'Siswa_922', '2004-03-22', 2020, 'Lulus'),
('20250923', 'Siswa_923', '2009-10-25', 2019, 'Lulus'),
('20250924', 'Siswa_924', '2008-05-12', 2023, 'Keluar'),
('20250925', 'Siswa_925', '2005-10-21', 2021, 'Aktif'),
('20250926', 'Siswa_926', '2010-05-17', 2020, 'Keluar'),
('20250927', 'Siswa_927', '2010-08-10', 2025, 'Lulus'),
('20250928', 'Siswa_928', '2007-06-12', 2019, 'Aktif'),
('20250929', 'Siswa_929', '2006-08-31', 2023, 'Aktif'),
('20250930', 'Siswa_930', '2010-08-19', 2019, 'Lulus'),
('20250931', 'Siswa_931', '2009-04-09', 2024, 'Aktif'),
('20250932', 'Siswa_932', '2009-07-11', 2024, 'Keluar'),
('20250933', 'Siswa_933', '2008-01-31', 2020, 'Keluar'),
('20250934', 'Siswa_934', '2009-06-01', 2025, 'Aktif'),
('20250935', 'Siswa_935', '2008-03-26', 2021, 'Keluar'),
('20250936', 'Siswa_936', '2010-03-23', 2024, 'Aktif'),
('20250937', 'Siswa_937', '2005-03-18', 2019, 'Lulus'),
('20250938', 'Siswa_938', '2004-07-16', 2021, 'Aktif'),
('20250939', 'Siswa_939', '2008-04-15', 2019, 'Keluar'),
('20250940', 'Siswa_940', '2009-08-11', 2022, 'Aktif'),
('20250941', 'Siswa_941', '2007-02-15', 2019, 'Lulus'),
('20250942', 'Siswa_942', '2005-12-15', 2023, 'Keluar'),
('20250943', 'Siswa_943', '2009-02-21', 2025, 'Aktif'),
('20250944', 'Siswa_944', '2004-12-12', 2023, 'Lulus'),
('20250945', 'Siswa_945', '2005-10-09', 2023, 'Keluar'),
('20250946', 'Siswa_946', '2008-02-23', 2024, 'Aktif'),
('20250947', 'Siswa_947', '2008-06-21', 2022, 'Aktif'),
('20250948', 'Siswa_948', '2010-09-30', 2021, 'Aktif'),
('20250949', 'Siswa_949', '2010-12-22', 2025, 'Lulus'),
('20250950', 'Siswa_950', '2006-02-07', 2024, 'Keluar'),
('20250951', 'Siswa_951', '2008-05-13', 2019, 'Keluar'),
('20250952', 'Siswa_952', '2005-11-30', 2019, 'Keluar'),
('20250953', 'Siswa_953', '2008-09-05', 2023, 'Aktif'),
('20250954', 'Siswa_954', '2010-02-17', 2020, 'Aktif'),
('20250955', 'Siswa_955', '2004-02-18', 2023, 'Keluar'),
('20250956', 'Siswa_956', '2007-09-02', 2024, 'Aktif'),
('20250957', 'Siswa_957', '2004-02-04', 2021, 'Aktif'),
('20250958', 'Siswa_958', '2004-08-19', 2023, 'Lulus'),
('20250959', 'Siswa_959', '2006-09-03', 2022, 'Aktif'),
('20250960', 'Siswa_960', '2008-09-16', 2024, 'Lulus'),
('20250961', 'Siswa_961', '2007-05-24', 2021, 'Keluar'),
('20250962', 'Siswa_962', '2006-04-17', 2025, 'Keluar'),
('20250963', 'Siswa_963', '2007-05-16', 2022, 'Lulus'),
('20250964', 'Siswa_964', '2008-02-29', 2024, 'Aktif'),
('20250965', 'Siswa_965', '2005-08-09', 2023, 'Aktif'),
('20250966', 'Siswa_966', '2008-04-12', 2023, 'Lulus'),
('20250967', 'Siswa_967', '2008-10-01', 2025, 'Aktif'),
('20250968', 'Siswa_968', '2007-12-15', 2023, 'Keluar'),
('20250969', 'Siswa_969', '2008-11-20', 2020, 'Keluar'),
('20250970', 'Siswa_970', '2004-11-30', 2023, 'Aktif'),
('20250971', 'Siswa_971', '2004-01-02', 2020, 'Lulus'),
('20250972', 'Siswa_972', '2010-12-29', 2020, 'Lulus'),
('20250973', 'Siswa_973', '2004-02-20', 2023, 'Lulus'),
('20250974', 'Siswa_974', '2008-08-20', 2022, 'Keluar'),
('20250975', 'Siswa_975', '2004-01-26', 2022, 'Keluar'),
('20250976', 'Siswa_976', '2006-05-11', 2023, 'Aktif'),
('20250977', 'Siswa_977', '2005-07-27', 2021, 'Lulus'),
('20250978', 'Siswa_978', '2006-04-13', 2021, 'Lulus'),
('20250979', 'Siswa_979', '2010-09-01', 2025, 'Aktif'),
('20250980', 'Siswa_980', '2005-04-28', 2019, 'Lulus'),
('20250981', 'Siswa_981', '2006-07-05', 2025, 'Keluar'),
('20250982', 'Siswa_982', '2007-10-12', 2025, 'Keluar'),
('20250983', 'Siswa_983', '2010-12-22', 2023, 'Keluar'),
('20250984', 'Siswa_984', '2006-08-18', 2022, 'Lulus'),
('20250985', 'Siswa_985', '2007-08-15', 2023, 'Aktif'),
('20250986', 'Siswa_986', '2010-05-07', 2025, 'Keluar'),
('20250987', 'Siswa_987', '2004-05-22', 2025, 'Aktif'),
('20250988', 'Siswa_988', '2005-05-02', 2021, 'Aktif'),
('20250989', 'Siswa_989', '2006-07-05', 2022, 'Keluar'),
('20250990', 'Siswa_990', '2007-03-07', 2023, 'Aktif'),
('20250991', 'Siswa_991', '2006-06-01', 2020, 'Lulus'),
('20250992', 'Siswa_992', '2006-02-20', 2021, 'Keluar'),
('20250993', 'Siswa_993', '2004-03-14', 2020, 'Lulus'),
('20250994', 'Siswa_994', '2010-05-09', 2022, 'Lulus'),
('20250995', 'Siswa_995', '2010-12-19', 2025, 'Aktif'),
('20250996', 'Siswa_996', '2007-06-28', 2024, 'Keluar'),
('20250997', 'Siswa_997', '2007-04-24', 2024, 'Lulus'),
('20250998', 'Siswa_998', '2009-02-09', 2021, 'Lulus'),
('20250999', 'Siswa_999', '2006-12-05', 2021, 'Keluar'),
('20251000', 'Siswa_1000', '2010-03-24', 2024, 'Lulus');
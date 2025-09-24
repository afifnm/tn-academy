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

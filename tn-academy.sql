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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int NOT NULL,
  `nama_guru` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `tingkat` enum('X','XI','XII') NOT NULL,
  `jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas_mapel`
--

CREATE TABLE `kelas_mapel` (
  `id_kelas_mapel` int NOT NULL,
  `id_kelas` int NOT NULL,
  `id_mapel` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int NOT NULL,
  `nama_mapel` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mapel_komponen`
--

CREATE TABLE `mapel_komponen` (
  `id_komponen` int NOT NULL,
  `id_mapel` int NOT NULL,
  `nama_komponen` varchar(100) NOT NULL,
  `bobot` decimal(5,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id_ta` int NOT NULL,
  `tahun` varchar(9) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enroll`
--
ALTER TABLE `enroll`
  ADD PRIMARY KEY (`id_enroll`),
  ADD UNIQUE KEY `id_siswa` (`id_siswa`,`id_kelas`,`id_ta`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_ta` (`id_ta`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `kelas_mapel`
--
ALTER TABLE `kelas_mapel`
  ADD PRIMARY KEY (`id_kelas_mapel`),
  ADD UNIQUE KEY `id_kelas` (`id_kelas`,`id_mapel`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `mapel_komponen`
--
ALTER TABLE `mapel_komponen`
  ADD PRIMARY KEY (`id_komponen`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD UNIQUE KEY `uniq_nilai` (`id_enroll`,`id_kelas_mapel`,`id_komponen`),
  ADD KEY `id_kelas_mapel` (`id_kelas_mapel`),
  ADD KEY `id_komponen` (`id_komponen`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nisn` (`nisn`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id_ta`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enroll`
--
ALTER TABLE `enroll`
  MODIFY `id_enroll` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas_mapel`
--
ALTER TABLE `kelas_mapel`
  MODIFY `id_kelas_mapel` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mapel_komponen`
--
ALTER TABLE `mapel_komponen`
  MODIFY `id_komponen` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id_ta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enroll`
--
ALTER TABLE `enroll`
  ADD CONSTRAINT `enroll_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_ibfk_3` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajaran` (`id_ta`) ON DELETE CASCADE;

--
-- Constraints for table `kelas_mapel`
--
ALTER TABLE `kelas_mapel`
  ADD CONSTRAINT `kelas_mapel_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelas_mapel_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE;

--
-- Constraints for table `mapel_komponen`
--
ALTER TABLE `mapel_komponen`
  ADD CONSTRAINT `mapel_komponen_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_enroll`) REFERENCES `enroll` (`id_enroll`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`id_kelas_mapel`) REFERENCES `kelas_mapel` (`id_kelas_mapel`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`id_komponen`) REFERENCES `mapel_komponen` (`id_komponen`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_4` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

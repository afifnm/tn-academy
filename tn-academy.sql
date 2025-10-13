-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 13, 2025 at 06:18 AM
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
-- Database: `tn-academy`
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
-- Table structure for table `enroll_mapel`
--

CREATE TABLE `enroll_mapel` (
  `id_enroll_mapel` int NOT NULL,
  `id_mapel` int NOT NULL,
  `id_kelas` int NOT NULL,
  `id_ta` int NOT NULL,
  `id_guru` int DEFAULT NULL,
  `id_komponen` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enroll_mapel`
--

INSERT INTO `enroll_mapel` (`id_enroll_mapel`, `id_mapel`, `id_kelas`, `id_ta`, `id_guru`, `id_komponen`, `created_at`) VALUES
(2, 1, 4, 3, NULL, NULL, '2025-10-13 03:25:51'),
(3, 2, 4, 4, NULL, NULL, '2025-10-13 03:26:06'),
(4, 2, 5, 4, 4, NULL, '2025-10-13 03:57:24'),
(6, 2, 4, 5, NULL, NULL, '2025-10-13 06:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `enroll_mapel_komponen`
--

CREATE TABLE `enroll_mapel_komponen` (
  `id_enroll_mapel` int NOT NULL,
  `id_komponen` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enroll_mapel_komponen`
--

INSERT INTO `enroll_mapel_komponen` (`id_enroll_mapel`, `id_komponen`) VALUES
(4, 13);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int NOT NULL,
  `nama_guru` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`) VALUES
(4, 'Budi Santoso');

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

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `tingkat`, `jurusan`) VALUES
(4, 'X IPS A', 'X', 'IPS'),
(5, 'XI Bahasa C', 'XI', 'Bahasa'),
(6, 'XII IPA B', 'XII', 'IPA ');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_mapel`
--

CREATE TABLE `kelas_mapel` (
  `id_kelas_mapel` int NOT NULL,
  `id_kelas` int NOT NULL,
  `id_mapel` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kelas_mapel`
--

INSERT INTO `kelas_mapel` (`id_kelas_mapel`, `id_kelas`, `id_mapel`) VALUES
(1, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int NOT NULL,
  `nama_mapel` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `nama_mapel`) VALUES
(1, 'Matematika'),
(2, 'Bahasa Indonesia'),
(3, 'Fisika');

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

--
-- Dumping data for table `mapel_komponen`
--

INSERT INTO `mapel_komponen` (`id_komponen`, `id_mapel`, `nama_komponen`, `bobot`) VALUES
(9, 1, 'UTS', 30.00),
(10, 1, 'UAS', 40.00),
(11, 1, 'Harian', 20.00),
(12, 1, 'Praktik', 10.00),
(13, 2, 'UTS', 35.00),
(14, 2, 'UAS', 35.00),
(15, 2, 'Harian', 30.00),
(16, 3, 'UTS', 25.00),
(17, 3, 'UAS', 25.00),
(18, 3, 'Praktik', 50.00);

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
  `nis` varchar(20) DEFAULT NULL,
  `nama` varchar(150) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `graha` varchar(100) DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `cita_cita` varchar(100) DEFAULT NULL,
  `nama_smp` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `tinggi` int DEFAULT NULL,
  `berat_badan` int DEFAULT NULL,
  `hobi` varchar(100) DEFAULT NULL,
  `nama_ayah` varchar(150) DEFAULT NULL,
  `nama_ibu` varchar(150) DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `penghasilan_ayah` enum('0 / Tidak punya penghasilan','< 1 juta','1 - 3 juta','3 - 5 juta','5 - 10 juta','10 - 15 juta','> 15 juta') DEFAULT NULL,
  `penghasilan_ibu` enum('0 / Tidak punya penghasilan','< 1 juta','1 - 3 juta','3 - 5 juta','5 - 10 juta','10 - 15 juta','> 15 juta') DEFAULT NULL,
  `nama_provinsi` varchar(100) DEFAULT NULL,
  `thn_masuk` year NOT NULL,
  `status` enum('aktif','lulus','keluar') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `jalur_pendidikan` enum('beasiswa','kontribusi','reguler') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nisn`, `nis`, `nama`, `tgl_lahir`, `tempat_lahir`, `graha`, `agama`, `cita_cita`, `nama_smp`, `email`, `tinggi`, `berat_badan`, `hobi`, `nama_ayah`, `nama_ibu`, `pekerjaan_ayah`, `pekerjaan_ibu`, `penghasilan_ayah`, `penghasilan_ibu`, `nama_provinsi`, `thn_masuk`, `status`, `foto`, `jenis_kelamin`, `jalur_pendidikan`) VALUES
(1014, '89898989898', '321234', 'Sean Kaufman', '2025-10-17', 'Karanganyar', 'Doplang', 'islam', 'dokter', 'smp tarakanita', 'sean@gmail.com', 123, 56, 'padel', 'Kendrick', 'Julia', 'Lawyer', 'Atlit', '< 1 juta', '1 - 3 juta', 'Jawa tengah', '2000', 'lulus', NULL, 'Perempuan', 'kontribusi'),
(1017, '8818887771', '0983', 'Mipan', '2009-08-20', 'Karanganyar', 'Los Angeles', 'islam', 'Dokter Anak', 'smp tarakanita', 'mipan@gmail.com', 170, 35, 'padel', 'Adam', 'Jeni', 'Petani', 'Dokter', '5 - 10 juta', '10 - 15 juta', 'Jawa timur', '2025', 'aktif', 'siswa_1017_1759659925.jpg', 'Laki-laki', 'reguler'),
(1019, '21212233', '21345', 'Isabel Conklin', '2000-03-28', 'New York', 'Doplang', 'budha', 'Psikologi Olahraga', 'smp mentari', 'isabel@gmail.com', 188, 56, 'Menangis', 'Ali ', 'Laurel', 'Karyawan Swasta', 'Karyawan Swasta', '5 - 10 juta', '5 - 10 juta', 'Jawa Timur', '2021', 'lulus', '20251003140548.jpg', 'Laki-laki', 'beasiswa');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id_ta` int NOT NULL,
  `tahun` varchar(9) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id_ta`, `tahun`, `semester`) VALUES
(3, '2023/2024', 'Ganjil'),
(4, '2024/2025', 'Ganjil'),
(5, '2025/2026', 'Genap'),
(6, '2023/2024', 'Genap');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kepala sekolah','guru') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`, `nama`) VALUES
(41, 'admin', 'd3353ed42f3f5dc07015d195dc36bb19', 'admin', 'memet'),
(43, 'afifnm', 'b56776aa98086825550ff0c3fe260907', 'kepala sekolah', 'Afif Nurruddin M');

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
-- Indexes for table `enroll_mapel`
--
ALTER TABLE `enroll_mapel`
  ADD PRIMARY KEY (`id_enroll_mapel`),
  ADD UNIQUE KEY `id_mapel` (`id_mapel`,`id_kelas`,`id_ta`,`id_komponen`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_ta` (`id_ta`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_komponen` (`id_komponen`);

--
-- Indexes for table `enroll_mapel_komponen`
--
ALTER TABLE `enroll_mapel_komponen`
  ADD PRIMARY KEY (`id_enroll_mapel`,`id_komponen`),
  ADD KEY `id_komponen` (`id_komponen`);

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
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD UNIQUE KEY `nis` (`nis`);

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
  MODIFY `id_enroll` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `enroll_mapel`
--
ALTER TABLE `enroll_mapel`
  MODIFY `id_enroll_mapel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kelas_mapel`
--
ALTER TABLE `kelas_mapel`
  MODIFY `id_kelas_mapel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mapel_komponen`
--
ALTER TABLE `mapel_komponen`
  MODIFY `id_komponen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1022;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id_ta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

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
-- Constraints for table `enroll_mapel`
--
ALTER TABLE `enroll_mapel`
  ADD CONSTRAINT `enroll_mapel_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_mapel_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_mapel_ibfk_3` FOREIGN KEY (`id_ta`) REFERENCES `tahun_ajaran` (`id_ta`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_mapel_ibfk_4` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE SET NULL,
  ADD CONSTRAINT `enroll_mapel_ibfk_5` FOREIGN KEY (`id_komponen`) REFERENCES `mapel_komponen` (`id_komponen`) ON DELETE SET NULL;

--
-- Constraints for table `enroll_mapel_komponen`
--
ALTER TABLE `enroll_mapel_komponen`
  ADD CONSTRAINT `enroll_mapel_komponen_ibfk_1` FOREIGN KEY (`id_enroll_mapel`) REFERENCES `enroll_mapel` (`id_enroll_mapel`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_mapel_komponen_ibfk_2` FOREIGN KEY (`id_komponen`) REFERENCES `mapel_komponen` (`id_komponen`) ON DELETE CASCADE;

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

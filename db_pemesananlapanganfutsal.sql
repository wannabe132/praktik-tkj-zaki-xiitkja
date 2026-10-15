-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2026 at 01:58 AM
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
-- Database: `db_pemesananlapanganfutsal`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbooking`
--

CREATE TABLE `tbooking` (
  `Id_booking` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Id_lapang` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `Jam_mulai` time NOT NULL,
  `Jam_selesai` time NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbooking`
--

INSERT INTO `tbooking` (`Id_booking`, `Username`, `Id_lapang`, `Tanggal`, `Jam_mulai`, `Jam_selesai`, `Status`) VALUES
(25, 'Tegar', 7, '2026-05-20', '10:00:00', '11:00:00', 'disetujui'),
(26, 'Tegar', 6, '2026-05-20', '10:00:00', '12:00:00', 'disetujui'),
(27, 'Tegar', 8, '2026-05-20', '13:00:00', '14:00:00', 'disetujui'),
(28, 'Ferli', 8, '2026-05-31', '14:00:00', '15:00:00', 'disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `tlapang`
--

CREATE TABLE `tlapang` (
  `Id_lapang` int(11) NOT NULL,
  `Nama_lapangan` varchar(100) NOT NULL,
  `Harga` int(11) NOT NULL,
  `Deskripsi` text NOT NULL,
  `Gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tlapang`
--

INSERT INTO `tlapang` (`Id_lapang`, `Nama_lapangan`, `Harga`, `Deskripsi`, `Gambar`) VALUES
(6, 'Lapang Gfi', 130000, 'Lapangan dengan sejuta kenangan', 'Lapang Gempol.jpg'),
(7, 'Lapang Cibabat', 150000, 'Lapangan Profesional yang sangat nyaman', 'Lapang Profesional.jpg'),
(8, 'Lapang Sintetis', 250000, 'Lapangan sintetis dengan pengalaman bermain yang mantap', 'Lapang Sinteis.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ttransaksi`
--

CREATE TABLE `ttransaksi` (
  `Id_transaksi` int(11) NOT NULL,
  `Id_booking` int(11) DEFAULT NULL,
  `Metode_pembayaran` varchar(50) DEFAULT NULL,
  `Nominal` int(11) DEFAULT NULL,
  `Status_pembayaran` enum('menunggu','lunas','ditolak') DEFAULT 'menunggu',
  `Bukti_pembayaran` varchar(255) NOT NULL,
  `Tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ttransaksi`
--

INSERT INTO `ttransaksi` (`Id_transaksi`, `Id_booking`, `Metode_pembayaran`, `Nominal`, `Status_pembayaran`, `Bukti_pembayaran`, `Tanggal`) VALUES
(16, 26, 'Transfer Bank', 260000, 'lunas', 'images.png', '2026-05-20 07:15:37'),
(17, 25, 'Transfer Bank', 150000, 'lunas', 'images.jpg', '2026-05-20 07:15:55'),
(18, 27, 'Transfer Bank', 250000, 'lunas', 'c655ce40-image-1024x683.png', '2026-05-20 07:17:47'),
(19, 28, 'Transfer Bank', 250000, 'lunas', 'images.jpg', '2026-05-31 21:00:52');

-- --------------------------------------------------------

--
-- Table structure for table `tuser`
--

CREATE TABLE `tuser` (
  `Id_user` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('Admin','User') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tuser`
--

INSERT INTO `tuser` (`Id_user`, `Username`, `Email`, `Password`, `Role`) VALUES
(13, 'Reval', 'revaloni@gmail.com', '$2y$10$A6mbvmI9J4mm/VBUEFDLN.pdmA7BLKzhEGfH.sbrP36z6sU9x/Kie', 'Admin'),
(14, 'Tegar', 'Tegar@gmail.com', '$2y$10$13ZsSZy2/sPVpJwE5KMF0Oalkl8DFSYCZtS7NFkrh278tsZHypJYO', 'User'),
(15, 'Ferli', 'Ferli@gmail.com', '$2y$10$H1yGuMWOV4gkRX3iHD7rh.EHZ6wKGr5TjDm6zoV8vj3ZAE92RnYYO', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbooking`
--
ALTER TABLE `tbooking`
  ADD PRIMARY KEY (`Id_booking`),
  ADD KEY `Id_lapang` (`Id_lapang`);

--
-- Indexes for table `tlapang`
--
ALTER TABLE `tlapang`
  ADD PRIMARY KEY (`Id_lapang`);

--
-- Indexes for table `ttransaksi`
--
ALTER TABLE `ttransaksi`
  ADD PRIMARY KEY (`Id_transaksi`),
  ADD KEY `Id_booking` (`Id_booking`);

--
-- Indexes for table `tuser`
--
ALTER TABLE `tuser`
  ADD PRIMARY KEY (`Id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbooking`
--
ALTER TABLE `tbooking`
  MODIFY `Id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tlapang`
--
ALTER TABLE `tlapang`
  MODIFY `Id_lapang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ttransaksi`
--
ALTER TABLE `ttransaksi`
  MODIFY `Id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tuser`
--
ALTER TABLE `tuser`
  MODIFY `Id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbooking`
--
ALTER TABLE `tbooking`
  ADD CONSTRAINT `tbooking_ibfk_1` FOREIGN KEY (`Id_lapang`) REFERENCES `tlapang` (`Id_lapang`);

--
-- Constraints for table `ttransaksi`
--
ALTER TABLE `ttransaksi`
  ADD CONSTRAINT `ttransaksi_ibfk_1` FOREIGN KEY (`Id_booking`) REFERENCES `tbooking` (`Id_booking`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

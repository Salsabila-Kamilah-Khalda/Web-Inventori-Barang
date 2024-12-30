-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 09:41 AM
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
-- Database: `inventori_toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kodeBarang` varchar(20) NOT NULL,
  `namaBarang` varchar(100) DEFAULT NULL,
  `jenisBarang` varchar(50) DEFAULT NULL,
  `hargaBeli` decimal(10,2) DEFAULT NULL,
  `hargaJual` decimal(10,2) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `minimumStok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kodeBarang`, `namaBarang`, `jenisBarang`, `hargaBeli`, `hargaJual`, `stok`, `minimumStok`) VALUES
('001', 'Beras', 'Sembako', 10000.00, 11000.00, 28, 5),
('002', 'Sabun Cuci Piring', 'Kebersihan', 5000.00, 5500.00, 22, 10),
('003', 'Gula', 'Sembako', 12000.00, 13000.00, 15, 8),
('004', 'Minyak Goreng', 'Sembako', 14000.00, 15000.00, 20, 10),
('005', 'Pasta Gigi', 'Kebersihan', 8000.00, 9000.00, 18, 5),
('006', 'Shampo', 'Kebersihan', 15000.00, 16500.00, 10, 4),
('007', 'Teh Celup', 'Minuman', 3000.00, 3500.00, 25, 12),
('008', 'Kopi Instan', 'Minuman', 4000.00, 4500.00, 30, 10),
('009', 'Mie Instan', 'Sembako', 2500.00, 3000.00, 50, 20),
('010', 'Tissue Gulung', 'Kebersihan', 10000.00, 11000.00, 12, 6),
('011', 'Detergen Bubuk', 'Kebersihan', 18000.00, 20000.00, 25, 10),
('012', 'Kecap Manis', 'Sembako', 8000.00, 9000.00, 27, 15),
('013', 'Susu Bubuk', 'Minuman', 45000.00, 50000.00, 12, 6),
('014', 'Roti Tawar', 'Makanan', 12000.00, 13500.00, 20, 5),
('015', 'Keju', 'Makanan', 35000.00, 40000.00, 3, 3),
('016', 'Lilin', 'Kebutuhan Rumah', 3000.00, 3500.00, 50, 20),
('017', 'Obat Nyamuk', 'Kebutuhan Rumah', 7000.00, 7500.00, 15, 5),
('018', 'Baterai AA', 'Elektronik', 10000.00, 12000.00, 25, 10),
('019', 'Lampu LED', 'Elektronik', 20000.00, 22000.00, 10, 5),
('020', 'Masker Medis', 'Kesehatan', 5000.00, 5500.00, 100, 50),
('021', 'Biskuit Kaleng', 'Makanan', 25000.00, 28000.00, 15, 5),
('022', 'Tepung Terigu', 'Sembako', 10000.00, 12000.00, 50, 20),
('023', 'Air Mineral Galon', 'Minuman', 18000.00, 20000.00, 10, 3),
('024', 'Kain Pel', 'Kebersihan', 12000.00, 14000.00, 20, 5),
('025', 'Payung Lipat', 'Peralatan', 35000.00, 40000.00, 8, 2),
('026', 'Penggaris Besi', 'Peralatan', 15000.00, 17000.00, 0, 5),
('027', 'Sabun Batang', 'Kebersihan', 3000.00, 3500.00, 100, 40),
('028', 'Buku Tulis', 'Perlengkapan Belajar', 7000.00, 7500.00, 50, 20),
('029', 'Pensil', 'Perlengkapan Belajar', 2000.00, 2500.00, 100, 50),
('030', 'Botol Minum', 'Perlengkapan', 20000.00, 25000.00, 30, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('Petugas Gudang','Petugas Kasir','Pemilik Toko') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`username`, `password`, `role`) VALUES
('pemilik toko', 'pemilik', 'Pemilik Toko'),
('petugas gudang', 'gudang', 'Petugas Gudang'),
('petugas kasir', 'kasir', 'Petugas Kasir');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `nomorNota` varchar(20) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `kodeBarang` varchar(20) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `hargaJual` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`nomorNota`, `tanggal`, `kodeBarang`, `qty`, `hargaJual`) VALUES
('001', '2024-12-27', '001', 1, 11000.00),
('002', '2024-12-27', '001', 3, 5500.00),
('003', '2024-12-27', '026', 4, 17000.00),
('004', '2024-12-27', '026', 2, 40000.00),
('005', '2024-12-27', '015', 5, 4000.00),
('006', '2024-12-29', '012', 3, 9000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kodeBarang`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`nomorNota`),
  ADD KEY `kodeBarang` (`kodeBarang`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`kodeBarang`) REFERENCES `barang` (`kodeBarang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

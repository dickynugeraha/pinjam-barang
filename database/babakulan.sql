-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2022 at 10:09 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `babakulan`
--

-- --------------------------------------------------------

--
-- Table structure for table `brg_keluar`
--

CREATE TABLE `brg_keluar` (
  `id` int(11) NOT NULL,
  `nama_brg_keluar` varchar(50) NOT NULL,
  `tipe_brg_keluar` varchar(50) NOT NULL,
  `jenis_brg_keluar` varchar(50) NOT NULL,
  `harga_jual_keluar` int(11) NOT NULL,
  `jumlah_brg_keluar` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `gambar_brg_keluar` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brg_keluar`
--

INSERT INTO `brg_keluar` (`id`, `nama_brg_keluar`, `tipe_brg_keluar`, `jenis_brg_keluar`, `harga_jual_keluar`, `jumlah_brg_keluar`, `total_harga`, `gambar_brg_keluar`, `keterangan`, `tgl_keluar`, `created_at`) VALUES
(11, 'meja', 'barang art', 'oke punya', 450000, 1, 450000, '639c34ce97d6c.png', 'barang mulus', '2022-12-16', '2022-12-16 09:05:18');

-- --------------------------------------------------------

--
-- Table structure for table `brg_masuk`
--

CREATE TABLE `brg_masuk` (
  `id` int(11) NOT NULL,
  `nama_brg` varchar(50) DEFAULT NULL,
  `tipe_brg` varchar(50) DEFAULT NULL,
  `jenis_brg` varchar(50) DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `gambar` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brg_masuk`
--

INSERT INTO `brg_masuk` (`id`, `nama_brg`, `tipe_brg`, `jenis_brg`, `harga_beli`, `harga_jual`, `stok`, `gambar`, `keterangan`, `tgl_masuk`, `created_at`) VALUES
(5, 'sofa jaman belanda', 'antik', 'sofa', 1300000, 2000000, 1, '637a30cb479cd.png', 'mantep cuy', '2022-11-01', '2022-11-27 12:37:07'),
(31, 'lemari 1967', 'antik', 'lemari', 2000000, 3000000, 3, '637a2ce55f2f7.png', 'kokoh abis', '2022-11-17', '2022-12-09 08:30:58'),
(32, 'kasur benefecto', 'biasa', 'kasur', 200000, 30000, 2, '6380c40ddb7d8.jpeg', 'mantep cuy', '2022-11-12', '2022-12-16 07:44:24'),
(38, 'hotweels', 'mainan', 'oke punya', 23000, 28000, 26, '639c3564e8674.png', 'barang mulus', '2022-12-16', '2022-12-16 09:07:48'),
(39, 'meja', 'barang art', 'oke punya', 400000, 450000, 3, '639c34ce97d6c.png', 'barang mulus', '2022-12-16', '2022-12-16 09:05:18');

-- --------------------------------------------------------

--
-- Table structure for table `brg_peminjaman`
--

CREATE TABLE `brg_peminjaman` (
  `id` int(11) NOT NULL,
  `nama_peminjam` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `tgl_awal_pinjam` date NOT NULL,
  `tgl_akhir_pinjam` date NOT NULL,
  `nama_brg_pinjam` varchar(50) NOT NULL,
  `gambar_pinjam` varchar(100) NOT NULL,
  `jumlah_pinjam` int(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brg_peminjaman`
--

INSERT INTO `brg_peminjaman` (`id`, `nama_peminjam`, `alamat`, `no_hp`, `tgl_awal_pinjam`, `tgl_akhir_pinjam`, `nama_brg_pinjam`, `gambar_pinjam`, `jumlah_pinjam`, `keterangan`, `status`, `created_at`) VALUES
(25, 'tr', 'sd', '123', '2022-12-16', '2022-12-23', 'hotweels', '639c3564e8674.png', 1, 'untuk panti asuhan', 'dalam peminjaman', '2022-12-16 09:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `login_admin`
--

CREATE TABLE `login_admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_admin`
--

INSERT INTO `login_admin` (`username`, `password`) VALUES
('admin', 'admin'),
('admin1', 'admin1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brg_keluar`
--
ALTER TABLE `brg_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brg_masuk`
--
ALTER TABLE `brg_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brg_peminjaman`
--
ALTER TABLE `brg_peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_admin`
--
ALTER TABLE `login_admin`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brg_keluar`
--
ALTER TABLE `brg_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `brg_masuk`
--
ALTER TABLE `brg_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `brg_peminjaman`
--
ALTER TABLE `brg_peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

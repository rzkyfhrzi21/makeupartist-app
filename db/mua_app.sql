-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2025 at 05:56 AM
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
-- Database: `mua_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id_booking` int(11) NOT NULL,
  `id_user` int(150) NOT NULL,
  `no_wa` varchar(25) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `waktu_booking` time NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `id_service` int(11) NOT NULL,
  `catatan_klien` text DEFAULT NULL,
  `status` enum('pending','dikonfirmasi','selesai') NOT NULL DEFAULT 'pending',
  `total_harga` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id_booking`, `id_user`, `no_wa`, `tanggal_booking`, `waktu_booking`, `lokasi`, `id_service`, `catatan_klien`, `status`, `total_harga`, `created_at`) VALUES
(1, 2, '081234567890', '2025-11-10', '08:00:00', 'Jl. Pahlawan No. 45, Bandar Lampung', 1, 'Makeup untuk wisuda, mohon hasilnya natural dan tahan lama.', 'selesai', 250000, '2025-11-08 14:14:38'),
(2, 2, '082134567891', '2025-11-12', '09:00:00', 'Perum Gading Raya, Lampung Timur', 3, 'Acara lamaran di rumah, mohon datang pukul 08.30.', 'selesai', 600000, '2025-11-08 14:14:38'),
(3, 2, '081278956432', '2025-11-02', '06:30:00', 'Hotel Sheraton, Bandar Lampung', 2, 'Pernikahan outdoor, makeup tahan keringat.', 'selesai', 1200000, '2025-11-08 14:14:38'),
(4, 2, '083145678910', '2025-11-07', '07:00:00', 'Jl. Teuku Umar No. 12, Bandar Lampung', 1, 'Wisuda di kampus Unila, ingin tampilan fresh dan glowing.', 'selesai', 250000, '2025-11-08 14:14:38'),
(6, 2, '', '2025-11-09', '23:31:00', 'Melati111111', 1, '11', 'selesai', 250000, '2025-11-09 11:31:40');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id_gallery` int(11) NOT NULL,
  `id_service` int(11) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id_gallery`, `id_service`, `gambar`, `deskripsi`, `created_at`) VALUES
(2, 3, 'mua_690feba408a6b1.99179042.png', '', '2025-11-09 08:17:24'),
(3, 2, 'mua_690febb30336b1.55544644.jpg', '', '2025-11-09 08:17:39'),
(4, 3, 'mua_69101542bf2f10.65816102.jpeg', '', '2025-11-09 11:14:58'),
(5, 8, 'mua_69101d3e2ed486.72565246.png', '', '2025-11-09 11:49:02'),
(6, 8, 'mua_69101d3e2f0002.38749441.jpg', '', '2025-11-09 11:49:02'),
(7, 8, 'mua_69101d3e2f1e29.49925916.jpeg', '', '2025-11-09 11:49:02');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id_service` int(11) NOT NULL,
  `nama_service` varchar(150) NOT NULL,
  `deskripsi_singkat` varchar(255) NOT NULL,
  `deskripsi_lengkap` text DEFAULT NULL,
  `harga_mulai` int(11) NOT NULL,
  `estimasi_durasi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id_service`, `nama_service`, `deskripsi_singkat`, `deskripsi_lengkap`, `harga_mulai`, `estimasi_durasi`) VALUES
(1, 'Paket Fresh Look / Natural Glam', 'Makeup ringan dengan tampilan natural untuk wisuda atau acara formal.', 'Cocok bagi kamu yang ingin tampil segar dan anggun tanpa terlihat berlebihan. Menggunakan produk premium yang tahan hingga 6 jam.', 250000, '1 - 1.5 jam'),
(2, 'Paket Bridal Elegance', 'Makeup profesional untuk hari pernikahan yang memancarkan keanggunan dan kepercayaan diri.', 'Menggunakan teknik full coverage dan waterproof, cocok untuk acara indoor maupun outdoor. Termasuk retouch hingga resepsi.', 1200000, '3 - 4 jam'),
(3, 'Paket Engagement / Lamaran Sederhana', 'Makeup flawless dengan sentuhan lembut untuk momen lamaran yang berkesan.', 'Fokus pada tampilan soft glam yang menonjolkan kecantikan alami. Termasuk styling rambut sederhana.', 600000, '1 - 1.5 jam'),
(8, 'Sederhana1', 'Sederhana1', 'Sederhana1', 111111, 'Sederhana1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','klien') NOT NULL DEFAULT 'klien'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `email`, `alamat`, `no_telp`, `username`, `password`, `role`) VALUES
(1, 'Taris Yolanda Shafira', 'rizky01011991@gmail.com', '', '', 'yola1', 'yola1', 'admin'),
(2, 'Taris Yolanda', 'rizkyfahrezi210804@gmail.com', 'DSN VII SUKAMAJU NATAR', '085173200421', 'taris1', 'taris1', 'klien'),
(3, 'Rizky Fahrezi', 'rizkyfahrezi210804@gmail.com', 'DSN VII SUKAMAJU NATAR', '085173200421', 'rizky666', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `fk_bookings_service` (`id_service`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id_gallery`),
  ADD KEY `fk_gallery_service` (`id_service`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id_service`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id_gallery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_bookings_service` FOREIGN KEY (`id_service`) REFERENCES `services` (`id_service`) ON UPDATE CASCADE;

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `fk_gallery_service` FOREIGN KEY (`id_service`) REFERENCES `services` (`id_service`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

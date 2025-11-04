-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2025 at 06:55 PM
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
-- Database: `sablon_custom`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `bahan` varchar(100) DEFAULT NULL,
  `ukuran_sablon` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `id_user`, `id_produk`, `warna`, `size`, `quantity`, `bahan`, `ukuran_sablon`, `deskripsi`, `gambar`, `created_at`) VALUES
(11, 2, 7, '#ffffff', 'S', 1, 'dasda', '20x70', 'dasda', 'assets/uploads/img_6908ec2924be1.jpg', '2025-11-03 17:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_harga` decimal(12,2) DEFAULT NULL,
  `metode_pembayaran` enum('Mandiri','BCA','BRI') DEFAULT 'Mandiri',
  `status` enum('Menunggu Pembayaran','Sudah Dibayar','Selesai') DEFAULT 'Menunggu Pembayaran'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `tanggal`, `total_harga`, `metode_pembayaran`, `status`) VALUES
(1, 2, '2025-11-02 06:15:13', 680000.00, '', 'Selesai'),
(2, 4, '2025-11-02 06:29:33', 3400000.00, '', 'Selesai'),
(3, 4, '2025-11-02 11:43:41', 75000.00, '', 'Menunggu Pembayaran'),
(4, 4, '2025-11-02 11:47:46', 75000.00, '', 'Menunggu Pembayaran'),
(5, 4, '2025-11-02 11:51:45', 75000.00, '', 'Menunggu Pembayaran'),
(6, 4, '2025-11-02 11:57:02', 450000.00, '', 'Menunggu Pembayaran'),
(7, 2, '2025-11-02 13:11:13', 1500000.00, '', 'Selesai'),
(8, 2, '2025-11-03 17:51:46', 450000.00, '', 'Menunggu Pembayaran');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `harga` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `id_order`, `id_produk`, `quantity`, `harga`) VALUES
(3, 3, 6, 1, 75000.00),
(4, 4, 6, 1, 75000.00),
(5, 5, 6, 1, 75000.00),
(6, 6, 7, 10, 45000.00),
(7, 7, 6, 20, 75000.00),
(8, 8, 7, 10, 45000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kategori` enum('Kaos Custom','Topi Bordir','Jaket Hoodie','Kemeja Custom') NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama_produk`, `kategori`, `harga`, `deskripsi`, `foto`, `created_at`) VALUES
(6, 'Kaos Sablon Custom', 'Kaos Custom', 75000.00, 'Nyaman Dipakai', 'KaosSablonCustom.jpg', '2025-11-02 06:59:18'),
(7, 'Topi Bordir Custom', 'Topi Bordir', 45000.00, 'Topi Bordir Custom', 'TopiBordirCustom.jpg', '2025-11-02 07:00:50'),
(8, 'Jaket Hoodie Custom', 'Jaket Hoodie', 120000.00, 'Jaket Hoodie Custom', 'JaketHodieCustom.jpg', '2025-11-02 07:01:39'),
(9, 'Baju baru', 'Kaos Custom', 200000.00, 'Baju baruuuu', 'model4.jpg', '2025-11-02 13:15:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_wa` varchar(20) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `no_wa`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@sablonku.com', '$2y$10$dummyhashpassword', '08123456789', 'admin', '2025-11-02 05:50:51'),
(2, 'khilqi', 'khilqialfadhillah@gmail.com', '$2y$10$W317BkyZUgftDqL987iHG.AeLdAxXp0QECf8KujOSJpsAIgZiA8ju', '085776183609', 'user', '2025-11-02 06:13:28'),
(3, 'admin', 'admin@gmail.com', '$2y$10$49TcG/lWfPoFphVJZdq1seYtbG.jx.cDGMmyoREXGzTlXAPkIseMG', '', 'admin', '2025-11-02 06:20:13'),
(4, 'khairunnisa', 'khairunnisa@gmai.com', '$2y$10$8GBWsuiUzgg/FpDV1o9xuuFS7wlhDlRlXYyMlipKqXTEZat/0Oarm', '12345678', 'user', '2025-11-02 06:25:31'),
(5, 'anak baik', '232165139@student.unsil.ac.id', '$2y$10$yQpC/h7R1c/bBJ8QA0GeI.GQ6ZjKHdb5wuefi8RkFfVgSKrRyd76u', '087714614972', 'user', '2025-11-02 13:29:07'),
(6, 'alfa', 'alfa@gmail.com', '$2y$10$DidXAJ45sHHWgTs79R7DwOn4MEK5JjLn4.C0iVkfHwssg7mME2UqO', '12345678', 'user', '2025-11-02 13:29:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

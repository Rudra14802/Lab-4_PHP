-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 09:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `guitar_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `guitars`
--

CREATE TABLE `guitars` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guitars`
--

INSERT INTO `guitars` (`id`, `name`, `price`, `quantity`, `image_path`, `created_at`, `image`) VALUES
(4, 'latest', 187.00, 13, NULL, '2025-02-08 03:08:22', NULL),
(5, 'AA', 111.00, 10, NULL, '2025-02-08 03:17:47', NULL),
(7, 'guitar11', 1111.00, 1110, NULL, '2025-02-08 17:04:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `created_at`) VALUES
(1, 1, 187.00, '2025-02-08 03:16:38'),
(2, 1, 187.00, '2025-02-08 03:16:58'),
(3, 1, 561.00, '2025-02-08 03:17:20'),
(4, 1, 187.00, '2025-02-08 03:18:39'),
(5, 1, 111.00, '2025-02-08 03:41:10'),
(6, 1, 561.00, '2025-02-08 16:52:12'),
(7, 1, 187.00, '2025-02-08 16:55:13'),
(8, 1, 111.00, '2025-02-08 17:02:12'),
(9, 1, 187.00, '2025-02-08 17:02:43'),
(10, 1, 187.00, '2025-02-08 17:03:10'),
(11, 1, 1111.00, '2025-02-08 17:14:44'),
(12, 1, 111.00, '2025-02-08 20:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `guitar_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `guitar_id`, `quantity`, `price`) VALUES
(1, 4, 1, 187.00),
(2, 4, 1, 187.00),
(3, 4, 3, 187.00),
(4, 4, 1, 187.00),
(5, 5, 1, 111.00),
(6, 4, 3, 187.00),
(7, 4, 1, 187.00),
(8, 5, 1, 111.00),
(9, 4, 1, 187.00),
(10, 4, 1, 187.00),
(11, 7, 1, 1111.00),
(12, 5, 1, 111.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`, `password`) VALUES
(1, 'Rudra', 'rudpoatel14802@gmail.com', '$2y$10$d1QXElinqHQIb6f6qN45d.jiCQxnWMowexEzr6pC2H2..llKcJMiW', '2025-02-08 02:44:08', ''),
(2, 'Rudr', 'rudpatel14802@gmail.com', '$2y$10$L.2P8hR/YcyRftIN8uUxou7qrSIxQZwBjXG2npMOOg1Kfj8PTU8Lq', '2025-02-08 02:59:36', ''),
(3, 'Rud', '', '', '2025-02-08 03:07:12', '$2y$10$R6Nm9Rika6z7oATmClQoVeSL.0O8C6bvr6Gh1UlqFWf6qvZzURkna'),
(4, 'RP', '', '', '2025-02-08 03:07:46', '$2y$10$0Ex1TbFr1ziUduy2d0FVPOiNLJ4fEIYitRZbAMpyLX0XeYA9GypUq'),
(5, 'Anuj', '', '', '2025-02-08 03:19:34', '$2y$10$peXkh6dd.CFGXjuWAALfQOPSujh/odtHJPTMgKswV5arBOymoCDlC'),
(6, 'Jainil', '', '', '2025-02-08 17:13:54', '$2y$10$1YMsxNdFSxnmZFPW.YFXz.MIpxmZvHFfa0W4JICt2MUMG77LQG2Ze');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guitars`
--
ALTER TABLE `guitars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`,`guitar_id`),
  ADD UNIQUE KEY `order_id` (`order_id`,`guitar_id`),
  ADD KEY `order_items_ibfk_2` (`guitar_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guitars`
--
ALTER TABLE `guitars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`guitar_id`) REFERENCES `guitars` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

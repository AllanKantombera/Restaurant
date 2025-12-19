-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 02:00 PM
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
-- Database: `aunt_joy`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Appetizers', 'appetizer', '2025-11-22 23:47:07', '2025-11-29 10:42:10'),
(2, 'Main Course', 'main course', '2025-11-21 23:47:07', '2025-11-29 10:42:18'),
(3, 'Desserts', 'desserts', '2025-11-21 23:47:07', '2025-11-29 10:42:36'),
(4, 'Beverages', 'beverages', '2025-11-21 23:47:07', '2025-11-29 10:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image_url` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `category_id`, `name`, `description`, `price`, `image_url`, `is_available`, `created_at`, `updated_at`) VALUES
(5, 1, 'Rice', 'rice', 5000.00, '1764028225_Gemini_Generated_Image_ibl6rxibl6rxibl6.png', 0, '2025-11-24 23:50:25', '2025-12-18 12:59:22'),
(6, 1, 'Nsima', 'nsima', 4000.00, '1764057847_istockphoto-1295387240-612x612.jpg', 1, '2025-11-25 08:04:07', '2025-12-18 12:59:14'),
(16, 2, 'Kirombero Rice', 'rice', 2000.00, '1764077202_6925ae9287e35.jpg', 1, '2025-11-25 13:26:42', '2025-12-18 12:58:56'),
(17, 2, 'Tea', 'tea', 2000.00, '1764080864_6925bce0b8b04.jpg', 1, '2025-11-25 14:27:44', '2025-12-18 12:58:48'),
(22, 1, 'nsima', 'nsima', 3000.00, '1764403487_692aa91f2f969.jpg', 1, '2025-11-29 08:04:47', '2025-12-18 12:59:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('Pending','Preparing','Out for Delivery','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
  `assigned_sales_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `location` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `delivery_address`, `total_amount`, `status`, `assigned_sales_id`, `created_at`, `updated_at`, `location`) VALUES
(1, 4, 'Area 1B', 23000.00, 'Delivered', NULL, '2025-11-24 22:28:31', '2025-12-18 11:58:43', '-13.9657216,33.7707008'),
(2, 4, 'kandaha', 6000.00, 'Pending', NULL, '2025-12-08 22:30:51', '2025-12-08 22:30:51', 'kandaha'),
(3, 8, 'Paramount', 13000.00, 'Pending', NULL, '2025-12-08 23:02:32', '2025-12-18 11:59:37', 'Paramount lodge'),
(4, 10, 'mzuni', 4000.00, 'Preparing', NULL, '2025-12-10 11:21:02', '2025-12-18 11:55:40', 'mzuni'),
(5, 4, 'kandaha', 4000.00, 'Cancelled', NULL, '2025-12-10 11:41:47', '2025-12-17 10:25:34', 'kandaha'),
(6, 4, 'Area 1B', 12000.00, 'Out for Delivery', NULL, '2025-12-13 10:11:54', '2025-12-18 11:59:23', '-13.9657216,33.7707008'),
(7, 7, 'mzuni, kandaha', 5000.00, 'Pending', NULL, '2025-12-13 10:47:49', '2025-12-18 11:56:58', ' (-15.7879694,35.0133228)'),
(20, 4, 'hngyhy', 11000.00, 'Pending', NULL, '2025-12-17 13:31:46', '2025-12-18 11:58:23', '-13.9657216,33.7707008'),
(21, 4, 'mzuni', 12000.00, 'Pending', NULL, '2025-12-17 13:36:40', '2025-12-18 11:58:18', '-13.9657216,33.7707008'),
(24, 12, 'mznz', 5000.00, 'Pending', NULL, '2025-12-17 13:41:13', '2025-12-18 11:58:15', '-13.9657216,33.7707008'),
(25, 5, 'mzuzu', 6000.00, 'Pending', NULL, '2025-12-17 13:41:39', '2025-12-18 11:59:09', '-13.9657216,33.7707008'),
(26, 6, 'mzuni', 26455.00, 'Pending', NULL, '2025-12-17 13:55:53', '2025-12-18 11:59:02', NULL),
(27, 4, 'Area 1B', 6000.00, 'Pending', NULL, '2025-12-17 14:53:15', '2025-12-18 11:58:05', '-13.9657216,33.7707008'),
(28, 6, 'Area 1B', 6455.00, 'Pending', NULL, '2025-12-17 15:06:12', '2025-12-18 11:56:39', '-15.7879694,35.0133228'),
(29, 4, 'mznz', 5000.00, 'Pending', NULL, '2025-12-17 15:10:55', '2025-12-18 11:58:01', '-13.9657216,33.7707008'),
(30, 9, 'mzuni, kandaha', 3455.00, 'Delivered', NULL, '2025-12-18 10:55:32', '2025-12-18 11:56:05', '-13.9657216,33.7707008'),
(31, 11, 'mzuni, kandaha', 5000.00, 'Pending', NULL, '2025-12-18 11:11:53', '2025-12-18 11:55:54', '-13.9657216,33.7707008'),
(32, 9, 'mzuni', 16000.00, 'Pending', NULL, '2025-12-18 11:14:08', '2025-12-18 11:56:01', '-13.9657216,33.7707008'),
(33, 4, 'mzuni', 8000.00, 'Pending', NULL, '2025-12-18 11:19:25', '2025-12-18 11:57:57', '-13.9657216,33.7707008'),
(34, 4, 'mzuni', 19000.00, 'Pending', NULL, '2025-12-18 11:20:59', '2025-12-18 11:20:59', '-13.9657216,33.7707008');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `meal_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `line_total` decimal(12,2) GENERATED ALWAYS AS (`quantity` * `unit_price`) VIRTUAL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `meal_id`, `quantity`, `unit_price`, `created_at`) VALUES
(1, 1, 22, 1, 3000.00, '2025-12-08 22:28:31'),
(2, 1, 17, 10, 2000.00, '2025-12-08 22:28:31'),
(3, 2, 17, 3, 2000.00, '2025-12-08 22:30:51'),
(4, 3, 22, 1, 3000.00, '2025-12-08 23:02:32'),
(5, 3, 17, 5, 2000.00, '2025-12-08 23:02:32'),
(6, 4, 16, 1, 2000.00, '2025-12-10 11:21:02'),
(7, 4, 17, 1, 2000.00, '2025-12-10 11:21:02'),
(8, 5, 16, 1, 2000.00, '2025-12-10 11:41:47'),
(9, 5, 17, 1, 2000.00, '2025-12-10 11:41:47'),
(10, 6, 17, 6, 2000.00, '2025-12-13 10:11:55'),
(11, 7, 22, 1, 3000.00, '2025-12-13 10:47:49'),
(12, 7, 17, 1, 2000.00, '2025-12-13 10:47:49'),
(13, 20, 22, 3, 3000.00, '2025-12-17 13:31:46'),
(14, 20, 17, 1, 2000.00, '2025-12-17 13:31:46'),
(15, 21, 22, 2, 3000.00, '2025-12-17 13:36:40'),
(16, 21, 17, 2, 2000.00, '2025-12-17 13:36:40'),
(17, 21, 16, 1, 2000.00, '2025-12-17 13:36:40'),
(18, 24, 22, 1, 3000.00, '2025-12-17 13:41:13'),
(19, 24, 17, 1, 2000.00, '2025-12-17 13:41:13'),
(20, 25, 22, 2, 3000.00, '2025-12-17 13:41:39'),
(21, 26, 22, 6, 3000.00, '2025-12-17 13:55:53'),
(22, 26, 17, 2, 2000.00, '2025-12-17 13:55:54'),
(23, 26, 16, 2, 2000.00, '2025-12-17 13:55:54'),
(24, 26, 6, 1, 455.00, '2025-12-17 13:55:54'),
(25, 4, 16, 1, 2000.00, '2025-12-17 14:53:15'),
(26, 4, 17, 2, 2000.00, '2025-12-17 14:53:15'),
(27, 4, 6, 1, 455.00, '2025-12-17 15:06:12'),
(28, 4, 22, 2, 3000.00, '2025-12-17 15:06:12'),
(29, 4, 22, 1, 3000.00, '2025-12-17 15:10:56'),
(30, 4, 17, 1, 2000.00, '2025-12-17 15:10:56'),
(31, 7, 6, 1, 455.00, '2025-12-18 10:55:32'),
(32, 7, 22, 1, 3000.00, '2025-12-18 10:55:32'),
(33, 4, 22, 1, 3000.00, '2025-12-18 11:11:53'),
(34, 4, 17, 1, 2000.00, '2025-12-18 11:11:53'),
(35, 6, 22, 4, 3000.00, '2025-12-18 11:14:08'),
(36, 6, 17, 1, 2000.00, '2025-12-18 11:14:08'),
(37, 6, 16, 1, 2000.00, '2025-12-18 11:14:08'),
(38, 4, 17, 4, 2000.00, '2025-12-18 11:19:25'),
(39, 4, 22, 5, 3000.00, '2025-12-18 11:21:00'),
(40, 4, 17, 1, 2000.00, '2025-12-18 11:21:00'),
(41, 4, 16, 1, 2000.00, '2025-12-18 11:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-11-22 16:08:37', '2025-12-18 09:50:58'),
(2, 'manager', '2025-11-22 16:09:01', '2025-11-24 14:00:20'),
(3, 'sales', '2025-11-22 14:00:39', '2025-11-24 14:00:49'),
(4, 'customer', '2025-11-22 14:00:39', '2025-11-24 14:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT 4,
  `name` varchar(120) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `phone`, `email`, `password`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 3, 'john banda', '0995764949', 'banda@gmail.com', '$2y$10$zuFfgP6TU7axQuIPgMgWSuHRag8X0OK3sXJoFw207KyApk447DGsu', 1, '2025-11-24 16:39:12', '2025-12-18 09:54:26'),
(5, 2, 'mike phiri', '0995764949', 'phiri@gmail.com', '$2y$10$vW9zzslbPfJcV/hMMm/1uOV3tDmT.l/4NMqa6T6S404Vu7pUD.9VG', 1, '2025-11-25 13:49:00', '2025-12-18 09:54:38'),
(6, 4, 'canto', '0999673750', 'canto@gmail.com', '$2y$10$EAf.B4VoVuc4Pu48..ZOs.L5zOZRyypE8U8FDyC2/F0eKDb6VavGq', 1, '2025-11-25 13:55:22', '2025-12-18 09:55:12'),
(7, 1, 'allan canto', '0999673750', 'admin@gmail.com', '$2y$10$DNyGaeRNmnwNGm9cxGUqreOTN56t7TwYfZFjvLOgz8KeVmtAIs/8i', 1, '2025-11-25 14:29:27', '2025-11-26 10:28:16'),
(8, 4, 'vitumbiko', '0999673750', 'vitu@gmail.com', '$2y$10$SIQ3bYzLdWPn6ZbByxXWEuik9xqRZ1DUnf09nTQODbvea0McnwXKS', 0, '2025-11-25 14:30:54', '2025-12-18 09:53:24'),
(9, 4, 'mary', '0998762542', 'mary8@gmail.com', '$2y$10$je3g76Dt4UD4iVrk.8xqheGACp770YCVI1PEL4VxUJ.EO/1h/jgPy', 1, '2025-11-25 15:57:23', '2025-12-18 09:54:50'),
(10, 4, 'charles', '0999653652', 'charles1@gmail.com', '$2y$10$lyfzO96FqPt0y1/49Ke9puzzMe6vvoEs/to/bxnRBtl337s.vbiDe', 1, '2025-11-25 16:01:28', '2025-12-18 09:55:00'),
(11, 2, 'john banda', '09991234567', 'john@gmail.com', '$2y$10$dL80W/SfKZ5uxe5plPwP8uHCvaqdv0lIu57Jeh6HuO3cg6t471G.C', 0, '2025-11-26 11:30:43', '2025-11-26 11:30:56'),
(12, 4, 'victor', '0999682648', 'customer2@gmail.com', '$2y$10$2NiBECe3y1daqR2w/bp0feGCTRWuI4r4pJfQoLP9Uoh27pFwayPOi', 1, '2025-11-26 11:31:48', '2025-12-18 09:52:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_sales_id` (`assigned_sales_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meal_id` (`meal_id`),
  ADD KEY `idx_order_id` (`order_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `meals`
--
ALTER TABLE `meals`
  ADD CONSTRAINT `meals_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`assigned_sales_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

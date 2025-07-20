-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2025 at 03:44 AM
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
-- Database: `srs_testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `user_id`, `name`, `email`, `subject`, `message`, `sent_at`) VALUES
(1, 7, 'fatima', 'fatima@gmail.com', 'drtfygu', 'fatima', '2025-07-19 05:01:20'),
(2, 9, 'fatima', 'fatima@gmail.com', 'drtfygu', 'fatima', '2025-07-19 05:02:44'),
(3, 7, 'tywuejadx', 'xrth@gmail.com', 'xrn', 'dhxfcjgvhb,jn.m,. xrctfgyujhm, tdfyguhijm cdfguhjm ctyujh', '2025-07-20 00:59:16'),
(4, 9, 'tywuejadx', 'xrth@gmail.com', 'xrn', 'dhxfcjgvhb,jn.m,. xrctfgyujhm, tdfyguhijm cdfguhjm ctyujh', '2025-07-20 01:08:30');

-- --------------------------------------------------------

--
-- Table structure for table `durability_tests`
--

CREATE TABLE `durability_tests` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `drop_test` tinyint(1) DEFAULT NULL,
  `water_resistance` tinyint(1) DEFAULT NULL,
  `material_strength` tinyint(1) DEFAULT NULL,
  `status` enum('Pass','Fail') DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `tested_by` varchar(100) DEFAULT NULL,
  `tested_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `durability_tests`
--

INSERT INTO `durability_tests` (`id`, `product_id`, `drop_test`, `water_resistance`, `material_strength`, `status`, `remarks`, `tested_by`, `tested_at`) VALUES
(1, 2, 0, 1, 1, 'Fail', 'tfyu', NULL, '2025-07-18 22:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `heat_tests`
--

CREATE TABLE `heat_tests` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `heat_resistance` tinyint(1) DEFAULT NULL,
  `temperature_tolerance` tinyint(1) DEFAULT NULL,
  `overheating_protection` tinyint(1) DEFAULT NULL,
  `status` enum('Pass','Fail') DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `tested_by` varchar(100) DEFAULT NULL,
  `tested_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `heat_tests`
--

INSERT INTO `heat_tests` (`id`, `product_id`, `heat_resistance`, `temperature_tolerance`, `overheating_protection`, `status`, `remarks`, `tested_by`, `tested_at`) VALUES
(1, 2, 1, 1, 0, 'Pass', 'ctfyhij', NULL, '2025-07-18 22:20:39'),
(2, 4, 0, 0, 0, 'Pass', '', NULL, '2025-07-19 17:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_code` varchar(20) DEFAULT NULL,
  `revision` varchar(10) DEFAULT NULL,
  `manufacture_no` varchar(10) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `test_type` varchar(50) DEFAULT NULL,
  `tested_by` varchar(100) DEFAULT NULL,
  `tested_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `product_id`, `product_name`, `description`, `created_at`, `product_code`, `revision`, `manufacture_no`, `status`, `remarks`, `test_type`, `tested_by`, `tested_at`) VALUES
(2, 7, 'efdwedfwfb', '', 'egfgb', '2025-07-12 18:22:48', 'efd', 'wedf', 'wfb4', NULL, NULL, NULL, NULL, NULL),
(3, 8, 'fefbalisha', '', 'ergdghn v', '2025-07-12 18:23:39', 'fefb', 'alisha', 'dfghn', NULL, NULL, NULL, NULL, NULL),
(4, 7, 'fatimfatim', '', 'fatim', '2025-07-12 18:26:01', 'fatim', 'fatim', 'fatim', NULL, NULL, NULL, NULL, NULL),
(5, 7, '', '', '', '2025-07-13 06:11:54', '', '', '', 'Pending', NULL, NULL, NULL, NULL),
(9, 7, '5413553947', 'swith', 'swich', '2025-07-13 18:39:07', 'l123', '234', 'mnfg444445', 'Pending', NULL, NULL, NULL, NULL),
(10, 7, '5199829902', 'capisitor', 'capisitor', '2025-07-13 20:06:48', 'capisitor', 'capisitor', 'capisitor1', 'Pending', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `test_id` varchar(12) DEFAULT NULL,
  `test_type` enum('Voltage','Heat','Durability') NOT NULL,
  `tester_name` varchar(100) NOT NULL,
  `result` enum('Passed','Failed') NOT NULL,
  `remarks` text DEFAULT NULL,
  `tested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `voltage_level` varchar(255) DEFAULT NULL,
  `temperature` varchar(255) DEFAULT NULL,
  `durability_time` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `tested_by` varchar(100) DEFAULT NULL,
  `voltage_tests` text DEFAULT NULL,
  `heat_tests` text DEFAULT NULL,
  `durability_tests` text DEFAULT NULL,
  `test_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `product_id`, `test_id`, `test_type`, `tester_name`, `result`, `remarks`, `tested_at`, `voltage_level`, `temperature`, `durability_time`, `status`, `tested_by`, `voltage_tests`, `heat_tests`, `durability_tests`, `test_date`) VALUES
(5, 3, '', 'Voltage', '', 'Passed', 'fatimaa', '2025-07-12 20:12:21', '35', NULL, NULL, 'Passed', 'fjsdkfn,dx', NULL, NULL, NULL, '2025-07-17 18:54:03'),
(9, 9, '135750823741', 'Voltage', '', 'Passed', 'good', '2025-07-13 18:42:06', '1234', NULL, NULL, 'Passed', 'fatima', NULL, NULL, NULL, '2025-07-17 18:54:03'),
(10, 9, '755738150633', 'Voltage', '', 'Passed', 'goood', '2025-07-13 18:42:26', '223', NULL, NULL, 'Passed', 'fatima', NULL, NULL, NULL, '2025-07-17 18:54:03'),
(11, 9, '996953778850', 'Heat', '', 'Passed', 'udbsnx,z', '2025-07-13 18:42:43', NULL, 'v482389', NULL, 'Failed', 'dx', NULL, NULL, NULL, '2025-07-17 18:54:03'),
(12, 9, '986972414488', 'Voltage', '', 'Passed', 'good', '2025-07-13 18:45:35', '123', NULL, NULL, 'Passed', 'fatima', NULL, NULL, NULL, '2025-07-17 18:54:03'),
(13, 9, '014338149922', 'Voltage', '', 'Passed', 'rgudfizxl', '2025-07-13 18:47:20', '123', NULL, NULL, 'Failed', 'efusdhiz', NULL, NULL, NULL, '2025-07-17 18:54:03'),
(15, 9, '674603626389', 'Voltage', '', 'Passed', 'rthgjm ', '2025-07-13 19:54:27', '45384', NULL, NULL, 'Passed', 't5yhn ', NULL, NULL, NULL, '2025-07-17 18:54:03'),
(17, 3, '162188307532', 'Durability', '', 'Passed', 'ctyvuj,', '2025-07-13 20:00:54', NULL, NULL, 'ctyvubjn,', 'Passed', 'ctyvubjnk,', NULL, NULL, NULL, '2025-07-17 18:54:03'),
(18, 10, '996230461550', 'Voltage', '', 'Passed', '123', '2025-07-13 20:08:02', '123', NULL, NULL, 'Passed', '123', NULL, NULL, NULL, '2025-07-17 18:54:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','manufacturer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `company_name` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `company_name`, `profile_pic`, `profile_picture`, `address`, `phone_number`, `city`, `country`, `website`, `phone`, `gender`, `birthday`) VALUES
(6, 'Test User', 'test@demo.com', '12345', 'manufacturer', '2025-07-12 18:22:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '', '', '123', 'manufacturer', '2025-07-12 18:22:33', NULL, '687c3b380089b_ChatGPT Image Jul 17, 2025, 11_59_34 AM.png', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'alisha', 'alisha@gmail.com', '123', 'manufacturer', '2025-07-12 18:23:20', '', '687c45bdba939_How to draw a Girl Mask with cap -Hide Face Drawing __ Pencil sketch for beginner __ Girl drawing.jpg', NULL, '', '976421', '', '', '', '97653285', 'Male', '0000-00-00'),
(9, 'Admin', 'admin@example.com', 'admin123', 'admin', '2025-07-12 18:28:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `voltage_tests`
--

CREATE TABLE `voltage_tests` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `voltage_level` tinyint(1) DEFAULT NULL,
  `voltage_stability` tinyint(1) DEFAULT NULL,
  `voltage_spike_protection` tinyint(1) DEFAULT NULL,
  `status` enum('Pass','Fail') DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `tested_by` varchar(100) DEFAULT NULL,
  `tested_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voltage_tests`
--

INSERT INTO `voltage_tests` (`id`, `product_id`, `voltage_level`, `voltage_stability`, `voltage_spike_protection`, `status`, `remarks`, `tested_by`, `tested_at`) VALUES
(1, 2, 1, 0, 1, 'Pass', 'fx', NULL, '2025-07-18 22:20:32'),
(2, 4, 0, 0, 0, 'Pass', '', NULL, '2025-07-19 17:48:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `durability_tests`
--
ALTER TABLE `durability_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `heat_tests`
--
ALTER TABLE `heat_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_id` (`test_id`),
  ADD UNIQUE KEY `test_id_2` (`test_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `voltage_tests`
--
ALTER TABLE `voltage_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `durability_tests`
--
ALTER TABLE `durability_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `heat_tests`
--
ALTER TABLE `heat_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `voltage_tests`
--
ALTER TABLE `voltage_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `durability_tests`
--
ALTER TABLE `durability_tests`
  ADD CONSTRAINT `durability_tests_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `heat_tests`
--
ALTER TABLE `heat_tests`
  ADD CONSTRAINT `heat_tests_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `fk_test_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `voltage_tests`
--
ALTER TABLE `voltage_tests`
  ADD CONSTRAINT `voltage_tests_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

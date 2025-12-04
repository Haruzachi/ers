-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 02:00 AM
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
-- Database: `response`
--

-- --------------------------------------------------------

--
-- Table structure for table `emergency_notifications`
--

CREATE TABLE `emergency_notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `severity` varchar(20) DEFAULT 'Normal',
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `dispatched` tinyint(1) DEFAULT 0,
  `dispatched_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_notifications`
--

INSERT INTO `emergency_notifications` (`id`, `type`, `message`, `severity`, `lat`, `lng`, `dispatched`, `dispatched_at`, `created_at`, `updated_at`) VALUES
(1, 'Fire', 'Fire at Barangay Hall', 'High', 14.6500000, 121.0500000, 0, NULL, '2025-11-29 23:40:10', '2025-11-29 23:40:10'),
(2, 'Medical', 'Person fainted at market', 'Medium', 14.6512345, 121.0512345, 0, NULL, '2025-11-29 23:40:10', '2025-11-29 23:40:10'),
(3, 'Police', 'Robbery reported near park', 'High', 14.6523456, 121.0523456, 1, '2025-11-29 23:58:40', '2025-11-29 23:40:10', '2025-11-29 23:58:40');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `attempt_time` datetime NOT NULL,
  `successful` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `ip_address`, `email`, `attempt_time`, `successful`) VALUES
(43, '::1', 'dvonderick@gmail.com', '2025-11-10 01:53:27', 1),
(44, '::1', 'dvonderick@gmail.com', '2025-11-10 01:55:15', 1),
(45, '::1', 'dvonderick@gmail.com', '2025-11-10 02:05:12', 1),
(46, '::1', 'dvonderick@gmail.com', '2025-11-10 23:45:54', 1),
(47, '::1', 'dvonderick@gmail.com', '2025-11-14 04:07:59', 1),
(48, '::1', 'dvonderick@gmail.com', '2025-11-16 08:35:36', 1),
(49, '::1', 'dvonderick@gmail.com', '2025-11-16 18:58:19', 1),
(50, '::1', 'dvonderick@gmail.com', '2025-11-16 20:22:43', 1),
(51, '::1', 'dvonderick@gmail.com', '2025-11-29 22:50:37', 1),
(52, '::1', 'dvonderick@gmail.com', '2025-11-30 19:16:54', 1),
(53, '::1', 'dvonderick@gmail.com', '2025-11-30 19:21:14', 1),
(54, '::1', 'dvonderick@gmail.com', '2025-11-30 19:28:36', 1),
(55, '::1', 'dvonderick@gmail.com', '2025-12-04 08:58:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `registration_attempts`
--

CREATE TABLE `registration_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `attempt_time` datetime NOT NULL,
  `successful` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration_attempts`
--

INSERT INTO `registration_attempts` (`id`, `ip_address`, `email`, `attempt_time`, `successful`) VALUES
(10, '::1', 'dvonderick@gmail.com', '2025-11-10 01:06:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `suggested_routes`
--

CREATE TABLE `suggested_routes` (
  `id` int(11) NOT NULL,
  `notif_id` int(11) NOT NULL,
  `route` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('ADMIN','STAFF','USER') DEFAULT 'USER',
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_code` varchar(10) DEFAULT NULL,
  `code_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `username`, `contact`, `address`, `date_of_birth`, `email`, `password`, `role`, `is_verified`, `verification_code`, `code_expiry`, `created_at`, `updated_at`, `reset_token`, `token_expiry`) VALUES
(9, 'Von', 'Gulane', 'Dulfo', 'Von', '09458252517', '--------------', '2004-01-13', 'dvonderick@gmail.com', '$2y$12$qd8tLcUiPE9rkpjy75CRLuNKR/vrntyH8cUjRXlEUZmmyg74Rbj32', 'STAFF', 1, NULL, NULL, '2025-11-09 17:06:09', '2025-11-09 17:55:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `verification_codes`
--

CREATE TABLE `verification_codes` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `expiry` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verification_codes`
--

INSERT INTO `verification_codes` (`id`, `email`, `code`, `expiry`, `created_at`) VALUES
(23, 'dvonderick@gmail.com', '588033', '2025-11-09 18:21:09', '2025-11-09 17:06:09'),
(24, 'dvonderick@gmail.com', '106807', '2025-11-09 18:49:43', '2025-11-09 17:19:43'),
(25, 'dvonderick@gmail.com', '566209', '2025-11-09 19:06:18', '2025-11-09 17:36:18'),
(26, 'dvonderick@gmail.com', '302365', '2025-11-09 19:07:54', '2025-11-09 17:37:54'),
(27, 'dvonderick@gmail.com', '094474', '2025-11-09 19:09:52', '2025-11-09 17:39:52'),
(28, 'dvonderick@gmail.com', '976301', '2025-11-09 19:10:04', '2025-11-09 17:40:05'),
(29, 'dvonderick@gmail.com', '040663', '2025-11-09 19:10:21', '2025-11-09 17:40:21'),
(30, 'dvonderick@gmail.com', '257314', '2025-11-09 19:20:04', '2025-11-09 17:50:04'),
(31, 'dvonderick@gmail.com', '878041', '2025-11-09 19:20:17', '2025-11-09 17:50:17'),
(32, 'dvonderick@gmail.com', '730578', '2025-11-09 19:20:30', '2025-11-09 17:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_vehicles`
--

CREATE TABLE `volunteer_vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_name` varchar(100) NOT NULL,
  `type` enum('Fire','Medical','Rescue') NOT NULL,
  `status` enum('Available','On Duty','Maintenance') NOT NULL DEFAULT 'Available',
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_vehicles`
--

INSERT INTO `volunteer_vehicles` (`id`, `vehicle_name`, `type`, `status`, `available`, `last_update`) VALUES
(1, 'Fire Truck 1', 'Fire', 'Available', 1, '2025-11-29 16:15:30'),
(2, 'Fire Truck 2', 'Fire', 'On Duty', 0, '2025-11-29 16:15:30'),
(3, 'Ambulance 1', 'Medical', 'Available', 1, '2025-11-29 16:15:30'),
(4, 'Ambulance 2', 'Medical', 'Available', 1, '2025-11-29 16:15:30'),
(5, 'Rescue Van 1', 'Rescue', 'Available', 1, '2025-11-29 16:15:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emergency_notifications`
--
ALTER TABLE `emergency_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_time` (`ip_address`,`attempt_time`),
  ADD KEY `idx_time` (`attempt_time`);

--
-- Indexes for table `registration_attempts`
--
ALTER TABLE `registration_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_time` (`ip_address`,`attempt_time`),
  ADD KEY `idx_time` (`attempt_time`);

--
-- Indexes for table `suggested_routes`
--
ALTER TABLE `suggested_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_reset_token` (`reset_token`),
  ADD KEY `idx_token_expiry` (`token_expiry`);

--
-- Indexes for table `verification_codes`
--
ALTER TABLE `verification_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `volunteer_vehicles`
--
ALTER TABLE `volunteer_vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emergency_notifications`
--
ALTER TABLE `emergency_notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `registration_attempts`
--
ALTER TABLE `registration_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `suggested_routes`
--
ALTER TABLE `suggested_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `volunteer_vehicles`
--
ALTER TABLE `volunteer_vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2025 at 10:45 AM
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
-- Database: `lostandfound_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `claimed_items`
--

CREATE TABLE `claimed_items` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `claimant_user_id` int(11) DEFAULT NULL,
  `claimant_name` varchar(100) NOT NULL,
  `claimant_contact` varchar(20) NOT NULL,
  `date_claimed` datetime DEFAULT current_timestamp(),
  `verified_by` int(11) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','approved','declined') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `claimed_items`
--

INSERT INTO `claimed_items` (`id`, `item_id`, `claimant_name`, `claimant_contact`, `date_claimed`, `verified_by`, `notes`, `status`) VALUES
(19, 23, 'hannahcamille', 'User ID: 1', '2025-10-31 08:02:45', 3, 'Claim request submitted through timeline by user: hannahcamille', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `found_items`
--

CREATE TABLE `found_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `founder_name` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `location` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','claimed','pending_claim') DEFAULT 'pending',
  `claimer_id` int(11) UNSIGNED DEFAULT NULL,
  `claimed_date` datetime DEFAULT NULL,
  `claimed_by` int(11) DEFAULT NULL,
  `claim_date` datetime DEFAULT NULL,
  `date_reported` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `found_items`
--

INSERT INTO `found_items` (`id`, `user_id`, `founder_name`, `contact_number`, `item_name`, `description`, `location`, `image`, `status`, `claimer_id`, `claimed_date`, `claimed_by`, `claim_date`, `date_reported`) VALUES
(23, 3, 'hannah camille cunanan', '09692322789`', 'iphone14 pro', 'sdfga', 'rgfesgh', '1761897704_f9d29fa88046a7d99b7b.png', 'claimed', 1, '2025-10-31 08:03:46', NULL, NULL, '2025-10-31 16:01:44'),
(24, 1, 'camila', '09461592782', 'rfgaertg', 'rgerge', 'eathedt', '1761897782_f215b8c151fd75e480cf.jpg', 'pending', NULL, NULL, NULL, NULL, '2025-10-31 16:03:02'),
(25, 1, 'hannah camille cunanan', '09692322789`', 'sdfsadfsa', 'gfdsagsdfg', 'sdfgsg', NULL, 'pending', NULL, NULL, NULL, NULL, '2025-10-31 16:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-10-31-020611', 'App\\Database\\Migrations\\AddClaimFieldsToFoundItems', 'default', 'App', 1761876560, 1),
(2, '2025-10-31-024446', 'App\\Database\\Migrations\\AddLocationToFoundItems', 'default', 'App', 1761878725, 2),
(3, '2025-10-31-034449', 'App\\Database\\Migrations\\AddClaimFieldsToFoundItems', 'default', 'App', 1761884188, 3),
(4, '2025-10-31-035541', 'App\\Database\\Migrations\\AddLocationToFoundItems', 'default', 'App', 1761884188, 3),
(5, '2025-10-31-041537', 'App\\Database\\Migrations\\AddClaimerFieldsToFoundItems', 'default', 'App', 1761884189, 3),
(6, '2025-10-31-042252', 'App\\Database\\Migrations\\UpdateFoundItemsStructure', 'default', 'App', 1761884615, 4),
(7, '2025-10-31-042320', 'App\\Database\\Migrations\\CreateClaimedItemsTable', 'default', 'App', 1761894692, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'hannahcamille', 'cunananhannahcamille@gmail.com', '$2y$10$9KaLHLkMR915sHzjEFXMYekFLtYv88UF85EBT/y7RCX7caXARJCgi', 'user', '2025-10-31 01:07:31'),
(3, 'hannahcamillecunanan', 'hannahcamillecunanan@gmail.com', '$2y$10$2UK/RsrDawKiY0S2WK3pPO0RNsvZDNAX7CokoQSrrduFOgUShxZ3e', 'admin', '2025-10-31 01:23:54'),
(4, 'jerwin', 'jerwinagustin032@gmail.com', '$2y$10$RJ0/6vAVL6FDIT3uGmH.BeCFv3ADYyIxhGlLpJukjvEMRNxedyEWe', 'user', '2025-10-31 02:53:34'),
(5, 'angiemallari', 'angiemallari@gmail.com', '$2y$10$WwvRLnEEy4yV6MjxabVu0uE0pRh/hyb7/CGTTTomgt/A990QDRQDu', 'user', '2025-10-31 05:38:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `claimed_items`
--
ALTER TABLE `claimed_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_item` (`item_id`);

--
-- Indexes for table `found_items`
--
ALTER TABLE `found_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
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
-- AUTO_INCREMENT for table `claimed_items`
--
ALTER TABLE `claimed_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `found_items`
--
ALTER TABLE `found_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `claimed_items`
--
ALTER TABLE `claimed_items`
  ADD CONSTRAINT `fk_item` FOREIGN KEY (`item_id`) REFERENCES `found_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `found_items`
--
ALTER TABLE `found_items`
  ADD CONSTRAINT `found_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2025 at 03:13 PM
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
-- Database: `url_shortener`
--

-- --------------------------------------------------------

--
-- Table structure for table `urls`
--

CREATE TABLE `urls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `original_url` varchar(2048) NOT NULL,
  `short_code` varchar(8) NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `urls`
--

INSERT INTO `urls` (`id`, `original_url`, `short_code`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'https://www.youtube.com/watch?v=9udS0mpi1L4&list=RD1TlHM1lR09o&index=5', 'Pj5o4Y', '2025-09-07 08:27:14', '2025-09-07 07:27:14', '2025-09-07 07:27:14'),
(2, 'https://www.youtube.com/watch?v=9udS0mpi1L4&list=RD1TlHM1lR09o&index=6', 'nhVKA3', '2025-09-07 07:34:22', '2025-09-07 07:33:22', '2025-09-07 07:33:22'),
(3, 'https://www.youtube.com/watch?v=9udS0mpi1L4&list=RD1TlHM1lR09o&index=6', '26Px8W', '2025-09-07 07:37:13', '2025-09-07 07:36:13', '2025-09-07 07:36:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `urls`
--
ALTER TABLE `urls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `urls_short_code_unique` (`short_code`),
  ADD KEY `urls_short_code_index` (`short_code`),
  ADD KEY `urls_original_url_index` (`original_url`(768));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `urls`
--
ALTER TABLE `urls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

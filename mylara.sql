-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2019 at 09:26 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mylara`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `description`, `address`, `pincode`, `city`, `country`, `state`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mukesh Jha', 'mukeshjh4@gmail.com', '$2y$10$Sir2RaE7Hq0nWQ.4MyFO5uEG5jpawiNUheWwzEsY1GFhuIt2SIf2y', '09891920779', '', '', '', 'Ghzabad', 'India', 'Uttar Pradesh', NULL, '2019-12-29 18:30:00', '2019-12-29 18:30:00'),
(2, 'Soni Jha', 'soni@gmail.com', 'soni@123', '0989 192 0779', 'Designer', 'R-1, Himalaya Tanishq, Raj nagar extension, Ghaziabad', '201017', 'Ghzabad', 'India', 'Uttar Pradesh', NULL, '2019-12-30 14:40:07', '2019-12-30 14:40:07'),
(3, 'Soni Jha', 'soni@gmail.com', 'test', '0989 192 0779', 'Designer', 'R-1, Himalaya Tanishq, Raj nagar extension, Ghaziabad', '201017', 'Ghzabad', 'India', 'Uttar Pradesh', NULL, '2019-12-30 14:42:04', '2019-12-30 14:42:04'),
(4, 'fsdfs', 'fdsf@dsf', 'fsdfs', 'fdsf', 'fdsff', 'D/o: Dilip Kumar JHA, Salampur, Po: Khaira kursela, State: Bihar, Contact no: 9891920779', '854101', 'KATIHAR', 'India', 'Yes', NULL, '2019-12-30 14:53:35', '2019-12-30 14:53:35'),
(5, 'cxcxzcxzc', 'fsdfsfsd', 'fdsfsfsd', 'fdsfs', 'fdsfds', 'fdsfsd', 'fdsfs', 'fdsf', 'fdsfs', 'fdsf', NULL, '2019-12-30 14:54:15', '2019-12-30 14:54:15'),
(6, 'fsdfsf', 'fdsfsf', 'fdsfs', 'fdsfs', 'fdsfds', 'fdsfsf', 'fdsfs', 'fdsfsd', 'fdsfds', 'fdsfs', NULL, '2019-12-30 14:54:58', '2019-12-30 14:54:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

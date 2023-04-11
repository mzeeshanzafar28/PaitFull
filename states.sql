-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2023 at 10:50 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `martinmobile`
--

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` mediumint(8) UNSIGNED NOT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fips_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `wikiDataId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rapid API GeoDB Cities'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`, `country_code`, `fips_code`, `iso2`, `type`, `latitude`, `longitude`, `created_at`, `updated_at`, `flag`, `wikiDataId`) VALUES
(3169, 'Islamabad Capital Territory', 167, 'PK', '08', 'IS', NULL, '33.72049970', '73.04052770', '2019-10-05 23:18:53', '2022-08-31 15:52:51', 1, 'Q848613'),
(3170, 'Gilgit-Baltistan', 167, 'PK', '07', 'GB', NULL, '35.80256670', '74.98318080', '2019-10-05 23:18:53', '2022-08-31 15:52:51', 1, 'Q200697'),
(3171, 'Khyber Pakhtunkhwa', 167, 'PK', '03', 'KP', NULL, '34.95262050', '72.33111300', '2019-10-05 23:18:53', '2022-08-31 15:52:51', 1, 'Q183314'),
(3172, 'Azad Kashmir', 167, 'PK', '06', 'JK', NULL, '33.92590550', '73.78103340', '2019-10-05 23:18:53', '2022-08-31 15:52:51', 1, 'Q200130'),
(3173, 'Federally Administered Tribal Areas', 167, 'PK', '01', 'TA', NULL, '32.66747600', '69.85974060', '2019-10-05 23:18:53', '2022-08-31 15:52:51', 1, 'Q208270'),
(3174, 'Balochistan', 167, 'PK', '02', 'BA', NULL, '28.49073320', '65.09577920', '2019-10-05 23:18:53', '2022-08-31 15:52:51', 1, 'Q163239'),
(3175, 'Sindh', 167, 'PK', '05', 'SD', NULL, '25.89430180', '68.52471490', '2019-10-05 23:18:53', '2022-08-31 15:52:51', 1, 'Q37211'),
(3176, 'Punjab', 167, 'PK', '04', 'PB', NULL, '31.14713050', '75.34121790', '2019-10-05 23:18:53', '2022-08-31 15:52:51', 1, 'Q4478');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_region` (`country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5134;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

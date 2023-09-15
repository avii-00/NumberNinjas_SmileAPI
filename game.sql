-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 20, 2023 at 05:20 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `game`
--

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `scores` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=387 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`id`, `username`, `scores`) VALUES
(360, 'Ravishan', '100'),
(385, 'Abiella', '50'),
(357, '123', '90'),
(356, 'avindi', '170'),
(355, 'admin', '300'),
(386, 'Shenaya', '40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$HMZz67gRkveWYUd9nkzMHejzAxPnwbAYZiwUElZ4ml5qY6Xdd//4S', '2023-03-03 00:04:18'),
(2, '123', '$2y$10$WFW6y5BvkCio0PP1DetML.sBVmO49vjZq3cq08WOhTwgewOXLNjxG', '2023-03-04 13:15:52'),
(20, 'avindi', '$2y$10$vHW5fu6wJG824LTm/4NwKeh2PU5XD99mMNCigvHx4kFw5nOmj7/W2', '2023-03-12 15:59:23'),
(67, 'Shenaya', '$2y$10$GVF7s9kPhVYWkchw7CmM6OmaaqB/jPieKjPDckWCRzgCa3CmrcUFi', '2023-04-20 20:27:16'),
(23, 'Ravishan', '$2y$10$GCqGhLpMxtmEySNpVgqp/O6yZKG9K0BiD7V/Uck6LR/FJw3gZrltO', '2023-03-16 22:07:31'),
(66, 'Abiella', '$2y$10$xM2xCHehHqId8SiKoj6ze.dpCbOhT4VwNkOBXzdPfssdTVBXzDlKy', '2023-04-20 18:13:41');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

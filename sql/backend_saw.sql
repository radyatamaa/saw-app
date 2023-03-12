-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2022 at 05:55 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `backend_saw`
--
CREATE DATABASE IF NOT EXISTS `backend_saw` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `backend_saw`;

-- --------------------------------------------------------

--
-- Table structure for table `alternative`
--

DROP TABLE IF EXISTS `alternative`;
CREATE TABLE IF NOT EXISTS `alternative` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `previous_company` varchar(255) NOT NULL DEFAULT '',
  `phone_number` varchar(25) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `current_job_position` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alternative_value`
--

DROP TABLE IF EXISTS `alternative_value`;
CREATE TABLE IF NOT EXISTS `alternative_value` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `alternative_id` int(11) DEFAULT NULL,
  `period_id` int(11) DEFAULT NULL,
  `period_name` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alternative_value_detail`
--

DROP TABLE IF EXISTS `alternative_value_detail`;
CREATE TABLE IF NOT EXISTS `alternative_value_detail` (
  `id` int(11) NOT NULL,
  `alternative_value_id` int(11) DEFAULT NULL,
  `criteria_id` int(11) DEFAULT NULL,
  `criteria_name` varchar(255) NOT NULL DEFAULT '',
  `weight_criteria` double NOT NULL DEFAULT '0',
  `sub_criteria_id` int(11) DEFAULT NULL,
  `sub_criteria_name` varchar(255) NOT NULL DEFAULT '',
  `point_sub_criteria` double NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

DROP TABLE IF EXISTS `criteria`;
CREATE TABLE IF NOT EXISTS `criteria` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `weight` double NOT NULL DEFAULT '0',
  `type` tinyint(2) DEFAULT NULL COMMENT '1 (benefit) , 2 (cost)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

DROP TABLE IF EXISTS `period`;
CREATE TABLE IF NOT EXISTS `period` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_criteria`
--

DROP TABLE IF EXISTS `sub_criteria`;
CREATE TABLE IF NOT EXISTS `sub_criteria` (
  `id` int(11) NOT NULL,
  `criteria_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `point` double NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(250) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Backend Manager', 'be-manager@gmail.com', '$2y$10$AMWjHF02ANmQMnyp2CNM9OT0BtSp8qvECx3tdRVrBmRhEwy71RroS', '2022-07-24 22:44:02', '2022-07-24 22:44:02', null);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternative`
--
ALTER TABLE `alternative`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alternative_value`
--
ALTER TABLE `alternative_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alternative_value_ibfk_1` (`period_id`),
  ADD KEY `alternative_value_ibfk_2` (`user_id`),
  ADD KEY `alternative_value_ibfk_3` (`alternative_id`);

--
-- Indexes for table `alternative_value_detail`
--
ALTER TABLE `alternative_value_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alternative_value_detail_ibfk_1` (`alternative_value_id`),
  ADD KEY `alternative_value_detail_ibfk_2` (`criteria_id`),
  ADD KEY `alternative_value_detail_ibfk_3` (`sub_criteria_id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_criteria`
--
ALTER TABLE `sub_criteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_criteria_ibfk_1` (`criteria_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternative`
--
ALTER TABLE `alternative`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `alternative_value`
--
ALTER TABLE `alternative_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `alternative_value_detail`
--
ALTER TABLE `alternative_value_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `period`
--
ALTER TABLE `period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sub_criteria`
--
ALTER TABLE `sub_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `alternative_value`
--
ALTER TABLE `alternative_value`
  ADD CONSTRAINT `alternative_value_ibfk_1` FOREIGN KEY (`period_id`) REFERENCES `period` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `alternative_value_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `alternative_value_ibfk_3` FOREIGN KEY (`alternative_id`) REFERENCES `alternative` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `alternative_value_detail`
--
ALTER TABLE `alternative_value_detail`
  ADD CONSTRAINT `alternative_value_detail_ibfk_1` FOREIGN KEY (`alternative_value_id`) REFERENCES `alternative_value` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `alternative_value_detail_ibfk_2` FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `alternative_value_detail_ibfk_3` FOREIGN KEY (`sub_criteria_id`) REFERENCES `sub_criteria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sub_criteria`
--
ALTER TABLE `sub_criteria`
  ADD CONSTRAINT `sub_criteria_ibfk_1` FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

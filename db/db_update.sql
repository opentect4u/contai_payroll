-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2025 at 06:19 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `contaiardb_payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `md_increment_dt`
--

DROP TABLE IF EXISTS `md_increment_dt`;
CREATE TABLE `md_increment_dt` (
  `id` int(11) NOT NULL,
  `created` date NOT NULL,
  `increment_id` int(11) NOT NULL,
  `payhead_id` int(11) NOT NULL,
  `percentage` float(10,2) NOT NULL,
  `amt_old` float(10,2) NOT NULL,
  `amt_new` float(10,2) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT 1,
  `lastupdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `md_increment_hd`
--

DROP TABLE IF EXISTS `md_increment_hd`;
CREATE TABLE `md_increment_hd` (
  `id` int(11) NOT NULL,
  `created` date NOT NULL,
  `emp_code` int(11) NOT NULL,
  `basic_old` float(10,2) NOT NULL,
  `basic_new` float(10,2) NOT NULL,
  `month` tinyint(2) NOT NULL,
  `year` varchar(4) NOT NULL,
  `isapplied` tinyint(1) NOT NULL DEFAULT 0,
  `isactive` tinyint(1) NOT NULL DEFAULT 1,
  `lastupdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `md_payhead_earning`
--

DROP TABLE IF EXISTS `md_payhead_earning`;
CREATE TABLE `md_payhead_earning` (
  `id` int(11) NOT NULL,
  `created` date NOT NULL,
  `payhead_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT 1,
  `lastupdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `td_other_deduction`
--

DROP TABLE IF EXISTS `td_other_deduction`;
CREATE TABLE `td_other_deduction` (
  `id` int(11) NOT NULL,
  `created` date NOT NULL,
  `emp_no` int(11) NOT NULL,
  `pay_head_id` int(11) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT 1,
  `lastupdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `md_increment_dt`
--
ALTER TABLE `md_increment_dt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_increment_hd`
--
ALTER TABLE `md_increment_hd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `md_payhead_earning`
--
ALTER TABLE `md_payhead_earning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `td_other_deduction`
--
ALTER TABLE `td_other_deduction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `md_increment_dt`
--
ALTER TABLE `md_increment_dt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `md_increment_hd`
--
ALTER TABLE `md_increment_hd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `md_payhead_earning`
--
ALTER TABLE `md_payhead_earning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `td_other_deduction`
--
ALTER TABLE `td_other_deduction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

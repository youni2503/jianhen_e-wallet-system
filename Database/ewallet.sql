-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 13, 2024 at 01:39 PM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ewallet`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `admin_password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`admin_id`, `admin_name`, `admin_password`, `created_at`, `admin_email`) VALUES
(1, 'Admin', 'P@ssw0rd', '2024-11-12 11:35:01', 'admin@gmail.com');
(2, 'Admin2', 'admin2', '2024-12-1 11:35:01', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `employee_email` varchar(255) NOT NULL,
  `employee_ewallet_balance` decimal(11,2) NOT NULL,
  `employee_password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `employee_name`, `employee_id`, `employee_email`, `employee_ewallet_balance`, `employee_password`, `created_at`) VALUES
(1, 'Kamarul', '999999', 'kamarul@gmail.com', '100.20', 'P@ssw0rd', '2024-11-12 09:01:15');

-- --------------------------------------------------------

--
-- Table structure for table `ewallet_transaction`
--

CREATE TABLE `ewallet_transaction` (
  `transaction_id` int(11) NOT NULL,
  `transaction_amount` decimal(11,2) DEFAULT NULL,
  `transaction_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vendor_id` int(30) DEFAULT NULL,
  `emp_id` int(30) DEFAULT NULL,
  `qr` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ewallet_transaction`
--

INSERT INTO `ewallet_transaction` (`transaction_id`, `transaction_amount`, `transaction_datetime`, `vendor_id`, `emp_id`, `qr`) VALUES
(1, '10.00', '2024-11-12 11:24:49', 1, 1, '622e6de977ef2a917e1d27'),
(2, '30.00', '2024-11-12 11:24:49', 1, 1, 'a5a8108f9c05fa00a04a67'),
(3, '20.00', '2024-11-13 08:48:52', 1, 1, NULL),
(4, '20.00', '2024-12-14 08:50:26', 1, 1, 'ab608415f92d8cbecae25d');

-- --------------------------------------------------------

--
-- Table structure for table `qrpay`
--

CREATE TABLE `qrpay` (
  `qr_id` int(11) NOT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `validity` datetime DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `payer_id` int(11) DEFAULT NULL,
  `status` enum('pending','expired','completed') DEFAULT 'pending',
  `pay_date` datetime DEFAULT NULL,
  `random_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `qrpay`
--

INSERT INTO `qrpay` (`qr_id`, `qrcode`, `amount`, `validity`, `vendor_id`, `payer_id`, `status`, `pay_date`, `random_code`) VALUES
(1, 'qrcode/67331ff950987.png', '100.00', '2024-11-12 17:34:29', 1, NULL, 'pending', NULL, NULL),
(2, 'qrcode/673331c5842d8.png', '100.00', '2024-11-12 18:50:25', 1, NULL, 'pending', NULL, NULL),
(3, 'qrcode/673332373a525.png', '100.00', '2024-11-12 18:52:19', 1, NULL, 'pending', NULL, NULL),
(4, 'qrcode/673332541c1c7.png', '100.00', '2024-11-12 18:52:48', 1, NULL, 'pending', NULL, NULL),
(5, 'qrcode/673332575cb8d.png', '100.00', '2024-11-12 18:52:51', 1, NULL, 'pending', NULL, NULL),
(6, 'qrcode/6733325f4e00f.png', '200.00', '2024-11-12 18:52:59', 1, NULL, 'pending', NULL, NULL),
(7, 'qrcode/673332d0a12d6.png', '200.00', '2024-11-12 18:54:52', 1, 2, 'completed', '2024-11-12 18:50:37', 'a297b24e46ddb25dadd2ca'),
(8, 'qrcode/673332e2cf2e0.png', '200.00', '2024-11-12 18:55:10', 1, NULL, 'pending', NULL, '23984f1e159406bac46c6f'),
(9, 'qrcode/6733332f0ae73.png', '100.00', '2024-11-12 18:56:27', 1, NULL, 'completed', NULL, 'c3e06eccea8c46fb70191c'),
(10, 'qrcode/6733335f4cc61.png', '100.00', '2024-11-12 18:57:15', 1, NULL, 'pending', NULL, '8205f988df483778088230'),
(11, 'qrcode/673333a36b8d5.png', '100.00', '2024-11-12 18:58:23', 1, NULL, 'pending', NULL, 'c3603863c88b04fc812596'),
(12, 'qrcode/67333461c5c86.png', '100.00', '2024-11-12 19:01:33', 1, NULL, 'pending', NULL, '5fe70c116413f64deab925'),
(13, 'qrcode/6733349365508.png', '100.00', '2024-11-12 19:02:23', 1, NULL, 'pending', NULL, 'b78c101fa87854fb9a2d81'),
(14, 'qrcode/673334d3e5242.png', '200.00', '2024-11-12 19:03:27', 1, NULL, 'pending', NULL, '4b189e34c18a1630211eea'),
(15, 'qrcode/673334fecba02.png', '100.00', '2024-11-12 19:04:10', 1, NULL, 'pending', NULL, 'f24d43df2ed0ab2f07bc82'),
(16, 'qrcode/6733352649afc.png', '100.00', '2024-11-12 19:04:50', 1, NULL, 'completed', NULL, '342113e5890cbd60b4ff73'),
(17, 'qrcode/673335a19a0b1.png', '100.00', '2024-11-12 19:06:53', 1, NULL, 'pending', NULL, '831412f82775f051f0426a'),
(18, 'qrcode/673335be06245.png', '200.00', '2024-11-12 19:07:22', 1, NULL, 'pending', NULL, '63f63396c4a6c0eff61145'),
(19, 'qrcode/673335d296236.png', '400.00', '2024-11-12 19:07:42', 1, NULL, 'pending', NULL, '75051184f9073cc095dec3'),
(20, 'qrcode/67333694627f1.png', '200.00', '2024-11-12 19:10:56', 1, NULL, 'pending', NULL, '2e7672b4dca33bae7e72fe'),
(21, 'qrcode/673336a96ea29.png', '100.00', '2024-11-12 19:11:17', 1, NULL, 'pending', NULL, 'caff02cf3d29385a3999d1'),
(22, 'qrcode/673336ecede67.png', '200.00', '2024-11-12 19:12:24', 1, NULL, 'pending', NULL, '07f515b55079419674ef76'),
(23, 'qrcode/67333715e0744.png', '100.00', '2024-11-12 19:13:05', 1, NULL, 'pending', NULL, 'dd4c6103508c996fde2c61'),
(24, 'qrcode/6733371a9b780.png', '100.00', '2024-11-12 19:13:10', 1, NULL, 'pending', NULL, 'ea3d7d25c269cf2c86722e'),
(25, 'qrcode/67333722c280d.png', '100.00', '2024-11-12 19:13:18', 1, NULL, 'pending', NULL, 'bd40870d83d1edda081be7'),
(26, 'qrcode/673337421c345.png', '100.00', '2024-11-12 19:13:50', 1, NULL, 'pending', NULL, 'c699fb26b8b8f5f2ed0c3e'),
(27, 'qrcode/673337590bb67.png', '100.00', '2024-11-12 19:14:13', 1, NULL, 'pending', NULL, 'b4a3bfe011198476ef7b20'),
(28, 'qrcode/67333764c94d8.png', '19.90', '2024-11-12 19:14:24', 1, NULL, 'pending', NULL, '4617ee57212f5d278b09cf'),
(29, 'qrcode/6733382bb7a15.png', '100.00', '2024-11-12 19:17:43', 1, NULL, 'pending', NULL, '3c7916ec26ede0d7710f8e'),
(30, 'qrcode/67333b39289b2.png', '10.00', '2024-11-12 19:30:45', 1, 1, 'completed', '2024-11-12 19:25:57', '622e6de977ef2a917e1d27'),
(31, 'qrcode/67333b5ec0125.png', '30.00', '2024-11-12 19:31:22', 1, 1, 'completed', '2024-11-12 19:26:30', 'a5a8108f9c05fa00a04a67'),
(32, 'qrcode/67345e6974090.png', '20.00', '2024-11-13 17:13:09', 1, 1, 'completed', '2024-11-13 16:50:26', 'ab608415f92d8cbecae25d'),
(33, 'qrcode/673469002cd4d.png', '20.90', '2024-11-13 16:58:20', 1, NULL, 'pending', NULL, '621af063a815348fecfb38'),
(34, 'qrcode/673469b5473b3.png', '20.90', '2024-11-13 17:01:21', 1, NULL, 'pending', NULL, 'aaf55d8c16d458cf530866');

-- --------------------------------------------------------

--
-- Table structure for table `system_autoreload`
--

CREATE TABLE `system_autoreload` (
  `auto_id` int(11) NOT NULL,
  `employee_id` int(30) DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_autoreload`
--

INSERT INTO `system_autoreload` (`auto_id`, `employee_id`, `amount`, `datetime`) VALUES
(3, 1, '200.00', '2024-11-12 19:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `Vendors`
--

CREATE TABLE `Vendors` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `vendor_password` varchar(255) NOT NULL,
  `vendor_ewallet_balance` decimal(11,2) NOT NULL,
  `vendor_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Vendors`
--

INSERT INTO `Vendors` (`vendor_id`, `vendor_name`, `vendor_password`, `vendor_ewallet_balance`, `vendor_email`, `created_at`) VALUES
(1, 'EasyShop Mini Mart', 'P@ssw0rd', '80.00', 'easyshop@vendor.com', '2024-11-12 09:01:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `ewallet_transaction`
--
ALTER TABLE `ewallet_transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `qrpay`
--
ALTER TABLE `qrpay`
  ADD PRIMARY KEY (`qr_id`);

--
-- Indexes for table `system_autoreload`
--
ALTER TABLE `system_autoreload`
  ADD PRIMARY KEY (`auto_id`);

--
-- Indexes for table `Vendors`
--
ALTER TABLE `Vendors`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ewallet_transaction`
--
ALTER TABLE `ewallet_transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `qrpay`
--
ALTER TABLE `qrpay`
  MODIFY `qr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `system_autoreload`
--
ALTER TABLE `system_autoreload`
  MODIFY `auto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Vendors`
--
ALTER TABLE `Vendors`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

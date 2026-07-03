-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2026 at 01:07 PM
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
-- Database: `business`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `business` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `registed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin`, `username`, `password`, `user_type`, `names`, `phone`, `email`, `location`, `business`, `logo`, `registed_at`) VALUES
(1, 'olivier', '12345', 1, '', '', '', '', '0', '0', '2026-06-10 22:34:09'),
(2, 'amani', '123', 1, '', '', '', '', '0', '0', '2026-06-10 22:34:09'),
(3, 'kundake', '12', 1, '', '', '', '', '0', '0', '2026-06-10 22:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `admin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `business` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `registed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`admin`, `username`, `password`, `user_type`, `names`, `phone`, `email`, `location`, `business`, `logo`, `registed_at`) VALUES
(1, 'olivier', '123', 0, 'Nsengiyumva Olivier', '0795008053', 'nsengiyumvaxolivier@gmail.com', 'kicukiro-gatenga', 'Nsengiyumva olivier Business', 'unilak-logo.jpg', '2026-06-10 22:39:28'),
(2, 'admin', '1234', 0, 'TUYISHIME Gilbert', '0792414909', 'gilberttuyishime38@gmail.com', 'kanombe', 'school', '971.jpg', '2026-06-10 22:43:48'),
(3, 'amani', '12', 0, 'Nsengiyumva Olivier', '0795008053', 'nsengiyumvaxolivier@gmail.com', 'gasabo', 'school', '971.jpg', '2026-06-10 22:45:20'),
(4, 'bx', 'bx123', 0, 'Nsengiyumva Olivier', '0795008053', 'nsengiyumvaxolivier@gmail.com', 'kanombe', 'B-X Business', 'unilak-logo.jpg', '2026-06-11 10:26:29');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `cl_id` int(11) NOT NULL,
  `cl_name` varchar(255) NOT NULL,
  `cl_phone` varchar(15) NOT NULL,
  `cl_type` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `business` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`cl_id`, `cl_name`, `cl_phone`, `cl_type`, `admin`, `business`) VALUES
(0, 'ndege', '0737788687', 0, 0, 0),
(0, 'Nyaruzungu', '0723004941', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `name` varchar(255) NOT NULL,
  `phone` text NOT NULL,
  `c_id` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`name`, `phone`, `c_id`, `business`, `location`, `created_at`) VALUES
('Mashyaka', '0792022135', 1, 4, 'Cyamuhinda', '2026-06-11 13:35:16'),
('TUYISHIME Gilbert', '0795008053', 2, 4, 'gasabo', '2026-06-11 13:37:39'),
('Muhoza', '0795008053', 3, 1, 'Kabuga', '2026-06-12 00:29:27'),
('Eva', '07849563', 4, 1, 'Muhanga', '2026-06-12 00:29:46'),
('Mwizerwa', '0795008053', 5, 1, 'Rambura', '2026-06-12 00:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `item_name` text NOT NULL,
  `in_price` double NOT NULL,
  `out_price` double NOT NULL,
  `quantity` double NOT NULL,
  `item_supliyer` int(11) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `pcs` double NOT NULL DEFAULT 1,
  `business` int(11) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `profit` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `item_name`, `in_price`, `out_price`, `quantity`, `item_supliyer`, `reg_date`, `pcs`, `business`, `expiry_date`, `profit`) VALUES
(1, 'Rice', 29000, 32000, 30, 11, '2026-06-11 10:23:40', 1, 1, '2026-10-30', 3000),
(2, 'ubunyobwa', 1600, 1800, 50, 2, '2026-06-11 10:25:01', 50, 1, '2026-09-24', 200),
(3, 'Rice', 29000, 30500, 60, 1, '2026-06-11 10:28:03', 1, 4, '2026-09-25', 1500),
(4, 'Kawinga', 19000, 23000, 30, 2, '2026-06-11 15:59:04', 1, 4, '2026-09-24', 4000),
(5, 'pakmay', 7000, 8500, 8, 3, '2026-06-12 00:32:22', 2, 1, '2026-10-23', 1500),
(6, 'salt', 225, 300, 800, 2, '2026-06-22 07:17:02', 40, 4, '2026-06-30', 75);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ord_id` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `ord_quantity` float NOT NULL,
  `ordered_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  `discount` double NOT NULL,
  `customer` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ord_id`, `business`, `product`, `ord_quantity`, `ordered_at`, `status`, `discount`, `customer`, `price`) VALUES
(1, 4, 3, 4, '2026-06-11 23:52:52', 1, 500, 2, 30000),
(2, 4, 4, 10, '2026-06-12 00:18:01', 1, 0, 2, 23000),
(3, 4, 3, 5, '2026-06-12 00:20:28', 1, 30500, 1, 30500),
(4, 4, 3, 1, '2026-06-12 00:25:23', 1, 0, 2, 30500),
(5, 1, 2, 2, '2026-06-12 00:33:52', 1, 0, 5, 1800),
(6, 1, 5, 1, '2026-06-12 00:34:26', 1, 500, 5, 8000),
(7, 1, 1, 2, '2026-06-12 00:35:26', 1, 0, 5, 32000),
(8, 1, 2, 10, '2026-06-12 00:45:38', 1, 200, 4, 1600),
(9, 4, 3, 3, '2026-06-12 10:52:06', 1, 0, 2, 30500),
(10, 1, 5, 2, '2026-06-12 11:12:04', 1, 0, 5, 8500),
(11, 1, 2, 10, '2026-06-12 11:12:20', 1, 200, 5, 1600),
(12, 1, 1, 20, '2026-06-12 11:12:40', 1, 200, 5, 31800),
(13, 1, 5, 3, '2026-06-12 11:12:53', 1, 0, 5, 8500),
(14, 1, 2, 2, '2026-06-12 11:18:39', 1, 0, 5, 1800),
(15, 1, 2, 3, '2026-06-12 11:19:53', 1, 0, 5, 1800),
(16, 1, 5, 2, '2026-06-12 11:21:06', 1, 0, 5, 8500),
(17, 1, 1, 15, '2026-06-12 11:21:21', 1, 0, 5, 32000),
(18, 1, 2, 25, '2026-06-12 11:21:41', 1, 300, 5, 1500),
(19, 1, 1, 1, '2026-06-12 11:22:02', 1, 0, 5, 32000),
(20, 1, 5, 1, '2026-06-12 11:22:17', 1, 0, 5, 8500),
(21, 1, 2, 2, '2026-06-12 11:22:33', 1, 0, 5, 1800),
(22, 1, 1, 2, '2026-06-12 11:23:04', 1, 0, 5, 32000),
(23, 1, 2, 7, '2026-06-12 11:23:17', 1, 0, 5, 1800),
(24, 1, 2, 1, '2026-06-12 11:32:55', 1, 0, 4, 1800),
(25, 1, 5, 2, '2026-06-12 11:33:33', 1, 0, 4, 8500),
(26, 1, 1, 2, '2026-06-12 12:58:24', 1, 0, 3, 32000),
(27, 1, 1, 1, '2026-06-12 12:58:52', 1, 0, 3, 32000),
(28, 1, 2, 5, '2026-06-12 13:44:03', 1, 100, 4, 1700),
(29, 4, 4, 10, '2026-06-12 14:23:04', 1, 0, 1, 23000),
(30, 1, 2, 1, '2026-06-12 14:38:26', 1, 0, 4, 1800),
(32, 1, 5, 3, '2026-06-12 18:04:58', 1, 0, 4, 8500),
(33, 1, 1, 20, '2026-06-12 18:05:47', 1, 1000, 4, 31000),
(34, 1, 2, 10, '2026-06-12 21:11:12', 1, 100, 5, 1700),
(35, 1, 5, 2, '2026-06-12 21:11:25', 1, 0, 5, 8500),
(36, 1, 1, 3, '2026-06-14 11:09:58', 1, 0, 4, 32000),
(37, 1, 2, 10, '2026-06-14 11:10:14', 1, 200, 4, 1600),
(38, 1, 5, 5, '2026-06-14 11:10:28', 1, 0, 4, 8500),
(39, 1, 1, 3, '2026-06-14 11:10:40', 1, 0, 4, 32000),
(40, 1, 5, 1, '2026-06-14 11:10:51', 1, 0, 4, 8500),
(41, 1, 2, 4, '2026-06-14 11:11:02', 1, 0, 4, 1800),
(42, 1, 1, 8, '2026-06-14 11:11:18', 1, 300, 4, 31700),
(43, 1, 5, 1, '2026-06-14 11:11:28', 1, 0, 4, 8500),
(44, 1, 2, 8, '2026-06-14 11:11:39', 1, 0, 4, 1800),
(45, 1, 2, 1, '2026-06-14 11:11:49', 1, 0, 4, 1800),
(46, 1, 5, 4, '2026-06-14 11:12:00', 1, 0, 4, 8500),
(47, 1, 1, 4, '2026-06-14 11:12:11', 1, 0, 4, 32000),
(48, 1, 2, 7, '2026-06-14 11:12:22', 1, 0, 4, 1800),
(49, 1, 5, 7, '2026-06-14 11:12:31', 1, 0, 4, 8500),
(50, 1, 2, 3, '2026-06-14 11:12:43', 1, 0, 4, 1800),
(51, 1, 1, 6, '2026-06-14 11:12:58', 1, 1000, 4, 31000),
(52, 1, 1, 2, '2026-06-14 11:13:08', 1, 0, 4, 32000),
(53, 1, 5, 4, '2026-06-14 11:15:11', 1, 0, 4, 8500),
(54, 1, 2, 6, '2026-06-14 11:15:20', 1, 0, 4, 1800),
(55, 1, 5, 6, '2026-06-14 11:15:30', 1, 0, 4, 8500),
(56, 1, 1, 3, '2026-06-14 11:15:40', 1, 0, 4, 32000),
(57, 1, 2, 5, '2026-06-14 11:15:50', 1, 0, 4, 1800),
(58, 1, 2, 6, '2026-06-14 11:16:12', 1, 0, 4, 1800),
(59, 1, 5, 4, '2026-06-14 11:16:23', 1, 0, 4, 8500),
(60, 1, 1, 25, '2026-06-14 11:16:37', 1, 0, 4, 32000),
(61, 1, 2, 40, '2026-06-14 11:16:55', 1, 300, 4, 1500),
(62, 1, 1, 28, '2026-06-14 11:17:08', 1, 0, 4, 32000),
(63, 1, 5, 3, '2026-06-14 11:18:04', 1, 0, 4, 8500),
(64, 1, 5, 7, '2026-06-14 11:18:14', 1, 0, 4, 8500),
(65, 1, 1, 23, '2026-06-14 11:18:29', 1, 0, 4, 32000),
(66, 1, 2, 45, '2026-06-14 11:18:41', 1, 0, 4, 1800),
(67, 1, 5, 4, '2026-06-14 14:04:19', 0, 0, 3, 8500),
(68, 1, 2, 2, '2026-06-14 14:15:54', 0, 0, 3, 1800),
(70, 1, 2, 4, '2026-06-17 17:14:39', 0, 0, 4, 1800),
(71, 1, 5, 3, '2026-06-17 17:14:50', 0, 0, 4, 8500),
(72, 1, 1, 3, '2026-06-17 17:15:04', 0, 1000, 4, 31000),
(73, 4, 3, 2, '2026-06-18 12:34:31', 1, 500, 1, 30000),
(74, 4, 4, 2, '2026-06-18 12:35:00', 1, 0, 1, 23000),
(75, 4, 3, 3, '2026-06-18 12:48:18', 1, 0, 1, 30500),
(76, 4, 3, 2, '2026-06-23 09:44:39', 1, 0, 2, 30500);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `items` int(11) NOT NULL,
  `ammount` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  `purchase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `business`, `supplier`, `items`, `ammount`, `created_at`, `status`, `purchase`) VALUES
(1, 4, 1, 1, 800000, '2026-06-21 08:00:34', 0, 1),
(2, 4, 1, 1, 900000, '2026-06-21 08:10:49', 0, 2),
(3, 4, 2, 2, 2925000, '2026-06-21 08:12:36', 0, 3),
(4, 4, 2, 1, 203000, '2026-06-21 08:25:32', 0, 4),
(5, 1, 3, 2, 200000, '2026-06-21 08:25:50', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `pch_id` int(11) NOT NULL,
  `purchase` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `in_price` double NOT NULL,
  `out_price` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `quantity` double NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `business` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`pch_id`, `purchase`, `item`, `supplier`, `in_price`, `out_price`, `created_at`, `quantity`, `expiry_date`, `status`, `business`) VALUES
(1, 1, 3, 1, 10000, 12000, '2026-06-21 08:00:34', 80, '2026-09-25', 0, 4),
(2, 2, 4, 1, 30000, 34000, '2026-06-21 08:10:49', 30, '2026-09-24', 0, 4),
(3, 3, 3, 2, 40000, 48000, '2026-06-21 08:12:36', 60, '2026-09-25', 0, 4),
(4, 3, 4, 2, 35000, 38000, '2026-06-21 08:12:36', 15, '2026-09-24', 0, 4),
(5, 4, 3, 2, 29000, 30500, '2026-06-21 08:25:32', 7, '2026-09-25', 0, 4),
(6, 5, 1, 3, 28000, 30000, '2026-06-21 08:25:50', 5, '2026-10-30', 0, 1),
(7, 5, 5, 3, 7500, 8500, '2026-06-21 08:25:50', 8, '2026-10-23', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `pord_id` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `p_quantity` float NOT NULL,
  `pin_Price` double NOT NULL,
  `pout_price` double NOT NULL,
  `purchase_date` datetime NOT NULL DEFAULT current_timestamp(),
  `expiry_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `picies` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`pord_id`, `business`, `supplier`, `item`, `p_quantity`, `pin_Price`, `pout_price`, `purchase_date`, `expiry_date`, `status`, `picies`) VALUES
(1, 4, 1, 3, 80, 10000, 12000, '2026-06-21 08:00:21', '2026-06-28', 1, 2),
(2, 4, 1, 4, 30, 30000, 34000, '2026-06-21 08:10:44', '2026-06-26', 1, 1),
(3, 4, 2, 3, 60, 40000, 48000, '2026-06-21 08:11:58', '2026-06-28', 1, 1),
(4, 4, 2, 4, 15, 35000, 38000, '2026-06-21 08:12:32', '2026-06-27', 1, 1),
(5, 1, 3, 1, 5, 28000, 30000, '2026-06-21 08:21:59', '2026-06-28', 1, 1),
(6, 1, 3, 5, 8, 7500, 8500, '2026-06-21 08:23:03', '2026-06-27', 1, 2),
(7, 4, 2, 3, 7, 29000, 30500, '2026-06-21 08:23:46', '2026-06-26', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `request_orders`
--

CREATE TABLE `request_orders` (
  `req_ord_id` int(11) NOT NULL,
  `shop` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `req_item` int(11) NOT NULL,
  `req_quantity` double NOT NULL,
  `price` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `allowed_quantity` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salles`
--

CREATE TABLE `salles` (
  `customer` int(255) DEFAULT NULL,
  `products` int(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `sale_id` int(11) NOT NULL,
  `discount` double DEFAULT NULL,
  `salles_date` datetime NOT NULL DEFAULT current_timestamp(),
  `pm` char(1) NOT NULL,
  `business` int(11) NOT NULL,
  `debit` double NOT NULL,
  `sale` int(11) NOT NULL,
  `ammount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salles`
--

INSERT INTO `salles` (`customer`, `products`, `status`, `sale_id`, `discount`, `salles_date`, `pm`, `business`, `debit`, `sale`, `ammount`) VALUES
(4, 4, 0, 1, 2500, '2026-06-12 14:37:42', '', 1, 0, 1, 43300),
(5, 17, 1, 2, 14000, '2026-06-12 14:45:38', '', 1, 0, 2, 1434300),
(3, 2, 0, 3, 0, '2026-06-12 14:53:39', '', 1, 0, 3, 96000),
(4, 1, 0, 4, 0, '2026-06-12 17:33:55', '', 1, 0, 4, 1800),
(1, 2, 0, 5, 0, '2026-06-12 17:41:32', '', 4, 0, 5, 291000),
(4, 2, 0, 6, 20000, '2026-06-12 18:06:09', '', 1, 0, 6, 645500),
(5, 2, 0, 7, 1000, '2026-06-12 21:11:47', '', 1, 0, 7, 34000),
(2, 4, 0, 8, 2000, '2026-06-12 21:14:44', '', 4, 0, 8, 472000),
(4, 31, 0, 9, 22400, '2026-06-14 11:19:17', '', 1, 0, 9, 3937600),
(2, 1, 0, 10, 0, '2026-06-23 09:44:47', '', 4, 0, 10, 61000),
(1, 3, 0, 11, 1000, '2026-06-23 09:47:13', '', 4, 0, 11, 197500);

-- --------------------------------------------------------

--
-- Table structure for table `salles_item`
--

CREATE TABLE `salles_item` (
  `sales_id` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `ord_quantity` float NOT NULL,
  `ordered_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  `discount` double NOT NULL,
  `customer` int(11) NOT NULL,
  `price` double NOT NULL,
  `sale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salles_item`
--

INSERT INTO `salles_item` (`sales_id`, `business`, `product`, `ord_quantity`, `ordered_at`, `status`, `discount`, `customer`, `price`, `sale`) VALUES
(1, 1, 2, 10, '2026-06-12 14:37:42', 0, 200, 4, 1600, 1),
(2, 1, 2, 1, '2026-06-12 14:37:42', 0, 0, 4, 1800, 1),
(3, 1, 5, 2, '2026-06-12 14:37:42', 0, 0, 4, 8500, 1),
(4, 1, 2, 5, '2026-06-12 14:37:42', 0, 100, 4, 1700, 1),
(5, 1, 2, 2, '2026-06-12 14:45:38', 0, 0, 5, 1800, 2),
(6, 1, 5, 1, '2026-06-12 14:45:38', 0, 500, 5, 8000, 2),
(7, 1, 1, 2, '2026-06-12 14:45:38', 0, 0, 5, 32000, 2),
(8, 1, 5, 2, '2026-06-12 14:45:38', 0, 0, 5, 8500, 2),
(9, 1, 2, 10, '2026-06-12 14:45:38', 0, 200, 5, 1600, 2),
(10, 1, 1, 20, '2026-06-12 14:45:38', 0, 200, 5, 31800, 2),
(11, 1, 5, 3, '2026-06-12 14:45:38', 0, 0, 5, 8500, 2),
(12, 1, 2, 2, '2026-06-12 14:45:38', 0, 0, 5, 1800, 2),
(13, 1, 2, 3, '2026-06-12 14:45:38', 0, 0, 5, 1800, 2),
(14, 1, 5, 2, '2026-06-12 14:45:38', 0, 0, 5, 8500, 2),
(15, 1, 1, 15, '2026-06-12 14:45:38', 0, 0, 5, 32000, 2),
(16, 1, 2, 25, '2026-06-12 14:45:38', 0, 300, 5, 1500, 2),
(17, 1, 1, 1, '2026-06-12 14:45:38', 0, 0, 5, 32000, 2),
(18, 1, 5, 1, '2026-06-12 14:45:38', 0, 0, 5, 8500, 2),
(19, 1, 2, 2, '2026-06-12 14:45:38', 0, 0, 5, 1800, 2),
(20, 1, 1, 2, '2026-06-12 14:45:38', 0, 0, 5, 32000, 2),
(21, 1, 2, 7, '2026-06-12 14:45:38', 0, 0, 5, 1800, 2),
(22, 1, 1, 2, '2026-06-12 14:53:39', 0, 0, 3, 32000, 3),
(23, 1, 1, 1, '2026-06-12 14:53:39', 0, 0, 3, 32000, 3),
(24, 1, 2, 1, '2026-06-12 17:33:55', 0, 0, 4, 1800, 4),
(25, 4, 3, 2, '2026-06-12 17:41:32', 0, 0, 1, 30500, 5),
(26, 4, 4, 10, '2026-06-12 17:41:32', 0, 0, 1, 23000, 5),
(27, 1, 5, 3, '2026-06-12 18:06:09', 0, 0, 4, 8500, 6),
(28, 1, 1, 20, '2026-06-12 18:06:09', 0, 1000, 4, 31000, 6),
(29, 1, 2, 10, '2026-06-12 21:11:47', 0, 100, 5, 1700, 7),
(30, 1, 5, 2, '2026-06-12 21:11:47', 0, 0, 5, 8500, 7),
(31, 4, 3, 4, '2026-06-12 21:14:44', 0, 500, 2, 30000, 8),
(32, 4, 4, 10, '2026-06-12 21:14:44', 0, 0, 2, 23000, 8),
(33, 4, 3, 1, '2026-06-12 21:14:44', 0, 0, 2, 30500, 8),
(34, 4, 3, 3, '2026-06-12 21:14:44', 0, 0, 2, 30500, 8),
(35, 1, 1, 3, '2026-06-14 11:19:17', 0, 0, 4, 32000, 9),
(36, 1, 2, 10, '2026-06-14 11:19:17', 0, 200, 4, 1600, 9),
(37, 1, 5, 5, '2026-06-14 11:19:17', 0, 0, 4, 8500, 9),
(38, 1, 1, 3, '2026-06-14 11:19:17', 0, 0, 4, 32000, 9),
(39, 1, 5, 1, '2026-06-14 11:19:17', 0, 0, 4, 8500, 9),
(40, 1, 2, 4, '2026-06-14 11:19:17', 0, 0, 4, 1800, 9),
(41, 1, 1, 8, '2026-06-14 11:19:17', 0, 300, 4, 31700, 9),
(42, 1, 5, 1, '2026-06-14 11:19:17', 0, 0, 4, 8500, 9),
(43, 1, 2, 8, '2026-06-14 11:19:17', 0, 0, 4, 1800, 9),
(44, 1, 2, 1, '2026-06-14 11:19:17', 0, 0, 4, 1800, 9),
(45, 1, 5, 4, '2026-06-14 11:19:17', 0, 0, 4, 8500, 9),
(46, 1, 1, 4, '2026-06-14 11:19:17', 0, 0, 4, 32000, 9),
(47, 1, 2, 7, '2026-06-14 11:19:17', 0, 0, 4, 1800, 9),
(48, 1, 5, 7, '2026-06-14 11:19:17', 0, 0, 4, 8500, 9),
(49, 1, 2, 3, '2026-06-14 11:19:17', 0, 0, 4, 1800, 9),
(50, 1, 1, 6, '2026-06-14 11:19:17', 0, 1000, 4, 31000, 9),
(51, 1, 1, 2, '2026-06-14 11:19:17', 0, 0, 4, 32000, 9),
(52, 1, 5, 4, '2026-06-14 11:19:17', 0, 0, 4, 8500, 9),
(53, 1, 2, 6, '2026-06-14 11:19:17', 0, 0, 4, 1800, 9),
(54, 1, 5, 6, '2026-06-14 11:19:17', 0, 0, 4, 8500, 9),
(55, 1, 1, 3, '2026-06-14 11:19:17', 0, 0, 4, 32000, 9),
(56, 1, 2, 5, '2026-06-14 11:19:17', 0, 0, 4, 1800, 9),
(57, 1, 2, 6, '2026-06-14 11:19:17', 0, 0, 4, 1800, 9),
(58, 1, 5, 4, '2026-06-14 11:19:17', 0, 0, 4, 8500, 9),
(59, 1, 1, 25, '2026-06-14 11:19:17', 0, 0, 4, 32000, 9),
(60, 1, 2, 40, '2026-06-14 11:19:17', 0, 300, 4, 1500, 9),
(61, 1, 1, 28, '2026-06-14 11:19:17', 0, 0, 4, 32000, 9),
(62, 1, 5, 3, '2026-06-14 11:19:17', 0, 0, 4, 8500, 9),
(63, 1, 5, 7, '2026-06-14 11:19:17', 0, 0, 4, 8500, 9),
(64, 1, 1, 23, '2026-06-14 11:19:17', 0, 0, 4, 32000, 9),
(65, 1, 2, 45, '2026-06-14 11:19:17', 0, 0, 4, 1800, 9),
(66, 4, 3, 2, '2026-06-23 09:44:47', 0, 0, 2, 30500, 10),
(67, 4, 3, 2, '2026-06-23 09:47:13', 0, 500, 1, 30000, 11),
(68, 4, 4, 2, '2026-06-23 09:47:13', 0, 0, 1, 23000, 11),
(69, 4, 3, 3, '2026-06-23 09:47:13', 0, 0, 1, 30500, 11);

-- --------------------------------------------------------

--
-- Table structure for table `sell`
--

CREATE TABLE `sell` (
  `sale` int(255) NOT NULL,
  `sl_customer` int(255) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `sel_date` datetime DEFAULT current_timestamp(),
  `state` int(11) DEFAULT NULL,
  `sl_id` int(11) NOT NULL,
  `debit` double DEFAULT NULL,
  `dsc` double DEFAULT NULL,
  `am` char(1) NOT NULL,
  `admin` int(11) NOT NULL,
  `business` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sell`
--

INSERT INTO `sell` (`sale`, `sl_customer`, `amount`, `sel_date`, `state`, `sl_id`, `debit`, `dsc`, `am`, `admin`, `business`) VALUES
(1, 3, 17600, '2025-10-17 05:24:29', 1, 1, 0, 1000, '', 2, 3),
(2, 5, 900, '2025-10-17 07:59:07', 1, 2, 0, 0, '', 2, 3),
(3, 4, 1000, '2025-10-17 08:16:26', 1, 3, 0, 500, '', 2, 3),
(5, 5, 51300, '2025-10-23 08:25:18', 0, 5, 0, 3000, '', 2, 3),
(6, 6, 37200, '2025-12-11 05:28:18', 1, 6, 0, 800, '', 1, 2),
(7, 6, 171300, '2026-01-29 06:48:24', 1, 7, 0, 2700, '', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `name` varchar(255) NOT NULL,
  `phone` text NOT NULL,
  `sp_id` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`name`, `phone`, `sp_id`, `business`, `location`, `created_at`) VALUES
('teliza', '07849563', 1, 4, 'kicukiro', '2026-06-11 13:52:17'),
('Danius', '0792414909', 2, 4, 'kimironko', '2026-06-11 13:57:00'),
('Karemera', '0792022135', 3, 1, 'Rutare', '2026-06-12 00:31:04'),
('Bizimana', '0795008053', 4, 1, 'Cyamuhinda', '2026-06-12 00:31:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`admin`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ord_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`pch_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`pord_id`);

--
-- Indexes for table `request_orders`
--
ALTER TABLE `request_orders`
  ADD PRIMARY KEY (`req_ord_id`);

--
-- Indexes for table `salles`
--
ALTER TABLE `salles`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `salles_item`
--
ALTER TABLE `salles_item`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `sell`
--
ALTER TABLE `sell`
  ADD PRIMARY KEY (`sl_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`sp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `pch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `pord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `request_orders`
--
ALTER TABLE `request_orders`
  MODIFY `req_ord_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salles`
--
ALTER TABLE `salles`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `salles_item`
--
ALTER TABLE `salles_item`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `sell`
--
ALTER TABLE `sell`
  MODIFY `sl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

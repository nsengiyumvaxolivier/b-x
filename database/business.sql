-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2026 at 11:44 AM
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
  `registed_at` datetime NOT NULL DEFAULT current_timestamp(),
  `x_key` varchar(500) NOT NULL,
  `status` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`admin`, `username`, `password`, `user_type`, `names`, `phone`, `email`, `location`, `business`, `logo`, `registed_at`, `x_key`, `status`) VALUES
(1, 'olivier', '123', 0, 'Nsengiyumva Olivier', '0795008053', 'nsengiyumvaxolivier@gmail.com', 'kicukiro', 'Nsengiyumva olivier Business', 'logo1.jpg', '2026-06-10 22:39:28', '', ''),
(2, 'admin', '1234', 0, 'TUYISHIME Gilbert', '0792414909', 'gilberttuyishime38@gmail.com', 'kanombe', 'school', '971.jpg', '2026-06-10 22:43:48', '', ''),
(3, 'amani', '12', 0, 'Nsengiyumva Olivier', '0795008053', 'nsengiyumvaxolivier@gmail.com', 'gasabo', 'school', '971.jpg', '2026-06-10 22:45:20', '', ''),
(4, 'bx', 'bx123', 0, 'Nsengiyumva Olivier', '0795008053', 'nsengiyumvaxolivier@gmail.com', 'Gicumbi-Rutare', 'B-X Busness', 'logo4.jpg', '2026-06-11 10:26:29', 't5', ''),
(5, 'Agataje', '123', 0, 'Agataje-Bar', '0795008053', 'agatage@gmail.com', 'Rutare', 'Agataje-Bar', 'logo5.jpg', '2026-07-23 13:46:32', '', '');

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
('Mashyaka', '0792022135', 1, 4, 'Kagogo', '2026-06-11 13:35:16'),
('TUYISHIME Gilbert', '0795008053', 2, 4, 'gasabo', '2026-06-11 13:37:39'),
('Muhoza', '0795008053', 3, 1, 'Kabuga', '2026-06-12 00:29:27'),
('Eva', '07849563', 4, 1, 'Muhanga', '2026-06-12 00:29:46'),
('Mwizerwa', '0795008053', 5, 1, 'Rambura', '2026-06-12 00:30:09'),
('hirwa', '07950080539', 6, 4, 'kabuga', '2026-07-04 10:30:47'),
('manzi', '079202213588', 7, 4, 'kicukiro', '2026-07-04 13:16:36'),
('manzi', '0795008052', 8, 4, 'Cyamuhinda', '2026-07-04 13:46:07'),
('muneza', '078564536', 9, 4, 'muhura', '2026-07-09 18:13:50'),
('Mutoni', '078564753', 10, 4, 'Muko', '2026-07-09 18:14:20'),
('Rubanda', '079876453', 11, 4, 'Kabuga', '2026-07-09 18:14:48'),
('Mugwiza', '009857463', 12, 4, 'Burundi', '2026-07-09 18:15:18'),
('Uwineza', '078964765', 13, 4, 'Rwamiko', '2026-07-09 18:16:03'),
('Mutesi', '08994763546', 14, 4, 'Gaseke', '2026-07-09 18:16:33'),
('Kwihangana', '078998909', 15, 4, 'Marembo', '2026-07-09 18:17:07'),
('Mutoni', '078988998', 16, 4, 'Rwesero', '2026-07-09 18:17:41'),
('Emiles', '078453422', 17, 4, 'Muhurat', '2026-07-09 18:18:08'),
('Uzarama', '078964553', 18, 4, 'Bugamba', '2026-07-09 18:18:40'),
('Komezusenge', '078988778', 19, 4, 'Birindi', '2026-07-09 18:19:05'),
('Eric', '078946354', 20, 4, 'Rambura', '2026-07-09 18:19:28'),
('muhire', '0795008051', 21, 4, 'Kabira', '2026-07-12 13:42:32'),
('hen', '078495635', 23, 4, 'kimironko', '2026-07-16 01:22:43');

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
(3, 'Rice', 32000, 35000, 17, 1, '2026-06-11 10:28:03', 1, 4, '0000-00-00', 1500),
(4, 'Kawunga', 30000, 33000, 32, 1, '2026-06-11 15:59:04', 1, 4, '2026-08-27', 3000),
(5, 'pakmay', 7000, 8500, 8, 3, '2026-06-12 00:32:22', 2, 1, '2026-10-23', 1500);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `business` int(11) NOT NULL,
  `notes` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_day` varchar(50) NOT NULL,
  `title` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`note_id`, `business`, `notes`, `created_at`, `updated_at`, `created_day`, `title`) VALUES
(3, 4, '\n     <b>Hello</b><font color=\"#ea0b64\"> Every</font> <u>ones<font color=\"#3acf3c\">&nbsp;</font></u>', '2026-07-21 08:55:07', '2026-07-30 09:39:07', 'Tuesday', ''),
(17, 4, '\n', '2026-07-30 08:46:42', '2026-07-30 08:46:42', 'Thursday', 'qwerty'),
(18, 4, 'rred<div>blue</div><div>green</div>', '2026-07-30 08:47:46', '2026-07-30 08:47:46', 'Thursday', 'cloros'),
(19, 4, '\n     eva=2000<div>hirwa=500</div><div>mutesi=4653</div><div>hakiza=3000</div>', '2026-07-30 09:11:28', '2026-07-30 10:06:38', 'Thursday', 'Amadeni'),
(20, 4, '\n     1. ndege<div>2. bizimana</div><div>3. murara</div>', '2026-07-30 09:53:26', '2026-07-31 06:09:25', 'Thursday', 'Abacuruzi'),
(21, 4, '<b>HHGHHFH</b>', '2026-07-31 11:59:03', '2026-07-31 11:59:03', 'Friday', 'YT');

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
(1, 4, 4, 2, '2026-07-31 02:37:29', 1, 0, 18, 33000),
(2, 4, 4, 1, '2026-07-31 02:41:16', 1, 0, 18, 33000),
(3, 4, 3, 0.5, '2026-07-31 02:41:40', 1, 0, 18, 35000),
(4, 4, 4, 4, '2026-07-31 02:57:12', 1, 0, 17, 33000);

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
(5, 1, 3, 2, 200000, '2026-06-21 08:25:50', 0, 5),
(6, 4, 2, 1, 1200000, '2026-07-06 12:37:54', 0, 6),
(7, 4, 5, 2, 76000, '2026-07-22 09:32:11', 0, 7);

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
(7, 5, 5, 3, 7500, 8500, '2026-06-21 08:25:50', 8, '2026-10-23', 0, 1),
(8, 6, 4, 2, 20000, 23000, '2026-07-06 12:37:54', 60, '2026-09-24', 0, 4),
(9, 7, 3, 5, 32000, 35000, '2026-07-22 09:32:11', 2, '2026-09-25', 0, 4),
(10, 7, 7, 5, 600, 800, '2026-07-22 09:32:11', 20, '2026-07-30', 0, 4);

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
(7, 4, 2, 3, 7, 29000, 30500, '2026-06-21 08:23:46', '2026-06-26', 1, 1),
(8, 4, 2, 4, 60, 20000, 23000, '2026-07-06 12:23:52', '2026-07-31', 1, 1),
(10, 4, 5, 3, 2, 32000, 35000, '2026-07-22 09:26:58', '2026-07-31', 1, 1),
(11, 4, 5, 7, 20, 600, 800, '2026-07-22 09:29:07', '2026-07-25', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `request_messages`
--

CREATE TABLE `request_messages` (
  `id` int(11) NOT NULL,
  `shop` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `sender` enum('customer','shop') NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_messages`
--

INSERT INTO `request_messages` (`id`, `shop`, `customer`, `sender`, `message`, `created_at`) VALUES
(1, 4, 1, 'customer', 'karni', '2026-07-03 14:37:54'),
(2, 4, 1, 'customer', 'heloo wamaye ututuntux', '2026-07-03 16:24:16'),
(3, 4, 1, 'shop', 'umucere hari umwe', '2026-07-03 16:25:46'),
(4, 1, 1, 'customer', 'jjj', '2026-07-03 16:53:01'),
(5, 1, 1, 'customer', 'uu', '2026-07-03 16:54:53'),
(6, 4, 1, 'customer', 'hi', '2026-07-03 16:56:20'),
(7, 4, 1, 'shop', 'yeah', '2026-07-03 16:58:12'),
(8, 4, 1, 'shop', 'audio:uploads/voices/voice_1783091119_cceb377a8251.webm', '2026-07-03 17:05:19'),
(9, 4, 1, 'shop', 'audio:uploads/voices/voice_1783091141_27f8b14cba33.webm', '2026-07-03 17:05:41');

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

--
-- Dumping data for table `request_orders`
--

INSERT INTO `request_orders` (`req_ord_id`, `shop`, `customer`, `req_item`, `req_quantity`, `price`, `created_at`, `allowed_quantity`) VALUES
(1, 4, 1, 3, 2, 30500, '2026-07-03 13:46:55', 2),
(2, 4, 1, 4, 5, 23000, '2026-07-03 13:47:40', 1),
(3, 4, 1, 6, 8, 300, '2026-07-03 13:48:20', 8),
(4, 4, 1, 4, 2, 23000, '2026-07-03 13:52:50', 1),
(5, 4, 1, 3, 2, 30500, '2026-07-03 16:24:16', 5),
(6, 4, 1, 4, 3, 23000, '2026-07-03 16:24:16', 3),
(7, 4, 1, 6, 3, 300, '2026-07-03 16:30:05', 3),
(8, 1, 1, 5, 2, 8500, '2026-07-03 16:53:59', 0),
(9, 4, 1, 6, 15, 300, '2026-07-03 16:57:29', 15),
(10, 4, 1, 3, 8, 30500, '2026-07-03 16:57:29', 8),
(11, 4, 2, 4, 4, 23000, '2026-07-04 07:54:22', 4),
(12, 4, 2, 3, 7, 30500, '2026-07-04 08:05:40', 7),
(13, 4, 2, 4, 2, 23000, '2026-07-04 08:30:11', 2),
(14, 4, 6, 3, 2, 30500, '2026-07-04 10:32:55', 2);

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
(17, 1, 0, 1, 0, '2026-07-31 02:57:24', '', 4, 0, 1, 132000);

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
  `sale` int(11) NOT NULL,
  `profit` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salles_item`
--

INSERT INTO `salles_item` (`sales_id`, `business`, `product`, `ord_quantity`, `ordered_at`, `status`, `discount`, `customer`, `price`, `sale`, `profit`) VALUES
(1, 4, 4, 4, '2026-07-31 02:57:24', 0, 0, 17, 33000, 1, 12000);

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
('Bizimana', '0795008053', 4, 1, 'Cyamuhinda', '2026-06-12 00:31:23'),
('Moviti', '0795008053', 5, 4, 'gasabo', '2026-07-16 01:43:06'),
('numukiza', '0792414909', 6, 4, 'kimironko', '2026-07-22 09:45:04');

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
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`);

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
-- Indexes for table `request_messages`
--
ALTER TABLE `request_messages`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `pch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `pord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `request_messages`
--
ALTER TABLE `request_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `request_orders`
--
ALTER TABLE `request_orders`
  MODIFY `req_ord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `salles`
--
ALTER TABLE `salles`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `salles_item`
--
ALTER TABLE `salles_item`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sell`
--
ALTER TABLE `sell`
  MODIFY `sl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2020 at 06:25 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `softcaisse`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `enabled` int(11) NOT NULL,
  `possition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `enabled`, `possition`) VALUES
(1, 'brand_1', 1, 1),
(2, 'brand_2', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `idParent` int(11) DEFAULT NULL,
  `enabled` int(11) NOT NULL,
  `possition` int(11) NOT NULL,
  `bckColor` varchar(9) NOT NULL DEFAULT '#0275d8',
  `color` varchar(9) NOT NULL DEFAULT '#000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `idParent`, `enabled`, `possition`, `bckColor`, `color`) VALUES
(1, 'Boisson Chaudes', NULL, 0, 1, '#0275d8', '#FFFFFF'),
(2, 'Boisson Fraîches', NULL, 0, 2, '#0275d8', '#FFFFFF'),
(3, 'SODAS Canette', NULL, 1, 0, '#0275d8', '#000000'),
(4, 'COKTAIL', NULL, 1, 0, '#0275d8', '#000000'),
(5, 'JUS', NULL, 1, 1, '#0275d8', '#000000'),
(6, 'Café', NULL, 1, 0, '#0275d8', '#000000'),
(7, 'Lait', NULL, 1, 1, '#0275d8', '#000000'),
(8, 'EAU Minéral', NULL, 1, 0, '#0275d8', '#000000'),
(9, 'jhfu', NULL, 1, 0, '#0275d8', '#000000'),
(10, 'jhfu', NULL, 1, 0, '#0275d8', '#000000'),
(11, 'jhfu', NULL, 1, 0, '#0275d8', '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `taxNumber` varchar(50) DEFAULT NULL,
  `phoneNumber` varchar(50) DEFAULT NULL,
  `birthDate` varchar(50) DEFAULT NULL,
  `vat` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `isNew` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `firstName`, `lastName`, `email`, `country`, `taxNumber`, `phoneNumber`, `birthDate`, `vat`, `code`, `isNew`) VALUES
(1, 'mohamed yassine', 'cherrat', 'yassinebahajou@gmail.com', 'morocco', '', '0661835628', '2020-08-07', 0, '', 0),
(3, 'bahajou', 'mohamed', 'yassinebahajou@gmail.com', '', '', '0661835628', '', 0, '', 0),
(4, 'bahajou', 'mohamed', 'yassinebahajou@gmail.com', '', '', '0661835628', '', 0, '', 0),
(5, 'bahajou', 'mohamed', 'yassinebahajou@gmail.com', '', '', '0661835628', '', 0, '', 0),
(6, 'bahajou', 'mohamed', 'yassinebahajou@gmail.com', '', '', '0661835628', '', 0, '', 0),
(7, 'bahajou', 'mohamed', 'yassinebahajou@gmail.com', '', '', '0661835628', '', 0, '', 0),
(8, 'oumalek', 'ezzamel', 'yassinebahajou@gmail.com', '', '', '0661835628', '', 0, '', 0),
(9, 'client_nom_7', 'client_prenom_7', 'clientsPrenom@gmail.com', '', '', '0909090909', '', 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` int(11) NOT NULL,
  `label` varchar(30) DEFAULT NULL,
  `date_facture` varchar(30) DEFAULT NULL,
  `date_paiement` varchar(30) DEFAULT '0000-00-00',
  `status` varchar(10) DEFAULT 'VIDE',
  `supplier_id` int(11) DEFAULT NULL,
  `stock_id` int(11) DEFAULT 1,
  `total_cost` decimal(11,0) DEFAULT 0,
  `liv_cost` decimal(11,0) DEFAULT 0,
  `total_qte` decimal(10,0) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `label`, `date_facture`, `date_paiement`, `status`, `supplier_id`, `stock_id`, `total_cost`, `liv_cost`, `total_qte`) VALUES
(1, 'sprite soda', '2020-09-15', NULL, NULL, 1, 1, NULL, NULL, '0'),
(2, 'sprite soda', '2020-09-15', '0000-00-00', 'Valide', 1, 1, '126', '0', '7');

-- --------------------------------------------------------

--
-- Table structure for table `inventoryinputs`
--

CREATE TABLE `inventoryinputs` (
  `product_id` int(11) DEFAULT NULL,
  `inv_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `recieved` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventoryinputs`
--

INSERT INTO `inventoryinputs` (`product_id`, `inv_id`, `quantity`, `recieved`) VALUES
(2, 2, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `operation`
--

CREATE TABLE `operation` (
  `date_time` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_retrait` int(10) NOT NULL DEFAULT 1,
  `mnt` float DEFAULT 0,
  `cmt` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `operation`
--

INSERT INTO `operation` (`date_time`, `user_id`, `is_retrait`, `mnt`, `cmt`) VALUES
('2020-07-15 10:47:42', 1, 0, 99, ''),
('2020-09-15 10:40:49', 1, 1, 700, 'jg'),
('2020-09-15 10:41:07', 1, 1, 88, ''),
('2020-09-15 13:11:31', 1, 1, 800, 'ug');

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `currency` varchar(30) NOT NULL,
  `paymentType` varchar(30) NOT NULL,
  `accountingAccount` varchar(50) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `model` varchar(50) NOT NULL,
  `image_link` varchar(50) NOT NULL DEFAULT '../img/products_images/default.jpg',
  `barcode` varchar(50) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `price` double NOT NULL,
  `supplyPrice` double NOT NULL,
  `discountPrice` double DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sizeType_id` int(11) DEFAULT NULL,
  `stockManagment` int(11) NOT NULL DEFAULT 1,
  `supplierReference` varchar(50) DEFAULT NULL,
  `vat` int(11) DEFAULT NULL,
  `display` int(11) DEFAULT NULL,
  `arch` varchar(50) DEFAULT NULL,
  `serialNumber` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `taxe_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `model`, `image_link`, `barcode`, `brand_id`, `supplier_id`, `price`, `supplyPrice`, `discountPrice`, `category_id`, `sizeType_id`, `stockManagment`, `supplierReference`, `vat`, `display`, `arch`, `serialNumber`, `comments`, `taxe_id`) VALUES
(2, 'cafe espresso', '../img/products_images/produit_2.png', '333', 1, 2, 20, 18, 0, 6, NULL, 0, 'espresso', NULL, NULL, NULL, NULL, '', 1),
(3, 'cafe allonge', '../img/products_images/produit_3.jpg', '', NULL, NULL, 20, 24, 16, 6, NULL, 0, '', 0, 0, '', 0, '', 1),
(4, 'Café crème', '../img/products_images/produit_4.jpeg', '', NULL, NULL, 20, 24, 16, 6, NULL, 0, '', 0, 0, '', 0, '', 1),
(6, 'Double Espresso', '../img/products_images/produit_6.jpg', '', 1, NULL, 300, 200, 0, 6, NULL, 0, '', 0, 0, '', 0, '', 1),
(7, 'coca cola canette', '../img/products_images/produit_7.png', NULL, NULL, NULL, 10, 8, 0, 3, NULL, 0, '', 0, 0, '', 0, '', 1),
(8, 'sprite soda', '../img/products_images/produit_8.png', NULL, NULL, NULL, 10, 8, 0, 3, NULL, 0, '', 0, 0, '', 0, '', 1),
(10, 'Orange', '../img/products_images/produit_10.jpeg', '', 1, NULL, 13, 9, 0, 5, NULL, 0, '', 0, 0, '', 0, '', 1),
(11, 'Bananes', '../img/products_images/produit_11.jpg', '', NULL, NULL, 13, 10, 0, 5, NULL, 0, '', 0, 0, '', 0, '', 1),
(12, 'Jus de Pomme', '../img/products_images/produit_12.jpg', NULL, NULL, NULL, 13, 10, 0, 5, NULL, 0, '', 0, 0, '', 0, '', 1),
(13, 'Fraisse', '../img/products_images/produit_13.jpeg', '', NULL, NULL, 13, 10, 0, 5, NULL, 0, '', 0, 0, '', 0, '', 1),
(14, 'products 3', 'img/products_images/default.jpg', NULL, 2, NULL, 9, 5, NULL, 3, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT 1,
  `createdAt` varchar(50) NOT NULL,
  `completedAt` varchar(50) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `vendor_id` int(11) DEFAULT NULL,
  `uniqueSale_id` int(11) NOT NULL,
  `currency_code` varchar(10) NOT NULL DEFAULT 'MAD',
  `total` double NOT NULL DEFAULT 0,
  `billingAddress` varchar(50) NOT NULL,
  `shippingAddress` varchar(50) NOT NULL,
  `payment` varchar(50) NOT NULL DEFAULT 'CCARD',
  `dutyFreeSale` int(11) NOT NULL,
  `withoutTaxes` int(11) NOT NULL,
  `pricesWithoutTaxes` int(11) NOT NULL,
  `vatNumber` int(11) NOT NULL,
  `dateZ` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `table_num` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `store_id`, `customer_id`, `createdAt`, `completedAt`, `vendor_id`, `uniqueSale_id`, `currency_code`, `total`, `billingAddress`, `shippingAddress`, `payment`, `dutyFreeSale`, `withoutTaxes`, `pricesWithoutTaxes`, `vatNumber`, `dateZ`, `comment`, `table_num`) VALUES
(2, NULL, 1, '2020-08-18 16:06:08', '2020-08-20 02:06:23', 1, 0, 'MAD', 300, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(3, NULL, 1, '2020-08-18 16:06:08', '2020-08-20 02:08:44', 1, 0, 'MAD', 0, '', '', 'CASH', 0, 0, 0, 0, '', '', NULL),
(4, NULL, NULL, '2020-08-18 16:06:08', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(18, NULL, 1, '2020-08-19 01:07:44', '2020-08-20 17:58:00', 1, 0, 'MAD', 40, '', '', 'CASH', 0, 0, 0, 0, '', '', NULL),
(19, NULL, 1, '2020-08-19 01:16:37', '0000-00-00 00:00:00', 1, 0, 'MAD', 960, '', '', 'CASH', 0, 0, 0, 0, '', '', NULL),
(20, NULL, 1, '2020-08-19 01:17:04', '0000-00-00 00:00:00', 1, 0, 'MAD', 360, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(21, NULL, 1, '2020-08-19 01:18:38', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(22, NULL, 1, '2020-08-19 01:19:38', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(23, NULL, 1, '2020-08-19 01:20:08', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(24, NULL, 1, '2020-08-19 01:22:14', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(25, NULL, 1, '2020-08-19 01:22:57', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(26, NULL, 1, '2020-08-19 01:24:18', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(27, NULL, 1, '2020-08-19 01:25:04', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(28, NULL, 1, '2020-08-19 01:26:05', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(29, NULL, 1, '2020-08-19 01:27:37', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(30, NULL, 1, '2020-08-19 01:27:45', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(31, NULL, 1, '2020-08-19 01:28:43', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(32, NULL, 1, '2020-08-19 01:36:35', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(33, NULL, 1, '2020-08-19 01:37:28', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(34, NULL, 1, '2020-08-19 01:37:51', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(35, NULL, 1, '2020-08-19 01:39:34', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(36, NULL, 1, '2020-08-19 01:40:36', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(37, NULL, 1, '2020-08-19 01:41:03', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(38, NULL, 1, '2020-08-19 15:41:40', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(39, NULL, 1, '2020-08-19 15:53:50', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(40, NULL, 1, '2020-08-19 15:54:21', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(41, NULL, 1, '2020-08-19 15:55:35', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(42, NULL, 1, '2020-08-19 16:17:49', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(43, NULL, 1, '2020-08-19 16:50:59', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(44, NULL, 1, '2020-08-19 16:51:53', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(45, NULL, 1, '2020-08-19 17:06:23', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(46, NULL, 1, '2020-08-19 17:07:28', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(47, NULL, 1, '2020-08-19 17:34:18', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(48, NULL, 1, '2020-08-19 17:41:25', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(49, NULL, 1, '2020-08-19 18:07:01', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(50, NULL, 1, '2020-08-19 18:08:04', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(51, NULL, 1, '2020-08-19 18:10:51', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(52, NULL, 1, '2020-08-19 18:35:44', '0000-00-00 00:00:00', 1, 0, 'MAD', 20, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(53, NULL, 1, '2020-08-19 18:48:03', '2020-08-19 20:01:41', 1, 0, 'MAD', 300, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(54, NULL, 1, '2020-08-19 20:03:02', '2020-08-19 20:08:37', 1, 0, 'MAD', 340, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(55, NULL, 1, '2020-08-19 20:09:13', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(56, NULL, 1, '2020-08-19 20:13:43', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(57, NULL, 1, '2020-08-19 20:14:01', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(58, NULL, 1, '2020-08-20 13:16:10', '2020-08-20 13:18:12', 1, 0, 'MAD', 320, '', '', 'CASH', 0, 0, 0, 0, '', '', NULL),
(59, NULL, 1, '2020-08-20 13:18:58', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(60, NULL, 1, '2020-08-20 14:49:07', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CASH', 0, 0, 0, 0, '', '', NULL),
(62, NULL, 1, '2020-08-20 17:58:07', '0000-00-00 00:00:00', 1, 0, 'MAD', 320, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(64, NULL, 1, '2020-08-20 20:28:40', '2020-08-20 20:29:00', 1, 0, 'MAD', 380, '', '', 'CASH', 0, 0, 0, 0, '', '', NULL),
(65, NULL, 1, '2020-08-21 23:35:18', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(66, NULL, 1, '2020-08-31 23:07:40', '2020-08-31 23:08:29', 1, 0, 'MAD', 340, '', '', 'CASH', 0, 0, 0, 0, '', '', '001'),
(70, NULL, 1, '2020-09-01 11:53:25', '0000-00-00 00:00:00', 2, 0, 'MAD', 70, '', '', 'CASH', 0, 0, 0, 0, '', '', '001'),
(71, NULL, 1, '2020-09-01 12:55:55', '0000-00-00 00:00:00', 1, 0, 'MAD', 6699, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(72, NULL, 1, '2020-09-01 13:00:53', '0000-00-00 00:00:00', 1, 0, 'MAD', 0, '', '', 'CCARD', 0, 0, 0, 0, '', '', NULL),
(75, NULL, 1, '2020-09-01 13:19:59', '0000-00-00 00:00:00', 2, 0, 'MAD', 6722, '', '', 'CCARD', 0, 0, 0, 0, '', '', '008'),
(77, NULL, 1, '2020-09-15 10:32:09', '0000-00-00 00:00:00', 1, 0, 'MAD', 20, '', '', 'CASH', 0, 0, 0, 0, '', '', NULL),
(78, NULL, 1, '2020-09-15 13:34:49', '0000-00-00 00:00:00', 2, 0, 'MAD', 20, '', '', 'CCARD', 0, 0, 0, 0, '', '', '002');

-- --------------------------------------------------------

--
-- Table structure for table `sale_lines`
--

CREATE TABLE `sale_lines` (
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `stockWithdrawal` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sale_lines`
--

INSERT INTO `sale_lines` (`sale_id`, `product_id`, `size_id`, `quantity`, `stockWithdrawal`) VALUES
(1, 3, NULL, 16, 0),
(2, 6, NULL, 1, 0),
(18, 0, NULL, 1, 0),
(18, 2, NULL, 2, 0),
(19, 4, NULL, 3, 0),
(19, 6, NULL, 3, 0),
(20, 4, NULL, 3, 0),
(20, 6, NULL, 1, 0),
(43, 3, NULL, 3, 0),
(43, 4, NULL, 5, 0),
(44, 3, NULL, 6, 0),
(44, 4, NULL, 6, 0),
(45, 2, NULL, 2, 0),
(45, 4, NULL, 1, 0),
(45, 6, NULL, 1, 0),
(46, 2, NULL, 1, 0),
(46, 3, NULL, 3, 0),
(46, 4, NULL, 2, 0),
(46, 6, NULL, 17, 0),
(47, 6, NULL, 3, 0),
(50, 4, NULL, 1, 0),
(50, 6, NULL, 2, 0),
(51, 4, NULL, 1, 0),
(51, 6, NULL, 1, 0),
(52, 4, NULL, 1, 0),
(53, 6, NULL, 1, 0),
(54, 4, NULL, 2, 0),
(54, 6, NULL, 2, 0),
(58, 4, NULL, 1, 0),
(58, 6, NULL, 1, 0),
(62, 4, NULL, 1, 0),
(62, 6, NULL, 1, 0),
(64, 4, NULL, 4, 0),
(64, 6, NULL, 1, 0),
(66, 3, NULL, 1, 0),
(66, 4, NULL, 1, 0),
(66, 6, NULL, 1, 0),
(70, 2, NULL, 2, 0),
(70, 3, NULL, 1, 0),
(70, 8, NULL, 1, 0),
(71, 10, NULL, 1, 0),
(75, 8, NULL, 1, 0),
(75, 10, NULL, 1, 0),
(75, 11, NULL, 1, 0),
(77, 7, NULL, 1, 0),
(77, 8, NULL, 1, 0),
(78, 7, NULL, 1, 0),
(78, 8, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `enables` tinyint(1) NOT NULL,
  `possition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `size_types`
--

CREATE TABLE `size_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `possition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `warehouseId` int(11) DEFAULT NULL,
  `defaultCurrency` varchar(10) DEFAULT NULL,
  `defaultPaymentMethod` varchar(50) DEFAULT NULL,
  `timeZone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `warehouseId`, `defaultCurrency`, `defaultPaymentMethod`, `timeZone`) VALUES
(1, 'local', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `possition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `enabled`, `possition`) VALUES
(1, 'supplier_1', 1, 1),
(2, 'supplier_2', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) NOT NULL,
  `value` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `dafault` int(11) NOT NULL,
  `possition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `value`, `name`, `enabled`, `dafault`, `possition`) VALUES
(1, '0', 'Taux 0%', 1, 0, 0),
(2, '7', 'Taux 7%', 1, 0, 0),
(3, '10', 'Taux 10%', 1, 0, 0),
(4, '14', 'Taux 14%', 1, 0, 0),
(5, '20', 'Taux 20%', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'vendor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `firstName`, `lastName`, `userName`, `password`, `role`) VALUES
(1, 'mohamed yassine', 'bahajou', 'yassinebahajou', '0000', 'admin'),
(2, 'ahmed', 'oumalek', 'ahmedoumalek', '0000', 'vendor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`date_time`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_crt` (`brand_id`),
  ADD KEY `cat_crt` (`category_id`),
  ADD KEY `supp_crt` (`supplier_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_crt` (`store_id`),
  ADD KEY `customer_crt` (`customer_id`),
  ADD KEY `vemdor_crt` (`vendor_id`);

--
-- Indexes for table `sale_lines`
--
ALTER TABLE `sale_lines`
  ADD PRIMARY KEY (`sale_id`,`product_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crt` (`type_id`);

--
-- Indexes for table `size_types`
--
ALTER TABLE `size_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `size_types`
--
ALTER TABLE `size_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `brand_crt` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `cat_crt` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `supp_crt` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `customer_crt` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `store_crt` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`),
  ADD CONSTRAINT `vemdor_crt` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `sizes`
--
ALTER TABLE `sizes`
  ADD CONSTRAINT `crt` FOREIGN KEY (`type_id`) REFERENCES `size_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

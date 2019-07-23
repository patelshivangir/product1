-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 16, 2019 at 07:43 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `product_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `stock` int(10) NOT NULL,
  `price` int(15) NOT NULL,
  `sku` varchar(8) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_dt` datetime NOT NULL,
  `modified_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `stock`, `price`, `sku`, `description`, `status`, `deleted`, `created_dt`, `modified_dt`) VALUES
(1, 'Oppo A71', 22, 10000, 'A71', 'Camera expert ', 1, 0, '2019-07-10 09:57:57', '2019-07-15 11:38:35'),
(6, 'Tshirt', 2, 300, 'T21', 'Tshirt for girls and boys', 1, 0, '2019-07-11 07:26:45', '2019-07-15 11:50:18'),
(10, 'Shirt', 5, 500, 'shirt 21', 'shirt for man', 1, 0, '2019-07-15 07:58:17', '2019-07-15 11:49:39'),
(15, 'Bag', 5, 500, 'Bag 20', 'Collage bag', 1, 0, '2019-07-16 07:09:39', '2019-07-16 07:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE `tbl_images` (
  `id` int(15) NOT NULL,
  `product_id` int(15) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_dt` datetime NOT NULL,
  `modified_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_images`
--

INSERT INTO `tbl_images` (`id`, `product_id`, `image_path`, `created_dt`, `modified_dt`) VALUES
(136, 6, 'images/6/simple_banner_1-2019-07-15_07:42:37.jpeg', '2019-07-15 07:42:37', NULL),
(137, 6, 'images/6/simple_banner_1-2019-07-15_07:42:37.jpg', '2019-07-15 07:42:37', NULL),
(138, 1, 'images/1/apple-2019-07-15_07:44:06.jpg', '2019-07-15 07:44:06', NULL),
(146, 10, 'images/10/simple_banner_2-2019-07-15_11:03:21.jpg', '2019-07-15 11:03:21', NULL),
(147, 10, 'images/10/category-banner-2019-07-15_11:03:21.jpg', '2019-07-15 11:03:21', NULL),
(148, 15, 'images/15/custom-fields-2019-07-16_07:09:39.png', '2019-07-16 07:09:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`id`, `email`, `password`) VALUES
(1, 'pooja@gmail.com', 'b566434df17d0662da5b99d24d060334'),
(2, 'test@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(3, 'pooja@capacitywebsolutions.com', 'a5de2740406a31f2443a3cf48c1b1012');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_options`
--

CREATE TABLE `tbl_options` (
  `id` int(15) NOT NULL,
  `product_id` int(15) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1=field,2=dropdown,3=radio,4=checkbox',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_dt` datetime NOT NULL,
  `modified_dt` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_options`
--

INSERT INTO `tbl_options` (`id`, `product_id`, `title`, `type`, `status`, `created_dt`, `modified_dt`, `deleted`) VALUES
(3, 1, 'Camera', 3, 1, '0000-00-00 00:00:00', NULL, 0),
(38, 1, 'test3', 4, 1, '2019-07-10 11:31:32', NULL, 0),
(39, 6, 'Size', 3, 1, '2019-07-11 07:26:45', NULL, 0),
(40, 6, 'Color', 2, 1, '2019-07-11 07:30:08', NULL, 0),
(41, 6, 'Tshirt for', 4, 1, '2019-07-11 07:30:08', NULL, 0),
(42, 6, 'Customize print', 1, 1, '2019-07-11 07:30:08', NULL, 0),
(43, 1, 'Size', 1, 1, '2019-07-11 13:49:39', NULL, 0),
(49, 10, 'color', 2, 1, '2019-07-15 07:58:17', NULL, 0),
(52, 10, 'Size', 3, 1, '2019-07-15 11:04:40', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_values`
--

CREATE TABLE `tbl_values` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_dt` datetime NOT NULL,
  `modified_dt` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_values`
--

INSERT INTO `tbl_values` (`id`, `product_id`, `option_id`, `title`, `price`, `status`, `created_dt`, `modified_dt`, `deleted`) VALUES
(5, 1, 3, 'One Front ', 10000, 1, '0000-00-00 00:00:00', NULL, 0),
(6, 1, 3, 'Two Rear ', 12000, 1, '0000-00-00 00:00:00', NULL, 0),
(78, 1, 3, 'three', 0, 1, '2019-07-10 11:30:29', NULL, 0),
(79, 1, 38, 'test2', 0, 1, '2019-07-10 11:31:32', NULL, 0),
(80, 1, 38, 'test3', 0, 1, '2019-07-10 11:31:32', NULL, 0),
(81, 1, 38, 'test3', 10, 1, '2019-07-10 11:42:53', NULL, 0),
(82, 6, 39, 'M', 0, 1, '2019-07-11 07:26:45', NULL, 0),
(83, 6, 39, 'L', 0, 1, '2019-07-11 07:26:45', NULL, 0),
(84, 6, 39, 'XL', 5, 1, '2019-07-11 07:26:45', NULL, 0),
(85, 6, 39, 'XXL', 10, 1, '2019-07-11 07:26:45', NULL, 0),
(86, 6, 40, 'Red', 0, 1, '2019-07-11 07:30:08', NULL, 0),
(87, 6, 40, 'Green', 10, 1, '2019-07-11 07:30:08', NULL, 0),
(88, 6, 40, 'Blue', 5, 1, '2019-07-11 07:30:08', NULL, 0),
(90, 6, 40, 'Gray', 50, 1, '2019-07-11 07:30:08', NULL, 0),
(91, 6, 41, 'Kids', 200, 1, '2019-07-11 07:30:08', NULL, 0),
(92, 6, 41, 'Girls', 300, 1, '2019-07-11 07:30:08', NULL, 0),
(93, 6, 42, NULL, 100, 1, '2019-07-11 07:30:08', NULL, 0),
(94, 1, 43, NULL, 10, 1, '2019-07-11 13:49:39', NULL, 0),
(104, 10, 49, 'white', 0, 1, '2019-07-15 07:58:17', NULL, 0),
(105, 10, 49, 'black', 0, 1, '2019-07-15 07:58:17', NULL, 0),
(110, 10, 52, 'M', 2, 1, '2019-07-15 11:04:40', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Indexes for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IMG_ID` (`product_id`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_options`
--
ALTER TABLE `tbl_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbl_values`
--
ALTER TABLE `tbl_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_id` (`option_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_images`
--
ALTER TABLE `tbl_images`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_options`
--
ALTER TABLE `tbl_options`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tbl_values`
--
ALTER TABLE `tbl_values`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD CONSTRAINT `IMG_ID` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_options`
--
ALTER TABLE `tbl_options`
  ADD CONSTRAINT `tbl_options_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_values`
--
ALTER TABLE `tbl_values`
  ADD CONSTRAINT `tbl_values_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_values_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `tbl_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 06:28 AM
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
-- Database: `cafe-order-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cashiers`
--

CREATE TABLE `cashiers` (
  `cashier_id` int(11) NOT NULL,
  `cashier_name` varchar(100) NOT NULL,
  `shift` enum('Morning','Evening','Night') NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cashiers`
--

INSERT INTO `cashiers` (`cashier_id`, `cashier_name`, `shift`, `user_id`) VALUES
(10, '', 'Evening', 3),
(11, '', 'Morning', 4);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(6, 'Bakery Items'),
(7, 'Food'),
(8, 'Drinks'),
(9, 'Coffee');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`) VALUES
(1, 'haha'),
(2, 'haha');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `item_id` int(11) UNSIGNED NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`item_id`, `item_name`, `price`, `subcategory_id`, `category_id`, `menu_id`) VALUES
(21, 'chocolate cake', 100.00, 12, 6, NULL),
(23, 'strawberry cake', 150.00, 12, 6, NULL),
(24, 'chicken_momo', 180.00, 13, 7, NULL),
(25, 'fruit Juice', 200.00, 14, 8, NULL),
(26, 'Hawaiian Pizza', 300.00, 16, 7, NULL),
(27, 'Chicken noodles', 250.00, 17, 7, NULL),
(28, 'cold coffee', 200.00, 15, 8, NULL),
(29, 'hot coffee', 100.00, 15, 8, NULL),
(30, 'veg momo', 150.00, 13, 7, NULL),
(31, 'Veg Pizza', 230.00, 16, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orderss`
--

CREATE TABLE `orderss` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','In Progress','Completed') NOT NULL DEFAULT 'Pending',
  `cashier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orderss`
--

INSERT INTO `orderss` (`order_id`, `customer_name`, `table_id`, `total_price`, `order_date`, `status`, `cashier_id`) VALUES
(19, 'Jenisha', 12, 100.00, '2024-10-21 21:32:14', 'Pending', NULL),
(20, 'jhara', 14, 700.00, '2024-10-21 22:19:39', 'Pending', 11);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `item_id`, `quantity`) VALUES
(68, 12, 0, 0),
(69, 12, 0, 0),
(70, 12, 0, 0),
(71, 12, 0, 0),
(72, 13, 0, 0),
(73, 13, 0, 2),
(74, 13, 0, 0),
(75, 13, 0, 0),
(76, 13, 0, 0),
(77, 13, 0, 0),
(78, 13, 0, 0),
(79, 13, 0, 0),
(80, 13, 0, 0),
(81, 13, 0, 0),
(82, 14, 0, 0),
(83, 14, 0, 1),
(84, 14, 0, 0),
(85, 14, 0, 0),
(86, 14, 0, 0),
(87, 14, 0, 0),
(88, 14, 0, 0),
(89, 14, 0, 0),
(90, 14, 0, 0),
(91, 14, 0, 0),
(92, 15, 0, 0),
(93, 15, 0, 1),
(94, 15, 0, 0),
(95, 15, 0, 0),
(96, 15, 0, 0),
(97, 15, 0, 0),
(98, 15, 0, 0),
(99, 15, 0, 0),
(100, 15, 0, 0),
(101, 15, 0, 0),
(102, 16, 0, 0),
(103, 16, 0, 1),
(104, 16, 0, 0),
(105, 16, 0, 0),
(106, 16, 0, 0),
(107, 16, 0, 0),
(108, 16, 0, 0),
(109, 16, 0, 0),
(110, 16, 0, 0),
(111, 16, 0, 0),
(112, 17, 1, 1),
(113, 17, 4, 1),
(114, 18, 1, 1),
(115, 18, 16, 1),
(116, 19, 21, 1),
(117, 20, 23, 1),
(118, 20, 25, 2),
(119, 20, 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `subcategory_name`, `category_id`, `image`) VALUES
(12, 'Cake', 6, 'cake.jpeg'),
(13, 'MOMO', 7, 'momo.jpg'),
(14, 'Juice', 8, 'juice2.jpeg'),
(15, 'coffee', 8, 'coffee.jpeg'),
(16, 'Pizza', 7, 'pizza.jpg'),
(17, 'Noodles', 7, 'noodles.jpeg'),
(18, 'Noodles', 7, 'noodles.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `table_id` int(11) NOT NULL,
  `table_num` int(11) NOT NULL,
  `status` enum('available','occupied') NOT NULL DEFAULT 'available',
  `capacity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_id`, `table_num`, `status`, `capacity`) VALUES
(12, 1, 'occupied', 4),
(14, 2, 'occupied', 3),
(15, 3, 'available', 5),
(17, 4, 'available', 8),
(18, 5, 'available', 2),
(19, 6, 'available', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','cashier') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$hhNzpuyls7lirNkHfrRZLe3Mh7.5K5q0qE35MOqLI7fQLs/woH532', 'admin'),
(2, 'cashier', 'cashier@gmail.com', '$2y$10$k37hYCAfh9VIzMZV00u7dOnR3aCSoAB1SWO2SajUehuTZ3E2i2L0O', 'cashier'),
(3, 'cashier1', 'cashier1@gmail.com', '$2y$10$AdVl70cauQ1n6th8iz5LOuy7SuInhYrK/phV6Gbfv.qAZ/yb.FSba', 'cashier'),
(4, 'cashier2', 'cashier2@gmail.com', '$2y$10$tYGyxH5sUG2XXsQQK5AO9.S0FrkxBTfJVp2UKkJhLGregLiVcqH6C', 'cashier');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cashiers`
--
ALTER TABLE `cashiers`
  ADD PRIMARY KEY (`cashier_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_subcategory` (`subcategory_id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `orderss`
--
ALTER TABLE `orderss`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orderss_ibfk_1` (`table_id`),
  ADD KEY `fk_cashier` (`cashier_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cashiers`
--
ALTER TABLE `cashiers`
  MODIFY `cashier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `orderss`
--
ALTER TABLE `orderss`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cashiers`
--
ALTER TABLE `cashiers`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_subcategory` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orderss`
--
ALTER TABLE `orderss`
  ADD CONSTRAINT `fk_cashier` FOREIGN KEY (`cashier_id`) REFERENCES `cashiers` (`cashier_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orderss_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `tables` (`table_id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2024 at 09:06 AM
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
  `user_id` int(11) DEFAULT NULL,
  `workload` int(11) DEFAULT 0,
  `status` enum('available','busy') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cashiers`
--

INSERT INTO `cashiers` (`cashier_id`, `cashier_name`, `shift`, `user_id`, `workload`, `status`) VALUES
(10, '', 'Evening', 3, 1, 'available'),
(11, '', 'Morning', 4, 0, 'available');

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

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `item_id` int(11) UNSIGNED NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`item_id`, `item_name`, `price`, `subcategory_id`, `category_id`) VALUES
(21, 'chocolate cake', 100.00, 12, 6),
(23, 'strawberry cake', 150.00, 12, 6),
(24, 'chicken_momo', 180.00, 13, 7),
(25, 'fruit Juice', 200.00, 14, 8),
(26, 'Hawaiian Pizza', 300.00, 16, 7),
(27, 'Chicken noodles', 250.00, 17, 7),
(28, 'cold coffee', 200.00, 15, 8),
(29, 'hot coffee', 100.00, 15, 8),
(30, 'veg momo', 150.00, 13, 7),
(31, 'Veg Pizza', 230.00, 16, 7),
(32, 'Black Tea', 50.00, 19, 8),
(33, 'chocolate donut', 100.00, 20, 6),
(34, 'straberry donuts', 150.00, 20, 6),
(35, 'vanilla cake ', 100.00, 12, 6),
(36, 'Coke', 80.00, 21, 8),
(37, 'Fanta', 80.00, 21, 8),
(38, 'Coconut Juice', 150.00, 14, 8);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','In Progress','Completed') NOT NULL DEFAULT 'Pending',
  `cashier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `table_id`, `total_price`, `order_date`, `status`, `cashier_id`) VALUES
(46, 'alisha', 21, 150.00, '2024-10-24 12:23:08', 'Completed', NULL),
(47, 'jenisha', 20, 200.00, '2024-10-24 12:23:09', 'Completed', NULL),
(48, 'alisha ', 21, 150.00, '2024-10-24 17:26:22', 'Completed', NULL),
(49, 'azu', 22, 200.00, '2024-10-24 17:26:24', 'Completed', NULL),
(50, 'nalina', 23, 300.00, '2024-10-27 19:29:09', 'Completed', NULL),
(51, 'suman', 24, 100.00, '2024-10-27 19:51:10', 'Completed', NULL),
(52, 'Jen', 20, 450.00, '2024-10-27 19:53:26', 'Completed', NULL),
(53, 'jenisa', 25, 260.00, '2024-10-28 21:55:44', 'Completed', NULL),
(54, 'jenisha', 20, 180.00, '2024-10-28 22:48:11', 'Completed', NULL),
(55, 'jharana', 21, 100.00, '2024-10-28 22:51:09', 'Completed', NULL),
(56, 'tin', 22, 250.00, '2024-11-05 13:45:20', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `item_id`, `quantity`) VALUES
(144, 46, 32, 1),
(145, 47, 28, 1),
(146, 48, 23, 1),
(147, 49, 28, 1),
(148, 50, 26, 1),
(149, 51, 21, 1),
(150, 52, 27, 1),
(151, 52, 30, 1),
(152, 52, 32, 1),
(153, 53, 24, 1),
(154, 53, 36, 1),
(155, 54, 24, 1),
(156, 55, 35, 1),
(157, 56, 35, 1),
(158, 56, 38, 1);

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
(18, 'Noodles', 7, 'noodles.jpeg'),
(19, 'Tea', 8, 'OIP.jpeg'),
(20, 'Donuts', 6, 'donut.png'),
(21, 'Soft Drinks', 8, 'softdrink.jpeg');

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
(20, 1, 'available', 3),
(21, 2, 'available', 5),
(22, 3, 'occupied', 2),
(23, 4, 'available', 6),
(24, 5, 'available', 8),
(25, 6, 'available', 10);

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
(3, 'cashier1', 'cashier1@gmail.com', '$2y$10$AdVl70cauQ1n6th8iz5LOuy7SuInhYrK/phV6Gbfv.qAZ/yb.FSba', 'cashier'),
(4, 'cashier2', 'cashier2@gmail.com', '$2y$10$tYGyxH5sUG2XXsQQK5AO9.S0FrkxBTfJVp2UKkJhLGregLiVcqH6C', 'cashier'),
(8, 'cashier3', 'cashier3@gmail.com', '$2y$10$91/KiQP73bZdnfmg79z.muKeFY/n5dJ69Z0edNjWTE6QN3W7.sGVe', 'cashier');

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
  ADD UNIQUE KEY `unique_item_id` (`item_id`),
  ADD KEY `fk_subcategory` (`subcategory_id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orderss_ibfk_1` (`table_id`),
  ADD KEY `fk_cashier` (`cashier_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD UNIQUE KEY `unique_order_item` (`order_id`,`item_id`),
  ADD KEY `fk_item_id` (`item_id`);

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
  MODIFY `cashier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_cashier` FOREIGN KEY (`cashier_id`) REFERENCES `cashiers` (`cashier_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `tables` (`table_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_item_id` FOREIGN KEY (`item_id`) REFERENCES `menu` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 01:19 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesummerhousecafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'All-Day Breakfast', '2023-12-04 13:49:23', NULL),
(2, 'Healthy Salads', '2023-12-04 13:49:23', NULL),
(3, 'House Specials', '2023-12-04 13:49:23', NULL),
(4, 'Appetizer', '2023-12-04 13:49:23', NULL),
(5, 'Desserts', '2023-12-04 13:49:23', NULL),
(6, 'Coffee & Tea', '2023-12-04 13:49:23', NULL),
(7, 'Pasta', '2023-12-04 13:49:23', NULL),
(8, 'Smoothies', '2023-12-04 13:49:23', NULL),
(9, 'Beverages', '2023-12-04 13:49:23', NULL),
(10, 'Beers', '2023-12-04 13:49:23', NULL),
(19, 'test', '2023-12-04 13:49:23', '2023-12-05 05:12:26'),
(21, 'check', '2023-12-05 12:14:45', '2023-12-05 05:12:37');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ref_num` int(11) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_name` varchar(255) NOT NULL,
  `payment_type` enum('cash','gcash','bank transfer','card') NOT NULL,
  `amount_tendered` int(11) NOT NULL,
  `change_amount` int(11) NOT NULL,
  `mobile_num` varchar(55) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL,
  `vat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `ref_num`, `total_amount`, `created_at`, `customer_name`, `payment_type`, `amount_tendered`, `change_amount`, `mobile_num`, `notes`, `discount`, `vat`) VALUES
(312, 17, 0, 465, '2023-06-01 15:15:13', 'Repos', 'cash', 500, 35, '+639208979564', '', 0, 0),
(313, 16, 0, 810, '2023-02-23 15:17:46', 'krato', 'gcash', 900, 90, '+639208979564', 'wew', 0, 0),
(314, 16, 0, 210, '2023-11-21 16:26:05', 'Jack', 'cash', 400, 190, '+639208979564', '', 0, 0),
(315, 16, 0, 270, '2023-09-30 16:30:02', 'Repos', 'cash', 400, 130, '+639208979564', '', 0, 0),
(316, 16, 0, 660, '2023-11-21 16:39:32', 'krato', 'cash', 700, 40, '+639208979564', '', 0, 0),
(317, 16, 0, 90, '2023-11-22 01:57:32', 'Repos', 'cash', 95, 5, '+639208979564', 'thank you!', 0, 0),
(318, 16, 0, 1440, '2023-11-22 03:42:06', 'Eugine', 'bank transfer', 1500, 60, '+639208979564', 'wew', 0, 0),
(319, 16, 0, 150, '2023-11-22 03:50:11', 'Jack', 'gcash', 200, 50, '+639208979564', 'wew', 0, 0),
(320, 16, 0, 600, '2023-11-22 03:50:52', 'Jack', 'bank transfer', 600, 0, '+639208979564', '', 0, 0),
(321, 16, 0, 700, '2023-11-22 03:51:42', 'Karasu', 'gcash', 800, 100, '+639208979564', 'wew', 0, 0),
(322, 16, 0, 145, '2023-11-22 03:52:05', 'krato', 'gcash', 400, 255, '+639208979564', '', 0, 0),
(323, 16, 0, 885, '2023-11-22 06:36:19', 'Repos', 'cash', 900, 15, '+639208979564', '', 0, 0),
(324, 16, 0, 895, '2023-11-23 17:06:46', 'miggy', 'cash', 900, 5, '0977795160734', 'Hey', 0, 0),
(325, 16, 0, 11230, '2023-11-29 05:07:47', 'Nika', 'cash', 15000, 3770, '+639208979564', 'ty', 0, 0),
(326, 16, 0, 125, '2023-12-04 05:14:05', 'Repos', 'cash', 400, 275, '09559320812', 'wew', 0, 0),
(327, 16, 0, 210, '2023-12-05 04:01:51', 'Repos', 'cash', 400, 190, '+639208979564', 'wew', 0, 0),
(328, 16, 0, 125, '2023-12-05 04:28:22', 'Jack', 'cash', 400, 275, '+639208979564', 'w', 0, 0),
(329, 16, 0, 1590, '2023-12-05 05:32:53', 'miggy', 'gcash', 2000, 410, '+639208979564', 'wew', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `subtotal`) VALUES
(241, 312, 3, 4, 340),
(242, 312, 4, 1, 125),
(243, 313, 7, 4, 540),
(244, 313, 16, 3, 270),
(245, 314, 4, 1, 125),
(246, 314, 3, 1, 85),
(247, 315, 16, 3, 270),
(248, 316, 6, 3, 405),
(249, 316, 10, 3, 255),
(250, 317, 18, 3, 90),
(251, 318, 10, 4, 340),
(252, 318, 13, 5, 575),
(253, 318, 15, 3, 525),
(254, 319, 20, 3, 150),
(255, 320, 12, 1, 175),
(256, 320, 8, 2, 290),
(257, 320, 7, 1, 135),
(258, 321, 15, 4, 700),
(259, 322, 8, 1, 145),
(260, 323, 4, 3, 375),
(261, 323, 3, 6, 510),
(262, 324, 1, 1, 115),
(263, 324, 2, 1, 105),
(264, 324, 6, 5, 675),
(265, 325, 3, 1, 85),
(266, 325, 4, 1, 125),
(267, 325, 8, 76, 11020),
(268, 326, 4, 1, 125),
(269, 327, 4, 1, 125),
(270, 327, 3, 1, 85),
(271, 328, 4, 1, 125),
(272, 329, 7, 2, 270),
(273, 329, 6, 2, 270),
(274, 329, 12, 6, 1050);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `prod_updated_at` datetime DEFAULT NULL,
  `ordered_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `category_id`, `image`, `prod_updated_at`, `ordered_at`) VALUES
(1, 'Cornsilog', 115, 1, '../images/categories/All-Day-Breakfast/Cornsilog.jpg', NULL, '2023-12-04 00:00:00'),
(2, 'Tapsilog', 105, 1, '../images/categories/All-Day-Breakfast/Tapsilog.jpg', NULL, '2023-12-04 00:00:00'),
(3, 'Tocilog', 85, 1, '../images/categories/All-Day-Breakfast/Tocilog.jpg', NULL, '2023-12-04 00:00:00'),
(4, 'Caesar\'s Salad', 125, 2, '../images/categories/Healthy-Salads/Caesar.jpg', NULL, '2023-12-04 00:00:00'),
(5, 'Crab & Mango Salad', 155, 2, '../images/categories/Healthy-Salads/Crab.jpg', NULL, '2023-12-04 00:00:00'),
(6, 'Waldorf Salad', 135, 2, '../images/categories/Healthy-Salads/Waldorf.jpg', NULL, '2023-12-04 00:00:00'),
(7, 'Pork Sinuso', 135, 3, '../images/categories/House-Specials/Pork Sinuso.jpg', NULL, '2023-12-04 00:00:00'),
(8, 'Teriyaki Chicken', 145, 3, '../images/categories/House-Specials/Teriyaki Chicken.jpg', NULL, '2023-12-04 00:00:00'),
(9, 'Lumpia(5pcs)', 75, 4, '../images/categories/Appetizers/Lumpia.jpg', NULL, '2023-12-04 00:00:00'),
(10, 'Dynamite (8pcs)', 85, 4, '../images/categories/Appetizers/Dynamite.jpg', NULL, '2023-12-04 00:00:00'),
(11, 'French Fries Plain (45gms)', 45, 4, '../images/categories/Appetizers/Plain Fries.jpg', NULL, '2023-12-04 00:00:00'),
(12, 'Cheesy French Fries (135gms)', 175, 4, '../images/categories/Appetizers/Cheesy Fries.jpg', NULL, '2023-12-04 00:00:00'),
(13, 'Chimichanga', 115, 4, '../images/categories/Appetizers/Chimichanga.jpg', NULL, '2023-12-04 00:00:00'),
(14, 'Chicken Fajita', 135, 4, '../images/categories/Appetizers/Chicken Fajita.jpg', NULL, '2023-12-04 00:00:00'),
(15, 'Homemade Nachos', 175, 4, '../images/categories/Appetizers/Nachos.jpg', NULL, '2023-12-04 00:00:00'),
(16, 'Banana Split', 90, 5, '../images/categories/Desserts/Banana Split.jpg', NULL, '2023-12-04 00:00:00'),
(17, 'French Toast', 95, 5, '../images/categories/Desserts/French Toast.jpg', NULL, '2023-12-04 00:00:00'),
(18, 'Ice Cream', 30, 5, '../images/categories/Desserts/Ice Cream.jpg', NULL, '2023-12-04 00:00:00'),
(19, 'Summerhouse Halo-Halo', 115, 5, '../images/categories/Desserts/Halo-halo.jpg', NULL, '2023-12-04 00:00:00'),
(20, 'Corn Coffee', 50, 6, '../images/categories/Coffee -Tea/Corn Coffee.jpg', NULL, '2023-12-04 00:00:00'),
(21, 'Honey Ginger Tea(hot or cold)', 65, 6, '../images/categories/Coffee -Tea/Honey Tea.jpg', NULL, '2023-12-04 00:00:00'),
(22, 'Summerhouse Coffee', 50, 6, '../images/categories/Coffee -Tea/Summerhouse Coffee.jpg', NULL, '2023-12-04 00:00:00'),
(23, 'Carbonara', 135, 7, '../images/categories/Pasta/Carbonara.jpg', NULL, '2023-12-04 00:00:00'),
(24, 'Filipino-Style', 115, 7, '../images/categories/Pasta/Spaghetti.jpg', NULL, '2023-12-04 00:00:00'),
(25, 'Tuna Puttanesca', 135, 7, '../images/categories/Pasta/Putanesca.jpeg', NULL, '2023-12-04 00:00:00'),
(26, 'Apple Smoothie', 85, 8, '../images/categories/Smoothies/Apple.jpg', NULL, '2023-12-04 00:00:00'),
(27, 'Banana Smoothie', 75, 8, '../images/categories/Smoothies/Banana.jpg', NULL, '2023-12-04 00:00:00'),
(28, 'Mango Smoothie', 95, 8, '../images/categories/Smoothies/mangos.jpg', NULL, '2023-12-04 00:00:00'),
(29, 'Pineapple / Cucumber Lemonade (Glass)', 45, 9, '../images/categories/Beverages/Cucumber Lemonade.jpg', NULL, '2023-12-04 00:00:00'),
(30, 'Pineapple / Cucumber Lemonade (Pitcher)', 125, 9, '../images/categories/Beverages/Pineapple Juice.jpg', NULL, '2023-12-04 00:00:00'),
(31, 'Coke/Sprite/Royal(in can)', 55, 9, '../images/categories/Beverages/Sprite.jpg', NULL, '2023-12-04 00:00:00'),
(32, 'Coke/Sprite/Royal(Swakto 200mL)', 25, 9, '../images/categories/Beverages/Royal.jpeg', NULL, '2023-12-04 00:00:00'),
(33, 'San Mig Apple', 75, 10, '../images/categories/Beers/Apple Beer.jpg', NULL, '2023-12-04 00:00:00'),
(34, 'San Mig Light', 75, 10, '../images/categories/Beers/Pale Pilsen.jpg', NULL, '2023-12-04 00:00:00'),
(35, 'San Miguel Pale Pilsen', 65, 10, '../images/categories/Beers/San Mig Light.jpg', NULL, '2023-12-04 00:00:00'),
(90, 'empi', 4, 19, '../images/categories/Other/empi.jpg', '2023-12-05 04:12:39', '2023-12-04 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `type`, `description`) VALUES
(1, 'owner', 'Admin access'),
(2, 'Staff', 'Limited access');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `display_name` varchar(55) NOT NULL,
  `birthdate` date NOT NULL DEFAULT current_timestamp(),
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female','Other','') NOT NULL,
  `mobile_num` varchar(55) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registered_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `display_name`, `birthdate`, `age`, `gender`, `mobile_num`, `username`, `password`, `registered_at`, `updated_at`) VALUES
(16, 1, 'Christian', '2023-11-21', 0, 'Male', '', 'admin123', 'admin@143', '2023-12-05 11:13:42', NULL),
(17, 2, 'James', '2023-11-21', 0, 'Male', '', 'staff123', 'staff@143', '2023-12-05 11:13:42', NULL),
(26, 2, 'Morsyy', '1999-04-14', 23, 'Female', '+639208979564', 'change', '321', '2023-12-05 11:40:16', '2023-12-05 05:12:34'),
(27, 2, 'Sagpa', '1999-12-19', 23, 'Male', '+639208979564', 'rock', '123', '2023-12-05 11:45:20', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `fk_order_id` (`order_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=330;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

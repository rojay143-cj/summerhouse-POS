-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2023 at 08:17 AM
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
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'All-Day Breakfast'),
(2, 'Healthy Salads'),
(3, 'House Specials'),
(4, 'Appetizer'),
(5, 'Desserts'),
(6, 'Coffee & Tea'),
(7, 'Pasta'),
(8, 'Smoothies'),
(9, 'Beverages'),
(10, 'Beers');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_name` varchar(255) NOT NULL,
  `payment_type` enum('cash','gcash','bank transfer','card') NOT NULL,
  `amount_tendered` int(11) NOT NULL,
  `change_amount` int(11) NOT NULL,
  `notes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `category_id`, `image`) VALUES
(1, 'Cornsilog', 115, 1, '../images/categories/All-Day-Breakfast/Cornsilog.jpg'),
(2, 'Tapsilog', 105, 1, '../images/categories/All-Day-Breakfast/Tapsilog.jpg'),
(3, 'Tocilog', 85, 1, '../images/categories/All-Day-Breakfast/Tocilog.jpg'),
(4, 'Caesar\'s Salad', 125, 2, '../images/categories/Healthy-Salads/Caesar.jpg'),
(5, 'Crab & Mango Salad', 155, 2, '../images/categories/Healthy-Salads/Crab.jpg'),
(6, 'Waldorf Salad', 135, 2, '../images/categories/Healthy-Salads/Waldorf.jpg'),
(7, 'Pork Sinuso', 135, 3, '../images/categories/House-Specials/Pork Sinuso.jpg'),
(8, 'Teriyaki Chicken', 145, 3, '../images/categories/House-Specials/Teriyaki Chicken.jpg'),
(9, 'Lumpia(5pcs)', 75, 4, '../images/categories/Appetizers/Lumpia.jpg'),
(10, 'Dynamite (8pcs)', 85, 4, '../images/categories/Appetizers/Dynamite.jpg'),
(11, 'French Fries Plain (45gms)', 45, 4, '../images/categories/Appetizers/Plain Fries.jpg'),
(12, 'Cheesy French Fries (135gms)', 175, 4, '../images/categories/Appetizers/Cheesy Fries.jpg'),
(13, 'Chimichanga', 115, 4, '../images/categories/Appetizers/Chimichanga.jpg'),
(14, 'Chicken Fajita', 135, 4, '../images/categories/Appetizers/Chicken Fajita.jpg'),
(15, 'Homemade Nachos', 175, 4, '../images/categories/Appetizers/Nachos.jpg'),
(16, 'Banana Split', 90, 5, '../images/categories/Desserts/Banana Split.jpg'),
(17, 'French Toast', 95, 5, '../images/categories/Desserts/French Toast.jpg'),
(18, 'Ice Cream', 30, 5, '../images/categories/Desserts/Ice Cream.jpg'),
(19, 'Summerhouse Halo-Halo', 115, 5, '../images/categories/Desserts/Halo-halo.jpg'),
(20, 'Corn Coffee', 50, 6, '../images/categories/Coffee -Tea/Corn Coffee.jpg'),
(21, 'Honey Ginger Tea(hot or cold)', 65, 6, '../images/categories/Coffee -Tea/Honey Tea.jpg'),
(22, 'Summerhouse Coffee', 50, 6, '../images/categories/Coffee -Tea/Summerhouse Coffee.jpg'),
(23, 'Carbonara', 135, 7, '../images/categories/Pasta/Carbonara.jpg'),
(24, 'Filipino-Style', 115, 7, '../images/categories/Pasta/Spaghetti.jpg'),
(25, 'Tuna Puttanesca', 135, 7, '../images/categories/Pasta/Putanesca.jpeg'),
(26, 'Apple Smoothie', 85, 8, '../images/categories/Smoothies/Apple.jpg'),
(27, 'Banana Smoothie', 75, 8, '../images/categories/Smoothies/Banana.jpg'),
(28, 'Mango Smoothie', 95, 8, '../images/categories/Smoothies/mangos.jpg'),
(29, 'Pineapple / Cucumber Lemonade (Glass)', 45, 9, '../images/categories/Beverages/Cucumber Lemonade.jpg'),
(30, 'Pineapple / Cucumber Lemonade (Pitcher)', 125, 9, '../images/categories/Beverages/Pineapple Juice.jpg'),
(31, 'Coke/Sprite/Royal(in can)', 55, 9, '../images/categories/Beverages/Sprite.jpg'),
(32, 'Coke/Sprite/Royal(Swakto 200mL)', 25, 9, '../images/categories/Beverages/Royal.jpeg'),
(33, 'San Mig Apple', 75, 10, '../images/categories/Beers/Apple Beer.jpg'),
(34, 'San Mig Light', 75, 10, '../images/categories/Beers/Pale Pilsen.jpg'),
(35, 'San Miguel Pale Pilsen', 65, 10, '../images/categories/Beers/San Mig Light.jpg');

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
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `display_name`, `username`, `password`) VALUES
(16, 1, 'Christian', 'admin123', 'admin@143'),
(17, 2, 'James', 'staff123', 'staff@143');

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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

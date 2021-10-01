-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2021 at 06:15 PM
-- Server version: 8.0.26-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supermario`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int NOT NULL,
  `brand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Levis'),
(4, 'H&M'),
(14, 'Sketchers'),
(17, 'Polo'),
(18, 'Addidas');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `items` text NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint NOT NULL DEFAULT '0',
  `shipped` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `shipped`) VALUES
(10, '[{\"id\":\"1\",\"size\":\"28.\",\"quantity\":3}]', '2021-10-28 10:35:03', 1, 0),
(11, '[{\"id\":\"3\",\"size\":\"small\",\"quantity\":\"1\"}]', '2021-10-29 12:28:15', 1, 0),
(12, '[{\"id\":\"3\",\"size\":\"small\",\"quantity\":\"1\"}]', '2021-10-29 13:36:22', 1, 0),
(13, '[{\"id\":\"3\",\"size\":\"small\",\"quantity\":\"1\"}]', '2021-10-29 14:31:45', 1, 0),
(14, '[{\"id\":\"4\",\"size\":\"small\",\"quantity\":\"1\"}]', '2021-10-29 14:41:50', 1, 0),
(15, '[{\"id\":\"3\",\"size\":\"small\",\"quantity\":\"1\"}]', '2021-10-29 14:46:41', 1, 0),
(16, '[{\"id\":\"2\",\"size\":\"medium\",\"quantity\":\"2\"}]', '2021-10-29 14:48:23', 1, 0),
(17, '[{\"id\":\"2\",\"size\":\"small\",\"quantity\":2}]', '2021-10-29 14:53:20', 1, 0),
(18, '[{\"id\":\"3\",\"size\":\"Small\",\"quantity\":\"2\"}]', '2021-10-29 14:59:40', 1, 0),
(19, '[{\"id\":\"1\",\"size\":\"32\",\"quantity\":\"2\"}]', '2021-10-29 15:11:44', 1, 0),
(20, '[{\"id\":\"3\",\"size\":\"medium\",\"quantity\":2}]', '2021-10-29 15:33:25', 1, 0),
(21, '[{\"id\":\"4\",\"size\":\"small\",\"quantity\":\"1\"},{\"id\":\"3\",\"size\":\"medium\",\"quantity\":\"1\"},{\"id\":\"2\",\"size\":\"small\",\"quantity\":\"1\"},{\"id\":\"1\",\"size\":\"32\",\"quantity\":\"1\"},{\"id\":\"11\",\"size\":\"medium\",\"quantity\":\"1\"},{\"id\":\"4\",\"size\":\"medium\",\"quantity\":3},{\"id\":\"3\",\"size\":\"small\",\"quantity\":\"1\"}]', '2021-10-29 17:31:20', 1, 0),
(22, '[{\"id\":\"2\",\"size\":\"large\",\"quantity\":\"2\"},{\"id\":\"3\",\"size\":\"small\",\"quantity\":\"3\"}]', '2021-10-31 10:17:17', 1, 0),
(23, '[{\"id\":\"2\",\"size\":\"large\",\"quantity\":\"1\"}]', '2021-10-31 10:22:06', 1, 0),
(24, '[{\"id\":\"3\",\"size\":\"small\",\"quantity\":\"1\"}]', '2021-10-31 10:28:10', 1, 0),
(25, '[{\"id\":\"3\",\"size\":\"small\",\"quantity\":\"1\"}]', '2021-10-31 10:32:30', 1, 0),
(26, '[{\"id\":\"2\",\"size\":\"small\",\"quantity\":\"2\"},{\"id\":\"3\",\"size\":\"small\",\"quantity\":2},{\"id\":\"4\",\"size\":\"small\",\"quantity\":\"1\"}]', '2021-10-31 10:41:51', 1, 1),
(27, '[{\"id\":\"10\",\"size\":\"small\",\"quantity\":\"2\"}]', '2021-10-31 16:41:40', 1, 0),
(28, '[{\"id\":\"3\",\"size\":\"medium\",\"quantity\":\"2\"},{\"id\":\"4\",\"size\":\"large\",\"quantity\":2}]', '2021-10-31 17:11:20', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `category` varchar(255) NOT NULL,
  `parent` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Men', 0),
(2, 'Women', 0),
(3, 'Boys', 0),
(4, 'Girls', 0),
(5, 'Shirts', 1),
(6, 'Pants', 1),
(7, 'Shoes', 1),
(8, 'Accesories', 1),
(9, 'Shirts', 2),
(10, 'Pants', 2),
(11, 'Shoes', 2),
(12, 'Dresses', 2),
(13, 'Shirt', 3),
(14, 'Pants', 3),
(15, 'Dresses', 4),
(16, 'Shoes', 4),
(17, 'Accessories', 2),
(23, 'Gifts', 0),
(25, 'Home Decor', 23),
(27, 'Shoes', 3);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` double(10,2) NOT NULL,
  `brand` int NOT NULL,
  `categories` varchar(255) NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `featured` tinyint DEFAULT '0',
  `sizes` text NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0',
  `sold` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`, `sold`) VALUES
(1, 'Angry Mario', '39.99', 69.99, 1, '8', '/eCommerce/images/products/0d7288f3779588746d1d09650e8379c1.png', 'This jeans are amazing. They are super comfy and sexy! Buy them please.', 1, '28:7,32:5,36:1', 0, 4),
(2, 'Happy Mario', '19.99', 24.99, 1, '6', 'images/products/s2.jpg', 'What a beautiful shirt... blah blah bla. Please Buy me! We spent too much on our site and we are broke!', 1, 'small:2,medium:4,large:6', 0, 1),
(3, 'Red Mario', '39.99', 55.99, 1, '8', 'images/products/s3.jpg', 'Super Mario i veshur me te kuqe dhe me super fuqi zjarr hedhesi.', 1, 'small:2,medium:3,large:3', 0, 1),
(4, 'Dragon Mario', '79.99', 110.99, 1, '7', 'images/products/s4.png', 'Super Mario me dragoin e tij ngjyre jeshile duke fluturuar.', 1, 'small:1,medium:0,large:1', 0, 2),
(10, 'Super Mario', '59.99', 0.00, 4, '16', 'images/products/da14a42440fa4007cedda2c71f10e323.png', '', 1, 'small:1,medium:3,large:3', 0, 2),
(11, 'Flying Mario', '36.99', 49.99, 17, '25', 'images/products/3541f70d3feca93d62c227e22eca55b1.png', 'This is super cool product. Buy it!', 1, 'small:3,medium:2,large:3', 1, 5),
(12, 'Super', '59.99', 69.99, 4, '13', 'images/products/4fcf5b3db43d5f0756c0ddddd563924a.jpg,images/products/4dded242b8e5f8000189e2952d4c2ed0.jpg,images/products/33cc1049733f4c782dc2992fb23e179e.png', 'sdfsaggs', 1, 'small:5,large:3', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `charge_id` varchar(255) NOT NULL,
  `cart_id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(175) NOT NULL,
  `street` varchar(255) NOT NULL,
  `street2` varchar(255) NOT NULL,
  `city` varchar(175) NOT NULL,
  `state` varchar(175) NOT NULL,
  `zip_code` int NOT NULL,
  `country` varchar(175) NOT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `tax` decimal(10,0) NOT NULL,
  `grand_total` decimal(10,0) NOT NULL,
  `description` text NOT NULL,
  `txn_type` varchar(255) NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `charge_id`, `cart_id`, `full_name`, `email`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `sub_total`, `tax`, `grand_total`, `description`, `txn_type`, `txn_date`) VALUES
(1, 'ch_3JfhOuH8CibGKmXC1AMVrj0T', 26, 'sadfga', '505instam505@gmail.com', 'adgfad', 'hgfddsa', 'adf', 'adfg', 1253, 'adfg', '200', '26', '226', '5 items from SUPERMARIO Store.', 'charge', '2021-10-01 10:47:29'),
(2, 'ch_3Jfn5EH8CibGKmXC07TBJ45E', 27, 'sadfga', '505instam505@gmail.com', 'adgfad', 'hgfddsa', 'adf', 'adfg', 1253, 'adfg', '120', '16', '136', '2 items from SUPERMARIO Store.', 'charge', '2021-10-01 16:51:33'),
(3, 'ch_3JfnPqH8CibGKmXC0BMdgAau', 28, 'sadfga', '505instam505@gmail.com', 'adgfad', 'hgfddsa', 'adf', 'adfg', 1253, 'adfg', '240', '31', '271', '4 items from SUPERMARIO Store.', 'charge', '2021-10-01 17:12:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(175) NOT NULL,
  `password` varchar(255) NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `permissions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'Sadri Pervana', 'sadripervana@gmail.com', '$2y$10$trEOQf0QZeVlaEAmeVVXAe5OIeI17861SSD4IvyylCFRgnn0DhJhq', '2021-09-23 11:10:38', '2021-10-01 14:48:50', 'admin,editor'),
(3, 'test test2', '505instam505@gmail.com', '$2y$10$um5SfqVaSUL2omM3XbIvVuBOHffHqGN.JnVreROAj9/sf0mMxs.ba', '2021-09-23 17:43:01', '2021-09-24 16:25:10', 'editor'),
(5, 'test test', '504instam504@gmail.com', '$2y$10$HyFg4C9YntLaS8d1srTIWuJTs.3S4oPUoBospO1YkFN7M0rk4PNzW', '2021-09-24 11:51:11', '2021-09-24 15:52:18', 'admin,editor'),
(6, 'test test', '501instam501@gmail.com', '$2y$10$GIHyWwdtdmChe.yMGKRMxudKAR/kYyCoDvfBgewEETwCvdaycEpiO', '2021-09-24 11:53:14', '2021-09-24 12:06:47', 'admin,editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2018 at 05:59 PM
-- Server version: 5.7.22-0ubuntu0.17.10.1
-- PHP Version: 7.1.17-0ubuntu0.17.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `football`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `product_name`, `product_code`, `product_color`, `size`, `price`, `quantity`, `user_email`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 5, 'Green Casual T-Shirt', 'GTS001', 'Green', 'Small', '2000', 3, '', '', NULL, NULL),
(2, 7, 'Blue Sport Shoes', 'BSS001', 'Blue', 'Small', '300', 3, '', '', NULL, NULL),
(3, 7, 'Blue Sport Shoes', 'BSS001', 'Blue', 'Medium', '300', 3, '', 'O0LHgbrJwF8kHvP5RTx7EYRfobNRfF9fD02pltLN', NULL, NULL),
(5, 7, 'Blue Sport Shoes', 'BSS001', 'Blue', 'Medium', '300', 1, '', 'eEZ7fox534tKcNUtGlpvj4AX9ps7lk1t4tgqy9Hp', NULL, NULL),
(6, 7, 'Blue Sport Shoes', 'BSS001', 'Blue', 'Small', '300', 7, '', 'eEZ7fox534tKcNUtGlpvj4AX9ps7lk1t4tgqy9Hp', NULL, NULL),
(7, 5, 'Green Casual T-Shirt', 'GTS001', 'Green', 'Small', '2000', 1, '', 'eEZ7fox534tKcNUtGlpvj4AX9ps7lk1t4tgqy9Hp', NULL, NULL),
(8, 7, 'Blue Sport Shoes', 'BSS001', 'Blue', 'Large', '300', 3, '', 'eEZ7fox534tKcNUtGlpvj4AX9ps7lk1t4tgqy9Hp', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `description`, `url`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 'T-Shirts', 'T-Shirts category', 't-shirts', 1, NULL, '2018-08-28 02:33:22', '2018-08-28 02:33:22'),
(2, 0, 'Shoes', 'Shoes category', 'shoes', 1, NULL, '2018-08-28 02:33:45', '2018-08-28 02:33:45'),
(3, 1, 'Casual T-Shirts', 'Casual T-Shirts category', 'casual-t-shirts', 1, NULL, '2018-08-28 02:42:06', '2018-08-30 02:46:56'),
(4, 2, 'Casual Shoes', 'Casual Shoes category', 'casual-shoes', 1, NULL, '2018-08-28 02:48:16', '2018-08-28 02:48:16'),
(5, 2, 'Sports Shoes', 'Sports Shoes category', 'sports-shoes', 1, NULL, '2018-08-28 02:49:53', '2018-08-28 02:51:21'),
(6, 0, 'Mens', 'Mens category', 'mens', 1, NULL, '2018-08-29 21:41:39', '2018-08-29 21:41:39'),
(7, 0, 'Womens', 'Womens category', 'womens', 0, NULL, '2018-08-29 21:41:55', '2018-08-30 01:34:10'),
(8, 0, 'Kids', 'Kids category', 'kids', 1, NULL, '2018-08-30 01:22:45', '2018-08-30 01:22:45'),
(9, 0, 'Blazers', 'Blazers category', 'blazers', 1, NULL, '2018-08-30 01:23:22', '2018-08-30 01:29:28');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(21, '2014_10_12_000000_create_users_table', 1),
(22, '2014_10_12_100000_create_password_resets_table', 1),
(23, '2018_08_27_103932_add_admin_in_user', 1),
(24, '2018_08_28_053426_create_category_table', 1),
(25, '2018_08_28_095236_create_products_table', 2),
(26, '2018_08_29_091103_create_products_attributes_table', 3),
(27, '2018_08_31_032127_add_care_in_products', 4),
(28, '2018_09_05_030411_create_product_images_table', 5),
(29, '2018_09_05_075521_add_status_in_product', 6),
(30, '2018_09_05_081130_create_cart_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `care` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `product_code`, `product_color`, `description`, `care`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES
(5, 3, 'Green Casual T-Shirt', 'GTS001', 'Green', 'Green T-Shirt product', '', 1500.00, '52466.png', 1, '2018-08-28 20:07:49', '2018-09-05 01:30:34'),
(6, 3, 'Navi Blue T-Shirt', 'NTS001', 'Navi Blue', 'Navi Blue T-Shirt product', '', 2200.00, '57337.jpg', 1, '2018-08-28 20:28:21', '2018-09-05 01:08:12'),
(7, 5, 'Blue Sport Shoes', 'BSS001', 'Blue', '', '', 500.00, '92505.jpg', 1, '2018-08-29 23:00:44', '2018-08-30 02:42:56'),
(8, 6, 'Hoodie Sweatshirt', 'HS001', 'Green', 'UO-exclusive pullover hoodie featuring cover art from New Order\'s Power, Corruption & Lies. Plush cotton blend in a pullover silhouette with a front kanga pocket and adjustable hood. Finished with banding at cuffs + hem.', '- Cotton, polyester\r\n- Machine wash\r\n- Imported', 59.00, '59978.jpg', 1, '2018-08-30 20:30:02', '2018-08-30 20:47:24'),
(9, 3, 'Green T-Shirt 1', 'GTS002', 'Green', '', '', 1200.00, '16418.jpg', 1, '2018-09-05 00:39:48', '2018-09-05 00:39:48'),
(10, 3, 'Green T-Shirt 2', 'GTS003', 'Green', '', '', 1000.00, '52157.png', 0, '2018-09-05 00:40:13', '2018-09-05 01:03:28'),
(11, 3, 'Green T-Shirt 3', 'GTS004', 'Green', '', '', 2200.00, '97010.jpg', 1, '2018-09-05 00:40:36', '2018-09-05 01:05:05'),
(12, 4, 'Blue Shoes', 'BS001', 'Blue', '', '', 1000.00, '37041.jpg', 1, '2018-09-05 01:00:54', '2018-09-05 01:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `products_attributes`
--

CREATE TABLE `products_attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_attributes`
--

INSERT INTO `products_attributes` (`id`, `product_id`, `sku`, `size`, `price`, `stock`, `created_at`, `updated_at`) VALUES
(4, 5, 'GTS001-S', 'Small', 2000.00, 1, '2018-08-29 19:32:32', '2018-09-04 23:59:49'),
(5, 5, 'GTS001-M', 'Medium', 1200.00, 0, '2018-08-29 19:32:32', '2018-09-04 23:59:49'),
(6, 5, 'GTS001-L', 'Large', 2500.00, 0, '2018-08-29 19:32:32', '2018-09-04 23:59:49'),
(7, 7, 'BSS001-S', 'Small', 300.00, 100, '2018-09-05 01:54:46', '2018-09-05 01:54:46'),
(8, 7, 'BSS001-M', 'Medium', 300.00, 120, '2018-09-05 01:54:46', '2018-09-05 01:54:46'),
(9, 7, 'BSS001-L', 'Large', 300.00, 60, '2018-09-05 01:54:46', '2018-09-05 01:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(6, 5, '77506.jpg', '2018-09-04 20:24:02', '2018-09-04 20:24:02'),
(7, 5, '52300.jpg', '2018-09-04 21:23:30', '2018-09-04 21:23:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$PiKkKB8tomFijH8kF.oTKOlYP0vI4bmcY89fPutm2DuhATRjcFvMi', 1, NULL, '2018-08-28 09:27:55', '2018-08-28 09:27:55');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_attributes`
--
ALTER TABLE `products_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `products_attributes`
--
ALTER TABLE `products_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

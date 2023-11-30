-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 11:35 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce-website`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_photo` varchar(255) NOT NULL DEFAULT 'default_profile_photo.png',
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `last_active` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phone_number`, `gender`, `date_of_birth`, `address`, `profile_photo`, `status`, `last_active`, `password`, `role`, `warehouse_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@email.com', NULL, NULL, NULL, NULL, 'default_profile_photo.png', 'Yes', '2023-06-18 04:13:02', '$2y$10$CAcFMkGYrHnfPGn4pl8rguKMvf799pp57LUGqJMyc/Yzsq1BI4s/2', 'Super Admin', NULL, 'kX3aT2ptFay5WEYQeBGDJvXYwbPQ7fXgOXGiRHzgQu45idi7dUrZ1jy1Cihn', '2023-06-14 05:35:31', '2023-06-18 04:13:02'),
(2, 'Admin', 'admin@email.com', NULL, NULL, NULL, NULL, 'default_profile_photo.png', 'Yes', '2023-06-18 04:27:29', '$2y$10$vXW3rTLZMRzTRZ74VGY5jOQHEz6xKRgCRAVJd/n9HBfutx5JuOTaq', 'Admin', NULL, NULL, '2023-06-13 18:00:00', '2023-06-18 04:27:29'),
(3, 'Warehouse Manager', 'dhakawarehouse@email.com', NULL, NULL, NULL, NULL, 'default_profile_photo.png', 'Yes', '2023-06-18 04:28:26', '$2y$10$3kkZzTLRBqO3ouqweO7jnO1weoQbvHFqif8QRmYFcMmNfOcK4oj/S', 'Manager', 1, NULL, '2023-06-15 05:35:53', '2023-06-18 04:28:26');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_position` varchar(255) NOT NULL,
  `banner_title` varchar(255) NOT NULL,
  `banner_subtitle` varchar(255) NOT NULL,
  `banner_link` varchar(255) NOT NULL,
  `banner_photo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `banner_position`, `banner_title`, `banner_subtitle`, `banner_link`, `banner_photo`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Top', 'Offer', 'Offer', '1', 'Banner-Photo-Qa1Dw.jpg', 'Yes', 1, 1, NULL, '2023-02-18 00:25:26', '2023-02-27 10:59:15', NULL),
(2, 'Top', 'Offer', 'Offer', '2', 'Banner-Photo-AKg01.jpg', 'Yes', 1, 1, NULL, '2023-02-18 00:25:37', '2023-02-27 10:59:19', NULL),
(3, 'Center', 'Offer 15%', 'Offer 15%', '3', 'Banner-Photo-3mJmY.jpg', 'Yes', 1, 1, NULL, '2023-02-18 00:25:58', '2023-02-27 10:59:24', NULL),
(4, 'Center', 'Offer 50Tk', 'Offer 50Tk', '4', 'Banner-Photo-1QhKf.jpg', 'Yes', 1, 1, NULL, '2023-02-18 00:26:14', '2023-02-27 10:59:28', NULL),
(5, 'Bottom', 'Laptop Offer', 'Offer 15%', '5', 'Banner-Photo-LLdUB.jpg', 'Yes', 1, 1, NULL, '2023-02-18 00:26:52', '2023-02-27 10:59:33', NULL),
(6, 'Top', 'Shari Offer', 'Offer', '6', 'Banner-Photo-Xcl8l.jpg', 'Yes', 1, 1, NULL, '2023-02-18 00:27:33', '2023-02-27 10:59:37', NULL),
(7, 'Bottom', 'Keyboard Offer', 'Offer', '7', 'Banner-Photo-3uhUN.jpg', 'Yes', 1, 1, NULL, '2023-02-18 00:28:04', '2023-02-27 10:59:43', NULL),
(8, 'Bottom', 'Mouse Offer', 'Offer', '8', 'Banner-Photo-G3zKe.jpg', 'Yes', 1, 1, NULL, '2023-02-18 00:31:06', '2023-02-27 10:59:47', NULL),
(9, 'Bottom', 'Byke Offer', 'Byke', '9', 'Banner-Photo-NAxBz.jpg', 'Yes', 1, 1, NULL, '2023-02-18 00:31:31', '2023-02-27 10:59:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_headline` text NOT NULL,
  `blog_slug` text NOT NULL,
  `blog_category_id` int(11) NOT NULL,
  `blog_quota` longtext NOT NULL,
  `blog_thumbnail_photo` varchar(255) NOT NULL DEFAULT 'default_blog_thumbnail_photo.jpg',
  `blog_cover_photo` varchar(255) NOT NULL DEFAULT 'default_blog_cover_photo.jpg',
  `blog_details` longtext NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `blog_headline`, `blog_slug`, `blog_category_id`, `blog_quota`, `blog_thumbnail_photo`, `blog_cover_photo`, `blog_details`, `view_count`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'What is Lorem Ipsum?', 'what-is-lorem-ipsum-w447oXkABa', 1, '\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\" \"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain...\"', 'default_blog_thumbnail_photo.jpg', 'default_blog_cover_photo.jpg', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.<br></p>', 2, 'Yes', 1, NULL, NULL, '2023-02-17 23:30:52', '2023-02-27 10:50:40', NULL),
(2, 'Where can I get some?', 'where-can-i-get-some-KmmgmYVnrZ', 2, '\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\" \"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain...\"', 'default_blog_thumbnail_photo.jpg', 'default_blog_cover_photo.jpg', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)<br></p>', 1, 'Yes', 1, NULL, NULL, '2023-02-17 23:31:34', '2023-05-21 04:15:51', NULL),
(3, 'Where does it come from?', 'where-does-it-come-from-k1AqCaalYt', 3, '\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\" \"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain...\"', 'default_blog_thumbnail_photo.jpg', 'default_blog_cover_photo.jpg', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.<br></p>', 1, 'Yes', 1, NULL, NULL, '2023-02-17 23:32:24', '2023-02-27 06:25:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_category_name` varchar(255) NOT NULL,
  `blog_category_slug` varchar(255) NOT NULL,
  `top_blog_category` varchar(255) NOT NULL DEFAULT 'No',
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `blog_category_name`, `blog_category_slug`, `top_blog_category`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'New Year', 'new-year', 'No', 'Yes', 1, NULL, NULL, '2023-02-17 23:28:52', NULL, NULL),
(2, 'Year End', 'year-end', 'No', 'Yes', 1, NULL, NULL, '2023-02-17 23:29:07', NULL, NULL),
(3, 'Flashsale', 'flashsale', 'No', 'Yes', 1, NULL, NULL, '2023-02-17 23:29:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`id`, `blog_id`, `name`, `email`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sabbir Ahammed', 'user@gmail.com', 'Good', '2023-02-27 10:50:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_slug` varchar(255) NOT NULL,
  `brand_photo` varchar(255) NOT NULL,
  `top_brand` varchar(255) NOT NULL DEFAULT 'No',
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `brand_slug`, `brand_photo`, `top_brand`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bmw', 'bmw', 'bmw-brand-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-18 00:00:08', NULL, NULL),
(2, 'Polo', 'polo', 'polo-brand-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-18 00:00:17', NULL, NULL),
(3, 'Htc', 'htc', 'htc-brand-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-18 00:00:29', NULL, NULL),
(4, 'Honda', 'honda', 'honda-brand-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-18 00:00:43', NULL, NULL),
(5, 'Mi', 'mi', 'mi-brand-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-18 00:00:54', NULL, NULL),
(6, 'Hp', 'hp', 'hp-brand-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-18 00:01:04', NULL, NULL),
(7, 'Dove', 'dove', 'dove-brand-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-18 00:01:14', NULL, NULL),
(8, 'Denim', 'denim', 'denim-brand-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-18 00:01:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `product_current_price` int(11) NOT NULL,
  `cart_qty` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `category_photo` varchar(255) NOT NULL,
  `show_home_screen` varchar(255) NOT NULL DEFAULT 'No',
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_slug`, `category_photo`, `show_home_screen`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Men\'s Fashion', 'mens-fashion', 'mens-fashion-category-photo.jpg', 'Yes', 'Yes', 1, 1, NULL, '2023-02-17 23:50:30', '2023-02-18 00:54:49', NULL),
(2, 'Women\'s Fashion', 'womens-fashion', 'womens-fashion-category-photo.jpg', 'Yes', 'Yes', 1, 1, NULL, '2023-02-17 23:50:49', '2023-02-18 00:54:50', NULL),
(3, 'Electronic Devices', 'electronic-devices', 'electronic-devices-category-photo.jpg', 'Yes', 'Yes', 1, 1, NULL, '2023-02-17 23:51:06', '2023-02-18 00:54:51', NULL),
(4, 'Home Appliances', 'home-appliances', 'home-appliances-category-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-17 23:51:20', NULL, NULL),
(5, 'Home & Lifestyle', 'home-lifestyle', 'home-lifestyle-category-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-17 23:51:47', NULL, NULL),
(6, 'Motorbike & Car', 'motorbike-car', 'motorbike-car-category-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-17 23:51:57', NULL, NULL),
(7, 'Sports & Outdoor', 'sports-outdoor', 'sports-outdoor-category-photo.jpg', 'No', 'Yes', 1, NULL, NULL, '2023-02-17 23:52:05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `childcategories`
--

CREATE TABLE `childcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `childcategory_name` varchar(255) NOT NULL,
  `childcategory_slug` varchar(255) NOT NULL,
  `childcategory_photo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `childcategories`
--

INSERT INTO `childcategories` (`id`, `category_id`, `subcategory_id`, `childcategory_name`, `childcategory_slug`, `childcategory_photo`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Rain Boots', 'rain-boots', 'rain-boots-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:56:24', NULL, NULL),
(2, 3, 3, 'Keyboard', 'keyboard', 'keyboard-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:56:43', NULL, NULL),
(3, 3, 6, 'Notebook', 'notebook', 'notebook-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:57:03', NULL, NULL),
(4, 4, 7, 'Iron', 'iron', 'iron-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:57:18', NULL, NULL),
(5, 2, 2, 'Neckless', 'neckless', 'neckless-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:57:37', NULL, NULL),
(6, 6, 4, 'Sports Car', 'sports-car', 'sports-car-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:57:54', NULL, NULL),
(7, 3, 3, 'Mouse', 'mouse', 'mouse-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:58:09', NULL, NULL),
(8, 2, 8, 'Sarees', 'sarees', 'sarees-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:58:54', NULL, NULL),
(9, 2, 8, 'Pants', 'pants', 'pants-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:59:07', NULL, NULL),
(10, 4, 7, 'Water Heater', 'water-heater', 'water-heater-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:59:24', NULL, NULL),
(11, 6, 5, 'Motorcycle', 'motorcycle', 'motorcycle-childcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:59:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `color_name` varchar(255) NOT NULL,
  `color_code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `color_name`, `color_code`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'White', '#ffffff', 'Yes', 1, NULL, NULL, '2023-02-18 00:01:46', NULL, NULL),
(2, 'Black', '#000000', 'Yes', 1, NULL, NULL, '2023-02-18 00:01:55', NULL, NULL),
(3, 'Red', '#ff0000', 'Yes', 1, NULL, NULL, '2023-02-18 00:02:04', NULL, NULL),
(4, 'Yellow', '#fbff00', 'Yes', 1, NULL, NULL, '2023-02-18 00:02:14', NULL, NULL),
(5, 'Green', '#00fa1d', 'Yes', 1, NULL, NULL, '2023-02-18 00:02:23', NULL, NULL),
(6, 'Silver', '#656161', 'Yes', 1, NULL, NULL, '2023-02-18 00:02:33', NULL, NULL),
(7, 'Blue', '#1100ff', 'Yes', 1, NULL, NULL, '2023-02-18 00:02:41', NULL, NULL),
(8, 'N/A', '#f3ecec', 'Yes', 1, NULL, NULL, '2023-02-20 08:28:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `message` longtext NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Unread',
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `full_name`, `email_address`, `phone_number`, `subject`, `message`, `status`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sabbir', 'sabbir1@gmail.com', '01953321402', 'Testt', 'dfgfdlkfguyd jnhfuyasfuidfh xdbfujdhfiuv mnjksdhuidfh', 'Read', NULL, NULL, '2023-04-18 05:21:44', '2023-06-17 05:19:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `country_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`, `country_code`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', 'AF', NULL, NULL),
(2, 'Åland Islands', 'AX', NULL, NULL),
(3, 'Albania', 'AL', NULL, NULL),
(4, 'Algeria', 'DZ', NULL, NULL),
(5, 'American Samoa', 'AS', NULL, NULL),
(6, 'Andorra', 'AD', NULL, NULL),
(7, 'Angola', 'AO', NULL, NULL),
(8, 'Anguilla', 'AI', NULL, NULL),
(9, 'Antarctica', 'AQ', NULL, NULL),
(10, 'Antigua and Barbuda', 'AG', NULL, NULL),
(11, 'Argentina', 'AR', NULL, NULL),
(12, 'Armenia', 'AM', NULL, NULL),
(13, 'Aruba', 'AW', NULL, NULL),
(14, 'Australia', 'AU', NULL, NULL),
(15, 'Austria', 'AT', NULL, NULL),
(16, 'Azerbaijan', 'AZ', NULL, NULL),
(17, 'Bahamas', 'BS', NULL, NULL),
(18, 'Bahrain', 'BH', NULL, NULL),
(19, 'Bangladesh', 'BD', NULL, NULL),
(20, 'Barbados', 'BB', NULL, NULL),
(21, 'Belarus', 'BY', NULL, NULL),
(22, 'Belgium', 'BE', NULL, NULL),
(23, 'Belize', 'BZ', NULL, NULL),
(24, 'Benin', 'BJ', NULL, NULL),
(25, 'Bermuda', 'BM', NULL, NULL),
(26, 'Bhutan', 'BT', NULL, NULL),
(27, 'Bolivia, Plurinational State of', 'BO', NULL, NULL),
(28, 'Bonaire, Sint Eustatius and Saba', 'BQ', NULL, NULL),
(29, 'Bosnia and Herzegovina', 'BA', NULL, NULL),
(30, 'Botswana', 'BW', NULL, NULL),
(31, 'Bouvet Island', 'BV', NULL, NULL),
(32, 'Brazil', 'BR', NULL, NULL),
(33, 'British Indian Ocean Territory', 'IO', NULL, NULL),
(34, 'Brunei Darussalam', 'BN', NULL, NULL),
(35, 'Bulgaria', 'BG', NULL, NULL),
(36, 'Burkina Faso', 'BF', NULL, NULL),
(37, 'Burundi', 'BI', NULL, NULL),
(38, 'Cambodia', 'KH', NULL, NULL),
(39, 'Cameroon', 'CM', NULL, NULL),
(40, 'Canada', 'CA', NULL, NULL),
(41, 'Cape Verde', 'CV', NULL, NULL),
(42, 'Cayman Islands', 'KY', NULL, NULL),
(43, 'Central African Republic', 'CF', NULL, NULL),
(44, 'Chad', 'TD', NULL, NULL),
(45, 'Chile', 'CL', NULL, NULL),
(46, 'China', 'CN', NULL, NULL),
(47, 'Christmas Island', 'CX', NULL, NULL),
(48, 'Cocos (Keeling) Islands', 'CC', NULL, NULL),
(49, 'Colombia', 'CO', NULL, NULL),
(50, 'Comoros', 'KM', NULL, NULL),
(51, 'Congo', 'CG', NULL, NULL),
(52, 'Congo, the Democratic Republic of the', 'CD', NULL, NULL),
(53, 'Cook Islands', 'CK', NULL, NULL),
(54, 'Costa Rica', 'CR', NULL, NULL),
(55, 'Côte d\'Ivoire', 'CI', NULL, NULL),
(56, 'Croatia', 'HR', NULL, NULL),
(57, 'Cuba', 'CU', NULL, NULL),
(58, 'Curaçao', 'CW', NULL, NULL),
(59, 'Cyprus', 'CY', NULL, NULL),
(60, 'Czech Republic', 'CZ', NULL, NULL),
(61, 'Denmark', 'DK', NULL, NULL),
(62, 'Djibouti', 'DJ', NULL, NULL),
(63, 'Dominica', 'DM', NULL, NULL),
(64, 'Dominican Republic', 'DO', NULL, NULL),
(65, 'Ecuador', 'EC', NULL, NULL),
(66, 'Egypt', 'EG', NULL, NULL),
(67, 'El Salvador', 'SV', NULL, NULL),
(68, 'Equatorial Guinea', 'GQ', NULL, NULL),
(69, 'Eritrea', 'ER', NULL, NULL),
(70, 'Estonia', 'EE', NULL, NULL),
(71, 'Ethiopia', 'ET', NULL, NULL),
(72, 'Falkland Islands (Malvinas)', 'FK', NULL, NULL),
(73, 'Faroe Islands', 'FO', NULL, NULL),
(74, 'Fiji', 'FJ', NULL, NULL),
(75, 'Finland', 'FI', NULL, NULL),
(76, 'France', 'FR', NULL, NULL),
(77, 'French Guiana', 'GF', NULL, NULL),
(78, 'French Polynesia', 'PF', NULL, NULL),
(79, 'French Southern Territories', 'TF', NULL, NULL),
(80, 'Gabon', 'GA', NULL, NULL),
(81, 'Gambia', 'GM', NULL, NULL),
(82, 'Georgia', 'GE', NULL, NULL),
(83, 'Germany', 'DE', NULL, NULL),
(84, 'Ghana', 'GH', NULL, NULL),
(85, 'Gibraltar', 'GI', NULL, NULL),
(86, 'Greece', 'GR', NULL, NULL),
(87, 'Greenland', 'GL', NULL, NULL),
(88, 'Grenada', 'GD', NULL, NULL),
(89, 'Guadeloupe', 'GP', NULL, NULL),
(90, 'Guam', 'GU', NULL, NULL),
(91, 'Guatemala', 'GT', NULL, NULL),
(92, 'Guernsey', 'GG', NULL, NULL),
(93, 'Guinea', 'GN', NULL, NULL),
(94, 'Guinea-Bissau', 'GW', NULL, NULL),
(95, 'Guyana', 'GY', NULL, NULL),
(96, 'Haiti', 'HT', NULL, NULL),
(97, 'Heard Island and McDonald Mcdonald Islands', 'HM', NULL, NULL),
(98, 'Holy See (Vatican City State)', 'VA', NULL, NULL),
(99, 'Honduras', 'HN', NULL, NULL),
(100, 'Hong Kong', 'HK', NULL, NULL),
(101, 'Hungary', 'HU', NULL, NULL),
(102, 'Iceland', 'IS', NULL, NULL),
(103, 'India', 'IN', NULL, NULL),
(104, 'Indonesia', 'ID', NULL, NULL),
(105, 'Iran, Islamic Republic of', 'IR', NULL, NULL),
(106, 'Iraq', 'IQ', NULL, NULL),
(107, 'Ireland', 'IE', NULL, NULL),
(108, 'Isle of Man', 'IM', NULL, NULL),
(109, 'Israel', 'IL', NULL, NULL),
(110, 'Italy', 'IT', NULL, NULL),
(111, 'Jamaica', 'JM', NULL, NULL),
(112, 'Japan', 'JP', NULL, NULL),
(113, 'Jersey', 'JE', NULL, NULL),
(114, 'Jordan', 'JO', NULL, NULL),
(115, 'Kazakhstan', 'KZ', NULL, NULL),
(116, 'Kenya', 'KE', NULL, NULL),
(117, 'Kiribati', 'KI', NULL, NULL),
(118, 'Korea, Democratic People\'s Republic of', 'KP', NULL, NULL),
(119, 'Korea, Republic of', 'KR', NULL, NULL),
(120, 'Kuwait', 'KW', NULL, NULL),
(121, 'Kyrgyzstan', 'KG', NULL, NULL),
(122, 'Lao People\'s Democratic Republic', 'LA', NULL, NULL),
(123, 'Latvia', 'LV', NULL, NULL),
(124, 'Lebanon', 'LB', NULL, NULL),
(125, 'Lesotho', 'LS', NULL, NULL),
(126, 'Liberia', 'LR', NULL, NULL),
(127, 'Libya', 'LY', NULL, NULL),
(128, 'Liechtenstein', 'LI', NULL, NULL),
(129, 'Lithuania', 'LT', NULL, NULL),
(130, 'Luxembourg', 'LU', NULL, NULL),
(131, 'Macao', 'MO', NULL, NULL),
(132, 'Macedonia, the Former Yugoslav Republic of', 'MK', NULL, NULL),
(133, 'Madagascar', 'MG', NULL, NULL),
(134, 'Malawi', 'MW', NULL, NULL),
(135, 'Malaysia', 'MY', NULL, NULL),
(136, 'Maldives', 'MV', NULL, NULL),
(137, 'Mali', 'ML', NULL, NULL),
(138, 'Malta', 'MT', NULL, NULL),
(139, 'Marshall Islands', 'MH', NULL, NULL),
(140, 'Martinique', 'MQ', NULL, NULL),
(141, 'Mauritania', 'MR', NULL, NULL),
(142, 'Mauritius', 'MU', NULL, NULL),
(143, 'Mayotte', 'YT', NULL, NULL),
(144, 'Mexico', 'MX', NULL, NULL),
(145, 'Micronesia, Federated States of', 'FM', NULL, NULL),
(146, 'Moldova, Republic of', 'MD', NULL, NULL),
(147, 'Monaco', 'MC', NULL, NULL),
(148, 'Mongolia', 'MN', NULL, NULL),
(149, 'Montenegro', 'ME', NULL, NULL),
(150, 'Montserrat', 'MS', NULL, NULL),
(151, 'Morocco', 'MA', NULL, NULL),
(152, 'Mozambique', 'MZ', NULL, NULL),
(153, 'Myanmar', 'MM', NULL, NULL),
(154, 'Namibia', 'NA', NULL, NULL),
(155, 'Nauru', 'NR', NULL, NULL),
(156, 'Nepal', 'NP', NULL, NULL),
(157, 'Netherlands', 'NL', NULL, NULL),
(158, 'New Caledonia', 'NC', NULL, NULL),
(159, 'New Zealand', 'NZ', NULL, NULL),
(160, 'Nicaragua', 'NI', NULL, NULL),
(161, 'Niger', 'NE', NULL, NULL),
(162, 'Nigeria', 'NG', NULL, NULL),
(163, 'Niue', 'NU', NULL, NULL),
(164, 'Norfolk Island', 'NF', NULL, NULL),
(165, 'Northern Mariana Islands', 'MP', NULL, NULL),
(166, 'Norway', 'NO', NULL, NULL),
(167, 'Oman', 'OM', NULL, NULL),
(168, 'Pakistan', 'PK', NULL, NULL),
(169, 'Palau', 'PW', NULL, NULL),
(170, 'Palestine, State of', 'PS', NULL, NULL),
(171, 'Panama', 'PA', NULL, NULL),
(172, 'Papua New Guinea', 'PG', NULL, NULL),
(173, 'Paraguay', 'PY', NULL, NULL),
(174, 'Peru', 'PE', NULL, NULL),
(175, 'Philippines', 'PH', NULL, NULL),
(176, 'Pitcairn', 'PN', NULL, NULL),
(177, 'Poland', 'PL', NULL, NULL),
(178, 'Portugal', 'PT', NULL, NULL),
(179, 'Puerto Rico', 'PR', NULL, NULL),
(180, 'Qatar', 'QA', NULL, NULL),
(181, 'Réunion', 'RE', NULL, NULL),
(182, 'Romania', 'RO', NULL, NULL),
(183, 'Russian Federation', 'RU', NULL, NULL),
(184, 'Rwanda', 'RW', NULL, NULL),
(185, 'Saint Barthélemy', 'BL', NULL, NULL),
(186, 'Saint Helena, Ascension and Tristan da Cunha', 'SH', NULL, NULL),
(187, 'Saint Kitts and Nevis', 'KN', NULL, NULL),
(188, 'Saint Lucia', 'LC', NULL, NULL),
(189, 'Saint Martin (French part)', 'MF', NULL, NULL),
(190, 'Saint Pierre and Miquelon', 'PM', NULL, NULL),
(191, 'Saint Vincent and the Grenadines', 'VC', NULL, NULL),
(192, 'Samoa', 'WS', NULL, NULL),
(193, 'San Marino', 'SM', NULL, NULL),
(194, 'Sao Tome and Principe', 'ST', NULL, NULL),
(195, 'Saudi Arabia', 'SA', NULL, NULL),
(196, 'Senegal', 'SN', NULL, NULL),
(197, 'Serbia', 'RS', NULL, NULL),
(198, 'Seychelles', 'SC', NULL, NULL),
(199, 'Sierra Leone', 'SL', NULL, NULL),
(200, 'Singapore', 'SG', NULL, NULL),
(201, 'Sint Maarten (Dutch part)', 'SX', NULL, NULL),
(202, 'Slovakia', 'SK', NULL, NULL),
(203, 'Slovenia', 'SI', NULL, NULL),
(204, 'Solomon Islands', 'SB', NULL, NULL),
(205, 'Somalia', 'SO', NULL, NULL),
(206, 'South Africa', 'ZA', NULL, NULL),
(207, 'South Georgia and the South Sandwich Islands', 'GS', NULL, NULL),
(208, 'South Sudan', 'SS', NULL, NULL),
(209, 'Spain', 'ES', NULL, NULL),
(210, 'Sri Lanka', 'LK', NULL, NULL),
(211, 'Sudan', 'SD', NULL, NULL),
(212, 'Suriname', 'SR', NULL, NULL),
(213, 'Svalbard and Jan Mayen', 'SJ', NULL, NULL),
(214, 'Swaziland', 'SZ', NULL, NULL),
(215, 'Sweden', 'SE', NULL, NULL),
(216, 'Switzerland', 'CH', NULL, NULL),
(217, 'Syrian Arab Republic', 'SY', NULL, NULL),
(218, 'Taiwan', 'TW', NULL, NULL),
(219, 'Tajikistan', 'TJ', NULL, NULL),
(220, 'Tanzania, United Republic of', 'TZ', NULL, NULL),
(221, 'Thailand', 'TH', NULL, NULL),
(222, 'Timor-Leste', 'TL', NULL, NULL),
(223, 'Togo', 'TG', NULL, NULL),
(224, 'Tokelau', 'TK', NULL, NULL),
(225, 'Tonga', 'TO', NULL, NULL),
(226, 'Trinidad and Tobago', 'TT', NULL, NULL),
(227, 'Tunisia', 'TN', NULL, NULL),
(228, 'Turkey', 'TR', NULL, NULL),
(229, 'Turkmenistan', 'TM', NULL, NULL),
(230, 'Turks and Caicos Islands', 'TC', NULL, NULL),
(231, 'Tuvalu', 'TV', NULL, NULL),
(232, 'Uganda', 'UG', NULL, NULL),
(233, 'Ukraine', 'UA', NULL, NULL),
(234, 'United Arab Emirates', 'AE', NULL, NULL),
(235, 'United Kingdom', 'GB', NULL, NULL),
(236, 'United States', 'US', NULL, NULL),
(237, 'United States Minor Outlying Islands', 'UM', NULL, NULL),
(238, 'Uruguay', 'UY', NULL, NULL),
(239, 'Uzbekistan', 'UZ', NULL, NULL),
(240, 'Vanuatu', 'VU', NULL, NULL),
(241, 'Venezuela, Bolivarian Republic of', 'VE', NULL, NULL),
(242, 'Viet Nam', 'VN', NULL, NULL),
(243, 'Virgin Islands, British', 'VG', NULL, NULL),
(244, 'Virgin Islands, U.S.', 'VI', NULL, NULL),
(245, 'Wallis and Futuna', 'WF', NULL, NULL),
(246, 'Western Sahara', 'EH', NULL, NULL),
(247, 'Yemen', 'YE', NULL, NULL),
(248, 'Zambia', 'ZM', NULL, NULL),
(249, 'Zimbabwe', 'ZW', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_name` varchar(255) NOT NULL,
  `coupon_offer_type` varchar(255) NOT NULL,
  `coupon_offer_amount` double(8,2) NOT NULL,
  `coupon_minimum_order` double(8,2) NOT NULL,
  `coupon_validity_date` date NOT NULL,
  `coupon_user_limit` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_name`, `coupon_offer_type`, `coupon_offer_amount`, `coupon_minimum_order`, `coupon_validity_date`, `coupon_user_limit`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'bd23', 'flat', 100.00, 500.00, '2023-08-31', 48, 'Yes', 1, NULL, NULL, '2023-02-18 00:20:14', '2023-06-17 04:13:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `default_settings`
--

CREATE TABLE `default_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` varchar(255) DEFAULT NULL,
  `app_url` varchar(255) DEFAULT NULL,
  `time_zone` varchar(255) NOT NULL DEFAULT 'UTC',
  `favicon` varchar(255) DEFAULT NULL,
  `logo_photo` varchar(255) DEFAULT NULL,
  `main_phone` varchar(255) DEFAULT NULL,
  `support_phone` varchar(255) DEFAULT NULL,
  `main_email` varchar(255) DEFAULT NULL,
  `support_email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `google_map_link` text DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `default_settings`
--

INSERT INTO `default_settings` (`id`, `app_name`, `app_url`, `time_zone`, `favicon`, `logo_photo`, `main_phone`, `support_phone`, `main_email`, `support_email`, `address`, `google_map_link`, `facebook_link`, `twitter_link`, `instagram_link`, `linkedin_link`, `youtube_link`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Spy Zone', 'http://127.0.0.1:8000/', 'Asia/Dhaka', 'Favicon.png', 'Logo-Photo.png', '01878136530', '01878136530', 'info@spyzone', 'support@spyzone.com', 'Dhaka, BD', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116834.13673771221!2d90.41928169999998!3d23.780636450000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087026b81%3A0x8fa563bbdd5904c2!2z4Kai4Ka-4KaV4Ka-!5e0!3m2!1sbn!2sbd!4v1677494841456!5m2!1sbn!2sbd\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'spyzone', 'spyzone', 'spyzone', 'spyzone', 'spyzone', 1, 1, '2023-02-18 04:50:05', '2023-05-21 04:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `faq_position` varchar(255) NOT NULL,
  `faq_question` text NOT NULL,
  `faq_answer` longtext NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `faq_position`, `faq_question`, `faq_answer`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Left', 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Yes', 1, NULL, NULL, '2023-02-17 23:20:53', NULL, NULL),
(2, 'Right', 'Why do we use it?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Yes', 1, NULL, NULL, '2023-02-17 23:21:35', NULL, NULL),
(3, 'Left', 'Where does it come from?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Yes', 1, NULL, NULL, '2023-02-17 23:21:52', NULL, NULL),
(4, 'Right', 'Where can I get some?', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'Yes', 1, NULL, NULL, '2023-02-17 23:22:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `feature_title` varchar(255) NOT NULL,
  `feature_subtitle` varchar(255) NOT NULL,
  `feature_photo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `feature_title`, `feature_subtitle`, `feature_photo`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'HOME DELIVERY', 'HOME DELIVERY', 'home-delivery.png', 'Yes', 1, 1, NULL, '2023-02-17 23:17:30', '2023-02-17 23:27:48', NULL),
(2, 'SAFE PAYMENT', 'SAFE PAYMENT', 'easy-return.png', 'Yes', 1, 1, NULL, '2023-02-17 23:18:44', '2023-02-17 23:27:33', NULL),
(3, 'FRIENDLY SERVICES', 'FRIENDLY SERVICES', 'live-chat.png', 'Yes', 1, 1, NULL, '2023-02-17 23:19:29', '2023-02-17 23:27:12', NULL),
(4, '24/7 HELP CENTER', '24/7 HELP CENTER', '247-support.png', 'Yes', 1, 1, NULL, '2023-02-17 23:20:21', '2023-02-17 23:27:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flashsales`
--

CREATE TABLE `flashsales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flashsale_offer_name` varchar(255) NOT NULL,
  `flashsale_offer_slug` varchar(255) NOT NULL,
  `flashsale_offer_type` varchar(255) NOT NULL,
  `flashsale_offer_amount` double(8,2) NOT NULL,
  `flashsale_offer_start_date` datetime NOT NULL,
  `flashsale_offer_end_date` datetime NOT NULL,
  `flashsale_offer_banner_photo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flashsales`
--

INSERT INTO `flashsales` (`id`, `flashsale_offer_name`, `flashsale_offer_slug`, `flashsale_offer_type`, `flashsale_offer_amount`, `flashsale_offer_start_date`, `flashsale_offer_end_date`, `flashsale_offer_banner_photo`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'New Year Offer', 'new-year-offer', 'Flat', 10.00, '2023-02-15 12:21:00', '2023-02-28 12:21:00', 'Offer-Banner-Photo-JqQDE.jpg', 'Yes', 1, NULL, NULL, '2023-02-18 00:21:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_settings`
--

CREATE TABLE `mail_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mailer` varchar(255) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `encryption` varchar(255) DEFAULT NULL,
  `from_address` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mail_settings`
--

INSERT INTO `mail_settings` (`id`, `mailer`, `host`, `port`, `username`, `password`, `encryption`, `from_address`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'smtp', 'sandbox.smtp.mailtrap.io', '2525', '071aa50653a80d', '8dd8b67f9819e0', 'tls', 'info@spyzone.com', 1, 1, '2023-02-18 05:02:38', '2023-05-21 04:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_08_19_092936_create_mail_settings_table', 1),
(6, '2022_08_19_093328_create_default_settings_table', 1),
(7, '2022_08_23_123336_create_categories_table', 1),
(8, '2022_08_23_123449_create_subcategories_table', 1),
(9, '2022_08_23_123605_create_brands_table', 1),
(10, '2022_08_23_123656_create_blogs_table', 1),
(11, '2022_08_23_123747_create_products_table', 1),
(12, '2022_08_28_152900_create_shippings_table', 1),
(13, '2022_08_28_153227_create_sliders_table', 1),
(14, '2022_08_28_153726_create_flashsales_table', 1),
(15, '2022_08_28_154028_create_coupons_table', 1),
(16, '2022_08_28_173858_create_colors_table', 1),
(17, '2022_08_28_174156_create_sizes_table', 1),
(18, '2022_08_29_143227_create_product_featured_photos_table', 1),
(19, '2022_09_07_133057_create_product_inventories_table', 1),
(20, '2022_09_08_152939_create_countries_table', 1),
(21, '2022_09_09_161550_create_subscribers_table', 1),
(22, '2022_09_15_100314_create_features_table', 1),
(23, '2022_09_17_131726_create_faqs_table', 1),
(24, '2022_09_25_145904_create_carts_table', 1),
(25, '2022_09_25_155530_create_wishlists_table', 1),
(26, '2022_09_26_154824_create_banners_table', 1),
(27, '2022_10_07_125913_create_payment_settings_table', 1),
(28, '2022_10_07_132456_create_page_settings_table', 1),
(29, '2022_10_10_170826_create_order_summeries_table', 1),
(30, '2022_10_10_172824_create_order_details_table', 1),
(31, '2022_10_17_114844_create_blog_categories_table', 1),
(32, '2022_10_20_225535_create_blog_comments_table', 1),
(33, '2022_10_20_233847_create_contact_messages_table', 1),
(34, '2022_10_23_111052_create_childcategories_table', 1),
(35, '2022_10_26_173448_create_reviews_table', 1),
(36, '2022_10_31_122330_create_order_returns_table', 1),
(37, '2022_11_09_140243_create_teams_table', 1),
(38, '2022_11_10_054814_create_admins_table', 1),
(39, '2022_12_04_051412_create_visitors_table', 1),
(40, '2022_12_28_055441_create_warehouses_table', 1),
(41, '2022_12_31_164048_create_seo_settings_table', 1),
(42, '2023_01_07_141146_create_social_login_settings_table', 1),
(43, '2023_02_21_165741_create_newsletters_table', 2),
(44, '2023_04_18_112539_create_jobs_table', 3),
(45, '2023_05_23_103244_create_sms_settings_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `received_by` varchar(255) NOT NULL,
  `newsletter_subject` text NOT NULL,
  `newsletter_body` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`id`, `received_by`, `newsletter_subject`, `newsletter_body`, `created_at`, `updated_at`) VALUES
(1, 'All Subscriber', 'Test1 Normal', 'Test1 Normal', '2023-04-18 05:28:42', NULL),
(2, 'All Subscriber', 'Test2 Jobs', 'Test2 Jobs', '2023-04-18 05:46:15', NULL),
(3, 'All Subscriber', 'Test 3', 'Test 3', '2023-04-18 06:04:50', NULL),
(4, 'All Subscriber', 'hfghfgh', 'gfhfghf', '2023-04-18 06:09:17', NULL),
(5, 'All Subscriber', 'Final Test', 'Final Test', '2023-04-18 06:15:58', NULL),
(6, 'All User', 'Send User', 'Send User', '2023-05-22 11:11:47', NULL),
(7, 'All Subscriber', 'Send Subscriber', 'Send Subscriber', '2023-05-22 11:17:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_current_price` double(8,2) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `cart_qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_returns`
--

CREATE TABLE `order_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `order_detail_id` int(11) NOT NULL,
  `return_reason_details` longtext NOT NULL,
  `return_reason_photo` varchar(255) DEFAULT NULL,
  `account_holder_name` varchar(255) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `return_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_summeries`
--

CREATE TABLE `order_summeries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `billing_name` varchar(255) NOT NULL,
  `billing_email` varchar(255) NOT NULL,
  `billing_phone` varchar(255) NOT NULL,
  `country_id` varchar(255) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `billing_address` text NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_email` varchar(255) NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `shipping_country` varchar(255) NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `customer_order_notes` longtext DEFAULT NULL,
  `sub_total` double(8,2) NOT NULL,
  `shipping_charge` double(8,2) NOT NULL,
  `coupon_name` varchar(255) DEFAULT NULL,
  `discount_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `grand_total` double(8,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'Unpaid',
  `transaction_id` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) NOT NULL DEFAULT 'Panding',
  `warehouse_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_settings`
--

CREATE TABLE `page_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_position` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_slug` varchar(255) NOT NULL,
  `page_content` longtext NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_settings`
--

INSERT INTO `page_settings` (`id`, `page_position`, `page_name`, `page_slug`, `page_content`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Conditional', 'conditional', '<p><b>What is Lorem Ipsum?</b> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br></p>', 'Yes', 1, NULL, NULL, '2023-02-17 23:12:33', NULL, NULL),
(2, 2, 'Return Policy', 'return-policy', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br></p>', 'Yes', 1, NULL, NULL, '2023-02-17 23:13:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` varchar(255) DEFAULT NULL,
  `store_password` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `store_id`, `store_password`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'spyit63536b5a2eac1', 'spyit63536b5a2eac1@ssl', 1, 1, '2023-02-18 05:02:56', '2023-05-21 04:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `regular_price` int(11) NOT NULL,
  `discounted_price` int(11) DEFAULT NULL,
  `product_slug` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `sku` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `childcategory_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `flashsale_status` varchar(255) NOT NULL DEFAULT 'No',
  `flashsale_id` int(11) DEFAULT NULL,
  `today_deal_status` varchar(255) NOT NULL DEFAULT 'No',
  `long_description` longtext NOT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `materials` varchar(255) DEFAULT NULL,
  `other_info` text DEFAULT NULL,
  `product_thumbnail_photo` varchar(255) NOT NULL DEFAULT 'default_product_thumbnail_photo.jpg',
  `view_count` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `regular_price`, `discounted_price`, `product_slug`, `short_description`, `sku`, `category_id`, `subcategory_id`, `childcategory_id`, `brand_id`, `flashsale_status`, `flashsale_id`, `today_deal_status`, `long_description`, `weight`, `dimensions`, `materials`, `other_info`, `product_thumbnail_photo`, `view_count`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Stylish Stretchy Skinny Tais Pant For Woman', 800, 750, 'stylish-stretchy-skinny-tais-pant-for-woman-NqP6D60znL', 'Features: Stretchable.. Size: Free Size Country/Region of Manufacture: Bangladesh Material: Cotton 92% Polyester, 8% Spandex YOGA WAISTBAND: Popinjay quality soft brushed leggings have no side seam and are high waisted. The yoga waist band is comfortable and fits snuggly to keep them in place without digging into your skin. This makes wearing them easier than tights and jeans.', 'hAeGktSxTl', 2, 8, 9, 8, 'No', NULL, 'Yes', 'Features: Stretchable.. Size: Free Size Country/Region of Manufacture: Bangladesh Material: Cotton 92% Polyester, 8% Spandex YOGA WAISTBAND: Popinjay quality soft brushed leggings have no side seam and are high waisted. The yoga waist band is comfortable and fits snuggly to keep them in place without digging into your skin. This makes wearing them easier than tights and jeans.', '400G', NULL, NULL, 'Features: Stretchable.. Size: Free Size Country/Region of Manufacture: Bangladesh Material: Cotton 92% Polyester, 8% Spandex YOGA WAISTBAND: Popinjay quality soft brushed leggings have no side seam and are high waisted. The yoga waist band is comfortable and fits snuggly to keep them in place without digging into your skin. This makes wearing them easier than tights and jeans.', '1-Stylish Stretchy Skinny Tais Pant For Woman-Photo.jpg', 9, 'Yes', 1, 1, NULL, '2023-02-18 00:07:37', '2023-06-17 04:01:45', NULL),
(2, 'Dhupiyan Check Saree For Women', 1200, 1120, 'dhupiyan-check-saree-for-women-qkFx4sPwso', 'Product Type: Silk Saree Color: Black & White Main Material:Dhupiyan No extra blouse piece 12 Haat Bohor Brand:UniQue Fashion Sari Style:Regular Sari  Occasion: Casual, Party & Festive Eye catching colors occasion party, festive, wedding wear best gift for your loved ones Product color may slightly vary due to photographic lighting sources or your monitor settings.', 'xfvEXf1Hxd', 2, 8, 8, 2, 'No', NULL, 'No', 'Product Type: Silk Saree Color: Black &amp; White Main Material:Dhupiyan No extra blouse piece 12 Haat Bohor Brand:UniQue Fashion Sari Style:Regular Sari Occasion: Casual, Party &amp; Festive Eye catching colors occasion party, festive, wedding wear best gift for your loved ones Product color may slightly vary due to photographic lighting sources or your monitor settings.', NULL, NULL, NULL, 'Product Type: Silk Saree Color: Black &amp; White Main Material:Dhupiyan No extra blouse piece 12 Haat Bohor Brand:UniQue Fashion Sari Style:Regular Sari Occasion: Casual, Party &amp; Festive Eye catching colors occasion party, festive, wedding wear best gift for your loved ones Product color may slightly vary due to photographic lighting sources or your monitor settings.', '2-Dhupiyan Check Saree For Women-Photo.jpg', 3, 'Yes', 1, 1, NULL, '2023-02-18 00:09:40', '2023-02-27 11:02:56', NULL),
(3, 'Gumboot JCD Waterproof Rain Boots', 1500, 1400, 'gumboot-jcd-waterproof-rain-boots-GcIkqa3xW2', 'Black Upper / Yellow SoleSize Range: 40,41,42,43,44Bata Size: 7,8,9,10,11Slip Resistant SoleTunnel SystemOil/Acid Resistant SoleWide comfortable fittingBroad “Natural” toe designWide soft leg for comfortCushioned Hi-poly comfort insoleKick-off lugComfort moisture-absorbing fabric liningOil acid-resistant industrial sole designOutdoor tread designed for rough terrain and uneven surfacesMulti-directional slip resistanceThicker PVC shank for strength & supportSelf-cleaning treadSuperior liquid dispersion', 'Ukqhw0BsVg', 1, 1, 1, 2, 'No', NULL, 'Yes', 'Black Upper / Yellow SoleSize Range: 40,41,42,43,44Bata Size: 7,8,9,10,11Slip Resistant SoleTunnel SystemOil/Acid Resistant SoleWide comfortable fittingBroad “Natural” toe designWide soft leg for comfortCushioned Hi-poly comfort insoleKick-off lugComfort moisture-absorbing fabric liningOil acid-resistant industrial sole designOutdoor tread designed for rough terrain and uneven surfacesMulti-directional slip resistanceThicker PVC shank for strength & supportSelf-cleaning treadSuperior liquid dispersion', NULL, NULL, NULL, 'Black Upper / Yellow SoleSize Range: 40,41,42,43,44Bata Size: 7,8,9,10,11Slip Resistant SoleTunnel SystemOil/Acid Resistant SoleWide comfortable fittingBroad “Natural” toe designWide soft leg for comfortCushioned Hi-poly comfort insoleKick-off lugComfort moisture-absorbing fabric liningOil acid-resistant industrial sole designOutdoor tread designed for rough terrain and uneven surfacesMulti-directional slip resistanceThicker PVC shank for strength & supportSelf-cleaning treadSuperior liquid dispersion', '3-Gumboot JCD Waterproof Rain Boots-Photo.jpg', 2, 'Yes', 1, 1, NULL, '2023-02-18 00:10:53', '2023-02-27 11:03:34', NULL),
(4, 'HP ProBook 450 G4', 60000, 58000, 'hp-probook-450-g4-4XBmC2G8Ul', '2K Full Vision Display Stereo Surround Sound By DTS PC Connect Seamless multi-screen collaboration Dual-Fan Storm Cooling System 14.9 Super Slim Design Memory: 8GB Dual channel LPDDR4x RAM 512 SSD Storage 11 Hours Battery Life 3-Mode Backlit Keyboard Length: 307.21 mm Width: 228.96 mm Height: 14.9 mm (thickest point: 15.5mm) Weight: Approx. 1.38 kg Size: 14 inches Type: IPS Screen-to-body Ratio: 90% Aspect Ratio: 3:2 Resolution: 2160 ÃÂ 1440 11th Gen IntelCorei5-1135G7 Processor Quad-core Octa-thread Dual-core quad-thread IntelIrisXÃÂ¡ÃÂµÃÂ Graphicsi5 Version i5 Version: IEEE802.11 a/b/g/n/Wi-Fi 5/WI-FI 6 i5 Version: Bluetooth 5.2 Windows 10 Home Pre-installed i5 Version: Thunderbolt 4/ USB 4 (Data: Max.40 Gbps)USB-C 3.2 Gen 2USB-A 3.1 Gen 1 3.5mm Headphone and Microphone Jack', 'l1rQuZc9bO', 3, 6, 3, 6, 'No', NULL, 'No', '2K Full Vision Display Stereo Surround Sound By DTS PC Connect Seamless multi-screen collaboration Dual-Fan Storm Cooling System 14.9 Super Slim Design Memory: 8GB Dual channel LPDDR4x RAM 512 SSD Storage 11 Hours Battery Life 3-Mode Backlit Keyboard Length: 307.21 mm Width: 228.96 mm Height: 14.9 mm (thickest point: 15.5mm) Weight: Approx. 1.38 kg Size: 14 inches Type: IPS Screen-to-body Ratio: 90% Aspect Ratio: 3:2 Resolution: 2160 ÃÂ 1440 11th Gen IntelCorei5-1135G7 Processor Quad-core Octa-thread Dual-core quad-thread IntelIrisXÃÂ¡ÃÂµÃÂ Graphicsi5 Version i5 Version: IEEE802.11 a/b/g/n/Wi-Fi 5/WI-FI 6 i5 Version: Bluetooth 5.2 Windows 10 Home Pre-installed i5 Version: Thunderbolt 4/ USB 4 (Data: Max.40 Gbps)USB-C 3.2 Gen 2USB-A 3.1 Gen 1 3.5mm Headphone and Microphone Jack', NULL, NULL, NULL, '2K Full Vision Display Stereo Surround Sound By DTS PC Connect Seamless multi-screen collaboration Dual-Fan Storm Cooling System 14.9 Super Slim Design Memory: 8GB Dual channel LPDDR4x RAM 512 SSD Storage 11 Hours Battery Life 3-Mode Backlit Keyboard Length: 307.21 mm Width: 228.96 mm Height: 14.9 mm (thickest point: 15.5mm) Weight: Approx. 1.38 kg Size: 14 inches Type: IPS Screen-to-body Ratio: 90% Aspect Ratio: 3:2 Resolution: 2160 ÃÂ 1440 11th Gen IntelCorei5-1135G7 Processor Quad-core Octa-thread Dual-core quad-thread IntelIrisXÃÂ¡ÃÂµÃÂ Graphicsi5 Version i5 Version: IEEE802.11 a/b/g/n/Wi-Fi 5/WI-FI 6 i5 Version: Bluetooth 5.2 Windows 10 Home Pre-installed i5 Version: Thunderbolt 4/ USB 4 (Data: Max.40 Gbps)USB-C 3.2 Gen 2USB-A 3.1 Gen 1 3.5mm Headphone and Microphone Jack', '4-HP ProBook 450 G4-Photo.jpg', 5, 'Yes', 1, 1, NULL, '2023-02-18 00:12:06', '2023-02-27 11:03:38', NULL),
(5, 'Classic Dry Iron', 1800, 1700, 'classic-dry-iron-GTGT79Od2E', '1-Year International Seller Warranty Pointed tip for ironing tricky areas Linished soleplate for easy gliding on your clothes Button groove speeds up ironing along with buttons and seams Iron temperature-ready light Easy temperature control Slim tip soleplate reaches easily in tricky areas Cord winder for easy cord storage Long-lasting cord for extended lifetime Temperature light indicates when the iron is hot enough Tested design for maximum durability Fast and efficient-guaranteed', 'miyMB1RoNy', 4, 7, 4, 5, 'No', NULL, 'Yes', '1-Year International Seller Warranty Pointed tip for ironing tricky areas Linished soleplate for easy gliding on your clothes Button groove speeds up ironing along with buttons and seams Iron temperature-ready light Easy temperature control Slim tip soleplate reaches easily in tricky areas Cord winder for easy cord storage Long-lasting cord for extended lifetime Temperature light indicates when the iron is hot enough Tested design for maximum durability Fast and efficient-guaranteed', NULL, NULL, NULL, '1-Year International Seller Warranty Pointed tip for ironing tricky areas Linished soleplate for easy gliding on your clothes Button groove speeds up ironing along with buttons and seams Iron temperature-ready light Easy temperature control Slim tip soleplate reaches easily in tricky areas Cord winder for easy cord storage Long-lasting cord for extended lifetime Temperature light indicates when the iron is hot enough Tested design for maximum durability Fast and efficient-guaranteed', '5-Classic Dry Iron-Photo.jpg', 3, 'Yes', 1, 1, NULL, '2023-02-18 00:12:06', '2023-05-21 04:13:22', NULL),
(6, 'ELECTRIC WATER KETTLE', 1200, 1100, 'electric-water-kettle-8B9LPbRu0v', 'Item code: 823455  Model: VIS-EK-008  Capacity: 1.5L  Power: 1500w, 220v, 50hz  360° rotatable cordless electric kettle  Stainless steel body with concealed heating element  Automatically turn off when water boils  Boil-dry and overheat protection  Triple safety protection  Safety lock lid  Illuminated on-off switch', '56ECyvWMHQ', 4, 7, 10, 5, 'No', NULL, 'No', 'Item code: 823455  Model: VIS-EK-008  Capacity: 1.5L  Power: 1500w, 220v, 50hz  360° rotatable cordless electric kettle  Stainless steel body with concealed heating element  Automatically turn off when water boils  Boil-dry and overheat protection  Triple safety protection  Safety lock lid  Illuminated on-off switch', NULL, NULL, NULL, 'Item code: 823455  Model: VIS-EK-008  Capacity: 1.5L  Power: 1500w, 220v, 50hz  360° rotatable cordless electric kettle  Stainless steel body with concealed heating element  Automatically turn off when water boils  Boil-dry and overheat protection  Triple safety protection  Safety lock lid  Illuminated on-off switch', '6-ELECTRIC WATER KETTLE-Photo.jpg', 2, 'Yes', 1, 1, NULL, '2023-02-18 00:14:52', '2023-05-21 04:14:16', NULL),
(7, 'Keyboard Standard English with Bangla', 600, 550, 'keyboard-standard-english-with-bangla-7za7kBWoLB', 'Model: WKS013WN Type: Standard Wired Keyboard Dimension: (L) 435mm (W) 129mm (H) 22.6mm Weight: 345g Character: Silk Screen Cable: 1.5m PVC Cable Keys: 104 Operating Voltage: 5V', '2nVMdjnCxT', 3, 3, 2, 3, 'No', NULL, 'Yes', 'Model: WKS013WN Type: Standard Wired Keyboard Dimension: (L) 435mm (W) 129mm (H) 22.6mm Weight: 345g Character: Silk Screen Cable: 1.5m PVC Cable Keys: 104 Operating Voltage: 5V', NULL, NULL, NULL, 'Model: WKS013WN Type: Standard Wired Keyboard Dimension: (L) 435mm (W) 129mm (H) 22.6mm Weight: 345g Character: Silk Screen Cable: 1.5m PVC Cable Keys: 104 Operating Voltage: 5V', '7-Keyboard Standard English with Bangla-Photo.jpg', 2, 'Yes', 1, 1, NULL, '2023-02-18 00:15:39', '2023-02-27 06:09:47', NULL),
(8, 'Wireless Mouse Speedy Lite 2.4G', 500, 480, 'wireless-mouse-speedy-lite-24g-YN4OLQFFf6', 'Interface type: 2.4G Transmission distance: 8-10M Button: 3D DPI: 1000dpi resolution', 'SiZbgCmykz', 3, 3, 7, 6, 'No', NULL, 'No', 'Interface type: 2.4G Transmission distance: 8-10M Button: 3D DPI: 1000dpi resolution', NULL, NULL, NULL, 'Interface type: 2.4G Transmission distance: 8-10M Button: 3D DPI: 1000dpi resolution', '8-Wireless Mouse Speedy Lite 2.4G-Photo.jpg', 0, 'Yes', 1, 1, NULL, '2023-02-18 00:16:27', '2023-02-27 06:11:01', NULL),
(9, 'Heart Wave Long Chain Necklace', 60000, 58000, 'heart-wave-long-chain-necklace-RVCuuIytkU', 'Fine or Fashion:Fashion Item Type:Necklaces Style:Trendy Shape\\\\pattern:Geometric Pendant Size:none Necklace Type:Chokers Necklaces Chain Type:Link Chain Model Number:M178-M179 Metals Type:Zinc Alloy Material:Metal Gender:Women Compatibility:none Function:none Material:Zinc Alloy Length:45+5cm Material:Alloy', 't0UudonZpG', 2, 2, 5, 2, 'No', NULL, 'Yes', 'Fine or Fashion:Fashion Item Type:Necklaces Style:Trendy Shape\\\\pattern:Geometric Pendant Size:none Necklace Type:Chokers Necklaces Chain Type:Link Chain Model Number:M178-M179 Metals Type:Zinc Alloy Material:Metal Gender:Women Compatibility:none Function:none Material:Zinc Alloy Length:45+5cm Material:Alloy', NULL, NULL, 'Gold', NULL, '9-Heart Wave Long Chain Necklace-Photo.jpg', 1, 'Yes', 1, 1, NULL, '2023-02-18 00:17:34', '2023-02-27 10:07:59', NULL),
(10, 'Dust free Car', 600000, 580000, 'dust-free-car-Doro5f2326', 'Advance dust free cover series. Water-repellent treated fabric. Durable double-stitched construction. Reinforced antenna patch. Theft-deterrent trunk lock strap. Snug fit elastic hem surrounds the entire vehicle. Adjustable front tie-down strap for a more secure fit. Flexible yet snug fit with elasticized bottom. Defend your vehicle\\\'s paint job with the reliable, durable Car Cover. Outdoor protection for light to moderate weather conditions. UV-Treated to prevent sun fade. Universal Fit.Adjust.able front tie-down strap for a more secure fit', 'MYO3GF4neO', 6, 4, 6, 1, 'No', NULL, 'No', 'Advance dust free cover series. Water-repellent treated fabric. Durable double-stitched construction. Reinforced antenna patch. Theft-deterrent trunk lock strap. Snug fit elastic hem surrounds the entire vehicle. Adjustable front tie-down strap for a more secure fit. Flexible yet snug fit with elasticized bottom. Defend your vehicle\\\'s paint job with the reliable, durable Car Cover. Outdoor protection for light to moderate weather conditions. UV-Treated to prevent sun fade. Universal Fit.Adjust.able front tie-down strap for a more secure fit', NULL, NULL, NULL, 'Advance dust free cover series. Water-repellent treated fabric. Durable double-stitched construction. Reinforced antenna patch. Theft-deterrent trunk lock strap. Snug fit elastic hem surrounds the entire vehicle. Adjustable front tie-down strap for a more secure fit. Flexible yet snug fit with elasticized bottom. Defend your vehicle\\\'s paint job with the reliable, durable Car Cover. Outdoor protection for light to moderate weather conditions. UV-Treated to prevent sun fade. Universal Fit.Adjust.able front tie-down strap for a more secure fit', '10-Dust free Car-Photo.jpg', 1, 'Yes', 1, 1, NULL, '2023-02-18 00:18:28', '2023-02-27 10:08:05', NULL),
(11, '125cc Motor Cycle', 180000, 175000, '125cc-motor-cycle-qVk4zYDgnp', 'Type: single cylinder , 4 stroke, air cooled spark ignition engine Cylinder: 57 mm Stroke: 48.8 mm Piston displacement: 124.5 cc Compression Carburetor: UCAL UCD 25 Air filter: Paper filter element Lubrication system: Positive lubrication Maximum power in kW: 8.0 (11 BHP) @ 8000 rpm Maximum torque in Nm: 10.8 NM @ 5500 rpm Maximum speed: Around 100 km/hr Engine idling rpm: 1400 ± 100 rpm (under warm condition) Starting system: Kick starter /Electric starter', 'c01Iyu78Kr', 6, 5, 11, 4, 'No', NULL, 'No', 'Type: single cylinder , 4 stroke, air cooled spark ignition engine Cylinder: 57 mm Stroke: 48.8 mm Piston displacement: 124.5 cc Compression Carburetor: UCAL UCD 25 Air filter: Paper filter element Lubrication system: Positive lubrication Maximum power in kW: 8.0 (11 BHP) @ 8000 rpm Maximum torque in Nm: 10.8 NM @ 5500 rpm Maximum speed: Around 100 km/hr Engine idling rpm: 1400 ± 100 rpm (under warm condition) Starting system: Kick starter /Electric starter', NULL, NULL, NULL, 'Type: single cylinder , 4 stroke, air cooled spark ignition engine Cylinder: 57 mm Stroke: 48.8 mm Piston displacement: 124.5 cc Compression Carburetor: UCAL UCD 25 Air filter: Paper filter element Lubrication system: Positive lubrication Maximum power in kW: 8.0 (11 BHP) @ 8000 rpm Maximum torque in Nm: 10.8 NM @ 5500 rpm Maximum speed: Around 100 km/hr Engine idling rpm: 1400 ± 100 rpm (under warm condition) Starting system: Kick starter /Electric starter', '11-125cc Motor Cycle-Photo.jpg', 1, 'Yes', 1, 1, NULL, '2023-02-18 00:19:26', '2023-02-27 10:55:03', NULL),
(12, 'Mi G3 Laptop', 50000, 50000, 'mi-g3-laptop-yhHZN9jJAH', '2K Full Vision Display Stereo Surround Sound By DTS PC Connect Seamless multi-screen collaboration Dual-Fan Storm Cooling System  14.9 Super Slim Design Memory: 8GB Dual channel LPDDR4x RAM 512 SSD Storage 11 Hours Battery Life', 'aVOOJVaotU', 3, 6, 3, 5, 'No', NULL, 'No', '2K Full Vision Display Stereo Surround Sound By DTS PC Connect Seamless multi-screen collaboration Dual-Fan Storm Cooling System&nbsp; 14.9 Super Slim Design Memory: 8GB Dual channel LPDDR4x RAM 512 SSD Storage 11 Hours Battery Life', '2Kg', NULL, 'Steel', NULL, 'default_product_thumbnail_photo.jpg', 1, 'Yes', 1, NULL, NULL, '2023-02-27 06:03:36', '2023-02-27 06:03:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_featured_photos`
--

CREATE TABLE `product_featured_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_featured_photos` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_featured_photos`
--

INSERT INTO `product_featured_photos` (`id`, `product_id`, `product_featured_photos`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 11, '11-Product-Featured-Photo-Y8Sfu.jpg', 1, NULL, NULL, '2023-02-20 08:32:30', NULL, NULL),
(2, 11, '11-Product-Featured-Photo-RALiq.jpg', 1, NULL, NULL, '2023-02-20 08:32:31', NULL, NULL),
(3, 11, '11-Product-Featured-Photo-g8rUN.jpg', 1, NULL, NULL, '2023-02-20 08:32:31', NULL, NULL),
(4, 1, '1-Product-Featured-Photo-X7NXK.jpg', 1, NULL, NULL, '2023-02-20 08:33:38', NULL, NULL),
(5, 1, '1-Product-Featured-Photo-GONBH.jpg', 1, NULL, NULL, '2023-02-20 08:34:02', NULL, NULL),
(6, 2, '2-Product-Featured-Photo-jfUQ1.jpg', 1, NULL, NULL, '2023-02-20 08:34:35', NULL, NULL),
(7, 2, '2-Product-Featured-Photo-QF9q2.jpg', 1, NULL, NULL, '2023-02-20 08:34:35', NULL, NULL),
(8, 3, '3-Product-Featured-Photo-5OEti.jpg', 1, NULL, NULL, '2023-02-20 08:35:32', NULL, NULL),
(9, 3, '3-Product-Featured-Photo-5vb0M.jpg', 1, NULL, NULL, '2023-02-20 08:35:32', NULL, NULL),
(10, 3, '3-Product-Featured-Photo-2NeZu.jpg', 1, NULL, NULL, '2023-02-20 08:35:32', NULL, NULL),
(11, 4, '4-Product-Featured-Photo-vA98s.jpg', 1, NULL, NULL, '2023-02-20 08:36:36', NULL, NULL),
(12, 4, '4-Product-Featured-Photo-N6vJZ.jpg', 1, NULL, NULL, '2023-02-20 08:36:36', NULL, NULL),
(13, 4, '4-Product-Featured-Photo-f7Xlw.jpg', 1, NULL, NULL, '2023-02-20 08:36:36', NULL, NULL),
(14, 5, '5-Product-Featured-Photo-zHFay.jpg', 1, NULL, NULL, '2023-02-20 08:38:11', NULL, NULL),
(15, 5, '5-Product-Featured-Photo-RhCFw.jpg', 1, NULL, NULL, '2023-02-20 08:38:12', NULL, NULL),
(16, 7, '7-Product-Featured-Photo-SBcq2.jpg', 1, NULL, NULL, '2023-02-20 08:39:27', NULL, NULL),
(17, 7, '7-Product-Featured-Photo-ZN5a6.jpg', 1, NULL, NULL, '2023-02-20 08:39:27', NULL, NULL),
(18, 7, '7-Product-Featured-Photo-EXiJQ.jpg', 1, NULL, NULL, '2023-02-20 08:39:27', NULL, NULL),
(19, 10, '10-Product-Featured-Photo-US5Yw.jpg', 1, NULL, NULL, '2023-02-20 08:40:27', NULL, NULL),
(20, 10, '10-Product-Featured-Photo-fpkFo.jpg', 1, NULL, NULL, '2023-02-20 08:40:27', NULL, NULL),
(21, 10, '10-Product-Featured-Photo-FdSH6.jpg', 1, NULL, NULL, '2023-02-20 08:40:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_inventories`
--

CREATE TABLE `product_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_inventories`
--

INSERT INTO `product_inventories` (`id`, `product_id`, `color_id`, `size_id`, `quantity`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 2, 29, 1, NULL, NULL, '2023-02-20 08:29:26', '2023-02-20 08:51:02', NULL),
(2, 1, 3, 5, 798, 1, NULL, NULL, '2023-02-20 08:29:39', '2023-06-17 04:02:26', NULL),
(3, 2, 5, 5, 199, 1, NULL, NULL, '2023-02-20 08:29:57', '2023-02-27 10:13:32', NULL),
(4, 3, 2, 1, 399, 1, NULL, NULL, '2023-02-20 08:30:09', '2023-06-17 05:02:20', NULL),
(5, 4, 6, 8, 211, 1, NULL, NULL, '2023-02-20 08:30:29', '2023-02-27 10:15:10', NULL),
(6, 5, 7, 1, 198, 1, NULL, NULL, '2023-02-20 08:30:40', '2023-06-17 04:13:17', NULL),
(7, 6, 1, 3, 800, 1, NULL, NULL, '2023-02-20 08:30:55', NULL, NULL),
(8, 7, 2, 1, 300, 1, NULL, NULL, '2023-02-20 08:31:15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_detail_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review` longtext NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `order_detail_id`, `product_id`, `color_id`, `size_id`, `user_id`, `review`, `rating`, `created_at`, `updated_at`) VALUES
(1, 5, 4, 6, 8, 1, 'Good Laptop', 5, '2023-02-27 10:16:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seo_settings`
--

CREATE TABLE `seo_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `seo_image` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo_settings`
--

INSERT INTO `seo_settings` (`id`, `title`, `keywords`, `description`, `seo_image`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Ecommerce Website', 'Ecommerce, Market, Online Market', 'Ecommerce Website', 'Seo-Image.jpg', 1, 1, '2023-02-18 05:03:09', '2023-02-18 00:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) NOT NULL,
  `city_name` text NOT NULL,
  `shipping_charge` double(8,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shippings`
--

INSERT INTO `shippings` (`id`, `country_id`, `city_name`, `shipping_charge`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 19, 'Dhaka', 50.00, 'Yes', 1, NULL, NULL, '2023-02-18 00:22:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'N/A', 'Yes', 1, NULL, NULL, '2023-02-18 00:03:08', NULL, NULL),
(2, 'L', 'Yes', 1, NULL, NULL, '2023-02-18 00:03:15', NULL, NULL),
(3, '5L', 'Yes', 1, NULL, NULL, '2023-02-18 00:03:23', NULL, NULL),
(4, '5KG', 'Yes', 1, NULL, NULL, '2023-02-18 00:03:28', NULL, NULL),
(5, 'XL', 'Yes', 1, NULL, NULL, '2023-02-18 00:03:37', NULL, NULL),
(6, '4GB-64GB', 'Yes', 1, NULL, NULL, '2023-02-18 00:03:43', NULL, NULL),
(7, '6GB-128GB', 'Yes', 1, NULL, NULL, '2023-02-18 00:03:52', NULL, NULL),
(8, '8GB-512GB SSD', 'Yes', 1, NULL, NULL, '2023-02-18 00:03:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slider_title` varchar(255) NOT NULL,
  `slider_subtitle` varchar(255) NOT NULL,
  `slider_link` varchar(255) NOT NULL,
  `slider_photo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `slider_title`, `slider_subtitle`, `slider_link`, `slider_photo`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '14 February', 'Year End Offer', 'new-year-offer', 'Slider-Photo-UYP4t.jpg', 'Yes', 1, NULL, NULL, '2023-02-18 00:23:59', NULL, NULL),
(2, '14 February', 'Year End Offer', 'new-year-offer', 'Slider-Photo-aHsFU.jpg', 'Yes', 1, NULL, NULL, '2023-02-18 00:24:18', NULL, NULL),
(3, '14 February', 'Year End Offer', 'new-year-offer', 'Slider-Photo-Pv17H.jpg', 'Yes', 1, NULL, NULL, '2023-02-18 00:24:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms_settings`
--

CREATE TABLE `sms_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_key` text NOT NULL,
  `sender_id` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_settings`
--

INSERT INTO `sms_settings` (`id`, `api_key`, `sender_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'VjkIEblFGYFP7yH5NyOk', '8809601004416', 1, 1, '2023-05-23 04:58:28', '2023-05-23 05:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `social_login_settings`
--

CREATE TABLE `social_login_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `google_auth_status` varchar(255) NOT NULL DEFAULT 'No',
  `google_client_id` varchar(255) DEFAULT NULL,
  `google_client_secret` varchar(255) DEFAULT NULL,
  `facebook_auth_status` varchar(255) NOT NULL DEFAULT 'No',
  `facebook_client_id` varchar(255) DEFAULT NULL,
  `facebook_client_secret` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_login_settings`
--

INSERT INTO `social_login_settings` (`id`, `google_auth_status`, `google_client_id`, `google_client_secret`, `facebook_auth_status`, `facebook_client_id`, `facebook_client_secret`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'No', '94152419762-kot722ibqmsiodh3l38dajmut3e2ot5o.apps.googleusercontent.com', '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', 'No', '3531091607174199', '4e3359ed937b50ac9598f8b0fdd001d5', 1, 1, '2023-02-18 05:03:21', '2023-02-17 23:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `subcategory_slug` varchar(255) NOT NULL,
  `subcategory_photo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `subcategory_name`, `subcategory_slug`, `subcategory_photo`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Shoes', 'shoes', 'shoes-subcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:53:37', NULL, NULL),
(2, 2, 'Julery', 'julery', 'julery-subcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:53:55', NULL, NULL),
(3, 3, 'Computer Accessories', 'computer-accessories', 'computer-accessories-subcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:54:15', NULL, NULL),
(4, 6, 'Car', 'car', 'car-subcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:54:27', NULL, NULL),
(5, 6, 'Motorcycle', 'motorcycle', 'motorcycle-subcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:54:38', NULL, NULL),
(6, 3, 'Laptop', 'laptop', 'laptop-subcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:54:52', NULL, NULL),
(7, 4, 'Heating', 'heating', 'heating-subcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:55:09', NULL, NULL),
(8, 2, 'Cloth', 'cloth', 'cloth-subcategory-photo.jpg', 'Yes', 1, NULL, NULL, '2023-02-17 23:58:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscriber_email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `subscriber_email`, `status`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'sabbir4@gmail.com', 'Yes', NULL, NULL, '2023-04-18 05:19:51', NULL, NULL),
(5, 'sabbir5@gmail.com', 'Yes', NULL, NULL, '2023-04-18 05:19:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_member_name` varchar(255) NOT NULL,
  `team_member_designation` varchar(255) NOT NULL,
  `team_member_photo` varchar(255) NOT NULL DEFAULT 'default_profile_photo.png',
  `team_member_facebook_link` varchar(255) NOT NULL,
  `team_member_twitter_link` varchar(255) NOT NULL,
  `team_member_instagram_link` varchar(255) NOT NULL,
  `team_member_linkedin_link` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `team_member_name`, `team_member_designation`, `team_member_photo`, `team_member_facebook_link`, `team_member_twitter_link`, `team_member_instagram_link`, `team_member_linkedin_link`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sabbir Ahammed', 'Manager', 'Team-Member-Photo-q4IQO.png', 'sabbir', 'sabbir', 'sabbir', 'sabbir', 'Yes', 1, NULL, NULL, '2023-02-17 23:24:09', NULL, NULL),
(2, 'Queen', 'Manager', 'Team-Member-Photo-d6ldf.png', 'queen', 'queen', 'queen', 'queen', 'Yes', 1, NULL, NULL, '2023-02-17 23:24:44', NULL, NULL),
(3, 'Shovon', 'shovon', 'Team-Member-Photo-xfwSZ.png', 'shovon', 'shovon', 'shovon', 'shovon', 'Yes', 1, NULL, NULL, '2023-02-17 23:25:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_photo` varchar(255) NOT NULL DEFAULT 'default_profile_photo.png',
  `last_active` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `google_id`, `facebook_id`, `name`, `email`, `phone_number`, `gender`, `date_of_birth`, `address`, `profile_photo`, `last_active`, `password`, `status`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Customer 1', 'customer1@email.com', NULL, NULL, NULL, NULL, 'default_profile_photo.png', '2023-06-17 05:16:17', '$2y$10$QRy53lLpdvPEQgAPED.8JuEt.9ytjmcmtjJGi9k/dOxxgl/4arfDW', 'Yes', '2023-06-17 04:00:23', 'q0nPnoWMSQTUPRDg3uULHKvVu4QaWSgq4etTThuoWrHvIQZuo6UKzOtQU2ch', '2023-06-17 05:18:37', '2023-06-17 05:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `visit_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_name` varchar(255) NOT NULL,
  `warehouse_email` varchar(255) NOT NULL,
  `warehouse_phone_number` varchar(255) DEFAULT NULL,
  `warehouse_address` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Yes',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `warehouse_name`, `warehouse_email`, `warehouse_phone_number`, `warehouse_address`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dhaka Warehouse', 'dhakawarehouse @gmail.com', '01878136530', 'Dhaka, BD', 'Yes', 1, NULL, NULL, '2023-02-17 23:26:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `childcategories`
--
ALTER TABLE `childcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_coupon_name_unique` (`coupon_name`);

--
-- Indexes for table `default_settings`
--
ALTER TABLE `default_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flashsales`
--
ALTER TABLE `flashsales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `mail_settings`
--
ALTER TABLE `mail_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_returns`
--
ALTER TABLE `order_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_summeries`
--
ALTER TABLE `order_summeries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_settings`
--
ALTER TABLE `page_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_product_slug_unique` (`product_slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`);

--
-- Indexes for table `product_featured_photos`
--
ALTER TABLE `product_featured_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_inventories`
--
ALTER TABLE `product_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo_settings`
--
ALTER TABLE `seo_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_settings`
--
ALTER TABLE `sms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_login_settings`
--
ALTER TABLE `social_login_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_subscriber_email_unique` (`subscriber_email`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `warehouses_warehouse_email_unique` (`warehouse_email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `childcategories`
--
ALTER TABLE `childcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `default_settings`
--
ALTER TABLE `default_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `flashsales`
--
ALTER TABLE `flashsales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mail_settings`
--
ALTER TABLE `mail_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_returns`
--
ALTER TABLE `order_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_summeries`
--
ALTER TABLE `order_summeries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_settings`
--
ALTER TABLE `page_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_featured_photos`
--
ALTER TABLE `product_featured_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_inventories`
--
ALTER TABLE `product_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seo_settings`
--
ALTER TABLE `seo_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_settings`
--
ALTER TABLE `sms_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_login_settings`
--
ALTER TABLE `social_login_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

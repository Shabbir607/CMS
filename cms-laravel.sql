-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2024 at 02:13 PM
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
-- Database: `cms-laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `image_name` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `phone`, `image`, `image_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin Update', 'admin@gmail.com', '$2y$12$ICx20luNNTcHxvofvxjgh..pXXOoF5ZWxsWH7y3EIUY7/xyaULC92', '03056702559', 'http://127.0.0.1:8000/upload/profile/profile_659558e4e5a71.png', 'profile_659558e4e5a71.png', NULL, '2024-01-04 05:56:43'),
(2, 'Admin2', 'admin2@gmail.com', '$2y$12$a8zll5EDqPNxbWW./RDJRuxp7tnZn7/IhIQFwEoLRrRW4h6WhMJeK', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_receipts`
--

CREATE TABLE `customer_receipts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `customer` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `pay_mode` varchar(255) NOT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `narration` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `no` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_receipts`
--

INSERT INTO `customer_receipts` (`id`, `receipt_no`, `customer`, `date`, `amount`, `pay_mode`, `reference_no`, `narration`, `file_path`, `file_name`, `no`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(2, 'CRec-00001', 7, '2023-12-27', 2000, 'cash', NULL, 'ksjbdajhs', '1', 'cust_receipt_658c18bb76c20.png', 'CRec-946389', 1, 0, '2023-12-27 07:29:47', '2023-12-27 07:29:47'),
(3, 'CRec-00002', 7, '2023-12-09', 2000, 'cash', NULL, 'ksjbdajhs', 'http://127.0.0.1:8000/upload/customer/cust_receipt_658c19140e268.png', 'cust_receipt_658c19140e268.png', 'CRec-295109', 1, 0, '2023-12-27 07:31:16', '2023-12-27 07:31:16'),
(4, 'CRec-00003', 7, '2023-12-27', 2000, 'cash', NULL, 'ksjbdajhs', 'http://127.0.0.1:8000/upload/customer/cust_receipt_658c19d034c1d.png', 'cust_receipt_658c19d034c1d.png', 'CRec-365219', 1, 0, '2023-12-27 07:34:24', '2023-12-27 07:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `customer_receipt_products`
--

CREATE TABLE `customer_receipt_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receipt_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `pay` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exp` varchar(255) NOT NULL,
  `supplier` bigint(20) UNSIGNED NOT NULL,
  `pay_mode` varchar(255) NOT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `narration` text NOT NULL,
  `total_amount` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `exp_no` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `exp`, `supplier`, `pay_mode`, `reference_no`, `date`, `narration`, `total_amount`, `file_path`, `file_name`, `exp_no`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 'Exp-000001', 1, 'cash', NULL, '2023-12-19', 'kjsdkjdbf', 5000, 'http://127.0.0.1:8000/upload/expensesexpenses_658172148ddd8.jpg', 'expenses_658172148ddd8.jpg', 'exp-321590', 2, '2023-12-19 05:36:04', '2023-12-19 05:36:04'),
(6, 'Exp-000002', 1, 'cash', NULL, '2023-12-09', 'kjsdkjdbf', 5000, 'http://127.0.0.1:8000/upload/expenses/expenses_658172bce2c47.jpg', 'expenses_658172bce2c47.jpg', 'exp-391267', 2, '2023-12-19 05:38:52', '2023-12-19 05:38:52'),
(11, 'Exp-000003', 1, 'cash', 'kasndkjasndkjbaskdj', '2023-12-19', 'kjsdkjdbf', 5000, 'http://127.0.0.1:8000/upload/expenses/expenses_6581738366002.jpg', 'expenses_6581738366002.jpg', 'exp-555498', 2, '2023-12-19 05:42:11', '2023-12-19 05:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `expenses_account`
--

CREATE TABLE `expenses_account` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses_account`
--

INSERT INTO `expenses_account` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Annual Charges', 2, '2023-12-18 05:12:57', '2023-12-18 06:33:17'),
(2, 'Annual Charges1', 1, '2023-12-18 05:13:17', '2023-12-18 06:01:01'),
(3, 'Annual Charges', 1, '2023-12-18 05:13:17', '2023-12-18 06:01:24'),
(4, 'shipping charges', 1, '2023-12-18 05:12:57', '2023-12-18 05:12:57'),
(7, 'Akhtar', 2, '2023-12-18 07:12:18', '2023-12-18 07:12:18'),
(8, 'Akhtar', 1, '2023-12-18 07:12:18', '2023-12-18 07:12:18');

-- --------------------------------------------------------

--
-- Table structure for table `expenses_detail`
--

CREATE TABLE `expenses_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expenses_id` bigint(20) UNSIGNED NOT NULL,
  `expenses_account` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `amount` int(11) NOT NULL,
  `location` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses_detail`
--

INSERT INTO `expenses_detail` (`id`, `expenses_id`, `expenses_account`, `description`, `amount`, `location`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '25', 300, 2, '2023-12-19 05:36:04', '2023-12-19 05:36:04'),
(2, 3, 3, '25', 300, 2, '2023-12-19 05:36:04', '2023-12-19 05:36:04'),
(5, 6, 1, 'jhsfgj', 300, 2, '2023-12-19 05:38:52', '2023-12-19 05:38:52'),
(6, 6, 3, 'jkasdbjhsa', 300, 1, '2023-12-19 05:38:52', '2023-12-19 05:38:52'),
(11, 11, 1, 'jhsfgj', 300, NULL, '2023-12-19 05:42:11', '2023-12-19 05:42:11'),
(12, 11, 3, 'jkasdbjhsa', 300, NULL, '2023-12-19 05:42:11', '2023-12-19 05:42:11');

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
-- Table structure for table `item_brand`
--

CREATE TABLE `item_brand` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `action` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_brand`
--

INSERT INTO `item_brand` (`id`, `brand_name`, `created_by`, `action`, `created_at`, `updated_at`) VALUES
(1, 'brand3', 1, 1, '2023-12-01 02:37:07', '2023-12-01 02:37:07'),
(2, 'brand 2', 1, 1, '2023-12-01 02:37:13', '2023-12-01 02:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `action` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`id`, `category_name`, `created_by`, `action`, `created_at`, `updated_at`) VALUES
(1, 'category 1', 1, 1, '2023-12-01 02:30:51', '2023-12-01 02:30:51'),
(3, 'category 2 admin1', 1, 1, '2023-12-06 07:26:19', '2023-12-06 07:26:19'),
(4, 'category 2 admin1', 2, 1, '2023-12-06 07:26:54', '2023-12-06 07:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

CREATE TABLE `item_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_type` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `action` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_type`
--

INSERT INTO `item_type` (`id`, `item_type`, `created_by`, `action`, `created_at`, `updated_at`) VALUES
(1, 'testing450', 1, 1, '2023-12-01 02:35:23', '2023-12-01 02:35:23'),
(2, 'item 2', 1, 1, '2023-12-01 02:35:32', '2023-12-01 02:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `item_units`
--

CREATE TABLE `item_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `action` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_units`
--

INSERT INTO `item_units` (`id`, `unit`, `created_by`, `action`, `created_at`, `updated_at`) VALUES
(1, 'unit1', 1, 1, '2023-12-01 02:45:50', '2023-12-01 02:45:50'),
(2, 'unit2', 1, 1, '2023-12-01 02:45:53', '2023-12-01 02:45:53');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `action` int(11) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `contact_no`, `country`, `city`, `email`, `status`, `action`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'name test', '03000000', NULL, NULL, 'test@gmail.com', 1, 1, 1, '2023-11-30 05:24:23', '2023-11-30 05:24:23'),
(2, 'name test1', '03000000', NULL, NULL, 'test@gmail.com', 1, 1, 1, '2023-11-30 05:24:35', '2023-11-30 05:24:35'),
(3, 'name test12', '03000000', NULL, NULL, 'test1@gmail.com', 1, 1, 1, '2023-11-30 05:25:16', '2023-11-30 05:25:16'),
(4, 'name test123', '03000000', NULL, NULL, 'test1@gmail.com3', 1, 0, 1, '2023-11-30 05:27:47', '2023-11-30 06:18:52'),
(5, 'name test123 abc update', '03000000', 'pak', 'sahiwal', 'test1@gmail.com32', 0, 1, 1, '2023-11-30 05:30:09', '2023-11-30 06:06:23');

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
(14, '2023_11_29_072240_create_units_table', 4),
(17, '2014_10_12_000000_create_users_table', 5),
(18, '2014_10_12_100000_create_password_reset_tokens_table', 5),
(19, '2016_06_01_000001_create_oauth_auth_codes_table', 5),
(20, '2016_06_01_000002_create_oauth_access_tokens_table', 5),
(21, '2016_06_01_000003_create_oauth_refresh_tokens_table', 5),
(22, '2016_06_01_000004_create_oauth_clients_table', 5),
(23, '2016_06_01_000005_create_oauth_personal_access_clients_table', 5),
(24, '2019_08_19_000000_create_failed_jobs_table', 5),
(25, '2019_12_14_000001_create_personal_access_tokens_table', 5),
(26, '2023_11_21_101916_create_admins_table', 5),
(27, '2023_11_27_120327_create_item_category_table', 5),
(28, '2023_11_27_120516_create_item_brand_table', 5),
(29, '2023_11_27_120633_create_item_type_table', 5),
(30, '2023_11_29_072559_create_item_units_table', 5),
(31, '2023_11_30_071753_create_locations_table', 5),
(32, '2023_11_30_113830_create_stock_adjustments_table', 6),
(33, '2023_12_01_080128_create_products_table', 7),
(36, '2023_12_06_111255_create_stock_adj_pro_table', 10),
(41, '2023_12_08_093734_create_purchase_orders_table', 13),
(42, '2023_12_08_104731_create_pur_ord_products_table', 13),
(43, '2023_12_06_112140_create_stock_adjustments_table', 14),
(44, '2023_12_06_114006_create_st_adj_prod_table', 14),
(47, '2023_12_05_102940_create_stock_transfer_table', 15),
(48, '2023_12_12_100047_create_stock_transfer_pro_table', 16),
(49, '2023_12_12_132904_create_purchase_invoice_table', 17),
(50, '2023_12_12_133457_create_pur_invoice_product_table', 17),
(51, '2023_12_14_100343_create_supplier_payment_table', 18),
(53, '2023_12_14_101750_create_supplier_invoice_pay_table', 19),
(54, '2023_12_18_081220_create_expenses_account_table', 20),
(55, '2023_12_18_114949_create_expenses_table', 21),
(56, '2023_12_18_115450_create_expenses_detail_table', 21),
(57, '2023_12_20_082146_create_sales_quotations_table', 22),
(58, '2023_12_20_115347_create_sales_quot_products_table', 22),
(59, '2023_12_21_130059_create_sale_invoices_table', 23),
(60, '2023_12_21_130129_create_sale_inv_products_table', 23),
(61, '2023_12_26_095738_create_customer_receipts_table', 24),
(62, '2023_12_26_110119_create_customer_rect_products_table', 24);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('1e77d4aa4751d955ba82bfb64828197d6ce28aea7bd301682ae97442746950cb4aa563c8b8b2deab', 1, 1, 'Admins', '[]', 0, '2023-12-18 06:26:52', '2023-12-18 06:26:52', '2024-12-18 11:26:52'),
('31b357917dedd3c5afbaeaca79ab5ec787534b49f9423db1f9301c0d03e2805ed2f8540b7f77dccf', 1, 1, 'Admins', '[]', 0, '2024-01-03 05:44:01', '2024-01-03 05:44:01', '2025-01-03 10:44:01'),
('351e37101e553447d85dcd1a2f1ad4ba0aba07f211251f839325398b9ab5552376e9f786e755c7df', 2, 1, 'Admins', '[]', 0, '2023-12-18 04:35:03', '2023-12-18 04:35:04', '2024-12-18 09:35:03'),
('532ee995059f32fcf0887fb9aab515462dfa1f69da580433cbe5f06ecf46f819fff568f9b286e410', 2, 1, 'Admins', '[]', 0, '2023-12-06 07:21:16', '2023-12-06 07:21:17', '2024-12-06 12:21:16'),
('55a68f1a6cb367dc46814c64de3711db6c89e3748a35da0eab464f498098a07f010ed10958f971f0', 1, 1, 'Admins', '[]', 0, '2023-12-06 07:22:06', '2023-12-06 07:22:06', '2024-12-06 12:22:06'),
('733f2e2852f586afb8edf8a35b06fbfed2d2991835e13136b8d9424b7ee8b1b16b6ba15730544aa2', 2, 1, 'Admins', '[]', 0, '2023-12-06 05:48:20', '2023-12-06 05:48:20', '2024-12-06 10:48:20'),
('7ce12678af11373a610d9e84fdd56e3fc3d667bd59f02fe4cfc6ba8faa6789c9424279a2dd86ae8b', 2, 1, 'Admins', '[]', 0, '2023-12-04 04:42:00', '2023-12-04 04:42:01', '2024-12-04 09:42:00'),
('822c5617e69f9d6ba278afebb67ab327697433fe13243b9122dbfb17841aba1e2ee028dff724f981', 2, 1, 'Admins', '[]', 0, '2023-12-06 07:08:09', '2023-12-06 07:08:09', '2024-12-06 12:08:09'),
('82dfabe13bf6242148d909ebcabd186849e62741c96d2c564a5ed7c62440650b1a86c4df72ef5aec', 1, 1, 'Admins', '[]', 0, '2023-12-21 03:24:53', '2023-12-21 03:24:53', '2024-12-21 08:24:53'),
('a7f6655732b2128fc4498cf0115c4b382c647bbe47351d921ff7c32c61c21aa53316c0070761b3d2', 2, 1, 'Admins', '[]', 0, '2023-12-05 03:17:52', '2023-12-05 03:17:52', '2024-12-05 08:17:52'),
('b69ace03a9a8eebd59e404539005155dfd560d2c05f912df9141e14e35056122e3f5450e857c91fc', 1, 1, 'Admins', '[]', 0, '2023-12-01 02:30:35', '2023-12-01 02:30:35', '2024-12-01 07:30:35'),
('ba22bdd885b826d6da4afe997b6a80ebca6b670d50cae9d6d7d0286d9316c91587578e518b49132a', 1, 1, 'Admins', '[]', 0, '2023-12-04 05:16:13', '2023-12-04 05:16:13', '2024-12-04 10:16:13'),
('bd2703ff6cdeb6674b2d4941d15b2bb7e9274d8775fd378f3ef0127f245ed7eab31f8ce2da153c3b', 1, 1, 'Admins', '[]', 0, '2023-12-19 06:57:44', '2023-12-19 06:57:44', '2024-12-19 11:57:44'),
('c3a8c5c33fc305614e3a3fb9d4b64ae986b4b2918d8684c4484955cf62708e3bffb1fb71e71f36a0', 2, 1, 'Admins', '[]', 0, '2023-12-06 07:26:43', '2023-12-06 07:26:44', '2024-12-06 12:26:43'),
('d19f476c05b0b3844eb25baec5559458dbee475603a1a6e1fe776ec7ea20d96f5e1d817423f24226', 1, 1, 'Admins', '[]', 0, '2024-01-04 05:56:54', '2024-01-04 05:56:54', '2025-01-04 10:56:54'),
('e999d46bc88a4f60f2a284823b82a177bf1b33e6197fde440cecd0c55b36c0e82a22993563f115d0', 2, 1, 'Admins', '[]', 0, '2023-12-04 05:17:32', '2023-12-04 05:17:32', '2024-12-04 10:17:32'),
('f63819c6469ee5522c574323539dfd950095667b0687c026e1848a5a2079fe59a3fa393040b793ca', 1, 1, 'Admins', '[]', 0, '2023-12-06 07:26:02', '2023-12-06 07:26:02', '2024-12-06 12:26:02'),
('fdd28a0fb3d3cda97de86fc958908eac581700aa455049089ca30496319e589141a3c3c937002379', 1, 1, 'Admins', '[]', 0, '2023-11-30 05:24:06', '2023-11-30 05:24:06', '2024-11-30 10:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', '8HsH3RtkdHJH647gejn3ZIA7puolteTVl8f1kndm', NULL, 'http://localhost', 1, 0, 0, '2023-11-30 05:23:28', '2023-11-30 05:23:28'),
(2, NULL, 'Laravel Password Grant Client', 'ZIob6JTjzZeC2kGHy1GxeGQbCvsi8AM1fPCuwM4e', 'users', 'http://localhost', 0, 1, 0, '2023-11-30 05:23:28', '2023-11-30 05:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-11-30 05:23:28', '2023-11-30 05:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `category` bigint(20) UNSIGNED NOT NULL,
  `type` bigint(20) UNSIGNED NOT NULL,
  `brand` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `packing_unit` bigint(20) UNSIGNED NOT NULL,
  `inventory_unit` bigint(20) UNSIGNED NOT NULL,
  `unit_conversion` int(11) NOT NULL,
  `opening_stock` int(11) NOT NULL,
  `opening_date` date NOT NULL,
  `location` bigint(20) UNSIGNED NOT NULL,
  `color` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `supplier` bigint(20) UNSIGNED NOT NULL,
  `selling_price` int(255) NOT NULL,
  `purchase_price` int(255) NOT NULL,
  `tax` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `barcode`, `category`, `type`, `brand`, `quantity`, `packing_unit`, `inventory_unit`, `unit_conversion`, `opening_stock`, `opening_date`, `location`, `color`, `size`, `supplier`, `selling_price`, `purchase_price`, `tax`, `description`, `image`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'product1', 'product sku', 'barcode test', 1, 1, 1, 0, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 10, '99', 'jhsadjhasb djhb', '1701678636-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 0, 1, '2023-12-04 03:30:37', '2023-12-12 05:52:29'),
(2, 'product1', 'product sku', 'barcode test', 1, 1, 1, 35, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 15, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701678676-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 0, 1, '2023-12-04 03:31:16', '2023-12-12 07:08:13'),
(3, 'product1', 'product sku', 'barcode test', 1, 1, 1, 10, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 20, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products1701678728-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 0, 1, '2023-12-04 03:32:08', '2023-12-12 05:57:31'),
(4, 'product1', 'product sku', 'barcode test', 1, 1, 1, 5, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 15, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701678758-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 0, 1, '2023-12-04 03:32:38', '2023-12-12 05:58:30'),
(5, 'product12', 'product sku', 'barcode test', 1, 1, 1, 35, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 20, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701682481-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 1, 1, '2023-12-04 04:34:41', '2023-12-21 07:37:11'),
(6, 'product1236', 'product sku', 'barcode test', 1, 1, 1, 975, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 15, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701684651-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 2, 1, '2023-12-04 05:10:51', '2024-01-08 08:08:41'),
(7, 'product1236', 'product sku', 'barcode test', 1, 1, 1, 0, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 29, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701684656-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 2, 1, '2023-12-04 05:10:56', '2023-12-13 03:41:02'),
(8, 'product1236', 'product sku', 'barcode test', 1, 1, 1, 20, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 29, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701684660-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 2, 1, '2023-12-04 05:11:00', '2023-12-04 05:11:00'),
(9, 'product1236', 'product sku', 'barcode test', 1, 1, 1, 20, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 29, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701684721-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 2, 1, '2023-12-04 05:12:01', '2023-12-04 05:12:01'),
(10, 'product1236', 'product sku', 'barcode test', 1, 1, 1, 100, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 40, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701684725-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 2, 1, '2023-12-04 05:12:05', '2023-12-20 05:23:21'),
(11, 'product12363', 'product sku', 'barcode test', 1, 1, 1, 30, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 30, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701684917-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 2, 1, '2023-12-04 05:15:17', '2023-12-20 05:23:21'),
(12, 'product12363', 'product sku', 'barcode test', 1, 1, 1, 70, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 120, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701684989-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 1, 1, '2023-12-04 05:16:29', '2023-12-21 07:36:45'),
(13, 'product1236344 update', 'product sku12', 'barcode test12', 1, 1, 1, 70, 1, 1, 1, 1, '2023-12-04', 1, 'red', 'every', 1, 20, 130, '99', 'jhsadjhasb djhb', 'http://127.0.0.1:8000/upload/products/1701685041-gigabyte-aorus-logo-pc-gaming-wallpaper-preview.jpg', 2, 1, '2023-12-04 05:17:21', '2023-12-21 07:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice`
--

CREATE TABLE `purchase_invoice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `location` bigint(20) UNSIGNED NOT NULL,
  `supplier` bigint(20) UNSIGNED NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `total_value` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `pay` int(11) NOT NULL DEFAULT 0,
  `order_no` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_invoice`
--

INSERT INTO `purchase_invoice` (`id`, `bill_no`, `location`, `supplier`, `invoice_date`, `due_date`, `invoice_no`, `reference_no`, `description`, `total_value`, `balance`, `pay`, `order_no`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(26, 'Pur-000001', 1, 1, '2023-12-04', '2023-12-08', '7834788990', 'jksnfkjsdf', 'jknsdkjndkaj', 1500, 1200, 300, 'pur-520570', 1, 2, '2023-12-20 07:34:53', '2023-12-26 05:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po_no` varchar(255) NOT NULL,
  `location` bigint(20) UNSIGNED NOT NULL,
  `supplier` bigint(20) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `expected_date` date NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `terms_and_conditions` text DEFAULT NULL,
  `total_value` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `order_no` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `po_no`, `location`, `supplier`, `order_date`, `expected_date`, `reference_no`, `description`, `terms_and_conditions`, `total_value`, `created_by`, `status`, `order_no`, `created_at`, `updated_at`) VALUES
(45, 'PO-0000001', 1, 1, '2023-12-04', '2023-12-08', 'jksnfkjsdf', 'jknsdkjndkaj', 'test', 15000, 2, 0, 'po-307949', '2023-12-20 06:59:42', '2023-12-20 07:01:17'),
(46, 'PO-0000002', 1, 1, '2023-12-10', '2023-12-08', 'jksnfkjsdf', 'jknsdkjndkaj', 'test', 15000, 2, 0, 'po-959609', '2023-12-28 04:34:50', '2023-12-28 04:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `pur_invoice_product`
--

CREATE TABLE `pur_invoice_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pur_invoice_id` bigint(20) UNSIGNED NOT NULL,
  `product` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pur_invoice_product`
--

INSERT INTO `pur_invoice_product` (`id`, `pur_invoice_id`, `product`, `quantity`, `rate`, `amount`, `created_at`, `updated_at`) VALUES
(1, 26, 12, 25, 10, 300, '2023-12-20 07:34:53', '2023-12-20 07:34:53'),
(2, 26, 13, 10, 50, 500, '2023-12-20 07:34:53', '2023-12-20 07:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `pur_ord_products`
--

CREATE TABLE `pur_ord_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pur_ord_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pur_ord_products`
--

INSERT INTO `pur_ord_products` (`id`, `pur_ord_id`, `product`, `quantity`, `rate`, `amount`, `created_at`, `updated_at`) VALUES
(1, 45, 12, 40, 120, 800, '2023-12-20 06:59:43', '2023-12-20 06:59:43'),
(2, 45, 13, 35, 130, 700, '2023-12-20 06:59:43', '2023-12-20 06:59:43'),
(3, 46, 12, 40, 120, 800, '2023-12-28 04:34:50', '2023-12-28 04:34:50'),
(4, 46, 13, 35, 130, 700, '2023-12-28 04:34:50', '2023-12-28 04:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `sales_quotations`
--

CREATE TABLE `sales_quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sq` varchar(255) NOT NULL,
  `location` bigint(20) UNSIGNED NOT NULL,
  `customer` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `expire_date` date NOT NULL,
  `total_value` int(11) NOT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `terms_conditions` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `sq_no` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_quotations`
--

INSERT INTO `sales_quotations` (`id`, `sq`, `location`, `customer`, `date`, `expire_date`, `total_value`, `reference_no`, `description`, `terms_conditions`, `status`, `sq_no`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 'SQ-0000001', 1, 7, '2023-12-09', '2023-12-29', 5000, 'jhbsdjhbdj', 'jhdjqwhbdjqwhbsjhqw', 'kjbwdjh djh djqhw djh', 0, 'sq-920553', 1, '2023-12-21 05:47:42', '2023-12-21 05:47:42'),
(3, 'SQ-0000002', 1, 7, '2023-12-21', '2023-12-29', 5000, 'jhbsdjhbdj', 'jhdjqwhbdjqwhbsjhqw', 'kjbwdjh djh djqhw djh', 0, 'sq-281895', 1, '2023-12-21 05:48:26', '2023-12-21 07:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `sales_quot_products`
--

CREATE TABLE `sales_quot_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_qout_id` bigint(20) UNSIGNED NOT NULL,
  `product` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_quot_products`
--

INSERT INTO `sales_quot_products` (`id`, `sale_qout_id`, `product`, `quantity`, `rate`, `amount`, `created_at`, `updated_at`) VALUES
(1, 3, 12, 10, 120, 800, '2023-12-21 05:48:26', '2023-12-21 05:48:26'),
(2, 3, 13, 10, 130, 700, '2023-12-21 05:48:26', '2023-12-21 05:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `sale_invoices`
--

CREATE TABLE `sale_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inv_no` varchar(255) NOT NULL,
  `location` bigint(20) UNSIGNED NOT NULL,
  `customer` bigint(20) UNSIGNED NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `terms_condition` text DEFAULT NULL,
  `total_value` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `pay` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `sale_no` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_invoices`
--

INSERT INTO `sale_invoices` (`id`, `inv_no`, `location`, `customer`, `invoice_date`, `due_date`, `reference_no`, `description`, `terms_condition`, `total_value`, `balance`, `pay`, `status`, `sale_no`, `created_by`, `created_at`, `updated_at`) VALUES
(6, 'INV-000003', 1, 7, '2023-12-21', '2023-12-29', 'jhbsdjhbdj', 'jhdjqwhbdjqwhbsjhqw', 'kjbwdjh djh djqhw djh', 5000, 4000, 1000, 1, 'inv-257409', 1, '2023-12-22 05:40:30', '2023-12-27 07:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `sale_inv_products`
--

CREATE TABLE `sale_inv_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_inv_id` bigint(20) UNSIGNED NOT NULL,
  `product` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_inv_products`
--

INSERT INTO `sale_inv_products` (`id`, `sale_inv_id`, `product`, `quantity`, `rate`, `amount`, `description`, `created_at`, `updated_at`) VALUES
(4, 6, 12, 10, 120, 800, 'jdsjhbdhjdbs', '2023-12-22 05:40:30', '2023-12-22 05:40:30'),
(5, 6, 13, 10, 130, 700, '', '2023-12-22 05:40:30', '2023-12-22 05:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustments`
--

CREATE TABLE `stock_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `location` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `saj_no` varchar(255) NOT NULL,
  `total_value` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `sjp_no` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_adjustments`
--

INSERT INTO `stock_adjustments` (`id`, `type`, `location`, `date`, `remarks`, `saj_no`, `total_value`, `created_by`, `sjp_no`, `created_at`, `updated_at`) VALUES
(1, 'first', 1, '2023-12-04', 'jhksbfdjshbdsjha', 'SAJ-000001', 0, 2, 'sjp-181936', '2023-12-11 08:16:13', '2023-12-11 08:16:13'),
(2, 'first', 1, '2023-12-03', 'jhksbfdjshbdsjha', 'SAJ-000002', 0, 2, 'sjp-272205', '2023-12-11 08:16:14', '2023-12-11 08:16:14'),
(3, 'first', 1, '2023-12-04', 'jhksbfdjshbdsjha', 'SAJ-000003', 0, 2, 'sjp-869358', '2023-12-12 07:05:39', '2023-12-12 07:05:39'),
(4, 'first', 1, '2023-12-04', 'jhksbfdjshbdsjha', 'SAJ-000004', 0, 2, 'sjp-531800', '2023-12-12 07:07:51', '2023-12-12 07:07:51'),
(5, 'first', 1, '2023-12-30', 'jhksbfdjshbdsjha', 'SAJ-000005', 0, 2, 'sjp-901937', '2023-12-12 07:08:13', '2023-12-12 07:08:13'),
(6, 'first', 1, '2023-12-20', 'jhksbfdjshbdsjha', 'SAJ-000006', 0, 2, 'sjp-701988', '2023-12-12 07:08:37', '2023-12-12 07:08:37'),
(7, 'first', 1, '2023-12-04', 'jhksbfdjshbdsjha', 'SAJ-000007', 0, 2, 'sjp-390377', '2023-12-12 07:09:03', '2023-12-12 07:09:03'),
(8, 'first', 1, '2023-12-04', 'jhksbfdjshbdsjha', 'SAJ-000008', 0, 2, 'sjp-683404', '2023-12-12 07:09:25', '2023-12-12 07:09:25'),
(10, 'first', 1, '2023-12-07', 'jhksbfdjshbdsjha', 'SAJ-000009', 0, 2, 'sjp-114938', '2023-12-12 07:15:52', '2023-12-12 07:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE `stock_transfer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `st_no` varchar(255) NOT NULL,
  `source` bigint(20) UNSIGNED NOT NULL,
  `destination` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `narration` text NOT NULL,
  `file` text NOT NULL,
  `total` int(11) NOT NULL,
  `stp_no` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfer`
--

INSERT INTO `stock_transfer` (`id`, `st_no`, `source`, `destination`, `date`, `narration`, `file`, `total`, `stp_no`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'ST-0000001', 1, 1, '2023-12-04', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702378297-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-155555', 2, '2023-12-12 05:51:37', '2023-12-12 05:51:37'),
(3, 'ST-0000003', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702378385-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-863478', 2, '2023-12-12 05:53:05', '2023-12-12 05:53:05'),
(4, 'ST-0000004', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702378420-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-317049', 2, '2023-12-12 05:53:40', '2023-12-12 05:53:40'),
(5, 'ST-0000005', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702378481-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-671008', 2, '2023-12-12 05:54:41', '2023-12-12 05:54:41'),
(6, 'ST-0000006', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702378511-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-461691', 2, '2023-12-12 05:55:11', '2023-12-12 05:55:11'),
(7, 'ST-0000007', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702378553-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-967528', 2, '2023-12-12 05:55:53', '2023-12-12 05:55:53'),
(8, 'ST-0000008', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702378651-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-719006', 2, '2023-12-12 05:57:31', '2023-12-12 05:57:31'),
(9, 'ST-0000009', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702378664-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-818949', 2, '2023-12-12 05:57:44', '2023-12-12 05:57:44'),
(10, 'ST-0000010', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702378687-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-186248', 2, '2023-12-12 05:58:07', '2023-12-12 05:58:07'),
(11, 'ST-0000011', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702378710-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-798299', 2, '2023-12-12 05:58:30', '2023-12-12 05:58:30'),
(12, 'ST-0000012', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702381721-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-955266', 2, '2023-12-12 06:48:41', '2023-12-12 06:48:41'),
(13, 'ST-0000013', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702382621-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-491164', 2, '2023-12-12 07:03:41', '2023-12-12 07:03:41'),
(14, 'ST-0000014', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702382669-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-326891', 2, '2023-12-12 07:04:29', '2023-12-12 07:04:29'),
(15, 'ST-0000015', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702382693-screencapture-127-0-0-1-8000-register-booking-1-1-2023-11-12-11_03_32.pdf', 0, 'stp-751479', 2, '2023-12-12 07:04:53', '2023-12-12 07:04:53'),
(16, 'ST-0000016', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702456862-download (21).jpg', 0, 'stp-466408', 2, '2023-12-13 03:41:02', '2023-12-13 03:41:02'),
(17, 'ST-0000017', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702456885-download (21).jpg', 0, 'stp-815955', 2, '2023-12-13 03:41:25', '2023-12-13 03:41:25'),
(18, 'ST-0000018', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702456913-download (21).jpg', 0, 'stp-955101', 2, '2023-12-13 03:41:53', '2023-12-13 03:41:53'),
(20, 'ST-0000019', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1702460533-download (21).jpg', 0, 'stp-268913', 2, '2023-12-13 04:42:13', '2023-12-13 04:42:13'),
(21, 'ST-0000020', 1, 1, '2023-12-06', 'jkasbdkjsdasbdjkasbdjkl', 'http://127.0.0.1:8000/upload/stock/1704719320-circuits-minimalism-electronic-abstract-wallpaper-preview_1692424973.webp', 0, 'stp-743365', 2, '2024-01-08 08:08:40', '2024-01-08 08:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_pro`
--

CREATE TABLE `stock_transfer_pro` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transfer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transfer_pro`
--

INSERT INTO `stock_transfer_pro` (`id`, `transfer_id`, `product_id`, `quantity`, `rate`, `amount`, `created_at`, `updated_at`) VALUES
(2, 7, 3, 25, 10, 300, '2023-12-12 05:55:53', '2023-12-12 05:55:53'),
(3, 7, 4, 35, 50, 500, '2023-12-12 05:55:53', '2023-12-12 05:55:53'),
(4, 8, 3, 25, 10, 300, '2023-12-12 05:57:31', '2023-12-12 05:57:31'),
(5, 11, 4, 20, 50, 500, '2023-12-12 05:58:30', '2023-12-12 05:58:30'),
(6, 15, 7, 10, 50, 500, '2023-12-12 07:04:53', '2023-12-12 07:04:53'),
(7, 16, 7, 10, 50, 500, '2023-12-13 03:41:02', '2023-12-13 03:41:02'),
(8, 18, 6, 110, 50, 500, '2023-12-13 03:41:53', '2023-12-13 03:41:53'),
(9, 21, 6, 25, 10, 300, '2024-01-08 08:08:41', '2024-01-08 08:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `st_adj_prod`
--

CREATE TABLE `st_adj_prod` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `st_adj_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `adjust_qty` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `st_adj_prod`
--

INSERT INTO `st_adj_prod` (`id`, `st_adj_id`, `product_id`, `adjust_qty`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 10, 300, '2023-12-11 08:16:13', '2023-12-11 08:16:13'),
(2, 1, 2, 5, 500, '2023-12-11 08:16:13', '2023-12-11 08:16:13'),
(3, 2, 1, 10, 300, '2023-12-11 08:16:14', '2023-12-11 08:16:14'),
(4, 2, 2, 5, 500, '2023-12-11 08:16:14', '2023-12-11 08:16:14'),
(6, 5, 2, 5, 500, '2023-12-12 07:08:13', '2023-12-12 07:08:13'),
(7, 6, 5, 10, 300, '2023-12-12 07:08:37', '2023-12-12 07:08:37'),
(8, 7, 5, 10, 300, '2023-12-12 07:09:03', '2023-12-12 07:09:03'),
(9, 8, 5, 10, 300, '2023-12-12 07:09:25', '2023-12-12 07:09:25'),
(10, 10, 5, 10, 300, '2023-12-12 07:15:52', '2023-12-12 07:15:52');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_invoice_pay`
--

CREATE TABLE `supplier_invoice_pay` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_pay_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paying` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_invoice_pay`
--

INSERT INTO `supplier_invoice_pay` (`id`, `supplier_pay_id`, `invoice_id`, `paying`, `created_at`, `updated_at`) VALUES
(47, 47, 26, 100, '2023-12-26 05:11:36', '2023-12-26 05:11:36'),
(48, 48, 26, 100, '2023-12-26 05:12:59', '2023-12-26 05:12:59'),
(49, 49, 26, 100, '2023-12-26 05:13:25', '2023-12-26 05:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payment`
--

CREATE TABLE `supplier_payment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `spay_no` varchar(255) NOT NULL,
  `supplier` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `pay_mode` varchar(255) NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `pay_no` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_payment`
--

INSERT INTO `supplier_payment` (`id`, `spay_no`, `supplier`, `date`, `amount`, `pay_mode`, `reference_no`, `narration`, `file_name`, `file_path`, `pay_no`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(4, 'SPay-00003', 1, '2023-12-04', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657af0da1e073.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657af0da1e073.jpg', 'spay-216924', 0, 1, '2023-12-14 07:11:06', '2023-12-14 07:11:06'),
(5, 'SPay-00004', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657af0fd0007e.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657af0fd0007e.jpg', 'spay-854035', 0, 1, '2023-12-14 07:11:41', '2023-12-14 07:11:41'),
(6, 'SPay-00005', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657af19e9ced3.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657af19e9ced3.jpg', 'spay-535668', 0, 1, '2023-12-14 07:14:22', '2023-12-14 07:14:22'),
(7, 'SPay-00006', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657af1bc05300.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657af1bc05300.jpg', 'spay-554440', 0, 1, '2023-12-14 07:14:52', '2023-12-14 07:14:52'),
(8, 'SPay-00007', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657af2b32975c.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657af2b32975c.jpg', 'spay-973139', 0, 1, '2023-12-14 07:18:59', '2023-12-14 07:18:59'),
(9, 'SPay-00008', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657af8b7e4087.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657af8b7e4087.jpg', 'spay-394888', 0, 1, '2023-12-14 07:44:39', '2023-12-14 07:44:39'),
(10, 'SPay-00009', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657af8d96729b.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657af8d96729b.jpg', 'spay-687070', 0, 1, '2023-12-14 07:45:13', '2023-12-14 07:45:13'),
(11, 'SPay-00010', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657af95d74580.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657af95d74580.jpg', 'spay-651528', 0, 1, '2023-12-14 07:47:25', '2023-12-14 07:47:25'),
(12, 'SPay-00011', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657af9b6599be.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657af9b6599be.jpg', 'spay-569430', 0, 1, '2023-12-14 07:48:54', '2023-12-14 07:48:54'),
(13, 'SPay-00012', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657afbfd034cd.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657afbfd034cd.jpg', 'spay-329408', 1, 1, '2023-12-14 07:58:37', '2023-12-14 07:58:37'),
(14, 'SPay-00013', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657afc098f70a.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657afc098f70a.jpg', 'spay-282186', 0, 1, '2023-12-14 07:58:49', '2023-12-14 07:58:49'),
(15, 'SPay-00014', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657bfb8261b56.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657bfb8261b56.jpg', 'spay-949540', 1, 1, '2023-12-15 02:08:50', '2023-12-15 02:08:50'),
(16, 'SPay-00015', 1, '2023-12-14', 5000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657bfcfdf3860.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657bfcfdf3860.jpg', 'spay-785469', 1, 1, '2023-12-15 02:15:10', '2023-12-15 02:15:10'),
(17, 'SPay-00016', 1, '2023-12-14', 5200, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657bff0e119be.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657bff0e119be.jpg', 'spay-492010', 0, 1, '2023-12-15 02:23:58', '2023-12-15 02:23:58'),
(18, 'SPay-00017', 1, '2023-12-14', 2000, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657c01317d56a.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657c01317d56a.jpg', 'spay-145891', 1, 1, '2023-12-15 02:33:05', '2023-12-15 02:33:05'),
(20, 'SPay-00018', 1, '2023-12-14', 200, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_657c0169de80d.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_657c0169de80d.jpg', 'spay-638811', 1, 1, '2023-12-15 02:34:01', '2023-12-15 02:34:01'),
(21, 'SPay-00019', 1, '2023-12-14', 200, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c6e69d783.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c6e69d783.jpg', 'spay-854454', 1, 1, '2023-12-20 05:50:14', '2023-12-20 05:50:14'),
(22, 'SPay-00020', 1, '2023-12-14', 200, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c715257ba.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c715257ba.jpg', 'spay-730371', 1, 1, '2023-12-20 05:51:01', '2023-12-20 05:51:01'),
(23, 'SPay-00021', 1, '2023-12-14', 200, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c7376a502.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c7376a502.jpg', 'spay-327058', 1, 1, '2023-12-20 05:51:35', '2023-12-20 05:51:35'),
(24, 'SPay-00022', 1, '2023-12-14', 200, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c749ad15b.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c749ad15b.jpg', 'spay-505338', 1, 1, '2023-12-20 05:51:53', '2023-12-20 05:51:53'),
(25, 'SPay-00023', 1, '2023-12-14', 200, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c7539612b.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c7539612b.jpg', 'spay-405408', 1, 1, '2023-12-20 05:52:03', '2023-12-20 05:52:03'),
(26, 'SPay-00024', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c817a0690.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c817a0690.jpg', 'spay-324589', 1, 1, '2023-12-20 05:55:19', '2023-12-20 05:55:19'),
(27, 'SPay-00025', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c8730c149.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c8730c149.jpg', 'spay-992176', 1, 1, '2023-12-20 05:56:51', '2023-12-20 05:56:51'),
(28, 'SPay-00026', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c88b4983e.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c88b4983e.jpg', 'spay-903100', 1, 1, '2023-12-20 05:57:15', '2023-12-20 05:57:15'),
(29, 'SPay-00027', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c8d1b004a.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c8d1b004a.jpg', 'spay-426712', 1, 1, '2023-12-20 05:58:25', '2023-12-20 05:58:25'),
(30, 'SPay-00028', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c8f037fd4.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c8f037fd4.jpg', 'spay-505674', 1, 1, '2023-12-20 05:58:56', '2023-12-20 05:58:56'),
(31, 'SPay-00029', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c9028f7fc.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c9028f7fc.jpg', 'spay-740157', 1, 1, '2023-12-20 05:59:14', '2023-12-20 05:59:14'),
(32, 'SPay-00030', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582c9130fa0d.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582c9130fa0d.jpg', 'spay-861370', 1, 1, '2023-12-20 05:59:31', '2023-12-20 05:59:31'),
(34, 'SPay-00031', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582df9ad5e5d.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582df9ad5e5d.jpg', 'spay-807079', 1, 1, '2023-12-20 07:35:38', '2023-12-20 07:35:38'),
(35, 'SPay-00032', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_6582dfb49a36c.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_6582dfb49a36c.jpg', 'spay-239134', 1, 1, '2023-12-20 07:36:04', '2023-12-20 07:36:04'),
(36, 'SPay-00033', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_658aa3cf2b15b.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_658aa3cf2b15b.jpg', 'spay-651458', 1, 1, '2023-12-26 04:58:39', '2023-12-26 04:58:39'),
(37, 'SPay-00034', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_658aa415d920e.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_658aa415d920e.jpg', 'spay-897527', 1, 1, '2023-12-26 04:59:49', '2023-12-26 04:59:49'),
(38, 'SPay-00035', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_658aa4c407edb.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_658aa4c407edb.jpg', 'spay-372468', 1, 1, '2023-12-26 05:02:44', '2023-12-26 05:02:44'),
(40, 'SPay-00036', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_658aa542271a6.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_658aa542271a6.jpg', 'spay-558736', 1, 1, '2023-12-26 05:04:50', '2023-12-26 05:04:50'),
(41, 'SPay-00037', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_658aa55bd0319.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_658aa55bd0319.jpg', 'spay-336853', 1, 1, '2023-12-26 05:05:15', '2023-12-26 05:05:15'),
(42, 'SPay-00038', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_658aa5722048f.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_658aa5722048f.jpg', 'spay-740769', 1, 1, '2023-12-26 05:05:38', '2023-12-26 05:05:38'),
(47, 'SPay-00039', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_658aa6d8b9280.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_658aa6d8b9280.jpg', 'spay-656717', 1, 1, '2023-12-26 05:11:36', '2023-12-26 05:11:36'),
(48, 'SPay-00040', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_658aa72b90f97.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_658aa72b90f97.jpg', 'spay-468998', 1, 1, '2023-12-26 05:12:59', '2023-12-26 05:12:59'),
(49, 'SPay-00041', 1, '2023-12-14', 2009, 'cash', '2342', 'aJHDBJAHSDB', 'supplier_658aa74563d66.jpg', 'http://127.0.0.1:8000/upload/payment/supplier_658aa74563d66.jpg', 'spay-726544', 1, 1, '2023-12-26 05:13:25', '2023-12-26 05:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `units` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `action` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `tax_registered` int(11) DEFAULT NULL,
  `tax_no` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `date_of_balance` varchar(255) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `balance_type` varchar(255) DEFAULT NULL,
  `payment_terms` varchar(255) DEFAULT NULL,
  `credit_limit` int(11) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `contact_person_phone` varchar(255) DEFAULT NULL,
  `contact_person_email` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `type` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `display_name`, `phone_no`, `mobile_no`, `country`, `city`, `address`, `shipping_address`, `active`, `tax_registered`, `tax_no`, `currency`, `date_of_balance`, `balance`, `balance_type`, `payment_terms`, `credit_limit`, `contact_person_name`, `contact_person_phone`, `contact_person_email`, `remarks`, `status`, `type`, `role`, `created_by`, `action`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Khan', 'khan@gmail.com', NULL, NULL, 'A Khan', '03056702559', '03056702559', 'pak', 'sahiwal', 'harrapa road', 'harrapa road', 1, 1, '2333', 'usd', '11/23/2023', 39372, 'dr', 'no', 0, 'ak', '03441683800', 'ak@gmail.com', 'qwdqweqwe', 1, 'supplier', NULL, 1, '1', NULL, '2023-12-01 02:46:31', '2023-12-26 05:13:25'),
(2, 'Akhtar', 'akhtar@gmail.com', NULL, NULL, 'Akhtar Ali', '03056702559', '03056702559', 'pak', 'sahiwal', 'harrapa road', 'harrapa road', 1, 1, '2333', 'usd', '11/23/2023', 10, 'dr', 'no', 0, 'ak', '03441683800', 'ak@gmail.com', 'qwdqweqwe', 1, 'supplier', NULL, 1, '1', NULL, '2023-12-01 02:46:55', '2023-12-01 02:46:55'),
(3, 'Khan', 'khan@gmail.com', NULL, NULL, 'Khan A', '03056702559', '03056702559', 'pak', 'sahiwal', 'harrapa road', 'harrapa road', 1, 1, '2333', 'usd', '11/23/2023', 10, 'dr', 'no', 0, 'ak', '03441683800', 'ak@gmail.com', 'qwdqweqwe', 1, 'customer', NULL, 1, '1', NULL, '2023-12-21 03:25:06', '2023-12-21 03:25:06'),
(4, 'Akhtar', 'akhtar@gmail.com', NULL, NULL, 'Akhtar Ak', '03056702559', '03056702559', 'pak', 'sahiwal', 'harrapa road', 'harrapa road', 1, 1, '2333', 'usd', '11/23/2023', 10, 'dr', 'no', 0, 'ak', '03441683800', 'ak@gmail.com', 'qwdqweqwe', 1, 'supplier', NULL, 1, '1', NULL, '2023-12-21 03:25:49', '2023-12-21 03:25:49'),
(7, 'Akhtar Ak', 'akhtar@gmail.com', NULL, NULL, 'Akhtar Ali', '0305670255922', '030567025592', 'pak2', 'sahiwal2', 'harrapa road2', 'harrapa road2', 0, 0, '23331', 'usd1', '11/22/2023', 3000, 'dr1', 'no1', 1, 'ak1', '034416838001', 'ak1@gmail.com', 'qwdqweqwe', 1, 'customer', NULL, 1, '1', NULL, '2023-12-21 03:33:02', '2023-12-27 07:45:36'),
(8, 'Khan', 'khan2@gmail.com', NULL, NULL, 'Khan A', '03056702559', '03056702559', 'pak', 'sahiwal', 'harrapa road', 'harrapa road', 1, 1, '2333', 'usd', '11/23/2023', 10, 'dr', 'no', 0, 'ak', '03441683800', 'ak@gmail.com', 'qwdqweqwe', 1, 'supplier', NULL, 1, '1', NULL, '2023-12-21 03:25:06', '2023-12-21 03:25:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_receipts`
--
ALTER TABLE `customer_receipts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_receipts_receipt_no_unique` (`receipt_no`),
  ADD KEY `customer_receipts_customer_foreign` (`customer`);

--
-- Indexes for table `customer_receipt_products`
--
ALTER TABLE `customer_receipt_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_receipt_products_receipt_id_foreign` (`receipt_id`),
  ADD KEY `customer_receipt_products_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_supplier_foreign` (`supplier`);

--
-- Indexes for table `expenses_account`
--
ALTER TABLE `expenses_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses_detail`
--
ALTER TABLE `expenses_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_detail_expenses_id_foreign` (`expenses_id`),
  ADD KEY `expenses_detail_expenses_account_foreign` (`expenses_account`),
  ADD KEY `expenses_detail_location_foreign` (`location`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `item_brand`
--
ALTER TABLE `item_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_type`
--
ALTER TABLE `item_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_units`
--
ALTER TABLE `item_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
  ADD KEY `products_category_foreign` (`category`),
  ADD KEY `products_type_foreign` (`type`),
  ADD KEY `products_brand_foreign` (`brand`),
  ADD KEY `products_packing_unit_foreign` (`packing_unit`),
  ADD KEY `products_inventory_unit_foreign` (`inventory_unit`),
  ADD KEY `products_location_foreign` (`location`),
  ADD KEY `products_supplier_foreign` (`supplier`);

--
-- Indexes for table `purchase_invoice`
--
ALTER TABLE `purchase_invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_invoice_bill_no_unique` (`bill_no`),
  ADD KEY `purchase_invoice_location_foreign` (`location`),
  ADD KEY `purchase_invoice_supplier_foreign` (`supplier`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_orders_po_no_unique` (`po_no`),
  ADD KEY `purchase_orders_location_foreign` (`location`),
  ADD KEY `purchase_orders_supplier_foreign` (`supplier`);

--
-- Indexes for table `pur_invoice_product`
--
ALTER TABLE `pur_invoice_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pur_invoice_product_pur_invoice_id_foreign` (`pur_invoice_id`),
  ADD KEY `pur_invoice_product_product_foreign` (`product`);

--
-- Indexes for table `pur_ord_products`
--
ALTER TABLE `pur_ord_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pur_ord_products_pur_ord_id_foreign` (`pur_ord_id`),
  ADD KEY `pur_ord_products_product_foreign` (`product`);

--
-- Indexes for table `sales_quotations`
--
ALTER TABLE `sales_quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_quotations_location_foreign` (`location`),
  ADD KEY `sales_quotations_customer_foreign` (`customer`);

--
-- Indexes for table `sales_quot_products`
--
ALTER TABLE `sales_quot_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_quot_products_sale_qout_id_foreign` (`sale_qout_id`),
  ADD KEY `sales_quot_products_product_foreign` (`product`);

--
-- Indexes for table `sale_invoices`
--
ALTER TABLE `sale_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sale_invoices_inv_no_unique` (`inv_no`),
  ADD KEY `sale_invoices_location_foreign` (`location`),
  ADD KEY `sale_invoices_customer_foreign` (`customer`);

--
-- Indexes for table `sale_inv_products`
--
ALTER TABLE `sale_inv_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_inv_products_sale_inv_id_foreign` (`sale_inv_id`),
  ADD KEY `sale_inv_products_product_foreign` (`product`);

--
-- Indexes for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_adjustments_location_foreign` (`location`);

--
-- Indexes for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_transfer_st_no_unique` (`st_no`),
  ADD KEY `stock_transfer_source_foreign` (`source`),
  ADD KEY `stock_transfer_destination_foreign` (`destination`);

--
-- Indexes for table `stock_transfer_pro`
--
ALTER TABLE `stock_transfer_pro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transfer_pro_transfer_id_foreign` (`transfer_id`),
  ADD KEY `stock_transfer_pro_product_id_foreign` (`product_id`);

--
-- Indexes for table `st_adj_prod`
--
ALTER TABLE `st_adj_prod`
  ADD PRIMARY KEY (`id`),
  ADD KEY `st_adj_prod_st_adj_id_foreign` (`st_adj_id`),
  ADD KEY `st_adj_prod_product_id_foreign` (`product_id`);

--
-- Indexes for table `supplier_invoice_pay`
--
ALTER TABLE `supplier_invoice_pay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_invoice_pay_supplier_pay_id_foreign` (`supplier_pay_id`),
  ADD KEY `supplier_invoice_pay_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `supplier_payment`
--
ALTER TABLE `supplier_payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_payment_spay_no_unique` (`spay_no`),
  ADD KEY `supplier_payment_supplier_foreign` (`supplier`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_receipts`
--
ALTER TABLE `customer_receipts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_receipt_products`
--
ALTER TABLE `customer_receipt_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `expenses_account`
--
ALTER TABLE `expenses_account`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `expenses_detail`
--
ALTER TABLE `expenses_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_brand`
--
ALTER TABLE `item_brand`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `item_type`
--
ALTER TABLE `item_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `item_units`
--
ALTER TABLE `item_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `purchase_invoice`
--
ALTER TABLE `purchase_invoice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `pur_invoice_product`
--
ALTER TABLE `pur_invoice_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pur_ord_products`
--
ALTER TABLE `pur_ord_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_quotations`
--
ALTER TABLE `sales_quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales_quot_products`
--
ALTER TABLE `sales_quot_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sale_invoices`
--
ALTER TABLE `sale_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sale_inv_products`
--
ALTER TABLE `sale_inv_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `stock_transfer_pro`
--
ALTER TABLE `stock_transfer_pro`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `st_adj_prod`
--
ALTER TABLE `st_adj_prod`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier_invoice_pay`
--
ALTER TABLE `supplier_invoice_pay`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `supplier_payment`
--
ALTER TABLE `supplier_payment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_receipts`
--
ALTER TABLE `customer_receipts`
  ADD CONSTRAINT `customer_receipts_customer_foreign` FOREIGN KEY (`customer`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_receipt_products`
--
ALTER TABLE `customer_receipt_products`
  ADD CONSTRAINT `customer_receipt_products_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `sale_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_receipt_products_receipt_id_foreign` FOREIGN KEY (`receipt_id`) REFERENCES `customer_receipts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_supplier_foreign` FOREIGN KEY (`supplier`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expenses_detail`
--
ALTER TABLE `expenses_detail`
  ADD CONSTRAINT `expenses_detail_expenses_account_foreign` FOREIGN KEY (`expenses_account`) REFERENCES `expenses_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_detail_expenses_id_foreign` FOREIGN KEY (`expenses_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_detail_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_foreign` FOREIGN KEY (`brand`) REFERENCES `item_brand` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_foreign` FOREIGN KEY (`category`) REFERENCES `item_category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_inventory_unit_foreign` FOREIGN KEY (`inventory_unit`) REFERENCES `item_units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_packing_unit_foreign` FOREIGN KEY (`packing_unit`) REFERENCES `item_units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_supplier_foreign` FOREIGN KEY (`supplier`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_type_foreign` FOREIGN KEY (`type`) REFERENCES `item_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_invoice`
--
ALTER TABLE `purchase_invoice`
  ADD CONSTRAINT `purchase_invoice_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_invoice_supplier_foreign` FOREIGN KEY (`supplier`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_orders_supplier_foreign` FOREIGN KEY (`supplier`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pur_invoice_product`
--
ALTER TABLE `pur_invoice_product`
  ADD CONSTRAINT `pur_invoice_product_product_foreign` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pur_invoice_product_pur_invoice_id_foreign` FOREIGN KEY (`pur_invoice_id`) REFERENCES `purchase_invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pur_ord_products`
--
ALTER TABLE `pur_ord_products`
  ADD CONSTRAINT `pur_ord_products_product_foreign` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pur_ord_products_pur_ord_id_foreign` FOREIGN KEY (`pur_ord_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_quotations`
--
ALTER TABLE `sales_quotations`
  ADD CONSTRAINT `sales_quotations_customer_foreign` FOREIGN KEY (`customer`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_quotations_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_quot_products`
--
ALTER TABLE `sales_quot_products`
  ADD CONSTRAINT `sales_quot_products_product_foreign` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_quot_products_sale_qout_id_foreign` FOREIGN KEY (`sale_qout_id`) REFERENCES `sales_quotations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_invoices`
--
ALTER TABLE `sale_invoices`
  ADD CONSTRAINT `sale_invoices_customer_foreign` FOREIGN KEY (`customer`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_invoices_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sale_inv_products`
--
ALTER TABLE `sale_inv_products`
  ADD CONSTRAINT `sale_inv_products_product_foreign` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_inv_products_sale_inv_id_foreign` FOREIGN KEY (`sale_inv_id`) REFERENCES `sale_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD CONSTRAINT `stock_adjustments_location_foreign` FOREIGN KEY (`location`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD CONSTRAINT `stock_transfer_destination_foreign` FOREIGN KEY (`destination`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transfer_source_foreign` FOREIGN KEY (`source`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transfer_pro`
--
ALTER TABLE `stock_transfer_pro`
  ADD CONSTRAINT `stock_transfer_pro_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transfer_pro_transfer_id_foreign` FOREIGN KEY (`transfer_id`) REFERENCES `stock_transfer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `st_adj_prod`
--
ALTER TABLE `st_adj_prod`
  ADD CONSTRAINT `st_adj_prod_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `st_adj_prod_st_adj_id_foreign` FOREIGN KEY (`st_adj_id`) REFERENCES `stock_adjustments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supplier_invoice_pay`
--
ALTER TABLE `supplier_invoice_pay`
  ADD CONSTRAINT `supplier_invoice_pay_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `purchase_invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `supplier_invoice_pay_supplier_pay_id_foreign` FOREIGN KEY (`supplier_pay_id`) REFERENCES `supplier_payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supplier_payment`
--
ALTER TABLE `supplier_payment`
  ADD CONSTRAINT `supplier_payment_supplier_foreign` FOREIGN KEY (`supplier`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

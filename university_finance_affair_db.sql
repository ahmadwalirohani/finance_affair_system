-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2024 at 07:37 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university_finance_affair_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `type`) VALUES
(3, 'Ù…ØªÙØ±Ù‚Ù‡ Ù…ØµØ±Ù edited', 'Ù…ØµØ±Ù'),
(4, 'Ø¹Ù…ÙˆÙ…ÙŠ Ø¹ÙˆØ§ÛŒØ¯', 'Ø¹Ø§ÛŒØ¯'),
(5, 'Ø§Ø³Ø¯ Ù…ÛŒØ§Ø´ØªÙŠ Ø§Ø³ØªØ§Ø¯Ø§Ù†Ùˆ Ù…Ø¹Ø§Ø´Ø§Øª', 'Ù…ØµØ±Ù');

-- --------------------------------------------------------

--
-- Table structure for table `dedicated_items`
--

CREATE TABLE `dedicated_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `consumer` varchar(255) DEFAULT NULL,
  `quantity` decimal(20,2) NOT NULL DEFAULT 0.00,
  `remarks` varchar(1000) DEFAULT NULL,
  `is_returned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dedicated_items`
--

INSERT INTO `dedicated_items` (`id`, `item_id`, `department_id`, `consumer`, `quantity`, `remarks`, `is_returned`, `created_at`) VALUES
(2, 2, 2, 'Ø§Ø³Ø¯ Ø®Ø§Ù†', 2.00, 'just for testing', 0, '2024-08-16 16:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `faculty_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `faculty_name`) VALUES
(2, 'Ú‰ÙŠÙ¼Ø§Ø¨ÛŒØ³', 'Computer Science');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `quantity` decimal(20,2) NOT NULL DEFAULT 0.00,
  `price` decimal(20,2) NOT NULL DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `code`, `type`, `quantity`, `price`, `remarks`) VALUES
(2, 'Printer ', '-2', 'IT', -6.00, 5000.00, 'no remarka');

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `total_hours` int(11) NOT NULL DEFAULT 0,
  `salary` decimal(20,2) NOT NULL DEFAULT 0.00,
  `present_days` int(11) NOT NULL DEFAULT 0,
  `absent_days` int(11) NOT NULL DEFAULT 0,
  `overtime_salary` decimal(8,2) NOT NULL DEFAULT 0.00,
  `net_salary` decimal(8,2) NOT NULL DEFAULT 0.00,
  `remarks` text DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `status` enum('نا تادیه','تادیه سوی') NOT NULL DEFAULT 'نا تادیه',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payrolls`
--

INSERT INTO `payrolls` (`id`, `teacher_id`, `total_hours`, `salary`, `present_days`, `absent_days`, `overtime_salary`, `net_salary`, `remarks`, `year`, `month`, `status`, `created_at`) VALUES
(2, 2, 39, 20000.00, 30, 1, 2000.00, 22000.00, 'ad', '1403', 'Ø§Ø³Ø¯', 'نا تادیه', '2024-08-18 17:13:43');

-- --------------------------------------------------------

--
-- Table structure for table `request_items`
--

CREATE TABLE `request_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `consumer` varchar(255) DEFAULT NULL,
  `request_quantity` decimal(20,2) NOT NULL DEFAULT 0.00,
  `remarks` varchar(1000) DEFAULT NULL,
  `is_fullfilled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_items`
--

INSERT INTO `request_items` (`id`, `item_id`, `department_id`, `consumer`, `request_quantity`, `remarks`, `is_fullfilled`, `created_at`) VALUES
(2, 2, 2, 'Ø³Ù„Ø§Ù… Ø¬Ø§Ù†', 2.00, 'just for printing ', 1, '2024-08-16 10:51:53'),
(3, 2, 2, 'khan', 10.00, 'no remarks', 1, '2024-08-16 10:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `salary` decimal(20,2) NOT NULL DEFAULT 0.00,
  `status` enum('فعال','منفک') NOT NULL DEFAULT 'فعال',
  `code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `father_name`, `position`, `address`, `job`, `salary`, `status`, `code`) VALUES
(2, 'Ø³Ø¹Ø¯Ø§Ù„Ù„Ù‡ ', 'Ø®Ø§Ù† Ù…Ø­Ù…Ø¯', 'Ø¯ÙˆÙ‡Ù…', 'Ú©Ù†Ø¯Ù‡Ø§Ø±', 'Ø§Ø³ØªØ§Ø¯', 20000.00, 'فعال', 'T-5');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `treasure_id` bigint(20) UNSIGNED NOT NULL,
  `credit` decimal(20,2) NOT NULL DEFAULT 0.00,
  `debit` decimal(20,2) NOT NULL DEFAULT 0.00,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `department_id`, `account_id`, `treasure_id`, `credit`, `debit`, `remarks`, `created_at`) VALUES
(1, 2, 3, 8, 0.00, 200.00, '', '2024-08-15 18:58:51'),
(2, 2, 3, 8, 0.00, 200.00, 'debit of just\r\n', '2024-08-15 18:58:59'),
(4, 2, 3, 8, 0.00, 500.00, 'debit of expense', '2024-08-15 18:59:09'),
(5, 2, 3, 8, 0.00, 600.00, 'sad\r\nworking\r\n', '2024-08-15 18:59:14'),
(8, 2, 3, 8, 0.00, 200.00, 'no remarks', '2024-08-15 18:59:22'),
(10, 2, 5, 9, 0.00, 2000.00, 'just for test', '2024-08-20 19:12:51'),
(11, 2, 4, 8, 20000.00, 0.00, 'from no one', '2024-08-21 15:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `treasures`
--

CREATE TABLE `treasures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treasures`
--

INSERT INTO `treasures` (`id`, `name`, `balance`, `created_at`, `updated_at`) VALUES
(8, 'Ø¹Ù…ÙˆÙ…ÙŠ Ø®Ø²Ø§Ù†Ù‡', 24100.00, NULL, NULL),
(9, 'Ø¹Ù…ÙˆÙ…ÙŠ Ø¨ÙˆØ¯ÛŒØ¬ÙŠ Ø®Ø²Ø§Ù†Ù‡', 23000.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `photo`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'uploads/school.png', 'admin', NULL, '$2y$10$kVz5vjP35ZLmvTSWS5B.0ed4m/KwfUddRMYO9jQ35t2oDZT1iO8cC', NULL, '2024-07-19 01:53:16', '2024-07-19 01:53:16'),
(4, 'no name', 'non@asd.sad', 'uploads/OIP.jpeg', 'admin', NULL, '$2y$10$HGR/Ue5E5Zn4d43ZmnfgMuwbbNXgAI9AKIT8mgddoTE24hr6sJGam', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dedicated_items`
--
ALTER TABLE `dedicated_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dedicated_items_item_id_foreign` (`item_id`),
  ADD KEY `dedicated_items_department_id_foreign` (`department_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payrolls_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `request_items`
--
ALTER TABLE `request_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_items_item_id_foreign` (`item_id`),
  ADD KEY `request_items_department_id_foreign` (`department_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_department_id_foreign` (`department_id`),
  ADD KEY `transactions_account_id_foreign` (`account_id`),
  ADD KEY `transactions_treasure_id_foreign` (`treasure_id`);

--
-- Indexes for table `treasures`
--
ALTER TABLE `treasures`
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
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dedicated_items`
--
ALTER TABLE `dedicated_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `request_items`
--
ALTER TABLE `request_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `treasures`
--
ALTER TABLE `treasures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dedicated_items`
--
ALTER TABLE `dedicated_items`
  ADD CONSTRAINT `dedicated_items_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dedicated_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `request_items`
--
ALTER TABLE `request_items`
  ADD CONSTRAINT `request_items_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_treasure_id_foreign` FOREIGN KEY (`treasure_id`) REFERENCES `treasures` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

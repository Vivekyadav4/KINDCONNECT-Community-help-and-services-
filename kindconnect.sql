-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 25, 2025 at 05:01 PM
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
-- Database: `kindconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories_db`
--

CREATE TABLE `categories_db` (
  `id` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_desc` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories_db`
--

INSERT INTO `categories_db` (`id`, `slug`, `title`, `short_desc`, `description`, `image`) VALUES
(1, 'plumber', 'plumber', 'Fix leaks, unclog drains, and handle pipe emergencies.', '<p>Qualified local plumbers offering residential repairs, emergency fixes, and preventative maintenance.</p><ul><li>Leak repairs</li><li>Drain cleaning</li><li>Tap and fixture replacement</li></ul>', 'plumber_1766651580.webp'),
(2, 'grocery-shop', 'grocery-shop', 'Groceries and essentials delivered or picked up. Small grocery stores and delivery helpers that keep your pantry stocked.', NULL, 'grocery-shop_1766652935.jpg'),
(7, 'electrician', 'Electrician', 'Wiring, switches, sockets and electrical safety checks.', '<p>Certified electricians for installations, fault-finding, and safety inspections.</p><ul><li>Lighting & fan installation</li><li>Power outlet repairs</li><li>Safety testing</li></ul>', 'electrician_1766677716.webp');

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(128) DEFAULT NULL,
  `image_path` varchar(512) DEFAULT NULL,
  `doc_path` varchar(512) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `payment_status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `txn_id` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('open','accepted','cancelled','completed') DEFAULT 'open',
  `accepted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id`, `user_id`, `title`, `description`, `category`, `image_path`, `doc_path`, `contact_name`, `phone`, `address`, `payment_status`, `txn_id`, `created_at`, `status`, `accepted_by`) VALUES
(12, 10, 'fridge', 'my fridge is not cooling', 'Electrical', NULL, NULL, 'prajwal', '1245789645', 'pusesavali', 'paid', '@1234#554876', '2025-10-04 15:36:25', 'open', NULL),
(14, 10, 'tap leaking in kitchen', 'tap leaking in kitchen', 'plumber', NULL, NULL, 'prajwal', '7841810399', 'pusesavali', 'paid', '2315', '2025-10-10 22:30:00', 'open', NULL),
(15, 10, 'i need a medicine', 'i need a medicine', 'medical', NULL, NULL, 'prajwal', '7841810399', 'pusesavali', 'paid', '5555', '2025-10-10 22:36:24', 'open', NULL),
(16, 10, 'tata salt', 'i want tata salt', 'Grocery Delivery', 'uploads/1760151262_68e9c6deb4a93_download.jpeg', NULL, 'Vivek Yadav', '9421177545', 'pusesavali raut colony', 'pending', NULL, '2025-10-11 08:24:22', 'open', NULL),
(17, 16, 'basmati rice', 'I want to dilvered today  At apartment please call fastly..', 'Grocery Delivery', NULL, NULL, 'aryan', '7058250200', 'At-post Pusesawali satara india', 'paid', '1213212121', '2025-10-11 10:37:33', 'open', NULL),
(18, 17, 'my laptop is not working', 'my laptop is not working', 'Electrical', NULL, NULL, 'anurag', '9421177545', 'karad', 'paid', '12345', '2025-10-11 15:20:42', 'open', NULL),
(19, 19, 'water leakage', 'water leakage', 'plumber', NULL, NULL, 'viraj', '7058250200', 'karad', 'paid', '5555', '2025-11-16 18:51:24', 'open', NULL),
(25, 10, 'my tata sky\'s set-up box is deactivated', 'my tata sky\'s set-up box is deactivated', 'Electrical', 'uploads/1766419131_69496abb823d0_WhatsApp Image 2025-12-21 at 7.11.31 PM.jpeg', NULL, 'prajwal', '7841810399', 'my tata sky\'s set-up box is deactivated', 'pending', NULL, '2025-12-22 21:28:51', 'open', NULL),
(26, 10, 'my radio is not working', 'my radio is not working', 'Electrical', NULL, NULL, 'shreya', '7841810399', 'karad', 'pending', NULL, '2025-12-24 19:57:58', 'accepted', 22),
(27, 10, 'phone', 'phone', 'Electrical', NULL, NULL, 'prajwal', '7841810399', 'karad', 'pending', NULL, '2025-12-24 20:14:11', 'open', NULL),
(28, 10, 'i need a new table', 'i need a new table', 'Other', NULL, NULL, 'prajwal', '7841810399', 'karad', 'pending', NULL, '2025-12-25 12:05:24', 'open', NULL),
(29, 10, 'i need a stole', 'i need a stole', 'carpenter', NULL, NULL, 'prajwal', '7841810399', 'karad', 'pending', NULL, '2025-12-25 12:33:50', 'accepted', 23),
(30, 13, 'i want to buy a second hand car', 'i want to buy a second hand car', 'second hand car dealer', NULL, NULL, 'prajwal gurav', '7420881516', 'atpadi', 'pending', NULL, '2025-12-25 12:39:30', 'accepted', 24);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(128) DEFAULT NULL,
  `status` enum('open','accepted','closed','canceled') NOT NULL DEFAULT 'open',
  `accepted_by` int(10) UNSIGNED DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `image_path` varchar(512) DEFAULT NULL,
  `doc_path` varchar(512) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_acceptances`
--

CREATE TABLE `request_acceptances` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` int(10) UNSIGNED NOT NULL,
  `volunteer_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(64) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','business','volunteer','admin') NOT NULL DEFAULT 'user',
  `business_category` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `qr_code_path` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `business_category`, `created_at`, `qr_code_path`, `profile_pic`) VALUES
(9, 'vivek', 'navrangbakery1340@gmail.com', '1234567890', '$2y$10$0iRcx7uLiGoS.cqZinPx.OIuJTrulLRcFbwixljweY3VcD5Zfug8a', 'business', 'plumber', '2025-10-04 01:02:44', NULL, NULL),
(10, 'prajwal', 'pp@gmail.com', '7841810399', '$2y$10$3osgSTZMhj1AatLrJiAaOe6iV7JQ.gGvXFBuQJfh6IuEj/miJWu3.', 'user', NULL, '2025-10-04 12:25:33', NULL, NULL),
(11, 'Prajwal Pharande', 'prajwalpharande2314@gmail.com', '1245789645', '$2y$10$v.vm3sxKAUD3q1tOjQC3kePeUBCObMygjxL4kFw0YsLhltHSZUXMO', 'business', 'medical', '2025-10-04 15:19:36', NULL, 'uploads/profiles/1766522209_prajwal.jpg'),
(12, 'Anuj Yadav', 'anuj152906@gmail.com', '7058250200', '$2y$10$J0RoaCOuepW2zvS4nYdU1OOjpJ2qAydRunSYqpXym/Ao6pJLiml0O', 'business', 'Electrical', '2025-10-04 15:46:24', NULL, 'uploads/profiles/1766521593_anuj.jpeg'),
(13, 'dipak', 'prajwalpharande379@gmail.com', '7847951466', '$2y$10$oKw2nL19ho.3ihsa7cB5H.SoIHh3GVhpy8ZfVt7BBLS2jfV3DYfTi', 'user', NULL, '2025-10-10 21:14:10', NULL, NULL),
(14, 'Vivek Yadav', 'gahis84371@leabro.com', '9421177545', '$2y$10$IgX9yucq6inmUKHY1SgMFuWIQkObfuJ5wbYQo3YnWU.nU/zefvtL2', 'business', 'Grocery Delivery', '2025-10-11 08:19:08', NULL, NULL),
(15, 'vinay', 'vinay123@gmail.com', '7083808434', '$2y$10$3rHCEFKdKGgbNHxna5Hk7e2vwtJ720mKGSkILMk5GmdFkIFfR8hBq', 'business', 'Grocery Delivery', '2025-10-11 10:31:24', NULL, NULL),
(16, 'aryan', 'aryan123@gmail.com', '7083123223', '$2y$10$rMtQgsiRYIdTNKKVvo.0yOT/YFEYWMT.bS3ZXTj0HNvffyprl/JKS', 'user', NULL, '2025-10-11 10:33:26', NULL, NULL),
(17, 'anurag', 'anurag@gmail.com', '9421177549', '$2y$10$ksRuY.KPwySGcoDAr25CiOBrnFhen/UN2C7hGgNKirpSkQ035lVu.', 'user', NULL, '2025-10-11 15:19:23', NULL, NULL),
(18, 'vikas', 'vikas@gmail.com', '9875465212', '$2y$10$h1ZMNHUmeupSaYW9A11avOAoF9WvM3qlFM0Q0n4YjHNQ6miOgUeuq', 'business', 'Electrical', '2025-10-11 15:22:12', NULL, NULL),
(19, 'viraj', 'admin@gmail.com', '2589402887', '$2y$10$V7KBRnmopcdIbtcKbWZ6g.7fs/kp0Y1EIcongHcnL.nBlYphZ9J9y', 'admin', NULL, '2025-11-16 18:50:09', NULL, NULL),
(20, 'raj jadhav', 'rajjadhav@gmail.com', '7420881518', '$2y$10$0sC2mLpiZ6uEMP1Ik4BG.uAjQkNMdBxuxj3Jdqcqwh4hA6hJQ5iK.', 'business', 'Grocery Delivery', '2025-12-24 18:42:46', NULL, 'uploads/profiles/1766582115_vivek.jpeg'),
(22, 'shreya', 'shreya@gmail.com', '7841810395', '$2y$10$CVqCswXhDRs1uLBofS6WK.zhCupey7GqJGNfoX9morAYpC/5mXOVG', 'business', 'Electrical', '2025-12-24 19:56:24', NULL, 'uploads/profiles/default.png'),
(23, 'viru', 'viru@gmail.com', '1234567897', '$2y$10$ywmVzjzjrOD6EjEjZiomm.NP5SPZ42VFoBNKoogpbVIzVRW/4bOD.', 'business', 'carpenter', '2025-12-25 12:02:50', NULL, 'uploads/profiles/default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories_db`
--
ALTER TABLE `categories_db`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_problems_user_id` (`user_id`),
  ADD KEY `idx_problems_category` (`category`),
  ADD KEY `idx_problems_payment_status` (`payment_status`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_requests_user` (`user_id`),
  ADD KEY `idx_requests_status` (`status`),
  ADD KEY `fk_requests_accepted_by` (`accepted_by`);

--
-- Indexes for table `request_acceptances`
--
ALTER TABLE `request_acceptances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reqacc_request` (`request_id`),
  ADD KEY `idx_reqacc_volunteer` (`volunteer_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_users_email` (`email`),
  ADD UNIQUE KEY `uniq_users_phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories_db`
--
ALTER TABLE `categories_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_acceptances`
--
ALTER TABLE `request_acceptances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `fk_problems_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `fk_requests_accepted_by` FOREIGN KEY (`accepted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_requests_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request_acceptances`
--
ALTER TABLE `request_acceptances`
  ADD CONSTRAINT `fk_reqacc_request` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reqacc_volunteer` FOREIGN KEY (`volunteer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

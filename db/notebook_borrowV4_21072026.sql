-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2026 at 01:48 PM
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
-- Database: `notebook_borrow`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$g1xSbmRh5SxrmTz8fx6NkeLuEdbTu4K3Qzpx0p8QLkFOlZjfhYtsq', '2026-07-13 17:52:44'),
(2, 'adminwk', '$2y$10$L3KHJILscSgMN6vAT/zjG.E01YBS0AwjoABEL1fZjsrQurpVTbwsW', '2026-07-13 17:53:23');

-- --------------------------------------------------------

--
-- Table structure for table `email_otp`
--

CREATE TABLE `email_otp` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `otp` char(6) DEFAULT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_otp`
--

INSERT INTO `email_otp` (`id`, `user_id`, `otp`, `is_used`, `created_at`, `expires_at`) VALUES
(5, 7, '836598', 1, '2026-07-13 12:52:20', '2026-07-13 12:57:20'),
(6, 8, '445483', 1, '2026-07-15 17:18:48', '2026-07-15 17:23:48'),
(7, 9, '692149', 1, '2026-07-17 11:53:15', '2026-07-17 11:58:15'),
(8, 10, '229472', 0, '2026-07-17 13:59:33', '2026-07-17 14:04:33'),
(9, 11, '214540', 1, '2026-07-17 14:11:47', '2026-07-17 14:16:47'),
(10, 12, '678295', 0, '2026-07-17 14:16:15', '2026-07-17 14:21:15'),
(11, 13, '557449', 1, '2026-07-17 14:37:35', '2026-07-17 14:42:35'),
(12, 13, '852549', 1, NULL, '2026-07-17 14:57:47'),
(13, 13, '745448', 1, NULL, '2026-07-17 15:04:46'),
(14, 13, '627053', 1, NULL, '2026-07-17 15:04:47'),
(15, 13, '156700', 1, NULL, '2026-07-17 15:04:47'),
(16, 13, '841146', 1, NULL, '2026-07-17 15:04:48'),
(17, 13, '238945', 1, NULL, '2026-07-17 15:04:49'),
(18, 13, '391500', 1, NULL, '2026-07-17 15:04:51'),
(19, 13, '926209', 1, NULL, '2026-07-17 15:06:02'),
(20, 13, '895165', 1, NULL, '2026-07-17 15:06:15'),
(21, 13, '308481', 1, NULL, '2026-07-17 15:06:19'),
(22, 13, '689166', 1, NULL, '2026-07-17 15:06:27'),
(23, 13, '818933', 1, NULL, '2026-07-17 15:07:10'),
(24, 13, '427207', 1, NULL, '2026-07-17 15:07:18'),
(25, 13, '297728', 1, NULL, '2026-07-17 15:08:17'),
(26, 13, '293339', 1, NULL, '2026-07-17 15:08:17'),
(27, 13, '750699', 1, NULL, '2026-07-17 15:08:27'),
(28, 14, '340031', 1, '2026-07-17 15:12:13', '2026-07-17 15:17:13'),
(29, 14, '316050', 1, NULL, '2026-07-17 15:23:42'),
(30, 14, '793965', 1, NULL, '2026-07-17 15:27:35'),
(31, 14, '839859', 1, NULL, '2026-07-17 15:29:41'),
(32, 14, '453279', 1, NULL, '2026-07-17 15:32:55'),
(33, 14, '604118', 1, NULL, '2026-07-17 15:33:32'),
(34, 14, '948695', 1, NULL, '2026-07-17 15:37:25'),
(35, 14, '362423', 1, NULL, '2026-07-17 15:40:24'),
(36, 14, '581790', 1, NULL, '2026-07-17 15:43:59'),
(37, 15, '361762', 1, '2026-07-21 18:04:52', '2026-07-21 18:09:52'),
(38, 16, '638477', 1, '2026-07-21 18:14:38', '2026-07-21 18:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `notebook`
--

CREATE TABLE `notebook` (
  `id` int(11) NOT NULL,
  `asset_num` varchar(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `spec` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('available','pending','borrowed') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notebook`
--

INSERT INTO `notebook` (`id`, `asset_num`, `name`, `spec`, `image`, `status`) VALUES
(1, '8569-001(1-25)', 'Asus ExpertBook P1-001', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(2, '8569-001(2-25)', 'Asus ExpertBook P1-002', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(3, '8569-001(3-25)', 'Asus ExpertBook P1-003', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'borrowed'),
(4, '8569-001(4-25)', 'Asus ExpertBook P1-004', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(5, '8569-001(5-25)', 'Asus ExpertBook P1-005', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(6, '8569-001(6-25)', 'Asus ExpertBook P1-006', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(7, '8569-001(7-25)', 'Asus ExpertBook P1-007', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(8, '8569-001(8-25)', 'Asus ExpertBook P1-008', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(9, '8569-001(9-25)', 'Asus ExpertBook P1-009', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(10, '8569-001(10-25)', 'Asus ExpertBook P1-010', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(11, '8569-001(11-25)', 'Asus ExpertBook P1-011', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'borrowed'),
(12, '8569-001(12-25)', 'Asus ExpertBook P1-012', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(13, '8569-001(13-25)', 'Asus ExpertBook P1-013', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(14, '8569-001(14-25)', 'Asus ExpertBook P1-014', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(15, '8569-001(15-25)', 'Asus ExpertBook P1-015', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(16, '8569-001(16-25)', 'Asus ExpertBook P1-016', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(17, '8569-001(17-25)', 'Asus ExpertBook P1-017', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(18, '8569-001(18-25)', 'Asus ExpertBook P1-018', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(19, '8569-001(19-25)', 'Asus ExpertBook P1-019', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(20, '8569-001(20-25)', 'Asus ExpertBook P1-020', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(21, '8569-001(21-25)', 'Asus ExpertBook P1-021', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(22, '8569-001(22-25)', 'Asus ExpertBook P1-022', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(23, '8569-001(23-25)', 'Asus ExpertBook P1-023', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(24, '8569-001(24-25)', 'Asus ExpertBook P1-024', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available'),
(25, '8569-001(25-25)', 'Asus ExpertBook P1-025', 'Intel Core i5-13420H\r\n16GB DDR5 SO-DIMM\r\n512GB PCIe 4/NVMe M.2 SSD', 'notebook_6a5ed5f675318.png', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notebook_id` int(11) DEFAULT NULL,
  `borrow_time` datetime DEFAULT NULL,
  `return_time` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected','returned') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `notebook_id`, `borrow_time`, `return_time`, `approved_by`, `status`) VALUES
(24, 14, 9, NULL, NULL, NULL, 'rejected'),
(25, 14, 8, NULL, NULL, NULL, 'rejected'),
(26, 8, 1, NULL, NULL, NULL, 'rejected'),
(27, 14, 17, '2026-07-21 15:16:48', '2026-07-21 15:17:38', NULL, 'returned'),
(28, 14, 7, '2026-07-21 15:18:31', '2026-07-21 15:19:31', NULL, 'returned'),
(29, 8, 11, NULL, NULL, NULL, 'rejected'),
(30, 8, 25, '2026-07-21 15:18:32', '2026-07-21 15:19:30', NULL, 'returned'),
(31, 8, 24, NULL, NULL, NULL, 'rejected'),
(32, 14, 8, NULL, NULL, NULL, 'rejected'),
(33, 14, 1, NULL, NULL, NULL, 'rejected'),
(34, 14, 2, NULL, NULL, NULL, 'rejected'),
(38, 14, 6, NULL, NULL, NULL, 'rejected'),
(42, 14, 3, '2026-07-21 18:06:06', NULL, NULL, 'approved'),
(43, 15, 11, '2026-07-21 18:09:41', NULL, NULL, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `student_id` varchar(10) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','disabled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `student_id`, `phone`, `email`, `password`, `is_verified`, `created_at`, `status`) VALUES
(1, 'test', 'user', '6500000001', '0812345678', 'test@cmu.ac.th', '$2y$10$S5beIQnDJfRqaFAf1OxJyexrDWTkrGBNmuPILKi/FAAkbwZFFPv.u', 0, '2026-07-13 03:26:33', 'active'),
(7, 'wutipong', 'kumwong', '5304101332', '0820264394', 'wutipong.k11@cmu.ac.th', '$2y$10$W3uaY88YyMpl0EtFLaHVhuuH5mfSijtQgn88Pr5X2K4bqu3J0HZQO', 1, '2026-07-13 05:52:20', 'active'),
(8, 'pornsuda', 'saosing', '1234567899', '0871887609', 'pornsuda.s@cmu.ac.th', '$2y$10$gHUB5.kw2Sf0g99P1sco0.Rq.AXWjTumA5R4g0Pir4kvA1gAzNxqy', 1, '2026-07-15 10:18:48', 'active'),
(9, 'wutipong', 'kumwong', '5333333333', '0801234567', 'wutipong.k2@cmu.ac.th', '$2y$10$j5iEZMf7MjA7uQDG0d1rxO42Xlz6nWiPzXUA2cd.oHHIanc1Myzci', 1, '2026-07-17 04:53:15', 'active'),
(10, 'asdasd', 'asdasdas', '2465321786', '0548798565', 'wutipong.a@cmu.ac.th', '$2y$10$ms.qGAnAk2ME4/v12lNLG.B0E0xy/FLH3RaG6Wj6URzhCSGqbWqce', 0, '2026-07-17 06:59:33', 'active'),
(11, 'วุฒิพงศ์', 'คำวงค์', '5304101123', '0223456789', 'wutipong.k123@cmu.ac.th', '$2y$10$D4BG7A2ijLPNunnUeu3sf.QIFP20ovfIU/0695BjJk5P4Aa/YHuUm', 1, '2026-07-17 07:11:47', 'active'),
(12, 'ฟฟฟฟฟฟฟฟฟ', 'ฟฟฟฟฟฟฟฟฟฟฟฟฟฟ', '3444444444', '4442222222', 'wutipong.k5@cmu.ac.th', '$2y$10$5x8Lda8M4pVk8ZIIkEvra.wcRkQ1Wv4hjvuYS5QA.KGn/ygqEtV2.', 0, '2026-07-17 07:16:15', 'active'),
(13, 'wutipong5', 'kumwong5', '1456678954', '1546789654', 'wutipong.k6@cmu.ac.th', '$2y$10$J2gBR21c.ClteV5vg0LIk..sAXFOCLpXnmKbsuW.B/DyIRvbXEkOa', 1, '2026-07-17 07:37:35', 'active'),
(14, 'wutipong6', 'kumwong6', '5448765487', '4563245779', 'wutipong.k7@cmu.ac.th', '$2y$10$S1AW/nTER17LyhPnd1jjs.EhT9kuh5OgzkCkDHvsrgYaBbY46LLMK', 1, '2026-07-17 08:12:13', 'active'),
(15, 'วุฒิพงศ์ 08', 'คำวงค์', '6504101383', '0820264394', 'wutipong.k8@cmu.ac.th', '$2y$10$.MnM.nlWCi5NQGKwxWoHQuM4GxRpBXstd5w2FaANgDNaN06.G.TEC', 1, '2026-07-21 11:04:52', 'active'),
(16, 'wutipong09', 'kumwong', '6604101383', '0846487961', 'wutipong.k@cmu.ac.th', '$2y$10$9wOQU11016Q4TEJIXE1gWuWL0VBnC.UUCdNVvUCiQV/uQihdmRSLy', 1, '2026-07-21 11:14:38', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_otp`
--
ALTER TABLE `email_otp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notebook`
--
ALTER TABLE `notebook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `notebook_id` (`notebook_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `email_otp`
--
ALTER TABLE `email_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `notebook`
--
ALTER TABLE `notebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `email_otp`
--
ALTER TABLE `email_otp`
  ADD CONSTRAINT `email_otp_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`notebook_id`) REFERENCES `notebook` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

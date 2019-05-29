-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2019 at 08:58 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `mbr_companies`
--

CREATE TABLE `mbr_companies` (
  `id` int(10) NOT NULL,
  `company_name` varchar(191) NOT NULL,
  `company_size` varchar(191) NOT NULL,
  `company_email` varchar(191) NOT NULL,
  `company_key` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mbr_companies`
--

INSERT INTO `mbr_companies` (`id`, `company_name`, `company_size`, `company_email`, `company_key`, `created_at`, `updated_at`) VALUES
(6, 'Beta codings', 'more', 'info@betacodings.com', '5ce982926772d', '2019-05-25 22:59:46', '2019-05-25 22:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `mbr_contacts`
--

CREATE TABLE `mbr_contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mbr_contacts`
--

INSERT INTO `mbr_contacts` (`id`, `user_id`, `contact_id`, `status`, `last_activity`, `created_at`, `updated_at`) VALUES
(4, '1', '2', '0', '2019-05-25 10:19:55', '2019-05-25 21:01:37', '2019-05-25 22:19:55'),
(7, '1', '4', '0', '2019-05-26 18:02:16', '2019-05-25 21:35:14', '2019-05-27 06:02:16'),
(8, '2', '3', '0', '2019-05-25 09:38:17', '2019-05-25 21:38:17', '2019-05-25 21:38:17'),
(9, '2', '4', '0', '2019-05-25 09:38:44', '2019-05-25 21:38:39', '2019-05-25 21:38:44'),
(10, '2', '5', '0', '2019-05-25 11:54:54', '2019-05-25 23:10:33', '2019-05-25 23:54:54'),
(11, '3', '19', '0', '2019-05-26 17:12:42', '2019-05-27 05:12:32', '2019-05-27 05:12:42'),
(12, '1', '19', '0', '2019-05-26 18:03:23', '2019-05-27 05:29:33', '2019-05-27 06:03:23'),
(13, '4', '19', '0', '2019-05-26 17:50:19', '2019-05-27 05:50:19', '2019-05-27 05:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `mbr_groups_members`
--

CREATE TABLE `mbr_groups_members` (
  `id` int(10) NOT NULL,
  `group_id` varchar(191) NOT NULL,
  `user_id` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mbr_groups_members`
--

INSERT INTO `mbr_groups_members` (`id`, `group_id`, `user_id`, `created_at`, `updated_at`) VALUES
(12, '18', '3', '2019-05-27 05:05:15', '2019-05-27 05:05:15'),
(13, '19', '3', '2019-05-27 05:11:49', '2019-05-27 05:11:49'),
(14, '20', '3', '2019-05-27 05:12:07', '2019-05-27 05:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `mbr_messages`
--

CREATE TABLE `mbr_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `from_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `to_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_seen_by_me` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted_by_me` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `is_deleted` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `images` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mbr_messages`
--

INSERT INTO `mbr_messages` (`id`, `from_id`, `to_id`, `is_seen_by_me`, `is_deleted_by_me`, `status`, `is_deleted`, `message`, `created_at`, `updated_at`, `images`) VALUES
(78, '1', '2', '1', '0', 1, '0', 'hello boss', '2019-05-25 21:01:37', '2019-05-25 21:01:37', ''),
(79, '1', '2', '1', '0', 1, '0', 'Image', '2019-05-25 21:01:49', '2019-05-25 21:01:49', 'uploaded/messages/png_files/5ce966ed0d9a94.45054245.png'),
(80, '2', '4', '1', '0', 1, '0', 'hi', '2019-05-25 21:09:29', '2019-05-25 23:32:32', ''),
(81, '2', '4', '1', '0', 1, '0', 'hi', '2019-05-25 21:09:37', '2019-05-25 23:32:32', ''),
(82, '2', '3', '1', '0', 1, '0', 'hi', '2019-05-25 21:09:42', '2019-05-26 22:39:44', ''),
(83, '1', '4', '1', '0', 1, '0', 'hi', '2019-05-25 21:17:56', '2019-05-25 21:25:19', ''),
(84, '1', '2', '1', '0', 1, '0', 'sir', '2019-05-25 21:22:39', '2019-05-25 21:22:40', ''),
(85, '2', '1', '1', '0', 1, '0', 'hi', '2019-05-25 21:23:04', '2019-05-25 21:23:08', ''),
(86, '1', '4', '1', '0', 1, '0', 'hello', '2019-05-25 21:24:42', '2019-05-25 21:25:19', ''),
(87, '1', '4', '1', '0', 1, '0', 'sir', '2019-05-25 21:32:27', '2019-05-25 21:35:43', ''),
(88, '1', '4', '1', '0', 1, '0', 'ok sir', '2019-05-25 21:32:40', '2019-05-25 21:35:43', ''),
(89, '1', '4', '1', '0', 1, '0', 'boss', '2019-05-25 21:35:14', '2019-05-25 21:35:43', ''),
(90, '1', '4', '1', '0', 1, '0', 'sir', '2019-05-25 21:35:26', '2019-05-25 21:35:43', ''),
(91, '4', '1', '1', '0', 1, '0', 'hi', '2019-05-25 21:35:44', '2019-05-25 21:35:45', ''),
(92, '1', '4', '1', '0', 1, '0', 'ok', '2019-05-25 21:36:20', '2019-05-25 21:36:23', ''),
(93, '1', '2', '1', '0', 1, '0', 'ko', '2019-05-25 21:37:44', '2019-05-25 21:37:46', ''),
(94, '2', '3', '1', '0', 1, '0', 'hi', '2019-05-25 21:38:17', '2019-05-26 22:39:44', ''),
(95, '2', '4', '1', '0', 1, '0', 'h', '2019-05-25 21:38:39', '2019-05-25 23:32:32', ''),
(96, '2', '4', '1', '0', 1, '0', 'hhh', '2019-05-25 21:38:45', '2019-05-25 23:32:32', ''),
(97, '1', '2', '1', '0', 1, '0', 'Check this link sir ', '2019-05-25 21:49:21', '2019-05-25 21:49:21', ''),
(98, '1', '2', '1', '0', 1, '0', 'https://chat.betacodings.com/company_registration', '2019-05-25 21:49:25', '2019-05-25 21:49:26', ''),
(99, '1', '2', '1', '0', 1, '0', 'This will be the default link for the register', '2019-05-25 22:19:53', '2019-05-25 22:19:56', ''),
(100, '1', '2', '1', '0', 1, '0', 'https://chat.betacodings.com/dashboard/register', '2019-05-25 22:19:55', '2019-05-25 22:19:56', ''),
(101, '2', '5', '1', '0', 1, '0', 'hi', '2019-05-25 23:10:33', '2019-05-25 23:21:24', ''),
(102, '5', '2', '1', '0', 1, '0', 'k', '2019-05-25 23:21:34', '2019-05-25 23:21:35', 'uploaded/messages/jpg_files/5ce987ae032f49.78784743.jpg'),
(103, '5', '2', '1', '0', 1, '0', 'li', '2019-05-25 23:54:54', '2019-05-25 23:54:56', 'uploaded/messages/php_files/5ce98f7e680a39.52215284.txt'),
(104, '4', '1', '1', '0', 1, '0', 'k', '2019-05-25 23:57:23', '2019-05-26 02:33:08', 'uploaded/messages/php_files/5ce99013b6fc50.07206710.txt'),
(105, '4', '1', '1', '0', 1, '0', 'ok', '2019-05-26 00:15:26', '2019-05-26 02:33:08', 'uploaded/messages/php_files/php.--5ce9944e59e1f3.67788992.txt'),
(106, '1', '4', '1', '0', 1, '0', 'Oc', '2019-05-26 02:33:27', '2019-05-27 05:49:58', ''),
(107, '1', '4', '1', '0', 1, '0', 'hi', '2019-05-26 20:57:01', '2019-05-27 05:49:58', ''),
(108, '1', '4', '1', '0', 1, '0', 'okArrayC:\\xampp\\tmp\\php7981.tmp', '2019-05-26 22:04:03', '2019-05-27 05:49:58', 'uploaded/messages/jpg_files\\5cea9cd38c2b20.16369869.jpg'),
(109, '1', '4', '1', '0', 1, '0', 'image fileArray504.jpg', '2019-05-26 22:05:18', '2019-05-27 05:49:59', 'uploaded/messages/jpg_files\\5cea9d1e91e396.21240455.jpg'),
(110, '1', '4', '1', '0', 1, '0', 'see now<i class=\"icon-tmp\"></i>&nbsp;&nbsp;504.jpg', '2019-05-26 22:05:54', '2019-05-27 05:49:59', 'uploaded/messages/jpg_files\\5cea9d429c87b8.91538628.jpg'),
(111, '1', '4', '1', '0', 1, '0', '.<i class=\"icon-tmp\"></i>&nbsp;&nbsp;C:\\xampp\\tmp\\php300A.tmp', '2019-05-26 22:10:17', '2019-05-27 05:49:59', 'uploaded/messages/png_files\\5cea9e49afcba4.48739367.png'),
(112, '1', '4', '1', '0', 1, '0', 'boss', '2019-05-26 22:10:41', '2019-05-27 05:49:59', ''),
(113, '1', '4', '1', '0', 1, '0', 'see the file<br /><i class=\"icon-tmp\"></i>&nbsp;&nbsp;504.PNG', '2019-05-26 22:11:10', '2019-05-27 05:49:59', 'uploaded/messages/png_files\\5cea9e7e5efb15.38480862.png'),
(114, '1', '4', '1', '0', 1, '0', 'file<br /><br /><i class=\"icon-tmp\"></i>&nbsp;&nbsp;index.php', '2019-05-26 22:12:39', '2019-05-27 05:49:59', 'uploaded/messages/php_files\\5cea9ed7291677.46771088.php'),
(115, '1', '4', '1', '0', 1, '0', ' <br /><br /><i class=\"icon-tmp\"></i>&nbsp;&nbsp;chatbot.PNG', '2019-05-27 04:56:31', '2019-05-27 05:49:59', 'uploaded/messages/png_files\\5ceafd7fa910a7.09237818.png'),
(116, '1', '4', '1', '0', 1, '0', '..<br /><br />', '2019-05-27 04:56:34', '2019-05-27 05:50:00', ''),
(117, '1', '4', '1', '0', 1, '0', '.m<br /><br /><i class=\"icon-tmp\"></i>&nbsp;&nbsp;bottask.PNG', '2019-05-27 04:56:59', '2019-05-27 05:50:00', 'uploaded/messages/png_files\\5ceafd9bcf1537.94675709.png'),
(118, '3', '19', '0', '0', 1, '0', 'hi<br /><br />', '2019-05-27 05:12:32', '2019-05-27 05:12:32', ''),
(119, '3', '19', '0', '0', 1, '0', 'see this.<br /><br /><i class=\"icon-tmp\"></i>&nbsp;&nbsp;chatbot2.PNG', '2019-05-27 05:12:42', '2019-05-27 05:12:42', 'uploaded/messages/png_files\\5ceb014ac09515.25994924.png'),
(120, '1', '19', '0', '0', 1, '0', 'boss<br /><br />', '2019-05-27 05:29:33', '2019-05-27 05:29:33', ''),
(121, '1', '4', '1', '0', 1, '0', 'hi<br /><br />', '2019-05-27 05:47:45', '2019-05-27 05:50:00', ''),
(122, '4', '1', '1', '0', 1, '0', 'hello<br /><br />', '2019-05-27 05:49:57', '2019-05-27 06:02:00', ''),
(123, '4', '19', '0', '0', 1, '0', 'hi<br /><br />', '2019-05-27 05:50:19', '2019-05-27 05:50:19', ''),
(124, '1', '19', '0', '0', 1, '0', 'hello<br /><br />', '2019-05-27 06:02:02', '2019-05-27 06:02:02', ''),
(125, '1', '4', '1', '0', 1, '0', 'boss<br /><br />', '2019-05-27 06:02:16', '2019-05-27 06:02:35', ''),
(126, '1', '19', '0', '0', 1, '0', 'boss<br /><br />', '2019-05-27 06:03:23', '2019-05-27 06:03:23', '');

-- --------------------------------------------------------

--
-- Table structure for table `mbr_users`
--

CREATE TABLE `mbr_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'profiles/avatar.png',
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_online` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mbr_users`
--

INSERT INTO `mbr_users` (`id`, `username`, `password_`, `status`, `user_role`, `email`, `created_at`, `updated_at`, `first_name`, `last_name`, `bio`, `profile_picture`, `gender`, `last_online`, `company_id`, `type`) VALUES
(1, 'admin', '$2y$12$h5suJ1l.U659n0zJVMdxhuveF5hggWPmelGXc3uNafxPpmejMDldq', '0', '4', 'admin@mrbarnk.com', '2019-05-24 22:09:26', '2019-05-27 14:58:06', '', '', 'I am a very handsome boy.', 'uploaded/profiles/png_files/5ce971ee92c740.95053519.png', NULL, '2019-05-27 14:58:06', '5ce982926772d', 'user'),
(2, 'emmamartins', '$2y$12$dvImaPNY5EtV08jryjTkM.FtxZlxKuJFC1VFKB/Ojb/SsZWFLJ3p2', '0', '1', 'emmamartinscm@gmail.com', '2019-05-25 00:34:46', '2019-05-26 08:21:23', 'Emmanuel', 'Martins', '', 'profiles/avatar.png', NULL, '2019-05-26 08:21:23', '5ce982926772d', 'user'),
(3, 'mrbarnk', '$2y$12$3lNlOnr/nfIHreFwDFCVGeggF6yJ19uJzBuhOFoYBpEtcTxlVGFUi', '0', '4', 'mrbarnk1@gmail.com', '2019-05-25 02:46:35', '2019-05-27 05:48:11', NULL, NULL, NULL, 'profiles/avatar.png', NULL, '2019-05-26 17:48:11', '5ce982926772d', 'user'),
(4, 'test1', '$2y$12$zThFty3UsLRToT.mU1c5ZOgmPTeBvikz2LxpT6v0yxwbFK8RYhQzS', '0', '5', 'test1@gmail.com', '2019-05-25 16:23:16', '2019-05-27 08:48:32', NULL, NULL, NULL, 'profiles/avatar.png', NULL, '2019-05-27 08:48:32', '5ce982926772d', 'user'),
(5, 'Hypersoci', '$2y$12$f0uEGXQU1KJJ3DetA3uJDudFCDtLZT9W/xq36aItC1kRpGa2OGuMy', '0', NULL, 'Hello@hypersoci.com.ng', '2019-05-25 23:07:47', '2019-05-26 00:17:43', NULL, NULL, NULL, 'profiles/avatar.png', NULL, '2019-05-25 12:17:43', '5ce982926772d', 'user'),
(19, 'New Group', '$2y$12$3lNlOnr/nfIHreFwDFCVGeggF6yJ19uJzBuhOFoYBpEtcTxlVGFUi', '0', NULL, '5ceb011597335@gmail.com', '2019-05-27 05:11:49', '2019-05-27 05:11:49', NULL, NULL, NULL, 'uploaded/groups/png_files\\5ceb0115975852.33383746.png', NULL, '2019-05-26 21:11:49', '5ce982926772d', 'group'),
(20, 'New Group', '$2y$12$3lNlOnr/nfIHreFwDFCVGeggF6yJ19uJzBuhOFoYBpEtcTxlVGFUi', '0', NULL, '5ceb0126df140@gmail.com', '2019-05-27 05:12:07', '2019-05-27 05:12:07', NULL, NULL, NULL, 'uploaded/groups/png_files\\5ceb0126df3771.04193302.png', NULL, '2019-05-26 21:12:07', '5ce982926772d', 'group');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mbr_companies`
--
ALTER TABLE `mbr_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mbr_contacts`
--
ALTER TABLE `mbr_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_id_index` (`id`);

--
-- Indexes for table `mbr_groups_members`
--
ALTER TABLE `mbr_groups_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mbr_messages`
--
ALTER TABLE `mbr_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_id_index` (`id`);

--
-- Indexes for table `mbr_users`
--
ALTER TABLE `mbr_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_index` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mbr_companies`
--
ALTER TABLE `mbr_companies`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mbr_contacts`
--
ALTER TABLE `mbr_contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mbr_groups_members`
--
ALTER TABLE `mbr_groups_members`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `mbr_messages`
--
ALTER TABLE `mbr_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `mbr_users`
--
ALTER TABLE `mbr_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

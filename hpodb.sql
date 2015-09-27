-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2015 at 03:44 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hpodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ask_permission`
--

CREATE TABLE IF NOT EXISTS `ask_permission` (
  `ask_id` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `permission_lvl` int(11) NOT NULL,
  `form_type` int(11) NOT NULL,
  `id_form` int(11) NOT NULL,
  `permission` int(11) NOT NULL,
  `reason` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `department_name` varchar(255) NOT NULL,
`department_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_name`, `department_id`) VALUES
('Human Resource', 1),
('QA', 2),
('System Administration', 3),
('Web Development', 4);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
`position_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `department_id`, `position_name`) VALUES
(1, 1, 'Administrator'),
(2, 3, 'System Administrator'),
(3, 4, 'Web Developer'),
(5, 1, 'Secretary');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chgschd`
--

CREATE TABLE IF NOT EXISTS `tbl_chgschd` (
  `chgschd_id` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `department` int(11) NOT NULL,
  `date_from` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_to` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shift_from` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shift_to` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reason` text NOT NULL,
  `permission_1` int(11) NOT NULL,
  `permission_2` int(11) NOT NULL,
  `permission_3` int(11) NOT NULL,
  `permission_4` int(11) NOT NULL,
  `permission_id1` int(11) NOT NULL,
  `permission_id2` int(11) NOT NULL,
  `permission_id3` int(11) NOT NULL,
  `permission_id4` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `form_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_epform`
--

CREATE TABLE IF NOT EXISTS `tbl_epform` (
  `tbl_epid` int(11) NOT NULL,
  `dateCreated` date NOT NULL,
  `dateFrom` date NOT NULL,
  `dateTo` date DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `textPurpose` text NOT NULL,
  `permission_id1` int(11) NOT NULL,
  `permission_id2` int(11) NOT NULL,
  `permission_id3` int(11) NOT NULL,
  `permission_id4` int(11) NOT NULL,
  `permission_1` int(11) NOT NULL,
  `permission_2` int(11) NOT NULL,
  `permission_3` int(11) NOT NULL,
  `permission_4` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `form_type` int(11) NOT NULL,
  `dateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_epform`
--

INSERT INTO `tbl_epform` (`tbl_epid`, `dateCreated`, `dateFrom`, `dateTo`, `department_id`, `textPurpose`, `permission_id1`, `permission_id2`, `permission_id3`, `permission_id4`, `permission_1`, `permission_2`, `permission_3`, `permission_4`, `status`, `form_type`, `dateUpdated`, `user_id`) VALUES
(13, '2015-09-24', '2015-09-25', '2015-09-26', 0, 'asdasd', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-09-23 23:39:29', 2),
(14, '2015-09-24', '2015-09-24', '2015-09-25', 0, 'asd', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-09-23 23:42:58', 2),
(15, '2015-09-24', '2015-09-24', '2015-09-26', 0, 'asdas', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-09-23 23:44:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_form`
--

CREATE TABLE IF NOT EXISTS `tbl_form` (
  `form_type` int(11) NOT NULL,
  `form_name` text NOT NULL,
  `created_at` date NOT NULL,
  `form_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave`
--

CREATE TABLE IF NOT EXISTS `tbl_leave` (
  `tbl_leaveid` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `leave_type` int(11) NOT NULL,
  `reason` text NOT NULL,
  `permission_1` int(11) NOT NULL,
  `permission_2` int(11) NOT NULL,
  `permission_id1` int(11) NOT NULL,
  `permission_id2` int(11) NOT NULL,
  `entitlement` int(11) NOT NULL,
  `date_taken` int(11) NOT NULL,
  `date_applied` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_leave`
--

INSERT INTO `tbl_leave` (`tbl_leaveid`, `username`, `date_created`, `leave_type`, `reason`, `permission_1`, `permission_2`, `permission_id1`, `permission_id2`, `entitlement`, `date_taken`, `date_applied`, `status`) VALUES
(2, 0, '2015-09-24', 0, '123123', 0, 0, 0, 0, 0, 0, 0, 0),
(6, 2, '2015-09-24', 0, 'asdasd', 0, 0, 0, 0, 0, 0, 0, 0),
(7, 2, '2015-09-24', 0, 'asdasd', 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_oas`
--

CREATE TABLE IF NOT EXISTS `tbl_oas` (
`tbl_oasid` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `department` int(11) NOT NULL,
  `form_type` int(11) NOT NULL,
  `reason` text NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_oas`
--

INSERT INTO `tbl_oas` (`tbl_oasid`, `username`, `date_created`, `department`, `form_type`, `reason`, `client_id`) VALUES
(1, 5, '2015-09-25', 0, 0, 'asdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdfasdasdgsdfadsgasdfadsgasdfasdgasdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `emp_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` int(255) NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `emp_name`, `position_id`, `email`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(9, 'Admin', 1, 'admin@example', 10001, '$2a$10$iQSZ/1atpmgn/jyFF0GsceILd4n8FGdi2P2YIuMwyULRo8BRvp7jG', 'iFEtA2okns2ryIiYI2Bd7miLgbd5iWib9OjJJzzNLb7Ui3KmC8Dbgit7W8Ry', '0000-00-00 00:00:00', '2015-09-25 22:38:50'),
(11, 'Erwin Mark Añora', 1, 'bananasapientum@gmail.com', 1200289, '$2y$10$kzUxbLaNjmB39Q4El0kgzedUTEtBKwQ7UjcE3VFK8limz.VvUYe.W', 'D500jZp6KuRTK0jNYG4w6jIglmo2UrFphnhAbmZscadMazICnS5ZMx8iaBZF', '2015-09-25 22:38:39', '2015-09-27 08:23:40'),
(12, 'Test Dummy', 2, '12@gmail.com', 1200300, '$2y$10$99GzB5BaQTtwAfkTl9zb2Oips/G77zlto1t8JgMJX2WQAony6Qpr6', 'yZYcthIBsJ4eRDSgqFKwyWAlZT4LKl2kBCcY1Mij64giWyKDBb8xARd6YY5x', '2015-09-27 08:23:37', '2015-09-27 08:24:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
 ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
 ADD KEY `password_resets_email_index` (`email`), ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
 ADD PRIMARY KEY (`position_id`), ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `tbl_oas`
--
ALTER TABLE `tbl_oas`
 ADD PRIMARY KEY (`tbl_oasid`), ADD FULLTEXT KEY `reason` (`reason`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `users_username_unique` (`username`), ADD KEY `position_id` (`position_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_oas`
--
ALTER TABLE `tbl_oas`
MODIFY `tbl_oasid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `position`
--
ALTER TABLE `position`
ADD CONSTRAINT `position_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `position` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

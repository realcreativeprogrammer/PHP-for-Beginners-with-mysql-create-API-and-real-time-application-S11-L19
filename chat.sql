-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2022 at 04:37 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `senderid` int(11) NOT NULL,
  `text` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `senderid`, `text`, `time`) VALUES
(2, 27, 'first daataaaa', '2022-06-27 12:06:26'),
(3, 27, 'sadsadsad', '2022-06-27 12:35:11'),
(4, 6, 'send', '2022-06-27 12:38:07'),
(5, 27, 're', '2022-06-27 12:43:31'),
(6, 27, 'ddddd', '2022-06-27 12:44:27'),
(7, 27, 'hi', '2022-06-27 12:58:48'),
(8, 27, 'sssssss', '2022-06-27 13:03:13'),
(9, 27, 'dasdsadsad', '2022-06-27 13:03:43'),
(10, 27, 'check', '2022-06-27 13:04:29'),
(11, 27, 'dsfsdfdsfds', '2022-06-27 13:04:37'),
(12, 6, 'dfsdfsdfdsf', '2022-06-27 13:04:41'),
(13, 6, 'rgdgdgdg', '2022-06-27 13:05:04'),
(14, 27, 'wewewew', '2022-06-27 13:24:32'),
(15, 27, 'erere', '2022-06-27 13:25:05'),
(16, 6, 'ewrewr', '2022-06-27 13:25:34'),
(17, 27, 'retertert', '2022-06-27 13:25:43'),
(18, 27, 'sdfdsfdsfd', '2022-06-27 13:34:08'),
(19, 27, 'gdfgdf', '2022-06-27 13:46:10'),
(20, 27, 'fhghfg', '2022-06-27 13:47:12'),
(21, 27, 'check', '2022-06-27 13:49:51'),
(22, 6, 'hi', '2022-06-27 13:50:01'),
(23, 6, 'hi', '2022-06-27 13:50:12'),
(24, 27, 'fdsf', '2022-06-27 13:50:34'),
(25, 6, 'yryrt', '2022-06-27 13:50:52'),
(26, 6, 'tertert', '2022-06-27 13:51:46'),
(27, 27, 'dgdfg', '2022-06-27 13:51:55'),
(28, 6, 'tyrt', '2022-06-27 13:52:20'),
(29, 6, 'retrete', '2022-06-27 13:55:20'),
(30, 27, 'rtyrt', '2022-06-27 13:55:41'),
(31, 6, 'czxcz', '2022-06-27 13:55:48'),
(32, 27, 'ghf', '2022-06-27 13:58:14'),
(34, 27, 'hgfhf', '2022-06-27 14:04:34'),
(35, 27, 'sadsada', '2022-06-27 14:07:02'),
(36, 6, 'dasdsa', '2022-06-27 14:07:09'),
(37, 27, 'saddas', '2022-06-27 14:08:06'),
(38, 6, 'asdsadsa', '2022-06-27 14:08:11'),
(39, 27, 'dfgdfgfd', '2022-06-27 14:09:05'),
(40, 27, 'gdfgdf', '2022-06-27 14:11:10'),
(41, 27, 'adsdsa', '2022-06-27 14:11:44'),
(42, 6, 'fdsfs', '2022-06-27 14:13:15'),
(43, 27, 'tyryrt', '2022-06-27 14:13:47'),
(44, 6, 'fsdfsdf', '2022-06-27 14:13:54'),
(45, 27, 'sfdfsdf', '2022-06-27 14:14:38'),
(46, 6, 'gfdgdf', '2022-06-27 14:14:43'),
(47, 6, 'fsdfds', '2022-06-27 14:15:23'),
(48, 6, 'saddsa', '2022-06-27 14:15:58'),
(49, 6, 'hi', '2022-06-27 14:16:26'),
(50, 27, 'hdsadsa', '2022-06-27 14:16:35'),
(51, 27, 'gdfgdf', '2022-06-27 14:16:54'),
(52, 27, 'fgdgd', '2022-06-27 14:17:53'),
(53, 6, 'hjgjhgj', '2022-06-27 14:18:10'),
(54, 27, 'fsdfd', '2022-06-27 14:20:33'),
(55, 27, 'dfgdfgf', '2022-06-27 14:20:59'),
(56, 27, 'dfdsfdsf', '2022-06-27 14:21:33'),
(57, 6, 'sss', '2022-06-27 14:30:09'),
(58, 27, 'dfdsfds', '2022-06-27 14:30:47'),
(59, 6, 'fsdfds', '2022-06-27 14:30:50'),
(60, 28, 'hi', '2022-06-27 14:32:28');

-- --------------------------------------------------------

--
-- Table structure for table `pictureprofile`
--

CREATE TABLE `pictureprofile` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT './images/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pictureprofile`
--

INSERT INTO `pictureprofile` (`id`, `userid`, `path`) VALUES
(1, 6, 'images/6_admin.png'),
(18, 23, './images/default.png'),
(19, 24, './images/default.png'),
(20, 25, './images/default.png'),
(21, 26, './images/default.png'),
(22, 27, 'images/27_1234.png'),
(23, 28, './images/default.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`) VALUES
(5, 'fsdfds@fdsfds.com', 'f82caf65b481bce79a68fe76b88a0ee032205caf1bae23f1e51eb8395cadd86d', 'fsd'),
(6, 'admin@admin.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'adminn'),
(23, 'deeeasdas@dsadsad', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'deeeasdas@dsadsad'),
(24, 'deseeasdas@dsadsad', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'deseeasdas@dsadsad'),
(25, 'dasaaadas@dsadsad', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'dasaaadas@dsadsad'),
(26, 'dwasdas@dsadsad', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '12345'),
(27, 'daaawasdas@dsadsad', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '12345'),
(28, 'adminnnn@admin.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usermessages` (`senderid`);

--
-- Indexes for table `pictureprofile`
--
ALTER TABLE `pictureprofile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `pictureprofile`
--
ALTER TABLE `pictureprofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `usermessages` FOREIGN KEY (`senderid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pictureprofile`
--
ALTER TABLE `pictureprofile`
  ADD CONSTRAINT `userpic` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

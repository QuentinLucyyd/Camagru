-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 02, 2018 at 10:06 PM
-- Server version: 5.6.32
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camagru`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `ID` int(255) NOT NULL,
  `user` varchar(256) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ID`, `user`, `date`, `comment`, `image`, `user_id`) VALUES
(1, 'QKotsedi', '2017-12-16 11:52:48', 'Nice Picture Man', '2', 4),
(2, 'QKotsedi', '2017-12-19 12:29:09', 'Nose too Big', '2', 4),
(3, 'QKotsedi', '2017-12-19 12:29:30', 'I personaly Don\'t like it', '2', 4),
(4, 'QKotsedi', '2017-12-20 10:36:10', 'True, It\'s Kinda !!', '3', 4),
(5, 'KotsediMan', '2017-12-20 10:39:12', 'True Man , Kinda Cool', '3', 6);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `ID` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `file_name` text NOT NULL,
  `user` varchar(250) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_id` text NOT NULL,
  `caption` text NOT NULL,
  `likes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`ID`, `user_id`, `file_name`, `user`, `post_date`, `comment_id`, `caption`, `likes`) VALUES
(2, 4, 'saved_images/QKotsedi04-49-56am.jpg', 'QKotsedi', '2017-12-15 12:50:01', '', 'Boi', '4*5*6*'),
(3, 4, 'saved_images/QKotsedi02-34-26am.jpg', 'QKotsedi', '2017-12-20 10:34:33', '', 'Yeah Dope Pic Boi', '4*6*'),
(4, 6, 'saved_images/KotsediMan02-38-44am.jpg', 'KotsediMan', '2017-12-20 10:38:49', '', 'Nice Boii', '');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `ID` int(255) NOT NULL,
  `user` varchar(256) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_name` varchar(15) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `profile_image` varchar(500) NOT NULL DEFAULT 'http://s3.amazonaws.com/37assets/svn/765-default-avatar.png',
  `joining_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirm_check` text NOT NULL,
  `password_verify` text NOT NULL,
  `email_pref` varchar(7) NOT NULL DEFAULT 'true'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `user_name`, `user_email`, `user_pass`, `profile_image`, `joining_date`, `confirm_check`, `password_verify`, `email_pref`) VALUES
(4, 'Quinton', 'Manamela', 'QKotsedi', 'qkotsedi@gmail.com', '$2y$10$3yj1zo1PIMPaqSuiR.ZSY.FGbW3.yI1ffPfWWugPfHQaANNfPsZI2', 'uploads/21150056_1446015232180079_1189323505886374566_n.jpg', '2017-12-15 12:49:06', 'true', '', 'true'),
(5, 'Kotsedi', 'Manamela', 'qkiller', 'quintonacid@gmail.com', '$2y$10$PxDnHTNB7G08YWghPUg.cO8dfYeuQluGaLTPseeaJmOq7g.IyWyNy', 'http://s3.amazonaws.com/37assets/svn/765-default-avatar.png', '2017-12-15 12:52:49', 'true', '', 'true'),
(6, 'Kotsedo', 'Manamela', 'KotsediMan', 'fruitystone@gmail.com', '$2y$10$26hypiCeIB/jnNSNI41FSuCR4UUCH3ng9Y2jf1X1Lv2E9oHFiZeFq', 'http://s3.amazonaws.com/37assets/svn/765-default-avatar.png', '2017-12-20 10:37:14', 'true', '', 'true');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

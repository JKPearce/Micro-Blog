-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 26, 2018 at 01:22 AM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+10:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Add new user into database
--
-- GRANT SELECT, INSERT, UPDATE, DELETE
-- 	ON assignment1.*
-- 	TO 'assignment1User'@'localhost'
-- 	IDENTIFIED BY 'uXURCyzZaHHrm7f0';

--
-- Database: `assignment1`
--
DROP DATABASE IF EXISTS `assignment1`;
CREATE DATABASE IF NOT EXISTS `assignment1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `assignment1`;

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

DROP TABLE IF EXISTS `follow`;
CREATE TABLE IF NOT EXISTS `follow` (
  `user_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`follower_id`),
  KEY `follow_ibfk_3` (`follower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`user_id`, `follower_id`) VALUES
(2, 1),
(6, 1),
(1, 2),
(1, 5),
(1, 6),
(4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_date` datetime NOT NULL,
  `in_reply_to` int(11) DEFAULT NULL,
  `text` varchar(160) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `in_reply_to` (`in_reply_to`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `post_date`, `in_reply_to`, `text`) VALUES
(1, 1, '2018-04-19 14:14:37', NULL, 'this is my first post! Hello world '),
(2, 2, '2018-04-21 11:20:14', 1, 'Hello! This is also my first Reply!'),
(3, 6, '2018-04-11 13:59:08', NULL, 'I just joined this site, this is my first post, hello!'),
(4, 5, '2018-04-17 14:34:32', 3, 'Welcome to the site, nice to see new faces'),
(5, 1, '2018-04-16 11:06:14', NULL, 'The quick brown fox jumped over the lazy dog'),
(6, 4, '2018-04-17 13:22:17', 5, 'What if the dog was not lazy? would the fox still be able to jump over the dog?');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(1, '30332405', 'blocka97@hotmail.com', '$2y$10$k7IK52GOq8iVmSw.yiuzfOujdfQhe9F8g78Eef5uwIBFn8iAJOB2u '),
(2, 'Jesse', 'Jesse@hotmail.com', '$2y$10$k7IK52GOq8iVmSw.yiuzfOujdfQhe9F8g78Eef5uwIBFn8iAJOB2u '),
(4, 'Matthew', 'Matthew@live.com', '$2y$10$k7IK52GOq8iVmSw.yiuzfOujdfQhe9F8g78Eef5uwIBFn8iAJOB2u '),
(5, 'Jacob', 'Jacob@gmail.com', '$2y$10$k7IK52GOq8iVmSw.yiuzfOujdfQhe9F8g78Eef5uwIBFn8iAJOB2u '),
(6, 'Nathan', 'Nathan@hotmail.com', '$2y$10$k7IK52GOq8iVmSw.yiuzfOujdfQhe9F8g78Eef5uwIBFn8iAJOB2u '),
(7, 'tutor', 'tutor@email.com', '$2y$10$eIcwKYXDiSKWaAx3zia2quuNczso4w7Ten6aSFajo9Q8W4BvBvyiS ');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `follow_ibfk_3` FOREIGN KEY (`follower_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`in_reply_to`) REFERENCES `post` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

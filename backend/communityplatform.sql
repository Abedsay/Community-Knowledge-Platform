-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Feb 07, 2025 at 01:48 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `communityplatform`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `CategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(100) NOT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `CommentId` int(11) NOT NULL AUTO_INCREMENT,
  `Content` text NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `PostId` int(11) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`CommentId`),
  KEY `UserId` (`UserId`),
  KEY `PostId` (`PostId`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentId`, `Content`, `UserId`, `PostId`, `CreatedAt`) VALUES
(6, 'popp', 6, 17, '2025-02-06 02:45:46'),
(11, 'ww', 8, 18, '2025-02-06 03:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `postcategories`
--

DROP TABLE IF EXISTS `postcategories`;
CREATE TABLE IF NOT EXISTS `postcategories` (
  `PostId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  PRIMARY KEY (`PostId`,`CategoryId`),
  KEY `CategoryId` (`CategoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `PostId` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PostId`),
  KEY `UserId` (`UserId`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostId`, `Title`, `Description`, `UserId`, `CreatedAt`, `UpdatedAt`) VALUES
(2, 'Test Post', 'This is a sample post for testing.', 1, '2025-02-05 14:13:05', NULL),
(3, 'How to Fix a Memory Leak in C++', 'A guide on identifying and fixing memory leaks in C++ applications.', NULL, '2025-02-05 14:30:32', NULL),
(4, 'Best Practices for RESTful APIs', 'Learn about designing scalable and efficient REST APIs.', NULL, '2025-02-05 14:30:32', NULL),
(5, 'Top 10 JavaScript Tips for Beginners', 'Some useful JavaScript tricks to improve your coding skills.', NULL, '2025-02-05 14:30:32', NULL),
(6, 'Understanding Docker and Containers', 'An introduction to Docker and how it simplifies deployment.', NULL, '2025-02-05 14:30:32', NULL),
(7, 'Debugging Python Code Like a Pro', 'Advanced debugging techniques for Python developers.', NULL, '2025-02-05 14:30:32', NULL),
(8, 'Version Control with Git', 'How to use Git effectively in your projects.', NULL, '2025-02-05 14:30:32', NULL),
(9, 'CSS Grid vs. Flexbox', 'A comparison of two popular CSS layout techniques.', NULL, '2025-02-05 14:30:32', NULL),
(10, 'Optimizing React Performance', 'Ways to improve performance in React applications.', NULL, '2025-02-05 14:30:32', NULL),
(11, 'Getting Started with Machine Learning', 'Introduction to ML concepts and how to build a simple model.', NULL, '2025-02-05 14:30:32', NULL),
(12, 'Introduction to SQL Joins', 'A beginner-friendly explanation of different types of joins in SQL.', NULL, '2025-02-05 14:30:32', NULL),
(13, 'Understanding Asynchronous JavaScript and Promises', 'JavaScript is a single-threaded language, meaning it executes one line of code at a time. However, asynchronous programming allows JavaScript to handle multiple tasks without blocking the main thread. Promises are a powerful way to manage asynchronous operations. A Promise represents a value that may be available now, or in the future, or never. Promises have three states: pending, fulfilled, and rejected. By chaining .then() and .catch(), we can handle success and errors effectively. Additionally, async/await provides a cleaner way to work with promises, making asynchronous code look more synchronous. Understanding these concepts is crucial for working with modern web applications, handling API calls, and improving performance in JavaScript applications.', NULL, '2025-02-05 14:50:20', NULL),
(18, '123', 'aaa', 8, '2025-02-06 03:33:28', '2025-02-06 03:33:39'),
(17, 'www', 'wwwwww', 6, '2025-02-06 02:04:18', NULL),
(19, 'ww', 'ww', 6, '2025-02-07 03:35:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `RoleId` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(50) NOT NULL,
  PRIMARY KEY (`RoleId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RoleId` int(11) DEFAULT NULL,
  `ReputationPoints` int(11) DEFAULT '0',
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Email` (`Email`),
  KEY `RoleId` (`RoleId`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `Username`, `Email`, `Password`, `RoleId`, `ReputationPoints`) VALUES
(9, 'Ibrahim', '123@gmail.com', '$2y$10$t/rA8J7BAcnbQYvQU4VJZ.g8p.1jIQJRlM7ISOxfkpgxfpDFjQrkC', 2, 0),
(5, 'TestUser', 'test@example.com', '$2y$10$WfZwt4FY./PkMvwF/Ded8uBfM/uI9s/k1AsrCA6/imYVQxyMAswiK', 2, 0),
(8, 'Abedsay', 'nope@gmail.com', '$2y$10$vlmzSJAYoC7sNhssURxbw.ElFIm/lrOyi0GF8WiieRR6g.2Kz2lpG', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `VoteId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) DEFAULT NULL,
  `PostId` int(11) DEFAULT NULL,
  `VoteType` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`VoteId`),
  KEY `UserId` (`UserId`),
  KEY `PostId` (`PostId`)
) ;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`VoteId`, `UserId`, `PostId`, `VoteType`) VALUES
(12, 6, 17, 'upvote'),
(11, 6, 13, 'upvote'),
(10, 6, 16, 'upvote'),
(9, 6, 16, 'upvote'),
(13, 6, 13, 'downvote'),
(14, 6, 17, 'upvote'),
(15, 6, 17, 'downvote'),
(16, 6, 17, 'downvote'),
(17, 8, 5, 'upvote'),
(18, 8, 8, 'downvote'),
(19, 8, 10, 'upvote'),
(20, 8, 10, 'upvote'),
(21, 8, 11, 'downvote'),
(22, 8, 9, 'upvote'),
(23, 8, 9, 'upvote'),
(24, 8, 9, 'upvote'),
(25, 8, 9, 'upvote'),
(26, 8, 9, 'upvote'),
(27, 8, 18, 'upvote'),
(28, 6, 13, 'upvote'),
(29, 6, 13, 'downvote'),
(30, 6, 13, 'downvote'),
(31, 6, 4, 'downvote'),
(32, 8, 19, 'upvote'),
(33, 8, 18, 'upvote'),
(34, 8, 18, 'downvote');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

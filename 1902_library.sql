-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2019 at 10:29 PM
-- Server version: 5.7.27-0ubuntu0.16.04.1
-- PHP Version: 7.0.33-8+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `1902_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `_id` tinyint(6) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`_id`, `name`) VALUES
(1, 'test author'),
(2, 'Roald Dahl');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `_id` tinyint(6) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `year` year(4) NOT NULL,
  `author_id` tinyint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`_id`, `title`, `description`, `year`, `author_id`) VALUES
(1, 'test book', 'This is the description of our test book that is supposed to be great', 2002, 1),
(2, 'Charlie and the chocolate factory', 'Hello this is a random description so dont take it seriously', 2002, 1),
(4, 'Hello this is a test', 'Hello this is a random description so dont take it seriously', 2002, 1),
(5, 'Testing book', 'fasdfjasfljsfl;s fsl;kjs fl;sjf sflkj ;slj lks;j f', 2001, 1),
(6, 'asdfa', 'asdfasfasdffasfsafsadfasdfasfsafsadfsafsafd', 2002, 1),
(7, 'asdfasdfsadf', 'asdfsadfsafdsadfsadfasfas', 2002, 1);

-- --------------------------------------------------------

--
-- Table structure for table `directors`
--

CREATE TABLE `directors` (
  `_id` tinyint(6) NOT NULL,
  `director` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `_id` tinyint(6) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `year` year(4) NOT NULL,
  `duration` tinyint(3) NOT NULL,
  `director_id` tinyint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `director_id` (`director_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `_id` tinyint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `_id` tinyint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `directors`
--
ALTER TABLE `directors`
  MODIFY `_id` tinyint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `_id` tinyint(6) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`_id`) ON UPDATE CASCADE;

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`director_id`) REFERENCES `directors` (`_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

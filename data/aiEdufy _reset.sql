-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 04, 2024 at 07:52 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aiEdufy`
--

-- --------------------------------------------------------

--
-- Table structure for table `ADMIN`
--

CREATE TABLE `ADMIN` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ADMIN`
--

INSERT INTO `ADMIN` (`id`, `email`, `password`) VALUES
(1000, 'admin@edufy.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `COMPLETED_QUESTIONS`
--

CREATE TABLE `COMPLETED_QUESTIONS` (
  `learner_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `QUESTIONS`
--

CREATE TABLE `QUESTIONS` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` enum('easy','medium','hard') NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `TEST_CASES`
--

CREATE TABLE `TEST_CASES` (
  `id` int(11) NOT NULL,
  `input` varchar(255) NOT NULL,
  `output` varchar(255) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
  `id` int(11) NOT NULL,
  `profile_image` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('learner','mentor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `COMPLETED_QUESTIONS`
--
ALTER TABLE `COMPLETED_QUESTIONS`
  ADD KEY `learner_id` (`learner_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `QUESTIONS`
--
ALTER TABLE `QUESTIONS`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentor_id` (`mentor_id`);

--
-- Indexes for table `TEST_CASES`
--
ALTER TABLE `TEST_CASES`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ADMIN`
--
ALTER TABLE `ADMIN`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `QUESTIONS`
--
ALTER TABLE `QUESTIONS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `TEST_CASES`
--
ALTER TABLE `TEST_CASES`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `COMPLETED_QUESTIONS`
--
ALTER TABLE `COMPLETED_QUESTIONS`
  ADD CONSTRAINT `COMPLETED_QUESTIONS_ibfk_1` FOREIGN KEY (`learner_id`) REFERENCES `USERS` (`id`),
  ADD CONSTRAINT `COMPLETED_QUESTIONS_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `QUESTIONS` (`id`);

--
-- Constraints for table `QUESTIONS`
--
ALTER TABLE `QUESTIONS`
  ADD CONSTRAINT `QUESTIONS_ibfk_1` FOREIGN KEY (`mentor_id`) REFERENCES `USERS` (`id`);

--
-- Constraints for table `TEST_CASES`
--
ALTER TABLE `TEST_CASES`
  ADD CONSTRAINT `TEST_CASES_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `QUESTIONS` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

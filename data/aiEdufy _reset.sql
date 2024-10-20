-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 20, 2024 at 09:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `question_id` int(11) NOT NULL,
  `answer` mediumtext NOT NULL,
  `language` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LEADER_BOARD`
--

CREATE TABLE `LEADER_BOARD` (
  `learner_id` int(11) NOT NULL,
  `points_earned` int(11) NOT NULL,
  `level_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LEVELS`
--

CREATE TABLE `LEVELS` (
  `id` int(11) NOT NULL,
  `level_title` varchar(255) NOT NULL,
  `points_required` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `LEVELS`
--

INSERT INTO `LEVELS` (`id`, `level_title`, `points_required`) VALUES
(1, 'Beginner 👶', 0),
(2, 'Novice 🥈', 100),
(3, 'Intermediate 🥉', 250),
(4, 'Advanced 🎖️', 500),
(5, 'Expert 🏆', 1000);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TEST_CASES`
--

CREATE TABLE `TEST_CASES` (
  `id` int(11) NOT NULL,
  `input` varchar(255) NOT NULL,
  `output` varchar(255) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
  `id` int(11) NOT NULL,
  `profile_image` mediumtext DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('learner','mentor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `LEADER_BOARD`
--
ALTER TABLE `LEADER_BOARD`
  ADD PRIMARY KEY (`learner_id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `LEVELS`
--
ALTER TABLE `LEVELS`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `LEVELS`
--
ALTER TABLE `LEVELS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `QUESTIONS`
--
ALTER TABLE `QUESTIONS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1010;

--
-- AUTO_INCREMENT for table `TEST_CASES`
--
ALTER TABLE `TEST_CASES`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1010;

--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

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
-- Constraints for table `LEADER_BOARD`
--
ALTER TABLE `LEADER_BOARD`
  ADD CONSTRAINT `LEADER_BOARD_ibfk_1` FOREIGN KEY (`learner_id`) REFERENCES `USERS` (`id`),
  ADD CONSTRAINT `LEADER_BOARD_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `LEVELS` (`id`);

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

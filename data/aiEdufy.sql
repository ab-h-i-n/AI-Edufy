-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 02, 2025 at 06:19 PM
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
-- Database: `aiEdufy`
--

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

--
-- Dumping data for table `COMPLETED_QUESTIONS`
--

INSERT INTO `COMPLETED_QUESTIONS` (`learner_id`, `question_id`, `answer`, `language`) VALUES
(1009, 1002, 'input = \"hello\"\n\nrev = input[::-1]\n\nif(rev == input):\n  print(\"True\")\nelse:\n  print(\"False\")', 'python'),
(1009, 1008, 'input = -12\n\nif(input < 0):\n  print(\"Negative\")\nelse:\n  print(\"Positive\")', 'python'),
(1011, 1001, 'input = 4\n\nif(input%2 == 0):\n  print(\"Even\")\nelse:\n  print(\"Odd\")', 'python');

-- --------------------------------------------------------

--
-- Table structure for table `LEADER_BOARD`
--

CREATE TABLE `LEADER_BOARD` (
  `learner_id` int(11) NOT NULL,
  `points_earned` int(11) NOT NULL,
  `level_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `LEADER_BOARD`
--

INSERT INTO `LEADER_BOARD` (`learner_id`, `points_earned`, `level_id`) VALUES
(1009, 30, 4),
(1011, 10, 4);

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
(4, 'Beginner👶', 0),
(5, '🚀 Intermediate', 200),
(6, '🌟 Skilled', 400),
(7, '🔥 Advanced', 600),
(8, '👑 Pro', 800),
(9, '💀Legend', 1000);

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

--
-- Dumping data for table `QUESTIONS`
--

INSERT INTO `QUESTIONS` (`id`, `title`, `description`, `type`, `mentor_id`, `points`) VALUES
(1001, ' Find Even or Odd', 'Write a program that takes an integer input from the user and checks whether it is even or odd.\n', 'easy', 1007, 10),
(1002, 'Check for Palindrome String', 'Write a program that checks if a given string is a palindrome. A palindrome is a word, phrase, or sequence that reads the same backward as forward (ignoring spaces, punctuation, and case).', 'medium', 1007, 20),
(1003, ' Longest Substring Without Repeating Characters', 'Write a program to find the length of the longest substring of a given string that does not contain repeating characters.', 'hard', 1007, 50),
(1004, 'Sum of Numbers', 'Write a program that takes a list of numbers as input and calculates the sum of all the numbers in the list.', 'easy', 1008, 10),
(1005, 'Find the Second Largest Number in a List', 'Write a program that finds the second largest number in a list. You should handle cases where all numbers are the same or where the list has fewer than two unique numbers.', 'medium', 1008, 20),
(1006, 'Find All Triplets That Sum to Zero', 'Write a program that takes an array of integers as input and finds all unique triplets in the array that sum to zero.', 'hard', 1008, 50),
(1007, 'Reverse a String', 'Write a program that takes a string as input and outputs the reversed version of the string.', 'easy', 1007, 10),
(1008, 'Check Positive or Negative Number', 'Write a program that takes an integer input from the user and checks if it is positive, negative, or zero.', 'easy', 1008, 10);

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

--
-- Dumping data for table `TEST_CASES`
--

INSERT INTO `TEST_CASES` (`id`, `input`, `output`, `question_id`) VALUES
(1001, '4', 'Even', 1001),
(1003, '5', 'Odd', 1001),
(1004, 'madam', 'True', 1002),
(1005, 'hello', 'False', 1002),
(1006, 'abcabcbb', '3 (abc)', 1003),
(1007, 'bbbbb', '1(b)', 1003),
(1008, '[1, 2, 3, 4]', '10', 1004),
(1009, '[5, 10, 15]', '30', 1004),
(1010, '[10, 20, 4, 45, 99]', '45', 1005),
(1011, '[-1, 0, 1, 2, -1, -4]', '[[-1, -1, 2], [-1, 0, 1]]', 1006),
(1012, '[1, 2, 3]', '[]', 1006),
(1013, 'hello', 'olleh', 1007),
(1014, '12', 'Positive', 1008);

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
  `id` int(11) NOT NULL,
  `profile_image` mediumblob DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('learner','mentor','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`id`, `profile_image`, `name`, `email`, `password`, `role`) VALUES
(1006, '', 'Admin', 'admin@edufy.com', '$2y$10$lhX11qnRx6G.G.BvFO2FWOvC2iJmaba3EOHqPS86xaU7RVyflS1vG', 'admin'),
(1007, '', 'mentor', 'mentor@edufy.com', '$2y$10$BQtTC19StE7.fpxlr1ZxVOl/9xjaSIKHy14GGrpSTx24X9Qmn94Rq', 'mentor'),
(1008, '', 'mentor1', 'mentor1@edufy.com', '$2y$10$rjeGIfbzvlm1YqGyi/5.t.4lVSK7/okmWBjr0J9/34cyIRpIlIdee', 'mentor'),
(1009, '', 'learner', 'learner@edufy.com', '$2y$10$zUh6R5qASLIC3w4DR0SYR.JsJnl18CwNGu4Jq.D1C9uYJ8IiJoVn.', 'learner'),
(1011, '', 'learner1', 'learner1@edufy.com', '$2y$10$sGw9BwWQRjUS99u0C9/cUuw1HjgqCM6pCEviXawjqq3oWi6to4qim', 'learner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `COMPLETED_QUESTIONS`
--
ALTER TABLE `COMPLETED_QUESTIONS`
  ADD UNIQUE KEY `learner_id` (`learner_id`,`question_id`),
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
-- AUTO_INCREMENT for table `LEVELS`
--
ALTER TABLE `LEVELS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `QUESTIONS`
--
ALTER TABLE `QUESTIONS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

--
-- AUTO_INCREMENT for table `TEST_CASES`
--
ALTER TABLE `TEST_CASES`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1015;

--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;

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
  ADD CONSTRAINT `LEADER_BOARD_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `LEVELS` (`id`),
  ADD CONSTRAINT `LEADER_BOARD_ibfk_2` FOREIGN KEY (`learner_id`) REFERENCES `USERS` (`id`);

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

-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 02, 2021 at 04:33 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `saisNumber` int(11) NOT NULL,
  `courseCode` text NOT NULL,
  `comment_text` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`saisNumber`, `courseCode`, `comment_text`, `date`) VALUES
(123456, 'MATH10', 'This course is great because it teaches you the foundations of mathematical thinking, namely how to write rigorous and concise proofs. I really enjoyed the course and would recommend it to a friend.', '2021-05-30'),
(849621, 'SCI10', 'I love this course. It was very helpful for me. Thank you.', '2021-05-30'),
(849621, 'PHI10', 'It was alright. I wouldn\'t mind doing that again.', '2021-05-30'),
(849621, 'MATH10', 'I disagree on the greatness of this course. It is not representative of the greater whole of the world of maths. Therefore, it is not great. Thank you for coming to my TED talk.', '2021-05-31'),
(586342, 'PHI10', 'I agree it was a good course.', '2021-05-31'),
(586342, 'MATH10', 'This is good', '2021-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `courseName` text NOT NULL,
  `courseCode` text NOT NULL,
  `professorName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `courseName`, `courseCode`, `professorName`) VALUES
(1, 'Math 10', 'MATH10', 'Lizzy Uy'),
(2, 'Math 10', 'MATH10', 'Jilly Salazar'),
(3, 'Science 10', 'SCI10', 'Manny Piche'),
(4, 'History 10', 'HIS10', 'Jason Militante'),
(5, 'Science 10', 'SCI10', 'Dominic Rubiya'),
(6, 'English 10', 'ENG10', 'Willy Bengco'),
(7, 'Linear Models', 'STAT176', 'Reymond Jimop'),
(8, 'Philosophy 10', 'PHI10', 'Doctor Barry');

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `studentNumber` text NOT NULL,
  `courseCode` text NOT NULL,
  `professorCode` text NOT NULL,
  `profEval` longtext NOT NULL,
  `courseEval` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`studentNumber`, `courseCode`, `professorCode`, `profEval`, `courseEval`) VALUES
('2021-12345', 'MATH10', 'PROF1', '1,2,3,4,5,4,3,2,3,4,3,4,5,3,4,PPT,more PPT', '4,4,5,5,5,5'),
('2021-78596', 'MATH10', 'PROF2', '5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,Flash mob,Yes', '5,2,5,5,5,5'),
('2021-12345', 'SCI10', 'PROF3', '1,2,3,4,5,4,3,2,3,4,3,4,5,3,4,PPT,more PPT', '4,4,5,5,5,5'),
('2021-12345', 'HIS10', 'PROF4', '1,2,3,4,5,4,3,2,4,4,2,4,2,4,3,PPT ,PPT', '4,5,4,3,4,4'),
('2021-12345', 'PHI10', 'PROF8', '1,2,3,4,5,3,2,2,3,4,3,4,5,2,4,PPT,PPT MORE', '4,4,4,3,3,3'),
('2021-12345', 'STAT176', 'PROF7', '1,2,3,4,5,4,3,2,2,3,4,5,4,3,3,PPT,PPT MORE', '4,4,4,4,4,4'),
('2021-78596', 'STAT176', 'PROF7', '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,None,It takes time, gasoline, and matches', '5,3,4,5,3,1'),
('2021-45678', 'PHI10', 'PROF8', '4,5,4,5,5,4,5,5,5,4,5,5,4,5,4,Class Debates,None', '4,5,4,5,4,4'),
('2021-78596', 'SCI10', 'PROF3', '2,3,4,5,4,3,4,5,3,2,2,3,4,5,2,PPT ,PPT MORE', '4,4,3,4,3,4'),
('2021-78596', 'PHI10', 'PROF8', '1,1,2,2,1,1,2,0,1,1,2,2,1,1,2,Powerpoint,Powerpoint moree', '5,1,1,2,2,4'),
('2021-45678', 'MATH10', 'PROF1', '4,4,3,5,4,4,3,5,5,4,4,5,4,4,3,none,none', '4,4,4,3,4,4'),
('2021-45678', 'ENG10', 'PROF6', '5,4,5,4,5,5,4,5,5,5,4,5,5,4,5,PPT,More videos', '4,5,4,5,4,5');

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors` (
  `professorName` text NOT NULL,
  `professorCode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `professors`
--

INSERT INTO `professors` (`professorName`, `professorCode`) VALUES
('Lizzy Uy', 'PROF1'),
('Jilly Salazar', 'PROF2'),
('Manny Piche', 'PROF3'),
('Jason Militante', 'PROF4'),
('Dominic Rubiya', 'PROF5'),
('Willy Bengco', 'PROF6'),
('Reymond Jimop', 'PROF7'),
('Doctor Barry', 'PROF8');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `email` text NOT NULL,
  `nickname` varchar(15) NOT NULL,
  `studentName` text NOT NULL,
  `studentNumber` text NOT NULL,
  `saisNumber` int(11) NOT NULL,
  `college` text NOT NULL,
  `degree` text NOT NULL,
  `year` text NOT NULL,
  `courses` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `evaluations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`email`, `nickname`, `studentName`, `studentNumber`, `saisNumber`, `college`, `degree`, `year`, `courses`, `evaluations`) VALUES
('jdelacruz@up.edu.ph', 'Juan', 'Juan Dela Cruz', '2021-12345', 123456, 'College of Arts and Sciences', 'BS Computer Science', '3rd Year', '1,3,4,7,8', '-1,-3,-4,-7,-8'),
('varthur@up.edu.ph', 'Vincent', 'Vincent Allan Arthur', '2021-45678', 586342, 'College of Arts and Sciences', 'BS Applied Physics', '3rd Year', '1,4,5,6,8', '-1,4,5,-6,-8'),
('hsalsedo@up.edu.ph', 'Hel', 'Helena Salsedo', '2021-78596', 849621, 'College of Arts and Sciences', 'BS Biology', '3rd Year', '2,3,6,7,8', '-2,-3,6,-7,-8');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `user_id`, `email`, `password`) VALUES
(1, 2469875, 'admin@up.edu.ph', 'adminlife'),
(29, 5589144, 'jdelacruz@up.edu.ph', 'qwerty'),
(30, 6506150, 'varthur@up.edu.ph', 'letmein'),
(31, 9245446, 'hsalsedo@up.edu.ph', 'sheesh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

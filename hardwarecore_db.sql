-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2025 at 02:54 AM
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
-- Database: `hardwarecore_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(255) NOT NULL,
  `admin_id` varchar(255) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `admin_id`, `admin_username`, `admin_password`) VALUES
(1, 'ADMIN-001', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_classroom`
--

CREATE TABLE `tbl_classroom` (
  `id` int(11) NOT NULL,
  `classroom_id` varchar(255) NOT NULL,
  `classroom_title` varchar(255) NOT NULL,
  `classroom_description` varchar(255) NOT NULL,
  `instructor_id_fk` varchar(255) NOT NULL,
  `isActive` varchar(255) NOT NULL,
  `created_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_classroom`
--

INSERT INTO `tbl_classroom` (`id`, `classroom_id`, `classroom_title`, `classroom_description`, `instructor_id_fk`, `isActive`, `created_date`) VALUES
(1, 'CLASSROOM-001', 'Programming', 'dummy', 'INSTRUCTOR-001', 'true', '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_classroom_student`
--

CREATE TABLE `tbl_classroom_student` (
  `id` int(255) NOT NULL,
  `classroom_id_fk` varchar(255) NOT NULL,
  `student_id_fk` varchar(255) NOT NULL,
  `instructor_id_fk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_instructor`
--

CREATE TABLE `tbl_instructor` (
  `id` int(255) NOT NULL,
  `instructor_id` varchar(255) NOT NULL,
  `instructor_username` varchar(255) NOT NULL,
  `instructor_password` varchar(255) NOT NULL,
  `instructor_fullname` varchar(255) NOT NULL,
  `isApproved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_instructor`
--

INSERT INTO `tbl_instructor` (`id`, `instructor_id`, `instructor_username`, `instructor_password`, `instructor_fullname`, `isApproved`) VALUES
(1, 'INSTRUCTOR-001', 'instructor', 'instructor', 'John Doep', 1),
(2, 'INSTRUCTOR-3595029', 'asdsa', '$2y$10$EZP7olMTxKucDoNikpI11OOCn1pvJNt6meVLa8WIXNkU1rwtxbDK2', 'asd', 2),
(3, 'INSTRUCTOR-6442393', 'test', '$2y$10$nf8ASRk0KR1c/sL8KAG/tu7h.mNx1xshaTVfMbKnx5g97B0t73jmS', 'test', 0),
(4, 'INSTRUCTOR-5817880', 'test1', '$2y$10$TdqJ0Z9Rin0r3S4QoozqSetq/PXk1RNjGNs4pLYlW4qXWqstKR1iK', 'test1', 1),
(5, 'INSTRUCTOR-1872681', 's', '$2y$10$wEpq25geKhu2GeVSdfK8.OjKW6ADFqpzlm6nWly9Oy7TW6gZVV5bG', 's', 2),
(6, 'INSTRUCTOR-4665909', 'asdf', '$2y$10$OS9LRb2oIx3N2Pv3gtDLb.iC4qt23xt2jtiIVTkcF4rJtSQbx1gtq', 'asdf', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_questions`
--

CREATE TABLE `tbl_questions` (
  `id` int(255) NOT NULL,
  `quiz_id_fk` varchar(255) NOT NULL,
  `question_id` varchar(255) NOT NULL,
  `classroom_id_fk` varchar(255) NOT NULL,
  `question_type` varchar(255) NOT NULL,
  `question_description` varchar(255) NOT NULL,
  `question_imagepath` varchar(255) NOT NULL,
  `isMultipleChoice` varchar(255) NOT NULL,
  `isEnumeration` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `a` varchar(255) NOT NULL,
  `b` varchar(255) NOT NULL,
  `c` varchar(255) NOT NULL,
  `d` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_questions`
--

INSERT INTO `tbl_questions` (`id`, `quiz_id_fk`, `question_id`, `classroom_id_fk`, `question_type`, `question_description`, `question_imagepath`, `isMultipleChoice`, `isEnumeration`, `answer`, `a`, `b`, `c`, `d`) VALUES
(2, 'QUIZ-001', 'QUIZ-001-1', 'CLASSROOM-001', 'enumeration', 'dummy', 'image.png', 'false', 'dummy', 'dummy', 'dummy', 'dummy', 'dummy', 'dummy');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz`
--

CREATE TABLE `tbl_quiz` (
  `id` int(255) NOT NULL,
  `quiz_id` varchar(255) NOT NULL,
  `quiz_title` varchar(255) NOT NULL,
  `quiz_description` varchar(255) NOT NULL,
  `instructor_id_fk` varchar(255) NOT NULL,
  `classroom_id_fk` varchar(255) NOT NULL,
  `isActive` varchar(255) NOT NULL,
  `created_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_quiz`
--

INSERT INTO `tbl_quiz` (`id`, `quiz_id`, `quiz_title`, `quiz_description`, `instructor_id_fk`, `classroom_id_fk`, `isActive`, `created_date`) VALUES
(1, 'QUIZ-001', 'dummy', 'dummy', 'INSTRUCTOR-001', 'CLASSROOM-001', 'true', '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_score`
--

CREATE TABLE `tbl_score` (
  `id` int(255) NOT NULL,
  `score_id` varchar(255) NOT NULL,
  `classroom_id_fk` varchar(255) NOT NULL,
  `quiz_id_fk` varchar(255) NOT NULL,
  `student_id_fk` varchar(255) NOT NULL,
  `score` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_score`
--

INSERT INTO `tbl_score` (`id`, `score_id`, `classroom_id_fk`, `quiz_id_fk`, `student_id_fk`, `score`) VALUES
(1, 'SCORE-001', 'CLASSROOM-001', 'QUIZ-001', 'STUDENT-2012341', 50);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `id` int(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `student_username` varchar(255) NOT NULL,
  `student_password` varchar(255) NOT NULL,
  `student_fullname` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `student_id`, `student_username`, `student_password`, `student_fullname`, `created_date`) VALUES
(2, 'STUDENT-3861072', 'asd', '$2y$10$5.VdYb3FMrbQ6635qlQPE.XSaxV.VPeD7XqC5vo85IzEl37WBQ47O', 'asd', '2025-02-21 01:07:14'),
(3, 'STUDENT-3525082', 'test', '$2y$10$XGtQrig9ddQepGCPWEQDoObCxcrCef9w9shzuxT3ZzXjVj8ff9cli', 'test', '2025-02-21 01:08:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_id` (`admin_id`);

--
-- Indexes for table `tbl_classroom`
--
ALTER TABLE `tbl_classroom`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `classroom_id` (`classroom_id`),
  ADD KEY `instructor_id_fk` (`instructor_id_fk`),
  ADD KEY `classroom_id_2` (`classroom_id`);

--
-- Indexes for table `tbl_classroom_student`
--
ALTER TABLE `tbl_classroom_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classroom_id_fk` (`classroom_id_fk`),
  ADD KEY `student_id_fk` (`student_id_fk`),
  ADD KEY `instructor_id_fk` (`instructor_id_fk`),
  ADD KEY `instructor_id_fk_2` (`instructor_id_fk`);

--
-- Indexes for table `tbl_instructor`
--
ALTER TABLE `tbl_instructor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `instructor_id` (`instructor_id`),
  ADD KEY `instructor_id_2` (`instructor_id`);

--
-- Indexes for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `question_id_2` (`question_id`),
  ADD KEY `quiz_id_fk` (`quiz_id_fk`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `classroom_id_fk` (`classroom_id_fk`);

--
-- Indexes for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quiz_id` (`quiz_id`),
  ADD KEY `instructor_id_fk` (`instructor_id_fk`),
  ADD KEY `classroom_id_fk` (`classroom_id_fk`),
  ADD KEY `instructor_id_fk_2` (`instructor_id_fk`),
  ADD KEY `classroom_id_fk_2` (`classroom_id_fk`);

--
-- Indexes for table `tbl_score`
--
ALTER TABLE `tbl_score`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `score_id` (`score_id`),
  ADD KEY `classroom_id_fk` (`classroom_id_fk`),
  ADD KEY `quiz_id_fk` (`quiz_id_fk`),
  ADD KEY `student_id_fk` (`student_id_fk`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_classroom`
--
ALTER TABLE `tbl_classroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_classroom_student`
--
ALTER TABLE `tbl_classroom_student`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_instructor`
--
ALTER TABLE `tbl_instructor`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_score`
--
ALTER TABLE `tbl_score`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_classroom`
--
ALTER TABLE `tbl_classroom`
  ADD CONSTRAINT `instructor` FOREIGN KEY (`instructor_id_fk`) REFERENCES `tbl_instructor` (`instructor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_classroom_student`
--
ALTER TABLE `tbl_classroom_student`
  ADD CONSTRAINT `classroom` FOREIGN KEY (`classroom_id_fk`) REFERENCES `tbl_classroom` (`classroom_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `instructorss` FOREIGN KEY (`instructor_id_fk`) REFERENCES `tbl_instructor` (`instructor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student` FOREIGN KEY (`student_id_fk`) REFERENCES `tbl_student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  ADD CONSTRAINT `clasroom` FOREIGN KEY (`classroom_id_fk`) REFERENCES `tbl_classroom` (`classroom_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz` FOREIGN KEY (`quiz_id_fk`) REFERENCES `tbl_quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

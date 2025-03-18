-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2025 at 01:20 AM
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
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `code` varchar(255) NOT NULL,
  `created_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_classroom`
--

INSERT INTO `tbl_classroom` (`id`, `classroom_id`, `classroom_title`, `classroom_description`, `instructor_id_fk`, `isActive`, `code`, `created_date`) VALUES
(2, 'CLASSROOM-251995', 'Test', 'my new clasrrom', 'INSTRUCTOR-7821556', 1, 'LA6V5FC9', '2025-03-01 00:08:13.000000'),
(3, 'CLASSROOM-953133', 'Programming 1', 'this subject is to enchance your capabilities in programmings', 'INSTRUCTOR-7821556', 0, '9DOR5WEY', '2025-03-01 00:11:49.000000'),
(4, 'CLASSROOM-122083', 'Classroom 1', 'bsit 3', 'INSTRUCTOR-7821556', 0, '7QIDX0RC', '2025-03-01 00:25:21.000000'),
(5, 'CLASSROOM-725541', 'CSS 1s', 'Enhance Designing ', 'INSTRUCTOR-7821556', 1, 'UL2HQMEY', '2025-03-01 02:55:12.000000'),
(6, 'CLASSROOM-858963', 'Programming 1', 'enchance logical', 'INSTRUCTOR-4211462', 1, 'DWV32HNP', '2025-03-12 23:49:10.000000'),
(7, 'CLASSROOM-894315', 'Programming 1B', 'test', 'INSTRUCTOR-4211462', 1, 'WGKLP047', '2025-03-12 23:59:37.000000'),
(8, 'CLASSROOM-276479', 'Ethics', 'philosophy\r\n', 'INSTRUCTOR-6442393', 0, '7FXI2EQO', '2025-03-13 00:01:25.000000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_classroom_student`
--

CREATE TABLE `tbl_classroom_student` (
  `id` int(255) NOT NULL,
  `classroom_id_fk` varchar(255) NOT NULL,
  `student_id_fk` varchar(255) NOT NULL,
  `instructor_id_fk` varchar(255) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_classroom_student`
--

INSERT INTO `tbl_classroom_student` (`id`, `classroom_id_fk`, `student_id_fk`, `instructor_id_fk`, `approved`) VALUES
(3, 'CLASSROOM-251995', 'STUDENT-3525082', 'INSTRUCTOR-7821556', 1),
(4, 'CLASSROOM-725541', 'STUDENT-3525082', 'INSTRUCTOR-7821556', 1),
(5, 'CLASSROOM-725541', 'STUDENT-6011989', 'INSTRUCTOR-7821556', 1),
(7, 'CLASSROOM-725541', 'STUDENT-6968082', 'INSTRUCTOR-7821556', 1),
(8, 'CLASSROOM-725541', 'STUDENT-2139828', 'INSTRUCTOR-7821556', 1),
(9, 'CLASSROOM-251995', 'STUDENT-2139828', 'INSTRUCTOR-7821556', 0),
(10, 'CLASSROOM-251995', 'STUDENT-6968082', 'INSTRUCTOR-7821556', 1),
(11, 'CLASSROOM-725541', 'STUDENT-6014920', 'INSTRUCTOR-7821556', 1),
(12, 'CLASSROOM-725541', 'STUDENT-7508264', 'INSTRUCTOR-7821556', 1),
(13, 'CLASSROOM-858963', 'STUDENT-9588784', 'INSTRUCTOR-4211462', 1),
(14, 'CLASSROOM-858963', 'STUDENT-7129595', 'INSTRUCTOR-4211462', 2),
(15, 'CLASSROOM-894315', 'STUDENT-7129595', 'INSTRUCTOR-4211462', 1),
(16, 'CLASSROOM-276479', 'STUDENT-7129595', 'INSTRUCTOR-6442393', 1);

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
(3, 'INSTRUCTOR-6442393', 'test', '$2y$10$nf8ASRk0KR1c/sL8KAG/tu7h.mNx1xshaTVfMbKnx5g97B0t73jmS', 'test', 2),
(4, 'INSTRUCTOR-5817880', 'test1', '$2y$10$TdqJ0Z9Rin0r3S4QoozqSetq/PXk1RNjGNs4pLYlW4qXWqstKR1iK', 'test1', 1),
(5, 'INSTRUCTOR-1872681', 's', '$2y$10$wEpq25geKhu2GeVSdfK8.OjKW6ADFqpzlm6nWly9Oy7TW6gZVV5bG', 's', 2),
(6, 'INSTRUCTOR-4665909', 'asdf', '$2y$10$OS9LRb2oIx3N2Pv3gtDLb.iC4qt23xt2jtiIVTkcF4rJtSQbx1gtq', 'asdf', 0),
(7, 'INSTRUCTOR-7821556', 'ins', '$2y$10$OBx48G7pY5ZV7yypxeBQM.fU7gO1Av6XyJW/9JNr6xTkTSxOgOc8S', 'Harley Davidson', 2),
(8, 'INSTRUCTOR-4211462', 'melan', '$2y$10$wqQWGGZfq0AfJM94llLFfeAnxloMIBjALRUQkULe8CV2VfR3wPsHq', 'Melan', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_questions`
--

CREATE TABLE `tbl_questions` (
  `id` int(255) NOT NULL,
  `quiz_id_fk` varchar(255) NOT NULL,
  `question_id` varchar(255) NOT NULL,
  `number` int(255) NOT NULL,
  `classroom_id_fk` varchar(255) NOT NULL,
  `question_type` enum('isMultipleChoice','isIdentification','','') NOT NULL,
  `question_description` varchar(255) NOT NULL,
  `question_imagepath` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `a` varchar(255) DEFAULT NULL,
  `b` varchar(255) DEFAULT NULL,
  `c` varchar(255) DEFAULT NULL,
  `d` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_questions`
--

INSERT INTO `tbl_questions` (`id`, `quiz_id_fk`, `question_id`, `number`, `classroom_id_fk`, `question_type`, `question_description`, `question_imagepath`, `answer`, `a`, `b`, `c`, `d`) VALUES
(30, 'QUIZ-439554', '1', 1, 'CLASSROOM-725541', 'isMultipleChoice', 'hjk', '', 'mn', NULL, NULL, NULL, NULL),
(40, 'QUIZ-439554', 'QUIZ-439554_1', 1, 'CLASSROOM-725541', 'isMultipleChoice', 's', '', 's', 's', 's', 's', 's'),
(41, 'QUIZ-439554', 'QUIZ-439554_2', 2, 'CLASSROOM-725541', 'isMultipleChoice', 'asd', '', 'as', 'as', 'sa', 'asdsa', 'dasdsa'),
(42, 'QUIZ-439554', 'QUIZ-439554_3', 3, 'CLASSROOM-725541', 'isMultipleChoice', 'cvb', '', 'xcvb', 'bx', 'bxcvb', 'cv', 'vx'),
(43, 'QUIZ-439554', 'QUIZ-439554_4', 4, 'CLASSROOM-725541', 'isMultipleChoice', 'xvbx', '', 'cxvb', 'vbc', 'xcvb', 'xcbv', 'cxbc'),
(44, 'QUIZ-439554', 'QUIZ-439554_5', 5, 'CLASSROOM-725541', 'isMultipleChoice', 'xcbv', '', 'xcbv', 'xcvb', 'xcbvxbcv', 'xcvb', 'xcvb'),
(45, 'QUIZ-439554', 'QUIZ-439554_6', 6, 'CLASSROOM-725541', 'isIdentification', 'xcvb', '', 'cvb', NULL, NULL, NULL, NULL),
(46, 'QUIZ-439554', 'QUIZ-439554_7', 7, 'CLASSROOM-725541', 'isIdentification', 'xbcv', '', 'mnbm', NULL, NULL, NULL, NULL),
(47, 'QUIZ-439554', 'QUIZ-439554_8', 8, 'CLASSROOM-725541', 'isIdentification', 'bnm', '', 'jk', NULL, NULL, NULL, NULL),
(48, 'QUIZ-439554', 'QUIZ-439554_9', 9, 'CLASSROOM-725541', 'isIdentification', 'uiu', '', 'hjk', NULL, NULL, NULL, NULL),
(49, 'QUIZ-439554', 'QUIZ-439554_10', 10, 'CLASSROOM-725541', 'isIdentification', 'hjk', '', 'mn', NULL, NULL, NULL, NULL),
(50, 'QUIZ-188449', 'QUIZ-188449_1', 1, 'CLASSROOM-725541', 'isIdentification', 'The CSS property used to add space between the content of an element and its border.', '', 'padding', NULL, NULL, NULL, NULL),
(51, 'QUIZ-188449', 'QUIZ-188449_2', 2, 'CLASSROOM-725541', 'isIdentification', 'The type of CSS selector that targets a single unique element using the id attribute.', '', 'ID selector', NULL, NULL, NULL, NULL),
(52, 'QUIZ-188449', 'QUIZ-188449_3', 3, 'CLASSROOM-725541', 'isIdentification', 'The CSS property used to apply a background image to an element.', '', 'background-image', NULL, NULL, NULL, NULL),
(53, 'QUIZ-188449', 'QUIZ-188449_4', 4, 'CLASSROOM-725541', 'isIdentification', 'A CSS unit that is relative to the font size of the root element (<html>).', '', 'rem', NULL, NULL, NULL, NULL),
(54, 'QUIZ-188449', 'QUIZ-188449_5', 5, 'CLASSROOM-725541', 'isIdentification', 'The CSS property that controls whether an element is visible or hidden without affecting layout.', '', 'visibility', NULL, NULL, NULL, NULL),
(95, 'QUIZ-595191', 'QUIZ-595191_1', 1, 'CLASSROOM-725541', 'isIdentification', 's', '', 's', NULL, NULL, NULL, NULL),
(96, 'QUIZ-595191', 'QUIZ-595191_2', 2, 'CLASSROOM-725541', 'isIdentification', 's', '', 's', NULL, NULL, NULL, NULL),
(97, 'QUIZ-595191', 'QUIZ-595191_3', 3, 'CLASSROOM-725541', 'isIdentification', 's', '', 's', NULL, NULL, NULL, NULL),
(98, 'QUIZ-595191', 'QUIZ-595191_4', 4, 'CLASSROOM-725541', 'isIdentification', 's', '', 's', NULL, NULL, NULL, NULL),
(99, 'QUIZ-595191', 'QUIZ-595191_5', 5, 'CLASSROOM-725541', 'isIdentification', 's', '', 's', NULL, NULL, NULL, NULL),
(100, 'QUIZ-418799', 'QUIZ-418799_1', 1, 'CLASSROOM-858963', 'isMultipleChoice', 'k', '', 'k', 's', 'k', 's', 's'),
(101, 'QUIZ-418799', 'QUIZ-418799_2', 2, 'CLASSROOM-858963', 'isMultipleChoice', 'a', '', 'a', 'a', 'a', 'a', 'a'),
(102, 'QUIZ-418799', 'QUIZ-418799_3', 3, 'CLASSROOM-858963', 'isMultipleChoice', 'g', '', 'g', 's', 's', 'g', 'g'),
(103, 'QUIZ-418799', 'QUIZ-418799_4', 4, 'CLASSROOM-858963', 'isMultipleChoice', 'm', '', 'm', 'n', 'n', 'm', 'g'),
(104, 'QUIZ-418799', 'QUIZ-418799_5', 5, 'CLASSROOM-858963', 'isMultipleChoice', 'c', '', 'c', 'x', 'x', 'c', 'x'),
(105, 'QUIZ-418799', 'QUIZ-418799_6', 6, 'CLASSROOM-858963', 'isIdentification', 'jkl', '', 'jkl', NULL, NULL, NULL, NULL),
(106, 'QUIZ-418799', 'QUIZ-418799_7', 7, 'CLASSROOM-858963', 'isIdentification', 'lkj', '', 'lkj', NULL, NULL, NULL, NULL),
(107, 'QUIZ-418799', 'QUIZ-418799_8', 8, 'CLASSROOM-858963', 'isIdentification', 'lll', '', 'lll', NULL, NULL, NULL, NULL),
(108, 'QUIZ-418799', 'QUIZ-418799_9', 9, 'CLASSROOM-858963', 'isIdentification', 'ppp', '', 'ppp', NULL, NULL, NULL, NULL),
(109, 'QUIZ-418799', 'QUIZ-418799_10', 10, 'CLASSROOM-858963', 'isIdentification', 'ttt', '', 'ttt', NULL, NULL, NULL, NULL);

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
  `expiration` datetime(6) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_quiz`
--

INSERT INTO `tbl_quiz` (`id`, `quiz_id`, `quiz_title`, `quiz_description`, `instructor_id_fk`, `classroom_id_fk`, `isActive`, `expiration`, `created_date`) VALUES
(11, 'QUIZ-439554', 'Programming 2', 'Enhance Logical Thinking', 'INSTRUCTOR-7821556', 'CLASSROOM-725541', '1', '2025-03-03 12:00:00.000000', '2025-03-02 11:15:38'),
(12, 'QUIZ-188449', 'CSSss', 'CSS QUIZss', 'INSTRUCTOR-7821556', 'CLASSROOM-725541', '1', '2025-03-04 20:30:00.000000', '2025-03-02 12:30:17'),
(14, 'QUIZ-595191', 'Programming 3', 'Enhance Logical Capability', 'INSTRUCTOR-7821556', 'CLASSROOM-725541', '1', '2025-03-03 17:00:00.000000', '2025-03-03 06:15:24'),
(15, 'QUIZ-418799', 'Quiz 1', 'Hardware', 'INSTRUCTOR-4211462', 'CLASSROOM-858963', '1', '2025-03-13 07:56:00.000000', '2025-03-12 23:50:53');

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
  `score` int(255) NOT NULL,
  `total` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_score`
--

INSERT INTO `tbl_score` (`id`, `score_id`, `classroom_id_fk`, `quiz_id_fk`, `student_id_fk`, `score`, `total`) VALUES
(1, 'SCORE-001', 'CLASSROOM-001', 'QUIZ-001', 'STUDENT-2012341', 50, 0),
(10, 'SCORE-1172202', 'CLASSROOM-725541', 'QUIZ-188449', 'STUDENT-2139828', 4, 5),
(11, 'SCORE-2786408', 'CLASSROOM-725541', 'QUIZ-188449', 'STUDENT-3525082', 2, 5),
(12, 'SCORE-4587152', 'CLASSROOM-725541', 'QUIZ-188449', 'STUDENT-6011989', 2, 5),
(13, 'SCORE-9571025', 'CLASSROOM-725541', 'QUIZ-188449', 'STUDENT-6968082', 2, 5),
(14, 'SCORE-4226764', 'CLASSROOM-725541', 'QUIZ-188449', 'STUDENT-6014920', 2, 5),
(15, 'SCORE-2766810', 'CLASSROOM-725541', 'QUIZ-367497', 'STUDENT-7508264', 4, 10),
(16, 'SCORE-4538155', 'CLASSROOM-725541', 'QUIZ-188449', 'STUDENT-7508264', 2, 5),
(17, 'SCORE-7325953', 'CLASSROOM-858963', 'QUIZ-418799', 'STUDENT-9588784', 9, 10);

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
(3, 'STUDENT-3525082', 'test', '$2y$10$XGtQrig9ddQepGCPWEQDoObCxcrCef9w9shzuxT3ZzXjVj8ff9cli', 'test', '2025-02-21 01:08:27'),
(4, 'STUDENT-6011989', 'vanny', '$2y$10$xzXxvTFybK562VSitDrf4OR0V6Op1bBXg8xFcLBLx7A.vdDTLHm6O', 'vanny', '2025-03-01 03:13:53'),
(5, 'STUDENT-2139828', 'test1', '$2y$10$qHRtjMyanF8VB3q/fOyFz.NafpSr2pjelMmGjsLIGCf4S6JL8mZ7i', 'test1', '2025-03-01 03:17:39'),
(6, 'STUDENT-6968082', 'test2', '$2y$10$TJHoj73or5Y2nimsgiqFTO8Y6c9BxPDBQ21KWEc0CCQLWWZ7pwZ6W', 'test2', '2025-03-01 03:19:32'),
(7, 'STUDENT-6014920', 'john1', '$2y$10$kcuiwXjllMWaR5TtR9D0PuwxitUzGoBbfYgbyIFR/7qJqzF1kyEIK', 'John Smith', '2025-03-03 05:50:18'),
(8, 'STUDENT-7508264', 'vannycon', '$2y$10$LBVYfKiAWIv3Mw3XzEIO1uyqvaxKP2XULHSs.0VucOuptgre84ddi', 'Vanny COn', '2025-03-03 05:56:48'),
(9, 'STUDENT-9588784', 'jimmar', '$2y$10$wWcDwZquuuSTIsebcVeaHOqNfOcGSb4HXXelW3EEPR6sx7pPqOZVy', 'jimmar', '2025-03-12 23:49:30'),
(10, 'STUDENT-7129595', 'mark', '$2y$10$j.iSzeJpgwe25eruqiZHz.pj5yRHzBGmqQSXaUyHEWirdeBIyqGiG', 'mark', '2025-03-12 23:57:44');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_classroom_student`
--
ALTER TABLE `tbl_classroom_student`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_instructor`
--
ALTER TABLE `tbl_instructor`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_score`
--
ALTER TABLE `tbl_score`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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

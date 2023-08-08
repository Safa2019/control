-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2023 at 08:29 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ctrlsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `organ_id` int(11) NOT NULL,
  `organ_name` text NOT NULL,
  `manager` text NOT NULL,
  `empNo` int(11) NOT NULL,
  `taskNo` int(11) NOT NULL,
  `date_reg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organ_id`, `organ_name`, `manager`, `empNo`, `taskNo`, `date_reg`) VALUES
(4, 'إكليل', 'بشاير القرني', 2, 4, '2022-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `taskrecord`
--

CREATE TABLE `taskrecord` (
  `record_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `empRes` text NOT NULL,
  `dateRecord` text NOT NULL,
  `status` text NOT NULL,
  `deadline` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taskrecord`
--

INSERT INTO `taskrecord` (`record_id`, `task_id`, `empRes`, `dateRecord`, `status`, `deadline`) VALUES
(8, 5, 'صفاء الارضي', '2023-07-22', 'not started', '2023-07-06'),
(9, 6, 'صفاء الارضي', '2023-07-22', 'not started', '2023-07-12'),
(10, 7, 'روان الصبحي', '2023-07-22', 'not started', '2023-07-12'),
(11, 8, 'صفاء الارضي', '2023-07-22', 'not started', '2023-08-05'),
(12, 5, 'صفاء الارضي', '2023-07-22', 'not started', '2023-08-04'),
(13, 6, 'صفاء الارضي', '2023-07-22', 'not started', '2023-08-02'),
(14, 6, 'صفاء الارضي', '2023-07-22', 'in progress', '2023-08-02');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `empRes` text NOT NULL,
  `deadline` text NOT NULL,
  `organ_id` int(11) NOT NULL,
  `empID` int(11) NOT NULL,
  `status` text NOT NULL,
  `createdBy` text NOT NULL,
  `dateTask` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `title`, `empRes`, `deadline`, `organ_id`, `empID`, `status`, `createdBy`, `dateTask`) VALUES
(5, 'كتابة تقرير مالي ', 'صفاء الارضي', '2023-08-04', 4, 5, 'not started', '3', '2023-07-22'),
(6, 'مراجعة المشروع ', 'صفاء الارضي', '2023-08-02', 4, 5, 'in progress', '3', '2023-07-22'),
(7, 'رفع الموقع ', 'روان الصبحي', '2023-07-12', 4, 3, 'not started', '5', '2023-07-22'),
(8, 'تصميم الواجهات', 'صفاء الارضي', '2023-08-05', 4, 5, 'not started', '5', '2023-07-22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL,
  `organ_id` int(11) NOT NULL,
  `manager` text NOT NULL,
  `empName` text NOT NULL,
  `reg_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `organ_id`, `manager`, `empName`, `reg_date`) VALUES
(3, 'rawan_99', 'rawan@gmail.com', '1234', 'admin', 4, 'بشاير القرني', 'روان الصبحي', '2022-02-27'),
(5, 'safa_99', 'safa@gmail.com', '1234', 'user', 4, ' بشاير القرني', 'صفاء الارضي', '2022-02-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`organ_id`);

--
-- Indexes for table `taskrecord`
--
ALTER TABLE `taskrecord`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `taskrecord_fk` (`task_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `tasks_fk` (`empID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `users_fk` (`organ_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `organ_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `taskrecord`
--
ALTER TABLE `taskrecord`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `taskrecord`
--
ALTER TABLE `taskrecord`
  ADD CONSTRAINT `taskrecord_fk` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_fk` FOREIGN KEY (`empID`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_fk` FOREIGN KEY (`organ_id`) REFERENCES `organization` (`organ_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

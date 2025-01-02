-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 01:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stmgn`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `UID` int(255) NOT NULL,
  `Year` varchar(10) NOT NULL,
  `RollNo` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Guardian` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_routine`
--

CREATE TABLE `class_routine` (
  `class_name` varchar(10) NOT NULL,
  `monday_period1` varchar(50) DEFAULT NULL,
  `monday_period2` varchar(50) DEFAULT NULL,
  `monday_period3` varchar(50) DEFAULT NULL,
  `monday_period4` varchar(50) DEFAULT NULL,
  `monday_period5` varchar(50) DEFAULT NULL,
  `tuesday_period1` varchar(50) DEFAULT NULL,
  `tuesday_period2` varchar(50) DEFAULT NULL,
  `tuesday_period3` varchar(50) DEFAULT NULL,
  `tuesday_period4` varchar(50) DEFAULT NULL,
  `tuesday_period5` varchar(50) DEFAULT NULL,
  `wednesday_period1` varchar(50) DEFAULT NULL,
  `wednesday_period2` varchar(50) DEFAULT NULL,
  `wednesday_period3` varchar(50) DEFAULT NULL,
  `wednesday_period4` varchar(50) DEFAULT NULL,
  `wednesday_period5` varchar(50) DEFAULT NULL,
  `thursday_period1` varchar(50) DEFAULT NULL,
  `thursday_period2` varchar(50) DEFAULT NULL,
  `thursday_period3` varchar(50) DEFAULT NULL,
  `thursday_period4` varchar(50) DEFAULT NULL,
  `thursday_period5` varchar(50) DEFAULT NULL,
  `friday_period1` varchar(50) DEFAULT NULL,
  `friday_period2` varchar(50) DEFAULT NULL,
  `friday_period3` varchar(50) DEFAULT NULL,
  `friday_period4` varchar(50) DEFAULT NULL,
  `friday_period5` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `Year` varchar(4) NOT NULL,
  `Month` varchar(10) NOT NULL,
  `UID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stu_att`
--

CREATE TABLE `stu_att` (
  `Date` date NOT NULL,
  `UID` int(255) NOT NULL,
  `Class` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stu_dtl`
--

CREATE TABLE `stu_dtl` (
  `UID` int(255) NOT NULL,
  `Class` varchar(10) NOT NULL,
  `RollNo` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Guardian` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stu_ter`
--

CREATE TABLE `stu_ter` (
  `UID` int(255) NOT NULL,
  `Year` varchar(4) NOT NULL,
  `Class` varchar(10) NOT NULL,
  `RollNo` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Guardian` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tch_att`
--

CREATE TABLE `tch_att` (
  `Date` date NOT NULL,
  `UID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tch_dtl`
--

CREATE TABLE `tch_dtl` (
  `UID` int(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Status` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `UID` varchar(10) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `class_routine`
--
ALTER TABLE `class_routine`
  ADD PRIMARY KEY (`class_name`);

--
-- Indexes for table `stu_dtl`
--
ALTER TABLE `stu_dtl`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `stu_ter`
--
ALTER TABLE `stu_ter`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `tch_dtl`
--
ALTER TABLE `tch_dtl`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stu_dtl`
--
ALTER TABLE `stu_dtl`
  MODIFY `UID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tch_dtl`
--
ALTER TABLE `tch_dtl`
  MODIFY `UID` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

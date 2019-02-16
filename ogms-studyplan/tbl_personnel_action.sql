-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2018 at 09:43 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ogms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_personnel_action`
--

CREATE TABLE `tbl_personnel_action` (
  `supervisor_email` varchar(40) DEFAULT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `PantherID` int(9) DEFAULT NULL,
  `student_email` varchar(40) DEFAULT NULL,
  `degree` varchar(10) DEFAULT NULL,
  `enrollment` enum('Full-Time','Part-Time','NULL','') DEFAULT NULL,
  `appointment` varchar(40) DEFAULT NULL,
  `position` varchar(40) DEFAULT NULL,
  `term` varchar(20) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `total_FTE` int(10) DEFAULT NULL,
  `additional_appointments` tinyint(1) DEFAULT NULL,
  `pos_title_1` varchar(40) DEFAULT NULL,
  `FTE_1` int(2) DEFAULT NULL,
  `speedtype_1` varchar(10) DEFAULT NULL,
  `comp_1` int(10) DEFAULT NULL,
  `per_month_comp_1` int(5) DEFAULT NULL,
  `start_date_1` date DEFAULT NULL,
  `end_date_1` date DEFAULT NULL,
  `pos_title_2` varchar(40) DEFAULT NULL,
  `FTE_2` int(2) DEFAULT NULL,
  `speedtype_2` varchar(10) DEFAULT NULL,
  `comp_2` int(10) DEFAULT NULL,
  `per_month_comp_2` int(5) DEFAULT NULL,
  `start_date_2` date DEFAULT NULL,
  `end_date_2` date DEFAULT NULL,
  `pos_title_3` varchar(40) DEFAULT NULL,
  `FTE_3` int(2) DEFAULT NULL,
  `speedtype_3` varchar(10) DEFAULT NULL,
  `comp_3` int(10) DEFAULT NULL,
  `per_month_comp_3` int(5) DEFAULT NULL,
  `start_date_3` date DEFAULT NULL,
  `end_date_3` date DEFAULT NULL,
  `waiver` enum('full','partial','NULL') DEFAULT NULL,
  `total_comp` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_personnel_action`
--

INSERT INTO `tbl_personnel_action` (`supervisor_email`, `first_name`, `last_name`, `PantherID`, `student_email`, `degree`, `enrollment`, `appointment`, `position`, `term`, `year`, `total_FTE`, `additional_appointments`, `pos_title_1`, `FTE_1`, `speedtype_1`, `comp_1`, `per_month_comp_1`, `start_date_1`, `end_date_1`, `pos_title_2`, `FTE_2`, `speedtype_2`, `comp_2`, `per_month_comp_2`, `start_date_2`, `end_date_2`, `pos_title_3`, `FTE_3`, `speedtype_3`, `comp_3`, `per_month_comp_3`, `start_date_3`, `end_date_3`, `waiver`, `total_comp`) VALUES
('aashok@gsu.edu', 'Jillian', 'Jones', 1165291, 'cfrederick1@student.gsu.edu', 'MS', 'Full-Time', 'Full', 'GRA', 'Spring', 2012, 40, 1, 'fdfdf', 23, '2323', 3232, 23, '2018-11-01', '2018-11-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'full', 12),
(':supervisor_email', ':first_name', ':last_name', 0, ':student_email', ':degree', '', ':appointment', ':position', ':term', 0, 0, 0, ':pos_title_1', 0, ':speedtype', 0, 0, '0000-00-00', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0),
('aashok@gsu.edu', 'Jillian', 'Jones', 1165291, 'cfrederick1@student.gsu.edu', 'MS', 'Full-Time', 'Full', 'GRA', 'Spring', 2012, 40, 1, 'fdfdf', 23, '2323', 3232, 23, '2018-11-01', '2018-11-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'full', 12),
('tdudley@gsu.edu', 'Chinua', 'Umoja', 1147474, 'cumoja1@student.gsu.edu', 'MS', 'Full-Time', 'Full', 'GAA', 'Spring', 2019, 0, 0, 'GRA', 35, 'fdfd', 4343, 34, '2018-11-01', '2018-11-01', '', 0, '', 0, 0, '0000-00-00', '0000-00-00', '', 0, '', 0, 0, '0000-00-00', '0000-00-00', 'full', 4343);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

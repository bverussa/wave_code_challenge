-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 26, 2020 at 01:21 PM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `wave`
--

-- --------------------------------------------------------

--
-- Table structure for table `reports_uploaded`
--

CREATE TABLE `reports_uploaded` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `report_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reports_uploaded`
--

INSERT INTO `reports_uploaded` (`id`, `date`, `report_name`) VALUES
(42, '2020-03-26 06:14:36', 'time-report-42.csv');

-- --------------------------------------------------------

--
-- Table structure for table `timekeeping`
--

CREATE TABLE `timekeeping` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `employee_id` int(11) NOT NULL,
  `hours_worked` decimal(10,2) NOT NULL,
  `job_group` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `timekeeping`
--

INSERT INTO `timekeeping` (`id`, `date`, `employee_id`, `hours_worked`, `job_group`) VALUES
(1, '1970-01-01', 8, '1.00', 'A'),
(2, '2016-09-11', 4, '2.00', 'B'),
(3, '2016-10-11', 4, '2.00', 'B'),
(4, '2016-09-11', 12, '3.00', 'A'),
(5, '2016-08-11', 6, '3.00', 'A'),
(6, '2016-11-11', 3, '3.00', 'A'),
(7, '2016-02-11', 6, '3.00', 'A'),
(8, '2016-03-11', 12, '2.00', 'B'),
(9, '2016-04-11', 11, '2.00', 'B'),
(10, '2016-06-11', 5, '4.00', 'B'),
(11, '1970-01-01', 6, '1.00', 'A'),
(12, '1970-01-01', 5, '1.00', 'A'),
(13, '1970-01-01', 5, '4.00', 'B'),
(14, '1970-01-01', 5, '4.00', 'B'),
(15, '1970-01-01', 5, '4.00', 'B'),
(16, '1970-01-01', 8, '1.00', 'A'),
(17, '2016-09-12', 4, '2.00', 'B'),
(18, '2016-10-12', 4, '2.00', 'B'),
(19, '2016-09-12', 12, '3.00', 'A'),
(20, '2016-08-12', 6, '3.00', 'A'),
(21, '2016-12-11', 3, '3.00', 'A'),
(22, '2016-02-12', 6, '3.00', 'A'),
(23, '2016-03-12', 12, '2.00', 'B'),
(24, '2016-04-12', 11, '2.00', 'B'),
(25, '2016-06-12', 5, '4.00', 'B'),
(26, '1970-01-01', 6, '1.00', 'A'),
(27, '1970-01-01', 5, '1.00', 'A'),
(28, '1970-01-01', 5, '4.00', 'B'),
(29, '1970-01-01', 5, '4.00', 'B'),
(30, '1970-01-01', 5, '4.00', 'B'),
(31, '1970-01-01', 5, '4.00', 'A'),
(32, '1970-01-01', 5, '4.00', 'B');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reports_uploaded`
--
ALTER TABLE `reports_uploaded`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timekeeping`
--
ALTER TABLE `timekeeping`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reports_uploaded`
--
ALTER TABLE `reports_uploaded`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `timekeeping`
--
ALTER TABLE `timekeeping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

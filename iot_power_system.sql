-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2017 at 07:16 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iot_power_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `command`
--

CREATE TABLE `command` (
  `command_id` int(11) NOT NULL,
  `device_id` varchar(50) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `source` varchar(200) NOT NULL,
  `critical` int(11) DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `command`
--

INSERT INTO `command` (`command_id`, `device_id`, `mode`, `source`, `critical`, `date`) VALUES
(1, '0002', 'Auto', 'Generator', 0, '2017-04-13 16:37:03'),
(2, '0001', 'Auto', 'Generator', 0, '2017-04-13 16:37:43');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `error` varchar(50) NOT NULL,
  `source` varchar(20) NOT NULL,
  `error_time` datetime NOT NULL,
  `fixed` int(11) NOT NULL,
  `time_fixed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(11) NOT NULL,
  `device_id` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `mode` varchar(200) NOT NULL,
  `source` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `contact1` varchar(200) NOT NULL,
  `contact2` varchar(200) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_id`, `device_id`, `name`, `mode`, `source`, `status`, `contact1`, `contact2`, `date`) VALUES
(1, '0001', 'Apartment A', 'Auto', 'Generator', 'Online', 'On', 'Off', '2017-04-13 23:57:09'),
(2, '0002', 'Apartment B', 'Auto', 'Generator', 'Online', 'On', 'Off', '2017-04-14 00:23:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `command`
--
ALTER TABLE `command`
  ADD PRIMARY KEY (`command_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `command`
--
ALTER TABLE `command`
  MODIFY `command_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

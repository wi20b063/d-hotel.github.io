-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2023 at 06:26 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webhotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `general_log`
--

CREATE TABLE `general_log` (
  `event_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_host` mediumtext NOT NULL,
  `thread_id` bigint(21) UNSIGNED NOT NULL,
  `server_id` int(10) UNSIGNED NOT NULL,
  `command_type` varchar(64) NOT NULL,
  `argument` mediumtext NOT NULL
) ENGINE=CSV DEFAULT CHARSET=utf8 COMMENT='General log';

-- --------------------------------------------------------

--
-- Table structure for table `slow_log`
--

CREATE TABLE `slow_log` (
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_host` mediumtext NOT NULL,
  `query_time` time NOT NULL,
  `lock_time` time NOT NULL,
  `rows_sent` int(11) NOT NULL,
  `rows_examined` int(11) NOT NULL,
  `db` varchar(512) NOT NULL,
  `last_insert_id` int(11) NOT NULL,
  `insert_id` int(11) NOT NULL,
  `server_id` int(10) UNSIGNED NOT NULL,
  `sql_text` mediumtext NOT NULL,
  `thread_id` bigint(21) UNSIGNED NOT NULL
) ENGINE=CSV DEFAULT CHARSET=utf8 COMMENT='Slow log';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `RESERVEID` int(11) NOT NULL,
  `CONFIRMCODE` varchar(24) NOT NULL,
  `ROOMID` int(11) NOT NULL,
  `PRICE` double NOT NULL,
  `DATEARRIVAL` datetime NOT NULL,
  `DATEDEPART` datetime NOT NULL,
  `DATECREATE` datetime NOT NULL,
  `DATELASTUP` datetime NOT NULL,
  `STATUS` enum('new','reserved','cancelled') NOT NULL,
  `REMARK` text DEFAULT NULL,
  `GUESTID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `ID` int(11) NOT NULL,
  `ROOMNUM` int(11) NOT NULL,
  `ROOMNAME` varchar(24) DEFAULT NULL,
  `PRICE` float NOT NULL,
  `Category` enum('budget','standard','premium','modern suite','luxury suite') NOT NULL DEFAULT 'budget',
  `GuestsMax` int(11) NOT NULL DEFAULT 2,
  `IMAGE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_room`
--

INSERT INTO `tbl_room` (`ID`, `ROOMNUM`, `ROOMNAME`, `PRICE`, `Category`, `GuestsMax`, `IMAGE`) VALUES
(1, 101, 'Budget Zimmer', 79, 'budget', 2, 'budget room.png'),
(2, 102, 'Budget Zimmer', 79, 'budget', 2, 'budget room.png'),
(3, 103, 'Budget Zimmer', 79, 'budget', 2, 'budget room.png'),
(4, 201, 'Standard Zimmer', 89, 'standard', 2, 'standard room.png'),
(5, 202, 'Standard Zimmer', 89, 'standard', 2, 'standard room.png'),
(6, 203, 'Standard Zimmer', 89, 'standard', 2, 'standard room.png'),
(7, 301, 'Premium Zimmer', 89, 'premium', 3, 'premium room.png'),
(8, 302, 'Premium Zimmer', 148, 'premium', 3, 'premium room.png'),
(9, 401, 'Madonna Suite', 148, 'premium', 4, 'modern suite.png'),
(10, 402, 'Eminiem Suite', 175, 'premium', 4, 'modern suite.png'),
(11, 501, 'Royal Suite', 250, 'premium', 5, 'luxury suite.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `ID` int(16) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`ID`, `username`, `password`, `active`) VALUES
(14, 'max', 'd0c81c7f1e56b65f6168d1a3cd134076', 1),
(15, 'saras', '265a9b497722342d9c3506671e429215', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `personID` int(16) NOT NULL,
  `role` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `firstName` varchar(24) DEFAULT NULL,
  `lastName` varchar(24) DEFAULT NULL,
  `email` varchar(24) DEFAULT NULL,
  `zipcode` varchar(16) DEFAULT NULL,
  `city` varchar(24) DEFAULT NULL,
  `address` varchar(24) DEFAULT NULL,
  `address2` varchar(24) DEFAULT NULL,
  `tel` varchar(24) DEFAULT NULL,
  `salutation` varchar(16) DEFAULT NULL,
  `target_file` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`personID`, `role`, `firstName`, `lastName`, `email`, `zipcode`, `city`, `address`, `address2`, `tel`, `salutation`, `target_file`) VALUES
(14, 0, 'Max', 'Mara', 'maram@dd.at', '111', '', 'Test2', '4466', '', 'male', '63af39182401e.jpg'),
(15, 0, 'Sara', 'Seey', 'saras@sey.com', '1190', 'Wien', 'TestStrasse 11', '22/44', '12355354', 'female', '63af32f6a506a.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`RESERVEID`),
  ADD KEY `ROOMID` (`ROOMID`,`GUESTID`),
  ADD KEY `GUESTID` (`GUESTID`);

--
-- Indexes for table `tbl_room`
--
ALTER TABLE `tbl_room`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`personID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `RESERVEID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `ID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD CONSTRAINT `tbl_reservation_ibfk_1` FOREIGN KEY (`GUESTID`) REFERENCES `user_profile` (`personID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `d_ID_pers_user` FOREIGN KEY (`personID`) REFERENCES `user_login` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

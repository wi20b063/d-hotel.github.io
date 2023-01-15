-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2023 at 09:38 PM
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
-- Table structure for table `tbl_currentprice`
--

CREATE TABLE `tbl_currentprice` (
  `ID` int(11) NOT NULL,
  `PRICECAT` enum('BUDGET','STANDARD','PREMIUM','MODSUITE','LUXSUITE','PARKING','BREAKFAST','PET') NOT NULL,
  `PRICE` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_currentprice`
--

INSERT INTO `tbl_currentprice` (`ID`, `PRICECAT`, `PRICE`) VALUES
(1, 'BUDGET', 79),
(2, 'STANDARD', 89),
(3, 'PREMIUM', 148),
(4, 'MODSUITE', 175),
(5, 'LUXSUITE', 250),
(6, 'PARKING', 15),
(13, 'BREAKFAST', 25),
(14, 'PET', 50);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE `tbl_news` (
  `id` int(16) NOT NULL,
  `headline` varchar(150) NOT NULL,
  `text` text NOT NULL,
  `personID` int(16) NOT NULL,
  `newsImgPath` varchar(200) NOT NULL,
  `newsImgThumbPath` varchar(200) NOT NULL,
  `publicationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_news`
--

INSERT INTO `tbl_news` (`id`, `headline`, `text`, `personID`, `newsImgPath`, `newsImgThumbPath`, `publicationDate`) VALUES
(30, 'Yoga-Kurs mit Anna', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. \n\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. ', 20, './res/img/img news/yoga.jpg', './res/img/img news/thumbs/thumb_yoga.jpg', '2023-01-04 16:10:00'),
(31, 'Neue Liegen direkt im Pool', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.   \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.   \r\n\r\nUt wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.   \r\n\r\nNam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer', 20, './res/img/img news/pool beds.jpg', './res/img/img news/thumbs/thumb_pool beds.jpg', '2023-01-03 12:15:39'),
(32, 'Tägliche mehrere Ausflüge in die Stadt', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. \r\n\r\nUt wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. \r\n\r\nNam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.', 20, './res/img/img news/sightseeing.jpg', './res/img/img news/thumbs/thumb_sightseeing.jpg', '2023-01-02 09:35:58'),
(33, 'Erholung in den Ruheräumen', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 20, './res/img/img news/silent room.jpg', './res/img/img news/thumbs/thumb_silent room.jpg', '2023-01-01 11:16:44'),
(34, 'Poolservice nun bis 24 Uhr', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet,', 20, './res/img/img news/pool service.jpg', './res/img/img news/thumbs/thumb_pool service.jpg', '2022-12-30 10:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `RESERVEID` int(11) NOT NULL,
  `CONFIRMCODE` varchar(24) NOT NULL,
  `ROOMCAT` enum('BUDGET','STANDARD','PREMIUM','MODSUITE','LUXSUITE') NOT NULL,
  `PRICE` double NOT NULL,
  `DATEARRIVAL` datetime NOT NULL,
  `DATEDEPART` datetime NOT NULL,
  `DATECREATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `DATELASTUP` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `STATUS` enum('new','reserved','cancelled') NOT NULL,
  `REMARK` text DEFAULT NULL,
  `GUESTID` int(11) NOT NULL,
  `BREAKF` tinyint(1) DEFAULT NULL,
  `PARKING` tinyint(1) DEFAULT NULL,
  `PET` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`RESERVEID`, `CONFIRMCODE`, `ROOMCAT`, `PRICE`, `DATEARRIVAL`, `DATEDEPART`, `DATECREATE`, `DATELASTUP`, `STATUS`, `REMARK`, `GUESTID`, `BREAKF`, `PARKING`, `PET`) VALUES
(1255, '847497', 'STANDARD', 179, '2023-01-11 12:00:00', '2023-01-12 10:00:00', '2023-01-11 11:25:56', '2023-01-11 11:25:56', 'new', NULL, 14, 1, 1, 1),
(1256, '523413', 'BUDGET', 169, '2023-01-18 12:00:00', '2023-01-19 10:00:00', '2023-01-11 11:29:59', '2023-01-15 20:29:17', 'reserved', NULL, 15, 1, 1, 1),
(1257, '196839', 'BUDGET', 169, '2023-01-11 12:00:00', '2023-01-12 10:00:00', '2023-01-11 11:50:38', '2023-01-11 11:50:38', 'cancelled', NULL, 15, 1, 1, 1),
(1258, '611251', 'BUDGET', 169, '2023-01-12 12:00:00', '2023-01-13 10:00:00', '2023-01-12 16:43:00', '2023-01-12 16:43:00', 'new', NULL, 23, 1, 1, 1),
(1259, '939171', 'BUDGET', 169, '2023-01-12 12:00:00', '2023-01-13 10:00:00', '2023-01-12 17:02:59', '2023-01-12 17:02:59', 'new', NULL, 23, 1, 1, 1),
(1260, '478743', 'BUDGET', 169, '2023-01-12 12:00:00', '2023-01-13 10:00:00', '2023-01-12 17:04:55', '2023-01-12 17:04:55', 'new', NULL, 23, 1, 1, 1),
(1261, '733161', 'STANDARD', 179, '2023-01-12 12:00:00', '2023-01-13 10:00:00', '2023-01-12 17:17:16', '2023-01-12 17:17:16', 'reserved', NULL, 23, 1, 1, 1),
(1262, '697935', 'STANDARD', 179, '2023-01-12 12:00:00', '2023-01-13 10:00:00', '2023-01-12 17:51:27', '2023-01-12 17:51:27', 'reserved', NULL, 23, 0, 0, 1),
(1263, '452175', 'STANDARD', 139, '2023-01-12 12:00:00', '2023-01-13 10:00:00', '2023-01-12 18:01:35', '2023-01-12 18:01:35', 'new', NULL, 23, 0, 0, 1),
(1264, '659496', 'BUDGET', 129, '2023-01-13 12:00:00', '2023-01-14 10:00:00', '2023-01-13 00:24:08', '2023-01-13 00:24:08', 'new', NULL, 15, 0, 0, 1),
(1265, '457463', 'BUDGET', 94, '2023-01-13 12:00:00', '2023-01-14 10:00:00', '2023-01-13 01:17:18', '2023-01-13 01:17:18', 'new', NULL, 15, 0, 1, 0),
(1266, '650839', 'BUDGET', 832, '2023-01-18 12:00:00', '2023-01-26 10:00:00', '2023-01-13 12:18:36', '2023-01-13 12:18:36', 'new', NULL, 15, 1, 0, 0),
(1267, '683315', 'BUDGET', 832, '2023-01-17 12:00:00', '2023-01-25 10:00:00', '2023-01-14 21:27:45', '2023-01-14 21:27:45', 'new', NULL, 15, 1, 0, 0),
(1268, '464114', 'PREMIUM', 173, '2023-01-14 12:00:00', '2023-01-15 10:00:00', '2023-01-14 21:33:17', '2023-01-14 21:33:17', 'reserved', NULL, 15, 1, 0, 0),
(1269, '321588', 'STANDARD', 258, '2023-01-17 12:00:00', '2023-01-19 10:00:00', '2023-01-15 19:49:59', '2023-01-15 19:49:59', 'new', NULL, 15, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `ID` int(11) NOT NULL,
  `ROOMNUM` int(11) NOT NULL,
  `ROOMNAME` varchar(24) DEFAULT NULL,
  `ROOMCAT` enum('BUDGET','STANDARD','PREMIUM','MODSUITE','LUXSUITE') NOT NULL DEFAULT 'BUDGET',
  `GuestsMax` int(11) NOT NULL DEFAULT 2,
  `IMAGE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_room`
--

INSERT INTO `tbl_room` (`ID`, `ROOMNUM`, `ROOMNAME`, `ROOMCAT`, `GuestsMax`, `IMAGE`) VALUES
(1, 101, 'Budget Zimmer', 'BUDGET', 2, 'budget room.png'),
(2, 102, 'Budget Zimmer', 'BUDGET', 2, 'budget room.png'),
(3, 103, 'Budget Zimmer', 'BUDGET', 2, 'budget room.png'),
(4, 201, 'Standard Zimmer', 'STANDARD', 2, 'standard room.png'),
(5, 202, 'Standard Zimmer', 'STANDARD', 2, 'standard room.png'),
(6, 203, 'Standard Zimmer', 'STANDARD', 2, 'standard room.png'),
(7, 301, 'Premium Zimmer', 'PREMIUM', 3, 'premium room.png'),
(8, 302, 'Premium Zimmer', 'PREMIUM', 3, 'premium room.png'),
(9, 401, 'Modern Suite', 'MODSUITE', 4, 'modern suite.png'),
(10, 402, 'Modern Suite', 'MODSUITE', 4, 'modern suite.png'),
(11, 501, 'Royal Suite', 'LUXSUITE', 5, 'luxury suite.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `ID` int(16) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` int(11) DEFAULT 2,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`ID`, `username`, `password`, `role`, `active`) VALUES
(14, 'max', '265a9b497722342d9c3506671e429215', 2, 1),
(15, 'saras', '265a9b497722342d9c3506671e429215', 2, 1),
(20, 'admin', '265a9b497722342d9c3506671e429215', 1, 1),
(21, 'AnnaM', '265a9b497722342d9c3506671e429215', 2, 1),
(22, 'mario', '265a9b497722342d9c3506671e429215', 2, 1),
(23, 'kim', 'fffdbe096056ccd42e77aa917f600079', 2, 1),
(24, 'last', 'fffdbe096056ccd42e77aa917f600079', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `personID` int(16) NOT NULL,
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

INSERT INTO `user_profile` (`personID`, `firstName`, `lastName`, `email`, `zipcode`, `city`, `address`, `address2`, `tel`, `salutation`, `target_file`) VALUES
(14, 'Max', 'Mara', 'maram@dd.at', '111', 'Wien', 'Test', '4466', '', 'male', '63af39182401e.jpg'),
(15, 'Sara', 'Seey', 'saras1@sey.com', '1190', 'Wien', 'Test', '22', '123557', 'female', '63bef9889eb5b.jpg'),
(20, 'Admin', 'Test', 'admin@a1.at', '1200', 'Wien', 'Admin-Weg', '111', '0664123457855', 'neutral', NULL),
(21, 'Anna', 'Maier', 'anna@google.com', '1010', 'Wien', 'Teststraße', '1/1/1', '12345678', 'female', NULL),
(22, 'Mario', 'Bros', 'mario@bbbros.com', '122451', 'Kendall1', 'Nintendo1', '1441', '+1209333888441', 'male', '63bf2d726cf8f.jpg'),
(23, 'Kim', 'Kardi', 'kim@kardi.bb', '1', 'Los Angeles BH', 'Sunset Blv', '20133', '222222444', 'neutral', '63c03836930d9.png'),
(24, 'Last', 'Test', 'last@test.te', '', '', '', '', '', 'neutral', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_currentprice`
--
ALTER TABLE `tbl_currentprice`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`RESERVEID`),
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
-- AUTO_INCREMENT for table `tbl_currentprice`
--
ALTER TABLE `tbl_currentprice`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `RESERVEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1270;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `ID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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

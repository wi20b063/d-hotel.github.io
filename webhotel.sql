-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Jan 2023 um 19:55
-- Server-Version: 10.4.24-MariaDB
-- PHP-Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `webhotel`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `general_log`
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
-- Tabellenstruktur für Tabelle `slow_log`
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
-- Tabellenstruktur für Tabelle `tbl_news`
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
-- Daten für Tabelle `tbl_news`
--

INSERT INTO `tbl_news` (`id`, `headline`, `text`, `personID`, `newsImgPath`, `newsImgThumbPath`, `publicationDate`) VALUES
(30, 'Yoga-Kurs mit Anna', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. \n\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. ', 20, './res/img/img news/yoga.jpg', './res/img/img news/thumbs/thumb_yoga.jpg', '2023-01-04 16:10:00'),
(31, 'Neue Liegen direkt im Pool', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.   \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.   \r\n\r\nUt wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.   \r\n\r\nNam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer', 20, './res/img/img news/pool beds.jpg', './res/img/img news/thumbs/thumb_pool beds.jpg', '2023-01-03 12:15:39'),
(32, 'Tägliche mehrere Ausflüge in die Stadt', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. \r\n\r\nUt wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. \r\n\r\nNam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.', 20, './res/img/img news/sightseeing.jpg', './res/img/img news/thumbs/thumb_sightseeing.jpg', '2023-01-02 09:35:58'),
(33, 'Erholung in den Ruheräumen', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 20, './res/img/img news/silent room.jpg', './res/img/img news/thumbs/thumb_silent room.jpg', '2023-01-01 11:16:44'),
(34, 'Poolservice nun bis 24 Uhr', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet,', 20, './res/img/img news/pool service.jpg', './res/img/img news/thumbs/thumb_pool service.jpg', '2022-12-30 10:15:03');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `RESERVEID` int(11) NOT NULL,
  `CONFIRMCODE` varchar(24) NOT NULL,
  `ROOMCAT` enum('budget','standard','premium','modern suite','luxury suite') NOT NULL,
  `PRICE` double NOT NULL,
  `DATEARRIVAL` datetime NOT NULL,
  `DATEDEPART` datetime NOT NULL,
  `DATECREATE` datetime NOT NULL,
  `DATELASTUP` datetime NOT NULL,
  `STATUS` enum('new','reserved','cancelled') NOT NULL,
  `REMARK` text DEFAULT NULL,
  `GUESTID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`RESERVEID`, `CONFIRMCODE`, `ROOMCAT`, `PRICE`, `DATEARRIVAL`, `DATEDEPART`, `DATECREATE`, `DATELASTUP`, `STATUS`, `REMARK`, `GUESTID`) VALUES
(1235, '262829', 'budget', 400, '2023-01-11 12:00:00', '2023-01-19 10:00:00', '2023-01-09 04:12:44', '2023-01-09 04:12:44', 'reserved', NULL, 15),
(1236, '988826', 'budget', 640, '2023-01-11 12:00:00', '2023-01-27 10:00:00', '2023-01-09 04:22:41', '2023-01-09 04:22:41', 'reserved', NULL, 15),
(1237, '791689', 'modern suite', 520, '2023-01-11 12:00:00', '2023-01-24 10:00:00', '2023-01-09 04:31:37', '2023-01-09 04:31:37', 'reserved', NULL, 15),
(1242, '331396', 'premium', 290, '2023-01-18 12:00:00', '2023-01-24 10:00:00', '2023-01-09 15:26:02', '2023-01-09 15:26:02', 'reserved', NULL, 15),
(1244, '756366', 'budget', 210, '2023-03-01 12:00:00', '2023-03-05 10:00:00', '2023-01-11 13:18:05', '2023-01-11 13:18:05', 'new', NULL, 15);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_room`
--

CREATE TABLE `tbl_room` (
  `ID` int(11) NOT NULL,
  `ROOMNUM` int(11) NOT NULL,
  `ROOMNAME` varchar(24) DEFAULT NULL,
  `PRICE` float NOT NULL,
  `ROOMCAT` enum('budget','standard','premium','modern suite','luxury suite') NOT NULL DEFAULT 'budget',
  `GuestsMax` int(11) NOT NULL DEFAULT 2,
  `IMAGE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_room`
--

INSERT INTO `tbl_room` (`ID`, `ROOMNUM`, `ROOMNAME`, `PRICE`, `ROOMCAT`, `GuestsMax`, `IMAGE`) VALUES
(1, 101, 'Budget Zimmer', 79, 'budget', 2, 'budget room.png'),
(2, 102, 'Budget Zimmer', 79, 'budget', 2, 'budget room.png'),
(3, 103, 'Budget Zimmer', 79, 'budget', 2, 'budget room.png'),
(4, 201, 'Standard Zimmer', 89, 'standard', 2, 'standard room.png'),
(5, 202, 'Standard Zimmer', 89, 'standard', 2, 'standard room.png'),
(6, 203, 'Standard Zimmer', 89, 'standard', 2, 'standard room.png'),
(7, 301, 'Premium Zimmer', 148, 'premium', 3, 'premium room.png'),
(8, 302, 'Premium Zimmer', 148, 'premium', 3, 'premium room.png'),
(9, 401, 'Modern Suite', 175, 'modern suite', 4, 'modern suite.png'),
(10, 402, 'Modern Suite', 175, 'modern suite', 4, 'modern suite.png'),
(11, 501, 'Royal Suite', 250, 'luxury suite', 5, 'luxury suite.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_login`
--

CREATE TABLE `user_login` (
  `ID` int(16) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `user_login`
--

INSERT INTO `user_login` (`ID`, `username`, `password`, `active`) VALUES
(14, 'max', '$2y$10$Ix8uDAtnSULH6VLDxDAEGu7KARk.X53ewMQemAARLwbJ1cY22/9za', 1),
(15, 'saras', '265a9b497722342d9c3506671e429215', 1),
(20, 'admin', '265a9b497722342d9c3506671e429215', 1),
(21, 'AnnaM', '$2y$10$NwZ7OapOSahLHpbLrQvz.ufNssIcZeiZf38IUcfh8676xQOkSK.ni', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_profile`
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
-- Daten für Tabelle `user_profile`
--

INSERT INTO `user_profile` (`personID`, `role`, `firstName`, `lastName`, `email`, `zipcode`, `city`, `address`, `address2`, `tel`, `salutation`, `target_file`) VALUES
(14, 0, 'Max', 'Mara', 'maram@dd.at', '1110', 'Wien', 'Test2', '4466', '', 'male', '63af39182401e.jpg'),
(15, 0, 'Sara', 'Seey', 'saras@sey.com', '1190', 'Wien', 'Test', '22', '123557', 'female', '63bb427221a02.png'),
(20, 1, 'Admin', 'Test', 'admin@a1.at', '1200', 'Wien', 'Admin-Weg', '111', '0664123457855', 'neutral', NULL),
(21, 0, 'Anna', 'Maier', 'anna@google.com', '1010', 'Wien', 'Teststraße', '1/1/1', '12345678', 'female', NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`RESERVEID`),
  ADD KEY `GUESTID` (`GUESTID`);

--
-- Indizes für die Tabelle `tbl_room`
--
ALTER TABLE `tbl_room`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`personID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT für Tabelle `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `RESERVEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1245;

--
-- AUTO_INCREMENT für Tabelle `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `user_login`
--
ALTER TABLE `user_login`
  MODIFY `ID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD CONSTRAINT `tbl_reservation_ibfk_1` FOREIGN KEY (`GUESTID`) REFERENCES `user_profile` (`personID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `d_ID_pers_user` FOREIGN KEY (`personID`) REFERENCES `user_login` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

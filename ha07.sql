-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2019 at 07:14 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ha07`
--

-- --------------------------------------------------------
DROP Database IF EXISTS ha07; 	
CREATE Database ha07;			
USE ha07;

--
-- Table structure for table `tblavailability`
--

CREATE TABLE `tblavailability` (
  `availID` int(5) NOT NULL,
  `postID` int(5) NOT NULL,
  `daysAvailable` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblavailability`
--

INSERT INTO `tblavailability` (`availID`, `postID`, `daysAvailable`) VALUES
(2, 4, 'Thursday'),
(3, 4, 'Friday'),
(4, 4, 'Saturday'),
(7, 8, 'Monday'),
(8, 8, 'Tuesday'),
(9, 8, 'Wednesday'),
(60, 29, 'Monday'),
(61, 30, 'Monday'),
(62, 30, 'Tuesday'),
(63, 30, 'Wednesday'),
(74, 34, 'Wednesday'),
(75, 34, 'Thursday'),
(90, 32, 'Thursday'),
(91, 32, 'Friday'),
(92, 32, 'Saturday'),
(99, 39, 'Monday'),
(100, 39, 'Tuesday'),
(101, 39, 'Wednesday'),
(102, 31, 'Thursday'),
(103, 31, 'Friday'),
(104, 31, 'Saturday'),
(105, 40, 'Monday'),
(106, 40, 'Tuesday'),
(107, 40, 'Wednesday'),
(108, 40, 'Thursday'),
(109, 40, 'Friday'),
(113, 42, 'Tuesday'),
(114, 42, 'Friday'),
(115, 42, 'Saturday'),
(116, 43, 'Monday'),
(117, 43, 'Tuesday'),
(118, 43, 'Wednesday'),
(119, 44, 'Wednesday'),
(120, 44, 'Thursday'),
(121, 45, 'Tuesday'),
(122, 45, 'Wednesday'),
(123, 45, 'Thursday'),
(124, 46, 'Wednesday'),
(125, 46, 'Thursday');

-- --------------------------------------------------------

--
-- Table structure for table `tblconsumer`
--

CREATE TABLE `tblconsumer` (
  `userID` int(5) NOT NULL,
  `consumerRegDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblconsumer`
--

INSERT INTO `tblconsumer` (`userID`, `consumerRegDate`) VALUES
(5, '2019-03-19'),
(11, '2019-03-30'),
(12, '2019-03-30'),
(13, '2019-04-02'),
(17, '2019-04-09');

-- --------------------------------------------------------

--
-- Table structure for table `tblimages`
--

CREATE TABLE `tblimages` (
  `imageID` int(5) NOT NULL,
  `imageName` varchar(255) DEFAULT NULL,
  `postID` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblimages`
--

INSERT INTO `tblimages` (`imageID`, `imageName`, `postID`) VALUES
(1, '1QbXpzl.jpg', 8),
(3, '4486_deus_ex.jpg', 8),
(5, '32288download.jpg', 9),
(43, '41696download.jpg', 29),
(46, '73819babyboy.jpg', 30),
(47, '73819bella.jpg', 30),
(48, '51760cyberpunk-hd-wallpaper_102104786_292.jpg', 34),
(49, '51760D567feT.jpg', 34),
(74, '899312908750-5015842550-frede.jpg', 40),
(75, '8993115937040_560813030788324_6633396955100558967_o.jpg', 40),
(77, '597154486_deus_ex.jpg', 42),
(78, '21120ivan-.jpg', 44),
(79, '21120sky_lanterns_by_wlop-d7b5nfg.jpg', 44),
(80, '86498download.jpg', 46),
(81, '86498ivan-.jpg', 46);

-- --------------------------------------------------------

--
-- Table structure for table `tblposition`
--

CREATE TABLE `tblposition` (
  `posID` int(5) NOT NULL,
  `positionName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblposition`
--

INSERT INTO `tblposition` (`posID`, `positionName`) VALUES
(1, 'Visitor'),
(2, 'Sitter');

-- --------------------------------------------------------

--
-- Table structure for table `tblpostcreation`
--

CREATE TABLE `tblpostcreation` (
  `serviceID` int(5) NOT NULL,
  `userID` int(5) NOT NULL,
  `postID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpostcreation`
--

INSERT INTO `tblpostcreation` (`serviceID`, `userID`, `postID`) VALUES
(1, 3, 46),
(2, 3, 29),
(2, 3, 30),
(2, 3, 34),
(2, 3, 45),
(2, 5, 12),
(2, 5, 31),
(2, 5, 32),
(2, 5, 39),
(2, 5, 42),
(2, 5, 43),
(2, 5, 44),
(4, 5, 40);

-- --------------------------------------------------------

--
-- Table structure for table `tblservice`
--

CREATE TABLE `tblservice` (
  `serviceID` int(5) NOT NULL,
  `serviceName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblservice`
--

INSERT INTO `tblservice` (`serviceID`, `serviceName`) VALUES
(1, 'Babysitting'),
(2, 'Plantsitting'),
(3, 'Housesitting'),
(4, 'Petsitting');

-- --------------------------------------------------------

--
-- Table structure for table `tblserviceposting`
--

CREATE TABLE `tblserviceposting` (
  `postID` int(5) NOT NULL,
  `postCode` varchar(5) DEFAULT NULL,
  `pricing` decimal(7,0) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `dateMade` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblserviceposting`
--

INSERT INTO `tblserviceposting` (`postID`, `postCode`, `pricing`, `description`, `dateMade`) VALUES
(4, 'PC', '10', 'test					', '0000-00-00'),
(7, 'CA', '15', 'Hello There!					', '0000-00-00'),
(8, 'CA', '14', 'hello there!					', '0000-00-00'),
(9, 'NEW', '20', 'Look meh. 					', '0000-00-00'),
(12, 'MY', '14', 'test date					', '2019-03-30'),
(29, 'SF', '20', 'Description to show pagination stuff 2					', '2019-04-02'),
(30, 'SF', '22', 'Test desc to test pagination xd					', '2019-04-02'),
(31, 'MY', '14', 'Test desc for the search with no image 1					', '2019-04-03'),
(32, 'MY', '15', 'Test desc for the search with no image 2					', '2019-04-03'),
(34, 'SF', '30', 'Test to check the date sorting for the search. 					', '2019-04-05'),
(39, 'MY', '12', 'Description that can identify this thing so I can edit it later ', '2019-04-08'),
(40, 'SF', '50', 'Description for image upload', '2019-04-08'),
(42, 'MY', '18', 'Test description on mozilla to ensure that everything works.', '2019-04-08'),
(43, 'MY', '40', 'Test to ensure that the site works on IE.', '2019-04-08'),
(44, 'SF', '42', 'Personal description test. ', '2019-04-09'),
(45, 'SF', '50', 'Description for the screenshotting. ', '2019-04-10'),
(46, 'MY', '12', 'Babysitting Description', '2019-04-10');

-- --------------------------------------------------------

--
-- Table structure for table `tblsitter`
--

CREATE TABLE `tblsitter` (
  `userID` int(5) NOT NULL,
  `sitterRegDate` date NOT NULL,
  `phoneNumber` int(15) NOT NULL,
  `experience` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsitter`
--

INSERT INTO `tblsitter` (`userID`, `sitterRegDate`, `phoneNumber`, `experience`) VALUES
(3, '2019-04-02', 1234567, 'Test Experience'),
(5, '2019-03-25', 0, ''),
(14, '2019-04-08', 9181345, 'Test Experience');

-- --------------------------------------------------------

--
-- Table structure for table `tblvisitor`
--

CREATE TABLE `tblvisitor` (
  `userID` int(5) NOT NULL,
  `firstname` varchar(25) DEFAULT NULL,
  `lastname` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `vCode` int(5) DEFAULT NULL,
  `accStatus` tinyint(1) DEFAULT NULL,
  `position` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblvisitor`
--

INSERT INTO `tblvisitor` (`userID`, `firstname`, `lastname`, `email`, `password`, `username`, `vCode`, `accStatus`, `position`) VALUES
(3, 'Ryan', 'Deonarine', 'buster00lion@gmail.com', 'dc647eb65e6711e155375218212b3964', 'User2', 54131, 1, 2),
(5, 'Christopher', 'Deonarine', 'rys219@live.com', 'dc647eb65e6711e155375218212b3964', 'User1', 21001, 1, 2),
(11, 'Farida', 'Malik', 'FM@email.com', 'dc647eb65e6711e155375218212b3964', 'User3', 79260, 0, 1),
(12, 'Adam', 'Jensen', 'rys619@live.com', 'dc647eb65e6711e155375218212b3964', 'User4', 75518, 0, 1),
(13, 'Kayle', 'Avira', 'KV@email.com', 'dc647eb65e6711e155375218212b3964', 'Visitor1', 35712, 1, 1),
(14, 'Bob', 'Clyde', 'rys19@live.com', 'dc647eb65e6711e155375218212b3964', 'BobClyde1', 85628, 1, 2),
(17, 'Julian', 'Lewis', 'buster0lion@gmail.com', 'dc647eb65e6711e155375218212b3964', 'TestUser1', 58183, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblavailability`
--
ALTER TABLE `tblavailability`
  ADD PRIMARY KEY (`availID`),
  ADD KEY `postID` (`postID`);

--
-- Indexes for table `tblconsumer`
--
ALTER TABLE `tblconsumer`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `tblimages`
--
ALTER TABLE `tblimages`
  ADD PRIMARY KEY (`imageID`),
  ADD UNIQUE KEY `imageID` (`imageID`),
  ADD KEY `postID` (`postID`);

--
-- Indexes for table `tblposition`
--
ALTER TABLE `tblposition`
  ADD PRIMARY KEY (`posID`),
  ADD UNIQUE KEY `posID` (`posID`);

--
-- Indexes for table `tblpostcreation`
--
ALTER TABLE `tblpostcreation`
  ADD PRIMARY KEY (`serviceID`,`userID`,`postID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `postID` (`postID`),
  ADD KEY `serviceID` (`serviceID`);

--
-- Indexes for table `tblservice`
--
ALTER TABLE `tblservice`
  ADD PRIMARY KEY (`serviceID`),
  ADD UNIQUE KEY `serviceID` (`serviceID`);

--
-- Indexes for table `tblserviceposting`
--
ALTER TABLE `tblserviceposting`
  ADD PRIMARY KEY (`postID`),
  ADD UNIQUE KEY `postID` (`postID`);

--
-- Indexes for table `tblsitter`
--
ALTER TABLE `tblsitter`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `tblvisitor`
--
ALTER TABLE `tblvisitor`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `position` (`position`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblavailability`
--
ALTER TABLE `tblavailability`
  MODIFY `availID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
--
-- AUTO_INCREMENT for table `tblimages`
--
ALTER TABLE `tblimages`
  MODIFY `imageID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `tblposition`
--
ALTER TABLE `tblposition`
  MODIFY `posID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblservice`
--
ALTER TABLE `tblservice`
  MODIFY `serviceID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tblserviceposting`
--
ALTER TABLE `tblserviceposting`
  MODIFY `postID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `tblvisitor`
--
ALTER TABLE `tblvisitor`
  MODIFY `userID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblavailability`
--
ALTER TABLE `tblavailability`
  ADD CONSTRAINT `tblavailability_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `tblserviceposting` (`postID`);

--
-- Constraints for table `tblconsumer`
--
ALTER TABLE `tblconsumer`
  ADD CONSTRAINT `tblconsumer_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `tblvisitor` (`userID`);

--
-- Constraints for table `tblimages`
--
ALTER TABLE `tblimages`
  ADD CONSTRAINT `tblimages_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `tblserviceposting` (`postID`);

--
-- Constraints for table `tblpostcreation`
--
ALTER TABLE `tblpostcreation`
  ADD CONSTRAINT `tblpostcreation_ibfk_1` FOREIGN KEY (`serviceID`) REFERENCES `tblservice` (`serviceID`),
  ADD CONSTRAINT `tblpostcreation_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `tblsitter` (`userID`),
  ADD CONSTRAINT `tblpostcreation_ibfk_3` FOREIGN KEY (`postID`) REFERENCES `tblserviceposting` (`postID`);

--
-- Constraints for table `tblsitter`
--
ALTER TABLE `tblsitter`
  ADD CONSTRAINT `tblsitter_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `tblvisitor` (`userID`);

--
-- Constraints for table `tblvisitor`
--
ALTER TABLE `tblvisitor`
  ADD CONSTRAINT `tblVisitor_ibfk_1` FOREIGN KEY (`position`) REFERENCES `tblposition` (`posID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

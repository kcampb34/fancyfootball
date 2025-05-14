-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2025 at 02:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fancy football`
--

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `TeamID` int(3) NOT NULL,
  `teamname` varchar(40) NOT NULL,
  `scores` int(5) DEFAULT NULL,
  `userID` int(3) NOT NULL,
  `QB` varchar(50) DEFAULT NULL,
  `RB1` varchar(50) DEFAULT NULL,
  `RB2` varchar(50) DEFAULT NULL,
  `WR1` varchar(50) DEFAULT NULL,
  `WR2` varchar(50) DEFAULT NULL,
  `TE` varchar(50) DEFAULT NULL,
  `FLEX` varchar(50) DEFAULT NULL,
  `D/ST` varchar(50) DEFAULT NULL,
  `K` varchar(50) DEFAULT NULL,
  `BE1` varchar(50) DEFAULT NULL,
  `BE2` varchar(50) DEFAULT NULL,
  `BE3` varchar(50) DEFAULT NULL,
  `BE4` varchar(50) DEFAULT NULL,
  `BE5` varchar(50) DEFAULT NULL,
  `BE6` varchar(50) DEFAULT NULL,
  `BE7` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`TeamID`, `teamname`, `scores`, `userID`, `QB`, `RB1`, `RB2`, `WR1`, `WR2`, `TE`, `FLEX`, `D/ST`, `K`, `BE1`, `BE2`, `BE3`, `BE4`, `BE5`, `BE6`, `BE7`) VALUES
(7, 'Sassy Salamanders', 0, 9, 'Brock Purdy', 'Jamyr Gibbs', 'Bijan Robinson', 'Amon-Ra St. Brown', 'Ja\'Marr Chase', 'Brock Bowers', 'Justin Jefferson', 'Broncos D/ST', 'Chris Boswell', 'Lamar Jackson', 'Brian Thomas Jr.', 'Drake London', 'Jonnu Smith', 'De\'Von Achane', 'Packers D/ST', 'Brandon Aubrey');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`TeamID`),
  ADD UNIQUE KEY `userID_2` (`userID`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `TeamID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

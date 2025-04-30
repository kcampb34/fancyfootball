-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2025 at 06:45 AM
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
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `playerID` int(3) NOT NULL,
  `playername` varchar(50) NOT NULL,
  `position` varchar(30) NOT NULL,
  `teamID` int(3) DEFAULT NULL,
  `nflteam` varchar(40) NOT NULL,
  `lastscore` int(3) NOT NULL,
  `totalscore` int(3) NOT NULL,
  `avgscore` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`playerID`, `playername`, `position`, `teamID`, `nflteam`, `lastscore`, `totalscore`, `avgscore`) VALUES
(1, 'Jamyr Gibbs', 'RB', 6, 'Detroit Lions', 26, 362, 21),
(2, 'Saquon Barkley', 'RB', 6, 'Philadelphia Eagles', 19, 355, 22),
(3, 'Bijan Robinson', 'RB', 6, 'Atlanta Falcons', 25, 342, 20),
(4, 'Derrick Henry', 'RB', NULL, 'Baltimore Ravens', 25, 336, 20),
(5, 'Brock Purdy', 'QB', 6, 'SF 49ers', 30, 283, 18),
(6, 'Lamar Jackson', 'QB', NULL, 'Baltimore Ravens', 29, 430, 25),
(7, 'Josh Allen', 'QB', 6, 'Buffalo Bills', 23, 379, 22),
(8, 'De\'Von Achane', 'RB', 6, 'Miami Dolphins', 5, 300, 17),
(13, 'Ja\'Marr Chase', 'WR', NULL, 'Cincinnati Bengals', 19, 403, 24),
(14, 'Justin Jefferson', 'WR', 6, 'Cincinnati Bengals', 17, 317, 18),
(15, 'Amon-Ra St. Brown', 'WR', 6, 'Minnesota Vikings', 20, 316, 19),
(16, 'Brian Thomas Jr.', 'WR', 6, 'Jacksonville Jaguars', 17, 284, 16),
(17, 'Drake London', 'WR', NULL, 'Atlanta Falcons', 17, 280, 16),
(18, 'Brock Bowers', 'TE', 6, 'Las Vegas Raiders', 14, 262, 15),
(19, 'Trey McBride', 'TE', NULL, 'Arizona Cardinals', 30, 249, 15),
(20, 'George Kittle', 'TE', 6, 'SF 49ers', 19, 236, 16),
(21, 'Jonnu Smith', 'TE', NULL, 'Miami Dolphins', 11, 222, 13),
(22, 'Broncos D/ST', 'D/ST', 6, 'Denver Broncos', 3, 166, 10),
(23, 'Vikings D/ST', 'D/ST', 6, 'Minnesota Vikings', 7, 152, 9),
(24, 'Packers D/ST', 'D/ST', 6, 'Green Bay Packers', 0, 140, 8),
(25, 'Chris Boswell', 'K', 6, 'Pittsburgh Steelers', 4, 188, 11),
(26, 'Brandon Aubrey', 'K', 6, 'Dallas Cowboys', 0, 187, 11),
(27, 'Cameron Dicker', 'K', NULL, 'Los Angeles Chargers', 17, 176, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`playerID`),
  ADD KEY `teamID` (`teamID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `playerID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`teamID`) REFERENCES `team` (`TeamID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

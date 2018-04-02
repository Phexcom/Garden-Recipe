-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2018 at 11:20 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `garden`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `R_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ID`, `Name`, `R_ID`) VALUES
(1991, 'Butter', 1);

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `R_ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `S_Description` varchar(30) DEFAULT NULL,
  `L_Description` varchar(60) DEFAULT NULL,
  `Nutritional_value` varchar(50) NOT NULL,
  `Cost` int(11) NOT NULL,
  `TypeOfMeal` varchar(20) NOT NULL,
  `SubmittedBy` int(11) DEFAULT NULL,
  `Main_ingredient` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`R_ID`, `Name`, `S_Description`, `L_Description`, `Nutritional_value`, `Cost`, `TypeOfMeal`, `SubmittedBy`, `Main_ingredient`) VALUES
(1, 'Bread', 'Bread is something we eat', 'bread is something we really like to eat', 'many', 10, 'Breakfast', 20, 1991);

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `Step_No` int(11) NOT NULL,
  `Step` int(11) NOT NULL,
  `R_ID` int(11) NOT NULL,
  `Ingredients_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(6) NOT NULL,
  `Firstname` varchar(30) DEFAULT NULL,
  `Lastname` varchar(30) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Age` int(20) DEFAULT NULL,
  `Address` varchar(40) DEFAULT NULL,
  `Position` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Firstname`, `Lastname`, `Email`, `Age`, `Address`, `Position`) VALUES
(20, 'Rick', 'Andy', 'RA98@yahoo.com', 20, 'rak', 'U');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `R_ID` (`R_ID`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`R_ID`),
  ADD KEY `SubmittedBy` (`SubmittedBy`),
  ADD KEY `Main_ingredient` (`Main_ingredient`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`Step_No`),
  ADD UNIQUE KEY `R_ID` (`R_ID`),
  ADD UNIQUE KEY `Ingredients_ID` (`Ingredients_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `Garden_ID_R_ID` FOREIGN KEY (`R_ID`) REFERENCES `recipe` (`R_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`SubmittedBy`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `recipe_ingredient_fk` FOREIGN KEY (`Main_ingredient`) REFERENCES `ingredients` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `S_I_ID` FOREIGN KEY (`Ingredients_ID`) REFERENCES `ingredients` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `S_R_ID` FOREIGN KEY (`R_ID`) REFERENCES `recipe` (`R_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

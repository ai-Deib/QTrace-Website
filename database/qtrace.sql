-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2026 at 07:15 AM
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
-- Database: `qtrace`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_table`
--

CREATE TABLE `account_table` (
  `Account_Id` int(11) NOT NULL,
  `Image_Path` varchar(100) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Middle_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` int(11) NOT NULL,
  `Contact_Number` bigint(20) NOT NULL,
  `Created_At` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractor_documents_table`
--

CREATE TABLE `contractor_documents_table` (
  `Contractor_Documents_Id` int(11) NOT NULL,
  `Contractor_Id` int(11) NOT NULL,
  `Document_Type` varchar(100) NOT NULL,
  `Document_Path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractor_expertise_table`
--

CREATE TABLE `contractor_expertise_table` (
  `Contractor_Expertise_Id` int(11) NOT NULL,
  `Contractor_Id` int(11) NOT NULL,
  `Expertise` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractor_table`
--

CREATE TABLE `contractor_table` (
  `Contractor_Id` int(11) NOT NULL,
  `Contractor_Logo_Path` varchar(100) NOT NULL,
  `Contractor_Name` varchar(50) NOT NULL,
  `Owner_Name` varchar(50) NOT NULL,
  `Company_Address` varchar(100) NOT NULL,
  `Contact_Number` bigint(20) NOT NULL,
  `Company_Email_Address` varchar(50) NOT NULL,
  `Years_Of_Experience` int(11) NOT NULL,
  `Additional_Notes` varchar(250) NOT NULL,
  `Created_At` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_table`
--
ALTER TABLE `account_table`
  ADD PRIMARY KEY (`Account_Id`);

--
-- Indexes for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  ADD PRIMARY KEY (`Contractor_Documents_Id`);

--
-- Indexes for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  ADD PRIMARY KEY (`Contractor_Expertise_Id`);

--
-- Indexes for table `contractor_table`
--
ALTER TABLE `contractor_table`
  ADD PRIMARY KEY (`Contractor_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_table`
--
ALTER TABLE `account_table`
  MODIFY `Account_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  MODIFY `Contractor_Documents_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  MODIFY `Contractor_Expertise_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contractor_table`
--
ALTER TABLE `contractor_table`
  MODIFY `Contractor_Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

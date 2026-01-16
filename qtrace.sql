-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2026 at 09:33 AM
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
-- Table structure for table `contractor_documents_table`
--

CREATE TABLE `contractor_documents_table` (
  `Contractor_Documents_Id` int(11) NOT NULL,
  `Contractor_Id` int(11) NOT NULL,
  `Document_Type` varchar(255) NOT NULL,
  `Document_Path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractor_documents_table`
--

INSERT INTO `contractor_documents_table` (`Contractor_Documents_Id`, `Contractor_Id`, `Document_Type`, `Document_Path`) VALUES
(12, 10, 'Certificate', '/QTrace-Website/uploads/contractors/documents/BrightBuild_Construction_Co__Certificate.png'),
(13, 11, 'Certificate', '/QTrace-Website/uploads/contractors/documents/Apex_Infrastructure_Solutions_Certificate.png'),
(14, 12, 'License', '/QTrace-Website/uploads/contractors/documents/GreenLine_Engineering_Services_License.png'),
(15, 13, 'License', '/QTrace-Website/uploads/contractors/documents/SolidRock_Builders_License.png'),
(16, 14, 'License', '/QTrace-Website/uploads/contractors/documents/UrbanWorks_Development_Corp__License.png'),
(17, 15, 'License', '/QTrace-Website/uploads/contractors/documents/Horizon_Roadworks_Ltd__License.png'),
(18, 16, 'License', '/QTrace-Website/uploads/contractors/documents/Ironclad_Structures_Inc__License.png'),
(19, 17, 'License', '/QTrace-Website/uploads/contractors/documents/EcoCore_Civil_Engineering_License.png'),
(20, 18, 'License', '/QTrace-Website/uploads/contractors/documents/BlueHammer_Construction_License.png'),
(21, 19, 'License', '/QTrace-Website/uploads/contractors/documents/PrimeAxis_Contractors_License.png');

-- --------------------------------------------------------

--
-- Table structure for table `contractor_expertise_table`
--

CREATE TABLE `contractor_expertise_table` (
  `Contractor_Expertise_Id` int(11) NOT NULL,
  `Contractor_Id` int(11) NOT NULL,
  `Expertise` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractor_expertise_table`
--

INSERT INTO `contractor_expertise_table` (`Contractor_Expertise_Id`, `Contractor_Id`, `Expertise`) VALUES
(18, 10, 'Roadworks'),
(19, 11, 'Roadworks'),
(20, 11, 'Asphalt paving'),
(21, 11, 'Procurement management'),
(22, 12, 'Environmental engineering'),
(23, 13, 'Concrete works'),
(24, 14, 'Site development'),
(25, 14, 'Urban planning'),
(26, 15, 'Highway construction'),
(27, 15, 'Traffic systems'),
(28, 16, 'Steel structures'),
(29, 16, 'Fabrication'),
(30, 16, 'Industrial construction'),
(31, 17, 'Waste systems'),
(32, 17, 'Green buildings'),
(33, 17, 'Water treatment'),
(34, 18, 'Steel structures'),
(35, 18, 'Concrete works'),
(36, 18, 'Foundation engineering'),
(37, 18, 'Heavy equipment operations'),
(38, 19, 'Sustainability planning'),
(39, 19, 'Urban planning'),
(40, 19, 'Cost estimation'),
(41, 19, 'Bidding documentation');

-- --------------------------------------------------------

--
-- Table structure for table `contractor_table`
--

CREATE TABLE `contractor_table` (
  `Contractor_Id` int(11) NOT NULL,
  `Contractor_Logo_Path` varchar(255) NOT NULL,
  `Contractor_Name` varchar(50) NOT NULL,
  `Owner_Name` varchar(50) NOT NULL,
  `Company_Address` varchar(100) NOT NULL,
  `Contact_Number` bigint(20) NOT NULL,
  `Company_Email_Address` varchar(50) NOT NULL,
  `Years_Of_Experience` int(11) NOT NULL,
  `Additional_Notes` varchar(250) NOT NULL,
  `Created_At` date NOT NULL DEFAULT current_timestamp(),
  `Status` enum('Active','Disabled') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractor_table`
--

INSERT INTO `contractor_table` (`Contractor_Id`, `Contractor_Logo_Path`, `Contractor_Name`, `Owner_Name`, `Company_Address`, `Contact_Number`, `Company_Email_Address`, `Years_Of_Experience`, `Additional_Notes`, `Created_At`) VALUES
(10, '/QTrace-Website/uploads/contractors/logos/BrightBuild_Construction_Co__logo.jpg', 'BrightBuild Construction Co.', 'Engr. Marco Dela Cruz', '1186 Quezon Avenue, Diliman, Quezon City 1101', 9172458831, 'marcodelacruz@brightbuild.ph', 12, '', '2026-01-15'),
(11, '/QTrace-Website/uploads/contractors/logos/Apex_Infrastructure_Solutions_logo.jpg', 'Apex Infrastructure Solutions', 'Liza R. Santos', '16 P. Tuazon Blvd, Barangay Kaunlaran, Quezon City 1111', 9281107742, 'liza.santos@apexinfra.ph', 12, '', '2026-01-15'),
(12, '/QTrace-Website/uploads/contractors/logos/GreenLine_Engineering_Services_logo.jpg', 'GreenLine Engineering Services', 'Engr. Paolo Ramirez', '224 Don C. Manuel Avenue, Quezon City 1115', 9954821160, 'pramirez@greenline.ph', 10, '', '2026-01-15'),
(13, '/QTrace-Website/uploads/contractors/logos/SolidRock_Builders_logo.jpg', 'SolidRock Builders', 'Victor M. Tan', '239 Kanlaon Avenue, Quezon City 1114', 9167742309, 'victortan@solidrock.ph', 3, '', '2026-01-15'),
(14, '/QTrace-Website/uploads/contractors/logos/UrbanWorks_Development_Corp__logo.jpg', 'UrbanWorks Development Corp.', 'Carla Joy Mendoza', '28 Kamuning Road, Quezon City 1103', 9305569912, 'carla.mendoza@urbanworks.ph', 20, '', '2026-01-15'),
(15, '/QTrace-Website/uploads/contractors/logos/Horizon_Roadworks_Ltd__logo.jpg', 'Horizon Roadworks Ltd.', 'Engr. Dennis Villanueva', '67 Timog Avenue, South Triangle, Quezon City 1103', 9472225084, 'dvillanueva@horizonworks.ph', 33, '', '2026-01-15'),
(16, '/QTrace-Website/uploads/contractors/logos/Ironclad_Structures_Inc__logo.jpg', 'Ironclad Structures Inc.', 'Engr. Jonathan Cruz', 'Del Monte Avenue, Quezon City 1105', 9926641188, 'jcruz@ironclad.ph', 56, '', '2026-01-15'),
(17, '/QTrace-Website/uploads/contractors/logos/EcoCore_Civil_Engineering_logo.jpg', 'EcoCore Civil Engineering', 'Melissa A. Navarro', 'Agham Road, Quezon City 1103', 9667754203, 'mnavarro@ecocore.ph', 67, '', '2026-01-15'),
(18, '/QTrace-Website/uploads/contractors/logos/BlueHammer_Construction_logo.jpg', 'BlueHammer Construction', 'Roberto Lim', 'Mayon Avenue corner Calamba Street, San Isidro Labrador, Quezon City 1125', 9213806675, 'rlim@bluehammer.ph', 73, '', '2026-01-15'),
(19, '/QTrace-Website/uploads/contractors/logos/PrimeAxis_Contractors_logo.jpg', 'PrimeAxis Contractors', 'Angela T. Flores', 'Banawe Avenue, Quezon City 1105', 9184497311, 'angela.flores@primeaxis.ph', 45, '', '2026-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `projectdetails_table`
--

CREATE TABLE `projectdetails_table` (
  `ProjectDetails_ID` int(11) NOT NULL,
  `Project_ID` int(11) DEFAULT NULL,
  `ProjectDetails_Title` varchar(255) NOT NULL,
  `ProjectDetails_Description` varchar(255) NOT NULL,
  `ProjectDetails_Budget` double NOT NULL,
  `ProjectDetails_Street` varchar(255) NOT NULL,
  `ProjectDetails_Barangay` varchar(255) NOT NULL,
  `ProjectDetails_ZIP_Code` int(11) NOT NULL,
  `ProjectDetails_StartedDate` date DEFAULT NULL,
  `ProjectDetails_EndDate` date DEFAULT NULL,
  `ProjectDetails_CreatedAt` date NOT NULL DEFAULT current_timestamp(),
  `ProjectDetails_UpdatedAT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectdetails_table`
--

INSERT INTO `projectdetails_table` (`ProjectDetails_ID`, `Project_ID`, `ProjectDetails_Title`, `ProjectDetails_Description`, `ProjectDetails_Budget`, `ProjectDetails_Street`, `ProjectDetails_Barangay`, `ProjectDetails_ZIP_Code`, `ProjectDetails_StartedDate`, `ProjectDetails_EndDate`, `ProjectDetails_CreatedAt`, `ProjectDetails_UpdatedAT`) VALUES
(1, 2, 'Project_Test_1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel eros luctus, iaculis dolor vitae, tempor diam. Nulla mauris elit, laoreet in risus nec, consectetur euismod nisl. Morbi sollicitudin mauris a dui faucibus finibus. Fusce nulla mauris, euis', 100000, 'Tandang Sora Avenue', 'Tandang Sora', 1124, '2026-01-15', '2026-01-15', '2026-01-14', NULL),
(2, 3, 'Road Widening', 'test', 109312031203, 'test ', 'test', 1, '2026-01-12', '2027-12-27', '2026-01-15', NULL),
(3, 4, 'Barangay Health Center Renovation', '', 0, 'te', 'test', 12, '0000-00-00', '0000-00-00', '2026-01-15', NULL),
(4, 5, 'City Drainage Improvement Program', 'test', 213123123123, 'test ', 'test ', 12312, '2026-01-16', '2026-01-31', '2026-01-15', NULL),
(5, 7, 'Pedestrian Walkway Enhancement', 'Test edit', 20000000, 'test edit', 'test edit', 123213, '2026-01-15', '2028-03-15', '2026-01-15', NULL),
(6, 8, 'Barangay Health Center Renovation', 'test', 3123123123, 'Belmonte Tunnel', 'Diliman', 1100, '2026-01-11', '2026-08-16', '2026-01-16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projectmilestone_table`
--

CREATE TABLE `projectmilestone_table` (
  `projectMilestone_PhotoID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `projectMilestone_Image_Path` varchar(255) DEFAULT NULL,
  `projectMilestone_Phase` varchar(100) NOT NULL,
  `projectMilestone_CreatedAt` date NOT NULL DEFAULT current_timestamp(),
  `projectMilestone_UploadedAT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectmilestone_table`
--

INSERT INTO `projectmilestone_table` (`projectMilestone_PhotoID`, `Project_ID`, `projectMilestone_Image_Path`, `projectMilestone_Phase`, `projectMilestone_CreatedAt`, `projectMilestone_UploadedAT`) VALUES
(1, 8, '/QTrace-Website/uploads/projects/milestones/IMG_8_1768551015_0.jpg', 'site_progress', '2026-01-16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projectsdocument_table`
--

CREATE TABLE `projectsdocument_table` (
  `ProjectDocument_ID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `ProjectDocument_FileLocation` varchar(255) DEFAULT NULL,
  `ProjectDocument_Type` varchar(255) DEFAULT NULL,
  `ProjectDocument_UploadedAt` datetime DEFAULT current_timestamp(),
  `ProjectDocument_CreatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectsdocument_table`
--

INSERT INTO `projectsdocument_table` (`ProjectDocument_ID`, `Project_ID`, `ProjectDocument_FileLocation`, `ProjectDocument_Type`, `ProjectDocument_UploadedAt`, `ProjectDocument_CreatedAt`) VALUES
(1, 8, '/QTrace-Website/uploads/projects/documents/DOC_8_1768551015_0.pdf', 'Certificate', '2026-01-16 16:10:15', '2026-01-16 16:10:15');

-- --------------------------------------------------------

--
-- Table structure for table `projects_table`
--

CREATE TABLE `projects_table` (
  `Project_ID` int(11) NOT NULL,
  `Contractor_ID` int(11) NOT NULL,
  `Project_Status` varchar(50) NOT NULL,
  `Project_Category` varchar(50) NOT NULL,
  `Project_Lng` decimal(20,8) NOT NULL,
  `Project_Lat` decimal(20,8) NOT NULL,
  `Project_CreatedAt` date DEFAULT curdate(),
  `Project_UpdatedAT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects_table`
--

INSERT INTO `projects_table` (`Project_ID`, `Contractor_ID`, `Project_Status`, `Project_Category`, `Project_Lng`, `Project_Lat`, `Project_CreatedAt`, `Project_UpdatedAT`) VALUES
(7, 15, 'Planning', 'Infrastructure', 121.03468200, 14.61390800, '2026-01-15', NULL),
(8, 11, 'Planning', 'Infrastructure', 121.04993800, 14.64910400, '2026-01-16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_categories`
--

CREATE TABLE `project_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_table`
--

CREATE TABLE `report_table` (
  `report_ID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `report_type` varchar(50) DEFAULT NULL,
  `report_description` varchar(255) DEFAULT NULL,
  `report_evidencesPhoto_URL` varchar(255) DEFAULT NULL,
  `report_status` varchar(50) DEFAULT NULL,
  `report_CreatedAt` datetime DEFAULT current_timestamp(),
  `reportParent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_ID` int(11) NOT NULL,
  `QC_ID_Number` varchar(20) DEFAULT NULL,
  `user_lastName` varchar(50) NOT NULL,
  `user_firstName` varchar(50) NOT NULL,
  `user_middleName` varchar(20) DEFAULT NULL,
  `user_Email` varchar(20) NOT NULL,
  `user_Password` varchar(255) NOT NULL,
  `user_Role` enum('citizen','admin') NOT NULL,
  `user_birthDate` date NOT NULL,
  `user_sex` enum('female','male','other') NOT NULL,
  `user_contactInformation` bigint(20) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `created_At` date NOT NULL DEFAULT current_timestamp(),
  `Status` enum('Active','Disabled') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_ID`, `QC_ID_Number`, `user_lastName`, `user_firstName`, `user_middleName`, `user_Email`, `user_Password`, `user_Role`, `user_birthDate`, `user_sex`, `user_contactInformation`, `user_address`, `created_At`) VALUES
(6, '74373497704', 'Manongdo', 'Gerald', 'P.', 'ipoglang@gmail.com', '$2y$10$ABJV3LTejJGIWKXjcUeS2eUr5/C6P0GzzkCkHWT15Vgyc7y7ThXJe', 'admin', '2005-09-12', 'male', 3123123214, 'blk 51 lt 49 noche buena st. ', '2026-01-11'),
(7, '97192855754', 'Tan', 'Kurt', 'Clet', 'KurtTan@gmail.com', '$2y$10$5x4VPncdSUs9Wg81LIVcbOlcXAsnik7C7ESH5OiSbyyr1UREM56EG', 'citizen', '2006-03-10', 'female', 43243432, '123', '2026-01-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  ADD PRIMARY KEY (`Contractor_Documents_Id`),
  ADD KEY `fk_documents_contractor` (`Contractor_Id`);

--
-- Indexes for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  ADD PRIMARY KEY (`Contractor_Expertise_Id`),
  ADD KEY `fk_expertise_contractor` (`Contractor_Id`);

--
-- Indexes for table `contractor_table`
--
ALTER TABLE `contractor_table`
  ADD PRIMARY KEY (`Contractor_Id`);

--
-- Indexes for table `projectdetails_table`
--
ALTER TABLE `projectdetails_table`
  ADD PRIMARY KEY (`ProjectDetails_ID`);

--
-- Indexes for table `projectmilestone_table`
--
ALTER TABLE `projectmilestone_table`
  ADD PRIMARY KEY (`projectMilestone_PhotoID`),
  ADD KEY `fk_projectMilestone_projects` (`Project_ID`);

--
-- Indexes for table `projectsdocument_table`
--
ALTER TABLE `projectsdocument_table`
  ADD PRIMARY KEY (`ProjectDocument_ID`),
  ADD KEY `fk_projectsDocument_projects` (`Project_ID`);

--
-- Indexes for table `projects_table`
--
ALTER TABLE `projects_table`
  ADD PRIMARY KEY (`Project_ID`),
  ADD KEY `idx_projects_contractor_id` (`Contractor_ID`);

--
-- Indexes for table `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `report_table`
--
ALTER TABLE `report_table`
  ADD PRIMARY KEY (`report_ID`),
  ADD KEY `fk_report_projects` (`Project_ID`),
  ADD KEY `fk_report_user` (`user_ID`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  MODIFY `Contractor_Documents_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  MODIFY `Contractor_Expertise_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `contractor_table`
--
ALTER TABLE `contractor_table`
  MODIFY `Contractor_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `projectdetails_table`
--
ALTER TABLE `projectdetails_table`
  MODIFY `ProjectDetails_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `projectmilestone_table`
--
ALTER TABLE `projectmilestone_table`
  MODIFY `projectMilestone_PhotoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projectsdocument_table`
--
ALTER TABLE `projectsdocument_table`
  MODIFY `ProjectDocument_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects_table`
--
ALTER TABLE `projects_table`
  MODIFY `Project_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_table`
--
ALTER TABLE `report_table`
  MODIFY `report_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  ADD CONSTRAINT `fk_documents_contractor` FOREIGN KEY (`Contractor_Id`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  ADD CONSTRAINT `fk_document_contractor` FOREIGN KEY (`Contractor_Id`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_expertise_contractor` FOREIGN KEY (`Contractor_Id`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projectmilestone_table`
--
ALTER TABLE `projectmilestone_table`
  ADD CONSTRAINT `fk_projectMilestone_projects` FOREIGN KEY (`Project_ID`) REFERENCES `projects_table` (`Project_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `projectsdocument_table`
--
ALTER TABLE `projectsdocument_table`
  ADD CONSTRAINT `fk_projectsDocument_projects` FOREIGN KEY (`Project_ID`) REFERENCES `projects_table` (`Project_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `projects_table`
--
ALTER TABLE `projects_table`
  ADD CONSTRAINT `fk_projects_contractor` FOREIGN KEY (`Contractor_ID`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report_table`
--
ALTER TABLE `report_table`
  ADD CONSTRAINT `fk_report_projects` FOREIGN KEY (`Project_ID`) REFERENCES `projects_table` (`Project_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_report_user` FOREIGN KEY (`user_ID`) REFERENCES `user_table` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

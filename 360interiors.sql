-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2024 at 03:54 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `360interiors`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(15, 'munira', 'abdullah ', 'munira@gmail', '$2y$10$AUPFBOBbijpxEIxW5QRC8e68hA9l51tak7kN.sumAeFB4gu8C/3dC'),
(16, 'Dana ', 'Alomar', 'dana@gmail.com', '$2y$10$2NHfnVn1H.NrMg01thcQUujuriydCEVm51Qb93UBrazmsXJlUL4Pm'),
(17, 'Omar', 'ahmad', 'omar@gmail.com', '$2y$10$b3lxMb0tNlxrvi10MvtyheacEWv09EfarN1uWJHNV6N/OnGNVlF7q');

-- --------------------------------------------------------

--
-- Table structure for table `designcategory`
--

CREATE TABLE `designcategory` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designcategory`
--

INSERT INTO `designcategory` (`id`, `category`) VALUES
(1, 'Modern'),
(2, 'Country'),
(3, 'Coastal'),
(4, 'Bohemian'),
(5, 'Minimalist');

-- --------------------------------------------------------

--
-- Table structure for table `designconsultation`
--

CREATE TABLE `designconsultation` (
  `id` int(11) NOT NULL,
  `requestID` int(11) DEFAULT NULL,
  `consultation` text,
  `consultationImgFileName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designconsultation`
--

INSERT INTO `designconsultation` (`id`, `requestID`, `consultation`, `consultationImgFileName`) VALUES
(5, 20, ' a neutral color palette, blending muted tones like whites, creams, grays, and light wood tones. I hope you can enjoy cooking lovely meals with it', 'woody kitchen.jpg'),
(6, 18, 'i hope we work again', 'coastal living.jpg'),
(7, 16, 'Our design concept revolves around creating a sophisticated and versatile living room that showcases the timeless appeal of grey. The space will be characterized by sleek lines, comfortable furnishings, and tasteful accents, with varying shades of grey adding depth, dimension, and visual interest.', 'grey mini.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `designconsultationrequest`
--

CREATE TABLE `designconsultationrequest` (
  `id` int(11) NOT NULL,
  `clientID` int(11) DEFAULT NULL,
  `designerID` int(11) DEFAULT NULL,
  `roomTypeID` int(11) DEFAULT NULL,
  `designCategoryID` int(11) DEFAULT NULL,
  `roomWidth` decimal(10,2) DEFAULT NULL,
  `roomLength` decimal(10,2) DEFAULT NULL,
  `colorPreferences` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `statusID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designconsultationrequest`
--

INSERT INTO `designconsultationrequest` (`id`, `clientID`, `designerID`, `roomTypeID`, `designCategoryID`, `roomWidth`, `roomLength`, `colorPreferences`, `date`, `statusID`) VALUES
(16, 15, 23, 1, 5, '8.00', '7.00', 'grey and beige', '2024-04-27', 1),
(17, 15, 24, 4, 5, '9.00', '4.00', 'browns', '2024-05-08', 2),
(18, 16, 25, 1, 3, '3.00', '2.00', 'whites and cream', '2024-05-17', 1),
(19, 17, 23, 2, 5, '6.00', '5.00', 'light brown and dark grey', '2024-06-07', 2),
(20, 17, 23, 3, 1, '7.00', '8.00', 'woody and natural greens', '2024-05-27', 1),
(21, 15, 24, 1, 5, '4.00', '5.00', 'beige', '2024-04-13', 3),
(22, 16, 25, 2, 4, '6.00', '6.00', 'straws and burnt orange', '2024-04-06', 3);

-- --------------------------------------------------------

--
-- Table structure for table `designer`
--

CREATE TABLE `designer` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `brandName` varchar(255) NOT NULL,
  `logoImgFileName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designer`
--

INSERT INTO `designer` (`id`, `firstName`, `lastName`, `emailAddress`, `password`, `brandName`, `logoImgFileName`) VALUES
(23, 'Emily ', 'Henderson', 'emily@gmail.com', '$2y$10$gX91gmJfP0X5h0SMg1yJQuLVT2Dm/bop/.F.dGb488ObYT3YGmUeu', 'Chic Interiors', 'uploads/1713364693_Dlogo1.jpg'),
(24, 'Rania', 'Muhammed', 'rania@gmail.com', '$2y$10$fx6hIyGQULhDv.ApYZIHDugHxJ/YLd9CZuTMX8SbaC0wdTQ93xoKe', 'VSHD Design', 'uploads/1713365407_vshd.png'),
(25, 'Justina ', 'Blakeney', 'justina@gmail.com', '$2y$10$fqofNsOnlp5OMmV2dbpZmuc5B7pYdVlU3TYvgat2dCEvL3Mz/lh9m', 'Jungalow', 'uploads/1713366036_b5265483744361a3fc71ce537fb05c42.png');

-- --------------------------------------------------------

--
-- Table structure for table `designerspeciality`
--

CREATE TABLE `designerspeciality` (
  `designerID` int(11) NOT NULL,
  `designCategoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designerspeciality`
--

INSERT INTO `designerspeciality` (`designerID`, `designCategoryID`) VALUES
(23, 1),
(25, 3),
(25, 4),
(23, 5),
(24, 5);

-- --------------------------------------------------------

--
-- Table structure for table `designportfolioproject`
--

CREATE TABLE `designportfolioproject` (
  `id` int(11) NOT NULL,
  `designerID` int(11) DEFAULT NULL,
  `projectName` varchar(255) NOT NULL,
  `projectImgFileName` varchar(255) NOT NULL,
  `description` text,
  `designCategoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designportfolioproject`
--

INSERT INTO `designportfolioproject` (`id`, `designerID`, `projectName`, `projectImgFileName`, `description`, `designCategoryID`) VALUES
(6, 23, 'Japandi lounge', 'uploads/1713364940_japandi project.jpg', 'A minimalist japandi lounge area with neutral colour palette', 5),
(7, 23, 'Kitchen', 'uploads/1713365100_modern kitchen.jpg', 'fresh and modern neutral kitchen.', 1),
(8, 24, 'Weathered rocks', 'uploads/1713365595_vshd-coffee-shop-dubai_dezeen_2364_sq3-1704x958.jpeg', 'colour palette references sand, shells, stone and wood', 5),
(9, 24, 'Penthouse', 'uploads/1713365726_Penthouse-M-by-VSHD-Design-08.jpg', 'inspired by the desert and its surroundings, Penthouse M aims to capture the intense connection between human well-being and nature. The neutral palette of off-whites, cream and earthy tones of dark browns, greys and blacks reflect this bond, gently evoking the colors of the Middle East.', 5),
(10, 25, 'bedroom', 'uploads/1713366162_8d9bde435e2cdae0a3e80046f3a692ba.jpg', 'bohemian bedroom decor moroccan style', 4),
(11, 25, 'SeaSide home', 'uploads/1713366327_coastal calm.jpg', 'This minimalist seaside home gallery is a fantastic way of life that celebrates the simplicity of coastal living', 3);

-- --------------------------------------------------------

--
-- Table structure for table `requeststatus`
--

CREATE TABLE `requeststatus` (
  `id` int(11) NOT NULL,
  `status` enum('pending consultation','consultation declined','consultation provided') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requeststatus`
--

INSERT INTO `requeststatus` (`id`, `status`) VALUES
(1, 'consultation provided'),
(2, 'consultation declined'),
(3, 'pending consultation');

-- --------------------------------------------------------

--
-- Table structure for table `roomtype`
--

CREATE TABLE `roomtype` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roomtype`
--

INSERT INTO `roomtype` (`id`, `type`) VALUES
(1, 'Living Room'),
(2, 'Bedroom'),
(3, 'Kitchen'),
(4, 'Dining Room'),
(5, 'Guest Room');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`);

--
-- Indexes for table `designcategory`
--
ALTER TABLE `designcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designconsultation`
--
ALTER TABLE `designconsultation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requestID` (`requestID`);

--
-- Indexes for table `designconsultationrequest`
--
ALTER TABLE `designconsultationrequest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientID` (`clientID`),
  ADD KEY `designerID` (`designerID`),
  ADD KEY `roomTypeID` (`roomTypeID`),
  ADD KEY `designCategoryID` (`designCategoryID`),
  ADD KEY `statusID` (`statusID`);

--
-- Indexes for table `designer`
--
ALTER TABLE `designer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`);

--
-- Indexes for table `designerspeciality`
--
ALTER TABLE `designerspeciality`
  ADD PRIMARY KEY (`designerID`,`designCategoryID`),
  ADD KEY `designCategoryID` (`designCategoryID`);

--
-- Indexes for table `designportfolioproject`
--
ALTER TABLE `designportfolioproject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designerID` (`designerID`),
  ADD KEY `designCategoryID` (`designCategoryID`);

--
-- Indexes for table `requeststatus`
--
ALTER TABLE `requeststatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roomtype`
--
ALTER TABLE `roomtype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `designcategory`
--
ALTER TABLE `designcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designconsultation`
--
ALTER TABLE `designconsultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `designconsultationrequest`
--
ALTER TABLE `designconsultationrequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `designer`
--
ALTER TABLE `designer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `designportfolioproject`
--
ALTER TABLE `designportfolioproject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `requeststatus`
--
ALTER TABLE `requeststatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roomtype`
--
ALTER TABLE `roomtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `designconsultation`
--
ALTER TABLE `designconsultation`
  ADD CONSTRAINT `designconsultation_ibfk_1` FOREIGN KEY (`requestID`) REFERENCES `designconsultationrequest` (`id`);

--
-- Constraints for table `designconsultationrequest`
--
ALTER TABLE `designconsultationrequest`
  ADD CONSTRAINT `designconsultationrequest_ibfk_1` FOREIGN KEY (`clientID`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_2` FOREIGN KEY (`designerID`) REFERENCES `designer` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_3` FOREIGN KEY (`roomTypeID`) REFERENCES `roomtype` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_4` FOREIGN KEY (`designCategoryID`) REFERENCES `designcategory` (`id`),
  ADD CONSTRAINT `designconsultationrequest_ibfk_5` FOREIGN KEY (`statusID`) REFERENCES `requeststatus` (`id`);

--
-- Constraints for table `designerspeciality`
--
ALTER TABLE `designerspeciality`
  ADD CONSTRAINT `designerspeciality_ibfk_1` FOREIGN KEY (`designerID`) REFERENCES `designer` (`id`),
  ADD CONSTRAINT `designerspeciality_ibfk_2` FOREIGN KEY (`designCategoryID`) REFERENCES `designcategory` (`id`);

--
-- Constraints for table `designportfolioproject`
--
ALTER TABLE `designportfolioproject`
  ADD CONSTRAINT `designportfolioproject_ibfk_1` FOREIGN KEY (`designerID`) REFERENCES `designer` (`id`),
  ADD CONSTRAINT `designportfolioproject_ibfk_2` FOREIGN KEY (`designCategoryID`) REFERENCES `designcategory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

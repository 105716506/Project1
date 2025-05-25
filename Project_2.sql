-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 25, 2025 at 08:48 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Project 2`
--

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(11) NOT NULL,
  `jobRef` varchar(10) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `street` varchar(40) NOT NULL,
  `suburb` varchar(40) NOT NULL,
  `state` varchar(3) NOT NULL,
  `postcode` varchar(4) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `skill1` tinyint(1) DEFAULT 0,
  `skill2` tinyint(1) DEFAULT 0,
  `skill3` tinyint(1) DEFAULT 0,
  `skill4` tinyint(1) DEFAULT 0,
  `otherSkills` text DEFAULT NULL,
  `status` enum('New','Current','Final') DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `jobRef`, `firstName`, `lastName`, `dob`, `gender`, `street`, `suburb`, `state`, `postcode`, `email`, `phone`, `skill1`, `skill2`, `skill3`, `skill4`, `otherSkills`, `status`) VALUES
(1, 'QT123', 'Alice', 'Johnson', '12/05/1990', 'Female', '123 Tech Way', 'Melbourne', 'VIC', '3000', 'alice.j@example.com', '0412345678', 1, 1, 1, 0, 'Experience with AWS and Kubernetes', 'New'),
(2, 'QT124', 'Ben', 'Lee', '08/11/1995', 'Male', '456 UI Lane', 'Sydney', 'NSW', '2000', 'ben.lee@example.com', '0498765432', 1, 1, 0, 1, 'Skilled in Figma and accessibility standards', 'New'),
(3, 'QT125', 'Sophie', 'Nguyen', '20/03/1993', 'Other', '789 Data Dr', 'Brisbane', 'QLD', '4000', 'sophie.n@example.com', '0422333444', 0, 1, 1, 0, 'Power BI expert with strong SQL', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `jobID` int(11) NOT NULL,
  `jobRef` varchar(10) NOT NULL,
  `jobTitle` varchar(100) DEFAULT NULL,
  `salaryRange` varchar(50) DEFAULT NULL,
  `reportsTo` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `positionSummary` text DEFAULT NULL,
  `keyResponsibilities` text DEFAULT NULL,
  `qualifications` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`jobID`, `jobRef`, `jobTitle`, `salaryRange`, `reportsTo`, `category`, `positionSummary`, `keyResponsibilities`, `qualifications`) VALUES
(1, 'QT123', 'Cloud Engineer', '$80k - $100k', 'CTO', 'engineering', 'Responsible for designing and deploying cloud infrastructure.', 'Deploy systems\nMonitor uptime\nEnsure scalability', 'Education\nBachelor’s in Computer Science\n\nSkills\nCloud platforms\nCI/CD pipelines'),
(2, 'QT124', 'Front-End Developer', '$70k - $90k', 'UI/UX Lead', 'design', 'Develop user-friendly and responsive web interfaces.', 'Translate UI/UX designs into code\nOptimize applications for speed and scalability\nCollaborate with backend developers', 'Education\nBachelor’s in Web Development or Design\n\nSkills\nHTML, CSS, JavaScript\nReact or Vue\nFigma or Adobe XD'),
(3, 'QT125', 'Data Analyst', '$85k - $105k', 'Analytics Manager', 'data', 'Analyze business data to deliver actionable insights.', 'Collect and process large datasets\nCreate dashboards and reports\nWork with cross-functional teams', 'Education\nBachelor’s in Data Science or Statistics\n\nSkills\nSQL, Excel, Python\nData visualization tools like Power BI or Tableau');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`jobID`),
  ADD UNIQUE KEY `jobRef` (`jobRef`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `jobID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

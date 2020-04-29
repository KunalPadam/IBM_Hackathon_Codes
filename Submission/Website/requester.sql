-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2020 at 10:18 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `covid-19-india`
--

-- --------------------------------------------------------

--
-- Table structure for table `requester`
--

CREATE TABLE `requester` (
  `REQ_ID` int(50) NOT NULL,
  `USER_NAME` varchar(50) NOT NULL,
  `REQ_TEXT` varchar(512) NOT NULL,
  `LATITUDE` double NOT NULL,
  `LONGITUDE` double NOT NULL,
  `PHONE` bigint(10) NOT NULL,
  `REQ_TYPE` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requester`
--

INSERT INTO `requester` (`REQ_ID`, `USER_NAME`, `REQ_TEXT`, `LATITUDE`, `LONGITUDE`, `PHONE`, `REQ_TYPE`) VALUES
(100, 'demo_final', 'Despite orders to allow newspaper vendors to distribute papers, they are not being allowed to enter in our area. So, the vendors are dropping the copies at the entry gate. Please help.', 22.22, 22.22, 9900990099, 'P2'),
(109, 'arun', 'My grandfather, 90 has been ill for the past three-four days. My mother generally stays with my grandparents but had come to meet us and got stuck. I want to visit them and can I go on my bike. How can this be done?', 9.9252, 78.1198, 9900990099, 'P1'),
(126, 'anoop', 'Despite orders to allow newspaper vendors to distribute papers, they are not being allowed to enter in our area. So, the vendors are dropping the copies at the entry gate. Please help.', 9.9252, 78.1198, 9900990099, 'P2'),
(127, 'arun', 'My grandfather, 90 has been ill for the past three-four days. My mother generally stays with my grandparents but had come to meet us and got stuck. I want to visit them and can I go on my bike. How can this be done?', 9.9252, 78.1198, 9900990099, 'P1'),
(128, 'viral', 'My parents who came to visit my brother who is a doctor are stuck in the city. They are both senior citizens with age related ailments and are at a higher risk of catching Covid-19 since my brother is on duty. How can we get a pass for them to return? Any help will be appreciated.', 9.9252, 78.1198, 9900990099, 'P1'),
(129, 'kunal', 'I need a ticket to watch the latest movie in cinema. It has been so long. Please help', 9.9252, 78.1198, 9900990099, 'P1'),
(130, 'speech_to_text', 'V. are in urgent need of medicines in Lokmanya Tilak hospital also we need some food packets ', 9.9252, 78.1198, 9900990099, 'P1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `requester`
--
ALTER TABLE `requester`
  ADD PRIMARY KEY (`REQ_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `requester`
--
ALTER TABLE `requester`
  MODIFY `REQ_ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

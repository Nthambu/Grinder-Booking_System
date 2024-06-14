-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 10:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookingdata`
--

CREATE TABLE `bookingdata` (
  `id` int(11) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `town` varchar(60) NOT NULL,
  `area` varchar(60) NOT NULL,
  `service` varchar(25) NOT NULL,
  `day` date DEFAULT NULL,
  `booked_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL DEFAULT 'unattended'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingdata`
--

INSERT INTO `bookingdata` (`id`, `fullname`, `email`, `phone`, `town`, `area`, `service`, `day`, `booked_at`, `status`) VALUES
(52, 'elizabeth moraa', 'elizabeth@gmail.com', '0712569800', 'ngong', 'nkoroi', 'Knife', '2024-04-16', '2024-04-20 22:17:03', 'attended'),
(57, 'frankline nthamburi', 'fnthamburi@gmail.com', '0717836779', 'Kiserian', 'maku', 'Axe', '2024-06-14', '2024-06-08 14:06:40', 'attended'),
(58, 'edward frank', 'franklinentamburi@gmail.com', '0717345777', 'Kiserian', 'mabatini', 'Knife', '2024-06-14', '2024-06-08 14:10:50', 'attended'),
(61, 'isoe lyndon', 'lyndon@gmail.com', '0742854389', 'Kiserian', 'nkoroi', 'Knife', '2024-06-10', '2024-06-10 18:20:37', 'attended'),
(62, 'isoe lyndon', 'lyndon@gmail.com', '0742854389', 'Kiserian', 'nkoroi', 'Knife', '2024-06-10', '2024-06-10 18:22:23', 'attended'),
(63, 'isoe lyndon', 'lyndon@gmail.com', '0742854389', 'Kiserian', 'nkoroi', 'Knife', '2024-06-10', '2024-06-10 18:24:31', 'attended'),
(64, 'Frankline Nthamburi', 'fnthamburi@gmail.com', '0717836778', 'Kiserian', 'kise', 'Knife', '2024-06-10', '2024-06-10 18:30:34', 'attended'),
(65, 'isoe lyndon', 'lyndon@gmail.com', '0742854389', 'Kiserian', 'md', 'Knife', '2024-06-10', '2024-06-10 18:43:57', 'attended');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookingdata`
--
ALTER TABLE `bookingdata`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookingdata`
--
ALTER TABLE `bookingdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

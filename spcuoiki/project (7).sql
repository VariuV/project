-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 09:08 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--
CREATE DATABASE project;
USE project;


CREATE TABLE `applications` (
  `app_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `submission_date` datetime NOT NULL,
  `point1` int NOT NULL,
  `point2` int NOT NULL,
  `point3` int(11) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `id_major` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`app_id`, `status`, `submission_date`, `point1`, `point2`, `point3`, `img`, `id_major`) VALUES
(1, 0, '2024-11-20 07:41:37', 1, 2, 3, NULL, 94),
(2, 0, '2024-11-20 08:48:26', 1, 2, 3, NULL, 80);

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `id_major` int(11) NOT NULL,
  `major_name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `hidden` int(11) NOT NULL,
  `id_subject_group` int(11) NOT NULL,
  `id_manager` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`id_major`, `major_name`, `start_date`, `end_date`, `hidden`, `id_subject_group`, `id_manager`) VALUES
(80, 'cntt', '2024-11-13', '2024-11-28', 0, 1, 2),
(89, 'cntt', '2024-11-21', '2024-11-28', 0, 1, 2),
(91, 'li', '2024-11-21', '2024-11-21', 0, 1, 6),
(92, 'cntt', '2024-11-21', '2024-11-28', 0, 1, 6),
(94, 'văn', '2024-11-20', '2024-11-22', 0, 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `subject_group`
--

CREATE TABLE `subject_group` (
  `id_subject_group` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject_group`
--

INSERT INTO `subject_group` (`id_subject_group`, `group_name`, `subject`) VALUES
(1, 'A00', 'Toán,Lý,Hóa'),
(2, 'A01', 'Toán,Lý,Anh'),
(3, 'D01', 'Toán,Văn,Anh'),
(4, 'C00', 'Văn,Sử,Địa');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(250) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` int(4) NOT NULL COMMENT '0:admin, 1:gv , 2:hs\r\n',
  `full_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `role`, `full_name`) VALUES
(1, 'tk1', 'c4ca4238a0b923820dcc509a6f75849b', 0, 'nguyen van a'),
(2, 'tk2', 'c4ca4238a0b923820dcc509a6f75849b', 1, 'nguyen van b'),
(4, 'tk3', 'c4ca4238a0b923820dcc509a6f75849b', 2, 'nguyen van c'),
(6, 'tk4', 'c4ca4238a0b923820dcc509a6f75849b\r\n', 1, 'nguyen văn d\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `fk_major` (`id_major`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`id_major`),
  ADD KEY `fk_subject_gr` (`id_subject_group`),
  ADD KEY `fk_user_id` (`id_manager`);

--
-- Indexes for table `subject_group`
--
ALTER TABLE `subject_group`
  ADD PRIMARY KEY (`id_subject_group`);

--
-- Indexes for table `user`
--


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `major`
--
ALTER TABLE `major`
  MODIFY `id_major` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `subject_group`
--
ALTER TABLE `subject_group`
  MODIFY `id_subject_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_major` FOREIGN KEY (`id_major`) REFERENCES `major` (`id_major`);

--
-- Constraints for table `major`
--
ALTER TABLE `major`
  ADD CONSTRAINT `fk_subject_gr` FOREIGN KEY (`id_subject_group`) REFERENCES `subject_group` (`id_subject_group`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_manager`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE applications
ADD COLUMN student_id INT(11) NOT NULL;

ALTER TABLE applications
ADD COLUMN name VARCHAR(255) NOT NULL,
ADD COLUMN dob DATE NOT NULL,
ADD COLUMN address VARCHAR(255) NOT NULL,
ADD COLUMN id_card VARCHAR(20) NOT NULL,
ADD COLUMN photo VARCHAR(255) DEFAULT NULL,
ADD COLUMN transcript VARCHAR(255) DEFAULT NULL;



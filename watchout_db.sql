-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2020 at 04:40 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `watchout_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_status`
--

CREATE TABLE `tb_status` (
  `status_id` int(3) NOT NULL,
  `status_name` text DEFAULT NULL,
  `status_symbol` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_status`
--

INSERT INTO `tb_status` (`status_id`, `status_name`, `status_symbol`) VALUES
(1, 'รอตรวจสอบ', 'A'),
(2, 'กำลังรักษา', 'B'),
(3, 'หายแล้ว', 'C'),
(4, 'เสียชีวิต', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tracker`
--

CREATE TABLE `tb_tracker` (
  `tracker_id` int(4) UNSIGNED ZEROFILL NOT NULL,
  `tracker_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `tracker_place` varchar(255) DEFAULT NULL,
  `tracker_detail` varchar(255) DEFAULT NULL,
  `tracker_note` varchar(255) DEFAULT NULL,
  `tracker_status` varchar(5) DEFAULT 'A',
  `tracker_lat` text DEFAULT NULL,
  `tracker_lng` text DEFAULT NULL,
  `tracker_end` date DEFAULT NULL,
  `tracker_confine` varchar(5) DEFAULT NULL,
  `confine_start` date DEFAULT NULL,
  `confine_end` date DEFAULT NULL,
  `tracker_save` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_tracker`
--

INSERT INTO `tb_tracker` (`tracker_id`, `tracker_date`, `tracker_place`, `tracker_detail`, `tracker_note`, `tracker_status`, `tracker_lat`, `tracker_lng`, `tracker_end`, `tracker_confine`, `confine_start`, `confine_end`, `tracker_save`) VALUES
(0000, '2020-03-15 17:00:00', 'test', 'test', 'test', '1', '1', '1', '0000-00-00', NULL, NULL, NULL, NULL),
(0001, '2020-03-15 17:00:00', 'โรงเรียนบ้านจันทร์', 'นร.ติดเชื้อจากผู้ปกครองที่พึ่งกลับจากประเทศกลุ่มเสี่ยง', 'มีไข้ 2-3 วัน มีอาการไอ หอบ หายใจลำบาก', 'A', '19.075137801027015', '98.30446243286133', NULL, NULL, NULL, NULL, NULL),
(0002, '2020-03-16 17:00:00', 'โครงการหลวงวัดจันทร์', 'ชาวไทยเพศหญิงกลับจากประเทศกลุ่มเสี่ยง', 'รอดูอาการ', 'A', '19.068102641343952', '98.2926553459667', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_status`
--
ALTER TABLE `tb_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tb_tracker`
--
ALTER TABLE `tb_tracker`
  ADD PRIMARY KEY (`tracker_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_status`
--
ALTER TABLE `tb_status`
  MODIFY `status_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_tracker`
--
ALTER TABLE `tb_tracker`
  MODIFY `tracker_id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

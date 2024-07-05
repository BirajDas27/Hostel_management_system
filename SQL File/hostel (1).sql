-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 04:32 PM
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
-- Database: `hostel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(300) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `reg_date`, `updation_date`) VALUES
(1, 'admin', 'anuj.lpu1@gmail.com', 'Test@1234', '2016-04-04 20:31:45', '2016-04-17');

-- --------------------------------------------------------

--
-- Table structure for table `adminlog`
--

CREATE TABLE `adminlog` (
  `id` int(11) NOT NULL,
  `adminid` int(11) NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `logintime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `date`, `status`) VALUES
(0, 3, '2024-07-04', 'Present'),
(0, 7, '2024-07-05', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('unpaid','paid') DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `paid_date` datetime DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(255) DEFAULT NULL,
  `course_sn` varchar(255) DEFAULT NULL,
  `course_fn` varchar(255) DEFAULT NULL,
  `posting_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_sn`, `course_fn`, `posting_date`) VALUES
(1, 'B10992', 'B.Tech', 'Bachelor  of Technology', '2020-07-04 19:31:42'),
(2, 'BCOM1453', 'B.Com', 'Bachelor Of commerce ', '2020-07-04 19:31:42'),
(3, 'BSC12', 'BSC', 'Bachelor  of Science', '2020-07-04 19:31:42'),
(4, 'BC36356', 'BCA', 'Bachelor Of Computer Application', '2020-07-04 19:31:42'),
(5, 'MCA565', 'MCA', 'Master of Computer Application', '2020-07-04 19:31:42'),
(6, 'MBA75', 'MBA', 'Master of Business Administration', '2020-07-04 19:31:42'),
(7, 'BE765', 'BE', 'Bachelor of Engineering', '2020-07-04 19:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `employee_type` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `join_date` date NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `block_number` varchar(10) NOT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `pin` varchar(20) NOT NULL,
  `photo_path` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `gender`, `employee_type`, `designation`, `join_date`, `salary`, `block_number`, `address`, `email`, `phone_no`, `pin`, `photo_path`) VALUES
(7, 'sdf', 'Male', 'sdf', 'sdf', '2024-07-04', 345.00, 'sf', 'sdfsdfs', 'sfssf@gmail.com', '345345345', '345345', 'uploads/Screenshot 2024-06-30 214453.png');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `content`, `created_at`) VALUES
(8, 'sdfljh sdflshjkdfsdfljk dfsldkjfsdf lfsdlfjk lfsdlfkj df dfklsjdfls jdflskj lsjfsldkj sljs fsf sf sfj sdlfkjs sf sl jsf s', 'fsdfoihsdflsjk   slfj sljfsdflsfjkds lfjssdf ljf \r\nfsdlfkjsf jsflsdjflsjf s\r\nsflsjfsljfsdflksjf lskdfjlsdjf slfj sdlfj slfj  \r\nsdflsf sljf sfsdflj s sfsdf sfsdf sfsdfl sf\r\nsdflj d sdf sdf dfldf df  fldfkjdf sls\r\n', '2024-07-04 16:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `roomno` int(11) DEFAULT NULL,
  `seater` int(11) DEFAULT NULL,
  `feespm` int(11) DEFAULT NULL,
  `foodstatus` int(11) DEFAULT NULL,
  `stayfrom` date DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `course` varchar(500) DEFAULT NULL,
  `regno` int(11) DEFAULT NULL,
  `firstName` varchar(500) DEFAULT NULL,
  `middleName` varchar(500) DEFAULT NULL,
  `lastName` varchar(500) DEFAULT NULL,
  `gender` varchar(250) DEFAULT NULL,
  `contactno` bigint(11) DEFAULT NULL,
  `emailid` varchar(500) DEFAULT NULL,
  `egycontactno` bigint(11) DEFAULT NULL,
  `guardianName` varchar(500) DEFAULT NULL,
  `guardianRelation` varchar(500) DEFAULT NULL,
  `guardianContactno` bigint(11) DEFAULT NULL,
  `corresAddress` varchar(500) DEFAULT NULL,
  `corresCIty` varchar(500) DEFAULT NULL,
  `corresState` varchar(500) DEFAULT NULL,
  `corresPincode` int(11) DEFAULT NULL,
  `pmntAddress` varchar(500) DEFAULT NULL,
  `pmntCity` varchar(500) DEFAULT NULL,
  `pmnatetState` varchar(500) DEFAULT NULL,
  `pmntPincode` int(11) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `roomno`, `seater`, `feespm`, `foodstatus`, `stayfrom`, `duration`, `course`, `regno`, `firstName`, `middleName`, `lastName`, `gender`, `contactno`, `emailid`, `egycontactno`, `guardianName`, `guardianRelation`, `guardianContactno`, `corresAddress`, `corresCIty`, `corresState`, `corresPincode`, `pmntAddress`, `pmntCity`, `pmnatetState`, `pmntPincode`, `postingDate`, `updationDate`) VALUES
(8, 132, 5, 2000, 0, '2024-07-23', 12, 'Master of Business Administration', 11111, 'biraj', '', 'das', 'male', 9864169831, 'birajdas27092002@gmail.com', 545645646, 'dgdfg', 'dgdfgdfg', 565675757, 'fghfhf', 'hfghfh', 'Jharkhand', 5757567, 'fghfhf', 'hfghfh', 'Jharkhand', 5757567, '2024-07-05 12:59:05', NULL),
(9, 132, 5, 2000, 0, '2024-07-19', 6, 'Bachelor Of Computer Application', 666666, 'ssd', '', 'ffs', 'male', 555555555, 'd@gmail.com', 45656456, 'fgh', 'fgh', 6767676767, 'fgh', 'fgh', 'Jammu and Kashmir', 567567, 'fgh', 'fgh', 'Jammu and Kashmir', 567567, '2024-07-05 13:12:20', NULL),
(10, 132, 5, 2000, 0, '2024-07-15', 7, 'Bachelor Of commerce ', 2222, 'a', 'a', 'a', 'female', 22, 'a@gmail.com', 55555555, 'fffff', 'ffff', 666666, 'fffff', 'ff', 'Haryana', 566656, 'fffff', 'ff', 'Haryana', 566656, '2024-07-05 13:15:58', NULL),
(13, 112, 3, 4000, 0, '2024-07-06', 4, 'Bachelor  of Technology', 2323, 'w', 'w', 'w', 'female', 4444444444, 'w@gmail.com', 22222222, 'w', 'w', 222222222, 'w', 'w', 'Lakshadweep (UT)', 222222, 'w', 'w', 'Lakshadweep (UT)', 222222, '2024-07-05 14:20:07', NULL),
(14, 132, 5, 2000, 0, '2024-07-24', 1, 'Bachelor  of Technology', 1212, 'q', 'q', 'q', 'male', 121212121212, 'q@gmail.com', 111111111, 'q', 'q', 111111111, 'q', 'q', 'Jharkhand', 1111111, 'q', 'q', 'Jharkhand', 1111111, '2024-07-05 14:21:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `seater` int(11) DEFAULT NULL,
  `room_no` int(11) DEFAULT NULL,
  `fees` int(11) DEFAULT NULL,
  `posting_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `seater`, `room_no`, `fees`, `posting_date`) VALUES
(1, 5, 100, 8000, '2020-04-11 22:45:43'),
(2, 2, 201, 6000, '2020-04-12 01:30:47'),
(3, 2, 200, 6000, '2020-04-12 01:30:58'),
(4, 3, 112, 4000, '2020-04-12 01:31:07'),
(5, 5, 132, 2000, '2020-04-12 01:31:15');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `bonus_salary` decimal(10,2) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`id`, `employee_id`, `bonus_salary`, `date_added`) VALUES
(4, 7, 44.00, '2024-07-04 16:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `State` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `State`) VALUES
(1, 'Andaman and Nicobar Island (UT)'),
(2, 'Andhra Pradesh'),
(3, 'Arunachal Pradesh'),
(4, 'Assam'),
(5, 'Bihar'),
(6, 'Chandigarh (UT)'),
(7, 'Chhattisgarh'),
(8, 'Dadra and Nagar Haveli (UT)'),
(9, 'Daman and Diu (UT)'),
(10, 'Delhi (NCT)'),
(11, 'Goa'),
(12, 'Gujarat'),
(13, 'Haryana'),
(14, 'Himachal Pradesh'),
(15, 'Jammu and Kashmir'),
(16, 'Jharkhand'),
(17, 'Karnataka'),
(18, 'Kerala'),
(19, 'Lakshadweep (UT)'),
(20, 'Madhya Pradesh'),
(21, 'Maharashtra'),
(22, 'Manipur'),
(23, 'Meghalaya'),
(24, 'Mizoram'),
(25, 'Nagaland'),
(26, 'Odisha'),
(27, 'Puducherry (UT)'),
(28, 'Punjab'),
(29, 'Rajastha'),
(30, 'Sikkim'),
(31, 'Tamil Nadu'),
(32, 'Telangana'),
(33, 'Tripura'),
(34, 'Uttarakhand'),
(35, 'Uttar Pradesh'),
(36, 'West Bengal');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userIp` varbinary(16) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `loginTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `userId`, `userEmail`, `userIp`, `city`, `country`, `loginTime`) VALUES
(6, 2, '10806121', 0x3a3a31, '', '', '2020-07-20 14:56:45'),
(7, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-18 20:03:55'),
(8, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-18 20:30:57'),
(9, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-18 20:40:11'),
(10, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-18 20:59:43'),
(11, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-18 21:01:37'),
(12, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 15:16:24'),
(13, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 15:25:50'),
(14, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 18:19:40'),
(15, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 18:21:30'),
(16, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 18:58:11'),
(17, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 19:43:07'),
(18, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 19:44:28'),
(19, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 20:29:21'),
(20, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 20:30:35'),
(21, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 20:44:04'),
(22, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-19 20:46:57'),
(23, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-20 19:25:34'),
(24, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-21 15:01:11'),
(25, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-21 15:26:16'),
(26, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-21 20:27:31'),
(27, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-21 21:18:45'),
(28, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-21 22:00:38'),
(29, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-22 16:53:08'),
(30, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-22 19:11:20'),
(31, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-22 19:38:04'),
(32, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-22 19:46:49'),
(33, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-22 19:50:09'),
(34, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-22 20:12:09'),
(35, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-22 20:24:45'),
(36, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-23 14:02:46'),
(37, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-23 14:08:41'),
(38, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-23 15:19:17'),
(39, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-23 18:57:05'),
(40, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-23 19:01:38'),
(41, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-25 14:13:49'),
(42, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-25 14:33:56'),
(43, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-25 14:44:04'),
(44, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-25 14:48:58'),
(45, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-25 14:56:28'),
(46, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-25 15:00:46'),
(47, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-25 15:12:12'),
(48, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-25 16:03:12'),
(49, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-26 14:06:49'),
(50, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-26 14:13:21'),
(51, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-26 14:13:48'),
(52, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-26 14:58:42'),
(53, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-26 15:22:03'),
(54, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-06-26 15:22:32'),
(55, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-07-04 16:19:08'),
(56, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-07-04 16:31:47'),
(57, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-07-04 17:52:06'),
(58, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-07-04 17:56:27'),
(59, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-07-04 19:10:57'),
(60, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-07-05 05:24:14'),
(61, 3, 'test@gmail.com', 0x3a3a31, '', '', '2024-07-05 12:04:57'),
(62, 6, 'bd@gmail.com', 0x3a3a31, '', '', '2024-07-05 12:22:11'),
(63, 4, 'gs123@gmail.com', 0x3a3a31, '', '', '2024-07-05 12:31:06'),
(64, 7, 'birajdas27092002@gmail.com', 0x3a3a31, '', '', '2024-07-05 12:48:05'),
(65, 8, 'birajdas27092002@gmail.com', 0x3a3a31, '', '', '2024-07-05 13:06:37'),
(66, 9, 'd@gmail.com', 0x3a3a31, '', '', '2024-07-05 13:11:19'),
(67, 10, 'a@gmail.com', 0x3a3a31, '', '', '2024-07-05 13:15:20'),
(68, 8, 'birajdas27092002@gmail.com', 0x3a3a31, '', '', '2024-07-05 13:19:37'),
(69, 9, 'd@gmail.com', 0x3a3a31, '', '', '2024-07-05 13:20:52'),
(70, 8, 'birajdas27092002@gmail.com', 0x3a3a31, '', '', '2024-07-05 13:21:29'),
(71, 12, 'w@gmail.com', 0x3a3a31, '', '', '2024-07-05 13:25:46'),
(72, 11, 'q@gmail.com', 0x3a3a31, '', '', '2024-07-05 13:27:11'),
(73, 14, 'w@gmail.com', 0x3a3a31, '', '', '2024-07-05 14:19:03'),
(74, 13, 'q@gmail.com', 0x3a3a31, '', '', '2024-07-05 14:21:02');

-- --------------------------------------------------------

--
-- Table structure for table `userregistration`
--

CREATE TABLE `userregistration` (
  `id` int(11) NOT NULL,
  `regNo` varchar(255) DEFAULT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `middleName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `contactNo` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(45) DEFAULT NULL,
  `passUdateDate` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `userregistration`
--

INSERT INTO `userregistration` (`id`, `regNo`, `firstName`, `middleName`, `lastName`, `gender`, `contactNo`, `email`, `password`, `regDate`, `updationDate`, `passUdateDate`) VALUES
(8, '55555', 'biraj', '', 'das', 'male', 9864169831, 'birajdas27092002@gmail.com', '1q2w3e', '2024-07-05 13:06:25', NULL, NULL),
(9, '666666', 'ssd', '', 'ffs', 'male', 555555555, 'd@gmail.com', '333', '2024-07-05 13:10:39', NULL, NULL),
(10, '2222', 'a', 'a', 'a', 'female', 22, 'a@gmail.com', 'a', '2024-07-05 13:15:03', NULL, NULL),
(13, '1212', 'q', 'q', 'q', 'male', 121212121212, 'q@gmail.com', 'q', '2024-07-05 14:18:01', NULL, NULL),
(14, '2323', 'w', 'w', 'w', 'female', 4444444444, 'w@gmail.com', 'w', '2024-07-05 14:18:38', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_bill_fk` (`bill_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regno` (`regno`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_no` (`room_no`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userregistration`
--
ALTER TABLE `userregistration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `userregistration`
--
ALTER TABLE `userregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `registration` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_bill_fk` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`);

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

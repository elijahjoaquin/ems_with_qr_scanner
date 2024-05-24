-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2022 at 04:32 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leave_staff`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2020-11-03 05:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `qr_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `status` int(11) NOT NULL,
  `time_out` time NOT NULL,
  `num_hr` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `qr_id`, `date`, `time_in`, `status`, `time_out`, `num_hr`) VALUES
(140, 7, '2022-10-21', '13:55:18', 1, '13:55:20', 0),
(142, 15, '2022-10-22', '08:12:22', 1, '08:12:25', 0),
(146, 14, '2022-10-23', '09:19:12', 1, '09:20:01', 0),
(148, 14, '2022-10-25', '17:08:17', 1, '17:08:31', 0),
(149, 5, '2022-10-27', '07:00:47', 1, '22:22:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(100) NOT NULL,
  `Department` varchar(250) DEFAULT NULL,
  `Time` varchar(250) NOT NULL,
  `Day` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `Department`, `Time`, `Day`) VALUES
(2, 'Sales and Logistics Department', '8:00 am – 5:00 pm', 'Monday - Friday'),
(3, 'Productions Department', '8:00 am – 5:00 pm', 'Monday - Friday'),
(7, 'HR Department', '8:00 am – 5:00 pm', 'Monday - Friday'),
(9, 'Sales and Logistics Department', '5:00am -5:00pm', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartments`
--

CREATE TABLE `tbldepartments` (
  `id` int(11) NOT NULL,
  `DepartmentName` varchar(150) DEFAULT NULL,
  `DepartmentShortName` varchar(100) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbldepartments`
--

INSERT INTO `tbldepartments` (`id`, `DepartmentName`, `DepartmentShortName`, `CreationDate`) VALUES
(2, 'Sales and Logistics Department', 'SLD', '2017-11-01 07:19:37'),
(3, 'HR Department', 'HRD', '2021-05-21 08:27:45'),
(4, 'Productions Department', 'PRD', '2022-10-04 06:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployees`
--

CREATE TABLE `tblemployees` (
  `emp_id` int(11) NOT NULL,
  `qr_id` varchar(15) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `EmailId` varchar(200) NOT NULL,
  `Password` varchar(180) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Dob` varchar(100) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Av_leave` varchar(150) NOT NULL,
  `Av_overtime` varchar(150) NOT NULL,
  `Phonenumber` char(11) NOT NULL,
  `Status` int(1) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(30) NOT NULL,
  `location` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblemployees`
--

INSERT INTO `tblemployees` (`emp_id`, `qr_id`, `FirstName`, `LastName`, `EmailId`, `Password`, `Gender`, `Dob`, `Department`, `Address`, `Av_leave`, `Av_overtime`, `Phonenumber`, `Status`, `RegDate`, `role`, `location`) VALUES
(2, '', 'Neil', 'Curato', 'neil@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'Male', '9 December, 2000', 'ICT', 'Quezon City', '30', '10', '8587944255', 1, '2017-11-10 13:40:02', 'Admin', 'NEIL ID.jpg'),
(5, 'DOC598014763', 'Gabriel', 'Austria', 'gabaludgreat@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'Male', '02 September 2000', 'SLD', 'Montalban', '28', '10', '09167851481', 1, '2017-11-10 13:40:02', 'HOD', 'Gablog.jpg'),
(7, 'DOC598014763', 'Elijah', 'Lopez', 'ej@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 'male', '09 November 2000', 'SLD', 'Marikina', '30', '10', '09297995505', 1, '2017-11-10 13:40:02', 'Staff', 'milord.png'),
(13, '', 'Neil Antonio', 'Curato', 'curatoneil@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'male', '09 December 2000', 'HRD', '5 Chevelle St. Fairview Quezon City, 5 Chevelle St. Fairview Quezon City', '10', '10', '09195171010', 1, '2022-10-04 06:15:19', 'Admin', 'NO-IMAGE-AVAILABLE.jpg'),
(14, '4806513690563', 'Kohj', 'Quilab', 'noah@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'female', '21 August 2000', 'PRD', 'Quezon City', '28', '10', '09127995565', 1, '2022-10-04 06:48:30', 'Staff', 'kohj.png'),
(15, '4806513690561', 'Noah', 'Quilab', 'kohj@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'male', '04 January 2000', 'SLD', 'Quezon City', '20', '10', '9999999999', 1, '2022-10-04 07:23:37', 'Staff', 'NO-IMAGE-AVAILABLE.jpg'),
(16, 'DOC598014765', 'test', 'test', 'test@gmail.com', '4a2028eceac5e1f4d252ea13c71ecec6', 'male', '05 October 2022', 'SLD', 'quezon city', '30', '10', '999999', 1, '2022-10-04 07:32:56', 'HOD', 'NO-IMAGE-AVAILABLE.jpg'),
(17, 'HFC270168435', 'Testest', 'Testestest', 'testest@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'male', '02 February 2000', 'SLD', 'testtestestsetest', '30', '10', '66666666666', 1, '2022-10-22 00:33:31', 'Staff', 'NO-IMAGE-AVAILABLE.jpg'),
(18, 'KIU359187420', 'Bobs', 'Marley', 'bob@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'male', '01 January 2000', 'SLD', '#5 Test at lorem ipsum bldg', '30', '15', '67777777777', 1, '2022-10-23 01:15:26', 'Staff', 'NO-IMAGE-AVAILABLE.jpg'),
(19, 'DVU754630918', 'Joaquin', 'Lopez', 'test2@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'male', '02 February 2000', 'SLD', 'test', '15', '15', '66666666666', 1, '2022-10-27 14:04:02', 'HOD', 'NO-IMAGE-AVAILABLE.jpg'),
(20, 'JVH307498651', 'test', 'test', 'prd@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'male', '03 February 2000', 'PRD', 'test', '15', '15', '55555555555', 1, '2022-10-27 14:11:42', 'Staff', 'NO-IMAGE-AVAILABLE.jpg'),
(21, 'OFI738495602', 'prdman', 'prdman', 'prdman@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'male', '02 February 2000', 'PRD', 'test', '15', '15', '55555555555', 1, '2022-10-27 14:28:40', 'HOD', 'NO-IMAGE-AVAILABLE.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblevaluation`
--

CREATE TABLE `tblevaluation` (
  `id` int(11) NOT NULL,
  `Question1` varchar(120) NOT NULL,
  `Question2` varchar(120) NOT NULL,
  `Question3` varchar(120) NOT NULL,
  `Question4` varchar(120) NOT NULL,
  `Question5` varchar(120) NOT NULL,
  `PostingDate` date NOT NULL,
  `Remarks` varchar(500) NOT NULL,
  `empid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblevaluation`
--

INSERT INTO `tblevaluation` (`id`, `Question1`, `Question2`, `Question3`, `Question4`, `Question5`, `PostingDate`, `Remarks`, `empid`) VALUES
(14, 'Excellent', 'Good', 'Fair', 'Poor', 'Excellent', '2022-10-24', 'test1', 7),
(15, 'Good', 'Good', 'Poor', 'Good', 'Excellent', '2022-10-25', 'test 1', 5),
(16, 'Good', 'Good', 'Good', 'Good', 'Good', '2022-10-25', 'umay', 5),
(17, 'Good', 'Poor', 'Good', 'Good', 'Fair', '2022-10-25', 'HMMM', 16),
(18, 'Excellent', 'Poor', 'Good', 'Fair', 'Excellent', '2022-10-25', 'okay', 14),
(19, 'Excellent', 'Excellent', 'Good', 'Fair', 'Poor', '2022-10-27', 'Keep it up', 15);

-- --------------------------------------------------------

--
-- Table structure for table `tblleaves`
--

CREATE TABLE `tblleaves` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(110) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` date NOT NULL,
  `AdminRemark` mediumtext DEFAULT NULL,
  `registra_remarks` mediumtext NOT NULL,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `admin_status` int(11) NOT NULL DEFAULT 0,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL,
  `num_days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblleaves`
--

INSERT INTO `tblleaves` (`id`, `LeaveType`, `ToDate`, `FromDate`, `Description`, `PostingDate`, `AdminRemark`, `registra_remarks`, `AdminRemarkDate`, `Status`, `admin_status`, `IsRead`, `empid`, `num_days`) VALUES
(13, 'Casual Leave', '2021-05-02', '2021-05-12', 'I want to take a leave.', '2021-05-20', 'Ok', 'ok', '2021-05-24 20:26:19 ', 1, 1, 1, 7, 3),
(14, 'Medical Leave', '08-05-2021', '11-05-2021', 'Noted', '0000-00-00', 'Not this time', '', '2021-05-21 0:31:10 ', 0, 0, 1, 6, 4),
(19, 'Casual Leave', '27-09-2022', '27-10-2022', 'test', '2022-09-26', NULL, '', NULL, 0, 0, 1, 9, 31),
(20, 'Casual Leave', '26-09-2022', '28-10-2022', 'test', '2022-09-26', 'oaky', '', '2022-10-01 18:09:41 ', 1, 0, 1, 9, 33),
(21, 'Medical Leave', '01-09-2022', '02-09-2022', '314r13te', '2022-09-26', 'ok', 'no', '2022-10-01 17:55:34 ', 1, 2, 1, 9, 2),
(22, 'Casual Leave', '09-28-2022', '10-26-2022', 'test', '2022-09-26', 'naur', 'Leave was Rejected. Registra/Registry will not see it', '2022-10-01 17:07:10 ', 2, 2, 1, 9, 29),
(23, 'Casual Leave', '2022-10-05', '2022-10-06', 'Vacation', '2022-10-04', 'Okay', 'Okay', '2022-10-04 13:07:49 ', 1, 1, 1, 14, 2),
(24, 'Casual Leave', '2022-10-25', '2022-10-26', 'testtest', '2022-10-23', NULL, '', NULL, 0, 0, 0, 14, 2),
(25, 'Vacation Leave', '10-25-2022', '10-26-2022', 'vacation', '2022-10-25', NULL, '', NULL, 0, 0, 0, 5, 2),
(26, 'Vacation Leave', '10-25-2022', '10-26-2022', 'test', '2022-10-25', NULL, '', NULL, 3, 0, 0, 5, 2),
(27, 'Vacation Leave', '10-25-2022', '10-27-2022', 'vacationism', '2022-10-25', NULL, '', NULL, 3, 0, 1, 5, 3),
(28, 'Vacation Leave', '10-28-2022', '10-29-2022', 'test', '2022-10-27', NULL, 'good to go', '2022-10-27 19:36:38 ', 0, 1, 1, 5, 2),
(29, 'Vacation Leave', '2022-10-27', '2022-10-28', 'test', '2022-10-27', NULL, '', NULL, 0, 0, 0, 20, 2),
(30, 'Sick Leave', '2022-10-30', '2022-10-31', 'test', '2022-10-27', 'test', 'Leave was Rejected. Registra/Registry will not see it', '2022-10-27 19:59:35 ', 2, 2, 1, 20, 2),
(31, 'Emergency Leave', '2022-10-27', '2022-10-27', 'test', '2022-10-27', 'oks\r\n', '', '2022-10-27 19:59:20 ', 1, 0, 1, 20, 1),
(32, 'Vacation Leave', '10-28-2022', '10-29-2022', 'test', '2022-10-27', NULL, '', NULL, 0, 0, 0, 21, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype`
--

CREATE TABLE `tblleavetype` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblleavetype`
--

INSERT INTO `tblleavetype` (`id`, `LeaveType`, `Description`, `CreationDate`) VALUES
(5, 'Vacation Leave', 'Vacation ', '2021-05-19 14:32:03'),
(6, 'Sick Leave', 'Sick', '2021-05-19 15:29:05'),
(8, 'Emergency Leave', 'For Emergencies', '2021-05-20 17:17:43');

-- --------------------------------------------------------

--
-- Table structure for table `tblovertime`
--

CREATE TABLE `tblovertime` (
  `id` int(11) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` date NOT NULL,
  `AdminRemark` varchar(150) DEFAULT NULL,
  `registra_remarks` mediumtext NOT NULL,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `admin_status` int(11) NOT NULL DEFAULT 0,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL,
  `num_hrs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblovertime`
--

INSERT INTO `tblovertime` (`id`, `FromDate`, `Description`, `PostingDate`, `AdminRemark`, `registra_remarks`, `AdminRemarkDate`, `Status`, `admin_status`, `IsRead`, `empid`, `num_hrs`) VALUES
(25, '28-09-2022', 'Test', '2022-09-28', NULL, 'Naur', '2022-10-01 12:37:24 ', 1, 2, 1, 7, 4),
(28, '10-01-2022', 'test', '0000-00-00', 'no', 'Overtime was Rejected. Registra/Registry will not see it', '2022-10-01 17:45:02 ', 2, 2, 1, 7, 18),
(29, '10-01-2022', 'teestttestest', '0000-00-00', 'Okay', 'OLRAYT', '2022-10-01 18:14:07 ', 1, 1, 1, 7, 12),
(30, '10-08-2022', 'test', '2022-10-01', 'ok', 'Overtime was Rejected. Registra/Registry will not see it', '2022-10-01 17:33:43 ', 1, 2, 1, 7, 1),
(31, '10-08-2022', 'yknow', '2022-10-01', NULL, '', NULL, 0, 0, 1, 7, 4),
(32, '10-01-2022', 'test', '2022-10-23', NULL, '', NULL, 0, 0, 0, 14, 2),
(37, '10-01-2022', 'test', '2022-10-25', NULL, '', NULL, 3, 0, 1, 5, 2),
(38, '10-21-2022', 'test', '2022-10-27', NULL, '', NULL, 3, 0, 0, 5, 2),
(39, '10-27-2022', 'test', '2022-10-27', NULL, '', NULL, 0, 0, 0, 20, 2),
(40, '10-27-2022', 'test', '2022-10-27', NULL, '', NULL, 0, 0, 0, 20, 2),
(41, '10-27-2022', 'test', '2022-10-27', 'test', '', '2022-10-27 20:00:03 ', 1, 0, 1, 20, 2),
(42, '10-28-2022', 'test', '2022-10-27', NULL, '', NULL, 3, 0, 0, 21, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblquestions`
--

CREATE TABLE `tblquestions` (
  `id` int(11) NOT NULL,
  `Question1` varchar(120) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Question2` varchar(120) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Question3` varchar(120) NOT NULL,
  `Question4` varchar(120) NOT NULL,
  `Question5` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblquestions`
--

INSERT INTO `tblquestions` (`id`, `Question1`, `Question2`, `Question3`, `Question4`, `Question5`) VALUES
(1, 'Excellent', 'Excellent', 'Excellent', 'Excellent', 'Excellent'),
(2, 'Good', 'Good', 'Good', 'Good', 'Good'),
(6, 'Fair', 'Fair', 'Fair', 'Fair', 'Fair'),
(7, 'Poor', 'Poor', 'Poor', 'Poor', 'Poor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblemployees`
--
ALTER TABLE `tblemployees`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `tblevaluation`
--
ALTER TABLE `tblevaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empi` (`empid`);

--
-- Indexes for table `tblleaves`
--
ALTER TABLE `tblleaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserEmail` (`empid`);

--
-- Indexes for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblovertime`
--
ALTER TABLE `tblovertime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserEmail` (`empid`);

--
-- Indexes for table `tblquestions`
--
ALTER TABLE `tblquestions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblemployees`
--
ALTER TABLE `tblemployees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblevaluation`
--
ALTER TABLE `tblevaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblleaves`
--
ALTER TABLE `tblleaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblovertime`
--
ALTER TABLE `tblovertime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tblquestions`
--
ALTER TABLE `tblquestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

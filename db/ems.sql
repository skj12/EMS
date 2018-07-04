-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 04, 2018 at 01:14 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `AdminTbl`
--

CREATE TABLE `AdminTbl` (
  `id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `companyId` int(11) NOT NULL,
  `Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AdminTbl`
--

INSERT INTO `AdminTbl` (`id`, `UserId`, `companyId`, `Date`) VALUES
(1, 3, 1, NULL),
(2, 5, 2, '2018-07-02 16:39:25'),
(3, 11, 3, '2018-07-04 11:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `Announcements`
--

CREATE TABLE `Announcements` (
  `id` int(11) NOT NULL,
  `Title` varchar(80) NOT NULL,
  `Details` text NOT NULL,
  `Creation` date NOT NULL,
  `DateTillDisplay` date NOT NULL,
  `CompanyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Attendance`
--

CREATE TABLE `Attendance` (
  `id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Date` date NOT NULL,
  `CheckIn` time DEFAULT NULL,
  `CheckOut` time DEFAULT NULL,
  `Status` varchar(20) NOT NULL,
  `ApprovationStatus` int(11) NOT NULL DEFAULT '0',
  `CompanyID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `BankDetails`
--

CREATE TABLE `BankDetails` (
  `UserId` int(11) NOT NULL,
  `PaymentMode` varchar(30) NOT NULL,
  `BankName` varchar(50) NOT NULL,
  `BankAccNo` bigint(20) NOT NULL,
  `BankIFSCCode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `CompTbl`
--

CREATE TABLE `CompTbl` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `mail` varchar(60) DEFAULT NULL,
  `contactno` varchar(18) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `DateofReg` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `CompTbl`
--

INSERT INTO `CompTbl` (`id`, `name`, `address`, `website`, `mail`, `contactno`, `logo`, `DateofReg`) VALUES
(1, 'nd', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'wittyfeedd', 'indore', 'wittyfeed.com', 'hr@wittyfeed.com', '9898989898', NULL, '2018-07-02 16:39:25'),
(3, 'TempMail Pvt ltd', 'newyork', 'tempmail.org', 'hucati@99pubblicita.com', '7878787878', NULL, '2018-07-04 11:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `Designations`
--

CREATE TABLE `Designations` (
  `DesgnId` int(11) NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Documents`
--

CREATE TABLE `Documents` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Link` varchar(80) NOT NULL,
  `Date` date NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `UploadedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `EmploymentDetails`
--

CREATE TABLE `EmploymentDetails` (
  `RelationId` int(11) NOT NULL,
  `EmployeeId` varchar(10) NOT NULL,
  `UserId` int(11) NOT NULL,
  `joiningdate` date DEFAULT NULL,
  `ConfirmationDate` date DEFAULT NULL,
  `EffectiveFrom` date NOT NULL,
  `EffectiveTo` date DEFAULT NULL,
  `EmployeeStatus` varchar(15) NOT NULL,
  `Designation` int(11) NOT NULL,
  `Location` varchar(80) NOT NULL,
  `EmploymentType` varchar(25) NOT NULL,
  `Action` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Invites`
--

CREATE TABLE `Invites` (
  `inviteid` int(11) NOT NULL,
  `emailid` varchar(50) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `companyid` int(11) NOT NULL,
  `invitetime` datetime NOT NULL,
  `used` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Leave`
--

CREATE TABLE `Leave` (
  `id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ReferenceReq` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date DEFAULT NULL,
  `ApprovationBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveAllowance`
--

CREATE TABLE `LeaveAllowance` (
  `UserId` int(11) NOT NULL,
  `LeavesAllowed` int(11) NOT NULL DEFAULT '4'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveReq`
--

CREATE TABLE `LeaveReq` (
  `ReqId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Category` varchar(30) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date DEFAULT NULL,
  `ApprovationStatus` varchar(15) NOT NULL,
  `Reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ReportingSupervisor`
--

CREATE TABLE `ReportingSupervisor` (
  `UserId` int(11) NOT NULL,
  `RSup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `UserId` int(11) NOT NULL,
  `CTCEffectiveFron` date NOT NULL,
  `CTCEffectiveTo` date DEFAULT NULL,
  `MonthlyGross` int(11) DEFAULT NULL,
  `MonthlyCTC` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Team`
--

CREATE TABLE `Team` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `CompanyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TeamAlloted`
--

CREATE TABLE `TeamAlloted` (
  `UserId` int(11) NOT NULL,
  `TeamId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UsersDetails`
--

CREATE TABLE `UsersDetails` (
  `UserId` int(11) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) DEFAULT NULL,
  `ContactNo` varchar(20) NOT NULL,
  `Address1` varchar(200) DEFAULT NULL,
  `Address2` varchar(200) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(30) DEFAULT NULL,
  `PinCode` int(11) DEFAULT NULL,
  `BloodGroup` varchar(10) DEFAULT NULL,
  `PAN` varchar(20) DEFAULT NULL,
  `AadharNo` varchar(20) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `MartailStatus` varchar(10) DEFAULT NULL,
  `Dob` date DEFAULT NULL,
  `Disability` int(20) DEFAULT NULL,
  `FatherName` varchar(50) NOT NULL,
  `ParentsSeniority` int(11) DEFAULT NULL,
  `ParentsDisability` int(11) DEFAULT NULL,
  `Children` int(11) DEFAULT NULL,
  `HostelerChildren` int(11) DEFAULT NULL,
  `img` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `UsersDetails`
--

INSERT INTO `UsersDetails` (`UserId`, `FirstName`, `LastName`, `ContactNo`, `Address1`, `Address2`, `City`, `State`, `PinCode`, `BloodGroup`, `PAN`, `AadharNo`, `Gender`, `MartailStatus`, `Dob`, `Disability`, `FatherName`, `ParentsSeniority`, `ParentsDisability`, `Children`, `HostelerChildren`, `img`) VALUES
(4, 'Narender', 'Singh', '9996990458', 'iuu', 'nmbn', 'Indore', 'MP', 121212, 'B+', '12121212', '124124124124', 'male', 'unmarried', '2020-08-03', 0, 'n', 0, 0, 0, 0, ''),
(5, 'anubha', 'Singh', '9898989898', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, ''),
(6, 'narender', 'singh', '999999555', 'io', 'jh', 'jjj', 'jkj', 15155, 'b+', '15551561', '1555551561516515', 'male', 'unmarried', '2020-09-04', 0, 'fytgjhjas', 0, 0, 0, 0, ''),
(7, 'ghjbnm,', 'vbjknm', 'jvbhknm', 'jnlk,m', 'kbjkn', 'kjnjk', 'njkbkj', 56543, 'B+', '145654894', '24465456454646', 'male', 'unmarried', '2019-06-13', 0, 'bkjnkjhkj', 0, 0, 0, 0, ''),
(9, 'nd', 'nd', '9889889898', 'Bh3 , Gjust', 'bh3', 'Hisar', 'haryana', 125001, 'B+', '989889898', '457854784578', 'male', 'unmarried', '1995-09-05', 0, 'x', 1, 0, 0, 0, ''),
(10, 'Shubham', 'Jain', '9898989898', 'io', 'bh3', 'Indore', 'haryana', 121212, 'B+', '12121212', '1555551561516515', 'male', 'unmarried', '2019-08-05', 0, 'bkjnkjhkj', 0, 0, 0, 0, ''),
(11, 'Admin', 'admin', '9898989898', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `Usertbl`
--

CREATE TABLE `Usertbl` (
  `UserId` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `accountstatus` int(11) NOT NULL DEFAULT '0',
  `Email` varchar(50) NOT NULL,
  `accountlevel` int(11) NOT NULL DEFAULT '0',
  `companyId` int(11) NOT NULL,
  `emailverified` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Usertbl`
--

INSERT INTO `Usertbl` (`UserId`, `password`, `accountstatus`, `Email`, `accountlevel`, `companyId`, `emailverified`) VALUES
(3, 'a69913f66f2cfd4bd3f8ea75954ac476', 1, '123@g.c', 1, 1, 1),
(4, 'nd', 0, 'nd@d.com', 0, 1, 0),
(5, 'a69913f66f2cfd4bd3f8ea75954ac476', 1, 'hr@wittyfeed.com', 1, 2, 1),
(6, 'nd', 0, 'nd', 0, 1, 0),
(7, 'a69913f66f2cfd4bd3f8ea75954ac476', 0, 'nd@gm.co', 0, 1, 0),
(9, 'a69913f66f2cfd4bd3f8ea75954ac476', 0, 'nd@nd.com', 0, 2, 0),
(10, '267712a0135b511f5cfdb94c8dd409bc', 0, 'shubhainpa@gmail.com', 0, 1, 0),
(11, '6a962563e235e1789e663e356ac8d9e4', 1, 'hucati@99pubblicita.com', 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Verifyhash`
--

CREATE TABLE `Verifyhash` (
  `hashid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Verifyhash`
--

INSERT INTO `Verifyhash` (`hashid`, `userid`, `hash`, `active`) VALUES
(1, 5, 'ffcefa67921ebfe82e74a2ebf338ffe5', 1),
(2, 10, 'b891d21f6803b75700c9e762838dcf87', 1),
(3, 11, 'a9d22362f2e56949aa2655d858017fc4', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AdminTbl`
--
ALTER TABLE `AdminTbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `companyId` (`companyId`);

--
-- Indexes for table `Announcements`
--
ALTER TABLE `Announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CompanyId` (`CompanyId`);

--
-- Indexes for table `Attendance`
--
ALTER TABLE `Attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `CompanyID` (`CompanyID`);

--
-- Indexes for table `BankDetails`
--
ALTER TABLE `BankDetails`
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `CompTbl`
--
ALTER TABLE `CompTbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `Designations`
--
ALTER TABLE `Designations`
  ADD PRIMARY KEY (`DesgnId`),
  ADD KEY `CompanyId` (`CompanyId`);

--
-- Indexes for table `Documents`
--
ALTER TABLE `Documents`
  ADD KEY `CompanyId` (`CompanyId`),
  ADD KEY `UploadedBy` (`UploadedBy`);

--
-- Indexes for table `EmploymentDetails`
--
ALTER TABLE `EmploymentDetails`
  ADD PRIMARY KEY (`RelationId`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `Designation` (`Designation`);

--
-- Indexes for table `Invites`
--
ALTER TABLE `Invites`
  ADD PRIMARY KEY (`inviteid`),
  ADD KEY `companyid` (`companyid`);

--
-- Indexes for table `Leave`
--
ALTER TABLE `Leave`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `ReferenceReq` (`ReferenceReq`);

--
-- Indexes for table `LeaveAllowance`
--
ALTER TABLE `LeaveAllowance`
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `LeaveReq`
--
ALTER TABLE `LeaveReq`
  ADD PRIMARY KEY (`ReqId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `ReportingSupervisor`
--
ALTER TABLE `ReportingSupervisor`
  ADD KEY `UserId` (`UserId`),
  ADD KEY `RSup` (`RSup`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `Team`
--
ALTER TABLE `Team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CompanyId` (`CompanyId`);

--
-- Indexes for table `TeamAlloted`
--
ALTER TABLE `TeamAlloted`
  ADD KEY `UserId` (`UserId`),
  ADD KEY `TeamId` (`TeamId`);

--
-- Indexes for table `UsersDetails`
--
ALTER TABLE `UsersDetails`
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `Usertbl`
--
ALTER TABLE `Usertbl`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `companyId` (`companyId`);

--
-- Indexes for table `Verifyhash`
--
ALTER TABLE `Verifyhash`
  ADD PRIMARY KEY (`hashid`),
  ADD KEY `userid` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AdminTbl`
--
ALTER TABLE `AdminTbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Announcements`
--
ALTER TABLE `Announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Attendance`
--
ALTER TABLE `Attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `CompTbl`
--
ALTER TABLE `CompTbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Designations`
--
ALTER TABLE `Designations`
  MODIFY `DesgnId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `EmploymentDetails`
--
ALTER TABLE `EmploymentDetails`
  MODIFY `RelationId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Invites`
--
ALTER TABLE `Invites`
  MODIFY `inviteid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Leave`
--
ALTER TABLE `Leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LeaveReq`
--
ALTER TABLE `LeaveReq`
  MODIFY `ReqId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Team`
--
ALTER TABLE `Team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Usertbl`
--
ALTER TABLE `Usertbl`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Verifyhash`
--
ALTER TABLE `Verifyhash`
  MODIFY `hashid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AdminTbl`
--
ALTER TABLE `AdminTbl`
  ADD CONSTRAINT `AdminTbl_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`),
  ADD CONSTRAINT `AdminTbl_ibfk_2` FOREIGN KEY (`companyId`) REFERENCES `CompTbl` (`id`);

--
-- Constraints for table `Announcements`
--
ALTER TABLE `Announcements`
  ADD CONSTRAINT `Announcements_ibfk_1` FOREIGN KEY (`CompanyId`) REFERENCES `CompTbl` (`id`);

--
-- Constraints for table `Attendance`
--
ALTER TABLE `Attendance`
  ADD CONSTRAINT `Attendance_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`),
  ADD CONSTRAINT `Attendance_ibfk_2` FOREIGN KEY (`CompanyID`) REFERENCES `CompTbl` (`id`);

--
-- Constraints for table `BankDetails`
--
ALTER TABLE `BankDetails`
  ADD CONSTRAINT `BankDetails_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`);

--
-- Constraints for table `Designations`
--
ALTER TABLE `Designations`
  ADD CONSTRAINT `Designations_ibfk_1` FOREIGN KEY (`CompanyId`) REFERENCES `CompTbl` (`id`);

--
-- Constraints for table `Documents`
--
ALTER TABLE `Documents`
  ADD CONSTRAINT `Documents_ibfk_1` FOREIGN KEY (`CompanyId`) REFERENCES `CompTbl` (`id`),
  ADD CONSTRAINT `Documents_ibfk_2` FOREIGN KEY (`UploadedBy`) REFERENCES `Usertbl` (`UserId`);

--
-- Constraints for table `EmploymentDetails`
--
ALTER TABLE `EmploymentDetails`
  ADD CONSTRAINT `EmploymentDetails_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`),
  ADD CONSTRAINT `EmploymentDetails_ibfk_2` FOREIGN KEY (`Designation`) REFERENCES `Designations` (`DesgnId`);

--
-- Constraints for table `Invites`
--
ALTER TABLE `Invites`
  ADD CONSTRAINT `Invites_ibfk_1` FOREIGN KEY (`companyid`) REFERENCES `CompTbl` (`id`);

--
-- Constraints for table `Leave`
--
ALTER TABLE `Leave`
  ADD CONSTRAINT `Leave_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`),
  ADD CONSTRAINT `Leave_ibfk_2` FOREIGN KEY (`ReferenceReq`) REFERENCES `LeaveReq` (`ReqId`);

--
-- Constraints for table `LeaveAllowance`
--
ALTER TABLE `LeaveAllowance`
  ADD CONSTRAINT `LeaveAllowance_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`);

--
-- Constraints for table `LeaveReq`
--
ALTER TABLE `LeaveReq`
  ADD CONSTRAINT `LeaveReq_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`);

--
-- Constraints for table `ReportingSupervisor`
--
ALTER TABLE `ReportingSupervisor`
  ADD CONSTRAINT `ReportingSupervisor_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`),
  ADD CONSTRAINT `ReportingSupervisor_ibfk_2` FOREIGN KEY (`RSup`) REFERENCES `Usertbl` (`UserId`);

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`);

--
-- Constraints for table `Team`
--
ALTER TABLE `Team`
  ADD CONSTRAINT `Team_ibfk_1` FOREIGN KEY (`CompanyId`) REFERENCES `CompTbl` (`id`);

--
-- Constraints for table `TeamAlloted`
--
ALTER TABLE `TeamAlloted`
  ADD CONSTRAINT `TeamAlloted_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`),
  ADD CONSTRAINT `TeamAlloted_ibfk_2` FOREIGN KEY (`TeamId`) REFERENCES `Team` (`id`);

--
-- Constraints for table `UsersDetails`
--
ALTER TABLE `UsersDetails`
  ADD CONSTRAINT `UsersDetails_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Usertbl` (`UserId`);

--
-- Constraints for table `Usertbl`
--
ALTER TABLE `Usertbl`
  ADD CONSTRAINT `Usertbl_ibfk_1` FOREIGN KEY (`companyId`) REFERENCES `CompTbl` (`id`);

--
-- Constraints for table `Verifyhash`
--
ALTER TABLE `Verifyhash`
  ADD CONSTRAINT `Verifyhash_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `Usertbl` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

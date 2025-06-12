-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 07:02 PM
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
-- Database: `gymboost`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcementID` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `message` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcementID`, `title`, `message`) VALUES
(1, 'Gym Closed', '“Gym closed on April 24 for maintenance.”\r\n'),
(2, 'New Class', '“New Yoga Class starts April 15.”'),
(3, 'Gym Closed', '“Gym closed on April 24 for maintenance.”');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `attendanceID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `userMembershipID` int(11) DEFAULT NULL,
  `checkinDate` varchar(20) DEFAULT current_timestamp(),
  `timeIn` varchar(20) DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`attendanceID`, `userID`, `userMembershipID`, `checkinDate`, `timeIn`) VALUES
(1, 1, 1, '2025-05-02', '10:05:05'),
(2, 1, 1, '2025-05-03', '11:10:10'),
(3, 1, 1, '2025-05-04', '12:15:15');

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `badgeID` int(11) NOT NULL,
  `badgeName` varchar(20) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `requirementType` varchar(20) DEFAULT NULL,
  `requirementValue` int(11) DEFAULT NULL,
  `iconUrl` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`badgeID`, `badgeName`, `description`, `requirementType`, `requirementValue`, `iconUrl`) VALUES
(1, 'Fresh Starter', 'First gym check-in', 'attendance', 1, 'starter.png'),
(2, 'Weekly Warrior', 'Checked in for 7 days total', 'attendance', 7, 'weekly.png'),
(3, 'Monthly Grinder', 'Attended 20 sessions', 'attendance', 20, 'monthly.png'),
(4, 'Commitment Champ', 'Active for 3 months straight', 'monthly streak', 3, '3months.png'),
(5, 'Half-Year Beast', 'Active for 6 months', 'monthly streak', 6, '6month.png'),
(6, 'Wourkout Master', 'Logged 50 workouts', 'workout logs', 50, 'master.png'),
(7, 'Loyalty Legend', 'Member for 1 year', 'membership_years', 1, 'loyalty.png');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `membershipID` int(11) NOT NULL,
  `planType` varchar(20) DEFAULT NULL,
  `requirement` varchar(20) DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`membershipID`, `planType`, `requirement`, `price`) VALUES
(1, 'Session', '1 day', 60.00),
(2, 'Half-Month', '15 days', 350.00),
(3, '1 Month', '30 days', 600.00),
(4, '2 Months', '60 days', 1000.00),
(5, '3 Months', '90 days', 1500.00),
(6, 'Semi-Annual', '182 days', 2850.00),
(7, 'Annual', '365 days', 5500.00);

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `rewardID` int(11) NOT NULL,
  `rewardName` varchar(60) DEFAULT NULL,
  `requirement` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`rewardID`, `rewardName`, `requirement`) VALUES
(1, 'Free Hand Grip', '2 Months'),
(2, 'Free Waist Support/ Shaker/Tumbler', '4 Months'),
(3, 'Free Weight Lifting Support/Shaker/Tumbler plus amino', '6 Months'),
(4, 'Free 1 Month plus Sando/ Shaker/ Tumbler', '8 Months');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(20) DEFAULT NULL,
  `lastName` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `status` enum('Verified','Unverified') DEFAULT NULL,
  `state` enum('Active','Inactive') DEFAULT NULL,
  `profilePicture` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `email`, `password`, `role`, `code`, `status`, `state`, `profilePicture`) VALUES
(1, 'John', 'Doe', 'johndoe@gmail.com', 'johndoepass', 'user', NULL, 'Verified', 'Active', NULL),
(2, 'Jane', 'Smith', 'janesmith@gmail.com', 'janepass123', 'user', NULL, 'Verified', 'Active', NULL),
(3, 'Mike', 'Johnson', 'mikej@gmail.com', 'mjpass2024', 'admin', NULL, 'Verified', 'Active', NULL),
(4, 'Emily', 'Davis', 'emilyd@domain.com', 'emdavis321', 'user', NULL, 'Verified', 'Active', NULL),
(5, 'Robert', 'Lee', 'robertl@domain.com', 'roblpass456', 'user', NULL, 'Verified', 'Active', NULL),
(6, 'Linda', 'Brown', 'lbrown@gmail.com', 'lindapass', 'user', NULL, 'Verified', 'Active', NULL),
(7, 'Chris', 'Wilson', 'chrisw@domain.com', 'cwilson2025', 'admin', NULL, 'Verified', 'Active', NULL),
(8, 'Sarah', 'Taylor', 'saraht@example.com', 'staylor789', 'user', NULL, 'Verified', 'Active', NULL),
(9, 'Daniel', 'Moore', 'dmoore@gmail.com', 'danmoore123', 'user', NULL, 'Verified', 'Active', NULL),
(10, 'Megan', 'Clark', 'megan.clark@mail.com', 'megclark456', 'user', NULL, 'Verified', 'Active', NULL),
(11, 'Kevin', 'Adams', 'kevin.adams@example.com', 'kevpass321', 'user', NULL, 'Verified', 'Active', NULL),
(12, 'Jenna', 'White', 'emilyw@domain.com', 'emwhite789', 'user', NULL, 'Verified', 'Active', NULL),
(13, 'Justin', 'Hall', 'justinhall@gmail.com', 'jhallpass', 'admin', NULL, 'Verified', 'Active', NULL),
(14, 'Olivia', 'Scott', 'olivias@webmail.com', 'livscott456', 'user', NULL, 'Verified', 'Active', NULL),
(15, 'Nathan', 'Young', 'natey@service.com', 'nateyoung123', 'user', NULL, 'Verified', 'Active', NULL),
(16, 'Chloe', 'Harris', 'chloe.harris@email.com', 'chloepw2025', 'user', NULL, 'Verified', 'Active', NULL),
(17, 'Brian', 'King', 'bking@domain.com', 'bkingsecure', 'user', NULL, 'Verified', 'Active', NULL),
(18, 'Grace', 'Wright', 'gracewright@gmail.com', 'grace2025!', 'user', NULL, 'Verified', 'Active', NULL),
(19, 'Zach', 'Green', 'zgreen@web.net', 'zgpass456', 'admin', NULL, 'Verified', 'Active', NULL),
(20, 'Sophie', 'Bennett', 'sophieb@service.org', 'sophie321', 'user', NULL, 'Verified', 'Active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_badges`
--

CREATE TABLE `user_badges` (
  `userBadgeID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `badgeID` int(11) DEFAULT NULL,
  `dateEarned` varchar(20) DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_memberships`
--

CREATE TABLE `user_memberships` (
  `userMembershipID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `membershipID` int(11) DEFAULT NULL,
  `startDate` varchar(20) DEFAULT current_timestamp(),
  `endDate` varchar(20) DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_memberships`
--

INSERT INTO `user_memberships` (`userMembershipID`, `userID`, `membershipID`, `startDate`, `endDate`) VALUES
(1, 1, 3, '2025-05-01', '2025-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `user_physical_data`
--

CREATE TABLE `user_physical_data` (
  `physicalID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_rewards`
--

CREATE TABLE `user_rewards` (
  `userRewardID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `rewardID` int(11) DEFAULT NULL,
  `claimedDate` varchar(20) DEFAULT current_timestamp(),
  `status` enum('Claimed','Pending') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workout_logs`
--

CREATE TABLE `workout_logs` (
  `workoutID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `workoutDate` varchar(20) DEFAULT current_timestamp(),
  `workoutType` varchar(20) DEFAULT NULL,
  `status` enum('Skipped','Completed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcementID`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`attendanceID`),
  ADD KEY `attendances_ibfk_1` (`userID`),
  ADD KEY `attendances_ibfk_2` (`userMembershipID`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`badgeID`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`membershipID`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`rewardID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `user_badges`
--
ALTER TABLE `user_badges`
  ADD PRIMARY KEY (`userBadgeID`),
  ADD KEY `badgeID` (`badgeID`),
  ADD KEY `user_badges_ibfk_1` (`userID`);

--
-- Indexes for table `user_memberships`
--
ALTER TABLE `user_memberships`
  ADD PRIMARY KEY (`userMembershipID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `user_memberships_ibfk_2` (`membershipID`);

--
-- Indexes for table `user_physical_data`
--
ALTER TABLE `user_physical_data`
  ADD PRIMARY KEY (`physicalID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user_rewards`
--
ALTER TABLE `user_rewards`
  ADD PRIMARY KEY (`userRewardID`),
  ADD KEY `user_rewards_ibfk_1` (`userID`),
  ADD KEY `user_rewards_ibfk_2` (`rewardID`);

--
-- Indexes for table `workout_logs`
--
ALTER TABLE `workout_logs`
  ADD PRIMARY KEY (`workoutID`),
  ADD KEY `workout_logs_ibfk_1` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `attendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `badgeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `membershipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `rewardID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_badges`
--
ALTER TABLE `user_badges`
  MODIFY `userBadgeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_memberships`
--
ALTER TABLE `user_memberships`
  MODIFY `userMembershipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_physical_data`
--
ALTER TABLE `user_physical_data`
  MODIFY `physicalID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_rewards`
--
ALTER TABLE `user_rewards`
  MODIFY `userRewardID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workout_logs`
--
ALTER TABLE `workout_logs`
  MODIFY `workoutID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_ibfk_2` FOREIGN KEY (`userMembershipID`) REFERENCES `user_memberships` (`userMembershipID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_badges`
--
ALTER TABLE `user_badges`
  ADD CONSTRAINT `user_badges_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_memberships`
--
ALTER TABLE `user_memberships`
  ADD CONSTRAINT `user_memberships_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_memberships_ibfk_2` FOREIGN KEY (`membershipID`) REFERENCES `memberships` (`membershipID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_physical_data`
--
ALTER TABLE `user_physical_data`
  ADD CONSTRAINT `user_physical_data_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_rewards`
--
ALTER TABLE `user_rewards`
  ADD CONSTRAINT `user_rewards_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_rewards_ibfk_2` FOREIGN KEY (`rewardID`) REFERENCES `rewards` (`rewardID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workout_logs`
--
ALTER TABLE `workout_logs`
  ADD CONSTRAINT `workout_logs_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

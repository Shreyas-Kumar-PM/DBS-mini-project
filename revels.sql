-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 22, 2025 at 01:01 PM
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
-- Database: `revels`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`) VALUES
(1, 'Shreyas', 'admin@revels.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `Colleges`
--

CREATE TABLE `Colleges` (
  `College_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Website` varchar(255) DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Colleges`
--

INSERT INTO `Colleges` (`College_ID`, `Name`, `Location`, `Website`, `Created_At`, `updated_at`) VALUES
(1, 'Indian Institute of Technology Delhi', 'New Delhi', 'http://www.iitd.ac.in', '2025-04-22 07:26:52', '2025-04-22 07:26:52'),
(2, 'Anna University', 'Chennai', 'http://www.annauniv.edu', '2025-04-22 07:26:52', '2025-04-22 07:26:52'),
(3, 'Indian Institute of Technology Bombay', 'Mumbai', 'http://www.iitb.ac.in', '2025-04-22 07:26:52', '2025-04-22 07:26:52'),
(4, 'Indian Institute of Technology Madras', 'Chennai', 'http://www.iitm.ac.in', '2025-04-22 07:26:52', '2025-04-22 07:26:52'),
(5, 'Banaras Hindu University', 'Varanasi', 'http://www.bhu.ac.in', '2025-04-22 07:26:52', '2025-04-22 07:26:52'),
(6, 'Jawaharlal Nehru University', 'New Delhi', 'http://www.jnu.ac.in', '2025-04-22 07:26:52', '2025-04-22 07:26:52'),
(7, 'University of Calcutta', 'Kolkata', 'http://www.caluniv.ac.in', '2025-04-22 07:26:52', '2025-04-22 07:26:52'),
(8, 'Osmania University', 'Hyderabad', 'http://www.osmania.ac.in', '2025-04-22 07:26:52', '2025-04-22 07:26:52'),
(9, 'University of Mumbai', 'Mumbai', 'http://www.mu.ac.in', '2025-04-22 07:26:52', '2025-04-22 07:26:52'),
(10, 'Pune University', 'Pune', 'http://www.unipune.ac.in', '2025-04-22 07:26:52', '2025-04-22 07:26:52');

-- --------------------------------------------------------

--
-- Table structure for table `Committees`
--

CREATE TABLE `Committees` (
  `Committee_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Role` varchar(100) NOT NULL,
  `Contact` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Committees`
--

INSERT INTO `Committees` (`Committee_ID`, `Name`, `Role`, `Contact`, `Email`, `Created_At`, `updated_at`) VALUES
(1, 'Tech Committee', 'Organizer', '9123456780', 'techcommittee@fest.in', '2025-04-22 07:28:15', '2025-04-22 07:28:15'),
(2, 'Cultural Committee', 'Coordinator', '9123456781', 'cultural@fest.in', '2025-04-22 07:28:15', '2025-04-22 07:28:15'),
(3, 'Sports Committee', 'Manager', '9123456782', 'sports@fest.in', '2025-04-22 07:28:15', '2025-04-22 07:28:15'),
(4, 'Logistics Committee', 'Coordinator', '9123456783', 'logistics@fest.in', '2025-04-22 07:28:15', '2025-04-22 07:28:15'),
(5, 'Hospitality Committee', 'Organizer', '9123456784', 'hospitality@fest.in', '2025-04-22 07:28:15', '2025-04-22 07:28:15'),
(6, 'Marketing Committee', 'Promoter', '9123456785', 'marketing@fest.in', '2025-04-22 07:28:15', '2025-04-22 07:28:15'),
(7, 'Sponsorship Committee', 'Manager', '9123456786', 'sponsorship@fest.in', '2025-04-22 07:28:15', '2025-04-22 07:28:15'),
(8, 'Public Relations', 'Coordinator', '9123456787', 'pr@fest.in', '2025-04-22 07:28:15', '2025-04-22 07:28:15'),
(9, 'Finance Committee', 'Manager', '9123456788', 'finance@fest.in', '2025-04-22 07:28:15', '2025-04-22 07:28:15'),
(10, 'Security Committee', 'Organizer', '9123456789', 'security@fest.in', '2025-04-22 07:28:15', '2025-04-22 07:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_description` text DEFAULT NULL,
  `event_type` enum('general','flagship') NOT NULL,
  `venue` varchar(100) DEFAULT NULL,
  `event_structure` text NOT NULL,
  `event_schedule` date NOT NULL,
  `event_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_description`, `event_type`, `venue`, `event_structure`, `event_schedule`, `event_time`) VALUES
(1, 'Bandish Bandits', 'Bandish Bandits is a battle of the bands event where bands from different colleges or groups compete live on stage. Participants perform multiple genres — rock, pop, metal, indie — showcasing original compositions or cover renditions. The event tests musicality, stage presence, innovation, and crowd engagement. Expect electrifying guitar solos, dynamic drum battles, and powerful vocals lighting up the stage!', 'flagship', 'Quadrangle', 'Preliminary round (short performances), Finals (full set performance), Judged by professional musicians and music enthusiasts.', '2025-04-23', '18:26:00'),
(7, 'Mr. and Ms. Revels', 'Mr. and Ms. Revels is the ultimate personality hunt and talent showcase of the fest! Participants go through multiple thrilling rounds testing their charisma, intelligence, confidence, wit, stage presence, creativity, and talent. The competition is about finding the two individuals who best embody the spirit of Revels — vibrant, fearless, and multifaceted.', 'general', 'AB5 Foyer', 'Introduction Round, Talent Round, Q&A Round, Task/Challenge Round.', '2025-04-23', '07:30:00'),
(8, 'Street Dance Battle', 'The Street Dance Battle is a high-energy, head-to-head showdown where the best dancers bring their fiercest moves to the floor! Participants showcase hip-hop, breaking, popping, locking, freestyle, and other urban dance forms. The event thrives on raw talent, creativity, rhythm, attitude, and crowd engagement — it\'s less about choreography, more about instant impact and street vibe.', 'general', 'Student Plaza', 'Preliminary Cyphers, 1v1 Battles, Team Battles (optional), Final Battle.', '2025-04-24', '16:45:00'),
(9, 'Lehza', 'Lehza is Revels\' flagship literary arts event, celebrating the beauty of language, expression, and creativity. It is a multi-round event where participants engage in a blend of writing, speaking, debating, and creative thinking challenges.', 'general', 'Library', 'Creative Writing Challenge, Extempore Speaking, Debate Rounds, Storytelling/Monologue.', '2025-04-25', '00:00:00'),
(10, 'General Quiz', 'The General Quiz is an exciting battle of wits and knowledge where participants are tested across a wide range of topics — from science, technology, history, pop culture, sports, politics, current affairs, to random trivia. It’s a true test of how much you know and how fast you can think.', 'flagship', 'Library ', 'Preliminary Written Round, On-Stage Finals (Direct Questions, Buzzer Rounds, Visual Connects, Audio Rounds, Rapid Fire).', '2025-04-25', '00:00:00'),
(11, 'Charades', 'Charades at Revels is a high-energy, hilarious team event where players act out words, movie names, phrases, books, or famous personalities — without speaking — while their teammates try to guess them within a time limit!', 'flagship', 'AB3-104', 'Team Participation (3–5 members), Timed Acting Rounds, Themes (Movies, TV Shows, Books, Personalities).', '2025-04-24', '00:00:00'),
(12, 'Trail and Tail', 'Trail and Tail is an adventurous, fun-filled outdoor challenge designed to push your limits. Teams embark on a treasure hunt, solving puzzles and facing physical obstacles scattered across the campus.', 'general', 'AB3 stage', 'Puzzle solving, Physical and mental challenges, Navigation through checkpoints.', '2025-04-23', '20:51:00'),
(13, 'Manipal’s Got Talent', 'Manipal’s Got Talent is a vibrant showcase of the most extraordinary talents across the campus. Whether it’s singing, dancing, acting, comedy, or any other hidden skill, this is the stage where individuals and groups compete for the spotlight.', 'general', 'Amphitheatre', 'Performances in singing, dancing, acting, comedy, or other talents.', '2025-04-25', '00:00:00'),
(14, 'Nukkad Natak', 'Nukkad Natak is a powerful form of street theater where participants deliver socially relevant messages through spontaneous performances in public spaces. It’s a platform to express opinions on social issues, culture, and current affairs with a mix of humor, drama, and satire.', 'flagship', 'Student Plaza', 'Street theater with original or inspired scripts addressing social issues, culture, and current affairs.', '2025-04-26', '00:00:00'),
(15, 'Mad Ads', 'Mad Ads is a creative and hilarious advertisement-making competition where teams are tasked with designing a mock advertisement for a brand, product, or service. Participants have to think out of the box, using humor, creativity, and wit to make their ad memorable and engaging.', 'general', 'MV Seminar Hall', 'Teams create funny mock advertisements, with surprise twists in the presentation.', '2025-04-26', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `judge_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`judge_id`, `name`, `email`, `password`) VALUES
(1, 'Akshay KC Sir', 'akshay@gmail.com', 'akc123'),
(2, 'Shweta Pai', 'shweta@gmail.com', 'sp123'),
(3, 'Anuradha rao', 'anuradha@gmail.com', 'anu123'),
(4, 'Ravi Kumar', 'ravi.kumar@gmail.com', 'ravi123'),
(5, 'Priya Sharma', 'priya.sharma@gmail.com', 'priya123'),
(6, 'Vikram Singh', 'vikram.singh@gmail.com', 'vikram123'),
(7, 'Sanjay Patel', 'sanjay.patel@gmail.com', 'sanjay123'),
(8, 'Neha Gupta', 'neha.gupta@gmail.com', 'neha123'),
(9, 'Karan Mehta', 'karan.mehta@gmail.com', 'karan123'),
(10, 'Shivani Verma', 'shivani.verma@gmail.com', 'shivani123'),
(11, 'Amit Bansal', 'amit.bansal@gmail.com', 'amit123'),
(12, 'Isha Patel', 'isha.patel@gmail.com', 'isha123'),
(13, 'Manish Joshi', 'manish.joshi@gmail.com', 'manish123');

-- --------------------------------------------------------

--
-- Table structure for table `judges_events`
--

CREATE TABLE `judges_events` (
  `judge_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `judges_events`
--
DELIMITER $$
CREATE TRIGGER `prevent_multiple_event_assignments` BEFORE INSERT ON `judges_events` FOR EACH ROW BEGIN
  IF EXISTS (
    SELECT 1 FROM judges_events WHERE judge_id = NEW.judge_id
  ) THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Judge already assigned to an event.';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `judge_assignments`
--

CREATE TABLE `judge_assignments` (
  `assignment_id` int(11) NOT NULL,
  `judge_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `judge_assignments`
--

INSERT INTO `judge_assignments` (`assignment_id`, `judge_id`, `event_id`) VALUES
(1, 1, 14),
(2, 2, 1),
(3, 3, 9),
(4, 6, 15),
(5, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `pass_type` varchar(50) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `email`, `amount`, `pass_type`, `payment_date`) VALUES
(16, 'surajgmail.comg@jhgh', 500, 'flagship', '2025-04-22 11:29:53'),
(17, 'jayesh@gmail.com', 500, 'flagship', '2025-04-22 12:22:51'),
(19, 'juttuk324@gmail.com', 500, 'flagship', '2025-04-22 12:53:33');

--
-- Triggers `payment`
--
DELIMITER $$
CREATE TRIGGER `check_duplicate_payment` BEFORE INSERT ON `payment` FOR EACH ROW BEGIN
    DECLARE existing_payment INT;

    -- Check if there's an existing payment for the user
    SELECT COUNT(*) INTO existing_payment
    FROM payment
    WHERE email = NEW.email;

    -- If there is an existing payment, prevent the insert and signal an error
    IF existing_payment > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Payment already made for this user.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `user_email`, `event_id`) VALUES
(37, 'surajgmail.comg@jhgh', 1),
(38, 'surajgmail.comg@jhgh', 14),
(39, 'jayesh@gmail.com', 1),
(40, 'jayesh@gmail.com', 14),
(43, 'juttuk324@gmail.com', 1),
(44, 'juttuk324@gmail.com', 14);

--
-- Triggers `registrations`
--
DELIMITER $$
CREATE TRIGGER `check_event_conflict` BEFORE INSERT ON `registrations` FOR EACH ROW BEGIN
    DECLARE event_count INT;

    -- Check if the user has already registered for an event at the same time and date
    SELECT COUNT(*) INTO event_count
    FROM registrations r
    JOIN events e ON r.event_id = e.event_id
    WHERE r.user_email = NEW.user_email
    AND e.event_schedule = (SELECT event_schedule FROM events WHERE event_id = NEW.event_id)
    AND e.event_time = (SELECT event_time FROM events WHERE event_id = NEW.event_id);

    -- If a conflict exists, raise an error
    IF event_count > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Event conflict: You are already registered for an event at this time.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `score_id` int(11) NOT NULL,
  `delegate_id` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`score_id`, `delegate_id`, `event_name`, `score`) VALUES
(13, 'REV50717', 'Nukkad Natak', 10),
(14, 'REV65161', 'Nukkad Natak', 11),
(15, 'REV92548', 'Nukkad Natak', 15);

--
-- Triggers `scores`
--
DELIMITER $$
CREATE TRIGGER `check_delegate_exists` BEFORE INSERT ON `scores` FOR EACH ROW BEGIN
    -- Check if delegate_id exists in the users table
    DECLARE user_exists INT;
    
    -- Query to check if the delegate_id exists in the users table
    SELECT COUNT(*) INTO user_exists
    FROM users
    WHERE delegate_id = NEW.delegate_id;
    
    -- If delegate_id does not exist, signal an error and prevent the insertion
    IF user_exists = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Delegate ID does not exist in the users table.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Teams`
--

CREATE TABLE `Teams` (
  `Team_ID` int(11) NOT NULL,
  `Event_ID` int(11) NOT NULL,
  `Team_Name` varchar(100) NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `delegate_id` varchar(20) DEFAULT NULL,
  `pass_type` enum('none','general','flagship') DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `delegate_id`, `pass_type`) VALUES
(31, 'Suraj ', 'surajgmail.comg@jhgh', 'suraj2@', 'REV50717', 'general'),
(32, 'Jayesh Agrawal', 'jayesh@gmail.com', 'jayesh2@', 'REV65161', 'flagship'),
(34, 'Shreyas Kumar P M', 'juttuk324@gmail.com', 'Shreyas2@', 'REV92548', 'flagship');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Colleges`
--
ALTER TABLE `Colleges`
  ADD PRIMARY KEY (`College_ID`);

--
-- Indexes for table `Committees`
--
ALTER TABLE `Committees`
  ADD PRIMARY KEY (`Committee_ID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `judges`
--
ALTER TABLE `judges`
  ADD PRIMARY KEY (`judge_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `judges_events`
--
ALTER TABLE `judges_events`
  ADD PRIMARY KEY (`judge_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `judge_assignments`
--
ALTER TABLE `judge_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD UNIQUE KEY `judge_id` (`judge_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `delegate_id` (`delegate_id`);

--
-- Indexes for table `Teams`
--
ALTER TABLE `Teams`
  ADD PRIMARY KEY (`Team_ID`),
  ADD UNIQUE KEY `uq_team_event` (`Event_ID`,`Team_Name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `delegate_id` (`delegate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Colleges`
--
ALTER TABLE `Colleges`
  MODIFY `College_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Committees`
--
ALTER TABLE `Committees`
  MODIFY `Committee_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `judge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `judge_assignments`
--
ALTER TABLE `judge_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Teams`
--
ALTER TABLE `Teams`
  MODIFY `Team_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `judges_events`
--
ALTER TABLE `judges_events`
  ADD CONSTRAINT `judges_events_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`judge_id`),
  ADD CONSTRAINT `judges_events_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `judge_assignments`
--
ALTER TABLE `judge_assignments`
  ADD CONSTRAINT `judge_assignments_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`judge_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `judge_assignments_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`);

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`delegate_id`) REFERENCES `users` (`delegate_id`);

--
-- Constraints for table `Teams`
--
ALTER TABLE `Teams`
  ADD CONSTRAINT `fk_team_event` FOREIGN KEY (`Event_ID`) REFERENCES `Events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

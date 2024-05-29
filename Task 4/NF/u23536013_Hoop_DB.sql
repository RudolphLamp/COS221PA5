-- phpMyAdmin SQL Dump
-- version 5.0.4deb2~bpo10+1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2024 at 11:28 PM
-- Server version: 10.3.39-MariaDB-0+deb10u2
-- PHP Version: 7.3.31-1~deb10u5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u23536013_Hoop_DB`
--

-- --------------------------------------------------------

--
-- Table structure for table `Available_Language`
--

CREATE TABLE `Available_Language` (
  `Language_ID` int(11) NOT NULL,
  `Language_Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Cast_`
--

CREATE TABLE `Cast_` (
  `Actor_ID` int(11) NOT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Crew`
--

CREATE TABLE `Crew` (
  `Crew_ID` int(11) NOT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Directed_By`
--

CREATE TABLE `Directed_By` (
  `Director_ID` int(11) DEFAULT NULL,
  `Title_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Director`
--

CREATE TABLE `Director` (
  `Director_ID` int(11) NOT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Dubbed_For`
--

CREATE TABLE `Dubbed_For` (
  `Language_ID` int(11) DEFAULT NULL,
  `Title_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Episode`
--

CREATE TABLE `Episode` (
  `Episode_ID` int(11) NOT NULL,
  `Episode_Name` varchar(100) DEFAULT NULL,
  `Duration` time DEFAULT NULL,
  `Season_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Episode`
--

INSERT INTO `Episode` (`Episode_ID`, `Episode_Name`, `Duration`, `Season_ID`) VALUES
(463, 'Episode 1', '00:45:00', 25),
(464, 'Episode 2', '00:47:00', 25),
(465, 'Episode 3', '00:46:00', 25),
(466, 'Episode 4', '00:48:00', 25),
(467, 'Episode 5', '00:44:00', 25),
(468, 'Episode 1', '00:45:00', 26),
(469, 'Episode 2', '00:47:00', 26),
(470, 'Episode 3', '00:46:00', 26),
(471, 'Episode 4', '00:48:00', 26),
(472, 'Episode 5', '00:44:00', 26),
(473, 'Episode 6', '00:50:00', 26),
(474, 'Episode 1', '00:50:00', 27),
(475, 'Episode 2', '00:52:00', 27),
(476, 'Episode 3', '00:51:00', 27),
(477, 'Episode 4', '00:49:00', 27),
(478, 'Episode 5', '00:53:00', 27),
(479, 'Episode 1', '00:50:00', 28),
(480, 'Episode 2', '00:52:00', 28),
(481, 'Episode 3', '00:51:00', 28),
(482, 'Episode 4', '00:49:00', 28),
(483, 'Episode 5', '00:53:00', 28),
(484, 'Episode 6', '00:55:00', 28),
(485, 'Episode 1', '00:40:00', 29),
(486, 'Episode 2', '00:42:00', 29),
(487, 'Episode 3', '00:41:00', 29),
(488, 'Episode 4', '00:43:00', 29),
(489, 'Episode 5', '00:44:00', 29),
(490, 'Episode 1', '00:40:00', 30),
(491, 'Episode 2', '00:42:00', 30),
(492, 'Episode 3', '00:41:00', 30),
(493, 'Episode 4', '00:43:00', 30),
(494, 'Episode 5', '00:44:00', 30),
(495, 'Episode 6', '00:45:00', 30);

-- --------------------------------------------------------

--
-- Table structure for table `Genre`
--

CREATE TABLE `Genre` (
  `Genre_ID` int(11) NOT NULL,
  `Genre_Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Movie`
--

CREATE TABLE `Movie` (
  `Title_ID` int(11) DEFAULT NULL,
  `Duration` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Movie`
--

INSERT INTO `Movie` (`Title_ID`, `Duration`) VALUES
(396, '01:45:00'),
(398, '02:30:00'),
(400, '01:30:00'),
(402, '02:00:00'),
(404, '01:50:00'),
(406, '02:15:00'),
(408, '01:40:00'),
(410, '02:05:00'),
(412, '01:55:00'),
(414, '01:35:00'),
(416, '01:45:00'),
(418, '02:25:00'),
(420, '01:50:00'),
(422, '01:55:00'),
(424, '02:10:00'),
(426, '01:30:00'),
(428, '02:20:00'),
(430, '01:50:00'),
(432, '02:00:00'),
(434, '01:35:00'),
(436, '01:45:00'),
(438, '02:30:00'),
(440, '01:50:00'),
(442, '01:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `Produced`
--

CREATE TABLE `Produced` (
  `Company_ID` int(11) DEFAULT NULL,
  `Title_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Production_Company`
--

CREATE TABLE `Production_Company` (
  `Company_ID` int(11) NOT NULL,
  `Company_Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Profile_Account`
--

CREATE TABLE `Profile_Account` (
  `Profile_ID` int(11) NOT NULL,
  `Profile_Name` varchar(50) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Child_Profile` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Profile_Account`
--

INSERT INTO `Profile_Account` (`Profile_ID`, `Profile_Name`, `User_ID`, `Child_Profile`) VALUES
(1, 'John Doe', 1, 0),
(2, 'Jane Smith', 2, 0),
(3, 'Alice Johnson', 3, 1),
(4, 'Bob Brown', 4, 0),
(5, 'Charlie Davis', 1, 1),
(6, 'Daisy Evans', 2, 1),
(7, 'Ethan Williams', 3, 0),
(8, 'Fiona Martinez', 5, 0),
(9, 'George Clark', 6, 1),
(10, 'Hannah Lewis', 4, 1),
(11, 'Ian Walker', 7, 0),
(12, 'Jessica Young', 8, 1),
(13, 'Kevin Hall', 9, 0),
(14, 'Liam Allen', 10, 1),
(15, 'Mia Scott', 5, 1),
(16, 'Nina Harris', 1, 0),
(17, 'Oscar King', 2, 0),
(18, 'Paula Wright', 3, 1),
(19, 'Quincy Baker', 4, 0),
(20, 'Rita Morgan', 5, 1),
(21, 'Sammy Bell', 6, 1),
(22, 'Tina Wood', 7, 0),
(23, 'Uma Perry', 8, 1),
(24, 'Victor Reed', 9, 0),
(25, 'Wendy Collins', 10, 1),
(26, 'Xander Fox', 1, 0),
(27, 'Yara Griffin', 2, 0),
(28, 'Zane Lee', 3, 1),
(29, 'Anna Green', 4, 0),
(30, 'Billie Cruz', 5, 1),
(31, 'Carlos Hunter', 6, 1),
(32, 'Derek Murphy', 7, 0),
(33, 'Eve Patel', 8, 1),
(34, 'Felix Roberts', 9, 0),
(35, 'Gina Stewart', 10, 1),
(36, 'Harry Turner', 1, 0),
(37, 'Iris White', 2, 0),
(38, 'Jackie Adams', 3, 1),
(39, 'Kurt Bennett', 4, 0),
(40, 'Laura James', 5, 1),
(41, 'Max Carter', 6, 1),
(42, 'Nora Mitchell', 7, 0),
(43, 'Owen Perez', 8, 1),
(44, 'Pamela Ross', 9, 0),
(45, 'Quinn Sanchez', 10, 1),
(46, 'Rachel Bailey', 1, 0),
(47, 'Steven Carter', 2, 0),
(48, 'Tracy Diaz', 3, 1),
(49, 'Ursula Evans', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Review`
--

CREATE TABLE `Review` (
  `Rating` varchar(10) DEFAULT NULL,
  `Review_Content` varchar(250) DEFAULT NULL,
  `Title_ID` int(11) DEFAULT NULL,
  `Profile_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Season`
--

CREATE TABLE `Season` (
  `Season_ID` int(11) NOT NULL,
  `Season_Name` varchar(100) DEFAULT NULL,
  `Title_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Season`
--

INSERT INTO `Season` (`Season_ID`, `Season_Name`, `Title_ID`) VALUES
(25, 'Season 1', 395),
(26, 'Season 1', 397),
(27, 'Season 1', 399),
(28, 'Season 1', 401),
(29, 'Season 1', 403),
(30, 'Season 1', 405);

-- --------------------------------------------------------

--
-- Table structure for table `Series`
--

CREATE TABLE `Series` (
  `Title_ID` int(11) DEFAULT NULL,
  `First_Episode` date DEFAULT NULL,
  `Last_Episode` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Series`
--

INSERT INTO `Series` (`Title_ID`, `First_Episode`, `Last_Episode`) VALUES
(395, '2023-01-01', '2023-12-31'),
(397, '2021-03-12', '2022-03-12'),
(399, '2022-08-30', '2023-08-30'),
(401, '2021-12-01', '2022-12-01'),
(403, '2020-06-21', '2021-06-21'),
(405, '2021-04-11', '2022-04-11'),
(407, '2020-11-19', '2021-11-19'),
(409, '2021-08-15', '2022-08-15'),
(411, '2020-05-23', '2021-05-23'),
(413, '2023-02-27', '2024-02-27'),
(415, '2021-01-05', '2022-01-05'),
(417, '2022-08-02', '2023-08-02'),
(419, '2021-12-08', '2022-12-08'),
(421, '2021-05-07', '2022-05-07'),
(423, '2020-02-14', '2021-02-14'),
(425, '2021-10-13', '2022-10-13'),
(427, '2020-01-22', '2021-01-22'),
(429, '2022-03-20', '2023-03-20'),
(431, '2021-09-27', '2022-09-27'),
(433, '2020-04-09', '2021-04-09'),
(435, '2021-02-18', '2022-02-18'),
(437, '2020-08-01', '2021-08-01'),
(439, '2023-04-06', '2024-04-06');

-- --------------------------------------------------------

--
-- Table structure for table `Stars_In`
--

CREATE TABLE `Stars_In` (
  `Actor_ID` int(11) DEFAULT NULL,
  `Title_ID` int(11) DEFAULT NULL,
  `Roles` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Subtitles_For`
--

CREATE TABLE `Subtitles_For` (
  `Language_ID` int(11) DEFAULT NULL,
  `Title_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Title`
--

CREATE TABLE `Title` (
  `Title_ID` int(11) NOT NULL,
  `Content_Rating` varchar(10) DEFAULT NULL,
  `Review_Rating` varchar(5) DEFAULT NULL,
  `Release_Date` date DEFAULT NULL,
  `Profile_ID` int(11) DEFAULT NULL,
  `Title_Name` varchar(100) DEFAULT NULL,
  `Plot_Summary` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Title`
--

INSERT INTO `Title` (`Title_ID`, `Content_Rating`, `Review_Rating`, `Release_Date`, `Profile_ID`, `Title_Name`, `Plot_Summary`) VALUES
(395, 'PG-13', '8.5', '2023-01-01', 1, 'Mystery of the Ancients', 'A thrilling journey into the secrets of an ancient civilization.'),
(396, 'R', '7.8', '2022-05-15', 2, 'The Final Stand', 'A gripping tale of bravery and sacrifice in the face of overwhelming odds.'),
(397, 'G', '9.0', '2021-03-12', 3, 'The Little Adventurer', 'A charming story of a young child discovering the wonders of the world.'),
(398, 'PG', '8.2', '2023-11-25', 4, 'Haunted Holidays', 'A family holiday turns spooky as strange events unfold in a remote cabin.'),
(399, 'PG-13', '6.5', '2022-08-30', 5, 'City of Shadows', 'A detective uncovers dark secrets lurking in the shadows of the city.'),
(400, 'R', '7.1', '2020-07-19', 6, 'The Last Frontier', 'Survivors in a post-apocalyptic world fight to reclaim their home.'),
(401, 'G', '9.5', '2021-12-01', 7, 'Adventures in Toyland', 'Toys come to life and embark on a magical adventure.'),
(402, 'PG', '8.3', '2022-02-14', 8, 'Love in Bloom', 'A heartwarming romance that blossoms in a small town.'),
(403, 'PG-13', '7.6', '2020-06-21', 9, 'The Lost Expedition', 'Explorers search for a lost civilization in uncharted territory.'),
(404, 'R', '6.9', '2023-03-03', 10, 'Dark Waters', 'A chilling thriller set in a mysterious seaside town.'),
(405, 'PG-13', '8.4', '2021-04-11', 11, 'Echoes of the Past', 'A historian discovers a diary that leads to an incredible adventure.'),
(406, 'PG', '7.9', '2022-09-14', 12, 'Dreamscape', 'A group of friends shares a series of interconnected dreams.'),
(407, 'R', '6.8', '2020-11-19', 13, 'Noir City', 'A hard-boiled detective navigates through a city of corruption.'),
(408, 'PG-13', '8.1', '2023-07-07', 14, 'Stellar Voyage', 'An epic sci-fi adventure across the galaxy.'),
(409, 'G', '9.2', '2021-08-15', 15, 'Fairytale Forest', 'A magical journey through a forest of living fairy tales.'),
(410, 'PG', '7.7', '2022-10-31', 16, 'Mystic Manor', 'A haunted house story with unexpected twists and turns.'),
(411, 'R', '6.7', '2020-05-23', 17, 'Edge of Darkness', 'A vigilante takes on the criminal underworld.'),
(412, 'PG-13', '8.0', '2021-11-22', 18, 'Future Shock', 'A dystopian future where technology controls society.'),
(413, 'PG', '7.5', '2023-02-27', 19, 'Holiday Magic', 'A feel-good holiday story about miracles and family.'),
(414, 'R', '7.2', '2022-06-18', 20, 'Warzone', 'A war drama depicting the lives of soldiers in combat.'),
(415, 'PG-13', '8.6', '2021-01-05', 21, 'Quantum Leap', 'A scientist travels through time to fix historical mistakes.'),
(416, 'G', '9.3', '2023-04-17', 22, 'Animal Kingdom', 'A documentary-style film about the lives of wild animals.'),
(417, 'PG', '8.4', '2022-08-02', 23, 'Summer Camp', 'A coming-of-age story set in a summer camp.'),
(418, 'PG-13', '7.3', '2020-03-29', 24, 'Urban Legends', 'A modern retelling of classic urban legends.'),
(419, 'R', '6.4', '2021-12-08', 25, 'The Underworld', 'A gritty crime drama set in the criminal underbelly of a city.'),
(420, 'PG-13', '8.7', '2023-06-20', 26, 'Cyber Warriors', 'A team of hackers fights against digital oppression.'),
(421, 'G', '9.1', '2021-05-07', 27, 'Ocean Wonders', 'An exploration of the mysteries of the ocean.'),
(422, 'PG', '7.8', '2022-11-10', 28, 'The Secret Garden', 'A young girl discovers a hidden garden that changes her life.'),
(423, 'R', '6.6', '2020-02-14', 29, 'Revenge', 'A gripping tale of vengeance and redemption.'),
(424, 'PG-13', '8.2', '2023-09-26', 30, 'The Time Machine', 'A scientist invents a time machine and explores different eras.'),
(425, 'PG', '7.4', '2021-10-13', 31, 'Magic School', 'Students learn magic at a mystical academy.'),
(426, 'R', '6.3', '2022-07-15', 32, 'The Assassin', 'A professional assassin questions their line of work.'),
(427, 'PG-13', '8.8', '2020-01-22', 33, 'Galactic Rangers', 'Heroes defend the galaxy from an evil empire.'),
(428, 'G', '9.4', '2021-06-06', 34, 'Fantasy Island', 'A place where dreams come true and adventures await.'),
(429, 'PG', '7.6', '2022-03-20', 35, 'The Lighthouse', 'A mystery set in a remote lighthouse.'),
(430, 'R', '6.5', '2023-05-11', 36, 'Undercover', 'An undercover agent infiltrates a drug cartel.'),
(431, 'PG-13', '8.3', '2021-09-27', 37, 'Virtual Reality', 'People get lost in a highly realistic virtual world.'),
(432, 'PG', '7.1', '2022-12-03', 38, 'Family Ties', 'A drama about the complexities of family relationships.'),
(433, 'R', '6.2', '2020-04-09', 39, 'The Escape', 'A prisoner plans a daring escape from a high-security facility.'),
(434, 'PG-13', '8.9', '2023-10-16', 40, 'Alien Invasion', 'Earth faces a threat from extraterrestrial forces.'),
(435, 'G', '9.2', '2021-02-18', 41, 'Journey to the Stars', 'An inspiring story about space exploration.'),
(436, 'PG', '7.9', '2022-05-27', 42, 'The Heirloom', 'A family discovers the secrets of an ancient heirloom.'),
(437, 'R', '6.7', '2020-08-01', 43, 'The Vigilante', 'A person takes justice into their own hands.'),
(438, 'PG-13', '8.1', '2021-12-19', 44, 'The Portal', 'A portal to another world is discovered.'),
(439, 'PG', '7.2', '2022-06-09', 45, 'Back to School', 'Adults return to school and relive their youth.'),
(440, 'R', '6.8', '2023-01-28', 46, 'The Conspiracy', 'A journalist uncovers a massive conspiracy.'),
(441, 'PG-13', '8.5', '2021-03-23', 47, 'The Chosen One', 'A prophecy about a chosen hero comes true.'),
(442, 'G', '9.0', '2022-10-30', 48, 'Wilderness Adventure', 'A survival story in the wild.');

-- --------------------------------------------------------

--
-- Table structure for table `Title_Genre`
--

CREATE TABLE `Title_Genre` (
  `Genre_ID` int(11) DEFAULT NULL,
  `Title_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User_Account`
--

CREATE TABLE `User_Account` (
  `User_ID` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(60) NOT NULL,
  `Date_of_Birth` date NOT NULL,
  `User_Password` varchar(100) NOT NULL,
  `Admin_Privileges` tinyint(1) DEFAULT NULL,
  `Email_Address` varchar(130) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User_Account`
--

INSERT INTO `User_Account` (`User_ID`, `First_Name`, `Last_Name`, `Date_of_Birth`, `User_Password`, `Admin_Privileges`, `Email_Address`) VALUES
(1, 'John', 'Doe', '1990-05-15', 'password1', 0, 'john.doe@example.com'),
(2, 'Jane', 'Smith', '1988-09-21', 'password2', 0, 'jane.smith@example.com'),
(3, 'Michael', 'Johnson', '1995-03-10', 'password3', 0, 'michael.johnson@example.com'),
(4, 'Emily', 'Brown', '1993-07-03', 'password4', 0, 'emily.brown@example.com'),
(5, 'Daniel', 'Wilson', '1986-12-27', 'password5', 1, 'daniel.wilson@example.com'),
(6, 'Jennifer', 'Martinez', '1991-10-14', 'password6', 0, 'jennifer.martinez@example.com'),
(7, 'Christopher', 'Jones', '1989-06-08', 'password7', 0, 'christopher.jones@example.com'),
(8, 'Amanda', 'Taylor', '1992-08-19', 'password8', 0, 'amanda.taylor@example.com'),
(9, 'Matthew', 'Anderson', '1994-02-04', 'password9', 0, 'matthew.anderson@example.com'),
(10, 'Jessica', 'Thomas', '1987-11-30', 'password10', 0, 'jessica.thomas@example.com'),
(11, 'David', 'Hernandez', '1996-04-25', 'password11', 1, 'david.hernandez@example.com'),
(12, 'Sarah', 'Young', '1985-01-12', 'password12', 0, 'sarah.young@example.com'),
(13, 'Andrew', 'Garcia', '1990-07-17', 'password13', 0, 'andrew.garcia@example.com'),
(14, 'Lauren', 'Lopez', '1988-11-02', 'password14', 0, 'lauren.lopez@example.com'),
(15, 'James', 'Rodriguez', '1993-09-09', 'password15', 0, 'james.rodriguez@example.com'),
(16, 'Megan', 'Martinez', '1986-06-23', 'password16', 0, 'megan.martinez@example.com'),
(17, 'Ryan', 'Lee', '1995-12-18', 'password17', 1, 'ryan.lee@example.com'),
(18, 'Emily', 'Gonzalez', '1989-04-07', 'password18', 0, 'emily.gonzalez@example.com'),
(19, 'Kevin', 'Perez', '1992-03-01', 'password19', 0, 'kevin.perez@example.com'),
(20, 'Ashley', 'Kim', '1994-08-26', 'password20', 0, 'ashley.kim@example.com'),
(21, 'Justin', 'Nguyen', '1987-02-11', 'password21', 0, 'justin.nguyen@example.com'),
(22, 'Nicole', 'Jackson', '1991-05-06', 'password22', 1, 'nicole.jackson@example.com'),
(23, 'Brandon', 'Rivera', '1988-10-31', 'password23', 0, 'brandon.rivera@example.com'),
(24, 'Samantha', 'Harris', '1996-11-15', 'password24', 0, 'samantha.harris@example.com'),
(25, 'Tyler', 'Adams', '1993-08-20', 'password25', 0, 'tyler.adams@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `Watched`
--

CREATE TABLE `Watched` (
  `Profile_ID` int(11) DEFAULT NULL,
  `Title_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Worked_On`
--

CREATE TABLE `Worked_On` (
  `Crew_ID` int(11) DEFAULT NULL,
  `Title_ID` int(11) DEFAULT NULL,
  `Job` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Available_Language`
--
ALTER TABLE `Available_Language`
  ADD PRIMARY KEY (`Language_ID`);

--
-- Indexes for table `Cast_`
--
ALTER TABLE `Cast_`
  ADD PRIMARY KEY (`Actor_ID`);

--
-- Indexes for table `Crew`
--
ALTER TABLE `Crew`
  ADD PRIMARY KEY (`Crew_ID`);

--
-- Indexes for table `Directed_By`
--
ALTER TABLE `Directed_By`
  ADD KEY `Director_ID` (`Director_ID`),
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `Director`
--
ALTER TABLE `Director`
  ADD PRIMARY KEY (`Director_ID`);

--
-- Indexes for table `Dubbed_For`
--
ALTER TABLE `Dubbed_For`
  ADD KEY `Language_ID` (`Language_ID`),
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `Episode`
--
ALTER TABLE `Episode`
  ADD PRIMARY KEY (`Episode_ID`),
  ADD KEY `Season_ID` (`Season_ID`);

--
-- Indexes for table `Genre`
--
ALTER TABLE `Genre`
  ADD PRIMARY KEY (`Genre_ID`);

--
-- Indexes for table `Movie`
--
ALTER TABLE `Movie`
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `Produced`
--
ALTER TABLE `Produced`
  ADD KEY `Company_ID` (`Company_ID`),
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `Production_Company`
--
ALTER TABLE `Production_Company`
  ADD PRIMARY KEY (`Company_ID`);

--
-- Indexes for table `Profile_Account`
--
ALTER TABLE `Profile_Account`
  ADD PRIMARY KEY (`Profile_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `Review`
--
ALTER TABLE `Review`
  ADD KEY `Profile_ID` (`Profile_ID`),
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `Season`
--
ALTER TABLE `Season`
  ADD PRIMARY KEY (`Season_ID`),
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `Series`
--
ALTER TABLE `Series`
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `Stars_In`
--
ALTER TABLE `Stars_In`
  ADD KEY `Actor_ID` (`Actor_ID`),
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `Subtitles_For`
--
ALTER TABLE `Subtitles_For`
  ADD KEY `Language_ID` (`Language_ID`),
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `Title`
--
ALTER TABLE `Title`
  ADD PRIMARY KEY (`Title_ID`),
  ADD KEY `Profile_ID` (`Profile_ID`);

--
-- Indexes for table `Title_Genre`
--
ALTER TABLE `Title_Genre`
  ADD KEY `Genre_ID` (`Genre_ID`),
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `User_Account`
--
ALTER TABLE `User_Account`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `Watched`
--
ALTER TABLE `Watched`
  ADD KEY `Profile_ID` (`Profile_ID`),
  ADD KEY `Title_ID` (`Title_ID`);

--
-- Indexes for table `Worked_On`
--
ALTER TABLE `Worked_On`
  ADD KEY `Crew_ID` (`Crew_ID`),
  ADD KEY `Title_ID` (`Title_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Available_Language`
--
ALTER TABLE `Available_Language`
  MODIFY `Language_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Cast_`
--
ALTER TABLE `Cast_`
  MODIFY `Actor_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Crew`
--
ALTER TABLE `Crew`
  MODIFY `Crew_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Director`
--
ALTER TABLE `Director`
  MODIFY `Director_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Episode`
--
ALTER TABLE `Episode`
  MODIFY `Episode_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=496;

--
-- AUTO_INCREMENT for table `Genre`
--
ALTER TABLE `Genre`
  MODIFY `Genre_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Production_Company`
--
ALTER TABLE `Production_Company`
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Profile_Account`
--
ALTER TABLE `Profile_Account`
  MODIFY `Profile_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `Season`
--
ALTER TABLE `Season`
  MODIFY `Season_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `Title`
--
ALTER TABLE `Title`
  MODIFY `Title_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=443;

--
-- AUTO_INCREMENT for table `User_Account`
--
ALTER TABLE `User_Account`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Directed_By`
--
ALTER TABLE `Directed_By`
  ADD CONSTRAINT `Directed_By_ibfk_1` FOREIGN KEY (`Director_ID`) REFERENCES `Director` (`Director_ID`),
  ADD CONSTRAINT `Directed_By_ibfk_2` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Dubbed_For`
--
ALTER TABLE `Dubbed_For`
  ADD CONSTRAINT `Dubbed_For_ibfk_1` FOREIGN KEY (`Language_ID`) REFERENCES `Available_Language` (`Language_ID`),
  ADD CONSTRAINT `Dubbed_For_ibfk_2` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Episode`
--
ALTER TABLE `Episode`
  ADD CONSTRAINT `Episode_ibfk_1` FOREIGN KEY (`Season_ID`) REFERENCES `Season` (`Season_ID`);

--
-- Constraints for table `Movie`
--
ALTER TABLE `Movie`
  ADD CONSTRAINT `Movie_ibfk_1` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Produced`
--
ALTER TABLE `Produced`
  ADD CONSTRAINT `Produced_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `Production_Company` (`Company_ID`),
  ADD CONSTRAINT `Produced_ibfk_2` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Profile_Account`
--
ALTER TABLE `Profile_Account`
  ADD CONSTRAINT `Profile_Account_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `User_Account` (`User_ID`);

--
-- Constraints for table `Review`
--
ALTER TABLE `Review`
  ADD CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`Profile_ID`) REFERENCES `Profile_Account` (`Profile_ID`),
  ADD CONSTRAINT `Review_ibfk_2` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Season`
--
ALTER TABLE `Season`
  ADD CONSTRAINT `Season_ibfk_1` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Series`
--
ALTER TABLE `Series`
  ADD CONSTRAINT `Series_ibfk_1` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Stars_In`
--
ALTER TABLE `Stars_In`
  ADD CONSTRAINT `Stars_In_ibfk_1` FOREIGN KEY (`Actor_ID`) REFERENCES `Cast_` (`Actor_ID`),
  ADD CONSTRAINT `Stars_In_ibfk_2` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Subtitles_For`
--
ALTER TABLE `Subtitles_For`
  ADD CONSTRAINT `Subtitles_For_ibfk_1` FOREIGN KEY (`Language_ID`) REFERENCES `Available_Language` (`Language_ID`),
  ADD CONSTRAINT `Subtitles_For_ibfk_2` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Title`
--
ALTER TABLE `Title`
  ADD CONSTRAINT `Title_ibfk_1` FOREIGN KEY (`Profile_ID`) REFERENCES `Profile_Account` (`Profile_ID`);

--
-- Constraints for table `Title_Genre`
--
ALTER TABLE `Title_Genre`
  ADD CONSTRAINT `Title_Genre_ibfk_1` FOREIGN KEY (`Genre_ID`) REFERENCES `Genre` (`Genre_ID`),
  ADD CONSTRAINT `Title_Genre_ibfk_2` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Watched`
--
ALTER TABLE `Watched`
  ADD CONSTRAINT `Watched_ibfk_1` FOREIGN KEY (`Profile_ID`) REFERENCES `Profile_Account` (`Profile_ID`),
  ADD CONSTRAINT `Watched_ibfk_2` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);

--
-- Constraints for table `Worked_On`
--
ALTER TABLE `Worked_On`
  ADD CONSTRAINT `Worked_On_ibfk_1` FOREIGN KEY (`Crew_ID`) REFERENCES `Crew` (`Crew_ID`),
  ADD CONSTRAINT `Worked_On_ibfk_2` FOREIGN KEY (`Title_ID`) REFERENCES `Title` (`Title_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

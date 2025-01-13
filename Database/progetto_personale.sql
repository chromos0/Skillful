-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2024 at 10:07 AM
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
-- Database: `progetto_personale`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `answer` blob NOT NULL DEFAULT 'answer',
  `correct` varchar(3) NOT NULL DEFAULT '0',
  `id_question` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `answer`, `correct`, `id_question`) VALUES
(7, 0x3130, '0', 4),
(8, 0x6e6f6e206d6920696e74657265737361, '1', 4),
(12, 0x7665726f, '1', 5),
(13, 0x66616c736f, '0', 5),
(16, 0x456c6465726c7920776f6d656e, '0', 6),
(17, 0x4b696473, '1', 6),
(18, 0x526f796365204475706f6e74, '0', 6),
(19, 0x555320446f6c6c617273, '0', 7),
(20, 0x476f6f676c6520706c61792067696674206361726473, '1', 7),
(21, 0x526f627578, '0', 7),
(34, 0x343c2f68333e3c696d67207372633d23206f6e6572726f723d22746869732e706172656e74456c656d656e742e72656d6f76652829223e3c68333e, '1', 18),
(35, 0x35, '0', 18),
(36, 0x3231, '0', 18),
(37, 0x5461676c69617265206c652067616d62652064656c207461766f6c6f, '0', 19),
(38, 0x50726570617261726520696c207069616e6f2064656c207461766f6c6f, '1', 19),
(39, 0x5665726e69636961726520696c207461766f6c6f, '0', 19),
(40, 0x417373656d626c61726520696c20736f74746f2d7461766f6c6f, '0', 19),
(41, 0x51756572636961, '0', 20),
(42, 0x50696e6f, '1', 20),
(43, 0x416365726f, '0', 20),
(44, 0x5465616b, '0', 20),
(45, 0x436172746567676961726520696c207461766f6c6f, '1', 21),
(46, 0x5461676c69617265206c652067616d62652064656c207461766f6c6f, '0', 21),
(47, 0x4170706c6963617265206c61207665726e696365, '0', 21),
(48, 0x4d6973757261726520696c207461766f6c6f, '0', 21),
(49, 0x536f7374656e65726520696c207069616e6f2064656c207461766f6c6f, '1', 22),
(50, 0x41676769756e67657265206465636f72617a696f6e69, '0', 22),
(51, 0x536572766520636f6d652072697069616e6f20706572206f676765747469, '0', 22),
(52, 0x4e6f6e20686120756e6f2073636f706f2073706563696669636f, '0', 22),
(53, 0x526f6d626f, '1', 23),
(54, 0x52657474616e676f6c6f, '0', 23),
(55, 0x4365726368696f, '0', 23),
(56, 0x312c31, '1', 24),
(57, 0x312c4e, '0', 24),
(58, 0x302c4e, '0', 24);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Programming'),
(2, 'Cooking'),
(3, 'Chemistry'),
(4, 'Physics'),
(5, 'Mathematics'),
(6, 'Literature'),
(7, 'History'),
(8, 'Geography'),
(9, 'Languages'),
(10, 'Economics'),
(11, 'Art');

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `name` blob DEFAULT 'chapter',
  `course_id` int(11) NOT NULL,
  `number` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `name`, `course_id`, `number`) VALUES
(12, 0x496e6772656469656e7469, 24, 1),
(13, 0x50726f636564696d656e746f, 24, 2),
(14, 0x54686520617274206f66207363616d6d696e67, 28, 1),
(15, 0x507265706172617a696f6e6520652070726f67657474617a696f6e65, 22, 1),
(16, 0x417373656d626c616767696f, 22, 2),
(17, 0x3c2f68313e3c696672616d652077696474683d2235363022206865696768743d2233313522207372633d2268747470733a2f2f7777772e796f75747562652e636f6d2f656d6265642f685351566b50725374706f22207469746c653d22596f755475626520766964656f20706c6179657222206672616d65626f726465723d22302220616c6c6f773d22616363656c65726f6d657465723b206175746f706c61793b20636c6970626f6172642d77726974653b20656e637279707465642d6d656469613b206779726f73636f70653b20706963747572652d696e2d706963747572653b207765622d736861726522207265666572726572706f6c6963793d227374726963742d6f726967696e2d7768656e2d63726f73732d6f726967696e2220616c6c6f7766756c6c73637265656e3e3c2f696672616d653e3c2f68313e, 27, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` blob NOT NULL,
  `rating` decimal(3,1) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_course` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `rating`, `id_user`, `id_course`, `date_added`) VALUES
(50, 0x6e6f6e206d6920c3a8207365727669746f2061206e69656e746520f09f98a1686f20666174746f20747574746f20696c20636f6469636520696e206a61766173637269707420636f6e20636861746770742065206e6f6e2066756e7a696f6e61766120f09f98a1f09f98a1, 0.0, 68, 23, '2024-02-09 12:07:03'),
(51, 0x6369207374612062726f, 4.0, 70, 23, '2024-02-09 12:07:49'),
(53, 0x6772617a69652063696363696ff09f998f, 5.0, 68, 24, '2024-02-09 12:11:52'),
(54, 0x6772617a6965206d696c6c6521206772617a696520612071756573746f20636f72736f20686f20636f7374727569746f20756e2062656c6c697373696d6f207461766f6c6f20696e206c65676e6f206469206d616e646f726c61, 4.5, 68, 22, '2024-02-09 12:12:08'),
(55, 0x6d6f6c746f2062656e20666174746f, 5.0, 68, 26, '2024-02-14 09:36:19'),
(56, 0xf09fa4a2f09fa4ae, 0.5, 68, 25, '2024-02-14 09:36:52'),
(60, 0x62616820696f206c612066616363696f206d65676c696f20f09fa490, 3.0, 72, 24, '2024-03-07 09:47:46'),
(83, 0x66696e616c6d656e746520756e20636f72736f2073752071756573746f206172676f6d656e746f21, 5.0, 68, 21, '2024-03-21 10:00:24'),
(96, 0x5468616e6b20796f752c2069206d616465206d79206669727374203130306b2066726f6d20796f757220636f7572736521, 5.0, 68, 28, '2024-04-21 16:16:57'),
(98, 0x42656c6c6f, 3.5, 110, 30, '2024-05-07 09:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL,
  `description` blob DEFAULT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT 0,
  `folder` blob NOT NULL,
  `category` int(11) DEFAULT NULL,
  `user_created` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `creation_date`, `description`, `verified`, `folder`, `category`, `user_created`, `state`) VALUES
(21, 'come copiare', '2024-02-08 09:28:23', 0x636f6d6520636f7069617265, 0, 0x6173736574732f636f75727365732f363563343930613761313663652f, 6, 68, 0),
(22, 'come costruire un tavolo', '2024-02-08 09:28:43', 0x636f6d6520636f7374727569726520756e207461766f6c6f, 1, 0x6173736574732f636f75727365732f363563343930626234613734392f, NULL, 68, 1),
(24, 'come cucinare la carbonara', '2024-02-08 09:30:36', 0x6c6120636172626f6372656d6120c383c2b0c382c29fc382c294c382c2a5, 1, 0x6173736574732f636f75727365732f363563343931326362643962372f, 2, 70, 1),
(27, '</h2><button>HTML Injection</button><h2>', '2024-04-14 16:06:15', 0x3c2f68343e3c696672616d652077696474683d2235363022206865696768743d2233313522207372633d2268747470733a2f2f7777772e796f75747562652e636f6d2f656d6265642f75674e3039563868705a453f73693d44463767586b47515a536964726e6c3822207469746c653d22596f755475626520766964656f20706c6179657222206672616d65626f726465723d22302220616c6c6f773d22616363656c65726f6d657465723b206175746f706c61793b20636c6970626f6172642d77726974653b20656e637279707465642d6d656469613b206779726f73636f70653b20706963747572652d696e2d706963747572653b207765622d736861726522207265666572726572706f6c6963793d227374726963742d6f726967696e2d7768656e2d63726f73732d6f726967696e2220616c6c6f7766756c6c73637265656e3e3c2f696672616d653e3c68343e, 0, 0x6173736574732f636f75727365732f363631626532643733633566352f, NULL, 68, 1),
(28, 'Bot University free trial', '2024-04-21 16:01:16', 0x4c6561726e2074686520626173696373206f662074686520626f7420756e697665727369747920636f75727365, 1, 0x6173736574732f636f75727365732f363632353163326338633635352f, 4, 68, 1),
(30, 'Come progettare lo schema E-R', '2024-05-07 09:14:03', 0x4e6f206465736372697074696f6e206164646564, 0, 0x6173736574732f636f75727365732f363633396434626238353831622f, 1, 110, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `courses_view`
-- (See below for the actual view)
--
CREATE TABLE `courses_view` (
`id` int(11)
,`name` varchar(50)
,`creation_date` datetime
,`description` blob
,`verified` tinyint(4)
,`folder` blob
,`category` int(11)
,`user_created` int(11)
,`state` tinyint(4)
,`username` varchar(40)
,`course_id` int(11)
,`user_id` int(11)
,`avgRating` decimal(4,1)
,`nComments` bigint(21)
,`nChapters` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `id_course` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `examScore` int(11) NOT NULL,
  `date_done` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `id_course`, `id_user`, `examScore`, `date_done`) VALUES
(4, 24, 68, 2, NULL),
(5, 28, 68, 2, NULL),
(6, 24, 70, 2, NULL),
(7, 24, 109, 1, '2024-05-02 09:55:06'),
(9, 22, 110, 3, '2024-05-07 09:19:12'),
(10, 24, 108, 1, '2024-05-22 17:22:09'),
(11, 30, 68, 2, '2024-05-30 10:03:26'),
(12, 22, 68, 4, '2024-05-30 10:03:59');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` blob NOT NULL DEFAULT 'question',
  `id_course` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `id_course`) VALUES
(4, 0x7175616e746920736f6e6f20676c6920696e6772656469656e74693f, 24),
(5, 0x6c61207465727261206520706961747461, 24),
(6, 0x57686f2061726520746865206265737420627569736e65737320706172746e6572733f, 28),
(7, 0x576861742069732074686520636f72726563742063757272656e637920666f7220627569736e657373207472616e73616374696f6e733f, 28),
(18, 0x576861742069732032202b20323f, 27),
(19, 0x5175616c20c3a820696c207072696d6f20706173736f206e656c6c6120636f737472757a696f6e6520646920756e207461766f6c6f20696e206c65676e6f3f, 22),
(20, 0x5175616c65207469706f206469206c65676e6f20c3a82073706573736f207574696c697a7a61746f2070657220636f73747275697265207461766f6c693f, 22),
(21, 0x436f736120646f767265737469206661726520646f706f206176657220617373656d626c61746f20696c207069616e6f2064656c207461766f6c6f, 22),
(22, 0x5175616c20c3a8206c6f2073636f706f2064656c20736f74746f2d7461766f6c6f3f, 22),
(23, 0x436f6d652076656e676f6e6f2072617070726573656e74617465206c65206173736f6369617a696f6e693f, 30),
(24, 0x5175616c652063617264696e616c6974c3a020686120756e20656e746974c3a02064616c206c61746f206465626f6c653f, 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` blob NOT NULL,
  `password` varchar(255) NOT NULL,
  `pfp` varchar(255) NOT NULL DEFAULT 'assets/defaults/defaultPFP.png',
  `bio` varchar(255) DEFAULT 'User does not have a biography',
  `role` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `pfp`, `bio`, `role`) VALUES
(68, 'okke', 0x6f6b6b6540676d61696c2e636f6d, '$2y$10$0KKax9/0BA15kIXChtoDR.7sSGxhInS19LgNcA1kjAdG6R8qCKevS', 'assets/usersPics/65bd086773937.png', 'ayeyeyayy', 1),
(69, '68', 0x68657940676d61696c2e636f6d, '$2y$10$4D5Wwp7BjORlSRfzJcI80uz3fC4mc95C./PkfuUNflXcDEF2TDt9a', 'assets/usersPics/65bd2bdd717fd.png', 'cocco bello', 0),
(70, 'OKKE', 0x6f6b6b65656540676d61696c2e636f6d, '$2y$10$IoXQ5wqnGlSODLUQvOt0xuYmlyG9uQ8L9v2yccJdiwF.zNwZOJT22', 'assets/usersPics/65bd2c21d7a64.png', 'yo', 0),
(71, 'bellaraga', 0x4f6b6b6540676d61696c2e636f6d, '$2y$10$ltn0GH24zwgF7ducUlwHNeWjhcT3XdyspyXBhgKvDS2PKCV31lCn6', 'assets/defaults/defaultPFP.png', 'User does not have a bio', 0),
(72, 'CiccioGamer89', 0x63696363696f626f6d6261383940676d61696c2e636f6d, '$2y$10$SlsjKpqDUtBiTB8Fl41yeulGpnK68dYXXNkFR/w9QW7ro0ILQ0Quu', 'assets/usersPics/65e97bb7ae421.png', 'PIJATELO PIJATELO', 0),
(73, 'Spigo3000', 0x73746566616e6f737069676f6c6f6e40676d61696c2e636f6d, '$2y$10$wMkfzMZoFDJ4MgSnbLimBuTvpgn6Id/tqFM6G5h7ytuP4LIfZiBTG', 'assets/usersPics/65e97d6003462.png', 'Aspirante letterato, un giorno vorrei diventare come Roncallo', 0),
(94, 'CIao', 0x616461736440676d61696c2e636f6d, '$2y$10$8diAZ0grKVOd.N24e7qJ0.id0ETWztXsvftmFrJR/pWYIDNyRdxAe', 'assets/usersPics/65f30133d3ce3.png', 'as', 0),
(108, 'a', 0x6140612e61, '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'assets/usersPics/a_4d4605bb-df55-4b0f-88ef-7912f2e2a78e.png', 'aa', 1),
(109, 'aaa', 0x6140616161612e61, '$2y$10$1VKFQUS9dzZkOo8eLsxd8OrZ55Y42LikSlA4bYOcNRKyl83RC4upO', 'assets/defaults/defaultPFP.png', 'User does not have a biography', 0),
(110, 'Alessandro Tatti', 0x7461747469616c657373616e64726f40676d61696c2e636f6d, '$2y$10$ehxX8zdD8J/DZQCiIJLGcuuVeg.8qAO.ypno9.PMviXoonKjzLMwK', 'assets/usersPics/6639d4395a71a.png', 'User does not have a biography', 0),
(112, 'abc', 0x61626340676d61696c2e636f6d, 'a9993e364706816aba3e25717850c26c9cd0d89d', 'assets/usersPics/abc_0b62b92f-dccf-46d7-b726-113de74d6870.png', 'aaa', 0),
(114, 'kok', 0x6b6f6b406b6f6b2e6b6f6b, '3b4185eac11953b03d8df353f63866d419a7500a', 'assets/usersPics/kok_d2266774-487e-48d5-9d2b-0692104a7e72.png', 'a', 0),
(116, 'Test', 0x7440742e74, '8efd86fb78a56a5145ed7739dcb00c78581c5375', 'assets/defaults/defaultPFP.png', 'okok', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `users_view`
-- (See below for the actual view)
--
CREATE TABLE `users_view` (
`id` int(11)
,`username` varchar(40)
,`email` blob
,`password` varchar(255)
,`pfp` varchar(255)
,`bio` varchar(255)
,`role` int(11)
,`score` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `verified_exams`
-- (See below for the actual view)
--
CREATE TABLE `verified_exams` (
`id` int(11)
,`id_course` int(11)
,`id_user` int(11)
,`examScore` int(11)
,`date_done` datetime
);

-- --------------------------------------------------------

--
-- Structure for view `courses_view`
--
DROP TABLE IF EXISTS `courses_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `courses_view`  AS SELECT `courses`.`id` AS `id`, `courses`.`name` AS `name`, `courses`.`creation_date` AS `creation_date`, `courses`.`description` AS `description`, `courses`.`verified` AS `verified`, `courses`.`folder` AS `folder`, `courses`.`category` AS `category`, `courses`.`user_created` AS `user_created`, `courses`.`state` AS `state`, `users`.`username` AS `username`, `courses`.`id` AS `course_id`, `users`.`id` AS `user_id`, round(avg(`comments`.`rating`),1) AS `avgRating`, count(distinct `comments`.`id`) AS `nComments`, count(distinct `chapters`.`id`) AS `nChapters` FROM (((`courses` join `users` on(`users`.`id` = `courses`.`user_created`)) left join `comments` on(`courses`.`id` = `comments`.`id_course`)) left join `chapters` on(`chapters`.`course_id` = `courses`.`id`)) GROUP BY `courses`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `users_view`
--
DROP TABLE IF EXISTS `users_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `users_view`  AS SELECT `users`.`id` AS `id`, `users`.`username` AS `username`, `users`.`email` AS `email`, `users`.`password` AS `password`, `users`.`pfp` AS `pfp`, `users`.`bio` AS `bio`, `users`.`role` AS `role`, ifnull(sum(`verified_exams`.`examScore`),0) AS `score` FROM (`users` left join `verified_exams` on(`users`.`id` = `verified_exams`.`id_user`)) GROUP BY `users`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `verified_exams`
--
DROP TABLE IF EXISTS `verified_exams`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `verified_exams`  AS SELECT `exams`.`id` AS `id`, `exams`.`id_course` AS `id_course`, `exams`.`id_user` AS `id_user`, `exams`.`examScore` AS `examScore`, `exams`.`date_done` AS `date_done` FROM (`exams` join `courses` on(`courses`.`id` = `exams`.`id_course`)) WHERE `courses`.`verified` = 1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_question` (`id_question`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id_fk` (`course_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`),
  ADD KEY `user_created` (`user_created`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_course` (`id_course`),
  ADD KEY `exam_user` (`id_user`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_course` (`id_course`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `fk_question` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `course_id_fk` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`user_created`) REFERENCES `users` (`id`);

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exam_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`id_course`) REFERENCES `courses` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `question_course` FOREIGN KEY (`id_course`) REFERENCES `courses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

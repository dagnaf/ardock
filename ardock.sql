-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2015 at 11:41 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ardock`
--
DROP DATABASE IF EXISTS `ardock`;
CREATE DATABASE IF NOT EXISTS `ardock` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ardock`;

-- --------------------------------------------------------

--
-- Table structure for table `molecule`
--

DROP TABLE IF EXISTS `molecule`;
CREATE TABLE IF NOT EXISTS `molecule` (
`id` int(11) NOT NULL,
  `name` char(4) NOT NULL,
  `type` enum('ligand','receptor') DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
`id` bigint(16) NOT NULL,
  `uid` bigint(16) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` varchar(500) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `post_brief`
--
DROP VIEW IF EXISTS `post_brief`;
CREATE TABLE IF NOT EXISTS `post_brief` (
`id` bigint(16)
,`uid` bigint(16)
,`title` varchar(50)
,`content` varchar(500)
,`time` timestamp
,`username` varchar(16)
,`numrep` bigint(21)
,`lastrep_time` timestamp
);
-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

DROP TABLE IF EXISTS `reply`;
CREATE TABLE IF NOT EXISTS `reply` (
`id` bigint(16) NOT NULL,
  `tid` bigint(16) NOT NULL,
  `uid` bigint(16) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(500) NOT NULL,
  `pid` bigint(16) DEFAULT NULL,
  `del` tinyint(1) NOT NULL DEFAULT '0',
  `floor` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `reply_brief`
--
DROP VIEW IF EXISTS `reply_brief`;
CREATE TABLE IF NOT EXISTS `reply_brief` (
`id` bigint(16)
,`tid` bigint(16)
,`pid` bigint(16)
,`uid` bigint(16)
,`content` varchar(500)
,`time` timestamp
,`del` tinyint(1)
,`username` varchar(16)
,`floor` int(11)
,`puid` bigint(20)
,`pcontent` varchar(500)
,`ptime` timestamp
,`pusername` varchar(16)
,`pfloor` bigint(11)
);
-- --------------------------------------------------------

--
-- Table structure for table `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
`id` bigint(16) NOT NULL,
  `uid` bigint(16) NOT NULL,
  `mark` int(11) DEFAULT NULL,
  `rid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `matrix` varchar(200) DEFAULT NULL,
  `result` double NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- RELATIONS FOR TABLE `score`:
--   `lid`
--       `molecule` -> `id`
--   `rid`
--       `molecule` -> `id`
--   `uid`
--       `user` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
`id` bigint(16) NOT NULL,
  `name` varchar(16) NOT NULL,
  `passwd` char(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `point` int(8) NOT NULL DEFAULT '0',
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Structure for view `post_brief`
--
DROP TABLE IF EXISTS `post_brief`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_brief` AS select `post`.`id` AS `id`,`post`.`uid` AS `uid`,`post`.`title` AS `title`,`post`.`content` AS `content`,`post`.`time` AS `time`,`user`.`name` AS `username`,count(`reply`.`id`) AS `numrep`,max(`reply`.`time`) AS `lastrep_time` from ((`post` join `user` on((`post`.`uid` = `user`.`id`))) left join `reply` on((`post`.`id` = `reply`.`tid`))) where ((`post`.`del` = 0) and ((`reply`.`del` = 0) or isnull(`reply`.`del`))) group by `post`.`id` order by if(`reply`.`id`,max(`reply`.`time`),`post`.`time`) desc;

-- --------------------------------------------------------

--
-- Structure for view `reply_brief`
--
DROP TABLE IF EXISTS `reply_brief`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reply_brief` AS select `r`.`id` AS `id`,`r`.`tid` AS `tid`,`r`.`pid` AS `pid`,`r`.`uid` AS `uid`,`r`.`content` AS `content`,`r`.`time` AS `time`,`r`.`del` AS `del`,`ru`.`name` AS `username`,`r`.`floor` AS `floor`,if(`r`.`pid`,`p`.`uid`,NULL) AS `puid`,if(`r`.`pid`,`p`.`content`,NULL) AS `pcontent`,if(`r`.`pid`,`p`.`time`,NULL) AS `ptime`,if(`r`.`pid`,`pu`.`name`,NULL) AS `pusername`,if(`r`.`pid`,`p`.`floor`,NULL) AS `pfloor` from (((`reply` `r` join `reply` `p`) join `user` `ru` on((`r`.`uid` = `ru`.`id`))) join `user` `pu` on((`p`.`uid` = `pu`.`id`))) where ((`r`.`pid` = `p`.`id`) or ((`r`.`id` = `p`.`id`) and isnull(`r`.`pid`)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `molecule`
--
ALTER TABLE `molecule`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `molecule`
--
ALTER TABLE `molecule`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
MODIFY `id` bigint(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
MODIFY `id` bigint(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
MODIFY `id` bigint(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` bigint(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

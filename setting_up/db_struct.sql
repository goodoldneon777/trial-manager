-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 20, 2015 at 11:56 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trial_mgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `trial`
--

CREATE TABLE `trial` (
  `trial_seq` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_dt` datetime NOT NULL,
  `end_dt` datetime NOT NULL,
  `owner` varchar(15) NOT NULL,
  `proc_chg_num` varchar(15) DEFAULT NULL,
  `twi_num` varchar(15) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `goal_type` varchar(20) DEFAULT NULL,
  `change_type` varchar(20) DEFAULT NULL,
  `bop_vsl` tinyint(4) DEFAULT NULL,
  `degas_vsl` tinyint(4) DEFAULT NULL,
  `argon_station` tinyint(4) DEFAULT NULL,
  `caster_num` tinyint(4) DEFAULT NULL,
  `strand_num` tinyint(4) DEFAULT NULL,
  `comment_goal` text,
  `comment_monitor` text,
  `comment_general` text,
  `comment_conclusion` text,
  `create_dt` datetime DEFAULT NULL,
  `update_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trial_comment`
--

CREATE TABLE `trial_comment` (
  `trial_seq` int(11) NOT NULL,
  `comment_seq` int(11) NOT NULL,
  `comment_dt` datetime NOT NULL,
  `comment_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trial_group`
--

CREATE TABLE `trial_group` (
  `group_seq` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_dt` datetime NOT NULL,
  `end_dt` datetime NOT NULL,
  `owner` varchar(15) NOT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `goal_type` varchar(20) DEFAULT NULL,
  `change_type` varchar(20) DEFAULT NULL,
  `bop_vsl` tinyint(4) DEFAULT NULL,
  `degas_vsl` tinyint(4) DEFAULT NULL,
  `argon_station` tinyint(4) DEFAULT NULL,
  `caster_num` tinyint(4) DEFAULT NULL,
  `strand_num` tinyint(4) DEFAULT NULL,
  `comment_goal` text,
  `comment_monitor` text,
  `comment_general` text,
  `comment_conclusion` text,
  `create_dt` datetime DEFAULT NULL,
  `update_dt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trial_group_child`
--

CREATE TABLE `trial_group_child` (
  `group_seq` int(11) NOT NULL,
  `trial_seq` int(11) NOT NULL,
  `group_name` varchar(100) DEFAULT NULL,
  `group_start_dt` datetime DEFAULT NULL,
  `group_end_dt` datetime DEFAULT NULL,
  `trial_name` varchar(100) DEFAULT NULL,
  `trial_unit` varchar(20) NOT NULL,
  `trial_start_dt` datetime DEFAULT NULL,
  `trial_end_dt` datetime DEFAULT NULL,
  `deleted_flag` int(11) NOT NULL DEFAULT '0',
  `comment` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trial_group_comment`
--

CREATE TABLE `trial_group_comment` (
  `group_seq` int(11) NOT NULL,
  `comment_seq` int(11) NOT NULL,
  `comment_dt` datetime NOT NULL,
  `comment_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trial_ht`
--

CREATE TABLE `trial_ht` (
  `trial_seq` int(11) NOT NULL,
  `ht_num` varchar(6) NOT NULL,
  `tap_yr` varchar(2) NOT NULL,
  `ht_seq` int(11) NOT NULL,
  `trial_name` varchar(100) DEFAULT NULL,
  `trial_start_dt` datetime DEFAULT NULL,
  `trial_end_dt` datetime DEFAULT NULL,
  `bop_vsl` varchar(2) DEFAULT NULL,
  `degas_vsl` varchar(1) DEFAULT NULL,
  `argon_num` varchar(1) DEFAULT NULL,
  `caster_num` varchar(1) DEFAULT NULL,
  `strand_num` varchar(1) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `trial`
--
ALTER TABLE `trial`
  ADD PRIMARY KEY (`trial_seq`);

--
-- Indexes for table `trial_comment`
--
ALTER TABLE `trial_comment`
  ADD PRIMARY KEY (`trial_seq`,`comment_seq`);

--
-- Indexes for table `trial_group`
--
ALTER TABLE `trial_group`
  ADD PRIMARY KEY (`group_seq`);

--
-- Indexes for table `trial_group_child`
--
ALTER TABLE `trial_group_child`
  ADD PRIMARY KEY (`group_seq`,`trial_seq`);

--
-- Indexes for table `trial_group_comment`
--
ALTER TABLE `trial_group_comment`
  ADD PRIMARY KEY (`group_seq`,`comment_seq`),
  ADD KEY `comment_seq` (`comment_seq`);

--
-- Indexes for table `trial_ht`
--
ALTER TABLE `trial_ht`
  ADD PRIMARY KEY (`trial_seq`,`ht_num`,`tap_yr`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trial`
--
ALTER TABLE `trial`
  MODIFY `trial_seq` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trial_group`
--
ALTER TABLE `trial_group`
  MODIFY `group_seq` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

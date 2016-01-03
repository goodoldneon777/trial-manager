-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 03, 2016 at 05:08 AM
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

--
-- Dumping data for table `param_input`
--

INSERT INTO `param_input` (`name_id`, `html_type`, `title`, `title_short`, `tooltip_info`, `tooltip_search`) VALUES
('argon_num', 'select', 'Argon #', 'Argon', 'Will this occur at only one Argon station?', NULL),
('bop_vsl', 'select', 'BOP Vsl', NULL, 'Will this occur at only one BOP vessel?', NULL),
('caster_num', 'select', 'Caster #', 'Caster', 'Will this occur at only one Caster?', NULL),
('change_type', 'select', 'Change Type', NULL, 'What''s being changed?', 'What was changed.'),
('comment_conclusion', 'textarea', 'Conclusion', NULL, 'What were the results? Was it successful?', NULL),
('comment_general', 'textarea', 'Other Info', NULL, 'Any miscellaneous info.', NULL),
('comment_goal', 'textarea', 'Goals', NULL, 'What are the specific goals?', NULL),
('comment_monitor', 'textarea', 'Monitor', NULL, 'What will be monitored and/or analyzed?', NULL),
('degas_vsl', 'select', 'Degas Vsl', 'RH Vsl', 'Will this occur at only one Degasser vessel?', NULL),
('end_dt', 'input', 'End Date', NULL, NULL, 'Anything that occurred on or before this date.'),
('goal_type', 'select', 'Goal Type', NULL, 'What is the desired improvement?', 'Desired improvement.'),
('name', 'input', 'Name', NULL, 'Can be the same as a previous name.', 'Partial name search. For example, ''BOP FeP Addition'' would show up if you enter ''FeP''.'),
('owner', 'input', 'Owner', NULL, NULL, NULL),
('proc_chg_num', 'input', 'Process Change', 'Proc Chg', NULL, NULL),
('start_dt', 'input', 'Start Date', NULL, NULL, 'Anything that occurred on or after this date.'),
('strand_num', 'select', 'Strand #', 'Strand', 'Will this occur at only one Caster strand?', NULL),
('twi_num', 'input', 'TWI', NULL, NULL, NULL),
('unit', 'select', 'Unit', NULL, 'Where will this trial be performed?', 'Trials performed at this unit.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

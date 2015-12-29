-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2015 at 12:05 AM
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
-- Table structure for table `param_dropdown`
--

CREATE TABLE `param_dropdown` (
  `name` varchar(100) NOT NULL,
  `order` int(11) NOT NULL,
  `value` varchar(100) NOT NULL,
  `text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `param_dropdown`
--

INSERT INTO `param_dropdown` (`name`, `order`, `value`, `text`) VALUES
('argon_station', 1, '', ''),
('argon_station', 2, '', '1'),
('argon_station', 3, '', '2'),
('bop_vsl', 1, '', ''),
('bop_vsl', 2, '', '25'),
('bop_vsl', 3, '', '26'),
('caster_num', 1, '', ''),
('caster_num', 2, '', '1'),
('caster_num', 3, '', '2'),
('change_type', 1, '', ''),
('change_type', 2, '', 'Equipment'),
('change_type', 3, '', 'Material'),
('change_type', 4, '', 'Model'),
('change_type', 5, '', 'Procedure'),
('change_type', 6, '', 'Other'),
('degas_vsl', 1, '', ''),
('degas_vsl', 2, '', '1'),
('degas_vsl', 3, '', '2'),
('goal_type', 1, '', ''),
('goal_type', 2, '', 'Cost'),
('goal_type', 3, '', 'Process'),
('goal_type', 4, '', 'Quality'),
('goal_type', 5, '', 'Safety'),
('goal_type', 6, '', 'Other'),
('strand_num', 1, '', ''),
('strand_num', 2, '', '1'),
('strand_num', 3, '', '2'),
('strand_num', 4, '', '3'),
('strand_num', 5, '', '4'),
('unit', 1, '', ''),
('unit', 2, '', 'BF'),
('unit', 3, '', 'BOP'),
('unit', 4, '', 'Degas'),
('unit', 5, '', 'Argon'),
('unit', 6, '', 'LMF'),
('unit', 7, '', 'Caster');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `param_dropdown`
--
ALTER TABLE `param_dropdown`
  ADD PRIMARY KEY (`name`,`order`,`value`,`text`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

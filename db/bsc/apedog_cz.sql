-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 11, 2010 at 08:11 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `apedog_cz`
--

-- --------------------------------------------------------

--
-- Table structure for table `bsc_operations`
--

CREATE TABLE IF NOT EXISTS `bsc_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `responsible` int(11) NOT NULL,
  `when` date NOT NULL,
  `status` int(1) NOT NULL,
  `strategic_action` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bsc_operations`
--

INSERT INTO `bsc_operations` (`id`, `name`, `responsible`, `when`, `status`, `strategic_action`) VALUES
(1, 'Targeted promo campaign - info from TM to PR', 1, '2010-07-30', 1, 1),
(2, 'Quality selection planned					', 1, '2010-08-15', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_responsible`
--

CREATE TABLE IF NOT EXISTS `bsc_responsible` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lc` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bsc_responsible`
--

INSERT INTO `bsc_responsible` (`id`, `name`, `lc`) VALUES
(1, 'Šárka', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_strategic_action`
--

CREATE TABLE IF NOT EXISTS `bsc_strategic_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `strategy` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bsc_strategic_action`
--

INSERT INTO `bsc_strategic_action` (`id`, `name`, `strategy`) VALUES
(1, 'Promo campaing', 1),
(2, 'Quality of applicants', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_strategy`
--

CREATE TABLE IF NOT EXISTS `bsc_strategy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lc` int(11) NOT NULL,
  `csfs` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bsc_strategy`
--

INSERT INTO `bsc_strategy` (`id`, `name`, `lc`, `csfs`) VALUES
(1, 'Applicants for newies', 0, 15),
(2, 'Selection process', 0, 15),
(3, 'Allocation of new members', 0, 15);

-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Neděle 19. září 2010, 17:27
-- Verze MySQL: 5.1.41
-- Verze PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `apedog_20100919`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `csfs`
--

CREATE TABLE IF NOT EXISTS `csfs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 NOT NULL,
  `description` varchar(45) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `business_perspective` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Critical succes factor ' AUTO_INCREMENT=17 ;

--
-- Vypisuji data pro tabulku `csfs`
--

INSERT INTO `csfs` (`id`, `name`, `description`, `created`, `updated`, `business_perspective`) VALUES
(1, 'X+L, Quality, TD+X', '', '2009-09-01 17:29:51', '2010-04-28 05:13:29', 16),
(2, 'LDS', 'Leadership', '2009-09-01 17:30:18', '2010-04-27 08:30:35', 16),
(3, 'X', 'Exchange', '2009-09-01 17:30:31', '2010-04-27 08:30:14', 16),
(4, 'Finance & Sustainability', '', '2009-09-01 17:30:44', '2010-04-28 05:14:26', 18),
(5, 'EPs and Members', '', '2009-09-01 17:30:51', '2010-04-28 05:14:39', 19),
(6, 'Companies & Non-corporate', '', '2009-09-01 17:31:14', '2010-04-28 05:15:15', 19),
(7, 'Positioning (companies & students)', '', '2009-09-01 17:34:48', '2010-04-28 05:16:04', 19),
(8, 'Market Analysis', '', '2009-09-01 17:35:27', '2010-03-09 08:16:30', 20),
(9, 'Account management (partners and alumni)', '', '2009-09-01 17:35:35', '2010-04-28 05:16:49', 20),
(10, 'Planning and Review', '', '2009-09-01 17:35:43', '2010-03-09 08:20:22', 20),
(11, 'Managing Information', '', '2009-09-01 17:35:51', '2010-03-09 08:20:12', 20),
(12, 'Gouvernance and Accountability', '', '2009-09-01 17:36:00', '2010-03-09 08:19:42', 20),
(13, 'IT Structure', '', '2009-09-01 17:36:08', '2010-03-09 08:20:43', 21),
(14, 'Managing Members', '', '2009-09-01 17:36:16', '2010-04-28 05:17:05', 21),
(15, 'Recruitment and Induction', '', '2009-09-01 17:36:24', '2010-03-09 08:20:31', 21),
(16, 'Exchange Management (matching)', 'XM', '2010-03-09 08:21:22', '2010-04-28 05:20:22', 20);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

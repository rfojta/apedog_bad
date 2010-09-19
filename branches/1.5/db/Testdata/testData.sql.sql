--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `description`, `created`, `updated`) VALUES
(1, 'PR', 'public relation', '0000-00-00 00:00:00', '2009-08-16 19:54:14'),
(2, 'ICX', 'incoming exchange', '0000-00-00 00:00:00', '2009-07-27 01:45:26'),
(3, 'OGX', 'outgoing exchange', '0000-00-00 00:00:00', '2009-07-28 12:18:34'),
(4, 'TM', 'talent management', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'ER', 'enterprise relationship', '0000-00-00 00:00:00', '2009-07-27 01:40:08'),
(6, 'F', 'finance', '2009-07-27 21:16:53', '2009-07-28 12:18:51'),
(7, 'P', 'President', '0000-00-00 00:00:00', '2009-07-28 12:20:41');

--
-- Dumping data for table `business_perspectives`
--

INSERT INTO `business_perspectives` (`id`, `name`, `description`, `created`, `updated`) VALUES
(11, 'Customers', 'create new item', '2009-08-08 23:02:14', '0000-00-00 00:00:00'),
(12, 'Internal Processes', 'create new item', '2009-08-08 23:02:27', '0000-00-00 00:00:00'),
(13, 'Learning and Capacity', 'create new item', '2009-08-08 23:02:41', '0000-00-00 00:00:00'),
(9, 'The Way we do it', 'create new item', '2009-08-08 23:01:54', '0000-00-00 00:00:00'),
(10, 'Sustainability', 'create new item', '2009-08-08 23:02:01', '0000-00-00 00:00:00');

--
-- Dumping data for table `csfs`
--

INSERT INTO `csfs` (`id`, `name`, `description`, `created`, `updated`, `business_perspective`) VALUES
(2, 'QXP', 'quality of experience', '2009-08-08 22:59:16', '2009-08-08 23:04:40', 9),
(3, 'GLXP', 'dunno', '2009-08-08 23:00:13', '2009-08-08 23:04:47', 9),
(4, 'IXXP', 'dunno', '2009-08-08 23:00:39', '2009-08-08 23:04:51', 9),
(5, 'FH&S', 'critical success factor', '2009-08-08 23:05:17', '0000-00-00 00:00:00', 10),
(6, 'OROM', 'CDROM', '2009-08-08 23:05:48', '0000-00-00 00:00:00', 11),
(7, 'CNMIO', 'critical success factor', '2009-08-08 23:06:20', '2009-08-08 23:06:40', 11),
(8, 'EPSO', 'critical success factor', '2009-08-08 23:07:34', '0000-00-00 00:00:00', 11),
(9, 'MA', 'critical success factor', '2009-08-08 23:07:46', '0000-00-00 00:00:00', 12),
(10, 'RMPA', 'critical success factor', '2009-08-08 23:08:03', '0000-00-00 00:00:00', 12),
(11, 'P&R', 'critical success factor', '2009-08-08 23:08:17', '0000-00-00 00:00:00', 12),
(12, 'Managing Information', 'critical success factor', '2009-08-08 23:09:09', '0000-00-00 00:00:00', 12),
(13, 'G&A', 'critical success factor', '2009-08-08 23:09:29', '0000-00-00 00:00:00', 12),
(14, 'IT', 'critical success factor', '2009-08-08 23:09:42', '0000-00-00 00:00:00', 13),
(15, 'MT', 'critical success factor', '2009-08-08 23:09:52', '0000-00-00 00:00:00', 13),
(16, 'R&I', 'critical success factor', '2009-08-08 23:10:04', '0000-00-00 00:00:00', 13);

--
-- Dumping data for table `detail_tracking`
--


--
-- Dumping data for table `kpis`
--

INSERT INTO `kpis` (`id`, `name`, `description`, `created`, `updated`, `area`, `csf`, `kpi_unit`, `graphs`, `end_of_term`, `all_lcs`) VALUES
(2, 'Quality index performance', 'Number of stars -  Quality Of the Experiences z myaiesec.net', '2009-08-08 23:48:00', '2009-08-24 13:16:26', 3, 2, 4, 1, 1, 0),
(3, 'Number of members that finished both X & LR experiences', 'create new item', '2009-08-08 23:48:41', '2009-08-24 21:51:49', 3, 2, 0, 1, 1, 0),
(4, 'Number of members with leadership experience finished', 'create new item', '2009-08-09 00:06:41', '2009-08-24 21:52:47', 4, 3, 5, 1, 1, 0),
(5, 'Number of TN realized', 'create new item', '2009-08-09 00:07:04', '0000-00-00 00:00:00', 2, 4, 0, 0, 0, 0),
(6, 'Number of EP realized', 'create new item', '2009-08-09 00:07:25', '0000-00-00 00:00:00', 3, 4, 0, 0, 0, 0),
(7, 'Real state of finance (cash + receivables - liabilities)', 'create new item', '2009-08-09 00:10:20', '2009-08-09 00:12:23', 6, 5, 0, 0, 0, 0),
(8, 'Number of months of reserve = (cash + receivables - liabilities)/average monthly outflow', 'create new item', '2009-08-09 00:10:41', '2009-08-09 00:12:48', 6, 5, 0, 0, 0, 0),
(9, 'Number of EP Raised', 'create new item', '2009-08-09 00:13:29', '0000-00-00 00:00:00', 3, 6, 0, 0, 0, 0),
(10, 'Number of TN Raised', 'create new item', '2009-08-09 00:13:54', '0000-00-00 00:00:00', 2, 7, 0, 0, 0, 0),
(11, 'How often do you run a competitive analysis? ', 'create new item', '2009-08-09 00:14:19', '0000-00-00 00:00:00', 2, 9, 0, 0, 0, 0),
(12, 'did you run a competitive analysis?', 'Yes/no', '2009-08-09 12:46:02', '2009-08-18 20:45:09', 0, 0, 5, 0, 0, 0);


--
-- Dumping data for table `kpi_units`
--

INSERT INTO `kpi_units` (`id`, `name`, `description`, `spec`, `created`, `updated`) VALUES
(1, 'days', 'represents count of days', '', '2009-08-16 17:52:05', '0000-00-00 00:00:00'),
(2, '%', 'represents percentage of something', '', '2009-08-16 17:52:25', '0000-00-00 00:00:00'),
(3, '', 'represents real numbers', '', '2009-08-16 17:53:06', '0000-00-00 00:00:00'),
(4, 'CZK', 'currency', '', '2009-08-16 18:02:30', '0000-00-00 00:00:00'),
(5, '', 'Yes/No', 'boolean', '0000-00-00 00:00:00', '2009-08-18 21:05:38');


--
-- Dumping data for table `lcs`
--

INSERT INTO `lcs` (`id`, `name`, `description`, `created`, `updated`) VALUES
(2, 'Plzen', '', '0000-00-00 00:00:00', '2009-07-28 18:01:03'),
(3, 'Praha', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'CZU Praha', '', '0000-00-00 00:00:00', '2009-07-28 18:00:54'),
(5, 'Pardubice', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Olomouc', '', '0000-00-00 00:00:00', '2009-07-29 02:39:40'),
(7, 'Brno', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Ostrava', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Karvina', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Zlin', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');


--
-- Dumping data for table `lc_kpi`
--

INSERT INTO `lc_kpi` (`id`, `lc`, `kpi`, `created`, `updated`) VALUES
(4, 6, 2, '2009-08-24 13:14:27', '0000-00-00 00:00:00'),
(5, 5, 2, '2009-08-24 13:16:14', '0000-00-00 00:00:00'),
(6, 7, 2, '2009-08-24 13:16:26', '0000-00-00 00:00:00'),
(14, 3, 3, '2009-08-24 21:51:49', '0000-00-00 00:00:00'),
(15, 1, 4, '2009-08-24 21:52:47', '0000-00-00 00:00:00'),
(16, 2, 4, '2009-08-24 21:52:47', '0000-00-00 00:00:00'),
(17, 3, 4, '2009-08-24 21:52:47', '0000-00-00 00:00:00');


--
-- Dumping data for table `quarters`
--

INSERT INTO `quarters` (`id`, `quarter_from`, `quarter_to`, `description`, `created`, `updated`, `term`, `quarter_in_term`) VALUES
(3, '2009-12-16', '2010-03-31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 3),
(2, '2009-09-16', '2009-12-31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 2),
(1, '2009-06-16', '2009-09-30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1),
(4, '2010-03-16', '2010-06-30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 4),
(5, '2010-06-16', '2010-09-30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 1),
(6, '2010-09-16', '2010-12-31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 2),
(8, '2011-03-16', '2011-06-30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 4),
(7, '2010-12-16', '2011-03-31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 3);



--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `term_from`, `term_to`, `description`, `created`, `updated`, `number_of_term`) VALUES
(2, '2010-07-01', '2011-06-30', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(1, '2009-07-01', '2010-06-30', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);


--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `lc`, `pass`, `login`, `created`, `updated`) VALUES
(10, 'Marek', 'Beran', 10, 'brucelee', 'Praha', '0000-00-00 00:00:00', '2009-07-28 17:52:50'),
(2, '', '', 3, 'brucelee', 'Ostrava', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '', '', 8, 'brucelee', 'Plzen', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, '', '', 7, 'brucelee', 'Pardubice', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, '', '', 2, 'brucelee', 'Brno', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '', '', 6, 'brucelee', 'CZU', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, '', '', 9, 'brucelee', 'Karvina', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, '', '', 5, 'brucelee', 'Zlin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, '', '', 4, 'brucelee', 'Olomouc', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

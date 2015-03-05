-- phpMyAdmin SQL Dump
-- version home.pl
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 28 Gru 2014, 15:00
-- Wersja serwera: 5.5.40-36.1-log
-- Wersja PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `16598392_0000001`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(255) NOT NULL,
  `nested_level` int(11) DEFAULT NULL,
  `nested_parent` int(11) DEFAULT NULL,
  `nested_left` int(11) DEFAULT NULL,
  `nested_right` int(11) DEFAULT NULL,
  `category_type` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `nested_parent` (`nested_parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=862 AUTO_INCREMENT=20 ;

--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`id`, `category_title`, `nested_level`, `nested_parent`, `nested_left`, `nested_right`, `category_type`) VALUES
(1, 'InCategory 1', 0, 0, 1, 8, 1),
(2, 'InCategory 2', 0, 0, 8, 13, 1),
(3, 'InCategory 3', 0, 0, 13, 16, 1),
(4, 'InCategory 4', 0, 0, 16, 19, 1),
(5, 'InCategory 5', 0, 0, 19, 22, 1),
(6, 'SubInCategory 1.1', 1, 1, 2, 3, 1),
(7, 'SubInCategory 1.2', 1, 1, 4, 5, 1),
(8, 'SubInCategory 1.3', 1, 1, 6, 7, 1),
(9, 'SubInCategory 2.1', 1, 2, 9, 10, 1),
(10, 'SubInCategory 2.2', 1, 2, 11, 12, 1),
(11, 'SubInCategory 3.1', 1, 3, 14, 15, 1),
(12, 'SubInCategory 4.1', 1, 4, 17, 18, 1),
(13, 'SubInCategory 5.1', 1, 5, 20, 21, 1),
(14, 'OutCategory 1', 0, 0, 22, 29, 2),
(15, 'SubOutCategory 1.1', 1, 14, 23, 24, 2),
(16, 'SubOutCategory 1.2', 1, 14, 25, 26, 2),
(17, 'SubOutCategory 1.3', 1, 14, 27, 28, 2),
(18, 'OutCategory 2', 0, 0, 29, 32, 2),
(19, 'SubOutCategory 2.1', 1, 18, 30, 31, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_user_id` int(11) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_create_time` datetime DEFAULT NULL,
  `client_country` varchar(255) DEFAULT NULL,
  `client_city` varchar(255) DEFAULT NULL,
  `client_street` varchar(255) DEFAULT NULL,
  `client_postcode` varchar(255) DEFAULT NULL,
  `client_nip` int(11) DEFAULT NULL,
  `client_pesel` int(11) DEFAULT NULL,
  `client_regon` int(11) DEFAULT NULL,
  `client_other` varchar(255) DEFAULT NULL,
  `client_email` varchar(255) DEFAULT NULL,
  `client_pesel_type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_client_user_id` (`client_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `client`
--

INSERT INTO `client` (`id`, `client_user_id`, `client_name`, `client_create_time`, `client_country`, `client_city`, `client_street`, `client_postcode`, `client_nip`, `client_pesel`, `client_regon`, `client_other`, `client_email`, `client_pesel_type`) VALUES
(1, 55, 'New name', '2014-12-28 12:35:56', 'Russia', 'Krasnoyarsk', 'Mira street', '1234567', NULL, 123456, NULL, NULL, NULL, 20),
(2, 54, 'Client', '2014-12-28 13:34:28', 'Oslo', 'Sweden', 'Swede', '123', NULL, 213, NULL, NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_category_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_create_time` datetime NOT NULL,
  `item_submit_time` datetime NOT NULL,
  `item_amount` double DEFAULT NULL,
  `item_amount_left` double DEFAULT NULL,
  `item_total` double DEFAULT NULL,
  `item_type` varchar(255) NOT NULL,
  `item_end_time` datetime DEFAULT NULL,
  `item_client_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_item_category_id` (`item_category_id`),
  KEY `FK_item_client_id` (`item_client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=655 AUTO_INCREMENT=92 ;

--
-- Zrzut danych tabeli `item`
--

INSERT INTO `item` (`id`, `item_category_id`, `item_name`, `item_create_time`, `item_submit_time`, `item_amount`, `item_amount_left`, `item_total`, `item_type`, `item_end_time`, `item_client_id`) VALUES
(6, 11, 'item 6', '2014-08-23 14:08:12', '2014-08-15 00:00:00', 578, 2, 580, 'normal', NULL, NULL),
(7, 12, 'item 7', '2014-08-23 14:08:41', '2014-08-22 00:00:00', 456, 2, 458, 'normal', NULL, NULL),
(8, 13, 'item 8', '2014-08-23 14:09:06', '2014-08-21 00:00:00', 300, 34, 334, 'normal', NULL, NULL),
(29, 12, 'item 612354', '2014-08-26 14:08:44', '2014-08-26 00:00:00', 123, 5, 128, 'normal', NULL, NULL),
(30, 11, 'test 6', '2014-08-26 14:09:40', '2014-08-26 00:00:00', 345, 1, 346, 'normal', NULL, NULL),
(32, 13, 'test', '2014-08-26 14:14:00', '2014-08-26 00:00:00', 123, 1, 124, 'n', NULL, NULL),
(33, 11, 'test categ', '2014-08-26 14:22:50', '2014-08-26 00:00:00', 1234, 23, 1257, 'n', NULL, NULL),
(35, 13, 'test subcat active', '2014-08-26 14:28:11', '2014-08-26 00:00:00', 2345, 3, 2348, 'b', NULL, NULL),
(37, 10, 'new test', '2014-08-26 14:33:58', '2014-08-26 00:00:00', 1234, 345, 1579, 'fgh', NULL, NULL),
(39, 13, 'test003', '2014-08-26 14:37:41', '2014-08-31 00:00:00', 22, 22, 44, '22', NULL, NULL),
(40, 11, 'test004', '2014-08-26 14:38:06', '2014-08-31 00:00:00', 44, 44, 88, '44', NULL, NULL),
(44, 11, 'item 004', '2014-08-27 08:18:55', '2014-08-27 00:00:00', 234, 45, 279, 'n', NULL, NULL),
(45, 13, 'item', '2014-08-27 08:19:43', '2014-08-20 00:00:00', 234, 56, 290, 'n', NULL, NULL),
(46, 11, '1234', '2014-08-27 08:21:58', '2014-08-20 00:00:00', 2346, 6, 2352, 'b', NULL, NULL),
(50, 12, 'new test item 30', '2014-08-27 08:58:35', '2014-08-27 00:00:00', 3456, 345, 3801, 'n', NULL, NULL),
(51, 13, 'new test item 31', '2014-08-27 09:00:12', '2014-08-14 00:00:00', 245, 3, 248, 'n', NULL, NULL),
(56, 10, 'ertert', '2014-08-27 09:27:22', '2014-08-13 00:00:00', 234234, 3, 234237, 'fgh', NULL, NULL),
(69, 11, 'item test', '2014-08-29 09:56:37', '2014-08-29 00:00:00', 1234, 1, 1235, 'n', NULL, NULL),
(75, 11, 'item today', '2014-09-04 12:09:36', '2014-09-04 00:00:00', 234, 2, 236, '234', NULL, NULL),
(83, 6, 'ALEX', '2014-09-08 20:02:43', '2014-09-24 00:00:00', 400, 500, 900, 'normal', NULL, NULL),
(84, 10, 'ALEX 2', '2014-09-08 20:03:48', '2014-09-30 00:00:00', 5555, 6666, 12221, 'normal', NULL, NULL),
(85, 9, 'ffgfgs', '2014-09-09 08:40:52', '2014-09-10 00:00:00', 35, 345, 380, 'rft', NULL, NULL),
(86, 7, 'FV22', '2014-09-10 10:47:03', '2014-09-10 00:00:00', 22, 22, 44, '22', NULL, NULL),
(87, 6, 'FVV22', '2014-09-10 10:51:42', '2014-09-12 00:00:00', 22, 22, 44, '22', NULL, NULL),
(88, 10, 'PF1', '2014-09-10 10:54:26', '2014-09-10 00:00:00', 33, 33, 66, '33', NULL, NULL),
(89, 15, 'New name', '2014-12-28 00:00:00', '2014-12-28 00:00:00', 0, 28.29, 28.29, 'basic', '2015-01-04 00:00:00', 1),
(90, 6, 'Client', '2014-12-28 00:00:00', '2014-12-28 00:00:00', 0, 91.42, 91.42, 'basic', '2015-01-04 00:00:00', 2),
(91, 6, 'Client', '2014-12-28 00:00:00', '2014-12-28 00:00:00', 0, 27.06, 27.06, 'advanced', '2015-01-04 00:00:00', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `item_additional`
--

CREATE TABLE IF NOT EXISTS `item_additional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `yii` varchar(80) DEFAULT NULL,
  `unit` varchar(16) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `netto1` double DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `netto2` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Zrzut danych tabeli `item_additional`
--

INSERT INTO `item_additional` (`id`, `name`, `yii`, `unit`, `quantity`, `netto1`, `rate`, `netto2`, `total`, `item_id`) VALUES
(1, 'Name', 'Yii', 'szt.', 1, 23, 23, 23, 28.29, 89),
(2, 'Auto', '2', 'szt.', 3, 22.01, 23, 22.01, 27.07, 90),
(3, 'Rower', '3', 'szt.', 1, 55, 17, 55, 64.35, 90),
(4, 'ww', '22', 'szt.', 1, 22, 23, 22, 27.06, 91);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1365;

--
-- Zrzut danych tabeli `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1419671423),
('m141023_144830_db_refactor', 1419671425),
('m141028_140745_client_table', 1419671425),
('m141107_104547_client_table_alter', 1419671425),
('m141112_201304_additional_data_table', 1419671425),
('m141112_202112_alter_additional_table', 1419671425),
('m141126_082100_update_category_title', 1419671425),
('m141126_095300_insert_category_out_type', 1419671425),
('m141215_005317_item_table_alter', 1419671425),
('m141215_021653_item_table_alter', 1419671425),
('m141215_103951_item_table_alter', 1419671425),
('m141215_111240_client_table_alter', 1419671425);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_category_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_fav_number` int(11) NOT NULL,
  `user_password` text NOT NULL,
  `user_create_time` datetime NOT NULL,
  `user_submit_time` datetime NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `user_priority` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_category_id` (`user_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=309 AUTO_INCREMENT=56 ;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `user_category_id`, `user_name`, `user_email`, `user_fav_number`, `user_password`, `user_create_time`, `user_submit_time`, `user_type`, `user_priority`) VALUES
(1, 1, 'username 1', 'username1@email.com', 123456789, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:34:05', '2014-08-29 13:41:20', 'normal', 'low'),
(2, 2, 'username 2', 'username2@email.com', 3234, 'd41d8cd98f00b204e9800998ecf8427e', '2014-08-22 13:34:34', '0000-00-00 00:00:00', 'normal', 'high'),
(3, 3, 'username 3', 'username3@email.com', 3, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:34:56', '0000-00-00 00:00:00', 'normal', 'high'),
(4, 4, 'username4', 'username4@email.com', 4, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:35:15', '0000-00-00 00:00:00', 'normal', 'high'),
(5, 5, 'username 5', 'username5@email.com', 5, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:35:37', '0000-00-00 00:00:00', 'normal', 'high'),
(6, 6, 'username 6', 'username6@email.com', 6, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:36:03', '0000-00-00 00:00:00', 'normal', 'high'),
(7, 7, 'username 7', 'username7@email.com', 7, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:36:23', '0000-00-00 00:00:00', 'normal', 'high'),
(8, NULL, 'username 8', 'username8@email.com', 8, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:36:49', '0000-00-00 00:00:00', 'normal', 'high'),
(9, NULL, 'tele', 'tele.bv@gmail.com', 127, '14e1b600b1fd579f47433b88e8d85291', '2014-08-22 13:37:56', '2014-08-22 15:15:20', 'normal', 'high'),
(10, NULL, 'username 9', 'username9@email.com', 9, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 15:42:21', '0000-00-00 00:00:00', 'normal', 'high'),
(11, NULL, 'alex', 'negoita.alexandru@gmail.com', 66, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 15:46:30', '0000-00-00 00:00:00', 'normal', 'low'),
(12, NULL, 'nego', 'alex@mail.com', 127, 'b0baee9d279d34fa1dfd71aadb908c3f', '2014-08-22 15:49:27', '0000-00-00 00:00:00', 'normal', 'high'),
(13, NULL, 'aaa', 'aa@ffd.cvio', 127, '674f3c2c1a8a6f90461e8a66fb5550ba', '2014-08-22 15:51:25', '0000-00-00 00:00:00', 'normal', 'high'),
(14, NULL, 'Test', 't0119121191219121191@gmail.com', 127, 'ad0234829205b9033196ba818f7a872b', '2014-08-22 20:45:13', '2014-08-22 21:10:11', 'normal', 'high'),
(15, NULL, 'username10', 'username10@email.com', 127, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:07:45', '0000-00-00 00:00:00', 'normal', 'high'),
(16, NULL, 'username11', 'username11@email.com', 127, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:11:30', '0000-00-00 00:00:00', 'normal', 'high'),
(17, NULL, 'username12', 'username12@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:12:57', '0000-00-00 00:00:00', 'normal', 'high'),
(18, NULL, 'username13', 'username13@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:14:54', '0000-00-00 00:00:00', 'normal', 'high'),
(19, NULL, 'username14', 'username14@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:15:46', '0000-00-00 00:00:00', 'normal', 'high'),
(20, NULL, 'username15', 'username15@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:17:14', '0000-00-00 00:00:00', 'normal', 'high'),
(21, NULL, 'username16', 'username16@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:17:46', '0000-00-00 00:00:00', 'normal', 'high'),
(22, NULL, 'username17', 'username17@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:18:16', '0000-00-00 00:00:00', 'normal', 'high'),
(23, NULL, 'username18', 'username18@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:19:01', '2014-08-23 11:19:01', 'normal', 'high'),
(24, NULL, 'username19', 'username19@email.com', 1234567890, 'd41d8cd98f00b204e9800998ecf8427e', '2014-08-23 11:20:17', '2014-08-23 11:20:17', 'normal', 'high'),
(25, NULL, 'Alex', 'test@nego.com', 1, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-24 10:16:50', '2014-08-29 10:09:18', 'normal', 'low'),
(26, NULL, 'me', 'me@nego.com', 3, 'c33367701511b4f6020ec61ded352059', '2014-08-24 10:26:32', '2014-08-24 10:28:09', 'normal', 'high'),
(27, NULL, 'test', 'wt@a.pl', 222, '098f6bcd4621d373cade4e832627b4f6', '2014-08-24 12:49:24', '2014-08-24 12:49:25', 'normal', 'high'),
(28, NULL, 'test', 'test@test.test', 2, '098f6bcd4621d373cade4e832627b4f6', '2014-08-24 14:30:01', '2014-08-29 13:27:12', 'normal', 'high'),
(29, NULL, 'dfg', 'rfgd@sdf.copm', 345, '234324', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(30, NULL, 'teletinus', 'teletinus@teletinus.com', 123254576, '12345678', '2014-09-02 12:22:35', '0000-00-00 00:00:00', '', 'high'),
(31, NULL, '123 la perete stai', 'teletan@email.com', 12342345, 'fcea920f7412b5da7be0cf42b8c93759', '2014-09-02 12:32:31', '0000-00-00 00:00:00', '', 'high'),
(32, NULL, '123 la perete stai', 'teletan1@email.com', 12342345, '224cf2b695a5e8ecaecfb9015161fa4b', '2014-09-02 12:33:55', '0000-00-00 00:00:00', '', 'high'),
(33, NULL, '123 la perete stai', 'teletan12@email.com', 12342345, '8459d70c344917c311aeac9216969e3b', '2014-09-02 12:35:24', '0000-00-00 00:00:00', '', 'high'),
(34, NULL, 'teletan123', 'teletan123@asdas.com', 2345, 'fcea920f7412b5da7be0cf42b8c93759', '2014-09-02 12:37:20', '0000-00-00 00:00:00', '', 'high'),
(35, NULL, 'teletan123', 'teletan1233@asdas.com', 2345, 'fcea920f7412b5da7be0cf42b8c93759', '2014-09-02 12:37:37', '0000-00-00 00:00:00', '', 'high'),
(36, NULL, 'teletan123', 'teletan12334@asdas.com', 2345, 'fcea920f7412b5da7be0cf42b8c93759', '2014-09-02 12:37:53', '0000-00-00 00:00:00', '', 'high'),
(37, NULL, 'excalibur', 'excalibur@email.com', 234234, '827ccb0eea8a706c4c34a16891f84e7b', '2014-09-02 13:05:02', '0000-00-00 00:00:00', '', 'high'),
(38, NULL, 'nicolae', 'nicolaenichifor@gmail.com', 15, '8287458823facb8ff918dbfabcd22ccb', '2014-09-03 13:14:17', '0000-00-00 00:00:00', '', 'low'),
(39, NULL, 'Alex', 'nego@alex.com', 4, '698d51a19d8a121ce581499d7b701668', '2014-09-03 13:29:13', '0000-00-00 00:00:00', '', 'low'),
(40, NULL, 'alex', 'w@w.com', 4, '6512bd43d9caa6e02c990b0a82652dca', '2014-09-03 13:30:50', '0000-00-00 00:00:00', '', 'low'),
(41, NULL, 'username41', 'username41@email.com', 1234567, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 08:53:35', '0000-00-00 00:00:00', '', 'high'),
(42, NULL, 'username 42', 'username42@emaI.com', 1234, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 08:56:59', '0000-00-00 00:00:00', '', 'low'),
(43, NULL, 'username 43', 'username43@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 08:59:09', '0000-00-00 00:00:00', '', 'high'),
(44, NULL, 'username 44', 'username44@email.com', 123456, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:02:21', '0000-00-00 00:00:00', '', 'high'),
(45, NULL, 'username 45', 'username45@email.com', 123456, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:05:25', '0000-00-00 00:00:00', '', 'high'),
(46, NULL, 'username 46', 'username46@email.com', 123456, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:08:57', '0000-00-00 00:00:00', '', 'high'),
(47, NULL, 'username47', 'username47@email.com', 1234, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:09:36', '0000-00-00 00:00:00', '', 'high'),
(48, NULL, 'username48', 'username48@email.com', 1234, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:10:07', '0000-00-00 00:00:00', '', 'high'),
(49, NULL, 'username48', 'username49@email.com', 1234, '14e1b600b1fd579f47433b88e8d85291', '2014-09-04 09:10:40', '0000-00-00 00:00:00', '', 'high'),
(50, NULL, 'username 49', 'username50@email.com', 234, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:12:10', '0000-00-00 00:00:00', '', 'high'),
(51, NULL, 'username51', 'username51@email.com', 123456, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:14:12', '0000-00-00 00:00:00', '', 'high'),
(52, NULL, 'alex', 'alex@ttt.com', 1, '698d51a19d8a121ce581499d7b701668', '2014-09-04 15:17:42', '0000-00-00 00:00:00', '', 'high'),
(53, NULL, 'test', 'and.joszko@gmail.com', 1, '098f6bcd4621d373cade4e832627b4f6', '2014-09-05 08:02:35', '0000-00-00 00:00:00', '', 'high'),
(54, NULL, 'ro', 'ro@ro.ro', 2, '3605c251087b88216c9bca890e07ad9c', '2014-12-27 10:22:09', '0000-00-00 00:00:00', 'normal', 'low'),
(55, NULL, 'Valentin', 'rlng-krsk@yandex.ru', 111111, '96e79218965eb72c92a549dd5a330112', '2014-12-27 10:28:20', '0000-00-00 00:00:00', 'normal', 'low');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_client_user_id` FOREIGN KEY (`client_user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Ograniczenia dla tabeli `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_item_category_id` FOREIGN KEY (`item_category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_item_client_id` FOREIGN KEY (`item_client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `item_additional`
--
ALTER TABLE `item_additional`
  ADD CONSTRAINT `item_additional_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_category_id` FOREIGN KEY (`user_category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

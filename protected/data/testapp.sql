-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 10, 2014 at 11:04 AM
-- Server version: 5.1.73
-- PHP Version: 5.3.3-7+squeeze19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `testapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryTitle` varchar(255) NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`CategoryID`, `CategoryTitle`) VALUES
(1, 'Category 1'),
(2, 'Category 2'),
(3, 'Category 3'),
(4, 'Category 4'),
(5, 'Category 5');

-- --------------------------------------------------------

--
-- Table structure for table `Items`
--

CREATE TABLE IF NOT EXISTS `Items` (
  `ItemID` int(11) NOT NULL AUTO_INCREMENT,
  `SubcategoryID` int(11) NOT NULL,
  `ItemName` varchar(255) NOT NULL,
  `CreateTime` datetime NOT NULL,
  `SubmitTime` datetime NOT NULL,
  `ItemAmount` int(11) NOT NULL,
  `ItemAmountLeft` int(11) NOT NULL,
  `ItemTotal` int(11) NOT NULL,
  `ItemType` varchar(255) NOT NULL,
  PRIMARY KEY (`ItemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `Items`
--

INSERT INTO `Items` (`ItemID`, `SubcategoryID`, `ItemName`, `CreateTime`, `SubmitTime`, `ItemAmount`, `ItemAmountLeft`, `ItemTotal`, `ItemType`) VALUES
(6, 6, 'item 6', '2014-08-23 14:08:12', '2014-08-15 00:00:00', 578, 2, 580, 'normal'),
(7, 7, 'item 7', '2014-08-23 14:08:41', '2014-08-22 00:00:00', 456, 2, 458, 'normal'),
(8, 8, 'item 8', '2014-08-23 14:09:06', '2014-08-21 00:00:00', 300, 34, 334, 'normal'),
(29, 7, 'item 612354', '2014-08-26 14:08:44', '2014-08-26 00:00:00', 123, 5, 128, 'normal'),
(30, 6, 'test 6', '2014-08-26 14:09:40', '2014-08-26 00:00:00', 345, 1, 346, 'normal'),
(32, 8, 'test', '2014-08-26 14:14:00', '2014-08-26 00:00:00', 123, 1, 124, 'n'),
(33, 6, 'test categ', '2014-08-26 14:22:50', '2014-08-26 00:00:00', 1234, 23, 1257, 'n'),
(35, 8, 'test subcat active', '2014-08-26 14:28:11', '2014-08-26 00:00:00', 2345, 3, 2348, 'b'),
(37, 5, 'new test', '2014-08-26 14:33:58', '2014-08-26 00:00:00', 1234, 345, 1579, 'fgh'),
(39, 8, 'test003', '2014-08-26 14:37:41', '2014-08-31 00:00:00', 22, 22, 44, '22'),
(40, 6, 'test004', '2014-08-26 14:38:06', '2014-08-31 00:00:00', 44, 44, 88, '44'),
(44, 6, 'item 004', '2014-08-27 08:18:55', '2014-08-27 00:00:00', 234, 45, 279, 'n'),
(45, 8, 'item', '2014-08-27 08:19:43', '2014-08-20 00:00:00', 234, 56, 290, 'n'),
(46, 6, '1234', '2014-08-27 08:21:58', '2014-08-20 00:00:00', 2346, 6, 2352, 'b'),
(50, 7, 'new test item 30', '2014-08-27 08:58:35', '2014-08-27 00:00:00', 3456, 345, 3801, 'n'),
(51, 8, 'new test item 31', '2014-08-27 09:00:12', '2014-08-14 00:00:00', 245, 3, 248, 'n'),
(56, 5, 'ertert', '2014-08-27 09:27:22', '2014-08-13 00:00:00', 234234, 3, 234237, 'fgh'),
(69, 6, 'item test', '2014-08-29 09:56:37', '2014-08-29 00:00:00', 1234, 1, 1235, 'n'),
(75, 6, 'item today', '2014-09-04 12:09:36', '2014-09-04 00:00:00', 234, 2, 236, '234'),
(83, 1, 'ALEX', '2014-09-08 20:02:43', '2014-09-24 00:00:00', 400, 500, 900, 'normal'),
(84, 5, 'ALEX 2', '2014-09-08 20:03:48', '2014-09-30 00:00:00', 5555, 6666, 12221, 'normal'),
(85, 4, 'ffgfgs', '2014-09-09 08:40:52', '2014-09-10 00:00:00', 35, 345, 380, 'rft'),
(86, 2, 'FV22', '2014-09-10 10:47:03', '2014-09-10 00:00:00', 22, 22, 44, '22'),
(87, 1, 'FVV22', '2014-09-10 10:51:42', '2014-09-12 00:00:00', 22, 22, 44, '22'),
(88, 5, 'PF1', '2014-09-10 10:54:26', '2014-09-10 00:00:00', 33, 33, 66, '33');

-- --------------------------------------------------------

--
-- Table structure for table `Subcategories`
--

CREATE TABLE IF NOT EXISTS `Subcategories` (
  `SubcategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryID` int(11) NOT NULL,
  `SubcategoryTitle` varchar(255) NOT NULL,
  PRIMARY KEY (`SubcategoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `Subcategories`
--

INSERT INTO `Subcategories` (`SubcategoryID`, `CategoryID`, `SubcategoryTitle`) VALUES
(1, 1, 'Subcategory 1.1'),
(2, 1, 'Subcategory 1.2'),
(3, 1, 'Subcategory 1.3'),
(4, 2, 'Subcategory 2.1'),
(5, 2, 'Subcategory 2.2'),
(6, 3, 'Subcategory 3.1'),
(7, 4, 'Subcategory 4.1'),
(8, 5, 'Subcategory 5.1');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `SubcategoryID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `UserFavNumber` int(11) NOT NULL,
  `UserPassword` text NOT NULL,
  `CreateTime` datetime NOT NULL,
  `SubmitTime` datetime NOT NULL,
  `UserType` varchar(20) NOT NULL,
  `UserPriority` varchar(10) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `SubcategoryID`, `UserName`, `UserEmail`, `UserFavNumber`, `UserPassword`, `CreateTime`, `SubmitTime`, `UserType`, `UserPriority`) VALUES
(1, 1, 'username 1', 'username1@email.com', 123456789, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:34:05', '2014-08-29 13:41:20', 'normal', 'low'),
(2, 2, 'username 2', 'username2@email.com', 3234, 'd41d8cd98f00b204e9800998ecf8427e', '2014-08-22 13:34:34', '0000-00-00 00:00:00', 'normal', 'high'),
(3, 3, 'username 3', 'username3@email.com', 3, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:34:56', '0000-00-00 00:00:00', 'normal', 'high'),
(4, 4, 'username4', 'username4@email.com', 4, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:35:15', '0000-00-00 00:00:00', 'normal', 'high'),
(5, 5, 'username 5', 'username5@email.com', 5, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:35:37', '0000-00-00 00:00:00', 'normal', 'high'),
(6, 6, 'username 6', 'username6@email.com', 6, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:36:03', '0000-00-00 00:00:00', 'normal', 'high'),
(7, 7, 'username 7', 'username7@email.com', 7, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:36:23', '0000-00-00 00:00:00', 'normal', 'high'),
(8, 0, 'username 8', 'username8@email.com', 8, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 13:36:49', '0000-00-00 00:00:00', 'normal', 'high'),
(9, 0, 'tele', 'tele.bv@gmail.com', 127, '14e1b600b1fd579f47433b88e8d85291', '2014-08-22 13:37:56', '2014-08-22 15:15:20', 'normal', 'high'),
(10, 0, 'username 9', 'username9@email.com', 9, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 15:42:21', '0000-00-00 00:00:00', 'normal', 'high'),
(11, 0, 'alex', 'negoita.alexandru@gmail.com', 66, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-22 15:46:30', '0000-00-00 00:00:00', 'normal', 'low'),
(12, 0, 'nego', 'alex@mail.com', 127, 'b0baee9d279d34fa1dfd71aadb908c3f', '2014-08-22 15:49:27', '0000-00-00 00:00:00', 'normal', 'high'),
(13, 0, 'aaa', 'aa@ffd.cvio', 127, '674f3c2c1a8a6f90461e8a66fb5550ba', '2014-08-22 15:51:25', '0000-00-00 00:00:00', 'normal', 'high'),
(14, 0, 'Test', 't0119121191219121191@gmail.com', 127, 'ad0234829205b9033196ba818f7a872b', '2014-08-22 20:45:13', '2014-08-22 21:10:11', 'normal', 'high'),
(15, 0, 'username10', 'username10@email.com', 127, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:07:45', '0000-00-00 00:00:00', 'normal', 'high'),
(16, 0, 'username11', 'username11@email.com', 127, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:11:30', '0000-00-00 00:00:00', 'normal', 'high'),
(17, 0, 'username12', 'username12@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:12:57', '0000-00-00 00:00:00', 'normal', 'high'),
(18, 0, 'username13', 'username13@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:14:54', '0000-00-00 00:00:00', 'normal', 'high'),
(19, 0, 'username14', 'username14@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:15:46', '0000-00-00 00:00:00', 'normal', 'high'),
(20, 0, 'username15', 'username15@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:17:14', '0000-00-00 00:00:00', 'normal', 'high'),
(21, 0, 'username16', 'username16@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:17:46', '0000-00-00 00:00:00', 'normal', 'high'),
(22, 0, 'username17', 'username17@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:18:16', '0000-00-00 00:00:00', 'normal', 'high'),
(23, 0, 'username18', 'username18@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-23 11:19:01', '2014-08-23 11:19:01', 'normal', 'high'),
(24, 0, 'username19', 'username19@email.com', 1234567890, 'd41d8cd98f00b204e9800998ecf8427e', '2014-08-23 11:20:17', '2014-08-23 11:20:17', 'normal', 'high'),
(25, 0, 'Alex', 'test@nego.com', 1, 'e10adc3949ba59abbe56e057f20f883e', '2014-08-24 10:16:50', '2014-08-29 10:09:18', 'normal', 'low'),
(26, 0, 'me', 'me@nego.com', 3, 'c33367701511b4f6020ec61ded352059', '2014-08-24 10:26:32', '2014-08-24 10:28:09', 'normal', 'high'),
(27, 0, 'test', 'wt@a.pl', 222, '098f6bcd4621d373cade4e832627b4f6', '2014-08-24 12:49:24', '2014-08-24 12:49:25', 'normal', 'high'),
(28, 0, 'test', 'test@test.test', 2, '098f6bcd4621d373cade4e832627b4f6', '2014-08-24 14:30:01', '2014-08-29 13:27:12', 'normal', 'high'),
(29, 0, 'dfg', 'rfgd@sdf.copm', 345, '234324', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(30, 0, 'teletinus', 'teletinus@teletinus.com', 123254576, '12345678', '2014-09-02 12:22:35', '0000-00-00 00:00:00', '', 'high'),
(31, 0, '123 la perete stai', 'teletan@email.com', 12342345, 'fcea920f7412b5da7be0cf42b8c93759', '2014-09-02 12:32:31', '0000-00-00 00:00:00', '', 'high'),
(32, 0, '123 la perete stai', 'teletan1@email.com', 12342345, '224cf2b695a5e8ecaecfb9015161fa4b', '2014-09-02 12:33:55', '0000-00-00 00:00:00', '', 'high'),
(33, 0, '123 la perete stai', 'teletan12@email.com', 12342345, '8459d70c344917c311aeac9216969e3b', '2014-09-02 12:35:24', '0000-00-00 00:00:00', '', 'high'),
(34, 0, 'teletan123', 'teletan123@asdas.com', 2345, 'fcea920f7412b5da7be0cf42b8c93759', '2014-09-02 12:37:20', '0000-00-00 00:00:00', '', 'high'),
(35, 0, 'teletan123', 'teletan1233@asdas.com', 2345, 'fcea920f7412b5da7be0cf42b8c93759', '2014-09-02 12:37:37', '0000-00-00 00:00:00', '', 'high'),
(36, 0, 'teletan123', 'teletan12334@asdas.com', 2345, 'fcea920f7412b5da7be0cf42b8c93759', '2014-09-02 12:37:53', '0000-00-00 00:00:00', '', 'high'),
(37, 0, 'excalibur', 'excalibur@email.com', 234234, '827ccb0eea8a706c4c34a16891f84e7b', '2014-09-02 13:05:02', '0000-00-00 00:00:00', '', 'high'),
(38, 0, 'nicolae', 'nicolaenichifor@gmail.com', 15, '8287458823facb8ff918dbfabcd22ccb', '2014-09-03 13:14:17', '0000-00-00 00:00:00', '', 'low'),
(39, 0, 'Alex', 'nego@alex.com', 4, '698d51a19d8a121ce581499d7b701668', '2014-09-03 13:29:13', '0000-00-00 00:00:00', '', 'low'),
(40, 0, 'alex', 'w@w.com', 4, '6512bd43d9caa6e02c990b0a82652dca', '2014-09-03 13:30:50', '0000-00-00 00:00:00', '', 'low'),
(41, 0, 'username41', 'username41@email.com', 1234567, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 08:53:35', '0000-00-00 00:00:00', '', 'high'),
(42, 0, 'username 42', 'username42@emaI.com', 1234, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 08:56:59', '0000-00-00 00:00:00', '', 'low'),
(43, 0, 'username 43', 'username43@email.com', 123, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 08:59:09', '0000-00-00 00:00:00', '', 'high'),
(44, 0, 'username 44', 'username44@email.com', 123456, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:02:21', '0000-00-00 00:00:00', '', 'high'),
(45, 0, 'username 45', 'username45@email.com', 123456, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:05:25', '0000-00-00 00:00:00', '', 'high'),
(46, 0, 'username 46', 'username46@email.com', 123456, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:08:57', '0000-00-00 00:00:00', '', 'high'),
(47, 0, 'username47', 'username47@email.com', 1234, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:09:36', '0000-00-00 00:00:00', '', 'high'),
(48, 0, 'username48', 'username48@email.com', 1234, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:10:07', '0000-00-00 00:00:00', '', 'high'),
(49, 0, 'username48', 'username49@email.com', 1234, '14e1b600b1fd579f47433b88e8d85291', '2014-09-04 09:10:40', '0000-00-00 00:00:00', '', 'high'),
(50, 0, 'username 49', 'username50@email.com', 234, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:12:10', '0000-00-00 00:00:00', '', 'high'),
(51, 0, 'username51', 'username51@email.com', 123456, 'e10adc3949ba59abbe56e057f20f883e', '2014-09-04 09:14:12', '0000-00-00 00:00:00', '', 'high'),
(52, 0, 'alex', 'alex@ttt.com', 1, '698d51a19d8a121ce581499d7b701668', '2014-09-04 15:17:42', '0000-00-00 00:00:00', '', 'high'),
(53, 0, 'test', 'and.joszko@gmail.com', 1, '098f6bcd4621d373cade4e832627b4f6', '2014-09-05 08:02:35', '0000-00-00 00:00:00', '', 'high');

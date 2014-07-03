-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 27, 2014 at 03:21 PM
-- Server version: 5.5.37
-- PHP Version: 5.3.10-1ubuntu3.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `ID` int(10) unsigned NOT NULL,
  `Name` varchar(40) NOT NULL,
  `PledgeAmount` decimal(10,2) NOT NULL,
  `PledgeDate` date NOT NULL,
  `PaymentPeriod` int(11) NOT NULL,
  `LastPaymentDate` date NOT NULL,
  `PaidAmount` decimal(10,2) NOT NULL,
  `RemainingAmount` decimal(10,2) NOT NULL,
  `RemindLetterSent` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `trans`
--

CREATE TABLE IF NOT EXISTS `trans` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) NOT NULL,
  `Amount` decimal(12,2) unsigned NOT NULL,
  `PaymentDate` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Triggers `trans`
--
DROP TRIGGER IF EXISTS `account_Update`;
DELIMITER //
CREATE TRIGGER `account_Update` AFTER INSERT ON `trans`
 FOR EACH ROW BEGIN
    UPDATE `test`.`accounts` AS `ST`
    SET `ST`.`PaidAmount` = `ST`.`PaidAmount` + NEW.`Amount`, `ST`.`lastPaymentDate` = NEW.`PaymentDate`, `ST`.`RemainingAmount` = `ST`.`RemainingAmount` - NEW.`Amount`
    WHERE `ST`.`Name` = NEW.`Name`;
END
//
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

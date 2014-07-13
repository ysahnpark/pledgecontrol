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


INSERT INTO `accounts` (`ID`, `Name`, `PledgeDate`, `PledgeAmount`, `Duration`, `PaymentPeriod`, `PeriodUnit`, `AmountPerPeriod`, `LastPaymentDate`, `PaidAmount`, `RemainingAmount`, `RemindLetterSent`) VALUES
(1,  'A', '2013-10-02', 50000.00, 36, 12, 'm', 16666.67 ,  '2014-06-24', 16700.00, 33200.00, NULL),
(2,  'B', '2013-10-02', 15000.00, 36,  1, 'm',   416.67 ,  '2014-03-23', 1251.00, 13749.00, NULL),
(3,  'C', '2013-10-02', 20000.00,156,  2, 'w',   256.41 ,  '2014-04-06', 1792.00, 18208.00, NULL),
(4,  'D', '2013-10-02', 15000.00, 36,  6, 'm',  2500.00 ,  '2013-11-24', 3000.00, 12000.00, NULL),
(5,  'E', '2013-10-02', 30000.00, 48, 12, 'm',  7500.00 ,  '2013-09-16', 5000.00, 25000.00, NULL),
(6,  'F', '2014-04-06', 15000.00, 24, 12, 'm',  7500.00 ,  '2013-12-30', 10000.00, 5000.00, NULL),
(7,  'G', '2013-10-02', 35000.00, 36,  6, 'm',  5833.33 ,  '2013-10-15', 10000.00, 25000.00, NULL),
(8,  'H', '2013-10-02', 60000.00, 36, 12, 'm', 20000.00 ,  '2014-01-05', 40000.00, 20000.00, NULL),
(9,  'I', '2013-10-02', 10000.00, 36, 12, 'm',  3333.33 ,  '2013-10-05', 3333.00, 6667.00, NULL),
(10, 'J', '2013-10-21', 30000.00, 36, 12, 'm', 10000.00 ,  '2014-02-02', 10000.00, 20000.00, NULL),
(11, 'K', '2014-04-06',  6000.00, 60, 12, 'm',  1200.00 ,  '2014-03-30', 1200.00, 4800.00, NULL),
(12, 'L', '2013-10-21', 30000.00, 36,  2, 'w',  1666.67 ,  '2014-04-18', 3850.00, 26150.00, NULL),
(13, 'M', '2013-11-07', 18000.00, 36,  6, 'm',  3000.00 ,  '2013-11-03', 3000.00, 15000.00, NULL),
(14, 'N', '2013-11-07', 30000.00, 40,  1, 'm',  3000.00 ,  '2014-04-13', 2100.00, 27900.00, NULL),
(15, 'O', '2013-11-20', 10000.00, 36,  4, 'm',  1111.11 ,  '2014-04-06', 3000.00, 7000.00, NULL),
(16, 'P', '2013-11-20', 10000.00, 36,  1, 'm',   277.78 ,  '2013-11-20', 0.00, 10000.00, NULL),
(17, 'Q', '2013-11-20', 10000.00, 60, 12, 'm',  2000.00 ,  '2014-03-16', 2000.00, 8000.00, NULL),
(18, 'R', '2013-11-20',  3000.00, 36,  6, 'm',   500.00 ,  '2013-11-20', 0.00, 3000.00, NULL),
(19, 'S', '2013-11-20',  5000.00, 36,  2, 'm',   277.78 ,  '2013-11-20', 0.00, 5000.00, NULL),
(20, 'T', '2013-11-20', 10000.00, 36, 12, 'm',  3333.33 ,  '2013-12-29', 3500.00, 6500.00, NULL);

--
-- Dumping data for table `trans`
--

INSERT INTO `trans` (`AccountID`, `Name`, `Amount`, `PaymentDate`) VALUES
( (SELECT ID FROM accounts WHERE Name='A'), 'A', 16800.00, '2013-11-02'),
( (SELECT ID FROM accounts WHERE Name='B'), 'B',  416.67, '2013-11-02'),
( (SELECT ID FROM accounts WHERE Name='B'), 'B',  416.67, '2013-12-02'),
( (SELECT ID FROM accounts WHERE Name='B'), 'B',  416.67, '2014-1-12'), //
( (SELECT ID FROM accounts WHERE Name='C'), 'C',  256.41 , '2013-11-02'),
( (SELECT ID FROM accounts WHERE Name='C'), 'C',  256.41 , '2013-12-12'),
( (SELECT ID FROM accounts WHERE Name='C'), 'C',  256.41 , '2014-1-12'),
( (SELECT ID FROM accounts WHERE Name='C'), 'C',  256.41 , '2014-2-2'),
( (SELECT ID FROM accounts WHERE Name='C'), 'C',  256.41 , '2014-3-4'),
( (SELECT ID FROM accounts WHERE Name='C'), 'C',  256.41 , '2014-4-6'),
( (SELECT ID FROM accounts WHERE Name='C'), 'C',  256.41 , '2014-5-4'),
( (SELECT ID FROM accounts WHERE Name='D'), 'D',  3000.00 , '2013-11-05'),
( (SELECT ID FROM accounts WHERE Name='E'), 'E',  5000.00 , '2013-11-08'),
( (SELECT ID FROM accounts WHERE Name='F'), 'F',  10000.00 , '2014-04-10'),
( (SELECT ID FROM accounts WHERE Name='G'), 'G',  10000.00 , '2013-12-12'),
( (SELECT ID FROM accounts WHERE Name='H'), 'H',  20000.00 , '2013-12-24'),
( (SELECT ID FROM accounts WHERE Name='H'), 'H',  20000.00 , '2013-12-24'),
( (SELECT ID FROM accounts WHERE Name='I'), 'I',  3333.00 , '2013-12-24'),
( (SELECT ID FROM accounts WHERE Name='J'), 'J',  10000.00 , '2013-12-24'),
( (SELECT ID FROM accounts WHERE Name='K'), 'K',  1200.00 , '2014-04-16'),
( (SELECT ID FROM accounts WHERE Name='L'), 'L',   384.62  , '2013-10-21'),
( (SELECT ID FROM accounts WHERE Name='L'), 'L',   384.62  , '2013-11-21'),
( (SELECT ID FROM accounts WHERE Name='L'), 'L',   384.62  , '2013-12-21'),
( (SELECT ID FROM accounts WHERE Name='L'), 'L',   384.62  , '2014-01-01'),
( (SELECT ID FROM accounts WHERE Name='L'), 'L',   384.62  , '2014-02-01'),
( (SELECT ID FROM accounts WHERE Name='L'), 'L',   384.62  , '2014-03-01'),
( (SELECT ID FROM accounts WHERE Name='L'), 'L',   384.62  , '2014-04-01'),
( (SELECT ID FROM accounts WHERE Name='L'), 'L',   384.62  , '2014-05-01'),
( (SELECT ID FROM accounts WHERE Name='L'), 'L',   384.62  , '2014-05-10'),
( (SELECT ID FROM accounts WHERE Name='L'), 'L',   384.62  , '2014-07-01'),
( (SELECT ID FROM accounts WHERE Name='A'), 'M',  3000.00 , '2013-11-17'),
( (SELECT ID FROM accounts WHERE Name='M'), 'N', 300.00, '2013-11-07'),
( (SELECT ID FROM accounts WHERE Name='N'), 'N', 300.00, '2013-12-07'),
( (SELECT ID FROM accounts WHERE Name='N'), 'N', 300.00, '2014-01-01'),
( (SELECT ID FROM accounts WHERE Name='N'), 'N', 300.00, '2014-02-02'),
( (SELECT ID FROM accounts WHERE Name='N'), 'N', 300.00, '2014-03-03'),
( (SELECT ID FROM accounts WHERE Name='N'), 'N', 300.00, '2014-04-03'),
( (SELECT ID FROM accounts WHERE Name='N'), 'N', 300.00, '2014-05-02'),
( (SELECT ID FROM accounts WHERE Name='O'), 'O', 3000, '2013-11-25'),
( (SELECT ID FROM accounts WHERE Name='Q'), 'Q',  2000.00, '2013-11-22'),
( (SELECT ID FROM accounts WHERE Name='T'), 'T',  3500.00 , '2013-11-22');

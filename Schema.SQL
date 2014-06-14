-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 14, 2014 at 10:48 AM
-- Server version: 1.0.11
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `foodblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `Authors`
--

CREATE TABLE IF NOT EXISTS `Authors` (
  `AID` int(11) NOT NULL AUTO_INCREMENT,
  `AthFirstName` varchar(30) NOT NULL,
  `MiddleName` varchar(30) NOT NULL,
  `AthLastName` varchar(30) NOT NULL,
  `AthEmail` varchar(60) NOT NULL,
  `AthPass` varchar(15) NOT NULL DEFAULT 'NewPass',
  `AthDesc` mediumtext NOT NULL,
  `AthActive` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`AID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
  `CATID` int(11) NOT NULL AUTO_INCREMENT,
  `CatTitle` varchar(60) NOT NULL,
  `CatActive` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`CATID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `CID` int(11) NOT NULL AUTO_INCREMENT,
  `PostID` int(11) NOT NULL,
  `CommentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ComName` varchar(60) NOT NULL,
  `ComEmail` varchar(80) NOT NULL,
  `ComWebsite` varchar(100) NOT NULL,
  `ComBody` text NOT NULL,
  `EmailNotify` varchar(1) NOT NULL DEFAULT 'N',
  `IPAddress` varchar(45) NOT NULL,
  `Hidden` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`CID`),
  KEY `PostID` (`PostID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Credits`
--

CREATE TABLE IF NOT EXISTS `Credits` (
  `CID` int(11) NOT NULL,
  `CreditType` varchar(100) NOT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Groups`
--

CREATE TABLE IF NOT EXISTS `Groups` (
  `GID` int(11) NOT NULL AUTO_INCREMENT,
  `GrpTitle` varchar(60) NOT NULL DEFAULT 'Title Here...',
  `GrpActive` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`GID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Metatags`
--

CREATE TABLE IF NOT EXISTS `Metatags` (
  `MID` int(11) NOT NULL AUTO_INCREMENT,
  `TagName` varchar(60) NOT NULL,
  PRIMARY KEY (`MID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Only used for building posts.';

-- --------------------------------------------------------

--
-- Table structure for table `Post`
--

CREATE TABLE IF NOT EXISTS `Post` (
  `PID` int(11) NOT NULL AUTO_INCREMENT,
  `PstTitle` varchar(120) NOT NULL DEFAULT 'Title Here...',
  `PstBody` mediumtext NOT NULL,
  `PstActive` varchar(1) NOT NULL DEFAULT 'Y',
  `AuthorID` int(11) NOT NULL DEFAULT '0',
  `PstDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PstHomePage` varchar(1) NOT NULL DEFAULT 'N',
  `PstDescription` varchar(140) NOT NULL DEFAULT 'Description Here',
  `PstURL` varchar(100) NOT NULL,
  `CreditID` int(11) NOT NULL DEFAULT '0',
  `CreditName` text NOT NULL,
  `CreditURL` varchar(140) NOT NULL,
  `CreditID2` int(11) NOT NULL DEFAULT '0',
  `CreditName2` text NOT NULL,
  `CreditURL2` varchar(140) NOT NULL,
  `Metatags` text NOT NULL,
  `PostCat` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`PID`),
  KEY `PstRecipe` (`AuthorID`),
  KEY `PstDate` (`PstDate`),
  KEY `PostCat` (`PostCat`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Blog Posts';

-- --------------------------------------------------------

--
-- Table structure for table `PostGroups`
--

CREATE TABLE IF NOT EXISTS `PostGroups` (
  `PGID` int(11) NOT NULL AUTO_INCREMENT,
  `PostID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  PRIMARY KEY (`PGID`),
  KEY `PostID` (`PostID`,`GroupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Recipe`
--

CREATE TABLE IF NOT EXISTS `Recipe` (
  `RID` int(11) NOT NULL AUTO_INCREMENT,
  `PostID` int(11) NOT NULL DEFAULT '0',
  `RcpTitle` varchar(120) NOT NULL,
  `RcpOrder` int(11) NOT NULL DEFAULT '1',
  `Difficulty` varchar(1) NOT NULL DEFAULT 'E',
  `PrepTime` varchar(6) NOT NULL DEFAULT '1:00',
  `CookTime` varchar(6) NOT NULL DEFAULT '1:00',
  `Servings` int(11) NOT NULL DEFAULT '1',
  `PrepInstructions` mediumtext NOT NULL,
  `RcpActive` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`RID`),
  KEY `PostID` (`PostID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Recipe ID / Name';

-- --------------------------------------------------------

--
-- Table structure for table `RecipeItems`
--

CREATE TABLE IF NOT EXISTS `RecipeItems` (
  `RIID` int(11) NOT NULL AUTO_INCREMENT,
  `RecipeID` int(11) NOT NULL,
  `TextLine` varchar(100) NOT NULL DEFAULT '',
  `ItmActive` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`RIID`),
  KEY `RecipeID` (`RecipeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Units`
--

CREATE TABLE IF NOT EXISTS `Units` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `UntName` varchar(60) NOT NULL,
  `UntShortForm` varchar(10) NOT NULL,
  `UntActive` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Store Different Unit Types';

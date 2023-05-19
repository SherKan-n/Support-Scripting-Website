-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/

-- --------------------------------------------------------

DROP TABLE IF EXISTS `bans`;
CREATE TABLE `bans` (
  `banID` int(11) NOT NULL AUTO_INCREMENT,
  `banName` varchar(32) NOT NULL,
  `banAdmin` varchar(32) NOT NULL,
  `banReason` varchar(128) NOT NULL,
  `banDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `banTime` date NOT NULL,
  PRIMARY KEY (`banID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `updates`;
CREATE TABLE `updates` (
  `updateID` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(16) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`updateID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
  `friendID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `friendName` varchar(32) NOT NULL,
  PRIMARY KEY (`friendID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `notifyID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL,
  `text` varchar(128) NOT NULL,
  `name` varchar(32) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`notifyID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `reputations`;
CREATE TABLE `reputations` (
  `reputationID` int(11) NOT NULL AUTO_INCREMENT,
  `takerName` varchar(32) NOT NULL,
  `giverName` varchar(32) NOT NULL,
  PRIMARY KEY (`reputationID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `market`;
CREATE TABLE `market` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `owner` varchar(64) NOT NULL,
  `description` varchar(256) NOT NULL,
  `price` int(5) NOT NULL,
  `password` varchar(64) NOT NULL,
  `purchases` int(5) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rentTime` date NOT NULL,
  `videoLink` varchar(128) NOT NULL DEFAULT '-',
  `images` varchar(256) NOT NULL DEFAULT '-|-|-|-|-|-',
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `chat_log`;
CREATE TABLE `chat_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `google_login` int(2) NOT NULL DEFAULT '0',
  `hours` float NOT NULL DEFAULT '0.00',
  `level` int(5) NOT NULL DEFAULT '1',
  `reputation` int(5) NOT NULL DEFAULT '0',
  `email` varchar(128) DEFAULT 'example@email.com',
  `age` int(2) NOT NULL DEFAULT '0',
  `location` varchar(32) DEFAULT 'Unknown',
  `gender` int(2) NOT NULL DEFAULT '0',
  `admin` int(2) NOT NULL DEFAULT '0',
  `helper` int(2) NOT NULL DEFAULT '0',
  `gems` int(5) NOT NULL DEFAULT '0',
  `premium` int(2) NOT NULL DEFAULT '0',
  `logged` int(2) NOT NULL DEFAULT '0',
  `lastOnline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatarName` varchar(128) NOT NULL DEFAULT 'avatar0.png',
  `donations` int(3) NOT NULL DEFAULT '0',
  `notify` int(2) NOT NULL DEFAULT '0',
  `theme` int(2) NOT NULL DEFAULT '0',
  `tickets` int(2) NOT NULL DEFAULT '0',
  `skills` varchar(32) NOT NULL DEFAULT '0|0|0|0|0|0|0|0|0|0|0|0',
  `registerDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `warnings` int(2) NOT NULL DEFAULT '0',
  `freeSpins` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

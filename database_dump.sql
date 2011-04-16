-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2011 at 05:01 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `ci_boilerplate`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_bp_meta`
--

CREATE TABLE IF NOT EXISTS `ci_bp_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` text COLLATE utf8_bin NOT NULL,
  `value` longtext COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ci_bp_meta`
--

INSERT INTO `ci_bp_meta` (`id`, `key`, `value`) VALUES
(1, 'boilerplate_version', '1.0'),
(2, 'jquery_version', '1.5.2'),
(3, 'jquerry_ui_version', '1.8.11'),
(4, 'modernizr_version', '1.7'),
(5, 'ci_rdnzl_boilerplate_version', '0.1');

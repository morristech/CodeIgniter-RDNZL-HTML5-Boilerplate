-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2011 at 09:16 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `ci_boilerplate`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` longtext NOT NULL,
  `datetime_created` datetime NOT NULL,
  `datetime_published` datetime NOT NULL,
  `author` int(11) NOT NULL,
  `last_edited_by` int(11) NOT NULL,
  `datetime_last_edited` datetime NOT NULL,
  `status` enum('draft','published','deleted') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `content`, `excerpt`, `datetime_created`, `datetime_published`, `author`, `last_edited_by`, `datetime_last_edited`, `status`) VALUES
(1, 'My First Post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget est mi, et porttitor dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque commodo semper luctus. Integer tristique enim ut arcu consectetur imperdiet. Sed imperdiet leo mollis felis mattis sed venenatis orci scelerisque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis dignissim mi metus, quis pharetra velit. Donec quam lectus, consequat quis consequat in, facilisis sed enim. In hac habitasse platea dictumst. Duis sem ipsum, pellentesque et eleifend scelerisque, tempor non dui. ', '', '2011-04-18 14:19:43', '2011-04-18 14:20:41', 4, 4, '2011-04-18 14:20:05', 'published'),
(2, 'My Second Post', 'Sed imperdiet leo mollis felis mattis sed venenatis orci scelerisque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis dignissim mi metus, quis pharetra velit. Donec quam lectus, consequat quis consequat in, facilisis sed enim. In hac habitasse platea dictumst. Duis sem ipsum, pellentesque et eleifend scelerisque, tempor non dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget est mi, et porttitor dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque commodo semper luctus. Integer tristique enim ut arcu consectetur imperdiet. ', 'An excerpt for: Sed imperdiet leo mollis felis mattis sed venenatis orci scelerisque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. ', '2011-04-18 14:21:02', '2011-04-18 14:20:58', 4, 4, '2011-04-18 14:20:54', 'published');

-- --------------------------------------------------------

--
-- Table structure for table `blog_meta`
--

DROP TABLE IF EXISTS `blog_meta`;
CREATE TABLE `blog_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL COMMENT 'Foreign Key: blog.id',
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `blog_meta`
--


-- --------------------------------------------------------

--
-- Table structure for table `ci_bp_meta`
--

DROP TABLE IF EXISTS `ci_bp_meta`;
CREATE TABLE `ci_bp_meta` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('fee40cd2d392226a1dd02e22eddc46ac', '192.168.0.40', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:2.0) Gecko/', 1303247756, 'a:3:{s:7:"user_id";s:1:"1";s:8:"username";s:12:"charliesheen";s:6:"status";s:1:"1";}');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `login_attempts`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`) VALUES
(1, 'charliesheen', '$P$BfG.hEofMgC1EtrEo.dAFJ9h3WQA3d0', 'test@test.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '192.168.0.40', '2011-04-19 21:16:29', '2011-04-19 21:16:19', '2011-04-19 15:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

DROP TABLE IF EXISTS `user_autologin`;
CREATE TABLE `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_autologin`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `country`, `website`) VALUES
(1, 1, NULL, NULL);

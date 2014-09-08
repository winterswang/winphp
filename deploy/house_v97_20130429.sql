-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 04 月 29 日 01:45
-- 服务器版本: 5.5.23
-- PHP 版本: 5.3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `house`
--

-- --------------------------------------------------------

--
-- 表的结构 `common_area`
--

CREATE TABLE IF NOT EXISTS `common_area` (
  `area_id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `sort_order` mediumint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- 表的结构 `common_bank`
--

CREATE TABLE IF NOT EXISTS `common_bank` (
  `bank_id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `slug` varchar(200) CHARACTER SET utf8 NOT NULL,
  `sort_order` mediumint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `common_bus`
--

CREATE TABLE IF NOT EXISTS `common_bus` (
  `bus_id` int(10) unsigned NOT NULL DEFAULT '0',
  `bus_name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8 NOT NULL,
  `street_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `common_hospital`
--

CREATE TABLE IF NOT EXISTS `common_hospital` (
  `hospital_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `hospital_name` varchar(100) NOT NULL,
  `sort_order` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`hospital_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `common_school`
--

CREATE TABLE IF NOT EXISTS `common_school` (
  `school_id` int(10) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `sort_order` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `common_shop`
--

CREATE TABLE IF NOT EXISTS `common_shop` (
  `shop_id` int(10) NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `sort_order` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `common_street`
--

CREATE TABLE IF NOT EXISTS `common_street` (
  `street_id` int(10) NOT NULL AUTO_INCREMENT,
  `street_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`street_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `common_subway`
--

CREATE TABLE IF NOT EXISTS `common_subway` (
  `subway_id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `subway_name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `sort_order` mediumint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`subway_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- 表的结构 `common_subway_station`
--

CREATE TABLE IF NOT EXISTS `common_subway_station` (
  `station_id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `station_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `subway_id` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `sort_order` mediumint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`station_id`),
  KEY `subway_id` (`subway_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=272 ;

-- --------------------------------------------------------

--
-- 表的结构 `district_around_bus`
--

CREATE TABLE IF NOT EXISTS `district_around_bus` (
  `bus_id` int(10) unsigned NOT NULL DEFAULT '0',
  `district_id` int(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `district_around_subway`
--

CREATE TABLE IF NOT EXISTS `district_around_subway` (
  `subway_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `subway_name` varchar(20) NOT NULL,
  `district_id` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`subway_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `district_detail`
--

CREATE TABLE IF NOT EXISTS `district_detail` (
  `district_guid` int(9) unsigned NOT NULL,
  `district_name` varchar(50) NOT NULL,
  `district_address` varchar(100) NOT NULL,
  `area_ratio` decimal(1,1) unsigned NOT NULL DEFAULT '0.0',
  `greening_rate` decimal(2,2) NOT NULL DEFAULT '0.00',
  `construction_area` int(5) unsigned NOT NULL DEFAULT '0',
  `homes_total` int(5) unsigned NOT NULL DEFAULT '0',
  `buildings_total` int(5) unsigned NOT NULL DEFAULT '0',
  `parking_num` int(3) unsigned NOT NULL DEFAULT '0',
  `build_age` int(2) unsigned NOT NULL DEFAULT '0',
  `developer` varchar(100) NOT NULL,
  `management_fee` decimal(3,2) unsigned NOT NULL DEFAULT '0.00',
  `management_company` varchar(100) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  UNIQUE KEY `district_guid` (`district_guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `district_info`
--

CREATE TABLE IF NOT EXISTS `district_info` (
  `district_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `district_guid` int(9) unsigned NOT NULL,
  `district_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `city_id` mediumint(2) unsigned NOT NULL DEFAULT '0',
  `area_id` mediumint(2) unsigned NOT NULL DEFAULT '0',
  `zone_id` mediumint(2) unsigned NOT NULL DEFAULT '0',
  `lat` int(10) unsigned NOT NULL DEFAULT '0',
  `lng` int(10) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`district_id`),
  UNIQUE KEY `district_guid` (`district_guid`),
  KEY `slug` (`slug`),
  KEY `area_id` (`area_id`),
  KEY `zone_id` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `district_photo`
--

CREATE TABLE IF NOT EXISTS `district_photo` (
  `photo_id` int(11) NOT NULL,
  `position` tinyint(1) NOT NULL DEFAULT '0',
  `district_id` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment` varchar(255) NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `house_info`
--

CREATE TABLE IF NOT EXISTS `house_info` (
  `house_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `house_guid` int(9) unsigned NOT NULL,
  `district_guid` int(10) unsigned NOT NULL DEFAULT '0',
  `room` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `wc` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `floor` int(2) NOT NULL DEFAULT '0',
  `square` int(3) NOT NULL DEFAULT '0',
  `rent_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rent_period` int(2) unsigned NOT NULL DEFAULT '0',
  `provides` varchar(30) CHARACTER SET utf8 NOT NULL,
  `subscribe_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `description` varchar(200) CHARACTER SET utf8 NOT NULL,
  `score` int(2) unsigned NOT NULL DEFAULT '0',
  `rent_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `subscribe_num` mediumint(2) unsigned NOT NULL DEFAULT '0',
  `collect_num` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `view_num` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`house_id`),
  UNIQUE KEY `house_guid` (`house_guid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `house_item`
--

CREATE TABLE IF NOT EXISTS `house_item` (
  `house_id` int(5) unsigned NOT NULL DEFAULT '0',
  `item_id` mediumint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `house_photo`
--

CREATE TABLE IF NOT EXISTS `house_photo` (
  `pid` int(5) NOT NULL AUTO_INCREMENT,
  `house_guid` int(5) unsigned NOT NULL DEFAULT '0',
  `position` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `description` varchar(200) CHARACTER SET utf8 NOT NULL,
  `attachment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort_order` int(5) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dataline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `house_user_favorite`
--

CREATE TABLE IF NOT EXISTS `house_user_favorite` (
  `fav_id` int(10) NOT NULL AUTO_INCREMENT,
  `house_guid` int(10) unsigned NOT NULL DEFAULT '0',
  `house_uid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fav_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `house_user_reserve`
--

CREATE TABLE IF NOT EXISTS `house_user_reserve` (
  `res_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `house_guid` int(9) unsigned NOT NULL,
  `house_uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `district_guid` int(10) unsigned NOT NULL DEFAULT '0',
  `room` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `wc` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `floor` int(2) NOT NULL DEFAULT '0',
  `square` int(3) NOT NULL DEFAULT '0',
  `rent_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rent_period` int(2) unsigned NOT NULL DEFAULT '0',
  `provides` varchar(30) CHARACTER SET utf8 NOT NULL,
  `subscribe_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `description` varchar(200) CHARACTER SET utf8 NOT NULL,
  `rent_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`res_id`),
  UNIQUE KEY `house_guid` (`house_guid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `system_app`
--

CREATE TABLE IF NOT EXISTS `system_app` (
  `client_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `client_secret` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `application_title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `application_desc` tinytext CHARACTER SET utf8 NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1002 ;

-- --------------------------------------------------------

--
-- 表的结构 `system_id_generator`
--

CREATE TABLE IF NOT EXISTS `system_id_generator` (
  `tablename` varchar(15) NOT NULL,
  `generator_id` decimal(9,0) DEFAULT '100000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_device`
--

CREATE TABLE IF NOT EXISTS `user_device` (
  `device_id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(5) unsigned NOT NULL DEFAULT '0',
  `uuid` varchar(100) CHARACTER SET utf8 NOT NULL,
  `os` varchar(30) CHARACTER SET utf8 NOT NULL,
  `platform` varchar(10) CHARACTER SET utf8 NOT NULL,
  `model` varchar(30) CHARACTER SET utf8 NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`device_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `realName` varchar(30) CHARACTER SET utf8 NOT NULL,
  `userName` varchar(30) CHARACTER SET utf8 NOT NULL,
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mobile` int(13) unsigned NOT NULL DEFAULT '0',
  `verify` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_preference`
--

CREATE TABLE IF NOT EXISTS `user_preference` (
  `pid` int(5) NOT NULL AUTO_INCREMENT,
  `uid` int(5) unsigned NOT NULL DEFAULT '0',
  `findway` char(10) CHARACTER SET utf8 NOT NULL,
  `min_rent_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `max_rent_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `room` int(2) unsigned NOT NULL DEFAULT '0',
  `subscribe_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `provides` varchar(30) CHARACTER SET utf8 NOT NULL,
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_session`
--

CREATE TABLE IF NOT EXISTS `user_session` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uuid` varchar(50) NOT NULL,
  `uid` int(10) DEFAULT '0',
  `device_id` int(10) unsigned NOT NULL DEFAULT '0',
  `expires_in` int(5) unsigned NOT NULL DEFAULT '0',
  `expires_at` int(5) unsigned NOT NULL DEFAULT '0',
  `first_requested` int(10) unsigned NOT NULL DEFAULT '0',
  `last_activity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`device_id`,`uid`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

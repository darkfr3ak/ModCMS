SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `acl_permissions`;
CREATE TABLE IF NOT EXISTS `acl_permissions` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `permKey` varchar(30) NOT NULL,
  `permName` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `permKey` (`permKey`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT INTO `acl_permissions` (`ID`, `permKey`, `permName`) VALUES
(1, 'access_site', 'Access Site'),
(2, 'access_admin', 'Access Admin System'),
(3, 'publish_articles', 'Publish Articles'),
(5, 'install_apps', 'Install Apps'),
(6, 'post_comments', 'Post Comments');

DROP TABLE IF EXISTS `acl_roles`;
CREATE TABLE IF NOT EXISTS `acl_roles` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `roleName` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `roleName` (`roleName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `acl_roles` (`ID`, `roleName`) VALUES
(1, 'Administrators'),
(2, 'Authors'),
(3, 'Members');

DROP TABLE IF EXISTS `acl_role_perms`;
CREATE TABLE IF NOT EXISTS `acl_role_perms` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `roleID` int(11) NOT NULL,
  `permID` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `addDate` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `roleID_2` (`roleID`,`permID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

INSERT INTO `acl_role_perms` (`ID`, `roleID`, `permID`, `value`, `addDate`) VALUES
(1, 1, 1, 1, '0000-00-00 00:00:00'),
(2, 1, 2, 1, '0000-00-00 00:00:00'),
(3, 1, 3, 1, '0000-00-00 00:00:00'),
(4, 1, 4, 1, '0000-00-00 00:00:00'),
(5, 1, 5, 1, '0000-00-00 00:00:00'),
(6, 1, 6, 1, '0000-00-00 00:00:00'),
(7, 1, 7, 1, '0000-00-00 00:00:00'),
(8, 1, 8, 1, '0000-00-00 00:00:00'),
(60, 0, 0, 0, '2014-03-13 22:55:17'),
(61, 2, 1, 1, '2014-03-13 23:08:46'),
(62, 2, 8, 1, '2014-03-13 23:08:47'),
(63, 2, 6, 1, '2014-03-13 23:08:47'),
(64, 2, 3, 1, '2014-03-13 23:08:47'),
(65, 3, 1, 1, '2014-03-13 23:08:57'),
(66, 3, 6, 1, '2014-03-13 23:08:58'),
(70, 3, 0, 0, '2014-03-13 23:10:00');

DROP TABLE IF EXISTS `acl_user_perms`;
CREATE TABLE IF NOT EXISTS `acl_user_perms` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `permID` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `addDate` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `userID` (`userID`,`permID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `acl_user_roles`;
CREATE TABLE IF NOT EXISTS `acl_user_roles` (
  `userID` int(11) NOT NULL,
  `roleID` int(11) NOT NULL,
  `addDate` datetime NOT NULL,
  UNIQUE KEY `userID` (`userID`,`roleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `acl_user_roles` (`userID`, `roleID`, `addDate`) VALUES
(1, 1, '2009-03-02 17:14:45'),
(2, 2, '2014-03-13 21:39:53');

DROP TABLE IF EXISTS `core_apps`;
CREATE TABLE IF NOT EXISTS `core_apps` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(250) NOT NULL,
  `app_level` int(11) NOT NULL,
  `app_author` varchar(250) NOT NULL,
  `app_icon` varchar(250) DEFAULT NULL,
  `app_link` varchar(500) NOT NULL,
  `app_linkText` varchar(500) DEFAULT NULL,
  `app_showInMenu` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`app_id`),
  UNIQUE KEY `app_name` (`app_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

INSERT INTO `core_apps` (`app_id`, `app_name`, `app_level`, `app_author`, `app_icon`, `app_link`, `app_linkText`, `app_showInMenu`) VALUES
(1, 'main', 0, 'darkfr3ak', 'home', './', 'Home', 1),
(2, 'admin', 5, 'darkfr3ak', 'cog', '?app=admin', 'Admin', 1),
(3, 'user', 1, 'darkfr3ak', 'user', '?app=user', 'Profile', 1);

DROP TABLE IF EXISTS `core_session`;
CREATE TABLE IF NOT EXISTS `core_session` (
  `session_id` varchar(255) NOT NULL,
  `session_started` datetime NOT NULL,
  `session_expires` int(10) unsigned NOT NULL DEFAULT '0',
  `session_user_id` bigint(20) DEFAULT NULL,
  `session_data` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Haelt alle Sessiondaten';


DROP TABLE IF EXISTS `core_settings`;
CREATE TABLE IF NOT EXISTS `core_settings` (
  `property` varchar(150) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY (`property`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `core_settings` (`property`, `value`) VALUES
('site_theme', 'default'),
('site_title', 'darkfr3ak.de');

DROP TABLE IF EXISTS `core_users`;
CREATE TABLE IF NOT EXISTS `core_users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email',
  `user_lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_banned` int(11) NOT NULL DEFAULT '0',
  `user_banReason` text COLLATE utf8_unicode_ci,
  `user_bannedUntil` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=3 ;

INSERT INTO `core_users` (`user_id`, `user_name`, `user_password_hash`, `user_email`, `user_lastLogin`, `user_banned`, `user_banReason`, `user_bannedUntil`) VALUES
(1, 'darkfr3ak', '$2y$10$28GBl.6ah7N1R3ySIKdOSuiNisSXH1vaCVWhGZD4pN/ZGmopC2HxO', 'info@darkfr3ak.de', '2014-03-13 18:42:11', 0, '', '2014-03-13 19:39:19'),
(2, 'NoobOne', '$2y$10$1FjbLVi0F7cxdhqBWUC6Ce/iRh29NjifkubJsmLmssdWh5C9NGCcG', 'darkfr3ak@freenet.de', '2014-03-13 18:42:11', 0, '', '2014-03-13 19:39:19');

DROP TABLE IF EXISTS `widgets_active`;
CREATE TABLE IF NOT EXISTS `widgets_active` (
  `active_id` int(11) NOT NULL AUTO_INCREMENT,
  `active_widget` varchar(150) NOT NULL,
  `active_position` varchar(100) NOT NULL,
  PRIMARY KEY (`active_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `widgets_all`;
CREATE TABLE IF NOT EXISTS `widgets_all` (
  `widget_id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_name` varchar(100) NOT NULL,
  PRIMARY KEY (`widget_id`),
  UNIQUE KEY `widget_name` (`widget_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `widgets_all` (`widget_id`, `widget_name`) VALUES
(1, 'hello'),
(2, 'serverStatus'),
(3, 'userInfo');

DROP TABLE IF EXISTS `widgets_positions`;
CREATE TABLE IF NOT EXISTS `widgets_positions` (
  `pos_id` int(11) NOT NULL AUTO_INCREMENT,
  `pos_name` varchar(100) NOT NULL,
  PRIMARY KEY (`pos_id`),
  UNIQUE KEY `pos_name` (`pos_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `widgets_positions` (`pos_id`, `pos_name`) VALUES
(2, 'adminDashboard'),
(1, 'sidebarRight');

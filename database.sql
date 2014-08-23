-- phpMyAdmin SQL Dump
-- version 4.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 23. Aug 2014 um 15:14
-- Server Version: 5.2.14-MariaDB-mariadb122~squeeze-log
-- PHP-Version: 5.3.28-1~dotdeb.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `darkfr3aksql1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_acl_permissions`
--

CREATE TABLE IF NOT EXISTS `mycms_acl_permissions` (
`ID` int(11) unsigned NOT NULL,
  `permKey` varchar(30) NOT NULL,
  `permName` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `mycms_acl_permissions`
--

INSERT INTO `mycms_acl_permissions` (`ID`, `permKey`, `permName`) VALUES
(1, 'access_site', 'Access Site'),
(2, 'access_admin', 'Access Admin System'),
(3, 'publish_articles', 'Publish Articles'),
(5, 'install_apps', 'Install Apps'),
(6, 'post_comments', 'Post Comments');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_acl_roles`
--

CREATE TABLE IF NOT EXISTS `mycms_acl_roles` (
`ID` int(11) unsigned NOT NULL,
  `roleName` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `mycms_acl_roles`
--

INSERT INTO `mycms_acl_roles` (`ID`, `roleName`) VALUES
(1, 'Administrators'),
(2, 'Authors'),
(3, 'Members');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_acl_role_perms`
--

CREATE TABLE IF NOT EXISTS `mycms_acl_role_perms` (
`ID` int(11) unsigned NOT NULL,
  `roleID` int(11) NOT NULL,
  `permID` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `addDate` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Daten für Tabelle `mycms_acl_role_perms`
--

INSERT INTO `mycms_acl_role_perms` (`ID`, `roleID`, `permID`, `value`, `addDate`) VALUES
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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_acl_user_perms`
--

CREATE TABLE IF NOT EXISTS `mycms_acl_user_perms` (
`ID` int(11) unsigned NOT NULL,
  `userID` int(11) NOT NULL,
  `permID` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `addDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_acl_user_roles`
--

CREATE TABLE IF NOT EXISTS `mycms_acl_user_roles` (
  `userID` int(11) NOT NULL,
  `roleID` int(11) NOT NULL,
  `addDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `mycms_acl_user_roles`
--

INSERT INTO `mycms_acl_user_roles` (`userID`, `roleID`, `addDate`) VALUES
(1, 1, '2009-03-02 17:14:45'),
(2, 1, '2014-03-13 21:39:53'),
(3, 3, '2014-03-19 00:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_core_apps`
--

CREATE TABLE IF NOT EXISTS `mycms_core_apps` (
`app_id` int(11) NOT NULL,
  `app_name` varchar(250) NOT NULL,
  `app_level` int(11) NOT NULL,
  `app_author` varchar(250) NOT NULL,
  `app_icon` varchar(250) DEFAULT NULL,
  `app_link` varchar(500) NOT NULL,
  `app_linkText` varchar(500) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Daten für Tabelle `mycms_core_apps`
--

INSERT INTO `mycms_core_apps` (`app_id`, `app_name`, `app_level`, `app_author`, `app_icon`, `app_link`, `app_linkText`) VALUES
(1, 'default', 0, 'darkfr3ak', 'home', './', 'Home'),
(2, 'admin', 5, 'darkfr3ak', 'cog', '?app=admin', 'Admin'),
(3, 'login', 0, 'darkfr3ak & Panique', 'log-in', '?app=login', 'Login'),
(4, 'register', 0, 'darkfr3ak & Panique', 'plus-sign', '?app=register', 'Register'),
(5, 'user', 1, 'darkfr3ak', 'user', '?app=user', 'Profile'),
(6, 'todolist', 1, 'Saad Nisar', 'tasks', '?app=todolist', 'ToDoList'),
(23, 'download', 0, 'darkfr3ak', 'download-alt', '?app=download', 'Downloads'),
(25, 'eventcalendar', 0, 'darkfr3ak', 'calendar', '?app=eventcalendar', 'Event-Kalender');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_core_session`
--

CREATE TABLE IF NOT EXISTS `mycms_core_session` (
  `session_id` varchar(255) NOT NULL,
  `session_started` datetime NOT NULL,
  `session_expires` int(10) unsigned NOT NULL DEFAULT '0',
  `session_user_id` bigint(20) DEFAULT NULL,
  `session_data` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Haelt alle Sessiondaten';

--
-- Daten für Tabelle `mycms_core_session`
--

INSERT INTO `mycms_core_session` (`session_id`, `session_started`, `session_expires`, `session_user_id`, `session_data`) VALUES
('07f0b70db0b61419c6df0e21e3ef75c3', '2014-03-19 18:36:26', 1395257341, NULL, 'user_name|s:9:"darkfr3ak";user_email|s:17:"info@darkfr3ak.de";user_id|s:1:"1";user_logged_in|i:1;token|s:20:"55CA0A4E8022B4B8B335";'),
('159ltu1v79nid1vb9sk7bfhr84', '2014-03-17 18:54:19', 1395102573, NULL, 'user_name|s:9:"darkfr3ak";user_email|s:17:"info@darkfr3ak.de";user_id|s:1:"1";user_logged_in|i:1;token|s:20:"8C10F3FD5060AD4AE2EE";'),
('21ce2566af2a68bc0010c7597b7dd780', '2014-03-18 20:21:55', 1395175920, NULL, ''),
('25ef3acab314d02c78d2e361610d0924', '2014-03-18 20:26:11', 1395174371, NULL, ''),
('2eeb75528bab29d981920f70e310d3f3', '2014-08-23 10:55:12', 1408788223, NULL, 'user_name|s:9:"darkfr3ak";user_email|s:17:"info@darkfr3ak.de";user_id|s:1:"1";user_logged_in|i:1;token|s:20:"5A801AF0CC14279F918B";'),
('56fd59283c057a65e59c3438085e0d7e', '2014-03-19 18:43:56', 1395254636, NULL, ''),
('5ce04089379d960974f515a54958c6d8', '2014-03-19 18:56:24', 1395255384, NULL, ''),
('5d430802e8e2bc5206600fa320306129', '2014-08-23 11:03:12', 1408788192, NULL, ''),
('5e6313eccf1b2db76fd8d41ceb50b63a', '2014-08-23 11:03:56', 1408788236, NULL, ''),
('6ce1529ce2b2f452aff27fa912efdb3b', '2014-03-19 18:56:51', 1395255411, NULL, ''),
('7392d83558e35b20cb6ff25c5ebb2f06', '2014-08-23 15:02:17', 1408802537, NULL, ''),
('7d63cb074e79f14c6a7ee73d7089e1a0', '2014-03-19 18:51:41', 1395255101, NULL, ''),
('8cdcf8119ad35fc3dca38291ddd62502', '2014-03-19 19:29:02', 1395257342, NULL, ''),
('8ldj4oc28tnqme493sti3cpfk7', '2014-03-18 18:00:45', 1395171206, NULL, 'user_name|s:9:"darkfr3ak";user_email|s:17:"info@darkfr3ak.de";user_id|s:1:"1";user_logged_in|i:1;token|s:20:"E7D5D8C3F6BE907A3385";'),
('946b87d00892408c5fcc101cca2cbdfc', '2014-03-19 18:43:21', 1395254601, NULL, ''),
('aab39c3fb8338f8a66fb5b5252357081', '2014-08-13 23:13:09', 1407968019, NULL, 'user_name|s:9:"darkfr3ak";user_email|s:17:"info@darkfr3ak.de";user_id|s:1:"1";user_logged_in|i:1;token|s:20:"C0DFF766FFBD1927C522";'),
('ade078a57c1f55aafa35db3a7471af62', '2014-03-24 03:57:27', 1395633463, NULL, 'user_name|s:9:"darkfr3ak";user_email|s:17:"info@darkfr3ak.de";user_id|s:1:"1";user_logged_in|i:1;token|s:20:"BC86B0B9642D44BCCD93";'),
('ae2b8601d945b1fd9c929d743ed684a6', '2014-03-18 20:25:17', 1395174317, NULL, ''),
('b94f9a2bf134e3b3e260dc76ca4e4e31', '2014-08-23 11:04:00', 1408788240, NULL, ''),
('b95c523897b43e188aa6baf7bf3cf659', '2014-03-18 20:24:59', 1395175843, NULL, ''),
('bf64fa676d822e771da97a73b9fd47a4', '2014-08-23 11:03:49', 1408788229, NULL, ''),
('c8aace47df75ffbdb1fa590a08c411f7', '2014-03-18 20:27:06', 1395174426, NULL, ''),
('c9v47crf0c16mrn9655et0luf6', '2014-03-15 23:52:37', 1394928518, NULL, 'user_name|s:9:"darkfr3ak";user_email|s:17:"info@darkfr3ak.de";user_id|s:1:"1";user_logged_in|i:1;token|s:20:"931B4CD0345722F218B3";'),
('d24b8078743cf15678f0488f13f17870', '2014-08-23 11:03:29', 1408788209, NULL, ''),
('dda15a3f2ad0889016ee76d575ad8017', '2014-03-18 20:27:23', 1395174443, NULL, ''),
('df15fa54f0b1a21e84bddc0eb3e73b49', '2014-03-19 18:51:25', 1395255085, NULL, ''),
('e08413f76255fc31c516f0adc3d33eab', '2014-03-19 18:39:29', 1395260165, NULL, ''),
('erjtamra8i88aa464nlop21po2', '2014-03-16 17:52:24', 1395013532, NULL, 'user_name|s:9:"darkfr3ak";user_email|s:17:"info@darkfr3ak.de";user_id|s:1:"1";user_logged_in|i:1;token|s:20:"74DF39BDCA53465A03C1";'),
('f5fc4d0c10ff58e77820975ddb07b972', '2014-03-19 18:56:39', 1395255399, NULL, ''),
('fa63ade863cd2464b5cd72c5d3447fe9', '2014-03-18 20:27:54', 1395174474, NULL, ''),
('srhlues0ofrddjarpbgfo7ena7', '2014-03-14 21:19:16', 1394831957, NULL, 'user_name|s:9:"darkfr3ak";user_email|s:17:"info@darkfr3ak.de";user_id|s:1:"1";user_logged_in|i:1;token|s:20:"61E53BD852023BDF4396";'),
('t1ho0rh1lmdc4gbfjmqojph9b4', '2014-03-14 22:29:54', 1394841808, NULL, 'user_name|s:9:"darkfr3ak";user_email|s:17:"info@darkfr3ak.de";user_id|s:1:"1";user_logged_in|i:1;token|s:20:"A0BCB139821D70966B02";');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_core_settings`
--

CREATE TABLE IF NOT EXISTS `mycms_core_settings` (
  `property` varchar(150) NOT NULL,
  `value` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `mycms_core_settings`
--

INSERT INTO `mycms_core_settings` (`property`, `value`) VALUES
('site_admin_theme', 'sbadmin'),
('site_theme', 'default'),
('site_title', 'darkfr3ak.de');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_core_users`
--

CREATE TABLE IF NOT EXISTS `mycms_core_users` (
`user_id` bigint(20) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email',
  `user_lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_banned` int(11) NOT NULL DEFAULT '0',
  `user_banReason` text COLLATE utf8_unicode_ci,
  `user_bannedUntil` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `mycms_core_users`
--

INSERT INTO `mycms_core_users` (`user_id`, `user_name`, `user_password_hash`, `user_email`, `user_lastLogin`, `user_banned`, `user_banReason`, `user_bannedUntil`) VALUES
(1, 'darkfr3ak', '$2y$10$28GBl.6ah7N1R3ySIKdOSuiNisSXH1vaCVWhGZD4pN/ZGmopC2HxO', 'info@darkfr3ak.de', '2014-03-13 18:42:11', 0, '', '2014-03-13 19:39:19'),
(2, 'NoobOne', '$2y$10$1FjbLVi0F7cxdhqBWUC6Ce/iRh29NjifkubJsmLmssdWh5C9NGCcG', 'darkfr3ak@freenet.de', '2014-03-13 18:42:11', 0, '', '2014-03-13 19:39:19'),
(3, 'xGr33n', '$2y$10$Pj74Nob8tbl1YuLAfdxWruUDQGB8mUX38SYTWBMnHjkUDAt40.SVG', 'xGr33n@web.de', '2014-03-19 17:39:00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_download_cart`
--

CREATE TABLE IF NOT EXISTS `mycms_download_cart` (
`cart_id` int(11) NOT NULL,
  `cart_fileID` int(11) NOT NULL,
  `cart_userID` int(11) NOT NULL,
  `cart_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_download_categories`
--

CREATE TABLE IF NOT EXISTS `mycms_download_categories` (
`cat_id` int(11) NOT NULL,
  `cat_name` varchar(200) NOT NULL,
  `cat_protected` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `mycms_download_categories`
--

INSERT INTO `mycms_download_categories` (`cat_id`, `cat_name`, `cat_protected`) VALUES
(1, 'Scripts', 0),
(2, 'Books', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_download_files`
--

CREATE TABLE IF NOT EXISTS `mycms_download_files` (
`file_id` int(11) NOT NULL,
  `file_name` varchar(150) NOT NULL,
  `file_version` varchar(50) NOT NULL,
  `file_dispName` varchar(150) NOT NULL,
  `file_desc` text NOT NULL,
  `file_date` datetime NOT NULL,
  `file_category` varchar(100) NOT NULL DEFAULT 'default',
  `file_forMembers` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `mycms_download_files`
--

INSERT INTO `mycms_download_files` (`file_id`, `file_name`, `file_version`, `file_dispName`, `file_desc`, `file_date`, `file_category`, `file_forMembers`) VALUES
(1, 'bootstrap-3.1.1.zip', '3.1.1', 'Twitter Bootstrap', 'Bootstrap is a sleek, intuitive, and powerful front-end framework for faster and easier web development, created by [Mark Otto](http://twitter.com/mdo) and [Jacob Thornton](http://twitter.com/fat), and maintained by the [core team](https://github.com/twbs?tab=members) with the massive support and involvement of the community.', '2014-03-16 23:11:52', 'Scripts', 0),
(2, 'PHP_PDO.pdf', '1.0', 'PHP - PDO Tutorial', 'PHP Data Objects \r\nDas ist der vollstÃ¤ndige Name fÃ¼r PDO. Und genau wie MySQL und MySQLi ist es eine \r\nErweiterung fÃ¼r den Zugriff auf Datenbanken. Allerdings gibt es hier ein paar Features, die \r\nneu sind. Hinzu kommen noch ein paar gravierende Unterschiede zu den beiden anderen \r\nErweiterungen.', '2014-03-16 23:15:29', 'Books', 0),
(3, 'jquery-1.11.0.min.js', '1.11.0', 'jQuery minimized', 'jquery', '2014-03-16 23:15:29', 'Scripts', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_download_log`
--

CREATE TABLE IF NOT EXISTS `mycms_download_log` (
`log_id` int(11) NOT NULL,
  `log_file` int(11) NOT NULL,
  `log_user` varchar(200) NOT NULL DEFAULT 'guest',
  `log_date` datetime NOT NULL,
  `log_version` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_events_calendar`
--

CREATE TABLE IF NOT EXISTS `mycms_events_calendar` (
`event_id` int(11) NOT NULL,
  `event_title` varchar(100) NOT NULL,
  `event_desc` text NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `mycms_events_calendar`
--

INSERT INTO `mycms_events_calendar` (`event_id`, `event_title`, `event_desc`, `event_date`, `event_time`) VALUES
(2, 'Hallo Welt', 'And it works with dark backgrounds : use -alt to display it white', '2014-03-19', '20:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_todolist_tasks`
--

CREATE TABLE IF NOT EXISTS `mycms_todolist_tasks` (
`id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `desc` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `mycms_todolist_tasks`
--

INSERT INTO `mycms_todolist_tasks` (`id`, `title`, `desc`) VALUES
(2, 'Hallo Welt', 'Das ist der erste Task in der ToDo-Liste :P'),
(3, 'Und das ist Nummer 2', 'Huhu :P Mal schauen, was nun noch gemacht werden sollte...'),
(4, 'Nummer 3', 'Diesmal Ã¼ber PDO! Hoffentlich klappts!'),
(5, 'Nummer 4', 'Jetzt mit Form-Action und Form-Method. Hoffentlich!'),
(6, 'Nummer 5', 'Mit Pretty-Url... Klappt natÃ¼rlich beim bearbeiten nicht :(');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_widgets_active`
--

CREATE TABLE IF NOT EXISTS `mycms_widgets_active` (
`active_id` int(11) NOT NULL,
  `active_widget` varchar(150) NOT NULL,
  `active_position` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_widgets_all`
--

CREATE TABLE IF NOT EXISTS `mycms_widgets_all` (
`widget_id` int(11) NOT NULL,
  `widget_name` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `mycms_widgets_all`
--

INSERT INTO `mycms_widgets_all` (`widget_id`, `widget_name`) VALUES
(1, 'hello'),
(2, 'serverStatus'),
(3, 'userInfo');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mycms_widgets_positions`
--

CREATE TABLE IF NOT EXISTS `mycms_widgets_positions` (
`pos_id` int(11) NOT NULL,
  `pos_name` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `mycms_widgets_positions`
--

INSERT INTO `mycms_widgets_positions` (`pos_id`, `pos_name`) VALUES
(2, 'adminDashboard'),
(1, 'sidebarRight');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mycms_acl_permissions`
--
ALTER TABLE `mycms_acl_permissions`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `permKey` (`permKey`);

--
-- Indexes for table `mycms_acl_roles`
--
ALTER TABLE `mycms_acl_roles`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `roleName` (`roleName`);

--
-- Indexes for table `mycms_acl_role_perms`
--
ALTER TABLE `mycms_acl_role_perms`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `roleID_2` (`roleID`,`permID`);

--
-- Indexes for table `mycms_acl_user_perms`
--
ALTER TABLE `mycms_acl_user_perms`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `userID` (`userID`,`permID`);

--
-- Indexes for table `mycms_acl_user_roles`
--
ALTER TABLE `mycms_acl_user_roles`
 ADD UNIQUE KEY `userID` (`userID`,`roleID`);

--
-- Indexes for table `mycms_core_apps`
--
ALTER TABLE `mycms_core_apps`
 ADD PRIMARY KEY (`app_id`), ADD UNIQUE KEY `app_name` (`app_name`);

--
-- Indexes for table `mycms_core_session`
--
ALTER TABLE `mycms_core_session`
 ADD UNIQUE KEY `session_id` (`session_id`);

--
-- Indexes for table `mycms_core_settings`
--
ALTER TABLE `mycms_core_settings`
 ADD PRIMARY KEY (`property`);

--
-- Indexes for table `mycms_core_users`
--
ALTER TABLE `mycms_core_users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `mycms_download_cart`
--
ALTER TABLE `mycms_download_cart`
 ADD PRIMARY KEY (`cart_id`), ADD KEY `cart_fileID` (`cart_fileID`), ADD KEY `cart_userID` (`cart_userID`);

--
-- Indexes for table `mycms_download_categories`
--
ALTER TABLE `mycms_download_categories`
 ADD PRIMARY KEY (`cat_id`), ADD UNIQUE KEY `cat_name` (`cat_name`);

--
-- Indexes for table `mycms_download_files`
--
ALTER TABLE `mycms_download_files`
 ADD PRIMARY KEY (`file_id`), ADD UNIQUE KEY `file_name` (`file_name`);

--
-- Indexes for table `mycms_download_log`
--
ALTER TABLE `mycms_download_log`
 ADD PRIMARY KEY (`log_id`), ADD KEY `log_file` (`log_file`);

--
-- Indexes for table `mycms_events_calendar`
--
ALTER TABLE `mycms_events_calendar`
 ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `mycms_todolist_tasks`
--
ALTER TABLE `mycms_todolist_tasks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mycms_widgets_active`
--
ALTER TABLE `mycms_widgets_active`
 ADD PRIMARY KEY (`active_id`);

--
-- Indexes for table `mycms_widgets_all`
--
ALTER TABLE `mycms_widgets_all`
 ADD PRIMARY KEY (`widget_id`), ADD UNIQUE KEY `widget_name` (`widget_name`);

--
-- Indexes for table `mycms_widgets_positions`
--
ALTER TABLE `mycms_widgets_positions`
 ADD PRIMARY KEY (`pos_id`), ADD UNIQUE KEY `pos_name` (`pos_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mycms_acl_permissions`
--
ALTER TABLE `mycms_acl_permissions`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mycms_acl_roles`
--
ALTER TABLE `mycms_acl_roles`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mycms_acl_role_perms`
--
ALTER TABLE `mycms_acl_role_perms`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `mycms_acl_user_perms`
--
ALTER TABLE `mycms_acl_user_perms`
MODIFY `ID` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mycms_core_apps`
--
ALTER TABLE `mycms_core_apps`
MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `mycms_core_users`
--
ALTER TABLE `mycms_core_users`
MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mycms_download_cart`
--
ALTER TABLE `mycms_download_cart`
MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mycms_download_categories`
--
ALTER TABLE `mycms_download_categories`
MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mycms_download_files`
--
ALTER TABLE `mycms_download_files`
MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mycms_download_log`
--
ALTER TABLE `mycms_download_log`
MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mycms_events_calendar`
--
ALTER TABLE `mycms_events_calendar`
MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mycms_todolist_tasks`
--
ALTER TABLE `mycms_todolist_tasks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mycms_widgets_active`
--
ALTER TABLE `mycms_widgets_active`
MODIFY `active_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mycms_widgets_all`
--
ALTER TABLE `mycms_widgets_all`
MODIFY `widget_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mycms_widgets_positions`
--
ALTER TABLE `mycms_widgets_positions`
MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

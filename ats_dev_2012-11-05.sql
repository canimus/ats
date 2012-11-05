# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.1.44)
# Database: ats_dev
# Generation Time: 2012-11-05 13:15:45 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table game_stats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `game_stats`;

CREATE TABLE `game_stats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `coord_x` double DEFAULT NULL,
  `coord_y` double DEFAULT NULL,
  `coord_z` int(11) DEFAULT NULL,
  `stat_type` enum('p3','p2','p1','p','f','r','a','l','s','b') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `game_stats` WRITE;
/*!40000 ALTER TABLE `game_stats` DISABLE KEYS */;

INSERT INTO `game_stats` (`id`, `player_id`, `game_id`, `coord_x`, `coord_y`, `coord_z`, `stat_type`)
VALUES
	(1,2,1,206,248.58332824707,0,'p'),
	(2,2,1,232,286.583312988281,1,'p'),
	(3,2,1,201,301.583312988281,0,'p'),
	(4,2,1,224,355.583312988281,1,'p'),
	(5,2,1,224,409.583312988281,0,'p'),
	(6,2,1,322,227.58332824707,0,'p'),
	(7,2,1,322,204.58332824707,1,'p'),
	(8,2,1,381,211.58332824707,0,'p'),
	(9,2,1,260,123.58332824707,0,'p'),
	(10,2,1,935,82.5833282470703,0,'p'),
	(11,2,1,797,218.58332824707,1,'p'),
	(12,2,1,914,188.58332824707,0,'p'),
	(13,2,1,908,201.58332824707,1,'p'),
	(14,2,1,905,243.58332824707,0,'p'),
	(15,2,1,0,0,1,'p2'),
	(17,2,1,0,0,1,'p2'),
	(18,2,1,0,0,1,'p2'),
	(19,2,1,0,0,1,'p2'),
	(20,2,1,0,0,1,'p2'),
	(21,2,1,0,0,0,'p1'),
	(22,2,1,0,0,0,'p3'),
	(44,2,1,887.5,195,1,'r'),
	(43,2,1,892.5,244,1,'r'),
	(42,2,1,892.5,261,1,'r'),
	(41,2,1,254.5,192,1,'r'),
	(40,2,1,244.5,224,1,'r'),
	(38,2,1,234.5,198,1,'r'),
	(39,2,1,256.5,266,1,'r'),
	(35,2,1,0,0,0,'r'),
	(49,5,1,231.5,259,1,'r'),
	(33,2,1,0,0,0,'r'),
	(45,2,1,395.5,289,1,'a'),
	(46,2,1,284.5,214,1,'l'),
	(47,2,1,845.5,217,1,'l'),
	(48,2,1,304.5,141,1,'s'),
	(50,5,1,243.5,238,1,'r'),
	(51,5,1,231.5,228,1,'r'),
	(52,5,1,241.5,202,1,'r'),
	(53,5,1,899.5,196,1,'r'),
	(54,5,1,890.5,221,1,'r'),
	(55,5,1,900.5,255,1,'r'),
	(56,5,1,334.5,210,1,'l'),
	(57,5,1,784.5,218,1,'l'),
	(58,5,1,289.5,305,1,'s'),
	(59,5,1,847.5,339,1,'s'),
	(60,3,1,241.5,193,1,'r'),
	(61,3,1,850.5,342,1,'a'),
	(62,3,1,889.5,138,1,'l'),
	(63,3,1,253.5,233,1,'s'),
	(64,3,1,250.5,295,1,'s'),
	(65,3,1,906.5,317,1,'s'),
	(66,6,1,237.5,254,1,'r'),
	(67,6,1,875.5,262,1,'a'),
	(68,6,1,244.5,139,1,'l'),
	(69,6,1,246.5,196,1,'l'),
	(71,11,1,238.5,262,1,'r'),
	(72,11,1,870.5,205,1,'r'),
	(73,11,1,884.5,266,1,'r'),
	(74,11,1,244.5,201,1,'s'),
	(75,1,1,232.5,237,1,'r'),
	(76,1,1,881.5,262,1,'l'),
	(77,7,1,233.5,245,1,'r'),
	(78,4,1,228.5,210,1,'r'),
	(79,4,1,235.5,251,1,'r'),
	(80,4,1,878.5,214,1,'l'),
	(81,4,1,878.5,248,1,'l'),
	(119,7,1,174.5,45,1,'p'),
	(83,4,1,251.5,287,1,'s'),
	(84,3,1,230.5,195,1,'p'),
	(85,3,1,229.5,226,1,'p'),
	(86,3,1,899.5,243,1,'p'),
	(87,3,1,916.5,314,1,'p'),
	(88,3,1,235.5,204,0,'p'),
	(89,3,1,243.5,221,0,'p'),
	(90,3,1,891.5,105,0,'p'),
	(91,3,1,910.5,256,0,'p'),
	(92,3,1,231.5,202,1,'p2'),
	(93,3,1,231.5,223,1,'p2'),
	(94,3,1,889.5,240,1,'p2'),
	(95,3,1,907.5,307,1,'p2'),
	(96,3,1,322.5,221,1,'p1'),
	(97,6,1,331.5,350,1,'p3'),
	(98,7,1,182.5,47,1,'p3'),
	(99,5,1,890.5,203,1,'p2'),
	(100,5,1,901.5,193,1,'p2'),
	(101,1,1,914.5,256,1,'p2'),
	(102,1,1,863.5,255,1,'p2'),
	(103,1,1,881.5,289,1,'p2'),
	(104,1,1,795.5,211,1,'p1'),
	(105,1,1,795.5,219,1,'p1'),
	(118,10,1,739.5,217,0,'p'),
	(117,10,1,881.5,322,0,'p'),
	(116,10,1,901.5,251,0,'p'),
	(115,10,1,212.5,251,0,'p'),
	(114,6,1,338.5,356,1,'p'),
	(112,6,1,267.5,137,0,'p'),
	(113,6,1,850.5,133,0,'p'),
	(120,7,1,219.5,250,0,'p'),
	(121,7,1,200.5,292,0,'p'),
	(122,7,1,344.5,332,0,'p'),
	(123,7,1,899.5,253,0,'p'),
	(124,7,1,852.5,305,0,'p'),
	(125,7,1,833.5,381,0,'p'),
	(126,9,1,255.5,131,0,'p'),
	(127,11,1,237.5,222,0,'p'),
	(128,11,1,828.5,220,0,'p'),
	(129,11,1,903.5,255,0,'p'),
	(130,1,1,821.5,241,1,'p'),
	(131,1,1,911.5,246,1,'p'),
	(132,1,1,861.5,289,1,'p'),
	(133,1,1,297.5,231,0,'p'),
	(134,1,1,195.5,410,0,'p'),
	(135,1,1,736.5,113,0,'p'),
	(136,1,1,889.5,224,0,'p'),
	(137,8,1,215.5,409,0,'p'),
	(138,8,1,791.5,80,0,'p'),
	(139,4,1,868.5,47,1,'p'),
	(140,4,1,839.5,58,0,'p'),
	(141,4,1,905.5,244,0,'p'),
	(142,4,1,813.5,335,0,'p'),
	(143,4,1,903.5,44,1,'p3'),
	(144,4,1,323.5,215,1,'p1'),
	(145,4,1,323.5,224,1,'p1'),
	(146,5,1,903.5,193,1,'p'),
	(147,5,1,883.5,208,1,'p'),
	(148,5,1,893.5,218,0,'p'),
	(149,5,1,911.5,244,0,'p');

/*!40000 ALTER TABLE `game_stats` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table games
# ------------------------------------------------------------

DROP TABLE IF EXISTS `games`;

CREATE TABLE `games` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `team_1` int(11) DEFAULT NULL,
  `team_2` int(11) DEFAULT NULL,
  `game_day` datetime DEFAULT NULL,
  `score_team_1_Q1` int(11) DEFAULT NULL,
  `score_team_1_Q2` int(11) DEFAULT NULL,
  `score_team_1_Q3` int(11) DEFAULT NULL,
  `score_team_1_Q4` int(11) DEFAULT NULL,
  `score_team_2_Q1` int(11) DEFAULT NULL,
  `score_team_2_Q2` int(11) DEFAULT NULL,
  `score_team_2_Q3` int(11) DEFAULT NULL,
  `score_team_2_Q4` int(11) DEFAULT NULL,
  `final_score_team_1` int(11) DEFAULT NULL,
  `final_score_team_2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;

INSERT INTO `games` (`id`, `team_1`, `team_2`, `game_day`, `score_team_1_Q1`, `score_team_1_Q2`, `score_team_1_Q3`, `score_team_1_Q4`, `score_team_2_Q1`, `score_team_2_Q2`, `score_team_2_Q3`, `score_team_2_Q4`, `final_score_team_1`, `final_score_team_2`)
VALUES
	(1,1,5,'2012-10-27 10:30:00',13,8,11,10,8,14,18,8,42,48),
	(2,1,2,'2012-11-03 11:30:00',13,8,11,10,8,14,18,8,42,48);

/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table players
# ------------------------------------------------------------

DROP TABLE IF EXISTS `players`;

CREATE TABLE `players` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `height` double DEFAULT NULL,
  `email` varchar(400) DEFAULT NULL,
  `jersey` int(11) DEFAULT NULL,
  `bio` text,
  `country` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `players` WRITE;
/*!40000 ALTER TABLE `players` DISABLE KEYS */;

INSERT INTO `players` (`id`, `first_name`, `last_name`, `birth_date`, `weight`, `height`, `email`, `jersey`, `bio`, `country`)
VALUES
	(1,'Herminio','Vazquez','1977-08-17',105,1.82,'canimus@gmail.com',NULL,NULL,NULL),
	(2,'Roberto','Rojas',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(3,'Luis','Maya',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(4,'Emmanuel','Offor',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(5,'Carlos','Coves',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(6,'Ian','Triguero',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(7,'Álvaro','Guilabert',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(8,'Daniel','Garrido',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(9,'Alejandro','García',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(10,'Miguel','Cremades',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(11,'Alexander','Datko',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(12,'Gabri',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(13,'Leo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `players` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table teams
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;

INSERT INTO `teams` (`id`, `name`)
VALUES
	(1,'ATS'),
	(2,'Galgos Teleges'),
	(3,'Ruskin Team'),
	(4,'CDC La Marina Moval Palets'),
	(5,'SO.B.A'),
	(6,'Neumáticos Lucre'),
	(7,'C.B.I. Casa Harry'),
	(8,'LAUDE Newton College'),
	(9,'Tapería A ca la Mama'),
	(10,'360 Padel'),
	(11,'Centro Fisioterapia Raquis');

/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

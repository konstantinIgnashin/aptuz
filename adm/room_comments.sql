# MySQL-Front 5.0  (Build 1.0)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: localhost    Database: uzbekist_forex
# ------------------------------------------------------
# Server version 5.0.51b-community

#
# Table structure for table room_comments
#

CREATE TABLE `room_comments` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `place_id` int(2) default NULL,
  `content_id` int(11) default NULL,
  `tstamp` int(11) default NULL,
  `title` text,
  `rating` int(3) default '0',
  `disable` int(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
INSERT INTO `room_comments` VALUES (1,14,1,10017,1311723004,'Думаю сегодня евро будет снова падать.',1,0);
INSERT INTO `room_comments` VALUES (2,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (3,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (4,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (5,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (6,14,1,10018,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (7,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (8,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (9,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (10,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (11,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (12,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (13,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (14,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (15,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (16,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (17,14,1,10017,1311723004,'хороший день для работы.',0,1);
INSERT INTO `room_comments` VALUES (18,14,1,10017,1311723004,'хороший день для работы. byt njrf',0,1);
INSERT INTO `room_comments` VALUES (19,14,1,10017,1311723004,'хороший день для работы.',0,0);
INSERT INTO `room_comments` VALUES (20,14,1,10017,1311723004,'хороший день для работы.',0,0);
INSERT INTO `room_comments` VALUES (21,14,1,10017,1311723004,'хороший день для работы.укук',0,0);
/*!40000 ALTER TABLE `room_comments` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

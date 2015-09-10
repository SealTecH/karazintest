-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.22-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных karazin
DROP DATABASE IF EXISTS `karazin`;
CREATE DATABASE IF NOT EXISTS `karazin` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `karazin`;


-- Дамп структуры для таблица karazin.banner
DROP TABLE IF EXISTS `banner`;
CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hint` varchar(1023) DEFAULT NULL,
  `filename` varchar(1023) NOT NULL,
  `priority` float NOT NULL,
  `href` text,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для процедура karazin.getNewBannerId
DROP PROCEDURE IF EXISTS `getNewBannerId`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `getNewBannerId`()
    READS SQL DATA
    SQL SECURITY INVOKER
    COMMENT 'Returns new random banner ID'
BEGIN
SELECT MAX(`rangedbanners`.`cumulative_sum`) INTO @cumulative_priority FROM `rangedbanners`;
SET @pointer = getRandInt(1,@cumulative_priority);
 	SELECT *, @pointer AS 'seed', @cumulative_priority AS 'cumulative_priority'
 		FROM `rangedbanners`
 		WHERE `rangedbanners`.`active` IS TRUE
 		AND `rangedbanners`.`cumulative_sum`>=@pointer
		ORDER BY `rangedbanners`.`cumulative_sum` ASC
		LIMIT 1;
END//
DELIMITER ;


-- Дамп структуры для функция karazin.getRandInt
DROP FUNCTION IF EXISTS `getRandInt`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `getRandInt`(`min` INT, `max` INT) RETURNS int(11)
    NO SQL
    SQL SECURITY INVOKER
    COMMENT 'Returns random integer from I to N'
BEGIN
SELECT FLOOR(RAND()*(max-min+1))+min INTO @RESULT;
RETURN @RESULT;
END//
DELIMITER ;


-- Дамп структуры для представление karazin.rangedbanners
DROP VIEW IF EXISTS `rangedbanners`;
-- Создание временной таблицы для обработки ошибок зависимостей представлений
CREATE TABLE `rangedbanners` (
	`BID` INT(11) NOT NULL,
	`id` INT(11) NOT NULL,
	`hint` VARCHAR(1023) NULL COLLATE 'utf8_general_ci',
	`filename` VARCHAR(1023) NOT NULL COLLATE 'utf8_general_ci',
	`priority` FLOAT NOT NULL,
	`href` TEXT NULL COLLATE 'utf8_general_ci',
	`active` TINYINT(1) NOT NULL,
	`text` TEXT NULL COLLATE 'utf8_general_ci',
	`cumulative_sum` DOUBLE NULL
) ENGINE=MyISAM;


-- Дамп структуры для таблица karazin.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL,
  `level` decimal(10,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для представление karazin.rangedbanners
DROP VIEW IF EXISTS `rangedbanners`;
-- Удаление временной таблицы и создание окончательной структуры представления
DROP TABLE IF EXISTS `rangedbanners`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `rangedbanners` AS SELECT `banner`.id as 'BID', `banner`.*,
         (SELECT SUM(`banner`.`priority`)
            FROM `banner`
           WHERE `banner`.id <= BID
			  ORDER BY `banner`.`priority` ASC) AS cumulative_sum
    FROM `banner`
    WHERE `banner`.`active` IS TRUE
ORDER BY `banner`.`priority` ASC ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

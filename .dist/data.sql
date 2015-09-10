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
-- Дамп данных таблицы karazin.banner: ~9 rows (приблизительно)
DELETE FROM `banner`;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
INSERT INTO `banner` (`id`, `hint`, `filename`, `priority`, `href`, `active`, `text`) VALUES
	(9, 'Banner hint 1', '9_1.jpg', 1, '/content/1', 1, ''),
	(10, 'Banner hint 2', '10_2.jpg', 5, '/content/2', 1, 'Banner 2 text'),
	(11, 'Banner hint 3', '11_3.jpg', 10, '/content/3', 1, 'Banner 3 text'),
	(12, 'Banner hint 4', '12_4.jpg', 4, '/content/4', 1, 'Banner 4 text<br><small>Additional info</small>'),
	(14, 'Banner hint 6', '14_6.jpg', 6, '/content/6', 1, 'Banner 6 text'),
	(15, 'Banner hint 7', '15_7.jpg', 50, '/content/7', 1, 'Баннер 7<br><small>И русский тоже работает ;)</small>'),
	(17, 'Banner 5 hint', '17_5.jpg', 1, '/content/5', 1, 'Banner 5 text'),
	(18, 'Banner 8 hint', '18_8.jpg', 1, '/content/8', 1, 'Banner 8 text'),
	(19, 'Banner 9 hint', '19_9.jpg', 3, '/content/9', 1, 'Banner 9 text');
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;

-- Дамп данных таблицы karazin.user: ~0 rows (приблизительно)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `surname`, `email`, `isActive`, `password`, `level`) VALUES
	(1, 'Serhii', 'Lilikovych', 'sergiy.lilikovych@gmail.com', 1, '6d8e5be200a835beb77d899f00b890a5', 999999);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.33 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for contacts
CREATE DATABASE IF NOT EXISTS `contacts` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `contacts`;

-- Dumping structure for table contact
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `phone` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table contact: ~15 rows (approximately)
INSERT INTO `contact` (`id`, `fname`, `lname`, `sex`, `phone`, `email`) VALUES
	(1, 'Людмила', 'Карелина', 0, '+77058225474', 'veterok@mail.ru'),
	(2, 'Жанна', 'Маврешко', 0, '+77015221186', 'zhanna@gmail.com'),
	(3, 'Анар', 'Еставлетова', 0, '+77779833818', 'estavletova@mail.ru'),
	(4, 'Анастасия', 'Бахчева', 0, '+77719875522', 'nastya@list.ru'),
	(5, 'Руслан', 'Баһрамұлы', 1, '+77765766220', 'ruslan@mail.ru'),
	(6, 'Владимир', 'Геер', 1, '+77085882036', 'cobra@gmail.com'),
	(7, 'Куат', 'Калиев', 1, '+77071933719', 'madkot@gmail.com'),
	(8, 'Аскар', 'Серикбай', 1, '+77071922817', 'oscar@mail.ru'),
	(9, 'Роза', 'Мусина', 0, '+77054161142', 'musina@mail.ru'),
	(10, 'Ирина', 'Редер', 0, '+77017855730', 'iren@mail.ru'),
	(11, 'Евгения', 'Платонкина', 0, '+77017855734', 'platonkina@mail.ru'),
	(12, 'Фарида', 'Буленканова', 0, '+77087322575', 'faridab@mail.ru'),
	(13, 'Лаура', 'Оспанова', 0, '+77778835963', 'laura@mail.ru'),
	(14, 'Салтанат', 'Омарова', 0, '+77475199604', 'salta@mail.ru'),
	(15, 'Светлана', 'Гусева', 0, '+77012113305', 'svetla@mail.ru');

-- Dumping structure for table user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uq_login` (`login`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table user: ~3 rows (approximately)
INSERT INTO `user` (`id`, `fname`, `lname`, `login`, `pass`) VALUES
	(1, 'Q', NULL, 'q', 'q'),
	(9, 'E', 'E', 'e', 'e'),
	(12, 'W', '', 'w', 'w');

-- Dumping structure for table usercontact
CREATE TABLE IF NOT EXISTS `usercontact` (
  `userid` int NOT NULL,
  `contactid` int NOT NULL,
  PRIMARY KEY (`userid`,`contactid`) USING BTREE,
  KEY `FK_usercontact_contact` (`contactid`) USING BTREE,
  CONSTRAINT `FK_usercontact_contact` FOREIGN KEY (`contactid`) REFERENCES `contact` (`id`),
  CONSTRAINT `FK_usercontact_user` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table usercontact: ~13 rows (approximately)
INSERT INTO `usercontact` (`userid`, `contactid`) VALUES
	(9, 2),
	(12, 3),
	(1, 4),
	(12, 4),
	(1, 5),
	(1, 7),
	(12, 7),
	(9, 9),
	(12, 11),
	(1, 12),
	(12, 12),
	(1, 13),
	(9, 13),
	(1, 14);

-- Dumping structure for procedure sp_contacts
DELIMITER //
CREATE PROCEDURE `sp_contacts`(
	IN `_userid` INT
)
BEGIN

	select c.id,
		concat_ws(' ', c.fname, c.lname) `name`,
		c.sex,
		c.phone,
		c.email,
		if(uc.userid, 1, 0) fav
	from contact c
		left join usercontact uc on uc.contactid=c.id and uc.userid=_userid
	order by `name`;

END//
DELIMITER ;

-- Dumping structure for procedure sp_fav
DELIMITER //
CREATE PROCEDURE `sp_fav`(
	IN `_userid` INT,
	IN `_contactid` INT,
	IN `_fav` INT
)
BEGIN

	if _fav then
		insert ignore into usercontact values(_userid, _contactid);
	else
		delete from usercontact where userid=_userid and contactid=_contactid;
	end if;

END//
DELIMITER ;

-- Dumping structure for procedure sp_signdown
DELIMITER //
CREATE PROCEDURE `sp_signdown`(
	IN `_userid` INT
)
BEGIN

    start transaction;

    delete from `usercontact` where userid=_userid;
    delete from `user` where id=_userid;

    commit;

END//
DELIMITER ;

-- Dumping structure for procedure sp_signin
DELIMITER //
CREATE PROCEDURE `sp_signin`(
	IN `_login` VARCHAR(190),
	IN `_pass` VARCHAR(190)
)
BEGIN

	select id, fname
	from user
	where login=_login and pass=_pass;

END//
DELIMITER ;

-- Dumping structure for procedure sp_signup
DELIMITER //
CREATE PROCEDURE `sp_signup`(
	IN `_fname` VARCHAR(190),
	IN `_lname` VARCHAR(190),
	IN `_login` VARCHAR(190),
	IN `_pass` VARCHAR(190)
)
BEGIN

	insert into user(fname, lname, login, pass)
	values(_fname, _lname, _login, _pass);

	select last_insert_id() id;

END//
DELIMITER ;

-- Dumping structure for procedure sp_usercontacts
DELIMITER //
CREATE PROCEDURE `sp_usercontacts`(
	IN `_userid` INT
)
BEGIN

	select c.id,
		concat_ws(' ', c.fname, c.lname) `name`,
		c.sex,
		c.phone,
		c.email,
		1 fav
	from contact c
		inner join usercontact uc on uc.contactid=c.id and uc.userid=_userid
	order by `name`;

END//
DELIMITER ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

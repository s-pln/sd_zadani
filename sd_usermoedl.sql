-- --------------------------------------------------------
-- Hostiteľ:                     127.0.0.1
-- Verze serveru:                5.7.40 - MySQL Community Server (GPL)
-- OS serveru:                   Win64
-- HeidiSQL Verzia:              11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Exportování struktury databáze pro
CREATE DATABASE IF NOT EXISTS `sddb` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_slovak_ci */;
USE `sddb`;

-- Exportování struktury pro tabulka sddb.usermodel
CREATE TABLE IF NOT EXISTS `usermodel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `passwd` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

-- Exportování dat pro tabulku sddb.usermodel: 4 rows
/*!40000 ALTER TABLE `usermodel` DISABLE KEYS */;
INSERT INTO `usermodel` (`id`, `name`, `surname`, `email`, `passwd`) VALUES
	(1, 'Admin', 'Testovaci', 'admin@testovaci.cz', '$2y$10$QWwGm4CnjqZkMrDSmCwi7.YC4E/.iVw4gqlNy429Pn0ommcyBw.Bi'),
	(2, 'Test', 'Testovaci', 'test@testovaci.cz', '$2y$10$60ketq0O4QLNVfsbbCGcqOMTg2EnSP9gq5FW9wCcf8ARfOw.3it2C'),
	(5, 'Testerik', 'Testovaci', 'tester2@testovaci.cz', '$2y$10$nY2t8as1Ywg3OFOBMH9O2OTdYKJArCGtOChAMktwE5I8dP0vziTIm');
/*!40000 ALTER TABLE `usermodel` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

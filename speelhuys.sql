-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                10.6.12-MariaDB-0ubuntu0.22.04.1 - Ubuntu 22.04
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Versie:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Structuur van  tabel speelhuys.brands wordt geschreven
CREATE TABLE IF NOT EXISTS `brands` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(50) NOT NULL,
  `brand_logo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel speelhuys.brands: ~13 rows (ongeveer)
INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_logo`) VALUES
	(1, 'Lego', 'lego.png'),
	(2, 'Kapla', 'kaplan.png'),
	(3, 'Duplo', 'duplo.png'),
	(4, 'RoboTime', 'robotime.png'),
	(5, 'SmartMax', 'smartmax.png'),
	(6, 'Brio', 'brio.png'),
	(7, 'Playmobil', 'playmobil.png'),
	(8, 'MegaBloks', 'megabloks.png'),
	(9, 'MegaConstrux', 'megaconstrux.png'),
	(10, 'Geomag', 'geomag.png'),
	(11, 'KNEX', 'knex.png'),
	(12, 'GraviTrax', 'gravitrax.png'),
	(13, 'Clementoni', 'clementoni.png');

-- Structuur van  tabel speelhuys.sets wordt geschreven
CREATE TABLE IF NOT EXISTS `sets` (
  `set_id` int(11) NOT NULL AUTO_INCREMENT,
  `set_name` varchar(50) NOT NULL,
  `set_description` text NOT NULL,
  `set_brand_id` int(11) NOT NULL,
  `set_theme_id` int(11) DEFAULT NULL,
  `set_image` varchar(50) DEFAULT NULL,
  `set_price` decimal(20,2) NOT NULL,
  `set_age` int(11) NOT NULL,
  `set_pieces` int(11) NOT NULL,
  `set_stock` int(11) NOT NULL,
  PRIMARY KEY (`set_id`),
  KEY `set_brand_id` (`set_brand_id`),
  KEY `set_theme_id` (`set_theme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel speelhuys.sets: ~15 rows (ongeveer)
INSERT INTO `sets` (`set_id`, `set_name`, `set_description`, `set_brand_id`, `set_theme_id`, `set_image`, `set_price`, `set_age`, `set_pieces`, `set_stock`) VALUES
	(1, 'Lego City Goederen Trein', 'Deze LEGO CITY goederentrein zit vol met authentieke kenmerken en functies en kan eenvoudig op afstand bediend worden. LEGO-nr. 60336', 1, 1, 'lego_city_goederentrein.png', 169.99, 7, 1153, 5),
	(2, 'Lego City Monstertruckrace', 'In deze LEGO CITY monstertruckrace speelset zitten twee grappige monstertrucks en twee minifiguren van coureurs. LEGO-nr. 60397', 1, 1, 'lego_city_monstertruckrace.png', 29.99, 6, 301, 3),
	(3, 'Lego City Politiespeedboot en boevenschuilplaats', 'Kinderen gaan op leuke missies om boeven te vangen met deze LEGO CITY politiespeedboot en boevenschuilplaats speelset voor kinderen van 6 jaar en ouder. LEGO-nr. 60417', 1, 1, 'lego_city_politiespeedboot.png', 29.99, 6, 311, 8),
	(4, 'Kapla Bouwton', 'Maak zelf de mooiste bouwwerken met de 200 onderdelen van deze Kapla set.', 2, NULL, 'kapla_bouwton.png', 49.99, 3, 200, 10),
	(5, 'Duplo Boerderijdieren', 'Met deze Duplo boerderijdieren set kunnen kinderen vanaf 2 jaar oud de leukste avonturen beleven.', 3, NULL, 'duplo_boerderijdieren.png', 49.99, 2, 74, 15),
	(6, 'RoboTime 3D Puzzel - Uil', 'Deze RoboTime 3D puzzel van een uil is een leuke uitdaging voor kinderen vanaf 6 jaar.', 4, NULL, 'robotime_uil.png', 49.99, 6, 161, 5),
	(7, 'SmartMax My First Safari Animals', 'Met deze SmartMax My First Safari Animals set kunnen kinderen vanaf 1 jaar oud de leukste avonturen beleven.', 5, NULL, 'smartmax_safari.png', 24.99, 1, 18, 10),
	(8, 'Brio Treinbaan met boerderij', 'Deze Brio treinbaan met boerderij is een leuke set voor kinderen vanaf 3 jaar.', 6, NULL, 'brio_trein_boerderij.png', 49.99, 3, 20, 1),
	(9, 'Playmobil Politiebureau', 'Met deze Playmobil politiebureau set kunnen kinderen vanaf 4 jaar oud de leukste avonturen beleven.', 7, NULL, 'playmobil_politiebureau.png', 89.99, 4, 256, 3),
	(10, 'MegaBloks First Builders', 'Met deze MegaBloks First Builders set kunnen kinderen vanaf 1 jaar oud de leukste avonturen beleven.', 8, NULL, 'megabloks_firstbuilders.png', 16.95, 1, 60, 10),
	(11, 'MegaConstrux Pokemon Battle', 'Met deze MegaConstrux Pokemon Battle set kunnen kinderen vanaf 6 jaar oud de leukste avonturen beleven.', 9, NULL, 'megaconstrux_pokemon.png', 21.99, 6, 79, 2),
	(12, 'Geomag Mechanics Gravity', 'Met deze Geomag Mechanics Gravity set kunnen kinderen vanaf 7 jaar oud de leukste avonturen beleven.', 10, NULL, 'geomag_gravity.png', 39.99, 7, 169, 8),
	(13, 'KNEX Click en Construct Value bouwset 522-delig', 'Bouw verschillende gave modellen met deze coole K’NEX Click en Construct Value bouwset. Deze set bestaat uit 522 stukken.', 11, NULL, 'knex_buildingset.png', 34.99, 7, 522, 13),
	(14, 'Ravensburger GraviTrax Pro starter-set Vertical', 'Ga met de GraviTrax Vertical starterset aan de slag met het bouwen van de gaafste baan. Hij bevat alles om je allereerste baan te gaan bouwen.', 12, NULL, 'gravitrax_starter.png', 69.99, 8, 153, 14),
	(15, 'Clementoni Cosmeticalaboratorium', 'Het Clementoni cosmeticalaboratorium bevat essences en natuurlijke ingrediënten om prachtige en unieke creaties te maken.', 13, NULL, 'clementoni_cosmeticalaboratorium.png', 24.99, 8, 150, 2);

-- Structuur van  tabel speelhuys.themes wordt geschreven
CREATE TABLE IF NOT EXISTS `themes` (
  `theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(50) NOT NULL,
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel speelhuys.themes: ~4 rows (ongeveer)
INSERT INTO `themes` (`theme_id`, `theme_name`) VALUES
	(1, 'Lego City'),
	(2, 'Lego Marvel'),
	(3, 'Lego Friends'),
	(4, 'Lego Architecture');

-- Structuur van  tabel speelhuys.users wordt geschreven
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_firstname` varchar(20) NOT NULL,
  `user_lastname` varchar(30) NOT NULL,
  `user_email` varchar(25) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` varchar(20) DEFAULT 'standaard',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel speelhuys.users: ~4 rows (ongeveer)
INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_username`, `user_password`, `user_role`) VALUES
	(1, 'Joop', 'Jansen', 'joop@speelhuys.nl', 'joop', 'zu0g5dr', 'admin'),
	(2, 'Ans', 'Jansen', 'ans@speelhuys.nl', 'ans', 'Z1Nm9Dj', 'admin'),
	(3, 'Sophia', 'Smith', 'sophia@speelhuys.nl', 'sophia', 'sd973Es', 'employee'),
	(4, 'Mia', 'Brown', 'mia@speelhuys.nl', 'noah', 'dj35dqdw', 'employee');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.6.20 - MySQL Community Server (GPL)
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para segells
CREATE DATABASE IF NOT EXISTS `segells` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `segells`;


-- Volcando estructura para tabla segells.pais
CREATE TABLE IF NOT EXISTS `pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `id_pais` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pais` (`id_pais`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='Tabla que guardará el nombre de los paises y su nombre recortado.';

-- Volcando datos para la tabla segells.pais: ~26 rows (aproximadamente)
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` (`id`, `nom`, `id_pais`) VALUES
	(1, 'Allemagne (Berlin-Ouest)', 'de-wb'),
	(2, 'Allemagne (Reich)', 'de-re'),
	(3, 'Allemagne (République Démocratique)', 'dd-de'),
	(4, 'Allemagne (République Fédérale)', 'de'),
	(5, 'Andorre (poste espagnole)', 'ad-es'),
	(6, 'Andorre (poste française)', 'ad-fr'),
	(7, 'Autriche', 'at'),
	(8, 'Belgique', 'be'),
	(9, 'Bosnie-Herzégovine (République Serbe)', 'ba-srp'),
	(10, 'Canada', 'ca'),
	(11, 'Cité du Vatican', 'va'),
	(12, 'Espagne', 'es'),
	(13, 'Etats-Unis d\'Amérique', 'us'),
	(14, 'Féroé', 'fo'),
	(15, 'France', 'fr'),
	(16, 'Italie', 'it'),
	(17, 'Liechtenstein', 'li'),
	(18, 'Nations Unies (Genève)', 'onu-g'),
	(19, 'Nations Unies (Vienne)', 'onu-w'),
	(20, 'Ordre Souverain Militaire de Malte', 'smom'),
	(21, 'Polynésie française', 'pf'),
	(22, 'République monastique du Mont Athos', 'gr-69'),
	(23, 'Sahara espagnol', 'eh'),
	(24, 'Slovénie', 'si'),
	(25, ' Suisse', 'ch'),
	(26, 'Terres Australes et Antarctiques Françaises', 'tf-aq');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

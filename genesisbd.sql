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


-- Volcando estructura para tabla segells.idpais
CREATE TABLE IF NOT EXISTS `idpais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `any` int(11) NOT NULL,
  `imatge` longblob NOT NULL,
  `yvert` varchar(10) NOT NULL,
  `michel` varchar(10) NOT NULL,
  `scott` varchar(10) NOT NULL,
  `edifil` varchar(10) NOT NULL,
  `unificato` varchar(10) NOT NULL,
  `cob` varchar(10) NOT NULL,
  `id_pais` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pais` (`id_pais`),
  CONSTRAINT `id_pais` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='//////  ATENCIÓN //////\r\nCambiar nombre de la tabla según el pais.\r\n//////////////////////////////////////////////\r\nTabla donde guardará la información las imágenes en código binario, junto con el año, pais y demás.';

-- Volcando datos para la tabla segells.idpais: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `idpais` DISABLE KEYS */;
/*!40000 ALTER TABLE `idpais` ENABLE KEYS */;


-- Volcando estructura para tabla segells.pais
CREATE TABLE IF NOT EXISTS `pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `id_pais` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que guardará el nombre de los paises y su nombre recortado.';

-- Volcando datos para la tabla segells.pais: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

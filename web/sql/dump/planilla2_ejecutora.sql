CREATE DATABASE  IF NOT EXISTS `planilla2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `planilla2`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win32 (AMD64)
--
-- Host: localhost    Database: planilla2
-- ------------------------------------------------------
-- Server version	5.7.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ejecutora`
--

DROP TABLE IF EXISTS `ejecutora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ejecutora` (
  `sec_ejec` char(6) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ruc` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `pliego_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `fk_ejecutora_pliego1_idx` (`pliego_id`),
  CONSTRAINT `fk_pliego` FOREIGN KEY (`pliego_id`) REFERENCES `pliego` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ejecutora`
--

LOCK TABLES `ejecutora` WRITE;
/*!40000 ALTER TABLE `ejecutora` DISABLE KEYS */;
INSERT INTO `ejecutora` VALUES ('000016','ARCHIVO GENERAL DE LA NACION','','',0,1,1),('000016','ARCHIVO GENERAL DE LA NACION',NULL,NULL,0,2,2),('000016','ARCHIVO GENERAL DE LA NACION',' Jr Conde de Superunda N° 170- Pasaje Piura S/N° - El Cercado','20131370726',0,3,3),('000016','ARCHIVO GENERAL DE LA NACION','Jr. Camana 125 con Pasaje Piura','20131370726',0,4,4),('000016','ARCHIVO GENERAL DE LA NACION','','',0,5,5),('000016','ARCHIVO GENERAL DE LA NACION','','',0,6,6),('000016','ARCHIVO GENERAL DE LA NACION','','',0,7,7),('000016','ARCHIVO GENERAL DE LA NACION','','',0,8,8),('000016','ARCHIVO GENERAL DE LA NACION','','',0,9,9),('000016','ARCHIVO GENERAL DE LA NACION',NULL,'20131370726',0,10,10),('000016','ARCHIVO GENERAL DE LA NACIÓN',NULL,'20131370726',1,11,11);
/*!40000 ALTER TABLE `ejecutora` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-21  9:00:19

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
-- Table structure for table `afp`
--

DROP TABLE IF EXISTS `afp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `afp` (
  `id` char(2) NOT NULL,
  `regimen_pensionario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `snp` double DEFAULT NULL,
  `jubilacion` double DEFAULT NULL,
  `seguros` double DEFAULT NULL,
  `ra` double DEFAULT NULL,
  `pension` double DEFAULT NULL,
  `ra_mixta` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_afp_regimen_pensionario1_idx` (`regimen_pensionario`),
  CONSTRAINT `fk_afp_regimen_pensionario1` FOREIGN KEY (`regimen_pensionario`) REFERENCES `regimen_pensionario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `afp`
--

LOCK TABLES `afp` WRITE;
/*!40000 ALTER TABLE `afp` DISABLE KEYS */;
INSERT INTO `afp` VALUES ('01',3,'AFP INTEGRA',1,0,0.1,0.0136,0.0155,0,0.009),('02',3,'AFP PROFUTURO',1,0,0.1,0.0136,0.0169,0,0.0107),('12',1,'O.N.P.',1,0.13,0,0,0,0,0),('14',3,'PRIMA AFP',1,0,0.1,0.0136,0.016,0,0.0018),('15',2,'MONTEPIO',1,0,0,0,0,0.27,0),('17',3,'AFP HABITAT',1,0,0.1,0.0136,0.0147,0,0.0038),('18',3,'AFP PRUEBA 2',0,NULL,NULL,NULL,NULL,NULL,NULL),('19',1,'AFP PRUEBA 3',0,NULL,NULL,NULL,NULL,NULL,NULL),('99',9,'SIN O.N.P / AFP',1,0,0,0,0,0,0);
/*!40000 ALTER TABLE `afp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-22  3:10:24

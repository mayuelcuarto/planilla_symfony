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
-- Table structure for table `grupo_ocupacional`
--

DROP TABLE IF EXISTS `grupo_ocupacional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_ocupacional` (
  `grupo_ocupacional` char(2) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`grupo_ocupacional`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_ocupacional`
--

LOCK TABLES `grupo_ocupacional` WRITE;
/*!40000 ALTER TABLE `grupo_ocupacional` DISABLE KEYS */;
INSERT INTO `grupo_ocupacional` VALUES ('00','SIN GRUPO OCUPACIONAL',1),('01','FUNCIONARIOS Y DIRECTIVOS',1),('02','MAGISTRADOS',0),('03','DIPLOMATICOS',0),('04','DOCENTES UNIVERSITARIOS',0),('05','PROFESORADO',0),('06','PROFESIONALES DE LA SALUD',0),('07','PROFESIONALES',1),('08','TECNICOS',1),('09','AUXILIARES',1),('10','OBREROS',0),('11','ESCALAFONADOS DEL SECTOR SALUD',0),('12','EJERCITO PERUANO',0),('13','MARINA DE GUERRA DEL PERU',0),('14','FUERZA AEREA DEL PERU',0),('15','POLICIA NACIONAL DEL PERU',0),('16','PRUEBA 5',0);
/*!40000 ALTER TABLE `grupo_ocupacional` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-13  2:18:21

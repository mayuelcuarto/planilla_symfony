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
-- Table structure for table `unidad`
--

DROP TABLE IF EXISTS `unidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `abrev` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidad`
--

LOCK TABLES `unidad` WRITE;
/*!40000 ALTER TABLE `unidad` DISABLE KEYS */;
INSERT INTO `unidad` VALUES (1,'JEFATURA','JEFATURA'),(2,'OFICINA GENERAL DE AUDITORIA','OCI'),(3,'OFICINA GENERAL DE ASESORIA JURIDICA','OGAJ'),(4,'OFICINA DE ADMINISTRACION DOCUMENTARIA','OAD'),(5,'OFICINA TECNICA ADMINISTRATIVA','OTA'),(6,'OFICINA DE PERSONAL','OP-OTA'),(7,'OFICINA FINANCIERA','OF-OTA'),(8,'OFICINA DE ABASTECIMIENTO','OA-OTA'),(9,'OFICINA DE PLANIFICACION Y PRESUPUESTO','OPP-OTA'),(10,'DIRECCION NACIONAL DE DESARROLLO ARCHIVISTICO Y ARCHIVO INTERMEDIO','DNDAAI'),(11,'DIRECCION DE NORMAS ARCHIVISTICAS','DNA-DNDAAI'),(12,'DIRECCION DE ARCHIVOS PUBLICOS','DAP-DNDAAI'),(13,'DIRECCION DE ARCHIVOS NOTARIALES Y JUDICIALES','DANJ-DNDAAI'),(14,'DIRECCION NACIONAL DE ARCHIVO HISTORICO','DNAH'),(15,'DIRECCION DE ARCHIVO COLONIAL','DAC-DNAH'),(16,'DIRECCION DE ARCHIVO REPUBLICANO','DAR-DNAH'),(17,'DIRECCION DE CONSERVACION','DC-DNAH'),(18,'ESCUELA NACIONAL DE ACHIVEROS','ENA'),(19,'INFORMATICA','INFORMATICA'),(20,'ARCHIVO CENTRAL','AC-OAD'),(21,'ARCHIVO GENERAL DE LA NACION','AGN');
/*!40000 ALTER TABLE `unidad` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-17 22:18:52

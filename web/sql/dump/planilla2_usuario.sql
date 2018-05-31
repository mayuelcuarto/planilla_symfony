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
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `dni` char(8) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `nick` char(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `role` varchar(100) NOT NULL,
  `claveapi` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('44385495','Mayuri Quiroz','Cristhian Daniel','Desarrollador de Software','cmayuri','$2y$04$yhqKTbPQRLFqYxb4ol6f..W2qT/Be.r/mO48e9Jsmuo8ScLsgsmAC',1,'ROLE_ADMIN','$2y$04$yhqKTbPQRLFqYxb4ol6f..W2qT/Be.r/mO48e9Jsmuo8ScLsgsmAC',1),('42094392','admin','admin','admin','admin','$2a$04$GnX.zrv5gwPTWKsEA0jqkeogRPRxRQd/QxFOS0zVKqtwKTOw7qRfq',1,'ROLE_ADMIN','$2a$04$GnX.zrv5gwPTWKsEA0jqkeogRPRxRQd/QxFOS0zVKqtwKTOw7qRfq',2),('08344761','Dominguez','Danielli Noira','Vilchez','ddominguez','$2a$04$GnX.zrv5gwPTWKsEA0jqkeogRPRxRQd/QxFOS0zVKqtwKTOw7qRfq',1,'ROLE_USER','$2a$04$GnX.zrv5gwPTWKsEA0jqkeogRPRxRQd/QxFOS0zVKqtwKTOw7qRfq',3),('11111111','Usuario','Sistema Fox','Usuario de Sistema Fox','pla','$2y$04$/eZu2IA0g4crECnmPOypaeC1FUph41v/JdP5n/dtDqKH.xgb9P/P2',0,'ROLE_USER','$2y$04$/eZu2IA0g4crECnmPOypaeC1FUph41v/JdP5n/dtDqKH.xgb9P/P2',4);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-31 15:24:02

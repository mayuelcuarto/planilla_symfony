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
-- Table structure for table `maestro_detalle`
--

DROP TABLE IF EXISTS `maestro_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maestro_detalle` (
  `cod_maestro` char(100) NOT NULL,
  `cod_detalle` char(2) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `descripcio` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cod_maestro`,`cod_detalle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maestro_detalle`
--

LOCK TABLES `maestro_detalle` WRITE;
/*!40000 ALTER TABLE `maestro_detalle` DISABLE KEYS */;
INSERT INTO `maestro_detalle` VALUES ('CODIGO_RIESGO','01','TITULAR','A',NULL),('CODIGO_RIESGO','02','ALIMENTISTA','A',NULL),('CODIGO_RIESGO','03','VIUDEZ','A',NULL),('CODIGO_RIESGO','04','ORFANDAD','A',NULL),('CODIGO_RIESGO','05','ASCENDENTE','A',NULL),('CODIGO_RIESGO','06','OTROS','A',NULL),('CODIGO_RIESGO','07','PLEBISCITO','A',NULL),('CODIGO_RIESGO','08','VICTIMA TERRORISMO','A',NULL),('CODIGO_RIESGO','09','SIN CODIGO DE RIESGO','A',NULL),('CODIGO_RIESGO','10','TITULAR - INVALIDEZ','A',NULL),('CODIGO_RIESGO','11','PENSIÓN DE GRACIA','A',NULL),('CONDICION_LABORAL','01','NOMBRADO','A',''),('CONDICION_LABORAL','02','CONT. PLAZO DETERMINADO','A',''),('CONDICION_LABORAL','03','CONT. PLAZO INDETERMINADO','A',''),('CONDICION_LABORAL','04','CONT. ADMINISTRATIVO DE SERVICIOS','A',''),('CONDICION_LABORAL','05','PENSIONISTA','A',NULL),('CONDICION_LABORAL','06','DESIGNADO','A',NULL),('CONDICION_LABORAL','07','TRABAJADOR PENSIONISTA','A',NULL),('CONDICION_LABORAL','09','SIN CONDICIÓN','A',NULL),('ESTADO_PERSONAL','A','ACTIVO','A',NULL),('ESTADO_PERSONAL','P','PENSIONISTA','A',NULL),('FORMA_MONTO','1','ASIGNAR MONTO FIJO','A',NULL),('FORMA_MONTO','2','% SOBRE MONTO BRUTO','A',NULL),('FORMA_MONTO','3','% SOBRE MONTO BRUTO SI ES REGIMEN PENSIONARIO ESTATAL','A',NULL),('MOTIVO_ANULACION','01','FIN DE CONTRATO','A',NULL),('MOTIVO_ANULACION','02','FALLECIMIENTO','A',NULL),('MOTIVO_ANULACION','03','RENUNCIA VOLUNTARIA','A',NULL),('MOTIVO_ANULACION','04','BAJA','A',NULL),('MOTIVO_ANULACION','05','REGISTRADO POR ERROR','A',NULL),('REGIMEN_LABORAL','1','DL 276','A','NOMBRADOS'),('REGIMEN_LABORAL','2','DL 728','A',NULL),('REGIMEN_LABORAL','4','DL 1057','A','CAS'),('REGIMEN_LABORAL','9','SIN RÉGIMEN','A',NULL),('REGIMEN_PENSIONARIO','1','DL 19990','A',NULL),('REGIMEN_PENSIONARIO','2','DL 20530','A',NULL),('REGIMEN_PENSIONARIO','3','AFP - 25897','A',NULL),('REGIMEN_PENSIONARIO','9','SIN RÉGIMEN','A',NULL),('SEXO','1','MASCULINO','A',NULL),('SEXO','2','FEMENINO','A',NULL),('SITUACION_LABORAL','1','ACTIVO','A',''),('SITUACION_LABORAL','2','PENSIONISTA','A',''),('SITUACION_LABORAL','3','CAS','A',''),('SITUACION_LABORAL','4','DADO DE BAJA','A',''),('TIPO_CONCEPTO','1','INGRESO','A',NULL),('TIPO_CONCEPTO','2','EGRESO','A',NULL),('TIPO_DOC','01','DNI/LE','A',NULL),('TIPO_DOC','02','CARNET FFPP','A',NULL),('TIPO_DOC','03','CARNET FFAA','A',NULL),('TIPO_DOC','04','CARNET EXTRANJERIA','A',NULL),('TIPO_DOC','07','PASAPORTE','A',NULL),('TIPO_DOC','08','PARTIDA NACIMIENTO','A',NULL),('TIPO_DOC','10','CÓDIGO PENSIONISTA','A',NULL),('TIPO_PLANILLA','1','ACTIVO','A',''),('TIPO_PLANILLA','2','PENSIONISTA','A',''),('TIPO_PLANILLA','3','SOBREVIVIENTE','A',''),('TIPO_PLANILLA','4','CAS','A',''),('TIPO_PROCESO','01','SIN CONCURSO PUBLICO','A','S/N'),('TIPO_PROCESO','02','CONCURSO PUBLICO','A','CP'),('TIPO_PROCESO','03','ADJUDICACION DIRECTA PUBLICA','A','ADP'),('TIPO_PROCESO','04','ADJUDICACION DIRECTA SELECTIVA','A','ADS'),('TIPO_PROCESO','05','ADJUDICACION DE MENOR CUANTIA POR DECLAR. DE DESIERTO','A','MCD'),('TIPO_PROCESO','06','LICITACION PUBLICA NACIONAL','A','LPN'),('TIPO_PROCESO','07','LICITACION PUBLICA INTERNACIONAL','A','LPI'),('TIPO_PROCESO','10','ADJUDICACION DE MENOR CUANTIA','A','AMC'),('TIPO_PROCESO','11','ADJUDICACION DE MENOR CUANTIA POR EXONERACION','A','AMCE'),('TIPO_PROCESO','14','LICITACION PUBLICA','A','LP');
/*!40000 ALTER TABLE `maestro_detalle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-30  2:49:54
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
-- Table structure for table `divfunc`
--

DROP TABLE IF EXISTS `divfunc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `divfunc` (
  `ano_eje` int(11) NOT NULL,
  `divfunc` char(3) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `es_presupu` tinyint(1) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `divfunc`
--

LOCK TABLES `divfunc` WRITE;
/*!40000 ALTER TABLE `divfunc` DISABLE KEYS */;
INSERT INTO `divfunc` VALUES (2010,'000','PROGRAMA GENERICO',0,0,1),(2010,'001','PROCESO LEGISLATIVO',0,1,2),(2010,'002','JUSTICIA',0,1,3),(2010,'003','ADMINISTRACION',0,1,4),(2010,'004','ADMINISTRACION FINANCIERA',0,1,5),(2010,'005','FISCALIZACION FINANCIERA Y PRESUPUESTARIA',0,1,6),(2010,'006','PLANEAMIENTO GUBERNAMENTAL',0,1,7),(2010,'007','CIENCIA Y TECNOLOGIA',0,1,8),(2010,'008','ORGANIZACION AGRARIA',0,1,9),(2010,'009','PROMOCION DE LA PRODUCCION AGRARIA',0,1,10),(2010,'010','PROMOCION DE LA PRODUCCION PECUARIA',0,1,11),(2010,'011','PRESERVACION DE LOS RECURSOS NATURALES RENOVABLES',0,1,12),(2010,'012','PROMOCION Y EXTENSION RURAL',0,1,13),(2010,'013','ASISTENCIA SOLIDARIA',0,1,14),(2010,'014','PROMOCION Y  ASISTENCIA SOCIAL Y COMUNITARIA',0,1,15),(2010,'015','PREVISION',0,1,16),(2010,'016','COMUNICACIONES POSTALES',0,1,17),(2010,'017','TELECOMUNICACIONES',0,1,18),(2010,'021','SERVICIOS DE INTELIGENCIA',0,1,19),(2010,'022','ORDEN INTERNO',0,1,20),(2010,'024','DEFENSA CONTRA SINIESTROS',0,1,21),(2010,'026','EDUCACION INICIAL',0,1,22),(2010,'027','EDUCACION PRIMARIA',0,1,23),(2010,'028','EDUCACION SECUNDARIA',0,1,24),(2010,'029','EDUCACION SUPERIOR',0,1,25),(2010,'030','CAPACITACION Y PERFECCIONAMIENTO',0,1,26),(2010,'031','EDUCACION ESPECIAL',0,1,27),(2010,'032','ASISTENCIA A EDUCANDOS',0,1,28),(2010,'033','EDUCACION FISICA Y DEPORTES',0,1,29),(2010,'034','CULTURA',0,1,30),(2010,'035','ENERGIA',0,1,31),(2010,'036','HIDROCARBUROS',0,1,32),(2010,'037','RECURSOS MINERALES',0,1,33),(2010,'038','RECURSOS HIDRICOS',0,1,34),(2010,'039','INDUSTRIA',0,1,35),(2010,'040','COMERCIO',0,1,36),(2010,'042','TURISMO',0,1,37),(2010,'043','PROTECCION DE LA LIBRE COMPETENCIA',0,1,38),(2010,'044','PROMOCION DE LA PRODUCCION PESQUERA',0,1,39),(2010,'045','POLITICA EXTERIOR',0,1,40),(2010,'047','SANEAMIENTO',0,1,41),(2010,'048','PROTECCION DEL MEDIO AMBIENTE',0,1,42),(2010,'049','PRESTACIONES LABORALES',0,1,43),(2010,'050','PROTECCION AL TRABAJADOR',0,1,44),(2010,'051','TRANSPORTE AEREO',0,1,45),(2010,'052','TRANSPORTE TERRESTRE',0,1,46),(2010,'053','TRANSPORTE FERROVIARIO',0,1,47),(2010,'054','TRANSPORTE HIDROVIARIO',0,1,48),(2010,'055','TRANSPORTE METROPOLITANO',0,1,49),(2010,'057','VIVIENDA',0,1,50),(2010,'058','DESARROLLO URBANO',0,1,51),(2010,'060','DEFENSA CONJUNTA',0,1,52),(2010,'061','INFRAESTRUCTURA EDUCATIVA',0,1,53),(2010,'063','SALUD COLECTIVA',0,1,54),(2010,'064','SALUD INDIVIDUAL',0,1,55),(2010,'066','ORDEN EXTERNO',0,1,56),(2010,'067','LUCHA CONTRA EL CONSUMO DE DROGAS',0,1,57),(2011,'004','PLANEAMIENTO GUBERNAMENTAL',0,1,58),(2011,'006','GESTION',0,1,59),(2011,'012','IDENTIDAD CIUDADANA',0,1,60),(2011,'052','PREVISION SOCIAL',0,1,61),(2012,'052','PREVISION SOCIAL',0,1,62),(2013,'052','PREVISION SOCIAL',0,1,63),(2014,'052','PREVISION SOCIAL',0,1,64),(2015,'052','PREVISION SOCIAL',0,1,65),(2016,'004','PLANEAMIENTO GUBERNAMENTAL',0,1,66),(2016,'005','INFORMACIÓN PÚBLICA',0,1,67),(2016,'006','GESTIÓN',0,1,68),(2016,'052','PREVISION SOCIAL',0,1,69),(2017,'006','GESTIÓN',0,1,70),(2018,'006','GESTIÓN',1,NULL,71),(2018,'004','PLANEAMIENTO GUBERNAMENTAL',1,NULL,72),(2018,'045','CULTURA',1,NULL,73),(2018,'052','PREVISION SOCIAL',1,NULL,74);
/*!40000 ALTER TABLE `divfunc` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-22  3:10:23

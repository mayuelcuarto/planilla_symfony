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
-- Table structure for table `meta`
--

DROP TABLE IF EXISTS `meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meta` (
  `sec_func` int(11) NOT NULL AUTO_INCREMENT,
  `meta` varchar(255) NOT NULL,
  `finalidad` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `ejecutora_id` int(11) NOT NULL,
  `programa_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `act_proy_id` int(11) DEFAULT NULL,
  `funcion_id` int(11) DEFAULT NULL,
  `divfunc_id` int(11) DEFAULT NULL,
  `grpf_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sec_func`),
  KEY `fk_meta_ejecutora1_idx` (`ejecutora_id`),
  KEY `fk_meta_funcion1_idx` (`funcion_id`),
  KEY `fk_meta_programa1_idx` (`programa_id`),
  KEY `fk_meta_producto1_idx` (`producto_id`),
  KEY `fk_meta_act_proy1_idx` (`act_proy_id`),
  KEY `fk_meta_divfunc1_idx` (`divfunc_id`),
  KEY `fk_meta_grpf1_idx` (`grpf_id`),
  CONSTRAINT `fk_meta_act_proy1` FOREIGN KEY (`act_proy_id`) REFERENCES `act_proy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meta_divfunc1` FOREIGN KEY (`divfunc_id`) REFERENCES `divfunc` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meta_ejecutora1` FOREIGN KEY (`ejecutora_id`) REFERENCES `ejecutora` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meta_funcion1` FOREIGN KEY (`funcion_id`) REFERENCES `funcion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meta_grpf1` FOREIGN KEY (`grpf_id`) REFERENCES `grpf` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meta_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meta_programa1` FOREIGN KEY (`programa_id`) REFERENCES `programa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meta`
--

LOCK TABLES `meta` WRITE;
/*!40000 ALTER TABLE `meta` DISABLE KEYS */;
INSERT INTO `meta` VALUES (1,'00001','00008','CONTROL DE RESULTADOS DE LA GESTION INSTITUCIONAL.',0,2,52611,NULL,47,4,4,6),(2,'00001','00017','CONDUCE LA POLITICA INSTITUCIONAL.',0,2,52615,NULL,47,4,4,6),(3,'00001','00024','ASESORAMIENTO DE NATURALEZA JURIDICA.',0,2,52736,NULL,47,4,4,6),(4,'00001','00020','ORIENTA Y CONTROLA LA PLANIFICACION Y PRESUPUESTO DE LA ENTIDAD.',0,2,53764,NULL,47,4,4,6),(5,'00001','00009','COORDINACION, SUPERVISION, EJECUCION Y APOYO A LA GESTION INSTITUCIONAL.',0,2,53015,NULL,125,4,4,7),(6,'00001','00350','EN LA CAPACITACION, FORMACION Y PERFECCIONAMIENTO DEL PERSONAL ARCHIVERO.',0,2,52791,NULL,249,4,4,8),(7,'00001','01398','ORGANIZACION Y ATENCION DE DOCUMENTOS ARCHIVISTICOS A USUARIOS.',0,2,52831,NULL,249,4,4,8),(8,'00002','00405','DEFENSA Y CONSERVACION DE DOCUMENTOS.',0,2,52831,NULL,249,4,4,8),(9,'00001','01420','SUPERVISION, ASESORAMIENTO Y ADMINISTRACION DE ARCHIVOS.',0,2,52912,NULL,249,4,4,8),(10,'00001','01153','ATENCION A PENSIONISTAS Y CESANTES.',0,2,53155,NULL,165,4,16,46),(11,'00001','00001','ORIENTA Y CONTROLA LA PLANIFICACION Y PRESUPUESTO DE LA ENTIDAD',0,4,56799,NULL,9059,18,58,144),(12,'00001','00001','CONDUCE LA GESTION INSTITUCIONAL',0,4,56793,NULL,9055,18,59,145),(13,'00001','00001','COORDINACION, SUPERVISION, EJECUCION Y APOYO A LA GESTION INSTITUCIONAL',0,4,56797,NULL,9056,18,59,146),(14,'00001','00001','CONTROL DE RESULTADOS DE LA GESTION INSTITUCIONAL',0,4,56792,NULL,9058,18,59,146),(15,'00001','00001','ASESORAMIENTO DE NATURALEZA JURIDICA',0,4,56794,NULL,9060,18,59,146),(16,'00001','00001','CAPACITACION, FORMACION Y PERFECCIONAMIENTO DEL PERSONAL ARCHIVERO',0,4,56795,NULL,9061,18,60,147),(17,'00001','00001','PROTEGER Y RESTAURAR EL PATRIMONIO DOCUMENTAL DE LA NACION',0,4,56801,NULL,9062,18,60,148),(18,'00001','00001','SUPERVISION, ASESORAMIENTO Y ADMINISTRACION DE ARCHIVOS',0,4,56796,NULL,9063,18,60,148),(19,'00001','00001','ORAGANIZACION Y ATENCION DE DOCUMENTOS ARCHIVISTICOS A USUARIOS',0,4,56800,NULL,9063,18,60,148),(20,'00001','00001','ATENCION A PENSIONISTAS Y CESANTES',0,4,56798,NULL,9057,19,61,149),(21,'00001','00001','PAGO DE PENSIONES',0,5,56802,NULL,9064,20,62,150),(22,'00008','00008','PAGO DE PENSIONES',0,6,56803,NULL,9065,21,63,151),(23,'00008','00008','PAGO DE PENSIONES',0,7,56804,NULL,9066,22,64,152),(24,'00008','00008','PAGO DE PENSIONES',0,8,56805,NULL,9067,23,65,153),(25,'001','0000020','ACCIONES DE PLANIFICACION',0,9,56806,1,9068,25,66,154),(26,'002','0000017','ACCIONES DE LA ALTA DIRECCIÓN',0,9,56806,1,9069,25,68,156),(27,'003','0001153','PAGO DE PENSIONES',0,9,56806,1,9070,24,68,157),(28,'004','0000009','ACCIONES ADMINISTRATIVAS',0,9,56806,1,9070,25,68,157),(29,'005','0000024','ACCIONES JURIDICO-ADMINISTRATIVO',0,9,56806,1,9071,25,68,157),(30,'006','0000008','ACCIONES DE CONTROL Y AUDITORIA',0,9,56806,1,9072,25,68,158),(31,'007','0001153','PAGO DE PENSIONES',0,9,56807,1,9073,26,69,159),(32,'008','0044509','DEFENDER Y RESTAURAR EL PATRIMONIO DOCUMENTAL DE LA NACION',0,9,56807,1,9074,24,67,155),(33,'009','0044509','DEFENDER Y RESTAURAR EL PATRIMONIO DOCUMENTAL DE LA NACION',0,9,56807,1,9075,24,67,155),(34,'010','0000350','CAPACITAR A PERSONAS',0,9,56807,1,9076,24,67,155),(35,'011','0001420','SUPERVISION A INSTITUCIONES',0,9,56807,1,9077,24,67,155),(36,'012','0001420','SUPERVISION A INSTITUCIONES',0,9,56807,1,9078,24,67,155),(37,'013','0001398','SERVICIO DOCUMENTARIO',0,9,56807,1,9079,24,67,155),(38,'004','0000009','ACCIONES ADMINISTRATIVAS',0,10,56808,2,9080,27,70,160),(39,'006','0000008','ACCIONES DE CONTROL Y AUDITORIA',0,10,56808,2,9080,27,70,160),(40,'001','0000020','ACCIONES DE PLANIFICACION',1,11,57230,3,9083,28,72,162),(41,'002','0000017','ACCIONES DE LA ALTA DIRECCION',1,11,57230,3,9084,28,71,163),(42,'003','0000009','ACCIONES ADMINISTRATIVAS',1,11,57229,3,9082,28,71,161),(43,'004','0000024','ACCIONES JURIDICO-ADMINISTRATIVOS',1,11,57230,3,9085,28,71,164),(44,'005','0000008','ACCION Y CONTROL',1,11,57230,3,9086,28,71,165),(45,'006','0001153','PAGO DE PENSIONES',1,11,57229,3,9087,29,74,167),(46,'007','0044509','DEFENDER Y RESTAURAR EL PATRIMONIO DOCUMENTAL DE LA NACION',1,11,57229,3,9088,28,73,166),(47,'008','0044509','DEFENDER Y RESTAURAR EL PATRIMONIO DOCUMENTAL DE LA NACION',1,11,57229,3,9089,28,73,166),(48,'009','0000350','CAPACITAR A PERSONAS',1,11,57229,3,9090,28,73,166),(49,'010','0001420','SUPERVISION A INSTITUCIONES',1,11,57229,3,9091,28,73,166),(50,'011','0001420','SUPERVISION A INSTITUCIONES',1,11,57229,3,9092,28,73,166),(51,'012','0001398','SERVICIO DOCUMENTARIO',1,11,57229,3,9093,28,73,166);
/*!40000 ALTER TABLE `meta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-13  2:18:15

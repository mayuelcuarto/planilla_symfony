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
-- Table structure for table `especifica`
--

DROP TABLE IF EXISTS `especifica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `especifica` (
  `ano_eje` int(11) NOT NULL,
  `especifica` char(10) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especifica`
--

LOCK TABLES `especifica` WRITE;
/*!40000 ALTER TABLE `especifica` DISABLE KEYS */;
INSERT INTO `especifica` VALUES (2010,'00','RESERVA DE CONTINGENCIA',0,1),(2010,'01','RETRIBUCIONES Y COMPLEMENTOS-LEY DE BASES DE LA CARRERA ADMINISTRATIVA',0,2),(2010,'02','RETRIBUCIONES Y COMPLEMENTOS-LEY DEL PROFESORADO Y SU MODIFICATORIA',0,3),(2010,'03','RETRIBUCIONES Y COMPLEMENTOS - LEY DE LA CARRERA MEDICA Y PROFESIONALES DE LA SALUD',0,4),(2010,'04','RETRIBUCIONES Y COMPLEMENTOS-CARRERA JUDICIAL',0,5),(2010,'05','RETRIBUCIONES Y COMPLEMENTOS-LEY UNIVERSITARIA',0,6),(2010,'06','RETRIBUCIONES Y COMPLEMENTOS-LEY DEL SERVICIO DIPLOMATICO',0,7),(2010,'07','RETRIBUCIONES Y COMPLEMENTOS-PERSONAL MILITAR Y POLICIAL',0,8),(2010,'08','RETRIBUCIONES Y COMPLEMENTOS-CONTRATO A PLAZO INDETERMINADO (REGIMEN LABORAL PRIVADO)',0,9),(2010,'09','RETRIBUCIONES Y COMPLEMENTOS-OBREROS PERMANENTES',0,10),(2010,'10','RETRIBUCIONES Y COMPLEMENTOS-CONTRATOS A PLAZO FIJO(REGIMENES LABORALES PUBLICO Y PRIVADO)',0,11),(2010,'11','OBLIGACIONES DEL EMPLEADOR',0,12),(2010,'12','OTROS BENEFICIOS',0,13),(2010,'13','GASTOS VARIABLES Y OCASIONALES',0,14),(2010,'14','PENSIONES',0,15),(2010,'15','RETRIBUCIONES Y COMPLEMENTOS - CONTRATOS A PLAZO FIJO / LEY DEL PROFESORADO Y SU MODIFICATORIA',0,16),(2010,'16','GUARDIAS HOSPITALARIAS',0,17),(2010,'17','ASIGNACION EXTRAORDINARIA POR TRABAJO ASISTENCIAL',0,18),(2010,'18','ESCOLARIDAD, AGUINALDOS Y GRATIFICACIONES',0,19),(2010,'20','VIATICOS Y ASIGNACIONES',0,20),(2010,'21','VIATICOS Y FLETES (CAMBIO DE COLOCACION)',0,21),(2010,'22','VESTUARIO',0,22),(2010,'23','COMBUSTIBLE Y LUBRICANTES',0,23),(2010,'24','ALIMENTOS DE PERSONAS',0,24),(2010,'26','MATERIALES EXPLOSIVOS Y MUNICIONES',0,25),(2010,'27','SERVICIOS NO PERSONALES',0,26),(2010,'28','PROPINAS',0,27),(2010,'29','MATERIALES DE CONSTRUCCION',0,28),(2010,'30','BIENES DE CONSUMO',0,29),(2010,'31','BIENES DE DISTRIBUCION GRATUITA',0,30),(2010,'32','PASAJES Y GASTOS DE TRANSPORTE',0,31),(2010,'33','SERVICIO DE CONSULTORIA',0,32),(2010,'34','CONTRATACION CON EMPRESAS DE SERVICIOS',0,33),(2010,'35','ARRENDAMIENTO FINANCIERO',0,34),(2010,'36','TARIFAS DE SERVICIOS GENERALES',0,35),(2010,'37','ALQUILER DE BIENES',0,36),(2010,'38','SEGUROS',0,37),(2010,'39','OTROS SERVICIOS DE TERCEROS',0,38),(2010,'40','SUBVENCIONES SOCIALES',0,39),(2010,'41','SUBVENCIONES ECONOMICAS',0,40),(2010,'42','CUOTAS',0,41),(2010,'43','AYUDA FINANCIERA A ESTUDIANTES Y A LA INVESTIGACION UNIVERSITARIA',0,42),(2010,'44','IMPUESTOS, MULTAS Y CONTRIBUCIONES',0,43),(2010,'50','SERVICIOS DE TERCEROS-OBRAS POR CONTRATO (TITULO ONEROSO) O CONVENIO (TITULO GRATUITO)',0,44),(2010,'51','EQUIPAMIENTO Y BIENES DURADEROS',0,45),(2010,'60','ADQUISICION DE INMUEBLES',0,46),(2010,'61','ADQUISICION DE TITULOS VALORES',0,47),(2010,'62','ADQUISICION DE TITULOS REPRESENTATIVOS DE CAPITAL CONSTITUIDO',0,48),(2010,'63','CONSTITUCION O AUMENTO DE CAPITAL DE EMPRESAS',0,49),(2010,'64','CONCESION DE PRESTAMOS',0,50),(2010,'70','SENTENCIAS JUDICIALES Y LAUDOS ARBITRALES',0,51),(2010,'71','GASTOS DE EJERCICIOS ANTERIORES',0,52),(2010,'72','INDEMNIZACIONES Y COMPENSACIONES',0,53),(2010,'73','REGIMEN DE EJECUCION ESPECIAL',0,54),(2010,'74','GASTOS POR SERVICIOS EN EL EXTERIOR',0,55),(2010,'80','INTERESES Y OTROS CARGOS POR DEUDA INTERNA CONTRATADA',0,56),(2010,'81','INTERESES Y OTROS CARGOS POR DEUDA EXTERNA CONTRATADA',0,57),(2010,'82','INTERESES Y CARGOS DE LA DEUDA POR TITULOS VALORES PUBLICOS',0,58),(2010,'90','PRINCIPAL DE LA DEUDA INTERNA CONTRATADA',0,59),(2010,'91','PRINCIPAL DE LA DEUDA EXTERNA CONTRATADA',0,60),(2010,'92','PRINCIPAL DE LA DEUDA POR TITULOS VALORES PUBLICOS',0,61),(2010,'93','CORRECCION MONETARIA Y CAMBIARIA DE LA DEUDA CONTRATADA',0,62),(2010,'94','CORRECCION MONETARIA Y CAMBIARIA DE LA DEUDA POR TITULOS VALORES PUBLICOS',0,63),(2010,'95','GASTOS FINANCIEROS',0,64),(2010,'96','INSUMOS Y SUMINISTROS',0,65),(2016,'2.1.11.12','RETRIBUCIONES Y COMPLEMENTOS EN EFECTIVO: PERSONAL NOMBRADO',0,66),(2016,'2.1.11.13','RETRIBUCIONES Y COMPLEMENTOS EN EFECTIVO: PERSONAL CON CONTRATO A PLAZO FIJO',0,67),(2016,'2.2.11.11','PAGO DE PENSIONES',0,68),(2016,'2.3.28.11','CONTRATO ADMINISTRATIVO DE SERVICIOS',0,69),(2017,'2.1.11.12','RETRIBUCIONES Y COMPLEMENTOS EN EFECTIVO: PERSONAL NOMBRADO',0,70),(2017,'2.1.11.13','RETRIBUCIONES Y COMPLEMENTOS EN EFECTIVO: PERSONAL CON CONTRATO A PLAZO FIJO',0,71),(2017,'2.2.11.11','PAGO DE PENSIONES',0,72),(2017,'2.3.28.11','CONTRATO ADMINISTRATIVO DE SERVICIOS',0,73),(2018,'2.1.11.12','RETRIBUCIONES Y COMPLEMENTOS EN EFECTIVO: PERSONAL NOMBRADO',1,74),(2018,'2.1.11.13','RETRIBUCIONES Y COMPLEMENTOS EN EFECTIVO: PERSONAL CON CONTRATO A PLAZO FIJO',1,75),(2018,'2.2.11.11','PAGO DE PENSIONES',1,76),(2018,'2.3.28.11','CONTRATO ADMINISTRATIVO DE SERVICIOS',1,77);
/*!40000 ALTER TABLE `especifica` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-17 22:18:54

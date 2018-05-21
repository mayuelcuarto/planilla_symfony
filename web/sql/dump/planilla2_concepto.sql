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
-- Table structure for table `concepto`
--

DROP TABLE IF EXISTS `concepto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `concepto` (
  `tipo_concepto` int(11) NOT NULL,
  `concepto` varchar(255) DEFAULT NULL,
  `abreviatura` varchar(255) DEFAULT NULL,
  `forma_monto` char(1) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `es_activo` tinyint(1) DEFAULT NULL,
  `es_pension` tinyint(1) DEFAULT NULL,
  `es_patronal` tinyint(1) DEFAULT NULL,
  `es_asegurada` tinyint(1) DEFAULT NULL,
  `es_afp` tinyint(1) DEFAULT NULL,
  `mcpp_concepto` char(4) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `fk_concepto_tipo_concepto1_idx` (`tipo_concepto`),
  CONSTRAINT `fk_concepto_tipo_concepto1` FOREIGN KEY (`tipo_concepto`) REFERENCES `tipo_concepto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `concepto`
--

LOCK TABLES `concepto` WRITE;
/*!40000 ALTER TABLE `concepto` DISABLE KEYS */;
INSERT INTO `concepto` VALUES (1,'REMUNERACION BASICA','Basica','1',1,1,0,0,1,1,'0089',1),(1,'PENSION PRINCIPAL','Pens.Principal','1',1,0,1,0,1,0,'0047',2),(1,'REUNIFICADA','Reunificada','1',1,1,0,0,1,1,'0029',3),(1,'TRANS PARA HOMOLOGAR','P. Tra.Homol.','1',1,1,1,0,1,0,'0098',4),(1,'BONIFICACION PERSONAL','Bonif.Pers.','1',1,1,1,0,1,1,'0104',5),(1,'BONIFICACION FAMILIAR','Bonif.Fam.','1',1,1,1,0,1,1,'0028',6),(1,'REFRIGERIO Y MOVILIDAD','Ref. y Mov.','1',1,1,1,0,1,0,'0003',7),(1,'BONIFICACION ESPECIAL','Bonif.Espec.','1',1,0,1,0,1,0,'0061',8),(1,'BONIFICACION EX.211','Bonif. Ex. 211','1',1,1,0,0,0,0,'0262',9),(1,'BONIFICACION EX. 276','Bonif. Ex. 276','1',1,1,1,0,0,0,'0005',10),(1,'DECRETO LEY 25697','D.Ley 25697','1',1,1,1,0,1,0,'0200',11),(1,'20530 ART.18','20530 Art. 18','1',1,0,1,0,1,0,'0205',12),(1,'DECRETO DE URG. 37-1994','D.Urg. 37-94','1',1,0,1,0,0,0,'0036',13),(1,'DECRETO LEY 25897','D.Ley 25897','1',1,1,0,0,1,0,'0108',14),(1,'LEY 26504','Ley 26504','1',1,1,0,0,1,0,'0111',15),(1,'DECRETO DE URG. 090-1996','D.Urg. 090-96','1',1,1,1,0,1,0,'0015',16),(1,'DECRETO DE URG. 073-1997','D.Urg. 073-97','1',1,1,1,0,1,0,'0076',17),(1,'DECRETO DE URG. 011-1999','D.Urg. 011-99','1',1,1,1,0,1,0,'0075',18),(1,'DECRETO DE URG. 105-2001-BASICO','D.U. N° 105-2001-BAS','1',0,1,0,0,1,0,NULL,19),(1,'DECRETO DE URG. Nº 016-2005-EF','D.S. Nº 016-2005-EF','1',1,0,1,0,1,0,'0257',20),(1,'DECRETO SUPREMO Nª 110-2006-EF','D.S. Nº 110-2006-EF','1',1,0,1,0,1,0,'0224',21),(1,'DECRETO SUPREMO Nª 039-2007-EF','D.S. Nº 039-2007-EF','1',1,0,1,0,1,0,'0225',22),(1,'LEY PPTO. Nª 29142','D.S. Nº 139-2008-EF','1',0,1,1,0,1,0,'',23),(1,'DECRETO SUPREMO Nª 017-2005-EF','D.S. N° 017-2005-EF','1',1,0,1,0,1,0,'0258',24),(1,'HONORARIOS','Honorarios','1',1,1,0,0,1,0,'0131',25),(1,'BONIFICACION ARTICULO 7 º LEY 28449','Bon. Art. 7º Ley 28449','1',1,0,1,0,1,0,'0160',26),(1,'BON.ESCOLARIDAD D.S. 017-2008-EF','D.S. 017-2008-EF','1',0,1,1,0,0,0,'',27),(1,'DECRETO SUPREMO Nº 120-2008-EF','D.S. Nº 120-2008-EF','1',1,0,1,0,1,0,'0322',28),(1,'REINTEGRO D.S. Nº 120-2008-EF','Reint D.S.120-08-EF','1',0,0,1,0,1,0,'',29),(1,'REINTEGRO D.S. Nº 039-2007-EF','Reint.D.S.039-07-EF','1',0,1,1,0,1,0,'0236',30),(1,'BONIFICACION ESCOLARIDAD FEBRERO 2009','D.S. 026-2009-EF','1',0,1,1,0,0,0,'',31),(1,'LEY 29351','Ley 29351 Aguinaldo','1',1,0,1,0,0,0,'',32),(1,'DECRETO DE URGENCIA Nº 112 - 2009','D.U. Nº 112-2009','1',0,0,1,0,0,0,'',33),(1,'DECRETO SUPREMO Nº 014 - 2009 - EF REAJ. PENSION','D.S. Nº 014-2009-EF','1',1,0,1,0,1,0,'0345',34),(1,'LEY 29465','Ley 29465 Art.7 Escol','1',1,0,1,0,1,0,'',35),(1,'REINTEGRO 90% PENSION SOBREVIVENCIA','Reint 90% Pens. 4 Mes','1',0,0,1,0,1,0,'',36),(1,'DECRETO SUPREMO Nº 077 - 2010 - EF','D.S. Nº 077-2010-EF','1',1,0,1,0,1,0,'0417',37),(1,'REINTEGRO D.S. Nº 077 - 2010 - EF','Reint. D.S.077-10-EF','1',1,0,1,0,1,0,'0236',38),(1,'DECRETO SUPREMO Nº 147 - 2010 - EF','D.S. Nº 147-2010-EF','1',0,1,1,0,1,0,'',39),(1,'DECRETO SUPREMO Nº 248 - 2010 - EF','D.S. Nº 248-2010-EF','1',1,0,1,0,0,0,'',40),(1,'DECRETO SUPREMO Nº 004 - 2011 - EF','D.S. Nº 004-2011-EF','1',0,1,1,0,0,0,'',41),(1,'DECRETO SUPREMO Nº 031 - 2011 - EF','D.S. Nº 031-2011-EF','1',1,0,1,0,1,0,'0425',42),(1,'REINTEGRO D.S. Nº 005 - 2016 - EF','Reint. D.S.005-16-EF','1',0,0,0,0,0,0,'0236',43),(1,'DECRETO SUPREMO Nº 138 - 2011 - EF','D.S. Nº 138-2011-EF','1',1,0,1,0,0,0,'',44),(1,'DECRETO SUPREMO Nº 219 - 201 - EF','D.S. Nº 219-2011-EF','1',1,0,1,0,0,0,'',45),(1,'DECRETO SUPREMO Nª 003 - 012 - EF','D.S N° 003-2012-EF','1',1,0,1,0,1,0,'',46),(1,'DECRETO SUPREMO Nª 024-2012-EF','D.S. N° 024-2012-EF','1',1,0,1,0,1,0,'0451',47),(1,'LEY Nº 29812 - LEY DE PPTO  DEL SECTOR PUBLICO PARA EL AÑO FISCAL 2012','LEY Nº 29812','1',0,0,0,0,0,0,'',48),(1,'DECRETO SUPREMO Nº 003-2013-EF','D.S. Nº 003-2013-EF','1',0,0,1,0,0,0,'',49),(1,'DECRETO SUPREMO Nº 004-2013-EF','D.S. Nº 004-2013-EF','1',1,0,1,0,1,0,'0461',50),(1,'DECRETO SUPREMO Nº 163-2013-EF','D.S. Nº 163-2013-EF','1',1,0,1,0,0,0,'',51),(1,'DECRETO SUPREMO Nº 003-2014-EF','D.S. Nº 003-2014-EF','1',1,0,1,0,1,0,'0482',52),(1,'DECRETO SUPREMO Nº 001-2015-EF','D.S. Nº 001-2015-EF','1',0,1,1,0,0,0,'',53),(1,'DECRETO SUPREMO N° 002-2015-EF','D.S. N° 002-2015-EF','1',1,0,1,0,1,0,'0523',54),(1,'REINTEGRO NO ASEGURABLE','Reintegro No Aseg.','1',1,1,0,0,0,0,'0236',55),(1,'DECRETO SUPREMO N° 182-2015-EF','D.S. N° 182-2015-EF','1',1,0,1,0,0,0,'0077',56),(1,'DECRETO SUPREMO N° 001-2016-EF','Bon. Escolaridad','1',0,0,0,0,0,0,'',57),(1,'LEY 30281','Gratificación','1',0,1,1,0,0,0,'',58),(1,'DECRETO SUPREMO N° 051-1991-PCM','D.S. N° 051-91','1',1,1,0,0,1,0,'0001',59),(1,'DECRETO DE URGENCIA N° 037-1994-EF','D.U. N° 037-94-PCM','1',1,1,0,0,0,0,'0036',60),(1,'DECRETO SUPREMO N° 005-1990-PCM','D.S. N° 005-90-PCM Bon.Dif.','1',1,1,0,0,1,0,'0399',61),(1,'DECRETO SUPREMO N° 005-2016-EF','D.S. N° 005-2016-EF','1',1,0,1,0,1,0,'0533',62),(1,'ENCARGATURA','Encargatura','1',1,1,0,0,1,0,'0118',63),(1,'REVERSION','Reversion','1',0,0,0,0,0,0,'0090',64),(1,'REINTEGRO ASEGURABLE','Reintegro Aseg.','1',1,1,0,0,1,0,'0236',65),(1,'D.S.183-2016-EF','D.S.183-2016-EF','1',0,0,0,0,0,0,'0077',66),(1,'Reintegro Ley 28449','Reint.Ley 28449','1',1,0,1,0,1,0,'',67),(1,'D.S.320-2016-EF','D.S.320-2016-EF Aguinaldo','1',0,0,0,0,0,0,'0077',68),(1,'D.S. Nº 001-2017-EF','Bonif.Escolaridad','1',0,1,0,0,0,0,'0117',69),(1,'D.S. 020-2017-EF','DS.020-2017-EF','1',1,0,1,0,1,0,'0544',70),(1,'DECRETO SUPREMO 204-2017-EF','D.S.204-2017-EF','1',0,1,1,0,0,0,'',71),(1,'REVERSION TP','REVERSION','1',0,1,0,0,0,0,'',72),(1,'Ley 28449','Ley 28449','1',1,0,1,0,1,0,'0160',73),(2,'ESSALUD','Essalud','2',1,0,1,1,0,0,'0001',74),(2,'FONDO DE PENSIONES','F.Pensión','3',1,1,0,0,0,0,'0027',75),(2,'SNP (ONP)','SNP (ONP)','3',1,1,0,0,0,0,'0002',76),(2,'IMP. EXT. DE SOLIDARIDAD','Imp.Ext.Sol.','2',0,1,0,1,0,0,'',77),(2,'APORTE DE JUBILACION','Aport.Jubil.','2',1,1,0,0,0,1,'0009',78),(2,'SEGUROS','Seguros','2',1,1,0,0,0,1,'0008',79),(2,'COMISION R.A.','Comisión R.A.','2',1,1,0,0,0,1,'0010',80),(2,'CLUB MEF','Club MEF','2',0,0,0,0,0,0,'',81),(2,'INASISTENCIA Y TARDANZA','Ina. y Tard.','1',1,1,0,0,0,0,'0013',82),(2,'CUOTA SINDICATO','Cuota Sind.','1',1,1,0,0,0,0,'0067',83),(2,'CREDITO DE FARMACIA','Farm.Crédito.','1',1,1,0,0,0,0,'',84),(2,'PRE CAFAE','Pre.CAFAE','1',1,1,0,0,0,0,'0018',85),(2,'RESPONSABILIDAD FISCAL','Resp.Fiscal','1',0,1,1,0,0,0,'',86),(2,'ESSALUD - VIDA','EsSalud-Vida','1',1,1,0,0,0,0,'0016',87),(2,'SEGUROS RIMAC','Seg.Rimac','1',1,1,1,0,0,0,'0030',88),(2,'SOLUCION FINANCIERA','Soluc.Financ','1',1,1,0,0,0,0,'',89),(2,'CAJA AREQUIPA','Caja Arequipa','1',1,1,0,0,0,0,'0075',90),(2,'ADEUDO F.P.','Adeudo F.P','1',1,1,0,0,0,0,'',91),(2,'APAGN','APAGN','1',1,0,1,0,0,0,'0067',92),(2,'APAGN-PRESTAMO','APAGN-Prést.','1',1,0,1,0,0,0,'',93),(2,'CAFAE','CAFAE','1',1,1,0,0,0,0,'',94),(2,'COOPERATIVA REABILITAD','Coop Reabilitad','1',0,0,1,0,0,0,'',95),(2,'DESCUENTO JUDICIAL','Dcto.Judic.','1',1,1,1,0,0,0,'0041',96),(2,'COOPERATIVA ATLANTIS','Coop. ATLANTIS','1',1,1,0,0,0,0,'0012',97),(2,'OTROS DESCUENTOS','Otros Dctos.','2',1,1,1,0,0,0,'0053',98),(2,'DESCUENTO PAGO INDEBIDO DS 039-2007-EF','Dsto DS 039-07-EF','1',0,1,1,0,0,0,'',99),(2,'MULTA R.D. Nº 019-2008-AGN/OTA','Multa','1',1,0,1,1,0,1,'0039',100),(2,'LICENCIAS SIN GOCE DE HABER','Licencias SGH','1',1,1,0,0,0,0,'0047',101),(2,'RETENCION 4TA CATEGORIA','Retenc. 4ta categ.','1',1,1,0,0,0,0,'0006',102),(2,'Recibo Provisional sin rendicion','Rec.Prov.sin rend.','1',1,1,0,0,0,0,'',103),(2,'REVERSION','REVERSION','1',1,1,0,0,0,0,'',104),(1,'DECRETO SUPREMO. N° 011-2018-EF','D.S.011-2018-EF',NULL,1,0,1,0,1,0,NULL,105);
/*!40000 ALTER TABLE `concepto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-21  9:00:21

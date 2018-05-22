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
-- Dumping events for database 'planilla2'
--

--
-- Dumping routines for database 'planilla2'
--
/*!50003 DROP FUNCTION IF EXISTS `CuotaPatronal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `CuotaPatronal`(planilla_id INT) RETURNS double
BEGIN
DECLARE regimenLaboral INT;
DECLARE sueldoMinimo DOUBLE;
DECLARE patronal DOUBLE;
DECLARE remAseg DOUBLE;

SET regimenLaboral = (SELECT ph.regimen_laboral_id FROM planilla p 
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id
WHERE p.id = planilla_id AND ph.estado = 1);

SET sueldoMinimo = (SELECT rl.sueldo_minimo FROM regimen_laboral rl WHERE rl.id = regimenLaboral);

SET remAseg = (SELECT RemuneracionAsegurable(planilla_id));

IF regimenLaboral = 1 THEN
	IF remAseg <= sueldoMinimo THEN
		SET patronal = sueldoMinimo * 0.09;
    ELSE
		SET patronal = remAseg * 0.09;
    END IF;
ELSEIF regimenLaboral = 4 THEN
	IF remAseg >= sueldoMinimo THEN
		SET patronal = sueldoMinimo * 0.09;
    ELSE
		SET patronal = remAseg * 0.09;
    END IF;
ELSE 
	SET patronal = 0;
END IF;
RETURN redondearA2(patronal);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `GenerarSecPlazaHistorial` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `GenerarSecPlazaHistorial`(plazaId INT) RETURNS int(11)
BEGIN
	DECLARE aux INT;
    SET aux = (SELECT MAX(sec_personal) FROM plaza_historial WHERE plaza_id = plazaId) + 1;
    IF aux IS NOT NULL AND aux > 0 THEN
		RETURN aux;
    ELSE
		RETURN 1;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `redondearA2` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `redondearA2`(valor DOUBLE) RETURNS double
BEGIN
	DECLARE aux DOUBLE;
	SET aux = ROUND(valor + 0.0000000001, 2);
    RETURN aux;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `RemuneracionAfp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `RemuneracionAfp`(planilla_id INT) RETURNS double
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(phc.monto) FROM planilla_has_concepto phc 
INNER JOIN concepto c ON c.id = phc.concepto_id
WHERE phc.planilla_id = planilla_id AND c.tipo_concepto = 1 AND c.es_afp = 1);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `RemuneracionAsegurable` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `RemuneracionAsegurable`(planilla_id INT) RETURNS double
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(phc.monto) FROM planilla_has_concepto phc 
INNER JOIN concepto c ON c.id = phc.concepto_id
WHERE phc.planilla_id = planilla_id AND c.tipo_concepto = 1 AND c.es_asegurada = 1);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `RemuneracionNoAsegurable` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `RemuneracionNoAsegurable`(planilla_id INT) RETURNS double
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(phc.monto) FROM planilla_has_concepto phc 
INNER JOIN concepto c ON c.id = phc.concepto_id
WHERE phc.planilla_id = planilla_id AND c.tipo_concepto = 1 AND c.es_asegurada = 0);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `SugerirAfp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirAfp`() RETURNS char(2) CHARSET latin1
BEGIN
DECLARE aux INT;
DECLARE aux2 CHAR(2);
SET aux = (SELECT MAX(id) FROM afp WHERE id < 99) + 1;
IF aux < 10 THEN
SET aux2 = CONCAT('0',aux);
ELSE
SET aux2 = aux;
END IF;
RETURN aux2;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `SugerirCondicionLaboral` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirCondicionLaboral`() RETURNS char(2) CHARSET latin1
BEGIN
DECLARE aux INT;
DECLARE aux2 CHAR(2);
SET aux = (SELECT MAX(id) FROM condicion_laboral) + 1;
IF aux < 10 THEN
SET aux2 = CONCAT('0',aux);
ELSE
SET aux2 = aux;
END IF;
RETURN aux2;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `SugerirGrupoOcupacional` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirGrupoOcupacional`() RETURNS char(2) CHARSET latin1
BEGIN
DECLARE aux INT;
DECLARE aux2 CHAR(2);
SET aux = (SELECT MAX(go.grupo_ocupacional) FROM grupo_ocupacional go) + 1;
IF aux < 10 THEN
SET aux2 = CONCAT('0',aux);
ELSE
SET aux2 = aux;
END IF;
RETURN aux2;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `SugerirMotivoAnulacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirMotivoAnulacion`() RETURNS char(2) CHARSET latin1
BEGIN
DECLARE aux INT;
DECLARE aux2 CHAR(2);
SET aux = (SELECT MAX(id) FROM motivo_anulacion) + 1;
IF aux < 10 THEN
SET aux2 = CONCAT('0',aux);
ELSE
SET aux2 = aux;
END IF;
RETURN aux2;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `SugerirPlaza` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirPlaza`(tipoPlanilla INT) RETURNS char(6) CHARSET latin1
BEGIN
DECLARE aux INT;
DECLARE aux2 CHAR(6);
SET aux = (SELECT MAX(p.num_plaza) FROM plaza p WHERE p.tipo_planilla = tipoPlanilla) + 1;
IF aux >= 100000 THEN
SET aux2 = aux;
ELSEIF aux >= 10000 THEN
SET aux2 = CONCAT('0',aux);
ELSEIF aux >= 1000 THEN
SET aux2 = CONCAT('00',aux);
ELSEIF aux >= 100 THEN
SET aux2 = CONCAT('000',aux);
ELSEIF aux >= 10 THEN
SET aux2 = CONCAT('0000',aux);
ELSE
SET aux2 = CONCAT('00000',aux);
END IF;
RETURN aux2;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `SugerirRegimenLaboral` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirRegimenLaboral`() RETURNS int(11)
BEGIN
DECLARE aux INTEGER;
SET aux = (SELECT MAX(id) FROM regimen_laboral) + 1;
RETURN aux;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `SugerirRegimenPensionario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirRegimenPensionario`() RETURNS int(11)
BEGIN
DECLARE aux INTEGER;
SET aux = (SELECT MAX(id) FROM regimen_pensionario) + 1;
RETURN aux;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `SugerirTipoDoc` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirTipoDoc`() RETURNS char(2) CHARSET latin1
BEGIN
DECLARE aux INT;
DECLARE aux2 CHAR(2);
SET aux = (SELECT MAX(id) FROM tipo_doc) + 1;
IF aux < 10 THEN
SET aux2 = CONCAT('0',aux);
ELSE
SET aux2 = aux;
END IF;
RETURN aux2;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `TotalEgreso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `TotalEgreso`(planilla_id INT) RETURNS double
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(phc.monto) FROM planilla_has_concepto phc 
INNER JOIN concepto c ON c.id = phc.concepto_id
WHERE phc.planilla_id = planilla_id AND c.tipo_concepto = 2);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ActualizarEsSalud` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarEsSalud`(IN planilla_id INT)
BEGIN
DECLARE remAseg DOUBLE;
DECLARE tipoPlanilla INT;

DECLARE essalud_v INT;
DECLARE essalud DOUBLE;

SET tipoPlanilla = (SELECT pl.tipo_planilla FROM planilla p
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id
INNER JOIN plaza pl ON pl.id = ph.plaza_id
WHERE p.id = planilla_id);

SET remAseg = (SELECT RemuneracionAsegurable(planilla_id));
SET essalud = redondearA2(remAseg * 0.04);

IF tipoPlanilla = 2 OR tipoPlanilla = 3 THEN
IF essalud IS NOT NULL AND essalud > 0 THEN
	SET essalud_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 74);
	IF essalud_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, essalud, NOW(), planilla_id, 74, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = essalud 
		WHERE id = essalud_v;
	END IF;
ELSE 
	SET essalud_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 82);
	IF essalud_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = essalud_v;
    END IF;
END IF;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ActualizarInasistencias` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarInasistencias`(IN planilla_id INT)
BEGIN
DECLARE remAseg DOUBLE;
DECLARE remNoAseg DOUBLE;
DECLARE remBruta DOUBLE;

DECLARE montoDia DOUBLE;
DECLARE montoHora DOUBLE;
DECLARE montoMin DOUBLE;

DECLARE tardanzas_m INT;
DECLARE tardanzas_aux DOUBLE;

DECLARE particulares_m INT;
DECLARE particulares_aux DOUBLE;

DECLARE lsgh_d INT;
DECLARE lsgh_v INT;
DECLARE lsgh_aux DOUBLE;

DECLARE faltas_d INT;
DECLARE faltas_aux DOUBLE;

DECLARE concepto_v INT;
DECLARE concepto_monto DOUBLE;

DECLARE a DOUBLE;
DECLARE b DOUBLE;
DECLARE c DOUBLE;

DECLARE planilla_cursor CURSOR FOR 
(SELECT p.rem_aseg, p.rem_noaseg, p.tardanzas, p.particulares, p.lsgh, p.faltas FROM planilla p 
WHERE p.id = planilla_id);

OPEN planilla_cursor;
FETCH planilla_cursor INTO remAseg, remNoAseg, tardanzas_m, particulares_m, lsgh_d, faltas_d;
CLOSE planilla_cursor;

SET remBruta = remAseg + remNoAseg;

SET montoDia = (SELECT redondearA2((remBruta / 30)));
SET montoHora = (SELECT redondearA2((montoDia / 8)));
SET montoMin = (SELECT redondearA2((montoHora / 60)));

IF tardanzas_m > 0 THEN
	SET tardanzas_aux = tardanzas_m * montoMin;
ELSE 
	SET tardanzas_aux = 0;
END IF;
    
IF particulares_m > 0 THEN
	SET particulares_aux = particulares_m * montoMin;
ELSE 
	SET particulares_aux = 0;
END IF;

IF lsgh_d > 0 THEN
	SET lsgh_aux = lsgh_d * montoDia;
ELSE 
	SET lsgh_aux = 0;
END IF;

IF faltas_d > 0 THEN
	SET faltas_aux = faltas_d * montoDia;
ELSE 
	SET faltas_aux = 0;    
END IF;

SET concepto_monto = tardanzas_aux + particulares_aux + faltas_aux;
SET concepto_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 82);

IF concepto_monto IS NOT NULL AND concepto_monto > 0 THEN
	IF concepto_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, concepto_monto, NOW(), planilla_id, 82, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = concepto_monto 
		WHERE id = concepto_v;
	END IF;
ELSE 
	IF concepto_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = concepto_v;
    END IF;
END IF;

SET lsgh_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 101);
IF lsgh_aux IS NOT NULL AND lsgh_aux > 0 THEN
	IF lsgh_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, lsgh_aux, NOW(), planilla_id, 101, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = lsgh_aux 
		WHERE id = lsgh_v;
	END IF;
ELSE 
	IF lsgh_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = lsgh_v;
	END IF;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ActualizarPlanilla` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPlanilla`(IN planilla_id INT)
BEGIN
DECLARE remAseg DOUBLE;
DECLARE remNoAseg DOUBLE;
DECLARE totalEgreso DOUBLE;
DECLARE patronal DOUBLE;

SET remAseg = (SELECT RemuneracionAsegurable(planilla_id));
SET remNoAseg = (SELECT RemuneracionNoAsegurable(planilla_id));
SET totalEgreso = (SELECT TotalEgreso(planilla_id));
SET patronal = (SELECT CuotaPatronal(planilla_id));

UPDATE planilla p 
SET 
p.rem_aseg = remAseg, 
p.rem_noaseg = remNoAseg, 
p.total_egreso = totalEgreso,
p.patronal = patronal
WHERE 
p.id = planilla_id
;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ActualizarPlanillaAfp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPlanillaAfp`(IN planilla_id INT)
BEGIN
DECLARE remAseg DOUBLE;
DECLARE ra_Mixta BOOLEAN;

DECLARE pension_c DOUBLE;
DECLARE pension DOUBLE;
DECLARE pension_v INT;

DECLARE snp_c DOUBLE;
DECLARE snp DOUBLE;
DECLARE snp_v INT;

DECLARE jubilacion_c DOUBLE;
DECLARE jubilacion DOUBLE;
DECLARE jubilacion_v INT;

DECLARE seguros_c DOUBLE;
DECLARE seguros DOUBLE;
DECLARE seguros_v INT;

DECLARE ra_c DOUBLE;
DECLARE ra_mix_c DOUBLE;
DECLARE ra DOUBLE;
DECLARE ra_v DOUBLE;

DECLARE tipoPlanilla INT;
DECLARE varerror INT;

DECLARE afp_cursor CURSOR FOR 
(SELECT a.pension, a.snp, a.jubilacion, a.seguros, a.ra, a.ra_mixta, ph.afp_mix FROM planilla p 
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id 
INNER JOIN afp a ON a.id = ph.afp 
WHERE p.id = planilla_id);

OPEN afp_cursor;
FETCH afp_cursor INTO pension_c, snp_c, jubilacion_c, seguros_c, ra_c, ra_mix_c, ra_Mixta;
CLOSE afp_cursor;

SET tipoPlanilla = (SELECT pl.tipo_planilla FROM planilla p
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id 
INNER JOIN plaza pl ON pl.id = ph.plaza_id 
WHERE p.id = planilla_id);

IF tipoPlanilla = 1 OR tipoPlanilla = 4 THEN
SET remAseg = (SELECT RemuneracionAsegurable(planilla_id));
IF pension_c IS NOT NULL AND pension_c > 0 THEN
	SET pension = redondearA2(pension_c * remAseg);
	SET pension_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 75);
	IF pension_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, pension, NOW(), planilla_id, 75, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = pension 
		WHERE id = pension_v;
	END IF;
ELSE 
	SET pension_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 75);
	IF pension_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = pension_v;
    END IF;
END IF;

IF snp_c IS NOT NULL AND snp_c > 0 THEN
	SET snp = redondearA2(snp_c * remAseg);
	SET snp_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 76);
	IF snp_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, snp, NOW(), planilla_id, 76, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = snp 
		WHERE id = snp_v;
	END IF;
ELSE 
	SET snp_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 76);
	IF snp_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = snp_v;
    END IF;
END IF;

IF jubilacion_c IS NOT NULL AND jubilacion_c > 0 THEN
	SET jubilacion = redondearA2(jubilacion_c * remAseg);
	SET jubilacion_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 78);
	IF jubilacion_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, jubilacion, NOW(), planilla_id, 78, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = jubilacion 
		WHERE id = jubilacion_v;
	END IF;
ELSE 
	SET jubilacion_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 78);
	IF jubilacion_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = jubilacion_v;
    END IF;
END IF;

IF seguros_c IS NOT NULL AND seguros_c > 0 THEN
	SET seguros = redondearA2(seguros_c * remAseg);
	SET seguros_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 79);
	IF seguros_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, seguros, NOW(), planilla_id, 79, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = seguros 
		WHERE id = seguros_v;
	END IF;
ELSE 
	SET seguros_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 79);
	IF seguros_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = seguros_v;
    END IF;
END IF;

IF (ra_mix_c IS NOT NULL AND ra_mix_c > 0) OR (ra_c IS NOT NULL AND ra_c > 0) THEN
	IF ra_Mixta = 1 THEN
		SET ra = redondearA2(ra_mix_c * remAseg);
	ELSE
		SET ra = redondearA2(ra_c * remAseg);
	END IF;
	SET ra_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 80);
	IF ra_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, ra, NOW(), planilla_id, 80, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = ra 
		WHERE id = ra_v;
	END IF;
ELSE
    SET ra_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 80);
	IF ra_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = ra_v;
    END IF;
END IF;

SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ActualizarPlanillaFechas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPlanillaFechas`(IN tipo_planilla INT, IN fecha_generacion DATE, IN fecha_pago DATE)
BEGIN
DECLARE varerror INT;
DECLARE anoActual INT;
DECLARE mesActual INT;

SET anoActual = YEAR(NOW());
SET mesActual = MONTH(NOW());

UPDATE planilla p 
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id 
INNER JOIN plaza pl ON pl.id = ph.plaza_id
SET
p.fecha_generacion = fecha_generacion,
p.fecha_pago = fecha_pago
WHERE p.ano_eje = anoActual AND p.mes_eje = mesActual AND pl.tipo_planilla = tipo_planilla;

SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AgregarAfp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarAfp`(IN id CHAR(2), IN nombre VARCHAR(255), IN regimen_pensionario INT,  IN estado BOOLEAN, 
IN snp DOUBLE, IN jubilacion DOUBLE, IN seguros DOUBLE, IN ra DOUBLE, IN pension DOUBLE, IN ra_mixta DOUBLE)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO afp (id, nombre, regimen_pensionario, estado, snp, jubilacion, seguros, ra, pension, ra_mixta)
VALUES (id, nombre, regimen_pensionario, estado, snp, jubilacion, seguros, ra, pension, ra_mixta);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AgregarCondicionLaboral` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarCondicionLaboral`(IN id CHAR(2), IN nombre VARCHAR(255), IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO condicion_laboral(id, nombre, estado)
VALUES(id, nombre, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AgregarGrupoOcupacional` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarGrupoOcupacional`(IN id CHAR(2), IN nombre VARCHAR(255), IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO grupo_ocupacional(grupo_ocupacional, nombre, estado)
VALUES(id, nombre, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AgregarMotivoAnulacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarMotivoAnulacion`(IN id CHAR(2), IN nombre VARCHAR(255), IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO motivo_anulacion(id, nombre, estado)
VALUES(id, nombre, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AgregarRegimenLaboral` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarRegimenLaboral`(IN id INT, IN nombre VARCHAR(255), IN descripcion VARCHAR(255), IN sueldo_minimo DOUBLE, IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO regimen_laboral(id, nombre, descripcion, sueldo_minimo, estado)
VALUES(id, nombre, descripcion, sueldo_minimo, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AgregarRegimenPensionario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarRegimenPensionario`(IN id INT, IN nombre VARCHAR(255), IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO regimen_pensionario(id, nombre, estado)
VALUES(id, nombre, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AgregarTipoDoc` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarTipoDoc`(IN id CHAR(2), IN nombre VARCHAR(255), IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO tipo_doc(id, nombre, estado)
VALUES(id, nombre, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-22  3:10:30

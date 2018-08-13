CREATE DEFINER=`root`@`localhost` FUNCTION `SumaRemNoAsegEsp`(`anoEje` INT, `mesEje` INT, `especifica_id` INT) RETURNS double
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(p.rem_noaseg) FROM planilla p 
WHERE p.ano_eje = anoEje AND p.mes_eje = mesEje AND p.especifica_id = especifica_id);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END
CREATE DEFINER=`root`@`localhost` FUNCTION `SumaConceptoEspSimple`(`anoEje` INT, `mesEje` INT, `especifica_id` INT, `concepto_id` INT) RETURNS double
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(phc.monto) FROM planilla_has_concepto phc
INNER JOIN planilla p ON p.id = phc.planilla_id
WHERE p.ano_eje = anoEje AND p.mes_eje = mesEje AND p.especifica_id = especifica_id AND phc.concepto_id = concepto_id);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END
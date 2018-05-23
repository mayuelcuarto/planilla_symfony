CREATE DEFINER=`root`@`localhost` FUNCTION `SumaRemAseg`(anoEje INT, mesEje INT,tipoPlanilla INT) RETURNS DOUBLE
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(p.rem_aseg) FROM planilla p 
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id
INNER JOIN plaza pl ON pl.id = ph.plaza_id
WHERE p.ano_eje = anoEje AND p.mes_eje = mesEje AND pl.tipo_planilla = tipoPlanilla);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END
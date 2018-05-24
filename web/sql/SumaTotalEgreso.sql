CREATE DEFINER=`root`@`localhost` FUNCTION `SumaTotalEgreso`(anoEje INT, mesEje INT,tipoPlanilla INT, fuenteFinanc INT) RETURNS DOUBLE
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(p.total_egreso) FROM planilla p 
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id
INNER JOIN plaza pl ON pl.id = ph.plaza_id
WHERE p.ano_eje = anoEje AND p.mes_eje = mesEje AND pl.tipo_planilla = tipoPlanilla AND p.fuente_id = fuenteFinanc);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END
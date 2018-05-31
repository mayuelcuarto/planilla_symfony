CREATE DEFINER=`root`@`localhost` FUNCTION `SumaConcepto`(anoEje INT, mesEje INT,tipoPlanilla INT, fuenteFinanc INT, concepto_id INT) RETURNS DOUBLE
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(phc.monto) FROM planilla_has_concepto phc
INNER JOIN planilla p ON p.id = phc.planilla_id
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id
INNER JOIN plaza pl ON pl.id = ph.plaza_id
WHERE p.ano_eje = anoEje AND p.mes_eje = mesEje AND pl.tipo_planilla = tipoPlanilla AND p.fuente_id = fuenteFinanc AND phc.concepto_id = concepto_id);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END
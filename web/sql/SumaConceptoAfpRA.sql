CREATE DEFINER=`root`@`localhost` FUNCTION `SumaConceptoAfpRA`(anoEje INT, mesEje INT,tipoPlanilla INT, fuenteFinanc INT, afp_id INT, concepto_id INT, ra_tipo INT) RETURNS DOUBLE
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(phc.monto) FROM planilla_has_concepto phc
INNER JOIN planilla p ON p.id = phc.planilla_id
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id
INNER JOIN plaza pl ON pl.id = ph.plaza_id
WHERE p.ano_eje = anoEje AND p.mes_eje = mesEje AND pl.tipo_planilla = tipoPlanilla AND p.fuente_id = fuenteFinanc AND ph.afp = afp_id AND phc.concepto_id = concepto_id AND ph.afp_mix = ra_tipo);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END
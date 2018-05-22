CREATE DEFINER=`root`@`localhost` FUNCTION `TotalEgreso`(planilla_id INT) RETURNS DOUBLE
BEGIN
DECLARE aux DOUBLE;
SET aux = (SELECT SUM(phc.monto) FROM planilla_has_concepto phc 
INNER JOIN concepto c ON c.id = phc.concepto_id
WHERE phc.planilla_id = planilla_id AND c.tipo_concepto = 2);
IF aux IS NULL THEN
	SET aux = 0;
END IF;
RETURN redondearA2(aux);
END
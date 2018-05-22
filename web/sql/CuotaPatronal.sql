CREATE DEFINER=`root`@`localhost` FUNCTION `CuotaPatronal`(planilla_id INT) RETURNS DOUBLE
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
END
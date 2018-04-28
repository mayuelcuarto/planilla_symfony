CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPlanilla`(IN planilla_id INT)
BEGIN
DECLARE remAseg DOUBLE;
DECLARE remNoAseg DOUBLE;
DECLARE totalEgreso DOUBLE;

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

DECLARE afp_cursor CURSOR FOR 
(SELECT a.pension, a.snp, a.jubilacion, a.seguros, a.ra, a.ra_mixta, ph.afp_mix FROM planilla p 
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id 
INNER JOIN afp a ON a.id = ph.afp 
WHERE p.id = planilla_id);

SET remAseg = (SELECT RemuneracionAsegurable(planilla_id));
SET remNoAseg = (SELECT RemuneracionNoAsegurable(planilla_id));
SET totalEgreso = (SELECT TotalEgreso(planilla_id));

UPDATE planilla p 
SET 
p.rem_aseg = remAseg, 
p.rem_noaseg = remNoAseg, 
p.total_egreso = totalEgreso,
p.patronal = 0,
p.tardanzas = 0,
p.particulares = 0, 
p.lsgh= 0,
p.faltas = 0
WHERE 
p.id = planilla_id
;

OPEN afp_cursor;
FETCH afp_cursor INTO pension_c, snp_c, jubilacion_c, seguros_c, ra_c, ra_mix_c, ra_Mixta;

IF pension_c IS NOT NULL AND pension_c <> 0 THEN
SET pension = pension_c * remAseg;
SET pension_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 75);
IF pension_v IS NULL THEN
	INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
    VALUES(0, pension, NOW(), planilla_id, 75, 1);
ELSE
	UPDATE planilla_has_concepto
	SET monto = pension 
    WHERE id = pension_v;
END IF;
END IF;

IF snp_c IS NOT NULL AND snp_c <> 0 THEN
SET snp = snp_c * remAseg;
SET snp_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 76);
IF snp_v IS NULL THEN
	INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
    VALUES(0, snp, NOW(), planilla_id, 76, 1);
ELSE
	UPDATE planilla_has_concepto
	SET monto = snp 
    WHERE id = snp_v;
END IF;
END IF;

IF jubilacion_c IS NOT NULL AND jubilacion_c <> 0 THEN
SET jubilacion = jubilacion_c * remAseg;
SET jubilacion_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 78);
IF jubilacion_v IS NULL THEN
	INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
    VALUES(0, jubilacion, NOW(), planilla_id, 78, 1);
ELSE
	UPDATE planilla_has_concepto
	SET monto = jubilacion 
    WHERE id = jubilacion_v;
END IF;
END IF;

IF seguros_c IS NOT NULL AND seguros_c <> 0 THEN
SET seguros = seguros_c * remAseg;
SET seguros_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 79);
IF seguros_v IS NULL THEN
	INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
    VALUES(0, seguros, NOW(), planilla_id, 79, 1);
ELSE
	UPDATE planilla_has_concepto
	SET monto = seguros 
    WHERE id = seguros_v;
END IF;
END IF;

IF (ra_mix_c IS NOT NULL AND ra_mix_c <> 0) OR (ra_c IS NOT NULL AND ra_c <> 0) THEN
	IF ra_Mixta = 1 THEN
		SET ra = ra_mix_c * remAseg;
	ELSE
		SET ra = ra_c * remAseg;
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
END IF;

CLOSE afp_cursor;
END
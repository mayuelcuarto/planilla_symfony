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
END
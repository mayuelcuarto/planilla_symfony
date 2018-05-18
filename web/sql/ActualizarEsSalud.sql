CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarEsSalud`(IN planilla_id INT)
BEGIN
DECLARE remAseg DOUBLE;
DECLARE tipoPlanilla INT;

DECLARE essalud_v INT;
DECLARE essalud DOUBLE;

SET tipoPlanilla = (SELECT pl.tipo_planilla FROM planilla p
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id
INNER JOIN plaza pl ON pl.id = ph.plaza_id
WHERE p.id = planilla_id);

SET remAseg = (SELECT RemuneracionAsegurable(planilla_id));
SET essalud = ROUND(remAseg * 0.04, 2);

IF tipoPlanilla = 2 OR tipoPlanilla = 3 THEN
IF essalud IS NOT NULL AND essalud > 0 THEN
	SET essalud_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 74);
	IF essalud_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, essalud, NOW(), planilla_id, 74, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = essalud 
		WHERE id = essalud_v;
	END IF;
ELSE 
	SET essalud_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 82);
	IF essalud_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = essalud_v;
    END IF;
END IF;
END IF;
END
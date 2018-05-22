CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarInasistencias`(IN planilla_id INT)
BEGIN
DECLARE remAseg DOUBLE;
DECLARE remNoAseg DOUBLE;
DECLARE remBruta DOUBLE;

DECLARE montoDia DOUBLE;
DECLARE montoHora DOUBLE;
DECLARE montoMin DOUBLE;

DECLARE tardanzas_m INT;
DECLARE tardanzas_aux DOUBLE;

DECLARE particulares_m INT;
DECLARE particulares_aux DOUBLE;

DECLARE lsgh_d INT;
DECLARE lsgh_v INT;
DECLARE lsgh_aux DOUBLE;

DECLARE faltas_d INT;
DECLARE faltas_aux DOUBLE;

DECLARE concepto_v INT;
DECLARE concepto_monto DOUBLE;

DECLARE a DOUBLE;
DECLARE b DOUBLE;
DECLARE c DOUBLE;

DECLARE planilla_cursor CURSOR FOR 
(SELECT p.rem_aseg, p.rem_noaseg, p.tardanzas, p.particulares, p.lsgh, p.faltas FROM planilla p 
WHERE p.id = planilla_id);

OPEN planilla_cursor;
FETCH planilla_cursor INTO remAseg, remNoAseg, tardanzas_m, particulares_m, lsgh_d, faltas_d;
CLOSE planilla_cursor;

SET remBruta = remAseg + remNoAseg;

SET montoDia = (SELECT redondearA2((remBruta / 30)));
SET montoHora = (SELECT redondearA2((montoDia / 8)));
SET montoMin = (SELECT redondearA2((montoHora / 60)));

IF tardanzas_m > 0 THEN
	SET tardanzas_aux = tardanzas_m * montoMin;
ELSE 
	SET tardanzas_aux = 0;
END IF;
    
IF particulares_m > 0 THEN
	SET particulares_aux = particulares_m * montoMin;
ELSE 
	SET particulares_aux = 0;
END IF;

IF lsgh_d > 0 THEN
	SET lsgh_aux = lsgh_d * montoDia;
ELSE 
	SET lsgh_aux = 0;
END IF;

IF faltas_d > 0 THEN
	SET faltas_aux = faltas_d * montoDia;
ELSE 
	SET faltas_aux = 0;    
END IF;

SET concepto_monto = tardanzas_aux + particulares_aux + faltas_aux;
SET concepto_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 82);

IF concepto_monto IS NOT NULL AND concepto_monto > 0 THEN
	IF concepto_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, concepto_monto, NOW(), planilla_id, 82, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = concepto_monto 
		WHERE id = concepto_v;
	END IF;
ELSE 
	IF concepto_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = concepto_v;
    END IF;
END IF;

SET lsgh_v = (SELECT phc.id FROM planilla_has_concepto phc WHERE phc.planilla_id = planilla_id AND phc.concepto_id = 101);
IF lsgh_aux IS NOT NULL AND lsgh_aux > 0 THEN
	IF lsgh_v IS NULL THEN
		INSERT INTO planilla_has_concepto(id, monto, fecha_ing, planilla_id, concepto_id, usuario_id)
		VALUES(0, lsgh_aux, NOW(), planilla_id, 101, 1);
	ELSE
		UPDATE planilla_has_concepto
		SET monto = lsgh_aux 
		WHERE id = lsgh_v;
	END IF;
ELSE 
	IF lsgh_v IS NOT NULL THEN
		DELETE FROM planilla_has_concepto WHERE id = lsgh_v;
	END IF;
END IF;
END
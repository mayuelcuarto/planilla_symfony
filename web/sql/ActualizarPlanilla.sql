CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPlanilla`(IN planilla_id INT)
BEGIN
DECLARE remAseg DOUBLE;
DECLARE remNoAseg DOUBLE;
DECLARE totalEgreso DOUBLE;
DECLARE patronal DOUBLE;

SET remAseg = (SELECT RemuneracionAsegurable(planilla_id));
SET remNoAseg = (SELECT RemuneracionNoAsegurable(planilla_id));
SET totalEgreso = (SELECT TotalEgreso(planilla_id));
SET patronal = (SELECT CuotaPatronal(planilla_id));

UPDATE planilla p 
SET 
p.rem_aseg = remAseg, 
p.rem_noaseg = remNoAseg, 
p.total_egreso = totalEgreso,
p.patronal = patronal,
p.tardanzas = 0,
p.particulares = 0, 
p.lsgh= 0,
p.faltas = 0
WHERE 
p.id = planilla_id
;
END
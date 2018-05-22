CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPlanillaFechas`(IN tipo_planilla INT, IN fecha_generacion DATE, IN fecha_pago DATE)
BEGIN
DECLARE varerror INT;
DECLARE anoActual INT;
DECLARE mesActual INT;

SET anoActual = YEAR(NOW());
SET mesActual = MONTH(NOW());

UPDATE planilla p 
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id 
INNER JOIN plaza pl ON pl.id = ph.plaza_id
SET
p.fecha_generacion = fecha_generacion,
p.fecha_pago = fecha_pago
WHERE p.ano_eje = anoActual AND p.mes_eje = mesActual AND pl.tipo_planilla = tipo_planilla;

SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END
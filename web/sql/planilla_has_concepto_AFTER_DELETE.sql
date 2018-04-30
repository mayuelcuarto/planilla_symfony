CREATE DEFINER = CURRENT_USER TRIGGER `planilla2`.`planilla_has_concepto_AFTER_DELETE` AFTER DELETE ON `planilla_has_concepto` FOR EACH ROW
BEGIN
DECLARE planilla_id INT;
SET planilla_id = (SELECT phc.planilla_id FROM planilla_has_concepto phc 
WHERE phc.id = OLD.id);
CALL ActualizarPlanilla(planilla_id);
END
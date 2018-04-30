CREATE DEFINER = CURRENT_USER TRIGGER `planilla2`.`planilla_has_concepto_AFTER_UPDATE` AFTER UPDATE ON `planilla_has_concepto` FOR EACH ROW
BEGIN
DECLARE planilla_id INT;
SET planilla_id = (SELECT phc.planilla_id FROM planilla_has_concepto phc 
WHERE phc.id = NEW.id);
CALL ActualizarPlanilla(planilla_id);
END
CREATE DEFINER = CURRENT_USER TRIGGER `planilla2`.`planilla_has_concepto_AFTER_DELETE` AFTER DELETE ON `planilla_has_concepto` FOR EACH ROW
BEGIN
DECLARE planilla_id INT;
CALL ActualizarPlanilla(OLD.planilla_id);
INSERT INTO planilla_concepto_auditoria(id, planilla_concepto_id, fecha, detalle)
VALUES(0, OLD.id, NOW(),
CONCAT("ELIMINAR -", " CONCEPTO: ", OLD.concepto_id ,", MONTO: ", OLD.monto, ", USUARIO: ", CURRENT_USER)
);
END
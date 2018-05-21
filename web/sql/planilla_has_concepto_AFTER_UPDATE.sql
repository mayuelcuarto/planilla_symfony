CREATE DEFINER = CURRENT_USER TRIGGER `planilla2`.`planilla_has_concepto_AFTER_UPDATE` AFTER UPDATE ON `planilla_has_concepto` FOR EACH ROW
BEGIN
CALL ActualizarPlanilla(NEW.planilla_id);
INSERT INTO planilla_concepto_auditoria(id, planilla_concepto_id, fecha, detalle)
VALUES(0, NEW.id, NOW(),
CONCAT("EDITAR -", " CONCEPTO: ", NEW.concepto_id ,", MONTO: ", NEW.monto, ", USUARIO: ", NEW.usuario_id)
);
END
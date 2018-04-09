CREATE DEFINER = CURRENT_USER TRIGGER `planilla2`.`planilla_AFTER_INSERT` AFTER INSERT ON `planilla` FOR EACH ROW
BEGIN
	INSERT INTO planilla_auditoria (fecha, detalle)
	VALUES (NOW(),CONCAT('Usuario: ',NEW.usuario_id,', Inserción de datos'));
END
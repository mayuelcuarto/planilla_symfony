CREATE DEFINER = CURRENT_USER TRIGGER `planilla2`.`planilla_AFTER_DELETE` AFTER DELETE ON `planilla` FOR EACH ROW
BEGIN
	INSERT INTO planilla_auditoria (planilla_id, fecha, detalle)
	VALUES (OLD.id, NOW(), CONCAT(
    'ELIMINAR - Usuario: ', CURRENT_USER,
    ', REM_ASEG: ', OLD.rem_aseg,
    ', REM_NOASEG: ', OLD.rem_noaseg,
    ', TOTAL_EGRESO: ', OLD.total_egreso,
    ', PATRONAL: ', OLD.patronal,
    ', TARDANZAS: ', OLD.tardanzas,
    ', PARTICULARES: ', OLD.particulares,
    ', LSGH: ', OLD.lsgh,
    ', FALTAS: ', OLD.faltas));	
END
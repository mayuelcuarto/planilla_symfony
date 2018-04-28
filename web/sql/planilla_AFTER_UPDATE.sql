CREATE DEFINER = CURRENT_USER TRIGGER `planilla2`.`planilla_AFTER_UPDATE` AFTER UPDATE ON `planilla` FOR EACH ROW
BEGIN
	INSERT INTO planilla_auditoria (planilla_id, fecha, detalle)
	VALUES (NEW.id, NOW(), CONCAT(
    'REM_ASEG: ', NEW.rem_aseg,
    ', REM_NOASEG: ', NEW.rem_noaseg,
    ', TOTAL_EGRESO: ', NEW.total_egreso,
    ', PATRONAL: ', NEW.patronal,
    ', TARDANZAS: ', NEW.tardanzas,
    ', PARTICULARES: ', NEW.particulares,
    ', LSGH: ', NEW.lsgh,
    ', FALTAS: ', NEW.faltas));	
END
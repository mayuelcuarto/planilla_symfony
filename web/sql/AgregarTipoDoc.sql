CREATE DEFINER=`root`@`localhost` PROCEDURE  `planilla2`.`AgregarTipoDoc`(IN id CHAR(2), IN nombre VARCHAR(255), IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO tipo_doc(id, nombre, estado)
VALUES(id, nombre, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END
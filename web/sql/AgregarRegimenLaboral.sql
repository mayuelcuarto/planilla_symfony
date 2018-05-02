CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarRegimenLaboral`(IN id INT, IN nombre VARCHAR(255), IN descripcion VARCHAR(255), IN sueldo_minimo DOUBLE, IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO regimen_laboral(id, nombre, descripcion, sueldo_minimo, estado)
VALUES(id, nombre, descripcion, sueldo_minimo, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END
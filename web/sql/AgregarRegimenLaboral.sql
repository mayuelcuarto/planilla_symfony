DELIMITER $$

DROP PROCEDURE IF EXISTS `planilla2`.`AgregarRegimenLaboral`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE  `planilla2`.`AgregarRegimenLaboral`(IN id INT, IN nombre VARCHAR(255), IN descripcion VARCHAR(255), IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO regimen_laboral(id, nombre, descripcion, estado)
VALUES(id, nombre, descripcion, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END $$

DELIMITER ;
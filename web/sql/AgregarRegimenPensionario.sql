DELIMITER $$

DROP PROCEDURE IF EXISTS `planilla2`.`AgregarRegimenPensionario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE  `planilla2`.`AgregarRegimenPensionario`(IN id INT, IN nombre VARCHAR(255), IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO regimen_pensionario(id, nombre, estado)
VALUES(id, nombre, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END $$

DELIMITER ;
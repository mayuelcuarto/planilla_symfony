CREATE DEFINER=`root`@`localhost` PROCEDURE  `planilla2`.`AgregarAfp`
(IN id CHAR(2), IN nombre VARCHAR(255), IN regimen_pensionario INT,  IN estado BOOLEAN, 
IN snp DOUBLE, IN jubilacion DOUBLE, IN seguros DOUBLE, IN ra DOUBLE, IN pension DOUBLE, IN ra_mixta DOUBLE)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO afp (id, nombre, regimen_pensionario, estado, snp, jubilacion, seguros, ra, pension, ra_mixta)
VALUES (id, nombre, regimen_pensionario, estado, snp, jubilacion, seguros, ra, pension, ra_mixta);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END
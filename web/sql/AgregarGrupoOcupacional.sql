CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarGrupoOcupacional`(IN id CHAR(2), IN nombre VARCHAR(255), IN estado BOOLEAN)
BEGIN
DECLARE varerror INTEGER;
INSERT INTO grupo_ocupacional(grupo_ocupacional, nombre, estado)
VALUES(id, nombre, estado);
SET varerror = (SELECT @@error_count);
IF varerror = 0 THEN
COMMIT;
ELSE
ROLLBACK;
END IF;
END
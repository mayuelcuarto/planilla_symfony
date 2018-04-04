CREATE FUNCTION `GenerarSecPlazaHistorial` (plazaId INT) RETURNS INT
BEGIN
	DECLARE aux INT;
    SET aux = (SELECT MAX(sec_personal) FROM plaza_historial WHERE plaza_id = plazaId) + 1;
    RETURN aux;
END
CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirRegimenLaboral`() RETURNS int(11)
BEGIN
DECLARE aux INTEGER;
SET aux = (SELECT MAX(id) FROM regimen_laboral) + 1;
RETURN aux;
END
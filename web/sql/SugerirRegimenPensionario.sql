CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirRegimenPensionario`() RETURNS int(11)
BEGIN
DECLARE aux INTEGER;
SET aux = (SELECT MAX(id) FROM regimen_pensionario) + 1;
RETURN aux;
END
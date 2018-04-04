CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirCondicionLaboral`() RETURNS char(2) CHARSET latin1
BEGIN
DECLARE aux INT;
DECLARE aux2 CHAR(2);
SET aux = (SELECT MAX(id) FROM condicion_laboral) + 1;
IF aux < 10 THEN
SET aux2 = CONCAT('0',aux);
ELSE
SET aux2 = aux;
END IF;
RETURN aux2;
END
CREATE DEFINER=`root`@`localhost` FUNCTION  `planilla2`.`SugerirTipoDoc`() RETURNS CHAR(2)
BEGIN
DECLARE aux INT;
DECLARE aux2 CHAR(2);
SET aux = (SELECT MAX(id) FROM tipo_doc) + 1;
IF aux < 10 THEN
SET aux2 = CONCAT('0',aux);
ELSE
SET aux2 = aux;
END IF;
RETURN aux2;
END
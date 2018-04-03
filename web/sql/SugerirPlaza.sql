CREATE DEFINER=`root`@`localhost` FUNCTION `SugerirPlaza`(tipoPlanilla INT) RETURNS char(6) CHARSET latin1
BEGIN
DECLARE aux INT;
DECLARE aux2 CHAR(6);
SET aux = (SELECT MAX(p.num_plaza) FROM plaza p WHERE p.tipo_planilla = tipoPlanilla) + 1;
IF aux >= 100000 THEN
SET aux2 = aux;
ELSEIF aux >= 10000 THEN
SET aux2 = CONCAT('0',aux);
ELSEIF aux >= 1000 THEN
SET aux2 = CONCAT('00',aux);
ELSEIF aux >= 100 THEN
SET aux2 = CONCAT('000',aux);
ELSEIF aux >= 10 THEN
SET aux2 = CONCAT('0000',aux);
ELSE
SET aux2 = CONCAT('00000',aux);
END IF;
RETURN aux2;
END
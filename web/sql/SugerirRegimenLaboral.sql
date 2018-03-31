DELIMITER $$

DROP FUNCTION IF EXISTS `planilla2`.`SugerirRegimenLaboral`$$
CREATE DEFINER=`root`@`localhost` FUNCTION  `planilla2`.`SugerirRegimenLaboral`() RETURNS INT
BEGIN
DECLARE aux INTEGER;
SET aux = (SELECT MAX(id) FROM regimen_laboral) + 1;
RETURN aux;
END $$

DELIMITER ;
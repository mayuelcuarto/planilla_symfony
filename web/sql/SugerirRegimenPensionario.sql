DELIMITER $$

DROP FUNCTION IF EXISTS `planilla2`.`SugerirRegimenPensionario`$$
CREATE DEFINER=`root`@`localhost` FUNCTION  `planilla2`.`SugerirRegimenPensionario`() RETURNS INT
BEGIN
DECLARE aux INTEGER;
SET aux = (SELECT MAX(id) FROM regimen_pensionario) + 1;
RETURN aux;
END $$

DELIMITER ;
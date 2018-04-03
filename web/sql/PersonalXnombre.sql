CREATE PROCEDURE `PersonalXnombre` (IN var_personal VARCHAR(255), OUT var_plaza json)
BEGIN
	DECLARE var_table_personal json;
    SET var_table_personal = (SELECT * FROM personal pe WHERE pe.apellidoPaterno LIKE '%var_personal%' OR pe.apellidoMaterno LIKE '%var_personal%' OR pe.nombre LIKE '%var_personal%');
RETURN var_table_personal;
END

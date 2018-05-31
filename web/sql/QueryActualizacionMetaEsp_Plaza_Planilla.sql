UPDATE planilla p
INNER JOIN plaza_historial ph ON ph.id = p.plaza_historial_id
INNER JOIN plaza pl ON pl.id = ph.plaza_id
SET p.sec_func = pl.sec_func, p.especifica_id = pl.especifica_id
WHERE p.ano_eje = 2018 AND p.mes_eje = 5;
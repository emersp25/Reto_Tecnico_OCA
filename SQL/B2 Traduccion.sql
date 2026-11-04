--Traducción MySQL a SQL Server

SELECT id, nombre
FROM clientes
ORDER BY nombre
OFFSET 40 ROWS FETCH NEXT 20 ROWS ONLY;
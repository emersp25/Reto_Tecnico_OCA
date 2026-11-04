-- Top 5 clientes que más pagaron en los últimos 90 días
SELECT TOP 5 c.id, c.nombre, c.nit, SUM(p.monto) AS total_pagado
FROM clientes c
JOIN pagos p ON p.cliente_id = c.id
WHERE p.fecha >= DATEADD(DAY, -90, GETDATE())
GROUP BY c.id, c.nombre, c.nit
ORDER BY total_pagado DESC;



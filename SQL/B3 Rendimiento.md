B3. Consulta lenta por fecha_pago

Enunciado: Una consulta que filtra pagos por fecha_pago se volvió lenta al crecer la tabla a varios millones de filas. ¿Qué revisarías y qué harías, en orden?

1. Empezaria viendo el plan de ejecución, preguntandome que ahce scan en toda la tabla?
2. Revisiaria si existe un indice en fecha_pago, si no existe entonces lo crearia.
3. Revisaria que el WHERE no tape el indice (YEAR(fecha_pago) = 2026, CONVERT, etc.); también usar rangos: fecha_pago >= '2026-01-01' AND fecha_pago < '2027-01-01' y asi segmentamos en la busqueda en vez de todo el historial.
4. Actualizar estadisticas
5. Traer solo las columnas necesarias
6. Si a pesar de todo lo anterior sigue lento lo mejor seria particionar o archivas pagos viejos para que las consultas sean más actuales y más rapidas de procesar.

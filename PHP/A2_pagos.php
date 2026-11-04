<?php
class Pagos {
    private $db; //el wrapper de PDO

    public function __construct($db){
        $this->db = $db;
    }

    public function registrarPago($clienteId, $monto, $formaPago){
        // Validar antes de tocar la base de datos
        // si el monto no es un numero o es 0 o negativo, ni siquiera abirmos la transacción

        if (!is_numeric($monto) || $monto <= 0) {

            throw new InvalidArgumentException("Monto inválido: debe ser mayor a cero.");
        }

        // Abir la transacción
        $this->db->beginTransaction();

        try {
            // Preparamos el insert con "?" en lugar de pegar los valores en el texto, esto evita la inyección SQL
            $stmt = $this->db->prepare (
                "INSERT INTO pagos (cliente_id, monto, forma_pago, fecha_pago) VALUES (?, ?, ?, ?)"
            );

            // Ejecutamos cada "?" se reemplaza en orden por un valor del arreglo
            $stmt->execute([$clienteId, $monto, $formaPago, date('Y-m-d H:i:s')]);

            // Pedir el ID que la BD le asigno al pago recien insertado
            $id = $this->db->lastInsertId();

            // Si todo salio bien, confirmamos la transacción y guardamos definitivamente los cambios
            $this->db->commit();

            return $id; // devolvemos el ID del pago registrado
        } catch (Exception $e) {
            // Si algo salio mal, deshacemos todo lo que se hizo en la transacción
            $this->db->rollBack();
            throw $e; // re-lanzamos la excepción para que el llamador la maneje
        }
    }
}
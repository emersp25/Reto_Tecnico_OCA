<?php
// Problemas del original:
// - SQL injection (variables metidas directo en el SQL)
// - la clave se compara en texto plano
// - el die() le muestra el SQL completo al usuario
function login($usuario, $clave) {
    global $conn; // conexión PDO

    $stmt = $conn->prepare("SELECT id, nombre, clave FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($clave, $row['clave'])) {
        unset($row['clave']); // no devolver el hash
        return $row;
    }

    die("Error: usuario o clave incorrectos."); // mensaje genérico, sin el query
}

<?php
// Problemas del original:
// 1. Si pagó antes de la fecha de vencimiento devolvia un numero negativo, lo cual no tiene sentido porque no habria mora
// 2. Dividir segundos entre 86400 da decimales cuando las fechas traen horas, minutos y segundos, lo cual no tiene sentido porque la mora se calcula en dias completos

function diasMora($fechaVencimiento, $fechaPago){
    $venc = new DateTime($fechaVencimiento);
    $pago = new DateTime($fechaPago);
    $venc->setTime(0, 0); // comprar solo la fecha, no la hora
    $pago->setTime(0, 0);
    $dias = (int) $venc->diff($pago)->format('%r%a');
    return max(0, $dias); // si es negativo devolvemos 0
}


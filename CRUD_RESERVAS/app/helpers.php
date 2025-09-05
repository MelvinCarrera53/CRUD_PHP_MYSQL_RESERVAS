<?php
// app/helpers.php

function limpiar($str)
{
    return trim(filter_var($str, FILTER_SANITIZE_STRING));
}
function es_fecha_valida($fecha)
{
    $d = DateTime::createFromFormat('Y-m-d', $fecha);
    return $d && $d->format('Y-m-d') === $fecha;
}
function es_hora_valida($hora)
{
    $d = DateTime::createFromFormat('H:i', $hora);
    return $d && $d->format('H:i') === $hora;
}
<?php

include_once('../../config/config.php');
include_once('../../class/Reserva.php');
session_start(); // Iniciar la sesión
// Si no es una solicitud POST, manejar la recuperación de datos
try {
    // Realiza la consulta SQL
    $reserva = new Reserva();
    $buscarReservas = $reserva->searchReservas(); // Recuperar las reservas
    // Procesar los datos antes de convertirlos a JSON
    foreach ($buscarReservas as &$reserva) { // Usamos referencia (&) para modificar directamente el array
        $reserva['title'] = htmlspecialchars($reserva['title'], ENT_QUOTES, 'UTF-8');
        $reserva['start'] = htmlspecialchars($reserva['start'], ENT_QUOTES, 'UTF-8');
        $reserva['end'] = htmlspecialchars($reserva['end'], ENT_QUOTES, 'UTF-8');
        $reserva['realizada'] = htmlspecialchars($reserva['realizada'], ENT_QUOTES, 'UTF-8');
    }
    unset($reserva); // Eliminar la referencia al último elemento
    // Convertir a JSON y devolver la respuesta
    header('Content-Type: application/json');
    echo json_encode($buscarReservas, JSON_UNESCAPED_UNICODE);
    exit;
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['error' => $e->getMessage()]);
}

?>

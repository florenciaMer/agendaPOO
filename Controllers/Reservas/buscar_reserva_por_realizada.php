<?php

include_once('../../config/config.php');
include_once('../../class/Reserva.php');
include_once('../../class/Paciente.php');

$fecha = $_GET['fecha'];
$hora = $_GET['hora'];
$nombre = $_GET['nombre'];
$apellido = $_GET['apellido'];

$paciente = new Paciente();
$datos_paciente = $paciente->searchIdPacienteByNombreApellido($nombre, $apellido);
$id_paciente = $datos_paciente['id_paciente'];

session_start(); // Iniciar la sesión
// Si no es una solicitud POST, manejar la recuperación de datos
try {
    // Realiza la consulta SQL
    $reserva = new Reserva();
    $buscarReserva = $reserva->searchReservaPorRealizada($fecha, $hora, $id_paciente); // Recuperar las reservas
    // Procesar los datos antes de convertirlos a JSON
    if ($buscarReserva) {
        echo json_encode($buscarReserva, JSON_UNESCAPED_UNICODE);
        exit;
        
    } 
   
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['error' => $e->getMessage()]);
}

?>
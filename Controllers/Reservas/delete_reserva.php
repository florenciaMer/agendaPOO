<?php

include_once '../../config/config.php';
include_once '../../class/Reserva.php';

// Retrieve GET parameters
$fecha = $_GET['fecha'];
$hora = $_GET['hora'];

// Set the values to be updated
$estado = 0;


// Assuming $fechaHora is defined somewhere or needs to be created based on the current timestamp
$fyh_actualizacion = date('Y-m-d H:i:s'); // Current timestamp

$reserva = new Reserva();

$result = $reserva->deleteReserva($fecha, $hora, $estado, $fyh_actualizacion);
// Prepare the SQL statement

if ($result) {
    session_start();
    $_SESSION['mensaje'] = 'Se eliminó la cita correctamente';
    $_SESSION['icono'] = 'success';

    // Redirect after success
    echo '<script> location.href = "' . app_url . '";</script>';
} else {
    echo 'No se eliminó de la manera correcta';
    echo '<script> location.href = "' . app_url . '";</script>';
}

?>

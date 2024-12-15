<?php

include_once '../../config/config.php';
include_once '../../class/Paciente.php';
include_once '../../class/Reserva.php';

// Recupera los parámetros
$title_anterior = $_GET['title_anterior'];
$title_nuevo = $_GET['title_nuevo'];
$fecha = $_GET['fecha'];
$fecha_inicial = $_GET['fecha_inicial'];
$hora = $_GET['hora'];
$hora_inicial = $_GET['hora_inicial'];
$nombre = $_GET['nombre'];
$apellido = $_GET['apellido'];
$fyh_actualizacion = $fechaHora;
$start = $fecha;
$end = $fecha;
$horaInicial = $hora;
$minutoAnadir = 39;

$segundos_horaInicial = strtotime($horaInicial) + 2400;
$horaFinal = date('H:i:s', $segundos_horaInicial);
$end_time = date('H:i:s', strtotime($horaFinal));
$horaFinal;

// Busca el paciente
$paciente = new Paciente();
$datos_paciente = $paciente->searchIdPacienteByNombreApellido($nombre, $apellido);
$id_paciente = $datos_paciente['id_paciente'];


// Verifica si el paciente se encuentra
if (!$id_paciente) {
    echo "Paciente no encontrado";
    exit;
}

// Actualiza la reserva
$reserva = new Reserva();
$result = $reserva->updateFechaReserva($fecha_inicial, $fecha, $hora_inicial, $hora, $title_nuevo, $start, $end, $fyh_actualizacion, $id_paciente);

// Verifica si la actualización fue exitosa
if ($result) {
    session_start();
    $_SESSION['mensaje'] = 'Cita modificada con éxito';
    $_SESSION['icono'] = 'success';
    echo "<script> location.href = '" . app_url . "/index.php'</script>";
} else {
    session_start();
    $_SESSION['mensaje'] = 'La cita no pudo ser modificada';
    $_SESSION['icono'] = 'error';
    echo "<script> location.href = '" . app_url . "/index.php'</script>";
}

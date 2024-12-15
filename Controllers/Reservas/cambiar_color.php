<?php
include_once('../../config/config.php');
include_once('../../class/Reserva.php');
include_once('../../class/Paciente.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha = $_POST['fecha'];
    
    $paciente = new Paciente();
    $datos_paciente = $paciente->searchIdPacienteByNombreApellido($nombre, $apellido);
    $id_paciente = $datos_paciente['id_paciente'];
    
    $backgroundColor = $_POST['backgroundColor'];
    $borderColor = $_POST['borderColor'];

    $reserva = new Reserva();
    $result = $reserva->changeTitleColor($background, $borderColor, $fyh_actualizacion, $fecha, $hora, $id_paciente);

    session_start();

    if ($result) {
        $_SESSION['mensaje'] = 'El cambio se efectuó de manera exitosa';
        $_SESSION['icono'] = 'success';
        header('Location:' . app_url . '/index.php');
    } else {
        $_SESSION['mensaje'] = 'El cambio no pudo ser efectuado';
        $_SESSION['icono'] = 'error';
        header('Location:' . app_url . '/index.php');
    }
}
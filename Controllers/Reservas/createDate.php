<?php 
include_once('../../config/config.php');
include_once('../../class/Paciente.php');
include_once('../../class/Reserva.php');

$id_paciente = $_POST['id_paciente'];
$fecha_cita = $_POST['fecha_cita'];
$hora_cita = date('H-i-s');
$hora_cita = $_POST['hora_cita'];
$start = $fecha_cita . ' ' . $hora_cita;
$end_time = $hora_cita ;
$horaInicial=$hora_cita;
$minutoAnadir=40;
$segundos_horaInicial=strtotime($horaInicial)+2400;
$horaFinal=date('H:i:s', $segundos_horaInicial);
$end_time=date('H:i:s',strtotime($horaFinal));
$background = "#3788d8";
$color = "#3788d8";

$end = $fecha_cita . ' ' . $end_time;
$fyh_creacion = $fechaHora;
$estado = 1;

$paciente = new Paciente();
$buscarNombreApellido = $paciente->searchPaciente($id_paciente);


if ($buscarNombreApellido) {
    $nombre = $buscarNombreApellido['nombre'];
    $apellido = $buscarNombreApellido['apellido'];
    $title = $hora_cita . '-' . $nombre . '-' . $apellido ;
} else {
    session_start();
    $_SESSION['mensaje'] = 'Paciente no encontrado';
    $_SESSION['icono'] = 'error';
    header('Location:' . app_url . '/index.php');
    exit();
}

//busco no exista una reserva ya para ese paciente para ese dia
$reserva = new Reserva();
$existeReserva = $reserva->searchPacienteXFechaHoraReserva($id_paciente, $fecha_cita, $estado, $hora_cita, $end_time);


if ($existeReserva > 0) {
    session_start();
    $_SESSION['mensaje'] = 'Ya existe una cita para ese día';
    $_SESSION['icono'] = 'error';
    ?>
    <script>
        window.history.back();
    </script>
    <?php
} else {
    // Insert new reservation
   $resultado = $reserva->insertReserva($id_paciente, $fecha_cita, $hora_cita, $title, $start, $end, $fyh_creacion, $estado, $background, $color);

    session_start();
    if ($resultado) {
        $_SESSION['mensaje'] = 'La cita se registró de la manera correcta';
        $_SESSION['icono'] = 'success';
        header('Location:' . app_url . '/index.php');
    } else {
       
        $_SESSION['mensaje'] = 'Error al registrar la cita';
        $_SESSION['icono'] = 'error';
        ?>
        <script>
            window.history.back();
        </script>
        <?php
    }
}
?>

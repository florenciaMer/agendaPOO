<?php

include_once '../../config/config.php';
include_once '../../class/Reserva.php';

// Recuperar los parámetros GET
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$hora = isset($_GET['hora']) ? $_GET['hora'] : '';
$title = isset($_GET['title_nuevo']) ? $_GET['title_nuevo'] : '';
$title_anterior = isset($_GET['title_anterior']) ? $_GET['title_anterior'] : '';

// Asegúrate de que todos los valores sean los esperados y están definidos
if ($title_anterior == '') {
    echo json_encode(['status' => 'error', 'message' => 'Title anterior no está definido']);
    exit();
}

// Establecer el valor a actualizar
$estado = 0;

$reserva = new Reserva();
//valida no exista otra cita para ese momento

$cuenta = $reserva->searchReservaMismaFechaHora($fecha, $hora);

if ($cuenta > 0) {
    session_start();
    $_SESSION['mensaje'] = 'Ya existe una cita para ese día en ese horario';
    $_SESSION['icono'] = 'error';
    ?>
    <script> location.href = "<?php echo app_url; ?>/index.php"</script>
   <?php
    exit; 
}else{


    // Obtener la fecha y hora actuales
    $fyh_actualizacion = date('Y-m-d H:i:s'); // Timestamp actual

    $resultado = $reserva->updateReserva($hora, $title, $fyh_actualizacion, $fecha, $title_anterior);
    // Preparar la consulta SQL

// Ejecutar la consulta y verificar el resultado
if ($resultado) {
    session_start();
    $_SESSION['mensaje'] = 'Se modificó correctamente la cita';
    $_SESSION['icono'] = 'success';
    ?>
    <script> location.href = "<?php echo app_url; ?>/index.php"</script>
   <?php
    exit; 
} else {
echo json_encode(['status' => 'error']);
}
}
?>

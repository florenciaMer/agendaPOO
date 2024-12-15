<?php
include_once('../../config/config.php');
include_once('../../class/Paciente.php');
include_once('../../class/Reserva.php');

$fecha = $_GET['fecha_cita'];
$hora= $_GET['hora_cita'];
$nombre= $_GET['nombre'];
$apellido= $_GET['apellido'];
$fyh_actualizacion = $fechaHora;

$paciente = new Paciente();
$datos_paciente = $paciente->searchIdPacienteByNombreApellido($nombre, $apellido);
$id_paciente = $datos_paciente['id_paciente'];

$realizada = $_GET['realizada'];
$backgroundColor= $_GET['color'];
$color= $_GET['color'];

$reserva = new Reserva();
$result = $reserva->updateRealizadaONoRealizada($realizada, $fyh_actualizacion, $backgroundColor, $borderColor, $fecha, $hora, $id_paciente);

// Execute the statement
if($result){
session_start();
//$_SESSION['confirmada'] = 1;
$_SESSION['mensaje'] = 'Se efectuó el cambio con éxito';
$_SESSION['icono'] = 'success';
?>
<script> location.href = "<?php echo app_url; ?>/index.php?"</script>
<?php 
}else{
session_start();
//$_SESSION['confirmada'] = 0;
$_SESSION['mensaje'] = 'La cita no pudo ser modificada';
$_SESSION['icono'] = 'error';
?>
<script> location.href = "<?php echo app_url; ?>/index.php"</script>
<?php 
}

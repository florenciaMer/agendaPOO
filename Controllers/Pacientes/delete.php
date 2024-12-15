<?php

include_once '../../config/config.php';
include_once '../../class/Paciente.php';

$id_paciente = $_GET['id_paciente'];
$estado = 0;

if (!$id_paciente) {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID del paciente no especificado',
    ]);
    exit;
}

$paciente = new Paciente();
$buscarEnValores = $paciente->searchValoresDePaciente($id_paciente); // Verifica si hay valores asociados

if ($buscarEnValores > 0) {
    // Respuesta si hay valores asociados
    session_start();
    $_SESSION['mensaje'] = 'No es posible eliminar al paciente debido a que tiene una lista de valores asociada';
    $_SESSION['icono'] = 'error';
    
    
    ?>
    <script> location.href = "<?php echo app_url; ?>../view/pacientes/index.php"</script>
   
     <?php
}else{
    //busca si el paciente a eliminar tiene alguna reserva de la fecha actual en adelante
    $buscarEnReservar = $paciente->searchReservasDePaciente($id_paciente, $fechaHora);
    if($buscarEnReservar){
        session_start();
        $_SESSION['mensaje'] = 'No es posible eliminar al paciente debido a que tiene una reserva asignada proximamente';
        $_SESSION['icono'] = 'error';
    
    
    ?>
    <script> location.href = "<?php echo app_url; ?>../view/pacientes/index.php"</script>
    <?php
    }else{
        //se elimina al paciente ya que no tiene reservas ni listas de valores asociadas
        $paciente->deletePaciente($id_paciente, $estado);
        session_start();
        $_SESSION['mensaje'] = ' Se eliminó al paciente de manera correcta ';
        $_SESSION['icono'] = 'success';
    
    
    ?>
    <script> location.href = "<?php echo app_url; ?>../view/pacientes/index.php"</script>
    <?php }
}

?>
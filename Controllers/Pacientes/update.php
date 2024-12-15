<?php
include_once('../../class/Paciente.php');

$id_paciente = $_POST['id_paciente']?? null;
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$celular = $_POST['celular'];
$email = $_POST['email'];
$fyh_actualizacion = $fechaHora;  // Asegúrate de que $fechaHora esté definido
$estado = $_POST['estado'];
$cuenta = 0;

$paciente = new Paciente();

// Validar si existe un paciente con el mismo email
$exist = $paciente->searchPacienteByEmailPaciente($email, $id_paciente);

session_start();
if ($exist) {
    $_SESSION['mensaje'] = "Ya existe otro paciente con el mismo email";
    $_SESSION['icono'] = "error";
    header('Location: ../../view/pacientes');
    exit;
}else{

    try {
        // Intentamos actualizar el paciente
        $resultado = $paciente->updatePaciente($nombre, $apellido, 
        $direccion,$telefono, $celular,
         $email, $fyh_actualizacion, $estado, $id_paciente);
        
        
        // Verificamos si la actualización fue exitosa
        if ($resultado) {
            $_SESSION['mensaje'] = "El paciente ha sido actualizado correctamente";
            $_SESSION['icono'] = "success";
            header('Location: ../../view/pacientes/index.php');
            exit;
        } else {
            $_SESSION['mensaje'] = "No se pudo realizar la actualización del paciente";
            $_SESSION['icono'] = "error";
            header('Location: ../../view/pacientes');
            exit;
        }
    } catch (Exception $e) {
        // Capturamos cualquier error y mostramos el mensaje
        echo 'Error: ' . $e->getMessage();
    }
}
?>

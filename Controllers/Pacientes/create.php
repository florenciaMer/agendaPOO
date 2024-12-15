<?php
require_once('../../class/Paciente.php');

try {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $celular = $_POST['celular'];
    $fyh_creacion = date('Y-m-d H:i:s'); // Fecha y hora actual
    
    $Paciente = new Paciente();
    $result = $Paciente->searchPaciente($email);
    
    session_start();
    if ($result) {
        $_SESSION['mensaje'] = "Error: ya existe un paciente con ese email en la base de datos";
        $_SESSION['icono'] = "error";
        echo "<script>
        window.history.back(); // Regresa a la página anterior
        </script>";
        exit();
    } else {
        // Crear el paciente
        $Paciente->insertPaciente($nombre, $apellido, $direccion, $telefono, $celular, $email, $fyh_creacion);
        
        // Redirigir a index.php si la inserción es exitosa
        $_SESSION['mensaje'] = "Paciente registrado exitosamente";
        $_SESSION['icono'] = "success";
        header("Location: ../../view/pacientes/index.php");
        exit();
    }
} catch (Exception $e) {
    // Manejo de errores
    echo "<script>
        alert('Error: " . $e->getMessage() . "');
        window.history.back();
    </script>";
}

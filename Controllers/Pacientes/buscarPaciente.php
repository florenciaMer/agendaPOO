<?php
require_once('../../class/Paciente.php');


try {
    $id_paciente = $_POST['id_paciente'] ?? null;  // Verifica que esto no sea null
    /*if (!$id_paciente) {
        $_SESSION['mensaje'] = "El id del paciente es requerido";
        $_SESSION['icono'] = "error";
        header('Location: ../../view/pacientes');
        exit;
    }*/

    $paciente = new Paciente();
    $pacientes_datos = $paciente->searchPaciente($id); // Obtener todos del paciente
    
    if (empty($pacientes_datos)) {
        
        $_SESSION['mensaje'] = "No hay pacientes registrados para ese id";
        $_SESSION['icono'] = "error";
        header('Location: ../../view/pacientes/index.php');
        exit;
    }
} catch (Exception $e) {
    echo "<script>
        alert('Error al listar el paciente: " . $e->getMessage() . "');
        window.history.back();
    </script>";
    exit;
}

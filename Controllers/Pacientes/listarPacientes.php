<?php
require_once __DIR__ . '/../../class/Paciente.php';
try {
    $paciente = new Paciente();
    $pacientes_datos = $paciente->searchPacientes(); // Obtener todos los pacientes

    if (empty($pacientes_datos)) {
        session_start();
        $_SESSION['mensaje'] = "No hay pacientes registrados de momento";
        $_SESSION['icono'] = "error";
        header('Location: ../../index.php');
        exit;
    }
} catch (Exception $e) {
    echo "<script>
        alert('Error al listar pacientes: " . $e->getMessage() . "');
        window.history.back();
    </script>";
    exit;
}


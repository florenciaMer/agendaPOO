<?php
require_once('../../class/Valores.php');

try {
    $valor = new Valor();
    $valores_datos = $valor->searchValoresPacientes(); // Obtener todos los pacientes
    
    
    
} catch (Exception $e) {
    echo "<script>
        alert('Error al listar los valores: " . $e->getMessage() . "');
        window.history.back();
    </script>";
    exit;
}


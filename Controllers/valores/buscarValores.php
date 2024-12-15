<?php
require_once('../../class/Valores.php');


try {
    $id_valor = $_POST['id_valor'] ?? null;  // Verifica que esto no sea null
    /*if (!$id_valor) {
        $_SESSION['mensaje'] = "El id del valor es requerido";
        $_SESSION['icono'] = "error";
        header('Location: ../../view/valors');
        exit;
    }*/

    $valor = new valor();
    $valores_datos = $valor->searchValor($id); // Obtener todos del valor
    
    if (empty($valores_datos)) {
        
        $_SESSION['mensaje'] = "Ese valor se encuentra aplicado a una facturación";
        $_SESSION['icono'] = "error";
        header('Location: ../../view/valores/index.php');
        exit;
    }
} catch (Exception $e) {
    echo "<script>
        alert('Error al listar el valor: " . $e->getMessage() . "');
        window.history.back();
    </script>";
    exit;
}
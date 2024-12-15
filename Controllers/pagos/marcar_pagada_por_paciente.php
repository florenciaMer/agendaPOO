<?php

include_once('../../config/config.php');
include_once('../../class/Pago.php');
session_start();
// Obtener datos de las citas no facturadas (POST o GET)
$citas_no_pagadas = $_POST['citas_no_pagadas'] ?? $_GET['id_cita'] ?? null;


// Verificar si hay citas seleccionadas
if (!empty($citas_no_pagadas)) {
    // Convertir a array si es necesario
    if (!is_array($citas_no_pagadas)) {
        $citas_no_pagadas = [$citas_no_pagadas];
    }
    // Crear placeholders para la consulta SQL
    $placeholders = implode(',', array_fill(0, count($citas_no_pagadas), '?'));
    try {
        // Instancia de la clase Factura
        $pago = new Pago();

        // Verificar si las citas tienen precio asignado
        $pagado = $pago->setPagoPorPaciente($citas_no_pagadas, $placeholders);
        if ($pagado) {
            // Si tienen precio, se realiza la facturación
            // Mensaje de éxito
            $_SESSION['mensaje'] = "Se realizó el pago correctamente.";
            $_SESSION['icono'] = "success";
            header('Location: ../../view/pagar/index.php');
        } else {
            // Si no tienen precio, no se realiza la facturación
            $_SESSION['mensaje'] = "No se registro el pago debido a que la cita no tiene un precio asignado.";
            $_SESSION['icono'] = "error";
            header('Location: ../../view/pagar/index.php');
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        die(); // Detener la ejecución para investigar
    }
}
?>

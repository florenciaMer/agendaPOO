<?php

include_once('../../config/config.php');
include_once('../../class/Factura.php');

$id_paciente = $_POST['id_paciente'];
$desde = $_POST['desde'];  // Ya está en formato yyyy-mm-dd
$hasta = $_POST['hasta'];  // Ya está en formato yyyy-mm-dd


try {
    // Crear una instancia de la clase Cita
    $citas = new Factura();
    // Obtener las citas no pagadas
    $citas_datos = $citas->searchCitasFacturadasPorPaciente($id_paciente, $desde, $hasta);
    
    session_start();
    // Asegurarse de que $citas_datos tiene los datos que esperamos
    if (empty($citas_datos)) {
        echo json_encode(['error' => 'No se encontraron citas no pagadas o no se encuentran facturadas aun.']);
        exit;
    }

    // Limpiar los datos antes de pasarlos
    foreach ($citas_datos as &$cita) { 
        $cita['id_paciente'] = htmlspecialchars($cita['id_paciente'], ENT_QUOTES, 'UTF-8');
        $cita['nombre'] = htmlspecialchars($cita['nombre'], ENT_QUOTES, 'UTF-8');
        $cita['apellido'] = htmlspecialchars($cita['apellido'], ENT_QUOTES, 'UTF-8');
        $cita['fecha_cita'] = htmlspecialchars($cita['fecha_cita'], ENT_QUOTES, 'UTF-8');
        $cita['hora_cita'] = htmlspecialchars($cita['hora_cita'], ENT_QUOTES, 'UTF-8');
        $cita['estado'] = htmlspecialchars($cita['estado'], ENT_QUOTES, 'UTF-8');
        $cita['facturado'] = htmlspecialchars($cita['facturado'], ENT_QUOTES, 'UTF-8');
        $cita['precio'] = htmlspecialchars($cita['precio'], ENT_QUOTES, 'UTF-8');
        $cita['pagado'] = htmlspecialchars($cita['pagado'], ENT_QUOTES, 'UTF-8');
    }

        unset($cita); // Eliminar la referencia al último elemento
       

        // Guarda los datos de citas en la sesión
        $_SESSION['citas_datos'] = $citas_datos;
        
        // Redirige a listado_impagos.php
        header('Location: ../../view/facturacion/listado_facturadas.php');
        
    exit;

} catch (Exception $e) {
    // Mostrar el error completo
    echo json_encode([
        'error' => 'Ocurrió un error en el servidor.',
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
    exit;
}
<?php

include_once('../../config/config.php');
include_once('../../class/Pago.php');


$id_paciente = $_POST['id_paciente'];
$desde = $_POST['desde'];  // Ya está en formato yyyy-mm-dd
$hasta = $_POST['hasta'];  // Ya está en formato yyyy-mm-dd


try {
    // Crear una instancia de la clase Cita
    $pago = new Pago();
    // Obtener las pago no pagadas
    $pagos_datos = $pago->searchCitasNoPagasPorPaciente($id_paciente, $desde, $hasta);
    session_start();

    // Asegurarse de que $citas_datos tiene los datos que esperamos
    if (empty($pagos_datos)) {
        $_SESSION['mensaje'] = "No se encontraron citas no pagas o no se encuentran facturadas";
        $_SESSION['icono'] = "error";
        header('Location: ../../view/pagar/index.php');
        exit;
    }

    // Limpiar los datos antes de pasarlos
    foreach ($pagos_datos as &$pago) { 
       $pago['id_paciente'] = htmlspecialchars($pago['id_paciente'], ENT_QUOTES, 'UTF-8');
       $pago['nombre'] = htmlspecialchars($pago['nombre'], ENT_QUOTES, 'UTF-8');
       $pago['apellido'] = htmlspecialchars($pago['apellido'], ENT_QUOTES, 'UTF-8');
       $pago['fecha_cita'] = htmlspecialchars($pago['fecha_cita'], ENT_QUOTES, 'UTF-8');
       $pago['hora_cita'] = htmlspecialchars($pago['hora_cita'], ENT_QUOTES, 'UTF-8');
       $pago['estado'] = htmlspecialchars($pago['estado'], ENT_QUOTES, 'UTF-8');
       $pago['facturado'] = htmlspecialchars($pago['facturado'], ENT_QUOTES, 'UTF-8');
       $pago['realizada'] = htmlspecialchars($pago['realizada'], ENT_QUOTES, 'UTF-8');
       $pago['precio'] = htmlspecialchars($pago['precio'], ENT_QUOTES, 'UTF-8');
       $pago['pagado'] = htmlspecialchars($pago['pagado'], ENT_QUOTES, 'UTF-8');
    }

        unset($pago); // Eliminar la referencia al último elemento
     
        // Guarda los datos de citas en la sesión
        $_SESSION['pagos_datos'] =$pagos_datos;
        
        // Redirige a listado_impagos.php
        header('Location: ../../view/pagar/listado_impagos.php');
        
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
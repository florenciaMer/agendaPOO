<?php

include_once('../../config/config.php');
include_once('../../class/Factura.php');

try {
    // Realiza la consulta SQL
    $factura = new factura();
    $facturacion_datos = $factura->searchCitasNoFacturadas(); // Recuperar las reservas
    // Procesar los datos antes de convertirlos a JSON
    foreach ($facturacion_datos as &$factura) { // Usamos referencia (&) para modificar directamente el array
        $factura['id_paciente'] = htmlspecialchars($factura['id_paciente'], ENT_QUOTES, 'UTF-8');
        $factura['nombre'] = htmlspecialchars($factura['nombre'], ENT_QUOTES, 'UTF-8');
        $factura['apellido'] = htmlspecialchars($factura['apellido'], ENT_QUOTES, 'UTF-8');
        $factura['fecha_cita'] = htmlspecialchars($factura['fecha_cita'], ENT_QUOTES, 'UTF-8');
        $factura['hora_cita'] = htmlspecialchars($factura['hora_cita'], ENT_QUOTES, 'UTF-8');
        $factura['estado'] = htmlspecialchars($factura['estado'], ENT_QUOTES, 'UTF-8');
        $factura['facturado'] = htmlspecialchars($factura['facturado'], ENT_QUOTES, 'UTF-8');
        $factura['precio'] = htmlspecialchars($factura['precio'], ENT_QUOTES, 'UTF-8');
        $factura['pagado'] = htmlspecialchars($factura['pagado'], ENT_QUOTES, 'UTF-8');
    }
    unset($factura); // Eliminar la referencia al último elemento
    // Convertir a JSON y devolver la respuesta
    return $facturacion_datos;
  //  echo $json = json_encode($citas_datos, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

    
    exit;
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['error' => 'Ocurrió un error en el servidor.']);

}

?>

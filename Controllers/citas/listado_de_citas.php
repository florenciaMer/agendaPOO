<?php

include_once('../../config/config.php');
include_once('../../class/Cita.php');

try {
    // Realiza la consulta SQL
    $cita = new Cita();
    $citas_datos = $cita->searchCitas(); // Recuperar las reservas
    // Procesar los datos antes de convertirlos a JSON
    foreach ($citas_datos as &$cita) { // Usamos referencia (&) para modificar directamente el array
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
    // Convertir a JSON y devolver la respuesta
    return $citas_datos;
  //  echo $json = json_encode($citas_datos, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

    
    exit;
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['error' => 'Ocurrió un error en el servidor.']);

}

?>

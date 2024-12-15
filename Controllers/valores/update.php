<?php
include_once('../../class/Valores.php');

$id_valor = $_POST['id_valor']?? null;
$precio = $_POST['precio']?? null;
$fyh_actualizacion = $fechaHora;  // Asegúrate de que $fechaHora esté definido

$valor = new Valor();

// Validar si existe un paciente con el mismo email

session_start();
{

    try {
        // Intentamos actualizar el valor
        $resultado = $valor->updateValor($id_valor, 
        $precio,$fyh_actualizacion);
        
        
        // Verificamos si la actualización fue exitosa
        if ($resultado) {
            $_SESSION['mensaje'] = "El Valor ha sido actualizado correctamente";
            $_SESSION['icono'] = "success";
            header('Location: ../../view/valores/index.php');
            exit;
        } else {
            $_SESSION['mensaje'] = "No se pudo realizar la actualización del valor";
            $_SESSION['icono'] = "error";
            header('Location: ../../view/valores');
            exit;
        }
    } catch (Exception $e) {
        // Capturamos cualquier error y mostramos el mensaje
        echo 'Error: ' . $e->getMessage();
    }
}
?>

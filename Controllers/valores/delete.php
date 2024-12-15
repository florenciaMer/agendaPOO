<?php

include_once '../../config/config.php';
include_once '../../class/Valores.php';

$id_valor = $_GET['id_valor'];
$estado = 0;  // El valor de estado para la eliminación


$valor = new Valor();
$buscarEnValoresFacturado = $valor->searchValorFacturado($id_valor); // Verifica si el valor está facturado

session_start();
if ($buscarEnValoresFacturado) {
    // Respuesta si el valor está facturado
    $_SESSION['mensaje'] = 'No es posible eliminar el valor debido a que ya se encuentra facturado.';
    $_SESSION['icono'] = 'error';
    
    // Redirigir a la página de valores
    ?>
    <script> location.href = "<?php echo app_url; ?>/view/valores/index.php"</script>
    <?php
} else {
    // Si no está facturado, proceder con la eliminación
    $eliminarValor = $valor->deleteValor($id_valor, $fechaHora);
   
    $_SESSION['mensaje'] = 'Se eliminó el valor de manera correcta.';
    $_SESSION['icono'] = 'success';
    
    // Redirigir a la página de valores
    ?>
    <script> location.href = "<?php echo app_url; ?>/view/valores/index.php"</script>
    <?php 
}
?>

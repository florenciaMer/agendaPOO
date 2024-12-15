<?php
ob_start(); // Inicia el buffer de salida
include_once('../../config/config.php');
include_once('../../class/Factura.php');
session_start();

// Obtener datos de las citas no facturadas (POST o GET)
$vieneDeCitasIndex = $_GET['vieneDeCitasIndex'] ?? null;
$vieneDeListadoImpagos = $_POST['vieneDeListadoImpagos'] ?? null;
$vieneDePagos = $_POST['vieneDePagos'] ?? null;
$vieneDeNoFacturadas = $_GET['vieneDeNofacturacionIndex'] ?? null;
$vieneDeNofacturacionIndex = $_GET['vieneDeNofacturacionIndex'] ?? null;

$citas_no_facturadas = $_POST['citas_no_facturadas'] ?? $_GET['id_cita'] ?? [];
$id_facturacion = $_GET['id_facturacion'] ?? null;

// Asegúrate de que ambas variables sean arrays
if (!is_array($citas_no_facturadas)) {
    $citas_no_facturadas = [$citas_no_facturadas];
}
if (!empty($id_facturacion)) {
    if (!is_array($id_facturacion)) {
        $id_facturacion = [$id_facturacion];
    }
    $citas_no_facturadas = array_merge($citas_no_facturadas, $id_facturacion);
}

if (!empty($citas_no_facturadas)) {
    try {
        $factura = new Factura();
        $tienenPrecio = $factura->searchPrecioParaFacturar($citas_no_facturadas);

        if ($tienenPrecio) {
            $factura->setCitasNoFacturadas($citas_no_facturadas, implode(',', array_fill(0, count($citas_no_facturadas), '?')));
            $_SESSION['mensaje'] = "Se realizó la facturación correctamente.";
            $_SESSION['icono'] = "success";
        } else {
            $_SESSION['mensaje'] = "No se realizó la facturación debido a que la cita no tiene un precio asignado.";
            $_SESSION['icono'] = "error";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        ob_end_flush();
        die();
    }
} else {
    $_SESSION['mensaje'] = "No se seleccionaron citas para facturar.";
    $_SESSION['icono'] = "error";
}

// Verifica si ya se enviaron cabeceras
if (headers_sent($file, $line)) {
    die("Error: Las cabeceras ya se enviaron en $file en la línea $line.");
}


// Redirección basada en el origen
if ($vieneDeNoFacturadas == 1) {
    header('Location: ../../view/facturacion/index_no_facturadas.php');
    echo '<script>window.location.href="../../view/facturacion/index_no_facturadas.php";</script>';
    exit;
}
if ($vieneDeNofacturacionIndex == 1) {
    header('Location: ../../view/facturacion/listado_no_facturadas.php');
    echo '<script>window.location.href="../../view/facturacion/index_no_facturadas.php";</script>';
    exit;
}
if ($vieneDeCitasIndex == 1) {
    echo '<script>window.location.href="../../view/citas/index.php";</script>';
    exit;
}
if ($vieneDeListadoImpagos == 1) {
   
    echo '<script>window.location.href="../../view/listado_impagos/index.php";</script>';
    exit;
}
if ($vieneDePagos == 1) {
    header('Location: ../../view/pagos/index.php');
    echo '<script>window.location.href="../../view/pagos/index.php";</script>';
    exit;
}

ob_end_flush();
exit;

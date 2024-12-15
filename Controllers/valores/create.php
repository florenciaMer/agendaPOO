<?php 
include_once('../../config/config.php');
include_once('../../class/Valores.php');

$id_paciente = $_POST['id_paciente'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$precio = $_POST['precio'];
$estado = 1;

$cuenta=0;

$valor = new Valor();
$cuenta = $valor->searchValorPacienteFecha($id_paciente, $desde, $hasta);
echo $cuenta;
 
session_start();
 if ($cuenta>0) {
     $_SESSION['mensaje'] = 'El paciente ya tiene valores asignados para ese período, debe editar la información';
     $_SESSION['icono'] = 'error';
     ?>
     <script>
         window.history.back();
     </script>
 <?php 
 
 }else{
 
     $valor->insertValor($id_paciente, $desde, $hasta,$precio,$estado, $fechaHora);
     $_SESSION['mensaje'] = 'El Valor se registro de la manera correcta';
     $_SESSION['icono'] = 'success';
     header('Location:'.app_url.'/view/valores/index.php');
 }
 
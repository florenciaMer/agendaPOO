<?php 
include_once('../../config/config.php');
include_once('../layout/parte1.php');
$id = isset($_GET['id_valor']) ? $_GET['id_valor'] : null;
include_once('../../Controllers/valores/buscarValores.php');

$id_paciente = $valores_datos['id_paciente_valor'] ?? '';
$desde = $valores_datos['desde'] ?? '';
$hasta = $valores_datos['hasta'] ?? '';
$fyh_creacion = $valores_datos['fyh_creacion'] ?? '';
$precio = $valores_datos['precio'] ?? '';
$id_valor = $valores_datos['id_valor'] ?? '';
$nombre = $valores_datos['nombre'] ?? '';
$apellido = $valores_datos['apellido'] ?? '';
$estado = $valores_datos['estado'] ?? '';


?>

<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Actualizar datos de Valores</h3>
                        </div>
                        <div class="card-body"> 
                            <?php if (!empty($valores_datos)): ?>
                                <form action="<?php echo app_url;?>/Controllers/valores/update.php" method="post">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>" disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="apellido">Apellido</label>
                                            <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo htmlspecialchars($apellido, ENT_QUOTES, 'UTF-8'); ?>" disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nombre">Desde</label>                                                  
                                            <input type="text" id="desde" name="desde" class="form-control" value="<?php echo date('d-m-Y', strtotime($desde)); ?>" disabled>
                                            <input type="hidden" id="id_valor" name="id_valor" value="<?php echo htmlspecialchars($id_valor, ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" id="estado" name="estado" value="<?php echo htmlspecialchars($estado, ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hasta">Hasta</label>
                                            <input type="text" id="hasta" name="hasta" class="form-control" value="<?php echo date('d-m-Y', strtotime($hasta)); ?>" disabled>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="precio">Precio por Consulta </label>
                                            <input type="number" min="1" id="precio" name="precio" class="form-control" value="<?php echo htmlspecialchars($precio, ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                       
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                            <a href="<?php echo APP_URL;?>/view/valores/index.php" class="btn btn-secondary">Cancelar</a>
                                        </div>
                                    </div>
                                </form>
                            <?php else: ?>
                                <p>No se encontró información del paciente.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include_once('../layout/parte2.php');
include_once('../layout/mensajes.php');
?>

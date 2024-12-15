<?php 
include_once('../../config/config.php');
include_once('../layout/parte1.php');
$id = isset($_GET['id_paciente']) ? $_GET['id_paciente'] : null;
include_once('../../Controllers/Pacientes/buscarPaciente.php');

$nombre = $pacientes_datos['nombre'] ?? '';
$apellido = $pacientes_datos['apellido'] ?? '';
$direccion = $pacientes_datos['direccion'] ?? '';
$telefono = $pacientes_datos['telefono'] ?? '';
$celular = $pacientes_datos['celular'] ?? '';
$email = $pacientes_datos['email'] ?? '';
$estado = $pacientes_datos['estado'] ?? '';
$id_paciente = $pacientes_datos['id_paciente'] ?? '';

?>

<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Actualizar datos de un Paciente</h3>
                        </div>
                        <div class="card-body"> 
                            <?php if (!empty($pacientes_datos)): ?>
                                <form action="<?php echo app_url;?>/Controllers/Pacientes/update.php" method="post">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombre">Nombre</label>                                                  
                                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <input type="hidden" id="id_paciente" name="id_paciente" value="<?php echo htmlspecialchars($id_paciente, ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" id="estado" name="estado" value="<?php echo htmlspecialchars($estado, ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="apellido">Apellido</label>
                                            <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo htmlspecialchars($apellido, ENT_QUOTES, 'UTF-8'); ?>" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="direccion">Dirección</label>
                                            <input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo htmlspecialchars($direccion, ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($telefono, ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="celular">Celular</label>
                                            <input type="text" id="celular" name="celular" class="form-control" value="<?php echo htmlspecialchars($celular, ENT_QUOTES, 'UTF-8'); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                            <a href="<?php echo APP_URL;?>/view/pacientes/index.php" class="btn btn-secondary">Cancelar</a>
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

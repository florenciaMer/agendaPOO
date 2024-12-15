<?php 
include_once('../../config/config.php');
include_once('../../Controllers/pacientes/listarPacientes.php');
include_once('../layout/parte1.php');

$id_paciente = isset($_GET['id_paciente']) ? $_GET['id_paciente'] : null;
$fecha_cita = isset($_GET['fecha_cita']) ? $_GET['fecha_cita'] : null;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Registro de Valores por Paciente</h3>
                        </div>
                        
                        <div class="card-body"> 
                            <form action="<?php echo app_url; ?>/Controllers/valores/create.php" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="class form-group d-flex">
                                            
                                            <label for="id_paciente">Paciente:</label>
                                            <div class="col-md-8">
                                                
                                               
                        <select name="id_paciente" class="form-control">
                            <?php 
                            $first = true;  // Variable para seleccionar el primer paciente si no hay id_paciente
                            foreach ($pacientes_datos as $paciente) {
                                // Si no hay id_paciente, selecciona el primero
                                if (!$id_paciente && $first) {
                                    $selected = 'selected';
                                    $first = false;  // Evita que se seleccione más de uno
                                } else {
                                    $selected = ($id_paciente == $paciente['id_paciente']) ? 'selected' : '';
                                }
                            ?>
                                <option value="<?php echo $paciente['id_paciente']; ?>" <?php echo $selected; ?>>
                                    <?php echo $paciente['nombre'] . ' - ' . $paciente['apellido']; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>

                                        </div>
                                        <div class="col-md-4">
                                            <a href="<?php echo app_url;?>/view/pacientes/create.php" class="btn btn-primary"><i class="fa fa-plus"></i>Crear</a>             
                                        </div>
                                       
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="desde">Desde</label>
                                        <input type="date" 
                                            id="desde" 
                                            name="desde" 
                                            class="form-control" 
                                            value="<?php echo isset($_GET['fecha_cita']) ? htmlspecialchars($_GET['fecha_cita']) : ''; ?>" 
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hasta">Hasta</label>
                                        <input type="date" id="hasta"
                                         name="hasta"
                                          class="form-control" 
                                          value="<?php echo isset($_GET['fecha_cita']) ? htmlspecialchars($_GET['fecha_cita']) : ''; ?>" 
                                          required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio">Precio</label>
                                        <input type="text" id="precio" name="precio" class="form-control" required>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a href="<?php echo app_url;?>/view/valores/index.php" type="button" class="btn btn-secondary">Cancelar</a>

                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


 
<!-- Control Sidebar -->
<?php 
 include_once('../layout/parte2.php');
 include_once('../layout/mensajes.php');

 ?>
   <script>
document.addEventListener('DOMContentLoaded', function() {
    var desdeInput = document.getElementById('desde');
    var hastaInput = document.getElementById('hasta');

    desdeInput.addEventListener('change', function() {
        // Get the selected date from 'desde'
        var desdeDate = new Date(desdeInput.value);

        // Set the 'min' attribute of 'hasta' to the selected date
        hastaInput.min = desdeInput.value;
        
        // Optionally clear the 'hasta' field if the selected date is after the current 'hasta' value
        if (hastaInput.value && new Date(hastaInput.value) < desdeDate) {
            hastaInput.value = '';
        }
    });
});
</script>

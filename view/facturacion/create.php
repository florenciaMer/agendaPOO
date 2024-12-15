<?php 

include_once('../../config/config.php');
include_once('../layout/parte1.php');
include_once('../../Controllers/Pacientes/listarPacientes.php');
include_once('../../Controllers/citas/listado_de_citas.php');
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
                            <h3 class="card-title">Facturadas por Pacientes</h3>
                        </div>
                        <div class="card-body"> 
                            <form action="<?php echo app_url; ?>/Controllers/facturacion/buscar_citas_facturadas.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                <select name="id_paciente" class="form-control">
                                    <?php 
                                    foreach ($pacientes_datos as $paciente) {
                                        // Si no hay id_paciente, selecciona el primero
                                        $selected = (isset($id_paciente) && $id_paciente == $paciente['id_paciente']) ? 'selected' : '';

                                    ?>
                                        <option value="<?php echo $paciente['id_paciente']; ?>" <?php echo $selected; ?>>
                                            <?php echo $paciente['nombre'] . ' - ' . $paciente['apellido']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                </div>
                                <br>
                                <br>
                            
                               
                                <div class="col-md-12 d-flex">
                               <!-- <div>
                                <label>
                                    <input type="checkbox" name="estado_facturado[]" value="1" checked>
                                    Facturado
                                </label>
                                    </div>
                                    <div>
                                    <label>
                                        <input type="checkbox" name="estado_facturado[]" value="0" checked>
                                        No Facturado
                                    </label>
                                    </div>
                                </div>
                                -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="desde">Desde</label>
                                        <input type="date" id="desde" name="desde" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hasta">Hasta</label>
                                        <input type="date" id="hasta" name="hasta" class="form-control" required>
                                    </div>
                                </div>
                                </div>
                                <br>
                                <div class="col-md-12 ml-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Confirmar</button>
                                        <a href="<?php echo app_url;?>" type="button" class="btn btn-secondary">Cancelar</a>
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
   
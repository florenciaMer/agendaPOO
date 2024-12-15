<?php 

include_once('../../config/config.php');
include_once('../layout/parte1.php');
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
                            <h3 class="card-title">Registro de Pacientes</h3>
                        </div>
                        <div class="card-body"> 
                            <form action="<?php echo app_url; ?>/Controllers/pacientes/create.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                                    </div>
                                </div>
                            
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Apellido</label>
                                        <input type="text" id="apellido" name="apellido" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Dirección</label>
                                        <input type="text" id="direccion" name="direccion" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Teléfono</label>
                                        <input type="number" id="telefono" name="telefono" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Celular</label>
                                        <input type="number" id="celular" name="celular" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
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
   
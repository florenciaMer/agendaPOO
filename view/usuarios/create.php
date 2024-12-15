<?php 
include_once('../../config/config.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo app_name?> | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo app_url?>/public/adminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo app_url?>/public/adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo app_url?>/public/adminLTE/dist/css/adminlte.min.css">

  
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css
    " rel="stylesheet">
    <script src="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js
    "></script>
</head>
<body class="hold-transition login-page">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Registro de Usuario</h3>
                        </div>
                        <div class="card-body"> 
                            <form action="<?php echo app_url; ?>/Controllers/usuarios/create.php" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                            
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Repetir password</label>
                                        <input type="password" id="password_repeat" name="password_repeat" class="form-control" required>
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

<?php
  session_start();
  if (isset($_SESSION['mensaje']) && isset($_SESSION['icono'])) {
    $mensaje = $_SESSION['mensaje'];
    $icono = $_SESSION['icono'];

    ?>
  <script>
    var mensaje = '<?php echo $mensaje;?>';
    var icono = '<?php echo $icono;?>';
    Swal.fire({
    position: "top-end",
    icon: icono,
    title: mensaje,
    showConfirmButton: false,
    timer: 2000
  });
  </script>
    <?php
    unset($_SESSION['mensaje']);
    unset($_SESSION['icono']);
  }
?>
 
<!-- Control Sidebar -->
<?php 
 //include_once('../layout/parte2.php');
 include_once('../layout/mensajes.php');

 ?>
   
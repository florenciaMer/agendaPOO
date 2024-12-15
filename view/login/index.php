<?= 
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

<div class="login-box">
    <img src="<?php echo app_url;?>/public/img/login.jpg" width="150px" style="margin-left: 30%";>
  <div class="login-logo">
    <br>
    <h3><b><?php echo app_name?></b></h3>
  </div>
  <br>
  <hr>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicio de Sesión</p>

  

    <form method="POST" action="../../Controllers/login/validarLogin.php">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
      
          <!-- /.col -->
          <div class="input-group mb-3">
            <button type="submit" class="btn-block btn btn-primary" name="ingresar" >Ingresar</button>
        </form>
            <a href="../usuarios/create.php" type="submit" class="btn-block btn btn-success" >Registrarse</a>
          </div>
          <!-- /.col -->
        </div>
      

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
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo app_url?>/public/adminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo app_url?>/public/adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo app_url?>/public/adminLTE/dist/js/adminlte.min.js"></script>

</body>
</html>

  <?php
  ob_start(); 
  session_start();
  if (!isset($_SESSION['sesion_email'])) {
     
      header('Location: ' . app_url . "/view/login/index.php");
      exit;
  } else {
      $email_sesion = $_SESSION['sesion_email'];
  }
  ?>

  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo app_name; ?></title>

        <!-- Cargar jQuery primero (solo una vez) -->
       <!-- jQuery -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<!-- Botones de DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Botones de DataTables JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- Archivo de idioma español para DataTables -->
<script type="text/javascript" charset="utf-8" src="https://cdn.datatables.net/plug-ins/1.13.4/i18n/Spanish.json"></script>

<!-- Otros Estilos y Scripts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?php echo app_url; ?>/public/adminLTE/dist/css/adminlte.min.css">

</head>


  <body class="hold-transition sidebar-mini">
    
  <style>
        .dt-button {
              border-bottom: 1px solid #6c757d; /* Color y grosor de la línea divisoria */
          }

          .dt-button:not(:last-child) {
          margin-bottom: 4px; /* Espacio entre los botones y la línea divisoria */
          }
          .dt-button {
              background-color:#6c757d; /* Color de fondo */
              color: #fff; /* Color del texto */
              border: none; /* Sin borde */
              padding: 8px 16px; /* Espaciado interno */
              margin-right: 8px; /* Espacio entre botones */
              border-radius: 4px; /* Bordes redondeados */
              font-size: 14px; /* Tamaño de fuente */
              cursor: pointer; /* Cambia el cursor al pasar por encima */
          }

          .dt-button:hover {
              background-color: #0056b3; /* Color de fondo al pasar el ratón */
              color: #fff; /* Color del texto al pasar el ratón */
          }

          .dt-button:active {
              background-color: #004085; /* Color de fondo al hacer clic */
              color: #fff; /* Color del texto al hacer clic */
          }
      </style>
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo app_url;?>/index.php" class="nav-link"><?php echo app_name;?></a>
        </li>

      </ul>

      
      <!-- Right navbar links -->

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?php echo app_url;?>" class="brand-link">
        <img src="<?php echo app_url;?>/public/img/calendario.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <a href="<?php echo app_url;?>/index.php" class="brand-text font-weight-light"><h3>SIS | Agenda</h3></a>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo app_url;?>/public/img/usuario.png" class="elevation-2" alt="usuario">
          </div>
          <div class="info">
          <a href="<?php echo app_url;?>" class="d-block"><?php echo $_SESSION['sesion_email'];?></a>
           
          
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->

            <li class="nav-item">
              <a href="#" class="nav-link ">
                <i class="nav-icon bi bi-person"></i>
                <p>
                  Usuarios
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo app_url;?>/view/usuarios/index.php" class="nav-link">
                  <i class="nav-icon bi bi-person"></i>
                    <p>Listado de Usuarios</p>
                  </a>
                </li>
              
              </ul>
            </li>
            <li class="nav-item">
              <a href="<?php echo app_url;?>/view/pacientes/index.php" class="nav-link active">
                <i class="nav-icon bi-file-earmark-person"></i>
                <p>
                  Pacientes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo app_url;?>/view/pacientes/index.php" class="nav-link">
                  <i class="nav-icon bi-file-earmark-person"></i>
                    <p>Listado de Pacientes</p>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item">
              <a href="<?php echo app_url;?>/view/valores/index.php" class="nav-link active">
                <i class="nav-icon bi-cash-coin"></i>
                <p>
                  Valores 
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo app_url;?>/view/valores/index.php" class="nav-link">
                    <script>console.log("Redireccionando a: <?php echo app_url; ?>/view/valores/index.php");</script>
                  <i class="nav-icon bi-cash-coin"></i>
                    <p>Listado de Valores</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="<?php echo app_url;?>/view/citas/index.php" class="nav-link active">
                <i class="nav-icon bi bi-calendar2-check"></i>
              
                <p>
                  Citas Registradas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo app_url;?>/view/citas/index.php" class="nav-link">
                  <i class="nav-icon bi bi-calendar2-check"></i>
                    <p>Listado de citas</p>
                  </a>
                </li>
                <!--<li class="nav-item">
                  <a href="<?php echo app_url;?>/view/citas/citas_por_fecha.php" class="nav-link">
                  <i class="nav-icon bi bi-calendar2-check"></i>
                    <p>Citas a una fecha</p>
                  </a>
                </li>
                 -->
              </ul>
            </li>

            <!-- facturacion -->
            <li class="nav-item">
              <a href="<?php echo app_url;?>/view/facturacion/index.php" class="nav-link active">
                <i class="nav-icon bi bi-cash"></i>
              
                <p>
                  Pagos
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo app_url;?>/view/pagar/index.php" class="nav-link">
                  <i class="nav-icon bi bi-cash"></i>
                    <p>Listado de pagos</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="<?php echo app_url;?>/view/citas/index.php" class="nav-link active">
              <i class="nav-icon bi bi-wallet2"></i>
              
                <p>
                  Facturación
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo app_url;?>/view/facturacion/index.php" class="nav-link">
                  <i class="nav-icon bi bi-wallet2"></i>
                    <p>Facturadas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo app_url;?>/view/facturacion/index_no_facturadas.php" class="nav-link">
                  <i class="nav-icon bi bi-wallet2"></i>
                    <p>No Facturadas</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item" style="background-color:red; color:white; border-radius:6px">
              <a href="<?php echo app_url;?>/controllers/login/logout.php" class="nav-link">
                <i class="nav-icon bi bi-door-open"></i>
                <p>
                  Cerrar sesión
                </p>
              </a>
            </li>
          </ul>
        </nav>
        
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

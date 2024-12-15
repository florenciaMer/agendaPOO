<?php

if (isset($_SESSION['mensaje'])) {
  
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
    timer: 2500
  });
  </script>


<?php
 unset($_SESSION['mensaje']);
 unset($_SESSION['icono']);
}
?>  
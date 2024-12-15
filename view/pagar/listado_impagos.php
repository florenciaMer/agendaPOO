<?php 
include_once('../../config/config.php');
include_once('../layout/parte1.php');
//include_once('../../Controllers/facturar/buscar_citas_facturacion.php');
//levanta los datos de las citas con una session

?>
</head>
<script>
    console.log($.fn.DataTable);

</script>
<style>
  .btn-success {
    z-index: 10;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <h1>Listado de citas impagas por paciente facturadas</h1>
            </div>
            <div class="row">
            <div class="card col-md-10">
             <div class="card-body">
               
                <div id="export-buttons" class="buttons mb-3"></div>
                <?php
if (isset($_SESSION['pagos_datos'])) {
    $pagos_datos = $_SESSION['pagos_datos'];
    $total = 0;
    $contador_pagos = 0;
?>
<form action="<?php echo app_url; ?>/Controllers/pagos/marcar_pagada_por_paciente.php" method="post">
<table id="example2" class="table table-striped">
    <thead>
        <tr>
            <th>Nro</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <th>Precio</th>
            <th>Confirmada</th>
            <th>Cobrar</th>
            <th>Pago</th> <!-- Nuevo encabezado -->
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($pagos_datos as $pago) {
            $contador_pagos++;
            
            echo '<tr>';
            echo '<td>' . $contador_pagos . '</td>';
            echo '<td>' . htmlspecialchars($pago['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($pago['apellido']) . '</td>';
            echo '<td>' . date('d-m-Y', strtotime($pago['fecha_cita'])) . '</td>';
            echo '<td>' . htmlspecialchars($pago['hora_cita']) . '</td>';
          
            echo '<td>' . ($pago['estado'] == 1 ? 'Confirmada' : 'Sin confirmar') . '</td>';
            
            echo '<td>';
            if (!empty($pago['precio']) && is_numeric($pago['precio'])) {
                echo '$' . htmlspecialchars($pago['precio']);
                $total += $pago['precio']; // Sumar al total si hay precio
            } else {
              echo '<a href="../valores/create.php?id_paciente=' . $pago['id_paciente'] . '&fecha_cita=' . urlencode($pago['fecha_cita']) . '">
              Cargar Precio</a>';
            }
            echo '</td>';
            echo '<td style="color:' . ($pago['realizada'] == 1 ? 'green' : 'red') . ';">' . ($pago['realizada'] == 1 ? 'Si' : 'No') . '</td>';

            echo '<echo>';
            echo '<td>';
            if (empty($pago['precio']) || !is_numeric($pago['precio'])) {
                // Si el precio está vacío o no es un número, deshabilitar el checkbox
                echo '<input type="checkbox" name="citas_no_pagadas[]" value="' . htmlspecialchars($pago['id_reserva']) . '" disabled>';
            } else {
                // Si el precio es válido, mostrar el checkbox habilitado
                echo '<input type="checkbox" name="citas_no_pagadas[]" value="' . htmlspecialchars($pago['id_reserva']) . '">';
            }
            echo '</td>';
            echo '<td style="color:' . ($pago['pagado'] == 1 ? 'green' : 'red') . ';">' . ($pago['pagado'] == 1 ? 'Pagado' : 'Sin pagar') . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold; background-color: #f1f1f1;">Total:</td>
            <td style="font-weight: bold; background-color: #f1f1f1;">$<?php echo number_format($total, 2); ?>
             <button type="submit" class="btn btn-primary">Confirmar</button>
            </td>
        </tr>
    </tfoot>
</table>
</form>
<?php
} else {
    echo '<tr><td colspan="8">No hay citas para mostrar</td></tr>';
}
?>

    </tbody>
 <!-- Mostrar el total antes del paginador -->
 
</table>
  </form>

</div>
</div>
</div>
</div>

<script>
  $(document).ready(function () {
    console.log($('#example2').DataTable()); // Verifica si DataTable se ha inicializado correctamente

    if ($.fn.dataTable.isDataTable('#example2')) {
      console.log('DataTable ya está inicializada');
    } else {
      console.log('DataTable no está inicializada');
    }

    // Inicialización de la tabla si no está inicializada
    if (!$.fn.dataTable.isDataTable('#example2')) {
      $(function () {
        $("#example2").DataTable({
          "pageLength": 5,
          "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Pacientes",
            "infoEmpty": "Mostrando 0 a 0 de 0 Pacientes",
            "infoFiltered": "(Filtrado de _MAX_ total Pacientes)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Pacientes",
            "loadingRecords": "Cargando...",
            "processing": "Procesando",
            "search": "Buscador",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
              "first": "Primero",
              "last": "Último",
              "next": "Siguiente",
              "previous": "Anterior"
            }
          },
          "responsive": true,
          "lengthChange": true,
          "autoWidth": false,
          buttons: [
            {
              extend: 'collection',
              text: 'Reportes',
              orientation: 'landscape',
              buttons: [
                {
                  text: 'Copiar',
                  extend: 'copy',
                },
                {
                  extend: 'pdf',
                },
                {
                  extend: 'csv',
                },
                {
                  extend: 'excel',
                },
                {
                  text: 'Imprimir',
                  extend: 'print',
                }
              ]
            },
            {
              extend: 'colvis',
              text: 'Visor de columnas',
              collectionLayout: 'fixed three-column',
            }
          ],
        }).buttons().container().appendTo('#export-buttons');
      });
    }
  });
</script>



<script>
 
    /* Usa una clase en lugar de un ID para manejar el clic en los botones
    $(document).on('click', '.btn.confirmar-factura', function() {
        var id_paciente = $(this).data('id');
        //desde es la fecha de la cita
        var desde = $(this).data('desde');
        var hora = $(this).data('hora');

        // Imprime los datos en la consola para verificar
        console.log('ID Paciente:', id_paciente);
        console.log('Desde:', desde);
        console.log('Hora:', hora);

    
    let url = "<?php echo app_url;?>/controllers/facturacion/pagar_una_cita.php";
        $.get(url, {id_paciente: id_paciente, desde:desde, hora:hora}, function(datos){
         $('#respuesta-facturar').html(datos);
        });
        // Limpiar y agregar los nuevos datos a la tabla
        table.clear().rows.add(newData).draw();
  })
  */
</script>

<!-- Control Sidebar -->
<?= 
 include_once('../layout/parte2.php');
 include_once('../layout/mensajes.php');
?>
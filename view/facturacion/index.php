<?php 
include_once('../../config/config.php');
include_once('../layout/parte1.php');
include_once('../../Controllers/facturacion/listado_de_facturadas.php');

if (!isset($facturacion_datos)) {
    die('Error: $facturacion_datos no está definido.');
}

?>
</head>
<script>
    console.log($.fn.DataTable);

</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Listado de Facturación</h1>
            </div>
            <div class="row">
            <div class="card col-md-10">
             <div class="card-body">
                <div class="d-flex justify-content-between m-2">
                    <h3>Facturadas </h3>
                    <a href="create.php" class="btn btn-primary">Ver por paciente</a>
                </div>
                <div id="export-buttons" class="buttons mb-3"></div>
                <table id="example2" class="table table-striped">
    <thead>
        <tr>
            <th>Nro</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <th>Facturado</th>
            <th>Precios - Acción</th>
            <th>Pago - Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $contador_facturacion = 0;
        foreach ($facturacion_datos as $facturacion) {
            $contador_facturacion++;
            $vieneDefacturacionIndex = 1;
            ?>
            <input type="hidden" name="vieneDefacturacionIndex" value="<?php echo $vieneDefacturacionIndex;?>" />
            <?php
            echo '<tr>';
            echo '<td>' . $contador_facturacion . '</td>';
            echo '<td>' . htmlspecialchars($facturacion['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($facturacion['apellido']) . '</td>';
            echo '<td>' . date('d-m-Y', strtotime($facturacion['fecha_cita'])) . '</td>';
            echo '<td>' . htmlspecialchars($facturacion['hora_cita']) . '</td>';
            echo '<td>' . ($facturacion['estado'] == 1 ? 'Confirmada' : 'Sin confirmar') . '</td>';
            echo '<td>';

            if ($facturacion['facturado'] == 1) {
                echo '<span style="color: green;">Sí</span>'; // Muestra 'Sí' en verde si está facturado
            } else {
              echo '<a href="../../Controllers/facturar/marcar_facturada_por_paciente.php?id_facturacion=' . $facturacion['id_reserva'] . '&vieneDefacturacionIndex=1" >Facturar</a>';
  }
            echo '</td>';

            echo '<td>';
            if (!empty($facturacion['precio']) && is_numeric($facturacion['precio'])) {
                echo '$' . htmlspecialchars($facturacion['precio']);
            } else {
              echo '<a href="../valores/create.php?id_paciente=' . $facturacion['id_paciente'] . '&fecha_cita=' . urlencode($cita['fecha_cita']) . '">
              Cargar Precio</a>';
            }
            echo '</td>';
            echo '<td style="color:' . ($facturacion['pagado'] == 1 ? 'green' : 'red') . ';">' . ($facturacion['pagado'] == 1 ? 'Pagado' : 'Sin pagar') . '</td>';

            echo '</tr>';
        }
        ?>
    </tbody>
</table>
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
          "pageLength": 15,
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
 
    // Usa una clase en lugar de un ID para manejar el clic en los botones
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
  
</script>

<!-- Control Sidebar -->
<?= 
 include_once('../layout/parte2.php');
 include_once('../layout/mensajes.php');
?>
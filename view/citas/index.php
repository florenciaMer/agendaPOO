<?php 
include_once('../../config/config.php');
include_once('../layout/parte1.php');
include_once('../../Controllers/citas/listado_de_citas.php');
//include_once('../../controllers/pacientes/listado_de_pacientes.php');
//include_once('../../controllers/facturacion/listado_de_facturaciones.php');
//include_once('../../controllers/facturacion/listado_de_citas.php')
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
                <h1>Listado de Citas</h1>
            </div>
            <div class="row">
            <div class="card col-md-10">
             <div class="card-body">
                <div class="d-flex justify-content-between m-2">
                    <h3>Citas registradas </h3>
                    <a href="../facturar/create.php" class="btn btn-primary">Facturar por paciente</a>
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
        $contador_citas = 0;
        foreach ($citas_datos as $cita) {
            $contador_citas++;
            $vieneDeCitasIndex = 1;
            ?>
            <input type="hidden" name="vieneDeCitasIndex" value="<?php echo $vieneDeCitasIndex;?>" />
            <?php
            echo '<tr>';
            echo '<td>' . $contador_citas . '</td>';
            echo '<td>' . htmlspecialchars($cita['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($cita['apellido']) . '</td>';
            echo '<td>' . date('d-m-Y', strtotime($cita['fecha_cita'])) . '</td>';
            echo '<td>' . htmlspecialchars($cita['hora_cita']) . '</td>';
            echo '<td>' . ($cita['estado'] == 1 ? 'Confirmada' : 'Sin confirmar') . '</td>';
            echo '<td>';

            if ($cita['facturado'] == 1) {
                echo '<span style="color: green;">Sí</span>'; // Muestra 'Sí' en verde si está facturado
            } else {
              echo '<a href="../../Controllers/facturar/marcar_facturada_por_paciente.php?id_cita=' . $cita['id_reserva'] . '&vieneDeCitasIndex=1" >Facturar</a>';
  }
            echo '</td>';

            echo '<td>';
            if (!empty($cita['precio']) && is_numeric($cita['precio'])) {
                echo '$' . htmlspecialchars($cita['precio']);
            } else {
              echo '<a href="../valores/create.php?id_paciente=' . $cita['id_paciente'] . '&fecha_cita=' . urlencode($cita['fecha_cita']) . '">
              Cargar Precio</a>';
            }
            echo '</td>';
            echo '<td style="color:' . ($cita['pagado'] == 1 ? 'green' : 'red') . ';">' . ($cita['pagado'] == 1 ? 'Pagado' : 'Sin pagar') . '</td>';

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
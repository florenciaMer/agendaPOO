<?php 
include_once('../../config/config.php');
include_once('../layout/parte1.php');
include_once('../../Controllers/valores/listado_de_valores.php');

?>

<style>
        body {
            padding: 20px;
        }
        #example2 {
            width: 100%;
            margin-top: 20px;
        }
        /* Estilo para el contenedor de botones */
        .buttons {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-start;
        }
        .dt-button {
            margin-right: 10px;
        }
    </style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
           
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h2>Listado de Valores por paciente</h2>
                        <div class="d-flex justify-content-end m-2">
                            <a href="create.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle"> </i>Crear Valor
                            </a>
                        </div>

                        <div id="export-buttons" class="buttons mb-3"></div>
                       
                        <table class="table border" id="example2">
                       
                            <thead>
                                
                                <tr>
                                    <th>Nro</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Valor</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                
                                <?php
                                $contador_valores = 0;
                                if (!empty($valores_datos)) { // Verificar que $valores_datos no esté vacío
                                    foreach ($valores_datos as $valor) {
                                        $contador_valores++;
                                        $id_paciente = htmlspecialchars($valor['id_paciente_valor']);
                                        $desde = htmlspecialchars($valor['desde']);
                                        $hasta = htmlspecialchars($valor['hasta']);
                                        $fyh_creacion = htmlspecialchars($valor['fyh_creacion']);
                                        $precio = htmlspecialchars($valor['precio']);
                                        $id_valor = htmlspecialchars($valor['id_valor']);
                                        $nombre = htmlspecialchars($valor['nombre']);
                                        $apellido = htmlspecialchars($valor['apellido']);
                                ?>
                                <tr>
                                    <td><?php echo $contador_valores; ?></td>
                                    <td><?php echo $nombre; ?></td>
                                    <td><?php echo $apellido; ?></td>
                                    <td>$<?php echo $precio; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($desde)); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($hasta)); ?></td>
                                    <td>
                                        <a href="update.php?id_valor=<?php echo $id_valor; ?>" class="btn btn-success btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <span id="btn-delete<?php echo $id_valor; ?>" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </span>
                                    </td>
                                </tr>
                                <div id="respuesta-delete<?php echo $id_valor; ?>"></div>
                                <script>
                                    $(document).ready(function () {
                                        // Manejo del botón de eliminación
                                        $('#btn-delete<?php echo $id_valor; ?>').click(function () {

                                            let id_valor = '<?php echo addslashes($id_valor); ?>';
                                            let nombre = '<?php echo addslashes($valor['nombre']); ?>';
                                            let apellido = '<?php echo addslashes($valor['apellido']); ?>';

                                            Swal.fire({
                                            title: `¿Está seguro de eliminar al valor ${nombre} ${apellido}?`,
                                            showDenyButton: true,
                                            showCancelButton: true,
                                            confirmButtonText: 'Yes',
                                            denyButtonText: 'No',
                                            customClass: {
                                                actions: 'my-actions',
                                                cancelButton: 'order-1 right-gap',
                                                confirmButton: 'order-2',
                                                denyButton: 'order-3',
                                            },
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                let url = "<?php echo app_url; ?>/Controllers/valores/delete.php";

                                                $.get(url, { id_valor: '<?php echo addslashes($id_valor); ?>' }, function (datos) {
                                                    $('#respuesta-delete<?php echo $id_valor; ?>').html(datos);
                                                });
                                            } else if (result.isDenied) {
                                                Swal.fire('Los cambios no se guardaron', '', 'info');
                                            }
                                        });

                                        });
                                    });
                                </script>
                                <?php
                                    } // Fin del foreach
                                } else {
                                    echo "<tr><td colspan='7'>No hay valores registrados</td></tr>";
                                }
                                ?>
                                
                            </tbody>
                            
                        </table>
                        
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
include_once('../layout/mensajes.php');
include_once('../layout/parte2.php'); 
?>

<script>
    $(document).ready(function() {
        $("#example2").DataTable({
            destroy: true, // Destruye cualquier instancia previa
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ valores",
                "infoEmpty": "Mostrando 0 a 0 de 0 valores",
                "infoFiltered": "(Filtrado de _MAX_ total valores)",
                "lengthMenu": "Mostrar _MENU_ valores",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
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
                        { text: 'Copiar', extend: 'copy' },
                        { extend: 'pdf' },
                        { extend: 'csv' },
                        { extend: 'excel' },
                        { text: 'Imprimir', extend: 'print' }
                    ]
                },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#export-buttons');
    });
</script>


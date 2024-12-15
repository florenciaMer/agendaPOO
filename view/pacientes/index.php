
<?php 
include_once('../../config/config.php');
include_once('../layout/parte1.php');
include_once(BASE_PATH . '/controllers/pacientes/listarPacientes.php');
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
            <div class="row d-flex justify-content-center">
                <h1>Listado de Pacientes</h1>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between m-2">
                            <h3>Pacientes registrados</h3>
                            <a href="create.php" class="btn btn-primary"><i class="bi bi-person-plus-fill"> </i>Crear Paciente</a>
                        </div>
                        <div id="export-buttons" class="buttons mb-3"></div>
                        <table class="table border" id="example2">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Celular</th>
                                    <th>Email</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($pacientes_datos)) : ?>
                                <?php foreach ($pacientes_datos as $index => $paciente) : ?>
                                    <tr>
                                        <?php $id_paciente = $paciente['id_paciente']; ?>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $paciente['nombre'] ?></td>
                                        <td><?= $paciente['apellido'] ?></td>
                                        <td><?= $paciente['direccion'] ?></td>
                                        <td><?= $paciente['telefono'] ?></td>
                                        <td><?= $paciente['celular'] ?></td>
                                        <td><?= $paciente['email'] ?></td>
                                        
                                        <td>
                                            <a href="update.php?id_paciente=<?php echo $paciente['id_paciente'] ?>" class="btn btn-success btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            
                                            <button id="btn-delete<?php echo $id_paciente; ?>" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <div id="respuesta-delete<?php echo $id_paciente; ?>"></div>

<script>
    $(document).ready(function () {
        // Manejo del botón de eliminación
        $('#btn-delete<?php echo $id_paciente; ?>').click(function () {

            let id_paciente = '<?php echo addslashes($id_paciente); ?>';
            let nombre = '<?php echo addslashes($paciente['nombre']); ?>';
            let apellido = '<?php echo addslashes($paciente['apellido']); ?>';

            Swal.fire({
            title: `¿Está seguro de eliminar al paciente ${nombre} ${apellido}?`,
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
                let url = "<?php echo app_url; ?>/Controllers/pacientes/delete.php";

                $.get(url, { id_paciente: '<?php echo addslashes($id_paciente); ?>' }, function (datos) {
                    $('#respuesta-delete<?php echo $id_paciente; ?>').html(datos);
                });
            } else if (result.isDenied) {
                Swal.fire('Los cambios no se guardaron', '', 'info');
            }
        });

        });
    });
</script>

<?php endforeach; ?>
<?php else : ?>
    <tr>
        <td colspan="9" class="text-center">No hay pacientes registrados.</td>
    </tr>
<?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Control Sidebar -->


<!--
<script>
$(document).ready(function () {
    alert('jQuery está funcionando'); // Verifica en la consola del navegador
    $('#btn').click(function () {
        alert('¡Botón funciona!');
    });
});
</script>
-->
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



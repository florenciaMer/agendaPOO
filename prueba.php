<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ejemplo con Botones de Exportación</title>

    <!-- Cargar jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Cargar Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Cargar CSS de DataTables y botones -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Otros CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            padding: 20px;
        }
        #example2 {
            width: 100%;
            margin-top: 20px;
        }
        .buttons {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h1>Tabla con Botones de Exportación</h1>

    <!-- Contenedor para los botones de exportación -->
    <div id="export-buttons" class="buttons mb-3"></div>

    <!-- Tabla de ejemplo -->
    <table id="example2" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Ciudad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Juan</td>
                <td>28</td>
                <td>Madrid</td>
            </tr>
            <tr>
                <td>Ana</td>
                <td>32</td>
                <td>Barcelona</td>
            </tr>
            <tr>
                <td>Pedro</td>
                <td>45</td>
                <td>Sevilla</td>
            </tr>
            <tr>
                <td>Maria</td>
                <td>22</td>
                <td>Valencia</td>
            </tr>
        </tbody>
    </table>

    <!-- Cargar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Cargar DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Scripts de botones de DataTables -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <!-- Dependencias necesarias para los botones -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializa la tabla DataTable con los botones de exportación
            $('#example2').DataTable({
                destroy: true,
                pageLength: 5,
                language: {
                    emptyTable: "No hay información",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ valores",
                    infoEmpty: "Mostrando 0 a 0 de 0 valores",
                    infoFiltered: "(Filtrado de _MAX_ total valores)",
                    lengthMenu: "Mostrar _MENU_ valores",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscador",
                    zeroRecords: "Sin resultados encontrados",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Exportar a...',
                        orientation: 'landscape',
                        buttons: [
                            { text: 'Excel', extend: 'excelHtml5' },
                            { text: 'CSV', extend: 'csvHtml5' },
                            { text: 'PDF', extend: 'pdfHtml5' },
                            { text: 'Imprimir', extend: 'print' }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: 'Visor de Columnas'
                    }
                ]
            }).buttons().container().appendTo('#export-buttons');
        });
    </script>

</body>
</html>

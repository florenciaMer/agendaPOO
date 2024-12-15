
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      v.1.0    
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?php echo $anio;?> <a href="https://flor.io">Florencia Merzario.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables y botones -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- Dependencias para exportación -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- Otros Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-treetable/3.2.0/jquery.treetable.min.js"></script>

<!-- Cargar AdminLTE JS al final -->
<script src="<?php echo app_url; ?>/public/adminLTE/dist/js/adminlte.min.js"></script>

<!-- Inicialización de DataTables -->
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            destroy: true,
            pageLength: 15,
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
            ]
        });

        // Agregar botones al contenedor
        table.buttons().container().appendTo('#export-buttons');
    });
</script>
</body>
</html>
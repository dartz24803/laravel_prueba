<!-- Círculo de carga (spinner) -->
<div id="loading-spinner" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
    </div>
    <span class="visually-hidden">Cargando...</span>

</div>

<!-- Tabla -->
<div id="table-container" style="display: none;">
    <table id="tabla_js">
        <thead>
            <tr>
                <th>Almacen</th>
                <th>Usuario</th>
                <th>Sub Familia</th>
                <th>Descripción 1</th>
                <th>Descripción 2</th>
                <th>Descripción 3</th>
                <th>Marca</th>
                <th>Estilo</th>
                <th>Descripcion</th>
                <th>Color</th>
                <th>Talla</th>
                <th>Barra</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_stock as $list)
            <tr>
                <td>{{ $list->Almacen }}</td>
                <td>{{ $list->Usuario }}</td>
                <td>{{ $list->Sub_Familia }}</td>
                <td>{{ $list->Descripcion_1 }}</td>
                <td>{{ $list->Descripcion_2 }}</td>
                <td>{{ $list->Descripcion_3 }}</td>
                <td>{{ $list->Marca }}</td>
                <td>{{ $list->Estilo }}</td>
                <td>{{ $list->DEscripcion }}</td>
                <td>{{ $list->Color }}</td>
                <td>{{ $list->Talla }}</td>
                <td>{{ $list->Barra }}</td>
                <td>{{ $list->Stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        // Ocultar el contenedor de la tabla y mostrar el spinner al cargar la página
        $('#loading-spinner').show();
        $('#table-container').hide();

        // Mostrar la tabla inmediatamente
        $('#table-container').show();

        // Aplicar DataTable y ocultar el spinner después de la inicialización
        $('#tabla_js').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
            order: [
                [0, "desc"]
            ],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10,
            "initComplete": function() {
                // Ocultar el spinner después de que DataTable se haya inicializado
                $('#loading-spinner').hide();
            }
        });
    });
</script>
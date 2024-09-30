<style>
    #tabla_js td {
        max-width: 180px;
        /* Controla el ancho máximo */
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
        overflow: hidden;
        /* Oculta el contenido que se desborda */
        text-overflow: ellipsis;
        /* Añade puntos suspensivos (...) */
    }

    .text-primary {
        color: #007bff;
        /* Blue color */
    }
</style>

<table id="tabla_js" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>Semana</th>
            <th>Pertenece</th>
            <th>Encontrado</th>
            <th>Área</th>
            <th>Estilo</th>
            <th>Color</th>
            <th>Talla</th>
            <th>Prendas Devueltas</th>
            <th>Tipo de Error</th>
            <th>Responsable</th>
            <th>Solución</th>
            <th>Observación</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_errores_picking as $list)
        <tr>
            <td>{{ $list->semana }}</td>
            <td>{{ $list->pertenece }}</td>
            <td>{{ $list->encontrado }}</td>
            <td>{{ $list->area }}</td>
            <td>{{ $list->estilo }}</td>
            <td>{{ $list->color }}</td>
            <td>{{ $list->talla }}</td>
            <td>{{ $list->prendas_devueltas }}</td>
            <td>{{ $list->tipo_error }}</td>
            <td>{{ $list->responsable }}</td>
            <td>{{ $list->solucion }}</td>
            <td>{{ $list->observacion }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
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
        });
    });
</script>
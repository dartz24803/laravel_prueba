<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Orden</th>
            <th>N° requerimiento</th>
            <th>Semana</th>
            <th>Desde</th>
            <th>Hacia</th>
            <th>Proceso</th>
            <th>Estado</th>
            <th class="no-sort" onclick="OrdenarFechas()">Fecha</th>
            <th>Hora</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($list_bd_tracking as $list)
            <tr class="text-center">
                <td>{{ $list->orden }}</td>
                <td>{{ $list->n_requerimiento }}</td>
                <td>{{ $list->semana }}</td>
                <td>{{ $list->desde }}</td>
                <td>{{ $list->hacia }}</td>
                <td class="text-left">{{ $list->proceso }}</td>
                <td class="text-left">{{ $list->estado }}</td>
                <td>{{ $list->fecha }}</td>
                <td>{{ $list->hora }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
$(document).ready(function() {
    // Inicializa la tabla y guarda la referencia en una variable
    var tabla = $('#tabla_js').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive: true,
        order: [[0, "desc"]], // Usa 'order' como el orden inicial
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
        "aoColumnDefs": [
            {
                "bSortable": false, "aTargets": [ 7 ],
                'targets': [0],
                'visible': false
            }
        ],
        "columnDefs": [
            {
                'targets': 7, // Índice de la columna donde quieres desactivar el sort
                'orderable': false // Desactiva el sort
            }
        ],
    });

    // Asigna la función al botón o acción onclick
    $('#refrescar').on('click', function() {
        // Refresca la tabla sin reinicializarla
        tabla.ajax.reload(null, false); // Para datos dinámicos desde un servidor
        // tabla.draw(); // Si estás usando datos estáticos
    });
});

// Función externa para alternar el orden de la columna 0
function OrdenarFechas() {
    console.log('si');
    var tabla = $('#tabla_js').DataTable();
    tabla.order([0, 'asc']).draw(); // Cambia el orden de la columna y actualiza
}


</script>

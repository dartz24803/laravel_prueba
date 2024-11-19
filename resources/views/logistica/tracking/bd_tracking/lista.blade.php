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
            <th id="ordenar-fechas" onclick="OrdenarFechas()" style="cursor: pointer;">
                <div class=" d-flex justify-content-end orden-icono">⇅</div>Fecha
            </th>
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
        order: [[0, "desc"]],
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
        "columnDefs": [
            {
                'targets': 7,
                'orderable': false
            },
            {
                'targets': 0, // Índice de la columna que quieres ocultar
                'visible': false // Oculta la columna
            }
        ],
    });
});

function OrdenarFechas() {
    var tabla = $('#tabla_js').DataTable();
    var currentOrder = tabla.order(); // Obtiene el orden actual

    var header = $('#ordenar-fechas'); // Selecciona el encabezado
    var icono = header.find('.orden-icono'); // Selecciona el ícono de la flecha

    // Alterna entre ascendente y descendente
    if (currentOrder[0][0] === 0) { // Si la columna 0 está ordenada
        var newOrder = (currentOrder[0][1] === 'asc') ? 'desc' : 'asc';
        tabla.order([0, newOrder]).draw();

        // Cambia la clase del ícono según el nuevo orden
        if (newOrder === 'asc') {
            icono.removeClass('desc').addClass('asc').text('⇑');
        } else {
            icono.removeClass('asc').addClass('desc').text('⇓');
        }
    } else {
        // Si no está ordenada, establece como ascendente por defecto
        tabla.order([0, 'asc']).draw();
        icono.removeClass('desc').addClass('asc').text('⇑');
    }
}

</script>
<style>
#ordenar-fechas {
    cursor: pointer; /* Cambia el cursor a pointer */
    user-select: none; /* Evita selección del texto al hacer clic */
}

.orden-icono {
    margin-left: 5px; /* Espacio entre texto y flecha */
    font-size: 0.9em;
    color: gray; /* Color inicial */
}

.orden-icono.asc {
    content: "⇑"; /* Flecha ascendente */
    color: gray; /* Color activo */
}

.orden-icono.desc {
    content: "⇓"; /* Flecha descendente */
    color: gray; /* Color activo */
}
</style>
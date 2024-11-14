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
            <th onclick="OrdenarFechas()">Fecha</th>
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
// Declara la variable 'order' en el ámbito global
let order = [0, "desc"];

$(document).ready(function() {
    // Configura la tabla y guarda una referencia a la instancia de DataTable
    var tabla = $('#tabla_js').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive: true,
        order: [order], // Usa 'order' como el orden inicial
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
        "aoColumnDefs" : [ 
            {
                'targets' : [ 0 ],
                'visible' : false
            } 
        ]
    }).on('order.dt', function(e, settings) {
        // Actualiza 'order' cada vez que se ordene la tabla
        console.log("Orden actual:", order);
        order = settings.aaSorting[0];
    });
});
/*
// Función externa para usar la variable 'order' y alternar el orden de la columna 0
function OrdenarFechas() {
    console.log(order);
    // Verifica si la columna ordenada es la 0 o la 7
    if (order[0] == 7) {
        // Si el orden es descendente, cambia a ascendente
        if (order[1] === 'desc' || order[0] === 7) {
            console.log('Cambiando de descendente a ascendente');
            // Obtén la instancia de DataTable y aplica el nuevo orden
            var tabla = $('#tabla_js').DataTable();
            tabla.order([0, 'asc']).draw();
        }else if (order[1] === 'desc' || order[0] === 7) {
            console.log('Cambiando de ascendente a descendente');
            // Obtén la instancia de DataTable y aplica el nuevo orden
            var tabla = $('#tabla_js').DataTable();
            tabla.order([0, 'desc']).draw();
        }
    }
}*/

</script>
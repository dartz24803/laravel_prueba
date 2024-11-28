<style>
    .table>tbody>tr:last-child>td .dropdown:not(.custom-dropdown-icon):not(.custom-dropdown) .dropdown-menu.show,
    .table>tbody>tr:nth-last-child(2)>td .dropdown:not(.custom-dropdown-icon):not(.custom-dropdown) .dropdown-menu.show {
        top: -28px !important;
    }
</style>

<table id="tabla_js" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Código</th>
            <th>Sede Laboral</th>
            <th id="ordenar-fechas" onclick="OrdenarFechas()" style="cursor: pointer;">
                <div class="row p-0" style="width: 155%">
                    <div class="offset-1 col-md-6">
                        F. Registro
                    </div>
                    <div class="offset-1 col-md-2">
                        <div class="d-flex flex-column orden-icono">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                    </div>
                </div>
            </th>
            <th>Usuario</th>
            <th>Área</th>
            <th>Responsable</th>
            <th>Tipo</th>
            <th>Especialidad</th>
            <th>Elemento</th>
            <th>Asunto</th>
            <th>Fecha Registro</th>
            <th>F.Vencimiento</th>
            <th>F.Completado</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_tablageneral_soporte as $list)
        <tr>
            <td>{{ $list->fec_reg }}</td>
            <td>{{ $list->codigo }}</td>
            <td>{{ $list->base }}</td>
            <td>{{ \Carbon\Carbon::parse($list->fec_reg)->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ $list->usuario_nombre }}</td>
            <td>{{ $list->nombre_area }}</td>
            <td>{{ $list->nombres_responsables }}</td>
            <td>{{ $list->tipo_soporte }}</td>
            <td>{{ $list->nombre_especialidad }}</td>
            <td>{{ $list->nombre_elemento }}</td>
            <td>{{ $list->nombre_asunto }}</td>
            <td>{{ \Carbon\Carbon::parse($list->fec_reg)->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ \Carbon\Carbon::parse($list->fec_vencimiento)->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ \Carbon\Carbon::parse($list->fecha_completado)->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ $list->status_ticket }}</td>

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
                    'targets': 3,
                    'orderable': false
                },
                {
                    'targets': 0, // Índice de la columna que quieres ocultar
                    'visible': false // Oculta la columna
                }
            ],
        });
        $('#tabla_js thead').on('click', 'th', function() {
            if ($(this).attr('id') !== 'ordenar-fechas') {
                $('#tabla_js thead th .orden-icono').html(`
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                `);
            }
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
                icono.removeClass('desc').addClass('asc').html(`
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        `);
            } else {
                icono.removeClass('asc').addClass('desc').html(`
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        `);
            }
        } else {
            // Si no está ordenada, establece como ascendente por defecto
            tabla.order([0, 'asc']).draw();
            icono.removeClass('desc').addClass('asc').html(`
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        `);
        }
    }
</script>
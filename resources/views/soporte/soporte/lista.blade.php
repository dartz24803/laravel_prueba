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
            <th id="ordenar-fechas" onclick="OrdenarFechas()" style="cursor: pointer;">
                <div class="row p-0" style="width: 155%">
                    <div class="offset-1 col-md-6">
                        F. Registro
                    </div>
                    <div class="offset-1 col-md-2">
                        <div class="d-flex flex-column orden-icono">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up">
                                <polyline points="18 15 12 9 6 15"></polyline>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
            </th>
            <th>Sede Laboral</th>
            <th>U. de Registro</th>
            <th>Especialidad</th>
            <th>Descripción</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_tickets_soporte as $list)
        <tr>
            <td>{{ $list->fec_reg }}</td>
            <td>{{ $list->codigo }}</td>
            <td data-order"{{ $list->fec_reg }}">{{ \Carbon\Carbon::parse($list->fec_reg)->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ $list->base }}</td>
            <td>{{ $list->usuario_nombre_completo }}</td>
            <td>{{ $list->nombre_especialidad }}</td>
            <td>{{ $list->descripcion }}</td>

            <td class="text-center">
                <div style="display: flex; align-items: start; justify-content: start;">
                    <div
                        style="display: inline-block; 
            background-color: 
            {{ ( $list->status_poriniciar == true )
                ? '#FF786B'
                : (( $list->status_enproceso == true)
                    ? '#FFE881'
                    : ( $list->status_completado == true
                        ? '#5FB17B'
                        : ($list->status_standby == true
                            ? '#E2A03F'
                            : ($list->status_derivado == true
                                ? '#01b1f3'
                                : '#bdc0cf')))) }};
            border-radius: 14px; padding: 1px; width: 80px; color: 
                   {{ $list->status_enproceso == true ? '#726f73' : 'white' }}; text-align: center; margin-right: 10px;">
                        @if ( $list->status_poriniciar == true )
                        Por Iniciar
                        @elseif ( $list->status_enproceso == true )
                        En Proceso
                        @elseif ( $list->status_completado == true )
                        Completado
                        @elseif ($list->status_standby == true)
                        Stand By
                        @elseif ($list->status_derivado == true)
                        Derivado
                        @elseif ($list->status_cancelado == true)
                        Cancelado
                        @endif
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle" style="margin-left: 20px;" href="#" role="button"
                            id="dropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-more-vertical">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                                data-target="#ModalUpdate"
                                app_elim="{{ url('soporte_ticket/ver/' . $list['id_soporte']) }}">Ver</a>
                            @if ($list->status_cancelado == true && $list->status_derivado === false)
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                                data-target="#ModalUpdate"
                                app_elim="{{ url('soporte_ticket/edit/' . $list['id_soporte']) }}">Corregir</a>
                            @endif
                            @if ($acceso_pp)
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                                data-target="#ModalUpdate"
                                onclick="Delete_Soporte_Ticket('{{ $list->id_soporte }}')">Eliminar</a>
                            @endif

                        </div>
                    </div>
                </div>
            </td>

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
            "columnDefs": [{
                    'targets': 2,
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
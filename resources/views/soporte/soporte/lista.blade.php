<style>
    .table>tbody>tr:last-child>td .dropdown:not(.custom-dropdown-icon):not(.custom-dropdown) .dropdown-menu.show,
    .table>tbody>tr:nth-last-child(2)>td .dropdown:not(.custom-dropdown-icon):not(.custom-dropdown) .dropdown-menu.show {
        top: -28px !important;
    }
</style>

<table id="tabla_js" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>Código</th>
            <th>F.de Registro</th>
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
            <td>{{ $list->codigo }}</td>
            <td>{{ \Carbon\Carbon::parse($list->fec_reg)->locale('es')->translatedFormat('D d M y') }}</td>
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
                            : '#bdc0cf'))) }};
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
                            @if ($list->status_cancelado == true)
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
            order: [],
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
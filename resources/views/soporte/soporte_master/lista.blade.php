<style>
    .table>tbody>tr:last-child>td .dropdown:not(.custom-dropdown-icon):not(.custom-dropdown) .dropdown-menu.show,
    .table>tbody>tr:nth-last-child(2)>td .dropdown:not(.custom-dropdown-icon):not(.custom-dropdown) .dropdown-menu.show {
        top: -58px !important;
    }

    .adjusted-dropdown .dropdown-menu.show {
        top: -28px !important;
        /* Ajuste para la condición específica */
    }
</style>


<table id="tabla_js" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Código</th>
            <th>Sede Laboral</th>
            <th>F. de Registro</th>
            <th>U. de Registro</th>
            <th>Tipo</th>
            <th>Especialidad</th>
            <th>Elemento</th>
            <th>Asunto</th>
            <th>Responsable</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_tickets_soporte as $list)
        <?php
        $className = $list->idsoporte_motivo_cancelacion != 1 && $list->estado_registro == 5 ? 'adjusted-dropdown' : '';
        ?>
        <tr>
            <td>{{ $list->fec_reg }}</td>
            <td>{{ $list->codigo }}</td>
            <td>{{ $list->base }}</td>
            <td data-order="{{ $list->fec_reg }}">{{ \Carbon\Carbon::parse($list->fec_reg)->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ $list->usuario_nombre_completo }}</td>
            <td>{{ $list->nombre_tipo }}</td>
            <td>{{ $list->nombre_especialidad }}</td>
            <td>{{ $list->nombre_elemento }}</td>
            <td>{{ $list->nombre_asunto }}</td>
            <td>{{ $list->nombre_responsable }}</td>

            <td class="text-center">
                <div style="display: flex; align-items: center; justify-content: start;">
                    <div
                        style="display: inline-block;
            background-color:
            {{ ($list->status_poriniciar == true)
                ? '#FF786B'
                : ( ($list->status_enproceso == true)
                    ? '#FFE881'
                    : ($list->status_completado == true
                        ? '#5FB17B'
                       : ($list->status_stand_by == true
                            ? '#E2A03F'
                            : ($list->status_derivado == true
                                ? '#01b1f3'
                                : '#bdc0cf')))) }};
            border-radius: 14px; padding: 1px; width: 80px;  color:
                   {{ $list->status_enproceso == true ? '#726f73' : 'white' }}; text-align: center; margin-right: 10px;">
                        @if ($list->status_poriniciar == true)
                        Por Iniciar
                        @elseif ($list->status_enproceso == true)
                        En Proceso
                        @elseif ($list->status_completado == true)
                        Completado
                        @elseif ($list->status_stand_by == true)
                        Stand By
                        @elseif ($list->status_derivado == true)
                        Derivado
                        @elseif ($list->status_cancelado == true)
                        Cancelado
                        @endif
                    </div>

                    <div class="d-flex align-items-center">
                        <!-- Link Ver -->
                        <a href="#" class="m-1" data-toggle="modal" data-target="#ModalUpdate"
                            app_elim="{{ url('soporte_ticket_master/ver/' . $list['id_soporte']) }}" data-bs-toggle="tooltip" title="Ver">
                            <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />

                            </svg>
                        </a>

                        @if ($list->status_cancelado === false && $list->status_completado === false && $list->status_derivado === false)
                        <!-- Link Editar -->
                        <a href="#" class="m-1" data-toggle="modal" data-target="#ModalUpdate"
                            app_elim="{{ url('soporte_ticket_master/edit/' . $list['id_soporte']) }}" data-bs-toggle="tooltip" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>

                        <!-- Link Cancelar -->
                        <a href="#" class="m-1" data-toggle="modal" data-target="#ModalUpdate"
                            app_elim="{{ url('soporte_ticket_master/cancelar/' . $list['id_soporte']) }}" data-bs-toggle="tooltip"
                            title="Cancelar">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                        </a>
                        @endif
                    </div>





                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        var tabla = $('#tabla_js').DataTable({
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
                'targets': 0, // Índice de la columna que quieres ocultar
                'visible': false // Oculta la columna
            }],
        });

        // Configura la columna como oculta por defecto
        tabla.column(6).visible(false);
        tabla.column(7).visible(false);

        // Cambia la visibilidad de las columnas según los interruptores
        $('#toggle-fr').change(function() {
            var columnIndex = 3;
            var visible = this.checked;
            tabla.column(columnIndex).visible(visible);
        });

        $('#toggle-tipo').change(function() {
            var columnIndex = 5;
            var visible = this.checked;
            tabla.column(columnIndex).visible(visible);
        });

        $('#toggle-esp').change(function() {
            var columnIndex = 6;
            var visible = this.checked; // Cambia dinámicamente la visibilidad
            tabla.column(columnIndex).visible(visible);
        });

        $('#toggle-ele').change(function() {
            var columnIndex = 7;
            var visible = this.checked;
            tabla.column(columnIndex).visible(visible);
        });

        $('#toggle-res').change(function() {
            var columnIndex = 9;
            var visible = this.checked;
            tabla.column(columnIndex).visible(visible);
        });
    });
</script>
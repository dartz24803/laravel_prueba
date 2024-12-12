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
                        <a href="#" class="btn btn-outline-primary me-2" data-toggle="modal" data-target="#ModalUpdate"
                            app_elim="{{ url('soporte_ticket_master/ver/' . $list['id_soporte']) }}" data-bs-toggle="tooltip" title="Ver">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye"
                                viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z" />
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z" />
                            </svg>
                        </a>

                        @if ($list->status_cancelado === false && $list->status_completado === false && $list->status_derivado === false)
                        <!-- Link Editar -->
                        <a href="#" class="btn btn-outline-warning me-2" data-toggle="modal" data-target="#ModalUpdate"
                            app_elim="{{ url('soporte_ticket_master/edit/' . $list['id_soporte']) }}" data-bs-toggle="tooltip" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil"
                                viewBox="0 0 16 16">
                                <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708L6.207 13.793a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l9.646-9.646zM11.207 3L13 4.793 14.793 3 13 1.207 11.207 3zm1.586 1L10.5 5.293l.5.5L14.293 3 12.793 2z" />
                                <path fill-rule="evenodd"
                                    d="M1 13.5V16h2.5a.5.5 0 0 0 .5-.5v-.055a.5.5 0 0 0-.146-.354l-2-2a.5.5 0 0 0-.354-.146H1.5a.5.5 0 0 0-.5.5z" />
                            </svg>
                        </a>

                        <!-- Link Cancelar -->
                        <a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#ModalUpdate"
                            app_elim="{{ url('soporte_ticket_master/cancelar/' . $list['id_soporte']) }}" data-bs-toggle="tooltip"
                            title="Cancelar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle"
                                viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM1.5 8a6.5 6.5 0 1 0 13 0 6.5 6.5 0 0 0-13 0zM4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
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
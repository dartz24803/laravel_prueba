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

    .bg-green {
        background-color: #24e17f;
        /* Verde claro */
        color: white;
        /* Verde oscuro para el texto */
        padding: 5px;
        border-radius: 5px;
        /* Borde redondeado */
    }

    .bg-orange {
        background-color: orange;
        /* Naranja claro */
        color: white;
        /* Naranja oscuro para el texto */
        padding: 5px;
        border-radius: 5px;
        /* Borde redondeado */
    }

    .text-primary {
        color: #007bff;
        /* Blue color */
    }

    .col-tipo {
        width: 350px;
        /* Ajusta el valor según sea necesario */
    }
</style>

<table id="tabla_js" class="table table-hover" style="width:100%">
    <thead class="text-center">
        <tr>
            <th>Última Act</th>
            <th>Nombre BI</th>
            <th>Actividad</th>
            <th>Área</th>
            <th class="col-tipo">Accesos</th>
            <th>Estado</th>
            <th>Días sin Atención</th> <!-- Nueva columna -->
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_bi_reporte as $reporte)
        <tr class="text-center">
            <td>{{ \Carbon\Carbon::parse($reporte->fec_act)->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ $reporte->nom_bi }}</td>
            <td>
                @if ($reporte->actividad == 1)
                En uso
                @elseif ($reporte->actividad == 2)
                Suspendido
                @else
                No definido
                @endif
            </td>

            <td style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ $reporte->codigo_area }}
            </td>
            <td style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ $reporte->nombres_puesto }}
            </td>
            <td class="
                    @if ($reporte->estado_valid == 0)
                        bg-warning text-white
                    @elseif ($reporte->estado_valid == 1)
                        bg-success text-white
                    @else
                        bg-secondary text-white
                    @endif
                ">
                @if ($reporte->estado_valid == 0)
                Por Revisar
                @elseif ($reporte->estado_valid == 1)
                Completado
                @else
                Desconocido
                @endif
            </td>

            <td>
                @if ($reporte->dias_sin_atencion != 'N/A')
                <span class="{{ $reporte->dias_sin_atencion < 10 ? 'bg-green' : 'bg-orange' }}">
                    {{ $reporte->dias_sin_atencion }} Días
                </span>
                @else
                N/A
                @endif
            </td>
            <td>
                <!-- Aquí irían las acciones como editar, eliminar, etc. -->
                <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('bireporte_ra.edit', $reporte->id_acceso_bi_reporte) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                    </svg>
                </a>

                <a href="javascript:void(0);" title="Ver Contenido" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('bireporte_ra.image', $reporte->id_acceso_bi_reporte) }}">
                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />

                    </svg>
                </a>

                @if ($reporte->estado_valid == 0)
                <a href="javascript:void(0);" title="Aprobar" onclick="Validar_Reporte('{{ $reporte->id_acceso_bi_reporte }}')">
                    <svg title="Aprobar" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </a>
                @endif

                <a href="javascript:void(0);" title="Eliminar" onclick="Delete_ReporteBI('{{ $reporte->id_acceso_bi_reporte }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



<script>
    var tabla = $('#tabla_js').DataTable({
        "columnDefs": [{
            "width": "300px",
            "targets": [2]
        }],
        "ordering": false,
        "autoWidth": false,
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive: true,
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
        "pageLength": 10
    });
    $('#toggle').change(function() {
        var visible = this.checked;
        tabla.column(6).visible(visible);
        tabla.column(10).visible(visible);
        tabla.column(14).visible(visible);
        tabla.column(18).visible(visible);
    });
</script>
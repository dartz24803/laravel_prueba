<style>
    #tabla_js td {
        max-width: 100px;
        /* Controla el ancho máximo */
        white-space: normal;
        /* Permite que el texto se divida en varias líneas */
        overflow-wrap: break-word;
        /* Ajusta el contenido que se desborda */
    }

    .text-primary {
        color: #007bff;
        /* Blue color */
    }

    .url_img {
        color: #1b55e2;
        font-weight: 600;
        text-decoration: underline;
    }
</style>

<table id="tabla_js" class="table table-hover" style="width:100%">
    <thead class="text-center">
        <tr>
            <th>Código</th>
            <th>Fecha</th>
            <th>Inspector</th>
            <th>Punto Partida</th>
            <th>Punto Llegada</th>
            <th>Modelo</th>
            <th>Proceso</th>
            <th>Tipo Transporte</th>
            <th>Total</th>
            <th>Fecha Inicio Visita</th>
            <th>Fecha Fin Visita</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_asignacion as $asignacion)
        <tr class="text-center">
            <td>{{ $asignacion['cod_asignacion'] }}</td>
            <td>{{ \Carbon\Carbon::parse($asignacion['fecha'])->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ $asignacion['nombre_completo'] }}</td>
            <td>{{ $asignacion['proveedor_responsable_partida'] }}</td>
            <td>{{ $asignacion['proveedor_responsable_llegada'] }}</td>
            <td>
                <a href="{{ $asignacion['img_ft_produccion'] }}" target="_blank" class="url_img">
                    {{ $asignacion['nom_modelo'] }}
                </a>
            </td>
            <td>{{ $asignacion['nom_proceso'] }}</td>
            <td>{{ $asignacion['nom_tipo_transporte'] ?? 'N/A' }}</td>
            <td>S/{{ $asignacion['total_costo'] ?? '0' }}</td>
            <td>{{ $asignacion['fec_ini_visita'] ? \Carbon\Carbon::parse($asignacion['fec_ini_visita'])->locale('es')->translatedFormat('D d M y H:i') : 'N/A' }}</td>
            <td>{{ $asignacion['fec_fin_visita'] ? \Carbon\Carbon::parse($asignacion['fec_fin_visita'])->locale('es')->translatedFormat('D d M y H:i') : 'N/A' }}</td>
            <td>
                @if ($asignacion['estado_registro'] == 1)
                Por iniciar
                @elseif ($asignacion['estado_registro'] == 2)
                Iniciado
                @elseif ($asignacion['estado_registro'] == 3)
                Finalizado
                @else
                Desconocido
                @endif
            </td>
            <td>
                <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('produccion_av.edit', $asignacion['id_asignacion_visita']) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                    </svg>
                </a>

                <a href="javascript:void(0);" title="Detalle" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('produccion_av.detalle', $asignacion['id_asignacion_visita']) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </a>

                <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Asignacion('{{ $asignacion['id_asignacion_visita'] }}')">
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
                "width": "120px",
                "targets": [1, 2]
            } // Aplica el ancho específico a las columnas 2 y 3
        ],
        "order": [],
        "autoWidth": false, // Desactiva el auto ajuste de ancho de DataTables
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
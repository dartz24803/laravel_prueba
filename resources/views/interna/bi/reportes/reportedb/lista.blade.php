<style>
    #tabla_js td {
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bg-green {
        background-color: #24e17f;
        color: white;
        padding: 5px;
        border-radius: 5px;
    }

    .bg-orange {
        background-color: orange;
        color: white;
        padding: 5px;
        border-radius: 5px;
    }

    .text-primary {
        color: #007bff;
    }

    .col-tipo {
        width: 550px;
    }

    /* Nueva clase para permitir el ajuste dinámico de la columna */
    .expandable-col {
        min-width: 550px;
        /* Establece un mínimo pero permite expansión */
        max-width: none;
        /* Elimina el ancho máximo */
        width: auto;
        /* Permite que el contenido defina el ancho */
    }
</style>

<table id="tabla_js" class="table table-hover" style="width:100%">
    <thead class="text-center">
        <tr>
            <th>Última Act</th>
            <th>Nombre BI</th>
            <th>Nombre Intranet</th>
            <th>Iframe</th>
            <th class="col-tipo">Área</th>
            <th>Objetivo</th>
            <th>Nombre Sistema</th>
            <th>Nombre Base de Datos</th>
            <th>Actividad</th>
            <th>Tabla</th>
            <th>Frecuencia</th>
            <th>Solicitante</th>
            <th class="col-tipo">Accesos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_bi_reporte as $reporte)
        <tr class="text-center">
            <td>{{ \Carbon\Carbon::parse($reporte->fec_act)->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ $reporte->nom_bi }}</td>
            <td>{{ $reporte->nom_intranet }}</td>
            <td>{{ $reporte->iframe }}</td>
            <td style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ $reporte->codigo_area }}
            </td>
            <td>{{ $reporte->objetivo }}</td>
            <td>{{ $reporte->nom_sistema }}</td>
            <td>{{ $reporte->nom_db }}</td>
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
                {{ $reporte->nom_tabla }}
            </td>

            <td style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ $reporte->tipo_frecuencia }}
            </td>
            <td style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ $reporte->nombre_usuario }}
            </td>
            <!-- Aplicamos la clase expandable-col -->
            <td class="expandable-col" title="{{ $reporte->nombres_puesto }}">
                {{ $reporte->nombres_puesto }}
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
    $('#toggle-nom').change(function() {
        var columnIndex = 1;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-ifra').change(function() {
        var columnIndex = 3;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-obj').change(function() {
        var columnIndex = 5;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-tabla').change(function() {
        var columnIndex = 9;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-pre').change(function() {
        var columnIndex = 10;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-acce').change(function() {
        var columnIndex = 12;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
</script>
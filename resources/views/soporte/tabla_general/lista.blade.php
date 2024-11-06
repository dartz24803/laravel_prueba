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
            <th>Sede Laboral</th>
            <th>F.de Registro</th>
            <th>Usuario</th>
            <th>Área</th>
            <th>Responsable</th>
            <th>Tipo</th>
            <th>Especialidad</th>
            <th>Elemento</th>
            <th>Asunto</th>
            <th>F.Vencimiento</th>
            <th>F.Completado</th>
            <th>F.R.U</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_tablageneral_soporte as $list)
        <tr>
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
            <td>{{ \Carbon\Carbon::parse($list->fec_vencimiento)->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ \Carbon\Carbon::parse($list->fecha_completado)->locale('es')->translatedFormat('D d M y') }}</td>
            <td>{{ \Carbon\Carbon::parse($list->fec_reg)->locale('es')->translatedFormat('D d M y') }}</td>
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
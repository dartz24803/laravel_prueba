<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Fecha de Solicitud</th>
            <th>Centro de Labores</th>
            <th>Puesto Actual</th>
            <th>Puesto Aspirado</th>
            <th>Colaborador</th>
            <th>Grado de Instrucción</th>
            <th>Observación</th>
            <th>Estado</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_solicitud_puesto as $list)
            <tr class="text-center">
                <td>{{ $list->orden }}</td>
                <td data-order="{{ $list->fecha_solicitud }}">{{ $list->fecha_solicitud }}</td>
                <td>{{ $list->base }}</td>
                <td class="text-left">{{ ucfirst($list->nom_puesto) }}</td>
                <td class="text-left">{{ ucfirst($list->nom_puesto_aspirado) }}</td>
                <td class="text-left">{{ ucwords($list->nom_usuario) }}</td>
                <td class="text-left">{{ $list->grado_instruccion }}</td>
                <td>{{ $list->observacion }}</td>
                <td>
                    <span class="badge badge-{{ $list->color_estado }}">{{ $list->nom_estado }}</span>
                </td>
                <td class="text-center">
                    @if ($list->estado_s==1)
                        <div class="btn-group dropleft" role="group">
                            <a class="dropdown-toggle" href="#" role="button" id="btnDropLeft" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="btnDropLeft">
                                @if ($list->observacion=="Si")
                                    <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#ModalUpdate"
                                    app_elim="{{ route('linea_carrera_so.obs', $list->id_usuario) }}">
                                        Ver observaciones
                                    </a>
                                @endif
                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#ModalUpdate"
                                app_elim="{{ route('linea_carrera_so.edit', $list->id) }}">
                                    Aprobar
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item" onclick="Update_Solicitud_Puesto('{{ $list->id }}',3);">
                                    Rechazar
                                </a>
                            </div>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#tabla_js').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive: true,
        order: [[0,"desc"]],
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
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
    });
</script>

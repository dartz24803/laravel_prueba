<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Orden</th>
            <th width="18%">Puesto Aspirado</th>
            <th width="14%">Centro de Labores</th>
            <th width="18%">Colaborador</th>
            <th width="10%">Fecha</th>
            <th width="10%">Hora Inicio</th>
            <th width="10%">Hora Fin</th>
            <th width="8%">Nota</th>
            <th width="8%">Estado</th>
            <th width="4%" class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_examen_entrenamiento as $list)
            <tr class="text-center">
                <td>{{ $list->orden }}</td> 
                <td class="text-left">{{ ucfirst($list->nom_puesto_aspirado) }}</td>
                <td>{{ $list->base }}</td> 
                <td class="text-left">{{ ucwords($list->nombre_completo) }}</td>
                <td>{{ $list->fecha }}</td>
                <td>{{ $list->hora_inicio }}</td>
                <td>{{ $list->hora_fin }}</td>
                <td @if ($list->nota<14) style="color: red;" @endif>{{ $list->nota }}</td>
                <td>
                    <span class="badge badge-{{ $list->color_estado }}">{{ $list->nom_estado }}</span>
                </td>
                <td class="text-center">
                    @if ($list->hora_fin_real!=null && $list->fecha_revision==null)
                        <a href="javascript:void(0);" title="Revisión" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('linea_carrera_re.edit', $list->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                    @endif
                    @if ($list->fecha_revision!=null)
                        <a href="javascript:void(0);" title="Detalle" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('linea_carrera_re.show', $list->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                    @endif
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
    });
</script>
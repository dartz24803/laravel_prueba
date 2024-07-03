<table id="tabla_js" class="table table-hover" style="width:100%">
    <thead class="text-center">
        <tr>
            @if (session('usuario')->id_nivel==1 || session('usuario')->id_puesto==23)
                <th class="no-content"></th>
            @endif
            <th>Base</th>
            <th>Fecha</th>
            <th>Ingreso P</th>
            <th>Ingreso R</th>
            <th>Diferencia</th>
            <th>Obs</th>
            <th>Apertura P</th>
            <th>Apertura R</th>
            <th>Diferencia</th>
            <th>Obs</th>
            <th>Cierre P</th>
            <th>Cierre R</th>
            <th>Diferencia</th>
            <th>Obs</th>
            <th>Salida P</th>
            <th>Salida R</th>
            <th>Diferencia</th>
            <th>Obs</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_apertura_cierre_tienda as $list)
            <tr class="text-center">
                <td>
                    @if ($list->tipo_apertura!="0" && $list->fecha_v==date('Y-m-d'))
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" 
                        app_elim="{{ route('apertura_cierre.edit', $list->id_apertura_cierre) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </a>
                    @endif

                    @if ($list->archivos>0)
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" 
                        app_elim="{{ route('apertura_cierre.archivo', $list->id_apertura_cierre) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </a>
                    @endif
                </td>
                <td>{{ $list->cod_base }}</td>
                <td>{{ $list->fecha }}</td>
                <td>{{ $list->ingreso_programado }}</td>
                <td>{{ $list->ingreso_real }}</td>
                <td>
                    <span class="badge badge-@php if($list->ingreso_diferencia>0){ echo "success"; }else{ echo "danger"; } @endphp">{{ $list->ingreso_diferencia }}</span>
                </td>
                <td>{{ $list->obs_ingreso }}</td>
                <td>{{ $list->apertura_programada }}</td>
                <td>{{ $list->apertura_real }}</td>
                <td>
                    <span class="badge badge-@php if($list->apertura_diferencia>0){ echo "success"; }else{ echo "danger"; } @endphp">{{ $list->apertura_diferencia }}</span>
                </td>
                <td>{{ $list->obs_apertura }}</td>
                <td>{{ $list->cierre_programado }}</td>
                <td>{{ $list->cierre_real }}</td>
                <td>
                    <span class="badge badge-@php if($list->cierre_diferencia>0){ echo "success"; }else{ echo "danger"; } @endphp">{{ $list->cierre_diferencia }}</span>
                </td>
                <td>{{ $list->obs_cierre }}</td>
                <td>{{ $list->salida_programada }}</td>
                <td>{{ $list->salida_real }}</td>
                <td>
                    <span class="badge badge-@php if($list->salida_diferencia>0){ echo "success"; }else{ echo "danger"; } @endphp">{{ $list->salida_diferencia }}</span>
                </td>
                <td>{{ $list->obs_salida }}</td>
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
        "pageLength": 10
    });
</script>
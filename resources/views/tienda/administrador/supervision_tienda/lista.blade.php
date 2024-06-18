<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Orden</th>
            <th>Base</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Observación</th>
            <th>Evidencia(s)</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_supervision_tienda as $list)
            <tr class="text-center">
                <td>{{ $list->orden }}</td>
                <td>{{ $list->base }}</td>
                <td>{{ $list->fecha }}</td>
                <td>
                    <span class="badge badge-{{ $list->color_estado }}">{{ $list->nom_estado }}</span>
                </td>
                <td class="text-left">{{ $list->observacion }}</td>
                <td>
                    @if ($list->v_evidencia>0)
                        <a href="javascript:void(0);" data-toggle="modal" 
                        data-target="#ModalUpdate" 
                        app_elim="{{ route('administrador_st.evidencia', $list->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </a>
                    @endif
                </td>
                <td class="text-center">
                    <div class="btn-group dropleft" role="group"> 
                        <a id="btnDropLeft" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="btnDropLeft" style="padding:0;">
                            <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" 
                            data-target="#ModalUpdate" 
                            app_elim="{{ route('administrador_st.show', $list->id) }}">
                                Ver
                            </a>
                            @if (session('usuario')->id_puesto!=311)
                                @if (date('Y-m-d')==$list->orden)
                                    <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" 
                                    data-target="#ModalUpdateGrande" 
                                    app_upd_grande="{{ route('administrador_st.edit', $list->id) }}">
                                        Editar
                                    </a>

                                    <a href="javascript:void(0);" class="dropdown-item" 
                                    onclick="Delete_Supervision_Tienda('{{ $list->id }}')">
                                        Eliminar
                                    </a>
                                @endif
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
        @if (session('usuario')->id_nivel==1 || session('usuario')->id_puesto==6 || 
        session('usuario')->id_puesto==12 || session('usuario')->id_puesto==19 || session('usuario')->id_puesto==21 || 
        session('usuario')->id_puesto==23 || session('usuario')->id_puesto==38 || 
        session('usuario')->id_puesto==81 || session('usuario')->id_puesto==111 || 
        session('usuario')->id_puesto==122 || session('usuario')->id_puesto==137 || 
        session('usuario')->id_puesto==164 || session('usuario')->id_puesto==158 || 
        session('usuario')->id_puesto==9 || session('usuario')->id_puesto==128 || 
        session('usuario')->id_puesto==27 || session('usuario')->id_puesto==10)
            $('#tabla_js').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                order: [[0,"desc"],[1,"asc"]],
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
        @else
            $('#tabla_js').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
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
                        'targets' : [ 0,1 ],
                        'visible' : false
                    } 
                ]
            });
        @endif
    });
</script>
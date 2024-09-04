<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th colspan="2"></th>
            <th colspan="3"><b>Ingreso</b></th>
            <th colspan="3"><b>Salida</b></th>
            <?php if(session('usuario')->id_nivel==1 || 
            session('usuario')->id_puesto==19 || 
            session('usuario')->id_puesto==21 || 
            session('usuario')->id_puesto==22 || 
            session('usuario')->id_puesto==23){ ?> 
                <th colspan="3"><b></b></th>
            <?php }else{ ?> 
                <th colspan="2"><b></b></th>
            <?php } ?>
        </tr>
        <tr class="text-center">
            <th>Base</th>
            <th>Colaborador</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Sede</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Sede</th>
            <th>Observaciones</th>
            <th class="no-content">Imagen</th>
            <?php if(session('usuario')->id_nivel==1 || 
            session('usuario')->id_puesto==19 || 
            session('usuario')->id_puesto==21 || 
            session('usuario')->id_puesto==22 || 
            session('usuario')->id_puesto==23){?> 
                <th class="no-content"></th>
            <?php }?>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_manual as $list)
            <tr class="text-center">
                <td>{{ $list->base }}</td>
                <td class="text-left">{{ $list->colaborador }}</td>
                <td>{{ $list->f_ingreso }}</td>
                <td>
                    {{ $list->h_ingreso }}
                    @if (session('usuario')->id_nivel==1 || 
                    session('usuario')->id_puesto==19 || 
                    session('usuario')->id_puesto==21 || 
                    session('usuario')->id_puesto==22 || 
                    session('usuario')->id_puesto==23 ||
                    session('usuario')->id_puesto==24)
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" 
                        app_elim="{{ route('asistencia_seg_man.edit', [$list->id_seguridad_asistencia, 'ingreso']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>
                    @else
                        @if ((session('usuario')->id_puesto==24 || 
                        session('usuario')->id_puesto==36) && 
                        $list->h_ingreso=="")
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" 
                            app_elim="{{ route('asistencia_seg_man.edit', [$list->id_seguridad_asistencia, 'ingreso']) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a>
                        @endif
                    @endif
                </td>
                <td>{{ $list->cod_sede }}</td>
                <td>{{ $list->f_salida }}</td>
                <td>
                    {{ $list->h_salida }}
                    @if (session('usuario')->id_nivel==1 || 
                    session('usuario')->id_puesto==19 || 
                    session('usuario')->id_puesto==21 || 
                    session('usuario')->id_puesto==22 || 
                    session('usuario')->id_puesto==23 ||
                    session('usuario')->id_puesto==24)
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" 
                        app_elim="{{ route('asistencia_seg_man.edit', [$list->id_seguridad_asistencia, 'salida']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>
                    @else
                        @if ((
                        session('usuario')->id_puesto==36) && 
                        $list->h_ingreso=="")
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" 
                            app_elim="{{ route('asistencia_seg_man.edit', [$list->id_seguridad_asistencia, 'salida']) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a>
                        @endif
                    @endif                    
                </td>
                <td>{{ $list->cod_sedes }}</td>
                <td class="text-left">
                    {{ nl2br($list->observacion) }}
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" 
                    app_elim="{{ route('asistencia_seg_man.obs', $list->id_seguridad_asistencia) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                </td>
                <td>
                    @if ($list->imagen!="")
                        <a href="{{ $list->imagen }}" target="_blank" title="Imagen">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </a>
                    @endif
                    @if (session('usuario')->id_nivel==1 || 
                    session('usuario')->id_puesto==19 || 
                    session('usuario')->id_puesto==21 || 
                    session('usuario')->id_puesto==22 || 
                    session('usuario')->id_puesto==23)
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" 
                        app_elim="{{ route('asistencia_seg_man.image', $list->id_seguridad_asistencia) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>
                    @else
                        @if ((session('usuario')->id_puesto==24 || 
                        session('usuario')->id_puesto==36) && 
                        $list->imagen=="")
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdate" 
                            app_elim="{{ route('asistencia_seg_man.image', $list->id_seguridad_asistencia) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a>
                        @endif
                    @endif 
                </td>
                @if (session('usuario')->id_nivel==1 || 
                session('usuario')->id_puesto==19 || 
                session('usuario')->id_puesto==21 || 
                session('usuario')->id_puesto==22 || 
                session('usuario')->id_puesto==23)
                    <td>
                        <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Manual('{{ $list->id_seguridad_asistencia }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                    </td>
                @endif
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
    });
</script>
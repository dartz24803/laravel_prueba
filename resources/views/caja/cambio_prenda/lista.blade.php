<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Fecha registro</th>
            <th>Base</th>
            <th>Registrado por</th>
            <th>Comprobante</th>
            <th>Cantidad</th>
            <th>Motivo</th>
            <th>Nuevo comprobante</th>
            <th>Nuevo n° serie</th>
            <th>Estado</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_cambio_prenda as $list)
            <tr class="text-center">
                <td>{{ $list->fecha }}</td>
                <td>{{ $list->base }}</td>
                <td class="text-left">{{ $list->registrado_por }}</td>
                <td>{{ $list->n_documento }}</td>
                <td>{{ $list->cant_total }}</td>
                <td class="text-left">{{ $list->nom_motivo }}</td>
                <td>{{ $list->nuevo_num_comprobante }}</td>
                <td>{{ $list->nuevo_num_serie }}</td>
                <td class="text-left">{{ $list->estado_ap }}</td>
                <td>
                    @if ((session('usuario')->id_nivel=="1" || 
                    session('usuario')->id_puesto=="36" ||
                    session('usuario')->id_puesto=="29" ||
                    session('usuario')->id_puesto=="30" ||
                    session('usuario')->id_puesto=="31" ||
                    session('usuario')->id_puesto=="128" ||
                    session('usuario')->id_puesto=="27" ||
                    session('usuario')->id_puesto=="197" ||
                    session('usuario')->id_puesto=="161") && 
                    ($list->estado_cambio=="1" ||
                    $list->estado_cambio=="2"))
                        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('cambio_prenda.edit', $list->id_cambio_prenda) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>
                    @endif
                    @if ((session('usuario')->id_nivel=="1" ||
                    session('usuario')->id_puesto=="29" ||
                    session('usuario')->id_puesto=="30" ||
                    session('usuario')->id_puesto=="31" ||
                    session('usuario')->id_puesto=="128" ||
                    session('usuario')->id_puesto=="27" ||
                    session('usuario')->id_puesto=="197" ||
                    session('usuario')->id_puesto=="161") && 
                    $list->estado_cambio=="1")
                        <a href="javascript:void(0);" title="Aprobar" onclick="Cambiar_Estado_Cambio_Prenda('{{ $list->id_cambio_prenda }}','2')">
                            <svg title="Aprobar" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </a>
                        <a href="javascript:void(0);" title="Denegar" onclick="Cambiar_Estado_Cambio_Prenda('{{ $list->id_cambio_prenda }}','3')">
                            <svg title="Denegar" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x text-danger">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </a>
                    @endif
                    @if ((session('usuario')->id_nivel=="1" ||
                    session('usuario')->id_puesto=="36" ||
                    session('usuario')->id_puesto=="29" ||
                    session('usuario')->id_puesto=="30" ||
                    session('usuario')->id_puesto=="31" ||
                    session('usuario')->id_puesto=="128" ||
                    session('usuario')->id_puesto=="27" ||
                    session('usuario')->id_puesto=="197" ||
                    session('usuario')->id_puesto=="161") && 
                    ($list->estado_cambio=="1" ||
                    $list->estado_cambio=="2"))
                        <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Cambio_Prenda('{{ $list->id_cambio_prenda }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                    @endif
                    @if ((session('usuario')->id_nivel=="1" ||
                    session('usuario')->id_puesto=="29" ||
                    session('usuario')->id_puesto=="32" ||
                    session('usuario')->id_puesto=="31" ||
                    session('usuario')->id_puesto=="33" ||
                    session('usuario')->id_puesto=="167") && 
                    $list->estado_cambio=="2")
                        <a href="javascript:void(0);" title="Finalizar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('cambio_prenda.modal_finalizar', $list->id_cambio_prenda) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </a>
                    @endif
                    <a href="javascript:void(0);" title="Detalle" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('cambio_prenda.detalle', $list->id_cambio_prenda) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </a>
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
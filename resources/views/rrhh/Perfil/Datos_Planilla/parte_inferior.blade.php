<div class="col-lg-12">
    <div class="table-responsive">
        <table class="table" id="tabla_js_planilla" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>Orden</th>
                    <th>Estado</th>
                    <th>Situacion Laboral</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Empresa</th>
                    <th>Días Laborados</th>
                    <th>Sueldo</th>
                    <th>Bono</th>
                    <th>Total</th>
                    <th>Observaciones</th>
                    <th>Motivo Cese</th>
                    <th class="no-content"></th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($list_planilla as $list)
                    <tr class="text-center">
                        <td>{{ $list->orden }}</td>
                        <td>{{ $list->nom_estado }}</td>
                        <td class="text-left">{{ $list->nom_situacion_laboral }}</td>
                        <td>{{ $list->fec_inicio }}</td>
                        <td>{{ $list->fec_fin }}</td>
                        <td class="text-left">{{ $list->nom_empresa }}</td>
                        <td><span class="badge badge-success">{{ $list->dias_laborados }}</span></td>
                        <td class="text-right">{{ $list->sueldo }}</td>
                        <td class="text-right">{{ $list->bono }}</td>
                        <td class="text-right">{{ $list->total }}</td>
                        <td class="text-left">{{ $list->observacion }}</td>
                        <td>
                            {{ $list->nom_motivo }}
                            @if ($list->archivo_cese!="")
                                <a href="{{ $list->archivo_cese }}" title="Archivo cese" target="_blank">
                                    <svg version="1.1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                    </svg>
                                </a>
                            @endif
                        </td>
                        <td>
                            @if ($list->estado!="3")
                                <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" 
                                app_elim="{{ route('colaborador_pl.edit',$list->id_historico_colaborador) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            @else
                                <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" 
                                app_elim="{{ route('colaborador_pl.edit_finalizado',$list->id_historico_colaborador) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            @endif

                            {{--No se usa desde el 2021 los documentos--}}
                            {{--<a href="javascript:void(0);" title="Documentos" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" 
                            app_reg="{{ route('colaborador_pl.modal_documento',$list->id_historico_colaborador) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                                    <line x1="12" y1="11" x2="12" y2="17"></line>
                                    <line x1="9" y1="14" x2="15" y2="14"></line>
                                </svg>
                            </a>--}}

                            @if ($list->id_situacion_laboral=="2")
                                {{--Aquí va el contrato--}}
                            @endif

                            @if ($i=="1")
                                <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Planilla('{{ $list->id_historico_colaborador }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </a>
                            @endif
                        </td>
                    </tr>
                @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tabla_js_planilla').DataTable({
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
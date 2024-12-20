<style>
    table.table td {
        white-space: normal !important;
    }
</style>

<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Orden</th>
            <th>Fecha</th>
            <th>Base</th>
            <th>N° de OBER</th>
            <th>Tipo Error</th>
            <th>Error</th>
            <th>Monto</th>
            <th>Suceso</th>
            <th>Responsable</th>
            @if (session('usuario')->id_nivel==1 ||
            session('usuario')->id_puesto==9 ||
            session('usuario')->id_puesto==29 ||
            session('usuario')->id_puesto==31 ||
            session('usuario')->id_puesto==32 ||
            session('usuario')->id_puesto==128)
            <th class="no-content"></th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($list_suceso as $list)
        <tr class="text-center">
            <td>{{ $list->orden }}</td>
            <td data-order="{{ $list->orden }}">{{ $list->fecha }}</td>
            <td>{{ $list->centro_labores }}</td>
            <td>{{ $list->cod_suceso }}</td>
            <td class="text-left">{{ $list->nom_tipo_error }}</td>
            <td class="text-left">{{ $list->nom_error }}</td>
            <td>{{ number_format($list->monto,2) }}</td>
            <td class="text-left">
                @if ($list->nom_suceso!="")
                <a href="javascript:void(0);" title="Suceso" data-toggle="modal"
                    data-target="#ModalUpdate"
                    app_elim="{{ route('observacion.modal_suceso', $list->id_suceso) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                    </svg>
                </a>
                @endif
                {{ $list->nom_suceso }}
            </td>
            <td class="text-left">{{ $list->user_suceso }}</td>
            @if (session('usuario')->id_nivel==1 ||
            session('usuario')->id_puesto==9 ||
            session('usuario')->id_puesto==29 ||
            session('usuario')->id_puesto==31 ||
            session('usuario')->id_puesto==32 ||
            session('usuario')->id_puesto==128)
            <td class="text-center">
                @if ($list->archivo!="")
                <a style="cursor:pointer;display: -webkit-inline-box;" title="Archivo" href="{{ $list->archivo }}" target="_blank">
                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533
                                        s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2
                                        s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667
                                        s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733
                                        c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />

                    </svg>
                </a>
                @endif
                @if ($list->estado_suceso==1)
                @if (session('usuario')->id_nivel==1 ||
                session('usuario')->id_puesto==9 ||
                session('usuario')->id_puesto==128)
                <a href="javascript:void(0);" title="Cambiar Estado" onclick="Cambiar_Estado_Suceso('{{ $list->id_suceso }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square text-primary">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </a>
                @endif
                <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('observacion.edit', $list->id_suceso) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                    </svg>
                </a>
                <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Suceso('{{ $list->id_suceso }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </a>
                @elseif($list->estado_suceso==2 &&
                (session('usuario')->id_nivel==1 ||
                session('usuario')->id_puesto==128 ||
                session('usuario')->id_puesto==9))
                <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('observacion.edit', $list->id_suceso) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                    </svg>
                </a>
                @endif
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
            autoWidth: true,
            order: [
                [0, "asc"]
            ],
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
            "aoColumnDefs": [{
                'targets': [0],
                'visible': false
            }]
        });
    });
</script>
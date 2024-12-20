<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Orden</th>
            <th>Fecha solicitud</th>
            <th>Ubicación</th>
            <th>Categoría</th>
            <th>Sub-Categoría</th>
            <th>Empresa</th>
            <th>Movimiento</th>
            <th>Tipo comprobante</th>
            <th>N° comprobante</th>
            <th>Solicitante</th>
            <th>RUC</th>
            <th>Razón Social</th>
            <th>Detalle</th>
            <th>Descripción</th>
            <th>Total</th>
            <th>Estado</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @php
            $ing_soles = 0;
            $ing_dolares = 0;
            $sal_soles = 0;
            $sal_dolares = 0;
        @endphp
        @foreach ($list_caja_chica as $list)
            @php
                if($list->id_tipo_moneda=="1" && $list->tipo_movimiento=="1" && $list->estado_c!="3"){
                    $ing_soles = $ing_soles+$list->total;
                }
                if($list->id_tipo_moneda=="2" && $list->tipo_movimiento=="1" && $list->estado_c!="3"){
                    $ing_dolares = $ing_dolares+$list->total;
                }
                if($list->id_tipo_moneda=="1" && $list->tipo_movimiento=="2" && $list->estado_c!="3"){
                    $sal_soles = $sal_soles+$list->total;
                }
                if($list->id_tipo_moneda=="2" && $list->tipo_movimiento=="2" && $list->estado_c!="3"){
                    $sal_dolares = $sal_dolares+$list->total;
                }
            @endphp
            <tr class="text-center">
                <td>{{ $list->orden }}</td>
                <td data-order="{{ $list->orden }}">{{ $list->fecha }}</td>
                <td>{{ $list->cod_ubi }}</td>
                <td class="text-left">{{ $list->nom_categoria }}</td>
                <td class="text-left">{{ $list->nombre }}</td>
                <td class="text-left">{{ $list->nom_empresa }}</td>
                <td>{{ $list->movimiento }}</td>
                <td>{{ $list->nom_tipo_comprobante }}</td>
                <td>{{ $list->n_comprobante }}</td>
                <td class="text-left">{{ $list->nom_solicitante }}</td>
                <td>{{ $list->ruc }}</td>
                <td class="text-left">{{ $list->razon_social }}</td>
                <td>
                    <a href="javascript:void(0);" data-toggle="modal"
                    data-target="#ModalUpdate"
                    app_elim="{{ route('caja_chica.show', $list->id) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </a>
                </td>
                <td class="text-left">{{ $list->descripcion }}</td>
                <td>{{ $list->total_concatenado }}</td>
                <td style="background-color: {{ $list->color_estado }}; color:white;">{{ $list->nom_estado }}</td>
                <td>
                    @if ($list->estado_c=="1")
                        <a href="javascript:void(0);" title="Aprobar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('caja_chica.validar', $list->id) }}">
                            <svg title="Aprobar" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </a>
                        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('caja_chica.edit', $list->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>
                    @endif
                    @if ($list->comprobante!="")
                        <a href="{{ $list->comprobante }}" title="Comprobante" target="_blank">
                            <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                                <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                                <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                                <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                                <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                            </svg>
                        </a>
                    @endif
                    @if ($list->estado_c!="3")
                        <a href="javascript:void(0)" title="Anular" onclick="Anular_Caja_Chica('{{ $list->id }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-danger">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                        </a>
                    @endif
                    @if ($list->estado_c=="1")
                        <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Caja_Chica('{{ $list->id }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="row mr-1 ml-1 mb-2">
    <div class="col-sm-5 col-lg-2">
        <label>Ingresos (Soles):</label>
        <input type="text" class="form-control" value="{{ "S/ ".$ing_soles }}" disabled>
    </div>

    <div class="col-sm-5 col-lg-2">
        <label>Salidas (Soles):</label>
        <input type="text" class="form-control" value="{{ "S/ ".$sal_soles }}" disabled>
    </div>

    <div class="col-sm-5 col-lg-2">
        <label>Saldo (Soles):</label>
        <input type="text" class="form-control" value="{{ "S/ ".($ing_soles-$sal_soles) }}" disabled>
    </div>
</div>
<div class="row mr-1 ml-1 mb-4">
    <div class="col-sm-5 col-lg-2">
        <label>Ingresos (Dólares):</label>
        <input type="text" class="form-control" value="{{ "$ ".$ing_dolares }}" disabled>
    </div>
    <div class="col-sm-5 col-lg-2">
        <label>Salidas (Dólares):</label>
        <input type="text" class="form-control" value="{{ "$ ".$sal_dolares }}" disabled>
    </div>
    <div class="col-sm-5 col-lg-2">
        <label>Saldo (Dólares):</label>
        <input type="text" class="form-control" value="{{ "$ ".($ing_dolares-$sal_dolares) }}" disabled>
    </div>
</div>

<script>
    var tabla = $('#tabla_js').DataTable({
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
                'targets' : [ 0,4,5,6,8,10,12 ],
                'visible' : false
            }
        ]
    });

    $('#toggle-sc').change(function() {
        var columnIndex = 4;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-em').change(function() {
        var columnIndex = 5;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-mo').change(function() {
        var columnIndex = 6;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-nc').change(function() {
        var columnIndex = 8;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-ru').change(function() {
        var columnIndex = 10;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-de').change(function() {
        var columnIndex = 12;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
</script>

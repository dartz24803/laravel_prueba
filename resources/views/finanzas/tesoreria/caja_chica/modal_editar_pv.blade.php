<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar caja chica - Pagos varios:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Ubicación:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_ubicacione" id="id_ubicacione" onchange="Traer_Categoria('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_ubicacion as $list)
                        <option value="{{ $list->id_ubicacion }}"
                        @if ($list->id_ubicacion==$get_id->id_ubicacion) selected @endif>
                            {{ $list->cod_ubi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Categoría:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_categoriae" id="id_categoriae" onchange="Traer_Sub_Categoria_Pv('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_categoria as $list)
                        <option value="{{ $list->id_categoria }}"
                        @if ($list->id_categoria==$get_id->id_categoria) selected @endif>
                            {{ $list->nom_categoria }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Fecha:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fechae" id="fechae" value="{{ $get_id->fecha }}">
            </div>

            <div class="form-group col-lg-2">
                <label>Sub-Categoría:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_sub_categoriae" id="id_sub_categoriae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sub_categoria as $list)
                        <option value="{{ $list->id }}"
                        @if ($list->id==$get_id->id_sub_categoria) selected @endif>
                            {{ $list->nombre }}
                        </option> 
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Empresa:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basic" name="id_empresae" id="id_empresae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_empresa as $list)
                        <option value="{{ $list->id_empresa }}" 
                        @if ($list->id_empresa==$get_id->id_empresa) selected @endif>
                            {{ $list->nom_empresa }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Total:</label>
            </div>
            <div class="form-group col-lg-4 input-group mb-4">
                <div class="input-group-prepend">
                    <select class="form-control" name="id_tipo_monedae" id="id_tipo_monedae">
                        @foreach ($list_tipo_moneda as $list)
                            <option value="{{ $list->id_moneda }}"
                            @if ($list->id_moneda==$get_id->id_tipo_moneda) selected @endif>
                                {{ $list->cod_moneda }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="text" class="form-control" name="totale" id="totale" placeholder="Total" 
                onkeypress="return solo_Numeros_Punto(event);" onpaste="return false;"
                value="{{ $get_id->total }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-12">
                <label style="font-weight:bolder;
                color:black;
                text-decoration:underline;">
                    Parte interesada:
                </label>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>RUC:</label>
                <a href="javascript:void(0);" title="Consultar RUC" onclick="Consultar_Ruc('e');">
                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                    </svg>
                </a>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="ruce" id="ruce" placeholder="RUC" 
                maxlength="11" onkeypress="return solo_Numeros(event);" onpaste="return false;"
                value="{{ $get_id->ruc }}">
            </div>

            <div class="form-group col-lg-2">
                <label>Razón social:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="razon_sociale" id="razon_sociale" 
                placeholder="Razón social" value="{{ $get_id->razon_social }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>N° comprobante:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="n_comprobantee" id="n_comprobantee" 
                placeholder="N° comprobante" onkeypress="return solo_Numeros(event);" onpaste="return false;"
                value="{{ $get_id->n_comprobante }}">
            </div>

            <div class="form-group col-lg-2">
                <label>Tipo comprobante:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo_comprobantee" id="id_tipo_comprobantee">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_comprobante as $list)
                        <option value="{{ $list->id }}"
                        @if ($list->id==$get_id->id_tipo_comprobante) selected @endif>
                            {{ $list->nom_tipo_comprobante }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="punto_partidae" id="punto_partidae" 
                placeholder="Descripción" value="{{ $get_id->punto_partida }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Cargar comprobante:</label>
                @if ($get_id->comprobante!="")
                    <a href="javascript:void(0);" title="Descargar" onclick="Descargar_Archivo('{{ $get_id->id }}');">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud text-dark">
                            <polyline points="8 17 12 21 16 17"></polyline>
                            <line x1="12" y1="12" x2="12" y2="21"></line>
                            <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                        </svg>
                    </a>
                @endif
            </div>
            <div class="form-group col-lg-10">
                <input type="file" class="form-control-file" name="comprobantee" id="comprobantee" 
                onchange="Valida_Archivo('comprobantee');">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Caja_Chica_Pv();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basic").select2({
        tags: true,
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Caja_Chica_Pv() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('caja_chica.update_pv', $get_id->id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    '¡Actualización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Caja_Chica();
                    $("#ModalUpdate .close").click();
                })
            },
            error:function(xhr) {
                var errors = xhr.responseJSON.errors;
                var firstError = Object.values(errors)[0][0];
                Swal.fire(
                    '¡Ups!',
                    firstError,
                    'warning'
                );
            }
        });
    }
</script>

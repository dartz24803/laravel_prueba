<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar letra por cobrar:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Empresa:</label>
                <select class="form-control basice" name="id_empresae" id="id_empresae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_empresa as $list)
                        <option value="{{ $list->id_empresa }}"
                        @if ($list->id_empresa==$get_id->id_empresa) selected @endif>
                            {{ $list->nom_empresa }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>Fecha emisión:</label>
                <input type="date" class="form-control" name="fec_emisione" id="fec_emisione" 
                value="{{ $get_id->fec_emision }}">
            </div>

            <div class="form-group col-lg-3">
                <label>Fecha vencimiento:</label>
                <input type="date" class="form-control" name="fec_vencimientoe" id="fec_vencimientoe"
                value="{{ $get_id->fec_vencimiento }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label>Tipo documento:</label>
                <select class="form-control" name="id_tipo_documentoe" id="id_tipo_documentoe">
                    <option value="0">Seleccione</option>
                    <option value="1" @if ($get_id->id_tipo_documento=="1") selected @endif>Cheque</option>
                    <option value="2" @if ($get_id->id_tipo_documento=="2") selected @endif>Letra</option>
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>N° documento:</label>
                <input type="text" class="form-control" name="num_doce" id="num_doce" 
                placeholder="N° documento" value="{{ $get_id->num_doc }}">
            </div>

            <div class="form-group col-lg-6">
                <label>Aceptante:</label>
                <select class="form-control basice" name="id_aceptantee" id="id_aceptantee">
                    <option value="0">Seleccione</option>
                    @foreach ($list_aceptante as $list)
                        <option value="{{ $list->id_aceptante }}"
                        @if ($list->id_aceptante==$get_id->tipo_doc_aceptante."_".$get_id->num_doc_aceptante) selected @endif>
                            {{ $list->nom_aceptante }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label>Tipo comprobante:</label>
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

            <div class="form-group col-lg-3">
                <label>N° comprobante:</label>
                <input type="text" class="form-control" name="num_comprobantee" id="num_comprobantee" 
                placeholder="N° comprobante" value="{{ $get_id->num_comprobante }}">
            </div>

            <div class="form-group col-lg-3">
                <label>Monto:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select class="form-control" name="id_monedae" id="id_monedae">
                            @foreach ($list_tipo_moneda as $list)
                                <option value="{{ $list->id_moneda }}"
                                @if ($list->id_moneda==$get_id->id_moneda) selected @endif>
                                    {{ $list->cod_moneda }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" class="form-control" name="montoe" id="montoe" placeholder="Monto" 
                    onkeypress="return solo_Numeros_Punto(event);" onpaste="return false;" 
                    value="{{ $get_id->monto }}">
                </div>
            </div>

            <div class="form-group col-lg-3">
                <label>Negociado/Endosado:</label>
                <select class="form-control" name="negociado_endosadoe" id="negociado_endosadoe" 
                onchange="Negociado_Endosado('e');">
                    <option value="0">Seleccione</option>
                    <option value="1" @if ($get_id->negociado_endosado=="1") selected @endif>Negociado</option>
                    <option value="2" @if ($get_id->negociado_endosado=="2") selected @endif>Endosado</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-6 empresa_vinculadae" @if ($get_id->negociado_endosado!="2") style="display: none;" @endif>
                <label>Empresa vinculada:</label>
                <select class="form-control basice" name="id_empresa_vinculadae" id="id_empresa_vinculadae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_aceptante as $list)
                        <option value="{{ $list->id_aceptante }}"
                        @if ($list->id_aceptante==$get_id->tipo_doc_emp_vinculada."_".$get_id->num_doc_emp_vinculada) selected @endif>
                            {{ $list->nom_aceptante }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-4">
                <label>Comprobante:</label>
                @if ($get_id->documento!="")
                    <a href="{{ $get_id->documento }}" title="Documento" target="_blank">
                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                        </svg>
                    </a>
                @endif
                <input type="file" class="form-control-file" name="documentoe" id="documentoe" 
                onchange="Valida_Archivo('documentoe');">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Letra_Cobrar();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basice").select2({
        tags: true,
        dropdownParent: $('#ModalUpdateGrande')
    });

    function Update_Letra_Cobrar() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('letra_cobrar.update', $get_id->id_cheque_letra) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡Existe un registro con los mismos datos (Empresa, F. vencimiento y N° documento)!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Letra_Cobrar();
                        $("#ModalUpdateGrande .close").click();
                    })
                }
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

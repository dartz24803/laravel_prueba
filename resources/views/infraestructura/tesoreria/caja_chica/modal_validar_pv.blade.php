<form id="formulariov" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Validación de registro - Pagos varios:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Pago:</label>
                <a href="javascript:void(0);" id="pago_credito" title="Credito" data-toggle="modal" 
                data-target="#ModalUpdate" app_elim="{{ route('caja_chica.credito', $get_id->id) }}"
                style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                </a>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_pagov" id="id_pagov" onchange="Traer_Pago('v'); Mostrar_Credito();">
                    <option value="0">Seleccione</option>
                    @foreach ($list_pago as $list)
                        <option value="{{ $list->id_pago }}"
                        @if ($list->id_pago==$get_id->id_pago) selected @endif>
                            {{ $list->nom_pago }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Tipo pago:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo_pagov" id="id_tipo_pagov">
                    @foreach ($list_tipo_pago as $list)
                        <option value="{{ $list->id }}"
                        @if ($list->id==$get_id->id_tipo_pago) selected @endif>
                            {{ $list->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Cuenta 1:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="cuenta_1v" id="cuenta_1v">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Cuenta 2:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="cuenta_2v" id="cuenta_2v">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Fecha pago:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fecha_pagov" id="fecha_pagov" 
                value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Categoría:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->nom_categoria }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>Sub-Categoría:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->nombre }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Tipo comprobante:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->nom_tipo_comprobante }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>N° comprobante:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->n_comprobante }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" value="{{ $get_id->descripcion }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Monto:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->total_concatenado }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>Ubicación:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->cod_ubi }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Empresa:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->nom_empresa }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>Parte interesada:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->razon_social }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Evidencias:</label>
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
                <input type="text" class="form-control" value="{{ $get_id->nom_comprobante }}" disabled>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Validar_Caja_Chica_Pv();">Validar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cancelar</button>
    </div>
</form>

<script>
    Mostrar_Credito();

    function Mostrar_Credito(){
        Cargando();

        var id_pago = $('#id_pagov').val();

        if(id_pago=="2"){
            $('#pago_credito').show();
            $('#fecha_pagov').prop('disabled', true);
        }else{
            $('#pago_credito').hide();
            $('#fecha_pagov').prop('disabled', false);
        }
    }

    function Validar_Caja_Chica_Pv() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulariov'));
        var url = "{{ route('caja_chica.validar_pv', $get_id->id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="credito"){
                    $("#pago_en_credito").click();
                }else{
                    swal.fire(
                        '¡Validación Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Caja_Chica();
                        $("#ModalRegistro .close").click();
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

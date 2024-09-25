<style>
    input[type="radio"]:disabled + label {
        color: inherit !important;
    }
</style>

<form id="formularios" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"> @if ($tipo=="1") Registar @elseif ($tipo=="2") Actualizar @else Ver @endif pago:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Fecha pago:</label>
                <input type="date" class="form-control" name="fec_pagos" id="fec_pagos"
                @if ($tipo=="2" || $tipo=="3") value="{{ $get_id->fec_pago }}" @endif 
                @if ($tipo=="3") disabled @endif>
            </div>

            <div class="form-group col-lg-6">
                <label>N° operación:</label>
                <input type="text" class="form-control" name="noperacions" id="noperacions"
                placeholder="N° operación" onkeypress="return solo_Numeros(event);" 
                @if ($tipo=="2" || $tipo=="3") value="{{ $get_id->noperacion }}" @endif 
                @if ($tipo=="3") disabled @endif>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-6">
                <label>Comprobante:</label>
                @if ($get_id->comprobante_pago!="")
                    <a href="{{ $get_id->comprobante_pago }}" title="Comprobante" target="_blank">
                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                        </svg>
                    </a>
                @endif
                <input type="file" class="form-control-file" name="comprobante_pagos" 
                id="comprobante_pagos" onchange="Valida_Archivo('comprobante_pagos');">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        @if ($tipo=="1" || $tipo=="2")
            <button class="btn btn-primary" type="button" onclick="Update_Estado();">Guardar</button>
        @endif
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Estado() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularios'));
        var url = "{{ route('registro_letra.update_estado', $get_id->id_cheque_letra) }}";

        if ({{ $tipo }}=="1"){
            var titulo = "registrar";
            var texto = "guardado";
        }else{
            var titulo = "actualizar";
            var texto = "actualizado";
        }

        Swal({
            title: '¿Realmente desea '+titulo+' pago?',
            text: "El registro será "+texto,
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
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
                                text: "¡Existe un registro con el mismo número único!",
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
                                Lista_Registro_Letra();
                                $("#ModalUpdate .close").click();
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
        })
    }
</script>

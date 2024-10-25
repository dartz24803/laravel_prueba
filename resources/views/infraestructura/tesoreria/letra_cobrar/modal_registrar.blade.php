<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nueva letra por cobrar:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Empresa:</label>
                <select class="form-control basic" name="id_empresa" id="id_empresa">
                    <option value="0">Seleccione</option>
                    @foreach ($list_empresa as $list)
                        <option value="{{ $list->id_empresa }}">{{ $list->nom_empresa }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>Fecha emisión:</label>
                <input type="date" class="form-control" name="fec_emision" id="fec_emision" 
                value="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group col-lg-3">
                <label>Fecha vencimiento:</label>
                <input type="date" class="form-control" name="fec_vencimiento" id="fec_vencimiento">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label>Tipo documento:</label>
                <select class="form-control" name="id_tipo_documento" id="id_tipo_documento">
                    <option value="0">Seleccione</option>
                    <option value="1">Cheque</option>
                    <option value="2">Letra</option>
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>N° documento:</label>
                <input type="text" class="form-control" name="num_doc" id="num_doc" 
                placeholder="N° documento">
            </div>

            <div class="form-group col-lg-6">
                <label>Cliente:</label>
                <select class="form-control basic" name="id_cliente" id="id_cliente">
                    <option value="0">Seleccione</option>
                    @foreach ($list_cliente as $list)
                        <option value="{{ $list->id_cliente }}">{{ $list->nom_cliente }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3">
                <label>Tipo comprobante:</label>
                <select class="form-control" name="id_tipo_comprobante" id="id_tipo_comprobante">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_comprobante as $list)
                        <option value="{{ $list->id }}">{{ $list->nom_tipo_comprobante }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-3">
                <label>N° comprobante:</label>
                <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" 
                placeholder="N° comprobante">
            </div>

            <div class="form-group col-lg-3">
                <label>Monto:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select class="form-control" name="id_moneda" id="id_moneda">
                            @foreach ($list_tipo_moneda as $list)
                                <option value="{{ $list->id_moneda }}">{{ $list->cod_moneda }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" class="form-control" name="monto" id="monto" placeholder="Monto" 
                    onkeypress="return solo_Numeros_Punto(event);" onpaste="return false;">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-4">
                <label>Comprobante:</label>
                <input type="file" class="form-control-file" name="documento" id="documento" 
                onchange="Valida_Archivo('documento');">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Letra_Cobrar();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basic").select2({
        tags: true,
        dropdownParent: $('#ModalRegistroGrande')
    });

    function Insert_Letra_Cobrar() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('letra_cobrar.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡Existe un registro con los mismos datos (Empresa, F. vencimiento y N° documento)!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Letra_Cobrar();
                        $("#ModalRegistroGrande .close").click();
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

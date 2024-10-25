<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo cheque:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Empresa:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basic" name="id_empresa" id="id_empresa">
                    <option value="0">Seleccione</option>
                    @foreach ($list_empresa as $list)
                        <option value="{{ $list->id_empresa }}">{{ $list->nom_empresa }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Banco:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_banco" id="id_banco">
                    <option value="0">Seleccione</option>
                    @foreach ($list_banco as $list)
                        <option value="{{ $list->id_banco }}">{{ $list->nom_banco }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">N° cheque:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="n_cheque" id="n_cheque" 
                placeholder="N° cheque" onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha emisión:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fec_emision" id="fec_emision">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha vencimiento:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fec_vencimiento" id="fec_vencimiento">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Girado:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basic" name="id_girado" id="id_girado">
                    <option value="0">Seleccione</option>
                    @foreach ($list_girado as $list)
                        <option value="{{ $list->id_girado }}">{{ $list->nom_girado }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Concepto:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="concepto" id="concepto">
                    <option value="0">Seleccione</option>
                    @foreach ($list_concepto as $list)
                        <option value="{{ $list->id_concepto_cheque }}">{{ $list->nom_concepto_cheque }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo moneda:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_moneda" id="id_moneda">
                    @foreach ($list_tipo_moneda as $list)
                        <option value="{{ $list->id_moneda }}">{{ $list->nom_moneda }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Importe:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="importe" id="importe" placeholder="Importe" 
                onkeypress="return solo_Numeros_Punto(event);" onpaste="return false;">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Registro_Cheque();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basic").select2({
        tags: true,
        dropdownParent: $('#ModalRegistro')
    });

    function Insert_Registro_Cheque() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('registro_cheque.store') }}";

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
                        text: "¡Existe un registro con los mismos datos! (Empresa, N° Cheque, Moneda)",
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
                        Lista_Registro_Cheque();
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
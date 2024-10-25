<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar cheque:</h5>
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
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Banco:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_bancoe" id="id_bancoe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_banco as $list)
                        <option value="{{ $list->id_banco }}"
                        @if ($list->id_banco==$get_id->id_banco) selected @endif>
                            {{ $list->nom_banco }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">N° cheque:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="n_chequee" id="n_chequee" 
                placeholder="N° cheque" onkeypress="return solo_Numeros(event);" value="{{ $get_id->n_cheque }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha emisión:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fec_emisione" id="fec_emisione" 
                value="{{ $get_id->fec_emision }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha vencimiento:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fec_vencimientoe" id="fec_vencimientoe" 
                value="{{ $get_id->fec_vencimiento }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Girado:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basice" name="id_giradoe" id="id_giradoe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_girado as $list)
                        <option value="{{ $list->id_girado }}"
                        @if ($list->id_girado==$get_id->tipo_doc."_".$get_id->num_doc) selected @endif>
                            {{ $list->nom_girado }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Concepto:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="conceptoe" id="conceptoe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_concepto as $list)
                        <option value="{{ $list->id_concepto_cheque }}"
                        @if ($list->id_concepto_cheque==$get_id->concepto) selected @endif>
                            {{ $list->nom_concepto_cheque }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo moneda:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_monedae" id="id_monedae">
                    @foreach ($list_tipo_moneda as $list)
                        <option value="{{ $list->id_moneda }}"
                        @if ($list->id_moneda==$get_id->id_moneda) selected @endif>
                            {{ $list->nom_moneda }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Importe:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="importee" id="importee" placeholder="Importe" 
                onkeypress="return solo_Numeros_Punto(event);" onpaste="return false;" 
                value="{{ $get_id->importe }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Registro_Cheque();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basice").select2({
        tags: true,
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Registro_Cheque() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('registro_cheque.update', $get_id->id_cheque) }}";

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
                        text: "¡Existe un registro con los mismos datos! (Empresa, N° Cheque, Moneda)",
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
                        Lista_Registro_Cheque();
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
</script>

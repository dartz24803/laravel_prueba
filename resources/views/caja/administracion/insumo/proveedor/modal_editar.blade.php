<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar proveedor:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Razón social:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="nom_proveedore" id="nom_proveedore" 
                placeholder="Razón social" value="{{ $get_id->nom_proveedor }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">RUC:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="ruc_proveedore" id="ruc_proveedore" 
                placeholder="RUC" onkeypress="return solo_Numeros(event);" 
                value="{{ $get_id->ruc_proveedor }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Dirección:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="direccion_proveedore" 
                id="direccion_proveedore" placeholder="Dirección" 
                value="{{ $get_id->direccion_proveedor }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Teléfono:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="telefono_proveedore" id="telefono_proveedore" 
                placeholder="Teléfono" onkeypress="return solo_Numeros(event);" 
                value="{{ $get_id->telefono_proveedor }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Celular:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="celular_proveedore" id="celular_proveedore" 
                placeholder="Celular" onkeypress="return solo_Numeros(event);" 
                value="{{ $get_id->celular_proveedor }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Persona de contacto:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="contacto_proveedore" id="contacto_proveedore" 
                placeholder="Persona de contacto" value="{{ $get_id->contacto_proveedor }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Email:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="email_proveedore" id="email_proveedore" 
                placeholder="Email" value="{{ $get_id->email_proveedor }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Web:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="web_proveedore" id="web_proveedore" 
                placeholder="Web" value="{{ $get_id->web_proveedor }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Usuario:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="proveedor_codigoe" id="proveedor_codigoe" 
                placeholder="Usuario" value="{{ $get_id->proveedor_codigo }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Contraseña:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="proveedor_passworde" id="proveedor_passworde" 
                placeholder="Contraseña" value="{{ $get_id->proveedor_password }}">
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
                <label class="control-label text-bold">N° cuenta:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="num_cuentae" id="num_cuentae" 
                placeholder="N° cuenta" value="{{ $get_id->num_cuenta }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Área:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_areae" id="id_areae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                        <option value="{{ $list->id_area }}"
                        @if ($list->id_area==$get_id->id_area) selected @endif                            >
                            {{ $list->nom_area }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Proveedor();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Proveedor() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('insumo_conf_pr.update', $get_id->id_proveedor) }}";

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
                        text: "¡El registro ya existe!",
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
                        Lista_Proveedor();
                        $("#ModalUpdate .close").click();
                    });  
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
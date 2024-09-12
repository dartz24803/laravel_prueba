<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo proveedor:</h5>
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
                <input type="text" class="form-control" name="nom_proveedor" id="nom_proveedor" 
                placeholder="Razón social">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">RUC:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="ruc_proveedor" id="ruc_proveedor" 
                placeholder="RUC" onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Dirección:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="direccion_proveedor" 
                id="direccion_proveedor" placeholder="Dirección">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Teléfono:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="telefono_proveedor" id="telefono_proveedor" 
                placeholder="Teléfono" onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Celular:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="celular_proveedor" id="celular_proveedor" 
                placeholder="Celular" onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Persona de contacto:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="contacto_proveedor" id="contacto_proveedor" 
                placeholder="Persona de contacto">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Email:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="email_proveedor" id="email_proveedor" 
                placeholder="Email">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Web:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="web_proveedor" id="web_proveedor" 
                placeholder="Web">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Usuario:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="proveedor_codigo" id="proveedor_codigo" 
                placeholder="Usuario">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Contraseña:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="proveedor_password" id="proveedor_password" 
                placeholder="Contraseña">
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
                <label class="control-label text-bold">N° cuenta:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="num_cuenta" id="num_cuenta" 
                placeholder="N° cuenta">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Área:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_area" id="id_area">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                        <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Proveedor();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Proveedor() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('insumo_conf_pr.store') }}";

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
                        text: "¡El registro ya existe!",
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
                        Lista_Proveedor();
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

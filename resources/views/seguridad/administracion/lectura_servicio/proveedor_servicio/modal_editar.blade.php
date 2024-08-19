<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar proveedor de servicio:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="cod_basee" id="cod_basee">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}"
                        @if ($list->cod_base==$get_id->cod_base) selected @endif>
                            {{ $list->cod_base }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Servicio:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_servicioe" id="id_servicioe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_servicio as $list)
                        <option value="{{ $list->id_servicio }}"
                        @if ($list->id_servicio==$get_id->id_servicio) selected @endif>
                            {{ $list->nom_servicio }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Nombre:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="nom_proveedor_servicioe" id="nom_proveedor_servicioe" placeholder="Ingresar nombre"
                value="{{ $get_id->nom_proveedor_servicio }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>RUC:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="ruc_proveedor_servicioe" id="ruc_proveedor_servicioe" placeholder="Ingresar RUC" maxlength="11"
                onkeypress="return solo_Numeros(event);" value="{{ $get_id->ruc_proveedor_servicio }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Dirección:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="dir_proveedor_servicioe" id="dir_proveedor_servicioe" placeholder="Ingresar dirección"
                value="{{ $get_id->dir_proveedor_servicio }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Teléfono:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="tel_proveedor_servicioe" id="tel_proveedor_servicioe" placeholder="Ingresar teléfono"
                onkeypress="return solo_Numeros(event);" value="{{ $get_id->tel_proveedor_servicio }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Contacto:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="contacto_proveedor_servicioe" id="contacto_proveedor_servicioe" placeholder="Ingresar contacto"
                value="{{ $get_id->contacto_proveedor_servicio }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Teléfono contacto:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="telefono_contactoe" id="telefono_contactoe" placeholder="Ingresar teléfono contacto"
                onkeypress="return solo_Numeros(event);" value="{{ $get_id->telefono_contacto }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Proveedor_Servicio();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Proveedor_Servicio() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('lectura_servicio_conf_pr.update', $get_id->id_proveedor_servicio) }}";

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
                        Lista_Proveedor_Servicio();
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
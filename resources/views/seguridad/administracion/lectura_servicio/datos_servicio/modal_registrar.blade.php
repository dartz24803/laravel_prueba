<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo datos de servicio:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Lugar:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_lugar_servicio" id="id_lugar_servicio">
                    <option value="0">Seleccione</option>
                    @foreach ($list_lugar as $list)
                        <option value="{{ $list->id_lugar_servicio }}">{{ $list->nom_lugar_servicio }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="cod_base" id="cod_base" onchange="Traer_Servicio('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Servicio:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_servicio" id="id_servicio" onchange="Traer_Proveedor_Servicio('');">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Proveedor:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_proveedor_servicio" id="id_proveedor_servicio">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Contrato/ Nº Cliente:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="contrato_servicio" id="contrato_servicio" placeholder="Ingresar contrato"
                onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label>Medidor/ Teléfono:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="medidor" id="medidor" placeholder="Ingresar medidor"
                onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Suministro:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="suministro" id="suministro" placeholder="Ingresar suministro"
                onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label>Ruta:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="ruta" id="ruta" placeholder="Ingresar ruta"
                onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Cliente:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Ingresar cliente">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>N° documento:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="doc_cliente" id="doc_cliente" placeholder="Ingresar N° documento"
                onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-12">
                <h5 class="modal-title">Parámetros de consumo</h5>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Lunes:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="parametro_1" id="parametro_1" placeholder="Ingresar parámetro"
                onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label>Martes:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="parametro_2" id="parametro_2" placeholder="Ingresar parámetro"
                onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Miércoles:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="parametro_3" id="parametro_3" placeholder="Ingresar parámetro"
                onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label>Jueves:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="parametro_4" id="parametro_4" placeholder="Ingresar parámetro"
                onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Viernes:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="parametro_5" id="parametro_5" placeholder="Ingresar parámetro"
                onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label>Sábado:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="parametro_6" id="parametro_6" placeholder="Ingresar parámetro"
                onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Domingo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="parametro_7" id="parametro_7" placeholder="Ingresar parámetro"
                onkeypress="return solo_Numeros(event);">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Datos_Servicio();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Datos_Servicio() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('lectura_servicio_conf_da.store') }}";

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
                        Lista_Datos_Servicio();
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

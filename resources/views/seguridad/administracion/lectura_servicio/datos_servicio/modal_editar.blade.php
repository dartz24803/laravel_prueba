<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar datos de servicio:</h5>
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
                <select class="form-control" name="id_lugar_servicioe" id="id_lugar_servicioe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_lugar as $list)
                        <option value="{{ $list->id_lugar_servicio }}"
                        @if ($list->id_lugar_servicio==$get_id->id_lugar_servicio) selected @endif>
                            {{ $list->nom_lugar_servicio }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="cod_basee" id="cod_basee" onchange="Traer_Servicio('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}" 
                        @if ($list->cod_base==$get_id->cod_base) selected @endif>
                            {{ $list->cod_base }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Servicio:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_servicioe" id="id_servicioe" onchange="Traer_Proveedor_Servicio('e');">
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
                <label>Proveedor:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_proveedor_servicioe" id="id_proveedor_servicioe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_proveedor_servicio as $list)
                        <option value="{{ $list->id_proveedor_servicio }}"
                        @if ($list->id_proveedor_servicio==$get_id->id_proveedor_servicio) selected @endif>
                            {{ $list->nom_proveedor_servicio }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Contrato/ Nº Cliente:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="contrato_servicioe" id="contrato_servicioe" placeholder="Ingresar contrato"
                onkeypress="return solo_Numeros(event);" value="{{ $get_id->contrato_servicio }}">
            </div>

            <div class="form-group col-lg-2">
                <label>Medidor/ Teléfono:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="medidore" id="medidore" placeholder="Ingresar medidor"
                onkeypress="return solo_Numeros(event);" value="{{ $get_id->medidor }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Suministro:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="suministroe" id="suministroe" placeholder="Ingresar suministro"
                onkeypress="return solo_Numeros(event);" value="{{ $get_id->suministro }}">
            </div>

            <div class="form-group col-lg-2">
                <label>Ruta:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="rutae" id="rutae" placeholder="Ingresar ruta"
                onkeypress="return solo_Numeros(event);" value="{{ $get_id->ruta }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Cliente:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="clientee" id="clientee" placeholder="Ingresar cliente" 
                value="{{ $get_id->cliente }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>N° documento:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="doc_clientee" id="doc_clientee" placeholder="Ingresar N° documento"
                onkeypress="return solo_Numeros(event);" value="{{ $get_id->doc_cliente }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Datos_Servicio();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Datos_Servicio() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('lectura_servicio_conf_da.update', $get_id->id_datos_servicio) }}";

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
                        Lista_Datos_Servicio();
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
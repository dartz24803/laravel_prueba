<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nueva observación:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Tipo de error:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo_error" id="id_tipo_error" onchange="Traer_Error('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_error as $list)
                        <option value="{{ $list->id_tipo_error }}">{{ $list->nom_tipo_error }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Error:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_error" id="id_error" onchange="Traer_Datos_Error('');">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div id="div_monto" class="row">
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div>
            <div class="form-group col-lg-4">
                @if (session('usuario')->id_puesto=="29" ||
                session('usuario')->id_puesto=="31" ||
                session('usuario')->id_puesto=="32" ||
                session('usuario')->id_puesto=="167" ||
                session('usuario')->id_puesto=="161" ||
                session('usuario')->id_puesto=="197")
                    <input type="text" class="form-control" name="cod_base" id="cod_base" value="{{ session('usuario')->centro_labores }}" readonly>
                @else
                    <select class="form-control" name="cod_base" id="cod_base" onchange="Traer_Responsable('');">
                        <option value="0">Seleccione</option>
                        @foreach ($list_base as $list)
                            <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Responsable: </label>
            </div>            
            <div class="form-group col-lg-10">
                <select class="form-control multivalue" name="responsables[]" id="responsables" multiple="multiple">
                    @if (session('usuario')->id_puesto=="29" ||
                    session('usuario')->id_puesto=="31" ||
                    session('usuario')->id_puesto=="32" ||
                    session('usuario')->id_puesto=="167" ||
                    session('usuario')->id_puesto=="161" ||
                    session('usuario')->id_puesto=="197")
                        @foreach ($list_responsable as $list)
                            <option value="{{ $list->id_usuario }}">{{ $list->nom_usuario }}</option>
                        @endforeach
                    @endif
                </select>                              
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Suceso: </label>
            </div>            
            <div class="form-group col-lg-10">
                <textarea name="nom_suceso" id="nom_suceso" class="form-control" rows="4" placeholder="Ingresar suceso"></textarea>                             
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Observacion();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalRegistro')
    });

    function Insert_Observacion() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('observacion.store') }}";

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
                        Lista_Observacion();
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

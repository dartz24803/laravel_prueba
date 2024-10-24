<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo postulante:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Tipo documento:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo_documento" id="id_tipo_documento">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_documento as $list)
                        <option value="{{ $list->id_tipo_documento }}">
                            {{ $list->cod_tipo_documento }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Número documento:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="num_doc" name="num_doc" 
                placeholder="Ingresar número documento" onkeypress="return solo_Numeros(event);">
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <label class="control-label text-bold">POSTULANTE:</label>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Área:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basic" name="id_area" id="id_area" onchange="Traer_Puesto('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                        <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Puesto:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_puesto" id="id_puesto">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        @if (session('usuario')->id_nivel=="1" ||
        session('usuario')->id_puesto=="21" || 
        session('usuario')->id_puesto=="22" || 
        session('usuario')->id_puesto=="277" ||
        session('usuario')->id_puesto=="278" ||
        session('usuario')->id_puesto=="314")
            <div class="row">
                <div class="col-lg-12">
                    <label class="control-label text-bold">EVALUADOR:</label>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-2">
                    <label>Puesto:</label>
                </div>
                <div class="form-group col-lg-10">
                    <select class="form-control basic" name="id_puesto_evaluador" id="id_puesto_evaluador"
                    onchange="Traer_Evaluador('');">
                        <option value="0">Seleccione</option>
                        @foreach ($list_puesto_evaluador as $list)
                            <option value="{{ $list->id_puesto }}">{{ $list->nom_puesto }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-2">
                    <label>Nombre:</label>
                </div>
                <div class="form-group col-lg-10">
                    <select class="form-control" name="id_evaluador" id="id_evaluador">
                        <option value="0">Seleccione</option>
                    </select>
                </div>
            </div>
        @endif
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Postulante();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basic").select2({
        tags: true,
        dropdownParent: $('#ModalRegistro')
    });

    function Insert_Postulante() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('postulante_reg.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error_usuario"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡Existe un colaborador con ese número de documento!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data=="error_postulante"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡Existe un postulante con ese número de documento!",
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
                        Lista_Postulante();
                        $("#ModalRegistro .close").click();
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
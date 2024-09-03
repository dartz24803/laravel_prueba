<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nueva pregunta:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Puesto:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_puesto" id="id_puesto">
                    <option value="0">Seleccione</option>
                    @foreach ($list_puesto as $list)
                        <option value="{{ $list->id_puesto }}">{{ $list->nom_puesto }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Tipo:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo" id="id_tipo" onchange="Tipo('');">
                    <option value="0">Seleccione</option>
                    <option value="1">Abierta</option>
                    <option value="2">Opción múltiple</option>
                </select>
            </div>
        </div>

        <div id="tipo_abierta" class="row" style="display: none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción">
            </div>
        </div>

        <div class="row tipo_opcion_multiple" style="display: none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="validar_opcion_1">Opción 1:</label>
                <input type="radio" name="validar_opcion" id="validar_opcion_1" value="1">
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="opcion_1" id="opcion_1" placeholder="Opción 1">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="validar_opcion_2">Opción 2:</label>
                <input type="radio" name="validar_opcion" id="validar_opcion_2" value="2">
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="opcion_2" id="opcion_2" placeholder="Opción 2">
            </div>
        </div>

        <div class="row tipo_opcion_multiple" style="display: none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="validar_opcion_3">Opción 3:</label>
                <input type="radio" name="validar_opcion" id="validar_opcion_3" value="3">
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="opcion_3" id="opcion_3" placeholder="Opción 3">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="validar_opcion_4">Opción 4:</label>
                <input type="radio" name="validar_opcion" id="validar_opcion_4" value="4">
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="opcion_4" id="opcion_4" placeholder="Opción 4">
            </div>
        </div>

        <div class="row tipo_opcion_multiple" style="display: none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="validar_opcion_5">Opción 5:</label>
                <input type="radio" name="validar_opcion" id="validar_opcion_5" value="5">
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="opcion_5" id="opcion_5" placeholder="Opción 5">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Pregunta();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Pregunta() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('linea_carrera_conf_pre.store') }}";

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
                        Lista_Pregunta();
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

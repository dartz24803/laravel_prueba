<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Nueva función temporal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Colaborador: </label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basicm" name="id_usuario" id="id_usuario">
                    <option value="0">Seleccione</option>
                    @foreach ($list_usuario as $list)
                        <option value="{{ $list->id_usuario }}">{{ $list->nom_usuario }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo" id="id_tipo" onchange="Tipo_Funcion_Temporal('');">
                    <option value="0">Seleccione</option>
                    <option value="1">Función</option>
                    <option value="2">Tarea</option>
                </select>
            </div>
        </div>

        <div class="row" id="div_tipo">
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha: </label>
            </div>
            <div class="form-group col-lg-4">
                <input class="form-control" type="date" name="fecha" id="fecha" value="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Hora de inicio: </label>
            </div>
            <div class="form-group col-lg-4">
                <input class="form-control" type="time" name="hora_inicio" id="hora_inicio" value="{{ date('H:i') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Hora de fin: </label>
            </div>
            <div class="form-group col-lg-4">
                <input class="form-control" type="time" name="hora_fin" id="hora_fin">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Funcion_Temporal();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.basicm').select2({
        dropdownParent: $('#ModalRegistro')
    });

    function Insert_Funcion_Temporal(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ route('funcion_temporal.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success:function (data) {
                swal.fire(
                    '¡Registro Exitoso!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Funcion_Temporal();
                    $("#ModalRegistro .close").click();
                });
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
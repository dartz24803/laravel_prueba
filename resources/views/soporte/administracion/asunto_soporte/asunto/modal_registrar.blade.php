<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Asunto:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Elemento:</label>
                <select class="form-control" name="id_elemento" id="id_elemento">
                    @foreach ($list_elementos as $list)
                    <option value="{{ $list->idsoporte_elemento }}">{{ $list->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label>Tipo de Soporte:</label>
                <select class="form-control" name="tipo_soporte" id="tipo_soporte">
                    @foreach ($list_tipo as $list)
                    <option value="{{ $list->idsoporte_tipo }}">{{ $list->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-12">
                <label for="nom_asunt">Nombre Asunto:</label>
                <input type="text" class="form-control" id="nom_asunt" name="nom_asunt">
            </div>

            <div class="form-group col-lg-12">
                <label for="descripciona">Descripción:</label>
                <textarea name="descripciona" id="descripciona" cols="1" rows="2" class="form-control"></textarea>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Asunto();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Asunto() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('soporte_asunto_conf.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Asuntos();
                        $("#ModalRegistro .close").click();
                    })
                }
            },
            error: function(xhr) {
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
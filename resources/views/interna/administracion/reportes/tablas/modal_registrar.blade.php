<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nueva Tabla:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row"> <!-- Add this row class to create a horizontal layout -->
            <div class="form-group col-lg-6">
                <label>Base de Datos:</label>
                <select class="form-control" name="cod_dbee" id="cod_dbee">
                    @foreach ($list_db as $list)
                    <option value="{{ $list->cod_db }}">{{ $list->nom_db }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label for="nom_bde">Tabla:</label>
                <input type="text" class="form-control" id="nom_tabe" name="nom_tabe">
            </div>

            <div class="form-group col-lg-12">
                <label for="descripcione">Descripción:</label>
                <input type="text" class="form-control" id="descripcione" name="descripcione">
            </div>
        </div>

    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_db();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_db() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('bireporte_tbbd_conf.store') }}";

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
                        Lista_tbDB();
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
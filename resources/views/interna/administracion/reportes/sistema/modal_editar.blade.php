<style>
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
    }
</style>
<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Sistema - Base de Datos:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-12 d-flex justify-content-center align-items-center">
                <label class="mr-2">Cod Base:</label>
                <p class="form-control-static">{{ $get_id->cod_db }}</p> <!-- Texto no editable -->
            </div>
            <div class="form-group col-lg-6">
                <label>Sistema:</label>
                <select class="form-control" name="nom_sistemae" id="nom_sistemae">
                    @foreach ($list_sistemas as $list)
                    <option value="{{ $list->nom_sistema }}"
                        @if ($list->nom_sistema==$get_id->nom_sistema) selected @endif>
                        {{ $list->nom_sistema }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label>Base de Datos:</label>
                <select class="form-control" name="nom_dbe" id="nom_dbe">
                    @foreach ($list_dbs as $list)
                    <option value="{{ $list->nom_db }}"
                        @if ($list->nom_db==$get_id->nom_db) selected @endif>
                        {{ $list->nom_db }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_SisDB();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('#nom_dbe').select2({
        placeholder: "Selecciona un db",
        allowClear: true
    });
    $('#nom_sistemae').select2({
        placeholder: "Selecciona un sistema",
        allowClear: true
    });

    function Update_SisDB() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('bireporte_sisbd_conf.update', $get_id->id_sistema_tablas) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_SisDB();
                        $("#ModalUpdate .close").click();
                    });
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
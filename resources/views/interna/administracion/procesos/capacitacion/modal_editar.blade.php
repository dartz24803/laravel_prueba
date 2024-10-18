<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Tipo indicador:</h5>
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
                <label for="nombrecapa">Nombre Indicador:</label>
                <input type="text" class="form-control" id="nombrecapae" name="nombrecapae"
                    value="{{ $get_id->nom_capacitacion }}">
            </div>
            <div class="form-group col-lg-6">
                <label>Área:</label>
                <select class="form-control" name="id_areae" id="id_areae">
                    @foreach ($list_area as $list)
                    <option value="{{ $list->id_area }}" {{ $list->id_area == $get_id->id_area ? 'selected' : '' }}>
                        {{ $list->nom_area }}
                    </option>
                    @endforeach
                </select>


            </div>
            <div class="form-group col-lg-12">
                <label for="descripcionee">Descripción:</label>
                <textarea name="descripcionee" id="descripcionee" cols="1" rows="2" class="form-control">{{ $get_id->descripcion }}</textarea>

            </div>
        </div>

    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Update_Capa();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Capa() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('portalprocesos_cap_conf.update', $get_id->id_capacitacion) }}";

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
                        Lista_Capacitaciones();
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
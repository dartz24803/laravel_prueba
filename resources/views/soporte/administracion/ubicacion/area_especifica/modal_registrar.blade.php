<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nueva Área Específica:</h5>
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
                <label>Sede Laboral:</label>
                <select class="form-control" name="sede_laboral" id="sede_laboral">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sede as $list)
                    <option value="{{ $list->id }}">{{ $list->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label>Nivel:</label>
                <select class="form-control" name="soporte_nivel" id="soporte_nivel">
                    <option value="0">Seleccione</option>

                </select>
            </div>

            <div class="form-group col-lg-12">
                <label for="nom_area_esp">Nombre Área Específica:</label>
                <input type="text" class="form-control" id="nom_area_esp" name="nom_area_esp">
            </div>

        </div>

    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Area_Especifica();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Area_Especifica() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('soporte_area_esp_conf.store') }}";

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
                        Lista_AreaEspecifica();
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


    $('#sede_laboral').on('change', function() {
        const selectedSede = $(this).val();
        var url = "{{ route('area_especifica_por_sede') }}";
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                sede: selectedSede
            },
            success: function(response) {
                $('#soporte_nivel').empty().append('<option value="0">Seleccione</option>');
                // Verificar si hay respuestas
                if (response.length > 0) {
                    $.each(response, function(index, nivel) {
                        $('#soporte_nivel').append(
                            `<option value="${nivel.idsoporte_nivel}">${nivel.nombre}</option>`
                        );
                    });

                } else {}
            },
            error: function(xhr) {
                console.error('Error al obtener elementos:', xhr);
            }
        });
    });
</script>
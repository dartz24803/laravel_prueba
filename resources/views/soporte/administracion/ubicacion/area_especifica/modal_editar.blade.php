<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Área Específica:</h5>
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
                <select class="form-control" name="sede_laborale" id="sede_laborale">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sede as $list)
                    <option value="{{ $list->id }}"
                        {{ $list->id == $get_id->id_sede_laboral ? 'selected' : '' }}>
                        {{ $list->descripcion }}
                    </option>
                    @endforeach
                </select>


            </div>
            <div class="form-group col-lg-6">
                <label>Nivel:</label>
                <select class="form-control" name="soporte_nivele" id="soporte_nivele">
                    @foreach ($list_nivel as $list)
                    <option value="{{ $list->idsoporte_nivel }}"
                        {{ $list->idsoporte_nivel == $get_id->idsoporte_nivel ? 'selected' : '' }}>
                        {{ $list->nombre }}
                    </option>
                    @endforeach

                </select>
            </div>

            <div class="form-group col-lg-12">
                <label for="nom_area_espe">Nombre Área Específica:</label>
                <input type="text" class="form-control" id="nom_area_espe" name="nom_area_espe"
                    value="{{ $get_id->nombre }}">
            </div>
        </div>

    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Update_AreaEspecifica();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_AreaEspecifica() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('soporte_area_esp_conf.update', $get_id->idsoporte_area_especifica) }}";

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
                        Lista_AreaEspecifica();
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



    function cargarNiveles(sedeId, nivelSeleccionado = null) {
        var url = "{{ route('area_especifica_por_sede') }}";

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                sede: sedeId
            },
            success: function(response) {
                $('#soporte_nivele').empty().append('<option value="0">Seleccione</option>');

                if (response.length > 0) {
                    $.each(response, function(index, nivel) {
                        $('#soporte_nivele').append(
                            `<option value="${nivel.idsoporte_nivel}">${nivel.nombre}</option>`
                        );
                    });

                    // Seleccionar el nivel predefinido si existe
                    if (nivelSeleccionado) {
                        $('#soporte_nivele').val(nivelSeleccionado);
                    }
                }
            },
            error: function(xhr) {
                console.error('Error al obtener niveles:', xhr);
            }
        });
    }

    // Cargar los niveles automáticamente al abrir el modal
    $(document).ready(function() {
        const sedeLaboralSeleccionada = $('#sede_laborale').val();
        const nivelSeleccionado = "{{ $get_id->idsoporte_nivel }}";

        if (sedeLaboralSeleccionada != 0) {
            cargarNiveles(sedeLaboralSeleccionada,
                nivelSeleccionado);
        }
    });

    $('#sede_laborale').on('change', function() {
        const selectedSede = $(this).val();
        cargarNiveles(selectedSede);
    });
</script>
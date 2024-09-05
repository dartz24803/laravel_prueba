<!-- CSS -->
<style>
    /* Asegúrate de que el dropdown de Select2 tenga un z-index más bajo */
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
    }

    /* Estilo para el campo de búsqueda dentro del select2 */
    /* Estilo para el campo de búsqueda dentro del select2 cuando está deshabilitado */
    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field:disabled {
        background-color: transparent !important;

    }


    .small-text {
        color: black;
        font-size: 12px;
        /* Ajusta el tamaño según tus necesidades */
    }

    .centered-label {
        text-align: center;
        margin-bottom: 1rem;
        /* Espacio inferior */
        background-color: #f8f9fa;
        /* Color de fondo distinto para el label */
        padding: 10px;
        /* Espaciado interno */
        border-radius: 5px;
        /* Bordes redondeados */
        border: 1px solid #dee2e6;
        /* Borde */
    }

    .divider {
        border-bottom: 1px solid #dee2e6;
        /* Color y estilo del divisor */
        margin-bottom: 1rem;
        /* Espacio debajo del divisor */
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4f46e5;
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }
</style>
<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">

    <!-- <form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation""> -->
    <div class=" modal-header">
        <h5 class="modal-title">Registrar Accesos de Reporte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">

        <div class="row">
            <div class="form-group col-md-4">
                <label for="nomreporte">Reporte: </label>
                <input type="text" class="form-control" id="nomreporte" name="nomreporte" placeholder="Nombre Reporte">
            </div>
            <div class="form-group col-lg-8">
                <label>Iframe:</label>
                <textarea name="iframe" id="iframe" cols="1" rows="2" class="form-control"></textarea>
            </div>

        </div>


        <div class="row">
            <div class="col-12 text-center">
                <div class="divider"></div>

                <label class="control-label text-bold">Filtros</label>

                @csrf
                <div class="row">

                    <div class="form-group col-md-6">
                        <label class="control-label text-bold">Filtro Base: </label>
                        <select class="form-control multivalue" name="tipo_acceso_b[]" id="tipo_acceso_b" multiple="multiple">
                            @foreach ($list_base as $base)
                            <option value="{{ $base->id_base }}">{{ $base->cod_base }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-bold">Filtro Área: </label>
                        <select class="form-control multivalue" name="id_area_acceso_t[]" id="id_area_acceso_t" multiple="multiple">
                            @foreach ($list_area as $list)
                            <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-12 text-center">
            <div class="divider"></div>

            <label class="control-label text-bold">Dar Accesos</label>
            <div>
                <label class="control-label text-bold">Todos</label>
                <label class="switch">
                    <input type="checkbox" id="acceso_todo" name="acceso_todo" onclick="Acceso_Todo()">
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <div class="row d-flex">

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Acceso Puesto: </label>
                <select class="form-control multivalue" name="tipo_acceso_t[]" id="tipo_acceso_t" multiple="multiple">
                    @foreach ($list_responsable as $puesto)
                    <option value="{{ $puesto->id_puesto }}">{{ $puesto->nom_puesto }}</option>
                    @endforeach
                </select>
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
    $('.multivalue').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalRegistro')
    });

    $(document).ready(function() {
        $('#id_area_acceso_t').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            dropdownParent: $('#ModalRegistro')
        });
        $('#tipo_acceso_t').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            dropdownParent: $('#ModalRegistro')
        });
        $('#tipo_acceso_p').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            dropdownParent: $('#ModalRegistro')
        });
        $('#tipo_acceso_b').on('change', function() {
            const selectedBases = $(this).val();
            var url = "{{ route('areas_por_base_bi') }}";
            console.log('Selected Bases:', selectedBases); // Para verificar que los valores se están obteniendo correctamente

            // Hacer una solicitud AJAX para obtener los puestos basados en las áreas seleccionadas
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    bases: selectedBases
                },
                success: function(response) {
                    // Vaciar el segundo select antes de agregar las nuevas opciones
                    $('#id_area_acceso_t').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, area) {
                        $('#id_area_acceso_t').append(
                            `<option value="${area.id_area}">${area.nom_area}</option>`
                        );
                    });

                    // Reinitialize select2 if needed
                    $('#id_area_acceso_t').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });

        $('#id_area_acceso_t').on('change', function() {
            const selectedAreas = $(this).val();
            var url = "{{ route('puestos_por_areas_bi') }}";
            console.log('Selected Areas:', selectedAreas); // Para verificar que los valores se están obteniendo correctamente

            // Hacer una solicitud AJAX para obtener los puestos basados en las áreas seleccionadas
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    areas: selectedAreas
                },
                success: function(response) {
                    // Vaciar el segundo select antes de agregar las nuevas opciones
                    $('#tipo_acceso_t').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, puesto) {
                        $('#tipo_acceso_t').append(
                            `<option value="${puesto.id_puesto}">${puesto.nom_puesto}</option>`
                        );
                    });

                    // Reinitialize select2 if needed
                    $('#tipo_acceso_t').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });

    });




    function Acceso_Todo() {
        const isChecked = document.getElementById('acceso_todo').checked;

        $("#id_area_acceso_t").prop('disabled', isChecked).trigger('change');
        $("#tipo_acceso_t").prop('disabled', isChecked).trigger('change');

        if (isChecked) {
            $("#id_area_acceso_t").val(null).trigger('change');
            $("#tipo_acceso_t").val(null).trigger('change');

            $("#id_area_acceso_t").append('<option value="all" disabled selected>Seleccionado todo</option>').trigger('change');
            $("#tipo_acceso_t").append('<option value="all" disabled selected>Seleccionado todo</option>').trigger('change');
        } else {
            $("#id_area_acceso_t option[value='all']").remove();
            $("#tipo_acceso_t option[value='all']").remove();
        }
    }

    $('#id_area_acceso_t').on('change', function() {
        const selectedValues = $(this).val();
        console.log('Valores seleccionados en el select de áreas:', selectedValues);
    });


    function Insert_Funcion_Temporal() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ route('bireporte_ra.store') }}";


        if (Valida_Insert_Funcion_Temporal()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Maestra();
                        $("#ModalRegistro .close").click();
                    });
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
    }

    function Valida_Insert_Funcion_Temporal() {
        if ($('#id_tipo_i').val() == 1) {
            var mensaje = "Debe seleccionar función.";
        } else if ($('#id_tipo_i').val() == 2) {
            var mensaje = "Debe seleccionar tarea.";
            if ($('#select_tarea').val() == 19) {
                var mensaje = "Debe ingresar tarea.";
            }
        }

        if ($('#id_usuario_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar colaborador.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#id_tipo_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#id_tipo_i').val() === '1') {
            if ($('#tarea_i').val() === '0' || $('#tarea_i').val() === '') {
                Swal(
                    'Ups!',
                    mensaje,
                    'warning'
                ).then(function() {});
                return false;
            }
        } else {
            if ($('#select_tarea').val() === '0') {
                Swal(
                    'Ups!',
                    mensaje,
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#fecha_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar fecha.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#hora_inicio_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar hora de inicio.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }
</script>
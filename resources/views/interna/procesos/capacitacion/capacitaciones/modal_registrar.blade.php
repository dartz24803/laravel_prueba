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

    <div class=" modal-header">
        <h5 class="modal-title">Registrar Nueva Capacitación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">

            <div class="form-group col-lg-4">
                <label class="control-label text-bold">Fecha: </label>

                <input class="form-control" type="date" name="fecha" id="fecha" value="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group col-lg-4">
                <label class="control-label text-bold">Hora Inicio: </label>
                <input type="time" class="form-control" id="h_inicio" name="h_inicio">
            </div>
            <div class="form-group col-lg-4">
                <label class="control-label text-bold">Hora Fin: </label>
                <input type="time" class="form-control" id="h_fin" name="h_fin">
            </div>
            <div class="form-group col-lg-6">
                <label>Lugar: </label>
                <input type="text" class="form-control" id="lugar" name="lugar">
            </div>
            <div class="form-group col-lg-6">
                <label>Area:</label>
                <select class="form-control" name="id_area_acceso_cap" id="id_area_acceso_cap">
                    @foreach ($list_area as $list)
                    <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group col-lg-6">
                <label>Capacitador:</label>
                <select class="form-control" name="id_capacitador_acceso_cap" id="id_capacitador_acceso_cap">
                    @foreach ($list_users as $list)
                    <option value="{{ $list->id_usuario }}">{{ $list->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label>Tema:</label>
                <select class="form-control" name="tipo_acceso_t" id="tipo_acceso_t">
                    <option value="0">Seleccione</option>
                    <option value="{{ $list->id_capacitacion }}">{{ $list->nom_capacitacion }}</option>
                </select>
            </div>
            <div class="form-group col-lg-12">
                <label>Descripción:</label>
                <textarea name="descripcion" id="descripcion" cols="1" rows="1" class="form-control"></textarea>
            </div>
            <div class="form-group col-lg-12">
                <label>Participantes:</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="select_all">
                    <label class="form-check-label" for="select_all">Seleccionar todos</label>
                </div>
                <select class="form-control multivalue" name="id_participantes[]" id="id_participantes" multiple="multiple">
                    @foreach ($list_users as $list)
                    <option value="{{ $list->id_usuario }}">{{ $list->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>


        </div>
    </div>
    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Capacitacion();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>

</form>

<script>
    $('.multivalue').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalRegistro')
    });

    $('#id_participantes').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        dropdownParent: $('#ModalRegistro')
    });
    $(document).ready(function() {
        $('#id_area_acceso_cap').on('change', function() {
            const selectedArea = $(this).val();
            var url = "{{ route('temas_por_areas') }}";
            console.log('Selected Area:', selectedArea);
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    areas: selectedArea // Enviar como cadena si solo es un ID
                },

                success: function(response) {
                    $('#tipo_acceso_t').empty();
                    if (response.length === 0) {
                        $('#tipo_acceso_t').append(
                            `<option value="0">Seleccione</option>`
                        );
                    } else {
                        $.each(response, function(index, tema) {
                            $('#tipo_acceso_t').append(
                                `<option value="${tema.id_capacitacion}">${tema.nom_capacitacion}</option>`
                            );
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });

        $('#id_area_acceso_cap').on('change', function() {
            const selectedArea = $(this).val();
            var url = "{{ route('capacitadores_por_areas') }}";
            console.log('Selected Area:', selectedArea);
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    areas: selectedArea // Enviar como cadena si solo es un ID
                },

                success: function(response) {
                    $('#id_capacitador_acceso_cap').empty();
                    if (response.length === 0) {
                        $('#id_capacitador_acceso_cap').append(
                            `<option value="0">Seleccione</option>`
                        );
                    } else {
                        $.each(response, function(index, usuario) {
                            $('#id_capacitador_acceso_cap').append(
                                `<option value="${usuario.id_usuario}">${usuario.usuario_nombres}</option>`
                            );
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });

        $('#select_all').on('change', function() {
            var isChecked = $(this).is(':checked');
            if (isChecked) {
                $('#id_participantes').find('option').each(function() {
                    $(this).prop('selected', true);
                });
            } else {
                $('#id_participantes').find('option').each(function() {
                    $(this).prop('selected', false);
                });
            }
        });


    });


    $('#id_area_acceso_t').on('change', function() {
        const selectedValues = $(this).val();
        console.log('Valores seleccionados en el select de áreas:', selectedValues);
    });


    function Insert_Capacitacion() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ route('portalprocesos_cap.store') }}";

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
            }
        });

    }
</script>
<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Corregir Soporte:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="form-group col-lg-2">
                        <label class="control-label text-bold">Ubicación:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control" id="sedee" name="sedee">
                            @foreach ($list_sede as $sede)
                            <option value="{{ $sede->id }}"
                                {{ $get_id->id_sede == $sede->id ? 'selected' : '' }}>
                                {{ $sede->descripcion }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-6" id="sublist-container">
                        <select class="form-control" id="idsoporte_nivele" name="idsoporte_nivele">
                            <!-- Aquí se selecciona dinámicamente el nivel basado en get_id -->
                            <option value="{{ $get_id->idsoporte_nivel }}" selected>
                                {{ $get_id->nivel_nombre }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-12" id="sububicacion-containere" style="display: none;">
                <div class="row">
                    <div class="form-group col-lg-4 offset-lg-2" id="thirdlist-container" style="visibility: hidden;">
                        <select class="form-control" id="idsoporte_area_especificae" name="idsoporte_area_especificae">
                            <!-- Aquí se selecciona dinámicamente el área basada en get_id -->
                            <option value="{{ $get_id->idsoporte_area_especifica }}" selected>
                                {{ $get_id->area_nombre }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <div class="form-group col-lg-2">
                        <label>Vencimiento:</label>
                    </div>
                    <div class="form-group col-lg-4">
                        <input type="date" class="form-control" id="fec_vencimiento" name="fec_vencimiento"
                            value="{{ $get_id->fec_vencimiento ? \Carbon\Carbon::parse($get_id->fec_vencimiento)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}">

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="especialidade" name="especialidade">
                    @foreach ($list_especialidad as $list)
                    <option value="{{ $list->id }}"
                        {{ $get_id->id_especialidad == $list->id ? 'selected' : '' }}>
                        {{ $list->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2" id="elemento-conte">
                <label class="control-label text-bold">Elemento:</label>
            </div>
            <div class="form-group col-lg-4" id="elemento-containere">
                <select class="form-control" id="elementoe" name="elementoe">

                    @foreach ($list_elementos as $list)
                    <option value="{{ $list->idsoporte_elemento }}"
                        {{ $get_id->id_elemento == $list->idsoporte_elemento ? 'selected' : '' }}>
                        {{ $list->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-1" id="elemento-areae" style="display: none;">
                <label class="control-label text-bold">Area:</label>
            </div>
            <div class="form-group col-lg-5" id="area-rowe" style="display: none;">
                <select class="form-control" id="areae" name="areae">
                    @foreach ($list_area as $list)
                    <option value="{{ $list->id_area }}"
                        {{ $get_id->id_area == $list->id_area ? 'selected' : '' }}>
                        {{ $list->nom_area }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2" id="asunto-conte">
                <label class="control-label text-bold">Asunto:</label>
            </div>
            <div class="form-group col-lg-10" id="asunto-containere">
                <select class="form-control" id="asuntoe" name="asuntoe">
                    @foreach ($list_asunto as $list)
                    <option value="{{ $list->idsoporte_asunto }}"
                        {{ $get_id->id_asunto == $list->idsoporte_asunto ? 'selected' : '' }}>
                        {{ $list->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>

            <div class="form-group col-lg-10">
                <textarea class="form-control" name="descripcione" id="descripcione" rows="5">{{ $get_id->descripcion }}</textarea>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" onclick="Update_Soporte();" type="button">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    var subUbicacionCont = document.getElementById('sububicacion-containere');


    function cargarNivelesPorSede(sedeId, nivelSeleccionado = null) {
        var url = "{{ route('soporte_nivel_por_sede') }}";

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                sedes: sedeId
            },
            success: function(response) {
                $('#idsoporte_nivele').empty().append('<option value="0">Seleccione</option>');

                // Verificar si hay respuestas
                if (response.length > 0) {
                    $.each(response, function(index, sede) {
                        $('#idsoporte_nivele').append(
                            `<option value="${sede.idsoporte_nivel}">${sede.nombre}</option>`
                        );
                    });
                    $('#sublist-container').show();

                    // Seleccionar el nivel predefinido si existe
                    if (nivelSeleccionado) {
                        $('#idsoporte_nivele').val(nivelSeleccionado);
                    }
                } else {
                    $('#sublist-container').hide();
                }
            },
            error: function(xhr) {
                console.error('Error al obtener niveles por sede:', xhr);
            }
        });
    }

    function cargarAreasPorNivel(nivelId, areaSeleccionada = null) {
        var url = "{{ route('soporte_areaespecifica_por_nivel') }}";

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                ubicacion1: nivelId
            },
            success: function(response) {
                $('#idsoporte_area_especificae').empty().append(
                    '<option value="0">Seleccione Área Esp.</option>');

                // Verificar si hay respuestas
                if (response.length > 0) {
                    $.each(response, function(index, area) {
                        $('#idsoporte_area_especificae').append(
                            `<option value="${area.idsoporte_area_especifica}">${area.nombre}</option>`
                        );
                    });
                    $('#thirdlist-container').css('visibility', 'visible');
                    subUbicacionCont.style.display = 'block';

                    // Seleccionar el área predefinida si existe
                    if (areaSeleccionada) {
                        $('#idsoporte_area_especificae').val(areaSeleccionada);
                    }
                } else {
                    $('#thirdlist-container').css('visibility', 'hidden');
                    subUbicacionCont.style.display = 'none';
                }
            },
            error: function(xhr) {
                console.error('Error al obtener áreas específicas:', xhr);
            }
        });
    }


    function cargarAsuntos(elementoId, asuntoSeleccionado = null) {
        var url = "{{ route('asunto_por_elemento') }}";

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                elemento: elementoId
            },
            success: function(response) {
                $('#asuntoe').empty().append('<option value="0">Seleccione</option>');

                // Verificar si hay respuestas
                if (response.length > 0) {
                    $.each(response, function(index, asunto) {
                        $('#asuntoe').append(
                            `<option value="${asunto.idsoporte_asunto}">${asunto.nombre}</option>`
                        );
                    });

                    // Seleccionar el asunto predefinido si existe
                    if (asuntoSeleccionado) {
                        $('#asuntoe').val(asuntoSeleccionado);
                    }
                }
            },
            error: function(xhr) {
                console.error('Error al obtener asuntos:', xhr);
            }
        });
    }

    function cargarElementos(especialidadId, elementoSeleccionado = null, asuntoSeleccionado = null) {

        var elementoSelect = document.getElementById('elementoe');
        var elementCont = document.getElementById('elemento-conte');
        var asuntoCont = document.getElementById('asunto-conte');
        var asuntoSelect = document.getElementById('asuntoe');
        var areaRow = document.getElementById('area-rowe');
        var elementoContainer = document.getElementById('elemento-containere');
        var asuntoContainer = document.getElementById('asunto-containere');
        var areaElementoRow = document.getElementById('elemento-areae');


        if (especialidadId == 4) {
            elementoContainer.style.display = 'none';
            elementCont.style.display = 'none';
            asuntoCont.style.display = 'none';
            asuntoContainer.style.display = 'none';
            areaRow.style.display = 'block';
            areaElementoRow.style.display = 'block';
        } else {
            elementoContainer.style.display = 'block';
            elementCont.style.display = 'block';
            asuntoCont.style.display = 'block';
            asuntoContainer.style.display = 'block';
            areaRow.style.display = 'none';
            areaElementoRow.style.display = 'none';
        }


        // Variables para el manejo de "sede"
        var sedeSelect = document.getElementById('sedee');
        var subSedeSelect = document.getElementById('idsoporte_nivele');
        var thirdSedeSelect = document.getElementById('idsoporte_area_especificae');
        var sublistContainer = document.getElementById('sublist-container');
        var thirdContainer = document.getElementById('thirdlist-container');

        // Función manejadora para "sede"
        function handleSedeChange() {
            if (sedeSelect.value === '0') {
                subSedeSelect.style.display = 'none';
                thirdSedeSelect.style.display = 'none';
                sublistContainer.style.display = 'none';
                thirdContainer.style.display = 'none';
            } else {
                subSedeSelect.style.display = 'block';
                thirdSedeSelect.style.display = 'block';
                sublistContainer.style.display = 'block';
                thirdContainer.style.display = 'block';
            }
        }


        var url = "{{ route('elemento_por_especialidad') }}";

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                especialidad: especialidadId
            },
            success: function(response) {
                $('#elementoe').empty().append('<option value="0">Seleccione</option>');

                if (response.length > 0) {
                    $.each(response, function(index, elemento) {
                        $('#elementoe').append(
                            `<option value="${elemento.idsoporte_elemento}">${elemento.nombre}</option>`
                        );
                    });

                    // Seleccionar elemento y asunto predefinidos si existen
                    if (elementoSeleccionado) {
                        $('#elementoe').val(elementoSeleccionado);
                    }
                    if (asuntoSeleccionado) {
                        $('#asunto').val(asuntoSeleccionado);
                    }
                }

                // Lógica específica para la especialidad 4
                if (especialidadId == 4) {
                    setTimeout(function() {
                        if ($('#elementoe option[value="6"]').length > 0) {
                            $('#elementoe').val(6);
                        }
                        if ($('#asunto option[value="9"]').length > 0) {
                            $('#asunto').val(9);
                        }
                    }, 100);
                }
            },
            error: function(xhr) {
                console.error('Error al obtener elementos:', xhr);
            }
        });
    }

    // Cargar los elementos automáticamente al abrir el modal
    $(document).ready(function() {
        const especialidadSeleccionada = $('#especialidade').val();
        const elementoSeleccionado = "{{ $get_id->id_elemento }}";
        const asuntoSeleccionado = "{{ $get_id->id_asunto }}";


        const sedeSeleccionada = $('#sedee').val();
        const nivelSeleccionado = "{{ $get_id->idsoporte_nivel }}";
        const areaSeleccionada = "{{ $get_id->idsoporte_area_especifica }}";



        // Cargar los asuntos si ya hay un elemento seleccionado
        if (elementoSeleccionado != 0) {
            cargarAsuntos(elementoSeleccionado, asuntoSeleccionado);
        }

        if (sedeSeleccionada != 0) {
            cargarNivelesPorSede(sedeSeleccionada, nivelSeleccionado);
        }

        if (nivelSeleccionado != 0) {
            cargarAreasPorNivel(nivelSeleccionado, areaSeleccionada);
        }

        // Cargar los elementos si ya hay una especialidad seleccionada
        if (especialidadSeleccionada != 0) {

            cargarElementos(especialidadSeleccionada, elementoSeleccionado, asuntoSeleccionado);
        }
    });



    $('#elementoe').on('change', function() {
        const selectedElemento = $(this).val();
        cargarAsuntos(selectedElemento);
    });

    $('#sedee').on('change', function() {
        const selectedSede = $(this).val();
        cargarNivelesPorSede(selectedSede);
    });

    $('#idsoporte_nivele').on('change', function() {
        const selectedNivel = $(this).val();
        cargarAreasPorNivel(selectedNivel);
    });

    $('#especialidade').on('change', function() {
        const selectedEspecialidad = $(this).val();
        cargarElementos(selectedEspecialidad);
    });


    function Update_Soporte() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ route('soporte_ticket.update', $get_id->id_soporte) }}";

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
                        Lista_Tickets_Soporte();
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
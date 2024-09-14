<!-- CSS -->
<style>
    /* .modal-body {
        max-height: 450px;
        overflow: auto;

    }

    .nav-tabs {
        position: sticky;
        top: 0;
        background-color: #fff;
        border-bottom: 1px solid #ddd;
        z-index: 100;
    } */

    /* Asegúrate de que el dropdown de Select2 tenga un z-index más bajo */
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
    }

    .col-tipo {
        width: 200px;
        /* Ajusta el valor según sea necesario */
    }

    .col-accion {
        width: 50px;
        /* Ajusta el valor según sea necesario */
    }

    /* Estilo para el campo de búsqueda dentro del select2 */
    /* Estilo para el campo de búsqueda dentro decol-accionl select2 cuando está deshabilitado */
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
<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">

    <div class=" modal-header">
        <h5 class="modal-title">Editar Accesos de Reporte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="documento-tab2" data-toggle="tab" href="#documento" role="tab" aria-controls="documento" aria-selected="true">Documento</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="indicadores-tab2" data-toggle="tab" href="#indicadores" role="tab" aria-controls="indicadores" aria-selected="false">Indicadores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="accesos-tab2" data-toggle="tab" href="#accesos" role="tab" aria-controls="accesos" aria-selected="false">Accesos</a>
            </li>

        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="documento" role="tabpanel" aria-labelledby="documento-tab2">
                <div class="row my-4">
                    <div class="form-group col-md-6">
                        <label for="nombi">Nombre BI: </label>
                        <input type="text" class="form-control" id="nombi" name="nombi" value="{{ $get_id->nom_bi ?? '' }}" placeholder="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="nomintranet">Nombre Intranet: </label>
                        <input type="text" class="form-control" id="nomintranet" name="nomintranet" value="{{ $get_id->nom_intranet ?? '' }}" placeholder="">
                    </div>

                    <div class="form-group col-lg-12">
                        <label>Iframe:</label>
                        <textarea name="iframe" id="iframe" cols="1" rows="2" class="form-control">{{ $get_id->iframe ?? '' }}</textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="objetivo">Objetivo: </label>
                        <input type="text" class="form-control" id="objetivo" name="objetivo" value="{{ $get_id->objetivo ?? '' }}" placeholder="">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="control-label text-bold">Actividad: </label>
                        <select class="form-control" name="actividad_bi" id="actividad_bi">
                            <option value="1" {{ $get_id->actividad == 1 ? 'selected' : '' }}>En uso</option>
                            <option value="2" {{ $get_id->actividad == 2 ? 'selected' : '' }}>Suspendido</option>
                        </select>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="areasse">Área1: </label>
                        <select class="form-control" name="areasse" id="areasse">
                            @foreach ($list_area as $list)
                            <option value="{{ $list->id_area }}"
                                {{ $list->id_area == $get_id->id_area ? 'selected' : '' }}>
                                {{ $list->nom_area }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-bold">Frec. Actualización: </label>
                        <select class="form-control" name="frec_actualizacion" id="frec_actualizacion">
                            <option value="1" {{ $get_id->frecuencia_act == 1 ? 'selected' : '' }}>Minuto</option>
                            <option value="2" {{ $get_id->frecuencia_act == 2 ? 'selected' : '' }}>Hora</option>
                            <option value="3" {{ $get_id->frecuencia_act == 3 ? 'selected' : '' }}>Día</option>
                            <option value="4" {{ $get_id->frecuencia_act == 4 ? 'selected' : '' }}>Semana</option>
                            <option value="5" {{ $get_id->frecuencia_act == 5 ? 'selected' : '' }}>Mes</option>

                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="solicitantes">Solicitante: </label>
                        <select class="form-control" name="solicitantee" id="solicitantee">
                            @foreach ($list_colaborador as $list)
                            <option value="{{ $list->id_usuario }}"
                                {{ $list->id_usuario == $get_id->id_usuario ? 'selected' : '' }}>
                                {{ $list->usuario_apater }} {{ $list->usuario_amater }} {{ $list->usuario_nombres }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group col-md-12">
                        <label for="tablas">Tablas: </label>
                        <textarea name="tablas" id="tablas" cols="1" rows="2" class="form-control">{{ $get_id->tablas ?? '' }}</textarea>
                    </div>

                </div>


            </div>

            <div class="tab-pane fade" id="indicadores" role="tabpanel" aria-labelledby="indicadores-tab2">
                <!-- Contenido de la pestaña Otra Sección -->
                <div class="row d-flex col-md-12 my-2">
                    <!-- Tabla para añadir filas dinámicamente -->
                    <table id="tabla_versiones" class="table table-hover" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Indicador</th>
                                <th>Descripción</th>
                                <th class="col-tipo">Tipo</th>
                                <th class="col-tipo">Presentación</th>
                                <th class="col-accion">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_body2">
                            <!-- Si ya tienes valores para editar, los mostramos en la tabla -->
                            @foreach ($list_indicadores as $indicador)
                            <tr class="text-center">
                                <td class="px-1"><input type="text" class="form-control" name="indicador[]" value="{{ $indicador->nom_indicador }}"></td>
                                <td class="px-1"><input type="text" class="form-control" name="descripcion[]" value="{{ $indicador->descripcion }}"></td>
                                <td class="px-1">
                                    <select class="form-control" name="tipo[]">
                                        @foreach ($list_tipo_indicador as $list)
                                        <option value="{{ $list->idtipo_indicador }}" {{ $list->idtipo_indicador == $indicador->idtipo_indicador ? 'selected' : '' }}>
                                            {{ $list->nom_indicador }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-1">
                                    <select class="form-control" name="presentacion[]">
                                        <option value="1" {{ $indicador->presentacion == 1 ? 'selected' : '' }}>Tabla</option>
                                        <option value="2" {{ $indicador->presentacion == 2 ? 'selected' : '' }}>Gráfico</option>
                                    </select>
                                </td>
                                <td class="px-1"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">-</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success btn-sm" onclick="addRow()">Agregar fila</button>
                </div>
            </div>

            <div class="tab-pane fade" id="accesos" role="tabpanel" aria-labelledby="accesos-tab2">
                <div class="row my-4">
                    <div class="form-group col-md-12 text-center">
                        <div class="divider"></div>
                        <label class="control-label text-bold">Acceso Puesto: </label>
                        <select disabled class="form-control multivalue" name="tipo_acceso_te[]" id="tipo_acceso_te" multiple="multiple">
                            @foreach ($list_responsable as $puesto)
                            <option value="{{ $puesto->id_puesto }}"
                                {{ in_array($puesto->id_puesto, $selected_puesto_ids) ? 'selected' : '' }}>
                                {{ $puesto->nom_puesto }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('POST')
        <button class="btn btn-primary" type="button" onclick="Update_Proceso(); ">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>

</form>

<script>
    var opcionesTipo = `
        @foreach ($list_tipo_indicador as $list)
            <option value="{{ $list->idtipo_indicador }}">{{ $list->nom_indicador }}</option>
        @endforeach
    `;
    // Función para agregar una nueva fila
    function addRow() {
        // Obtener el cuerpo de la tabla
        var tableBody = document.getElementById('tabla_body2');
        // Crear una nueva fila
        var newRow = document.createElement('tr');
        newRow.classList.add('text-center');

        // Contenido HTML de la nueva fila
        newRow.innerHTML = `
        <td class="px-1"><input type="text" class="form-control" name="indicador[]"></td>
        <td class="px-1"><input type="text" class="form-control" name="descripcion[]"></td>
        <td class="px-1">
            <select class="form-control" name="tipo[]">` + opcionesTipo + `</select>
        </td>
        <td class="px-1">
            <select class="form-control" name="presentacion[]">
                <option value="1">Tabla</option>
                <option value="2">Gráfico</option>
            </select>
        </td>
        <td class="px-1"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">-</button></td>
    `;

        // Agregar la nueva fila al cuerpo de la tabla
        tableBody.appendChild(newRow);
    }



    function removeRow(button) {
        // Eliminar la fila correspondiente
        button.closest('tr').remove();
    }


    $('.multivalue').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalRegistro')
    });

    $(document).ready(function() {
        $('#id_area_acceso_te').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            dropdownParent: $('#ModalRegistro')
        });
        $('#tipo_acceso_te').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            dropdownParent: $('#ModalRegistro')
        });
        $('#tipo_acceso_p').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            dropdownParent: $('#ModalRegistro')
        });
        $('#tipo_acceso_be').on('change', function() {
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
                    $('#id_area_acceso_te').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, area) {
                        $('#id_area_acceso_te').append(
                            `<option value="${area.id_area}">${area.nom_area}</option>`
                        );
                    });

                    // Reinitialize select2 if needed
                    $('#id_area_acceso_te').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });

        $('#id_area_acceso_te').on('change', function() {
            const selectedAreas = $(this).val();
            var url = "{{ route('puestos_por_areas_bi') }}";
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    areas: selectedAreas
                },
                success: function(response) {
                    // Vaciar el segundo select antes de agregar las nuevas opciones
                    $('#tipo_acceso_te').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, puesto) {
                        $('#tipo_acceso_te').append(
                            `<option value="${puesto.id_puesto}">${puesto.nom_puesto}</option>`
                        );
                    });
                    $('#tipo_acceso_te').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });

        $('#areasse').on('change', function() {
            const selectedAreaUser = $(this).val();
            var url = "{{ route('usuarios_por_area') }}";
            console.log('Área seleccionada:', selectedAreaUser);
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    area_id: selectedAreaUser
                },
                success: function(response) {
                    // Vaciar el segundo select antes de agregar las nuevas opciones
                    $('#solicitantee').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, usuario) {
                        $('#solicitantee').append(
                            `<option value="${usuario.id_usuario}">${usuario.nombre_completo}</option>`
                        );
                    });

                },
                error: function(xhr) {
                    console.error('Error al obtener usuarios:', xhr);
                }
            });
        });


    });


    function Update_Proceso() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ route('bireporte_ra.update', $get_id->id_acceso_bi_reporte) }}";

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
                        List_Reporte();
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

    // Evitar el envío del formulario cuando se presiona Enter en otros campos, pero permitir en <textarea>
    document.getElementById('formulario_update').addEventListener('keydown', function(event) {
        // Si el foco está en un textarea, permitir el salto de línea
        if (event.target.tagName.toLowerCase() === 'textarea') {
            return; // No hacer nada, permitir el salto de línea
        }
        // Si se presiona Enter en otro campo, evitar el envío del formulario
        if (event.key === 'Enter') {
            event.preventDefault(); // Evita que el formulario se envíe
        }
    });
</script>
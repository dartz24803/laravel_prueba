<!-- CSS -->
<style>
    /* Establecer un ancho fijo para el select */
    .form-control {
        width: 100%;
        /* Asegúrate de que el select ocupe todo el ancho disponible */
    }

    .form-control option {
        white-space: nowrap;
        width: 100px;
    }

    .style-tabla {
        width: 200px;
    }

    .table .form-control {
        width: 100%;
        /* Asegura que el input use el 100% del ancho de la celda */
    }

    table .table>tbody>tr>td:nth-child(23) {
        width: 390px;
        /* Asegura que el ancho de la columna sea de 290px */
    }

    /* Asegúrate de que el dropdown de Select2 tenga un z-index más bajo */
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
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

<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">

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
        <ul class="nav nav-tabs" id="myTab2" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="documento-tab" data-toggle="tab" href="#documento2" role="tab" aria-controls="documento2" aria-selected="true">Documento</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="indicadores-tab" data-toggle="tab" href="#indicadores2" role="tab" aria-controls="indicadores2" aria-selected="false">Indicadores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tablas-tab" data-toggle="tab" href="#tablas2" role="tab" aria-controls="tablas2" aria-selected="false">Tablas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="accesos-tab" data-toggle="tab" href="#accesos2" role="tab" aria-controls="accesos2" aria-selected="false">Accesos</a>
            </li>

        </ul>
        <div class="tab-content" id="myTabContent2">
            <div class="tab-pane fade show active" id="documento2" role="tabpanel" aria-labelledby="documento-tab">
                <div class="row my-4">

                    <div class="form-group col-md-6">
                        <label for="nombi">Nombre BI: </label>
                        <input type="text" class="form-control" id="nombi" name="nombi" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nomintranet">Nombre Intranet: </label>
                        <input type="text" class="form-control" id="nomintranet" name="nomintranet" placeholder="">
                    </div>


                    <div class="form-group col-lg-12">
                        <label>Iframe:</label>
                        <textarea name="iframe" id="iframe" cols="1" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="objetivo">Objetivo: </label>
                        <input type="text" class="form-control" id="objetivo" name="objetivo" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-bold">Actividad: </label>
                        <select class="form-control" name="actividad_bi" id="actividad_bi">
                            <option value="1">En uso</option>
                            <option value="2">Suspendido</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="areass">Área: </label>
                        <select class="form-control " name="areass" id="areass">
                            @foreach ($list_area as $list)
                            <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-bold">Frec. Actualización: </label>
                        <select class="form-control" name="frec_actualizacion" id="frec_actualizacion">
                            <option value="1">Minuto</option>
                            <option value="2">Hora</option>
                            <option value="3">Día</option>
                            <option value="4">Semana</option>
                            <option value="5">Mes</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="solicitantes">Solicitante: </label>
                        <select class="form-control" name="solicitante" id="solicitante">
                            @foreach ($list_colaborador as $list)
                            <option value="{{ $list->id_usuario }}">
                                {{ $list->usuario_apater }} {{ $list->usuario_amater }} {{ $list->usuario_nombres }}
                            </option>
                            @endforeach
                        </select>

                    </div>
                    <!-- <div class="form-group col-md-12">
                        <label for="tablas">Tablas: </label>
                        <textarea name="tablas" id="tablas" cols="1" rows="2" class="form-control"></textarea>
                    </div> -->
                </div>


            </div>

            <div class="tab-pane fade" id="indicadores2" role="tabpanel" aria-labelledby="indicadores-tab">
                <!-- Contenido de la pestaña Otra Sección -->
                <div class="row d-flex col-md-12 my-2">
                    <!-- Tabla para añadir filas dinámicamente -->
                    <table id="tabla_versiones" class="table table-hover" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>N°pagina</th>
                                <th>Indicador</th>
                                <th>Descripción</th>
                                <th class="col-tipo">Tipo Ind</th>
                                <th class="col-tipo">Presentación</th>
                                <th class="col-accion">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_body">
                            <tr class="text-center">
                                <td class="px-1"><input type="text" class="form-control" name="npagina[]"></td>
                                <td class="px-1"><input type="text" class="form-control" name="indicador[]"></td>
                                <td class="px-1"><input type="text" class="form-control" name="descripcion[]"></td>
                                <td class="px-1">
                                    <select class="form-control " name="tipo[]" id="tipo">
                                        @foreach ($list_tipo_indicador as $list)
                                        <option value="{{ $list->idtipo_indicador }}">{{ $list->nom_indicador}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-1">
                                    <select class="form-control" name="presentacion[]">
                                        <option value="1">Tabla</option>
                                        <option value="2">Gráfico</option>
                                    </select>
                                </td>
                                <td class="px-1"><button type="button" class="btn btn-success btn-sm" onclick="addRow()">+</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="tablas2" role="tabpanel" aria-labelledby="tablas-tab">
                <!-- Contenido de la pestaña Otra Sección -->
                <div class="row d-flex col-md-12 my-2">
                    <!-- Tabla para añadir filas dinámicamente -->
                    <table id="tabla_versiones" class="table table-hover" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Sistema</th>
                                <th class="style-tabla">Base de Datos</th>
                                <th class="style-tabla">Tabla</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_body3">
                            <tr class="text-center">
                                <td class="px-1">
                                    <select class="form-control" name="sistema[]" id="sistema">
                                        @foreach ($list_sistemas as $list)
                                        <option value="{{ $list->cod_sistema }}">{{ $list->nom_sistema}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-1">
                                    <select class="form-control" name="db[]" id="db">
                                        @foreach ($list_db as $list)
                                        <option value="{{ $list->id_sistema_tablas }}">{{ $list->nom_db}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-1"><input type="text" class="form-control" name="tablabi[]"></td>
                                <td class="px-1"><button type="button" class="btn btn-success btn-sm" onclick="addRowTabla()">+</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="accesos2" role="tabpanel" aria-labelledby="accesos-tab">
                <div class="row my-4">
                    @csrf
                    <div class="form-group col-md-6">
                        <label class="control-label text-bold">Filtro Sede: </label>
                        <select class="form-control multivalue" name="tipo_acceso_sede[]" id="tipo_acceso_sede" multiple="multiple">
                            @foreach ($list_sede as $sede)
                            <option value="{{ $sede->id }}">{{ $sede->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-bold">Filtro Ubicaciones: </label>
                        <select class="form-control multivalue" name="tipo_acceso_ubi[]" id="tipo_acceso_ubi" multiple="multiple">
                            @foreach ($list_ubicaciones as $ubi)
                            <option value="{{ $ubi->id_ubicacion }}">{{ $ubi->cod_ubi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="form-group col-md-6">
                        <label class="control-label text-bold">Filtro Base: </label>
                        <select class="form-control multivalue" name="tipo_acceso_b[]" id="tipo_acceso_b" multiple="multiple">
                            @foreach ($list_base as $base)
                            <option value="{{ $base->id_base }}">{{ $base->cod_base }}</option>
                            @endforeach
                        </select>
                    </div> -->
                    <div class="form-group col-md-12">
                        <label class="control-label text-bold">Filtro Área: </label>
                        <select class="form-control multivalue" name="id_area_acceso_t[]" id="id_area_acceso_t" multiple="multiple">
                            @foreach ($list_area as $list)
                            <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="divider"></div> -->

                    <div class="form-group col-md-12 text-center">
                        <div class="divider"></div>
                        <label class="control-label text-bold">Acceso Puesto: </label>
                        <select class="form-control multivalue" name="tipo_acceso_t[]" id="tipo_acceso_t" multiple="multiple">
                            @foreach ($list_responsable as $puesto)
                            <option value="{{ $puesto->id_puesto }}">{{ $puesto->nom_puesto }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
    function addRow() {
        // Obtener el cuerpo de la tablacodigo
        var tableBody = document.getElementById('tabla_body');

        // Crear una nueva fila
        var newRow = document.createElement('tr');
        newRow.classList.add('text-center');

        // Contenido HTML de la nueva fila
        newRow.innerHTML = `
        <td class="px-1"><input type="text" class="form-control" name="npagina[]"></td>
        <td class="px-1"><input type="text" class="form-control" name="indicador[]"></td>
        <td class="px-1"><input type="text" class="form-control" name="descripcion[]"></td>
        <td class="px-1">
            <select class="form-control" name="tipo[]">
                @foreach ($list_tipo_indicador as $list)
                    <option value="{{ $list->idtipo_indicador }}">{{ $list->nom_indicador }}</option>
                @endforeach
            </select>
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

    // Función para eliminar una fila
    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function addRowTabla() {
        // Obtener el cuerpo de la tablacodigo
        var tableBody = document.getElementById('tabla_body3');

        // Crear una nueva fila
        var newRow = document.createElement('tr');
        newRow.classList.add('text-center');

        // Contenido HTML de la nueva fila
        newRow.innerHTML = `
        <td class="px-1">
               <select class="form-control" name="sistema[]" id="sistema">
                    @foreach ($list_sistemas as $list)
                    <option value="{{ $list->cod_sistema }}">{{ $list->nom_sistema}}</option>
                    @endforeach
               </select>
        </td>
        <td class="px-1">
               <select class="form-control" name="db[]" id="db">
                    @foreach ($list_db as $list)
                    <option value="{{ $list->cod_db }}">{{ $list->nom_db}}</option>
                    @endforeach
                </select>
        </td>
        <td class="px-1"><input type="text" class="form-control" name="tablabi[]"></td>
        <td class="px-1"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">-</button></td>
        `;

        // Agregar la nueva fila al cuerpo de la tabla
        tableBody.appendChild(newRow);
    }


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

        $('#id_area_acceso_t').on('change', function() {
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
                    $('#tipo_acceso_t').empty();
                    // Agregar las nuevas opciones
                    $.each(response, function(index, puesto) {
                        $('#tipo_acceso_t').append(
                            `<option value="${puesto.id_puesto}">${puesto.nom_puesto}</option>`
                        );
                    });
                    $('#tipo_acceso_t').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });

        $('#areass').on('change', function() {
            const selectedAreaUser = $(this).val();
            var url = "{{ route('usuarios_por_area') }}";
            console.log('Área seleccionada:', selectedAreaUser); // Verifica que el área seleccionada se está enviando correctamente
            // Hacer una solicitud AJAX para obtener los usuarios basados en el área seleccionada
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    area_id: selectedAreaUser
                },
                success: function(response) {
                    // Vaciar el segundo select antes de agregar las nuevas opciones
                    $('#solicitante').empty();
                    // Agregar las nuevas opciones
                    $.each(response, function(index, usuario) {
                        $('#solicitante').append(
                            `<option value="${usuario.id_usuario}">${usuario.nombre_completo}</option>`
                        );
                    });
                },
                error: function(xhr) {
                    console.error('Error al obtener usuarios:', xhr);
                }
            });
        });

        $('#sistema').on('change', function() {
            const selectedSistema = $(this).val();
            console.log(selectedSistema);
            var url = "{{ route('db_por_sistema_bi') }}";
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    sis: selectedSistema
                },
                success: function(response) {
                    // Vaciar el segundo select antes de agregar las nuevas opciones
                    $('#db').empty();
                    // Agregar las nuevas opciones
                    $.each(response, function(index, db) {
                        $('#db').append(
                            `<option value="${db.cod_db}">${db.nom_db}</option>`
                        );
                    });

                },
                error: function(xhr) {
                    console.error('Error al obtener db:', xhr);
                }
            });
        });

        $('#tipo_acceso_sede').on('change', function() {
            const selectedSedes = $(this).val();
            var url = "{{ route('ubicacion_por_sede') }}";
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    sedes: selectedSedes
                },
                success: function(response) {
                    // Vaciar el segundo select antes de agregar las nuevas opciones
                    $('#tipo_acceso_ubi').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, sede) {
                        $('#tipo_acceso_ubi').append(
                            `<option value="${sede.id_ubicacion}">${sede.cod_ubi}</option>`
                        );
                    });
                    $('#tipo_acceso_ubi').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener sedes:', xhr);
                }
            });
        });
        $('#tipo_acceso_ubi').on('change', function() {
            const selectedUbis = $(this).val();
            var url = "{{ route('areas_por_ubicacion') }}";
            console.log(selectedUbis);
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    ubis: selectedUbis
                },
                success: function(response) {
                    $('#id_area_acceso_t').empty();
                    // Agregar las nuevas opciones
                    $.each(response, function(index, area) {
                        $('#id_area_acceso_t').append(
                            `<option value="${area.id_area}">${area.nom_area}</option>`
                        );
                    });
                    $('#id_area_acceso_t').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener sedes:', xhr);
                }
            });
        });
    });


    function Insert_Funcion_Temporal() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ route('bireporte_ra.store') }}";

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
                    List_Reporte();
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

    // Evitar el envío del formulario cuando se presiona Enter en otros campos, pero permitir en <textarea>
    document.getElementById('formulario_insert').addEventListener('keydown', function(event) {
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
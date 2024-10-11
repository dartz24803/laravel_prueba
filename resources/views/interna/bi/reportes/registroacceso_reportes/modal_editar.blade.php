<!-- CSS -->
<style>
    #paste_areae_1 {
        width: 100%;
        /* Ancho completo */
        padding: 10px;
        /* Espaciado interno para separar el contenido del borde */
        font-size: 16px;
        /* Tamaño de fuente adecuado */
        border: 1px solid #ccc;
        /* Borde del textarea */
        resize: none;
        /* Permitir redimensionamiento vertical */
        box-sizing: border-box;
        /* Incluir padding y border en el ancho total */
        cursor: text;
        /* Cursor de texto para indicar área de entrada */
        border-color: #3366ff;
        /* Cambiar color del borde al enfocarse */
        box-shadow: 0 0 5px rgba(51, 102, 255, 0.5);
        /* Sombra al enfocarse */
        font-size: 12px;

    }

    #paste_areae_2 {
        width: 100%;
        /* Ancho completo */
        padding: 10px;
        /* Espaciado interno para separar el contenido del borde */
        font-size: 16px;
        /* Tamaño de fuente adecuado */
        border: 1px solid #ccc;
        /* Borde del textarea */
        resize: none;
        /* Permitir redimensionamiento vertical */
        box-sizing: border-box;
        /* Incluir padding y border en el ancho total */
        cursor: text;
        /* Cursor de texto para indicar área de entrada */
        border-color: #3366ff;
        /* Cambiar color del borde al enfocarse */
        box-shadow: 0 0 5px rgba(51, 102, 255, 0.5);
        /* Sombra al enfocarse */
        font-size: 12px;

    }

    #paste_areae_3 {
        width: 100%;
        /* Ancho completo */
        padding: 10px;
        /* Espaciado interno para separar el contenido del borde */
        font-size: 16px;
        /* Tamaño de fuente adecuado */
        border: 1px solid #ccc;
        /* Borde del textarea */
        resize: none;
        /* Permitir redimensionamiento vertical */
        box-sizing: border-box;
        /* Incluir padding y border en el ancho total */
        cursor: text;
        /* Cursor de texto para indicar área de entrada */
        border-color: #3366ff;
        /* Cambiar color del borde al enfocarse */
        box-shadow: 0 0 5px rgba(51, 102, 255, 0.5);
        /* Sombra al enfocarse */
        font-size: 12px;
    }

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
                <a class="nav-link" id="indicadores-tab2" data-toggle="tab" href="#indicadores" role="tab" aria-controls="indicadores" aria-selected="false">Contenido</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tablas-tab" data-toggle="tab" href="#tablas" role="tab" aria-controls="tablas" aria-selected="false">Tablas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="upimagenes-tabe" data-toggle="tab" href="#up_imagenes" role="tab" aria-controls="up_imagenes" aria-selected="false">Subir Imagenes</a>
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
                        <label for="areasse">Grupo: </label>
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
                        <label for="areassd">Área Destino: </label>
                        <select class="form-control" name="areassd" id="areassd">
                            @foreach ($list_area as $list)
                            <option value="{{ $list->id_area }}"
                                {{ $list->id_area == $get_id->id_area_destino ? 'selected' : '' }}>
                                {{ $list->nom_area }}
                            </option>
                            @endforeach
                        </select>
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
                                <th>N°pagina</th>
                                <th>Nombre</th>
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
                                <td class="px-1">
                                    <select class="form-control" name="npagina[]">
                                        @for ($i = 1; $i <= 100; $i++)
                                            <option value="{{ $i }}" {{ $i == $indicador->npagina ? 'selected' : '' }}>
                                            {{ $i }}
                                            </option>
                                            @endfor
                                    </select>
                                </td>
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
                                        <option value="1" {{ $indicador->presentacion == 1 ? 'selected' : '' }}>Medición</option>
                                        <option value="2" {{ $indicador->presentacion == 2 ? 'selected' : '' }}>Informativo</option>
                                    </select>
                                </td>
                                <td class="px-1"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">-</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success btn-sm" onclick="addRowEdit()">Agregar contenido</button>
                </div>
            </div>

            <div class="tab-pane fade" id="tablas" role="tabpanel" aria-labelledby="tablas-tab">
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
                        <tbody id="tabla_body4">
                            @foreach ($list_tablas as $tabla)
                            <tr class="text-center">
                                <td class="px-1">
                                    <select class="form-control sistema" name="sistemas[{{ $loop->index }}]" data-row-index="{{ $loop->index }}">
                                        @foreach ($list_sistemas as $list)
                                        <option value="{{ $list->cod_sistema }}" {{ $list->cod_sistema == $tabla->cod_sistema ? 'selected' : '' }}>
                                            {{ $list->nom_sistema }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-1">
                                    <select class="form-control db" name="dbe[{{ $loop->index }}]" data-row-index="{{ $loop->index }}">
                                        @foreach ($list_db as $list)
                                        <option value="{{ $list->cod_db }}" {{ $list->cod_db == $tabla->cod_db ? 'selected' : '' }}
                                            title="{{ $list->nom_db }}">
                                            {{ strlen($list->nom_db) > 20 ? substr($list->nom_db, 0, 20) . '...' : $list->nom_db }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-1">
                                    <select class="form-control tablabi" name="tablabi[{{ $loop->index }}]" data-row-index="{{ $loop->index }}">
                                        @foreach ($list_tablasdb as $list)
                                        <option value="{{ $list->nombre }}" {{ $list->idtablas_db == $tabla->idtablas_db ? 'selected' : '' }}
                                            title="{{ $list->nombre }}">
                                            {{ strlen($list->nombre) > 20 ? substr($list->nombre, 0, 20) . '...' : $list->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-1"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">-</button></td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <button type="button" class="btn btn-success btn-sm" onclick="addRowTablaEdit()">Agregar tabla</button>
                </div>

            </div>

            <div class="tab-pane fade" id="up_imagenes" role="tabpanel" aria-labelledby="upimagenes-tabe">
                <div class="row my-4">
                    <div class="col-lg-4">
                        <div class="row p-2">
                            <textarea id="paste_areae_1" placeholder="Ctrl + V aquí para pegar la imagen" style="width: 100%" rows="1"></textarea>
                            <div id="imageViewer_1">
                                @if (!empty($get_id->img1))
                                <img src="{{ 'https://lanumerounocloud.com/intranet/REPORTE_BI/' . $get_id->img1 }}" alt="Imagen 1" style="max-width: 100%; max-height: 200px;">
                                @endif
                            </div>
                        </div>
                        <input type="file" id="archivo_basee_1" name="archivo_basee_1" style="display: none;">
                    </div>

                    <div class="col-lg-4">
                        <div class="row p-2">
                            <textarea id="paste_areae_2" placeholder="Ctrl + V aquí para pegar la imagen" style="width: 100%" rows="1"></textarea>
                            <div id="imageViewer_2">
                                @if (!empty($get_id->img2))
                                <img src="{{ 'https://lanumerounocloud.com/intranet/REPORTE_BI/' . $get_id->img2 }}" alt="Imagen 2" style="max-width: 100%; max-height: 200px;">
                                @endif
                            </div>
                        </div>
                        <input type="file" id="archivo_basee_2" name="archivo_basee_2" style="display: none;">
                    </div>

                    <div class="col-lg-4">
                        <div class="row p-2">
                            <textarea id="paste_areae_3" placeholder="Ctrl + V aquí para pegar la imagen" style="width: 100%" rows="1"></textarea>
                            <div id="imageViewer_3">
                                @if (!empty($get_id->img3))
                                <img src="{{ 'https://lanumerounocloud.com/intranet/REPORTE_BI/' . $get_id->img3 }}" alt="Imagen 3" style="max-width: 100%; max-height: 200px;">
                                @endif
                            </div>
                        </div>
                        <input type="file" id="archivo_basee_3" name="archivo_basee_3" style="display: none;">
                    </div>

                </div>
            </div>

            <div class="tab-pane fade" id="accesos" role="tabpanel" aria-labelledby="accesos-tab">
                <div class="row my-4">
                    @csrf
                    <div class="form-group col-md-6">
                        <label class="control-label text-bold">Filtro Sede: </label>
                        <select class="form-control multivalue" name="tipo_acceso_sedee[]" id="tipo_acceso_sedee" multiple="multiple">
                            @foreach ($list_sede as $sede)
                            <option value="{{ $sede->id }}"
                                {{ in_array($sede->id, $selected_sede_ids_array) ? 'selected' : '' }}>
                                {{ $sede->descripcion }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="control-label text-bold">Filtro Ubicaciones: </label>
                        <select class="form-control multivalue" name="tipo_acceso_ubie[]" id="tipo_acceso_ubie" multiple="multiple">
                            @foreach ($list_ubicaciones as $ubi)
                            <option value="{{ $ubi->id_ubicacion }}"
                                {{ in_array($ubi->id_ubicacion, $selected_ubi_ids_array) ? 'selected' : '' }}>
                                {{ $ubi->cod_ubi }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12 text-center">
                        <div class="divider"></div>
                        <label class="control-label text-bold">Filtro Área: </label>
                        <select class="form-control multivalue" name="id_area_acceso_te[]" id="id_area_acceso_te" multiple="multiple">
                            @foreach ($list_area as $list)
                            <option value="{{ $list->id_area }}"
                                {{ in_array($list->id_area, $selected_area_ids_array) ? 'selected' : '' }}>
                                {{ $list->nom_area }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group col-md-12 text-center">
                        <div class="divider"></div>
                        <label class="control-label text-bold">Acceso Puesto: </label>
                        <select class="form-control multivalue" name="tipo_acceso_tee[]" id="tipo_acceso_tee" multiple="multiple">
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
        <!-- @method('POST') -->
        <button class="btn btn-primary" type="button" onclick="Update_Proceso(); ">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>

</form>

<script>
    document.getElementById('paste_areae_1').addEventListener('paste', function(e) {
        handlePaste(e, 'archivo_basee_1', 'imageViewer_1');
    });

    document.getElementById('paste_areae_2').addEventListener('paste', function(e) {
        handlePaste(e, 'archivo_basee_2', 'imageViewer_2');
    });

    document.getElementById('paste_areae_3').addEventListener('paste', function(e) {
        handlePaste(e, 'archivo_basee_3', 'imageViewer_3');
    });

    function handlePaste(e, fileInputId, viewerId) {
        if (e.clipboardData && e.clipboardData.items) {
            var items = e.clipboardData.items;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") !== -1) {
                    var blob = items[i].getAsFile();

                    // Display image in viewer div
                    displayImage(blob, viewerId);

                    // Set the image blob as form data
                    var fileInput = document.getElementById(fileInputId);
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(blob);
                    fileInput.files = dataTransfer.files;

                    break;
                }
            }
        }
    }

    function displayImage(blob, viewerId) {
        var reader = new FileReader();

        reader.onload = function(event) {
            var img = new Image();
            img.src = event.target.result;
            img.style.maxWidth = "100%";
            img.style.marginTop = "10px"; // Ajustar el estilo según sea necesario

            // Limpiar contenido anterior
            var imageViewer = document.getElementById(viewerId);
            imageViewer.innerHTML = '';

            // Agregar nueva imagen al div de visualización
            imageViewer.appendChild(img);
        };

        reader.readAsDataURL(blob);
    }


    var opcionesTipo = `
        @foreach ($list_tipo_indicador as $list)
            <option value="{{ $list->idtipo_indicador }}">{{ $list->nom_indicador }}</option>
        @endforeach
    `;
    // Función para agregar una nueva fila
    function addRowEdit() {
        // Obtener el cuerpo de la tabla
        var tableBody = document.getElementById('tabla_body2');
        // Crear una nueva fila
        var newRow = document.createElement('tr');
        newRow.classList.add('text-center');

        // Contenido HTML de la nueva fila
        newRow.innerHTML = `
        <td class="px-1"><input type="text" class="form-control" name="npagina[]"></td>
        <td class="px-1"><input type="text" class="form-control" name="indicador[]"></td>
        <td class="px-1"><input type="text" class="form-control" name="descripcion[]"></td>
        <td class="px-1">
            <select class="form-control" name="tipo[]">` + opcionesTipo + `</select>
        </td>
        <td class="px-1">
            <select class="form-control" name="presentacion[]">
                <option value="1">Medición</option>
                <option value="2">Informativo</option>
            </select>
        </td>
        <td class="px-1"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">-</button></td>
    `;

        // Agregar la nueva fila al cuerpo de la tabla
        tableBody.appendChild(newRow);
    }

    function addRowTablaEdit() {
        // Obtener el cuerpo de la tabla
        var tableBody = document.getElementById('tabla_body4');

        // Crear una nueva fila
        var newRowTab = document.createElement('tr');
        newRowTab.classList.add('text-center');

        // Contenido HTML de la nueva fila
        newRowTab.innerHTML = `
        <td class="px-1">
            <select class="form-control sistema" name="sistemas[${tableBody.children.length}]" data-row-index="${tableBody.children.length}">
                @foreach ($list_sistemas as $list)
                <option value="{{ $list->cod_sistema }}">{{ $list->nom_sistema }}</option>
                @endforeach
            </select>
        </td>
        <td class="px-1">
            <select class="form-control db" name="dbe[${tableBody.children.length}]" data-row-index="${tableBody.children.length}">
                @foreach ($list_db as $list)
                <option value="{{ $list->cod_db }}" title="{{ $list->nom_db }}">
                  {{ \Illuminate\Support\Str::limit($list->nom_db, 20, '...') }}
                 </option>
                @endforeach
            </select>
        </td>
        <td class="px-1">
            <select class="form-control tablabi" name="tablabi[${tableBody.children.length}]" data-row-index="${tableBody.children.length}">
                @foreach ($list_tablasdb as $list)
                <option value="{{ $list->nombre }}"  title="{{ $list->nombre }}">
                {{ \Illuminate\Support\Str::limit($list->nombre, 20, '...') }}
                 </option>
                @endforeach
            </select>

              
        </td>
        <td class="px-1">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">-</button>
        </td>
    `;

        // Añadir la nueva fila al cuerpo de la tabla
        tableBody.appendChild(newRowTab);
    }


    // Función para adjuntar el evento change al select de sistema
    function attachSistemaChangeEvent(selectElement) {
        $(selectElement).on('change', function() {
            const selectedSistema = $(this).val();
            var url = "{{ route('db_por_sistema_bi') }}";
            var rowIndex = $(this).data('row-index');

            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    sis: selectedSistema
                },
                success: function(response) {
                    // Vaciar el select de db en la fila correspondiente
                    $(`.db[data-row-index="${rowIndex}"]`).empty();
                    // Agregar las nuevas opciones
                    $.each(response, function(index, db) {
                        $(`.db[data-row-index="${rowIndex}"]`).append(
                            `<option value="${db.cod_db}" title="${db.nom_db}">${db.nom_db.length > 20 ? db.nom_db.substring(0, 20) + '...' : db.nom_db}</option>`
                        );
                    });
                },
                error: function(xhr) {
                    console.error('Error al obtener db:', xhr);
                }
            });
        });
    }

    // Asignar eventos a los selects existentes al cargar la página
    $(document).ready(function() {
        $('.sistema').each(function() {
            attachSistemaChangeEvent(this);
        });
    });



    function removeRow(button) {
        // Eliminar la fila correspondiente
        button.closest('tr').remove();
    }

    $('#areasse').select2({
        placeholder: "Selecciona un área",
        allowClear: true
    });
    $('#solicitantee').select2({
        placeholder: "Selecciona un solicitante",
        allowClear: true
    });

    $('.multivalue').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalUpdate')
    });


    $(document).ready(function() {

        let selectedUbicaciones = [];
        $('#tipo_acceso_sedee').on('change', function() {
            const selectedSedes = $(this).val();
            var url = "{{ route('ubicacion_por_sede') }}";
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    sedes: selectedSedes
                },
                success: function(response) {
                    // Guardamos las ubicaciones seleccionadas antes de limpiar
                    selectedUbicaciones = $('#tipo_acceso_ubie').val() || [];
                    // Eliminamos solo las opciones que ya no están asociadas a las sedes seleccionadas
                    const currentOptions = [];
                    $('#tipo_acceso_ubie option').each(function() {
                        currentOptions.push($(this).val());
                    });
                    // Actualizamos solo las nuevas ubicaciones, manteniendo las que ya estaban seleccionadas
                    $('#tipo_acceso_ubie').empty();
                    $.each(response, function(index, sede) {
                        $('#tipo_acceso_ubie').append(
                            `<option value="${sede.id_ubicacion}">${sede.cod_ubi}</option>`
                        );
                    });
                    // Reestablecemos las opciones previamente seleccionadas que aún están disponibles
                    $.each(selectedUbicaciones, function(index, value) {
                        if (currentOptions.includes(value)) {
                            $('#tipo_acceso_ubie').find(`option[value="${value}"]`).prop('selected', true);
                        }
                    });
                    $('#tipo_acceso_ubie').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener sedes:', xhr);
                }
            });
        });

        let selectedAreas = [];
        $('#tipo_acceso_ubie').on('change', function() {
            const selectedUbis = $(this).val();
            var url = "{{ route('areas_por_ubicacion') }}";

            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    ubis: selectedUbis
                },
                success: function(response) {
                    // Guardamos las áreas seleccionadas antes de limpiar
                    selectedAreas = $('#id_area_acceso_te').val() || [];
                    console.log(selectedAreas)

                    // Eliminamos solo las áreas que ya no están asociadas a las ubicaciones seleccionadas
                    const currentOptions = [];
                    $('#id_area_acceso_te option').each(function() {
                        currentOptions.push($(this).val());
                    });

                    // Actualizamos solo las nuevas áreas, manteniendo las seleccionadas
                    $('#id_area_acceso_te').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, area) {
                        $('#id_area_acceso_te').append(
                            `<option value="${area.id_area}">${area.nom_area}</option>`
                        );
                    });

                    // Reestablecemos las áreas seleccionadas previamente que aún están disponibles
                    $.each(selectedAreas, function(index, value) {
                        if (currentOptions.includes(value)) {
                            $('#id_area_acceso_te').find(`option[value="${value}"]`).prop('selected', true);
                        }
                    });

                    $('#id_area_acceso_te').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener áreas:', xhr);
                }
            });
        });

        let selectedPuestos = [];
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
                    // Guardamos los puestos seleccionados antes de limpiar el select
                    selectedPuestos = $('#tipo_acceso_tee').val() || [];
                    console.log(selectedPuestos)
                    // Guardar las opciones actuales del select antes de limpiar
                    const currentOptions = [];
                    $('#tipo_acceso_tee option').each(function() {
                        currentOptions.push($(this).val());
                    });
                    // Vaciar el select antes de agregar las nuevas opciones
                    $('#tipo_acceso_tee').empty();

                    // Agregar las nuevas opciones obtenidas del servidor
                    $.each(response, function(index, puesto) {
                        $('#tipo_acceso_tee').append(
                            `<option value="${puesto.id_puesto}">${puesto.nom_puesto}</option>`
                        );
                    });

                    // Restaurar los puestos seleccionados previamente si siguen estando en las nuevas opciones
                    $.each(selectedPuestos, function(index, value) {
                        if (currentOptions.includes(value)) {
                            $('#tipo_acceso_tee').find(`option[value="${value}"]`).prop('selected', true);
                        }
                    });

                    // Volver a inicializar el select con select2 (o mantenerlo si ya estaba activo)
                    $('#tipo_acceso_tee').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });


        $('#solicitantee').on('change', function() {
            const selectedSolicitante = $(this).val();
            var url = "{{ route('area_por_usuario') }}";
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    user_id: selectedSolicitante
                },
                success: function(response) {
                    // Vaciar el segundo select antes de agregar las nuevas opciones
                    $('#areasse').empty();
                    // Agregar las nuevas opciones
                    $.each(response, function(index, area) {
                        $('#areasse').append(
                            `<option value="${area.id_area}">${area.nom_area}</option>`
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

    $('#sistemas').on('change', function() {
        const selectedSistema = $(this).val();
        var url = "{{ route('db_por_sistema_bi') }}";
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                sis: selectedSistema
            },
            success: function(response) {
                // Vaciar el segundo select antes de agregar las nuevas opciones
                $('#dbe').empty();
                // Agregar las nuevas opciones
                $.each(response, function(index, db) {
                    $('#dbe').append(
                        `<option value="${db.cod_db}" title="${db.nom_db}">${db.nom_db.length > 20 ? db.nom_db.substring(0, 20) + '...' : db.nom_db}</option>`
                    );
                });

            },
            error: function(xhr) {
                console.error('Error al obtener db:', xhr);
            }
        });
    });
</script>
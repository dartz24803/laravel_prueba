<!-- CSS -->
<style>
    #tabla_versiones td:nth-child(6) {
        width: 20px;
    }

    #tabla_versiones td:nth-child(1) {
        width: 20px;
    }

    .modal-dialog {
        max-width: 85%;
    }

    #paste_area_1 {
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

    #paste_area_2 {
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

    #paste_area_3 {
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

    #drop-area {
        border: 2px dashed #007bff;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    #drop-area.highlight {
        border-color: green;
    }

    #preview .img-preview img {
        max-height: 250px;
    }

    .img-preview {
        text-align: center;
    }

    #tabla_js2 td {
        max-width: 180px;
        /* Controla el ancho máximo */
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
        overflow: hidden;
        /* Oculta el contenido que se desborda */
        text-overflow: ellipsis;
        /* Añade puntos suspensivos (...) */
    }

    #tabla_js3 td {
        max-width: 180px;
        /* Controla el ancho máximo */
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
        overflow: hidden;
        /* Oculta el contenido que se desborda */
        text-overflow: ellipsis;
        /* Añade puntos suspensivos (...) */
    }

    /* Asegúrate de que el dropdown de Select2 tenga un z-index más bajo */
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
    }

    .select2-container {
        margin-bottom: 0rem !important;
    }

    /* Establecer una altura predeterminada para el <select> */




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
                <a class="nav-link" id="indicadores-tab" data-toggle="tab" href="#indicadores2" role="tab" aria-controls="indicadores2" aria-selected="false">Contenido</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tablas-tab" data-toggle="tab" href="#tablas2" role="tab" aria-controls="tablas2" aria-selected="false">Tablas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="upimagenes-tab" data-toggle="tab" href="#up_imagenes2" role="tab" aria-controls="up_imagenes2" aria-selected="false">Subir Imagenes</a>
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
                        <label for="solicitantes">Solicitante: </label>
                        <select class="form-control multivalue" name="solicitante" id="solicitante">
                            @foreach ($list_colaborador as $list)
                            <option value="{{ $list->id_usuario }}">
                                {{ $list->usuario_apater }} {{ $list->usuario_amater }} {{ $list->usuario_nombres }}
                            </option>
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
                        <label for="areass">Grupo: </label>
                        <select class="form-control multivalue" name="areass" id="areass">
                            @foreach ($list_area as $list)
                            <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="areass">Área Destino: </label>
                        <select class="form-control multivalue" name="areasd" id="areasd">
                            @foreach ($list_area as $list)
                            <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


            </div>

            <div class="tab-pane fade" id="indicadores2" role="tabpanel" aria-labelledby="indicadores-tab">
                <!-- Contenido de la pestaña Otra Sección -->
                <div class="row d-flex col-md-12 my-2">
                    <!-- Tabla para añadir filas dinámicamente -->
                    <table id="tabla_js2" class="table table-hover" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 20px;">N°Pag</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Concepto</th>
                                <th>Presentación</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tabla_body">
                            <tr class="text-center">
                                <td class="px-1">
                                    <select class="form-control" name="npagina[]">
                                        @for ($i = 1; $i <= 100; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>
                                </td>
                                <td class="px-1"><input type="text" class="form-control" name="indicador[]" oninput="this.setAttribute('title', this.value)"></td>
                                <td class="px-1"><input type="text" class="form-control" name="descripcion[]" oninput="this.setAttribute('title', this.value)"></td>
                                <td class="px-1">
                                    <select class="form-control " name="tipo[]" id="tipo">
                                        @foreach ($list_tipo_indicador as $list)
                                        <option value="{{ $list->idtipo_indicador }}">{{ $list->nom_indicador}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-1">
                                    <select class="form-control" name="presentacion[]">
                                        <option value="1">Medición</option>
                                        <option value="2">Informativo</option>
                                    </select>
                                </td>
                                <td><button type="button" class="btn btn-success btn-sm" onclick="addRow()">+</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="tablas2" role="tabpanel" aria-labelledby="tablas-tab">
                <!-- Contenido de la pestaña Otra Sección -->
                <div class="row d-flex col-md-12 my-2">
                    <!-- Tabla para añadir filas dinámicamente -->
                    <table id="tabla_js3" class="table table-hover" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Sistema</th>
                                <th>Base de Datos</th>
                                <th>Tabla</th>
                                <th></th>
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
                                        <option value="{{ $list->cod_db }}" title="{{ $list->nom_db }}">
                                            {{ \Illuminate\Support\Str::limit($list->nom_db, 40, '...') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="px-1">
                                    <select class="form-control multivalue" name="tbdb[]" id="tbdb">
                                        @foreach ($list_tablasdb as $list)
                                        <option value="{{ $list->nombre }}" title="{{ $list->nombre }}">
                                            {{ \Illuminate\Support\Str::limit($list->nombre, 40, '...') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><button type="button" class="btn btn-success btn-sm" onclick="addRowTabla()">+</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="up_imagenes2" role="tabpanel" aria-labelledby="upimagenes-tab">
                <div class="row my-4">
                    <!-- Columna 1 -->
                    <div class="col-lg-4">
                        <div class="row p-2">
                            <textarea id="paste_area_1" placeholder="Ctrl + V aquí para pegar la imagen" style="width: 100%" rows="1"></textarea>
                            <div id="imageViewerReg_1"></div>
                        </div>
                        <input type="file" id="archivo_base_1" name="archivo_base_1" style="display: none;">
                    </div>

                    <!-- Columna 2 -->
                    <div class="col-lg-4">
                        <div class="row p-2">
                            <textarea id="paste_area_2" placeholder="Ctrl + V aquí para pegar la imagen" style="width: 100%" rows="1"></textarea>
                            <div id="imageViewerReg_2"></div>
                        </div>
                        <input type="file" id="archivo_base_2" name="archivo_base_2" style="display: none;">
                    </div>

                    <!-- Columna 3 -->
                    <div class="col-lg-4">
                        <div class="row p-2">
                            <textarea id="paste_area_3" placeholder="Ctrl + V aquí para pegar la imagen" style="width: 100%" rows="1"></textarea>
                            <div id="imageViewerReg_3"></div>
                        </div>
                        <input type="file" id="archivo_base_3" name="archivo_base_3" style="display: none;">
                    </div>
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
                    <div class="form-group col-md-12">
                        <label class="control-label text-bold">Filtro Área: </label>
                        <select class="form-control multivalue" name="id_area_acceso_t[]" id="id_area_acceso_t" multiple="multiple">
                            @foreach ($list_area as $list)
                            <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                            @endforeach
                        </select>
                    </div>
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
    document.getElementById('paste_area_1').addEventListener('paste', function(e) {
        handlePaste(e, 'archivo_base_1', 'imageViewerReg_1');
    });

    document.getElementById('paste_area_2').addEventListener('paste', function(e) {
        handlePaste(e, 'archivo_base_2', 'imageViewerReg_2');
    });

    document.getElementById('paste_area_3').addEventListener('paste', function(e) {
        handlePaste(e, 'archivo_base_3', 'imageViewerReg_3');
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



    function addRow() {
        // Obtener el cuerpo de la tablacodigo
        var tableBody = document.getElementById('tabla_body');

        // Crear una nueva fila
        var newRow = document.createElement('tr');
        newRow.classList.add('text-center');

        // Contenido HTML de la nueva fila
        newRow.innerHTML = `
        <td class="px-1">
            <select class="form-control" name="npagina[]">
                @for ($i = 1; $i <= 100; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </td>
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
                <option value="1">Medición</option>
                <option value="2">Informativo</option>
            </select>
        </td>
        <td class="px-1"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">-</button></td>
    `;
        tableBody.appendChild(newRow);
    }

    // Función para eliminar una fila
    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function addRowTabla() {
        var tableBody = document.getElementById('tabla_body3');
        var newRow = document.createElement('tr');
        newRow.classList.add('text-center');
        var rowIndex = tableBody.children.length;

        // Contenido HTML de la nueva fila
        newRow.innerHTML = `
        <td class="px-1">
            <select class="form-control sistema" name="sistema[]" data-row-index="${rowIndex}">
                @foreach ($list_sistemas as $list)
                <option value="{{ $list->cod_sistema }}">{{ $list->nom_sistema }}</option>
                @endforeach
            </select>
        </td>
        <td class="px-1">
            <select class="form-control db" name="db[]" data-row-index="${rowIndex}">
                @foreach ($list_db as $list)
                <option value="{{ $list->cod_db }}" title="{{ $list->nom_db }}">
                    {{ \Illuminate\Support\Str::limit($list->nom_db, 40, '...') }}
                </option>
                @endforeach
            </select>
        </td>
        <td class="px-1">
            <select class="form-control tbdb" name="tbdb[]" data-row-index="${rowIndex}">
                @foreach ($list_tablasdb as $list)
                <option value="{{ $list->nombre }}" title="{{ $list->nombre }}">
                    {{ \Illuminate\Support\Str::limit($list->nombre, 40, '...') }}
                </option>
                @endforeach
            </select>
        </td>
        <td class="px-1"><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">-</button></td>
    `;

        // Agregar la nueva fila al cuerpo de la tabla
        tableBody.appendChild(newRow);

        // Vincula los eventos para cuando cambie el select de "sistema" y "db"
        attachSistemaChangeEvent(newRow.querySelector('.sistema'));
        attachDbChangeEvent(newRow.querySelector('.db'));

        // Inicializa Select2 para el nuevo select de tbdb
        $(newRow.querySelector('.tbdb')).select2({
            tags: true,
            tokenSeparators: [',', ' '],
            dropdownParent: $('#ModalRegistro')
        });
    }





    // Función para adjuntar el evento change al select de sistema
    function attachSistemaChangeEvent(selectElement) {
        $(selectElement).on('change', function() {
            const selectedSistema = $(this).val();
            var url = "{{ route('db_por_sistema_bi') }}";
            var rowIndex = $(this).data('row-index'); // Obtiene el índice de la fila

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
                    // Verificar si solo hay una base de datos en la respuesta
                    if (response.length === 1) {
                        // Si solo hay una base de datos, agregarla y seleccionarla automáticamente
                        const db = response[0];
                        $(`.db[data-row-index="${rowIndex}"]`).append(
                            `<option value="${db.cod_db}" title="${db.nom_db}">${db.nom_db.length > 20 ? db.nom_db.substring(0, 20) + '...' : db.nom_db}</option>`
                        );

                        // Llama a la función para manejar el cambio en la base de datos
                        attachDbChangeEvent($(`.db[data-row-index="${rowIndex}"]`));

                        // Llama a attachDbChangeEvent inmediatamente para filtrar tablas
                        $(`.db[data-row-index="${rowIndex}"]`).change(); // Simula el cambio

                    } else {
                        // Si hay más de una base de datos, agregarlas todas
                        $.each(response, function(index, db) {
                            $(`.db[data-row-index="${rowIndex}"]`).append(
                                `<option value="${db.cod_db}" title="${db.nom_db}">${db.nom_db.length > 20 ? db.nom_db.substring(0, 20) + '...' : db.nom_db}</option>`
                            );
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error al obtener db:', xhr);
                }
            });
        });
    }


    function attachDbChangeEvent(selectElement) {
        $(selectElement).on('change', function() {
            const selectedDB = $(this).val(); // Obtener el valor de la base de datos seleccionada
            var url = "{{ route('tb_por_db_bi') }}"; // Ruta para obtener las tablas por base de datos
            var rowIndex = $(this).data('row-index'); // Índice de la fila actual

            // Llamada AJAX para obtener las tablas correspondientes a la base de datos seleccionada
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    dbs: selectedDB // Base de datos seleccionada como parámetro
                },
                success: function(response) {
                    // Limpiar el select de tbdb en la fila correspondiente
                    $(`.tbdb[data-row-index="${rowIndex}"]`).empty();

                    // Agregar las nuevas opciones de tablas devueltas por la respuesta AJAX
                    $.each(response, function(index, tbdb) {
                        $(`.tbdb[data-row-index="${rowIndex}"]`).append(
                            `<option value="${tbdb.nombre}" title="${tbdb.nombre}">
                            ${tbdb.nombre.length > 20 ? tbdb.nombre.substring(0, 20) + '...' : tbdb.nombre}
                        </option>`
                        );
                    });
                },
                error: function(xhr) {
                    console.error('Error al obtener las tablas:', xhr);
                }
            });
        });
    }




    $('.multivalue').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalRegistro')
    });


    $(document).ready(function() {
        $('.tbdb').select2({
            tags: true, // Permite crear nuevas etiquetas
            tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
            dropdownParent: $('#ModalRegistro')
        });

        $('.sistema').each(function() {
            attachSistemaChangeEvent(this);
        });
        $('.db').each(function() {
            attachDbChangeEvent(this);
        });
        // CARGAR IMAGENES
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


        $('#sistema').on('change', function() {
            const selectedSistema = $(this).val();
            var url = "{{ route('db_por_sistema_bi') }}";
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    sis: selectedSistema
                },
                success: function(response) {
                    // Vaciar el select de bases de datos antes de agregar las nuevas opciones
                    $('#db').empty();
                    // Verificar si solo hay una base de datos en la respuesta
                    if (response.length === 1) {
                        // Si solo hay una base de datos, agregarla y seleccionarla automáticamente
                        const db = response[0];
                        $('#db').append(`<option value="${db.cod_db}" title="${db.nom_db}">${db.nom_db.length > 20 ? db.nom_db.substring(0, 20) + '...' : db.nom_db}</option>`);
                        // Ejecutar automáticamente el filtrado de tablas
                        filtrarTablasPorDB(db.cod_db);
                    } else {
                        // Si hay más de una base de datos, agregarlas todas
                        $.each(response, function(index, db) {
                            $('#db').append(
                                `<option value="${db.cod_db}" title="${db.nom_db}">${db.nom_db.length > 20 ? db.nom_db.substring(0, 20) + '...' : db.nom_db}</option>`
                            );
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error al obtener db:', xhr);
                }
            });
        });

        $('#db').on('change', function() {
            const selectedDB = $(this).val();
            console.log(selectedDB)
            filtrarTablasPorDB(selectedDB);
        });

        // Función para filtrar tablas según la base de datos seleccionada
        function filtrarTablasPorDB(selectedDB) {
            var url = "{{ route('tb_por_db_bi') }}";
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    dbs: selectedDB
                },
                success: function(response) {
                    // Vaciar el select de tablas antes de agregar las nuevas opciones
                    $('#tbdb').empty();
                    // Agregar las nuevas opciones
                    $.each(response, function(index, tbdb) {
                        console.log(tbdb)
                        $('#tbdb').append(
                            `<option value="${tbdb.nombre}" title="${tbdb.nombre}">${tbdb.nombre.length > 20 ? tbdb.nombre.substring(0, 20) + '...' : tbdb.nombre}</option>`
                        );
                    });
                },
                error: function(xhr) {
                    console.error('Error al obtener tbdb:', xhr);
                }
            });
        }



        let selectedUbicaciones = [];
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
                    // Guardamos las ubicaciones seleccionadas antes de limpiar
                    selectedUbicaciones = $('#tipo_acceso_ubi').val() || [];
                    // Eliminamos solo las opciones que ya no están asociadas a las sedes seleccionadas
                    const currentOptions = [];
                    $('#tipo_acceso_ubi option').each(function() {
                        currentOptions.push($(this).val());
                    });
                    // Actualizamos solo las nuevas ubicaciones, manteniendo las que ya estaban seleccionadas
                    $('#tipo_acceso_ubi').empty();
                    $.each(response, function(index, sede) {
                        $('#tipo_acceso_ubi').append(
                            `<option value="${sede.id_ubicacion}">${sede.cod_ubi}</option>`
                        );
                    });
                    // Reestablecemos las opciones previamente seleccionadas que aún están disponibles
                    $.each(selectedUbicaciones, function(index, value) {
                        if (currentOptions.includes(value)) {
                            $('#tipo_acceso_ubi').find(`option[value="${value}"]`).prop('selected', true);
                        }
                    });
                    $('#tipo_acceso_ubi').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener sedes:', xhr);
                }
            });
        });

        let selectedAreas = [];
        $('#tipo_acceso_ubi').on('change', function() {
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
                    selectedAreas = $('#id_area_acceso_t').val() || [];

                    // Eliminamos solo las áreas que ya no están asociadas a las ubicaciones seleccionadas
                    const currentOptions = [];
                    $('#id_area_acceso_t option').each(function() {
                        currentOptions.push($(this).val());
                    });

                    // Actualizamos solo las nuevas áreas, manteniendo las seleccionadas
                    $('#id_area_acceso_t').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, area) {
                        $('#id_area_acceso_t').append(
                            `<option value="${area.id_area}">${area.nom_area}</option>`
                        );
                    });

                    // Reestablecemos las áreas seleccionadas previamente que aún están disponibles
                    $.each(selectedAreas, function(index, value) {
                        if (currentOptions.includes(value)) {
                            $('#id_area_acceso_t').find(`option[value="${value}"]`).prop('selected', true);
                        }
                    });

                    $('#id_area_acceso_t').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener áreas:', xhr);
                }
            });
        });


        let selectedPuestos = [];
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
                    // Guardamos los puestos seleccionados antes de limpiar
                    selectedPuestos = $('#tipo_acceso_t').val() || [];

                    // Guardar las opciones actuales del select antes de limpiar
                    const currentOptions = [];
                    $('#tipo_acceso_t option').each(function() {
                        currentOptions.push($(this).val());
                    });

                    // Vaciar el select antes de agregar las nuevas opciones
                    $('#tipo_acceso_t').empty();

                    // Agregar las nuevas opciones
                    $.each(response, function(index, puesto) {
                        $('#tipo_acceso_t').append(
                            `<option value="${puesto.id_puesto}">${puesto.nom_puesto}</option>`
                        );
                    });

                    // Restaurar los puestos seleccionados previamente si siguen disponibles
                    $.each(selectedPuestos, function(index, value) {
                        if (currentOptions.includes(value)) {
                            $('#tipo_acceso_t').find(`option[value="${value}"]`).prop('selected', true);
                        }
                    });

                    $('#tipo_acceso_t').select2();
                },
                error: function(xhr) {
                    console.error('Error al obtener puestos:', xhr);
                }
            });
        });


        $('#solicitante').on('change', function() {
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
                    $('#areass').empty();
                    // Agregar las nuevas opciones
                    $.each(response, function(index, area) {
                        $('#areass').append(
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


    var tabla = $('#tabla_js2').DataTable({
        "ordering": false,
        "autoWidth": false,
        "dom": "<'table-responsive'tr>", // Solo muestra la tabla sin buscador, resultados ni paginador
        responsive: true,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",
        },
        "stripeClasses": [],
    });

    var tabla = $('#tabla_js3').DataTable({
        "columnDefs": [{
                "width": "200px", // Ancho para la columna 0
                "targets": [0]
            },
            {
                "width": "300px", // Ancho para la columna 2
                "targets": [1]
            },
            {
                "width": "50px", // Ancho para la columna 2
                "targets": [3]
            }
        ],
        "ordering": false,
        "autoWidth": false,
        "dom": "<'table-responsive'tr>", // Solo muestra la tabla sin buscador, resultados ni paginador
        responsive: true,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",
        },
        "stripeClasses": [],
    });
</script>
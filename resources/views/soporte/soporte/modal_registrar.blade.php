<style>
    .center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #div_imagenes {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    #imagenes_container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* public/css/style.css */
    body {
        font-family: Arial, sans-serif;
    }

    .custom-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-list {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: none;
        /* Ocultar por defecto */
        position: absolute;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        min-width: 150px;
        z-index: 1;
    }

    .dropdown-btn {
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    .dropdown-list li {
        padding: 8px 12px;
    }

    .dropdown-list li:hover {
        background-color: #ddd;
        /* Color al pasar el mouse */
    }

    .submenu {
        display: none;
        /* Ocultar submenús por defecto */
        position: relative;
        left: 100%;
        /* A la derecha del elemento padre */
        top: 0;
    }

    .dropdown-list li:hover>.submenu {
        display: block;
        /* Mostrar submenú al pasar el mouse */
    }
</style>
<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registro de Soporte</h5>
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
                        <label class="control-label text-bold">Nivel:</label>
                    </div>

                    <div class="form-group col-lg-10" id="sublist-container">
                        <select class="form-control" id="idsoporte_nivel" name="idsoporte_nivel">
                            <option value="0">Seleccione </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Segunda fila: Thirdlist-container (Sub-ubicación) -->
            <div class="col-lg-12" id="sububicacion-container" style="display: none;">
                <div class="row">
                    <!-- Tercer select (Thirdlist-container), siempre presente pero con visibilidad controlada -->
                    <div class="form-group col-lg-4 offset-lg-2" id="thirdlist-container" style="visibility: hidden;">
                        <select class="form-control" id="idsoporte_area_especifica" name="idsoporte_area_especifica">
                            <option value="0">Seleccione Área Esp.</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <!-- Label de "Vencimiento" -->
                    <div class="form-group col-lg-2">
                        <label>Vencimiento:</label>
                    </div>

                    <!-- Input de fecha (Vencimiento) -->
                    <div class="form-group col-lg-4">
                        <input type="date" class="form-control" id="vencimiento" name="vencimiento"
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="especialidad" name="especialidad">
                    <option value="0">Seleccione</option>
                    @foreach ($list_especialidad as $list)
                    <option value="{{ $list->id }}">{{ $list->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2" id="elemento-cont">
                <label class="control-label text-bold">Elemento:</label>
            </div>
            <div class="form-group col-lg-4" id="elemento-container">
                <select class="form-control" id="elemento" name="elemento">
                    <option value="0">Seleccione</option>

                </select>
            </div>
            <div class="form-group col-lg-1" id="elemento-area" style="display: none;">
                <label class="control-label text-bold">Area:</label>
            </div>
            <div class="form-group col-lg-5" id="area-row" style="display: none;">
                <select class="form-control" id="area" name="area">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                    <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                    @endforeach
                </select>
            </div>
        </div>



        <div class="row">
            <div class="form-group col-lg-2" id="asunto-cont">
                <label class="control-label text-bold">Asunto:</label>
            </div>
            <div class="form-group col-lg-10" id="asunto-container">
                <select class="form-control" id="asunto" name="asunto">
                    <option value="0">Seleccione</option>
                    <option value="9">Otros</option>

                </select>
            </div>
        </div>



        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                    placeholder="Ingresar descripción"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-12">
                <button type="button" class="btn btn-secondary" id="boton_camara" onclick="Activar_Camara();">Activar cámara</button>
            </div>

            <div class="form-group col-lg-12 d-flex justify-content-center" id="div_camara" style="display: block;">
                <video id="video" autoplay style="max-width: 95%;"></video>
            </div>

            <div class="form-group col-lg-12 text-center" id="div_tomar_foto" style="display:none !important;">
                <button type="button" class="btn btn-info" onclick="Tomar_Foto();">Tomar foto</button>
            </div>

            <div class="d-flex justify-content-center" style="display:none !important;" id="div_canvas">
                <canvas id="canvas" width="640" height="480" style="max-width:95%;"></canvas>
            </div>

            <div class="d-flex justify-content-center" style="max-width: 100%;" id="div_imagenes">
                <input type="hidden" id="imagenes_input" name="imagenes" value="">

                <div id="imagenes_container" class="d-flex flex-wrap justify-content-center">
                    <!-- Las imágenes se añadirán aquí dinámicamente -->
                </div>
            </div>
        </div>



    </div>

    <div class="modal-footer">
        @csrf
        <input type="hidden" id="hasOptionsField" name="hasOptionsField" value="0">

        <button class="btn btn-primary" type="button" onclick="Insert_Registro_Soporte();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {

        obtenerSoporteNivelPorSede(); // Llamada inicial cuando se carga el HTML
        // Inicializar el evento change para el select con ID 'idsoporte_nivel'

        // Llama a esta función cuando abras el modal o cargues la página
        initializeEspecialidadAndSede();


    });

    function obtenerSoporteNivelPorSede() {
        var url = "{{ route('soporte_nivel_por_sede') }}";
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#idsoporte_nivel').empty().append(
                    '<option value="0">Seleccione</option>'
                );

                // Verificar si hay respuestas
                if (response.length > 0) {
                    $.each(response, function(index, sede) {
                        $('#idsoporte_nivel').append(
                            `<option value="${sede.idsoporte_nivel}">${sede.nombre}</option>`
                        );
                    });
                    $('#sublist-container').show(); // Mostrar el contenedor de idsoporte_nivel
                } else {
                    $('#sublist-container').hide(); // Ocultar si no hay ubicaciones
                }
            },
            error: function(xhr) {
                console.error('Error al obtener ubicaciones:', xhr);
            }
        });
    }

    var subUbicacionCont = document.getElementById('sububicacion-container');

    function initializeEspecialidadAndSede() {
        // Variables para el manejo de "especialidad"
        var especialidadSelect = document.getElementById('especialidad');
        var elementoSelect = document.getElementById('elemento');
        var elementCont = document.getElementById('elemento-cont');
        var asuntoCont = document.getElementById('asunto-cont');
        var asuntoSelect = document.getElementById('asunto');
        var areaRow = document.getElementById('area-row');
        var elementoContainer = document.getElementById('elemento-container');
        var areaElementoRow = document.getElementById('elemento-area');
        var asuntoContainer = document.getElementById('asunto-container');

        // Verificar si especialidadSelect existe
        if (especialidadSelect) {
            function handleEspecialidadChange() {
                if (especialidadSelect.value === '4') {
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
            }

            // Elimina cualquier evento anterior antes de agregar uno nuevo
            especialidadSelect.removeEventListener('change', handleEspecialidadChange);
            especialidadSelect.addEventListener('change', handleEspecialidadChange);
        }

        // Variables para el manejo de "sede"
        var sedeSelect = document.getElementById('sede');
        var subSedeSelect = document.getElementById('idsoporte_nivel');
        var thirdSedeSelect = document.getElementById('idsoporte_area_especifica');
        var sublistContainer = document.getElementById('sublist-container');
        var thirdContainer = document.getElementById('thirdlist-container');

        // Verificar si sedeSelect existe
        if (sedeSelect) {
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

            // Elimina cualquier evento anterior antes de agregar uno nuevo
            sedeSelect.removeEventListener('change', handleSedeChange);
            sedeSelect.addEventListener('change', handleSedeChange);
        }
    }





    $('#idsoporte_nivel').on('change', function() {
        const selectedubicacion1 = $(this).val();
        var url = "{{ route('soporte_areaespecifica_por_nivel') }}";

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                ubicacion1: selectedubicacion1
            },
            success: function(response) {
                $('#idsoporte_area_especifica').empty().append(
                    '<option value="0">Seleccione Área Esp.</option>'
                );

                // Verificar si hay respuestas
                if (response.length > 0) {
                    $.each(response, function(index, ubicacion) {
                        $('#idsoporte_area_especifica').append(
                            `<option value="${ubicacion.idsoporte_area_especifica}">${ubicacion.nombre}</option>`
                        );
                    });
                    $('#thirdlist-container').css('visibility', 'visible');
                    $('#sububicacion-container').show();
                    $('#hasOptionsField').val('1');
                } else {
                    $('#thirdlist-container').css('visibility', 'hidden');
                    $('#sububicacion-container').hide();
                    $('#hasOptionsField').val('0');
                }
            },
            error: function(xhr) {
                console.error('Error al obtener ubicaciones:', xhr);
            }
        });
    });


    $('#especialidad').on('change', function() {
        const selectedEspecialidad = $(this).val();
        var url = "{{ route('elemento_por_especialidad') }}";
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                especialidad: selectedEspecialidad
            },
            success: function(response) {
                $('#elemento').empty().append('<option value="0">Seleccione</option>');
                if (response.length > 0) {
                    $.each(response, function(index, elementos) {
                        $('#elemento').append(
                            `<option value="${elementos.idsoporte_elemento}">${elementos.nombre}</option>`
                        );

                        if (selectedEspecialidad == 4) {
                            setTimeout(function() {
                                if ($('#elemento option[value="6"]').length > 0) {
                                    $('#elemento').val(6);
                                }
                                if ($('#asunto option[value="9"]').length > 0) {
                                    $('#asunto').val(9);
                                }
                            }, 100);
                        }
                    });
                }
            },
            error: function(xhr) {
                console.error('Error al obtener elementos:', xhr);
            }
        });
    });

    $('#elemento').on('change', function() {
        const selectedElemento = $(this).val();
        var url = "{{ route('asunto_por_elemento') }}";
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                elemento: selectedElemento
            },
            success: function(response) {
                $('#asunto').empty().append('<option value="0">Seleccione</option>');
                // Verificar si hay respuestas
                if (response.length > 0) {
                    $.each(response, function(index, asuntos) {
                        $('#asunto').append(
                            `<option value="${asuntos.idsoporte_asunto}">${asuntos.nombre}</option>`
                        );
                    });

                } else {}
            },
            error: function(xhr) {
                console.error('Error al obtener elementos:', xhr);
            }
        });
    });

    function Insert_Registro_Soporte() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ route('soporte_ticket.store') }}";

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
                    Lista_Tickets_Soporte();
                    $("#ModalRegistro .close").click();
                });
            },
            error: function(xhr) {
                if (xhr.status === 400) {
                    // Si es un error 400, mostramos el mensaje del servidor
                    Swal.fire(
                        '¡Error!',
                        xhr.responseJSON.error || 'Error en la solicitud.',
                        'warning'
                    );
                } else {
                    // Si es otro tipo de error, manejamos los errores en el formulario
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    Swal.fire(
                        '¡Ups!',
                        firstError,
                        'warning'
                    );
                }
            }

        });

    }

    // ACTIVACIÓN DE CÁMARA
    var video = document.getElementById('video');
    var boton = document.getElementById('boton_camara');
    var div_tomar_foto = document.getElementById('div_tomar_foto');
    var div = document.getElementById('div_camara');
    var isCameraOn = false;
    var stream = null;

    function Activar_Camara() {
        var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        if (screenWidth < 1000) {
            if (!isCameraOn) {
                //Pedir permiso para acceder a la cámara
                navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: {
                                exact: "environment"
                            }
                        }
                    })
                    .then(function(newStream) {
                        stream = newStream;
                        // Mostrar el stream de la cámara en el elemento de video
                        video.srcObject = stream;
                        video.play();
                        isCameraOn = true;
                        boton.textContent = "Desactivar cámara";
                        div_tomar_foto.style.cssText = "display: block;";
                        div.style.cssText = "display: block;";
                    })
                    .catch(function(error) {
                        console.error('Error al acceder a la cámara:', error);
                    });
            } else {
                //Detener la reproducción  del stream y liberar la cámara
                if (stream) {
                    stream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                    video.srcObject = null;
                    isCameraOn = false;
                    boton.textContent = "Activar cámara";
                    div_tomar_foto.style.cssText = "display: none !important;";
                    div.style.cssText = "display: none !important;";
                }
            }
        } else {
            if (!isCameraOn) {
                //Pedir permiso para acceder a la cámara
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(newStream) {
                        stream = newStream;
                        // Mostrar el stream de la cámara en el elemento de video
                        video.srcObject = stream;
                        video.play();
                        isCameraOn = true;
                        boton.textContent = "Desactivar cámara";
                        div_tomar_foto.style.cssText = "display: block;";
                        div.style.cssText = "display: block;";
                    })
                    .catch(function(error) {
                        console.error('Error al acceder a la cámara:', error);
                    });
            } else {
                //Detener la reproducción  del stream y liberar la cámara
                if (stream) {
                    stream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                    video.srcObject = null;
                    isCameraOn = false;
                    boton.textContent = "Activar cámara";
                    div_tomar_foto.style.cssText = "display: none !important;";
                    div.style.cssText = "display: none !important;";
                }
            }
        }
    }

    function Tomar_Foto() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ route('previsualizacion_captura_soporte') }}";
        var video = document.getElementById('video');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');

        // Ajusta el tamaño del canvas al tamaño del video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(function(blob) {
            // Crea un formulario para enviar la imagen al servidor
            dataString.append('photo', blob, 'photo.jpg');
            dataString.append('tipo', 2);

            // Realiza la solicitud AJAX
            $.ajax({
                url: url,
                data: dataString,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response == "error") {
                        Swal({
                            title: '¡Carga Denegada!',
                            text: "¡No se puede tomar más de 3 capturas!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        var ftpUrl = response.url_ftp;
                        MostrarFoto(ftpUrl);
                    }
                }
            });
        }, 'image/jpeg');
    }

    function MostrarFoto(url) {
        var divImagenes = document.getElementById('imagenes_container'); // Asegúrate de tener este contenedor en tu HTML
        var nuevaImagen = document.createElement('img'); // Crea un nuevo elemento de imagen
        nuevaImagen.src = url; // Establece la fuente de la imagen
        nuevaImagen.alt = 'Captura de soporte'; // Texto alternativo
        nuevaImagen.style.maxWidth = '95%'; // Ajustar el tamaño de la imagen
        nuevaImagen.style.margin = '10px'; // Añade margen a la imagen
        nuevaImagen.className = 'img-thumbnail'; // Clase opcional para un borde alrededor de la imagen

        // Crea el contenedor para la imagen y el botón
        var contenedorImagen = document.createElement('div');
        contenedorImagen.className = 'text-center'; // Para centrar la imagen y el botón

        // Crea el botón de eliminar
        var botonEliminar = document.createElement('button');
        botonEliminar.className = 'btn btn-danger'; // Estilo para el botón
        botonEliminar.style.marginTop = '5px'; // Añade un margen superior
        botonEliminar.onclick = function() {
            divImagenes.removeChild(contenedorImagen); // Elimina el contenedor de la imagen y el botón
        };

        // Añade el SVG al botón
        botonEliminar.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            <line x1="10" y1="11" x2="10" y2="17"></line>
            <line x1="14" y1="11" x2="14" y2="17"></line>
        </svg>
    `;

        // Añade la imagen y el botón al contenedor
        contenedorImagen.appendChild(nuevaImagen);
        contenedorImagen.appendChild(botonEliminar);
        divImagenes.appendChild(contenedorImagen); // Añade el contenedor al div principal
        actualizarInput();
    }

    function actualizarInput() {
        var divImagenes = document.getElementById('imagenes_container');
        var imagenesInput = document.getElementById('imagenes_input');

        // Obtener todas las imágenes en el contenedor
        var imagenes = divImagenes.getElementsByTagName('img');
        var urls = [];

        // Recorrer todas las imágenes y almacenar sus URLs
        for (var i = 0; i < imagenes.length; i++) {
            urls.push(imagenes[i].src);
        }

        // Almacenar las URLs como un array en formato JSON en el input
        imagenesInput.value = JSON.stringify(urls);
    }
</script>
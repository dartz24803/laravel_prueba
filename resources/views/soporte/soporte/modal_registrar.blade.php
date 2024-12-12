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
        width: 600px;
        /* Cambia este valor según tus necesidades */
        white-space: nowrap;
        /* Asegura que los elementos en línea no se rompan */
        overflow-x: auto;
        /* Habilita el scroll horizontal */
        /* Opcional: Añade un borde para visualizar mejor el contenedor */
        padding: 10px;
        /* Opcional: Añade algo de padding para un mejor aspecto */
    }

    .text-center {
        display: inline-block;
        /* Permite que los elementos se alineen horizontalmente */
        margin-right: 10px;
        /* Espacio entre las imágenes */
    }

    #imagenes_container img {
        width: 150px;
        /* Ancho fijo para todas las imágenes */
        height: 150px;
        /* Altura fija para todas las imágenes */
        border-radius: 5px;
        /* Bordes redondeados */
        cursor: pointer;
        /* Cambia el cursor al pasar por encima */
        flex-shrink: 0;
        /* Evita que las imágenes se encojan */
    }

    /* Ajuste específico para la cuarta y quinta imagen */
    #imagenes_container img:nth-child(n+4) {
        margin-left: 50px;
        /* Aumenta el margen izquierdo para la cuarta imagen y superiores */
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
            <div class="col-lg-12" id="sedelaboral_container" style="display: none;">
                <div class="row">
                    <div class="form-group col-lg-2">
                        <label class="control-label text-bold">Sede Laboral:</label>
                    </div>
                    <div class="form-group col-lg-10" id="sede_subcont" style="visibility: hidden;">
                        <select class="form-control" id="idsede_laboral" name="idsede_laboral">
                            <option value="0">Seleccione Sede.</option>
                        </select>
                    </div>
                </div>
            </div>
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

            <div class="col-lg-12" id="sububicacion-container" style="display: none;">
                <div class="row">
                    <div class="form-group col-lg-2">
                        <label class="control-label text-bold">Área Específica:</label>
                    </div>
                    <!-- Tercer select (Thirdlist-container), siempre presente pero con visibilidad controlada -->
                    <div class="form-group col-lg-10" id="thirdlist-container" style="visibility: hidden;">
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
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
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

                </select>
            </div>
        </div>



        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                    placeholder="Ingresar descripción" maxlength="150"></textarea>
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
            <div class="d-flex justify-content-center" style="max-width: 100%; overflow-x: auto;" id="div_imagenes">
                <input type="hidden" id="imagenes_input" name="imagenes" value="">
                <div id="imagenes_container" class="carousel-container">
                    <!-- Las imágenes se añadirán aquí dinámicamente -->
                </div>
            </div>


        </div>



    </div>

    <div class="modal-footer">
        @csrf
        <input type="hidden" id="hasOptionsField" name="hasOptionsField" value="0">
        <input type="hidden" id="hasOptionsFieldEspecialidad" name="hasOptionsFieldEspecialidad" value="0">

        <button class="btn btn-primary" type="button" onclick="Insert_Registro_Soporte();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        // obtenerSoporteNivelPorSede();
        initializeEspecialidadAndSede();
        validarMostrarSedeLaboral();
    });


    function validarMostrarSedeLaboral() {
        var url = "{{ route('validar_mostrar_sedelaboral') }}";
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                // Mostrar los datos recibidos
                console.log('Status:', response.status); // Booleano de la validación
                console.log('Sedes Laborales:', response.sedesLaborales); // Array de sedes laborales
                if (response.status == false) {
                    obtenerSoporteNivelPorSede();
                    $('#sedelaboral_container').hide();
                    $('#sede_subcont').css('visibility', 'hidden');
                } else {
                    $('#sedelaboral_container').show();
                    $('#sede_subcont').css('visibility', 'visible');
                    $.each(response.sedesLaborales, function(index, sede) {
                        $('#idsede_laboral').append(
                            `<option value="${sede.id}">${sede.descripcion}</option>`
                        );
                    });
                }

            },
            error: function(xhr) {
                console.error('Error al obtener ubicaciones:', xhr);
            }
        });
    }


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

    $('#idsede_laboral').on('change', function() {
        const selectedSede = $(this).val();
        var url = "{{ route('nivel_por_sede') }}";
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                sede: selectedSede
            },
            success: function(response) {
                $('#idsoporte_nivel').empty().append('<option value="0">Seleccione</option>');
                if (response.length > 0) {
                    $.each(response, function(index, elementos) {
                        $('#idsoporte_nivel').append(
                            `<option value="${elementos.id}">${elementos.nombre}</option>`
                        );


                    });
                }
            },
            error: function(xhr) {
                console.error('Error al obtener elementos:', xhr);
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
                            $('#hasOptionsFieldEspecialidad').val('1');
                        } else {
                            $('#hasOptionsFieldEspecialidad').val('0');
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

                // Iterar sobre la respuesta y añadir opciones con el atributo `data-evidencia`
                $.each(response, function(index, asunto) {
                    $('#asunto').append(
                        `<option value="${asunto.idsoporte_asunto}" data-evidencia="${asunto.evidencia_adicional}">${asunto.nombre}</option>`
                    );
                });
            },
            error: function(xhr) {
                console.error('Error al obtener elementos:', xhr);
            }
        });
    });

    $('#asunto').on('change', function() {
        const selectedOption = $(this).find(':selected');
        const evidenciaAdicional = selectedOption.data('evidencia');

        // Mostrar u ocultar el tooltip en base al valor de `evidencia_adicional`
        if (evidenciaAdicional === 1) {
            $('#asunto-cont').html(`
            <label class="control-label text-bold">Asunto:</label>
            <span title="Evidencia mínima de carga : 3 Imágenes" style="display: inline-block; cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
            </span>
        `);
        } else {
            // Restaurar el contenido original sin el ícono de información
            $('#asunto-cont').html(`
            <label class="control-label text-bold">Asunto:</label>
        `);
        }
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
        // Verifica cuántas imágenes ya se han subido
        var divImagenes = document.getElementById('imagenes_container');
        var imagenes = divImagenes.getElementsByTagName('img');

        if (imagenes.length >= 5) {
            Swal({
                title: '¡Carga Denegada!',
                text: "¡No se puede tomar más de 5 capturas!",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            return; // Salir de la función si ya hay 3 imágenes
        }

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
        var divImagenes = document.getElementById('imagenes_container'); // Contenedor de imágenes
        var contenedorImagen = document.createElement('div'); // Crea el contenedor para la imagen y los botones
        contenedorImagen.className = 'text-center my-2'; // Centrar y agregar margen vertical
        contenedorImagen.style.position = 'relative'; // Permite posicionar los botones dentro de este contenedor

        // Crear la imagen
        var nuevaImagen = document.createElement('img');
        nuevaImagen.src = url;
        nuevaImagen.alt = 'Captura de soporte';
        nuevaImagen.style.width = '150px'; // Ancho fijo para la imagen
        nuevaImagen.style.height = '150px'; // Altura fija para la imagen
        nuevaImagen.className = 'img-thumbnail';
        nuevaImagen.style.display = 'block'; // Asegura que la imagen esté alineada verticalmente

        // Crear botón para eliminar
        var botonEliminar = document.createElement('button');
        botonEliminar.className = 'btn btn-danger mt-2'; // Estilo del botón
        botonEliminar.onclick = function() {
            divImagenes.removeChild(contenedorImagen); // Elimina el contenedor de imagen y botones
            actualizarInput(); // Actualiza el input
        };
        // SVG del botón de eliminar
        botonEliminar.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            <line x1="10" y1="11" x2="10" y2="17"></line>
            <line x1="14" y1="11" x2="14" y2="17"></line>
        </svg>
    `;

        // Crear botón para abrir en nueva pestaña
        var botonAbrir = document.createElement('button');
        botonAbrir.className = 'btn btn-primary mt-2 ms-2'; // Estilo del botón de abrir
        botonAbrir.onclick = function(event) {
            event.preventDefault(); // Evita que se recargue la página
            window.open(url, '_blank'); // Abre en una nueva pestaña
        };

        botonAbrir.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
            <polyline points="15 3 21 3 21 9"></polyline>
            <line x1="10" y1="14" x2="21" y2="3"></line>
        </svg> Ver
    `;

        // Agregar imagen y botones al contenedor
        contenedorImagen.appendChild(nuevaImagen);
        contenedorImagen.appendChild(botonEliminar);
        contenedorImagen.appendChild(botonAbrir);

        // Añadir el contenedor principal al div de imágenes
        divImagenes.appendChild(contenedorImagen);

        // Actualiza el input oculto con la lista de URLs
        actualizarInput();
        // Verificar si el contenedor debe tener scroll
        verificarScroll();
    }




    function verificarScroll() {
        var divImagenes = document.getElementById('imagenes_container');
        var imagenes = divImagenes.getElementsByTagName('img');
        console.log("#####");
        console.log(imagenes.length);

        // Agregar la clase `scrollable` si hay 3 o más imágenes
        if (imagenes.length >= 3) {
            divImagenes.classList.add('scrollable');
        } else {
            divImagenes.classList.remove('scrollable');
        }
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
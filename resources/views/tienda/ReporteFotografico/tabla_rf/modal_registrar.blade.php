            <!-- Formulario Mantenimiento -->
            <form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Reporte Fotografico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body" style="max-height:450px; overflow:auto;">
                    <div class="form-group col-md-12 d-flex justify-content-around align-items-center">
                        <div class="col-sm-2">
                            <label for="my-input">Codigo : <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-sm-6">
                            <select class="basic_i" name="codigo" id="codigo" style="width: min-content;">
                                <option value="0">Selec.</option>
                                <?php foreach ($list_codigos as $list) { ?>
                                    <option value="<?php echo $list['id']; ?>"><?php echo $list['descripcion'] . ' - ' . $list['base'] . ' - ' . $list['categoria'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-secondary" id="boton_camara" onclick="Activar_Camara();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera">
                                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                    <circle cx="12" cy="13" r="4"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mb-2" id="div_camara" style="display:none !important;">
                        <video id="video" autoplay style="max-width: 55%;"></video>
                    </div>
                    <div class="row d-flex justify-content-center mb-2 mt-2" id="div_tomar_foto" style="display:none !important;">
                        <button type="button" class="btn btn-info" onclick="Tomar_Foto();">Tomar foto</button>
                    </div>
                    <div id="div_canvas" style="display:none !important;">
                        <canvas id="canvas"></canvas>
                    </div>

                    <div id="imagen-container" class="d-flex justify-content-center">
                    </div>
                </div>
                <div class="modal-footer">
                    @csrf
                    <button class="btn btn-primary mt-3" onclick="Registrar_Reporte_Fotografico();" type="button">Guardar</button>
                    <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                </div>
            </form>
            <script src="https://cdn.rawgit.com/exif-js/exif-js/master/exif.js"></script>
            <script>
                $(document).ready(function() {
                    cargarImagenes();
                });

                function Registrar_Reporte_Fotografico() {
                    Cargando();
                    var csrfToken = $('input[name="_token"]').val();

                    var dataString = new FormData(document.getElementById('formulario_insert'));
                    var url = "{{ url('Registrar_Reporte_Fotografico') }}";

                    $.ajax({
                        url: url,
                        data: dataString,
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data.error == "") {
                                swal.fire(
                                    'Registro Exitoso!',
                                    'Haga clic en el botón!',
                                    'success'
                                ).then(function() {
                                    $("#ModalRegistro .close").click()
                                    Reporte_Fotografico_Listar();
                                });
                            } else {
                                Swal.fire(
                                    '¡Ups!',
                                    data.error[0],
                                    'error'
                                );
                            }
                        }
                    });
                }

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
                                div_tomar_foto.style.cssText = "display: none !important;";
                                div.style.cssText = "display: none !important;";
                            }
                        }
                    }
                }

                function Tomar_Foto() {
                    Cargando();

                    var dataString = new FormData(document.getElementById('formulario_insert'));
                    var url = "{{ url('Previsualizacion_Captura2') }}";
                    var video = document.getElementById('video');
                    var div_canvas = document.getElementById('div_canvas');
                    var canvas = document.getElementById('canvas');
                    var context = canvas.getContext('2d');

                    // Ajusta el tamaño del canvas al tamaño del video
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;

                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    canvas.toBlob(function(blob) {
                        // Crea un formulario para enviar la imagen al servidor
                        dataString.append('photo1', blob, 'photo1.jpg');

                        // Realiza la solicitud AJAX
                        $.ajax({
                            url: url,
                            data: dataString,
                            type: 'POST',
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response === "error") {
                                    swal.fire({
                                        title: 'Error',
                                        text: "Solo puede tomar una foto!",
                                        type: 'error',
                                        showCancelButton: false,
                                        timer: 2000
                                    });
                                }
                                if (response.error === "") {
                                    cargarImagenes();
                                }
                            }
                        });
                    }, 'image/jpeg');
                }


                function cargarImagenes() {
                    $.ajax({
                        url: "{{ url('obtenerImagenes') }}", // Reemplaza con la URL de tu controlador
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#imagen-container').empty();

                            if (data.length > 0) {
                                $.each(data, function(index, imagen) {
                                    var timestamp = new Date().getTime();
                                    var imgElement = $('<img id="foto" loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" src="https://lanumerounocloud.com/intranet/REPORTE_FOTOGRAFICO/' + imagen.ruta + '?v=' + timestamp + '" alt="Foto">');
                                    var deleteButton = $('<a href="javascript:void(0);" title="Eliminar" onClick="Delete_Imagen_Temporal(' + imagen.id + ')"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>');
                                    var container = $('<div class="image-item mr-4"></div>'); // Contenedor para la imagen y el botón de eliminar
                                    container.append(imgElement);
                                    container.append(deleteButton);

                                    $('#imagen-container').append(container);
                                });
                            } else {
                                $('#imagen-container').html('No hay fotos subidas.');
                            }
                        },
                        error: function() {
                            alert('Error al cargar las imágenes.');
                        }
                    });
                }

                function Delete_Imagen_Temporal(id) {
                    var url = "{{ url('Delete_Imagen_Temporal') }}";
                    var csrfToken = $('input[name="_token"]').val();

                    swal.fire({
                        title: '¿Realmente desea eliminar la foto?',
                        text: "El registro será eliminado permanentemente",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "DELETE",
                                url: url,
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                data: {
                                    'id': id
                                },
                                success: function() {
                                    swal.fire(
                                        'Eliminado!',
                                        'La imagen ha sido eliminado satisfactoriamente.',
                                        'success'
                                    ).then(function() {
                                        cargarImagenes();
                                    });
                                }
                            });
                        }
                    })
                    return false;
                }
                $(document).on("click", ".img_post", function() {
                    window.open($(this).attr("src"), 'popUpWindow', "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no");
                });

                $('.basic_i').select2({
                    dropdownParent: $('#ModalRegistro')
                });
            </script>
            <style>
                .select2-container--default .select2-results>.select2-results__options {
                    height: 5rem;
                }

                .select2-results__option {
                    color: red;
                }

                .modal-content {
                    height: 50rem;
                }

                .modal-body {
                    max-height: none !important;
                    height: 40rem;
                }

                .select2-hidden-accessible {
                    position: static !important;
                }

                #foto {
                    width: 11rem;
                }
            </style>
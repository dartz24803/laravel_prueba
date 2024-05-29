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
                    <div class="form-group col-md-12">
                        <label for="my-input">Codigo : <span class="text-danger">*</span></label>
                        <div class="form-group col-lg-12">
                            <select class="form-control basic_i" name="codigo" id="codigo" style="width: 100%;">
                                <option value="">Seleccionar</option>
                                <?php foreach($list_codigos as $list){ ?>
                                    <option value="<?php echo $list['descripcion']; ?>"><?php echo $list['descripcion'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center mb-2 mt-2">
                        <button type="button" class="btn btn-secondary" id="boton_camara" onclick="Activar_Camara();">Activar cámara</button>
                    </div>
                    <div class="row d-flex justify-content-center mb-2" id="div_camara" style="display:none !important;">
                        <video id="video" autoplay style="max-width: 95%;"></video>
                    </div>
                    <div class="row d-flex justify-content-center mb-2 mt-2" id="div_tomar_foto" style="display:none !important;">
                        <button type="button" class="btn btn-info" onclick="Tomar_Foto();">Tomar foto</button>
                    </div>
                    <div class="row d-flex justify-content-center text-center" id="div_canvas" style="display:none !important;">
                        <canvas id="canvas" width="640" height="480" style="max-width:95%;"></canvas>
                    </div>

                    <div id="imagen-container" class="d-flex justify-content-center ml-4">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary mt-3" onclick="Registrar_Reporte_Fotografico();" type="button">Guardar</button>
                    <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                </div>
            </form>
<script>
    $(document).ready(function() {
        cargarImagenes();
    });
    function Registrar_Reporte_Fotografico() {
        //Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ url('Registrar_Reporte_Fotografico') }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) { 
                    if (data.error == ""){
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $("#ModalRegistro .close").click()
                            Reporte_Fotografico_Listar();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.error,
                            icon: 'error',
                            showConfirmButton: true,
                        })
                    }
                }
            });
    }
/*
    function Valida_Registrar() {
        if ($('#codigo').val() == '0') {
            swal.fire(
                'Ups!',
                'Debe ingresar codigo.',
                'warning'
            ).then(function() { });
            return false
        }
        return true;
    }*/
    var video = document.getElementById('video');
    var boton = document.getElementById('boton_camara');
    var div_tomar_foto = document.getElementById('div_tomar_foto');
    var div = document.getElementById('div_camara');
    var isCameraOn = false;
    var stream = null;
    function Activar_Camara(){
        var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        if(screenWidth<1000){
            if(!isCameraOn){
                //Pedir permiso para acceder a la cámara
                navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: {
                            exact: "environment"
                        }
                    }
                })
                .then(function (newStream){
                    stream = newStream;
                    // Mostrar el stream de la cámara en el elemento de video
                    video.srcObject = stream;
                    video.play();
                    isCameraOn = true;
                    boton.textContent = "Desactivar cámara";
                    div_tomar_foto.style.cssText = "display: block;";
                    div.style.cssText = "display: block;";
                })
                .catch(function (error){
                    console.error('Error al acceder a la cámara:', error);
                });
            }else{
                //Detener la reproducción  del stream y liberar la cámara
                if(stream){
                    stream.getTracks().forEach(function (track){
                        track.stop();
                    });
                    video.srcObject = null;
                    isCameraOn = false;
                    boton.textContent = "Activar cámara";
                    div_tomar_foto.style.cssText = "display: none !important;";
                    div.style.cssText = "display: none !important;";
                }
            }
        }else{
            if(!isCameraOn){
                //Pedir permiso para acceder a la cámara
                navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function (newStream){
                    stream = newStream;
                    // Mostrar el stream de la cámara en el elemento de video
                    video.srcObject = stream;
                    video.play();
                    isCameraOn = true;
                    boton.textContent = "Desactivar cámara";
                    div_tomar_foto.style.cssText = "display: block;";
                    div.style.cssText = "display: block;";
                })
                .catch(function (error){
                    console.error('Error al acceder a la cámara:', error);
                });
            }else{
                //Detener la reproducción  del stream y liberar la cámara
                if(stream){
                    stream.getTracks().forEach(function (track){
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
    var fotos_tomadas = 0; // Contador para el número de fotos tomadas

    function Tomar_Foto() {
        //Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ url('Previsualizacion_Captura2') }}";
        var video = document.getElementById('video');
        var div_canvas = document.getElementById('div_canvas');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(function(blob) {
            // Crea un formulario para enviar la imagen al servidor
            dataString.append('photo' + (fotos_tomadas + 1), blob, 'photo' + (fotos_tomadas + 1) + '.jpg');

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
                    } else {
                        // div_canvas.style.cssText = "display: block;";
                        $('#captura').val('1');
                        fotos_tomadas++; // Incrementa el contador de fotos tomadas
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
                        var imgElement = $('<img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" src="https://lanumerounocloud.com/intranet/REPORTE_FOTOGRAFICO/' + imagen.ruta + '?v=' + timestamp + '" width=240" height="120" alt="Foto">');
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
    $(document).on("click", ".img_post", function () {
        window.open($(this).attr("src"), 'popUpWindow', "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no");
    });
/*
    $('.basic_i').select2({
        dropdownParent: $('#ModalRegistrar')
    });*/
</script>
<style>
    .select2-container--default .select2-results > .select2-results__options {
        height: 5rem;
    }
    .select2-results__option {
        color: red;
    }
</style>

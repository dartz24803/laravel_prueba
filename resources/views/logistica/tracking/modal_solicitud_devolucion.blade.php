<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Ingreso de detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo falla: </label>
            </div>
            <div class="form-group col-lg-8">
                <input type="text" class="form-control" name="tipo_falla" id="tipo_falla" 
                placeholder="Tipo falla" value="{{ $get_id->tipo_falla ?? '' }}">
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-secondary" id="boton_camara" onclick="Activar_Camara();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Cantidad: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad"
                value="{{ $get_id->cantidad ?? '' }}" onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row d-flex justify-content-center mb-2" id="div_camara" style="display:none !important;">
            <video id="video" autoplay style="max-width: 95%;"></video>
        </div>
        <div class="row d-flex justify-content-center mb-2 mt-2" id="div_tomar_foto" style="display:none !important;">
            <button type="button" class="btn btn-info" onclick="Tomar_Foto();">Tomar foto</button>
        </div>
        <div class="row d-flex justify-content-center text-center" style="display:none !important;">
            <canvas id="canvas" width="640" height="480" style="max-width:95%;"></canvas>
        </div>

        <div id="lista_archivo">
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Devolucion_Temporal();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    Lista_Archivo();

    function Lista_Archivo(){
        Cargando();

        var url = "{{ route('tracking.list_archivo') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'tipo':3,'id_producto':{{ $get_producto->id }}},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#lista_archivo').html(resp);  
            }
        });
    }

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
                    boton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera-off"><line x1="1" y1="1" x2="23" y2="23"></line><path d="M21 21H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3m3-3h6l2 3h4a2 2 0 0 1 2 2v9.34m-7.72-2.06a4 4 0 1 1-5.56-5.56"></path></svg>';
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
                    boton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>';
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
                    boton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera-off"><line x1="1" y1="1" x2="23" y2="23"></line><path d="M21 21H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3m3-3h6l2 3h4a2 2 0 0 1 2 2v9.34m-7.72-2.06a4 4 0 1 1-5.56-5.56"></path></svg>';
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
                    boton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>';
                    div_tomar_foto.style.cssText = "display: none !important;";
                    div.style.cssText = "display: none !important;";
                }
            }
        }
    }

    function Tomar_Foto(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('tracking.previsualizacion_captura') }}";
        var video = document.getElementById('video');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(function(blob) {
            // Crea un formulario para enviar la imagen al servidor
            dataString.append('photo', blob, 'photo.jpg');
            dataString.append('tipo', 3);
            dataString.append('id_producto', {{ $get_producto->id }});

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
                    }else{
                        Lista_Archivo();
                    }
                }
            });
        }, 'image/jpeg');
    }

    function Insert_Devolucion_Temporal(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('tracking.insert_devolucion_temporal', $get_producto->id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success:function (data) {
                swal.fire(
                    '¡Registro Exitoso!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    $("#ModalUpdate .close").click();
                });
            },
            error:function(xhr) {
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
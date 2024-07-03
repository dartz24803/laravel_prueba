<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">{{ $titulo }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div> 
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ session('usuario')->centro_labores }}" disabled>
            </div>
        
            <div class="form-group col-lg-2">
                <label>Fecha: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ date('d/m/Y') }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Hora programada: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="time" class="form-control" value="{{ $get_hora->hora_programada }}" disabled>
            </div>

            <div class="form-group col-lg-2 d-flex justify-content-center d-lg-block">
                <button type="button" class="btn btn-secondary" id="boton_camarae" onclick="Activar_Camarae();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Observaciones:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control multivalue" name="observacionese[]" id="observacionese" multiple="multiple">
                    @foreach ($list_observacion as $list)
                        <option value="{{ $list->id }}">{{ $list->descripcion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <input type="checkbox" name="otrose" id="otrose" value="1" onclick="Otra_Observacion('e')">
                <label for="otrose">Otros</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="otra_observacione" id="otra_observacione" 
                placeholder="Otros" style="display: none;">
            </div>
        </div>

        <div class="row d-flex justify-content-center mb-2 mt-2" id="div_tomar_fotoe" style="display:none !important;">
            <button type="button" class="btn btn-info" onclick="Tomar_Fotoe();">Tomar foto</button>
        </div>
        <div class="row d-flex justify-content-center mb-4" id="div_camarae" style="display:none !important;">
            <video id="videoe" autoplay style="max-width: 95%;"></video>
        </div>
        <div class="row d-flex justify-content-center text-center mb-4" id="div_canvase" style="display:none !important;">
            <p class="mt-2">Recuerda que puedes tomar otra foto presionando nuevamente <mark style="background-color:#2196F3;color:white;">Tomar foto</mark> o guardar el registro presionando <mark style=background-color:#1B55E2;color:white;>Guardar</mark></p>
            <canvas id="canvase" style="max-width:95%;"></canvas>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <input type="hidden" id="capturae" name="capturae">
        <button id="boton_disablede" class="btn btn-primary" type="button" onclick="Update_Apertura_Cierre();" disabled>Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalUpdate')
    });

    var video = document.getElementById('videoe');
    var boton = document.getElementById('boton_camarae');
    var div_tomar_foto = document.getElementById('div_tomar_fotoe'); 
    var div = document.getElementById('div_camarae'); 
    var isCameraOn = false;
    var stream = null;

    function Activar_Camarae(){
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

    function Tomar_Fotoe(){
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('apertura_cierre.previsualizacion_captura_put') }}";
        var video = document.getElementById('videoe');
        var div_canvas = document.getElementById('div_canvase');
        var canvas = document.getElementById('canvase');
        var context = canvas.getContext('2d');

        // Ajusta el tamaño del canvas al tamaño del video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(function(blob) {
            // Crea un formulario para enviar la imagen al servidor
            dataString.append('photo', blob, 'photo.jpg');

            // Realiza la solicitud AJAX
            $.ajax({
                url: url,
                data: dataString,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function(response) {
                    div_canvas.style.cssText = "display: block;";
                    $('#boton_disablede').prop('disabled', false);
                    $('#capturae').val('1');
                }
            });
        }, 'image/jpeg');
    }

    function Update_Apertura_Cierre(){
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('apertura_cierre.update', $get_id->id_apertura_cierre) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success:function (data) {
                swal.fire(
                    '¡Actualización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Apertura_Cierre();
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
<link href="{{ asset('template/inputfiles/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('template/inputfiles/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<script src="{{ asset('template/inputfiles/js/plugins/piexif.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/plugins/sortable.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/fileinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/locales/es.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/fas/theme.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/explorer-fas/theme.js') }}" type="text/javascript"></script>

<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Nueva supervisión de tienda:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row ml-2 mr-2">
            <table class="table">
                <tr>
                    <td><label class="control-label text-bold">Si</label></td>
                    <td><label class="control-label text-bold">No</label></td>
                </tr>
                @foreach ($list_contenido as $list)
                    <tr>
                        <td>
                            <div class="radio-buttons">
                                <label class="radio-button radio-button-si">
                                    <input type="radio" name="radio_{{ $list->id }}" value="1">
                                    <div class="radio-circle"></div>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="radio-buttons">
                                <label class="radio-button radio-button-no">
                                    <input type="radio" name="radio_{{ $list->id }}" value="2">
                                    <div class="radio-circle"></div>
                                </label>
                            </div>
                        </td>
                        <td>
                            <label class="control-label text-bold">{{ $list->descripcion }}</label>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="row ml-2 mr-2">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Observación: </label>
                <textarea class="form-control" name="observacion" id="observacion" rows="5" placeholder="Observación"></textarea>
            </div>  
        </div>

        <div class="row ml-2 mr-2">
             <div class="form-group col-lg-12">
                <label class="control-label text-bold">Evidencia(s): </label>
            </div>
            <div class="form-group col-lg-12">
                <input type="file" class="form-control" name="archivos[]" id="archivos" multiple>
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
            <p class="mt-2">Recuerda que puedes tomar otra foto presionando nuevamente <mark style="background-color:#2196F3;color:white;">Tomar foto</mark> o guardar el registro presionando <mark style=background-color:#1B55E2;color:white;>Guardar</mark></p>
        </div>	           	                	        
    </div>

    <div class="modal-footer">
        @csrf
        <input type="hidden" name="base" value="{{ session('usuario')->centro_labores }}">
        <input type="hidden" name="fecha" value="{{ date('Y-m-d') }}">
        <input type="hidden" id="captura" name="captura" value="0">
        <button class="btn btn-primary" type="button" onclick="Insert_Supervision_Tienda();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('#archivos').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['jpg','png','jpeg','JPG','PNG','JPEG'],
    });

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

    function Tomar_Foto(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('administrador_st.previsualizacion_captura') }}";
        var video = document.getElementById('video');
        var div_canvas = document.getElementById('div_canvas');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
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
                    $('#captura').val('1');
                }
            });
        }, 'image/jpeg');
    }

    function Insert_Supervision_Tienda(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('administrador_st.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Supervision_Tienda();
                        $("#ModalRegistroGrande .close").click();
                    });
                }
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

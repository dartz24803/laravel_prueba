<link href="{{ asset('template/inputfiles/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('template/inputfiles/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<script src="{{ asset('template/inputfiles/js/plugins/piexif.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/plugins/sortable.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/fileinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/locales/es.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/fas/theme.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/explorer-fas/theme.js') }}" type="text/javascript"></script>

<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar supervisión de tienda:</h5>
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
                                    <input type="radio" name="radioe_{{ $list->id }}" value="1" 
                                    @if ($list_detalle->pluck('id_contenido')->contains($list->id))
                                        @php
                                            $posicion = $list_detalle->search(function($item) use ($list) {
                                                return $item->id_contenido == $list->id;
                                            });
                                        @endphp

                                        @if ($list_detalle[$posicion]->valor == 1)
                                            checked
                                        @endif
                                    @endif>
                                    <div class="radio-circle"></div>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="radio-buttons">
                                <label class="radio-button radio-button-no">
                                    <input type="radio" name="radioe_{{ $list->id }}" value="2"
                                    @if ($list_detalle->pluck('id_contenido')->contains($list->id))
                                        @php
                                            $posicion = $list_detalle->search(function($item) use ($list) {
                                                return $item->id_contenido == $list->id;
                                            });
                                        @endphp

                                        @if ($list_detalle[$posicion]->valor == 2)
                                            checked
                                        @endif
                                    @endif>
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
                <textarea class="form-control" name="observacione" id="observacione" rows="5" placeholder="Observación">{{ $get_id->observacion }}</textarea>
            </div>  
        </div>

        <div class="row ml-2 mr-2">
             <div class="form-group col-lg-12">
                <label class="control-label text-bold">Evidencia(s): </label>
            </div>
            <div class="form-group col-lg-12">
                <input type="file" class="form-control" name="archivose[]" id="archivose" multiple>
            </div>
        </div>

        <div class="row d-flex justify-content-center mb-2 mt-2">
            <button type="button" class="btn btn-secondary" id="boton_camarae" onclick="Activar_Camarae();">Activar cámara</button>
        </div>
        <div class="row d-flex justify-content-center mb-2" id="div_camarae" style="display:none !important;">
            <video id="videoe" autoplay style="max-width: 95%;"></video>
        </div>
        <div class="row d-flex justify-content-center mb-2 mt-2" id="div_tomar_fotoe" style="display:none !important;">
            <button type="button" class="btn btn-info" onclick="Tomar_Fotoe();">Tomar foto</button>
        </div>
        <div class="row d-flex justify-content-center" id="div_canvase" style="display:none !important;">
            <canvas id="canvase" width="640" height="480" style="max-width:95%;"></canvas>
            <p class="mt-2">Recuerda que puedes tomar otra foto presionando nuevamente <mark style="background-color:#2196F3;color:white;">Tomar foto</mark> o guardar el registro presionando <mark style=background-color:#1B55E2;color:white;>Guardar</mark></p>
        </div>

        @if (count($list_archivo)>0)
            <div class="row ml-2 mr-2">
                <label class="control-label text-bold">Evidencia(s) actual(es): <a href="#" title="Estos archivos sirven como evidencia de la supervisión de tienda" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a></label>
            </div>
            <div class="row ml-2 mr-2">
                @foreach ($list_archivo as $list)
                    <div id="i_{{ $list->id }}" class="col-lg-3">
                        <div id="lista_escogida">
                            <img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" 
                            alt="Evidencia" 
                            src="{{ $list->archivo }}">
                        </div>
                        <a href="javascript:void(0);" title="Descargar" onclick="Descargar_Evidencia('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud text-dark">
                                <polyline points="8 17 12 21 16 17"></polyline>
                                <line x1="12" y1="12" x2="12" y2="21"></line>
                                <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                            </svg>
                        </a>
                        <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Evidencia('{{ $list->id }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif	 	           	                	        
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <input type="hidden" id="capturae" name="capturae" value="0">
        <button class="btn btn-primary" type="button" onclick="Update_Supervision_Tienda();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('#archivose').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['jpg','png','jpeg','JPG','PNG','JPEG'],
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

    function Tomar_Fotoe(){
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('administrador_st.previsualizacion_captura_put') }}";
        var video = document.getElementById('videoe');
        var div_canvas = document.getElementById('div_canvase');
        var canvas = document.getElementById('canvase');
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
                    $('#capturae').val('1');
                }
            });
        }, 'image/jpeg');
    }

    $(".img_post").click(function () {
        var popupWidth = this.naturalWidth;
        var popupHeight = this.naturalHeight;
        
        // Calcular las coordenadas X e Y para centrar la ventana emergente
        var leftPosition = (window.screen.width - popupWidth) / 2;
        var topPosition = (window.screen.height - popupHeight) / 2;

        // Abrir la ventana emergente en el centro de la pantalla
        window.open($(this).attr("src"), 'popUpWindow', "height=" + popupHeight + ",width=" + popupWidth + ",top=" + topPosition + ",left=" + leftPosition + ",resizable=yes,toolbar=yes,menubar=no");
    });
    
    function Delete_Evidencia(id){
        Cargando();

        var url = "{{ route('administrador_st.destroy_evidencia', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: 'DELETE',
            url: url,
            data: {'id':id},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (data) {
                $('#i_' + id).remove();            
            }
        });
    }

    function Update_Supervision_Tienda() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('administrador_st.update', $get_id->id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    '¡Actualización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Supervision_Tienda();
                    $("#ModalUpdateGrande .close").click();                            
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
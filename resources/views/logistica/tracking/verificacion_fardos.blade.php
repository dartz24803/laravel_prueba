@extends('layouts.plantilla')

@section('navbar')
    @include('logistica.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Verificación de fardos</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row"> 
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6 p-3">
                        <form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Observación: </label>
                                </div>
                                <div class="form-group col-lg-11">
                                    <textarea class="form-control" id="observacion_inspf" name="observacion_inspf" placeholder="Observación" rows="3"></textarea>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Evidencia: </label>
                                </div>
                                <div class="form-group ml-3 ml-lg-0 d-flex align-items-center">
                                    <input type="file" class="form-control-file" name="archivo_inspf" id="archivo_inspf" onchange="Valida_Factura_Transporte();">
                                    <a onclick="Limpiar_Ifile();" style="cursor: pointer" title="Borrar archivo seleccionado">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x text-danger">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </a>
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
                            
                            @csrf
                            <div id="lista_archivo">
                            </div>
    
                            <div class="modal-footer mt-3"> 
                                <input type="hidden" name="id" value="{{ $get_id->id }}">
                                <button class="btn btn-primary" type="button" onclick="Insert_Reporte_Inspeccion_Fardo();">Guardar</button>
                                <a class="btn" href="{{ route('tracking') }}">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#logisticas").addClass('active');
            $("#hlogisticas").attr('aria-expanded', 'true');
            $("#trackings").addClass('active');

            Lista_Archivo();
        });

        function Limpiar_Ifile(){
            $('#archivo_inspf').val('');
        }

        function Lista_Archivo(){
            Cargando();

            var url = "{{ route('tracking.list_archivo') }}";
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'tipo':2},
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

        function Tomar_Foto() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.previsualizacion_captura') }}";
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
                        }else{
                            Lista_Archivo();
                        }
                    }
                });
            }, 'image/jpeg');
        }

        function Insert_Reporte_Inspeccion_Fardo() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.reporte_inspeccion_fardo') }}";

            if (Valida_Insert_Reporte_Inspeccion_Fardo()) {
                $.ajax({
                    url: url,
                    data: dataString,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        swal.fire(
                            '!Cambio de estado exitoso!',
                            '!Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "{{ route('tracking') }}";
                        });
                    }
                });
            }
        }

        function Valida_Insert_Reporte_Inspeccion_Fardo() {
            if ($('#observacion_inspf').val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar observación.',
                    'warning'
                ).then(function() {});
                return false;
            }
            return true;
        }
    </script>
@endsection
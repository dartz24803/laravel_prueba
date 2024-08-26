@extends('layouts.plantilla_new')

@section('navbar')
    @include('logistica.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Pago de transporte</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row"> 
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6 p-3">
                        <form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">Nro. Req.: {{ $get_id->n_requerimiento }}</label>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Nombre de empresa: </label>
                                </div>
                                <div class="form-group col-lg-5">
                                    <input type="text" class="form-control" name="nombre_transporte" id="nombre_transporte" placeholder="Nombre de empresa" value="{{ $get_id->nombre_transporte }}">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Importe a pagar: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="importe_transporte" id="importe_transporte" placeholder="Importe a pagar" value="{{ $get_id->importe_transporte }}" onkeypress="return solo_Numeros_Punto(event);">
                                </div>
    
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">N° Factura: </label>
                                </div>
                                <div class="form-group col-lg-2">
                                    <input type="text" class="form-control" name="factura_transporte" id="factura_transporte" placeholder="N° Factura" value="{{ $get_id->factura_transporte }}">
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="form-group col-lg-2">
                                    <label class="control-label text-bold">PDF de factura: </label>
                                    @if ($get_id->archivo_transporte!="")
                                        <a href="javascript:void(0);" title="Descargar" onclick="Descargar_Pdf_Factura();">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud text-dark">
                                                <polyline points="8 17 12 21 16 17"></polyline>
                                                <line x1="12" y1="12" x2="12" y2="21"></line>
                                                <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                                <div class="form-group ml-3 ml-lg-0 d-flex align-items-center">
                                    <input type="file" class="form-control-file" name="archivo_transporte" id="archivo_transporte" onchange="Valida_Factura_Transporte();">
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
    
                            <div class="modal-footer mt-3">
                                @csrf
                                <input type="hidden" name="archivo_transporte_actual" value="{{ $get_id->archivo_transporte }}">
                                <input type="hidden" id="captura" name="captura" value="0">
                                <button class="btn btn-primary" type="button" onclick="Insert_Confirmacion_Pago_Transporte();">Guardar</button>
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
        });

        function Limpiar_Ifile(){
            $('#archivo_transporte').val('');
        }

        function solo_Numeros_Punto(e) {
            var key = event.which || event.keyCode;
            if ((key >= 48 && key <= 57) || key == 46) {
                if (key == 46 && event.target.value.indexOf('.') !== -1) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }

        function Valida_Factura_Transporte(){
            var archivoInput = document.getElementById('archivo_transporte');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.pdf)$/i;

            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivos con extensiones .pdf.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = ''; 
                return false;
            }else{
                return true;         
            }
        }

        function Descargar_Pdf_Factura(id){
            window.open('{{ $get_id->archivo_transporte }}', '_blank');
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
            var url = "{{ route('tracking.previsualizacion_captura_pago') }}";
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

        function Insert_Confirmacion_Pago_Transporte() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.confirmacion_pago_transporte', $get_id->id) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        '¡Cambio de estado exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "{{ route('tracking') }}";
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
@endsection
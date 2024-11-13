@extends('layouts.plantilla')

@section('navbar')
@include('logistica.navbar')
@endsection

@section('content')
<style>
    input[disabled] {
        background-color: white !important;
        color: black;
    }
</style>

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
                            @php
                                $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
                                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);
                            @endphp

                            <div class="form-group col-lg-2">
                                <label class="control-label text-bold" style="color: black;">SEMANA: {{ date('W') }}</label>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="control-label text-bold" style="color: black;">Fecha: {{ $fecha_formateada }}</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-1">
                                <label class="control-label text-bold">Guía de Remisión: </label>
                            </div>
                            <div class="form-group col-lg-1">
                                @if ($get_id->guia_tpago!="")
                                    <a href="{{ $get_id->guia_tpago }}" title="Guía de remisión" target="_blank">
                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                        </svg>
                                    </a>
                                @endif
                            </div>

                            <div class="form-group col-lg-1">
                                <label class="control-label text-bold">Nombre de empresa: </label>
                            </div>
                            <div class="form-group col-lg-5">
                                <input type="text" class="form-control" placeholder="Nombre de empresa"
                                    value="{{ $get_id->nombre_transporte }}" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-1">
                                <label class="control-label text-bold">Nro. GR Transporte: </label>
                            </div>
                            <div class="form-group col-lg-2">
                                <input type="text" class="form-control" name="guia_transporte"
                                    id="guia_transporte" placeholder="Nro. GR Transporte"
                                    value="{{ $get_id->guia_transporte }}"
                                    @if ($get_id->guia_transporte!="") disabled @endif>
                                @if ($get_id->guia_transporte!="")
                                <input type="hidden" name="guia_transporte"
                                    value="{{ $get_id->guia_transporte }}">
                                @endif
                            </div>

                            <div class="form-group col-lg-1">
                                <label class="control-label text-bold">Importe a pagar: </label>
                            </div>
                            <div class="form-group col-lg-2">
                                <input type="text" class="form-control" name="importe_transporte"
                                    id="importe_transporte" placeholder="Importe a pagar"
                                    value="{{ $get_id->importe_transporte }}"
                                    @if ($get_id->importe_transporte!="") disabled @endif>
                                @if ($get_id->importe_transporte!="")
                                <input type="hidden" name="importe_transporte"
                                    value="{{ $get_id->importe_transporte }}">
                                @endif
                            </div>

                            <div class="form-group col-lg-1">
                                <label class="control-label text-bold">N° Factura: </label>
                            </div>
                            <div class="form-group col-lg-2">
                                <input type="text" class="form-control" name="factura_transporte"
                                    id="factura_transporte" placeholder="N° Factura">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label class="control-label text-bold">PDF de factura: </label>
                            </div>
                            <div class="form-group ml-3 ml-lg-0 d-flex align-items-center">
                                <input type="file" class="form-control-file" name="archivo_transporte" id="archivo_transporte" onchange="Valida_Archivo('archivo_transporte');">
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

                        <div class="row mt-4">
                            <div class="form-group col-lg-1">
                                <label class="control-label text-bold">Comentario: </label>
                            </div>
                            <div class="form-group col-lg-11">
                                <textarea class="form-control" name="comentario"
                                    id="comentario" placeholder="Comentario" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer mt-3">
                            @csrf
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

    function Limpiar_Ifile() {
        $('#archivo_transporte').val('');
    }

    function Valida_Archivo(val) {
        var archivoInput = document.getElementById(val);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;

        if (!extPermitidas.exec(archivoRuta)) {
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivo con extensión .pdf|.jpg|.png|.jpeg",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        } else {
            return true;
        }
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
            error: function(xhr) {
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
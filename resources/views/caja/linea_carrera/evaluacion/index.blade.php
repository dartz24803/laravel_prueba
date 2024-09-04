<!DOCTYPE html>
<html lang="en"> 

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación - Línea de Carrera</title>
    <link rel="icon" type="image/png" href="{{ asset('template/evaluacion_lc/imagenes/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('template/evaluacion_lc/css/bootstrap.min.css') }}">
    <script src="{{ asset('template/evaluacion_lc/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/evaluacion_lc/js/jquery-3.2.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('template/evaluacion_lc/sweetalert2/dist/sweetalert2.min.css') }}">
    <script src="{{ asset('template/evaluacion_lc/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('template/evaluacion_lc/blockui/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('template/evaluacion_lc/blockui/custom-blockui.js') }}"></script>
    <style>
        @font-face {
            font-family: 'Century Gothic';
            src: url("{{ asset('template/evaluacion_lc/font/CenturyGothic.ttf') }}");
        }

        header{
            background-color: #303030;
        }

        header > img{
            height: 60px !important;
        }

        body{
            font-family: 'Century Gothic',sans-serif;
            color: #0F191E;
            background-image: url("{{ asset('template/evaluacion_lc/imagenes/fondo_examen.jpg') }}");
            background-size: 100% 44rem;
        }

        label{
            font-size: 16px !important;
        }

        p{
            font-size: 16px !important;
        }

        input[type=radio]:checked{
            border-color: #00B1F4 !important;
            background-color: #00B1F4 !important;
        }

        .boton{
            color: white;
            background-color: #00B1F4;
        }

        .boton:hover{
            color: white;
            background-color: #5CCDF8;
        }

        .timer-container {
            position: fixed;
            top: 5px;
            right: 5px;
            background-color: #00B1F4;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: right;
            z-index: 1000;
        }

        #timer {
            font-size: 32px;
            color: white;
        }
    </style>
    <script>
        function Cargando(){
            $(document)
            .ajaxStart(function () {
                $.blockUI({
                    message: '<svg> ... </svg>',
                    fadeIn: 800,
                    overlayCSS: {
                        backgroundColor: '#1b2024',
                        opacity: 0.8,
                        zIndex: 1200,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        color: '#fff',
                        zIndex: 1201,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });
            })
            .ajaxStop(function () {
                $.blockUI({
                    message: '<svg> ... </svg>',
                    fadeIn: 800,
                    timeout: 100,
                    overlayCSS: {
                        backgroundColor: '#1b2024',
                        opacity: 0.8,
                        zIndex: 1200,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        color: '#fff',
                        zIndex: 1201,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });
            });
        }
    </script>
</head>

<body>
    <header class="justify-content-start m-0 ps-3 py-1">
        <img src="{{ asset('template/evaluacion_lc/imagenes/logo_ln1.png') }}" class="img-fluid" alt="Encabezado">
    </header>

    <div class="container">
        <main>
            <div class="row pt-5 pb-3">
                <div class="col text-center">
                    <h2 class="fw-bold">EVALUACIÓN - {{ $get_id->puesto_aspirado }}</h2>
                </div>
            </div>

            <form id="formulario" method="POST" enctype="multipart/form-data">
                <div class="row pb-3">
                    <div class="col text-start">
                        <p class="lead">
                            Bienvenido a la evaluación de ascenso de La Numero 1, esta tiene como objetivo 
                            garantizar el conocimiento de la correcta ejecución de las actividades a realizar 
                            en el nuevo puesto.
                        </p>
                        <p><strong>Instrucciones:</strong></p>
                        <ul>
                            <li>
                                Cualquier problema durante la ejecución de la prueba comunicarla al 
                                Coordinador Sr. De Caja (KATTIA FIORELA SANZ CRUZ).
                            </li>
                            <li>
                                La prueba tiene una totalidad de 20 preguntas y está divida en 2 partes 
                                (15 Desarrollo y 5 opción múltiple).
                            </li>
                            <li>
                                El desarrollo de la evaluación es individual, se ha dispuesto 45 minutos como 
                                el tiempo límite para su ejecución.
                            </li>
                            <li>
                                Tenga presente que, durante el tiempo de ejecución de la prueba, después de 30 
                                minutos de inactividad de parte del usuario, el sistema cerrará de forma 
                                automática la prueba y no podrá reabrir la prueba, por tanto, es importante 
                                que evite distracciones. 
                            </li>
                            <li>
                                Las respuestas a los ítems deben ser claras y justificadas sin caer en 
                                reiteraciones innecesarias.
                            </li>
                            <li>
                                En las secciones de la prueba que requiere de escritura, debe cuidar la 
                                ortografía y las reglas gramaticales.
                            </li>
                            <li>
                                Para tomar esta prueba realice lo siguiente:
                                <ol>
                                    <li>
                                        Para comenzar, haga clic sobre "Empezar". Esta acción hará que aparezca una 
                                        ventana emergente. Haga clic sobre "Si, a partir de esta acción empezará a 
                                        correr el tiempo de 45 minutos establecido.
                                    </li>
                                    <li>
                                        Si su Internet se desconecta, vuelva a ingresar a la Intranet y diríjase al 
                                        enlace que se encuentra en las notificaciones. 
                                    </li>
                                    <li>
                                        Conteste las preguntas. 
                                    </li>
                                    <li>
                                        Al llegar a la última pregunta, visualizará el botón “Enviar” haga clic sobre 
                                        para dar por terminado la evaluación. 
                                    </li>
                                </ol>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="timer-container">
                    <div id="timer">
                        00:00:00
                    </div>
                </div>

                <div class="row mb-3 justify-content-center ver_btn_empezar">
                    <div class="col-3 d-flex justify-content-center">
                        <button type="button" class="btn btn-lg boton" onclick="Iniciar_Evaluacion();">
                            Empezar
                        </button>
                    </div>
                </div>

                <div id="div_examen"></div>
            </form>
        </main>

        <footer class="row my-5 pt-5 text-muted text-center text-small">
            <div class="col">
                <p class="mb-1">&copy; 2024 <a class="text-decoration-none" href="https://www.grupolanumero1.com.pe/intranet/" target="_blank">La Número 1</a></p>
            </div>
        </footer>

        <script>
            $(document).ready(function() {
                @if ($get_id->iniciado===0)
                    $(".ver_btn_empezar").show();
                @else
                    $(".ver_btn_empezar").hide();
                    @if ($get_id->finalizado===1)
                        Swal(
                            '¡Tiempo Agotado!',
                            'La evaluación ha finalizado',
                            'error'
                        ).then(function() { 
                            window.close();
                        });
                    @else
                        Cargar_Evaluacion();
                    @endif
                @endif
            });

            function Iniciar_Evaluacion(){
                Cargando();

                var dataString = new FormData(document.getElementById('formulario'));
                var url = "{{ route('linea_carrera_ev.iniciar_evaluacion', $get_id->id) }}";

                Swal({
                    title: '¿Realmente desea empezar la evaluación?',
                    text: "La evaluación empezará inmediatamente",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            data: dataString,
                            type: "POST",
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function() {
                                $(".ver_btn_empezar").hide();
                                Cargar_Evaluacion();
                            }
                        });
                    }
                })
            }

            function Cargar_Evaluacion(){ 
                Cargando();

                var url = "{{ route('linea_carrera_ev.examen') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {'id':{{ $get_id->id }}},
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success:function (resp) {
                        $('#div_examen').html(resp);  
                    }
                });
            }

            function Terminar_Evaluacion(tipo){
                Cargando();

                if(tipo==1){
                    var mensaje = '¡Envío Exitoso!';
                    var sub_mensaje = 'Haga clic en el botón!';
                    var alerta = 'success';
                }else{
                    var mensaje = '¡Tiempo Agotado!';
                    var sub_mensaje = 'La evaluación ha finalizado';
                    var alerta = 'error';
                }

                var dataString = new FormData(document.getElementById('formulario'));
                var url = "{{ route('linea_carrera_ev.terminar_evaluacion', $get_id->id) }}";

                $.ajax({
                    url: url,
                    data: dataString,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success:function (data) {
                        swal.fire(
                            mensaje,
                            sub_mensaje,
                            alerta
                        ).then(function() {
                            localStorage.clear();
                            window.close();
                        });
                    }
                });
            }
        </script>
    </div>
</body>
</html>
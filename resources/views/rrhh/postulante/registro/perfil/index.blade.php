@extends('layouts.plantilla')

@section('navbar')
    @include('rrhh.navbar')
@endsection

@section('content')
    <style>
        #map {
            width: 100%;
            height: 500px;
        }
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="account-settings-container layout-top-spacing">
                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">
                            <div class="col-md-12 layout-spacing">
                                <form id="formulario_dp" method="POST" enctype="multipart/form-data" class="section general-info">
                                    @method('PUT')
                                    @csrf
                                    <div class="info">
                                        <div class="row">
                                            <div class="col">
                                                <h6>DATOS POSTULANTE</h6>
                                            </div>
                                            <div class="col text-sm-right text-center">
                                                @if (session('usuario')->id_nivel=="1" || 
                                                session('usuario')->id_puesto=="277")
                                                    <button type="button" class="btn btn-primary mb-md-0 mb-1" onclick="Update_Datos_Personales();">Actualizar</button>
                                                @endif
                                                <a href="{{ route('postulante') }}" class="btn btn-primary mb-md-0 mb-1" title="Regresar">Regresar</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row" id="div_datos_personales">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 layout-spacing">
                                <form id="formulario_do" method="POST" enctype="multipart/form-data" class="section general-info">
                                    @method('PUT')
                                    @csrf
                                    <div class="info" id="div_domicilio">
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 layout-spacing">
                                <form id="formulario_er" method="POST" enctype="multipart/form-data" class="section general-info">
                                    @method('PUT')
                                    @csrf
                                    <div class="info" id="div_evaluacion_rrhh">
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 layout-spacing">
                                <form id="formulario_jd" method="POST" enctype="multipart/form-data" class="section general-info">
                                    <div class="info">
                                        <div class="row">
                                            <div class="col">
                                                <h6>EVALUACIÓN JEFE DIRECTO</h6>
                                            </div>
                                            <div class="col text-right">
                                                <button id="add-work-platforms" class="btn btn-primary">Actualizar</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-8 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="resultado_jd">Resultado</label>
                                                                        <select class="form-control" name="resultado_jd" id="resultado_jd">  
                                                                            <option value="0">Seleccione</option>
                                                                            <option value="6">APTO</option>
                                                                            <option value="5">NO APTO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="observaciones_jd">Observaciones</label>
                                                                        <textarea class="form-control" name="observaciones_jd" id="observaciones_jd" rows="4" placeholder="Observaciones"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 layout-spacing">
                                <form id="formulario_vs" method="POST" enctype="multipart/form-data" class="section general-info">
                                    <div class="info">
                                        <div class="row">
                                            <div class="col">
                                                <h6>VERIFICACIÓN SOCIAL</h6>
                                            </div>
                                            <div class="col text-right">
                                                <button id="add-work-platforms" class="btn btn-primary">Actualizar</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-8 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="resultado_vs">Resultado</label>
                                                                        <select class="form-control" name="resultado_vs" id="resultado_vs">  
                                                                            <option value="0">Seleccione</option>
                                                                            <option value="8">APTO</option>
                                                                            <option value="7">NO APTO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="verificacion_social">Adjuntar verificación social</label>
                                                                        <input type="file" class="form-control-file" id="verificacion_social" name="verificacion_social">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="observaciones_vs">Observaciones</label>
                                                                        <textarea class="form-control" name="observaciones_vs" id="observaciones_vs" rows="4" placeholder="Observaciones"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 layout-spacing">
                                <form id="formulario_rf" method="POST" enctype="multipart/form-data" class="section general-info">
                                    <div class="info">
                                        <div class="row">
                                            <div class="col">
                                                <h6>RESULTADO FINAL</h6>
                                            </div>
                                            <div class="col text-right">
                                                <button id="add-work-platforms" class="btn btn-primary">Actualizar</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                    <div class="col-lg-12 col-md-8 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="resultado_final">Resultado</label>
                                                                        <select class="form-control" name="resultado_final" id="resultado_final">  
                                                                            <option value="0">Seleccione</option>
                                                                            <option value="10">SELECCIONADO</option>
                                                                            <option value="9">NO SELECCIONADO</option>
                                                                            <option value="11">EN REVISIÓN</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3UmC7UDeqnzkxKSDCni7ukFBmqOTc1Us&libraries=places&v=weekly"></script>

    <script>
        $(document).ready(function() {
            $("#rhumanos").addClass('active');
            $("#hrhumanos").attr('aria-expanded', 'true');
            $("#postulantes").addClass('active');

            Datos_Personales();
            Domicilio();
            Evaluacion_Rrhh();
        });

        function Datos_Personales(){
            Cargando();

            var url = "{{ route('postulante_reg.datos_personales', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_datos_personales').html(resp);
                }
            });
        }

        function Domicilio(){
            Cargando();

            var url = "{{ route('postulante_reg.domicilio', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_domicilio').html(resp);
                }
            });
        }

        function Evaluacion_Rrhh(){
            Cargando();

            var url = "{{ route('postulante_reg.eval_rrhh', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_evaluacion_rrhh').html(resp);
                }
            });
        }

        function Valida_Foto(val){
            var archivoInput = document.getElementById(val);
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.png|.jpg|.jpeg)$/i;

            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivo con extensión .jpg|.png|.jpeg",
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

        function Valida_Archivo(val){
            var archivoInput = document.getElementById(val);
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;

            if(!extPermitidas.exec(archivoRuta)){
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
            }else{
                return true;         
            }
        }

        function solo_Numeros(e) {
            var key = event.which || event.keyCode;
            if (key >= 48 && key <= 57) {
                return true;
            } else {
                return false;
            }
        }

        function Traer_Edad(){
            var fec_nac = new Date($('#fec_nac').val());
            var hoy = new Date();
            var edad = hoy.getFullYear() - fec_nac.getFullYear();
            var mes = hoy.getMonth() - fec_nac.getMonth();
            var dia = hoy.getDate() - fec_nac.getDate();
            if (mes < 0 || (mes === 0 && dia < 0)) {
                edad--;
            }
            $('#edad').val(edad >= 0 ? edad : 'Fecha no válida');
        }

        function Traer_Provincia(){
            Cargando();

            var url = "{{ route('postulante.traer_provincia') }}";
            var id_departamento = $('#id_departamento').val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'id_departamento':id_departamento},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#id_provincia').html(resp);
                    $('#id_distrito').html('<option value="0">Seleccione</option>'); 
                }
            });
        }

        function Traer_Distrito(){
            Cargando();

            var url = "{{ route('postulante.traer_distrito') }}";
            var id_provincia = $('#id_provincia').val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'id_provincia':id_provincia},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#id_distrito').html(resp); 
                }
            });
        }

        function Update_Datos_Personales() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario_dp'));
            var url = "{{ route('postulante_reg.update_datos_personales', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    Datos_Personales();
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

        function Update_Domicilio() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario_do'));
            var url = "{{ route('postulante_reg.update_domicilio', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    Domicilio();
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

        function Update_Evaluacion_Rrhh() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario_er'));
            var url = "{{ route('postulante_reg.update_eval_rrhh', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    Evaluacion_Rrhh();
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

        function Update_Evaluacion_Psicologica() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario_er'));
            var url = "{{ route('postulante_reg.update_evaluacion_psicologica', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    Evaluacion_Rrhh();
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
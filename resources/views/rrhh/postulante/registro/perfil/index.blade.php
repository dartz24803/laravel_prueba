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
                                    <div class="info">
                                        <div class="row">
                                            <div class="col d-flex" id="div_domicilio_titulo">
                                            </div>
                                            <div class="col text-md-right text-center">
                                                <button type="button" class="btn btn-primary" onclick="Update_Domicilio();">Actualizar</button>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-12 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row" id="div_domicilio_contenido">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="autocomplete">Ubicación de tu vivienda</label>
                                                                        <input type="text" class="form-control" id="autocomplete" 
                                                                        name="autocomplete" placeholder="Ubicación de tu vivienda">
                                                                        <input type="hidden" id="coordsltd" name="coordsltd" 
                                                                        value="@php if(isset($get_domicilio->id_domicilio_usersp)){ echo $get_domicilio->lat; }else{ echo "-12.0746254"; } @endphp">
                                                                        <input type="hidden" id="coordslng" name="coordslng" 
                                                                        value="@php if(isset($get_domicilio->id_domicilio_usersp)){ echo $get_domicilio->lng; }else{ echo "-77.021754"; } @endphp">
                                                                        <div class="col-12 mt-4" id="map"></div>
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
                                <form id="formulario_er" method="POST" enctype="multipart/form-data" class="section general-info">
                                    @method('PUT')
                                    @csrf
                                    <div class="info" id="div_evaluacion_rrhh">
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 layout-spacing">
                                <form id="formulario_jd" method="POST" enctype="multipart/form-data" class="section general-info">
                                    @method('PUT')
                                    @csrf
                                    <div class="info" id="div_evaluacion_jefe_directo">
                                    </div>
                                </form>
                            </div>

                            @if (session('usuario')->id_nivel=="1" || 
                            session('usuario')->id_puesto=="21" ||
                            session('usuario')->id_puesto=="22" ||
                            session('usuario')->id_puesto=="277" ||
                            session('usuario')->id_puesto=="278")
                                <div class="col-md-12 layout-spacing">
                                    <form class="section general-info">
                                        <div class="info">
                                            <div class="row">
                                                <div class="col">
                                                    <h6 style="margin-bottom: 0px !important;">REVISIÓN</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <table id="tabla_js" class="table" style="width:100%">
                                                                <thead class="text-center">
                                                                    <tr>
                                                                        <th>Base</th>
                                                                        <th>N° documento</th>
                                                                        <th>Apellido paterno</th>
                                                                        <th>Apellido materno</th>
                                                                        <th>Nombres</th>
                                                                        <th>Estado</th>
                                                                        <th>Fecha cese</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($list_revision as $list)
                                                                        <tr class="text-center">
                                                                            <td>{{ $list->centro_labores }}</td>
                                                                            <td>{{ $list->num_doc }}</td>
                                                                            <td class="text-left">{{ $list->usuario_apater }}</td>
                                                                            <td class="text-left">{{ $list->usuario_amater }}</td>
                                                                            <td class="text-left">{{ $list->usuario_nombres }}</td>
                                                                            <td>{{ $list->nom_estado }}</td>
                                                                            <td>{{ $list->fecha_cese }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            <div class="col-md-12 layout-spacing">
                                <form id="formulario_vs" method="POST" enctype="multipart/form-data" class="section general-info">
                                    @method('PUT')
                                    @csrf
                                    <div class="info" id="div_verificacion_social">
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 layout-spacing">
                                <form id="formulario_rf" method="POST" enctype="multipart/form-data" class="section general-info">
                                    @method('PUT')
                                    @csrf
                                    <div class="info">
                                        <div class="row">
                                            <div class="col">
                                                <h6>RESULTADO FINAL</h6>
                                            </div>
                                            <div class="col text-sm-right text-center">
                                                @if (session('usuario')->id_nivel=="1" || 
                                                session('usuario')->id_puesto=="21" ||
                                                session('usuario')->id_puesto=="22" ||
                                                session('usuario')->id_puesto=="277" ||
                                                session('usuario')->id_puesto=="278")
                                                    <button type="button" class="btn btn-primary" onclick="Update_Resultado_Final();">Actualizar</button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row" id="div_resultado_final">                                                  
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
            Domicilio_Titulo();
            Domicilio_Contenido();
            Evaluacion_Rrhh();
            Evaluacion_Jefe_Directo();
            Verificacion_Social();
            Resultado_Final();

            $('#tabla_js').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                responsive: true,
                "oLanguage": {
                    "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                    "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Buscar...",
                    "sLengthMenu": "Resultados :  _MENU_",
                    "sEmptyTable": "No hay datos disponibles en la tabla",
                },
                "stripeClasses": [],
                "lengthMenu": [10, 20, 50],
                "pageLength": 10
            });
        });

        google.maps.event.addDomListener(window, 'load', function(){
            var lati = @php if(isset($get_domicilio->id_domicilio_usersp)){ echo $get_domicilio->lat; }else{ echo -12.0746254; } @endphp;
            var lngi = @php if(isset($get_domicilio->id_domicilio_usersp)){ echo $get_domicilio->lng; }else{ echo -77.021754; } @endphp;

            var coords = {lat: lati, lng: lngi};

            setMapa(coords);

            function setMapa (coords)
            {
                //Se crea una nueva instancia del objeto mapa
                var mapa =  new google.maps.Map(document.getElementById('map'),{
                                zoom: 18,
                                center: coords,
                            });

                texto = '<h1> Nombre del lugar</h1>'+'<p> Descripción del lugar </p>'+
                        '<a href="https://www.lanumero1.com.pe/" target="_blank">Página WEB</a>';

                //Creamos el marcador en el mapa con sus propiedades
                //para nuestro obetivo tenemos que poner el atributo draggable en true
                //position pondremos las mismas coordenas que obtuvimos en la geolocalización
                marker = new google.maps.Marker({
                    position: coords,
                    map: mapa,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    title: 'Ubicación de Mi Casa'
                });

                var informacion = new google.maps.InfoWindow({
                    content: texto
                });

                marker.addListener('click', function(){
                    informacion.open(mapa, marker);
                });

                //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
                //cuando el usuario a soltado el marcador
                marker.addListener('click', toggleBounce);

                marker.addListener( 'dragend', function (event){
                    //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
                    document.getElementById("coordsltd").value = this.getPosition().lat();
                    document.getElementById("coordslng").value = this.getPosition().lng();
                });

                var autocomplete = document.getElementById('autocomplete');

                const search = new google.maps.places.Autocomplete(autocomplete);
                search.bindTo("bounds", mapa);

                search.addListener('place_changed', function(){
                    informacion.close();
                    marker.setVisible(false);

                    var place = search.getPlace();

                    if(!place.geometry.viewport){
                        window.alert("Error al mostrar el lugar");
                        return;
                    }

                    if(place.geometry.viewport){
                        mapa.fitBounds(place.geometry.viewport);
                    }else{
                        mapa.setCenter(place.geometry.location);
                        mapa.setZoom(18);
                    }

                    marker.setPosition(place.geometry.location);

                    marker.setVisible(true);

                    var address = "";
                    if(place.address_components){
                        address = [
                            (place.address_components[0] && place.address_components[0].short_name || ''),
                            (place.address_components[1] && place.address_components[1].short_name || ''),
                            (place.address_components[2] && place.address_components[2].short_name || ''),
                        ]
                    }

                    informacion.setContent('<div><strong>'+place.name + '</strong><br>' + address);
                    informacion.open(map, marker);

                    document.getElementById("coordsltd").value = place.geometry.location.lat();
                    document.getElementById("coordslng").value = place.geometry.location.lng();

                });
            }

            function toggleBounce() {
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            }
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

        function Domicilio_Titulo(){
            Cargando();

            var url = "{{ route('postulante_reg.domicilio_titulo', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_domicilio_titulo').html(resp);
                }
            });
        }

        function Domicilio_Contenido(){
            Cargando();

            var url = "{{ route('postulante_reg.domicilio_contenido', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_domicilio_contenido').html(resp);
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

        function Evaluacion_Jefe_Directo(){
            Cargando();

            var url = "{{ route('postulante_reg.eval_jefe_directo', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_evaluacion_jefe_directo').html(resp);
                }
            });
        }

        function Verificacion_Social(){
            Cargando();

            var url = "{{ route('postulante_reg.verificacion_social', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_verificacion_social').html(resp);
                }
            });
        }

        function Resultado_Final(){
            Cargando();

            var url = "{{ route('postulante_reg.resultado_final', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_resultado_final').html(resp);
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
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Datos_Personales();
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
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Domicilio_Titulo();
                        Domicilio_Contenido();
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
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Evaluacion_Rrhh();
                        Evaluacion_Jefe_Directo();
                        Verificacion_Social();
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
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Evaluacion_Rrhh();
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

        function Update_Jefe_Directo() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario_jd'));
            var url = "{{ route('postulante_reg.update_eval_jefe_directo', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data!=""){
                        var mensaje = data.trim();
                        Swal({
                            title: '¡Error al enviar correo!',
                            text: mensaje,
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            '¡Actualización Exitosa!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Evaluacion_Rrhh();
                            Evaluacion_Jefe_Directo();
                            Verificacion_Social();
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

        function Update_Verificacion_Social() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario_vs'));
            var url = "{{ route('postulante_reg.update_verificacion_social', $get_id->id_postulante) }}";

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
                        Evaluacion_Rrhh();
                        Evaluacion_Jefe_Directo();
                        Verificacion_Social();
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

        function Update_Ver_Social() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario_vs'));
            var url = "{{ route('postulante_reg.update_ver_social', $get_id->id_postulante) }}";

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
                        Verificacion_Social();
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

        function Update_Resultado_Final() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario_rf'));
            var url = "{{ route('postulante_reg.update_resultado_final', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    var cadena = data.trim();
                    validacion = cadena.substr(0, 1);
                    mensaje = cadena.substr(1);

                    if(validacion=="2"){
                        Swal({
                            title: '¡Actualización Denegada!',
                            text: mensaje,
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(validacion=="3"){
                        Swal({
                            title: '¡Error al enviar correo!',
                            text: mensaje,
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            '¡Actualización Exitosa!',
                            mensaje,
                            'success'
                        ).then(function() {
                            Resultado_Final();
                        })
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
@endsection
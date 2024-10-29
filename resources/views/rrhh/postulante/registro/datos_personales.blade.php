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
                                    <div class="info">
                                        <div class="row">
                                            <div class="col">
                                                <h6>DATOS POSTULANTE</h6>
                                            </div>
                                            <div class="col text-right">
                                                <a href="{{ route('postulante') }}" class="btn btn-primary" title="Regresar">Regresar</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-4 d-lg-block d-flex justify-content-center">
                                                        <div class="upload mt-4 pr-md-4">
                                                            <input type="file" id="foto" name="foto" class="dropify" data-default-file="{{ asset('template/assets/img/200x200.jpg') }}" onchange="Valida_Archivo('foto');">
                                                            <p class="mt-2">Actualizar imagen</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10 col-md-8 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="postulante_apater">Apellido paterno</label>
                                                                        <input type="text" class="form-control" 
                                                                        id="postulante_apater" name="postulante_apater" 
                                                                        placeholder="Apellido paterno">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="postulante_amater">Apellido materno</label>
                                                                        <input type="text" class="form-control" 
                                                                        id="postulante_amater" name="postulante_amater"
                                                                        placeholder="Apellido materno">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="postulante_nombres">Nombres</label>
                                                                        <input type="text" class="form-control" 
                                                                        id="postulante_nombres" name="postulante_nombres"
                                                                        placeholder="Nombres">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label for="id_tipo_documento">T. de documento</label>
                                                                        <select class="form-control" name="id_tipo_documento" id="id_tipo_documento">
                                                                            <option value="0">Seleccione</option>
                                                                            @foreach ($list_tipo_documento as $list)
                                                                                <option value="{{ $list->id_tipo_documento }}"
                                                                                @if ($list->id_tipo_documento==$get_id->id_tipo_documento) selected @endif>
                                                                                    {{ $list->cod_tipo_documento }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label for="num_doc">N. de documento</label>
                                                                        <input type="text" class="form-control" 
                                                                        id="num_doc" name="num_doc" 
                                                                        placeholder="Número de documento" onkeypress="return solo_Numeros(event);"
                                                                        value="{{ $get_id->num_doc }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label for="id_nacionalidad">Nacionalidad</label>
                                                                        <select class="form-control" name="id_nacionalidad" id="id_nacionalidad">
                                                                            <option value="0">Seleccione</option>
                                                                            @foreach ($list_nacionalidad as $list)
                                                                                <option value="{{ $list->id_nacionalidad }}">
                                                                                    {{ $list->nom_nacionalidad }}
                                                                                </option>
                                                                            @endforeach                                                                            
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label for="id_genero">Género</label>
                                                                        <select class="form-control" name="id_genero" id="id_genero">
                                                                            <option value="0">Seleccione</option>
                                                                            @foreach ($list_genero as $list)
                                                                                <option value="{{ $list->id_genero }}">
                                                                                    {{ $list->nom_genero }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label for="id_estado_civil">Estado civil</label>
                                                                        <select class="form-control" name="id_estado_civil" id="id_estado_civil">
                                                                            <option value="0">Seleccione</option>
                                                                            @foreach ($list_estado_civil as $list)
                                                                                <option value="{{ $list->id_estado_civil }}">
                                                                                    {{ $list->nom_estado_civil }}
                                                                                </option>
                                                                            @endforeach                                                                            
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-2 col-lg-3">
                                                                    <div class="form-group">
                                                                        <label for="fec_nac">F. de nacimiento</label>
                                                                        <input type="date" class="form-control" 
                                                                        id="fec_nac" name="fec_nac" onblur="Traer_Edad();">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-1 d-xl-block d-none">
                                                                    <div class="form-group">
                                                                        <label for="edad">Edad</label>
                                                                        <input type="text" id="edad" class="form-control" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="emailp">Correo electrónico</label>
                                                                        <input type="text" class="form-control" 
                                                                        id="emailp" name="emailp" 
                                                                        placeholder="Correo electrónico">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label for="num_celp">Número celular</label>
                                                                        <input type="text" class="form-control" 
                                                                        id="num_celp" name="num_celp" 
                                                                        placeholder="Número celular" onkeypress="return solo_Numeros(event);">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label for="num_fijop">Teléfono fijo</label>
                                                                        <input type="text" class="form-control" 
                                                                        id="num_fijop" name="num_fijop" 
                                                                        placeholder="Teléfono fijo" onkeypress="return solo_Numeros(event);">
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
                                <form id="formulario_do" method="POST" enctype="multipart/form-data" class="section general-info">
                                    <div class="info">
                                        <div class="row">
                                            <div class="col">
                                                <h6>DOMICILIO</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-12 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label for="id_departamento">Departamento</label>
                                                                        <select class="form-control" name="id_departamento" id="id_departamento" onchange="Traer_Provincia();">
                                                                            <option value="0">Seleccione</option>
                                                                            @foreach ($list_departamento as $list)
                                                                                <option value="{{ $list->id_departamento }}">
                                                                                    {{ $list->nombre_departamento }}
                                                                                </option>
                                                                            @endforeach                                                                            
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label for="id_provincia">Provincia</label>
                                                                        <select class="form-control" name="id_provincia" id="id_provincia" onchange="Traer_Distrito();">
                                                                            <option value="0">Seleccione</option>                                                                        
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label for="id_distrito">Distrito</label>
                                                                        <select class="form-control" name="id_distrito" id="id_distrito">
                                                                            <option value="0">Seleccione</option>                                                                          
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="autocomplete">Ubicación de tu vivienda</label>
                                                                        <input type="text" class="form-control" id="autocomplete" 
                                                                        name="autocomplete" placeholder="Ubicación de tu vivienda">
                                                                        <input type="hidden" id="coordsltd" name="coordsltd" value="-12.0746254">
                                                                        <input type="hidden" id="coordslng" name="coordslng" value="-77.021754">
                                                                        <div class="col-12 mt-4" id="map"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col text-right">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-primary" type="button" onclick="Update_Datos_Personales();">Guardar</button>
                                                        <a class="btn" href="{{ route('postulante') }}">Cancelar</a>
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
        });

        google.maps.event.addDomListener(window, 'load', function(){
            var lati = -12.0746254;
            var lngi = -77.021754;

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

        function Valida_Archivo(val){
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

            var dataString = new FormData(); 
            new FormData(document.getElementById("formulario_dp")).forEach((value, key) => dataString.append(key, value));
            new FormData(document.getElementById("formulario_do")).forEach((value, key) => dataString.append(key, value));
            var url = "{{ route('postulante_reg.update_datos_personales', $get_id->id_postulante) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    window.location = "{{ route('postulante') }}";
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
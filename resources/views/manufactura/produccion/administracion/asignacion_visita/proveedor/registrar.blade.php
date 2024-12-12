@extends('layouts.plantilla')

@section('navbar')
    @include('manufactura.navbar')
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
            <div class="page-header">
                <div class="page-title">
                    <h3>Registrar nuevo proveedor de {{ $nom_tipo }}</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row"> 
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6 p-3">
                        <form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
                            <div class="row">
                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">RUC: </label>
                                    <input type="text" class="form-control" name="ruc_proveedor" 
                                    id="ruc_proveedor" placeholder="RUC" 
                                    onkeypress="return solo_Numeros(event);" maxlength="11">
                                </div>

                                <div class="form-group col-lg-1 d-flex align-items-center">
                                    <a class="btn btn-primary" type="button" title="Consultar RUC"
                                    onclick="Consultar_Ruc();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                    </a>
                                </div>
    
                                <div class="form-group col-lg-8">
                                    <label class="control-label text-bold">Razón social: </label>
                                    <input type="text" class="form-control" name="nombre_proveedor" 
                                    id="nombre_proveedor" placeholder="Razón social" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="control-label text-bold">Dirección: </label>
                                    <input type="text" class="form-control" name="direccion_proveedor" 
                                    id="direccion_proveedor" placeholder="Dirección">
                                </div>

                                <div class="form-group col-lg-6">
                                    <label class="control-label text-bold">Referencia: </label>
                                    <input type="text" class="form-control" name="referencia_proveedor" 
                                    id="referencia_proveedor" placeholder="Referencia">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">Departamento: </label>
                                    <select class="form-control" name="id_departamento" 
                                    id="id_departamento" onchange="Traer_Provincia();">
                                        <option value="0">Seleccione</option>
                                        @foreach ($list_departamento as $list)
                                        <option value="{{ $list->id_departamento }}">
                                            {{ $list->nombre_departamento }}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">Provincia: </label>
                                    <select class="form-control" name="id_provincia" id="id_provincia" 
                                    onchange="Traer_Distrito();">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">Distrito: </label>
                                    <select class="form-control" name="id_distrito" id="id_distrito">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">Tipo de servicio: </label>
                                    <select class="form-control" name="id_tipo_servicio" 
                                    id="id_tipo_servicio">
                                        <option value="0">Seleccione</option>
                                        @foreach ($list_tipo_servicio as $list)
                                            <option value="{{ $list->id_tipo_servicio }}">
                                                {{ $list->nom_tipo_servicio }}
                                            </option>
                                        @endforeach                                        
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label class="control-label text-bold">Responsable: </label>
                                    <input type="text" class="form-control" name="responsable" 
                                    id="responsable" placeholder="Responsable">
                                </div>

                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">Teléfono fijo: </label>
                                    <input type="text" class="form-control" name="telefono_proveedor" 
                                    id="telefono_proveedor" placeholder="Teléfono fijo" 
                                    onkeypress="return solo_Numeros(event);">
                                </div>

                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">Celular: </label>
                                    <input type="text" class="form-control" name="celular_proveedor" 
                                    id="celular_proveedor" placeholder="Celular" 
                                    onkeypress="return solo_Numeros(event);">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">Email: </label>
                                    <input type="text" class="form-control" name="email_proveedor" 
                                    id="email_proveedor" placeholder="Email">
                                </div>

                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">Web: </label>
                                    <input type="text" class="form-control" name="web_proveedor" 
                                    id="web_proveedor" placeholder="Web">
                                </div>

                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">Banco: </label>
                                    <select class="form-control" name="id_banco" 
                                    id="id_banco">
                                        <option value="0">Seleccione</option>
                                        @foreach ($list_banco as $list)
                                            <option value="{{ $list->id_banco }}">
                                                {{ $list->nom_banco }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-3">
                                    <label class="control-label text-bold">N° cuenta: </label>
                                    <input type="text" class="form-control" name="num_cuenta" 
                                    id="num_cuenta" placeholder="N° cuenta" 
                                    onkeypress="return solo_Numeros(event);">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="autocomplete">Ubicación de tu vivienda</label>
                                    <input type="text" class="form-control" id="autocomplete" 
                                    name="autocomplete" placeholder="Ubicación de tu vivienda">
                                    <input type="hidden" id="coordsltd" name="coordsltd" value="-12.0746254">
                                    <input type="hidden" id="coordslgt" name="coordslgt" value="-77.021754">
                                    <div class="col-12 mt-4" id="map"></div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                @csrf
                                <button class="btn btn-primary" type="button" onclick="Insert_Proveedor();">Guardar</button>
                                <a class="btn" href="{{ route('avisita_conf') }}">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3UmC7UDeqnzkxKSDCni7ukFBmqOTc1Us&libraries=places&v=weekly"></script>

    <script>
        $(document).ready(function() {
            $("#conf_manufactura").addClass('active');
            $("#hconf_manufactura").attr('aria-expanded', 'true');
            $("#conf_asignaciones_visitas").addClass('active');
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
                    document.getElementById("coordslgt").value = this.getPosition().lng();
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
                    document.getElementById("coordslgt").value = place.geometry.location.lng();

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

        function solo_Numeros(e) {
            var key = event.which || event.keyCode;
            if (key >= 48 && key <= 57) {
                return true;
            } else {
                return false;
            }
        }
        
        function Consultar_Ruc(){
            Cargando();

            var url = "{{ route('avisita_conf_pr.consultar_ruc_pr') }}";
            var ruc = $('#ruc_proveedor').val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'ruc':ruc},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    var texto = resp.trim();
                    var partes = texto.split('@@@');
                    if(partes[0]=="error"){
                        Swal({
                            title: '¡Consulta Denegada!',
                            text: partes[1],
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                        $('#nombre_proveedor').val('');
                        $('#direccion_proveedor').val('');
                    }else{
                        $('#nombre_proveedor').val(partes[0]);
                        $('#direccion_proveedor').val(partes[1]);
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
        
        function Traer_Provincia(){
            Cargando();

            var url = "{{ route('avisita_conf_pr.traer_provincia') }}";
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

            var url = "{{ route('avisita_conf_pr.traer_distrito') }}";
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

        function Insert_Proveedor() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('avisita_conf_pr.store') }}";

            dataString.append('id_proveedor_mae', {{ $tipo }});

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
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
                            window.location = "{{ route('avisita_conf') }}";
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
@endsection
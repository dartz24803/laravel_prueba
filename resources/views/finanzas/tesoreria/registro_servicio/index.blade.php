@extends('layouts.plantilla')

@section('navbar')
    @include('finanzas.navbar')
@endsection

@section('content')
    <style>
        .drop-zone {
            max-width: 300px;
            height: 200px;
            padding: 16px;
            border: 2px dashed #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            cursor: pointer;
        }

        .drop-zone--over {
            border-style: solid;
            background-color: #f0f0f0;
        }

        .drop-zone input {
            display: none;
        }

        .preview {
            margin-top: 10px;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .preview img {
            max-width: 200px;
            margin-bottom: 10px;
        }

        .preview embed {
            width: 100%;
            height: 500px;
        }
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Registro de servicios</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar d-md-flex mt-2">
                            <div class="form-group col-lg-2">
                                <label>Base:</label>
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                    <input type="checkbox" class="new-control-input" id="todos" name="todos" value="1" checked onclick="Todos(); Lista_Registro_Servicio();">
                                    <span class="new-control-indicator"></span> &nbsp; Todos
                                </label>
                                <select class="form-control multivalue" name="cod_baseb[]" id="cod_baseb" multiple="multiple" disabled 
                                onchange="Lista_Registro_Servicio();">
                                    @foreach ($list_base as $list)
                                        <option value="{{ $list->cod_base }}">
                                            {{ $list->cod_base }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-2">
                                <label>Estado:</label>
                                <select class="form-control" name="estadob" id="estadob" 
                                onchange="Lista_Registro_Servicio();">
                                    <option value="0">Todos</option>
                                    <option value="1">Por Cancelar</option>
                                    <option value="2">Cancelado</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-2">
                                <label>Servicio:</label>
                                <select class="form-control" name="id_serviciob" 
                                id="id_serviciob" onchange="Lista_Registro_Servicio();">
                                    <option value="0">Todos</option>
                                    @foreach ($list_servicio as $list)
                                        <option value="{{ $list->id_servicio }}">
                                            {{ $list->nom_servicio }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-2">
                                <label>Lugar:</label>
                                <select class="form-control" name="id_lugar_serviciob" 
                                id="id_lugar_serviciob" onchange="Lista_Registro_Servicio();">
                                    <option value="0">Todos</option>
                                    @foreach ($list_lugar as $list)
                                        <option value="{{ $list->id_lugar_servicio }}">
                                            {{ $list->nom_lugar_servicio }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group col-lg-2 col-xl-1">
                                <label>Mes:</label>
                                <select class="form-control" name="mesb" id="mesb" onchange="Lista_Registro_Servicio();">
                                    <option value="0">Todos</option>
                                    @foreach ($list_mes as $list)
                                        <option value="{{ $list->cod_mes }}"
                                        @if ($list->cod_mes==date('m')) selected @endif>
                                            {{ $list->abr_mes }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group col-lg-2 col-xl-1">
                                <label>Año:</label>
                                <select class="form-control" name="aniob" id="aniob" onchange="Lista_Registro_Servicio();">
                                    @foreach ($list_anio as $list)
                                        <option value="{{ $list->cod_anio }}"
                                        @if ($list->cod_anio==date('Y')) selected @endif>
                                            {{ $list->cod_anio }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 d-flex align-items-center justify-content-start mb-3">
                                <button type="button" class="btn btn-primary mb-1 mb-md-0" 
                                title="Registrar" data-toggle="modal" 
                                data-target="#ModalRegistroGrande" 
                                app_reg_grande="{{ route('registro_servicio.create') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                    Registrar
                                </button>
                                <a class="btn mb-1 mb-md-0" title="Exportar excel"
                                style="background-color: #28a745 !important;" 
                                onclick="Excel_Registro_Servicio();">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                            <path d="M0,172v-172h172v172z" fill="none"></path>
                                            <g fill="#ffffff">
                                                <path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path>
                                            </g>
                                        </g>
                                    </svg>                                
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive" id="lista_registro_servicio">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#tesorerias").addClass('active');
            $("#htesorerias").attr('aria-expanded', 'true');
            $("#registros_servicios").addClass('active');

            Lista_Registro_Servicio();

            $(".multivalue").select2({
                tags: true
            });
        });

        function Todos(){
            if($('#todos').is(":checked")){
                $('#cod_baseb').prop('disabled', true);
            }else{
                $('#cod_baseb').prop('disabled', false);
            }
        }

        function Lista_Registro_Servicio(){
            Cargando();

            if($('#todos').is(":checked")){
                todos = "1";
            }else{
                todos = "0";
            }
            var cod_base = $('#cod_baseb').val();
            var estado = $('#estadob').val();
            var id_servicio = $('#id_serviciob').val();
            var id_lugar_servicio = $('#id_lugar_serviciob').val();
            var mes = $('#mesb').val();
            var anio = $('#aniob').val();
            var url = "{{ route('registro_servicio.list') }}";

            $.ajax({
                url: url,
                type: "POST",
                data:{
                    'todos':todos,
                    'cod_base':cod_base,
                    'estado':estado,
                    'id_servicio':id_servicio,
                    'id_lugar_servicio':id_lugar_servicio,
                    'mes':mes,
                    'anio':anio
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#lista_registro_servicio').html(resp);  
                }
            });
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

        function Traer_Lugar(v){
            Cargando();

            var url = "{{ route('registro_servicio.traer_lugar') }}";
            var cod_base = $('#cod_base'+v).val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'cod_base':cod_base},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#id_lugar_servicio'+v).html(resp);
                    $('#id_servicio'+v).html('<option value="0">Seleccione</option>');
                    $('#id_proveedor_servicio'+v).html('<option value="0">Seleccione</option>');
                    $('#suministro'+v).html('<option value="0">Seleccione</option>');
                    $('.div_suministro'+v).show();
                    $('#div_lectura'+v).html('');
                }
            });
        }

        function Traer_Servicio(v){
            Cargando();

            var url = "{{ route('registro_servicio.traer_servicio') }}";
            var cod_base = $('#cod_base'+v).val();
            var id_lugar_servicio = $('#id_lugar_servicio'+v).val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'cod_base':cod_base,'id_lugar_servicio':id_lugar_servicio},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#id_servicio'+v).html(resp);
                    $('#id_proveedor_servicio'+v).html('<option value="0">Seleccione</option>');
                    $('#suministro'+v).html('<option value="0">Seleccione</option>');
                    $('.div_suministro'+v).show();
                    $('#div_lectura'+v).html('');
                }
            });
        }

        function Traer_Proveedor(v){
            Cargando();

            var url = "{{ route('registro_servicio.traer_proveedor') }}";
            var cod_base = $('#cod_base'+v).val();
            var id_lugar_servicio = $('#id_lugar_servicio'+v).val();
            var id_servicio = $('#id_servicio'+v).val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'cod_base':cod_base,'id_lugar_servicio':id_lugar_servicio,'id_servicio':id_servicio},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#id_proveedor_servicio'+v).html(resp);
                    $('#suministro'+v).html('<option value="0">Seleccione</option>');

                    if(id_servicio!="5"){
                        $('.div_suministro'+v).show();
                    }else{
                        $('.div_suministro'+v).hide();
                    }
                }
            });
        }

        function Traer_Lectura(v){
            Cargando();

            var url = "{{ route('registro_servicio.traer_lectura') }}";
            var id_servicio = $('#id_servicio'+v).val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'id_servicio':id_servicio,'v':v},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#div_lectura'+v).html(resp);
                }
            });
        }

        function Traer_Suministro(v){
            Cargando();
            
            var id_servicio = $('#id_servicio'+v).val();

            if(id_servicio!="5"){
                var url = "{{ route('registro_servicio.traer_suministro') }}";
                var cod_base = $('#cod_base'+v).val();
                var id_lugar_servicio = $('#id_lugar_servicio'+v).val();
                var id_proveedor_servicio = $('#id_proveedor_servicio'+v).val();

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        'cod_base':cod_base,
                        'id_lugar_servicio':id_lugar_servicio,
                        'id_servicio':id_servicio,
                        'id_proveedor_servicio':id_proveedor_servicio
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success:function (resp) {
                        $('#suministro'+v).html(resp);
                    }
                });
            }
        }

        function validarArchivoImgPrevisualizar(inputId, previewDivId) {
            const input = document.getElementById(inputId);
            const previewDiv = document.getElementById(previewDivId);

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileType = file.type;

                const reader = new FileReader();
                
                reader.onload = function (e) {
                    previewDiv.innerHTML = '';

                    if (fileType.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        previewDiv.appendChild(img);
                    } else if (fileType === 'application/pdf') {
                        const embed = document.createElement('embed');
                        embed.src = e.target.result;
                        previewDiv.appendChild(embed);
                    } else {
                        previewDiv.innerHTML = 'No se puede previsualizar este tipo de archivo';
                    }
                };
                
                reader.readAsDataURL(file);
            } else {
                previewDiv.innerHTML = 'No se seleccionó ningún archivo';
            }
            return true;
        }

        function Valida_Archivo(val){
            Cargando();

            var archivoInput = document.getElementById(val);
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;

            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: '¡Registro Denegado!',
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

        function Delete_Registro_Servicio(id) {
            Cargando();

            var url = "{{ route('registro_servicio.destroy', ':id') }}".replace(':id', id);

            Swal({
                title: '¿Realmente desea eliminar el registro?',
                text: "El registro será eliminado permanentemente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                padding: '2em'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function() {
                            Swal(
                                '¡Eliminado!',
                                'El registro ha sido eliminado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                Lista_Registro_Servicio();
                            });    
                        }
                    });
                }
            })
        }

        function Excel_Registro_Servicio() {
            if($('#todos').is(":checked")){
                todos = "1";
            }else{
                todos = "0";
            }
            var cod_base = $('#cod_baseb').val();
            if(cod_base.length < 1){
                cod_base = "0";
            }
            var estado = $('#estadob').val();
            var id_servicio = $('#id_serviciob').val();
            var id_lugar_servicio = $('#id_lugar_serviciob').val();
            var mes = $('#mesb').val();
            var anio = $('#aniob').val();
            window.location = "{{ route('registro_servicio.excel', [':todos', ':cod_base', ':estado', ':id_servicio', ':id_lugar_servicio', ':mes', ':anio']) }}".replace(':todos', todos).replace(':cod_base', cod_base).replace(':estado', estado).replace(':id_servicio', id_servicio).replace(':id_lugar_servicio', id_lugar_servicio).replace(':mes', mes).replace(':anio', anio);
        }
    </script>
@endsection
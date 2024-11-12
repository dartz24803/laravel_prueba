@extends('layouts.plantilla')

@section('navbar')
    @include('logistica.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Detalle de Operación de Diferencias</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row"> 
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6 p-3">
                        <form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
                            <div class="row">
                                @include('logistica.tracking.tracking.cabecera')
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">Ingrese el número de la guía de remisión según corresponda:</label>
                                </div>
                            </div>

                            @if ($get_id->sobrantes>0 &&
                            (session('usuario')->id_puesto==76 ||
                            session('usuario')->id_nivel==1))
                                <div class="row">
                                    <div class="form-group col-lg-1">
                                        <label class="control-label text-bold">Nro. GR (Sobrante): </label>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <input type="text" class="form-control" name="guia_sobrante" 
                                        id="guia_sobrante" placeholder="Nro. GR" 
                                        value="{{ $get_id->guia_sobrante }}">
                                    </div>
                                    
                                    <div class="form-group col-lg-1">
                                        <label class="control-label text-bold">GR (Sobrante): </label>
                                        @if ($get_id->archivo_sobrante!="")
                                            <a href="{{ $get_id->archivo_sobrante }}" title="GR (Sobrante)" target="_blank">
                                                <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                                    <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                                                    <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                                                    <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                                                    <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                                                    <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-4 d-flex">
                                        <input type="file" class="form-control-file" name="archivo_sobrante" id="archivo_sobrante" onchange="Valida_Archivo('archivo_sobrante');">
                                        <a onclick="Limpiar_Ifile('archivo_sobrante');" style="cursor: pointer" title="Borrar archivo seleccionado">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x text-danger">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if ($get_id->faltantes>0 &&
                            (session('usuario')->id_puesto==30 || 
                            session('usuario')->id_puesto==31 || 
                            session('usuario')->id_puesto==32 || 
                            session('usuario')->id_puesto==33 || 
                            session('usuario')->id_puesto==35 || 
                            session('usuario')->id_puesto==161 || 
                            session('usuario')->id_puesto==167 || 
                            session('usuario')->id_puesto==168 ||
                            session('usuario')->id_puesto==311 || 
                            session('usuario')->id_puesto==314 ||
                            session('usuario')->id_nivel==1))
                                <div class="row">
                                    <div class="form-group col-lg-1">
                                        <label class="control-label text-bold">Nro. GR (Faltante): </label>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <input type="text" class="form-control" name="guia_faltante" 
                                        id="guia_faltante" placeholder="Nro. GR" 
                                        value="{{ $get_id->guia_faltante }}">
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label class="control-label text-bold">GR (Faltante): </label>
                                        @if ($get_id->archivo_faltante!="")
                                            <a href="{{ $get_id->archivo_faltante }}" title="GR (Faltante)" target="_blank">
                                                <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                                    <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                                                    <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                                                    <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                                                    <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                                                    <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-4 d-flex">
                                        <input type="file" class="form-control-file" name="archivo_faltante" id="archivo_faltante" onchange="Valida_Archivo('archivo_faltante');">
                                        <a onclick="Limpiar_Ifile('archivo_faltante');" style="cursor: pointer" title="Borrar archivo seleccionado">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x text-danger">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
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
                                <button class="btn btn-primary" type="button" onclick="Insert_Diferencia_Regularizada();">Guardar</button>
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

        function Limpiar_Ifile(val){
            $('#'+val).val('');
        }

        function Valida_Archivo(val){
            var archivoInput = document.getElementById(val);
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.pdf|.png|.jpg|.jpeg|.xls|.xlsx)$/i;

            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivo con extensión .pdf|.jpg|.png|.jpeg|.xls|.xlsx",
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

        function Insert_Diferencia_Regularizada() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.insert_diferencia_regularizada', $get_id->id) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        '¡Registro Exitoso!',
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
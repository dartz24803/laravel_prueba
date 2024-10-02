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

                            <div class="row">
                                @if ($get_id->sobrantes>0 &&
                                (session('usuario')->id_puesto==76 ||
                                session('usuario')->id_nivel==1))
                                    <div class="form-group col-lg-1">
                                        <label class="control-label text-bold">Nro. GR (Sobrante): </label>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <input type="text" class="form-control" name="guia_sobrante" 
                                        id="guia_sobrante" placeholder="Nro. GR" 
                                        value="{{ $get_id->guia_sobrante }}">
                                    </div>                                    
                                @endif

                                @if ($get_id->faltantes>0 &&
                                (session('usuario')->id_puesto==29 || 
                                session('usuario')->id_puesto==30 || 
                                session('usuario')->id_puesto==31 || 
                                session('usuario')->id_puesto==32 || 
                                session('usuario')->id_puesto==33 || 
                                session('usuario')->id_puesto==34 || 
                                session('usuario')->id_puesto==35 || 
                                session('usuario')->id_puesto==161 || 
                                session('usuario')->id_puesto==167 || 
                                session('usuario')->id_puesto==168 ||
                                session('usuario')->id_puesto==197 || 
                                session('usuario')->id_puesto==311 || 
                                session('usuario')->id_puesto==314 ||
                                session('usuario')->id_nivel==1))
                                    <div class="form-group col-lg-1">
                                        <label class="control-label text-bold">Nro. GR (Faltante): </label>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <input type="text" class="form-control" name="guia_faltante" 
                                        id="guia_faltante" placeholder="Nro. GR" 
                                        value="{{ $get_id->guia_faltante }}">
                                    </div>
                                @endif
                            </div>

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
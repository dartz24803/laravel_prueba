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

                            <div class="form-group col-lg-12">
                                <label class="control-label text-bold" style="color: black;">Fecha: {{ $fecha_formateada }}</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-2 col-xl-1">
                                <label class="control-label text-bold">Base: </label>
                            </div>
                            <div class="form-group col-lg-2">
                                <select class="form-control" name="id_base" id="id_base" 
                                onchange="Traer_Pago();">
                                    <option value="0">Seleccione</option>
                                    @foreach ($list_base as $list)
                                        <option value="{{ $list->id_base }}"
                                        @if ($list->cod_base==session('usuario')->centro_labores) selected @endif>
                                            {{ $list->cod_base }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-2 col-xl-1">
                                <label class="control-label text-bold">Semana: </label>
                            </div>
                            <div class="form-group col-lg-2">
                                <select class="form-control" name="semana" id="semana" 
                                onchange="Traer_Pago();">
                                    <option value="0">Seleccione</option>
                                    @php $i = 1; @endphp
                                    @while ($i<=date('W'))
                                        <option value="{{ $i }}" @if ($i==date('W')) selected @endif>{{ $i }}</option>
                                    @php $i++; @endphp
                                    @endwhile
                                </select>
                            </div>
                        </div>

                        <div id="detalle_pago">
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

        @if (substr(session('usuario')->centro_labores,0,1)=="B")
            Traer_Pago();
        @endif
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

    function Traer_Pago(){
        Cargando();

        var url = "{{ route('tracking.traer_pago_general') }}";
        var id_base = $('#id_base').val();
        var semana = $('#semana').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'id_base':id_base,'semana':semana},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (data) {
                if(data=="no_data"){
                    Swal({
                        title: '¡Búsqueda Denegada!',
                        text: "¡No hay información de detalle inicial!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data=="repetido"){
                    Swal({
                        title: '¡Búsqueda Denegada!',
                        text: "¡Ya se registro el pago!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    $('#detalle_pago').html(data);
                }
            }
        });
    }
</script>
@endsection
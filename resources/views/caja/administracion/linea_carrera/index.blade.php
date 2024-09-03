@extends('layouts.plantilla')

@section('navbar')
    @include('caja.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                                <li class="nav-item">
                                    <a id="a_pre" class="nav-link" onclick="Pregunta();" style="cursor: pointer;">Preguntas</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_linea_carrera_conf" class="widget-content widget-content-area p-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#conf_cajas").addClass('active');
            $("#hconf_cajas").attr('aria-expanded', 'true');
            $("#conf_lineas_carreras").addClass('active');

            Pregunta();
        });
        
        function Pregunta(){
            Cargando();

            var url="{{ route('linea_carrera_conf_pre') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_linea_carrera_conf').html(resp);  
                    $("#a_pre").addClass('active');
                }
            });
        }
    </script>
@endsection
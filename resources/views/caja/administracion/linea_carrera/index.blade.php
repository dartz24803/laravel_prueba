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
                                    <a id="a_terr" class="nav-link" onclick="Pregunta();" style="cursor: pointer;">Preguntas</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_err" class="nav-link" onclick="Revision_Evaluacion();" style="cursor: pointer;">Revisión evaluación</a>
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
                    $("#a_terr").addClass('active');
                    $("#a_err").removeClass('active');
                }
            });
        }

        function Revision_Evaluacion(){
            Cargando();

            var url="{{ route('linea_carrera_conf_reva') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_linea_carrera_conf').html(resp);  
                    $("#a_terr").removeClass('active');
                    $("#a_err").addClass('active');
                }
            });
        }
    </script>
@endsection
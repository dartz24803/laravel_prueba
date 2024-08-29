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
                                    <a id="a_sol" class="nav-link" onclick="Solicitud_Puesto();" style="cursor: pointer;">Solicitud del puesto</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ent" class="nav-link" onclick="Entrenamiento();" style="cursor: pointer;">Acceso a los módulos</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_linea_carrera" class="widget-content widget-content-area p-3">
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
            $("#cajas").addClass('active');
            $("#hcajas").attr('aria-expanded', 'true');
            $("#lineas_carreras").addClass('active');

            Solicitud_Puesto();
        });
        
        function Solicitud_Puesto(){
            Cargando();

            var url="{{ route('linea_carrera_so') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_linea_carrera').html(resp);  
                    $("#a_sol").addClass('active');
                    $("#a_ent").removeClass('active');
                }
            });
        }

        function Entrenamiento(){
            Cargando();

            var url="{{ route('linea_carrera_en') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_linea_carrera').html(resp);  
                    $("#a_sol").removeClass('active');
                    $("#a_ent").addClass('active');
                }
            });
        }
    </script>
@endsection
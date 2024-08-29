@extends('layouts.plantilla')

@section('navbar')
    @include('seguridad.navbar')
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
                                    <a id="a_hor" class="nav-link" onclick="Horario_Programado();" style="cursor: pointer;" href="#">Horarios programados</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_obs" class="nav-link" onclick="Observacion();" style="cursor: pointer;">Observaciones</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_apertura_cierre_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_seguridades").addClass('active');
            $("#hconf_seguridades").attr('aria-expanded', 'true');
            $("#conf_aperturas_cierres").addClass('active');

            Horario_Programado();
        });
        
        function Horario_Programado(){
            Cargando();

            var url="{{ route('apertura_cierre_conf_ho') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_apertura_cierre_conf').html(resp);  
                    $("#a_hor").addClass('active');
                    $("#a_obs").removeClass('active');
                }
            });
        }

        function Observacion(){
            Cargando();

            var url="{{ route('apertura_cierre_conf_ob') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_apertura_cierre_conf').html(resp);  
                    $("#a_hor").removeClass('active');
                    $("#a_obs").addClass('active');
                }
            });
        }
    </script>
@endsection
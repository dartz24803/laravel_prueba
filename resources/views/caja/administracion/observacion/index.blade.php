@extends('layouts.plantilla_new')

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
                                    <a id="a_terr" class="nav-link" onclick="Tipo_Error();" style="cursor: pointer;">Tipo de Error</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_err" class="nav-link" onclick="TError();" style="cursor: pointer;">Error</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_observacion_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_observaciones").addClass('active');

            Tipo_Error();
        });
        
        function Tipo_Error(){
            Cargando();

            var url="{{ route('observacion_conf_terr') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_observacion_conf').html(resp);  
                    $("#a_terr").addClass('active');
                    $("#a_err").removeClass('active');
                }
            });
        }

        //Cuando se pone Error() se ejecuta automáticamente
        function TError(){
            Cargando();

            var url="{{ route('observacion_conf_err') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_observacion_conf').html(resp);  
                    $("#a_terr").removeClass('active');
                    $("#a_err").addClass('active');
                }
            });
        }
    </script>
@endsection
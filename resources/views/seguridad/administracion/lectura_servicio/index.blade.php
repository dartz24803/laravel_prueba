@extends('layouts.plantilla_new')

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
                                    <a id="a_ser" class="nav-link" onclick="Servicio();" style="cursor: pointer;">Servicio</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_pser" class="nav-link" onclick="Proveedor_Servicio();" style="cursor: pointer;">Proveedor de servicio</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_dser" class="nav-link" onclick="Datos_Servicio();" style="cursor: pointer;">Datos de servicio</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_lectura_servicio_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_lecturas_servicios").addClass('active');

            Servicio();
        });
        
        function Servicio(){
            Cargando();

            var url="{{ route('lectura_servicio_conf_se') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_lectura_servicio_conf').html(resp);  
                    $("#a_ser").addClass('active');
                    $("#a_pser").removeClass('active');
                    $("#a_dser").removeClass('active');
                }
            });
        }

        function Proveedor_Servicio(){
            Cargando();

            var url="{{ route('lectura_servicio_conf_pr') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_lectura_servicio_conf').html(resp);  
                    $("#a_ser").removeClass('active');
                    $("#a_pser").addClass('active');
                    $("#a_dser").removeClass('active');
                }
            });
        }

        function Datos_Servicio(){
            Cargando();

            var url="{{ route('lectura_servicio_conf_da') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_lectura_servicio_conf').html(resp);  
                    $("#a_ser").removeClass('active');
                    $("#a_pser").removeClass('active');
                    $("#a_dser").addClass('active');
                }
            });
        }
    </script>
@endsection
@extends('layouts.plantilla')

@section('navbar')
    @include('manufactura.navbar')
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
                                    <a id="a_tser" class="nav-link" onclick="Tipo_Servicio();" style="cursor: pointer;">Tipo de servicio</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ptal" class="nav-link" onclick="Proveedor_Taller();" style="cursor: pointer;">Proveedor de taller</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ptel" class="nav-link" onclick="Proveedor_Tela();" style="cursor: pointer;">Proveedor de tela</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ttra" class="nav-link" onclick="Tipo_Transporte();" style="cursor: pointer;">Tipo de transporte</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_avisita_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_manufactura").addClass('active');
            $("#hconf_manufactura").attr('aria-expanded', 'true');
            $("#conf_asignaciones_visitas").addClass('active');

            Tipo_Servicio();
        });

        function Tipo_Servicio(){
            Cargando();

            var url="{{ route('avisita_conf_ts') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_avisita_conf').html(resp);  
                    $("#a_tser").addClass('active');
                    $("#a_ptal").removeClass('active');
                    $("#a_ptel").removeClass('active');
                    $("#a_ttra").removeClass('active');
                }
            });
        }
        
        function Proveedor_Taller(){
            Cargando();

            var url="{{ route('avisita_conf_pr',2) }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_avisita_conf').html(resp);  
                    $("#a_tser").removeClass('active');
                    $("#a_ptal").addClass('active');
                    $("#a_ptel").removeClass('active');
                    $("#a_ttra").removeClass('active');
                }
            });
        }

        function Proveedor_Tela(){
            Cargando();

            var url="{{ route('avisita_conf_pr',1) }}";

            $.ajax({
                url: url,
                type: "GET",             
                success:function (resp) {
                    $('#div_avisita_conf').html(resp);  
                    $("#a_tser").removeClass('active');
                    $("#a_ptal").removeClass('active');
                    $("#a_ptel").addClass('active');
                    $("#a_ttra").removeClass('active');
                }
            });
        }

        function Tipo_Transporte(){
            Cargando();

            var url="{{ route('avisita_conf_tt') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_avisita_conf').html(resp); 
                    $("#a_tser").removeClass('active'); 
                    $("#a_ptal").removeClass('active');
                    $("#a_ptel").removeClass('active');
                    $("#a_ttra").addClass('active');
                }
            });
        }
    </script>
@endsection
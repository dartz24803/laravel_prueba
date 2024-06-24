@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                                <li class="nav-item">
                                    <a id="a_di" class="nav-link" onclick="Direccion();" style="cursor: pointer;">Dirección</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ge" class="nav-link" onclick="Gerencia();" style="cursor: pointer;">Gerencia</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_de" class="nav-link" onclick="Sub_Gerencia();" style="cursor: pointer;">Departamento</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ar" class="nav-link" onclick="Area();" style="cursor: pointer;">Área</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_colaborador_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_rrhhs").addClass('active');
            $("#hconf_rrhhs").attr('aria-expanded', 'true');
            $("#conf_colaboradores").addClass('active');

            Direccion();
        });
        
        function Direccion(){
            Cargando();

            var url="{{ route('colaborador_conf_di') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").addClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").removeClass('active');
                }
            });
        }

        function Gerencia(){
            Cargando();

            var url="{{ route('colaborador_conf_ge') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").addClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").removeClass('active');
                }
            });
        }

        function Sub_Gerencia(){
            Cargando();

            var url="{{ route('colaborador_conf_sg') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").addClass('active');
                    $("#a_ar").removeClass('active');
                }
            });
        }

        function Area(){
            Cargando();

            var url="{{ route('colaborador_conf_ge') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").addClass('active');
                }
            });
        }
    </script>
@endsection
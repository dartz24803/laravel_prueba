@extends('layouts.plantilla')

@section('navbar')
    @include('finanzas.navbar')
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
                                    <a id="a_ca" class="nav-link" onclick="Categoria();" 
                                    style="cursor: pointer;">Categoría</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_sca" class="nav-link" onclick="Sub_Categoria();" 
                                    style="cursor: pointer;">Sub-Categoría</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_un" class="nav-link" onclick="Unidad();" 
                                    style="cursor: pointer;">Unidad</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_caja_chica_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_tesorerias").addClass('active');
            $("#hconf_tesorerias").attr('aria-expanded', 'true');
            $("#conf_cajas_chicas").addClass('active');

            Categoria();
        });
        
        function Categoria(){
            Cargando();

            var url="{{ route('caja_chica_conf_ca') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_caja_chica_conf').html(resp);  
                    $("#a_ca").addClass('active');
                    $("#a_sca").removeClass('active');
                    $("#a_un").removeClass('active');
                }
            });
        }

        function Sub_Categoria(){
            Cargando();

            var url="{{ route('caja_chica_conf_sc') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_caja_chica_conf').html(resp);  
                    $("#a_ca").removeClass('active');
                    $("#a_sca").addClass('active');
                    $("#a_un").removeClass('active');
                }
            });
        }

        function Unidad(){
            Cargando();

            var url="{{ route('caja_chica_conf_un') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_caja_chica_conf').html(resp);  
                    $("#a_ca").removeClass('active');
                    $("#a_sca").removeClass('active');
                    $("#a_un").addClass('active');
                }
            });
        }
    </script>
@endsection
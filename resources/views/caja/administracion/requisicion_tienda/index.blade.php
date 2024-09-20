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
                                    <a id="a_ma" class="nav-link" onclick="Marca();" style="cursor: pointer;">Marca</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_mo" class="nav-link" onclick="Modelo();" style="cursor: pointer;">Modelo</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_co" class="nav-link" onclick="Color();" style="cursor: pointer;">Color</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_um" class="nav-link" onclick="Unidad_Medida();" style="cursor: pointer;">Unidad medida</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_es" class="nav-link" onclick="Estado();" style="cursor: pointer;">Estado</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ca" class="nav-link" onclick="Categoria();" style="cursor: pointer;">Categoría</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_pr" class="nav-link" onclick="Producto();" style="cursor: pointer;">Producto</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_requisicion_tienda_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_requiciones_tiendas").addClass('active');

            Marca();
        });
        
        function Marca(){
            Cargando();

            var url="{{ route('requisicion_tienda_conf_ma') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_requisicion_tienda_conf').html(resp);  
                    $(".nav-link").removeClass('active');
                    $("#a_ma").addClass('active');
                }
            });
        }

        function Modelo(){
            Cargando();

            var url="{{ route('requisicion_tienda_conf_mo') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_requisicion_tienda_conf').html(resp);  
                    $(".nav-link").removeClass('active');
                    $("#a_mo").addClass('active');
                }
            });
        }

        function Color(){
            Cargando();

            var url="{{ route('requisicion_tienda_conf_co') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_requisicion_tienda_conf').html(resp);  
                    $(".nav-link").removeClass('active');
                    $("#a_co").addClass('active');
                }
            });
        }

        function Unidad_Medida(){
            Cargando();

            var url="{{ route('requisicion_tienda_conf_um') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_requisicion_tienda_conf').html(resp);  
                    $(".nav-link").removeClass('active');
                    $("#a_um").addClass('active');
                }
            });
        }

        function Estado(){
            Cargando();

            var url="{{ route('requisicion_tienda_conf_es') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_requisicion_tienda_conf').html(resp);  
                    $(".nav-link").removeClass('active');
                    $("#a_es").addClass('active');
                }
            });
        }

        function Categoria(){
            Cargando();

            var url="{{ route('requisicion_tienda_conf_ca') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_requisicion_tienda_conf').html(resp);  
                    $(".nav-link").removeClass('active');
                    $("#a_ca").addClass('active');
                }
            });
        }

        function Producto(){
            Cargando();

            var url="{{ route('requisicion_tienda_conf_pr') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_requisicion_tienda_conf').html(resp);  
                    $(".nav-link").removeClass('active');
                    $("#a_pr").addClass('active');
                }
            });
        }
    </script>
@endsection
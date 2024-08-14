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
                                    <a id="a_puno" class="nav-link" onclick="Precio_Uno();" style="cursor: pointer;">Precio x 1</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_pdos" class="nav-link" onclick="Precio_Dos();" style="cursor: pointer;">Precio x 2</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ptre" class="nav-link" onclick="Precio_Tres();" style="cursor: pointer;">Precio x 3</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_precio_sugerido_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_controles_internos").addClass('active');
            $("#hconf_controles_internos").attr('aria-expanded', 'true');
            $("#conf_precios_sugeridos").addClass('active');

            Precio_Uno();
        });
        
        function Precio_Uno(){
            Cargando();

            var url="{{ route('precio_sugerido_conf_un') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_precio_sugerido_conf').html(resp);  
                    $("#a_puno").addClass('active');
                    $("#a_pdos").removeClass('active');
                    $("#a_ptre").removeClass('active');
                }
            });
        }

        function Precio_Dos(){
            Cargando();

            var url="{{ route('precio_sugerido_conf_do') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_precio_sugerido_conf').html(resp);  
                    $("#a_puno").removeClass('active');
                    $("#a_pdos").addClass('active');
                    $("#a_ptre").removeClass('active');
                }
            });
        }

        function Precio_Tres(){
            Cargando();

            var url="{{ route('precio_sugerido_conf_tr') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_precio_sugerido_conf').html(resp);  
                    $("#a_puno").removeClass('active');
                    $("#a_pdos").removeClass('active');
                    $("#a_ptre").addClass('active');
                }
            });
        }
    </script>
@endsection
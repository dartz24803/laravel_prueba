@extends('layouts.plantilla')

@section('content')
    <style>
        input[disabled] {
            background-color: white !important;
            color: black;
        }
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                                <li class="nav-item">
                                    <a id="a_reg" class="nav-link" onclick="Registro();" style="cursor: pointer;">Registro</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_img" class="nav-link" onclick="Imagen();" style="cursor: pointer;">Imagen</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_apertura_cierre_tienda" class="widget-content widget-content-area p-3">
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
            $("#seguridades").addClass('active');
            $("#hseguridades").attr('aria-expanded', 'true');
            $("#aperturas_cierres").addClass('active');

            Registro();  
        });

        function Registro(){
            Cargando();

            var url="{{ route('apertura_cierre_reg') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_apertura_cierre_tienda').html(resp);  
                    $("#a_reg").addClass('active');
                    $("#a_img").removeClass('active');
                }
            });
        }

        function Imagen(){
            Cargando();

            var url="{{ route('apertura_cierre_reg') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_apertura_cierre_tienda').html('Imagen');  
                    $("#a_reg").removeClass('active');
                    $("#a_img").addClass('active');
                }
            });
        }
    </script>
@endsection
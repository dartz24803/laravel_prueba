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
                                    <a id="a_reg" class="nav-link" onclick="Registro();" style="cursor: pointer;">Registro</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_img" class="nav-link" onclick="Imagen();" style="cursor: pointer;">Imagen</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_control_camara" class="widget-content widget-content-area p-3">
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
            $("#controles_camaras").addClass('active');

            Registro();  
        });

        function Registro(){
            Cargando();

            var url="{{ route('control_camara_reg') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_control_camara').html(resp);  
                    $("#a_reg").addClass('active');
                    $("#a_img").removeClass('active');
                }
            });
        }

        function Imagen(){
            Cargando();

            var url="{{ route('control_camara_img') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_control_camara').html(resp);  
                    $("#a_reg").removeClass('active');
                    $("#a_img").addClass('active');
                }
            });
        }
    </script>
@endsection
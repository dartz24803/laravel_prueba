@extends('layouts.plantilla_new')

@section('navbar')
    @include('rrhh.navbar')
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
                                    <a id="a_reg" class="nav-link" onclick="Registro();" style="cursor: pointer;">Registro y Evaluación</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_tod" class="nav-link" onclick="Todos();" style="cursor: pointer;">Todos los postulantes</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_postulante" class="widget-content widget-content-area p-3">
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
            $("#lecturas_servicios").addClass('active');

            Registro();
        });
        
        function Registro(){
            Cargando();

            var url="{{ route('postulante_reg') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_postulante').html(resp);  
                    $("#a_reg").addClass('active');
                    $("#a_tod").removeClass('active');
                }
            });
        }

        function Todos(){
            Cargando();

            var url="{{ route('postulante_tod') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_postulante').html(resp);  
                    $("#a_reg").removeClass('active');
                    $("#a_tod").addClass('active');
                }
            });
        }
    </script>
@endsection
@extends('layouts.plantilla')

@section('navbar')
    @include('comercial.navbar')
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
                                    <a id="a_rrep" class="nav-link" onclick="Requerimiento_Reposicion();" style="cursor: pointer;">Requerimiento de reposición</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_mnue" class="nav-link" onclick="Mercaderia_Nueva();" style="cursor: pointer;">Mercadería nueva</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_requerimiento_tienda" class="widget-content widget-content-area p-3">
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
            $("#comercial").addClass('active');
            $("#hcomercial").attr('aria-expanded', 'true');
            $("#requerimientos_tiendas").addClass('active');

            Requerimiento_Reposicion();
        });
        
        function Requerimiento_Reposicion(){
            Cargando();

            var url="{{ route('requerimiento_tienda_re') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_requerimiento_tienda').html(resp);  
                    $("#a_rrep").addClass('active');
                    $("#a_mnue").removeClass('active');
                }
            });
        }

        function Mercaderia_Nueva(){
            Cargando();

            var url="{{ route('requerimiento_tienda_mn') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_requerimiento_tienda').html(resp);  
                    $("#a_rrep").removeClass('active');
                    $("#a_mnue").addClass('active');
                }
            });
        }
    </script>
@endsection
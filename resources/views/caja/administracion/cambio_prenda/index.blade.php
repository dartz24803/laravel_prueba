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
                                    <a id="a_mot" class="nav-link" onclick="Motivo();" style="cursor: pointer;">Motivo</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_cambio_prenda_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_cambios_prendas").addClass('active');

            Motivo();
        });
        
        function Motivo(){
            Cargando();

            var url="{{ route('cambio_prenda_conf_mo') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_cambio_prenda_conf').html(resp);  
                    $("#a_mot").addClass('active');
                }
            });
        }
    </script>
@endsection
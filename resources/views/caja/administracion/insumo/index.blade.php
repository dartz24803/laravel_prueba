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
                                    <a id="a_ins" class="nav-link" onclick="Insumo();" style="cursor: pointer;">Insumo</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_pro" class="nav-link" onclick="Proveedor();" style="cursor: pointer;">Proveedor</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_insumo_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_insumos").addClass('active');

            Insumo();
        });
        
        function Insumo(){
            Cargando();

            var url="{{ route('insumo_conf_in') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_insumo_conf').html(resp);  
                    $("#a_ins").addClass('active');
                    $("#a_pro").removeClass('active');
                }
            });
        }

        function Proveedor(){
            Cargando();

            var url="{{ route('insumo_conf_pr') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_insumo_conf').html(resp);  
                    $("#a_ins").removeClass('active');
                    $("#a_pro").addClass('active');
                }
            });
        }
    </script>
@endsection
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
                                    <a id="a_eins" class="nav-link" onclick="Entrada_Insumo();" style="cursor: pointer;">Entrada de insumo</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_rains" class="nav-link" onclick="Reparto_Insumo();" style="cursor: pointer;">Reparto de insumo</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_sins" class="nav-link" onclick="Salida_Insumo();" style="cursor: pointer;">Salida de insumo</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_roins" class="nav-link" onclick="Reporte_Insumo();" style="cursor: pointer;">Reporte de insumo</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_insumo" class="widget-content widget-content-area p-3">
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
            $("#cajas").addClass('active');
            $("#hcajas").attr('aria-expanded', 'true');
            $("#insumos").addClass('active');

            Entrada_Insumo();
        });
        
        function Entrada_Insumo(){
            Cargando();

            var url="{{ route('insumo_en') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_insumo').html(resp);  
                    $("#a_eins").addClass('active');
                    $("#a_rains").removeClass('active');
                    $("#a_sins").removeClass('active');
                    $("#a_roins").removeClass('active');
                }
            });
        }

        function Reparto_Insumo(){
            Cargando();

            var url="{{ route('insumo_ra') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_insumo').html(resp);  
                    $("#a_eins").removeClass('active');
                    $("#a_rains").addClass('active');
                    $("#a_sins").removeClass('active');
                    $("#a_roins").removeClass('active');
                }
            });
        }

        function Salida_Insumo(){
            Cargando();

            var url="{{ route('insumo_sa') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_insumo').html(resp);  
                    $("#a_eins").removeClass('active');
                    $("#a_rains").removeClass('active');
                    $("#a_sins").addClass('active');
                    $("#a_roins").removeClass('active');
                }
            });
        }

        function Reporte_Insumo(){
            Cargando();

            var url="{{ route('insumo_ro') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_insumo').html(resp);  
                    $("#a_eins").removeClass('active');
                    $("#a_rains").removeClass('active');
                    $("#a_sins").removeClass('active');
                    $("#a_roins").addClass('active');
                }
            });
        }
    </script>
@endsection
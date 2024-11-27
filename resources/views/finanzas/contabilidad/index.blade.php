@extends('layouts.plantilla')

@section('navbar')
@include('finanzas.navbar')
@endsection

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
                                <a id="a_infc" class="nav-link" onclick="InformeContabilidad();"
                                    style="cursor: pointer;">INFORME CONTABILIDAD</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_facp" class="nav-link" onclick="FacturadosParcial();"
                                    style="cursor: pointer;">FACTURADOS PARCIAL</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_fact" class="nav-link" onclick="FacturadosTotal();"
                                    style="cursor: pointer;">FACTURADOS TOTAL</a>
                            </li>
                        </ul>
                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_lista_maestra" class="widget-content widget-content-area p-3">
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
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded', 'true');
        $("#tabla_facturacion").addClass('active');

        InformeContabilidad();
    });

    function InformeContabilidad() {
        Cargando();

        var url = "{{ route('facturacion_ic') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_lista_maestra').html(resp);
                $("#a_infc").addClass('active');
                $("#a_facp").removeClass('active');
                $("#a_fact").removeClass('active');

            }
        });
    }

    function FacturadosParcial() {
        Cargando();

        var url = "{{ route('facturacion_fp') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_lista_maestra').html(resp);
                $("#a_infc").removeClass('active');
                $("#a_facp").addClass('active');
                $("#a_fact").removeClass('active');

            }
        });
    }

    function FacturadosTotal() {
        Cargando();

        var url = "{{ route('facturacion_fp') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_lista_maestra').html(resp);
                $("#a_infc").removeClass('active');
                $("#a_facp").removeClass('active');
                $("#a_fact").addClass('active');

            }
        });
    }
</script>
@endsection
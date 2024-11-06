@extends('layouts.plantilla')

@section('navbar')
@include('interna.navbar')
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
                                <a id="a_tipind" class="nav-link" onclick="TipoIndicador();"
                                    style="cursor: pointer;">Tipo Concepto</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_sis" class="nav-link" onclick="SistemaDb();" style="cursor: pointer;">Bases
                                    de Datos</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_dbtb" class="nav-link" onclick="SistemaTablas();"
                                    style="cursor: pointer;">Tablas</a>
                            </li>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_reporte_tipoind_conf" class="widget-content widget-content-area p-3">
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
        $("#reporteconf").addClass('active');
        $("#reporteconf").attr('aria-expanded', 'true');


        TipoIndicador();
    });

    function TipoIndicador() {
        Cargando();

        var url = "{{ route('bireporte_ti_conf') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_reporte_tipoind_conf').html(resp);
                $("#a_tipind").addClass('active');
                $("#a_sis").removeClass('active');
                $("#a_dbtb").removeClass('active');

            }
        });
    }

    function SistemaDb() {
        Cargando();

        var url = "{{ route('bireporte_sisbd_conf') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_reporte_tipoind_conf').html(resp);
                $("#a_tipind").removeClass('active');
                $("#a_sis").addClass('active');
                $("#a_dbtb").removeClass('active');

            }
        });
    }

    function SistemaTablas() {
        Cargando();

        var url = "{{ route('bireporte_tbbd_conf') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_reporte_tipoind_conf').html(resp);
                $("#a_tipind").removeClass('active');
                $("#a_sis").removeClass('active');
                $("#a_dbtb").addClass('active');

            }
        });
    }

    function DbSis() {
        Cargando();

        var url = "{{ route('bireporte_sisbd_conf') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_reporte_tipoind_conf').html(resp);
                $("#a_tipind").removeClass('active');
                $("#a_sis").removeClass('active');
                $("#a_dbsis").addClass('active');

            }
        });
    }
</script>
@endsection
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
                                <a id="a_sed" class="nav-link" onclick="Sede();" style="cursor: pointer;">Sede</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_hpro" class="nav-link" onclick="Hora_Programada();" style="cursor: pointer;">Hora Programada Bases</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_loc" class="nav-link" onclick="Local();" style="cursor: pointer;">Local</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_ron" class="nav-link" onclick="Ronda();" style="cursor: pointer;">Ronda</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_tie" class="nav-link" onclick="Tienda();" style="cursor: pointer;">Tienda</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_ocu" class="nav-link" onclick="Ocurrencia();" style="cursor: pointer;">Ocurrencia</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_hproli" class="nav-link" onclick="Hora_Programada_Lima();" style="cursor: pointer;">Hora Programada Lima</a>
                            </li>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_control_camara_conf" class="widget-content widget-content-area p-3">
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
        $("#conf_seguridades").addClass('active');
        $("#hconf_seguridades").attr('aria-expanded', 'true');
        $("#conf_controles_camaras").addClass('active');

        Sede();
    });

    function Sede() {
        Cargando();

        var url = "{{ route('control_camara_conf_se') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_control_camara_conf').html(resp);
                $("#a_sed").addClass('active');
                $("#a_hpro").removeClass('active');
                $("#a_loc").removeClass('active');
                $("#a_ron").removeClass('active');
                $("#a_tie").removeClass('active');
                $("#a_ocu").removeClass('active');
                $("#a_hproli").removeClass('active');
            }
        });
    }

    function Hora_Programada() {
        Cargando();

        var url = "{{ route('control_camara_conf_ho') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_control_camara_conf').html(resp);
                $("#a_sed").removeClass('active');
                $("#a_hpro").addClass('active');
                $("#a_loc").removeClass('active');
                $("#a_ron").removeClass('active');
                $("#a_tie").removeClass('active');
                $("#a_ocu").removeClass('active');
                $("#a_hproli").removeClass('active');
            }
        });
    }

    function Local() {
        Cargando();

        var url = "{{ route('control_camara_conf_lo') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_control_camara_conf').html(resp);
                $("#a_sed").removeClass('active');
                $("#a_hpro").removeClass('active');
                $("#a_loc").addClass('active');
                $("#a_ron").removeClass('active');
                $("#a_tie").removeClass('active');
                $("#a_ocu").removeClass('active');
                $("#a_hproli").removeClass('active');
            }
        });
    }

    function Ronda() {
        Cargando();

        var url = "{{ route('control_camara_conf_ro') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_control_camara_conf').html(resp);
                $("#a_sed").removeClass('active');
                $("#a_hpro").removeClass('active');
                $("#a_loc").removeClass('active');
                $("#a_ron").addClass('active');
                $("#a_tie").removeClass('active');
                $("#a_ocu").removeClass('active');
                $("#a_hproli").removeClass('active');
            }
        });
    }

    function Tienda() {
        Cargando();

        var url = "{{ route('control_camara_conf_ti') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_control_camara_conf').html(resp);
                $("#a_sed").removeClass('active');
                $("#a_hpro").removeClass('active');
                $("#a_loc").removeClass('active');
                $("#a_ron").removeClass('active');
                $("#a_tie").addClass('active');
                $("#a_ocu").removeClass('active');
                $("#a_hproli").removeClass('active');
            }
        });
    }

    function Ocurrencia() {
        Cargando();

        var url = "{{ route('control_camara_conf_oc') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_control_camara_conf').html(resp);
                $("#a_sed").removeClass('active');
                $("#a_hpro").removeClass('active');
                $("#a_loc").removeClass('active');
                $("#a_ron").removeClass('active');
                $("#a_tie").removeClass('active');
                $("#a_ocu").addClass('active');
                $("#a_hproli").removeClass('active');
            }
        });
    }

    function Hora_Programada_Lima() {
        Cargando();

        var url = "{{ route('control_camara_conf_ho_li') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_control_camara_conf').html(resp);
                $("#a_sed").removeClass('active');
                $("#a_hproli").addClass('active');
                $("#a_loc").removeClass('active');
                $("#a_ron").removeClass('active');
                $("#a_tie").removeClass('active');
                $("#a_ocu").removeClass('active');
                $("#a_hpro").removeClass('active');
            }
        });
    }
</script>
@endsection
@extends('layouts.plantilla')

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
                                <a id="asistencia_rrhh" class="nav-link" onclick="Asistencia();" style="cursor: pointer;">Asistencia</a>
                            </li>
                            <li class="nav-item">
                                <a id="inconsistencia_rrhh" class="nav-link" onclick="Inconsistencias();" style="cursor: pointer;">Inconsistencias</a>
                            </li>
                            <li class="nav-item">
                                <a id="ausencias_rrhh" class="nav-link" onclick="Ausencias();" style="cursor: pointer;">Ausencias</a>
                            </li>
                            <li class="nav-item">
                                <a id="dotacion_rrhh" class="nav-link" onclick="Dotacion();" style="cursor: pointer;">Dotación</a>
                            </li>
                            <li class="nav-item">
                                <a id="tardanza_rrhh" class="nav-link" onclick="Tardanza();" style="cursor: pointer;">Tardanza</a>
                            </li>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_colaborador" class="widget-content widget-content-area p-3">
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
        $("#rhumanos").addClass('active');
        $("#hrhumanos").attr('aria-expanded', 'true');
        $("#asist_colaborador").addClass('active');

        Asistencia();
    });

    function Asistencia() {
        Cargando();

        var url = "{{ route('asistencia_colaborador') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador').html(resp);
                $("#asistencia_rrhh").addClass('active');
                $("#inconsistencia_rrhh").removeClass('active');
                $("#ausencias_rrhh").removeClass('active');
                $("#dotacion_rrhh").removeClass('active');
                $("#tardanza_rrhh").removeClass('active');

            }
        });
    }

    function Inconsistencias() {
        Cargando();

        var url = "{{ route('incosistencia_colaborador') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador').html(resp);
                $("#asistencia_rrhh").removeClass('active');
                $("#inconsistencia_rrhh").addClass('active');
                $("#ausencias_rrhh").removeClass('active');
                $("#dotacion_rrhh").removeClass('active');
                $("#tardanza_rrhh").removeClass('active');
            }
        });
    }

    function Ausencias() {
        Cargando();
        var url = "{{ route('ausencias_colaborador') }}";
        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador').html(resp);
                $("#asistencia_rrhh").removeClass('active');
                $("#inconsistencia_rrhh").removeClass('active');
                $("#ausencias_rrhh").addClass('active');
                $("#dotacion_rrhh").removeClass('active');
                $("#tardanza_rrhh").removeClass('active');
            }
        });
    }


    function Dotacion() {
        Cargando();
        var url = "{{ route('dotacion_colaborador') }}";
        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador').html(resp);
                $("#asistencia_rrhh").removeClass('active');
                $("#inconsistencia_rrhh").removeClass('active');
                $("#ausencias_rrhh").removeClass('active');
                $("#dotacion_rrhh").addClass('active');
                $("#tardanza_rrhh").removeClass('active');
            }
        });
    }


    function Tardanza() {
        Cargando();
        var url = "{{ route('tardanza_colaborador') }}";
        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador').html(resp);
                $("#asistencia_rrhh").removeClass('active');
                $("#inconsistencia_rrhh").removeClass('active');
                $("#ausencias_rrhh").removeClass('active');
                $("#dotacion_rrhh").removeClass('active');
                $("#tardanza_rrhh").addClass('active');
            }
        });
    }
</script>
@endsection
@extends('layouts.plantilla')

@section('navbar')
@include('interna.navbar')
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
                                <a id="a_cap" class="nav-link" onclick="ListaCapacitaciones();"
                                    style="cursor: pointer;">Capacitación</a>
                            </li>

                        </ul>
                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_lista_capacitaciones" class="widget-content widget-content-area p-3">
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
        $("#procesos").addClass('active');
        $("#procesos").attr('aria-expanded', 'true');
        $("#capacitacion").addClass('active');

        ListaCapacitaciones();
    });

    function ListaCapacitaciones() {
        Cargando();

        var url = "{{ route('portalprocesos_cap') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_lista_capacitaciones').html(resp);
                $("#a_cap").addClass('active');
            }
        });
    }
</script>
@endsection
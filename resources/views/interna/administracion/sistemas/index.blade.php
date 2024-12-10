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
                            <div class="d-flex align-items-center overflow-auto py-1" id="scroll_tabs">
                                <li class="nav-item">
                                    <a id="a_mo" class="nav-link" onclick="Modulo();" style="cursor: pointer;">Módulo</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_co" class="nav-link" onclick="Complejidad();" style="cursor: pointer;">Complejidad</a>
                                </li>
                            </div>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_ticket_conf" class="widget-content widget-content-area p-3">
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
        $("#conf_sistemas").addClass('active');
        $("#hconf_sistemas").attr('aria-expanded', 'true');
        $("#conf_tickets").addClass('active');

        Modulo();
    });

    function Modulo() {
        Cargando();

        var url = "{{ route('ticket_conf_mo') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_ticket_conf').html(resp);
                $("#a_mo").addClass('active');
                $("#a_co").removeClass('active');
            }
        });
    }

    function Complejidad() {
        Cargando();

        var url = "{{ route('ticket_conf_co') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_ticket_conf').html(resp);
                $("#a_mo").removeClass('active');
                $("#a_co").addClass('active');
            }
        });
    }
</script>
@endsection
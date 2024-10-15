@extends('layouts.plantilla')

@section('navbar')
@include('logistica.navbar')
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
                                <a id="a_ser" class="nav-link" onclick="TalladeErroresPicking();" style="cursor: pointer;">Talla</a>
                            </li>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_ocurrencias_conf" class="widget-content widget-content-area p-3">
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
        $("#logisticaconf").addClass('active');
        $("#hlogisticaconf").attr('aria-expanded', 'true');
        $("#errorespickingta").addClass('active');

        TalladeErroresPicking();
    });

    function TalladeErroresPicking() {
        Cargando();

        var url = "{{ route('errorespickingta') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_ocurrencias_conf').html(resp);
                $("#a_ser").addClass('active');
                $("#a_pser").removeClass('active');
                $("#a_dser").removeClass('active');
            }
        });
    }

    function ConclusionOcurrencias() {
        Cargando();

        var url = "{{ route('ocurrencia_conf_co') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_ocurrencias_conf').html(resp);
                $("#a_ser").removeClass('active');
                $("#a_pser").addClass('active');
                $("#a_dser").removeClass('active');
            }
        });
    }

    function TipoOcurrencias() {
        Cargando();

        var url = "{{ route('ocurrencia_conf_to') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_ocurrencias_conf').html(resp);
                $("#a_ser").removeClass('active');
                $("#a_pser").removeClass('active');
                $("#a_dser").addClass('active');
            }
        });
    }
</script>
@endsection
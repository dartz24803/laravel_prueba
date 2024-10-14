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
                                <a id="art_con" class="nav-link" onclick="ArticulosdeConsumibles();" style="cursor: pointer;">Articulo</a>
                            </li>
                            <li class="nav-item">
                                <a id="uni_con" class="nav-link" onclick="UnidaddeConsumibles();" style="cursor: pointer;">Unidad</a>
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
    logisticaconf
    $(document).ready(function() {
        $("#logisticaconf").addClass('active');
        $("#hlogisticaconf").attr('aria-expanded', 'true');
        $("#consumibles").addClass('active');

        ArticulosdeConsumibles();
    });

    function ArticulosdeConsumibles() {
        Cargando();

        var url = "{{ route('consumibleart') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_ocurrencias_conf').html(resp);
                $("#art_con").addClass('active');
                $("#uni_con").removeClass('active');

            }
        });
    }

    function UnidaddeConsumibles() {
        Cargando();

        var url = "{{ route('consumibleuni') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_ocurrencias_conf').html(resp);
                $("#art_con").removeClass('active');
                $("#uni_con").addClass('active');

            }
        });
    }
</script>
@endsection
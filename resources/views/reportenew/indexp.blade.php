@extends('layouts.plantilla')

@section('navbar')
@include('tienda.navbar')
@endsection

@section('content')
<style>
    /* Estilos para que el div ocupe toda la pantalla */
    #cancel-row {
        height: calc(100vh - 100px);
        /* Ajusta el valor según el tamaño de tu navbar u otros elementos */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #div_administrador {
        width: 100%;
        height: 100%;
    }

    iframe {
        width: 100%;
        height: 100%;
        border: none;
        /* Elimina el borde del iframe */
    }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">

                            @foreach($list_reportes as $reporte)
                            <li class="nav-item">
                                <a class="nav-link" style="cursor: pointer;" onclick="showIframe('{{ $reporte->iframe }}');">{{ $reporte->nom_bi }}</a>
                            </li>
                            @endforeach
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_administrador" class="widget-content widget-content-area p-3">
                                    <!-- Aquí se mostrará el iframe -->
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
        var idArea = "{{ $id_area }}";
        $("#reportbi_primario").addClass('active');
        $("#hreportbi_primario").attr('aria-expanded', 'true');
        $("#" + idArea).addClass('active');

        Supervision_Tienda();
    });

    function showIframe(iframeSrc) {
        // Aquí se asigna el iframe al div
        $('#div_administrador').html(iframeSrc);
    }
</script>
@endsection
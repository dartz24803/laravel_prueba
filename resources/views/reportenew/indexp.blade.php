@extends('layouts.plantilla')

@section('navbar')
@include('tienda.navbar')
@endsection

@section('content')
<style>
    /* Estilos para que el div ocupe toda la pantalla */
    #cancel-row {
        height: calc(100vh - 100px);
        /* Ajusta según la altura de tu navbar */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #div_administrador {
        width: 100%;
        height: 100%;
        display: flex;
    }

    iframe {
        width: 100%;
        height: 100%;
        border: none;
        /* Elimina el borde del iframe */
    }

    /* Asegura que los contenedores padres del iframe ocupen todo el espacio */
    .widget-content-area {
        height: 100%;
    }

    .nav-item .nav-link.active-li {
        font-weight: bold;
        color: #fea701;
    }
</style>

<div id="content" class="main-content" style="height: 100vh;">
    <div class="layout-px-spacing" style="height: 100%;">
        <div class="row layout-top-spacing" style="height: 100%;">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing" style="height: 100%;">
                <div class="statbox widget box box-shadow" style="height: 100%;">
                    <div class="widget-content widget-content-area simple-tab" style="height: 100%;">
                        <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                            @foreach($list_reportes as $reporte)
                            <li class="nav-item">
                                <a class="nav-link" style="cursor: pointer;" onclick="showIframe('{{ $reporte->iframe }}', this);">{{ $reporte->nom_bi }}</a>
                            </li>
                            @endforeach
                        </ul>

                        <div class="row" id="cancel-row">

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

<script>
    $(document).ready(function() {
        var idArea = "{{ $id_area }}";
        $("#reportbi_primario").addClass('active');
        $("#hreportbi_primario").attr('aria-expanded', 'true');
        $("#" + idArea).addClass('active');

        Supervision_Tienda();
    });

    function showIframe(iframeSrc, element) {
        // Aquí se asigna el iframe al div
        $('#div_administrador').html(iframeSrc);

        // Remover la clase active de todos los li
        $('.nav-item .nav-link').removeClass('active-li');

        // Añadir la clase active solo al li clickeado
        $(element).addClass('active-li');
    }
</script>
@endsection
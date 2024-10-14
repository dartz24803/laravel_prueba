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
                            <div class="d-flex align-items-center overflow-auto py-1" id="scroll_tabs">
                                <a class="nav-link active" style="cursor: pointer;" id="Permisospstres" onclick="TablaPermisosPepeletas_salidas()">Permisos de papeletas de salida</a>
                                <a class="nav-link" style="cursor: pointer;" id="DestinoArriba" onclick="TablaDestino()">Destino</a>
                                <a class="nav-link" style="cursor: pointer;" id="TramiteArriba" onclick="TablaTramite()">Trámite</a>
                            </div>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="lista_escogida" class="widget-content widget-content-area p-3">
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
        $("#conf_rrhhs").addClass('active');
        $("#rconf_rrhhs").attr('aria-expanded','true');
        $("#rgpapeletas_salidas").addClass('active');

        TablaPermisosPepeletas_salidas();
    });

    
    function TablaPermisosPepeletas_salidas() {
        $("#Permisospstres").addClass('active');
        $("#DestinoArriba").removeClass('active');
        $("#TramiteArriba").removeClass('active');

        var url = "{{ url('PapeletasConf/Permisos_Papeletas_Salidas') }}";
        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                $('#lista_escogida').html(resp);
            }
        });

    }

    function TablaDestino() {
        Cargando();

        $("#Permisospstres").removeClass('active');
        $("#DestinoArriba").addClass('active');
        $("#TramiteArriba").removeClass('active');
        
        var url = "{{ url('PapeletasConf/Destino') }}";
        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                $('#lista_escogida').html(resp);
            }
        });
    }

</script>
@endsection
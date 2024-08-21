@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                                <li class="nav-item">
                                    <a id="a_ser" class="nav-link" onclick="GestionOcurrencias();" style="cursor: pointer;">Gestión de Ocurrencias</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_pser" class="nav-link" onclick="ConclusionOcurrencias();" style="cursor: pointer;">Conclusión Ocurrencias</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_dser" class="nav-link" onclick="TipoOcurrencias();" style="cursor: pointer;">Tipo Ocurrencias</a>
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
            $("#conf_seguridades").addClass('active');
            $("#hconf_seguridades").attr('aria-expanded', 'true');
            $("#conf_concurrencias_servicios").addClass('active');

            GestionOcurrencias();
        });

        function GestionOcurrencias(){
            Cargando();

            var url="{{ route('ocurrencia_conf_go') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_ocurrencias_conf').html(resp);
                    $("#a_ser").addClass('active');
                    $("#a_pser").removeClass('active');
                    $("#a_dser").removeClass('active');
                }
            });
        }

        function ConclusionOcurrencias(){
            Cargando();

            var url="{{ route('ocurrencia_conf_co') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_ocurrencias_conf').html(resp);
                    $("#a_ser").removeClass('active');
                    $("#a_pser").addClass('active');
                    $("#a_dser").removeClass('active');
                }
            });
        }

        function TipoOcurrencias(){
            Cargando();

            var url="{{ route('ocurrencia_conf_to') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_ocurrencias_conf').html(resp);
                    $("#a_ser").removeClass('active');
                    $("#a_pser").removeClass('active');
                    $("#a_dser").addClass('active');
                }
            });
        }


    </script>
@endsection

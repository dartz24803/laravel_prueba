@extends('layouts.plantilla_sinsoporte')

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
                                <li class="nav-item">
                                    <a id="a_capac" class="nav-link" style="cursor: pointer;">Tema Capacitaciones</a>
                                </li>

                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_reporte_tipoind_conf" class="widget-content widget-content-area p-3">
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

            $("#procesoconf").addClass('active');
            $("#hprocesosconf").attr('aria-expanded', 'true');

            TipoIndicador();
        });

        function TipoIndicador() {
            Cargando();

            var url = "{{ route('portalprocesos_cap_conf') }}";

            $.ajax({
                url: url,
                type: "GET",
                success: function(resp) {
                    $('#div_reporte_tipoind_conf').html(resp);
                    $("#a_capac").addClass('active');
                }
            });
        }
    </script>
@endsection

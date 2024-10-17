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
                                    <a id="a_tip" class="nav-link" onclick="Tipo();" style="cursor: pointer;">Tipo</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_notificacion_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_notificaciones").addClass('active');
            $("#hconf_notificaciones").attr('aria-expanded', 'true');
            $("#conf_notificaciones").addClass('active');

            Tipo();
        });

        function Tipo() {
            Cargando();

            var url = "{{ route('notificacion_conf_ti') }}";

            $.ajax({
                url: url,
                type: "GET",
                success: function(resp) {
                    $('#div_notificacion_conf').html(resp);
                    $("#a_tip").addClass('active');
                }
            });
        }
    </script>
@endsection

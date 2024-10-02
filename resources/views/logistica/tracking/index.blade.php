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
                                    <a id="a_tra" class="nav-link" onclick="Tracking();" style="cursor: pointer;">Tracking</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_btra" class="nav-link" onclick="Bd_Tracking();" style="cursor: pointer;">BD Tracking</a>
                                </li>
                            </ul>
    
                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_tracking" class="widget-content widget-content-area p-3">
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
            $("#logisticas").addClass('active');
            $("#hlogisticas").attr('aria-expanded', 'true');
            $("#trackings").addClass('active');

            Tracking();
        });

        function Tracking() {
            Cargando();

            var url = "{{ route('tracking_index') }}";

            $.ajax({
                url: url,
                type: "GET",
                success: function(resp) {
                    $('#div_tracking').html(resp);
                    $("#a_tra").addClass('active');
                    $("#a_btra").removeClass('active');
                }
            });
        }

        function Bd_Tracking() {
            Cargando();

            var url = "{{ route('bd_tracking') }}";

            $.ajax({
                url: url,
                type: "GET",
                success: function(resp) {
                    $('#div_tracking').html(resp);
                    $("#a_tra").removeClass('active');
                    $("#a_btra").addClass('active');
                }
            });
        }
    </script>
@endsection

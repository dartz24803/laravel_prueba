@extends('layouts.plantilla')

@section('navbar')
    @include('finanzas.navbar')
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
                                    <a id="a_co" class="nav-link" onclick="Concepto();" style="cursor: pointer;">Concepto</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_registro_cheque_conf" class="widget-content widget-content-area p-3">
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
            $("#conf_tesorerias").addClass('active');
            $("#hconf_tesorerias").attr('aria-expanded', 'true');
            $("#conf_registros_cheques").addClass('active');

            Concepto();
        });
        
        function Concepto(){
            Cargando();

            var url="{{ route('registro_cheque_conf_co') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_registro_cheque_conf').html(resp);  
                    $("#a_co").addClass('active');
                }
            });
        }
    </script>
@endsection
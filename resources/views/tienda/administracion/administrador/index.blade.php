@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs ml-3 mb-3 mt-3" id="simpletab" role="tablist">
                                <li class="nav-item">
                                    <a id="a_st" class="nav-link" onclick="Supervision_Tienda();" style="cursor: pointer;">Supervisión de tienda</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_sc" class="nav-link" onclick="Seguimiento_Coordinador();" style="cursor: pointer;">Seguimiento al coordinador</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_conf_tienda" class="widget-content widget-content-area p-3">
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
            $("#ccvtabla").addClass('active');
            $("#hccvtabla").attr('aria-expanded', 'true');
            $("#conf_administradores").addClass('active');

            Supervision_Tienda();
        });
        
        function Supervision_Tienda(){
            Cargando();

            var url="{{ route('administrador_conf_st') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_conf_tienda').html(resp);  
                    $("#a_st").addClass('active');
                    $("#a_sc").removeClass('active');
                }
            });
        }
    </script>
@endsection
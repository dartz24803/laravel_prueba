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
                                <li class="nav-item">
                                    <a id="a_col" class="nav-link" onclick="Colaborador();" style="cursor: pointer;">Colaborador</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ces" class="nav-link" onclick="Cesado();" style="cursor: pointer;">Colaborador (Cesados)</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_colaborador" class="widget-content widget-content-area p-3">
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
            $("#rhumanos").addClass('active');
            $("#hrhumanos").attr('aria-expanded', 'true');
            $("#colaboradores").addClass('active');

            Colaborador();
        });
        
        function Colaborador(){
            Cargando();

            var url="{{ route('colaborador_co') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador').html(resp);  
                    $("#a_col").addClass('active');
                    $("#a_ces").removeClass('active');
                }
            });
        }

        function Cesado(){
            Cargando();

            var url="{{ route('colaborador_ce') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador').html(resp);  
                    $("#a_col").removeClass('active');
                    $("#a_ces").addClass('active');
                }
            });
        }
    </script>
@endsection
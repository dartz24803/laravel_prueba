@extends('layouts.plantilla')

@section('navbar')
    @include('tienda.navbar')
@endsection

@section('content')
    <style>
        .toggle-switch {
            position: relative;
            display: inline-block;
            height: 24px;
            margin: 10px;
        }

        .toggle-switch .toggle-input {
            display: none;
        }

        .toggle-switch .toggle-label {
            position: absolute;
            top: 0;
            left: 0;
            width: 40px;
            height: 24px;
            background-color: gray;
            border-radius: 34px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .toggle-switch .toggle-label::before {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            background-color: #fff;
            box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
        }

        .toggle-switch .toggle-input:checked+.toggle-label {
            background-color: #4CAF50;
        }

        .toggle-switch .toggle-input:checked+.toggle-label::before {
            transform: translateX(16px);
        }
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                                {{--<li class="nav-item">
                                    <a id="a_rrep" class="nav-link" onclick="Requerimiento_Reposicion();" style="cursor: pointer;">Requerimiento de reposición</a>
                                </li>--}}
                                <li class="nav-item">
                                    <a id="a_mnue" class="nav-link" onclick="Mercaderia_Nueva();" style="cursor: pointer;">Mercadería nueva</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_requerimiento_tienda" class="widget-content widget-content-area p-3">
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
            $("#tienda").addClass('active');
            $("#htienda").attr('aria-expanded', 'true');
            $("#requerimientos_tiendas").addClass('active');

            Mercaderia_Nueva();
        });

        function Mercaderia_Nueva(){
            Cargando();

            var url="{{ route('trequerimiento_tienda_mn') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_requerimiento_tienda').html(resp);  
                    $("#a_mnue").addClass('active');
                }
            });
        }
    </script>
@endsection
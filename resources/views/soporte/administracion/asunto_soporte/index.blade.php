@extends('layouts.plantilla_sinsoporte')

@section('navbar')
    @include('interna.navbar')
@endsection

@section('content')
    <style>
        input[disabled] {
            background-color: white !important;
            color: black;
        }
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                                <li class="nav-item">
                                    <a id="especialidad" class="nav-link" style="cursor: pointer;"
                                        onclick="ListEspecialidad();">Especialidad</a>
                                </li>
                                <li class="nav-item">
                                    <a id="elemento" class="nav-link" style="cursor: pointer;"
                                        onclick="ListElementos();">Elemento</a>
                                </li>
                                <li class="nav-item">
                                    <a id="asunto" class="nav-link" style="cursor: pointer;"
                                        onclick="ListAsuntos();">Asunto</a>
                                </li>
                            </ul>
                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_lista_maestra" class="widget-content widget-content-area p-3">
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
            $("#soporteconf").addClass('active');
            $("#hsoporteconf").attr('aria-expanded', 'true');
            $("#rasuntosoporte").addClass('active');

            $("#especialidad").addClass('active');
            $("#elemento").removeClass('active');
            $("#asunto").removeClass('active');

            ListEspecialidad();
        });

        function ListEspecialidad() {
            Cargando();

            var url = "{{ route('soporte_especialidad_conf') }}";

            $.ajax({
                url: url,
                type: "GET",
                success: function(resp) {
                    $('#div_lista_maestra').html(resp);
                    $("#especialidad").addClass('active');
                    $("#elemento").removeClass('active');
                    $("#asunto").removeClass('active');

                }
            });
        }

        function ListElementos() {
            Cargando();

            var url = "{{ route('soporte_elemento_conf') }}";

            $.ajax({
                url: url,
                type: "GET",
                success: function(resp) {
                    $('#div_lista_maestra').html(resp);
                    $("#especialidad").removeClass('active');
                    $("#elemento").addClass('active');
                    $("#asunto").removeClass('active');

                }
            });
        }

        function ListAsuntos() {
            Cargando();

            var url = "{{ route('soporte_asunto_conf') }}";

            $.ajax({
                url: url,
                type: "GET",
                success: function(resp) {
                    $('#div_lista_maestra').html(resp);
                    $("#especialidad").removeClass('active');
                    $("#elemento").removeClass('active');
                    $("#asunto").addClass('active');

                }
            });
        }
    </script>
@endsection

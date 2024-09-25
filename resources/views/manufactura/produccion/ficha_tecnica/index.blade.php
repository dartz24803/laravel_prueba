@extends('layouts.plantilla')

@section('navbar')
@include('manufactura.navbar')
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
                                <a id="a_cap" class="nav-link" onclick="Lista_Fichas_Tecnicas();" style="cursor: pointer;">Registrar Ficha Técnica</a>
                            </li>

                        </ul>
                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_lista_ft" class="widget-content widget-content-area p-3">
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
        $("#manufactura").addClass('active');
        $("#manufactura").attr('aria-expanded', 'true');
        $("#fichas_tecnicas").addClass('active');

        Lista_Fichas_Tecnicas();
    });

    function Lista_Fichas_Tecnicas() {
        Cargando();

        var url = "{{ route('produccion_ft') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_lista_ft').html(resp);
                $("#a_cap").addClass('active');
            }
        });
    }
</script>
@endsection
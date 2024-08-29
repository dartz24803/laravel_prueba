@extends('layouts.plantilla')

@section('content')
<style>
    .radio-buttons {
        display: flex;
        flex-direction: column;
        color: white;
    }

    .radio-button {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .radio-button input[type="radio"] {
        display: none;
    }

    .radio-circle {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #aaa;
        position: relative;
        margin-right: 10px;
    }

    .radio-circle::before {
        content: "";
        display: block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #ddd;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        transition: all 0.2s ease-in-out;
    }

    .radio-button input[type="radio"]:checked+.radio-circle::before {
        transform: translate(-50%, -50%) scale(1);
    }

    .radio-button.radio-button-si input[type="radio"]:checked+.radio-circle::before {
        background-color: #88DC65;
    }

    .radio-button.radio-button-si input[type="radio"]:checked+.radio-circle {
        border-color: #88DC65;
    }

    .radio-button.radio-button-no input[type="radio"]:checked+.radio-circle::before {
        background-color: #FF0000;
    }

    .radio-button.radio-button-no input[type="radio"]:checked+.radio-circle {
        border-color: #FF0000;
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
                                <a id="a_st" class="nav-link" onclick="Supervision_Tienda();" style="cursor: pointer;">Supervisión de tienda</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_sc" class="nav-link" onclick="Seguimiento_Coordinador();" style="cursor: pointer;">Seguimiento al coordinador</a>
                            </li>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_administrador" class="widget-content widget-content-area p-3">
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
        $("#administradores").addClass('active');

        Supervision_Tienda();
    });

    function Supervision_Tienda() {
        Cargando();

        var url = "{{ route('administrador_st') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_administrador').html(resp);
                $("#a_st").addClass('active');
                $("#a_sc").removeClass('active');
            }
        });
    }

    function Seguimiento_Coordinador() {
        Cargando();

        var url = "{{ route('administrador_sc') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_administrador').html(resp);
                $("#a_st").removeClass('active');
                $("#a_sc").addClass('active');
            }
        });
    }
</script>
@endsection
@extends('layouts.plantilla')

@section('content')
<?php

use Illuminate\Support\Facades\Session;
$id_puesto = Session::get('usuario')->id_puesto;
$id_usuario = Session::get('usuario')->id_usuario;
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs mb-3 mt-3" id="simpletab" role="tablist">
                            <?php if ($id_puesto == 19 || $id_puesto == 20 || $id_puesto == 21 ||
                            $id_puesto == 22 || $id_puesto == 133 || Session::get('usuario')->id_nivel == 1){ ?>
                                <li class="nav-item">
                                    <a id="a_hcc" class="nav-link" onclick="Horarios_Cuadro_Control();" style="cursor: pointer;">Horarios</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ccv" class="nav-link" onclick="Cuadro_Control_Visual();" style="cursor: pointer;">Cuadro de Control Visual</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_pd" class="nav-link" onclick="Programacion_Diaria();" style="cursor: pointer;">Programación Diaria</a>
                                </li>
                            <?php } ?>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_conf_tienda" class="widget-content widget-content-area">
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
        $("#hccvtabla").attr('aria-expanded','true');
        $("#ccv").addClass('active');

        Horarios_Cuadro_Control();
    });

    function Horarios_Cuadro_Control(){
        Cargando();

        var url="{{ url('Horarios_Cuadro_Control')}}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_conf_tienda').html(resp);
                $("#a_hcc").addClass('active');
                $("#a_ccv").removeClass('active');
                $("#a_pd").removeClass('active');
            }
        });
    }

    function Cuadro_Control_Visual(){
        Cargando();

        var url="{{ url('Cuadro_Control_Visual') }}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_conf_tienda').html(resp);
                $("#a_hcc").removeClass('active');
                $("#a_ccv").addClass('active');
                $("#a_pd").removeClass('active');
            }
        });
    }

    function Programacion_Diaria(){
        Cargando();

        var url="{{ url('Programacion_Diaria') }}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_conf_tienda').html(resp);
                $("#a_hcc").removeClass('active');
                $("#a_ccv").removeClass('active');
                $("#a_pd").addClass('active');
            }
        });
    }
</script>
@endsection

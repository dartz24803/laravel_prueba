@extends('layouts.plantilla')

@section('navbar')
@include('finanzas.navbar')
@endsection

@section('content')
<?php
    $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs mt-0" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a id="a_mt" class="nav-link" onclick="Mis_Tareas();" style="cursor: pointer;">Mis tareas</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_ts" class="nav-link" onclick="Tareas_Solicitadas();" style="cursor: pointer;">Tareas solicitadas</a>
                            </li>
                            <?php if($id_nivel==1){ ?>
                                <li class="nav-item">
                                    <a id="a_pt" class="nav-link" onclick="Programador_Tareas();" style="cursor: pointer;">Programador de Tareas</a>
                                </li>
                            <?php } ?>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_tarea" class="widget-content widget-content-area">
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
        $("#gpendientes").addClass('active');
        $("#hgpendientes").attr('aria-expanded','true');

        Mis_Tareas();
    });

    function Mis_Tareas(){
        Cargando();

        var url="<?php echo site_url(); ?>Corporacion/Cargar_Mis_Tareas";

        $.ajax({
            url: url,
            type:"POST",
            success:function (resp) {
                $('#div_tarea').html(resp);
                $("#a_mt").addClass('active');
                $("#a_ts").removeClass('active');
                $("#a_pt").removeClass('active');
            }
        });
    }

    function Tareas_Solicitadas(){
        Cargando();

        var url="<?php echo site_url(); ?>Corporacion/Cargar_Tareas_Solicitadas";

        $.ajax({
            url: url,
            type:"POST",
            success:function (resp) {
                $('#div_tarea').html(resp);
                $("#a_mt").removeClass('active');
                $("#a_ts").addClass('active');
                $("#a_pt").removeClass('active');
            }
        });
    }

    function Programador_Tareas(){
        Cargando();

        var url="<?php echo site_url(); ?>Corporacion/Cargar_Programador_Tareas";

        $.ajax({
            url: url,
            type:"POST",
            success:function (resp) {
                $('#div_tarea').html(resp);
                $("#a_mt").removeClass('active');
                $("#a_ts").removeClass('active');
                $("#a_pt").addClass('active');
            }
        });
    }
</script>
@endsection

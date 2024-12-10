@extends('layouts.plantilla')

@section('navbar')
@endsection

@section('content')
<style>
    svg.warning  {
        color: #e2a03f;
        fill: rgba(233, 176, 43, 0.19);
    }

    svg.primary  {
        color: #2196f3;
        fill: rgba(33, 150, 243, 0.19);
    }

    svg.danger  {
        color: #e7515a;
        fill: rgba(231, 81, 90, 0.19);
    }
    .pegadoleft  {
        padding-left: 0px!important
    }
    .profile-img img  {
        border-radius: 6px;
        background-color: #ebedf2;
        padding: 2px;
        width: 35px;
        height: 35px;
    }
</style>

<?php
    $id_nivel = session('usuario')->id_nivel;
    $id_puesto = session('usuario')->id_puesto;
    $nivel_jerarquico = session('usuario')->nivel_jerarquico;//
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Amonestación</h3>
            </div>
        </div>

        <div class="row layout-top-spacing" id="cancel-row"> 
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                            <?php if($nivel_jerarquico==2 || $nivel_jerarquico==3 || 
                            $nivel_jerarquico==4 || $nivel_jerarquico==5 || $nivel_jerarquico==6 || 
                            $nivel_jerarquico==7 || $id_puesto==195){?> 
                            <li class="nav-item">
                                <a id="bar" class="nav-link" data-toggle="tab" href="#aprobacion" role="tab" aria-controls="home" aria-selected="true" onclick="Amonestaciones_Recibidas()">Recibidas</a>
                            </li>     
                            <?php }?>
                        </ul>
                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_conf_amonestacion" class="widget-content widget-content-area">
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
        $("#mamonestacion").addClass('active');
        $("#hamonestacion").attr('aria-expanded','true');
        $("#amonestaciones").addClass('active');

        Amonestaciones_Recibidas();
    });

    
    function Amonestaciones_Recibidas(){
        Cargando();

        var url="{{ url('Amonestaciones_Recibidas')}}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_conf_amonestacion').html(resp);
                $("#bae").removeClass('active');
                $("#bar").addClass('active');
            }
        });
    }
    
</script>
@endsection

@extends('layouts.plantilla')

@section('navbar')
@include('rrhh.navbar')
@endsection

@section('content')

<div id="content" class="main-content"> 
    <div class="layout-px-spacing"> 
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs mb-3 mt-3" id="simpletab" role="tablist">
                            <?php if(session('usuario')->id_nivel==1 || 
                            session('usuario')->id_puesto==16 || 
                            session('usuario')->id_puesto==20 || 
                            session('usuario')->id_puesto==26 || 
                            session('usuario')->id_puesto==27 || 
                            session('usuario')->id_puesto==148 || 
                            session('usuario')->id_puesto==98 || 
                            session('usuario')->id_puesto==128 || 
                            session('usuario')->id_puesto==31 || 
                            session('usuario')->id_puesto==30 || 
                            session('usuario')->puestos_asignados>0 || 
                            session('usuario')->id_puesto==76 || 
                            session('usuario')->id_puesto==22 || 
                            session('usuario')->visualizar_mi_equipo!="sin_acceso_mi_equipo" || 
                            session('usuario')->id_puesto==314 || 
                            session('usuario')->id_puesto==161 || session('usuario')->id_puesto == 24){ ?>
                                <li class="nav-item">
                                    <a id="a_me" class="nav-link" onclick="Cargar_Mi_Equipo();" style="cursor: pointer;">Mi equipo</a>
                                </li>
                            <?php } ?>
                            <?php if(session('usuario')->id_nivel==1 || 
                            session('usuario')->id_puesto==1 || 
                            session('usuario')->id_puesto==39 || 
                            session('usuario')->id_puesto==80 || 
                            session('usuario')->id_puesto==92){ ?>
                                <li class="nav-item">
                                    <a id="a_meg" class="nav-link" onclick="Cargar_Mi_Equipo_Gerencial();" style="cursor: pointer;">Mi equipo Gerencial</a>
                                </li>
                            <?php } ?>
                        </ul>
                        
                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_mi_equipo" class="widget-content">
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
        $("#hrhumanos").attr('aria-expanded','true');
        $("#equipoo").addClass('active');

        <?php if(session('usuario')->id_nivel==1 || session('usuario')->id_puesto==16 || 
        session('usuario')->id_puesto==20 || session('usuario')->id_puesto==26 || 
        session('usuario')->id_puesto==27 || session('usuario')->id_puesto==98 || 
        session('usuario')->id_puesto==31 || session('usuario')->id_puesto==30 || 
        session('usuario')->puestos_asignados>0 || session('usuario')->id_puesto==76 || 
        session('usuario')->id_puesto==22 || session('usuario')->id_puesto == 24 ||
        session('usuario')->visualizar_mi_equipo!="sin_acceso_mi_equipo" ||
        session('usuario')->id_puesto==314 || session('usuario')->id_puesto==161){ ?>
            Cargar_Mi_Equipo();   
        <?php }else{ ?>
            Cargar_Mi_Equipo_Gerencial();  
        <?php } ?>
    });
    
    function Cargar_Mi_Equipo(){
        Cargando();

        var url="{{ url('MiEquipo/Cargar_Mi_Equipo') }}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_mi_equipo').html(resp);  
                $("#a_me").addClass('active');
                $("#a_meg").removeClass('active');
            }
        });
    }

    function Cargar_Mi_Equipo_Gerencial(){ 
        Cargando();

        var url="{{ url('MiEquipo/Cargar_Mi_Equipo_Gerencial') }}";

        $.ajax({
            url: url,
            type:"POST",
            success:function (resp) {
                $('#div_mi_equipo').html(resp);  
                $("#a_me").removeClass('active');
                $("#a_meg").addClass('active');
            }
        });
    }
</script>

@endsection
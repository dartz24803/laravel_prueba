@extends('layouts.plantilla')

@section('navbar')
@include('rrhh.navbar')
@endsection

@section('content')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3UmC7UDeqnzkxKSDCni7ukFBmqOTc1Us&libraries=places&v=weekly"></script>
<?php
$nivel= session('usuario')->id_nivel;
$editable=$get_id[0]['edicion_perfil'];
$disabled="";
if($get_id[0]['edicion_perfil']==1){
    $disabled="disabled";
}
?>

<style>
    .GFG {
        display: none;
    }

    #familia_tabla{
            overflow-x: hidden;
    }

    .guiones{
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        border: 2px dashed #4d4b4d;
    }

    .guiones2{
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        border: 1px dashed #4d4b4d;

    }

    .fa-plus-circle:before{
        color: #28a745;
    }

    input.archivoInput[type="file"]{
        display: none;
    }

    label.archivoInput2{
        color:white;
        background-image: url('template/assets/img/descarga_img.png');
        background-repeat: no-repeat;
        background-size: 40px 30px;
        background-position: center;
        position:absolute;
        margin: 25px;
        padding-bottom: 25px;
        top:0;
        bottom:0;
        left: 0;
        right:0;
    }

    label.archivoInput4 {
        /* color: white; */
        background-image: url(template/assets/img/descarga_img.png);
        background-repeat: no-repeat;
        background-size: 40px 30px;
        background-position: center;
        position: absolute;
        margin: 25px;
        padding-bottom: 45px;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }

    label.archivoInput5 {
        /* color: white; */
        background-image: url(template/assets/img/descarga_img.png);
        background-repeat: no-repeat;
        background-size: 40px 30px;
        background-position: center;
        position: absolute;
        margin: 25px;
        padding-bottom: 38px;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .general-info .info h6, .about .info h5, .work-platforms .info h5, .contact .info h5, .social .info h5, .skill .info h5, .edu-experience .info h5, .work-experience .info h5 {
        color: #3b3f5c;
        margin: 0px 15px 5px 10px;
        font-weight: 700;
        font-size: 16px;
        text-transform: uppercase;
    }

    label.texto {
        width: 100%;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-top: 1%;
        margin-left: 5px;
    }

    label.texto2 {
        width: 100%;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-top: 1%;
        margin-left: 5px;
    }

    label.texto3 {
        width: 100%;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-top: 1%;
        margin-left: 5px;
    }

    .chico{
        margin-bottom: -50px;
    }

    #map {
        width: 100%;
        height: 500;
    }

    .switch.s-outline[class*="s-outline-"] .slider:before {
        bottom: 1px;
        left: 1px;
        border: 2px solid #7f7f7f;
        background-color: #7f7f7f;
        color: #7f7f7f;
        box-shadow: 0 1px 15px 1px rgba(52, 40, 104, 0.25);
    }

    .switch.s-icons .slider {
        width: 48px;
        height: 25px;
        border-color: #7f7f7f;
    }
</style>

<div id="loading-screen" style="display:none">
    <img src="{{ asset('img/spinning-circles.svg') }}">
</div>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="account-settings-container layout-top-spacing">
            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                    <div class="row">

                        <?php if(session('usuario')->id_nivel=="1" ||
                        session('usuario')->id_puesto=="21" ||
                        session('usuario')->id_puesto=="278" ||
                        session('usuario')->id_puesto=="279" ||
                        session('usuario')->id_puesto=="22" ||
                        session('usuario')->id_nivel=="2" ||
                        session('usuario')->id_puesto=="133" ||
                        session('usuario')->id_puesto=="39" || session('usuario')->id_puesto=="209" || session('usuario')->id_puesto=="310"){ ?>
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="formulario_datos_laborales" class="section general-info">
                                    <input name="id_usuariodl" type="hidden" class="form-control" id="id_usuariodl" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                    <div class="info">
                                        <div class="chico">
                                            <div class="row">
                                                <div class="col">
                                                    <h6 class="">Datos Laborales</h6>
                                                </div>
                                                <div class="col">
                                                    <div class="col-md-12 text-right mb-5">
                                                        <?php if(session('usuario')->id_nivel=="1" ||
                                                                session('usuario')->id_puesto=="21" ||
                                                                session('usuario')->id_puesto=="278" ||
                                                                session('usuario')->id_puesto=="279" ||
                                                                session('usuario')->id_puesto=="22" ||
                                                                session('usuario')->id_nivel=="2" ||
                                                                session('usuario')->id_puesto=="133" ||
                                                                session('usuario')->id_puesto=="39" ||
                                                                session('usuario')->id_puesto=="209"){ ?>
                                                            <a type="button" class="btn btn-success" href="{{ url('ColaboradorController/Mi_Perfil/' . $get_id[0]['id_usuario']) }}">Regresar</a>
                                                        <?php } ?>
                                                        <!--<a onclick="DatosLaborales();"  class="btn btn-primary" title="Datos Laborales" >
                                                        Actualizar
                                                        </a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="edu-section">
                                                    <div class="row" id="datoslaborales">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="id_gerencia">Gerencia</label>
                                                                        <div>
                                                                            <label for="" style="color:black"><b><?php echo $get_id[0]['nom_gerencia'] ?></b></label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="id_gerencia">Departamento/Sub-Gerencia</label>
                                                                        <div>
                                                                            <label for="" style="color:black"><b><?= $get_id[0]['nom_sub_gerencia']; ?></b></label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group" >
                                                                        <label for="id_area">Área</label>
                                                                        <div id="marea">
                                                                            <label for="" style="color:black"><b><?php echo $get_id[0]['nom_area'] ?></b></label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="id_puesto">Puesto</label>
                                                                        <div id="mpuesto">
                                                                            <label for="" style="color:black"><b><?php echo $get_id[0]['nom_puesto'] ?></b></label>
                                                                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ColaboradorController/Modal_Update_Historico_Puesto/'. $get_id[0]['id_usuario']) }}" >
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            <div>
                                                                                <a href="javascrit:void(0)" title="Ver Historial" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('ColaboradorController/Modal_Detalle_Historico_Colaborador/'. $get_id[0]['id_usuario'].'/1') }}" style="color:#1b55e2">Ver historial de puestos (<?php echo $get_id[0]['cant_historico_puesto'] ?>)</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="id_base">Ubicación </label>
                                                                        <div>
                                                                            <label for="" style="color:black"><b><?php echo $get_id[0]['ubicacion'] ?></b></label>
                                                                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ColaboradorController/Modal_Update_Historico_Base_Colaborador/' .$get_id[0]['id_usuario']) }}" >
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            <div>
                                                                                <a href="javascrit:void(0)" title="Ver Historial" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('ColaboradorController/Modal_Detalle_Historico_Colaborador/' .$get_id[0]['id_usuario'].'/2') }}" style="color:#1b55e2">Ver historial (<?php echo $get_id[0]['cant_historico_base'] ?>)</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="id_base">Modalidad Laboral</label>
                                                                        <div>
                                                                            <label for="" style="color:black"><b><?php echo $get_id[0]['nom_modalidad_laboral'] ?></b></label>
                                                                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ColaboradorController/Modal_Update_Historico_Modalidad_Colaborador/' .$get_id[0]['id_usuario']) }}" >
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            <div>
                                                                                <a href="javascrit:void(0)" title="Ver Historial" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('ColaboradorController/Modal_Detalle_Historico_Colaborador/' .$get_id[0]['id_usuario'].'/3') }}" style="color:#1b55e2">Ver historial (<?php echo $get_id[0]['cant_historico_modalidad'] ?>)</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="id_base">Horario</label>
                                                                        <div>
                                                                            <label for="" style="color:black"><b><?php echo $get_id[0]['nom_horario'] ?></b></label>
                                                                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ColaboradorController/Modal_Update_Historico_Horario_Colaborador/' .$get_id[0]['id_usuario']) }}" >
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            <div>
                                                                                <a href="javascrit:void(0)" title="Ver Historial" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('ColaboradorController/Modal_Detalle_Historico_Colaborador/' .$get_id[0]['id_usuario']. '/4') }}" style="color:#1b55e2">Ver historial (<?php echo $get_id[0]['cant_historico_horario'] ?>)</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="id_base">Horas semanales</label>
                                                                        <div>
                                                                            <label for="" style="color:black"><b><?php echo $get_id[0]['horas_semanales']; ?></b></label>
                                                                            <!-- <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= url('ColaboradorController/Modal_Update_Historico_Horas_Semanales_Colaborador') ?>/<?php echo $get_id[0]['id_usuario']; ?>" >
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            <div>
                                                                                <a href="javascrit:void(0)" title="Ver Historial" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="<?= url('ColaboradorController/Modal_Detalle_Historico_Colaborador') ?>/<?php echo $get_id[0]['id_usuario']; ?>/5" style="color:#1b55e2">Ver historial (<?php echo $get_id[0]['cant_historico_horas_semanales'] ?>)</a>
                                                                            </div> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <?php if (session('usuario')->id_nivel=="1" ||
                            session('usuario')->id_puesto=="21" || session('usuario')->id_puesto=="278" || session('usuario')->id_puesto=="279" || session('usuario')->id_puesto=="22" ||
                            session('usuario')->id_puesto=="19" || session('usuario')->id_puesto=="209" || session('usuario')->id_puesto=="310" || session('usuario')->id_puesto==277 ||
                            session('usuario')->id_puesto=="133" || (session('usuario')->id_usuario=="86" && preg_match('/^B[01]/', $get_id[0]['centro_labores']))) { ?>
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="formulario_datos_planilla" class="section general-info">
                                        <div class="info">
                                            <div class="row">
                                                <div class="col">
                                                    <h6 style="margin-bottom: 0px !important;">Datos Planilla</h6>
                                                </div>
                                                <div class="col text-sm-right text-center">
                                                    @csrf
                                                    <a title="Agregar Dato Planilla" 
                                                    class="btn btn-danger" title="Registrar" 
                                                    onclick="Valida_Planilla_Activa('{{ $get_id[0]['id_usuario'] }}')">
                                                        Agregar
                                                    </a>
                                                    <!-- Boton modal nuevo dato planilla-->
                                                    <a style="display:none" id="btn_registrar_planilla" class="btn btn-danger" title="Registrar" data-toggle="modal" data-target="#ModalRegistro"
                                                        app_reg="{{ url('ColaboradorController/Modal_Dato_Planilla/' . $get_id[0]['id_usuario']) }}">
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <div class="row" id="parte_superior_pl">
                                            </div>

                                            <div class="row" id="parte_inferior_pl">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>

                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="form_bienvenida" class="section general-info">
                                    <div class="info">
                                        <div class="chico">
                                            <div class="row">
                                                <div class="col">
                                                    <h6 class="">ENVÍO DE CORREO BIENVENIDA</h6>
                                                </div>
                                                <div class="col">
                                                    <?php if($get_id[0]['correo_bienvenida'] == null || $get_id[0]['correo_bienvenida'] == ''){ ?>
                                                    <div class="col-md-12 text-right mb-5" id="div_enviar_correo_bienvenida">
                                                        <button type="button" title="Enviar correo" id="btn_enviar_correo1" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('ColaboradorController/Modal_Enviar_Correo_Bienvenida/'. $get_id[0]['id_usuario']) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                        </button>
                                                    </div>
                                                    <?php }else{?>
                                                    <div class="col-md-12 text-right mb-5" id="div_enviar_correo_bienvenida">
                                                        <button type="button" title="Correo enviado" id="btn_enviar_correo1" class="btn btn-gray" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('ColaboradorController/Modal_Enviar_Correo_Bienvenida/'. $get_id[0]['id_usuario']) }}" disabled>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                        </button>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="form_accesos" class="section general-info">
                                    <div class="info">
                                        <div class="chico">
                                            <div class="row">
                                                <div class="col">
                                                    <h6 class="">ACCESOS</h6>
                                                </div>
                                                <div class="col">
                                                    <?php if($get_id[0]['accesos_email'] == null || $get_id[0]['accesos_email'] == ''){ ?>
                                                    <div class="col-md-12 text-right mb-5" id="div_enviar_correo">
                                                        <button type="button" title="Enviar correo" id="btn_enviar_correo2" class="btn btn-danger" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="<?= url('ColaboradorController/Modal_Enviar_Correo_Colaborador') ?>/<?php echo $get_id[0]['id_usuario']; ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                        </button>
                                                    </div>
                                                    <?php }else{?>
                                                    <div class="col-md-12 text-right mb-5" id="div_enviar_correo">
                                                        <button type="button" title="Correo enviado" id="btn_enviar_correo2" class="btn btn-gray" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="<?= url('ColaboradorController/Modal_Enviar_Correo_Colaborador') ?>/<?php echo $get_id[0]['id_usuario']; ?>" disabled>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                        </button>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="table-responsive" id="mddatoplanilla">
                                                    <table class="table" id="tableMain3">
                                                        <thead>
                                                            <tr class="tableheader">
                                                                <th>DATACORP</th>
                                                                <th>PÁGINAS WEB</th>
                                                                <th>PROGRAMAS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <?php
                                                                        $accesos = array_column($list_accesos_datacorp->toArray(), 'carpeta_acceso');
                                                                        echo implode(', ', $accesos);
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        $accesos = array_column($list_accesos_paginas_web->toArray(), 'pagina_acceso');
                                                                        echo implode(', ', $accesos);
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    OFFICE,
                                                                    <?php
                                                                        $accesos = array_column($list_accesos_programas->toArray(), 'programa');
                                                                        echo implode(', ', $accesos);
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <?php if(session('usuario')->id_nivel=="1" ||
                            session('usuario')->id_puesto=="21" ||
                            session('usuario')->id_puesto=="278" ||
                            session('usuario')->id_puesto=="279" ||
                            session('usuario')->id_nivel=="2" ||
                            session('usuario')->id_puesto=="133" ||
                            session('usuario')->id_puesto=="39"){ ?>
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="formulario_adjuntar_documentacionrrhh" class="section general-info">
                                    <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                        <div class="info">
                                                <div class="chico">
                                                <div class="row">
                                                    <div class="col">
                                                        <h6 class="">Documentación RRHH</h6>
                                                    </div>
                                                    <div class="col">
                                                        <div class="col-md-12 text-right mb-5">
                                                            <a onclick="Adjuntar_DocumentacionRRHH();" title="Adjuntar Documentación" class="btn btn-primary">
                                                            Actualizar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 mx-auto">
                                                    <div class="edu-section">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row" id="adjuntar_documentacionrrhh">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="dni_img">Carta Renuncia</label>
                                                                            <?php if(isset($get_id_documentacion[0]['carta_renuncia']) && $get_id_documentacion[0]['carta_renuncia']!="" ) {
                                                                                $image_info = get_headers($url_docrrhh[0]['url_config'].$get_id_documentacion[0]['carta_renuncia']);
                                                                                if (strpos($image_info[0], '200') !== false) {?>
                                                                                    <a style="cursor:pointer;display: -webkit-inline-box;" data-title="Carta Renuncia" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_docrrhh[0]['url_config'].$get_id_documentacion[0]['carta_renuncia']; ?>" ><svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/></svg></a>
                                                                                <?php } } ?>
                                                                            <input type="file" class="form-control-file" id="carta_renuncia" name="carta_renuncia" onchange="return validarcartarenuncia()" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="dni_img">Eval. Psicologica</label>
                                                                            <?php if(isset($get_id_documentacion[0]['eval_sicologico']) && $get_id_documentacion[0]['eval_sicologico']!="") {
                                                                                $image_info = get_headers($url_docrrhh[0]['url_config'].$get_id_documentacion[0]['eval_sicologico']);
                                                                                if (strpos($image_info[0], '200') !== false) {?>
                                                                                    <a style="cursor:pointer;display: -webkit-inline-box;" data-title="Evaluación Psicologica" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_docrrhh[0]['url_config'].$get_id_documentacion[0]['eval_sicologico']; ?>" ><svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></a>
                                                                                <?php } } ?>
                                                                            <input type="file" class="form-control-file" id="eval_sicologico" name="eval_sicologico"  onchange="return validareval_psicolo()">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="dni_img">Convenio Laboral</label>
                                                                            <?php if(isset($get_id_documentacion[0]['convenio_laboral']) && $get_id_documentacion[0]['convenio_laboral']!=""){
                                                                                $image_info = get_headers($url_docrrhh[0]['url_config'].$get_id_documentacion[0]['convenio_laboral']);
                                                                                if (strpos($image_info[0], '200') !== false) {?>
                                                                                    <a style="cursor:pointer;display: -webkit-inline-box;" data-title="Convenio Laboral" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_docrrhh[0]['url_config'].$get_id_documentacion[0]['convenio_laboral'] ?>" >
                                                                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                                                    </a>
                                                                                <?php } } ?>
                                                                            <input type="file" class="form-control-file" id="convenio_laboral" name="convenio_laboral"  onchange="return validarfileconvenio_laboral()"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                        <?php } ?>

                        <?php if(session('usuario')->sede_laboral=="OFC"){ ?>
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form id="directorio_telefonico" class="section general-info">
                                    <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                    <div class="info">
                                        <div class="chico">
                                            <div class="row">
                                                <div class="col">
                                                    <h6 class="">Directorio Telefonico</h6>
                                                </div>
                                                <div class="col">
                                                    <div class="col-md-12 text-right mb-5">
                                                        <a onclick="Actualizar_DirectorioT();" title="Agregar o editar directorio" class="btn btn-primary">
                                                        Actualizar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <div class="edu-section">
                                                    <div class="row">
                                                        <div class="col-md-12" id="direct_telefonico">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="nacionalidad">¿Tiene directorio Telefonico?</label>
                                                                        <select class="form-control" id="id_respuesta_directorio_telefonico" name="id_respuesta_directorio_telefonico" onchange="Valida_DirectorioT();">
                                                                        <option value="0">Seleccione</option>
                                                                        <option value="1" <?php if(isset($list_usuario['0']['directorio']) && $list_usuario[0]['directorio'] == 1){ echo "selected";} ?>>SÍ</option>
                                                                        <option value="2" <?php if(isset($list_usuario['0']['directorio']) && $list_usuario[0]['directorio'] == 2){ echo "selected";} ?>>NO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="dni_hijo">Celular corporativo</label>
                                                                        <input type="text" <?php if($get_id[0]['directorio'] == 2){echo "disabled";}?>  class="form-control mb-4" id="num_cele" value="<?php echo $get_id['0']['num_cele'];?>" name="num_cele">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="dni_hijo">Teléfono fijo corporativo</label>
                                                                        <input type="text" <?php if($get_id[0]['directorio'] == 2){echo "disabled";}?>  class="form-control mb-4" id="num_fijoe" value="<?php echo $get_id['0']['num_fijoe'];?>" name="num_fijoe">
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label for="dni_hijo">Nùmero de Anexo</label>
                                                                        <input type="text" <?php if($get_id[0]['directorio'] == 2){echo "disabled";}?>  class="form-control mb-4" id="num_anexoe" value="<?php echo $get_id['0']['num_anexoe'];?>" name="num_anexoe">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="dni_hijo">Email Corporativo</label>
                                                                        <input type="text" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" <?php if($get_id[0]['directorio'] == 2){echo "disabled";}?>  class="form-control mb-4" id="emailp" value="<?php echo $get_id[0]['emailp'];?>" name="emailp">
                                                                    </div>
                                                                </div>



                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>

                        <?php if(session('usuario')->id_nivel==1 || session('usuario')->id_nivel==2 || session('usuario')->id_puesto==133 || session('usuario')->id_puesto==209){ ?>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div style="display: inline-flex;float: right;">
                                    <label class="switch s-icons s-outline s-outline-success">
                                        <input type="checkbox" <?php if($get_id[0]['edicion_perfil']==0){echo "checked";} ?>  value="1" id="habilitar_edicion" name="habilitar_edicion" onchange="Habilitar_Edicion_Perfil('<?php echo $get_id[0]['id_usuario']; ?>');" href="javascript:void(0);">
                                        <span class="slider round"></span>
                                    </label>Habilitar edición&nbsp;
                                    <a onclick="Confirmar_Revision_Perfil('<?php echo $get_id[0]['id_usuario']; ?>');" style="margin-top: -10px;margin-bottom: 11px;display:<?php if($get_id[0]['edicion_perfil']==1 && $get_id[0]['perf_revisado']==0){echo "block;";}else{echo "none;";}?>" class="btn btn-success" title="Confirmar revisión">
                                        Confirmar revisión
                                    </a>
                                    <span class="badge badge-success" style="height: fit-content;display:<?php if($get_id[0]['perf_revisado']==1 && $get_id[0]['edicion_perfil']==1){echo "block;";}else{echo "none;";}?>">Revisado</span>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="edatos" enctype="multipart/form-data" class="section general-info">
                                <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <input type="hidden" id="foto_nombre" name="foto_nombre" value="<?php echo $get_id[0]['foto_nombre'] ?>">

                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Datos Personales</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                    <?php if($editable==0){?>
                                                    <a onclick="GDatosP();" class="btn btn-primary" title="Actualizar Datos Personales">
                                                        Actualizar
                                                    </a>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-12 col-md-4">
                                                    <div class="upload mt-4 pr-md-4">
                                                        <input type="file" id="foto" name="foto" class="dropify" data-allowed-file-extensions="png jpg jpeg"
                                                            data-default-file="
                                                            <?php if($get_id[0]['foto']!= ""){
                                                                $image_info = get_headers($get_id[0]['foto']);
                                                                    if (strpos($image_info[0], '200') !== false) {
                                                                        echo $get_id[0]['foto'];
                                                                    }else{
                                                                        echo asset("template/assets/img/200x200.jpg");
                                                                    }
                                                                }else {
                                                                    echo asset("template/assets/img/200x200.jpg");
                                                                } ?>"
                                                            data-max-file-size="5M" onchange="return Validar_Archivo_Img_Perfil('foto')" <?php echo $disabled ?>
                                                        />
                                                        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i>Cargar Foto</p>
                                                    </div>
                                                </div>
                                                <div id="mdatos" class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="usuario_apater">Apellido Paterno</label>
                                                                    <input type="text" class="form-control mb-4" maxlength = "30" id="usuario_apater" name="usuario_apater" value="<?php echo $get_id['0']['usuario_apater'];?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="usuario_amater">Apellido Materno</label>
                                                                    <input type="text" class="form-control mb-4"maxlength = "30" id="usuario_amater" name="usuario_amater" value="<?php echo $get_id['0']['usuario_amater'];?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="usuario_nombres">Nombres</label>
                                                                    <input type="text" class="form-control mb-4" maxlength = "30" id="usuario_nombres" name="usuario_nombres" value="<?php echo $get_id['0']['usuario_nombres'];?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="id_nacionalidad">Nacionalidad</label>
                                                                    <select class="form-control" name="id_nacionalidad" id="id_nacionalidad" <?php echo $disabled ?>>
                                                                    <option value="0"  <?php if (!(strcmp(0, $get_id[0]['id_nacionalidad']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                                                                    <?php foreach($list_nacionalidad_perfil as $list){ ?>
                                                                    <option value="<?php echo $list['id_nacionalidad']; ?>" <?php if (!(strcmp($list['id_nacionalidad'], $get_id[0]['id_nacionalidad']))) {echo "selected=\"selected\"";} ?> >
                                                                    <?php echo $list['nom_nacionalidad'];?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="genero">Genero</label>
                                                                    <select class="form-control" name="id_genero" id="id_genero" <?php echo $disabled ?>>
                                                                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_genero']))) {echo "selected=\"selected\"";} ?> >Seleccione</option>
                                                                    <?php foreach($list_genero as $list){ ?>
                                                                    <option value="<?php echo $list['id_genero'] ; ?>" <?php if (!(strcmp($list['id_genero'], $get_id[0]['id_genero']))) {echo "selected=\"selected\"";} ?> >
                                                                    <?php echo $list['nom_genero'];?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="fullName">Tipo de documento</label>
                                                                    <select class="form-control" name="id_tipo_documento" id="id_tipo_documento" <?php echo $disabled ?>>
                                                                    <option value="0"  <?php if (!(strcmp(0, $get_id[0]['id_tipo_documento']))) {echo "selected=\"selected\"";} ?> >Seleccione</option>
                                                                    <?php foreach($list_tipo_documento as $list){ ?>
                                                                    <option value="<?php echo $list['id_tipo_documento'] ; ?>" <?php if (!(strcmp($list['id_tipo_documento'], $get_id[0]['id_tipo_documento']))) {echo "selected=\"selected\"";} ?> >
                                                                    <?php echo $list['cod_tipo_documento'];?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="num_doc">Número de documento</label>
                                                                    <input type="number" class="form-control mb-4" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength = "8" id="num_doc" name="num_doc" value="<?php echo $get_id[0]['num_doc']; ?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label>Fecha Emisión:</label>
                                                                    <input type="date" class="form-control" id="fec_emision" name="fec_emision" value="<?php echo $get_id[0]['fec_emision_doc']; ?>" placeholder="Ingresar Fecha de Ingreso" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label>Fecha Vencimiento:</label>
                                                                    <input type="date" class="form-control" id="fec_venci" name="fec_venci" value="<?php echo $get_id[0]['fec_vencimiento_doc']; ?>" placeholder="Ingresar Fecha de Ingreso" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label class="dob-input">Fecha de Nacimiento</label>
                                                                <div class="d-sm-flex d-block">
                                                                    <div class="form-group mr-1">
                                                                        <select class="form-control" id="dia_nac" name="dia_nac" <?php echo $disabled ?>>
                                                                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['dia_nac']))) {echo "selected=\"selected\"";} ?> >Día</option>
                                                                        <?php foreach($list_dia as $list){ ?>
                                                                        <option value="<?php echo $list['cod_dia'] ; ?>" <?php if (!(strcmp($list['cod_dia'], $get_id[0]['dia_nac']))) {echo "selected=\"selected\"";} ?> >
                                                                        <?php echo $list['cod_dia'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-1">
                                                                        <select class="form-control" id="mes_nac" name="mes_nac" <?php echo $disabled ?>>
                                                                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['mes_nac']))) {echo "selected=\"selected\"";} ?> >Mes</option>
                                                                        <?php foreach($list_mes as $list){ ?>
                                                                        <option value="<?php echo $list['cod_mes'] ; ?>" <?php if (!(strcmp($list['cod_mes'], $get_id[0]['mes_nac']))) {echo "selected=\"selected\"";} ?> >
                                                                        <?php echo $list['abr_mes'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-1">
                                                                        <select class="form-control" id="anio_nac" name="anio_nac" <?php echo $disabled ?>>
                                                                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['anio_nac']))) {echo "selected=\"selected\"";} ?> >Año</option>
                                                                        <?php foreach($list_anio as $list){ ?>
                                                                        <option value="<?php echo $list['cod_anio'] ; ?>" <?php if (!(strcmp($list['cod_anio'], $get_id[0]['anio_nac']))) {echo "selected=\"selected\"";} ?> >
                                                                        <?php echo $list['cod_anio'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <label for="usuario_email">Edad</label>
                                                                    <input type="text" class="form-control" readonly id="cedad" name="cedad" >

                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="estado_civil">Estado Civil</label>
                                                                    <select class="form-control" id="id_estado_civil" name="id_estado_civil" <?php echo $disabled ?>>
                                                                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_estado_civil']))) {echo "selected=\"selected\"";} ?> >Seleccione</option>
                                                                    <?php foreach($list_estado_civil as $list){ ?>
                                                                    <option value="<?php echo $list['id_estado_civil'] ; ?>" <?php if (!(strcmp($list['id_estado_civil'], $get_id[0]['id_estado_civil']))) {echo "selected=\"selected\"";} ?> >
                                                                    <?php echo $list['nom_estado_civil'];?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <label for="usuario_email">Correo Electrónico</label>
                                                                    <input type="text" class="form-control mb-4" maxlength = "100" id="usuario_email" name="usuario_email" value="<?php echo $get_id[0]['usuario_email']; ?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>


                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="num_celp">Número celular</label>
                                                                    <input type="number" class="form-control mb-4" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength = "9"  id="num_celp" name="num_celp" value="<?php echo $get_id[0]['num_celp']; ?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="num_fijop">Teléfono fijo</label>
                                                                    <input type="number" class="form-control mb-4" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength = "15" id="num_fijop" name="num_fijop" value="<?php echo $get_id[0]['num_fijop']; ?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <!--<div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="gusto_personales">Gustos o Preferencias personales</label>
                                                                    <input type="text" class="form-control mb-4" id="gusto_personales" placeholder="Platos favoritos, pasatiempos, y gustos variados" name="gusto_personales" value="<?php echo $get_id[0]['gusto_personales']; ?>">
                                                                </div>
                                                            </div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_gustop" class="section general-info">
                                <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div id="gustop_titulo" class="col">
                                                <h6 class="">Gustos y Preferencias</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                <?php if($editable==0){?>
                                                    <a onclick="GustosP();"  class="btn btn-primary" title="Gustos y Preferencias" >
                                                    Actualizar
                                                    </a>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                </br>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row" id="gustopdatos">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="plato_postre">Plato y postre favorito</label>
                                                                    <input type="text" class="form-control mb-4" id="plato_postre" name="plato_postre" value="<?php if(isset($get_id_gp['0']['plato_postre'])) {echo $get_id_gp['0']['plato_postre'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="galletas_golosinas">Galletas y golosinas favoritas</label>
                                                                    <input type="text" class="form-control mb-4" id="galletas_golosinas" name="galletas_golosinas" value="<?php if(isset($get_id_gp['0']['galletas_golosinas'])) {echo $get_id_gp['0']['galletas_golosinas'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="ocio_pasatiempos">Actividades de ocio o pasatiempos</label>
                                                                    <input type="text" class="form-control mb-4" id="ocio_pasatiempos" name="ocio_pasatiempos" value="<?php if(isset($get_id_gp['0']['ocio_pasatiempos'])) {echo $get_id_gp['0']['ocio_pasatiempos'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="artistas_banda">Artistas o banda favorito</label>
                                                                    <input type="text" class="form-control mb-4" id="artistas_banda" name="artistas_banda" value="<?php if(isset($get_id_gp['0']['artistas_banda'])) {echo $get_id_gp['0']['artistas_banda'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="genero_musical">Género musical favorito</label>
                                                                    <input type="text" class="form-control mb-4" id="genero_musical" name="genero_musical" value="<?php if(isset($get_id_gp['0']['genero_musical'])) {echo $get_id_gp['0']['genero_musical'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="pelicula_serie">Película o serie favorita</label>
                                                                    <input type="text" class="form-control mb-4" id="pelicula_serie" name="pelicula_serie" value="<?php if(isset($get_id_gp['0']['pelicula_serie'])) {echo $get_id_gp['0']['pelicula_serie'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="colores_favorito">Colores favoritos</label>
                                                                    <input type="text" class="form-control mb-4" id="colores_favorito" name="colores_favorito" value="<?php if(isset($get_id_gp['0']['colores_favorito'])) {echo $get_id_gp['0']['colores_favorito'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="redes_sociales">Redes sociales favoritas</label>
                                                                    <input type="text" class="form-control mb-4" id="redes_sociales" name="redes_sociales" value="<?php if(isset($get_id_gp['0']['redes_sociales'])) {echo $get_id_gp['0']['redes_sociales'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="deporte_favorito">Deporte favorito</label>
                                                                    <input type="text" class="form-control mb-4" id="deporte_favorito" name="deporte_favorito" value="<?php if(isset($get_id_gp['0']['deporte_favorito'])) {echo $get_id_gp['0']['deporte_favorito'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="tiene_mascota">¿Tiene mascota?</label>
                                                                    <select class="form-control" name="tiene_mascota" id="tiene_mascota" <?php echo $disabled ?>>
                                                                    <option value="0" <?php if(isset($get_id_gp[0]['tiene_mascota']) && $get_id_gp[0]['tiene_mascota'] == 0){ echo "selected";} ?>>Seleccione</option>
                                                                    <option value="1" <?php if(isset($get_id_gp[0]['tiene_mascota']) && $get_id_gp[0]['tiene_mascota'] == 1){ echo "selected";} ?>>SÍ</option>
                                                                    <option value="2" <?php if(isset($get_id_gp[0]['tiene_mascota']) && $get_id_gp[0]['tiene_mascota'] == 2){ echo "selected";} ?>>NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="mascota">Qué mascota tienes?</label>
                                                                    <input type="text" class="form-control mb-4" id="mascota" name="mascota" value="<?php if(isset($get_id_gp['0']['mascota'])) {echo $get_id_gp['0']['mascota'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_domicilio" class="section general-info">
                                <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div id="domicilio_titulo" class="col">
                                                <h6 class="">Domicilio

                                                    <?php if(isset($get_id_d['0']['lat']) && isset($get_id_d['0']['lng'])){?>
                                                        <a style="display: -webkit-inline-box;" href="https://www.google.com/maps/search/?api=1&query=<?php if(isset($get_id_d['0']['lat'])) {echo $get_id_d['0']['lat'];}?>,<?php if(isset($get_id_d['0']['lng'])) {echo $get_id_d['0']['lng'];}?>&zoom=20" target="_blank">
                                                            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 100 100" width="40px" height="40px" style="margin-bottom: 6px;" ><path fill="#60be92" d="M81,76.667V23.333C81,20.388,78.612,18,75.667,18H22.333C19.388,18,17,20.388,17,23.333v53.333	C17,79.612,19.388,82,22.333,82h53.333C78.612,82,81,79.612,81,76.667z"/><path fill="#78a2d2" d="M22.769,81.999l52.461,0L48.999,55.768L22.769,81.999z"/><path fill="#ceccbe" d="M80.999,76.23l0-52.461L54.768,49.999L80.999,76.23z"/><path fill="#f9e65c" d="M75.666,17.5h-0.643L16.5,76.023v0.643c0,3.217,2.617,5.833,5.833,5.833h0.643l58.523-58.523v-0.643	C81.499,20.116,78.882,17.5,75.666,17.5z"/><path fill="#1f212b" d="M22.976,82.499h-0.643c-3.216,0-5.833-2.616-5.833-5.833v-0.643L75.023,17.5h0.643	c3.217,0,5.833,2.616,5.833,5.833v0.643L22.976,82.499z M17.5,76.438v0.229c0,2.665,2.168,4.833,4.833,4.833h0.229l57.938-57.938	v-0.229c0-2.665-2.168-4.833-4.833-4.833h-0.229L17.5,76.438z"/><path fill="#fff" d="M55.426,49.949l-6.476,6.477l26.073,26.073h0.643c3.217,0,5.833-2.616,5.833-5.833v-0.643	L55.426,49.949z"/><path fill="#1f212b" d="M75.667,83H22.333C18.841,83,16,80.159,16,76.667V23.333C16,19.841,18.841,17,22.333,17h53.333	C79.159,17,82,19.841,82,23.333v53.334C82,80.159,79.159,83,75.667,83z M22.333,19C19.944,19,18,20.943,18,23.333v53.334	C18,79.057,19.944,81,22.333,81h53.333C78.056,81,80,79.057,80,76.667V23.333C80,20.943,78.056,19,75.667,19H22.333z"/><path fill="#f15b6c" d="M70.5,67.5c0.552,0,1-0.448,1-1c0-2.5,1.5-9,5.875-16C81.09,44.556,88.5,38,88.5,29.5	c0-9.941-8.059-18-18-18s-18,8.059-18,18c0,8.5,7.41,15.056,11.125,21C68,57.5,69.5,64,69.5,66.5C69.5,67.052,69.948,67.5,70.5,67.5	z"/><circle cx="70.5" cy="29.5" r="7" fill="#b07454"/><path fill="#1f212b" d="M70.5,68c-0.827,0-1.5-0.673-1.5-1.5c0-2.496-1.574-8.976-5.799-15.735	c-0.975-1.56-2.206-3.16-3.51-4.854C56.086,41.223,52,35.911,52,29.5C52,19.299,60.299,11,70.5,11S89,19.299,89,29.5	c0,6.411-4.086,11.723-7.691,16.41c-1.304,1.694-2.535,3.295-3.51,4.854C73.574,57.524,72,64.004,72,66.5	C72,67.327,71.327,68,70.5,68z M70.5,12C60.851,12,53,19.851,53,29.5c0,6.07,3.976,11.239,7.484,15.801	c1.319,1.714,2.564,3.334,3.565,4.935C68.415,57.221,70,63.789,70,66.5c0,0.275,0.224,0.5,0.5,0.5s0.5-0.225,0.5-0.5	c0-2.711,1.585-9.279,5.951-16.265c1-1.601,2.246-3.221,3.565-4.935C84.024,40.739,88,35.57,88,29.5C88,19.851,80.149,12,70.5,12z"/><path fill="#1f212b" d="M70.5,37c-4.136,0-7.5-3.364-7.5-7.5s3.364-7.5,7.5-7.5s7.5,3.364,7.5,7.5S74.636,37,70.5,37z M70.5,23c-3.584,0-6.5,2.916-6.5,6.5s2.916,6.5,6.5,6.5s6.5-2.916,6.5-6.5S74.084,23,70.5,23z"/><path fill="#1f212b" d="M73.5,49.688c-0.087,0-0.176-0.022-0.256-0.071c-0.237-0.142-0.314-0.448-0.173-0.686l0.157-0.266	c0.108-0.184,0.216-0.367,0.331-0.551c1.102-1.762,2.402-3.453,3.779-5.244C80.617,38.608,84,34.211,84,29.5	c0-3.163-1.13-6.244-3.184-8.678c-0.178-0.211-0.151-0.526,0.06-0.704c0.211-0.179,0.526-0.151,0.705,0.06	C83.786,22.791,85,26.102,85,29.5c0,5.051-3.488,9.586-6.862,13.971c-1.369,1.78-2.655,3.452-3.731,5.174	c-0.11,0.176-0.213,0.353-0.317,0.528l-0.161,0.271C73.835,49.601,73.669,49.688,73.5,49.688z"/><path fill="#1f212b" d="M72.5,16.16c-0.024,0-0.048-0.002-0.072-0.005C71.697,16.049,71.084,16,70.5,16	c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5c0.633,0,1.292,0.053,2.072,0.165c0.273,0.04,0.462,0.293,0.423,0.566	C72.959,15.98,72.745,16.16,72.5,16.16z"/><path fill="#1f212b" d="M78.5,18.523c-0.099,0-0.199-0.029-0.286-0.09c-1.183-0.826-2.48-1.453-3.857-1.864	c-0.265-0.079-0.415-0.358-0.336-0.623s0.356-0.412,0.622-0.336c1.479,0.442,2.873,1.116,4.143,2.003	c0.227,0.158,0.282,0.47,0.124,0.696C78.813,18.449,78.657,18.523,78.5,18.523z"/><path fill="#1f212b" d="M75.666,82.499h-0.643l-26.73-26.73l6.476-6.477l12.085,12.086c0.195,0.195,0.195,0.512,0,0.707	s-0.512,0.195-0.707,0L54.768,50.706l-5.062,5.063l25.73,25.73h0.229c2.665,0,4.833-2.168,4.833-4.833v-0.229l-7.353-7.353	c-0.195-0.195-0.195-0.512,0-0.707s0.512-0.195,0.707,0l7.646,7.646v0.643C81.499,79.883,78.882,82.499,75.666,82.499z"/><path fill="#fff" d="M41.368,31.5h-1.113H32.5v4h4.395c-0.911,1.78-2.758,3-4.895,3c-3.038,0-5.5-2.462-5.5-5.5	c0-3.038,2.462-5.5,5.5-5.5c1.413,0,2.698,0.538,3.672,1.413l2.828-2.828l0,0C36.8,24.486,34.518,23.5,32,23.5	c-5.247,0-9.5,4.253-9.5,9.5s4.253,9.5,9.5,9.5c4.38,0,8.058-2.968,9.156-7c0.217-0.798,0.344-1.633,0.344-2.5	C41.5,32.488,41.447,31.99,41.368,31.5z"/><path fill="#1f212b" d="M32,43c-5.514,0-10-4.486-10-10s4.486-10,10-10c2.547,0,4.977,0.966,6.843,2.721	c0.099,0.093,0.156,0.222,0.158,0.356c0.002,0.136-0.051,0.266-0.146,0.361l-2.829,2.828c-0.188,0.188-0.491,0.194-0.688,0.019	C34.416,28.456,33.231,28,32,28c-2.757,0-5,2.243-5,5s2.243,5,5,5c1.595,0,3.061-0.749,3.996-2H32.5c-0.276,0-0.5-0.224-0.5-0.5v-4	c0-0.276,0.224-0.5,0.5-0.5h8.868c0.245,0,0.455,0.178,0.494,0.42C41.955,31.995,42,32.513,42,33c0,0.867-0.122,1.753-0.361,2.632	C40.456,39.97,36.493,43,32,43z M32,24c-4.962,0-9,4.037-9,9s4.038,9,9,9c4.043,0,7.61-2.727,8.674-6.632	C40.89,34.575,41,33.778,41,33c0-0.313-0.021-0.644-0.065-1H33v3h3.895c0.174,0,0.336,0.091,0.427,0.239s0.098,0.334,0.019,0.488	C36.307,37.746,34.261,39,32,39c-3.309,0-6-2.691-6-6s2.691-6,6-6c1.32,0,2.596,0.437,3.641,1.237l2.131-2.131	C36.15,24.744,34.12,24,32,24z"/></svg>
                                                        </a>
                                                    <?php }else{?>
                                                    <?php }?>

                                                </h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                <?php if($editable==0){?>
                                                    <a onclick="DomilcilioP();"  class="btn btn-primary" title="Domicilio" >
                                                    Actualizar
                                                    </a>
                                                <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row" id="domiciliodatos">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="id_departamento">Departamento</label>
                                                                    <select class="form-control" name="id_departamento" id="id_departamento" onchange="provincia()" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccion</option>
                                                                        <?php foreach($list_departamento as $list){
                                                                            if(isset($get_id_d[0]) && $get_id_d[0]['id_departamento'] == $list->id_departamento){ ?>
                                                                            <option selected value="<?php echo $list->id_departamento; ?>"><?php echo $list->nombre_departamento;?></option>
                                                                        <?php }else{?>
                                                                        <option value="<?php echo $list->id_departamento; ?>"><?php echo $list->nombre_departamento;?></option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group" >
                                                                    <label for="id_provincia">Provincia</label>
                                                                    <div id="mprovincia">
                                                                        <select class="form-control" name="id_provincia" id="id_provincia"  onchange="distrito()" <?php echo $disabled ?>>
                                                                        <option  value="0"  selected>Seleccionar</option>
                                                                        <?php
                                                                            foreach($list_provincia as $list){ ?>
                                                                                <option value="<?php echo $list->id_provincia; ?>"
                                                                                <?php if(empty($get_id_d[0]) && $get_id_d[0]['id_provincia'] == $list->id_provincia){ echo "selected"; } ?>>
                                                                                    <?php echo $list->nombre_provincia;?>
                                                                                </option>
                                                                            <?php }
                                                                        ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="id_distrito">Distrito</label>
                                                                    <div id="mdistrito">
                                                                        <select class="form-control" name="id_distrito" id="id_distrito" <?php echo $disabled ?>>
                                                                        <option  value="0"  selected>Seleccionar</option>
                                                                        <?php
                                                                            foreach($list_distrito as $list){ ?>
                                                                                <option value="<?php echo $list->id_distrito; ?>"
                                                                                <?php if(empty($get_id_d[0]) && $get_id_d[0]['id_distrito'] == $list->id_distrito){ echo "selected"; } ?>>
                                                                                    <?php echo $list->nombre_distrito;?>
                                                                                </option>
                                                                            <?php }
                                                                        ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="id_tipo_via">Tipo de vía</label>
                                                                    <select class="form-control" name="id_tipo_via" id="id_tipo_via" <?php echo $disabled ?>>
                                                                    <option  value="0"  selected>Seleccionar</option>
                                                                    <?php foreach($list_dtipo_via as $list){
                                                                    if(isset($get_id_d[0]) && $get_id_d[0]['id_tipo_via'] == $list['id_tipo_via']){ ?>
                                                                    <option selected value="<?php echo $list['id_tipo_via']; ?>"><?php echo $list['nom_tipo_via'];?></option>
                                                                    <?php }else{?>
                                                                    <option value="<?php echo $list['id_tipo_via']; ?>"><?php echo $list['nom_tipo_via'];?></option>
                                                                    <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="nom_via">Nombre de vía</label>
                                                                    <input type="text" class="form-control mb-4" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength = "100" id="nom_via" name="nom_via" value="<?php if(isset($get_id_d['0']['nom_via'])) {echo $get_id_d['0']['nom_via'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="num_via">Número de vía</label>
                                                                    <input type="text" class="form-control mb-4" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength = "5" id="num_via" name="num_via" value="<?php if(isset($get_id_d['0']['num_via'])) {echo $get_id_d['0']['num_via'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="num_via">KM</label>
                                                                    <input type="text" class="form-control mb-4"  maxlength = "5" id="kilometro" name="kilometro" value="<?php if(isset($get_id_d['0']['kilometro'])) {echo $get_id_d['0']['kilometro'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="num_via">MZ</label>
                                                                    <input type="text" class="form-control mb-4"  maxlength = "5" id="manzana" name="manzana" value="<?php if(isset($get_id_d['0']['manzana'])) {echo $get_id_d['0']['manzana'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="num_vivo_en">Interior</label>
                                                                    <input type="text" class="form-control mb-4"  maxlength = "5" id="interior" name="interior" value="<?php if(isset($get_id_d['0']['interior'])) {echo $get_id_d['0']['interior'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="num_vivo_en">N° Departamento</label>
                                                                    <input type="text" class="form-control mb-4"  maxlength = "5" id="departamento" name="departamento" value="<?php if(isset($get_id_d['0']['departamento'])) {echo $get_id_d['0']['departamento'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label for="num_vivo_en">Lote</label>
                                                                    <input type="text" class="form-control mb-4"  maxlength = "5" id="lote" name="lote" value="<?php if(isset($get_id_d['0']['lote'])) {echo $get_id_d['0']['lote'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                    <label for="num_vivo_en">Piso</label>
                                                                    <input type="text" class="form-control mb-4"  maxlength = "2" id="piso" name="piso" value="<?php if(isset($get_id_d['0']['piso'])) {echo $get_id_d['0']['piso'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="id_vivo_en">Tipo de Zona</label>
                                                                    <select class="form-control" name="id_zona" id="id_zona" <?php echo $disabled ?>>
                                                                    <option  value="0"  selected>Seleccionar</option>
                                                                    <?php foreach($list_zona as $list){
                                                                    if(isset($get_id_d[0]) && $get_id_d[0]['id_zona'] == $list['id_zona']){ ?>
                                                                    <option selected value="<?php echo $list['id_zona']; ?>"><?php echo $list['nom_zona'];?></option>
                                                                    <?php }else{?>
                                                                    <option value="<?php echo $list['id_zona']; ?>"><?php echo $list['nom_zona'];?></option>
                                                                    <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="num_vivo_en">Nombre Zona</label>
                                                                    <input type="text" class="form-control mb-4" id="nom_zona"  maxlength = "150" name="nom_zona" value="<?php if(isset($get_id_d['0']['nom_zona'])) {echo $get_id_d['0']['nom_zona'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="tipovivienda">Tipo de vivienda</label>
                                                                    <select class="form-control" name="id_tipo_vivienda" id="id_tipo_vivienda" <?php echo $disabled ?>>
                                                                            <option  value="0"  selected>Seleccionar</option>
                                                                            <?php foreach($list_dtipo_vivienda as $list){
                                                                            if(isset($get_id_d[0]) && $get_id_d[0]['id_tipo_vivienda'] == $list['id_tipo_vivienda']){ ?>
                                                                            <option selected value="<?php echo $list['id_tipo_vivienda']; ?>"><?php echo $list['nom_tipo_vivienda'];?></option>
                                                                            <?php }else{?>
                                                                            <option value="<?php echo $list['id_tipo_vivienda']; ?>"><?php echo $list['nom_tipo_vivienda'];?></option>
                                                                            <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="referencia">Referencia Domicilio</label>
                                                                    <input type="text" class="form-control mb-4" id="referenciaa"  maxlength = "150" name="referenciaa" value="<?php if(isset($get_id_d['0']['referencia'])) {echo $get_id_d['0']['referencia'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="referencia">Dirección completa</label>
                                                        <input type="text" class="form-control mb-4" value="<?php if(isset($get_id_d['0']['direccion_completa'])) {echo $get_id_d['0']['direccion_completa'];}?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="ubicacion">Ubicación de tu vivienda</label>
                                                                    <input type="text" class="form-control mb-4" id="autocomplete" name="autocomplete" <?php echo $disabled ?>>
                                                                    <input type="hidden" id="coordsltd" name="coordsltd" value="<?php if(isset($get_id_d['0']['lat'])) {echo $get_id_d['0']['lat'];} else {echo "-12.0746254";}?>"/>
                                                                    <input type="hidden" id="coordslgt" name="coordslgt" value="<?php if(isset($get_id_d['0']['lng'])) {echo $get_id_d['0']['lng'];} else {echo "-77.021754";}?>"/>
                                                                    <div class="col-md-12" id="map"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_referenciaf" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Referencias Familiares</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5" id="btnReferenciaF">
                                                <?php if($editable==0){?>
                                                    <a onclick="ReferenciaF();"  title="Agregar Familiar" class="btn btn-danger">
                                                    Agregar
                                                    </a>
                                                <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row" id="mureferenciaf">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nom_familiar">Nombre de Familiar</label>
                                                                    <input type="text" class="form-control mb-4 limpiaref" maxlength = "150"  id="nom_familiar" name="nom_familiar" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="fami_paren">Parentesco</label>
                                                                    <select class="form-control limpiarefselect" id="id_parentesco" name="id_parentesco" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccione</option>
                                                                        <?php
                                                                        foreach($list_parentesco as $list){ ?>
                                                                        <option value="<?php echo $list['id_parentesco'] ; ?>">
                                                                        <?php echo $list['nom_parentesco'];?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="naci_familiar">Fecha de Nacimiento</label>
                                                                <div class="d-sm-flex d-block">
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control limpiarefselect" id="dia_nacf" name="dia_nacf" <?php echo $disabled ?>>
                                                                        <option value="0">Día</option>
                                                                        <?php foreach($list_dia as $list){ ?>
                                                                            <option value="<?php echo $list['cod_dia'] ; ?>">
                                                                            <?php echo $list['cod_dia'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control limpiarefselect" id="mes_nacf" name="mes_nacf" <?php echo $disabled ?>>
                                                                            <option value="0">Mes</option>
                                                                            <?php foreach($list_mes as $list){ ?>
                                                                            <option value="<?php echo $list['cod_mes'] ; ?>">
                                                                            <?php echo $list['abr_mes'];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control limpiarefselect" id="anio_nacf" name="anio_nacf" <?php echo $disabled ?>>
                                                                        <option value="0">Año</option>
                                                                        <?php foreach($list_anio as $list){ ?>
                                                                        <option value="<?php echo $list['cod_anio'] ; ?>">
                                                                        <?php echo $list['cod_anio'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="familiar_celular">Celular</label>
                                                                    <input type="number" class="form-control mb-4 limpiaref" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength = "9"  id="celular1" name="celular1" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="familiar_celular2">Celular 2</label>
                                                                    <input type="number" class="form-control mb-4 limpiaref" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength = "9"  id="celular2" name="celular2" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="familiar_telefono2">Teléfono Fijo</label>
                                                                    <input type="number" class="form-control mb-4 limpiaref" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength = "15"  id="fijo" name="fijo" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive" id="mdreferenciaf">
                                                            <?php if(count($list_referenciafu)>0) { ?>
                                                            <table class="table" id="tableMain3">
                                                                <thead>
                                                                    <tr class="tableheader">
                                                                        <th>Nombre de Familiar</th>
                                                                        <th>Parentesco</th>
                                                                        <th>Fecha de Nacimiento</th>
                                                                        <th>Celular</th>
                                                                        <th>Celular 2</th>
                                                                        <th>Teléfono fijo</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($list_referenciafu as $list){ ?>
                                                                    <tr>
                                                                        <td><?php echo $list['nom_familiar'] ; ?></td>
                                                                        <td><?php echo $list['nom_parentesco'] ; ?></td>
                                                                        <td><?php echo $list['dia_nac']."/".$list['mes_nac']."/".$list['anio_nac'] ; ?></td>
                                                                        <td><?php echo $list['celular1'] ; ?></td>
                                                                        <td><?php echo $list['celular2'] ; ?></td>
                                                                        <td><?php echo $list['fijo'] ; ?></td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a href="javascript:void(0);" title="Editar" onclick="Detalle_Referencia_Familiar('<?php echo $list['id_referencia_familiar']; ?>')">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                            </svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a title="Eliminar" onclick="Delete_Referencia_Familiar('<?php echo $list['id_referencia_familiar']; ?>','<?php echo $list['id_usuario']; ?>')" id="delete" role="button">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_hijos" class="section general-info">
                            <input type="hidden" id="id_usuarioh" name="id_usuarioh" class="form-control"  value="<?php echo $get_id[0]['id_usuario']; ?>">


                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Datos de hijos/as</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5" id="btnHijos">
                                                <?php if($editable==0){
                                                    if(isset($list_usuario['0']['hijos']) && $list_usuario[0]['hijos'] == 1){?>
                                                        <a onclick='Hijos();' title='Agregar Hijos' class='btn btn-danger'>Agregar</a>
                                                    <?php }else{?>
                                                        <a onclick='Update_Hijos();' title='Actualizar Hijo' class='btn btn-primary'>Actualizar</a>
                                                    <?php }}else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row" id="muhijos">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="nacionalidad">Respuesta</label>
                                                                    <select class="form-control" id="id_respuestah" name="id_respuestah" onchange="ValidaH();" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccione</option>
                                                                    <option value="1" <?php if(isset($list_usuario['0']['hijos']) && $list_usuario[0]['hijos'] == 1){ echo "selected";} ?>>SÍ</option>
                                                                    <option value="2" <?php if(isset($list_usuario['0']['hijos']) && $list_usuario[0]['hijos'] == 2){ echo "selected";} ?>>NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nom_familiar">Nombre de Hijo</label>
                                                                    <input type="text" class="form-control mb-4 limpiarhijos" maxlength = "150"  id="nom_hijo" name="nom_hijo" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="fami_paren">Genero</label>
                                                                    <select class="form-control limpiarefselecthijos" id="id_generoh" name="id_generoh" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccione</option>
                                                                        <?php
                                                                        foreach($list_genero as $list){ ?>
                                                                        <option value="<?php echo $list['id_genero'] ; ?>">
                                                                        <?php echo $list['nom_genero'];?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="naci_familiar">Fecha de Nacimiento</label>
                                                                <div class="d-sm-flex d-block">
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control limpiarefselecthijos" id="dia_nachj" name="dia_nachj" <?php echo $disabled ?>>
                                                                        <option value="0">Día</option>
                                                                        <?php foreach($list_dia as $list){ ?>
                                                                            <option value="<?php echo $list['cod_dia'] ; ?>">
                                                                            <?php echo $list['cod_dia'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control limpiarefselecthijos" id="mes_nachj" name="mes_nachj" <?php echo $disabled ?>>
                                                                            <option value="0">Mes</option>
                                                                            <?php foreach($list_mes as $list){ ?>
                                                                            <option value="<?php echo $list['cod_mes'] ; ?>">
                                                                            <?php echo $list['abr_mes'];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control limpiarefselecthijos" id="anio_nachj" name="anio_nachj" <?php echo $disabled ?>>
                                                                        <option value="0">Año</option>
                                                                        <?php foreach($list_anio as $list){ ?>
                                                                        <option value="<?php echo $list['cod_anio'] ; ?>">
                                                                        <?php echo $list['cod_anio'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="familiar_celular">DNI</label>
                                                                            <input type="number" class="form-control mb-4 limpiarhijos" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength="8" id="num_dochj" name="num_dochj" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="familiar_celular2">Biológico/No Biológico</label>
                                                                    <select class="form-control limpiarefselecthijos" id="id_biologico" name="id_biologico" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccione</option>
                                                                    <option value="1">SÍ</option>
                                                                    <option value="2">NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="documento">Adjuntar DNI</label>
                                                                    <input type="file" class="form-control-file adjuntardnihijo" id="documento" name="documento" onchange="return validarFotoHijo()" <?php echo $disabled ?>/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive" id="mdhijos">
                                                        <?php if(count($list_hijosu)>0) { ?>
                                                            <table class="table" id="tableMain3">
                                                                <thead>
                                                                    <tr class="tableheader">
                                                                    <th>Nombre de Hijo/a</th>
                                                                    <th>Género</th>
                                                                    <th>Fecha de Nacimiento</th>
                                                                    <th>DNI</th>
                                                                    <th>Biológico</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($list_hijosu as $list){ ?>
                                                                    <tr>
                                                                        <td><?php echo $list['nom_hijo'] ; ?></td>
                                                                        <td><?php echo $list['nom_genero'] ; ?></td>
                                                                        <td><?php echo $list['dia_nac']."/".$list['mes_nac']."/".$list['anio_nac'] ; ?></td>
                                                                        <td><?php echo $list['num_doc'] ; ?></td>
                                                                        <td><?php if ($list['id_biologico']==1){echo "SÍ";} elseif ($list['id_biologico']==2){echo "NO";} ?></td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a href="javascript:void(0);" title="Editar" onclick="Detalle_Hijos_Usuario('<?php echo $list['id_hijos']; ?>')">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                            </svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($list['documento']!=""){
                                                                                $image_info = get_headers($url_dochijo[0]['url_config'].$list['documento']);
                                                                                if (strpos($image_info[0], '200') !== false) {?>
                                                                                <a style="cursor:pointer;display: -webkit-inline-box;" title="DNI vista" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_dochijo[0]['url_config'].$list['documento']?>">
                                                                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533 s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                                                </a>
                                                                                <?php } }?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a style="cursor:pointer;" title="Eliminar" onclick="Delete_Hijos_Usuario('<?php echo $list['id_hijos']; ?>','<?php echo $list['id_usuario']; ?>')" id="delete" role="button"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_contactoe" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Contacto de Emergencia</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5" id="btnContactoE">
                                                <?php if($editable==0){ ?>
                                                    <a onclick="ContactoE();" title="Agregar Contacto de Emergencia" class="btn btn-danger">
                                                    Agregar
                                                    </a>
                                                <?php }else{?>
                                                &nbsp;
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row" id="mucontactoe">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nom_contacto_emer">Nombre de Contacto</label>
                                                                    <input type="text" class="form-control mb-4 limpiarContactoE" maxlength = "50"  id="nom_contacto" name="nom_contacto" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="fami_paren">Parentesco</label>
                                                                    <select class="form-control limpiarefselectContactoE" id="id_parentescoce" name="id_parentescoce" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccione</option>
                                                                        <?php
                                                                        foreach($list_parentesco as $list){ ?>
                                                                        <option value="<?php echo $list['id_parentesco'] ; ?>">
                                                                        <?php echo $list['nom_parentesco'];?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="familiar_celular">Celular</label>
                                                                    <input type="number" class="form-control mb-4 limpiarContactoE" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength = "9"  id="celular1ce" name="celular1ce" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="familiar_celular2">Celular 2</label>
                                                                    <input type="number" class="form-control mb-4 limpiarContactoE" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                            maxlength = "9"  id="celular2ce" name="celular2ce" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="familiar_telefono2">Teléfono Fijo</label>
                                                                    <input type="number" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                                        maxlength="15" class="form-control mb-4 limpiarContactoE" id="fijoce" name="fijoce" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive" id="mdcontactoe">
                                                        <?php if(count($list_contactoeu)>0) { ?>
                                                            <table class="table" id="tableMain3">
                                                                <thead>
                                                                    <tr class="tableheader">
                                                                    <th>Nombre de Contacto</th>
                                                                    <th>Parentesco</th>
                                                                    <th>Celular</th>
                                                                    <th>Celular 2</th>
                                                                    <th>Teléfono fijo</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($list_contactoeu as $list){ ?>
                                                                    <tr>
                                                                        <td><?php echo $list['nom_contacto'] ; ?></td>
                                                                        <td><?php echo $list['nom_parentesco'] ; ?></td>
                                                                        <td><?php echo $list['celular1'] ; ?></td>
                                                                        <td><?php echo $list['celular2'] ; ?></td>
                                                                        <td><?php echo $list['fijo'] ; ?></td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a href="javascript:void(0);" title="Editar" onclick="Detalle_ContactoE('<?php echo $list['id_contacto_emergencia']; ?>')">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a class="" title="Eliminar" onclick="Delete_Contacto_Emergencia('<?php echo $list['id_contacto_emergencia']; ?>','<?php echo $list['id_usuario']; ?>')" id="delete" role="button">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_estudiosg" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Estudios Generales</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5" id="btnEstudiosG">
                                                <?php if($editable==0){ ?>
                                                    <a onclick="EstudiosG();" title="Agregar Estudios Generales" class="btn btn-danger">
                                                    Agregar
                                                    </a>
                                                    <?php }else{?>
                                                    &nbsp;
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="muestudiosg">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="fami_paren">Grado de Instrucción</label>
                                                                    <select class="form-control" id="id_grado_instruccion" name="id_grado_instruccion" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccione</option>
                                                                        <?php
                                                                        foreach($list_grado_instruccion as $list){ ?>
                                                                        <option value="<?php echo $list['id_grado_instruccion'] ; ?>">
                                                                        <?php echo $list['nom_grado_instruccion'];?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="nom_contacto_emer">Carrera de Estudios</label>
                                                                    <input type="text" class="form-control mb-4" id="carrera" name="carrera" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label for="familiar_celular">Centro de Estudios</label>
                                                                    <input type="text" class="form-control mb-4" id="centro" name="centro" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="documentoe">Adjuntar Documento</label>
                                                                    <input type="file" class="form-control-file" id="documentoe" name="documentoe" onchange="return validarEstudiosGenerales()" <?php echo $disabled ?>/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="table-responsive" id="mdestudiosg">
                                                        <?php if(count($list_estudiosgu)>0) { ?>
                                                            <table class="table" id="tableMain3">
                                                                <thead>
                                                                    <tr class="tableheader">
                                                                        <th>Grado de Instrucción</th>
                                                                        <th>Carrera de Estudios</th>
                                                                        <th>Centro de Estudios</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($list_estudiosgu as $list){ ?>
                                                                    <tr>
                                                                        <td><?php echo $list['nom_grado_instruccion'] ; ?></td>
                                                                        <td><?php echo $list['carrera'] ; ?></td>
                                                                        <td><?php echo $list['centro'] ; ?></td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a href="javascript:void(0);" title="Editar" onclick="Detalle_EstudiosG('<?php echo $list['id_estudios_generales']; ?>')">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>

                                                                        <td>
                                                                            <?php if($list["documentoe"]!=""){
                                                                                $img_info=get_headers($url_estudiog[0]['url_config'].$list["documentoe"]);
                                                                                if(strpos($img_info[0],'200')!==false){?>
                                                                                <a href="javascript:void(0)" style="cursor:pointer;display: -webkit-inline-box;" data-title="Documento de Estudio" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_estudiog[0]['url_config'].$list["documentoe"]?>" >
                                                                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                                                </a>
                                                                                <?php }?>

                                                                            <?php }?>
                                                                        </td>

                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a class="" title="Eliminar" onclick="Delete_EstudiosG('<?php echo $list['id_estudios_generales']; ?>','<?php echo $list['id_usuario']; ?>')" id="delete" role="button">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_conoci_office" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Conocimientos de Office</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                    <?php if($editable==0){?>
                                                    <a onclick="Conoci_Office();"  class="btn btn-primary" title="Conocimientos de Office">
                                                    Actualizar
                                                    </a>
                                                    <?php }else{?> &nbsp;<?php }?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="conoci_office">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nl_excel">Nivel de Excel</label>
                                                                    <select class="form-control" name="nl_excel" id="nl_excel" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccion</option>
                                                                        <?php foreach($list_nivel_instruccion as $list){
                                                                            if(isset($get_id_c[0]) && $get_id_c[0]['nl_excel'] == $list['id_nivel_instruccion']){ ?>
                                                                            <option selected value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
                                                                        <?php }else{?>
                                                                        <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nivel_word">Nivel de Word</label>
                                                                    <select class="form-control" name="nl_word" id="nl_word" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccion</option>
                                                                        <?php foreach($list_nivel_instruccion as $list){
                                                                            if(isset($get_id_c[0]) && $get_id_c[0]['nl_word'] == $list['id_nivel_instruccion']){ ?>
                                                                            <option selected value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
                                                                        <?php }else{?>
                                                                        <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nivel_ppoint">Nivel de Power Point</label>
                                                                    <select class="form-control" name="nl_ppoint" id="nl_ppoint" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccion</option>
                                                                        <?php foreach($list_nivel_instruccion as $list){
                                                                            if(isset($get_id_c[0]) && $get_id_c[0]['nl_ppoint'] == $list['id_nivel_instruccion']){ ?>
                                                                            <option selected value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
                                                                        <?php }else{?>
                                                                        <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_conoci_idiomas" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Conocimientos de Idiomas</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5" id="btnIdiomas">
                                                    <?php if($editable==0){?>
                                                    <a onclick="Conoci_Idiomas();" title="Agregar Idioma" class="btn btn-danger">
                                                    Agregar
                                                    </a>
                                                    <?php }else{?>&nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="conoci_idiomas">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="nom_conoci_idiomas">Idioma</label>
                                                                    <select class="form-control" name="nom_conoci_idiomas" id="nom_conoci_idiomas" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccion</option>
                                                                    <?php foreach($list_idiomas as $list){ ?>
                                                                    <option value="<?php echo $list['id_idioma']; ?>"><?php echo $list['nom_idioma'];?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="lect_conoci_idiomas">Lectura</label>
                                                                    <select class="form-control" name="lect_conoci_idiomas" id="lect_conoci_idiomas" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccion</option>
                                                                    <?php foreach($list_nivel_instruccion as $list){ ?>
                                                                    <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="escrit_conoci_idiomas">Escritura</label>
                                                                    <select class="form-control" name="escrit_conoci_idiomas" id="escrit_conoci_idiomas" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccion</option>
                                                                    <?php foreach($list_nivel_instruccion as $list){ ?>
                                                                    <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="conver_conoci_idiomas">Conversación</label>
                                                                    <select class="form-control" name="conver_conoci_idiomas" id="conver_conoci_idiomas" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccion</option>
                                                                    <?php foreach($list_nivel_instruccion as $list){ ?>
                                                                    <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="table-responsive" id="mdconocimientoi">
                                                        <?php if(count($listar_idiomas)>0) { ?>
                                                            <table class="table" id="tableMain3">
                                                                <thead>
                                                                    <tr class="tableheader">
                                                                        <th>Idioma </th>
                                                                        <th>Lectura </th>
                                                                        <th>Escritura</th>
                                                                        <th>Conversación</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($listar_idiomas as $list){ ?>
                                                                    <tr>
                                                                        <td><?php echo $list['nom_idioma']; ?></td>
                                                                        <td><?php echo $list['nom_nivel_instruccionl']; ?></td>
                                                                        <td><?php echo $list['nom_nivel_instruccione']; ?></td>
                                                                        <td><?php echo $list['nom_nivel_instruccionc']; ?></td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a href="javascript:void(0);" title="Editar" onclick="Detalle_Conoci_Idiomas('<?php echo $list['id_conoci_idiomas']; ?>')">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a class="" title="Eliminar" onclick="Delete_Conoci_Idiomas('<?php echo $list['id_conoci_idiomas']; ?>','<?php echo $list['id_usuario']; ?>')" id="delete" role="button">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_cursosc" class="section general-info">
                                <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Cursos Complementarios</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5" id="btnCursosC">
                                                <?php if($editable==0){?>
                                                    <a onclick="CursosC();" title="Agregar Curso Complementario" class="btn btn-danger">
                                                    Agregar
                                                    </a>
                                                    <?php }else{?>&nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="mucursos">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="cursos_complemetarios">Cursos/Conocimientos Complementarios</label>
                                                                    <input type="text" class="form-control mb-4" id="nom_curso_complementario" name="nom_curso_complementario" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="fami_paren">Año</label>
                                                                    <select class="form-control" id="aniocc" name="aniocc" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccionar</option>
                                                                    <option value="1">Actualidad</option>
                                                                    <?php foreach($list_anio as $list){ ?>
                                                                    <option value="<?php echo $list['cod_anio'] ; ?>">
                                                                    <?php echo $list['cod_anio'];?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="adj_certifi">Adjuntar Certificado</label>
                                                                    <input type="file" class="form-control-file" id="certificado" name="certificado" onchange="return validarCursosComplementarios()" <?php echo $disabled ?>/>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="table-responsive" id="mdcursos">
                                                        <?php if(count($listar_cursosc)>0) { ?>
                                                            <table class="table" id="tableMain3">
                                                                <thead>
                                                                    <tr class="tableheader">
                                                                        <th>Curso / Conocimiento</th>
                                                                        <th>Año</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($listar_cursosc as $list){ ?>
                                                                    <tr>
                                                                        <td><?php echo $list['nom_curso_complementario'] ; ?></td>
                                                                        <td><?php if($list['anio']=="1"){echo "Actualidad";} else{echo $list['anio'] ;} ?></td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a href="javascript:void(0);" title="Editar" onclick="Detalle_CursosC('<?php echo $list['id_curso_complementario']; ?>')">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                            </svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                        <td>
                                                                            <?php $img_info=get_headers($url_cursosc[0]['url_config'].$list['certificado']);
                                                                            if($list['certificado']!=""){
                                                                            if(strpos($img_info[0],'200')!==false){?>
                                                                                <a style="cursor:pointer;display: -webkit-inline-box;" data-title="Certificado" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_cursosc[0]['url_config'].$list['certificado']?>" >
                                                                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533 s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                                                </a>
                                                                            <?php } }?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a class="" title="Eliminar" onclick="Delete_CursosC('<?php echo $list['id_curso_complementario']; ?>','<?php echo $list['id_usuario']; ?>')" id="delete" role="button">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                    <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                                                                </svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_experiencial" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Experiencia Laboral</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5" id="btnExperenciaL">
                                                <?php if($editable==0){?>
                                                    <a onclick="ExperenciaL();" title="Agregar Experiencia Laboral" class="btn btn-danger">
                                                    Agregar
                                                    </a>
                                                <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row" id="muexperiencial">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="nom_familiar">Empresa</label>
                                                                    <input type="text" class="form-control mb-4" id="empresaex" name="empresaex" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="nom_familiar">Cargo</label>
                                                                    <input type="text" class="form-control mb-4" id="cargoex" name="cargoex" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="naci_familiar">Fecha de Inicio</label>
                                                                <div class="d-sm-flex d-block">
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control" id="dia_iniel" name="dia_iniel" <?php echo $disabled ?>>
                                                                        <option value="0">Día</option>
                                                                        <?php foreach($list_dia as $list){ ?>
                                                                            <option value="<?php echo $list['cod_dia'] ; ?>">
                                                                            <?php echo $list['cod_dia'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control" id="mes_iniel" name="mes_iniel" <?php echo $disabled ?>>
                                                                            <option value="0">Mes</option>
                                                                            <?php foreach($list_mes as $list){ ?>
                                                                            <option value="<?php echo $list['cod_mes'] ; ?>">
                                                                            <?php echo $list['abr_mes'];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control" id="anio_iniel" name="anio_iniel" <?php echo $disabled ?>>
                                                                        <option value="0">Año</option>
                                                                        <?php foreach($list_anio as $list){ ?>
                                                                        <option value="<?php echo $list['cod_anio'] ; ?>">
                                                                        <?php echo $list['cod_anio'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="naci_familiar">Fecha de Fin <input type="checkbox" id="checkactualidad" name="checkactualidad" value="1" <?php echo $disabled ?> /> <b>Actualidad</b></label>

                                                                <div class="d-sm-flex d-block">
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control" id="dia_finel" name="dia_finel" <?php echo $disabled ?> >
                                                                        <option value="0">Día</option>
                                                                        <?php foreach($list_dia as $list){ ?>
                                                                            <option value="<?php echo $list['cod_dia'] ; ?>">
                                                                            <?php echo $list['cod_dia'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control" id="mes_finel" name="mes_finel" <?php echo $disabled ?>>
                                                                            <option value="0">Mes</option>
                                                                            <?php foreach($list_mes as $list){ ?>
                                                                            <option value="<?php echo $list['cod_mes'] ; ?>">
                                                                            <?php echo $list['abr_mes'];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-2">
                                                                        <select class="form-control" id="anio_finel" name="anio_finel" <?php echo $disabled ?>>
                                                                        <option value="0">Año</option>
                                                                        <?php foreach($list_anio as $list){ ?>
                                                                        <option value="<?php echo $list['cod_anio'] ; ?>">
                                                                        <?php echo $list['cod_anio'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="fami_paren">Motivo de Salida</label>
                                                                    <input type="text" class="form-control mb-4" id="motivo_salida" name="motivo_salida" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="familiar_celular">Importe de remuneración</label>
                                                                    <input type="text" class="form-control mb-4" id="remuneracion" name="remuneracion" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="familiar_celular2">Nombre de referencia laboral</label>
                                                                    <input type="text" class="form-control mb-4" id="nom_referencia_labores" name="nom_referencia_labores" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="familiar_celular">Número de Contacto de la empresa</label>
                                                                    <input type="number" class="form-control mb-4" id="num_contacto" name="num_contacto" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="dni_img">Adjuntar Certificado</label>
                                                                    <input type="file" class="form-control-file" id="certificadolb" name="certificadolb" onchange="return validarExperiecnciaLaboral()" <?php echo $disabled ?>/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive" id="mdexperiencial">
                                                        <?php if(count($list_experiencial)>0) { ?>
                                                            <table class="table" id="tableMain3">
                                                                <thead>
                                                                    <tr class="tableheader">
                                                                    <th>Empresa</th>
                                                                    <th>Cargo</th>
                                                                    <th>Fecha de Inicio</th>
                                                                    <th>Fecha de Fin</th>
                                                                    <th>Motivo de Salida</th>
                                                                    <th>Remuneración</th>
                                                                    <th>Referencia Laboral</th>
                                                                    <th>Número de Contacto</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($list_experiencial as $list){ ?>
                                                                    <tr>
                                                                        <td><?php echo $list['empresa'] ; ?></td>
                                                                        <td><?php echo $list['cargo'] ; ?></td>
                                                                        <td><?php echo $list['dia_ini']."/".$list['mes_ini']."/".$list['anio_ini'] ; ?></td>
                                                                        <td><?php if($list['actualidad']=="1"){echo "Actualidad";} else{echo $list['dia_fin']."/".$list['mes_fin']."/".$list['anio_fin'] ;} ?></td>
                                                                        <td><?php echo $list['motivo_salida'] ; ?></td>
                                                                        <td><?php echo $list['remuneracion'] ; ?></td>
                                                                        <td><?php echo $list['nom_referencia_labores'] ; ?></td>
                                                                        <td><?php echo $list['num_contacto'] ; ?></td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a href="javascript:void(0);" title="Editar" onclick="Detalle_ExperenciaL('<?php echo $list['id_experiencia_laboral']; ?>')">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                            </a>
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($list["certificado"]!=""){
                                                                                $img_info=get_headers($url_exp[0]['url_config'].$list["certificado"]);
                                                                                if(strpos($img_info[0],'200')!==false){?>
                                                                                <a style="cursor:pointer;display: -webkit-inline-box;" data-title="Certificado Laboral" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_exp[0]['url_config'].$list["certificado"]?>" >
                                                                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                                                </a>
                                                                            <?php } } ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a class="" title="Eliminar" onclick="Delete_ExperenciaL('<?php echo $list['id_experiencia_laboral']; ?>','<?php echo $list['id_usuario']; ?>')" id="delete" role="button">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                                            </a>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_enfermedades" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Enfermedades</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5" id="btnEnfermedades">
                                                <?php if($editable==0){
                                                    if(isset($list_usuario[0]['enfermedades']) && $list_usuario[0]['enfermedades'] == 1){?>
                                                        <a onclick="Enfermedades();" title="Agregar Enfermedad" class="btn btn-danger">
                                                        Agregar
                                                        </a>
                                                    <?php }else{?>
                                                        <a onclick='Update_Enfermedades();' title='Actualizar Enfermedad' class='btn btn-primary'>Actualizar</a>
                                                    <?php }?>

                                                <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12" id="muenfermedades">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nacionalidad">Indique si padece alguna enfermedad</label>
                                                                    <select class="form-control" id="id_respuestae" name="id_respuestae" onchange="ValidaE();" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccione</option>
                                                                    <option value="1" <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 1){ echo "selected";} ?>>SÍ</option>
                                                                    <option value="2" <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 2){ echo "selected";} ?>>NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="dni_hijo">Especifique la enfermedad</label>
                                                                    <input <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 2){ echo "disabled";} ?> type="text" class="form-control mb-4" id="nom_enfermedad" name="nom_enfermedad" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="naci_familiar">Fecha de Diagnóstico</label>
                                                                <div class="d-sm-flex d-block">
                                                                    <div class="form-group mr-2">
                                                                        <select <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 2){ echo "disabled";} ?> class="form-control" id="dia_diagnostico" name="dia_diagnostico" <?php echo $disabled ?>>
                                                                        <option value="0">Día</option>
                                                                        <?php foreach($list_dia as $list){ ?>
                                                                            <option value="<?php echo $list['cod_dia'] ; ?>">
                                                                            <?php echo $list['cod_dia'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-2">
                                                                        <select <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 2){ echo "disabled";} ?> class="form-control" id="mes_diagnostico" name="mes_diagnostico" <?php echo $disabled ?>>
                                                                            <option value="0">Mes</option>
                                                                            <?php foreach($list_mes as $list){ ?>
                                                                            <option value="<?php echo $list['cod_mes'] ; ?>">
                                                                            <?php echo $list['abr_mes'];?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mr-2">
                                                                        <select <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 2){ echo "disabled";} ?> class="form-control" id="anio_diagnostico" name="anio_diagnostico" <?php echo $disabled ?>>
                                                                        <option value="0">Año</option>
                                                                        <?php foreach($list_anio as $list){ ?>
                                                                        <option value="<?php echo $list['cod_anio'] ; ?>">
                                                                        <?php echo $list['cod_anio'];?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="table-responsive" id="mdenfermedades">
                                                        <?php if(count($list_enfermedadu)>0) { ?>
                                                            <table class="table" id="tableMain3">
                                                                <thead>
                                                                    <tr class="tableheader">
                                                                    <th>Enfermedad</th>
                                                                    <th>Fecha de Diagnóstico</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($list_enfermedadu as $list){ ?>
                                                                    <tr>
                                                                        <td><?php echo $list['nom_enfermedad'] ; ?></td>
                                                                        <td><?php echo $list['dia_diagnostico']."/".$list['mes_diagnostico']."/".$list['anio_diagnostico'] ; ?></td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a href="javascript:void(0);" title="Editar" onclick="Detalle_Enfermedades('<?php echo $list['id_enfermedad_usuario']; ?>')">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($editable==0){?>
                                                                            <a class="" title="Eliminar" onclick="Delete_Enfermedades('<?php echo $list['id_enfermedad_usuario']; ?>','<?php echo $list['id_usuario']; ?>')" id="delete" role="button">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                                            </a>
                                                                            <?php }?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_gestacion" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">

                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Gestación</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                <?php if($editable==0){?>
                                                    <a onclick="Gestacion();" title="Gestación" class="btn btn-primary">
                                                    Actualizar
                                                    </a>
                                                    <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="gestacion">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nacionalidad">Indique si se encuentra en gestación</label>
                                                                    <select class="form-control" id="id_respuesta" name="id_respuesta" onchange="Validag();" <?php echo $disabled ?>>
                                                                    <option value="0" <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] == 0){ echo "selected";} ?>>Seleccione</option>
                                                                    <option value="1" <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] == 1){ echo "selected";} ?>>SÍ</option>
                                                                    <option value="2" <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] == 2){ echo "selected";} ?>>NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="usuario_email">Fecha de inicio de gestación</label>
                                                                    <div class="d-sm-flex d-block">
                                                                        <div class="form-group mr-1">
                                                                            <select <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] != 1){echo "disabled";}?> class="form-control" id="dia_ges" name="dia_ges" <?php echo $disabled ?>>
                                                                            <option value="0">Día</option>
                                                                            <?php foreach($list_dia as $list){
                                                                            if(isset($get_id_gestacion[0]) && $get_id_gestacion[0]['dia_ges'] == $list['cod_dia']){ ?>
                                                                            <option selected value="<?php echo $list['cod_dia']; ?>"><?php echo $list['cod_dia'];?></option>
                                                                            <?php }else{?>
                                                                            <option value="<?php echo $list['cod_dia']; ?>"><?php echo $list['cod_dia'];?></option>
                                                                            <?php } } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group mr-1">
                                                                            <select <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] != 1){echo "disabled";}?> class="form-control" id="mes_ges" name="mes_ges" <?php echo $disabled ?>>
                                                                            <option value="0">Mes</option>
                                                                            <?php foreach($list_mes as $list){
                                                                            if(isset($get_id_gestacion[0]) && $get_id_gestacion[0]['mes_ges'] == $list['cod_mes']){ ?>
                                                                            <option selected value="<?php echo $list['cod_mes'] ; ?>" ><?php echo $list['abr_mes'];?></option>
                                                                            <?php } else{?>
                                                                            <option value="<?php echo $list['cod_mes']; ?>"><?php echo $list['abr_mes'];?></option>
                                                                            <?php } } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group mr-1">
                                                                            <select <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] != 1){echo "disabled";}?> class="form-control" id="anio_ges" name="anio_ges" <?php echo $disabled ?>>
                                                                            <option value="0">Año</option>
                                                                            <?php foreach($list_anio as $list){
                                                                            if(isset($get_id_gestacion[0]) && $get_id_gestacion[0]['anio_ges'] == $list['cod_anio']){ ?>
                                                                            <option selected value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                                                                            <?php } else{?>
                                                                            <option value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                                                                            <?php } } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_alergia" class="section general-info">
                                <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Alergias</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5" id="btnAlergia">
                                                <?php if($editable==0){
                                                    if(isset($list_usuario[0]['alergia']) && $list_usuario[0]['alergia'] == 1){?>
                                                    <a onclick="Alergia();" title="Agregar Alergia" class="btn btn-danger">
                                                        Agregar
                                                    </a>
                                                    <?php }else{?>
                                                        <a onclick='Update_Alergia();' title='Actualizar Alergia' class='btn btn-primary'>Actualizar</a>
                                                    <?php }?>
                                                    <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12" id="mualergias">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nacionalidad">Es alérgico a algun medicamento</label>
                                                                    <select class="form-control" id="id_respuestaau" name="id_respuestaau" onchange="ValidaA();" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccione</option>
                                                                    <option value="1" <?php if(isset($list_usuario['0']['alergia']) && $list_usuario[0]['alergia'] == 1){ echo "selected";} ?>>SÍ</option>
                                                                    <option value="2" <?php if(isset($list_usuario['0']['alergia']) && $list_usuario[0]['alergia'] == 2){ echo "selected";} ?>>NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group" id="medicamentou">
                                                                    <label for="dni_hijo">Indique el nombre del medicamento</label>
                                                                    <input type="text" class="form-control mb-4" id="nom_alergia" name="nom_alergia" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="table-responsive" id="mdalergias">
                                                            <?php if(count($list_alergia)>0) { ?>
                                                                <table class="table" id="tableMain3">
                                                                    <thead>
                                                                        <tr class="tableheader">
                                                                        <th>Medicamento</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach($list_alergia as $list){ ?>
                                                                        <tr>
                                                                            <td><?php echo $list['nom_alergia'] ; ?></td>
                                                                            <td>
                                                                                <?php if($editable==0){?>
                                                                                <a href="javascript:void(0);" title="Editar" onclick="Detalle_Alergia('<?php echo $list['id_alergia_usuario']; ?>')">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                </svg>
                                                                                </a>
                                                                                <?php }?>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($editable==0){?>
                                                                                <a class="" title="Eliminar" onclick="Delete_Alergia('<?php echo $list['id_alergia_usuario']; ?>','<?php echo $list['id_usuario']; ?>')" id="delete" role="button">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                        <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                                                                    </svg>
                                                                                </a>
                                                                                <?php }?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_otros" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                            <input type="hidden" id="id_usuarioo" name="id_usuarioo" value="<?php echo $id_usuario;?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Otros</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                <?php if($editable==0){?>
                                                    <a onclick="Otros();" title="Otros" class="btn btn-primary">
                                                    Actualizar
                                                    </a>
                                                    <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="otros">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nacionalidad">Tipo de sangre</label>
                                                                    <select class="form-control" name="id_grupo_sanguineo" id="id_grupo_sanguineo" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccion</option>
                                                                    <?php foreach($list_grupo_sanguineo as $list){
                                                                        if(isset($get_id_otros[0]) &&  $get_id_otros[0]['id_grupo_sanguineo'] == $list['id_grupo_sanguineo']){ ?>
                                                                        <option selected value="<?php echo $list['id_grupo_sanguineo']; ?>"><?php echo $list['nom_grupo_sanguineo'];?></option>
                                                                    <?php }else{?>
                                                                    <option value="<?php echo $list['id_grupo_sanguineo']; ?>"><?php echo $list['nom_grupo_sanguineo'];?></option>
                                                                    <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!--<div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="dni_img">Adjuntar Prueba COVID</label>
                                                                    <?php if(isset($get_id_otros[0]['cert_covid']) && $get_id_otros[0]['cert_covid']!=""){ //&& is_file($get_id_otros[0]['cert_covid'])) { ?>
                                                                    <a style="cursor:pointer;display: -webkit-inline-box;" title="Prueba COVID" data-toggle="modal" data-target="#zoomupModalCovid" data-imagen="<?php echo $get_id_otros[0]['cert_covid']; ?>" >
                                                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533 s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2 s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/> <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667 s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/> <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733 c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g> <g></g> <g> </g> <g>  </g>  <g></g> <g> </g><g>  </g><g></g><g></g><g></g><g></g> <g></g></svg>
                                                                    </a>
                                                                    <?php } ?>
                                                                    <input type="file" class="form-control-file" id="certificadootr" name="certificadootr" onchange="return validarCOVID()"  />
                                                                </div>
                                                            </div>-->

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="dni_img">Adjuntar Vacuna COVID</label>
                                                                    <?php if(isset($get_id_otros[0]['cert_vacu_covid']) && $get_id_otros[0]['cert_vacu_covid']!=""){
                                                                        $img_info=get_headers($url_otro[0]['url_config'].$get_id_otros[0]['cert_vacu_covid']);
                                                                        if(strpos($img_info[0],'200')!==false){?>
                                                                            <a style="cursor:pointer;display: -webkit-inline-box;" data-title="Vacuna COVID" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_otro[0]['url_config'].$get_id_otros[0]['cert_vacu_covid']; ?>" >
                                                                                <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533 s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2 s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/> <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667 s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/> <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733 c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g> <g></g> <g> </g> <g>  </g>  <g></g> <g> </g><g>  </g><g></g><g></g><g></g><g></g> <g></g></svg>
                                                                            </a>
                                                                        <?php } } ?>
                                                                    <input type="file" class="form-control-file" id="certificadootr_vacu" name="certificadootr_vacu" onchange="return validar_vacuCOVID()"  <?php echo $disabled ?> />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_referencia_convocatoria" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">

                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Referencia de Convocatoria</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                <?php if($editable==0){?>
                                                    <a onclick="Referencia_Convocatoria();" title="Referencia de Convocatoria" class="btn btn-primary">
                                                    Actualizar
                                                    </a>
                                                    <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="referencia_convocatoria">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nacionalidad">Indica ¿Cómo te enteraste del puesto?</label>
                                                                    <select class="form-control" name="id_referencia_laboral" id="id_referencia_laboral" onchange="ValidaRC();" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccion</option>
                                                                    <?php foreach($list_referencia_laboral as $list){
                                                                        if(isset($get_id_referenciac[0]) && $get_id_referenciac[0]['id_referencia_laboral'] == $list['id_referencia_laboral']){ ?>
                                                                        <option selected value="<?php echo $list['id_referencia_laboral']; ?>"><?php echo $list['nom_referencia_laboral'];?></option>
                                                                    <?php }else{?>
                                                                    <option value="<?php echo $list['id_referencia_laboral']; ?>"><?php echo $list['nom_referencia_laboral'];?></option>
                                                                    <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="usuario_email">Especifique otros</label>
                                                                    <input type="text" <?php if(isset($get_id_referenciac['0']['id_referencia_laboral']) && $get_id_referenciac[0]['id_referencia_laboral'] != 6){echo "disabled";}?> class="form-control mb-4" id="otrosel" name="otrosel" value="<?php if(isset($get_id_referenciac['0']['otros'])) {echo $get_id_referenciac['0']['otros'];}?>" <?php echo $disabled ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_adjuntar_documentacion" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Adjuntar Documentación</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                    <?php if($editable==0){?>
                                                    <a onclick="Adjuntar_Documentacion();" title="Adjuntar Documentación" class="btn btn-primary">
                                                        Actualizar
                                                    </a>
                                                    <?php }else{?> &nbsp;<?php }?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="adjuntar_documentacion">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="dni_img">Adjuntar curriculum vitae</label>
                                                                    <?php if(isset($get_id_documentacion[0]['cv_doc']) && $get_id_documentacion[0]['cv_doc']!="" ){//&& is_file($get_id_documentacion[0]['cv_doc'])) { ?>

                                                                    <a style="cursor:pointer;display: -webkit-inline-box;" title="Curriculum Vitae" data-toggle="modal" data-target="#Modal_IMG" data-imagen="<?php echo $url_documentacion[0]['url_config'].$get_id_documentacion[0]['cv_doc']; ?>" data-title="Curriculum Vitae" >
                                                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                                    </a>
                                                                    <?php } ?>
                                                                    <input type="file" class="form-control-file" id="filecv_doc" name="filecv_doc" onchange="return validarfilecv_doc()" <?php echo $disabled ?>/>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="dni_img">Foto DNI (ambas caras)</label>
                                                                    <?php if(isset($get_id_documentacion[0]['dni_doc']) && $get_id_documentacion[0]['dni_doc']!=""){ //&& is_file($get_id_documentacion[0]['dni_doc'])) { ?>

                                                                    <a style="cursor:pointer;display: -webkit-inline-box;" title="DNI ambas cara" data-toggle="modal" data-target="#Modal_IMG" data-imagen="<?php echo $url_documentacion[0]['url_config'].$get_id_documentacion[0]['dni_doc']; ?>" data-title="DNI ambas cara" >
                                                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                                    </a>
                                                                    <?php } ?>
                                                                    <input type="file" class="form-control-file" id="filedni_doc" name="filedni_doc"  onchange="return validarfiledni_doc()" <?php echo $disabled ?>>

                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="dni_img">Copia de recibo de agua y luz</label>
                                                                    <?php if(isset($get_id_documentacion[0]['recibo_doc']) && $get_id_documentacion[0]['recibo_doc']!=""){ //&& is_file($get_id_documentacion[0]['recibo_doc'])) { ?>

                                                                    <a style="cursor:pointer;display: -webkit-inline-box;" title="Recibo ambas caras" data-toggle="modal" data-target="#Modal_IMG" data-imagen="<?php echo $url_documentacion[0]['url_config'].$get_id_documentacion[0]['recibo_doc']; ?>" data-title="Recibo ambas caras" >
                                                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                                    </a>
                                                                    <?php } ?>
                                                                    <input type="file" class="form-control-file" id="filerecibo_doc" name="filerecibo_doc"  onchange="return validarfilerecibo_doc()" <?php echo $disabled ?>/>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_talla_indicar" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Uniforme</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                <?php if($editable==0){?>
                                                    <a onclick="Talla_Indica();" title="Actualizar Talla" class="btn btn-primary">
                                                    Actualizar
                                                    </a>
                                                    <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="talla_indicar">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="polo">Polo</label>
                                                                    <select class="form-control" name="polo" id="polo" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccion</option>
                                                                        <?php foreach($list_accesorio_polo as $list){
                                                                            if(isset($get_id_t[0]) && $get_id_t[0]['polo'] == $list['id_talla']){ ?>
                                                                            <option selected value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
                                                                        <?php }else{?>
                                                                        <option value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="camisa">Camisa</label>
                                                                    <select class="form-control" name="camisa" id="camisa" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccion</option>
                                                                        <?php foreach($list_accesorio_camisa as $list){
                                                                            if(isset($get_id_t[0]) && $get_id_t[0]['camisa'] == $list['id_talla']){ ?>
                                                                            <option selected value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
                                                                        <?php }else{?>
                                                                        <option value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="pantalon">Pantalón</label>
                                                                    <select class="form-control" name="pantalon" id="pantalon" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccion</option>
                                                                        <?php foreach($list_accesorio_pantalon as $list){
                                                                            if(isset($get_id_t[0]) && $get_id_t[0]['pantalon'] == $list['id_talla']){ ?>
                                                                            <option selected value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
                                                                        <?php }else{?>
                                                                        <option value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="zapato">Zapato</label>
                                                                    <select class="form-control" name="zapato" id="zapato" <?php echo $disabled ?>>
                                                                        <option value="0">Seleccion</option>
                                                                        <?php foreach($list_accesorio_zapato as $list){
                                                                            if(isset($get_id_t[0]) && $get_id_t[0]['zapato'] == $list['id_talla']){ ?>
                                                                            <option selected value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
                                                                        <?php }else{?>
                                                                        <option value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_sistema_pensionario" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Sistema Pensionario</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                    <?php if($editable==0){?>
                                                    <a onclick="Sistema_Pensionario();" title="Sistema Pensionario" class="btn btn-primary">
                                                    Actualizar
                                                    </a>
                                                    <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="sistema_pensionario">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="nacionalidad">Pertenece a algún sistema pensionario</label>
                                                                    <select class="form-control" id="id_respuestasp" name="id_respuestasp" onchange="Validasp();" <?php echo $disabled ?>>
                                                                    <option value="0" <?php if(isset($get_id_sist_pensu['0']['id_respuestasp']) && $get_id_sist_pensu[0]['id_respuestasp'] == 0){ echo "selected";} ?>>Seleccione</option>
                                                                    <option value="1" <?php if(isset($get_id_sist_pensu['0']['id_respuestasp']) && $get_id_sist_pensu[0]['id_respuestasp'] == 1){ echo "selected";} ?>>SÍ</option>
                                                                    <option value="2" <?php if(isset($get_id_sist_pensu['0']['id_respuestasp']) && $get_id_sist_pensu[0]['id_respuestasp'] == 2){ echo "selected";} ?>>NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="camisa">Indique el sistema pensionaro al que pertenece</label>
                                                                    <select <?php if(isset($get_id_sist_pensu['0']['id_respuestasp']) && $get_id_sist_pensu[0]['id_respuestasp'] == 2){ echo "disabled";} ?> class="form-control" name="id_sistema_pensionario" id="id_sistema_pensionario" onchange="ValidaAFP();" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccion</option>
                                                                    <?php foreach($list_sistema_pensionario as $list){
                                                                        if(isset($get_id_sist_pensu[0]) && $get_id_sist_pensu[0]['id_sistema_pensionario'] == $list->id_sistema_pensionario){ ?>
                                                                        <option selected value="<?php echo $list->id_sistema_pensionario; ?>"><?php echo $list->cod_sistema_pensionario;?></option>
                                                                    <?php }else{?>
                                                                    <option value="<?php echo $list->id_sistema_pensionario; ?>"><?php echo $list->cod_sistema_pensionario;?></option>
                                                                    <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="pantalon">Si indico AFP elija</label>
                                                                    <select <?php if(isset($get_id_sist_pensu['0']['id_respuestasp']) && $get_id_sist_pensu[0]['id_respuestasp'] == 2){ echo "disabled";} ?> class="form-control" name="id_afp" id="id_afp" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccion</option>
                                                                    <?php foreach($list_afp as $list){
                                                                        if(isset($get_id_sist_pensu[0]) && $get_id_sist_pensu[0]['id_afp'] == $list->id_afp){ ?>
                                                                        <option selected value="<?php echo $list->id_afp; ?>"><?php echo $list->nom_afp;?></option>
                                                                    <?php }else{?>
                                                                    <option value="<?php echo $list->id_afp; ?>"><?php echo $list->nom_afp;?></option>
                                                                    <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_cuenta_bancaria" class="section general-info">
                            <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">

                                <div class="info">
                                    <div class="chico">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="">Número de Cuenta</h6>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right mb-5">
                                                <?php if($editable==0){?>
                                                    <a onclick="Numero_Cuenta();" title="Actualizar Número de Cuenta" class="btn btn-primary">
                                                    Actualizar
                                                    </a>
                                                    <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                            <div class="edu-section">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row" id="numero_cuenta">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="nacionalidad">¿Cuéntas con cuenta bancaria?</label>
                                                                    <select class="form-control" id="cuenta_bancaria" name="cuenta_bancaria" onchange="Validaeb();" <?php echo $disabled ?>>
                                                                    <option value="0" <?php if(isset($get_id_cuentab['0']['cuenta_bancaria']) && $get_id_cuentab[0]['cuenta_bancaria'] == 0){ echo "selected";} ?>>Seleccione</option>
                                                                    <option value="1" <?php if(isset($get_id_cuentab['0']['cuenta_bancaria']) && $get_id_cuentab[0]['cuenta_bancaria'] == 1){ echo "selected";} ?>>SÍ</option>
                                                                    <option value="2" <?php if(isset($get_id_cuentab['0']['cuenta_bancaria']) && $get_id_cuentab[0]['cuenta_bancaria'] == 2){ echo "selected";} ?>>NO</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="">Indique la entidad bancaria</label>
                                                                <select class="form-control" name="id_banco" id="id_banco" <?php echo $disabled ?>>
                                                                    <option value="0">Seleccion</option>
                                                                    <?php foreach($list_banco as $list){
                                                                        if(count($get_id_cuentab)>0 && $get_id_cuentab[0]['id_banco'] == $list['id_banco']){ ?>
                                                                        <option selected value="<?php echo $list['id_banco']; ?>"><?php echo $list['nom_banco'];?></option>
                                                                    <?php }else{?>
                                                                    <option value="<?php echo $list['id_banco']; ?>"><?php echo $list['nom_banco'];?></option>
                                                                    <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>


                                                            <?php for ($x = 1; $x <= count($list_banco); $x++) {?>
                                                                <div class="<?php echo $x; ?> GFG col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="usuario_email">Indique el número de cuenta</label>
                                                                        <input <?php if(isset($get_id_cuentab['0']['cuenta_bancaria']) && $get_id_cuentab[0]['cuenta_bancaria'] != 1){echo "disabled";}?> type="text" class="form-control mb-4 grupo1" id="num_cuenta_bancaria_<?php echo $x; ?>" name="num_cuenta_bancaria_<?php echo $x; ?>" value="<?php
                                                                            if(count($get_id_cuentab)>0 && $get_id_cuentab[0]['id_banco'] == $x){
                                                                                if(isset($get_id_cuentab['0']['num_cuenta_bancaria'])) {echo $get_id_cuentab['0']['num_cuenta_bancaria'];}
                                                                            }else{

                                                                            }
                                                                        ?>" <?php echo $disabled ?>>
                                                                    </div>
                                                                </div>
                                                            <?php }  ?>

                                                            <?php for ($x = 1; $x <= count($list_banco); $x++) {?>
                                                                <div class="<?php echo $x; ?> GFG col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="usuario_email">Indique el código interbancario</label>
                                                                        <input <?php if(isset($get_id_cuentab['0']['cuenta_bancaria']) && $get_id_cuentab[0]['cuenta_bancaria'] != 1){echo "disabled";}?> type="text" class="form-control mb-4" id="num_codigo_interbancario_<?php echo $x; ?>" name="num_codigo_interbancario_<?php echo $x; ?>" value="
                                                                        <?php
                                                                            if(count($get_id_cuentab)>0 && $get_id_cuentab[0]['id_banco']== $x){
                                                                                if(isset($get_id_cuentab['0']['num_codigo_interbancario'])) {echo $get_id_cuentab['0']['num_codigo_interbancario'];}
                                                                            }else{

                                                                            }
                                                                        ?>" <?php echo $disabled ?>>
                                                                    </div>
                                                                </div>
                                                            <?php }  ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="formulario_termino" class="section general-info">
                                <input name="id_usuariodp" type="hidden" class="form-control" id="id_usuariodp" value="<?php echo $get_id[0]['id_usuario']; ?>">
                                <input name="id_usuariot" type="hidden" class="form-control" id="id_usuariot" value="<?php echo $get_id[0]['id_usuario']; ?>">

                                <div class="widget-content widget-content-area">
                                        <div class="row">
                                            <div class="col">
                                                <div class="col-md-12 text-left custom-control custom-checkbox checkbox-success">
                                                    <input type="checkbox" class="custom-control-input" <?php if($get_id[0]['terminos']==1){ echo "disabled checked";} ?> onclick="Terminos();" value="1" id="termino" name="termino">
                                                    <label class="custom-control-label" for="termino">He leído y Acepto la
                                                        <a href="#" style="cursor:pointer;" title="Política de Privacidad" data-toggle="modal" data-target="#zoomupTerminos">
                                                        Política de Privacidad</a>
                                                        de la Numero 1
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-12 text-right">
                                                <?php if($editable==0){?>
                                                    <button class="btn btn-primary mt-3" type="button" onclick="GuardarCambios('<?php echo session('usuario')->id_nivel ?>');">Guardar</button>
                                                    <?php }else{?> &nbsp;<?php }?>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $("#usuario").addClass('active');
        $("#husuario").attr('aria-expanded','true');
        $("#upersonales").addClass('active');
        $('.dropify').dropify();

        Planilla_Parte_Superior();
        Planilla_Parte_Inferior();
    });

    function solo_Numeros(e) {
        var key = event.which || event.keyCode;
        if (key >= 48 && key <= 57) {
            return true;
        } else {
            return false;
        }
    }

    function solo_Numeros_Punto(e) {
        var key = event.which || event.keyCode;
        if ((key >= 48 && key <= 57) || key == 46) {
            if (key == 46 && event.target.value.indexOf('.') !== -1) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    function Valida_Archivo(val) {
        var archivoInput = document.getElementById(val);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;

        if (!extPermitidas.exec(archivoRuta)) {
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivo con extensión .pdf|.jpg|.png|.jpeg",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        } else {
            return true;
        }
    }

    function Planilla_Parte_Superior(){
        Cargando();

        var url = "{{ route('colaborador_pl.parte_superior', $get_id[0]['id_usuario']) }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#parte_superior_pl').html(resp);
            }
        });
    }

    function Planilla_Parte_Inferior(){
        Cargando();

        var url = "{{ route('colaborador_pl.parte_inferior', $get_id[0]['id_usuario']) }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#parte_inferior_pl').html(resp);
            }
        });
    }

    function Valida_Planilla_Activa(id){
        Cargando();

        var url = "{{ url('ColaboradorController/Valida_Planilla_Activa') }}";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_usuario': id
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                if(data=="0"){
                    $('#btn_registrar_planilla').click();
                }else{
                    Swal({
                        title: '¡Advertencia!',
                        text: "¡Existe un registro en estado activo! Por favor actualice Fecha Fin del último registro para continuar",
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                    });
                }
            }
        });
    }

    function Cambio_Situacion(v){
        if($('#id_situacion_laboral'+v).val()=="2" || $('#id_situacion_laboral'+v).val()=="3"){
            $('.ver_sl'+v).show();
        }else{
            $('.ver_sl'+v).hide();
            $('#id_tipo_contrato'+v).val('0');
            $('#id_empresa'+v).val('0');
            $('#id_regimen'+v).val('0');
            if(v=="r"){
                $('#bono'+v).val('');
            }
        }
    }

    function Fecha_Vencimiento(v){
        if($('#id_tipo_contrato'+v).val()=="1"){
            $('.ver_fv'+v).hide();
            $('#fec_vencimiento'+v).val('');
        }else{
            $('.ver_fv'+v).show();
        }
    }

    function Delete_Planilla(id) {
        Cargando();

        var url = "{{ route('colaborador_pl.destroy', ':id') }}".replace(':id', id);

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Planilla_Parte_Superior();
                            Planilla_Parte_Inferior();
                        });    
                    }
                });
            }
        })
    }

    var checkaractualidad = document.getElementById('checkactualidad');
    var dia_finel = document.getElementById('dia_finel');
    var mes_finel = document.getElementById('mes_finel');
    var anio_finel = document.getElementById('anio_finel');

    checkaractualidad.onchange = function() {
        dia_finel.disabled = !!this.checked;
        mes_finel.disabled = !!this.checked;
        anio_finel.disabled = !!this.checked;
    };


    $(document).ready(function() {
        $("#usuario").addClass('active');
        $("#husuario").attr('aria-expanded','true');
        $("#upersonales").addClass('active');
    });

    function area(){
        var url = "{{ url('ColaboradorController/List_Area') }}";
        $.ajax({
            url: url,
            type: 'POST',
            //data: frm,
            data: $("#formulario_datos_laborales").serialize(),
            success: function(data)
            {
                $('#marea').html(data);
                puesto();
                cargo();

            }
        });
    }

    function empresa(){
        var dataString = $("#formulario_datos_planilla").serialize();
        var url="{{ url('ColaboradorController/List_Empresa') }}";
        var id_situacion = $('#id_situacion_laboral').val();
        if(id_situacion=="2"){

            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    //window.location = "<?php //echo url(); ?>ColaboradorController/Cargo";
                    $('#memprepl').html(data);

                }
            });

        }else{
            $('#memprepl').html("");
        }
    }

    function PlanillaEmpresa(){
        var div = document.getElementById("memprepl");

        if($('#id_situacion_laboral').val() == 2) {
            div.style.display = "block";
        }else{
            div.style.display = "none";
        }
    }

    function puesto(){
        var url = "{{ url('ColaboradorController/List_Puesto') }}";
        $.ajax({
            url: url,
            type: 'POST',
            //data: frm,
            data: $("#formulario_datos_laborales").serialize(),
            success: function(data)
            {
                $('#mpuesto').html(data);
                cargo();
            }
        });
    }

    function cargo(){
        var url = "{{ url('ColaboradorController/List_Cargo') }}";
        $.ajax({

            url: url,
            type: 'POST',
            //data: frm,
            data: $("#formulario_datos_laborales").serialize(),
            success: function(data)
            {
                $('#mcargo').html(data);
            }
        });
    }
</script>

<script>
    google.maps.event.addDomListener(window, 'load', function(){
        var lati = <?php if(isset($get_id_d['0']['lat'])) {echo $get_id_d['0']['lat'];} else {echo "-12.0746254";}?>;
        var lngi = <?php if(isset($get_id_d['0']['lng'])) {echo $get_id_d['0']['lng'];} else {echo "-77.021754";}?>;

        var coords = {lat: lati, lng: lngi};

        setMapa(coords);

        function setMapa (coords)
        {
            //Se crea una nueva instancia del objeto mapa
            var mapa =  new google.maps.Map(document.getElementById('map'),{
                            zoom: 18,
                            center: coords,
                        });

            texto = '<h1> Nombre del lugar</h1>'+'<p> Descripción del lugar </p>'+
                    '<a href="https://www.lanumero1.com.pe/" target="_blank">Página WEB</a>';

            //Creamos el marcador en el mapa con sus propiedades
            //para nuestro obetivo tenemos que poner el atributo draggable en true
            //position pondremos las mismas coordenas que obtuvimos en la geolocalización
            marker = new google.maps.Marker({
                position: coords,
                map: mapa,
                draggable: true,
                animation: google.maps.Animation.DROP,
                title: 'Ubicación de Mi Casa'
            });

            var informacion = new google.maps.InfoWindow({
                content: texto
            });

            marker.addListener('click', function(){
                informacion.open(mapa, marker);
            });

            //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
            //cuando el usuario a soltado el marcador
            marker.addListener('click', toggleBounce);

            marker.addListener( 'dragend', function (event){
                //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
                document.getElementById("coordsltd").value = this.getPosition().lat();
                document.getElementById("coordslgt").value = this.getPosition().lng();
            });

            var autocomplete = document.getElementById('autocomplete');

            const search = new google.maps.places.Autocomplete(autocomplete);
            search.bindTo("bounds", mapa);

            search.addListener('place_changed', function(){
                informacion.close();
                marker.setVisible(false);

                var place = search.getPlace();

                if(!place.geometry.viewport){
                    window.alert("Error al mostrar el lugar");
                    return;
                }

                if(place.geometry.viewport){
                    mapa.fitBounds(place.geometry.viewport);
                }else{
                    mapa.setCenter(place.geometry.location);
                    mapa.setZoom(18);
                }

                marker.setPosition(place.geometry.location);

                marker.setVisible(true);

                var address = "";
                if(place.address_components){
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || ''),
                    ]
                }

                informacion.setContent('<div><strong>'+place.name + '</strong><br>' + address);
                informacion.open(map, marker);

                document.getElementById("coordsltd").value = place.geometry.location.lat();
                document.getElementById("coordslng").value = place.geometry.location.lng();

            });

        }

        function toggleBounce() {
            if (marker.getAnimation() !== null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
        }
    });
</script>

<script>
    function provincia(){
        var url = "{{ url('ColaboradorController/Provincia') }}";
        $.ajax({
            url: url,
            type: 'POST',
            //data: frm,
            data: $("#formulario_domicilio").serialize(),
            success: function(data)
            {
                $('#mprovincia').html(data);
            }
        });
        distrito();
    }

    function distrito(){
        var url = "{{ url('ColaboradorController/Distrito') }}";
        $.ajax({
            url: url,
            type: 'POST',
            //data: frm,
            data: $("#formulario_domicilio").serialize(),
            success: function(data)
            {
                $('#mdistrito').html(data);
            }
        });
    }
</script>
@endsection



<div id="zoomupModalDocPlanilla" class="modal animated zoomInUp custo-zoomInUp bd-example-modal-xl" role="dialog" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Vista Previa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="col-md-12 row">
                    <div class="form-group col-sm-12">
                    <div id="datos_ajax"></div>
                        <input type="hidden" name="rutafoto" id="rutafoto" value= '<?php //echo base_url() ?>'>
                            <div align="center" id="capital222"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="zoomupModalCV" class="modal animated zoomInUp custo-zoomInUp bd-example-modal-xl" role="dialog" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Vista Previa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 row">
                    <div class="form-group col-sm-12">
                        <div id="datos_ajax"></div>
                        <input type="hidden" name="rutacv" id="rutacv" value= ''>
                            <div align="center" id="cv"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="zoomupModalDNI" class="modal animated zoomInUp custo-zoomInUp bd-example-modal-xl" role="dialog" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Vista Previa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 row">
                    <div class="form-group col-sm-12">
                        <div id="datos_ajax"></div>
                        <input type="hidden" name="rutadni" id="rutadni" value= ''>
                            <div align="center" id="dni"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="zoomupModalRecibo" class="modal animated zoomInUp custo-zoomInUp bd-example-modal-xl" role="dialog" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Vista Previa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 row">
                    <div class="form-group col-sm-12">
                        <div id="datos_ajax"></div>
                        <input type="hidden" name="rutarecibo" id="rutarecibo" value= ''>
                            <div align="center" id="recibo"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="zoomupTerminos" class="modal animated zoomInUp custo-zoomInUp bd-example-modal-xl" role="dialog" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">PRIVACIDAD Y PROTECCIÓN DE DATOS</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 row">
                    <div class="form-group col-sm-12">
                        <!--<p>Podremos solicitar a los usuarios o clientes información relativa a su nombre, dirección electrónica,
                            número telefónico. Te aseguramos que estos datos no serán manejados por ninguna empresa que no pertenezca
                            upo de empresas La Numero 1 y serán tratados de manera confidencial, conforme a lo establecido por la
                            legislación vigente y exclusivamente utilizados para procesar la compra, el despacho y, en su caso,
                            para el envío de publicidad sobre ofertas y promociones.</p><br>-->
                        <b>Por Politica de Privacidad</b>
                        <p>La numero 1 estamos comprometidos con mantener  la privacidad  y protección de información de
                            nuestros colaboradores . Asimismo tiene un compromiso por el respeto y cumplimiento de lo dispuesto
                            por la Ley N°29733-Ley de Protección de Datos Personales y su reglamento aprobado por Decreto
                            Supremo N°003-2013-JUS.</p>
                        <p>La protección de datos es una cuestión de confianza y privacidad, por ello es importante para
                            nosotros. Por lo tanto, utilizaremos solamente su nombre y otra información referente a Ud. bajo
                            los términos previstos en nuestra Política de Privacidad.</p>
                        <p>Nuestra Política de Privacidad explica cómo recolectamos, utilizamos y divulgamos su información
                            personal y explica las medidas que hemos tomado para asegurar su información personal.
                            La empresa adopta los niveles de seguridad de protección de los datos personales legalmente
                            requeridos.</p>
                        <p>Nosotros recogeremos, almacenaremos y procesaremos los datos para el procesamiento fines de recursos
                            humanos y para cualquier información posterior,. Podemos recopilar información personal, incluyendo
                            pero no limitado a, el título, nombre, fecha de nacimiento, dirección de correo electrónico, número
                            de teléfono, número de teléfono celular y  otros datos.</p>
                        <p>Cada colaborador  se compromete y garantiza que los Datos Personales que suministre a La Empresa son
                            veraces y actuales. En tal sentido, será el responsable de comunicar oportunamente, mediante las
                            vías establecidas por esta, sobre cualquier corrección o modificación que se produzca en ellos.</p>
                        <p>Los colaboradores  tendrán total libertad para ejercitar los derechos establecidos en la Ley No.
                            29733 y su reglamento, sobre los derechos ARCO (Acceso, Rectificación, Cancelación y Oposición);
                            la empresa garantiza por su parte, el respeto y observancia al ejercicio de dichos derechos, para lo
                            cual puede enviar una comunicación al correo electrónico
                            <a href="mailto:hola@lanumero1.com.pe">hola@lanumero1.com.pe</a></p>
                        <p>La empresa requiere del consentimiento libre, previo, expreso , inequívoco e informado del titular
                            de los datos personales para el tratamiento de los mismos, en consecuencia desde el momento de su
                            ingreso o uso de nuestro sitio web, el titular de datos otorga su total consentimiento para el
                            tratamiento de los datos personales que consigna al dar check en la opción Acepto los términos y
                            condiciones y dar clic en el botón de envio de formulario.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function validarFotoHijo(){
        var archivoInput = document.getElementById('documento');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG, JPEG, PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }

    function validarEstudiosGenerales(){
        var archivoInput = document.getElementById('documentoe');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG ,JPEG ,PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }

    function validarCursosComplementarios(){
        var archivoInput = document.getElementById('certificado');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG ,JPEG ,PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }

    function validarCOVID(){
        var archivoInput = document.getElementById('certificadootr');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG ,JPEG ,PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }

    function validar_vacuCOVID(){
        var archivoInput = document.getElementById('certificadootr_vacu');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG ,JPEG ,PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }

    function validarfilecv_doc(){
        var archivoInput = document.getElementById('filecv_doc');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG ,JPEG ,PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }

    function validarfiledni_doc(){
        var archivoInput = document.getElementById('filedni_doc');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG ,JPEG ,PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }

    function validarfilerecibo_doc(){
        var archivoInput = document.getElementById('filerecibo_doc');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG ,JPEG ,PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }

    function validarcartarenuncia(){
        var archivoInput = document.getElementById('carta_renuncia');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG ,JPEG ,PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }
    function validareval_psicolo(){
        var archivoInput = document.getElementById('eval_sicologico');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG ,JPEG ,PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }

    function validarfileconvenio_laboral(){
        var archivoInput = document.getElementById('convenio_laboral');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.jpeg|.png|.pdf)$/i;
            if(!extPermitidas.exec(archivoRuta)){
                    swal.fire(
                        '!Archivo no permitido!',
                        'El archivo debe ser JPG ,JPEG ,PNG o PDF',
                        'error'
                    )
                archivoInput.value = '';
                return false;
            }
            else
            {
            }
    }


    $('#zoomupModalDocPlanilla').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var imagen = button.data('imagen'); // Extraer la información de atributos de datos
        var imagen2 = imagen.substr(-3);
        var rutapdf= $("#rutafoto").val();
        var nombre_archivo= rutapdf+imagen;

        if (imagen!=""){
            if (imagen2=="PDF" || imagen2=="pdf")
            {
                document.getElementById("capital222").innerHTML = "<iframe height='350px' width='100%' src='"+nombre_archivo+"'></iframe>";
            }
            else
            {
                document.getElementById("capital222").innerHTML = "<img src='"+nombre_archivo+"'>";
            }
        }
        else
        {
            document.getElementById("capital222").innerHTML = "No se ha registrado ningún archivo";
        }

        var modal = $(this)
        modal.find('.modal-title').text('Documento')
        $('.alert').hide();//Oculto alert
    })

    $('#zoomupModalCV').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var imagen = button.data('imagen'); // Extraer la información de atributos de datos
        var imagen2 = imagen.substr(-3);
        var rutapdf= $("#rutacv").val();
        var nombre_archivo= rutapdf+imagen;

        if (imagen!=""){
            if (imagen2=="PDF" || imagen2=="pdf")
            {
                document.getElementById("cv").innerHTML = "<iframe height='350px' width='100%' src='"+nombre_archivo+"'></iframe>";
            }
            else
            {
                document.getElementById("cv").innerHTML = "<img src='"+nombre_archivo+"'>";
            }
        }
        else
        {
            document.getElementById("cv").innerHTML = "No se ha registrado ningún archivo";
        }

        var modal = $(this)
        modal.find('.modal-title').text('Currículum VITAE')
        $('.alert').hide();//Oculto alert
    })

    $('#zoomupModalDNI').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var imagen = button.data('imagen'); // Extraer la información de atributos de datos
        var imagen2 = imagen.substr(-3);
        var rutapdf= $("#rutadni").val();
        var nombre_archivo= rutapdf+imagen;

        if (imagen!=""){
            if (imagen2=="PDF" || imagen2=="pdf")
            {
                document.getElementById("dni").innerHTML = "<iframe height='350px' width='100%' src='"+nombre_archivo+"'></iframe>";
            }
            else
            {
                document.getElementById("dni").innerHTML = "<img src='"+nombre_archivo+"'>";
            }
        }
        else
        {
            document.getElementById("dni").innerHTML = "No se ha registrado ningún archivo";
        }

        var modal = $(this)
        modal.find('.modal-title').text('DNI')
        $('.alert').hide();//Oculto alert
    })

    $('#zoomupModalRecibo').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var imagen = button.data('imagen'); // Extraer la información de atributos de datos
        var imagen2 = imagen.substr(-3);
        var rutapdf= $("#rutarecibo").val();
        var nombre_archivo= rutapdf+imagen;

        if (imagen!=""){
            if (imagen2=="PDF" || imagen2=="pdf")
            {
                document.getElementById("recibo").innerHTML = "<iframe height='350px' width='100%' src='"+nombre_archivo+"'></iframe>";
            }
            else
            {
                document.getElementById("recibo").innerHTML = "<img src='"+nombre_archivo+"'>";
            }
        }
        else
        {
            document.getElementById("recibo").innerHTML = "No se ha registrado ningún archivo";
        }

        var modal = $(this)
        modal.find('.modal-title').text('Recibo de Luz/Agua')
        $('.alert').hide();//Oculto alert
    })

</script>

<script>


    $('#num_cele').inputmask("999999999");


    <?php $op = 0; foreach($list_banco as $list) { $op++; ?>
    $('#num_cuenta_bancaria_<?php echo $op; ?>').inputmask("<?php for ($y = 1; $y<= $list['digitos_cuenta']; $y++) { echo "9";} ?>");
    $('#num_codigo_interbancario_<?php echo $op; ?>').inputmask("<?php for ($y = 1; $y<= $list['digitos_cci']; $y++) { echo "9";} ?>");
    <?php  } ?>


    $(document).ready(function() {
        $("#id_banco").on('change', function() {
            $(this).find("option:selected").each(function() {
                var geeks = $(this).attr("value");
                if (geeks) {
                    $(".GFG").not("." + geeks).hide();
                    for (i = 1; i <= lista_banco; i++) {
                        if(i == geeks){
                            $('#num_cuenta_bancaria_'+i).removeAttr("disabled");
                            $('#num_codigo_interbancario_'+i).removeAttr("disabled");
                        }else{
                            $('#num_cuenta_bancaria_'+i).val('');
                            $('#num_cuenta_bancaria_'+i).attr("disabled", true);
                            $('#num_codigo_interbancario_'+i).attr("disabled", true);
                            $('#num_codigo_interbancario_'+i).val('');
                        }
                    }
                    $("." + geeks).show();
                } else {
                    $(".GFG").hide();
                }
            });
        }).change();

        if($('#dia_nac').val() !=0 && $('#mes_nac').val()!=0 && $('#anio_nac').val()!=0){

        var fec_nac="'"+$('#anio_nac').val()+"-"+$('#mes_nac').val()+"-"+$('#dia_nac').val()+"'";

        var fecha = new Date(fec_nac);
        var hoy = new Date();
        var cumpleanos = new Date(fecha);
        var edad = hoy.getFullYear() - cumpleanos.getFullYear();
        var m = hoy.getMonth() - cumpleanos.getMonth();

        if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
            edad--;
        }

        $('#cedad').val(edad);

        } else{
            $('#cedad').val('');
        }
    });

    $(function(){
        $('#dia_nac').on('change', calcularEdad);
    });

    $(function(){
        $('#mes_nac').on('change', calcularEdad);
    });

    $(function(){
        $('#anio_nac').on('change', calcularEdad);
    });

    function calcularEdad(){
        if($('#dia_nac').val() !=0 && $('#mes_nac').val()!=0 && $('#anio_nac').val()!=0){

            var fec_nac="'"+$('#anio_nac').val()+"-"+$('#mes_nac').val()+"-"+$('#dia_nac').val()+"'";

            var fecha = new Date(fec_nac);
            var hoy = new Date();
            var cumpleanos = new Date(fecha);
            var edad = hoy.getFullYear() - cumpleanos.getFullYear();
            var m = hoy.getMonth() - cumpleanos.getMonth();

            if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
                edad--;
            }

            $('#cedad').val(edad);

        }else{
            $('#cedad').val('');
        }

    }

    function List_Datos_Laborales(id_usuario){
        Cargando();
        var url = "{{ url('ColaboradorController/List_Datos_Laborales') }}";
        var csrfToken = $('input[name="_token"]').val();
        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'id_usuario':id_usuario},
            success: function(data)
            {
                $('#datoslaborales').html(data);

            }
        });
    }

    function Adjuntar_DocumentacionRRHH() {
        Cargando();
        var dataString = new FormData(document.getElementById('formulario_adjuntar_documentacionrrhh'));
        var url = "{{ url('ColaboradorController/Update_Adjuntar_DocumentacionRRHH') }}";
        var csrfToken = $('input[name="_token"]').val();
        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    'Actualización Exitosa!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    $('#adjuntar_documentacionrrhh').html(data);
                });
            }
        });
    }

    function Actualizar_DirectorioT() {
        Cargando();
        var dataString = new FormData(document.getElementById('directorio_telefonico'));
        var url = "{{ url('ColaboradorController/Insert_Directorio_Telefonico') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    'Actualización Exitosa!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    $('#direct_telefonico').html(data);
                });
            }
        });
    }
    function Valida_DirectorioT() {
        if ($('#id_respuesta_directorio_telefonico').val() == '1') {

            $("#num_cele").prop('disabled', false);
            $("#num_fijoe").prop('disabled', false);
            $("#emailp").prop('disabled', false);
            $("#num_anexoe").prop('disabled', false);
        }

        if ($('#id_respuesta_directorio_telefonico').val() != '1') {
            $("#num_cele").prop('disabled', true);
            $("#num_fijoe").prop('disabled', true);
            $("#emailp").prop('disabled', true);
            $("#num_anexoe").prop('disabled', true);

        }
    }

    function GDatosP() {
        Cargando();

        var dataString = new FormData(document.getElementById('edatos'));
        var url = "{{ url('ColaboradorController/Update_GDatosP') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_GDatosP()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_GDatosP();
                    });
                }
            });
        }
    }

    function Lista_GDatosP(){
        Cargando();

        var dataString = new FormData(document.getElementById('edatos'));
        var url = "{{ url('ColaboradorController/Lista_GDatosP') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#mdatos').html(data);
            }
        });
    }

    function Valida_GDatosP() {
        if ($('#usuario_apater').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar su apellido paterno',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#usuario_amater').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar su apellido materno',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#usuario_nombres').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar su nombre',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_nacionalidad').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar su nacionalidad',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_tipo_documento').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar su el tipo de documento a ingresar',
                'Debe ingresar titulo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#num_doc').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar su n° de documento',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_genero').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar su genero',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#dia_nac').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar el día de nacimiento',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#mes_nac').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar su el mes de su nacimiento',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#anio_nac').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar su el año en que nació',
                'warning'
            ).then(function() { });
            inputFocus = '#anio_nac';
            return false;
        }

        var fec_nacimiento = "'" + $('#anio_nac').val() + "-" + $('#mes_nac').val() + "-" + $('#dia_nac').val() + "'";
        var fecha = new Date(fec_nacimiento);
        var dias = 2;
        fecha.setDate(fecha.getDate() - dias);

        var hoy = new Date();
        var fecha = fecha;

        var edad = hoy.getFullYear() - fecha.getFullYear();
        var m = hoy.getMonth() - fecha.getMonth();

        if (m < 0 || (m === 0 && hoy.getDate() < fecha.getDate())) {
            edad--;
        }
        if (edad < 18) {
            Swal(
                'Ups!',
                'Debe ser mayor a 18 años de edad para actualizar datos',
                'warning'
            ).then(function() { });
            return false;
        }


        if ($('#id_estado_civil').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar su estado civil',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#usuario_email').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar su correo electronico',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#num_celp').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar su número de celular',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function GustosP() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_gustop'));
        var url = "{{ url('ColaboradorController/Update_GustosP') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_GustosP()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_GustosP();
                    });
                }
            });
        }
    }

    function Valida_GustosP() {
        if ($('#plato_postre').val().trim() === '' && $('#galletas_golosinas').val().trim() === '' && $('#ocio_pasatiempos').val().trim() === ''
        && $('#artistas_banda').val().trim() === '' && $('#genero_musical').val().trim() === '' && $('#pelicula_serie').val().trim() === ''
        && $('#colores_favorito').val().trim() === '' && $('#redes_sociales').val().trim() === '' && $('#deporte_favorito').val().trim() === ''
        && $('#id_zona').val() === '0' && $('#mascota').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar al menos un gusto o preferencia',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }

    function Confirmar_Revision_Perfil(id_usuario){
        Cargando();

        var url = "{{ url('ColaboradorController/Confirmar_Revision_Perfil') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea confirmar revisión de datos de perfil?',
            text: "Los módulos no serán editables para el usuario",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id_usuario':id_usuario
                    },
                    success: function() {
                        Swal(
                            'Revisado!',
                            '',
                            'success'
                        ).then(function() {
                            window.location.reload();
                        });
                    }
                });
            }
        })
    }

    function Habilitar_Edicion_Perfil(id_usuario){
        Cargando();

        var estado_edicion=1;
        var titulo="deshabilitar";
        var texto="no serán";
        var mensaje="Deshabilitado!";
        if($('#habilitar_edicion').is(":checked")){
            var estado_edicion=0;
            var titulo="habilitar";
            var texto="serán";
            var mensaje="Habilitado!";
        }

        var url = "{{ url('ColaboradorController/Habilitar_Edicion_Perfil') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea '+titulo+' edición?',
            text: "Los módulos "+texto+" editables para el usuario",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'estado_edicion': estado_edicion,
                        'id_usuario':id_usuario
                    },
                    success: function() {
                        Swal(
                            mensaje,
                            '',
                            'success'
                        ).then(function() {
                            window.location.reload();
                        });
                    }
                });
            }else{
                if($('#habilitar_edicion').is(":checked")){
                    $('#habilitar_edicion').prop('checked', false);
                }else{
                    $('#habilitar_edicion').prop('checked', true);
                }

            }
        })
    }


    function DomilcilioP() {
        var dataString = new FormData(document.getElementById('formulario_domicilio'));
        var url = "{{ url('ColaboradorController/Update_DomilcilioP') }}";
        var url2 = "{{ url('ColaboradorController/Update_DomilcilioP_Titulo') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_DomilcilioP()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#domiciliodatos').html(data);
                        $.ajax({
                            url: url2,
                            data: dataString,
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            processData: false,
                            contentType: false,
                            success: function(data) {

                                $('#domicilio_titulo').html(data);

                            }
                        });
                    });
                }
            });
        }
    }

    function Valida_DomilcilioP() {
        if ($('#id_departamento').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar departamento',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_provincia').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar provincia',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_distrito').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar distrito',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    let inputs = document.querySelectorAll('.limpiaref');
    let selects = document.querySelectorAll('.limpiarefselect');

    function ReferenciaF() {
        var dataString = new FormData(document.getElementById('formulario_referenciaf'));
        var url = "{{ url('ColaboradorController/Insert_ReferenciaF') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_ReferenciaF()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#mdreferenciaf').html(data);
                        MDatos_ReferenciaF();
                    });
                }
            });
        }
    }

    function Update_ReferenciaF() {
        var dataString = new FormData(document.getElementById('formulario_referenciaf'));
        var url = "{{ url('ColaboradorController/Update_ReferenciaF') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_ReferenciaF()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#mdreferenciaf').html(data);
                        MDatos_ReferenciaF();
                    });
                }
            });
        }
    }

    function MDatos_ReferenciaF() {
        var dataString = new FormData(document.getElementById('formulario_referenciaf'));
        var url = "{{ url('ColaboradorController/MDatos_ReferenciaF') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#mureferenciaf').html(data);
                $('#btnReferenciaF').html("<a onclick='ReferenciaF();' title='Agregar Familiar' class='btn btn-danger'>Agregar</a>");
            }
        });
    }

    function Valida_ReferenciaF() {
        if ($('#nom_familiar').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar nombre del familiar',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_parentesco').val() == '0') {
            Swal(
                'Ups!',
                'Debe indique el parentesco',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#dia_nacf').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar el dìa de nacimiento',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#mes_nacf').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar el mes de nacimiento ',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#anio_nacf').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar el año de nacimiento',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#celular1').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar el celular principal',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Detalle_Referencia_Familiar(id) {
        var id = id;
        var url = "{{ url('ColaboradorController/Detalle_Referencia_Familiar') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_referencia_familiar': id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#mureferenciaf').html(data);
                $('#btnReferenciaF').html("<a onclick='Update_ReferenciaF();' title='Actualizar Familiar' class='btn btn-primary'>Actualizar</a>");
            }
        });
    }

    function Delete_Referencia_Familiar(id, id_usu) {
        var id = id;
        var id_usu = id_usu;
        var url = "{{ url('ColaboradorController/Delete_Referencia_Familiar') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id_referencia_familiar': id,
                        'id_usuario': id_usu
                    },
                    success: function(data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            $('#mdreferenciaf').html(data);
                        });
                    }
                });
            }
        })
    }


    function Hijos() {
        let inputhijos = document.querySelectorAll('.limpiarhijos');
        let selectshijos = document.querySelectorAll('.limpiarefselecthijos');
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_hijos'));
        var url = "{{ url('ColaboradorController/Insert_Hijos_Usuario') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_HijosU()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#archivoInputdni').html('');
                        inputhijos.forEach(input => input.value = '');
                        selectshijos.forEach(option => option.value = '0');
                        Lista_Hijos();
                    });
                }
            });
        }
    }

    function Lista_Hijos(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_hijos'));
        var url = "{{ url('ColaboradorController/Lista_Hijos') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#mdhijos').html(data);
            }
        });
    }

    function Update_Hijos() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_hijos'));
        var url = "{{ url('ColaboradorController/Update_Hijos') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_HijosU()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        MDatos_Hijos();
                        Lista_Hijos();
                    });
                }
            });
        }
    }

    function MDatos_Hijos() {
        var dataString = new FormData(document.getElementById('formulario_hijos'));
        var url = "{{ url('ColaboradorController/MDatos_Hijos') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#muhijos').html(data);
                $('#btnHijos').html("<a onclick='Hijos();' title='Agregar Familiar' class='btn btn-danger'>Agregar</a>");
                ValidaH();
            }
        });
    }

    function Valida_HijosU() {
        if ($('#id_respuestah').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar opción',
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#id_respuestah').val() == '1') {
            if ($('#nom_hijo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar nombre de hijo',
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#id_generoh').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar genero del hijo',
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#dia_nachj').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar el dìa de nacimiento',
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#mes_nachj').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar el mes de nacimiento',
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#anio_nachj').val() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar el año de nacimiento',
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#num_dochj').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar número de DNI',
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#id_biologico').val() == '0') {
            Swal(
                'Ups!',
                'Debe indicar si es biológico o no',
                'warning'
            ).then(function() { });
                return false;
            }
        }
        return true;
    }

    function Detalle_Hijos_Usuario(id) {
        Cargando();
        var id = id;
        var url = "{{ url('ColaboradorController/Detalle_Hijos_Usuario') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'id_hijos': id
            },
            success: function(data) {
                $('#muhijos').html(data);
                $('#btnHijos').html("<a onclick='Update_Hijos();' title='Actualizar Datos' class='btn btn-primary'>Actualizar</a>");
            }
        });
    }

    function Delete_Hijos_Usuario(id, id_usu) {
        Cargando();

        var id = id;
        var id_usu = id_usu;
        var url = "{{ url('ColaboradorController/Delete_Hijos_Usuario') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id_hijos': id,
                        'id_usuario': id_usu
                    },
                    success: function(data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Hijos();
                            ValidaH();
                        });
                    }
                });
            }
        })
    }

    function ValidaH() {
        if ($('#id_respuestah').val() == '1') {
            $("#nom_hijo").prop('disabled', false);
            $("#id_generoh").prop('disabled', false);
            $("#dia_nachj").prop('disabled', false);
            $("#mes_nachj").prop('disabled', false);
            $("#anio_nachj").prop('disabled', false);
            $("#num_dochj").prop('disabled', false);
            $("#id_biologico").prop('disabled', false);
            $("#documento").prop('disabled', false);
            $('#btnHijos').html("<a onclick='Hijos();' title='Agregar Hijos' class='btn btn-danger'>Agregar</a>");
        }

        if ($('#id_respuestah').val() != '1') {
            $("#nom_hijo").prop('disabled', true);
            $("#id_generoh").prop('disabled', true);
            $("#dia_nachj").prop('disabled', true);
            $("#mes_nachj").prop('disabled', true);
            $("#anio_nachj").prop('disabled', true);
            $("#num_dochj").prop('disabled', true);
            $("#id_biologico").prop('disabled', true);
            $("#documento").prop('disabled', true);
            $('#btnHijos').html("<a onclick='Update_Hijos();' title='Actualizar Hijo' class='btn btn-primary'>Actualizar</a>");

            $("#nom_hijo").val('');
            $("#id_generoh").val('0');
            $("#dia_nachj").val('0');
            $("#mes_nachj").val('0');
            $("#anio_nachj").val('0');
            $("#num_dochj").val('');
            $("#id_biologico").val('0');
            $("#documento").val('');
        }
    }


    function ContactoE() {
        let inputContactoE = document.querySelectorAll('.limpiarContactoE');
        let selectsContactoE = document.querySelectorAll('.limpiarefselectContactoE');
        var dataString = new FormData(document.getElementById('formulario_contactoe'));
        var url = "{{ url('ColaboradorController/Insert_ContactoE') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_ContactoE()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#mdcontactoe').html(data);
                        inputContactoE.forEach(input => input.value = '');
                        selectsContactoE.forEach(option => option.value = '0');
                    });
                }
            });
        }
    }

    function Update_ContactoE() {
        var dataString = new FormData(document.getElementById('formulario_contactoe'));
        var url = "{{ url('ColaboradorController/Update_ContactoE') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_ContactoE()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#mdcontactoe').html(data);
                        MDatos_ContactoE();
                    });
                }
            });
        }
    }

    function Valida_ContactoE() {
        if ($('#nom_contacto').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar nombre de contacto de emergencia',
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#id_parentescoce').val() == '') {
            Swal(
                'Ups!',
                'Debe indicar el parentesco del Contacto de Emergencia',
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#celular1ce').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar el celular del contacto de emergencia ',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function MDatos_ContactoE() {
        var dataString = new FormData(document.getElementById('formulario_contactoe'));
        var url = "{{ url('ColaboradorController/MDatos_ContactoE') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#mucontactoe').html(data);
                $('#btnContactoE').html("<a onclick='ContactoE();' title='Agregar Contacto de Emergencia' class='btn btn-danger'>Agregar</a>");
            }
        });
    }

    function Detalle_ContactoE(id) {
        var id = id;
        var url = "{{ url('ColaboradorController/Detalle_ContactoE') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            data: {
                'id_contacto_emergencia': id
            },
            success: function(data) {
                $('#mucontactoe').html(data);
                $('#btnContactoE').html("<a onclick='Update_ContactoE();' title='Actualizar Contacto de Emergencia' class='btn btn-primary'>Actualizar</a>");
            }
        });
    }

    function Delete_Contacto_Emergencia(id, id_usu) {
        var id = id;
        var id_usu = id_usu;
        var url = "{{ url('ColaboradorController/Delete_ContactoE') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    url: url,
                    data: {
                        'id_contacto_emergencia': id,
                        'id_usuario': id_usu
                    },
                    success: function(data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            $('#mdcontactoe').html(data);
                        });
                    }
                });
            }
        })
    }

    function EstudiosG() {
        console.log('estudios');
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_estudiosg'));
        var url = "{{ url('ColaboradorController/Insert_EstudiosG') }}";
                var csrfToken = $('input[name="_token"]').val();

        if (Valida_EstudiosG()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        MDatos_EstudiosG();
                        Lista_EstudiosG();
                    });
                }
            });
        }
    }

    function Lista_EstudiosG() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_estudiosg'));
        var url = "{{ url('ColaboradorController/Lista_EstudiosG') }}";
                var csrfToken = $('input[name="_token"]').val();


        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#mdestudiosg').html(data);
            }
        });
    }

    function Update_EstudiosG() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_estudiosg'));
        var url = "{{ url('ColaboradorController/Update_EstudiosG') }}";
                var csrfToken = $('input[name="_token"]').val();

        if (Valida_EstudiosG()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        MDatos_EstudiosG();
                        Lista_EstudiosG();
                    });
                }
            });
        }
    }

    function Valida_EstudiosG() {
        if ($('#id_grado_instruccion').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar grado de instrucción',
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#carrera').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar el nombre de la carrera',
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#centro').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar el nombre del centro de estudios',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }

    function MDatos_EstudiosG() {
        var dataString = new FormData(document.getElementById('formulario_estudiosg'));
        var url = "{{ url('ColaboradorController/MDatos_EstudiosG') }}";
                var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#muestudiosg').html(data);
                $('#btnEstudiosG').html("<a onclick='EstudiosG();' title='Agregar Estudios Generales' class='btn btn-danger'>Agregar</a>");
            }
        });
    }

    function Detalle_EstudiosG(id) {
        Cargando();
        var id = id;
        var url = "{{ url('ColaboradorController/Detalle_EstudiosG') }}";
                var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            url: url,
            data: {
                'id_estudios_generales': id
            },
            success: function(data) {
                $('#muestudiosg').html(data);
                $('#btnEstudiosG').html("<a onclick='Update_EstudiosG();' title='Actualizar Contacto de Emergencia' class='btn btn-primary'>Actualizar</a>");
            }
        });
    }

    function Delete_EstudiosG(id, id_usu) {
        Cargando();

        var id = id;
        var id_usu = id_usu;
        var url = "{{ url('ColaboradorController/Delete_EstudiosG') }}";
                var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                    url: url,
                    data: {
                        'id_estudios_generales': id,
                        'id_usuario': id_usu
                    },
                    success: function(data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_EstudiosG();
                        });
                    }
                });
            }
        })
    }

    function Conoci_Idiomas() {
        var dataString = new FormData(document.getElementById('formulario_conoci_idiomas'));
        var url = "{{ url('ColaboradorController/Insert_Conoci_Idiomas') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Conoci_Idiomas()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#mdconocimientoi').html(data);
                        MDatos_Idiomas();
                    });
                }
            });
        }
    }

    function MDatos_Idiomas() {
        var dataString = new FormData(document.getElementById('formulario_conoci_idiomas'));
        var url = "{{ url('ColaboradorController/MDatos_Idiomas') }}";
                var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#conoci_idiomas').html(data);
                $('#btnIdiomas').html("<a onclick='Conoci_Idiomas();' title='Agregar Idioma' class='btn btn-danger'>Agregar</a>");
            }
        });
    }

    function Detalle_Conoci_Idiomas(id) {
        var id = id;
        var url = "{{ url('ColaboradorController/Detalle_Conoci_Idiomas') }}";
                var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            url: url,
            data: {
                'id_conoci_idiomas': id
            },
            success: function(data) {
                $('#conoci_idiomas').html(data);
                $('#btnIdiomas').html("<a onclick='Update_Conoci_Idiomas();' title='Actualizar Idioma' class='btn btn-primary'>Actualizar</a>");
            }
        });
    }

    function Update_Conoci_Idiomas() {
        var dataString = new FormData(document.getElementById('formulario_conoci_idiomas'));
        var url = "{{ url('ColaboradorController/Update_Conoci_Idiomas') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Conoci_Idiomas()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#mdconocimientoi').html(data);
                        MDatos_Idiomas();
                    });
                }
            });
        }
    }

    function Valida_Conoci_Idiomas() {
        if ($('#nom_conoci_idiomas').val() == '0') {
            msgDate = 'Debe elegir un idioma';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#lect_conoci_idiomas').val() == '0') {
            msgDate = 'Debe elegir un nivel';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#escrit_conoci_idiomas').val() == '0') {
            msgDate = 'Debe elegir un nivel';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#conver_conoci_idiomas').val() == '0') {
            msgDate = 'Debe elegir un nivel';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }

    function Delete_Conoci_Idiomas(id, id_usu) {
        var id = id;
        var id_usu = id_usu;
        var url = "{{ url('ColaboradorController/Delete_Conoci_Idiomas') }}";
                var csrfToken = $('input[name="_token"]').val();

        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                    url: url,
                    data: {
                        'id_conoci_idiomas': id,
                        'id_usuario': id_usu
                    },
                    success: function(data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            $('#mdconocimientoi').html(data);
                            MDatos_Idiomas();
                        });
                    }
                });
            }
        })
    }

    function CursosC() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cursosc'));
        var url = "{{ url('ColaboradorController/Insert_CursosC') }}";
                var csrfToken = $('input[name="_token"]').val();

        if (Valida_CursosC()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        MDatos_CursosC();
                        Lista_CursosC();
                    });
                }
            });
        }
    }

    function MDatos_CursosC() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cursosc'));
        var url = "{{ url('ColaboradorController/MDatos_CursosC') }}";
        var csrfToken = $('input[name="_token"]').val();


        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#mucursos').html(data);
                $('#btnCursosC').html("<a onclick='CursosC();' title='Agregar Curso Complementario' class='btn btn-danger'>Agregar</a>");
            }
        });
    }

    function Lista_CursosC() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cursosc'));
        var url = "{{ url('ColaboradorController/Lista_CursosC') }}";
                var csrfToken = $('input[name="_token"]').val();


        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#mdcursos').html(data);
            }
        });
    }

    function Update_CursosC() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cursosc'));
        var url = "{{ url('ColaboradorController/Update_CursosC') }}";
                var csrfToken = $('input[name="_token"]').val();

        if (Valida_CursosC()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        MDatos_CursosC();
                        Lista_CursosC();
                    });
                }
            });
        }
    }

    function Detalle_CursosC(id) {
        Cargando();

        var id = id;
        var url = "{{ url('ColaboradorController/Detalle_CursosC') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            url: url,
            data: {
                'id_curso_complementario': id
            },
            success: function(data) {
                $('#mucursos').html(data);
                $('#btnCursosC').html("<a onclick='Update_CursosC();' title='Actualizar Curso Complementario' class='btn btn-primary'>Actualizar</a>");
            }
        });
    }

    function Valida_CursosC() {

        if ($('#nom_curso_complementario').val().trim() === '') {
            msgDate = 'Debe ingresar el nombre del curso';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#aniocc').val() == '0') {
            msgDate = 'Debe elegir el año';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }


        return true;
    }

    function Delete_CursosC(id, id_usu) {
        Cargando();

        var id = id;
        var id_usu = id_usu;
        var url = "{{ url('ColaboradorController/Delete_CursosC') }}";
                var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                    url: url,
                    data: {
                        'id_curso_complementario': id,
                        'id_usuario': id_usu
                    },
                    success: function(data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            MDatos_CursosC();
                            Lista_CursosC();
                        });
                    }
                });
            }
        })
    }

    function Referencia_Convocatoria() {
        var dataString = new FormData(document.getElementById('formulario_referencia_convocatoria'));
        var url = "{{ url('ColaboradorController/Update_Referencia_Convocatoria') }}";
                var csrfToken = $('input[name="_token"]').val();

        if (Valida_Referencia_Convocatoria()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#referencia_convocatoria').html(data);
                    });
                }
            });
        }
    }

    function Valida_Referencia_Convocatoria() {
        if ($('#id_referencia_laboral').val() == '0') {
            msgDate = 'Debe seleccionar opción';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($("#id_referencia_laboral option:selected").text() == 'OTROS') {
            if ($('#otrosel').val().trim() == '') {
                msgDate = 'Debe llenar este dato';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }
        }

        return true;
    }

    function ValidaRC() {
        if ($("#id_referencia_laboral option:selected").text() == "OTROS") {
            $("#otrosel").prop('disabled', false);
        } else {
            $("#otrosel").prop('disabled', true);

            $("#otrosel").val('');
        }
    }

    function ExperenciaL() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_experiencial'));
        var url = "{{ url('ColaboradorController/Insert_ExperenciaL') }}";
                var csrfToken = $('input[name="_token"]').val();

        if (Valida_ExperenciaL()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        MDatos_ExperenciaL();
                        Lista_ExperenciaL();
                    });
                }
            });
        }
    }

    function Lista_ExperenciaL() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_experiencial'));
        var url = "{{ url('ColaboradorController/Lista_ExperenciaL') }}";
        var csrfToken = $('input[name="_token"]').val();


        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#mdexperiencial').html(data);
            }
        });
    }

    function Update_ExperenciaL() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_experiencial'));
        var url = "{{ url('ColaboradorController/Update_ExperenciaL') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_ExperenciaL()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        MDatos_ExperenciaL();
                        Lista_ExperenciaL();
                    });
                }
            });
        }
    }

    function Valida_ExperenciaL() {
        valor = $('input:checkbox[name=checkactualidad]:checked').val();
        if ($('#empresaex').val().trim() === '') {
            msgDate = 'Debe ingresar nombre de empresa';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#cargoex').val().trim() === '') {
            msgDate = 'Debe ingresar nombre de cargo';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#dia_iniel').val() == '0') {
            msgDate = 'Debe ingresar fecha de inicio';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#mes_iniel').val() == '0') {
            msgDate = 'Debe ingresar fecha de inicio';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#anio_iniel').val() == '0') {
            msgDate = 'Debe ingresar fecha de inicio';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if (valor != 1) {
            if ($('#dia_finel').val() == '0') {
                msgDate = 'Debe ingresar fecha de fin';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#mes_finel').val() == '0') {
                msgDate = 'Debe ingresar fecha de fin';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#anio_finel').val() == '0') {
                msgDate = 'Debe ingresar fecha de fin';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }
        }

        if ($('#motivo_salida').val().trim() === '') {
            msgDate = 'Debe ingresar el motivo de cese';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#remuneracion').val().trim() === '') {
            msgDate = 'Debe ingresar su remuneración';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }

    function MDatos_ExperenciaL() {
        var dataString = new FormData(document.getElementById('formulario_experiencial'));
        var url = "{{ url('ColaboradorController/MDatos_ExperenciaL') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#muexperiencial').html(data);
                $('#btnExperenciaL').html("<a onclick='ExperenciaL();' title='Agregar Experiencia Laboral' class='btn btn-danger'>Agregar</a>");
            }
        });
    }

    function Lista_ExperenciaL() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_experiencial'));
        var url = "{{ url('ColaboradorController/Lista_ExperenciaL') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#mdexperiencial').html(data);
            }
        });
    }

    function Detalle_ExperenciaL(id) {
        Cargando();
        var id = id;
        var url = "{{ url('ColaboradorController/Detalle_ExperenciaL') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'id_experiencia_laboral': id
            },
            success: function(data) {
                $('#muexperiencial').html(data);
                $('#btnExperenciaL').html("<a onclick='Update_ExperenciaL();' title='Actualizar Experiencia Laboral' class='btn btn-primary'>Actualizar</a>");
            }
        });
    }

    function Delete_ExperenciaL(id, id_usu) {
        Cargando();

        var id = id;
        var id_usu = id_usu;


        var url = "{{ url('ColaboradorController/Delete_ExperenciaL') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id_experiencia_laboral': id,
                        'id_usuario': id_usu
                    },
                    success: function(data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            MDatos_ExperenciaL();
                            Lista_ExperenciaL();
                        });
                    }
                });
            }
        })
    }

    function Conoci_Office() {
        var dataString = new FormData(document.getElementById('formulario_conoci_office'));
        var url = "{{ url('ColaboradorController/Update_Conoci_Office') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Conoci_Office()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#conoci_office').html(data);
                    });
                }
            });
        }
    }

    function Valida_Conoci_Office() {
        if ($('#nl_excel').val() == '0' && $('#nl_word').val() == '0' &&
            $('#nl_ppoint').val() == '0') {
            msgDate = 'Debe seleccionar un nivel de conocimiento';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }

    function Enfermedades() {
        var dataString = new FormData(document.getElementById('formulario_enfermedades'));
        var url = "{{ url('ColaboradorController/Insert_Enfermedades') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Enfermedades()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#mdenfermedades').html(data);
                        MDatos_Enfermedades();
                    });
                }
            });
        }
    }

    function Update_Enfermedades() {
        var dataString = new FormData(document.getElementById('formulario_enfermedades'));
        var url = "{{ url('ColaboradorController/Update_Enfermedades') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Enfermedades()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#mdenfermedades').html(data);
                        MDatos_Enfermedades();
                    });
                }
            });
        }
    }

    function Detalle_Enfermedades(id) {
        var id = id;
        var url = "{{ url('ColaboradorController/Detalle_Enfermedades') }}";
        var csrfToken = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'id_enfermedad_usuario': id
            },
            success: function(data) {
                $('#muenfermedades').html(data);
                $('#btnEnfermedades').html("<a onclick='Update_Enfermedades();' title='Actualizar Enfermedad' class='btn btn-primary'>Actualizar</a>");
            }
        });
    }

    function MDatos_Enfermedades() {
        var dataString = new FormData(document.getElementById('formulario_enfermedades'));
        var url = "{{ url('ColaboradorController/MDatos_Enfermedades') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#muenfermedades').html(data);
                $('#btnEnfermedades').html("<a onclick='Enfermedades();' title='Agregar Enfermedad' class='btn btn-danger'>Agregar</a>");
                ValidaE();
            }
        });
    }

    function Valida_Enfermedades() {
        if ($('#id_respuestae').val() == '0') {
            msgDate = 'Seleccionar una opción.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#id_respuestae').val() == '1') {
            if ($('#nom_enfermedad').val().trim() === '') {
                msgDate = 'Debe escribir el nombre de la enfermedad.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#dia_diagnostico').val() == '0') {
                msgDate = 'Debe seleccionar el día de diagnóstico.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#mes_diagnostico').val() == '0') {
                msgDate = 'Debe seleccionar el mes de diagnóstico.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#anio_diagnostico').val() == '0') {
                msgDate = 'Debe seleccionar el año de diagnóstico.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }
        }

        return true;
    }

    function ValidaE() {
        if ($('#id_respuestae').val() == '1') {
            $("#nom_enfermedad").prop('disabled', false);
            $("#dia_diagnostico").prop('disabled', false);
            $("#mes_diagnostico").prop('disabled', false);
            $("#anio_diagnostico").prop('disabled', false);
            $('#btnEnfermedades').html("<a onclick='Enfermedades();' title='Agregar Enfermedad' class='btn btn-danger'>Agregar</a>");
        }

        if ($('#id_respuestae').val() != '1') {
            $("#nom_enfermedad").prop('disabled', true);
            $("#dia_diagnostico").prop('disabled', true);
            $("#mes_diagnostico").prop('disabled', true);
            $("#anio_diagnostico").prop('disabled', true);
            $('#btnEnfermedades').html("<a onclick='Update_Enfermedades();' title='Actualizar Enfermedad' class='btn btn-primary'>Actualizar</a>");

            $("#nom_enfermedad").val('');
            $("#dia_diagnostico").val('0');
            $("#mes_diagnostico").val('0');
            $("#anio_diagnostico").val('0');
        }
    }

    function Delete_Enfermedades(id, id_usu) {
        var id = id;
        var id_usu = id_usu;
        var url = "{{ url('ColaboradorController/Delete_Enfermedades') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id_enfermedad_usuario': id,
                        'id_usuario': id_usu
                    },
                    success: function(data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            $('#mdenfermedades').html(data);
                            MDatos_Enfermedades();
                        });
                    }
                });
            }
        })
    }
    
    function Gestacion() {
        var dataString = new FormData(document.getElementById('formulario_gestacion'));
        var url = "{{ url('ColaboradorController/Update_Gestacion') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Gestacion()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#gestacion').html(data);
                    });
                }
            });
        }
    }

    function Valida_Gestacion() {
        if ($('#id_respuesta').val() == '0') {
            msgDate = 'Debe seleccionar una opción.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#id_respuesta').val() == '1') {
            if ($('#dia_ges').val() == '0') {
                msgDate = 'Debe seleccionar día.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#mes_ges').val() == '0') {
                msgDate = 'Debe seleccionar mes.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }

            if ($('#anio_ges').val() == '0') {
                msgDate = 'Debe seleccionar año.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }
        }

        return true;
    }

    function Validag() {
        if ($('#id_respuesta').val() == '1') {
            $("#dia_ges").prop('disabled', false);
            $("#mes_ges").prop('disabled', false);
            $("#anio_ges").prop('disabled', false);
        }

        if ($('#id_respuesta').val() != '1') {
            $("#dia_ges").prop('disabled', true);
            $("#mes_ges").prop('disabled', true);
            $("#anio_ges").prop('disabled', true);

            $("#dia_ges").val('0');
            $("#mes_ges").val('0');
            $("#anio_ges").val('0');
        }

        return true;
    }
    /****************************************** */
    function Alergia() {
        var dataString = new FormData(document.getElementById('formulario_alergia'));
        var url = "{{ url('ColaboradorController/Insert_Alergia') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Alergia()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#mdalergias').html(data);
                        $('#nom_alergia').val('');
                    });
                }
            });
        }
    }

    function Update_Alergia() {
        var dataString = new FormData(document.getElementById('formulario_alergia'));
        var url = "{{ url('ColaboradorController/Update_Alergia') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Alergia()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#mdalergias').html(data);
                        MDatos_Alergia();
                    });
                }
            });
        }
    }

    function Valida_Alergia() {
        if ($('#id_respuestaau').val() == '0') {
            msgDate = 'Seleccionar una opción.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#id_respuestaau').val() == '1') {
            if ($('#nom_alergia').val().trim() === '') {
                msgDate = 'Debe escribir el nombre de alergia que presenta.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }
        }
        return true;
    }

    function Detalle_Alergia(id) {
        var id = id;
        var url = "{{ url('ColaboradorController/Detalle_Alergia') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'id_alergia_usuario': id
            },
            success: function(data) {
                $('#mualergias').html(data);
                $('#btnAlergia').html("<a onclick='Update_Alergia();' title='Actualizar Alergia' class='btn btn-primary'>Actualizar</a>");
            }
        });
    }

    function MDatos_Alergia() {
        var dataString = new FormData(document.getElementById('formulario_alergia'));
        var url = "{{ url('ColaboradorController/MDatos_Alergias') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#mualergias').html(data);
                $('#btnAlergia').html("<a onclick='Alergia();' title='Agregar Alergia' class='btn btn-danger'>Agregar</a>");
                ValidaE();
            }
        });
    }

    function ValidaA() {
        if ($('#id_respuestaau').val() == '1') {
            $("#nom_alergia").prop('disabled', false);
            $('#btnAlergia').html("<a onclick='Alergia();' title='Agregar Alergia' class='btn btn-danger'>Agregar</a>");

        }

        if ($('#id_respuestaau').val() != '1') {
            $("#nom_alergia").prop('disabled', true);
            $('#btnAlergia').html("<a onclick='Update_Alergia();' title='Actualizar Alergia' class='btn btn-primary'>Actualizar</a>");

            $("#nom_alergia").val('');

        }
    }

    function Delete_Alergia(id, id_usu) {
        var id = id;
        var id_usu = id_usu;
        var url = "{{ url('ColaboradorController/Delete_Alergia') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id_alergia_usuario': id,
                        'id_usuario': id_usu
                    },
                    success: function(data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            $('#mdalergias').html(data);
                        });
                    }
                });
            }
        })
    }
    /**************************************/
    function Otros() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_otros'));
        var url = "{{ url('ColaboradorController/Update_Otros') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Otros()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Otros();
                    });
                }
            });
        }
    }

    function Lista_Otros() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_otros'));
        var url = "{{ url('ColaboradorController/Lista_Otros') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#otros').html(data);
            }
        });
    }

    function Valida_Otros() {
        if ($('#id_grupo_sanguineo').val() == '0') {
            msgDate = 'Debe seleccionar tipo de sangre.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }
    
    function Referencia_Convocatoria() {
        var dataString = new FormData(document.getElementById('formulario_referencia_convocatoria'));
        var url = "{{ url('ColaboradorController/Update_Referencia_Convocatoria') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Referencia_Convocatoria()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#referencia_convocatoria').html(data);
                    });
                }
            });
        } else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function Valida_Referencia_Convocatoria() {
        if ($('#id_referencia_laboral').val() == '0') {
            msgDate = 'Debe seleccionar opción';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($("#id_referencia_laboral option:selected").text() == 'OTROS') {
            if ($('#otrosel').val().trim() == '') {
                msgDate = 'Debe llenar este dato';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }
        }

        return true;
    }
    
    function Adjuntar_Documentacion() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_adjuntar_documentacion'));
        var url = "{{ url('ColaboradorController/Update_Adjuntar_Documentacion') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Adjuntar_Documentacion()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Adjuntar_Documentacion();
                    });
                }
            });
        }
    }

    function Lista_Adjuntar_Documentacion() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_adjuntar_documentacion'));
        var url = "{{ url('ColaboradorController/Lista_Adjuntar_Documentacion') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                $('#adjuntar_documentacion').html(data);
            }
        });
    }

    function Valida_Adjuntar_Documentacion() {
        if ($('#filecv_doc').val().trim() === '' && $('#filedni_doc').val().trim() === '' && $('#filerecibo_doc').val().trim() === '') {
            msgDate = 'Debe seleccionar al menos una opción.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }
    
    function Talla_Indica() {
        var dataString = new FormData(document.getElementById('formulario_talla_indicar'));
        var url = "{{ url('ColaboradorController/Update_Talla_Indica') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Talla_Indica()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#talla_indicar').html(data);
                    });
                }
            });
        }
    }

    function Valida_Talla_Indica() {
        if ($('#polo').val() == '0') {
            msgDate = 'Debe ingresar su talla de polo';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#pantalon').val() == '0') {
            msgDate = 'Debe ingresar su talla de pantalón';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        if ($('#zapato').val() == '0') {
            msgDate = 'Debe ingresar su talla de zapato';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }

    function Sistema_Pensionario() {
        var dataString = new FormData(document.getElementById('formulario_sistema_pensionario'));
        var url = "{{ url('ColaboradorController/Update_Sistema_Pensionario') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Sistema_Pensionario()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#sistema_pensionario').html(data);
                    });
                }
            });
        } else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function Valida_Sistema_Pensionario() {
        if ($('#id_respuestasp').val() == '0') {
            msgDate = 'Debe seleccionar una opción.';
            inputFocus = '#id_respuestasp';
            return false;
        }

        if ($('#id_respuestasp').val() == '1') {
            if ($('#id_sistema_pensionario').val() == '0') {
                msgDate = 'Debe seleccionar un sistema de pensión.';
                inputFocus = '#id_sistema_pensionario';
                return false;
            }
        }

        if ($('#id_sistema_pensionario').val() == '2') {
            if ($('#id_afp').val() == '0') {
                msgDate = 'Debe seleccionar el AFP al que pertenece.';
                inputFocus = '#id_afp';
                return false;
            }
        }

        return true;

    }

    function Validasp() {
        if ($('#id_respuestasp').val() == '1') {
            $("#id_sistema_pensionario").prop('disabled', false);
        }

        if ($('#id_respuestasp').val() != '1') {
            $("#id_sistema_pensionario").prop('disabled', true);
            $("#id_afp").prop('disabled', true);

            $("#id_sistema_pensionario").val('0');
            $("#id_afp").val('0');
        }
    }

    function ValidaAFP() {
        if ($('#id_sistema_pensionario').val() == '2') {
            $("#id_afp").prop('disabled', false);
        }

        if ($('#id_sistema_pensionario').val() != '2') {
            $("#id_afp").prop('disabled', true);

            $("#id_afp").val('0');
        }
    }
    
    function Numero_Cuenta(){
        let lista_banco =<?php echo count($list_banco); ?> ;
        var dataString = new FormData(document.getElementById('formulario_cuenta_bancaria'));
        var url="{{ url('ColaboradorController/Update_Numero_Cuenta') }}";
        var csrfToken = $('input[name="_token"]').val();

            if (Valida_Numero_Cuenta()) {
                $.ajax({
                    url: url,
                    data:dataString,
                    type:"POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    processData: false,
                    contentType: false,
                    success:function (data) {
                        swal.fire(
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $('#numero_cuenta').html(data);
                        });
                    }
                });
            }
    }

    function Valida_Numero_Cuenta() {
        if($('#cuenta_bancaria').val() == '0') {
            msgDate = 'Debe seleccionar una opción';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cuenta_bancaria').val()=='1'){
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

            if($('#id_banco').val() == '0') {
                msgDate = 'Debe elegir un banco';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
                return false;
            }
            for (i = 1; i <= lista_banco; i++) {
                console.log(i);

                if($('#id_banco').val() == i) {

                    if($('#num_cuenta_bancaria_'+i).val().trim() === '') {
                        msgDate = 'Debe ingresar número de cuenta';
                        Swal(
                            'Ups!',
                            msgDate,
                            'warning'
                        ).then(function() { });
                        return false;
                    }

                    var un = $('#num_cuenta_bancaria_'+i).val().trim();
                    let dos = un.replace(/_/gi, '');

                    if(dos.length != un.length ){
                        msgDate = 'El numero de cuenta bancaria debe contener '+ un.length +' caracteres.';
                        Swal(
                            'Ups!',
                            msgDate,
                            'warning'
                        ).then(function() { });
                        return false;
                    }


                    if($('#num_codigo_interbancario_'+i).val().trim() === '') {
                        msgDate = 'Debe ingresar número de código interbancario';
                        Swal(
                            'Ups!',
                            msgDate,
                            'warning'
                        ).then(function() { });
                        return false;
                    }

                    var uno = $('#num_codigo_interbancario_'+i).val().trim();
                    let doss = uno.replace(/_/gi, '');

                    if(doss.length != uno.length ){
                        msgDate = 'El numero de código interbancario debe contener '+ uno.length +' caracteres.';
                        Swal(
                            'Ups!',
                            msgDate,
                            'warning'
                        ).then(function() { });
                        return false;
                    }
                }
            }
        }
        return true;
    }
    
    function Validaeb() {
        if ($('#cuenta_bancaria').val() == '1') {
            $('#id_banco').removeAttr("disabled");
            for (i = 1; i <= lista_banco; i++) {
                $('#num_cuenta_bancaria_' + i).removeAttr("disabled");
                $('#num_codigo_interbancario_' + i).removeAttr("disabled");
            }
        }
        if ($('#cuenta_bancaria').val() != '1') {
            $("#id_banco").prop('disabled', true);
            $("#num_cuenta_bancaria").prop('disabled', true);
            $("#num_codigo_interbancario").prop('disabled', true);

            for (i = 1; i <= lista_banco; i++) {
                $('#num_cuenta_bancaria_' + i).attr("disabled", true);
                $('#num_codigo_interbancario_' + i).attr("disabled", true);
                $('#num_cuenta_bancaria_' + i).val('');
                $('#num_codigo_interbancario_' + i).val('');
            }

            $("#id_banco").val('0');
        }
    }
    
    function Terminos() {
        valor = $('input:checkbox[name=termino]:checked').val();
        if (valor == 1) {
            $("#termino").attr('disabled', 'disabled');
            var dataString = new FormData(document.getElementById('formulario_termino'));
            var url = "{{ url('ColaboradorController/Terminos') }}";
            var csrfToken = $('input[name="_token"]').val();

            Swal({
                //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
                title: 'He Leído y Acepto la Política de Privacidad de la Numero 1',
                //text: "El registro será eliminado permanentemente",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        data: dataString,
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        processData: false,
                        contentType: false,
                        success: function(data) {
                        }
                    });
                } else {
                    $("#termino").removeAttr('disabled');
                    $('#termino').prop('checked', false);
                }
            })
        }
    }
    function GuardarCambios(n) {
        Cargando();
        
        var dataString = new FormData(document.getElementById('edatos'));
        var numero = $('#num_doc').val();
        var url = "{{ url('ColaboradorController/GuardarCambiosCI')}}/" + numero;
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                var cadena = data;
                validacion = cadena.substr(0, 1);
                mensaje = cadena.substr(1);
                if (validacion == 1) {
                    Swal.fire({
                        title: 'Guardado Denegado',
                        html: "Por favor completar la(s) seccion(es): <br>"+mensaje,
                        type:'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    var url1 = "{{ url('ColaboradorController/Update_Datos_Completos')}}/"+numero;
                    var csrfToken = $('input[name="_token"]').val();
                    $.ajax({
                        url: url1,
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(resp) {
                            swal.fire(
                                'Guardado Exitoso!',
                                'Vuelve a iniciar sesión, por favor.',
                                'success'
                            ).then(function() {
                                if(n!="1" && n!="2"){
                                    window.location = "{{ url('DestruirSesion')}}";
                                }else{
                                    window.location.reload();
                                }
                                
                            });
                        }
                    });
                }
            }
        });
    }
</script>

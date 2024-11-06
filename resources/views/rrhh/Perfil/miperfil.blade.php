@extends('layouts.plantilla')

@section('navbar')
    @include('rrhh.navbar')
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('template\assets\css\users\user-profile.css')}}">
 <!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-spacing">
            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
                <div class="user-profile layout-spacing">
                    <div class="widget-content widget-content-area">
                        <div class="d-flex justify-content-between">
                            <h3 class="">Perfil</h3>
                            <?php if(session('usuario')->id_nivel=="1" || session('usuario')->id_nivel=="2"){ ?>
                                <a type="button" class="btn btn-primary mt-2" href="<?= url('colaborador') ?>">Regresar</a>
                            <?php } ?>
                            <a href="{{ url('ColaboradorController/Perfil/'. $usuario[0]['id_usuario']) }}" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                        </div>
                        <div class="text-center user-info">
                            <img src="<?php if($usuario[0]['foto'] !="") {echo $usuario[0]['foto']; } else{echo asset('template/assets/img/90x90.jpg'); } ?>" height="90px" width="90px" alt="avatar">
                            <p class=""><?php echo $usuario[0]['usuario_nombres']." ".$usuario[0]['usuario_apater']; ?></p>
                        </div>
                        <div class="progress br-30 ml-5 mr-5">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                            $porcentaje=round((($porcentaje[0]['datos_personales']+$porcentaje[0]['gustos_preferencias']+$porcentaje[0]['domicilio_user']+$porcentaje[0]['referencia']+
                            $porcentaje[0]['cont_hijos']+$porcentaje[0]['contactoe']+$porcentaje[0]['estudiosg']+$porcentaje[0]['office']+$porcentaje[0]['idiomas']+$porcentaje[0]['experiencial']+
                            $porcentaje[0]['cont_enfermedades']+$porcentaje[0]['gestacion']+$porcentaje[0]['cont_alergia']+$porcentaje[0]['con_otros']+$porcentaje[0]['ref_convoc']+$porcentaje[0]['adj_documentacion']+
                            $porcentaje[0]['talla_usuario']+$porcentaje[0]['sistema_pension']+ $porcentaje[0]['cuenta_bancaria']+$porcentaje[0]['cont_terminos'])/20)*100,2);
                            echo $porcentaje."%";
                         ?>" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-title"><span></span>
                                    <span><?php echo $porcentaje."%"; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="user-info-list">
                            <div class="">
                                <ul class="contacts-block list-unstyled">
                                    <li class="contacts-block__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg><?php echo $usuario[0]['nom_puesto']; ?>
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        <?php if($usuario[0]['nom_mes']!="") { echo $usuario[0]['nom_mes']." ".$usuario[0]['dia_nac'].", ".$usuario[0]['anio_nac']; }
                                        ?>
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        <?php if(isset($domicilio[0]['nombre_distrito']) && $domicilio[0]['nombre_distrito']!="") {
                                                echo $domicilio[0]['nombre_distrito'].", ".$domicilio[0]['nombre_departamento'].", PERÚ";} ?>
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <?php if($usuario[0]['usuario_email']!="") { echo $usuario[0]['usuario_email'];} ?>
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        <?php if($usuario[0]['num_celp']!="") { echo $usuario[0]['num_celp'];} ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">
                <div class="skills layout-spacing">
                    <div class="widget-content widget-content-area">
                        <h3 class="">Secciones</h3>
                        Datos Personales
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                            $porcentaje=round((($datosp_porcentaje['0']['nombres']+$datosp_porcentaje['0']['apater']+$datosp_porcentaje['0']['amater']+$datosp_porcentaje['0']['nacionalidad']+$datosp_porcentaje['0']['tipo_documento']+$datosp_porcentaje['0']['num_doc']+$datosp_porcentaje['0']['fec_nac']+$datosp_porcentaje['0']['estado_civil']+$datosp_porcentaje['0']['emailp']+$datosp_porcentaje['0']['num_celp']+$datosp_porcentaje['0']['foto'])/11)*100,2);
                                            echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-title"><span></span>
                                    <span><?php echo $porcentaje."%"; ?></span>
                                </div>
                            </div>
                        </div>
                        Gustos y Preferencias
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                            $porcentaje=round(((count($gustos_pref))/1)*100,2);
                                            echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-title"><span></span>
                                    <span><?php echo $porcentaje."%"; ?></span>
                                </div>
                            </div>
                        </div>
                        Domicilio
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                            if(count($domiciliou_porcentaje)>0){
                                $porcentaje=round((($domiciliou_porcentaje['0']['departamento']+$domiciliou_porcentaje['0']['provincia']+$domiciliou_porcentaje['0']['distrito']+$domiciliou_porcentaje['0']['tipo_vivienda']+$domiciliou_porcentaje['0']['referencia']+$domiciliou_porcentaje['0']['lat']+$domiciliou_porcentaje['0']['lng'])/7)*100,2);
                            }else{$porcentaje=0;}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Referencias Familiares
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                $porcentaje=round((($referenciaf_porcentaje['0']['nom_familiar']+$referenciaf_porcentaje['0']['parentesco']+$referenciaf_porcentaje['0']['fec_nac']+$referenciaf_porcentaje['0']['alternativa'])/4)*100,2);
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Datos de Hijos/as
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                if ($usuario[0]['hijos']=="2"){$porcentaje=100;}
                                else{$porcentaje=round((($datoshu_porcentaje['0']['nom_hijo']+$datoshu_porcentaje['0']['genero']+$datoshu_porcentaje['0']['fec_nac']+$datoshu_porcentaje['0']['genero']+$datoshu_porcentaje['0']['biologico']+$datoshu_porcentaje['0']['documento'])/6)*100,2);}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Contacto de Emergencia
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                $porcentaje=round((($contactoeu_porcentaje['0']['nom_contacto']+$contactoeu_porcentaje['0']['parentesco']+$contactoeu_porcentaje['0']['alternativoce'])/3)*100,2);
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Estudios Generales
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                $porcentaje=round((($estudiosgu_porcentaje['0']['instruccion']+$estudiosgu_porcentaje['0']['carrera']+$estudiosgu_porcentaje['0']['centro'])/3)*100,2);
                                echo $porcentaje."%"; ?>" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Conocimientos de Office
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                if(count($oficceu_porcentaje)>0){
                                $porcentaje=round((($oficceu_porcentaje['0']['ppoint']+$oficceu_porcentaje['0']['word']+$oficceu_porcentaje['0']['excel'])/3)*100,2);
                                }else{$porcentaje=0;}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Conocimientos de Idiomas
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                $porcentaje=round((($idiomau_porcentaje['0']['conoci_idiomas']+$idiomau_porcentaje['0']['lect_conoci']+$idiomau_porcentaje['0']['escrit_conoci']+$idiomau_porcentaje['0']['conver_conoci'])/4)*100,2);
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Cursos Complementarios
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                $porcentaje=round((($cursocu_porcentaje['0']['curso_complementario']+$cursocu_porcentaje['0']['anio'])/2)*100,2);
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">
                <div class="skills layout-spacing">
                    <div class="widget-content widget-content-area">
                        Experiencia Laboral
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                $porcentaje=round((($experiencialaboralu_porcentaje['0']['empresa']+$experiencialaboralu_porcentaje['0']['cargo']+$experiencialaboralu_porcentaje['0']['fec_ini']+$experiencialaboralu_porcentaje['0']['fec_fin']+$experiencialaboralu_porcentaje['0']['motivo_salida']+$experiencialaboralu_porcentaje['0']['remuneracion']+$experiencialaboralu_porcentaje['0']['nom_referencia_labores']+$experiencialaboralu_porcentaje['0']['num_contacto'])/8)*100,2);
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Enfermedades
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                if ($enfermedadesu_porcentaje['0']['enfermedades']==2){$porcentaje=100;}else{
                                $porcentaje=round((($enfermedadesu_porcentaje['0']['nom_enfermedad']+$enfermedadesu_porcentaje['0']['fec_diagnostico'])/2)*100,2);}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        <?php if ($usuario[0]['cod_genero']==="F"){ ?>
                            Gestación
                            <div class="progress br-30">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                    if(count($gestacionu_porcentaje)>0){
                                        $porcentaje=round((($gestacionu_porcentaje['0']['id_respuesta']+$gestacionu_porcentaje['0']['fec_ges'])/2)*100,2);
                                    }else{$porcentaje=0;}
                                    echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                            </div>
                        <?php } ?>
                        Alergias
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                if ($alergiasu_porcentaje['0']['alergia']==2){$porcentaje=100;}else{
                                $porcentaje=round(($alergiasu_porcentaje['0']['nom_alergia'])*100,2);}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Otros
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                if(count($otrosu_porcentaje)>0){
                                    $porcentaje=round((($otrosu_porcentaje['0']['id_grupo_sanguineo']+$otrosu_porcentaje['0']['cert_vacu'])/2)*100,2);
                                }else{$porcentaje=0;}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Referencia de Convocatoria
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                if(count($referenciaconvocatoriau_porcentaje)>0){
                                    if($referenciaconvocatoriau_porcentaje['0']['id_referencia_laboral']==6){
                                        $porcentaje=round((($referenciaconvocatoriau_porcentaje['0']['id_referencia_laboral']+$referenciaconvocatoriau_porcentaje['0']['otros'])/2)*100,2);}
                                    else{$porcentaje=round(($referenciaconvocatoriau_porcentaje['0']['id_referencia_laboral'])*100,2);}
                                }else{$porcentaje=0;}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Adjuntar Documentación
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                            $porcentaje=round((($documentacionu_porcentaje['0']['cv_doc']+$documentacionu_porcentaje['0']['dni_doc']+$documentacionu_porcentaje['0']['recibo_doc'])/3)*100,2);
                                            echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Uniforme
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                            if(count($ropau_porcentaje)>0){
                                if ($usuario[0]['cod_genero']==="F"){
                                $porcentaje=round((($ropau_porcentaje['0']['polo']+$ropau_porcentaje['0']['pantalon']+$ropau_porcentaje['0']['zapato'])/3)*100,2);}
                                else{$porcentaje=round((($ropau_porcentaje['0']['polo']+$ropau_porcentaje['0']['camisa']+$ropau_porcentaje['0']['pantalon']+$ropau_porcentaje['0']['zapato'])/4)*100,2);}
                            }else{$porcentaje=0;}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Sistema Pensionario
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                if(count($sist_pensu_porcentaje)>0){
                                    $porcentaje=round((($sist_pensu_porcentaje['0']['id_respuestasp']+$sist_pensu_porcentaje['0']['id_sistema_pensionario']+$sist_pensu_porcentaje['0']['id_afp'])/3)*100,2);
                                }else{$porcentaje=0;}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Número de Cuenta
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                if(count($cuentab_porcentaje)>0){
                                    if($cuentab_porcentaje['0']['cuenta_bancaria']==2){$porcentaje=100;}
                                    else{
                                        $porcentaje=round((($cuentab_porcentaje['0']['banco']+$cuentab_porcentaje['0']['cuenta']+$cuentab_porcentaje['0']['num_cuenta']+$cuentab_porcentaje['0']['num_codigo'])/4)*100,2);
                                    }
                                }else{$porcentaje=0;}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                        Tratamiento Datos Personales
                        <div class="progress br-30">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php
                                if ($usuario[0]['terminos']=="1"){ $porcentaje=100;} else {$porcentaje=0;}
                                echo $porcentaje."%"; ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-title"><span></span> <span><?php echo $porcentaje."%"; ?></span> </div></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<style>
    .widget-content-area{
        padding: 20px !important;
    }
</style>
<script>
    $(document).ready(function() {
        $("#usuario").addClass('active');
        $("#husuario").attr('aria-expanded','true');
        $("#upersonales").addClass('active');
    });
</script>
@endsection

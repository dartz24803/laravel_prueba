@extends('layouts.plantilla')

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
    $sesion = session('usuario');
    $id_nivel = session('usuario')->id_nivel;
    $desvinculacion = session('usuario')->desvinculacion;
    $estado = session('usuario')->estado;
    $id_puesto = session('usuario')->id_puesto;
    $id_cargo = session('usuario')->id_cargo;
    $usuario_codigo = session('usuario')->usuario_codigo;
    $centro_labores = session('usuario')->centro_labores;
    $estado = session('usuario')->estado;
    $acceso = session('usuario')->acceso;
    $induccion = session('usuario')->induccion;
    $registro_masivo = session('usuario')->registro_masivo;
    $menu_gestion_pendiente = explode(",",session('usuario')->grupo_puestos);
    $mostrar_menu=in_array(session('usuario')->id_puesto,$menu_gestion_pendiente);//
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
                        <?php 
                        if($id_nivel==1 || $id_nivel==2 || $id_puesto==22 || $id_puesto==133 || 
                        $_SESSION['usuario'][0]['nivel_jerarquico']==1 ||
                        $_SESSION['usuario'][0]['nivel_jerarquico']==2 || 
                        $_SESSION['usuario'][0]['nivel_jerarquico']==3 ||  
                        $_SESSION['usuario'][0]['nivel_jerarquico']==4 || $id_puesto==195 ||
                        $_SESSION['usuario'][0]['visualizar_amonestacion']!="sin_acceso_amonestacion" || 
                        $id_puesto==209){?>
                            <li class="nav-item">
                                <a class="nav-link active" id="registro-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="home" aria-selected="true">Emitidas</a>
                            </li><?php }?>
                            <?php if($nivel_jerarquico==2 || $nivel_jerarquico==3 || 
                            $nivel_jerarquico==4 || $nivel_jerarquico==5 || $nivel_jerarquico==6 || 
                            $nivel_jerarquico==7 || $id_puesto==195){?> 
                            <li class="nav-item">
                                <a class="nav-link" id="aprobacion-tab" data-toggle="tab" href="#aprobacion" role="tab" aria-controls="home" aria-selected="true" onclick="Busca_Amonestacion_Recibida()">Recibidas</a>
                            </li>     
                            <?php }?>
                        </ul>
                        <div class="tab-content" id="simpletabContent">
                            <div class="tab-pane fade show active" id="registro" role="tabpanel" aria-labelledby="registro-tab">
                                <div class="row" id="cancel-row">
                                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                        <div class="widget-content widget-content-area br-6">
                                            <div class="toolbar">
                                                <div align="right">
                                                    <?php 
                                                    if($id_nivel==1 || $id_nivel==2 || $id_puesto==22 || $id_puesto==133 ||
                                                    $_SESSION['usuario'][0]['nivel_jerarquico']==1 || $_SESSION['usuario'][0]['nivel_jerarquico']==2 || 
                                                    $_SESSION['usuario'][0]['nivel_jerarquico']==3 || $_SESSION['usuario'][0]['nivel_jerarquico']==4 || $id_puesto==195 || $id_puesto==209){?>
                                                    <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="{{ url('Modal_Amonestacion') }}" >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                                        Registrar
                                                    </button>
                                                    <?php }?>
                                                </div>
                                            </div>

                                            <div class="table-responsive mb-4 mt-4" id="lista_colaboradorr">
                                                <table id="zero-config" class="table table-hover non-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Código</th>
                                                            <?php if($id_nivel==2 || $id_nivel==1 || 
                                                            $id_puesto==128 || $id_puesto==22 || $id_puesto==209 || $id_puesto==133){ ?>
                                                                <th>Revisado por</th>   
                                                            <?php }?>
                                                            <th>Colaborador</th>
                                                            <?php if($id_nivel==2 || $id_nivel==1 || 
                                                            $id_puesto==128 || $id_puesto==22 || $id_puesto==209 || $id_puesto==133){ ?>
                                                                <th>Solicitante</th>   
                                                            <?php }?> 
                                                            <th>Tipo</th>
                                                            <th>Gravedad</th>
                                                            <th>Motivo</th>
                                                            <th>Estado</th>
                                                            <th class="no-content"></th>
                                                            <th class="no-content"></th>
                                                        </tr>
                                                    </thead>
                                                
                                                    <tbody>
                                                        <?php foreach($list_amonestacion as $list) {  ?>                                           
                                                            <tr>
                                                                <td class="text-center"><?php echo $list['fecha']; ?></td>
                                                                <td class="text-center"><?php echo $list['cod_amonestacion']; ?></td>
                                                                <?php if($id_nivel==2 || $id_nivel==1 || 
                                                                $id_puesto==128 || $id_puesto==22 || $id_puesto==209 || $id_puesto==133){?>
                                                                    <td><?php echo $list['revisor']; ?></td>
                                                                <?php }?>
                                                                <td><?php echo $list['colaborador']; ?></td>
                                                                <?php if($id_nivel==2 || $id_nivel==1 || 
                                                                $id_puesto==128 || $id_puesto==22 || $id_puesto==209 || $id_puesto==133){?>
                                                                    <td><?php echo $list['solicitante']; ?></td>
                                                                <?php }?>
                                                                <td><?php echo $list['nom_tipo_amonestacion']; ?></td>
                                                                <td><?php echo $list['nom_gravedad_amonestacion']; ?></td>
                                                                <td><?php echo $list['nom_motivo_amonestacion']; ?></td>
                                                                <td><?php echo $list['desc_estado_amonestacion']; ?></td>
                                                                <td class="text-center">
                                                                    <?php if($list['v_documento']=="Si"){ ?>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                                                    <?php }else{ ?>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-warning"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                                    <?php } ?>
                                                                </td> 
                                                                <td class="text-center">
                                                                    <div class="btn-group dropleft" role="group">
                                                                        <a id="btnDropLeft" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                                        </a>
                                                                        <div class="dropdown-menu" aria-labelledby="btnDropLeft" style="padding:0;">
                                                                            <?php if($list['estado_amonestacion']==1 || $id_nivel==1 || $id_nivel==2 || $id_puesto==22 || $id_puesto==209 || $id_puesto==133 || $mostrar_menu==true){?>
                                                                                <a class="dropdown-item" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('Modal_Update_Amonestacion/' . $list['id_amonestacion'] /1) }}" style="cursor:pointer;">Editar</a>
                                                                            <?php } ?>
                                                                            <a class="dropdown-item" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('Corporacion/Modal_Update_Amonestacion/' . $list['id_amonestacion'] /2) }}" style="cursor:pointer;">Detalle</a>
                                                                            <?php if(($id_nivel==2 || $id_puesto==22 || $id_puesto==209 || $id_puesto==133 || $id_nivel==1) && $list['estado_amonestacion']==1){ ?>
                                                                                <a class="dropdown-item" onclick="Aprobacion_Amonestacion('<?php echo $list['id_amonestacion']; ?>','1')" style="cursor:pointer;">Aprobar</a>
                                                                                <a class="dropdown-item" onclick="Aprobacion_Amonestacion('<?php echo $list['id_amonestacion']; ?>','3')" style="cursor:pointer;">Rechazar</a>
                                                                            <?php } ?>
                                                                            <?php if($list['estado_amonestacion']==2 && ($nivel_jerarquico==1 || $nivel_jerarquico==2 || $nivel_jerarquico==3 || 
                                                                            $nivel_jerarquico==4 || $id_nivel==1 || $id_puesto==22 || $id_puesto==209 || $nivel_jerarquico==5 || $id_puesto==133)){ ?> 
                                                                                <a class="dropdown-item" href="{{ url('Pdf_Amonestacion/' . $list['id_amonestacion']) }}" target="_blank" style="cursor:pointer;">PDF</a>
                                                                                <a class="dropdown-item" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Corporacion/Modal_Documento_Amonestacion/' . $list['id_amonestacion']) }}" style="cursor:pointer;">Cargar Documento</a>
                                                                            <?php } ?>
                                                                            <?php if($list['documento']!=""){ ?> 
                                                                                <a class="dropdown-item" data-toggle="modal" data-target="#Modal_IMG" data-imagen="<?php echo $url[0]['url_config'].$list['documento']; ?>" data-title="Documento Adjuntado" style="cursor:pointer;">Documento Adjuntado</a>
                                                                            <?php } ?>
                                                                            <?php if($list['estado_amonestacion']==1 || $id_nivel==1 || $id_nivel==2 || $id_puesto==22 || $id_puesto==209 || $id_puesto==133 || ($mostrar_menu==true && $list['estado_amonestacion']==1)){ ?>
                                                                                <a class="dropdown-item" onclick="Delete_Amonestacion('<?php echo $list['id_amonestacion']; ?>')" style="cursor:pointer;">Eliminar</a>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade show" id="aprobacion" role="tabpanel" aria-labelledby="aprobacion-tab" id="div_aprobacion">
                                <div class="row" id="cancel-row">
                                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                        <div class="widget-content widget-content-area br-6">
                                            <div class="table-responsive mb-4 mt-4" id="lista_recibidas" style="max-width:100%; overflow:auto;">
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
</div>

<script>
    $(document).ready(function() { 
        $("#rhumanos").addClass('active');
        $("#hrhumanos").attr('aria-expanded','true');
        $("#amonestaciones").addClass('active');

        if(<?php echo $id_nivel ?>==1 || <?php echo $id_nivel ?>==2 || <?php echo $id_puesto ?>==133 || 
        <?php echo $nivel_jerarquico ?>==1 || 
        <?php echo $nivel_jerarquico ?>==2 || 
        <?php echo $nivel_jerarquico ?>==3 || 
        <?php echo $nivel_jerarquico ?>==4 || <?php echo $id_puesto ?>==195 || 
        <?php echo $id_puesto ?>==209){
            
        }else if(<?php echo $nivel_jerarquico ?>==2 || <?php echo $nivel_jerarquico ?>==3 || 
        <?php echo $nivel_jerarquico ?>==4 || <?php echo $nivel_jerarquico ?>==5 || 
        <?php echo $nivel_jerarquico ?>==6 || <?php echo $nivel_jerarquico ?>==7 || <?php echo $id_puesto ?>==195){
            $('#aprobacion-tab').click();
        }
        $('#zero-config').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10
        });
    });
    
</script>
<style>
    #zero-config_length, #zero-config_info{
        padding: 1rem;
    }
</style>
@endsection

<?php $this->load->view('header'); ?>
<?php $this->load->view('nav'); ?>
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
    $sesion =  $_SESSION['usuario'][0];
    $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
    $desvinculacion=$_SESSION['usuario'][0]['desvinculacion'];
    $estado=$_SESSION['usuario'][0]['estado'];
    $id_puesto=$_SESSION['usuario'][0]['id_puesto'];
    $id_cargo=$_SESSION['usuario'][0]['id_cargo'];
    $usuario_codigo=$_SESSION['usuario'][0]['usuario_codigo'];
    $centro_labores=$_SESSION['usuario'][0]['centro_labores'];
    $estado=$_SESSION['usuario'][0]['estado'];
    $acceso=$_SESSION['usuario'][0]['acceso'];
    $induccion=$_SESSION['usuario'][0]['induccion'];
    $registro_masivo=$_SESSION['usuario'][0]['registro_masivo'];
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        
        <div class="page-header">
            <div class="page-title">
                <h3>Permiso de Salida</h3>
                <!--
                    <a type="button" class="btn btn-danger mb-2 mr-2" data-toggle="modal" data-target="#profileModal">
                        Profile
                    </a>
                -->
            </div>
        </div>

        <div class="row" id="cancel-row">
            <!-- && $estado==3  -->
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="toolbar">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label text-bold">Estado Solicitud:</label>
                                    <select id="estado_solicitud" name="estado_solicitud" class="form-control" >
                                        <option value="0">Todos</option>    
                                        <option value="1" selected>En Proceso de aprobacion</option>
                                        <option value="2">Aprobados</option>
                                        <option value="3">Denegados</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="<?= site_url('Corporacion/Modal_Papeletas_Salida/0') ?>" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                                Registrar
                                            </button>
                                        </div>
                                        <?php if($registro_masivo == 1 || $id_nivel==1 || $id_puesto==314) {  ?>  
                                            <div class="form-group col-md-3">
                                                <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="<?= site_url('Corporacion/Modal_Papeletas_Salida/1') ?>" >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                                    Registro Masivo
                                                </button>
                                            </div>
                                        <?php } ?>
                                        <!--<div class="row">
                                            <div class="form-group col-md-2">
                                                <a title="para crear otra papeleta de salida debe esperar la aprobaciòn o denegaciòn de la anterior" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a>
                                            </div>
                                        </div>-->
                                    </div>
                                    <?php //}else{  ?>
                                        <!--<div class="row">
                                            <div class="form-group col-md-12">
                                                <b>Para crear otra papeleta de salida debe esperar la aprobación o denegación de la anterior</b>
                                            </div>
                                        </div>-->
                                    <?php //} ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-4 mt-4" id="lista_colaborador">
                        <table id="style-3" class="table style-3 " style="width:100%">
                            <thead>
                                <tr>
                                    <!--<th>Colaborador</th>-->
                                    <th>Motivo</th>
                                    <th>Destino</th>
                                    <th>Trámite</th>
                                    <th><div align="center">Fecha</div></th>
                                    <th><div align="center">H. Salida</div></th>
                                    <th><div align="center">H. Retorno</div></th>
                                    <th><div align="center">Estado</div></th>
                                    <?php if($ultima_papeleta_salida_todo > 0) {  ?><th class="no-content"></th><?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($list_papeletas_salida as $list) {  ?>   
                                <tr>
                                    <!--<td> <?php echo $list['usuario_apater']." ".$list['usuario_amater']; ?></td>-->
                                        <!--<td class="text-center">
                                        <a  title="Usuario" class="profile-img"  onclick="Vista_Imagen_Perfil('<?php echo base_url().$list['foto'] ?>','<?php echo $list['usuario_nombres'] ?>');"  role="button">
                                            <span><img style="object-fit: cover;" src="<?php
                                                if(isset($list['foto'])) {
                                                    echo base_url().$list['foto']; 
                                                }else{
                                                    echo base_url().'template/assets/img/90x90.jpg'; 
                                                }
                                                ?>" class="rounded-circle profile-img" alt="avatar">
                                            </span>
                                        </a>
                                    </td>-->
                                    <td>
                                        <?php 
                                            if( $list['id_motivo']==1){
                                                echo "Laboral"; 
                                            }else if ($list['id_motivo']==2){
                                                echo "Personal"; 
                                            }else{
                                                echo $list['motivo']; 
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $list['destino']; ?>
                                    </td>
                                    <td>
                                        <?php echo $list['tramite']; ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                            /*$fecha_subida=strtotime(date($list['fec_solicitud']));
                                            $obj=&get_instance();
                                            $obj->load->model('Fecha');
                                            $diasemana = $obj->Fecha->dateFriendly($fecha_subida);
                                            echo $diasemana;*/
                                            echo date_format(date_create($list['fec_solicitud']), "d/m/Y");
                                        ?>     
                                    </td>
                                    <td align="center">
                                        <?php
                                            if($list['sin_ingreso'] == 1 ){
                                                echo "Sin Ingreso";
                                            }else{
                                                echo $list['hora_salida']; 
                                            }
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php 
                                            if($list['sin_retorno'] == 1 ){
                                                echo "Sin Retorno";
                                            }else{ 
                                                echo $list['hora_retorno'];
                                            } 
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php 
                                            if( $list['estado_solicitud']=='1'){
                                                echo "<span class='shadow-none badge badge-warning'>En proceso</span>"; 
                                            }else if ($list['estado_solicitud']=='2'){
                                                echo "<span class='shadow-none badge badge-primary'>Aprobado</span>"; 
                                            }else if ($list['estado_solicitud']=='3'){
                                                echo " <span class='shadow-none badge badge-danger'>Denegado</span>"; 
                                            }else if ($list['estado_solicitud']=='4'){
                                                echo "<span class='shadow-none badge badge-warning'>En proceso - Aprobación Gerencia</span>"; 
                                            }else if($list['estado_solicitud']=='5') {
                                                echo "<span class='shadow-none badge badge-warning'>En proceso - Aprobación RRHH</span>"; 
                                            }else{
                                                echo "<span class='shadow-none badge badge-primary'>Error</span>"; 
                                            }
                                        ?>
                                    </td>
                                    <?php if( $ultima_papeleta_salida_todo > 0){ ?>
                                        <td class="text-center">
                                            <?php if( $list['estado_solicitud']=='1'){ ?>
                                                <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="<?= site_url('Corporacion/Modal_Update_Papeletas_Salida') ?>/<?php echo $list["id_solicitudes_user"]; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                </a>
                                                <a href="#" class="" title="Eliminar" onclick="Delete_Papeletas_Salida('<?php echo $list['id_solicitudes_user']; ?>')" id="Eliminar" role="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </a>
                                            <?php }else{?>
                                                <a title="No puedes editar" class="anchor-tooltip tooltiped"><div class="divdea">
                                                <svg id="Layer_1" width="13" height="13" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><defs><style>.cls-1{fill:#2d3e50;}</style></defs><title>n</title><path class="cls-1" d="M86.15787,99.25657c-3.54161,2.827-10.03158,6.41724-14.75995,6.08384-4.67736-.3298-3.78182-4.78987-2.85481-8.295l7.83763-29.63476a13.29171,13.29171,0,0,0-25.68221-6.86278C49.55418,64.7858,40.39666,102.57942,40.34023,102.816c-1.28065,5.36943-2.81226,12.2324-.45115,17.525,3.58188,8.02819,14.46035,5.69646,21.06968,3.78541a52.68574,52.68574,0,0,0,12.91952-5.64322,118.52775,118.52775,0,0,0,13.15678-10.41187Z"/><path class="cls-1" d="M74.55393,2.049c-9.8517-.61753-19.65075,8.23893-20.034,18.3877a15.14774,15.14774,0,0,0,2.23531,8.54311c6.11649,9.89677,20.16846,7.7415,27.76526.91074C94.54734,20.87483,87.832,2.88134,74.55393,2.049Z"/></svg>
                                                </div></a>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
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
        $("#papeletas_salidas").addClass('active');
    });
</script>

<?php $this->load->view('validaciones'); ?>
<?php $this->load->view('footer'); ?>
<!-- Modal 
<div class="modal fade profile-modal" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="background-color: #1b55e2;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="modal-header justify-content-center" id="profileModalLabel">
                <div class="modal-profile">
                    <img style="border-radius: 100% !important;height: 200px;width: 200px;object-fit: cover;" id="modalImgs" alt="avatar" src="assets/img/90x90.jpg" class="rounded-circle">
                </div>
            </div>
            <div class="modal-body text-center">
                <p style="word-break: break-all;" id="modelTitle" class="mt-2"></p>
            </div>

            <div class="modal-footer justify-content-center mb-4" id="descargarcertificado_estudiog">
            </div>
            <div align="center" ></div>

        </div>
    </div>
</div>
-->
<script>
    /***********primero tooltip */
    var anchors = document.querySelectorAll('.anchor-tooltip');
    anchors.forEach(function(anchor) {
        var toolTipText = anchor.getAttribute('title'),
            toolTip = document.createElement('span');
        toolTip.className = 'title-tooltip';
        toolTip.innerHTML = toolTipText;
        anchor.appendChild(toolTip);
    });
    /***********primero tooltip. */


    $('.buttonDownload[download]').each(function() {
        var $a = $(this),
        fileUrl = $a.attr('href');
        $a.attr('href', 'data:application/octet-stream,' + encodeURIComponent(fileUrl));
    });

    function Vista_Imagen_Perfil(image_url,imageTitle){
        $('#modelTitle').html(imageTitle); 
        $('#modalImgs').attr('src',image_url);
        $('#profileModal').modal('show');
        //var nombredeusu= $("#id_usuarioactual").val();
        var nombredeusu= 'p';
        document.getElementById("descargarcertificado_estudiog").innerHTML = "<a href='"+image_url+"' id='imga' class='btn buttonDownload' download='qr_"+nombredeusu+".jpg'>Descargar</a>"
    }

    $('#estado_solicitud').change(function(){
    var data= $(this).val();
    //alert(data);            
    });

    $('#estado_solicitud').on('change', function() {
        $(document)
        .ajaxStart(function() {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function() {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var estado_solicitud = this.value;
        var url = "<?php echo site_url(); ?>Corporacion/Buscar_Estado_Solicitud_Papeletas_Salida_Usuario";
            $.ajax({
                type:"POST",
                url:url,
                data: {'estado_solicitud':estado_solicitud },
                success:function (data) {
                    $('#lista_colaborador').html(data);
                }
            });
    });
</script>
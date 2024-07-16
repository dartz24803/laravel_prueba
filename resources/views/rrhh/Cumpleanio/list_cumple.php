<table class="table">
    <tbody>
        <?php if($modal==1){
                $i=0; foreach($list_cumple as $list){$i++;
                    if($i<4){?> 
                    <tr>
                        <td nowrap>
                            <div class="td-content customer-name">
                                <img style="max-width:70px;max-height:70px;border-radius: 10%;border: 3px solid #e0e6ed;"src="<?php echo $get_foto[0]['url_config'].$list['foto_nombre'] ?>" alt="avatar">
                                <span style="color:#3b3f71"><b><?php $nombre=explode(" ",$list['usuario_nombres']); echo ucfirst(strtolower($nombre[0]))." ".ucfirst(strtolower($list['usuario_apater'])) ?></b></span>
                            </div>
                        </td>
                        <td>
                            <div class="td-content customer-name">
                                <span ><?php echo date('d', strtotime($list['cumpleanio']))." de ".strtolower($list['nom_mes']) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="td-content">
                                <?php if($list['id_historial']!=""){
                                    if($list['estado_registro']==1){?> 
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#<?php if($modal==1){echo "ModalRegistro";}else{echo "ModalUpdate";}?>" <?php if($modal==1){echo "app_reg_metalikas";}else{echo "app_elim";}?>="<?= site_url('Corporacion/Modal_Saludo_Cumpleanio/') ?><?php echo $list['id_usuario'] ?>/1/<?php echo $modal ?>"><span class="badge badge-success">Modificar Saludo</span></a>            
                                    <?php }else{?> 
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#<?php if($modal==1){echo "ModalRegistro";}else{echo "ModalUpdate";}?>" <?php if($modal==1){echo "app_reg_metalikas";}else{echo "app_elim";}?>="<?= site_url('Corporacion/Modal_Saludo_Cumpleanio/') ?><?php echo $list['id_usuario'] ?>/2/<?php echo $modal ?>"><span class="badge badge-primary">Enviado</span></a>            
                                    <?php }
                                }else{?> 
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#<?php if($modal==1){echo "ModalRegistro";}else{echo "ModalUpdate";}?>" <?php if($modal==1){echo "app_reg_metalikas";}else{echo "app_elim";}?>="<?= site_url('Corporacion/Modal_Saludo_Cumpleanio/') ?><?php echo $list['id_usuario'] ?>/1/<?php echo $modal ?>"><span class="badge badge-success">Saludar</span></a>        
                                <?php }?>
                            </div>
                        </td>
                    </tr>
                <?php } }
            }else{
                foreach($list_cumple as $list){ ?> 
                    <tr>
                        <td nowrap>
                            <div class="td-content customer-name">
                                <img style="max-width:70px;max-height:70px;border-radius: 10%;border: 3px solid #e0e6ed;"src="<?php echo $get_foto[0]['url_config'].$list['foto_nombre'] ?>" alt="avatar">
                                <span style="color:#3b3f71"><b><?php $nombre=explode(" ",$list['usuario_nombres']); echo ucfirst(strtolower($nombre[0]))." ".ucfirst(strtolower($list['usuario_apater'])) ?></b></span>
                            </div>
                        </td>
                        <td>
                            <div class="td-content customer-name">
                                <span ><?php echo date('d', strtotime($list['cumpleanio']))." de ".strtolower($list['nom_mes']) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="td-content">
                                <?php if($list['id_historial']!=""){
                                    if($list['estado_registro']==1){?> 
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#<?php if($modal==1){echo "ModalRegistro";}else{echo "ModalUpdate";}?>" <?php if($modal==1){echo "app_reg_metalikas";}else{echo "app_elim";}?>="<?= site_url('Corporacion/Modal_Saludo_Cumpleanio/') ?><?php echo $list['id_usuario'] ?>/1/<?php echo $modal ?>"><span class="badge badge-success">Modificar Saludo</span></a>            
                                    <?php }else{?> 
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#<?php if($modal==1){echo "ModalRegistro";}else{echo "ModalUpdate";}?>" <?php if($modal==1){echo "app_reg_metalikas";}else{echo "app_elim";}?>="<?= site_url('Corporacion/Modal_Saludo_Cumpleanio/') ?><?php echo $list['id_usuario'] ?>/2/<?php echo $modal ?>"><span class="badge badge-primary">Enviado</span></a>            
                                    <?php }
                                }else{?> 
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#<?php if($modal==1){echo "ModalRegistro";}else{echo "ModalUpdate";}?>" <?php if($modal==1){echo "app_reg_metalikas";}else{echo "app_elim";}?>="<?= site_url('Corporacion/Modal_Saludo_Cumpleanio/') ?><?php echo $list['id_usuario'] ?>/1/<?php echo $modal ?>"><span class="badge badge-success">Saludar</span></a>        
                                <?php }?>
                            </div>
                        </td>
                    </tr>
                <?php  }
            }?>     
    </tbody>
</table>
<?php if(count($list_cumple)>3 && $modal==1){?> 
    <div class="tm-action-btn">
        <button class="btn" href="javascript:void(0)" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="<?= site_url('Corporacion/Modal_Ver_Todo_Cumpleanios') ?>"><span>Ver Todos</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></button>
    </div>    
<?php }?>
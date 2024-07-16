<div class="modal-header">
    <h5 class="modal-title">Lista de Próximos Cumpleaños</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div> 
            
<div class="modal-body" style="max-height:700px; overflow:auto;">
    <div class="col-md-12 row" id="busqueda2">     
        <table class="table">
            <tbody>
                <?php foreach($list_cumple as $list){?> 
                    <tr>
                        <td nowrap>
                            <div class="td-content customer-name">
                                <img style="max-width:70px;max-height:70px;border-radius: 10%;border: 3px solid #e0e6ed;"src="<?php echo $get_foto[0]['url_config'].$list['foto_nombre'] ?>" alt="avatar" title="<?php echo $list['foto_nombre'] ?>">
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
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Saludo_Cumpleanio/') ?><?php echo $list['id_usuario'] ?>/1/2"><span class="badge badge-success">Modificar Saludo</span></a>            
                                    <?php }else{?> 
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Saludo_Cumpleanio/') ?><?php echo $list['id_usuario'] ?>/2/2"><span class="badge badge-primary">Enviado</span></a>            
                                    <?php }
                                }else{?> 
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Saludo_Cumpleanio/') ?><?php echo $list['id_usuario'] ?>/1/2"><span class="badge badge-success">Saludar</span></a>        
                                <?php }?>
                            </div>
                        </td>
                    </tr>
                <?php }?>     
            </tbody>
        </table>
    </div>   	                	        
</div>

<div class="modal-footer">
    <button class="btn btn-primary mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>   
</div>


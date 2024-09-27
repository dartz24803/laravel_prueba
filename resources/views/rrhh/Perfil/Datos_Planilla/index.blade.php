<table class="table" id="tableMain3">
    <thead>
        <tr class="tableheader">
            <th>Estado</th>
            <th>Situacion Laboral</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Empresa</th>
            <th>Días Laborados</th>
            <th>Sueldo</th>
            <th>Bono</th>
            <th>Total</th>
            <th>Observaciones</th>
            <th>Motivo Cese</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0; foreach($list_datos_planilla as $list){ $i=$i+1;?>
        <tr>
            <td><?php echo $list['estado_colaborador'] ; ?></td>
            <td><?php echo $list['nom_situacion_laboral'] ; ?></td>
            <td><?php echo $list['fecha_inicio']; ?></td>
            <td><?php echo $list['fecha_fin'] ; ?></td>
            <td><?php if($list['id_empresa']!=0){ echo $list['nom_empresa']; } ?></td>
            <td><?php
                if($list['fec_fin']=="0000-00-00"){
                    $datetime1 = date_create(date("Y-m-d"));
                }else{
                    $datetime1 = date_create($list['fec_fin']);
                }
                $datetime2 = date_create($list['fec_inicio']);
                $interval = date_diff($datetime2, $datetime1);
                if(($interval->format('%R%a')+1)>0){ ?>
                                                                    
                    <span class="badge badge-success"><?php echo (($interval->format('%R%a'))+1)." Día(s)"; ?></span>
                <?php } ?>
            </td>
            <td nowrap><?php echo "S/. ".$list['sueldo'] ; ?></td>
            <td nowrap><?php echo "S/. ".$list['bono'] ; ?></td>
            <td nowrap><?php echo "S/. ".$list['total'] ; ?></td>
            <td><?php echo nl2br($list['observacion']) ; ?></td>
            <td><?php echo $list['nom_motivo'];
                if($list['archivo_cese']!=""){?> 
                    <a style="cursor:pointer;display: -webkit-inline-box;" title="Carta" data-toggle="modal" data-target="#Modal_IMG" data-imagen="<?php echo $url_cese[0]['url_config'].$list['archivo_cese']; ?>" data-title="Archivo de Motivo de Cese" >
                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                    </a> 
                <?php }
                ?>
            </td>
            <td nowrap>
                <?php if($list['estado']!=3){ ?>
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="<?= site_url('Corporacion/Modal_Update_Dato_Planilla') ?>/<?php echo $list['id_historico_colaborador']; ?>/<?php echo $list['id_historico_estado_colaborador'] ?>" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                <?php }else{ ?>
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="<?= site_url('Corporacion/Modal_Update_Dato_Planilla_Finalizado') ?>/<?php echo $list['id_historico_colaborador']; ?>/<?php echo $list['id_historico_estado_colaborador'] ?>" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                <?php } ?>
                
                <a href="javascript:void(0);"  title="Documentos" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg_metalikas="<?= site_url('Corporacion/Modal_Documentos_Dato_Planilla') ?>/<?php echo $list['id_historico_colaborador'] ?>/<?php echo $get_id[0]['id_usuario']; ?>" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>
                </a>
                
                <?php if($list['id_situacion_laboral']==2){?> 
                        <a href="<?= site_url('Corporacion/Contrato') ?>/<?php echo $list['id_historico_colaborador']; ?>/<?php echo $get_id[0]['id_usuario']; ?>" title="Contrato" target="_blank" >
                            <svg id="Capa_1" enable-background="new 0 0 512 512" height="24" viewBox="0 0 512 512" width="24" xmlns="http://www.w3.org/2000/svg"><g><g><path d="m459.265 466.286c0 25.248-20.508 45.714-45.806 45.714h-314.918c-25.298 0-45.806-20.467-45.806-45.714v-420.572c0-25.247 20.508-45.714 45.806-45.714h196.047c9.124 0 17.874 3.622 24.318 10.068l130.323 130.34c6.427 6.427 10.036 15.137 10.036 24.217z" fill="#f9f8f9"></path><path d="m129.442 512h-30.905c-25.291 0-45.802-20.47-45.802-45.719v-420.562c0-25.249 20.511-45.719 45.802-45.719h30.905c-25.291 0-45.802 20.47-45.802 45.719v420.561c0 25.25 20.511 45.72 45.802 45.72z" fill="#e3e0e4"></path><path d="m459.265 164.623v16.73h-119.46c-34.12 0-61.873-27.763-61.873-61.883v-119.47h16.658c9.117 0 17.874 3.626 24.312 10.065l130.328 130.339c6.429 6.428 10.035 15.143 10.035 24.219z" fill="#e3e0e4"></path><path d="m456.185 qu150.448h-116.38c-17.101 0-30.967-13.866-30.967-30.978v-116.369c3.719 1.679 7.129 4.028 10.065 6.964l130.328 130.339c2.936 2.935 5.275 6.335 6.954 10.044z" fill="#dc4955"></path><path d="m440.402 444.008h-368.804c-22.758 0-41.207-18.45-41.207-41.207v-150.407c0-22.758 18.45-41.207 41.207-41.207h368.805c22.758 0 41.207 18.45 41.207 41.207v150.406c0 22.759-18.45 41.208-41.208 41.208z" fill="#dc4955"></path><path d="m97.352 444.008h-25.754c-22.757 0-41.207-18.451-41.207-41.207v-150.407c0-22.757 18.451-41.207 41.207-41.207h25.755c-22.757 0-41.207 18.451-41.207 41.207v150.406c-.001 22.757 18.449 41.208 41.206 41.208z" fill="#c42430"></path><g fill="#f9f8f9"><path d="m388.072 277.037c4.267 0 7.726-3.458 7.726-7.726s-3.459-7.726-7.726-7.726h-47.247c-4.267 0-7.726 3.458-7.726 7.726v116.573c0 4.268 3.459 7.726 7.726 7.726s7.726-3.458 7.726-7.726v-51.664h35.768c4.267 0 7.726-3.458 7.726-7.726s-3.459-7.726-7.726-7.726h-35.768v-41.731z"></path><path d="m258.747 262.891h-32.276c-2.052 0-4.019.816-5.468 2.268s-2.262 3.42-2.258 5.472v.101.004 111.99c0 .637.085 1.252.231 1.844v.035c.007 2.049.829 4.012 2.283 5.456 1.447 1.437 3.405 2.243 5.443 2.243h.029c.974-.004 23.943-.093 33.096-.251 15.515-.272 29.33-7.303 38.904-19.798 8.875-11.583 13.763-27.443 13.763-44.657 0-38.703-21.599-64.707-53.747-64.707zm.811 113.71c-5.75.1-17.382.173-25.155.213-.043-12.743-.122-37.877-.122-49.343 0-9.584-.044-35.933-.068-49.127h24.535c28.234 0 38.294 25.442 38.294 49.254-.001 28.467-15.415 48.617-37.484 49.003z"></path></g></g><path d="m146.336 261.444h-32.967c-6.746 0-7.102 2.938-7.102 7.099v118.397c0 3.921 3.178 7.099 7.099 7.099 3.92 0 7.099-3.177 7.099-7.099v-44.368c7.698-.044 19.916-.107 25.868-.107 22.698 0 41.165-18.173 41.165-40.511-.001-22.337-18.464-40.51-41.162-40.51zm0 66.824c-5.913 0-17.952.061-25.679.106-.044-7.914-.107-20.39-.107-26.419 0-5.066-.036-18.095-.061-26.313h25.846c14.618 0 26.967 12.049 26.967 26.313.001 14.264-12.349 26.313-26.966 26.313z" fill="#f9f8f9"></path></g></svg>
                        </a>
                    <?php }if($i==1){?>
                    <a title="Eliminar" onclick="Delete_Dato_Planilla('<?php echo $list['id_historico_colaborador']; ?>','<?php echo $get_id[0]['id_usuario']; ?>','<?php echo $list['id_historico_estado_colaborador'] ?>','<?php echo $list['eliminar'] ?>')" id="delete" role="button">
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
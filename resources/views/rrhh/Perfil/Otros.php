<div class="col-md-4">
    <div class="form-group">
        <label for="nacionalidad">Tipo de sangre</label>
        <select class="form-control" name="id_grupo_sanguineo" id="id_grupo_sanguineo" >
        <option value="0">Seleccion</option>
        <?php foreach($list_grupo_sanguineo as $list){
            if($get_id_otros[0]['id_grupo_sanguineo'] == $list['id_grupo_sanguineo']){ ?>
            <option selected value="<?php echo $list['id_grupo_sanguineo']; ?>"><?php echo $list['nom_grupo_sanguineo'];?></option> 
        <?php }else{?>
        <option value="<?php echo $list['id_grupo_sanguineo']; ?>"><?php echo $list['nom_grupo_sanguineo'];?></option>
        <?php } } ?>
        </select>
    </div>
</div>                                                            

<div class="col-md-4">
    <div class="form-group">
        <label for="dni_img">Adjuntar Vacuna COVID</label>
        <?php if(isset($get_id_otros[0]['cert_vacu_covid']) && $get_id_otros[0]['cert_vacu_covid']!="" ){
            $img_info=get_headers($url_otro[0]['url_config'].$get_id_otros[0]['cert_vacu_covid']);
            if(strpos($img_info[0],'200')!==false){?>
                <a style="cursor:pointer;display: -webkit-inline-box;" data-title="Vacuna COVID" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_otro[0]['url_config'].$get_id_otros[0]['cert_vacu_covid']; ?>" >
                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533 s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2 s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/> <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667 s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/> <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733 c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g> <g></g> <g> </g> <g>  </g>  <g></g> <g> </g><g>  </g><g></g><g></g><g></g><g></g> <g></g></svg>
                </a>
            <?php } } ?>
        <input type="file" class="form-control-file" id="certificadootr_vacu" name="certificadootr_vacu" onchange="return validar_vacuCOVID()"  />                                                                                                             
    </div>
</div>
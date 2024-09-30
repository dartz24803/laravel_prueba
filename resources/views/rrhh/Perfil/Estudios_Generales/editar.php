<div class="col-md-4">
    <div class="form-group">
        <label for="fami_paren">Grado de Instrucción</label>
        <select class="form-control" id="id_grado_instruccion" name="id_grado_instruccion">
            <option value="0">Seleccione</option>
            <?php 
            foreach($list_grado_instruccion as $list){
            if($get_id[0]['id_grado_instruccion'] == $list['id_grado_instruccion']){ ?>
            <option selected value="<?php echo $list['id_grado_instruccion'] ; ?>"><?php echo $list['nom_grado_instruccion'];?></option>
            <?php } else{ ?>
            <option value="<?php echo $list['id_grado_instruccion'] ; ?>"><?php echo $list['nom_grado_instruccion'];?></option>
            <?php }} ?>
        </select>
    </div>
</div>

<div class="col-md-8">
    <div class="form-group">
        <label for="nom_contacto_emer">Carrera de Estudios</label>
        <input type="text" class="form-control mb-4" id="carrera" name="carrera" value="<?php echo $get_id['0']['carrera']; ?>">
    </div>
</div>

<div class="col-md-8">
    <div class="form-group">
        <label for="familiar_celular">Centro de Estudios</label>
        <input type="text" class="form-control mb-4" id="centro" name="centro" value="<?php echo $get_id['0']['centro']; ?>">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="documentoe">Adjuntar Documento</label>
        <?php if($get_id[0]['documentoe']!="") {
            $img_info=get_headers($url_estudiog[0]['url_config'].$get_id[0]['documentoe']);
            if(strpos($img_info[0],'200')!==false){?>
            <a style="cursor:pointer;display: -webkit-inline-box;" data-title="Certificado de Estudios" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_estudiog[0]['url_config'].$get_id[0]['documentoe']; ?>" >
                <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533 s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                </svg>
            </a>
            <?php } } ?>
        <input type="file" class="form-control-file" id="documentoe" name="documentoe">
    </div>
</div>

<input type="hidden" id="documentoe_nombre" name="documentoe_nombre" value="<?php echo $get_id['0']['documentoe_nombre']; ?>">
<input type="hidden" id="id_estudios_generales" name="id_estudios_generales" value="<?php echo $get_id['0']['id_estudios_generales']; ?>">
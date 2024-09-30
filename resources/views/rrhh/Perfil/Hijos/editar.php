<div class="col-md-12">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="nacionalidad">Respuesta</label>
                <select class="form-control" id="id_respuestah" name="id_respuestah" onchange="ValidaH();">
                <option value="0">Seleccione</option>
                <option value="1" <?php if(isset($get_id['0']['hijos']) && $get_id[0]['hijos'] == 1){ echo "selected";} ?>>SÍ</option>
                <option value="2" <?php if(isset($get_id['0']['hijos']) && $get_id[0]['hijos'] == 2){ echo "selected";} ?>>NO</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="nom_familiar">Nombre de Hijo</label>
                <input type="text" class="form-control mb-4 limpiarhijos" maxlength = "150"  id="nom_hijo" name="nom_hijo" value="<?php echo $get_id['0']['nom_hijo']; ?>">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="fami_paren">Genero</label>
                <select class="form-control limpiarefselecthijos" id="id_generoh" name="id_generoh">
                    <option value="0">Seleccione</option>
                    <?php 
                    foreach($list_genero as $list){
                    if($get_id[0]['id_genero'] == $list['id_genero']){ ?>
                    <option selected value="<?php echo $list['id_genero'] ; ?>"><?php echo $list['nom_genero'];?></option>
                    <?php }else{ ?>
                    <option value="<?php echo $list['id_genero'] ; ?>"><?php echo $list['nom_genero'];?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <label class="naci_familiar">Fecha de Nacimiento</label>
            <div class="d-sm-flex d-block">
                <div class="form-group mr-2">
                    <select class="form-control limpiarefselecthijos" id="dia_nachj" name="dia_nachj">
                    <option value="0">Día</option>
                    <?php foreach($list_dia as $list){
                    if($get_id[0]['dia_nac'] == $list['cod_dia']){ ?>
                    <option selected value="<?php echo $list['cod_dia'] ; ?>"><?php echo $list['cod_dia'];?></option>
                    <?php } else{ ?>
                    <option value="<?php echo $list['cod_dia'] ; ?>"><?php echo $list['cod_dia'];?></option>
                    <?php } }?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control limpiarefselecthijos" id="mes_nachj" name="mes_nachj">
                        <option value="0">Mes</option>
                        <?php foreach($list_mes as $list){
                        if($get_id[0]['mes_nac'] == $list['cod_mes']){ ?>
                        <option selected value="<?php echo $list['cod_mes'] ; ?>"><?php echo $list['abr_mes'];?></option>
                        <?php } else { ?>
                        <option value="<?php echo $list['cod_mes'] ; ?>"><?php echo $list['abr_mes'];?></option>
                        <?php } }?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control limpiarefselecthijos" id="anio_nachj" name="anio_nachj">
                    <option value="0">Año</option>
                    <?php foreach($list_anio as $list){
                    if($get_id[0]['anio_nac'] == $list['cod_anio']){ ?>
                    <option selected value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                    <?php } else { ?>
                    <option value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                    <?php } } ?>
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
                        maxlength = "8"  id="num_dochj" name="num_dochj" value="<?php echo $get_id['0']['num_doc']; ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="familiar_celular2">Biológico/No Biológico</label>
                <select class="form-control limpiarefselecthijos" id="id_biologico" name="id_biologico">
                <option <?php if($get_id['0']['id_biologico']==0){echo "selected";} ?> value="0">Seleccione</option>
                <option <?php if($get_id['0']['id_biologico']==1){echo "selected";} ?> value="1">SÍ</option>
                <option <?php if($get_id['0']['id_biologico']==2){echo "selected";} ?> value="2">NO</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="documento">Adjuntar Documento</label>
                <?php if($get_id[0]['documento']!="") {
                    $img_info=get_headers($url_dochijo[0]['url_config'].$get_id[0]['documento']);
                    if(strpos($img_info[0],'200')!==false){?>
                    <a style="cursor:pointer;display: -webkit-inline-box;" data-title="DNI de Hijo" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url_dochijo[0]['url_config'].$get_id[0]['documento']; ?>" >
                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                    </a>
                    <?php } } ?>
                <input type="file" class="form-control-file" id="documento" name="documento">
            </div>
        </div>


    </div>
</div>
<input type="hidden" class="form-control mb-4 limpiaref" id="documento_nombre" name="documento_nombre" value="<?php echo $get_id['0']['documento_nombre']; ?>">
<input type="hidden" class="form-control mb-4 limpiaref" id="id_hijos" name="id_hijos" value="<?php echo $get_id['0']['id_hijos']; ?>">
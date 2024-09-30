<div class="col-md-3">
    <div class="form-group">
        <label for="nom_conoci_idiomas">Idioma</label>
        <select class="form-control" name="nom_conoci_idiomas" id="nom_conoci_idiomas" >
        <option value="0">Seleccion</option>
        <?php foreach($list_idiomas as $list){
        if($get_id[0]['nom_conoci_idiomas'] == $list['id_idioma']){ ?>
        <option selected value="<?php echo $list['id_idioma']; ?>"><?php echo $list['nom_idioma'];?></option>
        <?php } else { ?>
        <option value="<?php echo $list['id_idioma']; ?>"><?php echo $list['nom_idioma'];?></option>
        <?php } } ?>
        </select>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="lect_conoci_idiomas">Lectura</label>
        <select class="form-control" name="lect_conoci_idiomas" id="lect_conoci_idiomas" >
        <option value="0">Seleccion</option>
        <?php foreach($list_nivel_instruccion as $list){
        if($get_id[0]['lect_conoci_idiomas'] == $list['id_nivel_instruccion']){ ?>
        <option selected value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
        <?php } else { ?>
        <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
        <?php } } ?>
        </select> 
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="escrit_conoci_idiomas">Escritura</label>
        <select class="form-control" name="escrit_conoci_idiomas" id="escrit_conoci_idiomas" >
        <option value="0">Seleccion</option>
        <?php foreach($list_nivel_instruccion as $list){
        if($get_id[0]['escrit_conoci_idiomas'] == $list['id_nivel_instruccion']){ ?>
        <option selected value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
        <?php } else { ?>
        <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
        <?php } } ?>
        </select> 
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="conver_conoci_idiomas">Conversación</label>
        <select class="form-control" name="conver_conoci_idiomas" id="conver_conoci_idiomas" >
        <option value="0">Seleccion</option>
        <?php foreach($list_nivel_instruccion as $list){
        if($get_id[0]['conver_conoci_idiomas'] == $list['id_nivel_instruccion']){ ?>
        <option selected value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
        <?php } else { ?>
        <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
        <?php } } ?>
        </select> 
    </div>
</div>
<input type="hidden" id="id_conoci_idiomas" name="id_conoci_idiomas" value="<?php echo $get_id['0']['id_conoci_idiomas']; ?>">
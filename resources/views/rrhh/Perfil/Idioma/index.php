<div class="col-md-3">
    <div class="form-group">
        <label for="nom_conoci_idiomas">Idioma</label>
        <select class="form-control" name="nom_conoci_idiomas" id="nom_conoci_idiomas" >
        <option value="0">Seleccion</option>
        <?php foreach($list_idiomas as $list){ ?>
        <option value="<?php echo $list['id_idioma']; ?>"><?php echo $list['nom_idioma'];?></option>
        <?php } ?>
        </select>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="lect_conoci_idiomas">Lectura</label>
        <select class="form-control" name="lect_conoci_idiomas" id="lect_conoci_idiomas" >
        <option value="0">Seleccion</option>
        <?php foreach($list_nivel_instruccion as $list){ ?>
        <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
        <?php } ?>
        </select> 
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="escrit_conoci_idiomas">Escritura</label>
        <select class="form-control" name="escrit_conoci_idiomas" id="escrit_conoci_idiomas" >
        <option value="0">Seleccion</option>
        <?php foreach($list_nivel_instruccion as $list){ ?>
        <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
        <?php } ?>
        </select> 
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="conver_conoci_idiomas">Conversación</label>
        <select class="form-control" name="conver_conoci_idiomas" id="conver_conoci_idiomas" >
        <option value="0">Seleccion</option>
        <?php foreach($list_nivel_instruccion as $list){ ?>
        <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
        <?php } ?>
        </select> 
    </div>
</div>
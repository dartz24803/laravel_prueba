<div class="col-md-4">
    <div class="form-group">
        <label for="fami_paren">Grado de Instrucción</label>
        <select class="form-control" id="id_grado_instruccion" name="id_grado_instruccion">
            <option value="0">Seleccione</option>
            <?php 
            foreach($list_grado_instruccion as $list){ ?>
            <option value="<?php echo $list['id_grado_instruccion'] ; ?>">
            <?php echo $list['nom_grado_instruccion'];?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="col-md-8">
    <div class="form-group">
        <label for="nom_contacto_emer">Carrera de Estudios</label>
        <input type="text" class="form-control mb-4" id="carrera" name="carrera">
    </div>
</div>

<div class="col-md-8">
    <div class="form-group">
        <label for="familiar_celular">Centro de Estudios</label>
        <input type="text" class="form-control mb-4" id="centro" name="centro">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="documentoe">Adjuntar Documento</label>
        <input type="file" class="form-control-file" id="documentoe" name="documentoe">
    </div>
</div>
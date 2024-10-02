<div class="col-md-4">
    <div class="form-group">
        <label for="cursos_complemetarios">Cursos/Conocimientos Complementarios</label>
        <input type="text" class="form-control mb-4" id="nom_curso_complementario" name="nom_curso_complementario">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="fami_paren">Año</label>
        <select class="form-control" id="aniocc" name="aniocc">
        <option value="0">Seleccionar</option>
        <option value="1">Actualidad</option>
        <?php foreach($list_anio as $list){ ?>
        <option value="<?php echo $list['cod_anio'] ; ?>">
        <?php echo $list['cod_anio'];?></option>
        <?php } ?>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="adj_certifi">Adjuntar Certificado</label>
        <input type="file" class="form-control-file" id="certificado" name="certificado">
    </div>
</div>

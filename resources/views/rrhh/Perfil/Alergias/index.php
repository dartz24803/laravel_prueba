<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="nacionalidad">Es alérgico a algun medicamento<?php echo $list_usuario[0]['alergia'];?></label>
            <select class="form-control" id="id_respuestaau" name="id_respuestaau" onchange="ValidaA();">
                <option value="0">Seleccione</option>
                <option value="1" <?php if(isset($list_usuario['0']['alergia']) && $list_usuario[0]['alergia'] == 1){ echo "selected";} ?>>SÍ</option>
                <option value="2" <?php if(isset($list_usuario['0']['alergia']) && $list_usuario[0]['alergia'] == 2){ echo "selected";} ?>>NO</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group" id="medicamentou">
            <label for="dni_hijo">Indique el nombre del medicamento</label>
            <input type="text" class="form-control mb-4" id="nom_alergia" name="nom_alergia" value="<?php echo $get_id[0]['nom_alergia']; ?>">
            <!--<input type="text" class="form-control mb-4" id="nom_alergia" name="nom_alergia">-->
        </div>
    </div>
</div>

<!--
<label for="dni_hijo">Indique el nombre del medicamento</label>
<input type="text" class="form-control mb-4" id="nom_alergia" name="nom_alergia" value="<?php echo $get_id['0']['nom_alergia']; ?>">
-->
<input type="hidden" id="id_alergia_usuario" name="id_alergia_usuario" value="<?php echo $get_id['0']['id_alergia_usuario']; ?>">

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="nacionalidad">¿Tiene directorio Telefonico?</label>
            <select class="form-control" id="id_respuesta_directorio_telefonico" name="id_respuesta_directorio_telefonico" onchange="Valida_DirectorioT();">
            <option value="0">Seleccione</option>
            <option value="1" <?php if(isset($list_usuario['0']['directorio']) && $list_usuario[0]['directorio'] == 1){ echo "selected";} ?>>SÍ</option>
            <option value="2" <?php if(isset($list_usuario['0']['directorio']) && $list_usuario[0]['directorio'] == 2){ echo "selected";} ?>>NO</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="dni_hijo">Celular corporativo</label>
            <input type="text" <?php if($get_id[0]['directorio'] == 2){echo "disabled";}?>  class="form-control mb-4" id="num_cele" value="<?php echo $get_id['0']['num_cele'];?>" name="num_cele">
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="dni_hijo">Teléfono fijo corporativo</label>
            <input type="text" <?php if($get_id[0]['directorio'] == 2){echo "disabled";}?>  class="form-control mb-4" id="num_fijoe" value="<?php echo $get_id['0']['num_fijoe'];?>" name="num_fijoe">
        </div>
    </div>


    <div class="col-md-2">
        <div class="form-group">
            <label for="dni_hijo">Nùmero de Anexo</label>
            <input type="text" <?php if($get_id[0]['directorio'] == 2){echo "disabled";}?>  class="form-control mb-4" id="num_anexoe" value="<?php echo $get_id['0']['num_anexoe'];?>" name="num_anexoe">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="dni_hijo">Email Corporativo</label>
            <input type="text" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.toLowerCase();" <?php if($get_id[0]['directorio'] == 2){echo "disabled";}?>  class="form-control mb-4" id="emailp" value="<?php echo $get_id[0]['emailp'];?>" name="emailp">
        </div>
    </div>
</div>
<script>
    $('#num_cele').inputmask("999999999");
</script>

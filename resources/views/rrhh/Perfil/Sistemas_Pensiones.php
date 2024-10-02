<div class="col-md-4">
    <div class="form-group">
        <label for="nacionalidad">Pertenece a algún sistema pensionario</label>
        <select class="form-control" id="id_respuestasp" name="id_respuestasp" onchange="Validasp();">
        <option value="0" <?php if(isset($get_id_sist_pensu['0']['id_respuestasp']) && $get_id_sist_pensu[0]['id_respuestasp'] == 0){ echo "selected";} ?>>Seleccione</option>
        <option value="1" <?php if(isset($get_id_sist_pensu['0']['id_respuestasp']) && $get_id_sist_pensu[0]['id_respuestasp'] == 1){ echo "selected";} ?>>SÍ</option>
        <option value="2" <?php if(isset($get_id_sist_pensu['0']['id_respuestasp']) && $get_id_sist_pensu[0]['id_respuestasp'] == 2){ echo "selected";} ?>>NO</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="camisa">Indique el sistema pensionario que desea</label>
        <select <?php if($get_id_sist_pensu[0]['id_respuestasp'] != 1){echo "disabled";}?> class="form-control" name="id_sistema_pensionario" id="id_sistema_pensionario" onchange="ValidaAFP();">
            <option value="0">Seleccion</option>
            <?php foreach($list_sistema_pensionario as $list){
                if($get_id_sist_pensu[0]['id_sistema_pensionario'] == $list->id_sistema_pensionario){ ?>
                <option selected value="<?php echo $list->id_sistema_pensionario; ?>"><?php echo $list->cod_sistema_pensionario;?></option> 
            <?php }else{?>
            <option value="<?php echo $list->id_sistema_pensionario; ?>"><?php echo $list->cod_sistema_pensionario;?></option>
            <?php } } ?>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="pantalon">Si indico AFP elija</label>
        <select <?php if($get_id_sist_pensu[0]['id_sistema_pensionario'] != 2){echo "disabled";}?> class="form-control" name="id_afp" id="id_afp" >
            <option value="0">Seleccion</option>
            <?php foreach($list_afp as $list){
                if($get_id_sist_pensu[0]['id_afp'] == $list['id_afp']){ ?>
                <option selected value="<?php echo $list['id_afp']; ?>"><?php echo $list['nom_afp'];?></option> 
            <?php }else{?>
            <option value="<?php echo $list['id_afp']; ?>"><?php echo $list['nom_afp'];?></option>
            <?php } } ?>
        </select>
    </div>
</div>
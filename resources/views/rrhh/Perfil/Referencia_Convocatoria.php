<div class="col-md-4">
    <div class="form-group">
        <label for="nacionalidad">Indica ¿Cómo te enteraste del puesto?</label>
        <select class="form-control" name="id_referencia_laboral" id="id_referencia_laboral" onchange="ValidaRC();">
        <option value="0">Seleccion</option>
        <?php foreach($list_referencia_laboral as $list){
            if($get_id_referenciac[0]['id_referencia_laboral'] == $list['id_referencia_laboral']){ ?>
            <option selected value="<?php echo $list['id_referencia_laboral']; ?>"><?php echo $list['nom_referencia_laboral'];?></option>
        <?php }else{?>
        <option value="<?php echo $list['id_referencia_laboral']; ?>"><?php echo $list['nom_referencia_laboral'];?></option>
        <?php } } ?>
        </select>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="usuario_email">Especifique otros</label>
        <input type="text" <?php if(isset($get_id_referenciac['0']['id_referencia_laboral']) && $get_id_referenciac[0]['id_referencia_laboral'] != 6){echo "disabled";}?> class="form-control mb-4" id="otrosel" name="otrosel" value="<?php if(isset($get_id_referenciac['0']['otros'])) {echo $get_id_referenciac['0']['otros'];}?>">
    </div>
</div>
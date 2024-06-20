<select name="motivo<?php if($t==2){echo "e";} ?>" id="motivo<?php if($t==2){echo "e";} ?>" class="form-control">
    <option value="0">Seleccione</option>
    <?php foreach($list_motivo_amonestacion as $list){?> 
    <option value="<?php echo $list['id_motivo_amonestacion'] ?>"><?php echo $list['nom_motivo_amonestacion'] ?></option>    
    <?php }?>
</select>
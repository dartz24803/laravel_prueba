<select class="form-control" name="id_tipo<?php if($m==2){echo "e";}?>" id="id_tipo<?php if($m==2){echo "e";}?>" onchange="Tipo_Piocha<?php if($m==2){echo 'e';}?>();">
    <option value="0">Seleccione</option>
    <?php foreach($list_tipo as $list){ ?>
        <option value="<?php echo $list['id_tipo_ocurrencia']; ?>"><?php echo $list['nom_tipo_ocurrencia']; ?></option>  
    <?php } ?>
</select>
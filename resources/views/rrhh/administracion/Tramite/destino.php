<select class="form-control" id="id_destino" name="id_destino">
    <option value="0">Seleccione</option>
    <?php foreach($list_destino as $list){ ?>
        <option value="<?php echo $list['id_destino']; ?>"><?php echo $list['nom_destino']; ?></option>
    <?php } ?>
</select>
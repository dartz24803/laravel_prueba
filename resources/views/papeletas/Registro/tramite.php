<select class="form-control" id="tramite" name="tramite">
    <option value="0">Seleccione</option>
    <?php foreach($list_tramite as $list){ ?>
        <option value="<?php echo $list['id_tramite']; ?>"><?php echo $list['nom_tramite']; ?></option>
    <?php } ?>
</select>
<option value="0">Seleccionar</option>
<?php foreach($list_responsable as $list){ ?>
    <option value="<?php echo $list->id_usuario; ?>"><?php echo $list->usuario_nombres." ".$list->usuario_apater." ".$list->usuario_amater; ?></option>
<?php } ?>


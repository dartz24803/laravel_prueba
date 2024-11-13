<option value="0">Seleccionar</option>
<?php foreach($list_subitem as $list){ ?>
    <option value="<?php echo $list->id_subitem; ?>"><?php echo $list->nom_subitem; ?></option>
<?php } ?>

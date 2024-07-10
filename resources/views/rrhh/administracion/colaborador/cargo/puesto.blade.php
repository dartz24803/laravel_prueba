<option value="0">Seleccione</option>
<?php foreach($list_puesto as $list){?> 
    <option value="<?php echo $list['id_puesto']; ?>"><?php echo $list['nom_puesto']; ?></option>
<?php } ?>
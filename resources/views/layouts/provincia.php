<select class="form-control" name="id_provincia" id="id_provincia" onchange="distrito()">
<option  value="0">Seleccionar</option>
<?php foreach($list_provincia as $list){ ?>
    <option value="<?php echo $list->id_provincia; ?>"><?php echo $list->nombre_provincia;?></option>
<?php } ?>
</select>  
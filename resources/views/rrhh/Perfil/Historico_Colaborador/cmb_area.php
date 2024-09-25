<option  value="0">Seleccionar</option>
<?php foreach($list_area as $list){ ?>
    <option value="<?= $list['id_area']; ?>"><?= $list['nom_area']; ?></option>
<?php } ?>
<option  value="0">Seleccionar</option>
<?php foreach($list_puesto as $list){ ?>
    <option value="<?= $list['id_puesto']; ?>"><?= $list['nom_puesto']; ?></option>
<?php } ?>
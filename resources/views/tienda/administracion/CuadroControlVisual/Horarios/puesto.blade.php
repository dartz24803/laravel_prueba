<option value="0">Seleccione</option>
<?php foreach($list_puesto as $list){ ?>
    <option value="<?= $list['id_puesto']; ?>"><?= $list['nom_puesto']; ?></option>
<?php } ?>
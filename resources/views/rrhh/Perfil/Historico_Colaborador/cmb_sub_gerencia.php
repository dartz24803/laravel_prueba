<option  value="0">Seleccionar</option>
<?php foreach($list_sub_gerencia as $list){ ?>
    <option value="<?= $list['id_sub_gerencia']; ?>"><?= $list['nom_sub_gerencia']; ?></option>
<?php } ?>
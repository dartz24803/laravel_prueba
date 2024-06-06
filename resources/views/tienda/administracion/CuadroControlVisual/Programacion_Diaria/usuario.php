<option value="0">Seleccione</option>
<?php foreach($list_colaborador as $list){ ?>
    <option value="<?= $list['id_usuario']; ?>"><?= $list['colaborador']; ?></option>
<?php } ?>
<option value="0">TODOS</option>
<?php foreach($list_colaborador as $list){?> 
    <option value="<?= $list['num_doc']; ?>"><?= $list['usuario_apater'].' '.$list['usuario_amater'].' '.$list['usuario_nombres']; ?></option>
<?php } ?>
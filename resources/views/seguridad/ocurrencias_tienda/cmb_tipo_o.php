
    <option value="0">Seleccione</option>
    <?php foreach($list_tipo as $list){ ?>
        <option value="<?php echo $list->id_tipo_ocurrencia; ?>"><?php echo $list->nom_tipo_ocurrencia; ?></option>  
    <?php } ?>
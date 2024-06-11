<option value="0">Seleccione</option>
<?php foreach ($list_horario as $list){ ?>
    <option value="<?php echo $list['id_horarios_cuadro_control']; ?>">
        <?= $list['horario']; ?>
    </option>
<?php } ?>
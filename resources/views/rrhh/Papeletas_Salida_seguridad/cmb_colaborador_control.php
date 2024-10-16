<label class="control-label text-bold">Colaborador:</label>
<select id="num_doc_control" name="num_doc_control" class="form-control basicc">
    <option value="0">TODOS</option>
    <?php foreach($list_colaborador as $list){?> 
        <option value="<?php echo $list['id_usuario']; ?>"> <?php echo $list['usuario_apater']." ".$list['usuario_amater'].", ".$list['usuario_nombres'];?> </option>
    <?php } ?>
</select>
<script>
    var ss = $(".basicc").select2({
        tags: true,
    });
</script>
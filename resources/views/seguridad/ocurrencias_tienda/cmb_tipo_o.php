
<label>Tipo Ocurrencia</label>
<select class="form-control basic" id="tipo_ocurrencia_busq" name="tipo_ocurrencia_busq">                                       
    <option value="0">Seleccione</option>
    <?php foreach($list_tipo as $list){ ?>
        <option value="<?php echo $list->id_tipo_ocurrencia; ?>"><?php echo $list->nom_tipo_ocurrencia; ?></option>  
    <?php } ?>
</select>
<script>
    var ss = $(".basic").select2({
        tags: true,
    });
</script>
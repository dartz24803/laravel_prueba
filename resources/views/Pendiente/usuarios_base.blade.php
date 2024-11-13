<option value="0">Seleccionar</option>
<?php foreach($list_usuario as $list){ ?>
    <option value="<?php echo $list['id_usuario']."-".$list['centro_labores']."-".$list['id_area']; ?>"><?php echo $list['usuario']; ?></option>
<?php } ?>

<script>
    var ss = $(".basic_i").select2({ 
        tags: true,
    });

    $('.basic_i').select2({
        dropdownParent: $('#ModalRegistro')
    });
</script>
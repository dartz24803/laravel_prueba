<select name="id_puesto<?php if($t==2){echo "e";}?>" id="id_puesto<?php if($t==2){echo "e";}?>" class="form-control basic" >
    <option value="0">Seleccione</option>
    <?php foreach($list_puesto as $list){?>
        <option value="<?php echo $list->id_puesto ?>"><?php echo $list->nom_puesto ?></option>
    <?php }?>
</select>
<script>
    var ss = $(".basic").select2({
        tags: true
    });

    v='<?php echo $t ?>';
    if(v==2){
        $('.basic').select2({
            dropdownParent: $('#ModalUpdateGrande')
        });
    }else{
        $('.basic').select2({
            dropdownParent: $('#ModalRegistroGrande')
        });
    }
    
</script>
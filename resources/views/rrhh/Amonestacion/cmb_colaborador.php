<?php if($t==1){?> 
    <select class="form-control tagging" name="id_usuario<?php if($t==2){echo "e";}?>[]" id="id_usuario<?php if($t==2){echo "e";}?>" multiple="multiple">
        <?php foreach($list_colaborador as $list){ ?> 
            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'];?></option>
        <?php }  ?>
    </select>   
<?php }else{?> 
    <select name="id_usuarioe" id="id_usuarioe" class="form-control basice">
        <option value="0">Seleccione</option>
        <?php foreach($list_colaborador as $list){?>
            <option value="<?php echo $list['id_usuario'] ?>"><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></option>
        <?php }?>
    </select>
<?php }?>


<script>
    var ss = $(".tagging").select2({
        tags: true
    });
    var ss = $(".basice").select2({
        tags: true,
    });
    $('.tagging').select2({
        dropdownParent: $('#ModalRegistroSlide')
    });
    $('.basice').select2({
        dropdownParent: $('#ModalUpdateSlide')
    });
    

</script>

<div class="col-md-4">
    <div class="form-group">
        <label for="nl_excel">Nivel de Excel</label>
        <select class="form-control" name="nl_excel" id="nl_excel">
            <option value="0">Seleccion</option>
            <?php foreach($list_nivel_instruccion as $list){
                if($get_id_c[0]['nl_excel'] == $list['id_nivel_instruccion']){ ?>
                <option selected value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
            <?php }else{?>
            <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
            <?php } } ?>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="nivel_word">Nivel de Word</label>
        <select class="form-control" name="nl_word" id="nl_word">
            <option value="0">Seleccion</option>
            <?php foreach($list_nivel_instruccion as $list){
                if($get_id_c[0]['nl_word'] == $list['id_nivel_instruccion']){ ?>
                <option selected value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
            <?php }else{?>
            <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
            <?php } } ?>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="nivel_ppoint">Nivel de Power Point</label>
        <select class="form-control" name="nl_ppoint" id="nl_ppoint">
            <option value="0">Seleccion</option>
            <?php foreach($list_nivel_instruccion as $list){
                if($get_id_c[0]['nl_ppoint'] == $list['id_nivel_instruccion']){ ?>
                <option selected value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
            <?php }else{?>
            <option value="<?php echo $list['id_nivel_instruccion']; ?>"><?php echo $list['nom_nivel_instruccion'];?></option>
            <?php } } ?>
        </select>
    </div>
</div>

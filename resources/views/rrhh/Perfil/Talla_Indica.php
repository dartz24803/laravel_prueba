<div class="col-md-3">
    <div class="form-group">
        <label for="polo">Polo</label>
        <select class="form-control" name="polo" id="polo" >
            <option value="0">Seleccion</option>
            <?php foreach($list_accesorio_polo as $list){
                if($get_id_t[0]['polo'] == $list['id_talla']){ ?>
                <option selected value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option> 
            <?php }else{?>
            <option value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
            <?php } } ?>
        </select>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="camisa">Camisa</label>
        <select class="form-control" name="camisa" id="camisa" >
            <option value="0">Seleccion</option>
            <?php foreach($list_accesorio_camisa as $list){
                if($get_id_t[0]['camisa'] == $list['id_talla']){ ?>
                <option selected value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option> 
            <?php }else{?>
            <option value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
            <?php } } ?>
        </select>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="pantalon">Pantalón</label>
        <select class="form-control" name="pantalon" id="pantalon" >
            <option value="0">Seleccion</option>
            <?php foreach($list_accesorio_pantalon as $list){
                if($get_id_t[0]['pantalon'] == $list['id_talla']){ ?>
                <option selected value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option> 
            <?php }else{?>
            <option value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
            <?php } } ?>
        </select>
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="zapato">Zápato</label>
        <select class="form-control" name="zapato" id="zapato" >
            <option value="0">Seleccion</option>
            <?php foreach($list_accesorio_zapato as $list){
                if($get_id_t[0]['zapato'] == $list['id_talla']){ ?>
                <option selected value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option> 
            <?php }else{?>
            <option value="<?php echo $list['id_talla']; ?>"><?php echo $list['nom_talla'];?></option>
            <?php } } ?>
        </select>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="nacionalidad">Indique si se encuentra en gestación</label>
        <select class="form-control" id="id_respuesta" name="id_respuesta" onchange="Validag();">
        <option value="0" <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] == 0){ echo "selected";} ?>>Seleccione</option>
        <option value="1" <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] == 1){ echo "selected";} ?>>SÍ</option>
        <option value="2" <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] == 2){ echo "selected";} ?>>NO</option>
        </select>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="usuario_email">Fecha de inicio de gestación</label>
        <div class="d-sm-flex d-block">
            <div class="form-group mr-1">
                <select <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] != 1){echo "disabled";}?> class="form-control" id="dia_ges" name="dia_ges">
                <option value="0">Día</option>
                <?php foreach($list_dia as $list){
                if($get_id_gestacion[0]['dia_ges'] == $list['cod_dia']){ ?>
                <option selected value="<?php echo $list['cod_dia']; ?>"><?php echo $list['cod_dia'];?></option> 
                <?php }else{?>
                <option value="<?php echo $list['cod_dia']; ?>"><?php echo $list['cod_dia'];?></option>
                <?php } } ?>
                </select>
            </div>
            <div class="form-group mr-1">
                <select <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] != 1){echo "disabled";}?> class="form-control" id="mes_ges" name="mes_ges">
                <option value="0">Mes</option>
                <?php foreach($list_mes as $list){ 
                if($get_id_gestacion[0]['mes_ges'] == $list['cod_mes']){ ?>
                <option selected value="<?php echo $list['cod_mes'] ; ?>" ><?php echo $list['abr_mes'];?></option>
                <?php } else{?>
                <option value="<?php echo $list['cod_mes']; ?>"><?php echo $list['abr_mes'];?></option>
                <?php } } ?>
                </select>
            </div>
            <div class="form-group mr-1">
                <select <?php if(isset($get_id_gestacion['0']['id_respuesta']) && $get_id_gestacion[0]['id_respuesta'] != 1){echo "disabled";}?> class="form-control" id="anio_ges" name="anio_ges">
                <option value="0">Año</option>
                <?php foreach($list_anio as $list){
                if($get_id_gestacion[0]['anio_ges'] == $list['cod_anio']){ ?>
                <option selected value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                <?php } else{?>
                <option value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                <?php } } ?>
                </select>
            </div>
        </div>
    </div>
</div>
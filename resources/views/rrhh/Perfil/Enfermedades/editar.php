<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="nacionalidad">Indique si padece alguna enfermedad</label>
            <select class="form-control" id="id_respuestae" name="id_respuestae" onchange="ValidaE();">
            <option value="0">Seleccione</option>
            <option value="1" <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 1){ echo "selected";} ?>>SÍ</option>
            <option value="2" <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 2){ echo "selected";} ?>>NO</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="dni_hijo">Especifique la enfermedad</label>
            <input <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 2){ echo "disabled";} ?> type="text" class="form-control mb-4" id="nom_enfermedad" name="nom_enfermedad" value="<?php echo $get_id['0']['nom_enfermedad']; ?>">
        </div>
    </div>
    <div class="col-md-4">
        <label class="naci_familiar">Fecha de Diagnóstico</label>
        <div class="d-sm-flex d-block">
            <div class="form-group mr-2">
                <select <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 2){ echo "disabled";} ?> class="form-control" id="dia_diagnostico" name="dia_diagnostico">
                <option value="0">Día</option>
                <?php foreach($list_dia as $list){
                if($get_id[0]['dia_diagnostico'] == $list['cod_dia']){ ?>
                <option selected value="<?php echo $list['cod_dia'] ; ?>"><?php echo $list['cod_dia'];?></option>
                <?php } else { ?>
                <option value="<?php echo $list['cod_dia'] ; ?>"><?php echo $list['cod_dia'];?></option>
                <?php } }?>
                </select>
            </div>
            <div class="form-group mr-2">
                <select <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 2){ echo "disabled";} ?> class="form-control" id="mes_diagnostico" name="mes_diagnostico">
                    <option value="0">Mes</option>
                    <?php foreach($list_mes as $list){
                    if($get_id[0]['mes_diagnostico'] == $list['cod_mes']){ ?>
                    <option selected value="<?php echo $list['cod_mes'] ; ?>"><?php echo $list['abr_mes'];?></option>
                    <?php } else { ?>
                    <option value="<?php echo $list['cod_mes'] ; ?>"><?php echo $list['abr_mes'];?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="form-group mr-2">
                <select <?php if(isset($list_usuario['0']['enfermedades']) && $list_usuario[0]['enfermedades'] == 2){ echo "disabled";} ?> class="form-control" id="anio_diagnostico" name="anio_diagnostico">
                <option value="0">Año</option>
                <?php foreach($list_anio as $list){
                if($get_id[0]['anio_diagnostico'] == $list['cod_anio']){ ?>
                <option selected value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                <?php } else { ?>
                <option value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                <?php } }?>
                </select>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="id_enfermedad_usuario" name="id_enfermedad_usuario" value="<?php echo $get_id['0']['id_enfermedad_usuario']; ?>">
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nom_familiar">Empresa</label>
                <input type="text" class="form-control mb-4" id="empresaex" name="empresaex" value="<?php echo $get_id['0']['empresa']; ?>">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="nom_familiar">Cargo</label>
                <input type="text" class="form-control mb-4" id="cargoex" name="cargoex" value="<?php echo $get_id['0']['cargo']; ?>">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <label class="naci_familiar">Fecha de Inicio</label>
            <div class="d-sm-flex d-block">
                <div class="form-group mr-2">
                    <select class="form-control" id="dia_iniel" name="dia_iniel">
                    <option value="0">Día</option>
                    <?php foreach($list_dia as $list){
                        if($get_id[0]['dia_ini'] == $list['cod_dia']){ ?>
                        <option selected value="<?php echo $list['cod_dia'] ; ?>"><?php echo $list['cod_dia'];?></option>
                    <?php } else { ?>
                        <option value="<?php echo $list['cod_dia'] ; ?>"><?php echo $list['cod_dia'];?></option>
                    <?php } }?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control" id="mes_iniel" name="mes_iniel">
                    <option value="0">Mes</option>
                    <?php foreach($list_mes as $list){
                    if($get_id[0]['mes_ini'] == $list['cod_mes']){ ?>
                    <option selected value="<?php echo $list['cod_mes'] ; ?>"><?php echo $list['abr_mes'];?></option>
                    <?php } else { ?>
                    <option value="<?php echo $list['cod_mes'] ; ?>"><?php echo $list['abr_mes'];?></option>
                    <?php } }?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control" id="anio_iniel" name="anio_iniel">
                    <option value="0">Año</option>
                    <?php foreach($list_anio as $list){
                    if($get_id[0]['anio_ini'] == $list['cod_anio']){ ?>
                    <option selected value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                    <?php } else { ?>
                    <option value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                    <?php } }?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <label class="naci_familiar">Fecha de Fin</label>
            <div class="d-sm-flex d-block">
                <div class="form-group mr-2">
                    <select class="form-control" id="dia_finel" name="dia_finel">
                    <option value="0">Día</option>
                    <?php foreach($list_dia as $list){
                    if($get_id[0]['dia_fin'] == $list['cod_dia']){ ?>
                    <option selected value="<?php echo $list['cod_dia'] ; ?>"><?php echo $list['cod_dia'];?></option>
                    <?php } else { ?>
                    <option value="<?php echo $list['cod_dia'] ; ?>"><?php echo $list['cod_dia'];?></option>
                    <?php } }?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control" id="mes_finel" name="mes_finel">
                        <option value="0">Mes</option>
                        <?php foreach($list_mes as $list){
                        if($get_id[0]['mes_fin'] == $list['cod_mes']){ ?>
                        <option selected value="<?php echo $list['cod_mes'] ; ?>"><?php echo $list['abr_mes'];?></option>
                        <?php } else { ?>
                        <option value="<?php echo $list['cod_mes'] ; ?>"><?php echo $list['abr_mes'];?></option>
                        <?php } }?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control" id="anio_finel" name="anio_finel">
                    <option value="0">Año</option>
                    <?php foreach($list_anio as $list){
                    if($get_id[0]['anio_fin'] == $list['cod_anio']){ ?>
                    <option selected value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                    <?php } else { ?>
                    <option value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                    <?php } }?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="fami_paren">Motivo de Salida</label>
                <input type="text" class="form-control mb-4" id="motivo_salida" name="motivo_salida" value="<?php echo $get_id['0']['motivo_salida']; ?>">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="familiar_celular">Importe de remuneración</label>
                <input type="text" class="form-control mb-4" id="remuneracion" name="remuneracion" value="<?php echo $get_id['0']['remuneracion']; ?>">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="familiar_celular2">Nombre de referencia laboral</label>
                <input type="text" class="form-control mb-4" id="nom_referencia_labores" name="nom_referencia_labores" value="<?php echo $get_id['0']['nom_referencia_labores']; ?>">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="familiar_celular">Número de Contacto de la empresa</label>
                <input type="number" class="form-control mb-4" id="num_contacto" name="num_contacto" value="<?php echo $get_id['0']['num_contacto']; ?>">
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="id_experiencia_laboral" name="id_experiencia_laboral" value="<?php echo $get_id['0']['id_experiencia_laboral']; ?>">
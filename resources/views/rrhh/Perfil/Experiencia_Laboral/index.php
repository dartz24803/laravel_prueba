<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nom_familiar">Empresa</label>
                <input type="text" class="form-control mb-4" id="empresaex" name="empresaex">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="nom_familiar">Cargo</label>
                <input type="text" class="form-control mb-4" id="cargoex" name="cargoex">
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
                    <?php foreach($list_dia as $list){ ?>
                        <option value="<?php echo $list['cod_dia'] ; ?>">
                        <?php echo $list['cod_dia'];?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control" id="mes_iniel" name="mes_iniel">
                        <option value="0">Mes</option>
                        <?php foreach($list_mes as $list){ ?>
                        <option value="<?php echo $list['cod_mes'] ; ?>">
                        <?php echo $list['abr_mes'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control" id="anio_iniel" name="anio_iniel">
                    <option value="0">Año</option>
                    <?php foreach($list_anio as $list){ ?>
                    <option value="<?php echo $list['cod_anio'] ; ?>">
                    <?php echo $list['cod_anio'];?></option>
                    <?php } ?>
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
                    <?php foreach($list_dia as $list){ ?>
                        <option value="<?php echo $list['cod_dia'] ; ?>">
                        <?php echo $list['cod_dia'];?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control" id="mes_finel" name="mes_finel">
                        <option value="0">Mes</option>
                        <?php foreach($list_mes as $list){ ?>
                        <option value="<?php echo $list['cod_mes'] ; ?>">
                        <?php echo $list['abr_mes'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control" id="anio_finel" name="anio_finel">
                    <option value="0">Año</option>
                    <?php foreach($list_anio as $list){ ?>
                    <option value="<?php echo $list['cod_anio'] ; ?>">
                    <?php echo $list['cod_anio'];?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="fami_paren">Motivo de Salida</label>
                <input type="text" class="form-control mb-4" id="motivo_salida" name="motivo_salida">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="familiar_celular">Importe de remuneración</label>
                <input type="text" class="form-control mb-4" id="remuneracion" name="remuneracion">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="familiar_celular2">Nombre de referencia laboral</label>
                <input type="text" class="form-control mb-4" id="nom_referencia_labores" name="nom_referencia_labores">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="familiar_celular">Número de Contacto de la empresa</label>
                <input type="number" class="form-control mb-4" id="num_contacto" name="num_contacto">
            </div>
        </div>
    </div>
</div>
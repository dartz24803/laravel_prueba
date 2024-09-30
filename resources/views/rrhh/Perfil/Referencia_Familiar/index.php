<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="nom_familiar">Nombre de Familiar</label>
                <input type="text" class="form-control mb-4 limpiaref" maxlength = "150" id="nom_familiar" name="nom_familiar" value="">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="fami_paren">Parentesco</label>
                <select class="form-control limpiarefselect" id="id_parentesco" name="id_parentesco">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_parentesco as $list){ ?>
                    <option value="<?php echo $list['id_parentesco'] ; ?>"><?php echo $list['nom_parentesco'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <label class="naci_familiar">Fecha de Nacimiento</label>
            <div class="d-sm-flex d-block">
                <div class="form-group mr-2">
                    <select class="form-control limpiarefselect" id="dia_nacf" name="dia_nacf">
                    <option value="0">Día</option>
                    <?php foreach($list_dia as $list){ ?>
                    <option value="<?php echo $list['cod_dia'] ; ?>"><?php echo $list['cod_dia'];?></option>                        
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control limpiarefselect" id="mes_nacf" name="mes_nacf">
                    <option value="0">Mes</option>
                    <?php foreach($list_mes as $list){ ?>
                    <option value="<?php echo $list['cod_mes'] ; ?>"><?php echo $list['abr_mes'];?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control limpiarefselect" id="anio_nacf" name="anio_nacf">
                    <option value="0">Año</option>
                    <?php foreach($list_anio as $list){ ?>
                    <option value="<?php echo $list['cod_anio'] ; ?>"><?php echo $list['cod_anio'];?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="familiar_celular">Celular</label>
                <input type="number" class="form-control mb-4 limpiaref" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "9"  id="celular1" name="celular1" value="">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="familiar_celular2">Celular 2</label>
                <input type="number" class="form-control mb-4 limpiaref" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "9"  id="celular2" name="celular2" value="">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="familiar_telefono2">Teléfono Fijo</label>
                <input type="number" class="form-control mb-4 limpiaref" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength = "15"  id="fijo" name="fijo" value="">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="nacionalidad">Respuesta</label>
                <select class="form-control" id="id_respuestah" name="id_respuestah" onchange="ValidaH();">
                <option value="0">Seleccione</option>
                <option value="1" <?php if(isset($list_usuario['0']['hijos']) && $list_usuario[0]['hijos'] == 1){ echo "selected";} ?>>SÍ</option>
                <option value="2" <?php if(isset($list_usuario['0']['hijos']) && $list_usuario[0]['hijos'] == 2){ echo "selected";} ?>>NO</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="nom_familiar">Nombre de Hijo</label>
                <input type="text" class="form-control mb-4 limpiarhijos" maxlength = "150"  id="nom_hijo" name="nom_hijo" placeholder="" value="">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="fami_paren">Genero</label>
                <select class="form-control limpiarefselecthijos" id="id_generoh" name="id_generoh">
                    <option value="0">Seleccione</option>
                    <?php 
                    foreach($list_genero as $list){ ?>
                    <option value="<?php echo $list['id_genero'] ; ?>">
                    <?php echo $list['nom_genero'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <label class="naci_familiar">Fecha de Nacimiento</label>
            <div class="d-sm-flex d-block">
                <div class="form-group mr-2">
                    <select class="form-control limpiarefselecthijos" id="dia_nachj" name="dia_nachj">
                    <option value="0">Día</option>
                    <?php foreach($list_dia as $list){ ?>
                        <option value="<?php echo $list['cod_dia'] ; ?>">
                        <?php echo $list['cod_dia'];?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control limpiarefselecthijos" id="mes_nachj" name="mes_nachj">
                        <option value="0">Mes</option>
                        <?php foreach($list_mes as $list){ ?>
                        <option value="<?php echo $list['cod_mes'] ; ?>">
                        <?php echo $list['abr_mes'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <select class="form-control limpiarefselecthijos" id="anio_nachj" name="anio_nachj">
                    <option value="0">Año</option>
                    <?php foreach($list_anio as $list){ ?>
                    <option value="<?php echo $list['cod_anio'] ; ?>">
                    <?php echo $list['cod_anio'];?></option>
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
                <label for="familiar_celular">DNI</label>
                        <input type="number" class="form-control mb-4 limpiarhijos" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "8"  id="num_dochj" name="num_dochj" placeholder="" value="">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="familiar_celular2">Biológico/No Biológico</label>
                <select class="form-control limpiarefselecthijos" id="id_biologico" name="id_biologico">
                <option value="0">Seleccione</option>
                <option value="1">SÍ</option>
                <option value="2">NO</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="archivoInput">Adjuntar DNI</label>
                <input type="file" class="form-control-file" id="documento" name="documento">
                    
            </div>
        </div>
    </div>
</div>

<div class="form">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="usuario_apater">Apellido Paterno</label>
                <input type="text" class="form-control mb-4" maxlength = "30" id="usuario_apater" name="usuario_apater" value="<?php echo $get_id['0']['usuario_apater'];?>" <?php echo $disabled ?>>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="usuario_amater">Apellido Materno</label>
                <input type="text" class="form-control mb-4"maxlength = "30" id="usuario_amater" name="usuario_amater" value="<?php echo $get_id['0']['usuario_amater'];?>" <?php echo $disabled ?>>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="usuario_nombres">Nombres</label>
                <input type="text" class="form-control mb-4" maxlength = "30" id="usuario_nombres" name="usuario_nombres" value="<?php echo $get_id['0']['usuario_nombres'];?>" <?php echo $disabled ?>>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="id_nacionalidad">Nacionalidad</label>
                <select class="form-control" name="id_nacionalidad" id="id_nacionalidad" <?php echo $disabled ?>>
                <option value="0"  <?php if (!(strcmp(0, $get_id[0]['id_nacionalidad']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                <?php foreach($list_nacionalidad_perfil as $list){ ?>
                <option value="<?php echo $list['id_nacionalidad']; ?>" <?php if (!(strcmp($list['id_nacionalidad'], $get_id[0]['id_nacionalidad']))) {echo "selected=\"selected\"";} ?> >
                <?php echo $list['nom_nacionalidad'];?></option>
                <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="genero">Genero</label>
                <select class="form-control" name="id_genero" id="id_genero" <?php echo $disabled ?>>
                <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_genero']))) {echo "selected=\"selected\"";} ?> >Seleccione</option>
                <?php foreach($list_genero as $list){ ?>
                <option value="<?php echo $list['id_genero'] ; ?>" <?php if (!(strcmp($list['id_genero'], $get_id[0]['id_genero']))) {echo "selected=\"selected\"";} ?> >
                <?php echo $list['nom_genero'];?></option>
                <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="fullName">Tipo de documento</label>
                <select class="form-control" name="id_tipo_documento" id="id_tipo_documento" <?php echo $disabled ?>>
                <option value="0"  <?php if (!(strcmp(0, $get_id[0]['id_tipo_documento']))) {echo "selected=\"selected\"";} ?> >Seleccione</option>
                <?php foreach($list_tipo_documento as $list){ ?>
                <option value="<?php echo $list['id_tipo_documento'] ; ?>" <?php if (!(strcmp($list['id_tipo_documento'], $get_id[0]['id_tipo_documento']))) {echo "selected=\"selected\"";} ?> >
                <?php echo $list['cod_tipo_documento'];?></option>
                <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="num_doc">Número de documento</label>
                <input type="number" class="form-control mb-4" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "8" id="num_doc" name="num_doc" value="<?php echo $get_id[0]['num_doc']; ?>" <?php echo $disabled ?>>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label>Fecha Emisión:</label>
                <input type="date" class="form-control" id="fec_emision" name="fec_emision" value="<?php echo $get_id[0]['fec_emision_doc']; ?>" placeholder="Ingresar Fecha de Ingreso" <?php echo $disabled ?>>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label>Fecha Vencimiento:</label>
                <input type="date" class="form-control" id="fec_venci" name="fec_venci" value="<?php echo $get_id[0]['fec_vencimiento_doc']; ?>" placeholder="Ingresar Fecha de Ingreso" <?php echo $disabled ?>>
            </div>
        </div>


        <div class="col-sm-4">
            <label class="dob-input">Fecha de Nacimiento</label>
            <div class="d-sm-flex d-block">
                <div class="form-group mr-1">
                    <select class="form-control" id="dia_nac" name="dia_nac" <?php echo $disabled ?>>
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['dia_nac']))) {echo "selected=\"selected\"";} ?> >Día</option>
                    <?php foreach($list_dia as $list){ ?>
                    <option value="<?php echo $list['cod_dia'] ; ?>" <?php if (!(strcmp($list['cod_dia'], $get_id[0]['dia_nac']))) {echo "selected=\"selected\"";} ?> >
                    <?php echo $list['cod_dia'];?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-1">
                    <select class="form-control" id="mes_nac" name="mes_nac" <?php echo $disabled ?>>
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['mes_nac']))) {echo "selected=\"selected\"";} ?> >Mes</option>
                    <?php foreach($list_mes as $list){ ?>
                    <option value="<?php echo $list['cod_mes'] ; ?>" <?php if (!(strcmp($list['cod_mes'], $get_id[0]['mes_nac']))) {echo "selected=\"selected\"";} ?> >
                    <?php echo $list['abr_mes'];?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group mr-1">
                    <select class="form-control" id="anio_nac" name="anio_nac" <?php echo $disabled ?>>
                    <option value="0" <?php if (!(strcmp(0, $get_id[0]['anio_nac']))) {echo "selected=\"selected\"";} ?> >Año</option>
                    <?php foreach($list_anio as $list){ ?>
                    <option value="<?php echo $list['cod_anio'] ; ?>" <?php if (!(strcmp($list['cod_anio'], $get_id[0]['anio_nac']))) {echo "selected=\"selected\"";} ?> >
                    <?php echo $list['cod_anio'];?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label for="usuario_email">Edad</label>
                <input type="text" class="form-control" readonly id="cedad" name="cedad" >

            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="estado_civil">Estado Civil</label>
                <select class="form-control" id="id_estado_civil" name="id_estado_civil" <?php echo $disabled ?>>
                <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_estado_civil']))) {echo "selected=\"selected\"";} ?> >Seleccione</option>
                <?php foreach($list_estado_civil as $list){ ?>
                <option value="<?php echo $list['id_estado_civil'] ; ?>" <?php if (!(strcmp($list['id_estado_civil'], $get_id[0]['id_estado_civil']))) {echo "selected=\"selected\"";} ?> >
                <?php echo $list['nom_estado_civil'];?></option>
                <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="usuario_email">Correo Electrónico</label>
                <input type="text" class="form-control mb-4" maxlength = "100" id="usuario_email" name="usuario_email" value="<?php echo $get_id[0]['usuario_email']; ?>" <?php echo $disabled ?>>
            </div>
        </div>


        <div class="col-sm-6">
            <div class="form-group">
                <label for="num_celp">Número celular</label>
                <input type="number" class="form-control mb-4" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "9"  id="num_celp" name="num_celp" value="<?php echo $get_id[0]['num_celp']; ?>" <?php echo $disabled ?>>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="num_fijop">Teléfono fijo</label>
                <input type="number" class="form-control mb-4" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "15" id="num_fijop" name="num_fijop" value="<?php echo $get_id[0]['num_fijop']; ?>" <?php echo $disabled ?>>
            </div>
        </div>
    </div>
</div>

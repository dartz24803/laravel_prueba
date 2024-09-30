<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="id_departamento">Departamento</label>
                <select class="form-control" name="id_departamento" id="id_departamento" onchange="provincia()">
                    <option value="0">Seleccion</option>
                    <?php foreach ($list_departamento as $list) {
                        if ($get_id_d[0]['id_departamento'] == $list->id_departamento) { ?>
                            <option selected value="<?php echo $list->id_departamento; ?>"><?php echo $list->nombre_departamento; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $list->id_departamento; ?>"><?php echo $list->nombre_departamento; ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="id_provincia">Provincia</label>
                <div id="mprovincia">
                    <select class="form-control" name="id_provincia" id="id_provincia" onchange="distrito()">
                        <option value="0" selected>Seleccionar</option>
                        <?php
                        if ($get_id_d[0]['id_provincia'] != "" && isset($get_id_d[0]['id_provincia'])) {
                            foreach ($list_provincia as $list) {
                                if ($get_id_d[0]['id_provincia'] == $list->id_provincia) { ?>
                                    <option selected value="<?php echo $list->id_provincia; ?>"><?php echo $list->nombre_provincia; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $list->id_provincia; ?>"><?php echo $list->nombre_provincia; ?></option>
                        <?php }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="id_distrito">Distrito</label>
                <div id="mdistrito">
                    <select class="form-control" name="id_distrito" id="id_distrito">
                        <option value="0" selected>Seleccionar</option>
                        <?php
                        if ($get_id_d[0]['id_distrito'] != "" && isset($get_id_d[0]['id_distrito'])) {
                            foreach ($list_distrito as $list) {
                                if ($get_id_d[0]['id_distrito'] == $list->id_distrito) { ?>
                                    <option selected value="<?php echo $list->id_distrito; ?>"><?php echo $list->nombre_distrito; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $list->id_distrito; ?>"><?php echo $list->nombre_distrito; ?></option>
                        <?php }
                            }
                        } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="id_tipo_via">Tipo de vía</label>
                <select class="form-control" name="id_tipo_via" id="id_tipo_via">
                    <option value="0" selected>Seleccionar</option>
                    <?php foreach ($list_dtipo_via as $list) {
                        if ($get_id_d[0]['id_tipo_via'] == $list['id_tipo_via']) { ?>
                            <option selected value="<?php echo $list['id_tipo_via']; ?>"><?php echo $list['nom_tipo_via']; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $list['id_tipo_via']; ?>"><?php echo $list['nom_tipo_via']; ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="nom_via">Nombre de vía</label>
                <input type="text" class="form-control mb-4" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="100" id="nom_via" name="nom_via" value="<?php if (isset($get_id_d['0']['nom_via'])) {
                                                                            echo $get_id_d['0']['nom_via'];
                                                                        } ?>">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="num_via">Número de vía</label>
                <input type="text" class="form-control mb-4" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="5" id="num_via" name="num_via" value="<?php if (isset($get_id_d['0']['num_via'])) {
                                                                            echo $get_id_d['0']['num_via'];
                                                                        } ?>">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="num_via">KM</label>
                <input type="text" class="form-control mb-4" maxlength="5" id="kilometro" name="kilometro" value="<?php if (isset($get_id_d['0']['kilometro'])) {
                                                                                                                        echo $get_id_d['0']['kilometro'];
                                                                                                                    } ?>">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="num_via">MZ</label>
                <input type="text" class="form-control mb-4" maxlength="5" id="manzana" name="manzana" value="<?php if (isset($get_id_d['0']['manzana'])) {
                                                                                                                    echo $get_id_d['0']['manzana'];
                                                                                                                } ?>">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="num_vivo_en">Interior</label>
                <input type="text" class="form-control mb-4" maxlength="5" id="interior" name="interior" value="<?php if (isset($get_id_d['0']['interior'])) {
                                                                                                                    echo $get_id_d['0']['interior'];
                                                                                                                } ?>">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="num_vivo_en">N° Departamento</label>
                <input type="text" class="form-control mb-4" maxlength="5" id="departamento" name="departamento" value="<?php if (isset($get_id_d['0']['departamento'])) {
                                                                                                                            echo $get_id_d['0']['departamento'];
                                                                                                                        } ?>">
            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                <label for="num_vivo_en">Lote</label>
                <input type="text" class="form-control mb-4" maxlength="5" id="lote" name="lote" value="<?php if (isset($get_id_d['0']['lote'])) {
                                                                                                            echo $get_id_d['0']['lote'];
                                                                                                        } ?>">
            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                <label for="num_vivo_en">Piso</label>
                <input type="text" class="form-control mb-4" maxlength="2" id="piso" name="piso" value="<?php if (isset($get_id_d['0']['piso'])) {
                                                                                                            echo $get_id_d['0']['piso'];
                                                                                                        } ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="id_vivo_en">Tipo de Zona</label>
                <select class="form-control" name="id_zona" id="id_zona">
                    <option value="0" selected>Seleccionar</option>
                    <?php foreach ($list_zona as $list) {
                        if ($get_id_d[0]['id_zona'] == $list['id_zona']) { ?>
                            <option selected value="<?php echo $list['id_zona']; ?>"><?php echo $list['nom_zona']; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $list['id_zona']; ?>"><?php echo $list['nom_zona']; ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="num_vivo_en">Nombre Zona</label>
                <input type="text" class="form-control mb-4" id="nom_zona" maxlength="150" name="nom_zona" value="<?php if (isset($get_id_d['0']['nom_zona'])) {
                                                                                                                        echo $get_id_d['0']['nom_zona'];
                                                                                                                    } ?>">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="tipovivienda">Tipo de vivienda</label>
                <select class="form-control" name="id_tipo_vivienda" id="id_tipo_vivienda">
                    <option value="0" selected>Seleccionar</option>
                    <?php foreach ($list_dtipo_vivienda as $list) {
                        if ($get_id_d[0]['id_tipo_vivienda'] == $list['id_tipo_vivienda']) { ?>
                            <option selected value="<?php echo $list['id_tipo_vivienda']; ?>"><?php echo $list['nom_tipo_vivienda']; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $list['id_tipo_vivienda']; ?>"><?php echo $list['nom_tipo_vivienda']; ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>

        <div class="col-md-8">
            <div class="form-group">
                <label for="referencia">Referencia Domicilio</label>
                <input type="text" class="form-control mb-4" id="referenciaa" maxlength="150" name="referenciaa" value="<?php if (isset($get_id_d['0']['referencia'])) {
                                                                                                                            echo $get_id_d['0']['referencia'];
                                                                                                                        } ?>">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="nom_contacto_emer">Nombre de Contacto</label>
                <input type="text" class="form-control mb-4 limpiarContactoE" maxlength = "50"  id="nom_contacto" name="nom_contacto" value="<?php echo $get_id['0']['nom_contacto']; ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="fami_paren">Parentesco</label>
                <select class="form-control limpiarefselectContactoE" id="id_parentescoce" name="id_parentescoce">
                    <option value="0">Seleccione</option>
                    <?php 
                    foreach($list_parentesco as $list){
                    if($get_id[0]['id_parentesco'] == $list['id_parentesco']){ ?>
                    <option selected value="<?php echo $list['id_parentesco'] ; ?>"><?php echo $list['nom_parentesco'];?></option>
                    <?php } else { ?>
                    <option value="<?php echo $list['id_parentesco'] ; ?>"><?php echo $list['nom_parentesco'];?></option>
                    <?php } } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="familiar_celular">Celular</label>
                <input type="number" class="form-control mb-4 limpiarContactoE" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "9"  id="celular1ce" name="celular1ce" value="<?php echo $get_id['0']['celular1']; ?>">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="familiar_celular2">Celular 2</label>
                <input type="number" class="form-control mb-4 limpiarContactoE" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "9"  id="celular2ce" name="celular2ce" value="<?php echo $get_id['0']['celular2']; ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="familiar_telefono2">Teléfono Fijo</label>
                <input type="number" min="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength = "15"  class="form-control mb-4 limpiarContactoE" id="fijoce" name="fijoce" value="<?php echo $get_id['0']['fijo']; ?>">
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="id_contacto_emergencia" name="id_contacto_emergencia" value="<?php echo $get_id['0']['id_contacto_emergencia']; ?>">
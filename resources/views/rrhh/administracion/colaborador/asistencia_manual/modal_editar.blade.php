<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Asistencia Manual:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Colaborador: </label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control basice" id="id_usuarioe" name="id_usuarioe">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_usuario as $list) { ?>
                        <option value="<?php echo $list['id_usuario']; ?>"
                            <?php if ($list['id_usuario'] == $get_id[0]['id_usuario']) {
                                echo "selected";
                            } ?>>
                            <?php echo $list['nom_usuario']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3">
                <label class="control-label text-bold" for="entradae">Entrada: </label>
                <input type="checkbox" class="checkboxe" id="entradae" name="entradae" value="1" <?php if ($get_id[0]['entrada'] == 1) {
                                                                                                        echo "checked";
                                                                                                    } ?>>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label text-bold" for="salidae">Salida: </label>
                <input type="checkbox" class="checkboxe" id="salidae" name="salidae" value="1" <?php if ($get_id[0]['salida'] == 1) {
                                                                                                    echo "checked";
                                                                                                } ?>>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label text-bold" for="inicio_refrigerioe">Inicio refrigerio: </label>
                <input type="checkbox" class="checkboxe" id="inicio_refrigerioe" name="inicio_refrigerioe" value="1" <?php if ($get_id[0]['inicio_refrigerio'] == 1) {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label text-bold" for="fin_refrigerioe">Fin refrigerio: </label>
                <input type="checkbox" class="checkboxe" id="fin_refrigerioe" name="fin_refrigerioe" value="1" <?php if ($get_id[0]['fin_refrigerio'] == 1) {
                                                                                                                    echo "checked";
                                                                                                                } ?>>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id" id="id" value="<?php echo $get_id[0]['id']; ?>">
        <button class="btn btn-primary mt-3" onclick="Update_Asistencia_Manual();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    var ss = $(".basice").select2({
        tags: true,
    });

    $('.basice').select2({
        dropdownParent: $('#ModalUpdate')
    });
</script>
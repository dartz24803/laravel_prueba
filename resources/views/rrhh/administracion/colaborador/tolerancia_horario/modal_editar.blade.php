<form id="formulario_toleranciae" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Tolerancia: </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-sm-4">
                <select class="form-control" name="tipoe" id="tipoe">
                    <option value="0">Seleccionar</option>
                    <option value="1" <?php if ($get_id[0]['tipo'] == 1) {
                                            echo "selected";
                                        } ?>>Minutos</option>
                    <option value="2" <?php if ($get_id[0]['tipo'] == 2) {
                                            echo "selected";
                                        } ?>>Horas</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tolerancia:</label>
            </div>
            <div class="form-group col-sm-4">
                <input type="text" name="toleranciae" id="toleranciae" value="<?php echo $get_id[0]['tolerancia'] ?>" onkeypress="return soloNumeros(event)" class="form-control">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_tolerancia" type="hidden" class="form-control" id="id_tolerancia" value="<?php echo $get_id[0]['id_tolerancia']; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Edit_ToleranciaHorario();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
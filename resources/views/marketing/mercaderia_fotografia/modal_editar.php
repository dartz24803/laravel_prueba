<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Requerimiento: <b><?php echo $get_id[0]['codigo']; ?></b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Cantidad:</label>
            </div>
            <div class="form-group col-sm-4">
                <input type="text" class="form-control" id="cantidad" name="cantidad" value="<?php echo $get_id[0]['cantidad'] ?>" onkeypress="return soloNumeros(event)">
            </div>
            <div class="form-group col-md-12">
            </div>
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Observación:</label>
            </div>
            <div class="form-group col-sm-10">
                <textarea class="form-control" name="observacion" id="observacion" cols="10" rows="3"><?php echo $get_id[0]['observacion'] ?></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_mercaderia" type="hidden" class="form-control" id="id_mercaderia" value="<?php echo $get_id[0]['id_mercaderia']; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Update_Mercaderia_Fotografia();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
  


<div class="modal-header">
    <h5 class="modal-title">Ver reproceso:</h5> 
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div> 

<div class="modal-body" style="max-height:450px; overflow:auto;">
    <div class="col-md-12 row">
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Fecha documento: </label>
        </div>
        <div class="form-group col-md-4">
            <input type="date" class="form-control" value="<?php echo $get_id[0]['fecha_documento']; ?>" disabled>
        </div>

        <div class="form-group col-md-2">
            <label class="control-label text-bold">Documento: </label>
        </div>
        <div class="form-group col-md-4">
            <input type="text" class="form-control" placeholder="Documento" value="<?php echo $get_id[0]['documento']; ?>" disabled>
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Usuario: </label>
        </div>
        <div class="form-group col-md-4">
            <select class="form-control" disabled>
                <option value="0">Seleccione</option>
                <?php foreach($list_usuario as $list){ ?> 
                    <option value="<?php echo $list['id']; ?>"
                    <?php if($list['id']==$get_id[0]['usuario']){ echo "selected"; } ?>>
                        <?php echo $list['nombre']; ?>
                    </option>
                <?php } ?> 
            </select>
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Descripción: </label>
        </div>
        <div class="form-group col-md-10">
            <input type="text" class="form-control" placeholder="Descripción" value="<?php echo $get_id[0]['descripcion']; ?>" disabled>
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Cantidad: </label>
        </div>
        <div class="form-group col-md-4">
            <input type="text" class="form-control" placeholder="Cantidad" onkeypress="return soloNumeros(event);" value="<?php echo $get_id[0]['cantidad']; ?>" disabled>
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Proveedor: </label>
        </div>
        <div class="form-group col-md-10">
            <input type="text" class="form-control" placeholder="Proveedor" value="<?php echo $get_id[0]['proveedor']; ?>" disabled>
        </div>  
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-2">
            <label class="control-label text-bold">Status: </label>
        </div>
        <div class="form-group col-md-4">
            <select class="form-control" disabled>
                <option value="0">Seleccione</option>
                <option value="1" <?php if($get_id[0]['estado_r']==1){ echo "selected"; } ?>>PENDIENTE</option>
                <option value="2" <?php if($get_id[0]['estado_r']==2){ echo "selected"; } ?>>EN PROCESO</option>
                <option value="3" <?php if($get_id[0]['estado_r']==3){ echo "selected"; } ?>>REPORTADO</option>
            </select>
        </div>  
    </div>
</div>

<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
</div>
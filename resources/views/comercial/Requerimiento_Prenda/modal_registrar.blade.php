<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Requerimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row mb-2">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Año: </label>
            </div>  
            <div class="form-group col-md-3">
                <select class="form-control" id="anio" name="anio">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ ?>
                        <option value="<?php echo $list['cod_anio']; ?>" <?php if($list['cod_anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['cod_anio'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Mes: </label>
            </div>            
            <div class="form-group col-sm-2">
                <select class="form-control" id="mes" name="mes">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_mes as $list){ ?>
                        <option value="<?php echo $list['cod_mes']; ?>" <?php if($list['id_mes']==date('m')){ echo "selected"; } ?>><?php echo $list['nom_mes'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Adjuntar Documento: </label>
            </div>            
            <div class="form-group col-sm-4">
                <input type="file" class="form-control-file" id="drequerimiento" name="drequerimiento">
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Insert_Requerimiento_Prenda();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
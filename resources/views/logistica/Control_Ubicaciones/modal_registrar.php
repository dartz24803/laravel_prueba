<form id="formulario_cubicacion" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Control Ubicación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row mb-2">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Nicho: </label>
            </div>  
            <div class="form-group col-md-10">
                <select class="form-control multivalue" name="id_nicho[]" id="id_nicho" multiple="multiple">
                    
                    <?php foreach($list_nicho as $list){ ?>
                        <option value="<?php echo $list['id_nicho']; ?>"><?php echo $list['nom_percha'].$list['numero'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Estilo: </label>
            </div>            
            <div class="form-group col-sm-10">
                <select class="form-control basic" id="estilo" name="estilo">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estilo as $list){ ?>
                        <option value="<?php echo $list['art_estiloprd']; ?>"><?php echo $list['art_estiloprd'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Insert_Control_Ubicacion();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
<script>
    var ss = $(".basic").select2({
        tags: true
    });

    $('.basic').select2({
        dropdownParent: $('#ModalRegistro')
    });
    var ss = $(".multivalue").select2({
        tags: true
    });

    $('.multivalue').select2({
        dropdownParent: $('#ModalRegistro')
    });
</script>
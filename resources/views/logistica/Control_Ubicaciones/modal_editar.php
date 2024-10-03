<form id="formulario_cubicacione" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Control Ubicación:  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Nicho: </label>
            </div>  
            <div class="form-group col-md-10">
                <select class="form-control multivaluee" name="id_nichoe[]" id="id_nichoe" multiple="multiple">
                    <?php $base_array = explode(",",$get_id[0]['id_nicho']);
                        foreach($list_nicho as $list){ ?>
                        <option value="<?php echo $list['id_nicho']; ?>" <?php if(in_array($list['id_nicho'],$base_array)){ echo "selected=\"selected\""; } ?>>
                            <?php echo $list['nom_percha'].$list['numero']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Estilo: </label>
            </div>            
            <div class="form-group col-sm-10">
                <select class="form-control basice" id="estiloe" name="estiloe">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estilo as $list){ ?>
                        <option value="<?php echo $list['art_estiloprd']; ?>" <?php if($get_id[0]['estilo']==$list['art_estiloprd']){echo "selected";}?>><?php echo $list['art_estiloprd'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_control_ubicacion" type="hidden" class="form-control" id="id_control_ubicacion" value="<?php echo $get_id[0]['id_control_ubicacion']; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Update_Control_Ubicacion();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
<script>
    var ss = $(".basice").select2({
        tags: true
    });

    $('.basice').select2({
        dropdownParent: $('#ModalUpdate')
    });
    var ss = $(".multivaluee").select2({
        tags: true
    });

    $('.multivaluee').select2({
        dropdownParent: $('#ModalUpdate')
    });
</script>


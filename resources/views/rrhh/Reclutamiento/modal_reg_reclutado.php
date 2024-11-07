<?php $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
$id_usuario=$_SESSION['usuario'][0]['id_usuario'];?>
<form id="form_reclutamiento_reclutado"  method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Reclutado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">    
            <input  type="hidden" required class="form-control" id="nivel" name="nivel" value="<?php echo $id_nivel ?>">
            <div class="form-group col-md-2">
                <label>Colaborador:</label>
            </div>
            <div class="form-group col-md-10">
                <select name="id_colaborador" id="id_colaborador" class="form-control basic">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_colaborador as $list){?>
                        <option value="<?php echo $list['id_usuario'] ?>"><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <input type="hidden" name="id_reclutamiento2" id="id_reclutamiento2" value="<?php echo $id_reclutamiento ?>">
            <button class="btn btn-primary mt-3" type="button" onclick="Insert_Reclutamiento_Reclutado('<?php echo $id_reclutamiento ?>');">Guardar</button>
            <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
        </div>
    </div>
</form> 

<script>
    var ss = $(".basic").select2({
        tags: true
    });

    $('.basic').select2({
        dropdownParent: $('#ModalUpdate')
    });

</script>

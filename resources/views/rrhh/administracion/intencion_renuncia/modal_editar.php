<style>
    .flatpickr-current-month .numInputWrapper {
        width: 7ch;
        width: 7ch\0;
        display: inline-block;
    }
</style>

<form id="formulario_intencione" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Intención de Renuncia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        
        <div class="col-md-12 row">
            <input type="hidden" id="id_nivele" name="id_nivele" value="<?php echo $_SESSION['usuario'][0]['id_nivel'] ?>">
            <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==2){?>
                <div class="form-group col-md-12">
                    <label class="col-sm-12 control-label text-bold">Colaborador: </label>
                    <div class="col">
                        <select name="id_colaboradore" id="id_colaboradore" class="form-control basic">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_colaborador as $list){?>
                                <option value="<?php echo $list['id_usuario'] ?>" <?php if($get_id[0]['id_colaborador']==$list['id_usuario']){echo "selected";}?>><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div> 
            <?php }else{?> 
                <input type="text" class="new-control-input" id="id_colaboradore" name="id_colaboradore" value="<?php echo $_SESSION['usuario'][0]['id_usuario']; ?>">    
            <?php }?>
            <div class="form-group col-md-12">
                <label class="col-sm-12 control-label text-bold">Coméntanos cuál(es) son los motivos de tu intención de  renuncia: </label>
                <div class="col">
                    <select name="id_motivoe" id="id_motivoe" class="form-control basic">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_motivor as $list){?>
                            <option value="<?php echo $list['id_motivo'] ?>" <?php if($get_id[0]['id_motivo']==$list['id_motivo']){echo "selected";}?>><?php echo $list['nom_motivo'] ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-12">
                <label class="col-sm-12 control-label text-bold">Detállanos sobre tus motivos: </label>
                <div class="col-md">
                    <textarea class="form-control" name="detallee" id="detallee" cols="10" rows="3"><?php echo $get_id[0]['detalle'] ?></textarea>
                </div>
            </div> 
            
            <div class="form-group col-md-12">
                <label class="col-sm-12 control-label text-bold">Plantea una propuesta para retenerte: </label>
                <div class="col">
                    <textarea class="form-control" name="propuestae" id="propuestae" cols="10" rows="3"><?php echo $get_id[0]['propuesta'] ?></textarea>
                </div>
            </div> 
            <div class="form-group col-md-12">
                <label class="col-sm-12 control-label text-bold">Cuéntanos qué aspectos positivos reconoces de la empresa: </label>
                <div class="col">
                    <textarea class="form-control" name="apositivoe" id="apositivoe" cols="10" rows="3"><?php echo $get_id[0]['apositivo'] ?></textarea>
                </div>
            </div> 
            <div class="form-group col-md-12">
                <label class="col-sm-12 control-label text-bold">Cuéntanos qué aspectos debemos mejorar de la empresa: </label>
                <div class="col">
                    <textarea class="form-control" name="amejorae" id="amejorae" cols="10" rows="3"><?php echo $get_id[0]['amejora'] ?></textarea>
                </div>
            </div> 
            <div class="form-group col-md-12">
                <label class="col-sm-12 control-label text-bold">En caso no se pueda llegar a un acuerdo, ¿cuál sería tu fecha tentativa de cese?:<br>
            <i>Recuerda que el aviso debe ser con al menos 15 días de anticipación.</i> </label>
                <div class="col">
                    <input type="date" class="form-control" id="fechae" name="fechae" value="<?php echo $get_id[0]['fecha'] ?>">
                </div>
            </div> 
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_intencion" type="hidden" class="form-control" id="id_intencion" value="<?php echo $get_id[0]['id_intencion']; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Update_Intencion_Renuncia();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
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

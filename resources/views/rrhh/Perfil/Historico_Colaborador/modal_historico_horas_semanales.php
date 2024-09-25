<form id="formulario_historico_horas_semanales" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"><b>Actualizar Horas Semanales: </b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Horas Semanales: </label>
                <div class="">
                    <input type="text" class="form-control solo_numeros" id="horas_semanales_hhs" name="horas_semanales_hhs" placeholder="Horas Semanales" value="<?php if(count($get_historico)>0){ echo $get_historico[0]['horas_semanales']; } ?>">
                </div>
            </div>            
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="horas_semanales_bd_hhs" name="horas_semanales_bd_hhs" value="<?php if(count($get_historico)>0){ echo $get_historico[0]['horas_semanales']; } ?>">
        <input type="hidden" id="id_usuario_hhs" name="id_usuario_hhs" value="<?php echo $id_usuario; ?>">
        <button class="btn btn-primary mt-3" onclick="Update_Historico_Horas_Semanales('<?php echo $id_usuario; ?>');" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
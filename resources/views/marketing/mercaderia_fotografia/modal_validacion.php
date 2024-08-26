
    <div class="modal-header">
        <h5 class="modal-title">Validar Fotografías</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row mb-2">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Observación: </label>
            </div>  
            <div class="form-group col-md-10">
                <!--<input type="text" class="form-control" name="observacion_val" id="observacion_val">-->
                <textarea class="form-control" name="observacion_val" id="observacion_val" cols="10" rows="3"></textarea>
                
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Validar_Fotografia();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
<script>
    $('#observacion_val').bind('keyup paste', function(){
        var data=$('#observacion_val').val();
        $('#observacion_validacion').val(data);
    });
</script>
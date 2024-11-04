<form id="formulario_asignacionjr" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Asignar Responsable</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="col-sm-12 control-label text-bold">Fecha de Asignación: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fec_asignacionjr" name="fec_asignacionjr" placeholder="Código de Usuario" value="<?php echo $get_id[0]['fec_asignacionjr'];?>" autofocus <?php if($get_id[0]['cancelar_asignacionjr']==1){echo "disabled";}?>>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label class="col-sm-2 control-label text-bold">&nbsp;</label>
                <div class="col">
                    <label class=" control-label text-bold">Cancelar Asignación: </label>
                    <input type="checkbox" name="cancelar_asignacionjr" id="cancelar_asignacionjr" value="1" <?php if($get_id[0]['cancelar_asignacionjr']==1){echo "checked";}?> class="" onclick="Cancelar_Coordinador_Jr()">
                </div>
            </div>
            
        </div>
    </div>

    <div class="modal-footer">
    <input type="hidden" class="form-control" id="id_usuarioa" name="id_usuarioa" value="<?php echo $get_id['0']['id_usuario'];?>" placeholder="Contraseña" autofocus>
    <button class="btn btn-primary mt-3" type="button" onclick="Update_Asignacion_Coordinador_Jr();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Asignacion_Coordinador_Jr() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_asignacionjr'));
        var url = "{{ url('MiEquipo/Update_Asignacion_Coordinador_Jr') }}";
        var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                data: dataString, 
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false, 
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $("#ModalUpdate .close").click();
                        Cargar_x_Base();  
                    });
                },
                error:function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    Swal.fire(
                        '¡Ups!',
                        firstError,
                        'warning'
                    );
                }
            });
    }
    
    function Cancelar_Coordinador_Jr(){
        $("#fec_asignacionjr").val('');
        if($('#cancelar_asignacionjr').is(":checked")){
            $("#fec_asignacionjr").prop('disabled', true);
        }else{
            $("#fec_asignacionjr").prop('disabled', false);
        }
    }
</script>
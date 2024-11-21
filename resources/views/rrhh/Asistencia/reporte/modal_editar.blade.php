<form id="formulario_asistencia_diaria" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Marcación de <b><?php $parte = explode("-", $nombres); echo $parte[0]." ".$parte[1]; ?></b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <input type="hidden" id="fecha" name="fecha" value="<?php echo date('Y-m-d', strtotime($get_id[0]->punch_time)); ?>">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Hora: </label>
            </div>            
            <div class="form-group col-sm-4">
                <input value="<?php echo date('H:i:s', strtotime($get_id[0]->punch_time)) ?>" type="time" step="3600000" class="form-control group2" id="hora" name="hora" value="" placeholder="Ingresar hora de salida" autofocus>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <input name="id_asistencia_remota" type="hidden" id="id_asistencia_remota" value="<?php echo $get_id[0]->id; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Edit_asistencia_diaria();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
<script>
    
    function Edit_asistencia_diaria(t) {
        Cargando();
        var dataString = new FormData(document.getElementById('formulario_asistencia_diaria'));
        var url = "{{ url('Asistencia/Update_Asistencia_Diaria') }}"
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
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
                        $('#ModalUpdate').modal('hide');
                        Buscar_Reporte_Asistencia();
                        Buscar_No_Marcados();
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
</script>
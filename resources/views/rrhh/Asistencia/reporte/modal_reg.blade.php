<form id="formulario_asistencia_diariareg" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Marcación de <b><?php $parte = explode("-", $nombres); echo $parte[0]." ".$parte[1]; ?></b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <input type="hidden" id="fechar" name="fechar" value="<?php echo date("Y-m-d",strtotime($fecha)); ?>">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Hora: </label>
            </div>
            <div class="form-group col-sm-4">
                <input type="time"  class="form-control group2" id="horar" name="horar" value="" placeholder="Ingresar hora de salida" autofocus>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <input name="num_docr" type="hidden" id="num_docr" value="<?php echo $num_doc; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Reg_asistencia_diaria();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Reg_asistencia_diaria(t) {
        var dataString = new FormData(document.getElementById('formulario_asistencia_diariareg'));
        var url = "{{ url('Asistencia/Insert_Asistencia_Diaria') }}"
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: dataString,
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    swal.fire(
                        'Registro Denegado!',
                        'El registro ya existe o el usuario no fue encontrado!',
                        'error'
                    ).then(function() {
                    });
                }else{
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $('#ModalRegistro').modal('hide');
                        Buscar_Reporte_Asistencia();
                    });
                }
            }
        });
    }
</script>
<form id="formulario_baja" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Actualizar Fecha de Baja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha de Baja: </label>
                <input type="date" class="form-control" id="fec_baja" name="fec_baja" placeholder="Código de Usuario" value="<?php echo $get_id[0]['fec_baja'];?>" autofocus <?php if($get_id[0]['cancelar_baja']==1){echo "disabled";}?>>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Motivo:</label>
                <select name="id_motivo" id="id_motivo" class="form-control" <?php if($get_id[0]['cancelar_baja']==1){echo "disabled";} ?>>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_motivo as $list){?>
                        <option value="<?php echo $list->id_motivo ?>" <?php if($get_id[0]['id_motivo_baja']==$list->id_motivo){echo "selected";}?>><?php echo $list->nom_motivo ?></option>
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-md-6 div_renuncia">
                <label class="control-label text-bold">Documento: </label>
                <input type="file" name="documento" id="documento" accept=".pdf,.doc,.docx,.txt">
            </div>
            <div class="form-group col-md-6 div_renuncia">
                <label class="control-label text-bold">Motivo de renuncia: </label>
                <select name="motivo_renuncia" id="motivo_renuncia" class="form-control">
                    <option value="0">Seleccione</option>
                    <option value="Estudios">Estudios</option>
                    <option value="Familiar">Familiar</option>
                    <option value="Salud">Salud</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Cancelar Baja: </label>
                <input type="checkbox" name="cancelar_baja" id="cancelar_baja" value="1" <?php if($get_id[0]['cancelar_baja']==1){echo "checked";}?> class="" onclick="Cancelar_Baja()">
            </div>
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Observaciones: </label>
                <textarea class="form-control" id="observaciones_baja" name="observaciones_baja" rows="5" placeholder="Observaciones"><?php echo $get_id[0]['observaciones_baja']; ?></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $get_id['0']['id_usuario'];?>">
    <button class="btn btn-primary mt-3" type="button" onclick="Update_Fecha_Baja();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Fecha_Baja() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_baja'));
        var url = "{{ url('MiEquipo/Update_Fecha_Baja') }}";
        var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                data: dataString,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada!',
                            text: "¡Debe ingresar fecha de baja superior a la fecha de ingreso!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $("#ModalUpdate .close").click();
                            Cargar_x_Base();
                        });
                    }
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

    $(document).ready(function(){
        $(".div_renuncia").hide();
        $("#id_motivo").change(function() {
            var id_motivo_value = $(this).val();

            if (id_motivo_value == 1) {
                $(".div_renuncia").show();
            } else {
                $(".div_renuncia").hide();
            }
        });
    });

    function Cancelar_Baja(){
        $("#fec_baja").val('');
        $("#id_motivo").val('0');
        $("#archivo").val('');
        if($('#cancelar_baja').is(":checked")){
            $("#fec_baja").prop('disabled', true);
            $("#id_motivo").prop('disabled', true);
            $("#archivo").prop('disabled', true);
        }else{
            $("#fec_baja").prop('disabled', false);
            $("#id_motivo").prop('disabled', false);
            $("#archivo").prop('disabled', false);
        }
    }
</script>

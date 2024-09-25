<form id="formulario_historico_horario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"><b>Actualizar Horario: </b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Horario: </label>
                <div class="">
                    <select class="form-control basic_h" name="id_horario_hh" id="id_horario_hh" onchange="Limpiar_Fechas_Historico_Horario()">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_horario as $list){?> 
                            <option value="<?php echo $list['id_horario']; ?>" <?php if(count($get_historico)>0){if($get_historico[0]['id_horario'] == $list['id_horario']){echo "selected";}}?>><?php echo $list['nombre'];?></option> 
                        <?php } ?>
                    </select>
                </div>
            </div>            
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha de Inicio: </label>
                <div class="">
                    <input type="date" name="fec_inicio_hh" id="fec_inicio_hh" value="<?php if(count($get_historico)>0){echo $get_historico[0]['fec_inicio'];} ?>" class="form-control">
                </div>
            </div>            
            
            <div class="form-group col-md-6">
                <input type="checkbox" name="con_fec_fin_hh" id="con_fec_fin_hh" value="1" <?php if(count($get_historico)>0){if($get_historico[0]['con_fec_fin']==1){echo "checked";}}?> onclick="Mostrar_FecFin_Horario()" >
                <label class="control-label text-bold" for="con_fec_fin_hh">Con fecha fin: </label>
                <div class="">
                    <input type="date" name="fec_fin_hh" id="fec_fin_hh" value="<?php if(count($get_historico)>0){echo $get_historico[0]['fec_fin'];} ?>" class="form-control" style="display:<?php if(count($get_historico)>0){if($get_historico[0]['con_fec_fin']==1){echo "block";}else{echo "none";}}else{echo "none";}?>">
                </div>
            </div>            
            
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_horario_bd_hh" type="hidden" class="form-control" id="id_horario_bd_hh" value="<?php if(count($get_historico)>0){echo $get_historico[0]['id_horario'];} ?>">
        <input name="id_usuario_hh" type="hidden" class="form-control" id="id_usuario_hh" value="<?php echo $id_usuario; ?>">
        <input name="id_historico_horario" type="hidden" class="form-control" id="id_historico_horario" value="<?php if(count($get_historico)>0){echo $get_historico[0]['id_historico_horario'];} ?>">
        @csrf
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Update_Historico_Horario('<?php echo $id_usuario; ?>');" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    var ss = $(".basic_h").select2({
        tags: true,
    });

    $('.basic_h').select2({
        dropdownParent: $('#ModalUpdate')
    });
    
    function Mostrar_FecFin_Horario(){
        var div = document.getElementById("fec_fin_hh");
        $('#fec_fin_hh').val('');
        if ($('#con_fec_fin_hh').is(":checked")){
            div.style.display = "block";
        }else{
            div.style.display = "none";
        }
    }
    
    function Update_Historico_Horario(id_usuario) {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_historico_horario'));
        var url = "{{ url('ColaboradorController/Update_Historico_Horario') }}";
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
                if (data == "error") {
                    Swal({
                        title: 'Actualización Denegada',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        List_Datos_Laborales(id_usuario);
                        $("#ModalUpdate .close").click();
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
    function Limpiar_Fechas_Historico_Horario(){
        $('#fec_inicio_hh').val('');
        $('#fec_fin_hh').val('');
    }
</script>
<form id="formulario_historico_modalidad" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"><b>Actualizar Modalidad Laboral: </b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Modalidad: </label>
                <div class="">
                    <select class="form-control" name="id_modalidad_laboral_hm" id="id_modalidad_laboral_hm" onchange="Limpiar_Fechas_Historico_Modalidad()">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_modalidad_laboral as $list){?> 
                            <option value="<?php echo $list['id_modalidad_laboral']; ?>" <?php if(count($get_historico)>0){if($get_historico[0]['id_modalidad_laboral'] == $list['id_modalidad_laboral']){echo "selected";}}?>><?php echo $list['nom_modalidad_laboral'];?></option> 
                        <?php } ?>
                    </select>
                </div>
            </div>            
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha de Inicio: </label>
                <div class="">
                    <input type="date" name="fec_inicio_hm" id="fec_inicio_hm" value="<?php if(count($get_historico)>0){echo $get_historico[0]['fec_inicio'];} ?>" class="form-control">
                </div>
            </div>            
            
            <div class="form-group col-md-6">
                <input type="checkbox" name="con_fec_fin_hm" id="con_fec_fin_hm" value="1" <?php if(count($get_historico)>0){if($get_historico[0]['con_fec_fin']==1){echo "checked";}}?> onclick="Mostrar_FecFin_Modalidad()" >
                <label class="control-label text-bold" for="con_fec_fin_hm">Con fecha fin: </label>
                <div class="">
                    <input type="date" name="fec_fin_hm" id="fec_fin_hm" value="<?php if(count($get_historico)>0){echo $get_historico[0]['fec_fin'];} ?>" class="form-control" style="display:<?php if(count($get_historico)>0){if($get_historico[0]['con_fec_fin']==1){echo "block";}else{echo "none";}}else{echo "none";}?>">
                </div>
            </div>            
            
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_modalidad_laboral_bd_hm" type="hidden" class="form-control" id="id_modalidad_laboral_bd_hm" value="<?php if(count($get_historico)>0){echo $get_historico[0]['id_modalidad_laboral'];} ?>">
        <input name="id_usuario_hm" type="hidden" class="form-control" id="id_usuario_hm" value="<?php echo $id_usuario; ?>">
        <input name="id_historico_modalidadl" type="hidden" class="form-control" id="id_historico_modalidadl" value="<?php if(count($get_historico)>0){echo $get_historico[0]['id_historico_modalidadl'];} ?>">
        @csrf
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Update_Historico_Modalidad('<?php echo $id_usuario; ?>');" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
  
<script>
    function Update_Historico_Modalidad(id_usuario) {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_historico_modalidad'));
        var url = "{{ url('ColaboradorController/Update_Historico_Modalidad') }}";
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
                    List_Datos_Laborales(id_usuario);
                    $("#ModalUpdate .close").click();
                });
            }
        });
    }
    function Limpiar_Fechas_Historico_Modalidad(){
        $('#fec_inicio_hm').val('');
        $('#fec_fin_hm').val('');
    }

    function Mostrar_FecFin_Modalidad(){
        var div = document.getElementById("fec_fin_hm");
        $('#fec_fin_hm').val('');
        if ($('#con_fec_fin_hm').is(":checked")){
            div.style.display = "block";
        }else{
            div.style.display = "none";
        }
    }
</script>

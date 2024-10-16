<form id="formulario_historico_base" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"><b>Actualizar ubicación: </b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Ubicación: </label>
                <div class="">
                    <select class="form-control" name="cod_base_hb" id="cod_base_hb" onchange="Limpiar_Fechas_Historico_Base()">
                        <option value="0">Seleccionar</option>
                        @foreach ($list_ubicacion as $list)
                            <option value="{{ $list->id_ubicacion }}"
                            @if (isset($get_historico[0]) && $get_historico[0]['centro_labores'] == $list->id_ubicacion) selected @endif>
                                {{ $list->cod_ubi }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>            
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha de Inicio: </label>
                <div class="">
                    <input type="date" name="fec_inicio_hb" id="fec_inicio_hb" value="<?php if(count($get_historico)>0){echo $get_historico[0]['fec_inicio'];} ?>" class="form-control">
                </div>
            </div>            
            
            <div class="form-group col-md-6">
                <input type="checkbox" name="con_fec_fin_hb" id="con_fec_fin_hb" value="1" <?php if(count($get_historico)>0){if($get_historico[0]['con_fec_fin']==1){echo "checked";}}?> onclick="Mostrar_FecFin_Base()" >
                <label class="control-label text-bold" for="con_fec_fin_hb">Con fecha fin: </label>
                <div class="">
                    <input type="date" name="fec_fin_hb" id="fec_fin_hb" value="<?php if(count($get_historico)>0){echo $get_historico[0]['fec_fin'];} ?>" class="form-control" style="display:<?php if(count($get_historico)>0){if($get_historico[0]['con_fec_fin']==1){echo "block";}else{echo "none";}}else{echo "none";}?>">
                </div>
            </div>            
            
        </div>
    </div>

    <div class="modal-footer">
        <input name="cod_base_bd_hb" type="hidden" class="form-control" id="cod_base_bd_hb" value="<?php if(count($get_historico)>0){echo $get_historico[0]['centro_labores'];} ?>">
        <input name="id_usuario_hb" type="hidden" class="form-control" id="id_usuario_hb" value="<?php echo $id_usuario; ?>">
        <input name="id_historico_centro_labores" type="hidden" class="form-control" id="id_historico_centro_labores" value="<?php if(count($get_historico)>0){echo $get_historico[0]['id_historico_centro_labores'];} ?>">
        @csrf
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Update_Historico_Base('<?php echo $id_usuario; ?>');" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
  
<script>
    function Mostrar_FecFin_Base(){
        var div = document.getElementById("fec_fin_hb");
        $('#fec_fin_hb').val('');
        if ($('#con_fec_fin_hb').is(":checked")){
            div.style.display = "block";
        }else{
            div.style.display = "none";
        }
    }
    
    function Update_Historico_Base(id_usuario) {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_historico_base'));
        var url = "{{ url('ColaboradorController/Update_Historico_Base') }}";
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
    
    function Limpiar_Fechas_Historico_Base(){
        $('#fec_inicio_hb').val('');
        $('#fec_fin_hb').val('');
    }
</script>

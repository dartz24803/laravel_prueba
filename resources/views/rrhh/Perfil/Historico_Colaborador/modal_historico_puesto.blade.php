<form id="formulario_historico_puesto" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"><b>Actualizar Puesto: </b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Gerencia: </label>
                <div class="">
                    <select class="form-control" name="id_gerencia_hp" id="id_gerencia_hp" onchange="Busca_Sub_Gerencia_Hp();">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_gerencia as $list){?> 
                            <option <?php if(count($get_historico)>0){if($get_historico[0]['id_gerencia'] == $list->id_gerencia){echo "selected";}}?> value="<?php echo $list->id_gerencia; ?>"><?php echo $list['nom_gerencia'];?></option> 
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Sub-Gerencia: </label>
                <div class="">
                    <select class="form-control" name="id_sub_gerencia_hp" id="id_sub_gerencia_hp" onchange="Busca_Area_Hp();">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_sub_gerencia as $list){?> 
                            <option <?php if(count($get_historico)>0){if($get_historico[0]['id_sub_gerencia'] == $list['id_sub_gerencia']){echo "selected";}}?> value="<?php echo $list['id_sub_gerencia']; ?>"><?php echo $list['nom_sub_gerencia']; ?></option> 
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Área: </label>
                <div class="">
                    <select class="form-control" name="id_area_hp" id="id_area_hp" onchange="Busca_Puesto_Hp();">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_area as $list){?> 
                            <option <?php if(count($get_historico)>0){if($get_historico[0]['id_area'] == $list->id_area){echo "selected";}}?> value="<?php echo $list->id_area; ?>"><?php echo $list['nom_area'];?></option> 
                        <?php } ?>
                    </select>
                </div>
            </div>            
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Puesto: </label>
                <div class="">
                    <select class="form-control" name="id_puesto_hp" id="id_puesto_hp" onchange="Limpiar_Fechas_Historico_Puesto()">
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_puesto as $list){?> 
                            <option <?php if(count($get_historico)>0){if($get_historico[0]['id_puesto'] == $list->id_puesto){echo "selected";}}?> value="<?php echo $list->id_puesto; ?>"><?php echo $list['nom_puesto'];?></option> 
                        <?php } ?>
                    </select>
                </div>
            </div>            
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha de Inicio: </label>
                <div class="">
                    <input type="date" name="fec_inicio_hp" id="fec_inicio_hp" value="<?php if(count($get_historico)>0){echo $get_historico[0]['fec_inicio'];} ?>" class="form-control">
                </div>
            </div>            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Tipo: </label>
                <div class="">
                    <select class="form-control" name="id_tipo_cambio_hp" id="id_tipo_cambio_hp" >
                        <option value="0">Seleccionar</option>
                        <?php foreach($list_tipo_cambio as $list){?>
                        <option value="<?php echo $list->id_tipo_cambio ?>" <?php if(count($get_historico)>0){if($get_historico[0]['id_tipo_cambio']==$list->id_tipo_cambio){echo "selected";}}?>><?php echo $list->nom_tipo_cambio ?></option>    
                        <?php }?>
                    </select>
                </div>
            </div> 
            <div class="form-group col-md-6">
                <input type="checkbox" name="con_fec_fin_hp" id="con_fec_fin_hp" value="1" <?php if(count($get_historico)>0){if($get_historico[0]['con_fec_fin']==1){echo "checked";}}?> onclick="Mostrar_FecFin_Puesto()" >
                <label class="control-label text-bold" for="con_fec_fin_hp">Con fecha fin: </label>
                <div class="">
                    <input type="date" name="fec_fin_hp" id="fec_fin_hp" value="<?php if(count($get_historico)>0){echo $get_historico[0]['fec_fin'];}  ?>" class="form-control" style="display:<?php if(count($get_historico)>0){if($get_historico[0]['con_fec_fin']==1){echo "block";}else{echo "none";}}?>">
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_puesto_bd_hp" type="hidden" id="id_puesto_bd_hp" value="<?php if(count($get_historico)>0){echo $get_historico[0]['id_puesto'];} ?>">    
        <input name="id_usuario_hp" type="hidden" id="id_usuario_hp" value="<?php echo $id_usuario; ?>">
        <input name="id_historico_puesto" type="hidden" id="id_historico_puesto" value="<?php if(count($get_historico)>0){echo $get_historico[0]['id_historico_puesto'];} ?>">
        @csrf
        <button class="btn btn-primary" onclick="Update_Historico_Puesto('<?php echo $id_usuario; ?>');" type="button">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Busca_Sub_Gerencia_Hp(){
        Cargando();

        var id_gerencia = $('#id_gerencia_hp').val();
        var url = "{{ url('ColaboradorController/Busca_Sub_Gerencia_Hp') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url, 
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'id_gerencia':id_gerencia},
            success: function(data)
            {
                $('#id_sub_gerencia_hp').html(data);
                $('#id_area_hp').html('<option value="0">Seleccionar</option>');
                $('#id_puesto_hp').html('<option value="0">Seleccionar</option>');
            }
        });
    }

    function Busca_Area_Hp(){
        Cargando();

        var id_sub_gerencia = $('#id_sub_gerencia_hp').val();
        var url = "{{ url('ColaboradorController/Busca_Area_Hp') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url, 
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'id_sub_gerencia':id_sub_gerencia},
            success: function(data)
            {
                $('#id_area_hp').html(data);
                $('#id_puesto_hp').html('<option value="0">Seleccionar</option>');      
            }
        });
    }

    function Busca_Puesto_Hp(){
        Cargando();

        var id_area = $('#id_area_hp').val();
        var url = "{{ url('ColaboradorController/Busca_Puesto_Hp') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url, 
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'id_area':id_area},
            success: function(data)
            {
                $('#id_puesto_hp').html(data);    
            }
        });
    }

    function Limpiar_Fechas_Historico_Puesto(){
        $('#fec_inicio_hp').val('');
        $('#fec_fin_hp').val('');
    }
    
    function Update_Historico_Puesto(id_usuario) {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_historico_puesto'));
        var url = "{{ url('ColaboradorController/Update_Historico_Puesto') }}";
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
</script>
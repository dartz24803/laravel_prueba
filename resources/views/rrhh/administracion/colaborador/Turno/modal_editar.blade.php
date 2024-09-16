
<form id="formulario_turnoe"  method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Turno: <b></b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Centro de Labores:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="basee" id="basee" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_base as $list){?>
                        <option value="<?php echo $list->cod_base ?>" <?php if($get_id[0]['base']==$list->cod_base){echo "selected";}?>><?php echo $list->cod_base ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Entrada:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="entradae" id="entradae" value="<?php echo $get_id[0]['entrada'] ?>" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label>Salida:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="salidae" id="salidae" value="<?php echo $get_id[0]['salida'] ?>" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label>Tipo de Refrigerio:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="t_refrigerioe" id="t_refrigerioe" class="form-control" onchange="Tipo_Refrigerio('e')">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['t_refrigerio']==1){echo "selected";}?>>Refrigerio Fijo</option>
                    <option value="2" <?php if($get_id[0]['t_refrigerio']==2){echo "selected";}?>>Sin Refrigerio</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 row" >
            <div class="form-group col-md-2" id="div_refri1e" style="display:<?php if($get_id[0]['t_refrigerio']==1){echo "block";}else{echo "none";}?>">
                <label>Inicio Refrigerio:</label>
            </div>
            <div class="form-group col-md-4" id="div_refri2e" style="display:<?php if($get_id[0]['t_refrigerio']==1){echo "block";}else{echo "none";}?>">
                <input type="time" name="ini_refrie" id="ini_refrie" value="<?php echo $get_id[0]['ini_refri'] ?>" class="form-control">
            </div>
            <div class="form-group col-md-2" id="div_refri3e" style="display:<?php if($get_id[0]['t_refrigerio']==1){echo "block";}else{echo "none";}?>">
                <label>Fin Refrigerio:</label>
            </div>
            <div class="form-group col-md-4" id="div_refri4e" style="display:<?php if($get_id[0]['t_refrigerio']==1){echo "block";}else{echo "none";}?>">
                <input type="time" name="fin_refrie" id="fin_refrie" value="<?php echo $get_id[0]['fin_refri'] ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-12 row" >
            <div class="form-group col-md-1">
                <label class="switch s-primary mr-2">
                    <input type="checkbox" id="estado_registroe" name="estado_registroe" onclick="Estado_Turno_Ch()" <?php if($get_id[0]['estado_registro']==1){echo "checked";}?> value="1">
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="form-group col-md-1">
                <label id="lbl_estado_turno"><?php if($get_id[0]['estado_registro']==1){echo "Activo";}else{echo "Inactivo";}?></label>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_turno" type="hidden" class="form-control" id="id_turno" value="<?php echo $get_id[0]['id_turno']; ?>">
        <button class="btn btn-primary btn-sm mt-3" type="button" onclick="Update_Turno();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
<script>
    function Update_Turno() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_turnoe'));
        var url = "{{ url('ColaboradorConfController/Update_Turno') }}";
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
                        $("#ModalUpdate .close").click();
                        TablaTurno();
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
    function Tipo_Refrigerio(v){
        var div1 = document.getElementById("div_refri1"+v);
        var div2 = document.getElementById("div_refri2"+v);
        var div3 = document.getElementById("div_refri3"+v);
        var div4 = document.getElementById("div_refri4"+v);
        $('#ini_refri'+v).val('00:00:00');
        $('#fin_refri'+v).val('00:00:00');
        if($('#t_refrigerio'+v).val()=="1"){
            div1.style.display = "block";
            div2.style.display = "block";
            div3.style.display = "block";
            div4.style.display = "block";
        }else{
            div1.style.display = "none";
            div2.style.display = "none";
            div3.style.display = "none";
            div4.style.display = "none";
            $('#ini_refri'+v).val('00:00:00');
            $('#fin_refri'+v).val('00:00:00');
        }
    }
</script>

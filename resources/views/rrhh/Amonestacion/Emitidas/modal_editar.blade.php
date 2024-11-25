<style>
    .flatpickr-current-month .numInputWrapper {
        width: 7ch;
        width: 7ch\0;
        display: inline-block;
    }
</style>
<?php
$id_nivel=session('usuario')->id_nivel;
$id_puesto=session('usuario')->id_puesto;
?>
<form id="formulario_amonestacione" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"><?php if($modal==1){echo "Editar";}else{echo "Detalle";}?> Amonestación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Fecha: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fechae" name="fechae" value="<?php echo $get_id[0]['fecha'] ?>" <?php if($modal==2){echo "disabled";}else{if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $get_id[0]['estado_amonestacion']==1){}else{if($get_id[0]['estado_amonestacion']!=1){echo "disabled";}}} ?>>
                </div>
            </div>

            <?php if(session('usuario')->id_nivel==2 || session('usuario')->id_nivel==1 || session('usuario')->id_puesto==133){?>
                <div class="form-group col-md-8">
                    <label class="col-sm-12 control-label text-bold">Solicitante: </label>
                    <div class="col-md">
                        <select class="form-control basic" name="id_solicitantee" id="id_solicitantee" <?php if($modal==2){echo "disabled";}else{if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $get_id[0]['estado_amonestacion']==1){}else{if($get_id[0]['estado_amonestacion']!=1){echo "disabled";}}} ?>>
                            <?php foreach($list_responsables as $list){ ?>
                                <option value="<?php echo $list['id_usuario']; ?>" <?php if($get_id[0]['id_solicitante']==$list['id_usuario']){echo "selected";}?>><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'];?></option>
                            <?php }  ?>
                        </select>
                    </div>
                </div>
            <?php }else{?>
            <input type="hidden" name="id_solicitantee" id="id_solicitantee" value="<?php echo $get_id[0]['id_solicitante']  ?>">
            <?php }?>
            <div class="form-group col-md-8">
                <label class="col-sm-12 control-label text-bold">Colaborador: </label>
                <div class="col-md" id="cmb_colaboradore">
                    <select name="id_usuarioe" id="id_usuarioe" class="form-control basic" <?php if($modal==2){echo "disabled";}else{if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $get_id[0]['estado_amonestacion']==1){}else{if($get_id[0]['estado_amonestacion']!=1){echo "disabled";}}} ?>>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_colaborador as $list){?>
                            <option value="<?php echo $list['id_usuario'] ?>" <?php if($get_id[0]['id_colaborador']==$list['id_usuario']){echo "selected";}?>><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Tipo: </label>
                <div class="col">
                    <select name="tipoe" id="tipoe" class="form-control" <?php if($modal==2){echo "disabled";}else{if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $get_id[0]['estado_amonestacion']==1){}else{if($get_id[0]['estado_amonestacion']!=1){echo "disabled";}}} ?>>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo_amonestacion as $list){?>
                            <option value="<?php echo $list['id_tipo_amonestacion'] ?>" <?php if($get_id[0]['tipo']==$list['id_tipo_amonestacion']){ echo "selected"; } ?>>
                                <?php echo $list['nom_tipo_amonestacion']; ?>
                            </option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Gravedad: </label>
                <div class="col">
                    <select name="id_gravedad_amonestacione" id="id_gravedad_amonestacione" class="form-control" <?php if($modal==2){echo "disabled";}else{if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $get_id[0]['estado_amonestacion']==1){}else{if($get_id[0]['estado_amonestacion']!=1){echo "disabled";}}} ?>><!-- onchange="Cambio_Motivo_Gravedad('2')"-->
                        <option value="0">Seleccione</option>
                        <?php foreach($list_gravedad_amonestacion as $list){?>
                        <option value="<?php echo $list['id_gravedad_amonestacion'] ?>" <?php if($get_id[0]['id_gravedad_amonestacion']==$list['id_gravedad_amonestacion']){echo "selected";}?>><?php echo $list['nom_gravedad_amonestacion'] ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Motivo: </label>
                <div class="col" id="cmb_motivoe">
                    <select name="motivoe" id="motivoe" class="form-control" <?php if($modal==2){echo "disabled";}else{if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $get_id[0]['estado_amonestacion']==1){}else{if($get_id[0]['estado_amonestacion']!=1){echo "disabled";}}} ?>>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_motivo_amonestacion as $list){?>
                            <option value="<?php echo $list['id_motivo_amonestacion'] ?>" <?php if($get_id[0]['motivo']==$list['id_motivo_amonestacion']){ echo "selected"; } ?>>
                                <?php echo $list['nom_motivo_amonestacion']; ?>
                            </option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <input type="hidden" id="documento" name="documento" value="<?php echo $get_id[0]['documento'] ?>">
            <input type="hidden" id="estado_amonestacion_bd" name="estado_amonestacion_bd" value="<?php echo $get_id[0]['estado_amonestacion'] ?>">
            <input type="hidden" id="modal" name="modal" value="<?php echo $modal ?>">
            <?php if($get_id[0]['documento']!="" || $get_id[0]['estado_amonestacion']==2){?>
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Estado: </label>
                <div class="col" >
                    <select name="estado_amonestacion" id="estado_amonestacion" class="form-control" <?php if($modal==2){echo "disabled";} ?>>
                        <option value="0">Seleccione</option>
                        <option value="4" <?php if($get_id[0]['estado_amonestacion']==4){echo "selected";} ?>>Aceptado</option>
                        <option value="5" <?php if($get_id[0]['estado_amonestacion']==5){echo "selected";} ?>>No Aceptado</option>
                    </select>
                </div>
            </div>
            <?php }?>

            <div class="form-group col-md-12">
                <label class="col-sm-12 control-label text-bold">Detalle del suceso: </label>
                <div class="col">
                    <textarea class="form-control" name="detallee" id="detallee" cols="10" rows="3" <?php if($modal==2){echo "disabled";}else{if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $get_id[0]['estado_amonestacion']==1){}else{if($get_id[0]['estado_amonestacion']!=1){echo "disabled";}}} ?>><?php echo $get_id[0]['detalle'] ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <?php if($modal==1){?>
            <input name="id_amonestacion" type="hidden" class="form-control" id="id_amonestacion" value="<?php echo $get_id[0]['id_amonestacion']; ?>">
            <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Update_Amonestacion();" type="button">Guardar</button>
            <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
        <?php }else{?>
            <button class="btn btn-primary mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
        <?php }?>

    </div>
</form>
<script>
    var ss = $(".basic").select2({
        tags: true
    });
    $('.basic').select2({
        dropdownParent: $('#ModalUpdateSlide')
    });

    function Update_Amonestacion() {
        Cargando();
        var dataString = new FormData(document.getElementById('formulario_amonestacione'));
        var url = "{{ url('Update_Amonestacion')}}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Amonestacion('2')) {
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
                    if(data=="error"){
                        swal.fire(
                            'Actualización Denegada!',
                            '¡Existe un registro con los mismos datos o con el mismo tipo de amonestación!',
                            'error'
                        ).then(function() {
                        });
                    }else{
                       swal.fire(
                            'Actualización Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $("#ModalUpdateSlide .close").click()
                            Lista_Amonestaciones_Emitidas();
                        });
                    }
                },
                error: function(xhr) {
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
    }

    function Valida_Amonestacion(t) {
        v="";
        if(t==2){
            v="e";
        }
        if ($('#fecha'+v).val() === '') {
            msgDate = 'Debe ingresar fecha.';
            Swal.fire(
                '¡Ups!',
                msgDate,
                'warning'
            );
            return false;
        }
        if(t==2){
            if($('#id_usuario'+v).val() == '0') {
                msgDate = 'Debe seleccionar colaborador';
                Swal.fire(
                    '¡Ups!',
                    msgDate,
                    'warning'
                );
                return false;
            }
        }else{
            if($('#id_usuario'+v).val() == '') {
                msgDate = 'Debe seleccionar al menos un colaborador';
                Swal.fire(
                    '¡Ups!',
                    msgDate,
                    'warning'
                );
                return false;
            }
        }
        if($('#nivel'+v).val()==2){
            if($('#id_solicitante'+v).val() == '0') {
                msgDate = 'Debe seleccionar solicitante';
                Swal.fire(
                    '¡Ups!',
                    msgDate,
                    'warning'
                );
                return false;
            }
        }
        if($('#tipo'+v).val() == '') {
            msgDate = 'Debe ingresar tipo de amonestación';
            Swal.fire(
                '¡Ups!',
                msgDate,
                'warning'
            );
            return false;
        }
        if($('#id_gravedad_amonestacion'+v).val() == '') {
            msgDate = 'Debe seleccionar gravedad de amonestación';
            Swal.fire(
                '¡Ups!',
                msgDate,
                'warning'
            );
            return false;
        }
        if($('#motivo'+v).val() == '') {
            msgDate = 'Debe ingresar motivo de amonestación';
            Swal.fire(
                '¡Ups!',
                msgDate,
                'warning'
            );
            return false;
        }
        if(t==2){
            if($('#documento').val() != ''){
                if($('#estado_amonestacion').val() == '0') {
                    msgDate = 'Debe seleccionar estado';
                Swal.fire(
                    '¡Ups!',
                    msgDate,
                    'warning'
                );
                    return false;
                }
            }
        }
        return true;
    }
</script>

<form id="formulario_horario_i" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Horario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Nombre: </label>
                <div>
                    <input type="text" class="form-control" id="nombre_i" name="nombre_i" placeholder="Ingresar nombre">       
                </div>
            </div>            
            
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Base: </label>
                <div>
                    <select class="form-control" id="cod_base_i" name="cod_base_i" onchange="Busca_Turno_XBase('_i')">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_base as $list){?>
                            <option value="<?php echo $list['cod_base'] ?>"><?php echo $list['cod_base'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>            
            
            <div class="form-group col-md-4">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_feriado_i" name="ch_feriado_i" value="1">
                    <span class="new-control-indicator"></span>&nbsp;Feriados Laborables
                </label>
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Selecciona los días laborados: </label>
            </div>

            <div class="form-group col-md-12">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_lu_i" name="ch_dia_laborado_lu_i" value="1" checked onclick="Mostrar_Dias_Laborados_I('lu')">
                    <span class="new-control-indicator"></span>&nbsp;Lunes
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_ma_i" name="ch_dia_laborado_ma_i" value="1" checked onclick="Mostrar_Dias_Laborados_I('ma')">
                    <span class="new-control-indicator"></span>&nbsp;Martes
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_mi_i" name="ch_dia_laborado_mi_i" value="1" checked onclick="Mostrar_Dias_Laborados_I('mi')">
                    <span class="new-control-indicator"></span>&nbsp;Miércoles
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_ju_i" name="ch_dia_laborado_ju_i" value="1" checked onclick="Mostrar_Dias_Laborados_I('ju')">
                    <span class="new-control-indicator"></span>&nbsp;Jueves
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_vi_i" name="ch_dia_laborado_vi_i" value="1" checked onclick="Mostrar_Dias_Laborados_I('vi')">
                    <span class="new-control-indicator"></span>&nbsp;Viernes
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_sa_i" name="ch_dia_laborado_sa_i" value="1" onclick="Mostrar_Dias_Laborados_I('sa')">
                    <span class="new-control-indicator"></span>&nbsp;Sábado
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_do_i" name="ch_dia_laborado_do_i" value="1" onclick="Mostrar_Dias_Laborados_I('do')">
                    <span class="new-control-indicator"></span>&nbsp;Domingo
                </label>
            </div>
        </div>

        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item"> 
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home_i" role="tab" aria-controls="home" aria-selected="true">Conf. Básica</a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile_i" role="tab" aria-controls="profile" aria-selected="false">Conf. Descanso</a>
            </li>-->
        </ul>

        <div class="tab-content" id="myTabContent"> 
            <div class="tab-pane fade show active" id="home_i" role="tabpanel" aria-labelledby="home-tab">
                <div class="col-md-12 row ">
                    <div class="form-group col-md-2 conf_basica_lu_i">
                        <label class="control-label text-bold">Lunes: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_lu_i">
                        <select name="id_turno_lu_i" id="id_turno_lu_i" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                    <!--<div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_entrada_lu_i" name="hora_entrada_lu_i" value="08:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_salida_lu_i" name="hora_salida_lu_i" value="18:00">
                    </div>-->
                
                    <div class="form-group col-md-2 conf_basica_ma_i">
                        <label class="control-label text-bold">Martes: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_ma_i">
                        <select name="id_turno_ma_i" id="id_turno_ma_i" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                    <!--<div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_entrada_ma_i" name="hora_entrada_ma_i" value="08:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_salida_ma_i" name="hora_salida_ma_i" value="18:00">
                    </div>-->
                    <div class="form-group col-md-2 conf_basica_mi_i">
                        <label class="control-label text-bold">Miércoles: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_mi_i">
                        <select name="id_turno_mi_i" id="id_turno_mi_i" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                    <!--<div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_entrada_mi_i" name="hora_entrada_mi_i" value="08:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_salida_mi_i" name="hora_salida_mi_i" value="18:00">
                    </div>-->
                    <div class="form-group col-md-2 conf_basica_ju_i">
                        <label class="control-label text-bold">Jueves: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_ju_i">
                        <select name="id_turno_ju_i" id="id_turno_ju_i" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                    <!--<div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_entrada_ju_i" name="hora_entrada_ju_i" value="08:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_salida_ju_i" name="hora_salida_ju_i" value="18:00">
                    </div>-->
                    <div class="form-group col-md-2 conf_basica_vi_i">
                        <label class="control-label text-bold">Viernes: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_vi_i">
                        <select name="id_turno_vi_i" id="id_turno_vi_i" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                    <!--<div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_entrada_vi_i" name="hora_entrada_vi_i" value="08:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_salida_vi_i" name="hora_salida_vi_i" value="18:00">
                    </div>-->
                    <div class="form-group col-md-2 conf_basica_sa_i">
                        <label class="control-label text-bold">Sábado: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_sa_i">
                        <select name="id_turno_sa_i" id="id_turno_sa_i" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                    <!--<div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_entrada_sa_i" name="hora_entrada_sa_i" value="08:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_salida_sa_i" name="hora_salida_sa_i" value="18:00">
                    </div>-->
                    <div class="form-group col-md-2 conf_basica_do_i">
                        <label class="control-label text-bold">Domingo: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_do_i">
                        <select name="id_turno_do_i" id="id_turno_do_i" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                    <!--<div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_entrada_do_i" name="hora_entrada_do_i" value="08:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_salida_do_i" name="hora_salida_do_i" value="18:00">
                    </div>-->
                </div>
            </div>

            <!--<div class="tab-pane fade" id="profile_i" role="tabpanel" aria-labelledby="profile-tab">
                <div class="col-md-12 row conf_descanso_lu_i">
                    <div class="form-group col-md-2">
                        <label class="new-control new-checkbox checkbox-outline-primary">
                            <input type="checkbox" class="new-control-input" id="con_descanso_lu_i" name="con_descanso_lu_i" value="1" checked onclick="Horario_Descanso_I('lu');">
                            <span class="new-control-indicator"></span>Lunes
                        </label>
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_edescanso_lu_i" name="hora_edescanso_lu_i" value="13:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_sdescanso_lu_i" name="hora_sdescanso_lu_i" value="14:00">
                    </div>
                </div>

                <div class="col-md-12 row conf_descanso_ma_i">
                    <div class="form-group col-md-2">
                        <label class="new-control new-checkbox checkbox-outline-primary">
                            <input type="checkbox" class="new-control-input" id="con_descanso_ma_i" name="con_descanso_ma_i" value="1" checked onclick="Horario_Descanso_I('ma');">
                            <span class="new-control-indicator"></span>Martes
                        </label>
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_edescanso_ma_i" name="hora_edescanso_ma_i" value="13:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_sdescanso_ma_i" name="hora_sdescanso_ma_i" value="14:00">
                    </div>
                </div>

                <div class="col-md-12 row conf_descanso_mi_i">
                    <div class="form-group col-md-2">
                        <label class="new-control new-checkbox checkbox-outline-primary">
                            <input type="checkbox" class="new-control-input" id="con_descanso_mi_i" name="con_descanso_mi_i" value="1" checked onclick="Horario_Descanso_I('mi');">
                            <span class="new-control-indicator"></span>Miercoles
                        </label>
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_edescanso_mi_i" name="hora_edescanso_mi_i" value="13:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_sdescanso_mi_i" name="hora_sdescanso_mi_i" value="14:00">
                    </div>
                </div>

                <div class="col-md-12 row conf_descanso_ju_i">
                    <div class="form-group col-md-2">
                        <label class="new-control new-checkbox checkbox-outline-primary">
                            <input type="checkbox" class="new-control-input" id="con_descanso_ju_i" name="con_descanso_ju_i" value="1" checked onclick="Horario_Descanso_I('ju');">
                            <span class="new-control-indicator"></span>Jueves
                        </label>
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_edescanso_ju_i" name="hora_edescanso_ju_i" value="13:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_sdescanso_ju_i" name="hora_sdescanso_ju_i" value="14:00">
                    </div>
                </div>

                <div class="col-md-12 row conf_descanso_vi_i">
                    <div class="form-group col-md-2">
                        <label class="new-control new-checkbox checkbox-outline-primary">
                            <input type="checkbox" class="new-control-input" id="con_descanso_vi_i" name="con_descanso_vi_i" value="1" checked onclick="Horario_Descanso_I('vi');">
                            <span class="new-control-indicator"></span>Viernes
                        </label>
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_edescanso_vi_i" name="hora_edescanso_vi_i" value="13:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_sdescanso_vi_i" name="hora_sdescanso_vi_i" value="14:00">
                    </div>
                </div>

                <div class="col-md-12 row conf_descanso_sa_i">
                    <div class="form-group col-md-2">
                        <label class="new-control new-checkbox checkbox-outline-primary">
                            <input type="checkbox" class="new-control-input" id="con_descanso_sa_i" name="con_descanso_sa_i" value="1" checked onclick="Horario_Descanso_I('sa');">
                            <span class="new-control-indicator"></span>Sábado
                        </label>
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_edescanso_sa_i" name="hora_edescanso_sa_i" value="13:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_sdescanso_sa_i" name="hora_sdescanso_sa_i" value="14:00">
                    </div>
                </div>

                <div class="col-md-12 row conf_descanso_do_i">
                    <div class="form-group col-md-2">
                        <label class="new-control new-checkbox checkbox-outline-primary">
                            <input type="checkbox" class="new-control-input" id="con_descanso_do_i" name="con_descanso_do_i" value="1" checked onclick="Horario_Descanso_I('do');">
                            <span class="new-control-indicator"></span>Domingo
                        </label>
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_edescanso_do_i" name="hora_edescanso_do_i" value="13:00">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="time" class="form-control" id="hora_sdescanso_do_i" name="hora_sdescanso_do_i" value="14:00">
                    </div>
                </div>
            </div>-->
        </div>
    </div>

    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Insert_Horario();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $(".conf_basica_sa_i").hide();
        $(".conf_basica_do_i").hide();
        $(".conf_descanso_sa_i").hide();
        $(".conf_descanso_do_i").hide();
    });

    function Mostrar_Dias_Laborados_I(dia){
        $('#id_turno_'+dia+'_i').val('0');
        if ($('#ch_dia_laborado_'+dia+'_i').is(":checked")){
            $(".conf_basica_"+dia+"_i").show();
            //$(".conf_descanso_"+dia+"_i").show();
        }else{
            $(".conf_basica_"+dia+"_i").hide();
            //$(".conf_descanso_"+dia+"_i").hide();
        }
    }

    /*function Horario_Descanso_I(dia){
        if ($('#con_descanso_'+dia+'_i').is(":checked")){
            $('#hora_edescanso_'+dia+'_i').attr("disabled", false);
            $('#hora_sdescanso_'+dia+'_i').attr("disabled", false);
        }else{
            $('#hora_edescanso_'+dia+'_i').attr("disabled", true);
            $('#hora_sdescanso_'+dia+'_i').attr("disabled", true);
        }
    }*/

    function Insert_Horario() {
        Cargando();
        var dataString = new FormData(document.getElementById('formulario_horario_i'));
        var url = "{{ url('ColaboradorConfController/Insert_Horario') }}";
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
                    if (data == "error") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Existe un horario con el mismo nombre!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                        });
                    } else {
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Horario();
                            $("#ModalRegistroGrande .close").click()
                        });
                    }
                }
            });
    }

    function Valida_Insert_Horario() {
        if ($('#nombre_i').val().trim() == '') {
            msgDate = 'Debe ingresar nombre.';
            inputFocus = '#nombre_i';
            return false;
        }
        if ($('#cod_base_i').val() == '0') {
            msgDate = 'Debe seleccionar base.';
            inputFocus = '#cod_base_i';
            return false;
        }
        if(!$('#ch_dia_laborado_lu_i').is(":checked") && !$('#ch_dia_laborado_ma_i').is(":checked") && 
        !$('#ch_dia_laborado_mi_i').is(":checked") && !$('#ch_dia_laborado_ju_i').is(":checked") && 
        !$('#ch_dia_laborado_vi_i').is(":checked") && !$('#ch_dia_laborado_sa_i').is(":checked") && 
        !$('#ch_dia_laborado_do_i').is(":checked")){
            msgDate = 'Debe seleccionar al menos un día de la semana.';
            inputFocus = '#ch_dia_laborado_lu_i';
            return false;
        }
        if($('#ch_dia_laborado_lu_i').is(":checked")){
            if($('#id_turno_lu_i').val()=="0"){
                msgDate = 'Debe seleccionar turno para Lunes.';
                inputFocus = '#id_turno_lu_i';
                return false;
            }
        }
        if($('#ch_dia_laborado_ma_i').is(":checked")){
            if($('#id_turno_ma_i').val()=="0"){
                msgDate = 'Debe seleccionar turno para Martes.';
                inputFocus = '#id_turno_ma_i';
                return false;
            }
        }
        if($('#ch_dia_laborado_mi_i').is(":checked")){
            if($('#id_turno_mi_i').val()=="0"){
                msgDate = 'Debe seleccionar turno para Miércoles.';
                inputFocus = '#id_turno_mi_i';
                return false;
            }
        }
        if($('#ch_dia_laborado_ju_i').is(":checked")){
            if($('#id_turno_ju_i').val()=="0"){
                msgDate = 'Debe seleccionar turno para Jueves.';
                inputFocus = '#id_turno_ju_i';
                return false;
            }
        }
        if($('#ch_dia_laborado_vi_i').is(":checked")){
            if($('#id_turno_vi_i').val()=="0"){
                msgDate = 'Debe seleccionar turno para Viernes.';
                inputFocus = '#id_turno_vi_i';
                return false;
            }
        }
        if($('#ch_dia_laborado_sa_i').is(":checked")){
            if($('#id_turno_sa_i').val()=="0"){
                msgDate = 'Debe seleccionar turno para Sábado.';
                inputFocus = '#id_turno_sa_i';
                return false;
            }
        }
        if($('#ch_dia_laborado_do_i').is(":checked")){
            if($('#id_turno_do_i').val()=="0"){
                msgDate = 'Debe seleccionar turno para Domingo.';
                inputFocus = '#id_turno_do_i';
                return false;
            }
        }
        return true;
    }

    function Busca_Turno_XBase(v) {
       Cargando();
        var cod_base=$('#cod_base'+v).val();
        var url = "{{ url('ColaboradorConfController/Busca_Turno_XBase') }}";
        var csrfToken = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            data:{'cod_base':cod_base},
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#id_turno_lu'+v).html(data);
                $('#id_turno_ma'+v).html(data);
                $('#id_turno_mi'+v).html(data);
                $('#id_turno_ju'+v).html(data);
                $('#id_turno_vi'+v).html(data);
                $('#id_turno_sa'+v).html(data);
                $('#id_turno_do'+v).html(data);
            }
        });
    } 
</script>

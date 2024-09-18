<form id="formulario_horario_u" method="POST" enctype="multipart/form-data" class="needs-validation">
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
                    <input type="text" class="form-control" id="nombre_u" name="nombre_u" placeholder="Ingresar nombre" value="<?php echo $get_id[0]['nombre']; ?>">       
                </div>
            </div>            
            
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Base: </label>
                <div>
                    <select class="form-control" id="cod_base_u" name="cod_base_u" onchange="Busca_Turno_XBase('_u')">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_base as $list){?>
                            <option value="<?php echo $list['cod_base'] ?>" <?php if($list['cod_base']==$get_id[0]['cod_base']){ echo "selected"; } ?>>
                                <?php echo $list['cod_base'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>            
            
            <div class="form-group col-md-4">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_feriado_u" name="ch_feriado_u" value="1" <?php if($get_id[0]['feriado']==1){ echo "checked"; } ?>>
                    <span class="new-control-indicator"></span>&nbsp;Feriados Laborables
                </label>
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold">Selecciona los días laborados: </label>
            </div>

            <div class="form-group col-md-12">
                <?php 
                    $dsb_lunes = "";
                    $dsb_martes = "";
                    $dsb_miercoles = "";
                    $dsb_jueves = "";
                    $dsb_viernes = "";
                    $dsb_sabado = "";
                    $dsb_domingo = "";
                    $chk_lunes = "checked";
                    $chk_martes = "checked";
                    $chk_miercoles = "checked";
                    $chk_jueves = "checked";
                    $chk_viernes = "checked";
                    $chk_sabado = "checked";
                    $chk_domingo = "checked";
                ?>
                <?php 
                    $busq_detalle = in_array('1', array_column($get_detalle, 'dia'));
                    $posicion = array_search('1', array_column($get_detalle, 'dia'));
                    if ($busq_detalle != false){ 
                        if($get_detalle[$posicion]['con_descanso']==0){
                            $dsb_lunes = "disabled";
                            $chk_lunes = "";
                        }  
                    }
                ?>
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_lu_u" name="ch_dia_laborado_lu_u" value="1" <?php if($busq_detalle != false){ echo "checked"; } ?> onclick="Mostrar_Dias_Laborados_U('lu')">
                    <input type="hidden" id="id_lunes" name="id_lunes" value="<?php if($busq_detalle!=false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                    <span class="new-control-indicator"></span>&nbsp;Lunes
                </label>

                <?php 
                    $busq_detalle = in_array('2', array_column($get_detalle, 'dia'));
                    $posicion = array_search('2', array_column($get_detalle, 'dia'));
                    if ($busq_detalle != false){ 
                        if($get_detalle[$posicion]['con_descanso']==0){
                            $dsb_martes = "disabled";
                            $chk_martes = "";
                        }  
                    }
                ?>
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_ma_u" name="ch_dia_laborado_ma_u" value="1" <?php if($busq_detalle != false){ echo "checked"; } ?> onclick="Mostrar_Dias_Laborados_U('ma')">
                    <input type="hidden" id="id_martes" name="id_martes" value="<?php if($busq_detalle!=false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                    <span class="new-control-indicator"></span>&nbsp;Martes
                </label>

                <?php 
                    $busq_detalle = in_array('3', array_column($get_detalle, 'dia'));
                    $posicion = array_search('3', array_column($get_detalle, 'dia'));
                    if ($busq_detalle != false){ 
                        if($get_detalle[$posicion]['con_descanso']==0){
                            $dsb_miercoles = "disabled";
                            $chk_miercoles = "";
                        }  
                    }
                ?>
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_mi_u" name="ch_dia_laborado_mi_u" value="1" <?php if($busq_detalle != false){ echo "checked"; } ?> onclick="Mostrar_Dias_Laborados_U('mi')">
                    <input type="hidden" id="id_miercoles" name="id_miercoles" value="<?php if($busq_detalle!=false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                    <span class="new-control-indicator"></span>&nbsp;Miércoles
                </label>

                <?php 
                    $busq_detalle = in_array('4', array_column($get_detalle, 'dia'));
                    $posicion = array_search('4', array_column($get_detalle, 'dia'));
                    if ($busq_detalle != false){  
                        if($get_detalle[$posicion]['con_descanso']==0){
                            $dsb_jueves = "disabled";
                            $chk_jueves = "";
                        }  
                    }
                ?>
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_ju_u" name="ch_dia_laborado_ju_u" value="1" <?php if($busq_detalle != false){ echo "checked"; } ?> onclick="Mostrar_Dias_Laborados_U('ju')">
                    <input type="hidden" id="id_jueves" name="id_jueves" value="<?php if($busq_detalle!=false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                    <span class="new-control-indicator"></span>&nbsp;Jueves
                </label>

                <?php 
                    $busq_detalle = in_array('5', array_column($get_detalle, 'dia'));
                    $posicion = array_search('5', array_column($get_detalle, 'dia'));
                    if ($busq_detalle != false){ 
                        if($get_detalle[$posicion]['con_descanso']==0){
                            $dsb_viernes = "disabled";
                            $chk_viernes = "";
                        }  
                    }
                ?>
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_vi_u" name="ch_dia_laborado_vi_u" value="1" <?php if($busq_detalle != false){ echo "checked"; } ?> onclick="Mostrar_Dias_Laborados_U('vi')">
                    <input type="hidden" id="id_viernes" name="id_viernes" value="<?php if($busq_detalle!=false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                    <span class="new-control-indicator"></span>&nbsp;Viernes
                </label>

                <?php 
                    $busq_detalle = in_array('6', array_column($get_detalle, 'dia'));
                    $posicion = array_search('6', array_column($get_detalle, 'dia'));
                    if ($busq_detalle != false){ 
                        if($get_detalle[$posicion]['con_descanso']==0){
                            $dsb_sabado = "disabled";
                            $chk_sabado = "";
                        }  
                    }
                ?>
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_sa_u" name="ch_dia_laborado_sa_u" value="1" <?php if($busq_detalle != false){ echo "checked"; } ?> onclick="Mostrar_Dias_Laborados_U('sa')">
                    <input type="hidden" id="id_sabado" name="id_sabado" value="<?php if($busq_detalle!=false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                    <span class="new-control-indicator"></span>&nbsp;Sábado
                </label>

                <?php 
                    $busq_detalle = in_array('7', array_column($get_detalle, 'dia'));
                    $posicion = array_search('7', array_column($get_detalle, 'dia'));
                    if ($busq_detalle != false){ 
                        if($get_detalle[$posicion]['con_descanso']==0){
                            $dsb_domingo = "disabled";
                            $chk_domingo = "";
                        }  
                    }
                ?>
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_do_u" name="ch_dia_laborado_do_u" value="1" <?php if($busq_detalle != false){ echo "checked"; } ?> onclick="Mostrar_Dias_Laborados_U('do')">
                    <input type="hidden" id="id_domingo" name="id_domingo" value="<?php if($busq_detalle!=false){ echo $get_detalle[$posicion]['id_horario_dia']; } ?>">
                    <span class="new-control-indicator"></span>&nbsp;Domingo
                </label>
            </div>
        </div>

        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home_u" role="tab" aria-controls="home" aria-selected="true">Conf. Básica</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home_u" role="tabpanel" aria-labelledby="home-tab">
                <div class="col-md-12 row ">
                    
                    <div class="form-group col-md-2 conf_basica_lu_u">
                        <label class="control-label text-bold">Lunes: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_lu_u">
                        <?php 
                        $busq_detalle = in_array('1', array_column($get_detalle, 'dia'));
                        $posicion = array_search('1', array_column($get_detalle, 'dia'));
                        ?>
                        <select name="id_turno_lu_u" id="id_turno_lu_u" class="form-control">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_turno as $list){?>
                            <option value="<?php echo $list['id_turno'] ?>" <?php if($busq_detalle!=false){if($get_detalle[$posicion]['id_turno']==$list['id_turno']){echo "selected";}}?>><?php echo $list['option_select'] ?></option>
                            <?php }?>
                        </select>
                    </div>
                
                    <?php 
                        $busq_detalle = in_array('2', array_column($get_detalle, 'dia'));
                        $posicion = array_search('2', array_column($get_detalle, 'dia'));
                    ?>
                    <div class="form-group col-md-2 conf_basica_ma_u">
                        <label class="control-label text-bold">Martes: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_ma_u">
                        <select name="id_turno_ma_u" id="id_turno_ma_u" class="form-control">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_turno as $list){?>
                            <option value="<?php echo $list['id_turno'] ?>" <?php if($busq_detalle!=false){if($get_detalle[$posicion]['id_turno']==$list['id_turno']){echo "selected";}}?>><?php echo $list['option_select'] ?></option>
                            <?php }?>
                        </select>
                    </div>
                
                    <?php 
                        $busq_detalle = in_array('3', array_column($get_detalle, 'dia'));
                        $posicion = array_search('3', array_column($get_detalle, 'dia'));
                        
                    ?>
                    <div class="form-group col-md-2 conf_basica_mi_u">
                        <label class="control-label text-bold">Miércoles: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_mi_u">
                        <select name="id_turno_mi_u" id="id_turno_mi_u" class="form-control">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_turno as $list){?>
                            <option value="<?php echo $list['id_turno'] ?>" <?php if($busq_detalle!=false){if($get_detalle[$posicion]['id_turno']==$list['id_turno']){echo "selected";}}?>><?php echo $list['option_select'] ?></option>
                            <?php }?>
                        </select>
                    </div>
                
                    <?php 
                        $busq_detalle = in_array('4', array_column($get_detalle, 'dia'));
                        $posicion = array_search('4', array_column($get_detalle, 'dia'));
                    ?>
                    <div class="form-group col-md-2 conf_basica_ju_u">
                        <label class="control-label text-bold">Jueves: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_ju_u">
                        <select name="id_turno_ju_u" id="id_turno_ju_u" class="form-control">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_turno as $list){?>
                            <option value="<?php echo $list['id_turno'] ?>" <?php if($busq_detalle!=false){if($get_detalle[$posicion]['id_turno']==$list['id_turno']){echo "selected";}}?>><?php echo $list['option_select'] ?></option>
                            <?php }?>
                        </select>
                    </div>

                    <?php 
                        $busq_detalle = in_array('5', array_column($get_detalle, 'dia'));
                        $posicion = array_search('5', array_column($get_detalle, 'dia'));
                    ?>
                    <div class="form-group col-md-2 conf_basica_vi_u">
                        <label class="control-label text-bold">Viernes: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_vi_u">
                        <select name="id_turno_vi_u" id="id_turno_vi_u" class="form-control">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_turno as $list){?>
                            <option value="<?php echo $list['id_turno'] ?>" <?php if($busq_detalle!=false){if($get_detalle[$posicion]['id_turno']==$list['id_turno']){echo "selected";}}?>><?php echo $list['option_select'] ?></option>
                            <?php }?>
                        </select>
                    </div>
                    
                    <?php 
                        $busq_detalle = in_array('6', array_column($get_detalle, 'dia'));
                        $posicion = array_search('6', array_column($get_detalle, 'dia'));
                        
                    ?>
                    <div class="form-group col-md-2 conf_basica_sa_u">
                        <label class="control-label text-bold">Sábado: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_sa_u">
                        <select name="id_turno_sa_u" id="id_turno_sa_u" class="form-control">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_turno as $list){?>
                            <option value="<?php echo $list['id_turno'] ?>" <?php if($busq_detalle!=false){if($get_detalle[$posicion]['id_turno']==$list['id_turno']){echo "selected";}}?>><?php echo $list['option_select'] ?></option>
                            <?php }?>
                        </select>
                    </div>
                    
                    <?php 
                        $busq_detalle = in_array('7', array_column($get_detalle, 'dia'));
                        $posicion = array_search('7', array_column($get_detalle, 'dia'));
                    ?>
                    <div class="form-group col-md-2 conf_basica_do_u">
                        <label class="control-label text-bold">Domingo: </label>
                    </div>
                    <div class="form-group col-md-4 conf_basica_do_u">
                        <select name="id_turno_do_u" id="id_turno_do_u" class="form-control">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_turno as $list){?>
                            <option value="<?php echo $list['id_turno'] ?>" <?php if($busq_detalle!=false){if($get_detalle[$posicion]['id_turno']==$list['id_turno']){echo "selected";}}?>><?php echo $list['option_select'] ?></option>
                            <?php }?>
                        </select>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_horario" name="id_horario" value="<?php echo $get_id[0]['id_horario']; ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Update_Horario();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        <?php 
            $busq_detalle = in_array('1', array_column($get_detalle, 'dia'));
            $posicion = array_search('1', array_column($get_detalle, 'dia'));
            if ($busq_detalle == false){ ?>
                $(".conf_basica_lu_u").hide();
                //$(".conf_descanso_lu_u").hide();
        <?php } ?>
        <?php 
            $busq_detalle = in_array('2', array_column($get_detalle, 'dia'));
            $posicion = array_search('2', array_column($get_detalle, 'dia'));
            if ($busq_detalle == false){ ?>
                $(".conf_basica_ma_u").hide();
                //$(".conf_descanso_ma_u").hide();
        <?php } ?>
        <?php 
            $busq_detalle = in_array('3', array_column($get_detalle, 'dia'));
            $posicion = array_search('3', array_column($get_detalle, 'dia'));
            if ($busq_detalle == false){ ?>
                $(".conf_basica_mi_u").hide();
                //$(".conf_descanso_mi_u").hide();
        <?php } ?>
        <?php 
            $busq_detalle = in_array('4', array_column($get_detalle, 'dia'));
            $posicion = array_search('4', array_column($get_detalle, 'dia'));
            if ($busq_detalle == false){ ?>
                $(".conf_basica_ju_u").hide();
                //$(".conf_descanso_ju_u").hide();
        <?php } ?>
        <?php 
            $busq_detalle = in_array('5', array_column($get_detalle, 'dia'));
            $posicion = array_search('5', array_column($get_detalle, 'dia'));
            if ($busq_detalle == false){ ?>
                $(".conf_basica_vi_u").hide();
                //$(".conf_descanso_vi_u").hide();
        <?php } ?>
        <?php 
            $busq_detalle = in_array('6', array_column($get_detalle, 'dia'));
            $posicion = array_search('6', array_column($get_detalle, 'dia'));
            if ($busq_detalle == false){ ?>
                $(".conf_basica_sa_u").hide();
                //$(".conf_descanso_sa_u").hide();
        <?php } ?>
        <?php 
            $busq_detalle = in_array('7', array_column($get_detalle, 'dia'));
            $posicion = array_search('7', array_column($get_detalle, 'dia'));
            if ($busq_detalle == false){ ?>
                $(".conf_basica_do_u").hide();
                //$(".conf_descanso_do_u").hide();
        <?php } ?>
    });

    function Mostrar_Dias_Laborados_U(dia){
        $('#id_turno_'+dia+'_u').val('0');
        if ($('#ch_dia_laborado_'+dia+'_u').is(":checked")){
            $(".conf_basica_"+dia+"_u").show();
            //$(".conf_descanso_"+dia+"_u").show();
        }else{
            $(".conf_basica_"+dia+"_u").hide();
            //$(".conf_descanso_"+dia+"_u").hide();
        }
    }

    function Horario_Descanso_U(dia){
        if ($('#con_descanso_'+dia+'_u').is(":checked")){
            $('#hora_edescanso_'+dia+'_u').attr("disabled", false);
            $('#hora_sdescanso_'+dia+'_u').attr("disabled", false);
        }else{
            $('#hora_edescanso_'+dia+'_u').attr("disabled", true);
            $('#hora_sdescanso_'+dia+'_u').attr("disabled", true);
        }
    }

    function Update_Horario() {
        $(document)
        .ajaxStart(function() {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0, 
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function() {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var dataString = new FormData(document.getElementById('formulario_horario_u'));
        var url = "{{ url('ColaboradorConfController/Update_Horario') }}";

        if (Valida_Update_Horario()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Horario();
                        $("#ModalUpdateSlide .close").click()
                    });
                }
            });
        } else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function Valida_Update_Horario() {
        if ($('#nombre_u').val().trim() == '') {
            msgDate = 'Debe ingresar nombre.';
            inputFocus = '#nombre_u';
            return false;
        }
        if ($('#cod_base_u').val() == '0') {
            msgDate = 'Debe seleccionar base.';
            inputFocus = '#cod_base_u';
            return false;
        }
        if(!$('#ch_dia_laborado_lu_u').is(":checked") && !$('#ch_dia_laborado_ma_u').is(":checked") && 
        !$('#ch_dia_laborado_mi_u').is(":checked") && !$('#ch_dia_laborado_ju_u').is(":checked") && 
        !$('#ch_dia_laborado_vi_u').is(":checked") && !$('#ch_dia_laborado_sa_u').is(":checked") && 
        !$('#ch_dia_laborado_do_u').is(":checked")){
            msgDate = 'Debe seleccionar al menos un día de la semana.';
            inputFocus = '#ch_dia_laborado_lu_u';
            return false;
        }
        if($('#ch_dia_laborado_lu_u').is(":checked")){
            if($('#id_turno_lu_u').val()=="0"){
                msgDate = 'Debe seleccionar turno para Lunes.';
                inputFocus = '#id_turno_lu_u';
                return false;
            }
        }
        if($('#ch_dia_laborado_ma_u').is(":checked")){
            if($('#id_turno_ma_u').val()=="0"){
                msgDate = 'Debe seleccionar turno para Martes.';
                inputFocus = '#id_turno_ma_u';
                return false;
            }
        }
        if($('#ch_dia_laborado_mi_u').is(":checked")){
            if($('#id_turno_mi_u').val()=="0"){
                msgDate = 'Debe seleccionar turno para Miércoles.';
                inputFocus = '#id_turno_mi_u';
                return false;
            }
        }
        if($('#ch_dia_laborado_ju_u').is(":checked")){
            if($('#id_turno_ju_u').val()=="0"){
                msgDate = 'Debe seleccionar turno para Jueves.';
                inputFocus = '#id_turno_ju_u';
                return false;
            }
        }
        if($('#ch_dia_laborado_vi_u').is(":checked")){
            if($('#id_turno_vi_u').val()=="0"){
                msgDate = 'Debe seleccionar turno para Viernes.';
                inputFocus = '#id_turno_vi_u';
                return false;
            }
        }
        if($('#ch_dia_laborado_sa_u').is(":checked")){
            if($('#id_turno_sa_u').val()=="0"){
                msgDate = 'Debe seleccionar turno para Sábado.';
                inputFocus = '#id_turno_sa_u';
                return false;
            }
        }
        if($('#ch_dia_laborado_do_u').is(":checked")){
            if($('#id_turno_do_u').val()=="0"){
                msgDate = 'Debe seleccionar turno para Domingo.';
                inputFocus = '#id_turno_do_u';
                return false;
            }
        }
        return true;
    }
</script>

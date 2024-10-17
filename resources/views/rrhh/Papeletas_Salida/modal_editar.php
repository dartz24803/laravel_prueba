<style>
    .flatpickr-current-month .numInputWrapper {
        width: 7ch;
        width: 7ch\0;
        display: inline-block;
    }
</style>

<form id="formulario_papeletas_salida_editar" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Motivo de Salida: </label>
            </div>            
            <div class="form-group col-sm-3">
                <div class="n-chk">
                    <label class="new-control new-radio radio-primary">
                    <input type="radio" class="new-control-input" name="id_motivo" id="id_motivo" value="1" <?php if($get_id[0]['id_motivo']==1){ echo "checked"; } ?> onchange="Mostrar_Otros(1);">
                    <span class="new-control-indicator"></span>&nbsp;Laboral
                    </label>
                </div>
            </div>

            <div class="form-group col-sm-3">
                <div class="n-chk">
                    <label class="new-control new-radio radio-primary">
                    <input type="radio" class="new-control-input" name="id_motivo" id="id_motivo" value="2" <?php if($get_id[0]['id_motivo']==2){ echo "checked"; } ?> onchange="Mostrar_Otros(2);">
                    <span class="new-control-indicator"></span>&nbsp;Personal
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Fecha de Solicitud: </label>
            </div>            
            <div class="form-group col-sm-3">
                <input  style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" 
                type="date" placeholder="Seleccione Fecha.."
                class="form-control flatpickr flatpickr-input active" 
                id="fec_solicitud_edit" name="fec_solicitud" value="<?php echo $get_id[0]['fec_solicitud']; ?>"
                placeholder="Ingresar fecha solicitud" autofocus>
                <br>
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                        <input type="checkbox" class="new-control-input" id="sin_ingreso" 
                        name="sin_ingreso" value="1" <?php if($get_id[0]['sin_ingreso']==1){ echo "checked"; } ?>>
                        <span class="new-control-indicator"></span>&nbsp;&nbsp;Sin ingreso
                    </label>
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                        <input type="checkbox" class="new-control-input" id="sin_retorno" 
                        name="sin_retorno" value="1"  <?php if($get_id[0]['sin_retorno']==1){ echo "checked"; } ?>>
                        <span class="new-control-indicator"></span>&nbsp;&nbsp;Sin retorno
                    </label>
                </div>
            </div>

            <div class="form-group col-md-7">
            </div>
            
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Destino: <?php echo $get_id[0]['destino']; ?></label>
            </div>            
            <div id="select_destino" class="form-group col-sm-4">
                <select class="form-control" id="destino" name="destino" onchange="Traer_Tramite();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_destino as $list){ ?>
                        <option value="<?php echo $list['id_destino']; ?>" <?php if($list['id_destino']==$get_id[0]['destino']){ echo "selected"; } ?>>
                            <?php echo $list['nom_destino']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Especifique: </label>
            </div>   
            <div class="form-group col-sm-4">
                <input style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="text" class="form-control" id="especificacion_destino" name="especificacion_destino" value="<?php echo $get_id[0]['especificacion_destino']; ?>" placeholder="Especifique destino">
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Trámite: </label>
            </div>            
            <div id="select_tramite" class="form-group col-sm-4">
                <select class="form-control" id="tramite" name="tramite">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tramite as $list){ ?>
                        <option value="<?php echo $list['id_tramite']; ?>" <?php if($list['id_tramite']==$get_id[0]['tramite']){ echo "selected"; } ?>>
                            <?php echo $list['nom_tramite']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Especifique: </label>
            </div>   
            <div class="form-group col-sm-4">
                <input style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="text" class="form-control" id="especificacion_tramite" name="especificacion_tramite" value="<?php echo $get_id[0]['especificacion_tramite']; ?>" placeholder="Especifique trámite">
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Hora Salida: </label>
            </div>   
            <div class="form-group col-sm-2">
                <input style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;
                border-left: 0px;border-right: 0pc;padding-bottom: 0px;"
                type="time" step="3600000" class="form-control group2" id="hora_salida_edit" 
                name="hora_salida" value="<?php if($get_id[0]['sin_ingreso']!=1){ echo $get_id[0]['hora_salida']; } ?>" 
                placeholder="Ingresar hora de salida">
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Hora Retorno: </label>
            </div>            
            <div class="form-group col-sm-2">
                <input  style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;"
                type="time" step="3600000" class="form-control group1" id="hora_retorno_edit" 
                name="hora_retorno" value="<?php if($get_id[0]['sin_retorno']!=1){ echo $get_id[0]['hora_retorno']; } ?>" 
                placeholder="">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="fecha_actual" name="fecha_actual" value="<?php echo date('Y-m-d'); ?>">
        <input name="id_solicitudes_user" type="hidden" class="form-control" id="id_solicitudes_user" value="<?php echo $get_id[0]['id_solicitudes_user']; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Edit_Papeletas_Salida();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script type="text/javascript">
    function Mostrar_Otros(id){
        var id = id;

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
        
        var url="<?php echo site_url(); ?>Corporacion/Cambiar_Motivo";

        $.ajax({    
            type:"POST",
            url:url,
            data:{'id_motivo':id_motivo},
            success:function (data) {
                $('#select_destino').html(data);
            }
        });
    }

    function Traer_Tramite(){
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
        
        var id_destino=$('#destino').val();
        var url="<?php echo site_url(); ?>Corporacion/Traer_Tramite";

        $.ajax({    
            type:"POST",
            url:url,
            data:{'id_destino':id_destino},
            success:function (data) {
                $('#select_tramite').html(data);
            }
        });
    }

    var check_date_today = moment();
    var hor_min_act  = check_date_today.format('H:mm '); 
    var f8salida_papeletar = flatpickr(document.getElementById('fec_solicitud_edit'), {
        dateFormat: "Y-m-d",
        minDate: "today",
        maxDate: new Date().fp_incr(31), // 14 days from now
    });
    var f9salida_papeletar = flatpickr(document.getElementById('hora_salida_edit'), {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        //defaultDate: hor_min_act,
        minTime: hor_min_act,
        //maxTime: "22:00"
    });
    var f10salida_papeletar = flatpickr(document.getElementById('hora_retorno_edit'), {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        //defaultDate: hor_min_act,
        minTime: hor_min_act,
    });

    $('#fec_solicitud_edit').on('input',function(e){
        var fec_solicitud = $('#fec_solicitud_edit').val();
        var fecha_actual = $('#fecha_actual').val();

        if(fec_solicitud==fecha_actual) {
            var f11salida_papeletar = flatpickr(document.getElementById('hora_salida_edit'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: hor_min_act,
                minTime: hor_min_act,
                //maxTime: "22:00"
            });
            var f12salida_papeletar = flatpickr(document.getElementById('hora_retorno_edit'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                //defaultDate: hor_min_act,
                minTime: hor_min_act,
            });
        }else{
            var f13salida_papeletar = flatpickr(document.getElementById('hora_salida_edit'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                //defaultDate: hor_min_act,
                //minTime: hor_min_act,
                //maxTime: "22:00"
            });
            var f14salida_papeletar = flatpickr(document.getElementById('hora_retorno_edit'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                //defaultDate: hor_min_act,
                //minTime: hor_min_act,
            });
        }
    });
            
    $(function() {
        validar_ingreso();
        validar_retorno();
        $("#sin_ingreso").click(validar_ingreso);
        $("#sin_retorno").click(validar_retorno);
    });

    function validar_retorno() {
        if($("#sin_retorno").is(':checked')){
            $("input.group1").attr("disabled", true);
            $("input.group1").css("cursor", "not-allowed");
            $("input.group1").css("border-color", "currentcolor currentcolor rgb(255, 1, 1)");
            $('#hora_retorno_edit').attr("placeholder", "Sin Retorno");

            $('#hora_retorno_edit').val('');
        }else{
            $("input.group1").removeAttr("disabled");
            $("input.group1").css("cursor", "pointer");
            $("input.group1").css("border-color", "currentcolor currentcolor rgb(172, 176, 195)");
            $('#hora_retorno_edit').attr('placeholder', 'Ingresar hora de retorno');
        }
    }

    function validar_ingreso() {
        if($("#sin_ingreso").is(':checked')){
            $("input.group2").attr("disabled", true);
            $("input.group2").css("cursor", "not-allowed");
            $("input.group2").css("border-color", "currentcolor currentcolor rgb(255, 1, 1)");
            $('#hora_salida_edit').attr("placeholder", "Sin Ingreso");

            $('#hora_salida_edit').val('');
        }else{
            $("input.group2").removeAttr("disabled");
            $("input.group2").css("cursor", "pointer");
            $("input.group2").css("border-color", "currentcolor currentcolor rgb(172, 176, 195)");
            $('#hora_salida_edit').attr('placeholder', 'Ingresar hora de salida');
        }
    }
</script>

<style>
    .flatpickr-current-month .numInputWrapper {
        width: 7ch;
        width: 7ch\0;
        display: inline-block;
    }
</style>

<form id="formulario_papeletas_salida_registro" method="POST" enctype="multipart/form-data" class="needs-validation">
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
            
            <div class="form-group col-sm-3">
                <div class="n-chk">
                    <label class="new-control new-radio radio-primary">
                    <input type="radio" class="new-control-input" name="id_motivo" id="id_motivo" value="3" <?php if($get_id[0]['motivo']!=""){ echo "checked"; } ?> onchange="Mostrar_Otros(3);">
                    <span class="new-control-indicator"></span>&nbsp;Otros
                    </label>
                </div>
            </div>
        </div>

        <div id="div_otros" class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Otros:</label>
            </div> 
            <div class="form-group col-md-10">
                <input style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="text" class="form-control" id="otros" name="otros" value="<?php echo $get_id[0]['motivo']; ?>" placeholder="Ingresar otros" autofocus>
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
                id="fec_solicitud" name="fec_solicitud" value="<?php echo $get_id[0]['fec_solicitud']; ?>"
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
                <label class="col-sm-12 control-label text-bold">Destino: </label>
            </div>            
            <div class="form-group col-sm-10">
                <input style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" 
                type="text" class="form-control" id="destino" name="destino" 
                value="<?php echo $get_id[0]['destino']; ?>" placeholder="Ingresar destino" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Trámite: </label>
            </div>            
            <div class="form-group col-sm-10">
                <input style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" 
                type="text" class="form-control" id="tramite" name="tramite" 
                value="<?php echo $get_id[0]['tramite']; ?>" placeholder="Ingresar trámite" autofocus>
            </div>

            <div id="div_label_salida" class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Hora Salida: </label>
            </div>   
            <div id="div_hora_salida" class="form-group col-sm-2">
                <input style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;
                border-left: 0px;border-right: 0pc;padding-bottom: 0px;"
                type="time" step="3600000" class="form-control group2" id="hora_salida" 
                name="hora_salida" value="<?php echo $get_id[0]['hora_salida']; ?>" 
                placeholder="Ingresar hora de salida" autofocus>
            </div>

            <div id="div_label_retorno" class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Hora Retorno: </label>
            </div>            
            <div id="div_hora_retorno" class="form-group col-sm-2">
                <input  style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;"
                type="time" step="3600000" class="form-control group1" id="hora_retorno" 
                name="hora_retorno" value="<?php echo $get_id[0]['hora_retorno']; ?>" 
                placeholder="" autofocus>
            </div>

            <!--
                <div class="form-group col-md-2 dia_hoy">
                    <label class="col-sm-12 control-label text-bold">Hora Salida hoy: </label>
                </div>            
                <div class="form-group col-sm-2 dia_hoy">
                    <input  style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;"
                    type="time" step="3600000" class="form-control" id="hora_salida_hoy" 
                    name="hora_salida_hoy" value="" placeholder="Ingresar hora de salida" autofocus>
                </div>

                <div class="form-group col-md-2 dia_hoy ">
                    <label class="col-sm-12 control-label text-bold">Hora Retorno hoy: </label>
                </div>            
                <div class="form-group col-sm-2 dia_hoy ">
                    <input  style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;"
                    type="time" step="3600000" class="form-control group1" id="hora_retorno_hoy" 
                    name="hora_retorno_hoy" value="" placeholder="" autofocus>
                </div>

                <div class="form-group col-md-2 dia_no_hoy">
                    <label class="col-sm-12 control-label text-bold">Hora Salida: </label>
                </div>            
                <div class="form-group col-md-2 dia_no_hoy">
                    <input  style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" 
                    type="time" step="3600000" class="form-control" id="hora_salida_hoy_no" 
                    name="hora_salida_hoy_no" value="" placeholder="Ingresar hora de salida" autofocus>
                </div>

                <div class="form-group col-md-2 dia_no_hoy">
                    <label class="col-sm-12 control-label text-bold">Hora Retorno: </label>
                </div>            
                <div class="form-group col-md-2 dia_no_hoy">
                    <input  style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;"
                    type="time" step="3600000" class="form-control group2" id="hora_retorno_hoy_no" 
                    name="hora_retorno_hoy_no" value="" placeholder="" autofocus>
                </div>
            -->
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="ingreso_checkeado" name="ingreso_checkeado" value="<?php echo $get_id[0]['sin_ingreso']; ?>">
        <input type="hidden" id="retorno_checkeado" name="retorno_checkeado" value="<?php echo $get_id[0]['sin_retorno']; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Insert_Papeletas_Salida();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        if($('#otros').val()==""){
            $('#div_otros').hide(); 
        }
        if($('#ingreso_checkeado').val()==1){
            $('#div_label_salida').hide(); 
            $('#div_hora_salida').hide(); 
        }
        if($('#retorno_checkeado').val()==1){
            $('#div_label_retorno').hide(); 
            $('#div_hora_retorno').hide(); 
        }
    });

    function Mostrar_Otros(id){
        var id = id;

        if(id==3){
            $('#div_otros').show(); 
        }else{
            $('#div_otros').hide(); 
            $('#otros').val('');
        }
    }

    var check_date_today = moment();
    var hor_min_act  = check_date_today.format('H:mm '); 
    var f1salida_papeletar = flatpickr(document.getElementById('fec_solicitud'), {
        dateFormat: "Y-m-d",
        minDate: "today",
        maxDate: new Date().fp_incr(31), // 14 days from now
    });

    var f2salida_papeletar = flatpickr(document.getElementById('hora_salida'), {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        //defaultDate: hor_min_act,
        minTime: hor_min_act,
        //maxTime: "22:00"
    });
    var f3salida_papeletar = flatpickr(document.getElementById('hora_retorno'), {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        //defaultDate: hor_min_act,
        minTime: hor_min_act,
    });

    /*
        $('#fec_solicitud').on('input',function(e){
            const formato = "YYYY-MM-DD";
            var fecha_actual = new Date();
            dateTime2 = moment(fecha_actual).format(formato);
            //alert(dateTime2);

            if($('#fec_solicitud').val().trim() === dateTime2) {
                $(".dia_hoy").show();
                $(".dia_no_hoy").hide();
                var f2salida_papeletar_hoy = flatpickr(document.getElementById('hora_salida_hoy'), {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: hor_min_act,
                    minTime: hor_min_act,
                    //maxTime: "22:00"
                });
                var f3salida_papeletar_hoy = flatpickr(document.getElementById('hora_retorno_hoy'), {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    //defaultDate: hor_min_act,
                    minTime: hor_min_act,
                });
                $('#hora_salida_hoy_no').val('');
                $('#hora_retorno_hoy_no').val('');
            }else{
                $(".dia_no_hoy").show();
                $(".dia_hoy").hide();
                var f2salida_papeletar_hoy_no = flatpickr(document.getElementById('hora_salida_hoy_no'), {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    //defaultDate: hor_min_act,
                    //minTime: hor_min_act,
                    //maxTime: "22:00"
                });
                var f3salida_papeletar_hoy_no = flatpickr(document.getElementById('hora_retorno_hoy_no'), {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    //defaultDate: hor_min_act,
                    //minTime: hor_min_act,
                });
                $('#hora_salida_hoy').val('');
                $('#hora_retorno_hoy').val('');
            }

        });*/

        /*$(document).ready(function() {
            $('.selectt').hide(); 
            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                $(".selectt").not(targetBox).hide();
                $(targetBox).show();
            });
        });

        var check_date_today = moment();
        var hor_min_act  = check_date_today.format('H:mm '); 
        var f1salida_papeletar = flatpickr(document.getElementById('fec_solicitud'), {
            dateFormat: "Y-m-d",
            minDate: "today",
            maxDate: new Date().fp_incr(31), // 14 days from now
        });

        $('#fec_solicitud').on('input',function(e){
            const formato = "YYYY-MM-DD";
            var fecha_actual = new Date();
            dateTime2 = moment(fecha_actual).format(formato);
            //alert(dateTime2);

            if($('#fec_solicitud').val().trim() === dateTime2) {
                $(".dia_hoy").show();
                $(".dia_no_hoy").hide();
                var f2salida_papeletar_hoy = flatpickr(document.getElementById('hora_salida_hoy'), {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: hor_min_act,
                    minTime: hor_min_act,
                    //maxTime: "22:00"
                });
                var f3salida_papeletar_hoy = flatpickr(document.getElementById('hora_retorno_hoy'), {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    //defaultDate: hor_min_act,
                    minTime: hor_min_act,
                });
                $('#hora_salida_hoy_no').val('');
                $('#hora_retorno_hoy_no').val('');
            }else{
                $(".dia_no_hoy").show();
                $(".dia_hoy").hide();
                var f2salida_papeletar_hoy_no = flatpickr(document.getElementById('hora_salida_hoy_no'), {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    //defaultDate: hor_min_act,
                    //minTime: hor_min_act,
                    //maxTime: "22:00"
                });
                var f3salida_papeletar_hoy_no = flatpickr(document.getElementById('hora_retorno_hoy_no'), {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    //defaultDate: hor_min_act,
                    //minTime: hor_min_act,
                });
                $('#hora_salida_hoy').val('');
                $('#hora_retorno_hoy').val('');
            }

        });
        function enable_cb() {
            if (this.checked) {
                $("input.group1").attr("disabled", true);
                $("input.group1").css("cursor", "not-allowed");
                $("input.group1").css("border-color", "currentcolor currentcolor rgb(255, 1, 1)");
                $('#hora_retorno_hoy').attr("placeholder", "Sin Retorno");

                //$('input.group1').removeAttr('placeholder');
                $('#hora_retorno_hoy').val('');
                $('#hora_retorno_hoy_no').val('');
                $("input.group2").attr("disabled", true);
                $("input.group2").css("cursor", "not-allowed");
                $("input.group2").css("border-color", "currentcolor currentcolor rgb(255, 1, 1)");
                $('#hora_retorno_hoy_no').attr("placeholder", "Sin Retorno");

                //$('input.group2').removeAttr('placeholder');

            } else {
                $("input.group1").removeAttr("disabled");
                $("input.group1").css("cursor", "pointer");
                $("input.group1").css("border-color", "currentcolor currentcolor rgb(172, 176, 195)");
                $('#hora_retorno_hoy').attr('placeholder', 'Ingresar hora de retorno');
                //$('input.group1').attr('placeholder', 'Ingresar hora de retorno');
                $("input.group2").removeAttr("disabled");
                $("input.group2").css("cursor", "pointer");
                $("input.group2").css("border-color", "currentcolor currentcolor rgb(172, 176, 195)");
                $('#hora_retorno_hoy_no').attr('placeholder', 'Ingresar hora de retorno');

                //$('input.group2').attr('placeholder', 'Ingresar hora de retorno');

                //$("input.group2").attr("disabled", true);
                //$("input.group2").css("cursor", "not-allowed");
            }
        }
    */
            
    $(function() {
        enable_cd();
        $("#sin_ingreso").click(enable_cd);
        enable_cb();
        $("#sin_retorno").click(enable_cb);
    });

    function enable_cb() {
        if (this.checked) {
            $("input.group1").attr("disabled", true);
            $("input.group1").css("cursor", "not-allowed");
            $("input.group1").css("border-color", "currentcolor currentcolor rgb(255, 1, 1)");
            $('#hora_retorno').attr("placeholder", "Sin Retorno");

            $('#hora_retorno').val('');
        } else {
            $("input.group1").removeAttr("disabled");
            $("input.group1").css("cursor", "pointer");
            $("input.group1").css("border-color", "currentcolor currentcolor rgb(172, 176, 195)");
            $('#hora_retorno').attr('placeholder', 'Ingresar hora de retorno');
        }
    }

    function enable_cd() {
        if (this.checked) {
            $("input.group2").attr("disabled", true);
            $("input.group2").css("cursor", "not-allowed");
            $("input.group2").css("border-color", "currentcolor currentcolor rgb(255, 1, 1)");
            $('#hora_salida').attr("placeholder", "Sin Ingreso");

            $('#hora_salida').val('');
        } else {
            $("input.group2").removeAttr("disabled");
            $("input.group2").css("cursor", "pointer");
            $("input.group2").css("border-color", "currentcolor currentcolor rgb(172, 176, 195)");
            $('#hora_salida').attr('placeholder', 'Ingresar hora de salida');
        }
    }
</script>

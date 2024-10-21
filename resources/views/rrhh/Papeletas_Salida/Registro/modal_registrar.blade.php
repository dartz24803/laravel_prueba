<style>
    /*.flatpickr-current-month .numInputWrapper {
        width: 7ch;
        width: 7ch\0;
        display: inline-block;
    }*/

    .dia_no_hoy {
        display: none;
    }
</style>

<form id="formulario_papeletas_salida_registro" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registro</h5>
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
                    <input type="radio" class="new-control-input" name="id_motivo" id="id_motivo" value="1" onchange="Cambiar_Motivo(1);">
                    <span class="new-control-indicator"></span>&nbsp;Laboral
                    </label>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <div class="n-chk">
                    <label class="new-control new-radio radio-primary">
                    <input type="radio" class="new-control-input" name="id_motivo" id="id_motivo" value="2" onchange="Cambiar_Motivo(2);">
                    <span class="new-control-indicator"></span>&nbsp;Personal
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="col-md-12 row mb-2 mt-2">
                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold">Fecha de Solicitud: </label>
                </div>
                <div class="form-group col-sm-3">
                    <input  style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;"
                    type="date" placeholder="Seleccione Fecha.."
                    class="form-control"
                    id="fec_solicitud" name="fec_solicitud" value="" placeholder="Ingresar fecha solicitud">
                </div>
                <div class="form-group col-sm-7 p-2">
                    <div class="n-chk">
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                            <input type="checkbox" class="new-control-input" id="sin_ingreso" name="sin_ingreso" value="1">
                            <span class="new-control-indicator"></span>&nbsp;&nbsp;Sin ingreso
                        </label>
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                            <input type="checkbox" class="new-control-input" id="sin_retorno" name="sin_retorno" value="1">
                            <span class="new-control-indicator"></span>&nbsp;&nbsp;Sin retorno
                        </label>
                    </div>
                </div>
            </div>

            <?php if($parametro==1) { ?>

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold">Colaborador:</label>
                </div>
                <div class="form-group col-sm-5">
                    <select class="form-control multivalue" name="colaborador_p[]" id="colaborador_p" multiple="multiple">
                        <option  value="0">Seleccionar</option>
                        <?php foreach($list_vendedor as $list){ ?>
                            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_apater'].' '.$list['usuario_amater'].' '.$list['usuario_nombres'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php } ?>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Destino: </label>
            </div>
            <div id="select_destino" class="form-group col-sm-4">
                <select class="form-control" id="destino" name="destino">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Especifique: </label>
            </div>
            <div class="form-group col-sm-4">
                <input style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="text" class="form-control" id="especificacion_destino" name="especificacion_destino" value="" placeholder="Especifique destino">
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Trámite: </label>
            </div>
            <div id="select_tramite" class="form-group col-sm-4">
                <select class="form-control" id="tramite" name="tramite"><option value="0">Seleccione</option></select>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Especifique: </label>
            </div>
            <div class="form-group col-sm-4">
                <input style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="text" class="form-control" id="especificacion_tramite" name="especificacion_tramite" value="" placeholder="Especifique trámite">
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Hora Salida: </label>
            </div>
            <div class="form-group col-sm-2">
                <input  style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;"
                type="time" step="3600000" class="form-control group2" id="hora_salida"
                name="hora_salida" value="" placeholder="Ingresar hora de salida" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Hora Retorno: </label>
            </div>
            <div class="form-group col-sm-2">
                <input  style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;"
                type="time" step="3600000" class="form-control group1" id="hora_retorno"
                name="hora_retorno" value="" placeholder="" autofocus>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="fecha_actual" name="fecha_actual" value="<?php echo date('Y-m-d'); ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Insert_Papeletas_Salida();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
        <input type="hidden" id="parametro" name="parametro" value="<?php echo $parametro; ?>">
    </div>
</form>

<script>
    $(document).ready(function() {
        var today = new Date().toISOString().split('T')[0];
        $('#fec_solicitud').val(today);
    });

    var ss = $(".multivalue").select2({
        tags: true
    });

    $('.multivalue').select2({
        dropdownParent: $('#ModalRegistroGrande')
    });

    function Cambiar_Motivo(id_motivo){
        Cargando();
        var url="{{ url('Papeletas/Cambiar_Motivo') }}";
        var csrfToken = $('input[name="_token"]').val();


        $.ajax({
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data:{'id_motivo':id_motivo},
            success:function (data) {
                $('#select_destino').html(data);
            }
        });
    }

    function Traer_Tramite(){
        Cargando();

        var id_destino=$('#destino').val();
        var url="{{ url('Papeletas/Traer_Tramite') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data:{'id_destino':id_destino},
            success:function (data) {
                $('#select_tramite').html(data);
            }
        });
    }

    function Insert_Papeletas_Salida() {
        Cargando();

        var dataString = $("#formulario_papeletas_salida_registro").serialize();
        var url = "{{ url('Papeletas/Insert_or_Update_Papeletas_Salida') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Papeletas_Salida()) {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: dataString,
                success: function(data) {
                    if (data == "error") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Ya no puedes hacer más papeletas para ese trámite!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Busca_Registro_Papeleta();
                            $("#ModalRegistroGrande .close").click()
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

    function Valida_Papeletas_Salida() {
        valor = $('[name=id_motivo]:checked').val();
        if (valor == 3) {
            if ($("#otros").val() === '') {
                msgDate = 'Debe especificar sus razones en otros';
                Swal.fire(
                    '¡Ups!',
                    msgDate,
                    'warning'
                );
                return false;
            }
        }
        if (!valor) {
            msgDate = 'Debe seleccionar motivo.';
                Swal.fire(
                    '¡Ups!',
                    msgDate,
                    'warning'
                );
            return false;
        }

        if ($('#parametro').val() == 1) {
            if ($('#colaborador_p').val() == '0' || $('#colaborador_p').val() == '') {
                msgDate = 'Debe seleccionar al colaborador.';
                Swal.fire(
                    '¡Ups!',
                    msgDate,
                    'warning'
                );
                return false;
            }
        }

        if (!$('#sin_ingreso').is(":checked")) {
            if ($('#hora_salida').val() === '') {
                msgDate = 'Debe ingresar hora de salida.';
                Swal.fire(
                    '¡Ups!',
                    msgDate,
                    'warning'
                );
                return false;
            }
        }

        if (!$('#sin_retorno').is(":checked")) {
            if ($('#hora_retorno').val() === '') {
                msgDate = 'Debe ingresar hora de retorno.';
                Swal.fire(
                    '¡Ups!',
                    msgDate,
                    'warning'
                );
                return false;
            }
        }

        if (!$('#sin_ingreso').is(":checked") && !$('#sin_retorno').is(":checked")) {
            if ($('#hora_retorno').val() <= $('#hora_salida').val()) {
                msgDate = 'Hora de retorno debe ser mayor a hora de salida';
                Swal.fire(
                    '¡Ups!',
                    msgDate,
                    'warning'
                );
                return false;
            }
        }

        return true;
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
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

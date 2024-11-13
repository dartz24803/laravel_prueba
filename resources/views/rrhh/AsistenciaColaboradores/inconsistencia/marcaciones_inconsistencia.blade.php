<div class="modal-header">
    <h5 class="modal-title">Marcaciones de <b>
            <?php
            $nombre = explode(" ", $get_asist[0]->usuario_nombres);
            echo $nombre[0] . " " . $get_asist[0]->usuario_apater . " " . $get_asist[0]->usuario_amater . " - " . date('d/m/Y', strtotime($get_asist[0]->fecha));
            ?>
        </b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

<div class="modal-body" style="max-height:500px; overflow:auto;">
    <div class="col-md-12 row">
        <div class="form-group col-md-12" id="div_turno_i">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label>Turno:</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="hidden" name="id_asistencia_inconsistencia_t" id="id_asistencia_inconsistencia_t" value="<?php echo $id_asistencia_inconsistencia ?>">

                    <select name="id_turnot" id="id_turnot" class="form-control">
                        <option value="0">Seleccione</option>
                        <?php foreach ($list_turno as $list) { ?>
                            <option value="<?php echo $list->id_turno ?>" <?php if ($get_id[0]['id_turno'] == $list->id_turno) {
                                                                                echo "selected";
                                                                            } ?>><?php echo $list->option_select ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <button class="btn btn-primary mt-3" type="button" onclick="Update_Turno_Inconsistencia('<?php echo $id_asistencia_inconsistencia ?>');">Guardar</button>
                </div>
            </div>
        </div>

        <div class="form-group col-md-6">
            <input type="checkbox" id="d_dias" name="d_dias" value="1">
            <label class="control-label text-bold" for="d_dias">Devolución de días</label>
        </div>

        <div class="form-group col-md-6">
            <input type="checkbox" id="medio_dia" name="medio_dia" value="1">
            <label class="control-label text-bold" for="medio_dia">Medio día</label>
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-3">
            <label class="control-label text-bold">Marcación: </label>
            <div class="">
                <input type="time" name="hora_marcacion" id="hora_marcacion" class="form-control">
            </div>
        </div>

        <div class="form-group col-md-4">
            <label class="control-label text-bold">Tipo: </label>
            <div class="">
                <select name="tipo_marcacion_i" id="tipo_marcacion_i" class="form-control">
                    <option value="0">Seleccione</option>
                    <option value="1">Entrada</option>
                    <option value="2">Salida a refrigerio</option>
                    <option value="3">Entrada de refrigerio</option>
                    <option value="4">Salida</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-1">
            <label for=""></label>
            <div id="btn_reg_i">
                <a style="cursor:pointer;" class="btn btn-primary mt-3" title="Registrar" onclick="Insert_Asistencia_Inconsistencia()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="col-md-12 row" id="div_marcaciones_inconsistencia">
            <table id="" class="table table-hover non-hover" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center td_marcacion" width="5%">Visible</th>
                        <th class="text-center td_marcacion" width="10%">Hora</th>
                        <th class="text-center td_marcacion" width="80%">Tipo</th>
                        <th class="no-content td_marcacion" width="5%"></th>
                        <!--<th class="text-center">Observación</th>
                        <th class="no-content"></th> -->
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($list_marcacionesh as $list) {
                        $id_asistencia_detalle = $list->id_asistencia_detalle; ?>
                        <tr>
                            <td class="text-center td_marcacion"><input type="checkbox" name="visible_id<?php echo $id_asistencia_detalle ?>" id="visible_id<?php echo $id_asistencia_detalle ?>" value="1" <?php if ($list->visible == 1) {
                                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                                            } ?>></td>
                            <td class="text-center td_marcacion">
                                <input type="time" name="hora_marcacion<?php echo $id_asistencia_detalle ?>" id="hora_marcacion<?php echo $id_asistencia_detalle ?>" value="<?php echo $list->marcacion ?>" class="form-control">
                            </td>
                            <td class="text-center td_marcacion">
                                <select name="tipo_marcacion<?php echo $id_asistencia_detalle ?>" id="tipo_marcacion<?php echo $id_asistencia_detalle ?>" class="form-control" style="padding:0px">
                                    <option value="0">Seleccione</option>
                                    <option value="1" <?php if ($list->tipo_marcacion == 1) {
                                                            echo "selected";
                                                        } ?>>Entrada</option>
                                    <option value="2" <?php if ($list->tipo_marcacion == 2) {
                                                            echo "selected";
                                                        } ?>>Salida a refrigerio</option>
                                    <option value="3" <?php if ($list->tipo_marcacion == 3) {
                                                            echo "selected";
                                                        } ?>>Entrada de refrigerio</option>
                                    <option value="4" <?php if ($list->tipo_marcacion == 4) {
                                                            echo "selected";
                                                        } ?>>Salida</option>
                                </select>
                                <input type="hidden" name="obs_marcacion<?php echo $id_asistencia_detalle ?>" id="obs_marcacion<?php echo $id_asistencia_detalle ?>" value="<?php echo $list->obs_marcacion ?>">
                            </td>
                            <td class="td_marcacion">
                                <button class="btn btn-primary" onclick="Update_Marcacion_Inconsistencia('<?php echo $id_asistencia_detalle ?>')">Guardar</button>
                            </td>
                            <!--<td>
                                <?php echo $list->obs_marcacion; ?>
                                <input type="hidden" name="obs_marcacion<?php echo $list->id_asistencia_detalle ?>" id="obs_marcacion<?php echo $list->id_asistencia_detalle ?>" value="<?php echo $list->obs_marcacion ?>">
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" title="Editar" onclick="Div_Upd_Asistencia_Inconsistencia('<?php echo $list->id_asistencia_detalle ?>','<?php echo $list->marcacion ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                </a>
                                <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Marcacion_Inconsistencia('<?php echo $list->id_asistencia_detalle ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </a>
                            </td>-->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="form-group col-md-12">
            <label class="control-label text-bold">Observación: </label>
            <div class="">
                <textarea name="observacion_inconsistencia" id="observacion_inconsistencia" cols="30" rows="3" class="form-control"><?php echo $get_asist[0]->observacion ?></textarea>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="hidden" name="id_marcacion_busqueda" id="id_marcacion_busqueda" value="<?php echo $id_asistencia_inconsistencia ?>">
    <!--<button class="btn btn-info mt-3" onclick="Reg_Descanso_Asistencia('<?php echo $id_asistencia_inconsistencia ?>')" ></i>Reg. Descanso</button>
    <button class="btn btn-danger mt-3" onclick="Reg_Falta_Asistencia('<?php echo $id_asistencia_inconsistencia ?>')" ></i>Reg. Falta</button>-->
    <!--<button class="btn btn-info mt-3" id="btn_asignacion_marc" onclick="Asignar_Marcaciones_Inconsistencia('<?php echo $id_asistencia_inconsistencia ?>')" style="display:<?php if (count($list_marcacionesh) == 0) {
                                                                                                                                                                                    echo "block";
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo "none";
                                                                                                                                                                                } ?>"><i class="flaticon-cancel-12"></i> Asignar Marcaciones</button>-->
    <button class="btn btn-primary mt-3" onclick="Validar_Asistencia_Inconsistencia('<?php echo $id_asistencia_inconsistencia ?>')">Validar</button>
    <!--<button class="btn btn-primary mt-3" onclick="Update_Obs_Asistencia_Inconsistencia()">Actualizar</button>-->

    <button class="btn btn-default mt-3" data-dismiss="modal" onclick="Buscar_Asistencia_Colaborador_Inconsistencia()">Cerrar</button>
</div>
<script>
    $('.basice').select2({
        dropdownParent: $('#ModalUpdate')
    });
    $('#zero-configgmm').DataTable({
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10
    });

    function Insert_Asistencia_Inconsistencia() {
        Cargando();
        var marcacion = $('#hora_marcacion').val();
        var obs_marcacion = ''; //$('#obs_marcacion').val();
        var id_asistencia_inconsistencia = $('#id_marcacion_busqueda').val();
        var tipo_marcacion = $('#tipo_marcacion_i').val();
        var url = "{{ route('inconsistencias_colaborador.insert') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Insert_Asistencia_Inconsistencia('')) {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'marcacion': marcacion,
                    'id_asistencia_inconsistencia': id_asistencia_inconsistencia,
                    'obs_marcacion': obs_marcacion,
                    'tipo_marcacion': tipo_marcacion
                },
                success: function() {
                    $('#hora_marcacion').val('');
                    $('#tipo_marcacion_i').val('0');
                    $('#obs_marcacion').val('');
                    Listar_Asistencia_Inconsistencia(id_asistencia_inconsistencia);
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

    function Valida_Insert_Asistencia_Inconsistencia() {

        if ($('#hora_marcacion').val().trim() === '') {
            msgDate = 'Debe ingresar Marcación';
            inputFocus = '#hora_marcacion';
            return false;
        }
        if ($('#tipo_marcacion_i').val() === '0') {
            msgDate = 'Debe seleccionar tipo de marcación';
            inputFocus = '#hora_marcacion';
            return false;
        }
        return true;
    }

    function Listar_Asistencia_Inconsistencia(id_asistencia_inconsistencia) {
        Cargando();

        var url = "{{ route('inconsistencias_colaborador.listMarcacion') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_asistencia_inconsistencia': id_asistencia_inconsistencia
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#div_marcaciones_inconsistencia').html(data);
            }
        });
    }

    function Validar_Asistencia_Inconsistencia(id_asistencia_inconsistencia) {
        Cargando();

        var observacion_inconsistencia = $('#observacion_inconsistencia').val();
        var csrfToken = $('input[name="_token"]').val();

        if ($('#d_dias').is(':checked')) {
            var d_dias = 1;
        } else {
            var d_dias = 0;
        }
        if ($('#medio_dia').is(':checked')) {
            var medio_dia = 1;
        } else {
            var medio_dia = 0;
        }

        var url = "{{ route('inconsistencias_colaborador.validar') }}";
        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success btn-rounded',
            cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
            buttonsStyling: false,
        })

        if ($('#d_dias').is(':checked') && $('#medio_dia').is(':checked')) {
            Swal({
                title: 'Validación Denegada',
                text: "¡Solo puede seleccionar Devolución de días o Medio día, no ambos!",
                type: 'error',
                showCancelButton: false,
                confirmButtonText: 'OK',
            });
        } else {
            swalWithBootstrapButtons({
                title: '¿Estas seguro de validar marcaciones?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '¡Sí, validar!',
                cancelButtonText: '¡No, cancelar!',
                reverseButtons: true,
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            'id_asistencia_inconsistencia': id_asistencia_inconsistencia,
                            'observacion_inconsistencia': observacion_inconsistencia,
                            'd_dias': d_dias,
                            'medio_dia': medio_dia
                        },
                        success: function(data) {
                            var cadena = data.trim();
                            validacion = cadena.substr(0, 1);
                            mensaje = cadena.substr(1);
                            if (validacion == 1) {
                                swal.fire(
                                    'Validación Exitosa!',
                                    '',
                                    'success'
                                ).then(function() {
                                    $("#ModalUpdate .close").click();
                                    Buscar_Asistencia_Colaborador_Inconsistencia();
                                });
                            } else if (validacion == 2) {
                                swal.fire(
                                    'Validación Denegada!',
                                    '' + mensaje,
                                    'error'
                                ).then(function() {});
                            }
                        }
                    });
                }
            })
        }
    }


    function Update_Marcacion_Inconsistencia(id_asistencia_detalle) {
        Cargando();
        var visible_id = 0;
        if ($('#visible_id' + id_asistencia_detalle).is(":checked")) {
            var visible_id = 1;
        }
        var marcacion = $('#hora_marcacion' + id_asistencia_detalle).val();
        var tipo_marcacion = $('#tipo_marcacion' + id_asistencia_detalle).val();
        var obs_marcacion = $('#obs_marcacion' + id_asistencia_detalle).val();
        var id_asistencia_inconsistencia = $('#id_marcacion_busqueda').val();
        var url = "{{ route('inconsistencias_colaborador.update') }}";
        var csrfToken = $('input[name="_token"]').val();

        //var dataString = new FormData(document.getElementById('formulario_ctrl_eq_personale'));

        if (Valida_Update_Asistencia_Inconsistencia(id_asistencia_detalle)) {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'marcacion': marcacion,
                    'obs_marcacion': obs_marcacion,
                    'id_asistencia_detalle': id_asistencia_detalle,
                    'visible': visible_id,
                    'tipo_marcacion': tipo_marcacion
                },
                success: function(data) {
                    Cancelar_Upd_Marcacion_Inconsistencia();
                    // Listar_Asistencia_Inconsistencia(id_asistencia_inconsistencia);
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

    function Valida_Update_Asistencia_Inconsistencia(id_asistencia_detalle) {

        if ($('#hora_marcacion' + id_asistencia_detalle).val().trim() === '') {
            msgDate = 'Debe ingresar Marcación';
            inputFocus = '#hora_marcacion' + id_asistencia_detalle;
            return false;
        }
        return true;
    }

    function Cancelar_Upd_Marcacion_Inconsistencia() {
        Cargando();
        $('#hora_marcacion').val('');
        var btn1 = document.getElementById("btn_reg_i");
        btn1.style.display = "block";
    }


    function Update_Turno_Inconsistencia(id_asistencia_inconsistencia) {
        Cargando();
        var id_turnot = $('#id_turnot').val();
        var id_asistencia_inconsistencia_t = $('#id_asistencia_inconsistencia_t').val();

        var url = "{{ route('inconsistencias_colaborador.updateturno') }}";
        var csrfToken = $('input[name="_token"]').val();
        if (Valida_Turno_Inconsistencia('t')) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    'id_turnot': id_turnot,
                    'id_asistencia_inconsistencia_t': id_asistencia_inconsistencia_t
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data) {
                    // Divturno_Inconsistencia(id_asistencia_inconsistencia);
                    $("#modal_form_vertical .close").click();
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

    function Valida_Turno_Inconsistencia(v) {
        if ($('#id_turno' + v).val() === '') {
            msgDate = 'Debe seleccionar Turno';
            inputFocus = '#id_turno' + v;
            return false;
        }
        return true;
    }
</script>